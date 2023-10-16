<?php

namespace App\models;

use src\database\Model;

class Wiki extends Model
{
    public function getTableName(): string
    {
        return 'wikis';
    }
}