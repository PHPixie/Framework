<?php

namespace PHPixie\Framework\Extensions\Template\Extension;

/**
 * Template extension that allows route generation
 */
class RouteTranslator implements \PHPixie\Template\Extensions\Extension
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @type \PHPixie\Route\Translator
     */
    protected $routeTranslator;

    /**
     * Constructor
     * @param string $name Extension name to use
     * @param \PHPixie\Route\Translator $routeTranslator
     */
    public function __construct($name, $routeTranslator)
    {
        $this->name            = $name;
        $this->routeTranslator = $routeTranslator;
    }

    /**
     * @inheritdoc
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function methods()
    {
        return array(
            $this->name.'Path' => 'path',
            $this->name.'Uri'  => 'uri'
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
     * Generate path
     * @param string $resolverPath
     * @param array $attributes
     * @return string
     */
    public function path($resolverPath, $attributes = array())
    {
        return $this->routeTranslator->generatePath(
            $resolverPath,
            $attributes
        );
    }

    /**
     * Generate URI
     * @param string $resolverPath
     * @param array $attributes
     * @param bool $withHost Whether to include host in the URI
     * @return string
     */
    public function uri(
        $resolverPath,
        $attributes    = array(),
        $withHost      = true
    )
    {
        return $this->routeTranslator->generateUri(
            $resolverPath,
            $attributes,
            $withHost
        );
    }
}