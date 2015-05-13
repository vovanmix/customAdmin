<?php

namespace Vovanmix\CustomAdmin\Lib\Database;

/**
 * Class Orm
 * @package Vovanmix\CustomAdmin\Lib\Database
 * @property \Vovanmix\CustomAdmin\Lib\Database\ConnectorInterface $connector
 * @property array $config
 * @property QueryBuilderInterface $queryBuilderClass
 */
class Orm{

    private $config;
    private $connector;
    private $queryBuilderClass;

    function __construct(){
        $this->config = include(CONFIG.'/database.php');

        $connectorClassName = "\\Vovanmix\\CustomAdmin\\Lib\\Database\\".ucfirst($this->config['driver'])."Connector";
        $this->connector = new $connectorClassName($this->config);
        $this->connector->connect();

        $queryBuilderClassName = "\\Vovanmix\\CustomAdmin\\Lib\\Database\\".ucfirst($this->config['driver'])."QueryBuilder";
        $this->queryBuilderClass = new $queryBuilderClassName();
    }

    /**
     * @param string $table
     * @return array
     */
    public function findAll($table){
        $query = $this->queryBuilderClass->findAll($table);
        $results = $this->connector->getMany($query);
        return $results;
    }

    /**
     * @param string $table
     * @param string $field
     * @param string $value
     * @return array
     */
    public function findBy($table, $field, $value){
        $query = $this->queryBuilderClass->findBy($table, $field, $value);
        $results = $this->connector->getMany($query);
        return $results;
    }

    /**
     * @param string$table
     * @param int $id
     * @return array
     */
    public function getById($table, $id){
        $query = $this->queryBuilderClass->getById($table, $id);
        $result = $this->connector->getOne($query);
        return $result;
    }

    /**
     * @param string $table
     * @param array $data
     * @return int|NULL
     */
    public function save($table, $data){
        $query = $this->queryBuilderClass->save($table, $data);
        $this->connector->execute($query);
        $id = $this->connector->lastInsertId();
        return $id;
    }

    /**
     * @param string $table
     * @param int $id
     * @param array $data
     */
    public function update($table, $id, $data){
        $query = $this->queryBuilderClass->update($table, $id, $data);
        $this->connector->execute($query);
    }

    /**
     * @param string $table
     * @param int $id
     */
    public function delete($table, $id){
        $query = $this->queryBuilderClass->delete($table, $id);
        $this->connector->execute($query);
    }

}