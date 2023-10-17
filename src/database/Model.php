<?php

namespace src\database;

use src\helpers\DBHelper;
use src\helpers\JsonResponse;

abstract class Model
{
    /**
     * @return string
     */
    abstract public function getTableName(): string;

    /**
     * @param array $data
     * @return void
     */
    public function create(array $data): void
    {
        $tableName = $this->getTableName();
        $columns = implode(',', array_keys($data));
        $values = array_map(function ($item) {
            return "'" . $item . "'";
        }, $data);
        $values = implode(',', $values);
        DBHelper::getInstance()->exec("INSERT INTO {$tableName} ({$columns}) VALUES ({$values})");
    }

    /**
     * @param $id
     * @return array|false|null
     */
    public function getById($id)
    {
        return DBHelper::getInstance()->fetchRow(
            sprintf("SELECT * FROM %s WHERE id = %d", $this->getTableName(), $id)
        );
    }

}