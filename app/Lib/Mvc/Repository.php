<?php

namespace Vovanmix\CustomAdmin\Lib\Mvc;

use Vovanmix\CustomAdmin\Lib\Database\Orm;
use Vovanmix\CustomAdmin\Lib\DependencyInjector;

/**
 * Class Repository
 * @package Vovanmix\CustomAdmin\Lib\Mvc
 * @property ORM $ORM
 * @property string $modelClassName
 * @property string $table
 */
class Repository{

    protected $ORM;
    protected $modelClassName;
    protected $table;

    /**
     * @param Orm $Orm
     */
    public function __construct(Orm &$Orm){
        $this->ORM = $Orm;
    }

    /**
     * @param array $data
     * @return ModelInterface
     */
    public function createModelInstance($data){
        $modelClassName = "\\Vovanmix\\CustomAdmin\\Models\\".$this->modelClassName;
        $modelInstance = DependencyInjector::getInstance()->createClassInstance($modelClassName);

        $modelInstance->fillData($data);

        return $modelInstance;
    }

    /**
     * @return array
     */
    public function findAll(){
        $resultsArray = $this->ORM->findAll($this->table);
        $results = [];
        foreach($resultsArray as $result){
            $results[] = $this->createModelInstance($result);
        }
        return $results;
    }

    /**
     * @param int $id
     * @return ModelInterface
     */
    public function getById($id){
        $resultArray = $this->ORM->getById($this->table, $id);
        $result = $this->createModelInstance($resultArray);
        return $result;
    }

    /**
     * @param string $field
     * @param string $value
     * @return array
     */
    public function findBy($field, $value){
        $resultsArray = $this->ORM->findBy($this->table, $field, $value);
        $results = [];
        foreach($resultsArray as $result){
            $results[] = $this->createModelInstance($result);
        }
        return $results;
    }

}