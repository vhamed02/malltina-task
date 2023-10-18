<?php

namespace src\objects;
class Route
{
    private string $type;
    private string $route;
    private array $action;
    private array $params;

    public function __construct(string $type, string $route, array $action, array $params)
    {
        $this->type = $type;
        $this->route = $route;
        $this->action = $action;
        $this->params = $params;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function getActionControllerClass(): string
    {
        return reset($this->action);
    }

    public function getActionControllerMethod(): string
    {
        return end($this->action);
    }

    public function getParams(): array
    {
        return $this->params;
    }
}