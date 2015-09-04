<?php

namespace PHPixie\Tests\Framework;

/**
 * @coversDefaultClass \PHPixie\Framework\Components
 */
class ComponentsTest extends \PHPixie\Test\Testcase
{
    protected $builder;
        
    protected $components;
    
    protected $configuration;
    protected $context;
    protected $extensions;
    
    public function setUp()
    {
        $this->builder = $this->builder();
        $this->components = $this->components(null);
        
        $this->configuration = $this->quickMock('\PHPixie\Framework\Configuration');
        $this->method($this->builder, 'configuration', $this->configuration, array());
        
        $this->context = $this->quickMock('\PHPixie\Framework\Context');
        $this->method($this->builder, 'context', $this->context, array());
        
        $this->extensions = $this->extensions();
        $this->method($this->builder, 'extensions', $this->extensions, array());
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
        
    }
    
    /**
     * @covers ::slice
     * @covers ::<protected>
     */
    public function testSlice()
    {
        $this->assertComponent('slice', '\PHPixie\Slice');
    }
    
    /**
     * @covers ::config
     * @covers ::<protected>
     */
    public function testConfig()
    {
        $this->components = $this->components(array('slice'));
        $slice = $this->prepareComponent('slice');
        
        $this->assertComponent('config', '\PHPixie\Config', array(
            'slice' => $slice
        ));
    }
    
    /**
     * @covers ::debug
     * @covers ::<protected>
     */
    public function testDebug()
    {
        $this->assertComponent('debug', '\PHPixie\Debug');
    }
    
    /**
     * @covers ::database
     * @covers ::<protected>
     */
    public function testDatabase()
    {
        $configData = $this->prepareConfig('database');
        
        $database = $this->components->database();
        $this->assertInstance($database, '\PHPixie\Database', array(
            'config' => $configData
        ));
        
        $this->assertSame($database, $this->components->database());
    }
    
    /**
     * @covers ::filesystem
     * @covers ::<protected>
     */
    public function testFilesystem()
    {
        $this->assertComponent('filesystem', '\PHPixie\Filesystem');
    }
    
    /**
     * @covers ::http
     * @covers ::<protected>
     */
    public function testHttp()
    {
        $this->components = $this->components(array('slice'));
        $slice = $this->prepareComponent('slice');
        
        $this->assertComponent('http', '\PHPixie\HTTP', array(
            'slice' => $slice
        ));
    }
    
    /**
     * @covers ::httpProcessors
     * @covers ::<protected>
     */
    public function testHttpProcessors()
    {
        $this->components = $this->components(array('http'));
        $http = $this->prepareComponent('http');
        
        $this->assertComponent('httpProcessors', '\PHPixie\HTTPProcessors', array(
            'http' => $http
        ));
    }
    
    
    /**
     * @covers ::orm
     * @covers ::<protected>
     */
    public function testOrm()
    {
        $this->components = $this->components(array('database'));
        $database = $this->prepareComponent('database');
        $configData = $this->prepareConfig('orm');
        
        $wrappers = $this->quickMock('\PHPixie\ORM\Wrappers');
        $this->method($this->configuration, 'ormWrappers', $wrappers, array());
        
        $this->assertComponent('orm', '\PHPixie\ORM', array(
            'database'    => $database,
            'configSlice' => $configData,
            'wrappers'    => $wrappers,
        ));
    }
    
    /**
     * @covers ::processors
     * @covers ::<protected>
     */
    public function testProcessors()
    {
        $this->assertComponent('processors', '\PHPixie\Processors');
    }
    
    /**
     * @covers ::route
     * @covers ::<protected>
     */
    public function testRoute()
    {
        $this->assertComponent('route', '\PHPixie\Route');
    }
    
    /**
     * @covers ::template
     * @covers ::<protected>
     */
    public function testTemplate()
    {
        $this->components = $this->components(array('slice'));
        $slice = $this->prepareComponent('slice');
        
        $configData = $this->prepareConfig('template');
        $locator    = $this->prepareLocator('template');
        $root       = $this->prepareRoot();
        
        $templateExtensions = array(
            $this->quickMock('\PHPixie\Template\Extensions\Extension')
        );
        $this->method($this->extensions, 'templateExtensions', $templateExtensions, array(), 0);
        
        $templateFormats = array(
            $this->quickMock('\PHPixie\Template\Formats\Format')
        );
        $this->method($this->extensions, 'templateFormats', $templateFormats, array(), 1);
        
        $this->assertComponent('template', '\PHPixie\Template', array(
            'slice'              => $slice,
            'configData'         => $configData,
            'filesystemLocator'  => $locator,
            'filesystemRoot'     => $root,
            'externalExtensions' => $templateExtensions,
            'externalFormats'    => $templateFormats
        ));
    }
    
    /**
     * @covers ::auth
     * @covers ::<protected>
     */
    public function testAuth()
    {
        $this->components = $this->components(array('database'));
        
        $database   = $this->prepareComponent('database');
        $configData = $this->prepareConfig('auth');
        
        $repositories = $this->quickMock('\PHPixie\Auth\Repositories\Registry');
        $this->method($this->configuration, 'authRepositories', $repositories, array());
        
        $this->assertComponent('auth', '\PHPixie\Auth', array(
            'database'   => $database,
            'configData' => $configData,
            'httpContextContainer' => $this->context,
            'authContextContainer' => $this->context
        ));
    }
    
    /**
     * @covers ::authProcessors
     * @covers ::<protected>
     */
    public function testAuthProcessors()
    {
        $this->components = $this->components(array('auth'));
        $auth = $this->prepareComponent('auth');
        
        $this->assertComponent('authProcessors', '\PHPixie\AuthProcessors', array(
            'auth' => $auth
        ));
    }
    
    protected function assertComponent($name, $class, $builderAttributes = null)
    {
        $instance = $this->components->$name();
        $this->assertInstance($instance, $class);
        
        if($builderAttributes !== null) {
            $builder = $instance->builder();
            foreach($builderAttributes as $key => $value) {
                $this->assertAttributeEquals($value, $key, $builder);
            }
        }
        
        $this->assertSame($instance, $this->components->$name());
    }
    
    protected function prepareComponent($name)
    {
        $mock = $this->quickMock('\PHPixie\\'.ucfirst($name));
        $this->method($this->components, $name, $mock, array());
        return $mock;
    }
    
    protected function prepareConfig($name)
    {
        $configData = $this->getSliceData();
        $this->method($this->configuration, $name.'Config', $configData, array());
        return $configData;
    }
    
    protected function prepareLocator($name)
    {
        $locator = $this->getSliceData();
        $this->method($this->configuration, $name.'Locator', $locator, array());
        return $locator;
    }
    
    protected function prepareRoot()
    {
        $root = $this->quickMock('\PHPixie\Filesystem\Root');
        $this->method($this->configuration, 'filesystemRoot', $root, array());
        return $root;
    }
    
    protected function getSliceData()
    {
        return $this->quickMock('\PHPixie\Slice\Data');
    }
    
    protected function extensions()
    {
        return $this->quickMock('\PHPixie\Framework\Extensions');
    }
    
    protected function builder()
    {
        return $this->quickMock('\PHPixie\Framework\Builder');
    }
    
    protected function components($methods)
    {
        return $this->getMock(
            '\PHPixie\Framework\Components',
            $methods,
            array($this->builder)
        );
    }
}