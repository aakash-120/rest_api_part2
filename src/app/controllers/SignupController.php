<?php

use Phalcon\Mvc\Controller;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;



class SignupController extends Controller{

    public function IndexAction()
    {

    }

    public function registerAction() {
        $signup = $this->mongo->test->users ;
        $name = $this->request->get('name');
        $email = $this->request->get('email');
        $password = $this->request->get('password');
        $role = 'user';
        $success = $signup->insertOne(['name' => $name, 'email' => $email , 'password' => $password, 'role' => $role]);
        // $token = $this->token($name, $email);
        // echo $token;
        $user = $this->mongo->test->users->findOne(['email'=>$email]);
    
        $id = strval($user->_id);
        $token = $this->token($id);
        echo $token;
        die;
    }

    public function token($id)
    {
        $key = "example_key";
        $payload = array(
            "iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => 1356999524,
            "exp" => time() * 24 + 3600,
            "role" => "user",
            "id" => $id
        );

        $jwt = JWT::encode($payload, $key, 'HS256');

        return $jwt;
    }

    //  public function token($name, $email) {
    // $key = "example_key";
    // $payload = array(
    //     "iss" => "http://example.org",
    //     "aud" => "http://example.com",
    //     "iat" => 1356999524,
    //     "exp" => time() * 24 + 3600,
    //     "role" => "user",
    //     "name" => $name,
    //     "email" => $email
    // );
    //  $jwt = JWT::encode($payload, $key, 'HS256');
    // return $jwt;
    //}




}