<?php

namespace PHPixie\Framework;

class Components
{
    /**
     * @type Builder
     */
    protected $builder;
    protected $instances = array();

    /**
     * @param Builder $builder
     */
    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    /**
     * @return \PHPixie\Slice
     */
    public function slice()
    {
        return $this->instance('slice');
    }

    /**
     * @return \PHPixie\Config
     */
    public function config()
    {
        return $this->instance('config');
    }

    /**
     * @return \PHPixie\Debug
     */
    public function debug()
    {
        return $this->instance('debug');
    }

    /**
     * @return \PHPixie\Database
     */
    public function database()
    {
        return $this->instance('database');
    }

    /**
     * @return \PHPixie\Filesystem
     */
    public function filesystem()
    {
        return $this->instance('filesystem');
    }

    /**
     * @return \PHPixie\HTTP
     */
    public function http()
    {
        return $this->instance('http');
    }

    /**
     * @return \PHPixie\HTTPProcessors
     */
    public function httpProcessors()
    {
        return $this->instance('httpProcessors');
    }

    /**
     * @return \PHPixie\ORM
     */
    public function orm()
    {
        return $this->instance('orm');
    }

    /**
     * @return \PHPixie\Processors
     */
    public function processors()
    {
        return $this->instance('processors');
    }

    /**
     * @return \PHPixie\Template
     */
    public function template()
    {
        return $this->instance('template');
    }

    /**
     * @return \PHPixie\Route
     */
    public function route()
    {
        return $this->instance('route');
    }

    /**
     * @return \PHPixie\Security
     */
    public function security()
    {
        return $this->instance('security');
    }

    /**
     * @return \PHPixie\Auth
     */
    public function auth()
    {
        return $this->instance('auth');
    }

    /**
     * @return \PHPixie\AuthProcessors
     */
    public function authProcessors()
    {
        return $this->instance('authProcessors');
    }

    /**
     * @return \PHPixie\Paginate
     */
    public function paginate()
    {
        return $this->instance('paginate');
    }

    /**
     * @return \PHPixie\PaginateORM
     */
    public function paginateOrm()
    {
        return $this->instance('paginateOrm');
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
        $extensions    = $this->builder->extensions();
        
        return new \PHPixie\Template(
            $this->slice(),
            $configuration->templateLocator(),
            $configuration->templateConfig(),
            $configuration->filesystemRoot(),
            $extensions->templateExtensions(),
            $extensions->templateFormats()
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
    
    protected function buildAuthProcessors()
    {
        return new \PHPixie\AuthProcessors(
            $this->auth()
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
    
    protected function buildSecurity()
    {
        return new \PHPixie\Security(
            $this->database()
        );
    }
    
    protected function buildAuth()
    {
        $configuration = $this->configuration();
        
        return new \PHPixie\Auth(
            $configuration->authConfig(),
            $configuration->authRepositories(),
            $this->builder->extensions()->authProviderBuilders(),
            $this->builder->context()
        );
    }
    
    protected function buildPaginate()
    {
        return new \PHPixie\Paginate();
    }
    
    protected function buildPaginateOrm()
    {
        return new \PHPixie\PaginateORM(
            $this->paginate()
        );
    }
    
    protected function configuration()
    {
        return $this->builder->configuration();
    }
    
}