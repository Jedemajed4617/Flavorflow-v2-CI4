<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InsertTestUserToTable extends Migration
{
    public function up()
    {
        // Insert data into the 'users' table
        $this->db->table('users')->insert([
            'user_id' => 1,
            'user_type' => 'res_owner',
            'restaurant_id' => 7,
            'fname' => 'Jan',
            'lname' => 'jansen',
            'email' => 'janjansen@voorbeeld.com',
            'password' => '$2y$10$teN7dDE8EFHEWocd6MuiaOA8231siv/BMbG3Y1hv4WyQM6N3/biAS', // hashed password: 'test'
            'username' => 'janjansen12',
            'phone' => '+31 0687654321',
            'date_of_birth' => '2003-02-22',
            'gender' => 'male',
            'profile_img_src' => '67d4303eb1d487.44047900.webp',
            'created_at' => '04/03/2025 om 13:07:11',
            'offline' => 0,
            'last_login' => '2025-03-14 15:21:50'
        ]);
    }

    public function down()
    {
        // Optional: If you want to delete this user on rollback
        $this->db->table('users')->where('user_id', 1)->delete();
    }
}
