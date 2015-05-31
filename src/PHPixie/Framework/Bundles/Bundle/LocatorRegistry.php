<?php

namespace PHPixie\Framework\Bundles\Bundle;

class LocatorRegistry
{
    protected $filesystem;
    protected $configData;
    
    public function __construct($filesystem, $configData)
    {
        $this->filesystem = $filesystem;
        $this->configData = $configData;
    }
    
    public function get($name)
    {
        if(!array_key_exists($name, $this->instances)) {
            $this->instances[$name] = $this->buildLocator($name);
        }
        return $this->instances[$name];
    }
    
    protected function buildRoute($name)
    {
        $config = $this->buildLocator->slice($name);
        return $this->filesystem->buildLocatorFromConfig($config);
    }
}    