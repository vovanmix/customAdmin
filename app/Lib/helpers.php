<?php

function getContainer(){
    return \Vovanmix\CustomAdmin\Lib\Container::getInstance();
}

function redirect($url, $statusCode=302){
    getContainer()->getResponse()->redirect($url, $statusCode);
}