<?php

namespace PHPixie\Framework\Environment;

class LocatorRegistry implements \PHPixie\Filesystem\Locators\Registry
{
    protected $bundles;
    
    public function __construct($bundles)
    {
        $this->bundles = $bundle;
    }
    
    public function get($name)
    {
        list($bundleName, $name) = explode($name);
        $bundle = $this->bundles->get($bundleName);
        $bundle->locatorRegistry()->get($name);
    }
}   