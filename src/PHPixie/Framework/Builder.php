<?php

namespace PHPixie\Framework;

abstract class Builder
{
    protected $instances = array();
    
    public function assets()
    {
        return $this->instance('assets');
    }
    
    public function components()
    {
        return $this->instance('components');
    }
    
    public function context()
    {
        return $this->instance('context');
    }
    
    public function extensions()
    {
        return $this->instance('extensions');
    }
    
    public function http()
    {
        return $this->instance('http');
    }
    
    public function processors()
    {
        return $this->instance('processors');
    }
    
    protected function instance($name)
    {
        if(!array_key_exists($name, $this->instances)) {
            $method = 'build'.ucfirst($name);
            $this->instances[$name] = $this->$method();
        }
        
        return $this->instances[$name];
    }
    
    protected function buildAssets()
    {
        return new Assets(
            $this->components()
        );
    }
    
    protected function buildComponents()
    {
        return new Components($this);
    }
    
    protected function buildContext()
    {
        return new Context($this);
    }
    
    protected function buildExtensions()
    {
        return new Extensions($this);
    }
    
    protected function buildHttp()
    {
        return new HTTP($this);
    }
    
    protected function buildProcessors()
    {
        return new Processors($this);
    }
    
    abstract public function configuration();
}