<?php

namespace PHPixie\Framework\Processors\Processor;

class CheckRoute
{
    protected $dispatcher;
    
    public function __construct($dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
    
    public function process($request)
    {
        if(!$this->dispatcher->hasProcessorForRequest($request)) {
            $processor = $this->notFoundProcessor
        }else{
            $processor = $this->foundProcessor;
        }
        
        return $processor->process($request);
    }
}