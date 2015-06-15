<?php

namespace PHPixie\Tests\Framework\HTTP\Processor;

/**
 * @coversDefaultClass \PHPixie\Framework\HTTP\Processor\CheckRoute
 */
class CheckRouteTest extends \PHPixie\Test\Testcase
{
    protected $httpDispatcher;
    protected $foundProcessor;
    protected $notFoundProcessor;
    
    protected $checkRoute;
    
    public function setUp()
    {
        $this->httpDispatcher    = $this->quickMock('\PHPixie\Framework\Dispatcher');
        $this->foundProcessor    = $this->quickMock('\PHPixie\Processors\Processor');
        $this->notFoundProcessor = $this->quickMock('\PHPixie\Processors\Processor');
        
        $this->checkRoute = new \PHPixie\Framework\HTTP\Processor\CheckRoute(
            $this->httpDispatcher,
            $this->foundProcessor,
            $this->notFoundProcessor
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
        $this->processTest(false);
        $this->processTest(true);
    }
    
    protected function processTest($found)
    {
        $request = $this->quickMock('\PHPixie\HTTP\Request');
        $this->method($this->httpDispatcher, 'hasProcessorForRequest', $found, array($request), 0);
        
        $processor = $found ? $this->foundProcessor : $this->notFoundProcessor;
        $response = $this->quickMock('\PHPixie\HTTP\Response');
        
        $this->method($processor, 'process', $response, array($request), 0);
        
        $this->assertSame($response, $this->checkRoute->process($request));
    }
}