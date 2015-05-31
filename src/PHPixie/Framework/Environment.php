<?php

class Environment
{
    protected $rootPath;
    protected $configData;
    
    public function __construct($builder, $rootPath)
    {
        $this->builder  = $builder;
        $this->rootPath = $rootPath;
    }
    
    public function rootPath()
    {
        return $this->rootPath;
    }
    
    public function configData()
    {
        $this->instance('configData');
    }
    
    public function routeRegistry()
    {
    
    }
    
    public function locatorRegistry()
    {
    
    }
    
    public function ormWrappers()
    {
    
    }
    
    public function configSlice($path)
    {
        $this->configData()->slice($path);
    }
    
    protected function instance($name)
    {
        if(!array_key_exists($name, $this->instances)) {
            $method = 'build'.ucfirst($name);
            $this->instances[$name] = $this->$method();
        }
        
        return $this->instances[$name];
    }
    
    protected function buildConfigData()
    {
        $this->builder->components()->config()->directory($this->rootPath);
    }
}