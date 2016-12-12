<?php

namespace PHPixie\Framework;

/**
 * Base framework factory
 */
abstract class Builder
{
    /**
     * @var array
     */
    protected $instances = array();

    /**
     * Assets registry
     * @return Assets
     */
    public function assets()
    {
        return $this->instance('assets');
    }

    /**
     * Components factory
     * @return Components
     */
    public function components()
    {
        return $this->instance('components');
    }

    /**
     * Context container (e.g. for HTTP context)
     * @return Context
     */
    public function context()
    {
        return $this->instance('context');
    }

    /**
     * Extensions registry
     * @return Extensions
     */
    public function extensions()
    {
        return $this->instance('extensions');
    }

    /**
     * HTTP handler
     * @return HTTP
     */
    public function http()
    {
        return $this->instance('http');
    }
    
    /**
     * Console handler
     * @return Console
     */
    public function console()
    {
        return $this->instance('console');
    }

    /**
     * Processors factory
     * @return Processors
     */
    public function processors()
    {
        return $this->instance('processors');
    }
    
    /**
     * Logger
     * @return \Psr\Log\Logger|null
     */
    public function logger()
    {
        return $this->instance('logger');
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function instance($name)
    {
        if(!array_key_exists($name, $this->instances)) {
            $method = 'build'.ucfirst($name);
            $this->instances[$name] = $this->$method();
        }
        
        return $this->instances[$name];
    }

    /**
     * @return Assets
     */
    protected function buildAssets()
    {
        return new Assets(
            $this->components()
        );
    }

    /**
     * @return Components
     */
    protected function buildComponents()
    {
        return new Components($this);
    }

    /**
     * @return Context
     */
    protected function buildContext()
    {
        return new Context($this);
    }

    /**
     * @return Extensions
     */
    protected function buildExtensions()
    {
        return new Extensions($this);
    }

    /**
     * @return HTTP
     */
    protected function buildHttp()
    {
        return new HTTP($this);
    }
    
    /**
     * @return Console
     */
    protected function buildConsole()
    {
        return new Console($this);
    }

    /**
     * @return Processors
     */
    protected function buildProcessors()
    {
        return new Processors($this);
    }
    
    /**
     * @return \Psr\Log\Logger|null
     */
    protected function buildLogger()
    {
        return null;
    }

    /**
     * Framework Configuration
     * @return Configuration
     */
    abstract public function configuration();
}