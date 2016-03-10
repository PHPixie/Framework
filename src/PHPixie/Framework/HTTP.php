<?php

namespace PHPixie\Framework;

use PHPixie\Processors\Processor;
use PHPixie\Slice\Data;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * HTTP processing chain
 *
 * Override its methods to hook into request processing
 */
class HTTP
{
    /**
     * @type Builder
     */
    protected $builder;

    /**
     * @var Data
     */
    protected $configData;

    /**
     * @var array
     */
    protected $instances = array();

    /**
     * Constructor
     * @param Builder $builder
     */
    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    /**
     * Get HTTP processor
     *
     * The resulting processor accepts a PSR7 ServerRequest
     * and returns a PHPixie Response
     * @return Processor
     */
    public function processor()
    {
        return $this->instance('processor');
    }

    /**
     * HTTP route translator
     * @return \PHPixie\Route\Translator
     */
    public function routeTranslator()
    {
        return $this->instance('routeTranslator');
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
     * @return \PHPixie\Route\Translator
     */
    protected function buildRouteTranslator()
    {
        $route = $this->builder->components()->route();
        $httpConfig = $this->builder->configuration()->httpConfig();
        
        return $route->translator(
            $this->builder->configuration()->httpRouteResolver(),
            $httpConfig->slice('translator'),
            $this->builder->context()
        );
    }

    /**
     * Process a PHP request from globals
     * and output the response
     * @return void
     */
    public function processSapiRequest()
    {
        $http = $this->builder->components()->http();
        $serverRequest = $http->sapiServerRequest();
        
        $response = $this->processor()->process($serverRequest);
        
        $http->output(
            $response,
            $this->builder->context()->httpContext()
        );
    }

    /**
     * Process a PSR7 ServerRequest into a PSR7 Response
     * @param ServerRequestInterface $serverRequest
     * @return ResponseInterface
     */
    public function processServerRequest($serverRequest)
    {
        $response = $this->processor()->process($serverRequest);
        
        return $response->asResponseMessage(
            $this->builder->context()->httpContext()
        );
    }

    /**
     * Builds the HTTP request processor
     * @return Processor
     */
    protected function buildProcessor()
    {
        $processors = $this->builder->components()->processors();
        
        return $processors->catchException(
            $processors->chain(array(
                $this->requestProcessor(),
                $this->contextProcessor(),
                $processors->checkIsProcessable(
                    $this->builder->configuration()->httpProcessor(),
                    $this->dispatchProcessor(),
                    $this->notFoundProcessor()
                )
            )),
            $this->exceptionProcessor()
        );
    }

    /**
     * Builds the processor that takes care
     * of generating the PHPixie HTTP Request
     * @return Processor
     */
    protected function requestProcessor()
    {
        $components = $this->builder->components();
        
        $processors     = $components->processors();
        $httpProcessors = $components->httpProcessors();
        
        return $processors->chain(array(
            $httpProcessors->parseBody(),
            $this->parseRouteProcessor(),
            $httpProcessors->buildRequest()
        ));
    }

    /**
     * Builds the processor that takes care
     * of setting contexts (e.g. HTTP and Auth context)
     * @return Processor
     */
    protected function contextProcessor()
    {
        $components = $this->builder->components();
        
        $processors     = $components->processors();
        $httpProcessors = $components->httpProcessors();
        $authProcessors = $components->authProcessors();
        
        $context = $this->builder->context();
        
        return $processors->chain(array(
            $httpProcessors->updateContext($context),
            $authProcessors->updateContext($context),
        ));
    }

    /**
     * Builds the processor that takes care
     * of parsing the Request and populating route data
     * @return Processor
     */
    protected function parseRouteProcessor()
    {
        $frameworkProcessors = $this->builder->processors();
        
        $translator = $this->routeTranslator();
        return $frameworkProcessors->httpParseRoute($translator);
    }

    /**
     * Builds the processor that takes care
     * of dispatching the request.
     *
     * If you want to process the request before
     * it reaches your code, you can do that
     * by overriding this method and adding your own
     * processor to the chain.
     * @return Processor
     */
    protected function dispatchProcessor()
    {
        $processors          = $this->builder->components()->processors();
        $frameworkProcessors = $this->builder->processors();
        
        return $processors->chain(array(
            $this->builder->configuration()->httpProcessor(),
            $frameworkProcessors->httpNormalizeResponse(),
        ));
    }

    /**
     * Builds the processor that handles uncaught exception
     * @return Processor
     */
    protected function exceptionProcessor()
    {
        $frameworkProcessors = $this->builder->processors();
        $httpConfig = $this->builder->configuration()->httpConfig();
        
        return $frameworkProcessors->httpExceptionResponse(
            $httpConfig->slice('exceptionResponse')
        );
    }

    /**
     * Builds the processor that handles non-existing urls
     * @return Processor
     */
    protected function notFoundProcessor()
    {
        $frameworkProcessors = $this->builder->processors();
        $httpConfig = $this->builder->configuration()->httpConfig();
        
        return $frameworkProcessors->httpNotFoundResponse(
            $httpConfig->slice('notFoundResponse')
        );
    }
    
    /**
     * Generate a path from route path and attributes
     * @param string $resolverPath
     * @param array $attributes
     * @return string
     */
    public function generatePath($resolverPath = null, $attributes = array())
    {
        return $this->routeTranslator()->generatePath(
            $resolverPath,
            $attributes
        );
    }
    
    /**
     * Generate a PSR-7 URI from route path and attributes
     * @param string $resolverPath
     * @param array $attributes
     * @param boolean $withHost Whether to include host in the URI
     * @return \PHPixie\HTTP\Messages\URI\Implementation
     */
    public function generateUri(
        $resolverPath  = null,
        $attributes    = array(),
        $withHost      = false
    )
    {
        return $this->routeTranslator()->generateUri(
            $resolverPath,
            $attributes,
            $withHost
        );
    }
    
    /**
     * Generate a redirect response from route path and attributes
     * @param string $resolverPath
     * @param array $attributes
     * @return \PHPixie\HTTP\Responses\Response
     */
    public function redirect($resolverPath = null, $attributes = array())
    {
        $path = $this->generatePath(
            $resolverPath,
            $attributes
        );
        
        $http = $this->builder->components()->http();
        return $http->responses()->redirect($path);
    }
}
