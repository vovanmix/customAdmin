<?php

namespace Vovanmix\CustomAdmin\Models;

use Vovanmix\CustomAdmin\Lib\Mvc\Model;

class Product extends Model{

    protected $table = 'products';

    protected $name;
    protected $category_id;
    protected $text;

    public function getName(){
        return $this->name;
    }

    public function getCategory_id(){
        return $this->category_id;
    }

    public function getText(){
        return $this->text;
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

}