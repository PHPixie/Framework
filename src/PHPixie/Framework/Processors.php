<?php

namespace PHPixie\Framework;

class Processors
{
    /**
     * @type Builder
     */
    protected $builder;
    
    public function __construct($builder)
    {
        $this->builder = $builder;
    }
    
    public function httpParseRoute($routeTranslator)
    {
        return new Processors\HTTP\ParseRoute(
            $routeTranslator
        );
    }
    
    public function httpExceptionResponse($configData)
    {
        $components = $this->builder->components();
        
        return new Processors\HTTP\Response\Exception(
            $components->debug(),
            $components->http(),
            $components->template(),
            $configData
        );
    }
    
    public function httpNotFoundResponse($configData)
    {
        $components = $this->builder->components();
        
        return new Processors\HTTP\Response\NotFound(
            $components->http(),
            $components->template(),
            $configData
        );
    }
    
    public function httpNormalizeResponse()
    {
        $components = $this->builder->components();
        
        return new Processors\HTTP\Response\Normalize(
            $components->http()
        );
    }
}