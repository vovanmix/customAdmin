<?php

namespace Vovanmix\CustomAdmin\Models;

use Vovanmix\CustomAdmin\Lib\Mvc\Model;

class Category extends Model{

    protected $table = 'categories';

    protected $name;
    protected $parent_id;
    protected $text;
    protected $created_at;
    protected $updated_at;

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

}