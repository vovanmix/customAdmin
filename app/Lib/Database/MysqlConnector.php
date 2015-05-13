<?php

namespace Vovanmix\CustomAdmin\Lib\Database;

use PDO;
use PDOException;
use PDOStatement;

/**
 * Class MysqlConnector
 * @package Vovanmix\CustomAdmin\Lib\Database
 * @property PDO $connection
 * @property array $config
 */
class MysqlConnector implements ConnectorInterface{

    private $config;
    private $connection;

    /**
     * @param array $config
     */
    public function __construct($config){
        $this->config = $config;
    }

    /**
     * @inheritdoc
     */
    public function connect(){
        try {
            $this->checkConnectionData();

            $connectionString = self::buildConnectionString($this->config);

            $dbConnection = new PDO($connectionString, $this->config['user'], $this->config['password']);
            $dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new PDOException('Connection failed: ' . $e->getMessage());
        }

        $this->connection = & $dbConnection;
    }

    /**
     * @return string
     */
    public function buildConnectionString(){
        $connectionString = 'mysql:';
        if (!empty($this->config['socket'])) {
            $connectionString .= 'unix_socket=' . $this->config['socket'] . ';';
        }
        $connectionString .= 'dbname=' . $this->config['base'] . ';host=' . $this->config['host'] . ';charset=' . $this->config['charset'];

        return $connectionString;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return PDOStatement
     */
    public function execute($sql, $params = array()){
        try {
            $sth = $this->connection->prepare($sql);
            $sth->execute($params);
        } catch (PDOException $e) {
            $this->logExecutionError($sql, $e);
            return NULL;
        }

        return $sth;
    }

    public function getOne($sql){
        $res = $this->execute($sql);
        $row = $res->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function getMany($sql){
        $res = $this->execute($sql);
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }

    /**
     * @throws \Exception
     */
    public function checkConnectionData(){
        if(empty($this->config['base'])){
            throw new \Exception('Base name is not specified');
        }
        if(empty($this->config['host'])){
            throw new \Exception('Host name is not specified');
        }
        if(empty($this->config['user'])){
            throw new \Exception('User is not specified');
        }
    }

    /**
     * @param $sql string
     * @param $e \Exception|PDOException
     */
    private function logExecutionError($sql, $e) {
        print "" . $e->getMessage() . "\r\n" . $sql . "\r\n\r\n";
    }

}