<?php

namespace Vovanmix\CustomAdmin\Repositories;

use Vovanmix\CustomAdmin\Lib\Mvc\Repository;
use Vovanmix\CustomAdmin\Lib\Mvc\RepositoryInterface;

class ProductImageRepository extends Repository implements RepositoryInterface{
    protected $modelClassName = "ProductImage";
    protected $table = 'product_images';



}