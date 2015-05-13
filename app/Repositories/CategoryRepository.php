<?php

namespace Vovanmix\CustomAdmin\Repositories;

use Vovanmix\CustomAdmin\Lib\Mvc\Repository;

class CategoryRepository extends Repository{
    protected $modelClassName = "Category";
    protected $table = 'categories';



}