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
     * @covers ::exceptionResponse
     * @covers ::<protected>
     */
    public function testExceptionResponse()
    {
        $debug      = $this->prepareComponent('debug');
        $http       = $this->prepareComponent('http');
        $template   = $this->prepareComponent('template');
        $configData = $this->getSliceData();
        
        $processor = $this->processors->exceptionResponse($configData);
        
        $this->assertInstance($processor, '\PHPixie\Framework\Processors\HTTP\Response\Exception', array(
            'debug'      => $debug,
            'http'       => $http,
            'template'   => $template,
            'configData' => $configData
        ));
    }
    
    /**
     * @covers ::notFoundResponse
     * @covers ::<protected>
     */
    public function testNotFoundResponse()
    {
        $http       = $this->prepareComponent('http');
        $template   = $this->prepareComponent('template');
        $configData = $this->getSliceData();
        
        $processor = $this->processors->notFoundResponse($configData);
        
        $this->assertInstance($processor, '\PHPixie\Framework\Processors\HTTP\Response\NotFound', array(
            'http'       => $http,
            'template'   => $template,
            'configData' => $configData
        ));
    }
    
    /**
     * @covers ::normalizeResponse
     * @covers ::<protected>
     */
    public function testNormalizeResponse()
    {
        $http = $this->prepareComponent('http');
        
        $processor = $this->processors->normalizeResponse();
        
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