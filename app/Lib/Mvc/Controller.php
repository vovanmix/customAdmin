<?php

namespace Vovanmix\CustomAdmin\Lib\Mvc;

class Controller{

    public function render($view, $parameters){

    }

    /**
     * @return \Vovanmix\CustomAdmin\Lib\Container
     */
    public function getContainer(){
        return \Vovanmix\CustomAdmin\Lib\Container::getInstance();
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