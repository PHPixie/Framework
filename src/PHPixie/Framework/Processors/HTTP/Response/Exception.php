<?php

namespace PHPixie\Framework\Processors\HTTP\Response;

/**
 * Processor that handles exception responses
 */
class Exception implements \PHPixie\Processors\Processor
{
    /**
     * @var \PHPixie\Debug
     */
    protected $debug;

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
     * @param \PHPixie\Debug $debug
     * @param \PHPixie\HTTP $http
     * @param \PHPixie\Template $template
     * @param \PHPixie\Slice\Data $configData
     */
    public function __construct($debug, $http, $template, $configData)
    {
        $this->debug      = $debug;
        $this->http       = $http;
        $this->template   = $template;
        $this->configData = $configData;
    }

    /**
     * Builds a response for an exception
     * @param \Exception $exception
     * @return \PHPixie\HTTP\Responses\Response
     */
    public function process($exception)
    {
        $templateName = $this->configData->getRequired('template');
        $trace = $this->debug->exceptionTrace($exception);
        
        $body = $this->template->render(
            $templateName,
            array(
                'exception' => $exception,
                'trace'     => $trace,
                'logger'    => $this->debug->logger()
            )
        );
        
        return $this->http->responses()->response($body, array(), 500);
    }
}