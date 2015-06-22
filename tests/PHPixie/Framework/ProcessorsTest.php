<?php

namespace PHPixie\Tests\Framework;

/**
 * @coversDefaultClass \PHPixie\Framework\Processors
 */
class ProcessorsTest extends \PHPixie\Test\Testcase
{
    protected $builder;
    
    protected $processors;
    
    protected $components;
    
    public function setUp()
    {
        $this->builder = $this->quickMock('\PHPixie\Framework\Builder');
        
        $this->processors = new \PHPixie\Framework\Processors($this->builder);
        
        $this->components = $this->quickMock('\PHPixie\Framework\Components');
        $this->method($this->builder, 'components', $this->components, array());
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
    
    }
    
    /**
     * @covers ::httpParseRoute
     * @covers ::<protected>
     */
    public function testHttpParseRoute()
    {
        $routeTranslator = $this->quickMock('\PHPixie\Route\Translator');
        
        $processor = $this->processors->httpParseRoute($routeTranslator);
        
        $this->assertInstance($processor, '\PHPixie\Framework\Processors\HTTP\ParseRoute', array(
            'routeTranslator' => $routeTranslator,
        ));
    }
    
    /**
     * @covers ::httpExceptionResponse
     * @covers ::<protected>
     */
    public function testHttpExceptionResponse()
    {
        $debug      = $this->prepareComponent('debug');
        $http       = $this->prepareComponent('http');
        $template   = $this->prepareComponent('template');
        $configData = $this->getSliceData();
        
        $processor = $this->processors->httpExceptionResponse($configData);
        
        $this->assertInstance($processor, '\PHPixie\Framework\Processors\HTTP\Response\Exception', array(
            'debug'      => $debug,
            'http'       => $http,
            'template'   => $template,
            'configData' => $configData
        ));
    }
    
    /**
     * @covers ::httpNotFoundResponse
     * @covers ::<protected>
     */
    public function testHttpNotFoundResponse()
    {
        $http       = $this->prepareComponent('http');
        $template   = $this->prepareComponent('template');
        $configData = $this->getSliceData();
        
        $processor = $this->processors->httpNotFoundResponse($configData);
        
        $this->assertInstance($processor, '\PHPixie\Framework\Processors\HTTP\Response\NotFound', array(
            'http'       => $http,
            'template'   => $template,
            'configData' => $configData
        ));
    }
    
    /**
     * @covers ::httpNormalizeResponse
     * @covers ::<protected>
     */
    public function testHttpNormalizeResponse()
    {
        $http = $this->prepareComponent('http');
        
        $processor = $this->processors->httpNormalizeResponse();
        
        $this->assertInstance($processor, '\PHPixie\Framework\Processors\HTTP\Response\Normalize', array(
            'http' => $http
        ));
    }
    
    protected function prepareComponent($name)
    {
        $mock = $this->quickMock('\PHPixie\\'.ucfirst($name));
        $this->method($this->components, $name, $mock, array());
        return $mock;
    }
    
    protected function getSliceData()
    {
        return $this->quickMock('\PHPixie\Slice\Data');
    }
}    