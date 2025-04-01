<?php

namespace App\Controllers;

class Ordersummary extends BaseController
{
    public function getIndex()
    {
        $session = session();
        $orderdata = $session->get('orderdata');
    
        if (empty($orderdata)) {
            return view('ordersummary', ['orderdata' => null]);
        }

        echo view('templates/smallnav');
        echo view('ordersummary', ['orderdata' => $orderdata]);
        echo view('templates/smallfooter');
    }
}