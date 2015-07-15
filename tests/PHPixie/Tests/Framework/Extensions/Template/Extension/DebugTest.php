<?php

namespace PHPixie\Tests\Framework\Extensions\Template\Extension;

/**
 * @coversDefaultClass \PHPixie\Framework\Extensions\Template\Extension\Debug
 */
class DebugTest extends \PHPixie\Test\Testcase
{
    protected $debug;
    
    protected $extension;
    
    public function setUp()
    {
        $this->debug = $this->quickMock('\PHPixie\Debug');
        $this->extension = new \PHPixie\Framework\Extensions\Template\Extension\Debug(
            $this->debug
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
        $this->assertSame('debug', $this->extension->name());
    }
    
    /**
     * @covers ::methods
     * @covers ::<protected>
     */
    public function testMethods()
    {
        $this->assertSame(array(
            'debugLogger' => 'logger'
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
     * @covers ::logger
     * @covers ::<protected>
     */
    public function testLogger()
    {
        $logger = $this->quickMock('\PHPixie\Debug\Logger');
        $this->method($this->debug, 'logger', $logger, array(), 0);
        
        $this->assertSame($logger, $this->extension->logger());
    }
}