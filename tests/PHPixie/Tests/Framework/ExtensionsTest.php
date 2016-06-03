<?php

namespace PHPixie\Tests\Framework;

/**
 * @coversDefaultClass \PHPixie\Framework\Extensions
 */
class ExtenionsTest extends \PHPixie\Test\Testcase
{
    protected $builder;
    protected $http;
    protected $debug;
    protected $routeTranslator;

    public function setUp()
    {
        $this->builder = $this->quickMock('\PHPixie\Framework\Builder');
        $this->extensions = $this->extensions();

        $this->http = $this->quickMock('\PHPixie\Framework\HTTP');
        $this->method($this->builder, 'http', $this->http, array());

        $this->routeTranslator = $this->quickMock('\PHPixie\Route\Translator');
        $this->method($this->http, 'routeTranslator', $this->routeTranslator, array());
    }

    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {

    }

    /**
     * @covers ::templateExtensions
     * @covers ::<protected>
     */
    public function testTemplateExtensions()
    {
        $components = $this->getComponents();
        $this->method($this->builder, 'components', $components, array(), 0);

        $debug = $this->quickMock('\PHPixie\Debug');
        $this->method($components, 'debug', $debug, array(), 0);

        $extensions = $this->extensions->templateExtensions();

        $this->assertTemplateDebugExtension($extensions[0], $debug);
        $this->assertTemplateRouteExtension($extensions[1]);
    }

    /**
     * @covers ::templateFormats
     * @covers ::<protected>
     */
    public function testTemplateFormats()
    {
        $this->assertSame(array(), $this->extensions->templateFormats());
    }

    /**
     * @covers ::authProviderBuilders
     * @covers ::<protected>
     */
    public function testAuthProviderBuilders()
    {
        $extensions = $this->extensionsMock(array(
            'buildAuthLogin',
            'buildAuthHttp',
            'buildAuthSocial'
        ));

        $authLogin = $this->quickMock('\PHPixie\AuthLogin');
        $this->method($extensions, 'buildAuthLogin', $authLogin, array(), 0);

        $authLoginProviders = $this->quickMock('\PHPixie\AuthLogin\Providers');
        $this->method($authLogin, 'providers', $authLoginProviders, array(), 0);

        $authHttp  = $this->quickMock('\PHPixie\AuthHTTP');
        $this->method($extensions, 'buildAuthHttp', $authHttp, array(), 1);

        $authHttpProviders = $this->quickMock('\PHPixie\AuthHTTP\Providers');
        $this->method($authHttp, 'providers', $authHttpProviders, array(), 0);

        $authSocial  = $this->quickMock('\PHPixie\AuthSocial');
        $this->method($extensions, 'buildAuthSocial', $authSocial, array(), 2);

        $authSocialProviders = $this->quickMock('\PHPixie\AuthSocial\Providers');
        $this->method($authSocial, 'providers', $authSocialProviders, array(), 0);

        $this->assertSame(
            array(
                $authLoginProviders,
                $authHttpProviders,
                $authSocialProviders
            ),
            $extensions->authProviderBuilders()
        );
    }

    /**
     * @covers ::buildAuthLogin
     * @covers ::<protected>
     */
    public function testBuildAuthLogin()
    {
        $components = $this->getComponents();
        $this->method($this->builder, 'components', $components, array(), 0);

        $security = $this->quickMock('\PHPixie\Security');
        $this->method($components, 'security', $security, array(), 0);

        $authLogin = $this->extensions->buildAuthLogin();
        $this->assertInstance($authLogin, '\PHPixie\AuthLogin');
        $this->assertInstance($authLogin->builder(), '\PHPixie\AuthLogin\Builder', array(
            'security'             => $security
        ));
    }

    /**
     * @covers ::buildAuthHttp
     * @covers ::<protected>
     */
    public function testBuildAuthHttp()
    {
        $components = $this->getComponents();
        $this->method($this->builder, 'components', $components, array(), 0);

        $security = $this->quickMock('\PHPixie\Security');
        $this->method($components, 'security', $security, array(), 0);

        $context = $this->quickMock('\PHPixie\Framework\Context');
        $this->method($this->builder, 'context', $context, array(), 1);

        $authHttp = $this->extensions->buildAuthHttp();
        $this->assertInstance($authHttp, '\PHPixie\AuthHttp');
        $this->assertInstance($authHttp->builder(), '\PHPixie\AuthHttp\Builder', array(
            'security'             => $security,
            'httpContextContainer' => $context
        ));
    }

    /**
     * @covers ::buildAuthSocial
     * @covers ::<protected>
     */
    public function testBuildAuthSocial()
    {
        $components = $this->getComponents();
        $this->method($this->builder, 'components', $components, array(), 0);

        $social = $this->quickMock('\PHPixie\Social');
        $this->method($components, 'social', $social, array(), 0);

        $authSocial = $this->extensions->buildAuthSocial();
        $this->assertInstance($authSocial, '\PHPixie\AuthSocial', array(
            'social' => $social
        ));
    }

    protected function assertTemplateDebugExtension($extension, $debug)
    {
        $class = 'PHPixie\Framework\Extensions\Template\Extension\Debug';
        $this->assertInstance($extension, $class, array(
            'debug' => $debug
        ));
    }

    protected function assertTemplateRouteExtension($extension)
    {
        $class = 'PHPixie\Framework\Extensions\Template\Extension\RouteTranslator';
        $this->assertInstance($extension, $class, array(
            'name'            => 'http',
            'routeTranslator' => $this->routeTranslator
        ));
    }

    protected function getComponents()
    {
        return $this->quickMock('\PHPixie\Framework\Components');
    }

    protected function extensions()
    {
        return new \PHPixie\Framework\Extensions($this->builder);
    }

    protected function extensionsMock($methods)
    {
        return $this->quickMock(
            '\PHPixie\Framework\Extensions',
            $methods,
            array($this->builder)
        );
    }
}
