<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    public function getUser($email)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('*');
        $builder->where('email', $email);
        $query = $builder->get();

        // Convert result to an array
        $user = $query->getRowArray();
        return $user;
    }

    public function createUser($data)
    {
        $valid = 1;
        $message = '';
        $session = session();
        $data = $_POST;
        $fname = $data['fname'];
        $lname = $data['lname'];
        $email = $data['email'];
        $password = $data['password'];
        $password_confirm = $data['pswrepeat'];
        $username = $data['username'];
        $order_id = $data['orderID'];
        $phone = trim(str_replace(' ', '', $data['phone']));
        $user_type = "customer";
        $gender = "";
        $profile_img_src = "";

        if (!isset($data)) {
            $valid = 0;
            $message = "Alle velden moeten ingevuld worden.";
        }

        if ($data['password'] !== $password_confirm) {  // Compare before hashing
            $valid = 0;
            $message = "Wachtwoorden komen niet overeen.";
        }

        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        if ($email != filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $valid = 0;
            $message = "Ongeldig e-mailadres.";
        }

        if (strlen($password) < 8) {
            $valid = 0;
            $message = "Wachtwoord moet minimaal 8 tekens bevatten.";
        }

        $prefix = substr($phone, 0, 4);

        if ($prefix !== '+316' && $prefix !== '+3106') {
            $valid = 0;
            $message = "Telefoonnummer moet beginnen met +316 of +3106.";
        }

        if (strlen($phone) !== 12) {
            $valid = 0;
            $message = "Telefoonnummer moet 7 tekens bevatten.";
        }

        $user_exist = $this->getUser($email);

        if ($user_exist) {
            $valid = 0;
            $message = "E-mailadres is al in gebruik.";
        }

        $db = \Config\Database::connect();
        $builder = $db->table('users');
        if ($valid === 1) {
            $builder->insert([
                'user_type' => $user_type,
                'fname' => $fname,
                'lname' => $lname,
                'email' => $email,
                'password' => $password,
                'username' => $username,
                'phone' => $phone,
                'gender' => $gender,
                'profile_img_src' => $profile_img_src,
                'created_at' => date('d-m-Y H:i:s'),
                'offline' => 0,
                'last_login' => date('d-m-Y H:i:s')
            ]);

            // Start session and set user data
            $session->set([
                'user_id' => $db->insertID(),
                'user_type' => $user_type,
                'username' => $username,
                'fname' => $fname,
                'lname' => $lname,
                'phone' => $phone,
                'email' => $email,
                'gender' => $gender,
                'logged_in' => true
            ]);
        }

        if (!empty($order_id)) {
            $builder = $db->table('orders');
            $builder->where('order_id', $order_id);
            $builder->update([
                'user_id' => $session->get('user_id')
            ]);
        } else{
            $order_id = 0;
        }

        return array($valid, $message, $order_id);
    }

    public function processUserLogin($data)
    {
        $session = session();
        $db = \Config\Database::connect();

        $valid = 1;
        $message = '';
        $data = $_POST;
        $email = $data['email'];
        $password = $data['password'];
        $userModel = new \App\Models\UserModel();
        $user = $userModel->getUser($email);

        if (empty($data['email']) || empty($data['password'])) {
            $valid = 0;
            $message = "Alle velden moeten ingevuld worden."; 
        }

        if (!$user) {
            $valid = 0;
            $message = "Geen gebruiker gevonden met dit e-mailadres.";
        }

        if (!password_verify($password, $user['password'])) {
            $valid = 0;
            $message = "Wachtwoord komt niet overeen met e-mailadres.";
        }

        if ($valid === 1) {
            // Update last login time
            $builder = $db->table('users');
            $builder->where('user_id', $user['user_id']);
            $builder->update([
                'last_login' => date('d-m-Y H:i:s') 
            ]);
    
            // Set session data
            $session->set([
                'user_id' => $user['user_id'],  // Ensure the key is correct here
                'user_type' => $user['user_type'],
                'fname' => $user['fname'],
                'lname' => $user['lname'],
                'phone' => $user['phone'],
                'profile_img_src' => $user['profile_img_src'],
                'username' => $user['username'],
                'email' => $user['email'],
                'restaurant_id' => $user['restaurant_id'],
                'birthdate' => $user['date_of_birth'],
                'gender' => $user['gender'],
                'logged_in' => true
            ]);
        }

        return array($valid, $message);
    }

    public function getUserInfo($user_id){
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('user_id', $user_id);
        $builder->select('*');
        $query = $builder->get();

        // Convert result to an array
        $users = $query->getResultArray();
        return $users;
    }

    public function getAllUserOrders($user_id)
    {
        $builder = $this->db->table('orders');
        $builder->select('orders.order_id, orders.user_id, orders.order_date, orders.address, orders.payment_method, orders.fname, orders.lname, orders.email, orders.phone, orders.delivery_method, orders.order_delivery_note, orders.order_food_note');
        $builder->where('orders.user_id', $user_id);
        $query = $builder->get();

        // Convert result to an array
        $orders = $query->getResultArray();
        return $orders;
    }

    public function getOrders($user_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->where('user_id', $user_id);

        $builder->select('orders.order_id, orders.user_id, orders.order_date, orders.address, orders.payment_method, orders.fname, orders.lname, orders.email, orders.phone, orders.delivery_method, orders.order_delivery_note, orders.order_food_note, orders.restaurant_id');
        $builder->select('SUM(order_dishes.price * order_dishes.quantity) AS total_order_price');

        $builder->join('order_dishes', 'order_dishes.order_id = orders.order_id', 'left');

        $builder->groupBy([
            'orders.order_id', 'orders.user_id', 'orders.order_date', 'orders.address',
            'orders.payment_method', 'orders.fname', 'orders.lname', 'orders.email',
            'orders.phone', 'orders.delivery_method', 'orders.order_delivery_note', 'orders.order_food_note', 'orders.restaurant_id'
        ]);

        $builder->orderBy('orders.order_date', 'DESC');

        // Convert result to an array
        $query = $builder->get();
        $orders = $query->getResultArray();
        return $orders;
    }
}
