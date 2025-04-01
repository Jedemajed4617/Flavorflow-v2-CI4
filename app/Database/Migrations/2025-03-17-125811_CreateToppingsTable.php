<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateToppingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'toppings_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'dish_id'     => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'topping_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '55',
            ],
            'topping_price' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
            'offline'      => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'default'    => 0,
            ],
        ]);

        // Add the primary key
        $this->forge->addPrimaryKey('toppings_id');

        // Create the table with InnoDB engine and utf8mb4 charset
        $this->forge->createTable('toppings', true);
    }

    public function down()
    {
        // Drop the table if rolling back
        $this->forge->dropTable('toppings');
    }
}
