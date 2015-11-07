<?php namespace Jiro\Core\Extension;

use Jiro\Core\Extension\Extension as BaseExtension;
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
     * @return \Jiro\Core\Extension\ExtensionContainer
     */
    public function register($extensionNamespace)
    {
        if (class_exists($extensionNamespace) && is_subclass_of($extensionNamespace, BaseExtension::class)) { 
            $this->items[$extensionNamespace] = new $extensionNamespace; 
        }
        else {
            throw new \InvalidArgumentException('Invalid extension class: ' . $extensionNamespace);
        } 

        return $this; // fluent api
    }     

    /**
     * Registers extensions into the container
     *
     * @return \Jiro\Core\Extension\ExtensionContainer
     */
    public function registerExtensions()
    {
        foreach ($this->config['jiro.extensions'] as $extensionNamespace) {
            $this->register($extensionNamespace);    
        }

        return $this; // fluent api
    }
}