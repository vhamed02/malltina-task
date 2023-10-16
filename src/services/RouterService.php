<?php

namespace src\services;

use src\helpers\JsonResponse;
use src\helpers\RequestHelper;
use src\helpers\UrlHelper;

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
            try {
                return call_user_func([$controller, $route[1]], new RequestHelper());
            } catch (\Exception $exception) {
                JsonResponse::create([
                    'hasError' => true,
                    'message' => $exception->getMessage()
                ]);
            }
        }
        return http_response_code(404);
    }
}