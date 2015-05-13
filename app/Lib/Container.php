<?php

namespace Vovanmix\CustomAdmin\Lib;

use Vovanmix\CustomAdmin\Lib\Exceptions\HttpNotFoundException;
use Vovanmix\CustomAdmin\Lib\Http\Response;
use Vovanmix\CustomAdmin\Lib\Http\Route;
use Vovanmix\CustomAdmin\Lib\Mvc\Controller;
use Vovanmix\CustomAdmin\Lib\Exceptions\HttpException;
use Vovanmix\CustomAdmin\Lib\Mvc\View;

/**
 * Class Container
 * @package Vovanmix\CustomAdmin\Lib
 * @property Http\Request request
 * @property Http\Router router
 * @property Http\Response response
 * @property DependencyInjector dependencyInjector
 * @property View view
 */
class Container{

    private $request;
    private $router;
    private $response;
    private $dependencyInjector;
    private $view;

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected function __construct(){}

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     * @return void
     */
    private function __clone(){}

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     * @return void
     */
    private function __wakeup(){}

    /**
     * Returns the *Singleton* instance of this class.
     * @staticvar Container $instance The *Singleton* instances of this class.
     * @return Container The *Singleton* instance.
     */
    public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    public function init(){
        session_start();
//        $this->request = new Http\Request();
//        $this->router = new Http\Router();
//        $this->response = new Response();
        $this->dependencyInjector = DependencyInjector::getInstance();
        $this->dependencyInjector->setContainer($this);

        $this->request = $this->dependencyInjector->getClassInstance("\\Vovanmix\\CustomAdmin\\Lib\\Http\\Request");
        $this->router = new Http\Router();
        $this->response = new Response();

        $this->view = new View();
    }

    /**
     * @throws HttpException
     */
    public function serve(){
        $this->request->readSystemInput();
        $route = $this->router->getRoute($this->request);

        try {
            $actionCode = $this->callController($route);
        }
        catch(HttpException $e){
            $actionCode = $this->handleException($e);
        }

        $responseCode = $this->view->renderLayout($actionCode);

        $this->response->setContent($responseCode);
        $this->response->output();
        session_commit();
    }

    public function getRouter(){
        return $this->router;
    }

    public function getRequest(){
        return $this->request;
    }

    public function getResponse(){
        return $this->response;
    }

    public function getDependencyInjector(){
        return $this->dependencyInjector;
    }

    public function getView(){
        return $this->view;
    }

    /**
     * @param $layout
     */
    public function setLayout($layout){
        $this->view->setLayout($layout);
    }

    /**
     * @param HttpException $e
     * @return mixed
     */
    private function handleException($e){
        $this->response->setStatus($e->getStatusCode());
        return $e->getMessage();
    }

    /**
     * @param Route $route
     * @return mixed
     * @throws HttpNotFoundException
     */
    private function callController($route){

        $controllerName = '\\Vovanmix\\CustomAdmin\\Controllers\\'.ucfirst($route->getController()).'Controller';
        if(class_exists($controllerName)){
            /** @var Controller $controller */
            $controller = $this->getDependencyInjector()->createClassInstance($controllerName);
            $response = $this->callAction($controller, $route);

            return $response;
        }
        else{
            throw new HttpNotFoundException();
        }
    }

    /**
     * @param Controller $controller
     * @param Route $route
     * @return mixed
     * @throws HttpNotFoundException
     */
    private function callAction($controller, $route){
        $actionName = $route->getAction();

        if(method_exists($controller, $actionName)){
            $dependencies = $this->getDependencyInjector()->getActionDependencies($controller, $actionName);
            return call_user_func_array([$controller, $actionName], $dependencies);
        }
        else{
            throw new HttpNotFoundException();
        }
    }


}