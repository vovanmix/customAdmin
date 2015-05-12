<?php

namespace Vovanmix\CustomAdmin\Lib;

use Vovanmix\CustomAdmin\Lib\Exceptions\HttpNotFoundException;
use Vovanmix\CustomAdmin\Lib\Http\Response;
use Vovanmix\CustomAdmin\Lib\Http\Route;
use Vovanmix\CustomAdmin\Lib\Mvc\Controller;
use Exception;

/**
 * Class Container
 * @package Vovanmix\CustomAdmin\Lib
 * @property Http\Request request
 * @property Http\Router router
 * @property Http\Response response
 * @property DependencyInjector dependencyInjector
 */
class Container{

    private $request;
    private $router;
    private $response;
    private $dependencyInjector;

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

    /**
     *
     */
    public function init(){
        $this->request = new Http\Request();
        $this->router = new Http\Router();
        $this->response = new Response();
        $this->dependencyInjector = new DependencyInjector();
    }

    /**
     * @throws HttpNotFoundException
     */
    public function serve(){
        $this->request->readSystemInput();
        $route = $this->router->getRoute($this->request);

        try {
            $response = $this->callController($route);
        }
        catch(Exception $e){
            $response = $this->handleException($e);
        }

        $this->response->setContent($response);
        $this->response->output();
    }

    /**
     * @param Exception $e
     * @return mixed
     */
    private function handleException($e){
        //todo
    }

    /**
     * @param Route $route
     * @return mixed
     * @throws HttpNotFoundException
     */
    private function callController($route){

        $controllerName = '\\Vovanmix\\CustomAdmin\\Controllers\\'.$route->getController();
        if(class_exists($controllerName)){
            $controller = new $controllerName($this);
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
            $dependencies = $this->dependencyInjector->getActionDependencies($controller->$actionName);
            return call_user_func_array($controller->$actionName, $dependencies);
        }
        else{
            throw new HttpNotFoundException();
        }
    }


}