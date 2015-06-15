<?php

namespace PHPixie\Framework\Processor\HTTP;

class Debug
{
    protected $http;
    protected $template;
    protected $processor;
    
    public function __construct($http, $template, $processor)
    {
        $this->http      = $http;
        $this->template  = $template;
        $this->processor = $processor;
    }
    
    public function process($serverRequest)
    {
        try{
            $response = $this->processor->process($serverRequest);
            
        }catch(\Exception $exception) {
            $response = $this->exceptionResponse($exception);
            
        }
        
        return $response;
    }
    
    protected function exceptionResponse($exception)
    {
        $body = $this->template->render(
            $this->exceptionTemplate,
            array(
                'exception' => $exception
            )
        );
        
        $response = $this->http->responses()->string($body);
        $response->setStatus('503');
        return $response;
    }
}