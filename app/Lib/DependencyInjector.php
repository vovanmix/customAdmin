<?php

namespace Vovanmix\CustomAdmin\Lib;

use ReflectionMethod;
use ReflectionClass;
use Vovanmix\CustomAdmin\Lib\Mvc\Controller;

/**
 * Class DependencyInjector
 * @package Vovanmix\CustomAdmin\Lib
 *
 * @property Container $container
 * @property Array $dependencies
 */
class DependencyInjector{

    private $dependencies;
    private $container;

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
     * @staticvar DependencyInjector $instance The *Singleton* instances of this class.
     * @return DependencyInjector The *Singleton* instance.
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
     * @param Container $container
     */
    function setContainer(&$container){
        $this->container = $container;
    }

    /**
     * @param Controller|string $controller
     * @return array
     */
    public function getConstructorDependencies($controller){

        $classReflection = new \ReflectionClass($controller);
        $ref = $classReflection->getConstructor();

        $parameters = $this->getParameters($ref);

        return $parameters;
    }

    /**
     * @param Controller|string $controller
     * @param string $actionName
     * @return array
     */
    public function getActionDependencies($controller, $actionName){

        $ref = new ReflectionMethod($controller, $actionName);

        $parameters = $this->getParameters($ref);

        return $parameters;
    }

    /**
     * @param ReflectionMethod $ref
     * @return array
     */
    private function getParameters($ref){
        $parameters = [];

        if(!empty($ref)) {
            foreach ($ref->getParameters() as $param) {

                $class = $param->getClass();

                if (!empty($class)) {
                    $className = $class->getName();
                    $classInstance = $this->getClassInstance($className);
                    $parameters[] = $classInstance;
                } else {
                    $parameters[] = $this->getRouteParameter($param->getName());
                }
            }
        }

        return $parameters;
    }



    /**
     * @param string $className
     * @return object
     */
    public function getClassInstance($className){
        if (isset($this->dependencies[$className])) {
            $classInstance = &$this->dependencies[$className];
        } else {
            $classInstance = $this->createClassInstance($className);
            $this->dependencies[$className] = &$classInstance;
        }

        return $classInstance;
    }

    /**
     * @param string $className
     * @return object
     */
    public function createClassInstance($className){
        $dependencies = $this->getConstructorDependencies($className);

        $r = new ReflectionClass($className);
        $classInstance = $r->newInstanceArgs($dependencies);

        return $classInstance;
    }

    private function getRouteParameter($name){
        return $this->container->getRouter()->getRoute($this->container->getRequest())->{'get'.ucfirst($name)}();
    }

}