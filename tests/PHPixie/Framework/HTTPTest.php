<?php

namespace PHPixie\Tests\Framework;

/**
 * @coversDefaultClass \PHPixie\Framework\HTTP
 */
class HTTPTest extends \PHPixie\Test\Testcase
{
    protected $builder;
    protected $configData;
    
    protected $http;
    
    protected $context;
    protected $processors;
    protected $httpContext;
    
    protected $componentNames = array(
        'http'           => '\PHPixie\HTTP',
        'httpProcessors' => '\PHPixie\HTTPProcessors',
        'processors',
        'route'
    );
    
    protected $configuration = array();
    protected $components = array();
    
    protected $processorPrefixes = array(
        'processors'          => '\PHPixie\Processors\Processor\\',
        'httpProcessors'      => '\PHPixie\HTTPProcessors\Processor\\',
        'frameworkProcessors' => '\PHPixie\Framework\Processors\\',
    );
    
    protected $at;
    
    public function setUp()
    {
        $this->builder    = $this->quickMock('\PHPixie\Framework\Builder');
        $this->configData = $this->quickMock('\PHPixie\Slice\Data');
        
        $this->http = new \PHPixie\Framework\HTTP(
            $this->builder,
            $this->configData
        );
        
        $components = $this->quickMock('\PHPixie\Framework\Components');
        $this->method($this->builder, 'components', $components, array());
        
        $configuration = $this->quickMock('\PHPixie\Framework\Configuration');
        $this->method($this->builder, 'configuration', $configuration, array());
        
        $this->processors = $this->quickMock('\PHPixie\Framework\Processors');
        $this->method($this->builder, 'processors', $this->processors, array());
        
        $this->context = $this->quickMock('\PHPixie\Framework\Context');
        $this->method($this->builder, 'context', $this->context, array());
        
        $this->httpContext = $this->quickMock('\PHPixie\HTTP\Context');
        $this->method($this->context, 'httpContext', $this->httpContext, array());
        
        
        $this->at = new \SplObjectStorage();
        
        foreach($this->componentNames as $name => $class) {
            if(is_numeric($name)) {
                $name  = $class;
                $class = '\PHPixie\\'.ucfirst($name);
            }
            $this->components[$name] = $this->quickMock($class);
            $this->method($components, $name, $this->components[$name], array());
            $this->at[$this->components[$name]] = 0;
        }
        
        $this->configuration = array(
            'httpProcessor' => $this->quickMock('\PHPixie\Processors\Dispatcher'),
            'routeResolver'  => $this->quickMock('\PHPixie\Route\Resolvers\Resolver'),
        );
        
        foreach($this->configuration as $key => $value) {
            $this->method($configuration, $key, $value, array());
            $this->at[$value] = 0;
        }
        
        $this->at[$this->configData] = 0;
        $this->at[$this->processors] = 0;
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
    
    }
    
    /**
     * @covers ::processor
     * @covers ::<protected>
     */
    public function testProcessor()
    {
        $processor = $this->prepareBuildProcessor();
        for($i=0; $i<2; $i++) {
            $this->assertSame($processor, $this->http->processor());
        }
    }
    
    /**
     * @covers ::routeTranslator
     * @covers ::<protected>
     */
    public function testRouteTranslator()
    {
        $translator = $this->prepareRouteTranslator();
        for($i=0; $i<2; $i++) {
            $this->assertSame($translator, $this->http->routeTranslator());
        }
    }
    
    /**
     * @covers ::processServerRequest
     * @covers ::<protected>
     */
    public function testProcessServerRequest()
    {
        $serverRequest = $this->getServerRequest();
        $response = $this->prepareProcessServerRequest($serverRequest);
        
        $this->assertSame($response, $this->http->processServerRequest($serverRequest));
    }
    
    /**
     * @covers ::processSapiRequest
     * @covers ::<protected>
     */
    public function testProcessSapiRequest()
    {
        $serverRequest = $this->getServerRequest();
        
        $http = $this->components['http'];
        
        $this->method(
            $http,
            'sapiServerRequest',
            $serverRequest,
            array(),
            $this->at[$http]
        );
        $this->at[$http] = $this->at[$http]+1;
        
        $response = $this->prepareProcessServerRequest($serverRequest);
        
        $this->method(
            $http,
            'output',
            null,
            array($response, $this->httpContext),
            $this->at[$http]
        );
        $this->at[$http] = $this->at[$http]+1;
        
        $this->http->processSapiRequest();
    }
    
