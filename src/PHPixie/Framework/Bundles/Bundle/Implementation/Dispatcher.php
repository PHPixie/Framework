<?php

namespace PHPixie\Framework\Bundles\Bundle\Implementation;

class Dispatcher
{
    protected $builder;
    protected $components;
    
    protected $names = array();
    
    public function __construct($builder)
    {
        $this->builder = $builder;
    }
    
    public function hasProcessorForRequest($request)
    {
        return $this->getProcessorName($request) !== null;
    }
    
    public function getProcessorForRequest($request)
    {
        $name = $this->getProcessorName($request);
        if($name === null) {
            throw new \PHPixie\Framework\Exception("No processor found for the request");
        }
    }
    
    protected function getProcessorName($request)
    {
        $name = $request->parameters->get('processor');
        if(!array_key_exists($name, $this->names, true)) {
            return null;
        }
        
        return $name;
    }
}