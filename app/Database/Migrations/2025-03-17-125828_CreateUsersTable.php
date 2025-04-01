<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id'           => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_type'         => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'restaurant_id'     => [
                'type'       => 'INT',
                'constraint' => '11',
                'unsigned'   => true,
                'null'       => true,
            ],
            'fname'             => [
                'type'       => 'VARCHAR',
                'constraint' => '55',
            ],
            'lname'             => [
                'type'       => 'VARCHAR',
                'constraint' => '55',
            ],
            'email'             => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'password'          => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'username'          => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'phone'             => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'date_of_birth'     => [
                'type'       => 'DATE',
                'null'       => true,
            ],
            'gender'            => [
                'type'       => 'VARCHAR',
                'constraint' => '55',
                'null'       => true,
            ],
            'profile_img_src'   => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'created_at'        => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'offline'           => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'default'    => 0,
            ],
            'last_login'        => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);
        
        // Adding primary key and indexes
        $this->forge->addPrimaryKey('user_id');
        
        // Create the table
        $this->forge->createTable('users');
    }

    public function down()
    {
        // Drop the table if rolling back
        $this->forge->dropTable('users');
    }
}