<?php

namespace PHPixie\Tests\FrameworkProcessors\HTTP;

/**
 * @coversDefaultClass \PHPixie\Framework\Processors\HTTP\NotFound
 */
class NotFoundTest extends \PHPixie\Test\Testcase
{
    protected $http;
    protected $template;
    protected $configData;
    
    protected $exception;
    
    protected $httpResponses;
    
    public function setUp()
    {
        $this->http       = $this->quickMock('\PHPixie\HTTP');
        $this->template   = $this->quickMock('\PHPixie\Template');
        $this->configData = $this->quickMock('\PHPixie\Slice\Data');
        
        $this->exception = new \PHPixie\Framework\Processors\HTTP\NotFound(
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
        $request = $this->quickMock('\PHPixie\HTTP\Request');
        
        $this->method($this->configData, 'getRequired', 'pixie', array('template'), 0);
        
        $this->method($this->template, 'render', 'trixie', array(
            'pixie',
            array(
                'request' => $request
            )
        ), 0);
        
        $response  = $this->quickMock('\PHPixie\HTTP\Response');
        $this->method($this->httpResponses, 'response', $response, array('trixie', array(), 404), 0);
        
        $this->assertSame($response, $this->exception->process($request));
    }
}