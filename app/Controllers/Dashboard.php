<?php

namespace App\Controllers;

use App\Models\RestaurantModel;

class Dashboard extends BaseController
{
    public function getAdminorders()
    {
        echo view('templates/dashnav');
        echo view('admindashboard/adminorders'); 
        echo view('templates/smallfooter');
    }

    public function getAdminrestaurants()
    {
        echo view('templates/dashnav');
        echo view('admindashboard/adminrestaurants'); 
        echo view('templates/smallfooter');
    }

    public function getOrderoverview($restaurant_id)
    {
        $restaurantmodel= new RestaurantModel();
        $info = $restaurantmodel->getRestaurantInfo($restaurant_id);
        echo view('templates/dashnav');
        echo view('restaurantdashboard/restaurantorderoverview', ['info' => $info]); 
        echo view('templates/smallfooter');
    }

    public function getProductoverview($restaurant_id)
    {
        $restaurantmodel= new RestaurantModel();
        $products = $restaurantmodel->getAllRestaurantProducts($restaurant_id);
        $info = $restaurantmodel->getRestaurantInfo($restaurant_id);
        echo view('templates/dashnav');
        echo view('restaurantdashboard/restaurantproductoverview', ['products' => $products, 'info' => $info]); 
        echo view('templates/smallfooter');
    }

    public function getRestaurantsettings($restaurant_id)
    {
        $restaurantmodel= new RestaurantModel();
        $info = $restaurantmodel->getRestaurantInfo($restaurant_id);
        echo view('templates/dashnav');
        echo view('restaurantdashboard/restaurantsettings', ['info' => $info]); 
        echo view('templates/smallfooter');
    }
}