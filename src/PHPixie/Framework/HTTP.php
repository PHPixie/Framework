<?php

namespace PHPixie\Framework;

class HTTP
{
    protected $builder;
    protected $configData;
    
    protected $processor;
    
    public function __construct($builder, $configData)
    {
        $this->builder    = $builder;
        $this->configData = $configData;
    }
    
    public function processor()
    {
        if($this->processor === null) {
            $this->processor = $this->buildProcessor();
        }
        
        return $this->processor;
    }
    
    public function processSapiRequest()
    {
        $http = $this->builder->components()->http();
        $serverRequest = $http->sapiServerRequest();
        
        $response = $this->processServerRequest($serverRequest);
        
        $http->output(
            $response,
            $this->builder->context()->httpContext()
        );
    }
    
    public function processServerRequest($serverRequest)
    {
        return $this->processor()->process($serverRequest);
    }
    
    protected function buildProcessor()
    {
        $processors = $this->builder->components()->processors();
        
        return $processors->catchException(
            $processors->chain(array(
                $this->requestProcessor(),
                $processors->checkIsDispatchable(
                    $this->builder->configuration()->httpDispatcher(),
                    $this->dispatchProcessor(),
                    $this->notFoundProcessor()
                )
            )),
            $this->exceptionProcessor()
        );
    }
    
    protected function requestProcessor()
    {
        $components = $this->builder->components();
        
        $processors     = $components->processors();
        $httpProcessors = $components->httpProcessors();
        
        return $processors->chain(array(
            $httpProcessors->parseBody(),
            $this->parseRouteProcessor(),
            $httpProcessors->updateContext(
                $this->builder->context()
            ),
            $httpProcessors->buildRequest()
        ));
    }
    
    protected function parseRouteProcessor()
    {
        $route               = $this->builder->components()->route();
        $frameworkProcessors = $this->builder->processors();
        
        $translator = $route->translator(
            $this->configData->slice('route'),
            $this->builder->configuration()->routeResolver(),
            $this->builder->context()
        );
        
        return $frameworkProcessors->httpParseRoute($translator);
    }
    
    protected function dispatchProcessor()
    {
        $processors          = $this->builder->components()->processors();
        $frameworkProcessors = $this->builder->processors();
        
        return $processors->chain(array(
            $processors->dispatch(
                $this->builder->configuration()->httpDispatcher()
            ),
            $frameworkProcessors->httpNormalizeResponse(),
        ));
    }
    
    protected function exceptionProcessor()
    {
        $configData = $this->configData->slice('exceptionResponse');
        
        $frameworkProcessors = $this->builder->processors();
        return $frameworkProcessors->httpExceptionResponse($configData);
    }
    
    protected function notFoundProcessor()
    {
        $configData = $this->configData->slice('notFoundResponse');
        
        $frameworkProcessors = $this->builder->processors();
        return $frameworkProcessors->httpNotFoundResponse($configData);
    }
}