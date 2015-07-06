<?php

namespace PHPixie\Framework;

interface Configuration
{
    public function databaseConfig();
    public function frameworkConfig();
    public function routeTranslatorConfig();
    public function templateConfig(); 
    
    public function filesystemRoot();
    
    public function ormConfig();
    public function ormWrappers();
    
    public function httpProcessor();
    public function routeResolver();
    public function templateLocator();
}