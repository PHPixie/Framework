<?php

namespace PHPixie\Tests\Framework\Extensions\Template\Extension;

/**
 * @coversDefaultClass \PHPixie\Framework\Extensions\Template\Extension\RouteTranslator
 */
class RouteTranslatorTest extends \PHPixie\Test\Testcase
{
    protected $name = 'http';
    protected $routeTranslator;
    
    protected $extension;
    
    public function setUp()
    {
        $this->routeTranslator = $this->quickMock('\PHPixie\Route\Translator');
        $this->extension = new \PHPixie\Framework\Extensions\Template\Extension\RouteTranslator(
            $this->name,
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
        $this->assertSame($this->name, $this->extension->name());
    }
    
    /**
     * @covers ::methods
     * @covers ::<protected>
     */
    public function testMethods()
    {
        $this->assertSame(array(
            $this->name.'Path' => 'path',
            $this->name.'Uri'  => 'uri'
        ), $this->extension->methods());
    }
    
    /**
     * @covers ::aliases
     * @covers ::<protected>
     */
    public function testAliases()
    {
        $this->assertSame(array(), $this->extension->aliases());
    }
    
    /**
     * @covers ::path
     * @covers ::<protected>
     */
    public function testPath()
    {
        $parameters = array('t' => 1);
        $this->method($this->routeTranslator, 'generatePath', '/trixie', array('pixie', $parameters), 0);
        $this->assertSame('/trixie', $this->extension->path('pixie', $parameters));
        
        $this->method($this->routeTranslator, 'generatePath', '/trixie', array('pixie', array()), 0);
        $this->assertSame('/trixie', $this->extension->path('pixie'));
    }
    
    /**
     * @covers ::uri
     * @covers ::<protected>
     */
    public function testUri()
    {
        $parameters = array('t' => 1);
        
        $uri = $this->getUri();
        $this->method($this->routeTranslator, 'generateUri', $uri, array('pixie', $parameters, false), 0);
        $this->assertSame($uri, $this->extension->uri('pixie', $parameters, false));
        
        $uri = $this->getUri();
        $this->method($this->routeTranslator, 'generateUri', $uri, array('pixie', array(), true), 0);
        $this->assertSame($uri, $this->extension->uri('pixie'));
    }
    
    protected function getUri()
    {
        return $this->quickMock('Psr\Http\Message\UriInterface');
    }
}