<?php

namespace PHPixie\Framework;

class Dispatcher
{
    protected $bundleMap = array();
    
    public function __construct($bundles)
    {
        foreach($bundles->map() as $name => $bundle) {
            if($bundle instanceof \PHPixie\Framework\Bundles\Bundle\Provides\Dispatcher) {
                $this->bundleMap[$name] = $bundle;
            }
        }
    }
    
    public function hasProcessorForRequest($request)
    {
        $dispatcher = $this->getBundleDispatcher($request);
        if($dispatcher === null) {
            return false;
        }
        
        return $dispatcher->hasProcessorForRequest($request);
    }
    
    public function getProcessorForRequest($request)
    {
        $dispatcher = $this->getBundleDispatcher($request);
        if($dispatcher === null) {
            throw new \PHPixie\Framework\Exception("No bundle found for the request");
        }
        
        return $dispatcher->getProcessorForRequest($request);
    }
    
    protected function getBundleDispatcher($request)
    {
        $name = $request->parameters->get('bundle');
        if(!array_key_exists($name, $this->bundleMap, true)) {
            return null;
        }
        
        return $this->bundleMap[$bundleName]->dispatcher();
    }
}