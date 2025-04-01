<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateAllTableID extends Migration
{
    public function up()
    {
        // Add primary keys
        $this->forge->addPrimaryKey('address_id', 'address');
        $this->forge->addPrimaryKey('category_id', 'category');
        $this->forge->addPrimaryKey('dish_id', 'dishes');
        $this->forge->addPrimaryKey('order_id', 'orders');
        $this->forge->addPrimaryKey('dish_order_id', 'order_dishes');
        $this->forge->addPrimaryKey('restaurant_id', 'restaurants');
        $this->forge->addPrimaryKey('toppings_id', 'toppings');
        $this->forge->addPrimaryKey('user_id', 'users');

        // Modify fields to AUTO_INCREMENT
        $this->forge->modifyColumn('address', [
            'address_id' => [
                'type' => 'INT',
                'auto_increment' => true,
                'null' => false,
                'constraint' => 11,
            ],
        ]);

        $this->forge->modifyColumn('category', [
            'category_id' => [
                'type' => 'INT',
                'auto_increment' => true,
                'null' => false,
                'constraint' => 11,
            ],
        ]);

        $this->forge->modifyColumn('dishes', [
            'dish_id' => [
                'type' => 'INT',
                'auto_increment' => true,
                'null' => false,
                'constraint' => 11,
            ],
        ]);

        $this->forge->modifyColumn('orders', [
            'order_id' => [
                'type' => 'INT',
                'auto_increment' => true,
                'null' => false,
                'constraint' => 11,
            ],
        ]);

        $this->forge->modifyColumn('order_dishes', [
            'dish_order_id' => [
                'type' => 'INT',
                'auto_increment' => true,
                'null' => false,
                'constraint' => 11,
            ],
        ]);

        $this->forge->modifyColumn('restaurants', [
            'restaurant_id' => [
                'type' => 'INT',
                'auto_increment' => true,
                'null' => false,
                'constraint' => 11,
            ],
        ]);

        $this->forge->modifyColumn('toppings', [
            'toppings_id' => [
                'type' => 'INT',
                'auto_increment' => true,
                'null' => false,
                'constraint' => 11,
            ],
        ]);

        $this->forge->modifyColumn('users', [
            'user_id' => [
                'type' => 'INT',
                'auto_increment' => true,
                'null' => false,
                'constraint' => 11,
            ],
        ]);

        // Add foreign keys for 'order_dishes'
        $this->forge->addForeignKey('order_id', 'orders', 'order_id');
        $this->forge->addForeignKey('dish_id', 'dishes', 'dish_id');
    }

    public function down()
    {
        // Drop the primary keys
        $this->forge->dropPrimaryKey('address_id', 'address');
        $this->forge->dropPrimaryKey('category_id', 'category');
        $this->forge->dropPrimaryKey('dish_id', 'dishes');
        $this->forge->dropPrimaryKey('order_id', 'orders');
        $this->forge->dropPrimaryKey('dish_order_id', 'order_dishes');
        $this->forge->dropPrimaryKey('restaurant_id', 'restaurants');
        $this->forge->dropPrimaryKey('toppings_id', 'toppings');
        $this->forge->dropPrimaryKey('user_id', 'users');

        // Drop foreign keys for 'order_dishes'
        $this->forge->dropForeignKey('order_dishes', 'order_dishes_ibfk_1');
        $this->forge->dropForeignKey('order_dishes', 'order_dishes_ibfk_2');
    }
}
