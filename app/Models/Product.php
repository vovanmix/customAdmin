<?php

namespace Vovanmix\CustomAdmin\Models;

use Vovanmix\CustomAdmin\Lib\Mvc\Model;
use Vovanmix\CustomAdmin\Lib\DependencyInjector;
use Vovanmix\CustomAdmin\Lib\Mvc\ModelInterface;

class Product extends Model implements ModelInterface{

    protected $table = 'products';

    protected $name;
    protected $category_id;
    protected $text;
    protected $created_at;
    protected $updated_at;

    public function getName(){
        return $this->name;
    }

    public function getCategory_id(){
        return $this->category_id;
    }

    public function getText(){
        return $this->text;
    }

    public function getCreated_at(){
        return $this->created_at;
    }

    public function getUpdated_at(){
        return $this->updated_at;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function setCategory_id($category_id){
        $this->category_id = $category_id;
    }

    public function setText($text){
        $this->text = $text;
    }

    public function setCreated_at($val){
        if(!empty($val)){
            $this->created_at = $val;
        }
        else{
            if(empty($this->id)) {
                $this->created_at = date('Y-m-d H:i:s');
            }
        }
    }

    public function setUpdated_at($val){
        if(!empty($val)){
            $this->updated_at = $val;
        }
        else{
            $this->updated_at = date('Y-m-d H:i:s');
        }
    }

    /**
     * @return array
     */
    public function getImages(){
        if(!empty($this->id)){
            return DependencyInjector::getInstance()->getClassInstance("\\Vovanmix\\CustomAdmin\\Repositories\\ProductImageRepository")->findBy('product_id', $this->id);
        }
        else{
            return [];
        }
    }

    /**
     * @return Category
     */
    public function getCategory(){
        if(!empty($this->category_id)){
            return DependencyInjector::getInstance()->getClassInstance("\\Vovanmix\\CustomAdmin\\Repositories\\CategoryRepository")->getById($this->category_id);
        }
        else{
            return NULL;
        }
    }

    public function __toString(){
        return (string)$this->getName();
    }

}