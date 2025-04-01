<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'category_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'restaurant_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'category_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 55,
            ],
            'dish_amount' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'category_img_src' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'charset'    => 'utf8mb4',
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
        $this->forge->addPrimaryKey('category_id');

        // Create the table with InnoDB engine and utf8mb4 charset
        $this->forge->createTable('category', true);
    }

    public function down()
    {
        // Drop the table if rolling back
        $this->forge->dropTable('category');
    }
}
