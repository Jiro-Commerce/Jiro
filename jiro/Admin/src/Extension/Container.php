<?php namespace Jiro\Admin\Extension;

use Jiro\Admin\Extension\Extension as BaseExtension;
use Illuminate\Support\Collection;
use Illuminate\Config\Repository;

/**
 * Extension container
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

class Container extends Collection
{
    /**
     * App Configuration repository
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * Object constructor.
     *
     * @param  \Illuminate\Config\Repository $config
     * @return void
     */
    public function __construct(Repository $config)     	
    {
        $this->config = $config;
    }

    /**
     * Registers an extension into the container
     *
     * @param  String  $extensionNamespace
     * @return \Jiro\Admin\Extension\ExtensionContainer
     */
    public function register($extensionNamespace)
    {
        $extension = new $extensionNamespace;

        if (! is_subclass_of($extension, BaseExtension::class)) {
            throw new \InvalidArgumentException("Invalid type {$extensionNamespace}, extensions must extend ".BaseExtension::class." base class.");
        }

        $this->items[get_class($extension)] = $extension; // register into container

        return $this; // fluent api
    }     

    /**
     * Registers extensions into the container
     *
     * @return \Jiro\Admin\Extension\ExtensionContainer
     */
    public function registerExtensions()
    {
        foreach ($this->config['jiro.extensions'] as $extensionNamespace) {
            $this->register($extensionNamespace);    
        }

        return $this; // fluent api
    }
}