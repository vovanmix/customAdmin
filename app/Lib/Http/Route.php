<?php

namespace Vovanmix\CustomAdmin\Lib\Http;

/**
 * Class Route
 * @package Vovanmix\CustomAdmin\Lib\Http
 * @property string $controller
 * @property string $action
 * @property int $id
 */
class Route{

    private $controller;
    private $action;
    private $id;

    public function __construct($routeSchema){
        $this->controller = !empty($routeSchema['controller']) ? $routeSchema['controller'] : 'home';
        $this->action = !empty($routeSchema['action']) ? $routeSchema['action'] : 'index';
        $this->id = !empty($routeSchema['id']) ? (int)$routeSchema['id'] : NULL;
    }

    public function getController(){
        return $this->controller;
    }

    public function getAction(){
        return $this->action;
    }

    public function getId(){
        return $this->id;
    }

}