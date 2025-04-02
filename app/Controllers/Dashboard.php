<?php

namespace App\Controllers;

use App\Models\RestaurantModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function getAdminorders()
    {
        echo view('templates/dashnav');
        echo view('admindashboard/adminorders'); 
    }

    public function getAdminrestaurants()
    {
        echo view('templates/dashnav');
        echo view('admindashboard/adminrestaurants'); 
    }

    public function getOrderoverview($restaurant_id)
    {
        $restaurantmodel = new RestaurantModel();
        $info = $restaurantmodel->getRestaurantInfo($restaurant_id);
        $orders = $restaurantmodel->getAllRestaurantOrdersWithTotals($restaurant_id);
    
        echo view('templates/dashnav');
        echo view('restaurantdashboard/restaurantorderoverview', ['info' => $info, 'orders' => $orders]);
    }

    public function getProductoverview($restaurant_id)
    {
        $restaurantmodel= new RestaurantModel();
        $products = $restaurantmodel->getAllRestaurantProducts($restaurant_id);
        $info = $restaurantmodel->getRestaurantInfo($restaurant_id);
        echo view('templates/dashnav');
        echo view('restaurantdashboard/restaurantproductoverview', ['products' => $products, 'info' => $info]); 
    }

    public function getRestaurantsettings($restaurant_id)
    {
        $restaurantmodel= new RestaurantModel();
        $info = $restaurantmodel->getRestaurantInfo($restaurant_id);
        echo view('templates/dashnav');
        echo view('restaurantdashboard/restaurantsettings', ['info' => $info]); 
    }
}