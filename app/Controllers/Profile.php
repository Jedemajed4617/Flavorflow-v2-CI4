<?php

namespace App\Controllers;

use App\Models\AddressModel;

class Profile extends BaseController
{
    public function getIndex()
    {
        echo view('templates/dashnav');
        echo view('profile/index'); 
    }

    public function getStamps()
    {
        echo view('templates/dashnav');
        echo view('profile/stamps'); 
    }

    public function getOrders()
    {
        echo view('templates/dashnav');
        echo view('profile/orders'); 
    }

    public function getNotifications()
    {
        echo view('templates/dashnav');
        echo view('profile/notifications'); 
    }

    public function getAddresses()
    {
        $addressmodel = new AddressModel();
        $billaddress = $addressmodel->getBillingaddress(); 
        $deliveryaddress = $addressmodel->getDeliveryaddress(); 

        echo view('templates/dashnav');
        echo view('profile/addresses', ['billaddress' => $billaddress, 'deliveryaddress' => $deliveryaddress]); 
    }

    public function getEditprofile()
    {
        echo view('templates/dashnav');
        echo view('profile/editprofile');    
    }
}