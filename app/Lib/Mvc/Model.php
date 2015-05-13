<?php

namespace Vovanmix\CustomAdmin\Lib\Mvc;

use Vovanmix\CustomAdmin\Lib\Database\Orm;
use Vovanmix\CustomAdmin\Lib\Exceptions\ModelException;

/**
 * Class Model
 * @package Vovanmix\CustomAdmin\Lib\Mvc
 * @property ORM $ORM
 * @property string $table
 */
class Model{

    protected $ORM;
    protected $table;
    protected $id;

    public function __construct(Orm &$Orm){
        $this->ORM = $Orm;
    }

    public function getTableName(){
        return $this->table;
    }

    public function setId($id){
        $this->id = $id;
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
            if(!in_array($property, ['ORM', 'table'])) {
                $data[$property] = $this->{'get'.ucfirst($property)}();
            }
        }

        return $data;
    }

    /**
     * @param $data
     */
    public function fillData($data){
        foreach($this as $property => $value) {
            if(!in_array($property, ['ORM', 'table'])) {
                if(isset($data[$property])){
                    $this->{'set'.ucfirst($property)}($data[$property]);
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