    protected function prepareProcessServerRequest($serverRequest)
    {
        $response  = $this->quickMock('\PHPixie\HTTP\Responses\Response');
        
        $processor = $this->prepareBuildProcessor();
        $this->method($processor, 'process', $response, array($serverRequest), 0);
        
        return $response;
    }
    
    protected function prepareBuildProcessor()
    {
        return $this->prepareProcessor('processors', 'catchException', array(
            $this->prepareProcessor('processors', 'chain', array(array(
                $this->prepareRequestProcessor(),
                $this->prepareProcessor('processors', 'checkIsProcessable', array(
                    $this->configuration['httpProcessor'],
                    $this->prepareDispatchProcessor(),
                    $this->prepareNotFoundProcessor()
                ))
            ))),
            $this->prepareExceptionProcessor()
        ));
    }
    
    protected function prepareRequestProcessor()
    {
        return $this->prepareProcessor('processors', 'chain', array(array(
            $this->prepareProcessor('httpProcessors', 'parseBody', array()),
            $this->prepareParseRouteProcessor(),
            $this->prepareProcessor('httpProcessors', 'updateContext', array(
                $this->context
            )),
            $this->prepareProcessor('httpProcessors', 'buildRequest', array()),
        )));
    }
    
    protected function prepareParseRouteProcessor()
    {
        $translator = $this->prepareRouteTranslator();
        
        return $this->prepareProcessor(
            'frameworkProcessors',
            'httpParseRoute',
            array($translator),
            'HTTP\ParseRoute'
        );
    }
    
    protected function prepareRouteTranslator()
    {
        $translator = $this->quickMock('\PHPixie\Route\Translator');
        
        $config = $this->prepareConfig('route');
        $this->method(
            $this->components['route'],
            'translator',
            $translator,
            array(
                $config,
                $this->configuration['routeResolver'],
                $this->context,
            ),
            0
        );
        
        return $translator;
    }
    
    protected function prepareDispatchProcessor()
    {
        return $this->prepareProcessor('processors', 'chain', array(array(
            $this->configuration['httpProcessor'],
            $this->prepareProcessor(
                'frameworkProcessors',
                'httpNormalizeResponse',
                array(),
                'HTTP\Response\Normalize'
            )
        )));
    }
    
    protected function prepareExceptionProcessor()
    {
        $config = $this->prepareConfig('exceptionResponse');
        return $this->prepareProcessor(
            'frameworkProcessors',
            'httpExceptionResponse',
            array($config),
            'HTTP\Response\Exception'
        );
    }
    
    protected function prepareNotFoundProcessor()
    {
        $config = $this->prepareConfig('notFoundResponse');
        return $this->prepareProcessor(
            'frameworkProcessors',
            'httpNotFoundResponse',
            array($config),
            'HTTP\Response\NotFound'
        );
    }
    
    protected function prepareProcessor($processorsName, $name, $parameters, $class = null)
    {
        if($processorsName === 'frameworkProcessors') {
            $processors = $this->processors;
        }else{
            $processors = $this->components[$processorsName];
        }
        
        if($class === null) {
            $class = ucfirst($name);
        }
        
        $class = $this->processorPrefixes[$processorsName].$class;
        
        $processor = $this->quickMock($class);
        $this->method(
            $processors,
            $name,
            $processor,
            $parameters,
            $this->at[$processors]
        );
        
        $this->at[$processors] = $this->at[$processors]+1;
        return $processor;
    }
    
    protected function prepareConfig($key)
    {
        $slice = $this->quickMock('\PHPixie\Slice\Data');
        $this->method(
            $this->configData,
            'slice',
            $slice,
            array($key),
            $this->at[$this->configData]
        );
        
        $this->at[$this->configData] = $this->at[$this->configData]+1;
        
        return $slice;
    }
    
    protected function getServerRequest()
    {
        return $this->quickMock('\Psr\Http\Message\ServerRequestInterface');
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}