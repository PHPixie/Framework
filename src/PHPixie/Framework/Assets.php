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
    
    public function templateLocator()
    {
        return $this->instance('templateLocator');
    }
    
    protected function instance($name)
    {
        if(!array_key_exists($name, $this->instances)) {
            $method = 'build'.ucfirst($name);
            $this->instances[$name] = $this->$method();
        }
        
        return $this->instances[$name];
    }
    
    protected function assetsRoot()
    {
        return $this->instance('assetsRoot');
    }
    
    protected function buildAssetsRoot()
    {
        $filesystem = $this->components->filesystem();
        
        return $filesystem->root(
            realpath(__DIR__.'/../../../assets')
        );
    }
    
    protected function buildTemplateLocator()
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