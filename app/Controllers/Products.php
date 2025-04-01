<?php

namespace App\Controllers;
use App\Models\ProductModel;

class Products extends BaseController{
    public function postAddproduct()
    {
        // Get restaurant_id from session if needed
        $session = session();
        $restaurant_id = $session->get('restaurant_id') ?? $this->request->getPost('restaurant_id');

        $ProductModel = new ProductModel();
        $result = $ProductModel->addProduct($restaurant_id);

        echo json_encode([
            'status' => $result[0] == 1 ? 'success' : 'error',
            'message' => $result[1]
        ]);
    }

    public function postGetcategories()
    {
        // Clear any previous output
        if (ob_get_level() > 0) {
            ob_end_clean();
        }
    
        $query = $this->request->getPost('query') ?? '';
        $ProductModel = new ProductModel();
        $categories = $ProductModel->getCategoriesfromdb($query);
    
        // Use CI4's built-in JSON response
        return $this->response->setJSON($categories);
    }

    public function postChangeproductstatus(){
        $data = $_POST;
        $ProductModel = new ProductModel();
        $result = $ProductModel->changeProductStatus($data);

        if($result[0] === 1){
            echo json_encode(['status' => 'success', 'newstatus' => $result[2]]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result[1]]);
        }
    }

    public function postDeleteproduct(){
        $data = $_POST;
        $ProductModel = new ProductModel();
        $result = $ProductModel->deleteProductfromdb($data);

        if($result[0] === 1){
            echo json_encode(['status' => 'success', 'message' => $result[1]]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result[1]]);
        }
    }

    public function postChangedishname(){
        $data = $_POST;
        $ProductModel = new ProductModel();
        $result = $ProductModel->changeDishname($data);

        if($result[0] === 1){
            echo json_encode(['status' => 'success', 'newdishname' => $result[2]]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result[1]]);
        }
    }

    public function postChangedishprice(){
        $data = $_POST;
        $ProductModel = new ProductModel();
        $result = $ProductModel->changeDishprice($data);

        if($result[0] === 1){
            echo json_encode(['status' => 'success', 'newdishprice' => $result[2]]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result[1]]);
        }
    }

    public function postChangedishdesc(){
        $data = $_POST;
        $ProductModel = new ProductModel();
        $result = $ProductModel->changeDishdescription($data);

        if($result[0] === 1){
            echo json_encode(['status' => 'success', 'newdishdescription' => $result[2]]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result[1]]);
        }
    }

    public function postChangedishcategory(){
        $data = $_POST;
        $ProductModel = new ProductModel();
        $result = $ProductModel->changeProductcategory($data);

        if($result[0] === 1){
            echo json_encode(['status' => 'success', 'newdishcategory' => $result[2]]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result[1]]);
        }
    }

    public function postSetproductdiscount(){
        $data = $_POST;
        $ProductModel = new ProductModel();
        $result = $ProductModel->Setproductdiscount($data);

        if($result[0] === 1){
            echo json_encode(['status' => 'success', 'newdiscount' => $result[2]]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result[1]]);
        }
    }

    public function postChangeproductimage(){
        $data = $_POST;
        $ProductModel = new ProductModel();
        $result = $ProductModel->changeProductImage($data);

        if($result[0] === 1){
            echo json_encode(['status' => 'success', 'newimage' => $result[2]]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result[1]]);
        }
    }
}