<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRestaurantsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'restaurant_id'      => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'restaurant_name'    => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'total_orders'       => [
                'type'       => 'INT',
                'constraint' => '11',
                'null'       => true,
            ],
            'total_dishes'       => [
                'type'       => 'INT',
                'constraint' => '11',
                'null'       => true,
            ],
            'total_categories'   => [
                'type'       => 'INT',
                'constraint' => '11',
                'null'       => true,
            ],
            'restaurant_logo_src'=> [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'character_set' => 'utf8mb4',
            ],
            'offline'            => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'default'    => 0,
            ],
        ]);
        
        // Add the primary key
        $this->forge->addPrimaryKey('restaurant_id');
        
        // Create the table with InnoDB engine and utf8mb4 charset
        $this->forge->createTable('restaurants', true);
    }

    public function down()
    {
        // Drop the table if rolling back
        $this->forge->dropTable('restaurants');
    }
}
