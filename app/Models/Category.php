<?php

namespace Vovanmix\CustomAdmin\Models;

use Vovanmix\CustomAdmin\Lib\Mvc\Model;
use Vovanmix\CustomAdmin\Lib\DependencyInjector;
use Vovanmix\CustomAdmin\Lib\Mvc\ModelInterface;

class Category extends Model implements ModelInterface{

    protected $table = 'categories';

    protected $name;
    protected $parent_id;
    protected $text;
    protected $created_at;
    protected $updated_at;

    protected $foreignFields = ['parent'];
    protected $required = ['name'];

    public function getName(){
        return $this->name;
    }

    public function getParent_id(){
        return $this->parent_id;
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

    public function setParent_id($parent_id){
        $this->parent_id = $parent_id;
    }

    public function setText($text){
        $this->text = $text;
    }

    public function getParent(){
        if(!empty($this->parent_id)){
            return DependencyInjector::getInstance()->getClassInstance("\\Vovanmix\\CustomAdmin\\Repositories\\CategoryRepository")->getById($this->parent_id);
        }
        else{
            return NULL;
        }
    }

    public function __toString(){
        return (string)$this->getName();
    }

}