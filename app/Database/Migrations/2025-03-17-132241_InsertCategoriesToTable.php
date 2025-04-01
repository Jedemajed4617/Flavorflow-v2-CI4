<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InsertCategoriesToTable extends Migration
{
    public function up()
    {
        // Insert data into the 'category' table
        $this->db->table('category')->insertBatch([
            [
                'category_id' => 1,
                'restaurant_id' => 7,
                'category_name' => 'Pizza',
                'dish_amount' => NULL,
                'category_img_src' => NULL,
                'created_at' => '2025-03-10 14:20:50',
                'offline' => 0
            ],
            [
                'category_id' => 2,
                'restaurant_id' => 7,
                'category_name' => 'Sushi',
                'dish_amount' => NULL,
                'category_img_src' => NULL,
                'created_at' => '2025-03-11 09:22:35',
                'offline' => 0
            ],
            [
                'category_id' => 3,
                'restaurant_id' => 7,
                'category_name' => 'Test',
                'dish_amount' => NULL,
                'category_img_src' => NULL,
                'created_at' => '2025-03-11 14:42:32',
                'offline' => 0
            ]
        ]);
    }

    public function down()
    {
        // Optional: If you want to delete this data on rollback
        $this->db->table('category')->truncate();
    }
}
