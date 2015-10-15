<?php

namespace PHPixie\Framework;

class Context implements \PHPixie\HTTP\Context\Container\Settable,
                         \PHPixie\Auth\Context\Container\Settable
{
    protected $httpContext;
    protected $authContext;

    /**
     * @return \PHPixie\HTTP\Context
     */
    public function httpContext()
    {
        return $this->httpContext;
    }
    
    public function setHttpContext($httpContext)
    {
        $this->httpContext = $httpContext;
    }

    /**
     * @return \PHPixie\Auth\Context
     */
    public function authContext()
    {
        return $this->authContext;
    }
    
    public function setAuthContext($authContext)
    {
        $this->authContext = $authContext;
    }
}