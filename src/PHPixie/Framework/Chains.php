<?php

namespace PHPixie\Framework;

class Chains
{
    protected $builder;
    protected $http;
    
    public function __construct($builder)
    {
        $this->builder = $builder;
    }
    
    public function http()
    {
        if($this->http === null) {
            $this->http = $this->buildHttpChain();
        }
        
        return $this->http;
    }
    
    protected function buildHttpChain()
    {
        $frameworkProcessors = $this->frameworkProcessors();
        
        return $this->chain(array(
            $frameworkProcessors->httpDebug(
                $this->chain(array(
                    $this->buildHttpRequestProcessor(),
                    $frameworkProcessors->processors()->checkRoute(
                        $this->buildHttpDispatchProcessor(),
                        $this->buildHttpNotFoundProcessor(),
                    )
                )),
                $this->buildHttpExceptionProcessor()
            ),
            $this->httpProcessors->output()
        ));
    }
    
    protected function buildHttpRequestProcessor()
    {
        $httpProcessors = $this->httpProcessors();
        
        return $this->chain(array(
            $httpProcessors->parseBody(),
            $this->frameworkProcessors()->parseAttributes(),
            $httpProcessors->wrapRequest()
        ));
    }
    
    protected function buildHttpDispatchProcessor()
    {
        return $this->frameworkProcessors()->dispatch();
    }
    
    protected function buildHttpExceptionProcessor()
    {
        return $this->frameworkProcessors->httpException();
    }
    
    protected function buildHttpNotFoundProcessor()
    {
        return $this->frameworkProcessors->notFound();
    }
}