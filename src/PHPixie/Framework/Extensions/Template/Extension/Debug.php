<?php

namespace PHPixie\Framework\Extensions\Template\Extension;

/**
 * Template extension that allows
 * access to the Debug component
 */
class Debug implements \PHPixie\Template\Extensions\Extension
{
    /**
     * @var \PHPixie\Debug
     */
    protected $debug;

    /**
     * Constructor
     * @param \PHPixie\Debug $debug
     */
    public function __construct($debug)
    {
        $this->debug = $debug;
    }

    /**
     * @inheritdoc
     */
    public function name()
    {
        return 'debug';
    }

    /**
     * @inheritdoc
     */
    public function methods()
    {
        return array(
            'debugLogger' => 'logger'
        );
    }

    /**
     * @inheritdoc
     */
    public function aliases()
    {
        return array();
    }

    /**
     * Debug component logger
     * @return \PHPixie\Debug\Logger
     */
    public function logger()
    {
        return $this->debug->logger();
    }
}