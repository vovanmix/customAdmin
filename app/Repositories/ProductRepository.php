<?php

namespace Vovanmix\CustomAdmin\Repositories;

use Vovanmix\CustomAdmin\Lib\Mvc\Repository;
use Vovanmix\CustomAdmin\Lib\Mvc\RepositoryInterface;

class ProductRepository extends Repository implements RepositoryInterface{
    protected $modelClassName = "Product";
    protected $table = 'products';



}