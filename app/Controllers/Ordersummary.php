<?php

namespace App\Controllers;

use App\Models\OrderModel;

class Ordersummary extends BaseController
{
    public function getIndex($order_id = null)
    {
        $session = session();
        $orderdata = $session->get('orderdata');

        // Get the order_id from the URI or GET parameters
        $order_id = $this->request->getUri()->getSegment(2) ?? $this->request->getGet('order_id') ?? null;

        // Fetch order data by ID only if an order ID is provided
        $orderdatabyid = [];
        if ($order_id !== null) {
            $ordermodel = new OrderModel();
            $orderdatabyid = $ordermodel->getOrderDataByOrderID($order_id);
        }

        echo view('templates/dashnav');
        echo view('ordersummary', [
            'order_id' => $order_id,
            'orderdata' => $orderdata,
            'orderdatabyid' => $orderdatabyid
        ]);
        echo view('templates/smallfooter');
    }
}