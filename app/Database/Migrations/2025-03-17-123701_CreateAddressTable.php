<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAddressTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'address_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'address_type' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'country' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'province' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'street_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'street_number' => [
                'type' => 'INT',
                'constraint' => 20
            ],
            'street_number_addition' => [
                'type' => 'VARCHAR',
                'constraint' => 5
            ],
            'postal_code' => [
                'type' => 'VARCHAR',
                'constraint' => 7
            ],
            'created_at' => [
                'type' => 'VARCHAR',
                'constraint' => 55
            ],
            'active' => [
                'type' => 'TINYINT',
                'constraint' => 1
            ],
            'offline' => [
                'type' => 'TINYINT',
                'constraint' => 1
            ]
        ])
        ->addKey('address_id', true)
        ->createTable('address');
    }

    public function down()
    {
        $this->forge->dropTable('address');
    }
}
