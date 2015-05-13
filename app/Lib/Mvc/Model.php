<?php

namespace Vovanmix\CustomAdmin\Lib\Mvc;

use Vovanmix\CustomAdmin\Lib\Database\Orm;
use Vovanmix\CustomAdmin\Lib\Exceptions\ModelException;

/**
 * Class Model
 * @package Vovanmix\CustomAdmin\Lib\Mvc
 * @property ORM $ORM
 * @property string $table
 * @property array $foreignFields
 */
class Model{

    protected $ORM;
    protected $table;
    protected $id;
    protected $foreignFields;

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
     */
    public function compactData(){
        $data = [];
        foreach($this as $property => $value) {
            $method = 'get'.ucfirst($property);
            if(method_exists($this, $method) && !in_array($property, $this->foreignFields)) {
                $data[$property] = $this->$method();
            }
        }

        return $data;
    }

    /**
     * @param $data
     */
    public function fillData($data){
        foreach($this as $property => $value) {
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

}