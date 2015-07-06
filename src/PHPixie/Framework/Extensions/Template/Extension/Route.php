<?php

namespace PHPixie\Framework\Extensions\Template\Extension;

class Route implements \PHPixie\Template\Extensions\Extension
{
    protected $routeTranslator;
    
    public function __construct($routeTranslator)
    {
        $this->routeTranslator = $routeTranslator;
    }
    
    public function name()
    {
        return 'route';
    }
    
    public function methods()
    {
        return array(
            'routePath' => 'path',
            'routeUri'  => 'uri'
        );
    }
    
    public function aliases()
    {
        return array();
    }
    
    public function path($resolverPath, $attributes = array())
    {
        return $this->routeTranslator->generatePath(
            $resolverPath,
            $attributes
        );
    }
    
    public function uri(
        $resolverPath,
        $attributes    = array(),
        $withHost      = true
    )
    {
        return $this->routeTranslator->generateUri(
            $resolverPath,
            $attributes,
            $withHost
        );
    }
}