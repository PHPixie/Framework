<?php

namespace PHPixie\Tests\Framework;

/**
 * @coversDefaultClass \PHPixie\Framework\Builder
 */
class BuilderTest extends \PHPixie\Test\Testcase
{
    protected $builder;
    
    public function setUp()
    {
        $this->builder = $this->builderMock();
    }
    
    /**
     * @covers ::assets
     * @covers ::<protected>
     */
    public function testAssets()
    {
        $this->builder = $this->builderMock(array('components'));
        
        $components = $this->prepareInstance('components', '\PHPixie\Framework\Components');
        
        $this->instanceTest('assets', '\PHPixie\Framework\Assets', array(
            'components' => $components
        ));
    }
    
    /**
     * @covers ::components
     * @covers ::<protected>
     */
    public function testComponents()
    {
        $this->instanceTest('components', '\PHPixie\Framework\Components', array(
            'builder' => $this->builder
        ));
    }
    
    
    protected function instanceTest($method, $class, $propertyMap = array())
    {
        $instance = $this->builder->$method();
        $this->assertInstance($instance, $class, $propertyMap);
        $this->assertSame($instance, $this->builder->$method());
    }
    
    protected function prepareInstance($method, $class)
    {
        $mock = $this->quickMock($class);
        $this->method($this->builder, $method, $mock, array());
        return $mock;
    }
    
    protected function builderMock($methods = null)
    {
        if($methods === null) {
            $methods = array();
        }
        
        if(!in_array('configuration', $methods)) {
            $methods[]= 'configuration';
        }
        
        return $this->getMock(
            '\PHPixie\Framework\Builder',
            $methods
        );
    }
}