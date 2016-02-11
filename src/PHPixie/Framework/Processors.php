<?php

namespace PHPixie\Framework;

use PHPixie\Route\Translator;
use PHPixie\Slice\Data;

/**
 * Processors factory
 */
class Processors
{
    /**
     * @type Builder
     */
    protected $builder;

    /**
     * Constructor
     * @param Builder $builder
     */
    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    /**
     * Processor that parses the url route
     * @param Translator $routeTranslator
     * @return Processors\HTTP\ParseRoute
     */
    public function httpParseRoute($routeTranslator)
    {
        return new Processors\HTTP\ParseRoute(
            $routeTranslator
        );
    }

    /**
     * Processor that renders the exception response
     * @param Data $configData
     * @return Processors\HTTP\Response\Exception
     */
    public function httpExceptionResponse($configData)
    {
        $components = $this->builder->components();
        
        return new Processors\HTTP\Response\Exception(
            $components->debug(),
            $components->http(),
            $components->template(),
            $configData
        );
    }

    /**
     * Processor for the "not found" page
     * @param Data $configData
     * @return Processors\HTTP\Response\NotFound
     */
    public function httpNotFoundResponse($configData)
    {
        $components = $this->builder->components();
        
        return new Processors\HTTP\Response\NotFound(
            $components->http(),
            $components->template(),
            $configData
        );
    }

    /**
     * Processor that turns return values into HTTP Responses.
     *
     * E.g. objects are turned into JSON responses
     * and template containers are rendered automatically
     * @return Processors\HTTP\Response\Normalize
     */
    public function httpNormalizeResponse()
    {
        $components = $this->builder->components();
        
        return new Processors\HTTP\Response\Normalize(
            $components->http()
        );
    }
}