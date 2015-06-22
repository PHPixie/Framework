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
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
    
    }
    
    /**
     * @covers ::httpContext
     * @covers ::setHttpContext
     * @covers ::<protected>
     */
    public function testHttpContext()
    {
        $this->assertSame(null, $this->context->httpContext());
        
        $httpContext = $this->quickMock('\PHPixie\Tests\HTTP\Context');
        $this->context->setHttpContext($httpContext);
        $this->assertSame($httpContext, $this->context->httpContext());
    }
}