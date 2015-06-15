<?php

namespace PHPixie\Framework\Processors;

class Route implements \PHPixie\HTTPProcessors\Repository
{
    protected $bundles;
    
    public function __construct($bundles)
    {
        $this->bundles = $bundles;
    }
    
    public function get($name)
    {
        explode()
    }
}