<?php

namespace PHPixie\Tests;

/**
 * @coversDefaultClass \PHPixie\Framework
 */
class FrameworkTest extends \PHPixie\Test\Testcase
{
    protected $framework;
    
    protected $builder;
    protected $http;
    
    public function setUp()
    {
        $this->framework = $this->framework();
        
        $this->builder = $this->builder();
        $this->method($this->framework, 'buildBuilder', $this->builder, array(), 0);
        
        $this->http = $this->http();
        $this->method($this->builder, 'http', $this->http, array());
        
        $this->framework->__construct();
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstructor()
    {
        
    }
    
    /**
     * @covers ::processHttpSapiRequest
     * @covers ::<protected>
     */
    public function testProcessHttpSapiRequest()
    {
        $this->method($this->http, 'processSapiRequest', null, array(), 0);
        $this->framework->processHttpSapiRequest();
    }
    
    /**
     * @covers ::processHttpServerRequest
     * @covers ::<protected>
     */
    public function testProcessHttpServerRequest()
    {
        $request  = $this->quickMock('\Psr\Http\Message\ServerRequestInterface');
        $response = $this->quickMock('\Psr\Http\Message\ResponseInterface');
        
        $this->method($this->http, 'processServerRequest', $response, array($request), 0);
        $this->assertSame($response, $this->framework->processHttpServerRequest($request));
    }
    
    protected function http()
    {
        return $this->quickMock('\PHPixie\Framework\HTTP');
    }
    
    protected function framework()
    {
        return $this->getMockBuilder('\PHPixie\Framework')
            ->setMethods(array('buildBuilder'))
            ->disableOriginalConstructor()
            ->getMock();
    }
    
    protected function builder()
    {
        return $this->abstractMock('\PHPixie\Framework\Builder');
    }
}