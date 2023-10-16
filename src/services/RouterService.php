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
            try {
                if(!class_exists($route[0])) {
                    throw new \Exception(sprintf("Class [%s] does not exists!", $route[0]));
                }
                if(!method_exists($route[0], $route[1])) {
                    throw new \Exception(
                        sprintf(
                            "The method [%s] does not defined in [%s] class!",
                            $route[1],
                            $route[0]
                        )
                    );
                }
                $controller = new $route[0];
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