<?php

namespace kernel\src\services;

use kernel\src\helpers\RequestHelper;
use kernel\src\helpers\UrlHelper;

class RouterService
{
    private UrlHelper $urlHelper;
    private RequestHelper $requestHelper;

    public function __construct(UrlHelper $urlHelper, RequestHelper $requestHelper)
    {
        $this->urlHelper = $urlHelper;
        $this->requestHelper = $requestHelper;
    }

    public function getRoutes()
    {
        return require_once ROOT_PATH . DIRECTORY_SEPARATOR . 'router.php';
    }

    public function findRoute()
    {
        $routes = $this->getRoutes();
        $expectedRoute = $this->requestHelper->getType() . ':' . $this->urlHelper->getRequestUri();
        return $routes[$expectedRoute] ?? false;
    }

    public function resolveController()
    {
        if ($route = $this->findRoute()) {
            $controller = new $route[0];
            return call_user_func([$controller, $route[1]]);
        }
        return http_response_code(404);
    }
}