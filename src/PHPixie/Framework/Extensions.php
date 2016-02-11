<?php

namespace PHPixie\Framework;

/**
 * Extensions registry
 */
class Extensions
{
    /**
     * @type Builder
     */
    protected $builder;

    /**
     * Constructor
     * @param Builder $builder
     */
    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    /**
     * Extensions for the Template component
     * @return array
     */
    public function templateExtensions()
    {
        return array(
            new Extensions\Template\Extension\Debug(
                $this->components()->debug()
            ),
            new Extensions\Template\Extension\RouteTranslator(
                'http',
                $this->builder->http()->routeTranslator()
            )
        );
    }

    /**
     * Additional formats for the Template component
     * @return array
     */
    public function templateFormats()
    {
        return array();
    }

    /**
     * Provider builders for the Auth component
     * @return array
     */
    public function authProviderBuilders()
    {
        return array(
            $this->buildAuthLogin()->providers(),
            $this->buildAuthHttp()->providers()
        );
    }

    /**
     * Login extension for the Auth component
     * @return \PHPixie\AuthLogin
     */
    public function buildAuthLogin()
    {
        return new \PHPixie\AuthLogin(
            $this->components()->security()
        );
    }

    /**
     * HTTP extension for the Auth component
     * @return \PHPixie\AuthHTTP
     */
    public function buildAuthHttp()
    {
        return new \PHPixie\AuthHTTP(
            $this->components()->security(),
            $this->builder->context()
        );
    }

    /**
     * @return Components
     */
    protected function components()
    {
        return $this->builder->components();
    }
}