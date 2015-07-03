<?php

namespace PHPixie\Tests\Framework\Components;

/**
 * @coversDefaultClass \PHPixie\Framework\Components\Extensions
 */
class ExtenionsTest extends \PHPixie\Test\Testcase
{
    protected $builder;
    protected $http;
    protected $routeTranslator;
    
    public function setUp()
    {
        $this->builder = $this->quickMock('\PHPixie\Framework\Builder');
        $this->extensions = $this->extensions();
        
        $this->http = $this->quickMock('\PHPixie\Framework\HTTP');
        $this->method($this->builder, 'http', $this->http, array());
        
        $this->routeTranslator = $this->quickMock('\PHPixie\Route\Translator');
        $this->method($this->http, 'routeTranslator', $this->routeTranslator, array());
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
        
    }
    
    /**
     * @covers ::templateExtensions
     * @covers ::<protected>
     */
    public function testTemplateExtensions()
    {
        $extensions = $this->extensions->templateExtensions();
        $this->assertTemplateRouteExtension($extensions[0]);
    }
    
    /**
     * @covers ::templateFormats
     * @covers ::<protected>
     */
    public function testTemplateFormats()
    {
        $this->assertSame(array(), $this->extensions->templateFormats());
    }
    
    protected function assertTemplateRouteExtension($extension)
    {
        $this->assertInstance($extension, 'PHPixie\Framework\Components\Extensions\Template\Extension\Route', array(
            'routeTranslator' => $this->routeTranslator
        ));
    }
    
    protected function extensions()
    {
        return new \PHPixie\Framework\Components\Extensions($this->builder);
    }
}