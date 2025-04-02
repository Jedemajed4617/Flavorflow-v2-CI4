<?php

namespace App\Models;

use CodeIgniter\Model;

class RestaurantModel extends Model
{
    public function getRestaurants()
    {
        $db = \Config\Database::connect();  
        $builder = $db->table('restaurants');
        $builder->select('*');
        $builder->where('offline', 0);
        $query = $builder->get();

        // Convert result to an array and replace NULL logo
        $restaurants = $query->getResultArray();
        foreach ($restaurants as &$restaurant) {
            if (empty($restaurant['restaurant_logo_src'])) {
                $restaurant['restaurant_logo_src'] = './img/logo-res.jpg';
            }
        }
        
        return $restaurants;
    }

    public function GetProducts($restaurant_id)
    {
        $db = \Config\Database::connect();  
        $builder = $db->table('dishes');
        $builder->select('*');
        $builder->where('offline', 0);
        $builder->where('restaurant_id', $restaurant_id); 
        $query = $builder->get();
        
        // Convert result to an array
        $dishes = $query->getResultArray();
        return $dishes;
    }

    public function GetSingleRestaurant($restaurant_id)
    {
        $db = \Config\Database::connect();  
        $builder = $db->table('restaurants');
        $builder->select('*');
        $builder->where('restaurant_id', $restaurant_id);
        $query = $builder->get();
        
        // Convert result to an array
        $restaurant_name = $query->getRowArray();
        return $restaurant_name;
    }

    public function getAllRestaurantProducts($restaurant_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('dishes');
        $builder->select('dishes.*, category.category_name');
        $builder->join('category', 'dishes.category_id = category.category_id', 'left');
        $builder->where('dishes.restaurant_id', $restaurant_id);
        
        $query = $builder->get();
        
        // Convert result to an array
        $products = $query->getResultArray();

        foreach ($products as &$product) {
            if (isset($product['active_discount']) && $product['active_discount'] !== null) {
                if ($product['active_discount'] == 100) {
                    $product['discounted_price'] = 'Gratis';
                } elseif ($product['active_discount'] == 0) {
                    $product['discounted_price'] = $product['dish_price'];
                } else {
                    $discount = ($product['dish_price'] * $product['active_discount']) / 100;
                    $product['discounted_price'] = $product['dish_price'] - $discount;
                }
            } else {
                $product['discounted_price'] = $product['dish_price'];
            }
        }

        return $products;
    }

    public function getRestaurantInfo($restaurant_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('restaurants');
        $builder->select('*');
        $builder->where('restaurant_id', $restaurant_id);
        $query = $builder->get();
        
        // Convert result to an array
        $restaurantinfo = $query->getRowArray();
        return $restaurantinfo;
    }

    public function getAllRestaurantOrdersWithTotals($restaurant_id)
    {
        $builder = $this->db->table('orders');

        $builder->select('orders.order_id, orders.user_id, orders.order_date, orders.address, orders.payment_method, orders.fname, orders.lname, orders.email, orders.phone, orders.delivery_method, orders.order_delivery_note, orders.order_food_note, orders.restaurant_id');
        $builder->select('users.username, users.date_of_birth');
        $builder->select('restaurants.restaurant_name');
        $builder->select('SUM(order_dishes.price * order_dishes.quantity) AS total_order_price');

        $builder->join('order_dishes', 'order_dishes.order_id = orders.order_id', 'left');
        $builder->join('users', 'users.user_id = orders.user_id', 'left');
        $builder->join('restaurants', 'restaurants.restaurant_id = orders.restaurant_id', 'left');

        $builder->where('orders.restaurant_id', $restaurant_id);

        $builder->groupBy([
            'orders.order_id', 'orders.user_id', 'orders.order_date', 'orders.address',
            'orders.payment_method', 'orders.fname', 'orders.lname', 'orders.email',
            'orders.phone', 'orders.delivery_method', 'orders.order_delivery_note', 'orders.order_food_note', 'orders.restaurant_id',
            'users.username', 'users.date_of_birth',
            'restaurants.restaurant_name'
        ]);

        $builder->orderBy('orders.order_date', 'DESC');

        $query = $builder->get();
        $orders = $query->getResultArray();
        return $orders;
    }
}