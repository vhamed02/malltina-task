<?php

namespace src\helpers;

use src\database\adapters\MysqliAdapter;
use src\database\Connections\MysqliConnection;

class DBHelper
{
    private static $instance;

    public static function getInstance() // singleton
    {
        if (self::$instance == null) {
            self::$instance = new MysqliAdapter(
                new MysqliConnection(
                    new ConfigReader()
                )
            );
        }

        return self::$instance;
    }
}