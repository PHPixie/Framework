<?php

namespace PHPixie\Framework;

interface Configuration
{
    public function databaseConfig();
    public function templateConfig(); 
    
    public function httpConfig();
    public function httpProcessor();
    public function httpRouteResolver();

    public function ormConfig();
    public function ormWrappers();
    
    public function filesystemRoot();
    public function templateLocator();
}