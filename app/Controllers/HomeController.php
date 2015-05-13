<?php

namespace Vovanmix\CustomAdmin\Controllers;

use Vovanmix\CustomAdmin\Lib\Mvc\Controller;

class HomeController extends Controller{

    public function index(){
        return $this->render('index');
    }

}