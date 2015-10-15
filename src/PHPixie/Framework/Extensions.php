<?php

namespace PHPixie\Framework;

class Extensions
{
    /**
     * @type Builder
     */
    protected $builder;
    
    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    public function templateExtensions()
    {
        return array(
            new Extensions\Template\Extension\RouteTranslator(
                'http',
                $this->builder->http()->routeTranslator()
            )
        );
    }
    
    public function templateFormats()
    {
        return array();
    }
    
    public function authProviderBuilders()
    {
        return array(
            $this->buildAuthLogin()->providers(),
            $this->buildAuthHttp()->providers()
        );
    }
    
    public function buildAuthLogin()
    {
        return new \PHPixie\AuthLogin(
            $this->components()->security()
        );
    }
    
    public function buildAuthHttp()
    {
        return new \PHPixie\AuthHTTP(
            $this->components()->security(),
            $this->builder->context()
        );
    }
    
    protected function components()
    {
        return $this->builder->components();
    }
}