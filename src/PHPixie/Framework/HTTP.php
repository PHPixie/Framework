<?php

namespace PHPixie\Framework;

class HTTP
{
    protected $builder;
    protected $configData;
    
    public function __construct($builder, $configData)
    {
        $this->builder    = $builder;
        $this->configData = $configData;
    }
    
    public function checkRoute()
    {
        new Processors\CheckRoute(
            $this->builder->dispatcher()
        );
    }
    
    public function dispatch()
    {
        new Processors\Dispatch(
            $this->builder->dispatcher()
        );
    }
    
    public function httpException()
    {
        $components   = $this->builder->components();
        
        new Processors\HTTPException(
            $components->debug(),
            $components->http(),
            $components->template(),
            $this->configData->slice('httpException')
        );
    }
    
    public function httpNotFound()
    {
        $components   = $this->builder->components();
        
        new Processors\HTTPNotFound(
            $components->http(),
            $components->template(),
            $this->configData->slice('httpNotFound')
        );
    }
}