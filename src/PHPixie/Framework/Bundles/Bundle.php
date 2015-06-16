<?php

namespace PHPixie\Framework\Bundles;

interface Bundle
{
    public function name();
    public function ormWrappers();
}