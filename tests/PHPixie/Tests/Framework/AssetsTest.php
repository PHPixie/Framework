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
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
        $this->assetsMock();
    }
    
    /**
     * @covers ::frameworkAssetsRoot
     * @covers ::<protected>
     */
    public function testFrameworkAssetsRoot()
    {
        $this->assets = $this->assetsMock();
        $filesystem = $this->prepareComponent('filesystem');
        
        $assetsDir = realpath(__DIR__.'/../../../assets');
        $root = $this->quickMock('\PHPixie\Filesystem\Root');
        $this->method($filesystem, 'root', $root, array($assetsDir), 0);
        
        for($i=0; $i<2; $i++) {
            $this->assertSame($root, $this->assets->frameworkAssetsRoot());
        }
    }
    
    /**
     * @covers ::frameworkTemplateLocator
     * @covers ::<protected>
     */
    public function testFrameworkTemplateLocator()
    {
        $this->assets = $this->assetsMock(array('assetsRoot'));
        $assetsRoot   = $this->prepareRoot('assetsRoot');
        
        $slice      = $this->prepareComponent('slice');
        $filesystem = $this->prepareComponent('filesystem');
        
        $configData = $this->quickMock('\PHPixie\Slice\Data');
        $this->method($slice, 'arrayData', $configData, array(array(
            'type'      => 'directory',
            'directory' => 'template'
        )), 0);
        
        $locator = $this->quickMock('\PHPixie\Filesystem\Locators\Locator');
        $this->method($filesystem, 'buildLocator', $locator, array($configData, $assetsRoot), 0);
        
        for($i=0; $i<2; $i++) {
            $this->assertSame($locator, $this->assets->frameworkTemplateLocator());
        }
    }
 
    protected function prepareRoot($name)
    {
        $root = $this->quickMock('\PHPixie\Filesystem\Root');
        $this->method($this->assets, $name, $root, array());
        return $root;
    }
    
    protected function prepareComponent($name)
    {
        $mock = $this->quickMock('\PHPixie\\'.ucfirst($name));
        $this->method($this->components, $name, $mock, array());
        return $mock;
    }
    
    protected function assetsMock($methods = null)
    {
        return $this->getMock(
            '\PHPixie\Framework\Assets',
            $methods,
            array($this->components)
        );
    }
}