<?php namespace Jiro\Core;

use Jiro\Core\Core;
use Jiro\Core\Extension\Container;
use Jiro\Core\Extension\Extensible;
use Jiro\Core\Extension\Extension;
use Illuminate\Support\ServiceProvider;

/**
 * Core package service provider.
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

class CoreServiceProvider extends ServiceProvider 
{
	/**
	 * {@inheritDoc}
	 */
	public function boot()
	{ 
		// Lets boot the core.
		$this->app['jiro.core']->boot();
	}

	/**
	 * {@inheritDoc}
	 */
	public function register()
	{
		$this->registerExtensions();

		$this->registerExtensionContainer();

		$this->registerCorePackage();
	}	

	/**
	 * Register Extension Class.
	 *
	 * @return void
	 */
	protected function registerExtensions()
	{
		$this->app->bind(Extensible::class, Extension::class);
	}		

	/**
	 * Register Extensions Container.
	 *
	 * @return void
	 */
	protected function registerExtensionContainer()
	{
		$this->app->singleton('jiro.extensions', function($app)
		{   
			return new Container($this->app['config']);
		});	

		$this->app->alias('jiro.extensions', Container::class); // bind the alias to the class
	}	

	/**
	 * Register Core package.
	 *
	 * @return void
	 */
	protected function registerCorePackage()
	{ 
		$this->app->singleton('jiro.core', function($app)
		{
			return new Core($app, $app['jiro.extensions']);
		});	

		$this->app->alias('jiro.core', Core::class); // bind the alias to the class
	}	
}
