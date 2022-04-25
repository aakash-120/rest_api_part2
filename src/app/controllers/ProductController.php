<?php

use Phalcon\Mvc\Controller;


class ProductController extends Controller
{


    public function indexAction()
    {
        $url = "http://192.168.2.8:8080/api/productlist/list";
        $ch = curl_init($url);
     //   curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $res = json_decode($response, true);


        print_r($res);
        // die;
        $this->view->productlist = $res;
    }

    public function orderPlacedAction()
    {
        print_r($_POST);
        $name = $this->request->getPost('name');
        $price = $this->request->getPost('price');
        $category = $this->request->getPost('category');
        $quantity = $this->request->getPost('quantity');
        $id = $this->request->getPost('id');

        $this->view->name = $name;
        $this->view->price = $price;
        $this->view->category = $category;
        $this->view->quantity = $quantity;
        $this->view->id = $id;

        // print_r($name);
        // print_r($price);
        // print_r($category);
        // print_r($quantity);
        // print_r($id);


    }

    public function addtomongoAction()
    {
        print_r($_POST);
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $p_name = $this->request->getPost('name');
        $p_price = $this->request->getPost('price');
        $p_category = $this->request->getPost('category');
        $p_quantity = $this->request->getPost('quantity');
        $pid = $this->request->getPost('id');
        // echo $pid;
        // die;
        $collection = $this->mongo->test->order;
        $insertOneResult = $collection->insertOne(['username' => $username, 'email' => $email, 'password' => $password, 'p_name' => $p_name, 'p_price' => $p_price, 'p_category' => $p_category , 'p_quantity' => $p_quantity, 'pid' => $pid]);
       // $this->response->redirect('/add/view');
 
    }

}
