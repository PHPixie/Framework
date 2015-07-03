<?php

namespace PHPixie\Framework;

class Assets
{
    protected $components;
    protected $instances = array();
    
    public function __construct($components)
    {
        $this->components = $components;
    }
    
    public function frameworkTemplateLocator()
    {
        return $this->instance('frameworkTemplateLocator');
    }
    
    protected function instance($name)
    {
        if(!array_key_exists($name, $this->instances)) {
            $method = 'build'.ucfirst($name);
            $this->instances[$name] = $this->$method();
        }
        
        return $this->instances[$name];
    }
    
    public function frameworkAssetsRoot()
    {
        return $this->instance('frameworkAssetsRoot');
    }
    
    protected function buildFrameworkAssetsRoot()
    {
        $directory = realpath(__DIR__.'/../../../assets');
        return $this->buildFilesystemRoot($directory);
    }
    
    protected function buildFilesystemRoot($directory)
    {
        $filesystem = $this->components->filesystem();
        return $filesystem->root($directory);
    }
    
    protected function buildFrameworkTemplateLocator()
    {
        $slice      = $this->components->slice();
        $filesystem = $this->components->filesystem();
        
        $configData = $slice->arrayData(array(
            'type'      => 'directory',
            'directory' => 'template'
        ));
        
        return $filesystem->buildLocator(
            $configData,
            $this->assetsRoot()
        );
    }
}