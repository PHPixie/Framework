<?php

namespace PHPixie\Framework;

class Assets
{
    protected $slice;
    protected $filesystem;
    
    protected $instances = array();
    
    public function __construct($slice, $filesystem)
    {
        $this->slice      = $slice;
        $this->filesystem = $filesystem;
    }
    
    public function assetsRoot()
    {
        return $this->instance('assetsRoot');
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
    
    protected buildAssetsRoot()
    {
        return $this->filesystem->root(
            realpath(__DIR__.'/../../../assets');
        );
    }
    
    protected function buildTemplateLocator()
    {
        $configData = $this->slice->arrayData(array(
            'type'      => 'directory',
            'directory' => 'template'
        ));
        
        return $this->filesystem->buildLocator(
            $configData,
            $this->assetsRoot()
        );
    }
}