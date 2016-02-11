<?php

namespace PHPixie\Framework;

use PHPixie\Filesystem\Locators\Locator;
use PHPixie\Filesystem\Root;

/**
 * Assets registry
 */
class Assets
{
    /**
     * @type Components
     */
    protected $components;

    /**
     * @var array
     */
    protected $instances = array();

    /**
     * Constructor
     * @param Components $components
     */
    public function __construct($components)
    {
        $this->components = $components;
    }

    /**
     * Framework assets root directory
     * @return Root
     */
    public function frameworkAssetsRoot()
    {
        return $this->instance('frameworkAssetsRoot');
    }

    /**
     * Filesystem locator for framework templates
     * @return Locator
     */
    public function frameworkTemplateLocator()
    {
        return $this->instance('frameworkTemplateLocator');
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function instance($name)
    {
        if(!array_key_exists($name, $this->instances)) {
            $method = 'build'.ucfirst($name);
            $this->instances[$name] = $this->$method();
        }
        
        return $this->instances[$name];
    }

    /**
     * @return Root
     */
    protected function buildFrameworkAssetsRoot()
    {
        $directory = realpath(__DIR__.'/../../../assets');
        return $this->buildFilesystemRoot($directory);
    }

    /**
     * @param string $directory
     * @return Root
     */
    protected function buildFilesystemRoot($directory)
    {
        $filesystem = $this->components->filesystem();
        return $filesystem->root($directory);
    }

    /**
     * @return Locator
     */
    protected function buildFrameworkTemplateLocator()
    {
        $slice      = $this->components->slice();
        $filesystem = $this->components->filesystem();
        
        $configData = $slice->arrayData(array(
            'type'      => 'directory',
            'directory' => 'template'
        ));
        
        return $filesystem->buildLocator(
            $configData,
            $this->frameworkAssetsRoot()
        );
    }
}