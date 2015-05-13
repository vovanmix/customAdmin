<?php

namespace Vovanmix\CustomAdmin\Lib\Database;

class MysqlQueryBuilder implements QueryBuilderInterface{

    public static function prepare($value){
        if( is_string($value) ) {
            $value = str_replace("'", '`', $value);
            $value = addslashes(trim($value));
        }
        if(is_array($value)) {
            $value = reset($value);
        }
        $value = !empty($value) ? "'" . $value . "'" : (($value === 0 || $value === '0') ? '0' : ($value === '' ? '""' : ($value === false ? 0 : 'NULL')));
        return $value;
    }

    /**
     * @inheritdoc
     */
    public function findAll($table){
        return "SELECT * FROM `$table`";
    }

    /**
     * @inheritdoc
     */
    public function getById($table, $id){
        return "SELECT * FROM `$table` WHERE id = '$id'";
    }

    /**
     * @inheritdoc
     */
    public function save($table, $data){
        $q = 'INSERT INTO `' . $table .'`';
        $fields = array();
        $values = array();
        foreach ($data as $field => $value) {
            $fields[] = $field;
            $values[] = self::prepare($value);
        }
        $q .= ' (' . implode(',', $fields) . ')';
        $q .= ' VALUES (' . implode(',', $values) . ')';
        return $q;
    }

    /**
     * @inheritdoc
     */
    public function update($table, $id, $data){
        $q = 'UPDATE `' . $table . '` SET ';
        $fields = array();
        foreach ($data as $field => $value) {
            if(substr($field, -2) == '==') {
                $field = substr($field, 0, -2);
                $fields[] = $field . ' = ' . $value;
            } else{
                $fields[] = $field . ' = ' . self::prepare($value);
            }
        }
        $q .= implode(',', $fields);
        $q .= ' WHERE id = "'.$id.'"';

        return $q;
    }

}