<?php namespace Jiro\Admin\Extension;

use Illuminate\Cache\CacheManager;
use Illuminate\Support\Collection;
use Illuminate\Container\Container as AppContainer;
use Illuminate\Filesystem\Filesystem;

/**
 * Admin Package
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

class Container extends Collection
{
    /**
     * Extensions Finder instance
     *
     * @var \Jiro\Admin\Extension\FinderInterface
     */
    protected $finder;

    /**
     * Filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * IoC container instance.
     *
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * Object constructor.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $filesystem
     * @param  \Jiro\Admin\Extension\FinderInterface  $finder
     * @param  \Illuminate\Container\Container  $container
     * @param  Array  $extensions
     * @return void
     */
    public function __construct(Filesystem $filesystem, FinderInterface $finder, AppContainer $container = null, array $extensions = array(), CacheManager $cache = null)     	
    {
        $this->filesystem = $filesystem;

        $this->finder = $finder;

        $this->container = $container;

        foreach ($extensions as $extension) {
            $this->register($extension);
        }

        $this->cache = $cache;
    }

    /**
     * Registers an extension into the container
     *
     * @param  Mixed  $extension
     * @return \Jiro\Admin\Extension\ExtensionContainer
     */
    public function register($extension)
    {
        if (is_string($extension)) {
            $extension = $this->create($extension);
        }

        $extension->register();

        $this->items[$extension->getSlug()] = $extension;

        return $this; // fluent api
    }     

    /**
     * Searches & Registers extensions into the container
     *
     * @return void
     */
    public function registerExtensions()
    {
        foreach ($this->finder->findExtensions() as $extension) {

            $this->register($extension);
        }

        return $this; // fluent api
    }

    /**
     * Creates extension from the given absolute extension file path.
     *
     * @param  string  $file
     * @return \Jiro\Admin\Extension\ExtensionInterface
     * @throws \RuntimeException
     */
    public function create($file)
    {
        $attributes = $this->filesystem->getRequire($file);

        if ( ! is_array($attributes) || ! isset($attributes['slug'])) {
            throw new \RuntimeException("Malformed extension.php at path [{$file}].");
        }

        $slug = $attributes['slug'];

        unset($attributes['slug']);

        $namespace = null;

        if (isset($attributes['namespace'])) {
            $namespace = $attributes['namespace'];

            unset($attributes['namespace']);
        }

        return new Extension($this, $slug, dirname($file), $attributes, $namespace, $this->cache);
    }    
}