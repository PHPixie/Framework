<?php

namespace PHPixie\Framework\HTTP\Processor;

class CheckRoute
{
    protected $dispatcher;
    protected $foundProcessor;
    protected $notFoundProcessor;
    
    public function __construct($dispatcher, $foundProcessor, $notFoundProcessor)
    {
        $this->dispatcher        = $dispatcher;
        $this->foundProcessor    = $foundProcessor;
        $this->notFoundProcessor = $notFoundProcessor;
    }
    
    public function process($request)
    {
        if(!$this->dispatcher->hasProcessorForRequest($request)) {
            $processor = $this->notFoundProcessor;
        }else{
            $processor = $this->foundProcessor;
        }
        
        return $processor->process($request);
    }
}