<?php

namespace PHPixie\Framework;

class Context implements \PHPixie\HTTP\Context\Container\Settable
{
    public function httpContext()
    {
        return $this->httpContext();
    }
    
    public function setHttpContet($context)
    {
        $this->httpContext = $context;s
    }
}