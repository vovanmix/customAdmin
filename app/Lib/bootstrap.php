<?php

define('ROOT', __DIR__.'/../..');
define('APP', ROOT.'/app');
define('CONFIG', APP.'/config');
define('WEBROOT', ROOT.'/webroot');

require_once __DIR__.'/helpers.php';

require_once ROOT . '/vendor/autoload.php';

$container = getContainer();
$container->init();

$container->serve();