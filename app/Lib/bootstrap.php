<?php

function getContainer(){
    return \Vovanmix\CustomAdmin\Lib\Container::getInstance();
}

require_once __DIR__ . '/../../vendor/autoload.php';

$container = getContainer();
$container->init();

$container->serve();