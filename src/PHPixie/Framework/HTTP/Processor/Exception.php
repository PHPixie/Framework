<?php

namespace PHPixie\Framework\HTTP\Processor;

class Exception
{
    protected $debug;
    protected $http;
    protected $template;
    protected $configData;
    
    public function __construct($debug, $http, $template, $configData)
    {
        $this->debug      = $debug;
        $this->http       = $http;
        $this->template   = $template;
        $this->configData = $configData;
    }
    
    public function process($exception)
    {
        $templateName = $this->configData->getRequired('template');
        $trace = $this->debug->exceptionTrace($exception);
        
        $body = $this->template->render(
            $templateName,
            array(
                'exception' => $exception,
                'trace'     => $trace
            )
        );
        
        return $this->http->responses()->response($body, array(), 500);
    }
}