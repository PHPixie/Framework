<?php

namespace PHPixie\Framework;

class Context implements \PHPixie\HTTP\Context\Container\Settable
{
    protected $httpContext;
    
    public function httpContext()
    {
        return $this->httpContext;
    }
    
    public function setHttpContext($httpContext)
    {
        $this->httpContext = $httpContext;
    }
}