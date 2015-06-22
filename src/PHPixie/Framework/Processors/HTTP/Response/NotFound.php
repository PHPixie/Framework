<?php

namespace PHPixie\Framework\Processors\HTTP\Response;

class NotFound implements \PHPixie\Processors\Processor
{
    protected $http;
    protected $template;
    protected $configData;
    
    public function __construct($http, $template, $configData)
    {
        $this->http       = $http;
        $this->template   = $template;
        $this->configData = $configData;
    }
    
    public function process($request)
    {
        $templateName = $this->configData->getRequired('template');
        
        $body = $this->template->render(
            $templateName,
            array(
                'request' => $request
            )
        );
        
        return $this->http->responses()->response($body, array(), 404);
    }
}