<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InsertDishesToTable extends Migration
{
    public function up()
    {
        // Insert data into the 'dishes' table
        $this->db->table('dishes')->insertBatch([
            [
                'dish_id' => 1,
                'restaurant_id' => 7,
                'category_id' => 1,
                'toppings_id' => NULL,
                'dish_name' => 'Pizza Margherita',
                'dish_price' => 12.95,
                'dish_desc' => 'Beste pizza ooit, gemaakt vanuit italiaans recept',
                'dish_img_src' => '../img/productimg/bakkerijraat_productimg/product_img_resid-7_67d1612541e13.jpg',
                'order_amount' => NULL,
                'active_discount' => NULL,
                'created_by' => 'Jan jansen',
                'created_at' => '2025-03-10 14:20:50',
                'offline' => 0
            ],
            [
                'dish_id' => 2,
                'restaurant_id' => 7,
                'category_id' => 2,
                'toppings_id' => NULL,
                'dish_name' => 'Sushi Roll Zalm 6st.',
                'dish_price' => 14.95,
                'dish_desc' => 'Vers gerolde sushiroll met zalm',
                'dish_img_src' => '../img/productimg/bakkerijraat_productimg/product_img_resid-7_67d13bc2998d4.jpg',
                'order_amount' => NULL,
                'active_discount' => NULL,
                'created_by' => 'Jan jansen',
                'created_at' => '2025-03-11 10:50:15',
                'offline' => 0
            ],
            [
                'dish_id' => 3,
                'restaurant_id' => 7,
                'category_id' => 1,
                'toppings_id' => NULL,
                'dish_name' => 'Pizza Pollo',
                'dish_price' => 14.95,
                'dish_desc' => 'Steenoven pizza versgebakken',
                'dish_img_src' => '../img/productimg/bakkerijraat_productimg/product_img_resid-7_67d13bd870eaa.jpg',
                'order_amount' => NULL,
                'active_discount' => NULL,
                'created_by' => 'Jan jansen',
                'created_at' => '2025-03-11 12:09:40',
                'offline' => 0
            ],
            [
                'dish_id' => 4,
                'restaurant_id' => 7,
                'category_id' => 1,
                'toppings_id' => NULL,
                'dish_name' => 'Pizza Salame',
                'dish_price' => 9.99,
                'dish_desc' => 'Meest gekozen pizza',
                'dish_img_src' => '../img/productimg/bakkerijraat_productimg/product_img_resid-7_67d13c1d69f97.jpg',
                'order_amount' => NULL,
                'active_discount' => NULL,
                'created_by' => 'Jan jansen',
                'created_at' => '2025-03-11 13:47:04',
                'offline' => 0
            ],
            [
                'dish_id' => 5,
                'restaurant_id' => 7,
                'category_id' => 1,
                'toppings_id' => NULL,
                'dish_name' => 'Pizza Tonno',
                'dish_price' => 14.99,
                'dish_desc' => 'Beste pizza ooit',
                'dish_img_src' => '../img/productimg/bakkerijraat_productimg/product_img_resid-7_67d15e8436281.jpg',
                'order_amount' => NULL,
                'active_discount' => NULL,
                'created_by' => 'Jan jansen',
                'created_at' => '2025-03-11 13:47:59',
                'offline' => 0
            ],
            [
                'dish_id' => 6,
                'restaurant_id' => 7,
                'category_id' => 2,
                'toppings_id' => NULL,
                'dish_name' => 'Sushi Roll Kip 6st.',
                'dish_price' => 18.99,
                'dish_desc' => 'Vers gerolde sushi rolls',
                'dish_img_src' => '../img/productimg/bakkerijraat_productimg/product_img_resid-7_67d159fcf1613.jpg',
                'order_amount' => NULL,
                'active_discount' => NULL,
                'created_by' => 'Jan jansen',
                'created_at' => '2025-03-11 13:52:37',
                'offline' => 0
            ]
        ]);
    }

    public function down()
    {
        // Optional: If you want to delete this data on rollback
        $this->db->table('dishes')->truncate();
    }
}
