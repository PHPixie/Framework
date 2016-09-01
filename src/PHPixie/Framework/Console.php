<?php

namespace PHPixie\Framework;

use PHPixie\Processors\Processor;
use PHPixie\Slice\Data;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Console
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

    public function processSapiCommand()
    {
        $components = $this->builder->components();
        
        $context = $this->builder->context();
        $cliContext = $components->cli()->buildSapiContext();
        $context->setCliContext($cliContext);
        
        $console = $components->console();
        $console->runCommand();
        return $cliContext->exitCode();
    }
}
