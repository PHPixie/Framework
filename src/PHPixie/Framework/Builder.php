<?php

namespace PHPixie\Framework;

abstract class Builder
{
    protected $rootDir;
    
    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
    }
    
    public function bundles()
    {
        $this->instance('bundles');
    }
    
    public function components()
    {
        $this->instance('components');
    }
    
    public function processors(){}
    public function context(){}
    public function http(){}
    
    public function configuration()
    {
        $this->instance('environment');
    }
    
    protected function instance($name)
    {
        if(!array_key_exists($name, $this->instances)) {
            $method = 'build'.ucfirst($name);
            $this->instances[$name] = $this->$method();
        }
        
        return $this->instances[$name];
    }
    
    protected function buildComponents()
    {
        return new Components($this);
    }
    
    protected function buildEnvironment()
    {
        return new Environment($this, $this->rootDir);
    }
    
    abstract public function buildBundles();
}