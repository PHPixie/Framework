<?php

namespace PHPixie\Framework\HTTP;

interface Dispatcher
{
    public function hasProcessorForRequest($request);
    public function getProcessorForRequest($request);
}