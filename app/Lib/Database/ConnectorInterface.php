<?php

namespace Vovanmix\CustomAdmin\Lib\Database;

interface ConnectorInterface{

    public function connect();

    public function checkConnectionData();

    public function execute($query);

    /**
     * @param $query
     * @return array
     */
    public function getOne($query);

    /**
     * @param $query
     * @return array
     */
    public function getMany($query);

    /**
     * @return int|NULL
     */
    public function lastInsertId();

}