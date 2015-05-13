<?php

namespace Vovanmix\CustomAdmin\Tests;

include __DIR__.'/../Lib/bootstrap.php';

use Vovanmix\CustomAdmin\Lib\Http\Router;
use Vovanmix\CustomAdmin\Lib\Http\Route;
use Vovanmix\CustomAdmin\Lib\Http\Request;

class queryBuildTest extends \PHPUnit_Framework_TestCase
{

    public function testUriWithId(){
        $Router = new Router();
        $Request = new Request();
        $Request->setInputServer([
            'REQUEST_URI' => '/category/edit/2/'
        ]);
        $Route = $Router->getRoute($Request);

        $ExpectedRoute = new Route([
            'controller' => 'category',
            'action' => 'edit',
            'id' => '2',
        ]);

        $this->assertEquals($ExpectedRoute, $Route);
    }

    public function testUriWithIndex(){
        $Router = new Router();
        $Request = new Request();
        $Request->setInputServer([
            'REQUEST_URI' => '/category/'
        ]);
        $Route = $Router->getRoute($Request);

        $ExpectedRoute = new Route([
            'controller' => 'category',
            'action' => 'index'
        ]);

        $this->assertEquals($ExpectedRoute, $Route);
    }

}