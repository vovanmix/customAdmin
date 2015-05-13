<?php

namespace Vovanmix\CustomAdmin\Repositories;

use Vovanmix\CustomAdmin\Lib\Mvc\Repository;
use Vovanmix\CustomAdmin\Lib\Mvc\RepositoryInterface;

class CategoryRepository extends Repository implements RepositoryInterface{
    protected $modelClassName = "Category";
    protected $table = 'categories';



}