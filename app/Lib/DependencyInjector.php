<?php

namespace Vovanmix\CustomAdmin\Lib;

use ReflectionMethod;

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
     * @param Container $container
     */
    function __construct(&$container){
        $this->container = $container;
    }

    public function getConstructorDependencies($controller){

        $classReflection = new \ReflectionClass($controller);
        $ref = $classReflection->getConstructor();

        $parameters = $this->getParameters($ref);
//        foreach( $ref->getParameters() as $param) {
//            var_dump($param);
//            echo $param.'<br>';
//        }

        return $parameters;
    }

    /**
     * @param $controller
     * @param $actionName
     * @return array
     */
    public function getActionDependencies($controller, $actionName){

        //todo: analyse

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
                    if (isset($this->dependencies[$className])) {
                        $classInstance = &$this->dependencies[$className];
                    } else {
                        $dependencies = $this->getConstructorDependencies($className);
                        $classInstance = new $className($dependencies);
                        $this->dependencies[$className] = &$classInstance;
                    }
                    $parameters[] = $classInstance;
                } else {
                    $parameters[] = $this->getRouteParameter($param->getName());
                }
            }
        }

        return $parameters;
    }

    private function getRouteParameter($name){
        return $this->container->getRouter()->getRoute($this->container->getRequest())->{'get'.ucfirst($name)}();
    }

}