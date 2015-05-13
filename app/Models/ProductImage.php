<?php

namespace Vovanmix\CustomAdmin\Models;

use Vovanmix\CustomAdmin\Lib\Mvc\Model;
use Vovanmix\CustomAdmin\Lib\DependencyInjector;

class ProductImage extends Model{

    protected $table = 'product_images';

    protected $file;
    protected $product_id;

    public function getFile(){
        return $this->file;
    }

    public function getProduct_id(){
        return $this->product_id;
    }

    public function setFile($file){
        $this->file = $file;
    }

    public function setProduct_id($product_id){
        $this->product_id = $product_id;
    }

    /**
     * @return \Vovanmix\CustomAdmin\Models\Product|null
     */
    public function getProduct(){
        if(!empty($this->product_id)){
            return DependencyInjector::getInstance()->getClassInstance("\\Vovanmix\\CustomAdmin\\Repositories\\ProductRepository")->getById($this->product_id);
        }
        else{
            return NULL;
        }
    }

}