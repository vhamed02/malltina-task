<?php

namespace src\services;

use src\helpers\JsonResponse;
use src\helpers\RequestHelper;
use src\helpers\UrlHelper;
use src\objects\Route;

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
        $requestType = $this->requestHelper->getType();
        $requestUri = $this->urlHelper->getRequestUri();

        if (!isset($routes[$requestType])) {
            return false;
        }
        if (isset($routes[$requestType][$requestUri])) {
            return new Route(
                $requestType,
                $requestUri,
                $routes[$requestType][$requestUri],
                []
            );
        }
        // if we reach here, means that the route doesn't found yet
        $requestParts = $this->urlHelper->explodeRequestUri();
        foreach ($routes[$requestType] as $route => $action) {
            $routeParts = $this->urlHelper->explodeRequestUri($route);
            if (count($routeParts) != count($requestParts))
                continue;

            $matched = true;
            $params = array();
            for ($i = 0; $i < count($routeParts); $i++) {
                if (str_contains($routeParts[$i], '{')) {
                    $params[str_replace(['{', '}'], '', $routeParts[$i])] = $requestParts[$i];
                    break;
                }
                if ($routeParts[$i] != $requestParts[$i]) {
                    $matched = false;
                    break;
                }
            }
            if ($matched) { // returns the first matched route
                return new Route(
                    $requestType,
                    $route,
                    $action,
                    $params
                );
            }
        }

        return false;
    }

    public function resolve()
    {
        try {
            if ($route = $this->findRoute()) {
                if (!class_exists($class = $route->getActionControllerClass())) {
                    throw new \Exception(sprintf("Class [%s] does not exists!", $route[0]));
                }
                if (!method_exists($class, $method = $route->getActionControllerMethod())) {
                    throw new \Exception(
                        sprintf(
                            "The method [%s] does not defined in [%s] class!",
                            $route[1],
                            $route[0]
                        )
                    );
                }
                $controller = new $class;

                return call_user_func([$controller, $method], new RequestHelper($route->getParams()));
            }
        } catch (\Exception $exception) {
            JsonResponse::create([
                'status' => 500,
                'message' => $exception->getMessage()
            ]);
        }

        return JsonResponse::create([
            'status' => 404,
            'message' => 'not found'
        ]);
    }
}