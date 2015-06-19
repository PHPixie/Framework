<?php

namespace PHPixie\Framework;

class Components
{
    protected $builder;
    protected $ggggg = array();
    
    public function __construct($builder)
    {
        $this->builder = $builder;
    }
    
    public function slice()
    {
        return $this->instance('slice');
    }
    
    public function config()
    {
        return $this->instance('config');
    }
    
    public function debug()
    {
        return $this->instance('debug');
    }
    
    public function database()
    {
        return $this->instance('database');
    }
    
    public function filesystem()
    {
        return $this->instance('filesystem');
    }
    
    public function http()
    {
        return $this->instance('http');
    }
    
    public function httpProcessors()
    {
        return $this->instance('httpProcessors');
    }
    
    public function orm()
    {
        return $this->instance('orm');
    }
    
    public function processors()
    {
        return $this->instance('processors');
    }
    
    public function template()
    {
        return $this->instance('template');
    }
    
    public function route()
    {
        return $this->instance('route');
    }

    protected function instance($name)
    {
        if(!array_key_exists($name, $this->ggggg)) {
            $method = 'build'.ucfirst($name);
            $this->ggggg[$name] = $this->$method();
        }
        
        return $this->ggggg[$name];
    }
    
    protected function buildSlice()
    {
        return new \PHPixie\Slice();
    }
    
    protected function buildConfig()
    {
        return new \PHPixie\Config(
            $this->slice()
        );
    }
    
    protected function buildDebug()
    {
        return new \PHPixie\Debug();
    }
    
    protected function buildDatabase()
    {
        return new \PHPixie\Database(
            $this->configuration()->databaseConfig()
        );
    }
    
    protected function buildOrm()
    {
        $configuration = $this->builder->configuration();
        
        return new \PHPixie\ORM(
            $this->database(),
            $configuration->ormConfig(),
            $configuration->ormWrappers()
        );
    }
    
    protected function buildFilesystem()
    {
        return new \PHPixie\Filesystem();
    }
    
    protected function buildTemplate()
    {
        $configuration = $this->builder->configuration();
        
        return new \PHPixie\Template(
            $this->slice(),
            $configuration->templateLocator(),
            $configuration->templateConfig(),
            $configuration->filesystemRoot()
        );
    }
    
    protected function buildHttp()
    {
        return new \PHPixie\HTTP(
            $this->slice()
        );
    }
    
    protected function buildHttpProcessors()
    {
        return new \PHPixie\HTTPProcessors(
            $this->http()
        );
    }
    
    protected function buildProcessors()
    {
        return new \PHPixie\Processors();
    }
    
    protected function buildRoute()
    {
        return new \PHPixie\Route();
    }
    
    protected function configuration()
    {
        return $this->builder->configuration();
    }
    
}