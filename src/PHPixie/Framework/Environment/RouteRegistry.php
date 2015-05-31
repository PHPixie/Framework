<?php

namespace PHPixie\Framework\Environment;

class RouteRegistry implements \PHPixie\Router\Routes\Registry
{
    protected $bundles;
    
    public function __construct($bundles)
    {
        $this->bundles = $bundle;
    }
    
    public function get($name)
    {
        list($bundleName, $name) = explode($name);
        $bundle = $this->bundles->get($bundleName);
        $bundle->routeRegistry()->get($name);
    }
}   