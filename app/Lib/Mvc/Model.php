<?php

namespace Vovanmix\CustomAdmin\Lib\Mvc;

use Vovanmix\CustomAdmin\Lib\Database\Orm;
use Vovanmix\CustomAdmin\Lib\Exceptions\ModelException;
use Vovanmix\CustomAdmin\Lib\Exceptions\ValidationException;

/**
 * Class Model
 * @package Vovanmix\CustomAdmin\Lib\Mvc
 * @property ORM $ORM
 * @property string $table
 * @property array $foreignFields
 * @property array $required
 */
class Model{

    protected $ORM;
    protected $table;
    protected $id;
    protected $foreignFields;
    protected $required;

    public function __construct(Orm &$Orm){
        $this->ORM = $Orm;
    }

    public function getTableName(){
        return $this->table;
    }

    public function setId($id){
        if(!empty($id)) {
            $this->id = $id;
        }
    }

    public function getId(){
        return $this->id;
    }

    /**
     * @return array
     * @throws ValidationException
     */
    public function compactData(){
        $data = [];
        foreach(get_object_vars($this) as $property => $value) {
            $method = 'get'.ucfirst($property);
            if(method_exists($this, $method) && !in_array($property, $this->foreignFields)) {
                $propertyValue = $this->$method();
                $this->validate($property, $propertyValue);
                $data[$property] = $propertyValue;
            }
        }

        return $data;
    }

    private function validate($property, $propertyValue){
        if(in_array($property, $this->required) && empty($propertyValue)){
            throw new ValidationException('Field '.$property.' should not be left blank!');
        }
    }

    /**
     * @param $data
     */
    public function fillData($data){
        foreach(get_object_vars($this) as $property => $value) {
            $method = 'set'.ucfirst($property);
            if(method_exists($this, $method) && !in_array($property, $this->foreignFields)) {
                if (isset($data[$property])) {
                    $this->$method($data[$property]);
                } else {
                    $this->$method(NULL);
                }
            }
        }
    }

    public function save(){
        $data = $this->compactData();
        if(empty($data)){
            throw new ModelException('No Data Provided When Save Called!');
        }
        $id = $this->ORM->save($this->table, $data);
        $this->setId($id);
    }

    public function update(){
        $data = $this->compactData();
        if(empty($this->id)){
            throw new ModelException('No Id Provided When Update Called!');
        }
        if(empty($data)){
            throw new ModelException('No Data Provided When Update Called!');
        }
        $this->ORM->update($this->table, $this->id, $data);
    }

    public function delete(){
        if(empty($this->id)){
            throw new ModelException('No Id Provided When Delete Called!');
        }
        $this->ORM->delete($this->table, $this->id);
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