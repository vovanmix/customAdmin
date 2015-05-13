<?php

namespace Vovanmix\CustomAdmin\Repositories;

use Vovanmix\CustomAdmin\Lib\Mvc\Repository;

class ProductRepository extends Repository{
    protected $modelClassName = "Product";
    protected $table = 'products';



}