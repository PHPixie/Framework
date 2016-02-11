<?php

namespace PHPixie\Framework\Processors\HTTP;

use PHPixie\Route\Translator;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Processor that handles route parsing
 */
class ParseRoute implements \PHPixie\Processors\Processor
{
    /**
     * @type \PHPixie\Route\Translator
     */
    protected $routeTranslator;

    /**
     * Constructor
     * @param Translator $routeTranslator
     */
    public function __construct($routeTranslator)
    {
        $this->routeTranslator = $routeTranslator;
    }

    /**
     * Matches routes and sets request attributes
     * @param ServerRequestInterface $serverRequest
     * @return ServerRequestInterface
     */
    public function process($serverRequest)
    {
        $match = $this->routeTranslator->match($serverRequest);
        
        if($match !== null) {
            $attributes = $match->attributes();
            $attributes['routeResolverPath'] = $match->resolverPath();

            foreach($attributes as $key => $value) {
                $serverRequest = $serverRequest->withAttribute($key, $value);
            }
        }
        
        return $serverRequest;
    }
}