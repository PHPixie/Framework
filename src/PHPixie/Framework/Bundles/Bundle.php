<?php

namespace PHPixie\Framework\Bundles;

abstract class Bundle
{
    protected $instances = array();
    
    public function get($name)
    {
        if(!array_key_exists($name, $this->instances)) {
            $this->instances[$name] = $this->$method();
        }
        
        return $this->instances[$name];
    }
}