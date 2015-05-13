<?php

namespace Vovanmix\CustomAdmin\Models;

use Vovanmix\CustomAdmin\Lib\Mvc\Model;
use Vovanmix\CustomAdmin\Lib\DependencyInjector;
use Vovanmix\CustomAdmin\Lib\Mvc\ModelInterface;
use Vovanmix\CustomAdmin\Lib\Exceptions\ValidationException;

/**
 * Class ProductImage
 * @package Vovanmix\CustomAdmin\Models
 * @property Product product
 */
class ProductImage extends Model implements ModelInterface{

    protected $table = 'product_images';

    protected $file;
    protected $product_id;
    protected $product;

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
     * @return Product|null
     */
    public function getProduct(){
        if(!empty($this->product_id)){
            return DependencyInjector::getInstance()->getClassInstance("\\Vovanmix\\CustomAdmin\\Repositories\\ProductRepository")->getById($this->product_id);
        }
        else{
            return NULL;
        }
    }

    /**
     * @param Product $product
     */
    public function setProduct($product){
        $this->product = $product;
        $this->setProduct_id($product->getId());
    }

    public function generateName($newImage){
        $fileName = uniqid($this->product->getName()).$this->getExtension($newImage);
        $this->setFile($fileName);
        return $fileName;
    }

    public function getExtension($newImage){
        $type = $newImage['type'];
        if(in_array($type, ['image/jpeg', 'image/gif', 'image/png'])){
            return str_replace('image/', '.', $type);
        }else{
            throw new ValidationException('File format is wrong!');
        }
    }

}