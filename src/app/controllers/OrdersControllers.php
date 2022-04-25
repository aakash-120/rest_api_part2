<?php

use Phalcon\Mvc\Controller;

class OrdersController extends Controller
{
    public function indexAction()
    {
        $data = $this->test->order->find();
        $this->view->orders = $data;
    }
}
