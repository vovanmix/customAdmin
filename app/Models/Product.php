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

//    protected $images;
//    protected $relations = ['images' =>
//        [
//            'type' => 'one-to-many',
//            'model' => 'ProductImage'
//        ]
//    ];

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

    public function setName($name){
        $this->name = $name;
    }

    public function setCategory_id($category_id){
        $this->category_id = $category_id;
    }

    public function setText($text){
        $this->text = $text;
    }

    public function setCreated_at($created_at){
        $this->created_at = $created_at;
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

    public function __toString(){
        return $this->getName();
    }

}