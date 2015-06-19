<?php

namespace PHPixie\Framework\Processors\HTTP\Response;

class Normalize implements \PHPixie\Processors\Processor
{
    protected $http;
    
    public function __construct($http)
    {
        $this->http = $http;
    }
    
    public function process($value)
    {
        if($value instanceof \PHPixie\HTTP\Responses\Response) {
            return $value;
        }
        
        if($value instanceof \Psr\Http\Message\ResponseInterface) {
            return $value;
        }
        
        if($value instanceof \PHPixie\Template\Container) {
            $value = $value->render();
        }
        
        if(is_string($value)) {
            return $this->httpResponses->string($value);
        }
        
        if(is_object($value) || is_array($value)) {
            return $this->httpResponses->json($value);
        }
        
        $type = gettype($value);
        throw new \PHPixie\HTTPProcessors\Exception("Cannot convert type '$type' into a response");
    }
}