<?php

namespace PHPixie\Framework;

class Components
{
    protected $builder;
    
    protected $instances = array();
    
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
    
    public function orm()
    {
        return $this->instance('orm');
    }
    
    public function filesystem()
    {
        return $this->instance('filesystem');
    }
    
    public function template()
    {
        return $this->instance('template');
    }
    
    public function http()
    {
        return $this->instance('http');
    }
    
    public function router()
    {
        return $this->instance('router');
    }

    protected function instance($name)
    {
        if(!array_key_exists($name, $this->instances)) {
            $method = 'build'.ucfirst($name);
            $this->instances[$name] = $this->$method();
        }
        
        return $this->instances[$name];
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
            $this->environment()->config('database')
        );
    }
    
    protected function buildOrm()
    {
        $environment = $this->builder->environment();
        
        return new \PHPixie\ORM(
            $this->database()
            $environment->config('orm'),
            $environment->ormWrappers()
        );
    }
    
    protected function buildFilesystem()
    {
        return new \PHPixie\Filesystem(
            $this->builder->environment()->rootDir()
        );
    }
    
    protected function buildTemplate()
    {
        return new \PHPixie\Template(
            $this->slice(),
            $this->filesystem(),
            $this->builder->environment()->config('template')
        );
    }
    
    protected function buildHttp()
    {
        return new \PHPixie\HTTP(
            $this->slice()
        );
    }
    
    protected function buildRouter()
    {
        $environment = $this->builder->environment();
        
        return new \PHPixie\Router(
            $environment->config('router'),
            $environment->context(),
            $environment->routeRegistry()
        );
    }
    
    
}