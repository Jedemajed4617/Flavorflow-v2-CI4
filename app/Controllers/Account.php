<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\CommonModel;

class Account extends BaseController
{
    public function getIndex()
    {
        echo view('templates/smallnav');
        echo view('account/index'); 
        echo view('templates/smallfooter');
    }

    public function getRegister()
    {
        echo view('templates/smallnav');
        echo view('account/register'); 
        echo view('templates/smallfooter');
    }

    public function postProcess()
    {
        $data = $_POST;
        $UserModel = new UserModel();
        $result = $UserModel->processUserLogin($data['email'], $data['password']);
        if($result[0] == 1){
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result[1]]);
        }
    }

    public function postCreate()
    {
        $data = $_POST;
        $UserModel = new UserModel();
        $result = $UserModel->createUser($data);
        if($result[0] == 1){
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result[1]]);
        }
    }

    public function getLogout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }

    public function postChangepassword()
    {
        $data = $_POST;
        $CommonModel = new CommonModel();
        $result = $CommonModel->changePassword($data);
        if($result[0] == 1){
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result[1]]);
        }
    }

    public function postChangeemail()
    {
        $data = $_POST;
        $CommonModel = new CommonModel();
        $result = $CommonModel->changeEmail($data);
        if($result[0] == 1){
            echo json_encode(['status' => 'success', 'newemail' => $result[2]]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result[1]]);
        }
    }

    public function postChangefirstname()
    {
        $data = $_POST;
        $CommonModel = new CommonModel();
        $result = $CommonModel->changeFirstname($data);
        if($result[0] == 1){
            echo json_encode(['status' => 'success', 'newfname' => $result[2]]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result[1]]);
        }
    }

    public function postChangelastname()
    {
        $data = $_POST;
        $CommonModel = new CommonModel();
        $result = $CommonModel->changeLastname($data);
        if($result[0] == 1){
            echo json_encode(['status' => 'success', 'newlname' => $result[2]]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result[1]]);
        }
    }

    public function postChangeusername()
    {
        $data = $_POST;
        $CommonModel = new CommonModel();
        $result = $CommonModel->changeUsername($data);
        if($result[0] == 1){
            echo json_encode(['status' => 'success', 'newusername' => $result[2]]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result[1]]);
        }
    }

    public function postChangephone()
    {
        $data = $_POST;
        $CommonModel = new CommonModel();
        $result = $CommonModel->changePhone($data);
        if($result[0] == 1){
            echo json_encode(['status' => 'success', 'newphone' => $result[2]]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result[1]]);
        }
    }

    public function postChangegender()
    {
        $data = $_POST;
        $CommonModel = new CommonModel();
        $result = $CommonModel->changeGender($data);
        if($result[0] == 1){
            echo json_encode(['status' => 'success', 'newgender' => $result[2]]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result[1]]);
        }
    }

    public function postChangebirthdate()
    {
        $data = $_POST;
        $CommonModel = new CommonModel();
        $result = $CommonModel->changeBirthdate($data);
        if($result[0] == 1){
            echo json_encode(['status' => 'success', 'newbdate' => $result[2]]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result[1]]);
        }
    }

    public function postAddaddress()
    {
        $data = $_POST;
        $CommonModel = new CommonModel();
        $result = $CommonModel->addAddress($data);
        if($result[0] == 1){
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result[1]]);
        }
    }
}