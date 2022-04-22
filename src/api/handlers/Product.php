<?php

namespace Api\Handlers;

use Phalcon\Di\Injectable;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Product extends Injectable
{
   
    function searchProducts($keyword = "")
    {
        $keywords = explode(" ", urldecode($keyword));
        $array = [];
        foreach ($keywords as $value) {
            $products = $this->mongo->products->find(
                [
                    'name' => [
                        '$regex' => $value,
                        '$options' => '$i'
                    ]
                ]
            );
            array_push($array, $products->toArray());
        }
        return json_encode($array);
    }

    function gettoken()
    {
        $key = "example_key";
        $payload = array(
            "iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => 1356999524,
            "exp" => time() * 24 + 3600,
            "role" => "admin"
        );

        $jwt = JWT::encode($payload, $key, 'HS256');
        return $jwt;
    }

  
    public function add()
    {
        $insert = $this->request->getPost();
        $key = "example_key";
        $bearer = $this->request->get('token');
        $jwt = JWT::decode($bearer, new Key($key, 'HS256'));
        if (isset($jwt)) {
            $data = $this->mongo->test->products->insertOne([
                'name' => $insert['name'],
                'price' => $insert['price'],
                'category' => $insert['category'],
                'quantity' => $insert['quantity'],
            ]);
            echo "<pre>";
            print_r($data);
        }
        else{
            echo "provide token";
            die;
        }
    }


    public function list()
    {
        $productlist = $this->mongo->test->products->find();
        // print_r("<pre>");
        // print_r($productlist->toArray());
        // die;
        foreach ($productlist as $key => $value) {
            $val[] = $value;
        }
        echo json_encode($val);
    }
}
