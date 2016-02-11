<?php

namespace PHPixie\Framework\Processors\HTTP\Response;

/**
 * Processor that handles requests
 * that did not match any route
 */
class NotFound implements \PHPixie\Processors\Processor
{
    /**
     * @var \PHPixie\HTTP
     */
    protected $http;

    /**
     * @var \PHPixie\Template
     */
    protected $template;

    /**
     * @var \PHPixie\Slice\Data
     */
    protected $configData;

    /**
     * Constructor
     * @param \PHPixie\HTTP $http
     * @param \PHPixie\Template $template
     * @param \PHPixie\Slice\Data $configData
     */
    public function __construct($http, $template, $configData)
    {
        $this->http       = $http;
        $this->template   = $template;
        $this->configData = $configData;
    }

    /**
     * Build a response for when a uri does not exist
     * @param \PHPixie\HTTP\Request $request
     * @return \PHPixie\HTTP\Responses\Response
     */
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