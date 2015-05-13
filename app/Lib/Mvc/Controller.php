<?php

namespace Vovanmix\CustomAdmin\Lib\Mvc;

use Vovanmix\CustomAdmin\Lib\Container;

class Controller{

    /**
     * @param $view
     * @param $parameters
     * @return string
     */
    public function render($view, $parameters=[]){
        $fullClassName = get_class($this);
        $className = str_replace("Vovanmix\\CustomAdmin\\Controllers\\", "", $fullClassName);
        $classShortName = str_replace("Controller", "", $className);
        echo "My name is " , $classShortName , "\n";die();
    }

    /**
     * @return Container
     */
    public function getContainer(){
        return Container::getInstance();
    }

    /**
     * @return \Vovanmix\CustomAdmin\Lib\DependencyInjector;
     */
    public function getDependencyInjector(){
        return $this->getContainer()->getDependencyInjector();
    }

    /**
     * @param string $ClassName
     * @return object
     */
    public function createClassInstance($ClassName){
        return $this->getDependencyInjector()->createClassInstance($ClassName);
    }

}