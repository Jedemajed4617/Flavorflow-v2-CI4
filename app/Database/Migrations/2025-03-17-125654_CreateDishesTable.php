<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDishesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'dish_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'restaurant_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'category_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'toppings_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'dish_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 55,
            ],
            'dish_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '20,2',
            ],
            'dish_desc' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'charset'    => 'utf8mb4',
            ],
            'dish_img_src' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'charset'    => 'utf8mb4',
            ],
            'order_amount' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'active_discount' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'created_by' => [
                'type'       => 'VARCHAR',
                'constraint' => 55,
                'null'       => true,
            ],
            'created_at' => [
                'type'       => 'VARCHAR',
                'constraint' => 55,
            ],
            'offline' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
            ],
        ]);

        // Add the primary key
        $this->forge->addPrimaryKey('dish_id');

        // Create the table with InnoDB engine and utf8mb4 charset
        $this->forge->createTable('dishes', true);
    }

    public function down()
    {
        // Drop the table if rolling back
        $this->forge->dropTable('dishes');
    }
}