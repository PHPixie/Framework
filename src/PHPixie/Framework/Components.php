<?php

namespace PHPixie\Framework;

/**
 * PHPixie components registry
 */
class Components
{
    /**
     * @type Builder
     */
    protected $builder;

    /**
     * @var array
     */
    protected $instances = array();

    /**
     * @param Builder $builder
     */
    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    /**
     * Slice
     * @return \PHPixie\Slice
     */
    public function slice()
    {
        return $this->instance('slice');
    }

    /**
     * Config
     * @return \PHPixie\Config
     */
    public function config()
    {
        return $this->instance('config');
    }

    /**
     * Debug
     * @return \PHPixie\Debug
     */
    public function debug()
    {
        return $this->instance('debug');
    }

    /**
     * Database
     * @return \PHPixie\Database
     */
    public function database()
    {
        return $this->instance('database');
    }

    /**
     * Filesystem
     * @return \PHPixie\Filesystem
     */
    public function filesystem()
    {
        return $this->instance('filesystem');
    }

    /**
     * HTTP
     * @return \PHPixie\HTTP
     */
    public function http()
    {
        return $this->instance('http');
    }

    /**
     * HTTP processors
     * @return \PHPixie\HTTPProcessors
     */
    public function httpProcessors()
    {
        return $this->instance('httpProcessors');
    }

    /**
     * ORM
     * @return \PHPixie\ORM
     */
    public function orm()
    {
        return $this->instance('orm');
    }

    /**
     * Processors
     * @return \PHPixie\Processors
     */
    public function processors()
    {
        return $this->instance('processors');
    }

    /**
     * Template
     * @return \PHPixie\Template
     */
    public function template()
    {
        return $this->instance('template');
    }

    /**
     * Route
     * @return \PHPixie\Route
     */
    public function route()
    {
        return $this->instance('route');
    }

    /**
     * Security
     * @return \PHPixie\Security
     */
    public function security()
    {
        return $this->instance('security');
    }

    /**
     * Auth
     * @return \PHPixie\Auth
     */
    public function auth()
    {
        return $this->instance('auth');
    }

    /**
     * Auth processors
     * @return \PHPixie\AuthProcessors
     */
    public function authProcessors()
    {
        return $this->instance('authProcessors');
    }

    /**
     * Paginate
     * @return \PHPixie\Paginate
     */
    public function paginate()
    {
        return $this->instance('paginate');
    }

    /**
     * ORM plugin for Paginate
     * @return \PHPixie\PaginateORM
     */
    public function paginateOrm()
    {
        return $this->instance('paginateOrm');
    }

    /**
     * Validate
     * @return \PHPixie\Validate
     */
    public function validate()
    {
        return $this->instance('validate');
    }

    /**
     * Validate
     * @return \PHPixie\Image
     */
    public function image()
    {
        return $this->instance('image');
    }

    /**
     * Validate
     * @return \PHPixie\Social
     */
    public function social()
    {
        return $this->instance('social');
    }
    
    /**
     * CLI
     * @return \PHPixie\CLI
     */
    public function cli()
    {
        return $this->instance('cli');
    }
    
    /**
     * Console
     * @return \PHPixie\Console
     */
    public function console()
    {
        return $this->instance('console');
    }

    /**
     * Migrate
     * @return \PHPixie\Migrate
     */
    public function migrate()
    {
        return $this->instance('migrate');
    }

    /**
     * Migrate
     * @return \PHPixie\Cache
     */
    public function cache()
    {
        return $this->instance('cache');
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
     * @return \PHPixie\Slice
     */
    protected function buildSlice()
    {
        return new \PHPixie\Slice();
    }

    /**
     * @return \PHPixie\Config
     */
    protected function buildConfig()
    {
        return new \PHPixie\Config(
            $this->slice()
        );
    }

    /**
     * @return \PHPixie\Debug
     */
    protected function buildDebug()
    {
        return new \PHPixie\Debug();
    }

    /**
     * @return \PHPixie\Database
     */
    protected function buildDatabase()
    {
        return new \PHPixie\Database(
            $this->configuration()->databaseConfig(),
            $this->builder->logger()
        );
    }

    /**
     * @return \PHPixie\ORM
     */
    protected function buildOrm()
    {
        $configuration = $this->builder->configuration();

        return new \PHPixie\ORM(
            $this->database(),
            $configuration->ormConfig(),
            $configuration->ormWrappers()
        );
    }

    /**
     * @return \PHPixie\Filesystem
     */
    protected function buildFilesystem()
    {
        return new \PHPixie\Filesystem();
    }

    /**
     * @return \PHPixie\Template
     */
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

    /**
     * @return \PHPixie\HTTP
     */
    protected function buildHttp()
    {
        return new \PHPixie\HTTP(
            $this->slice()
        );
    }

    /**
     * @return \PHPixie\HTTPProcessors
     */
    protected function buildHttpProcessors()
    {
        return new \PHPixie\HTTPProcessors(
            $this->http()
        );
    }

    /**
     * @return \PHPixie\AuthProcessors
     */
    protected function buildAuthProcessors()
    {
        return new \PHPixie\AuthProcessors(
            $this->auth()
        );
    }

    /**
     * @return \PHPixie\Processors
     */
    protected function buildProcessors()
    {
        return new \PHPixie\Processors();
    }

    /**
     * @return \PHPixie\Route
     */
    protected function buildRoute()
    {
        return new \PHPixie\Route();
    }

    /**
     * @return \PHPixie\Security
     */
    protected function buildSecurity()
    {
        return new \PHPixie\Security(
            $this->database()
        );
    }

    /**
     * @return \PHPixie\Auth
     */
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

    /**
     * @return \PHPixie\Paginate
     */
    protected function buildPaginate()
    {
        return new \PHPixie\Paginate();
    }

    /**
     * @return \PHPixie\PaginateORM
     */
    protected function buildPaginateOrm()
    {
        return new \PHPixie\PaginateORM(
            $this->paginate()
        );
    }

    /**
     * @return \PHPixie\Validate
     */
    protected function buildValidate()
    {
        return new \PHPixie\Validate();
    }

    /**
     * @return \PHPixie\Image
     */
    protected function buildImage()
    {
        return new \PHPixie\Image(
            $this->configuration()->imageDefaultDriver()
        );
    }

    /**
     * @return \PHPixie\Social
     */
    protected function buildSocial()
    {
        return new \PHPixie\Social(
            $this->configuration()->socialConfig()
        );
    }
    
    /**
     * @return \PHPixie\CLI
     */
    protected function buildCli()
    {
        return new \PHPixie\CLI();
    }
    
    /**
     * @return \PHPixie\Console
     */
    protected function buildConsole()
    {
        return new \PHPixie\Console(
            $this->slice(),
            $this->cli(),
            $this->configuration()->consoleProvider()
        );
    }
    
    /**
     * @return \PHPixie\Migrate
     */
    protected function buildMigrate()
    {
        $configuration = $this->configuration();
        
        return new \PHPixie\Migrate(
            $this->database(),
            $configuration->migrateRoot(),
            $configuration->migrateConfig()
        );
    }

    /**
     * @return \PHPixie\Cache
     */
    protected function buildCache()
    {
        $configuration = $this->configuration();

        return new \PHPixie\Cache(
            $configuration->cacheConfig(),
            $configuration->cacheRoot()
        );
    }

    /**
     * @return Configuration
     */
    protected function configuration()
    {
        return $this->builder->configuration();
    }

}
