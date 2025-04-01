<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderDishesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'dish_order_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'order_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'dish_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'quantity' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 1,
            ],
            'price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'created_at' => [
                'type'       => 'VARCHAR',
                'constraint' => 55,
            ],
        ]);

        // Add the primary key
        $this->forge->addPrimaryKey('dish_order_id');

        // Create the table with InnoDB engine and utf8mb4 charset
        $this->forge->createTable('order_dishes', true);
    }

    public function down()
    {
        // Drop the table if rolling back
        $this->forge->dropTable('order_dishes');
    }
}