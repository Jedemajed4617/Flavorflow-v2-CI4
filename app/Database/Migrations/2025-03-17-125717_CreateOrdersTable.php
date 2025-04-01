<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'restaurant_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'address_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'address' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'order_date' => [
                'type'       => 'VARCHAR',
                'constraint' => 55,
            ],
            'order_delivery_note' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'charset'    => 'utf8mb4',
            ],
            'order_food_note' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'charset'    => 'utf8mb4',
            ],
            'offline' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
            ],
        ]);

        // Add the primary key
        $this->forge->addPrimaryKey('order_id');

        // Create the table with InnoDB engine and utf8mb4 charset
        $this->forge->createTable('orders', true);
    }

    public function down()
    {
        // Drop the table if rolling back
        $this->forge->dropTable('orders');
    }
}