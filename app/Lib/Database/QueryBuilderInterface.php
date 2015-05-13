<?php

namespace Vovanmix\CustomAdmin\Lib\Database;

interface QueryBuilderInterface{

    /**
     * @param string $table
     * @return string
     */
    public function findAll($table);

    /**
     * @param string $table
     * @param int $id
     * @return string
     */
    public function getById($table, $id);

    /**
     * @param string $table
     * @param array $data
     * @return string
     */
    public function save($table, $data);

    /**
     * @param string $table
     * @param int $id
     * @param array $data
     * @return string
     */
    public function update($table, $id, $data);

}