<?php

namespace PHPixie\Framework\Bundles\Bundle\Processors;

class Route
{
    protected $processors;
    protected $names;
    
    public function __construct($processors, $names)
    {
        $this->processorBuilder = $processorBuilder;
        $this->names = array_fill_keys($names, true);
    }
    
    public function get($name)
    {
        if(!array_key_exists($name, $this->names)) {
            return null;
        }
        
        return $this->processors->get($name);
    }
}