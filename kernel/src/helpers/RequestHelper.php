<?php

namespace kernel\src\helpers;

class RequestHelper
{
    public function getType()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}