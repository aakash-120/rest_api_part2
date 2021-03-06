<?php

use Phalcon\Mvc\Micro;
use Phalcon\Loader;
use Phalcon\Di\FactoryDefault;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once "./vendor/autoload.php";

$loader = new Loader();
$loader->registerNamespaces(
    [
        'Api\Handlers' => './handlers'
    ]
);

$loader->register();

$product = new Api\Handlers\Product();
$order = new Api\Handlers\Order();

$container = new FactoryDefault();


$app = new Micro($container);



// $app->before(
//     function () use ($app) {
//         if (!str_contains($_SERVER['REQUEST_URI'], 'gettoken') && !str_contains($_SERVER['REQUEST_URI'], 'order')) {
//             $token = $app->request->getQuery("token");
//             if (!$token) {
//                 echo 'Token not provided"';
//                 die;
//             }
//             $key = 'example_key';
//             try {
//                 $decoded = JWT::decode($token, new Key($key, 'HS256'));
//                 // print_r($decoded);
//                 // die;
//             } catch (\Firebase\JWT\ExpiredException $e) {
//                 echo 'Caught exception: ',  $e->getMessage(), "\n";
//                 die;
//             }
//             // if ($decoded->role != 'admin') {
//             //     echo 'Permission Denied';
//             //     die;
//             // }
//         }
//     }
// );


$app->get(
    '/invoices/view/{id}/{where}/{limit}/{page}',
    [
        $product,
        'get'
    ]
);

$app->get(
    '/product/get/{per_page}/{page}',
    [
        $product,
        'getProducts'
    ]
);

$app->get(
    '/product/search/{keyword}',
    [
        $product,
        'searchProducts'
    ]
);

$app->get(
    '/api/gettoken',
    [
        $product,
        'gettoken'
    ]
);



$app->post(
    '/api/products/add',
    [
        $product,
        'add'
    ]
);

$app->get(
    '/api/productlist/list',
    [
        $product,
        'list'
    ]
);

$app->post(
    '/api/order/placeorder',
    [
        $order,
        'placeorder'
    ]
);

$app->put(
    '/api/order/updateorder',
    [
        $order,
        'updateorder'
    ]
);


$container->set(
    'mongo',
    function () {
        $mongo = new MongoDB\Client("mongodb://root:password123@mongo");

        return $mongo;
    },
    true
);



// $app->get(
//     '/products/search',
//     [
//         $prod,
//         'searchProducts'
//     ]
// );

// $app->get(
//     '/products/get/{per_page}/{page}',
//     [
//         $prod,
//         'getProducts'
//     ]
// );

try {
    $app->handle(
        $_SERVER['REQUEST_URI']
    );
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
