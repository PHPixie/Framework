<?php

namespace PHPixie\Tests\Framework;

/**
 * @coversDefaultClass \PHPixie\Framework\Assets
 */
class AssetsTest extends \PHPixie\Test\Testcase
{
    protected $components;
    
    protected $assets;
    
    public function setUp()
    {
        $this->components = $this->quickMock('\PHPixie\Framework\Components');
        $this->assets = $this->assets();
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
        
    }
    
    /**
     * @covers ::templateLocator
     * @covers ::<protected>
     */
    public function testTemplateLocator()
    {
        $filesystem = $this->prepareComponent('filesystem');
        $slice = $this->prepareComponent('slice');
        
        $root  = $this->prepareAssetsRoot($filesystem);
        
        $configData = $this->quickMock('\PHPixie\Slice\Data');
        $this->method($slice, 'arrayData', $configData, array(array(
            'type'      => 'directory',
            'directory' => 'template'
        )), 0);
        
        $locator = $this->quickMock('\PHPixie\Filesystem\Locators\Locator');
        $this->method($filesystem, 'buildLocator', $locator, array($configData, $root), 1);
        
        for($i=0; $i<2; $i++) {
            $this->assertSame($locator, $this->assets->templateLocator());
        }
    }
 
    public function prepareAssetsRoot($filesystem)
    {
        $assetsDir = realpath(__DIR__.'/../../../assets');
        $root = $this->quickMock('\PHPixie\Filesystem\Root');
        $this->method($filesystem, 'root', $root, array($assetsDir), 0);
        
        return $root;
    }
    
    protected function prepareComponent($name)
    {
        $mock = $this->quickMock('\PHPixie\\'.ucfirst($name));
        $this->method($this->components, $name, $mock, array());
        return $mock;
    }
    
    protected function assets()
    {
        return new \PHPixie\Framework\Assets($this->components);
    }
}