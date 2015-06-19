<?php

namespace PHPixie\Tests\FrameworkProcessors\HTTP;

/**
 * @coversDefaultClass \PHPixie\Framework\Processors\HTTP\Responder
 */
class ResponderTest extends \PHPixie\Test\Testcase
{
    protected $httpResponses;
    protected $responder;
    
    public function setUp()
    {
        $this->httpResponses = $this->quickMock('\PHPixie\HTTP\Responses');
        
        $this->responder = new \PHPixie\Framework\Processors\HTTP\Responder(
            $this->httpResponses
        );
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
        $this->assertSame($response, $this->responder->process($response));
    }
    
    /**
     * @covers ::process
     * @covers ::<protected>
     */
    public function testProcessResponseMessage()
    {
        $response = $this->quickMock('\Psr\Http\Message\ResponseInterface');
        $this->assertSame($response, $this->responder->process($response));
    }
    
    /**
     * @covers ::process
     * @covers ::<protected>
     */
    public function testProcessString()
    {
        $response = $this->getResponse();
        $this->method($this->httpResponses, 'string', $response, array('test'), 0);
        $this->assertSame($response, $this->responder->process('test'));
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
        $this->assertSame($response, $this->responder->process($array));
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
        $this->assertSame($response, $this->responder->process($object));
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
        $this->assertSame($response, $this->responder->process($container));
    }
    
    /**
     * @covers ::process
     * @covers ::<protected>
     */
    public function testProcessException()
    {
        $responder = $this->responder;
        $this->assertException(function() use($responder) {
            $responder->process(8);
        }, '\PHPixie\HTTPProcessors\Exception');
    }
    
    protected function getResponse()
    {
        return $this->quickMock('\PHPixie\HTTP\Responses\Response');
    }}