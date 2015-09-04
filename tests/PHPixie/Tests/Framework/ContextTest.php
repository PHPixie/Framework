<?php

namespace PHPixie\Tests\Framework;

/**
 * @coversDefaultClass \PHPixie\Framework\Context
 */
class ContextTest extends \PHPixie\Test\Testcase
{
    protected $context;
    
    public function setUp()
    {
        $this->context = new \PHPixie\Framework\Context();
    }
    
    /**
     * @covers ::httpContext
     * @covers ::setHttpContext
     * @covers ::<protected>
     */
    public function testHttpContext()
    {
        $this->assertSame(null, $this->context->httpContext());
        
        $httpContext = $this->quickMock('\PHPixie\HTTP\Context');
        $this->context->setHttpContext($httpContext);
        $this->assertSame($httpContext, $this->context->httpContext());
    }
    
    /**
     * @covers ::authContext
     * @covers ::setAuthContext
     * @covers ::<protected>
     */
    public function testAuthContext()
    {
        $this->assertSame(null, $this->context->authContext());
        
        $authContext = $this->quickMock('\PHPixie\Auth\Context');
        $this->context->setAuthContext($authContext);
        $this->assertSame($authContext, $this->context->authContext());
    }
}