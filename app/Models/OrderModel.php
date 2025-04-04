<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\RestaurantModel;

class OrderModel extends Model
{
    public function getActiveaddress($user_id)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('address');
        $builder->where('user_id', $user_id);
        $builder->where('active', 0);
        $builder->where('address_type', "bezorgadres");
        $query = $builder->get();

        $result = $query->getResultArray();
        return !empty($result) ? $result[0]['address_id'] : null;
    }

    public function Processorder($data)
    {
        $db = \Config\Database::connect();

        $valid = 1;
        $message = '';

        $session = session();
        $user_id = $session->get('user_id');
        $address_id = $this->getActiveaddress($user_id);

        $cart = $data['cart'];
        $order_data = $data['orderData'];
        $payment_method = $data['selectedPaymentMethod'];


        $fname = $order_data['fname'];
        $lname = $order_data['lname'];
        $email = $order_data['email'];
        $phone = $order_data['phone'];
        $address = $order_data['address'];
        $delivery_method = $order_data['deliveryMethod'];
        $restaurantid = $order_data['restaurantId'];
        $order_delivery_note = isset($order_data['ordernote']) ? $order_data['ordernote'] : '';

        $order_date = date('d-m-Y H:i:s');

        $builder = $db->table('orders');
        $builder->insert([
            'restaurant_id' => $restaurantid,
            'user_id' => $user_id,
            'address_id' => $address_id,
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'delivery_method' => $delivery_method,
            'payment_method' => $payment_method,
            'order_date' => $order_date,
            'order_delivery_note' => $order_delivery_note,
            'offline' => 0,
        ]);
        $order_id = $db->insertID();

        foreach($cart as $item){
            $dish_id = $item['id'];
            $quantity = $item['quantity'];
            $price = $item['price'];

            $builder = $db->table('order_dishes');
            $builder->insert([
                'order_id' => $order_id, 
                'dish_id' => $dish_id,
                'quantity' => $quantity,
                'price' => $price,
            ]);
        } 


        // Get restaurant name
        $restaurant_name = new RestaurantModel();
        $resdata = $restaurant_name->GetSingleRestaurant($restaurantid); // Get restaurant name 
        if (empty($resdata)) {
            $resdata['restaurant_name'] = 'Niet gevonden';
        }

        $builder = $db->table('restaurants');
        $builder->where('restaurant_id', $restaurantid);
        $builder->update([
            'total_orders' => $resdata['total_orders'] + 1
        ]);

        $orderdata = [
            'order_id' => $order_id,
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'delivery_method' => $delivery_method,
            'payment_method' => $payment_method,
            'order_date' => $order_date,
            'order_delivery_note' => $order_delivery_note,
            'cart' => $cart,
            'total_price' => number_format(array_reduce($cart, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
            }, 0), 2, '.', ''),
            'restaurant_id' => $restaurantid,
            'restaurant_name' => $resdata['restaurant_name'],
        ];

        // print_r($orderdata);
        // die();

        return array($valid, $message, $orderdata, $order_id);
    }

    public function GetActiveAddressByUserID($user_id)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('address');
        $builder->where('user_id', $user_id);
        $builder->where('active', 0);
        $builder->where('address_type', "bezorgadres");
        $query = $builder->get();

        $result = $query->getResultArray();
        return !empty($result) ? $result[0] : null;
    }

    public function getOrderDataByOrderID($order_id)
    {
        $db = \Config\Database::connect();
    
        // Fetch order details with restaurant name
        $builder = $db->table('orders');
        $builder->select('orders.*, COALESCE(restaurants.restaurant_name, "Onbekend restaurant") AS restaurant_name');
        $builder->join('restaurants', 'restaurants.restaurant_id = orders.restaurant_id', 'left');
        $builder->where('orders.order_id', $order_id);
        $query = $builder->get();
    
        $order = $query->getRowArray(); // Fetch single order row
    
        if (!$order) {
            return null; // No order found
        }
    
        // Fetch order dishes (cart items)
        $builder = $db->table('order_dishes');
        $builder->select('order_dishes.*, dishes.dish_name'); // Assuming 'dishes' table has 'name'
        $builder->join('dishes', 'dishes.dish_id = order_dishes.dish_id', 'left');
        $builder->where('order_dishes.order_id', $order_id);
        $query = $builder->get();
    
        $order['cart'] = $query->getResultArray(); 
    
        return $order;
    }
}