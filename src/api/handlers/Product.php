<?php

namespace Api\Handlers;

use Phalcon\Di\Injectable;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Phalcon\Http\Response;


class Product extends Injectable
{
    
    function getProducts($per_page = 10, $page = 1)
    {
        $collection = $this->mongo->products->find();
        // foreach ($collection as $k => $v) {
        //     echo '<pre>';
        //     echo $v->brand;
        $array = $collection->toArray();
        return json_encode($array);
    }
    
    function searchProducts($keyword = "")
    {
        $response = new Response();

        if (strpos($keyword, "%20") == true) {
            $newstr = explode("%20", $keyword);
            foreach ($newstr as $str) {
                $arr[] = array('name' => ['$regex' => $str]);
            }
            $products = $this->mongo->products->find(['$or' => $arr])->toArray();
        } else {
            $products = $this->mongo->products->find(
                [
                    'name' => [
                        '$regex' => $keyword,
                        '$options' => '$i'
                    ]
                ]
            )->toArray();
        }

        if(json_encode($products)=="[]"){
            return json_encode(array("status"=>"404, please enter correct keyword"));
        }
        else{
            $data = ["status" => 200, "data" => array_values($products)];
            // return json_encode($data);
           return $response->setJSONContent($data)->send();
        }
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
