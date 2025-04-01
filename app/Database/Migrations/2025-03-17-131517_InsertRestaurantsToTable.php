<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InsertRestaurantsToTable extends Migration
{
    public function up()
    {
        // Insert data into the 'restaurants' table
        $this->db->table('restaurants')->insertBatch([
            [
                'restaurant_id' => 1,
                'restaurant_name' => 'Bij Oost',
                'total_orders' => NULL,
                'total_dishes' => NULL,
                'total_categories' => NULL,
                'restaurant_logo_src' => NULL,
                'offline' => 0
            ],
            [
                'restaurant_id' => 2,
                'restaurant_name' => 'New York Pizza',
                'total_orders' => NULL,
                'total_dishes' => NULL,
                'total_categories' => NULL,
                'restaurant_logo_src' => NULL,
                'offline' => 0
            ],
            [
                'restaurant_id' => 3,
                'restaurant_name' => 'Bistro Op3',
                'total_orders' => NULL,
                'total_dishes' => NULL,
                'total_categories' => NULL,
                'restaurant_logo_src' => NULL,
                'offline' => 0
            ],
            [
                'restaurant_id' => 4,
                'restaurant_name' => 'Pizzeria Medemblik',
                'total_orders' => NULL,
                'total_dishes' => NULL,
                'total_categories' => NULL,
                'restaurant_logo_src' => NULL,
                'offline' => 0
            ],
            [
                'restaurant_id' => 5,
                'restaurant_name' => 'Herberg de Compagnie',
                'total_orders' => NULL,
                'total_dishes' => NULL,
                'total_categories' => NULL,
                'restaurant_logo_src' => NULL,
                'offline' => 0
            ],
            [
                'restaurant_id' => 6,
                'restaurant_name' => 'IJssalon Medemblik',
                'total_orders' => NULL,
                'total_dishes' => NULL,
                'total_categories' => NULL,
                'restaurant_logo_src' => NULL,
                'offline' => 0
            ],
            [
                'restaurant_id' => 7,
                'restaurant_name' => 'Bakkerij Raat',
                'total_orders' => NULL,
                'total_dishes' => NULL,
                'total_categories' => NULL,
                'restaurant_logo_src' => NULL,
                'offline' => 0
            ],
            [
                'restaurant_id' => 8,
                'restaurant_name' => 'Eetcafé De Kwikkel',
                'total_orders' => NULL,
                'total_dishes' => NULL,
                'total_categories' => NULL,
                'restaurant_logo_src' => NULL,
                'offline' => 0
            ],
            [
                'restaurant_id' => 9,
                'restaurant_name' => 'De Driemaster',
                'total_orders' => NULL,
                'total_dishes' => NULL,
                'total_categories' => NULL,
                'restaurant_logo_src' => NULL,
                'offline' => 0
            ],
            [
                'restaurant_id' => 10,
                'restaurant_name' => 'Eetcafé Rumours',
                'total_orders' => NULL,
                'total_dishes' => NULL,
                'total_categories' => NULL,
                'restaurant_logo_src' => NULL,
                'offline' => 0
            ]
        ]);
    }

    public function down()
    {
        // Optional: If you want to delete this data on rollback
        $this->db->table('restaurants')->truncate();
    }
}