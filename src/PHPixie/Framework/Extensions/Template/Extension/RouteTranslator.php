<?php

namespace PHPixie\Framework\Extensions\Template\Extension;

class RouteTranslator implements \PHPixie\Template\Extensions\Extension
{
    
    protected $name;

    /**
     * @type \PHPixie\Route\Translator
     */
    protected $routeTranslator;
    
    public function __construct($name, $routeTranslator)
    {
        $this->name            = $name;
        $this->routeTranslator = $routeTranslator;
    }
    
    public function name()
    {
        return $this->name;
    }
    
    public function methods()
    {
        return array(
            $this->name.'Path' => 'path',
            $this->name.'Uri'  => 'uri'
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