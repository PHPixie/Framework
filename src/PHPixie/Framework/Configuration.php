<?php

namespace PHPixie\Framework;

interface Configuration
{
    public function databaseConfig();
    public function ormConfig();
    public function templateConfig();
    public function frameworkConfig();
    
    public function filesystemRoot();
    public function ormWrappers();
    public function templateFilesystemLocator();
    
    public function httpDispatcher();
    public function routeResolver();
    public function filesystemLocator();
}