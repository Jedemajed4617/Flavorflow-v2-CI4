<?php

namespace App\Controllers;

class Order extends BaseController
{
    public function GetIndex()
    {
        $orderModel = new \App\Models\OrderModel();
        $session = session();
        $user_id = $session->get('user_id');
        $activeaddress = $orderModel->GetActiveAddressByUserID($user_id);
        echo view('templates/smallnav');
        echo view('templates/cart');
        echo view('order', ['activeaddress' => $activeaddress]);
        echo view('templates/smallfooter');
    }

    public function postProcessorder()
    {
        $orderModel = new \App\Models\OrderModel();
        $data = $_POST;
        $session = session();

        // Process the order
        $result = $orderModel->Processorder($data);

        // Redirect to the payment page with the order ID
        if($result[0] == 1){
            $session->set('orderdata', $result[2]);
            echo json_encode(['status' => 'success', 'orderid' => $result[3]]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result[1]]);
        }
    }
}