<?php

namespace PHPixie\Framework;

interface Configuration
{
    public function databaseConfig();
    public function ormConfig();
    public function templateConfig();
    
    public function filesystemRoot();
    public function ormWrappers();
    public function templateLocator();
    
    public function routeResolver();
    public function locator();
    public function route();
}