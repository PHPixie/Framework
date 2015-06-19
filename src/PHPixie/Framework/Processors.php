<?php

namespace PHPixie\Framework;

class Processors
{
    protected $builder;
    
    public function __construct($builder)
    {
        $this->builder = $builder;
    }
    
    public function exceptionResponse($configData)
    {
        $components = $this->builder->components();
        
        return new Processors\HTTP\Response\Exception(
            $components->debug(),
            $components->http(),
            $components->template(),
            $configData
        );
    }
    
    public function notFoundResponse($configData)
    {
        $components = $this->builder->components();
        
        return new Processors\HTTP\Response\NotFound(
            $components->http(),
            $components->template(),
            $configData
        );
    }
    
    public function normalizeResponse()
    {
        $components = $this->builder->components();
        
        return new Processors\HTTP\Response\Normalize(
            $components->http()
        );
    }
}