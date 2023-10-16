<?php

namespace src\helpers;

class UrlHelper
{
    public function getRequestUri()
    {
        return trim($_SERVER['REQUEST_URI'], '/');
    }
}