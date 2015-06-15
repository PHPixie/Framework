<?php

namespace;

class HTTPException
{
    protected $debug;
    protected $http;
    protected $template;
    protected $templateName;
    
    public function __construct($debug, $http, $template, $templateName)
    {
        $this->debug        = $debug;
        $this->http         = $http;
        $this->template     = $template;
        $this->templateName = $templateName;
    }
    
    public function process($exception)
    {
        $trace = $debug->exceptionTrace($exception);
        
        $body = $this->template->render(
            $this->templateName,
            array(
                'exception' => $exception,
                'trace'     => $trace
            )
        );
        
        return $this->http->responses->response($body, array(), 500);
    }
}