<?php

namespace PHPixie\Framework\Bundles\Bundle;

class Implementation
{
    protected $bundles;
    
    public function routeRegistry()
    {
        return $this->instance('routeRegistry');
    }
    
    public function locatorRegistry()
    {
        return $this->instance('locatorRegistry');
    }
    
    public function ormWrappers()
    {
        return $this->instance('ormWrappers');
    }
    
    protected function instance($name)
    {
        if(!array_key_exists($name, $this->instances)) {
            $method = 'build'.ucfirst($name);
            $this->instances[$name] = $this->$method();
        }
        
        return $this->instances[$name];
    }
    
    protected function buildRouteRegistry()
    {
        $config = $this->configData()->slice('routes');
        return $this->bundles->routeRegistry($config);
    }
    
    protected function buildLocatorRegistry()
    {
        $config = $this->configData()->slice('locators');
        return $this->bundles->locatorRegistry($config);
    }
    
    protected function buildOrmWrappers()
    {
        return null;
    }
}