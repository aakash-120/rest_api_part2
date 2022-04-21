<?php

namespace Api\Handlers;

use Phalcon\Di\Injectable;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Product extends Injectable
{
    function get($select = "", $where = "", $limit = 10, $page = 1)
    {
        $products = array(
            array('select' => $select, 'where' => $where, 'limit' => $limit, 'page' => $page),
            array('name' => 'Product 2', 'price' => 40)
        );
        return json_encode($products);
    }

    // function getProducts($pageNumber = "", $nPerPage ="") {
    //     print( "Page: " + $pageNumber );
    //     $this->mongo->products->find()
    //                .sort( { _id: 1 } )
    //                .skip( $pageNumber > 0 ? ( ( $pageNumber - 1 ) * $nPerPage ) : 0 )
    //                .limit( $nPerPage )
    //                .forEach( $product => {
    //                  print( $products->name );
    //                } );
    //   }
    function getProducts($per_page = "", $page = "")
    {
        
     $collection = $this->mongo->products->find();
  // $collection = $this->mongo->products->find()->limit(3);
       $array = $collection->toArray();
  
       
      //  $len = count($array);
      //  echo $len;
     //   echo $per_page * $page;

     
       // if ($len >= $per_page * $page)
        // {
        //     echo "found";
        // }
        // else {
        //     echo "not found";
        // }


     //   print_r($array);

        
        return json_encode($array);
    }
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
        // print_r(json_encode($array));
        // die;
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

    function addProducts($keyword = "")
    {
        echo $keyword;
        $collection = $this->mongo->products;
        $insertOneResult = $collection->insertOne(['name' => $keyword]);

    }

    
}
