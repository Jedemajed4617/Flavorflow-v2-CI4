<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function GetIndex()
    {
        echo view('templates/nav');
        echo view('templates/categories');
        echo view('homepage');
        echo view('templates/footer');
        return;
    }
}