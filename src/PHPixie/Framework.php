<?php

namespace PHPixie;

/**
 * PHPixie Framework Base.
 *
 * Extend it to build your own framework on top of PHPixie.
 */
abstract class Framework
{
    /**
     * @var Framework\Builder
     */
    protected $builder;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->builder = $this->buildBuilder();
    }

    /**
     * The main framework factory
     * @return Framework\Builder
     */
    public function builder()
    {
        return $this->builder;
    }

    /**
     * Process HTTP request built from PHP globals
     * and output the response
     * @return void
     */
    public function processHttpSapiRequest()
    {
        $this->builder->http()->processSapiRequest();
    }

    /**
     * Process a PSR7 ServerRequest and get a PSR7 Response
     * @param \Psr\Http\Message\ServerRequestInterface
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function processHttpServerRequest($serverRequest)
    {
        return $this->builder->http()->processServerRequest($serverRequest);
    }

    /**
     * Register error and exception handlers
     * @param bool $shutdownLog Whether to output log contents at shutdown
     * @param bool $exception Whether to catch and dump exceptions
     * @param bool $error Whether to convert errors to exceptions
     * @return void
     */
    public function registerDebugHandlers($shutdownLog = false, $exception = true, $error = true)
    {
        $debug = $this->builder->components()->debug();
        $debug->registerHandlers($shutdownLog, $exception, $error);
    }

    /**
     * @return Framework\Builder
     */
    abstract protected function buildBuilder();
}