<?php

function getContainer(){
    return \Vovanmix\CustomAdmin\Lib\Container::getInstance();
}

define('ROOT', __DIR__.'/../..');
define('APP', ROOT.'/app');
define('CONFIG', APP.'/config');

require_once ROOT . '/vendor/autoload.php';

$container = getContainer();
$container->init();

$container->serve();