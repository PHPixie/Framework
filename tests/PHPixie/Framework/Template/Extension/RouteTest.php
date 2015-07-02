<?php

namespace PHPixie\Tests\Framework\Template\Extension;

/**
 * @coversDefaultClass \PHPixie\Framework\Template\Extension\Route
 */
class RouteTest extends \PHPixie\Test\Testcase
{
    protected $routeTranslator;
    
    protected $extension;
    
    public function setUp()
    {
        $this->routeTranslator = $this->quickMock('\PHPixie\Route\Translator');
        $this->extension = new \PHPixie\Framework\Template\Extension\Route(
            $this->routeTranslator
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
     * @covers ::name
     * @covers ::<protected>
     */
    public function testName()
    {
        $this->assertSame('route', $this->extension->name());
    }
    
    /**
     * @covers ::methods
     * @covers ::<protected>
     */
    public function testMethods()
    {
        $this->assertSame(array('path', 'uri'), $this->extension->methods());
    }
    
    /**
     * @covers ::methods
     * @covers ::<protected>
     */
    public function testMethods()
    {
        $this->assertSame(array('path', 'uri'), $this->extension->methods());
    }
}