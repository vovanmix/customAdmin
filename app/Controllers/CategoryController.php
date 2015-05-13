<?php

namespace Vovanmix\CustomAdmin\Controllers;

use Vovanmix\CustomAdmin\Models\Category;
use Vovanmix\CustomAdmin\Lib\Mvc\Controller;

class CategoryController extends Controller{

    function __construct(){

    }

    function add(){

        /**
         * @var Category $category
         */
        $category = $this->createClassInstance("\\Vovanmix\\CustomAdmin\\Models\\Category");

        $category->setName('Hello');

        var_dump( $category->compactData() );

        return 'hello';
    }

}