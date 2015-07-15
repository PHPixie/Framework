<?php

namespace PHPixie\Framework\Extensions\Template\Extension;

class Debug implements \PHPixie\Template\Extensions\Extension
{
    
    protected $debug;
    
    public function __construct($debug)
    {
        $this->debug = $debug;
    }
    
    public function name()
    {
        return 'debug';
    }
    
    public function methods()
    {
        return array(
            'debugLogger' => 'logger'
        );
    }
    
    public function aliases()
    {
        return array();
    }
    
    public function logger()
    {
        return $this->debug->logger();
    }
}