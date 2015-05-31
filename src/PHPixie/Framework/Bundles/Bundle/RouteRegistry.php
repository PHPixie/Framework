<?php

namespace PHPixie\Framework\Bundles\Bundle;

class RouteRegistry
{
    protected $router;
    protected $configData;
    
    public function __construct($router, $configData)
    {
        $this->router     = $router;
        $this->configData = $configData;
    }
    
    public function get($name)
    {
        if(!array_key_exists($name, $this->instances)) {
            $this->instances[$name] = $this->buildRoute($name);
        }
        return $this->instances[$name];
    }
    
    protected function buildRoute($name)
    {
        $config = $this->configData->slice($name);
        return $this->router->buildRouteFromConfig($config);
    }
}    