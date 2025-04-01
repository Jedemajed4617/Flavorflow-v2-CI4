<?php

namespace App\Controllers;

use App\Models\RestaurantModel;

class Restaurants extends BaseController
{
    public function GetIndex()
    {
        $restaurantModel = new RestaurantModel();
        $data = $restaurantModel->getRestaurants(); 

        echo view('templates/smallnav');
        echo view('templates/categories');
        echo view('restaurant/index', ['restaurants' => $data]); 
        echo view('templates/footer');
    }

    public function getOrder($restaurant_id)
    {
        $restaurantmodel = new RestaurantModel();
        $data = $restaurantmodel->getProducts($restaurant_id); 
        $restaurant = $restaurantmodel->getSingleRestaurant($restaurant_id);

        echo view('templates/smallnav');
        echo view('templates/cart');
        echo view('templates/categories');
        echo view('restaurant/order', ['dishes' => $data, 'restaurant' => $restaurant]); 
        echo view('templates/smallfooter');
    }
}