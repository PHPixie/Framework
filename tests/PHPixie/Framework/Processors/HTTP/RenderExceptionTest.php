<?php

namespace PHPixie\Tests\Framework\Processors\HTTP;

/**
 * @coversDefaultClass \PHPixie\Framework\Processors\HTTP\RenderException
 */
class RenderExceptionTest extends \PHPixie\Test\Testcase
{
    protected $debug;
    protected $http;
    protected $template;
    protected $configData;
    
    protected $renderException;
    
    protected $httpResponses;
    
    public function setUp()
    {
        $this->debug      = $this->quickMock('\PHPixie\Debug', array('exceptionTrace'));
        $this->http       = $this->quickMock('\PHPixie\HTTP');
        $this->template   = $this->quickMock('\PHPixie\Template');
        $this->configData = $this->quickMock('\PHPixie\Slice\Data');
        
        $this->renderException = new \PHPixie\Framework\Processors\HTTP\RenderException(
            $this->debug,
            $this->http,
            $this->template,
            $this->configData
        );
        
        $this->httpResponses = $this->quickMock('\PHPixie\HTTP\Responses');
        $this->method($this->http, 'responses', $this->httpResponses, array());
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
        $exception = $this->quickMock('\Exception');
        
        $this->method($this->configData, 'getRequired', 'pixie', array('template'), 0);
        
        $trace = $this->quickMock('\PHPixie\Debug\Tracer\Trace');
        $this->method($this->debug, 'exceptionTrace', $trace, array($exception), 0);
        
        $this->method($this->template, 'render', 'trixie', array(
            'pixie',
            array(
                'exception' => $exception,
                'trace'     => $trace
            )
        ), 0);
        
        $response  = $this->quickMock('\PHPixie\HTTP\Response');
        $this->method($this->httpResponses, 'response', $response, array('trixie', array(), 500), 0);
        
        $this->assertSame($response, $this->renderException->process($exception));
    }
}