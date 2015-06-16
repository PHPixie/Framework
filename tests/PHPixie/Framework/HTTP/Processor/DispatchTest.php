<?php

namespace PHPixie\Tests\Framework\HTTP\Processor;

/**
 * @coversDefaultClass \PHPixie\Framework\HTTP\Processor\Dispatch
 */
class DispatchTest extends \PHPixie\Test\Testcase
{
    protected $httpDispatcher;
    
    protected $dispatch;
    
    public function setUp()
    {
        $this->httpDispatcher    = $this->quickMock('\PHPixie\Framework\Dispatcher');
        
        $this->dispatch = new \PHPixie\Framework\HTTP\Processor\Dispatch(
            $this->httpDispatcher
        );
    }
    
    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
    
    }
    
    /**
     * @covers ::process
     */
    public function testProcess()
    {
        $request   = $this->quickMock('\PHPixie\HTTP\Request');
        $processor = $this->quickMock('\PHPixie\Processors\Processor');
        $response  = $this->quickMock('\PHPixie\HTTP\Response');
        
        $this->method($this->httpDispatcher, 'getProcessorForRequest', $processor, array($request), 0);
        $this->method($processor, 'process', $response, array($request), 0);
        
        $this->assertSame($response, $this->dispatch->process($request));
    }
}