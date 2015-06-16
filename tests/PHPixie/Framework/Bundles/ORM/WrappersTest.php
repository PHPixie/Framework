<?php

namespace PHPixie\Tests\Framework\Bundles\ORM;

/**
 * @coversDefaultClass \PHPixie\Framework\Bundles\ORM\Wrappers
 */
class WrappersTest extends \PHPixie\Test\Testcase
{
    protected $bundles;
    
    protected $wrappers;
    
    protected $bundleMap = array();
    protected $wrapperMap = array();
    
    public function setUp()
    {
        $this->bundles = $this->quickMock('\PHPixie\Framework\Bundles');
        
        $bundleNames = array('trixie', 'stella', 'blum');
        foreach($bundleNames as $name) {
            $bundle = $this->quickMock('\PHPixie\Framework\Bundles\Bundle');
            $this->bundleMap[$name] = $bundle;
            
            $wrappers = null;
            if($name !== 'blum') {
                $wrappers = $this->quickMock('\PHPixie\ORM\Wrappers');
                
                $this->method($wrappers, 'databaseRepositories', array($name.'Repo1', $name.'Repo2'), array(), 0);
                $this->method($wrappers, 'databaseQueries', array($name.'Query1', $name.'Query1'), array(), 1);
                $this->method($wrappers, 'databaseEntities', array($name.'Entity1', $name.'Entity2'), array(), 2);
                $this->method($wrappers, 'embeddedEntities', array($name.'Embedded1', $name.'Embedded2'), array(), 3);
            }
            
            $this->method($bundle, 'ormWrappers', $wrappers, array());
        }
        
        $this->method($this->bundles, 'map', $this->bundleMap, array());
        
        $this->wrappers = new \PHPixie\Framework\Bundles\ORM\Wrappers(
            $this->bundles
        );
    }
    
    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
    
    }
    
}