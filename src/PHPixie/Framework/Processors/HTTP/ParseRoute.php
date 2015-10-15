<?php

namespace PHPixie\Framework\Processors\HTTP;

class ParseRoute implements \PHPixie\Processors\Processor
{
    /**
     * @type \PHPixie\Route\Translator
     */
    protected $routeTranslator;
    
    public function __construct($routeTranslator)
    {
        $this->routeTranslator = $routeTranslator;
    }
    
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