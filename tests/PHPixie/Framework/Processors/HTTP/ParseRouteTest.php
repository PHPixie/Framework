<?php

namespace PHPixie\Tests\FrameworkProcessors\HTTP;

/**
 * @coversDefaultClass \PHPixie\Framework\Processors\HTTP\ParseRoute
 */
class ParseRouteTest extends \PHPixie\Test\Testcase
{
    protected $routeTranslator;
    
    protected $parseRoute;
    
    public function setUp()
    {
        $this->routeTranslator = $this->quickMock('\PHPixie\Route\Translator');
        $this->parseRoute = new \PHPixie\Framework\Processors\HTTP\ParseRoute(
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
     * @covers ::process
     * @covers ::<protected>
     */
    public function testProcess()
    {
        $this->processTest(false);
        $this->processTest(true);
    }
    
    protected function processTest($matches)
    {
        $originalServerRequest = $this->getServerRequest();
        $serverRequest = $originalServerRequest;
        
        if($matches) {
            $match = $this->quickMock('\PHPixie\Route\Translator\Match');
            
            $attributes = array(
                'pixie' => 'Trixie',
                'fairy' => 'Blum',
            );
            $this->method($match, 'attributes', $attributes, array(), 0);
            $this->method($match, 'resolverPath', 'pixie.trixie', array(), 1);
            
            $attributes['routeResolverPath'] = 'pixie.trixie';
            
            foreach($attributes as $key => $value) {
                $newServerRequest = $this->getServerRequest();
                $this->method($serverRequest, 'withAttribute', $newServerRequest, array($key, $value), 0);
                $serverRequest = $newServerRequest;
            }
            
            
        }else{
            $match = null;
        }
        
        $this->method($this->routeTranslator, 'match', $match , array($originalServerRequest), 0);
        $this->assertSame($serverRequest, $this->parseRoute->process($originalServerRequest));
    }
    
    protected function getServerRequest()
    {
        return $this->quickMock('\Psr\Http\Message\ServerRequestInterface');
    }
}