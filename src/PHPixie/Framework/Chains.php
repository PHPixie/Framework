<?php

namespace PHPixie\Framework;

class Chains
{
    public function http()
    {
        $httpChain = $this->processors->chain(array(
            $httpProcessors->parseBody(),
            $httpProcessors->parseUri(),
            $httpProcessors->dispatcher(),
            $httpProcessors->responder()
        ));
        
        $this->processors->chain(array(
            $processors->debug($httpChain),
            $httpProcessors->output()
        ))
    }
}