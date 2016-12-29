<?php

namespace PHPixie\Framework;

use PHPixie\Auth\Repositories;
use PHPixie\Filesystem\Root;
use PHPixie\ORM\Wrappers;
use PHPixie\Route\Resolvers\Resolver;
use PHPixie\Slice\Data;

/**
 * Framework configuration
 */
interface Configuration
{
    /**
     * Database configuration
     * @return Data
     */
    public function databaseConfig();

    /**
     * Template configuration
     * @return Data
     */
    public function templateConfig();

    /**
     * HTTP configuration
     * @return Data
     */
    public function httpConfig();

    /**
     * Processor for HTTP requests
     * @return HTTP
     */
    public function httpProcessor();

    /**
     * Route resolver
     * @return Resolver
     */
    public function httpRouteResolver();

    /**
     * ORM configuration
     * @return Data
     */
    public function ormConfig();

    /**
     * ORM wrappers
     * @return Wrappers
     */
    public function ormWrappers();

    /**
     * Project root
     * @return Root
     */
    public function filesystemRoot();

    /**
     * Template locator
     * @return Locator
     */
    public function templateLocator();

    /**
     * Auth configuration
     * @return Data
     */
    public function authConfig();

    /**
     * User repositories for Auth component
     * @return Repositories
     */
    public function authRepositories();

    /**
     * Name of the default driver to use with Image component
     * @return string
     */
    public function imageDefaultDriver();

    /**
     * Social configuration
     * @return Data
     */
    public function socialConfig();
    
    /**
     * Console command provider
     * @return \PHPixie\Console\Registry\Provider
     */
    public function consoleProvider();
    
    /**
     * Migrations configuration
     * @return Data
     */
    public function migrateConfig();
    
    /**
     * Migrations root
     * @return Root
     */
    public function migrateRoot();

    /**
     * Cache configuration
     * @return Data
     */
    public function cacheConfig();

    /**
     * Cache root
     * @return Root
     */
    public function cacheRoot();
}
