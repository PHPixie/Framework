<?php

namespace PHPixie\Tests\FrameworkProcessors\HTTP\Response;

/**
 * @coversDefaultClass \PHPixie\Framework\Processors\HTTP\Response\Normalize
 */
class ResponderTest extends \PHPixie\Test\Testcase
{
    protected $http;
    
    protected $normalizer;
    
    protected $httpResponses;
    
    public function setUp()
    {
        $this->http = $this->quickMock('\PHPixie\HTTP');
        
        $this->normalizer = new \PHPixie\Framework\Processors\HTTP\Response\Normalize(
            $this->http
        );
        
        $this->httpResponses = $this->quickMock('\PHPixie\HTTP\Responses');
        $this->method($this->http, 'responses', $this->httpResponses, array());
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
    
    }
    
    /**
     * @covers ::process
     * @covers ::<protected>
     */
    public function testProcessResponse()
    {
        $response = $this->getResponse();
        $this->assertSame($response, $this->normalizer->process($response));
    }
    
    /**
     * @covers ::process
     * @covers ::<protected>
     */
    public function testProcessResponseMessage()
    {
        $response = $this->quickMock('\Psr\Http\Message\ResponseInterface');
        $this->assertSame($response, $this->normalizer->process($response));
    }
    
    /**
     * @covers ::process
     * @covers ::<protected>
     */
    public function testProcessString()
    {
        $response = $this->getResponse();
        $this->method($this->httpResponses, 'string', $response, array('test'), 0);
        $this->assertSame($response, $this->normalizer->process('test'));
    }
    
    /**
     * @covers ::process
     * @covers ::<protected>
     */
    public function testProcessArray()
    {
        $array = array('t' => 1);
        $response = $this->getResponse();
        $this->method($this->httpResponses, 'json', $response, array($array), 0);
        $this->assertSame($response, $this->normalizer->process($array));
    }
    
    /**
     * @covers ::process
     * @covers ::<protected>
     */
    public function testProcessObject()
    {
        $object = (object) array('t' => 1);
        $response = $this->getResponse();
        $this->method($this->httpResponses, 'json', $response, array($object), 0);
        $this->assertSame($response, $this->normalizer->process($object));
    }
    
    /**
     * @covers ::process
     * @covers ::<protected>
     */
    public function testProcessTemplateContainer()
    {
        $container = $this->quickMock('\PHPixie\Template\Container');
        $response = $this->getResponse();
        
        $this->method($container, 'render', 'test', array(), 0);
        $this->method($this->httpResponses, 'string', $response, array('test'), 0);
        $this->assertSame($response, $this->normalizer->process($container));
    }
    
    /**
     * @covers ::process
     * @covers ::<protected>
     */
    public function testProcessException()
    {
        $normalizer = $this->normalizer;
        $this->assertException(function() use($normalizer) {
            $normalizer->process(8);
        }, '\PHPixie\HTTPProcessors\Exception');
    }
    
    protected function getResponse()
    {
        return $this->quickMock('\PHPixie\HTTP\Responses\Response');
    }}