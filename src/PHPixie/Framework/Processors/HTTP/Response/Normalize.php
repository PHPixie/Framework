<?php

namespace PHPixie\Framework\Processors\HTTP\Response;

/**
 * Converts data into HTTP responses
 */
class Normalize implements \PHPixie\Processors\Processor
{
    /**
     * @var \PHPixie\HTTP
     */
    protected $http;

    /**
     * Constructor
     * @param \PHPixie\HTTP $http
     */
    public function __construct($http)
    {
        $this->http = $http;
    }

    /**
     * Convert data to a HTTP response
     * @param mixed $value
     * @return \PHPixie\HTTP\Responses\Response
     * @throws \PHPixie\HTTPProcessors\Exception If data type is not supported
     */
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
            return $this->http->responses()->string($value);
        }
        
        if(is_object($value) || is_array($value)) {
            return $this->http->responses()->json($value);
        }
        
        $type = gettype($value);
        throw new \PHPixie\HTTPProcessors\Exception("Cannot convert type '$type' into a response");
    }
}