<?php

namespace PHPixie\Tests\Framework\Processors\HTTP\Response;

/**
 * @coversDefaultClass \PHPixie\Framework\Processors\HTTP\Response\Exception
 */
class ExceptionTest extends \PHPixie\Test\Testcase
{
    protected $debug;
    protected $http;
    protected $template;
    protected $configData;
    
    protected $responseException;
    
    protected $httpResponses;
    
    public function setUp()
    {
        $this->debug      = $this->quickMock('\PHPixie\Debug', array('exceptionTrace'));
        $this->http       = $this->quickMock('\PHPixie\HTTP');
        $this->template   = $this->quickMock('\PHPixie\Template');
        $this->configData = $this->quickMock('\PHPixie\Slice\Data');
        
        $this->responseException = new \PHPixie\Framework\Processors\HTTP\Response\Exception(
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
        
        $this->assertSame($response, $this->responseException->process($exception));
    }
}