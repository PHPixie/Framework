<?php

namespace PHPixie\Framework;

/**
 * Context containers
 */
class Context implements \PHPixie\HTTP\Context\Container\Settable,
                         \PHPixie\Auth\Context\Container\Settable
{
    /**
     * HTTP context
     * @var \PHPixie\HTTP\Context
     */
    protected $httpContext;

    /**
     * Auth context
     * @var \PHPixie\Auth\Context
     */
    protected $authContext;

    /**
     * @return \PHPixie\HTTP\Context
     */
    public function httpContext()
    {
        return $this->httpContext;
    }

    /**
     * Set HTTP context
     * @param \PHPixie\HTTP\Context $httpContext
     */
    public function setHttpContext($httpContext)
    {
        $this->httpContext = $httpContext;
    }

    /**
     * Auth context
     * @return \PHPixie\Auth\Context
     */
    public function authContext()
    {
        return $this->authContext;
    }

    /**
     * Set Auth context
     * @param  \PHPixie\Auth\Context $authContext
     */
    public function setAuthContext($authContext)
    {
        $this->authContext = $authContext;
    }
}