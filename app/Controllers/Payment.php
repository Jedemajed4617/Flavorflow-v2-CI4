<?php

namespace App\Controllers;

class Payment extends BaseController
{
    public function GetIndex()
    {
        echo view('templates/smallnav');
        echo view('payment');
        echo view('templates/smallfooter'); 
    }
}