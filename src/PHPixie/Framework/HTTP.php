<?php

namespace PHPixie\Framework;

class HTTP
{
    protected $builder;
    protected $processor;
    
    public function __construct($builder)
    {
        $this->builder = $builder;
    }
    
    public function processor()
    {
        if($this->processor === null) {
            $this->processor = $this->buildProcessor();
        }
        
        return $this->processor;
    }
    
    protected function buildProcessor()
    {
        $components = $this->builder->components();
        $processors = $components->processors();
        
        return $processors->chain(array(
            $processors->catchException(
                $this->chain(array(
                    $this->buildRequestProcessor(),
                    $processors->checkIsDispatchable(
                        $this->builder->configuration()->dispatcher(),
                        $this->buildDispatchProcessor(),
                        $this->buildNotFoundProcessor(),
                    )
                )),
                $this->buildExceptionProcessor()
            ),
            $this->httpProcessors->output()
        ));
    }
    
    protected function buildRequestProcessor()
    {
        $httpProcessors = $this->httpProcessors();
        
        return $this->chain(array(
            $httpProcessors->parseBody(),
            $this->frameworkProcessors()->parseAttributes(),
            $this->frameworkProcessors()->setContext(),
            $httpProcessors->wrapRequest()
        ));
    }
    
    protected function buildDispatchProcessor()
    {
        return $this->frameworkProcessors()->dispatch(
            $this->builder->configuration()->dispatcher(),
            $this->frameworkProcessors()->dispatcher(),
        );
    }
    
    protected function buildExceptionProcessor()
    {
        return $this->frameworkProcessors->httpException();
    }
    
    protected function buildNotFoundProcessor()
    {
        return $this->frameworkProcessors->notFound();
    }
}