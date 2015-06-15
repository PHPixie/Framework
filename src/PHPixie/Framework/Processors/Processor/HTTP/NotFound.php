<?php

namespace;

class NotFound
{
    protected $http;
    protected $template;
    protected $templateName;
    
    public function __construct($http, $template, $templateName)
    {
        $this->http         = $http;
        $this->template     = $template;
        $this->templateName = $templateName;
    }
    
    public function process($request)
    {
        $body = $this->template->render(
            $this->templateName,
            array(
                'request' => $request
            )
        );
        
        return $this->http->responses->response($body, array(), 404);
    }
}