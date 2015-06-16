<?php

namespace PHPixie\Framework;

abstract class Bundles
{
    protected $builder;
    protected $instances = array();
    
    public function __construct($builder)
    {
        $this->builder = $builder;
    }
    
    public function get($name)
    {
        if(!array_key_exists($name, $this->instances)) {
            $this->instances[$name] = $this->$method();
        }
        
        return $this->instances[$name];
    }
    
    public function map(){}
}