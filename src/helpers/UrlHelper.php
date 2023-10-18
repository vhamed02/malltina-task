<?php

namespace src\helpers;

class UrlHelper
{
    public function getRequestUri()
    {
        return trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    }

    public function explodeRequestUri($route=null)
    {
        return explode('/', $route ?? $this->getRequestUri());
    }
}