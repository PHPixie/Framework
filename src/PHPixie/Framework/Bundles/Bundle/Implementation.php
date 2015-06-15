<?php

namespace PHPixie\Framework\Bundles\Bundle;

class Implementation
{
    public function route()
    {
        return $this->builder->route();
    }
    
    public function locator()
    {
        return $this->builder->locator();
    }
    
    public function ormWrappers()
    {
        return $this->builder->ormWrappers();
    }
    
    public function dispatcher()
    {
        return $this->builder->dispatcher();
    }
}