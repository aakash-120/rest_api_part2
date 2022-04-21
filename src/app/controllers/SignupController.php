<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller{

    public function IndexAction()
    {

    }

    public function registerAction() {
        $signup = $this->mongo->test->users ;
        $name = $this->request->get('name');
        $email = $this->request->get('email');
        $password = $this->request->get('password');
        $success = $signup->insertOne(['name' => $name, 'email' => $email , 'password' => $password]);


       die;
    }
}
