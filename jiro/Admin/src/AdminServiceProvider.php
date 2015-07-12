<?php namespace Jiro\Admin;

use Jiro\Admin\Admin;
use Jiro\Admin\Extension\Container;
use Jiro\Admin\Extension\Extensible;
use Jiro\Admin\Extension\Extension;
use Illuminate\Support\ServiceProvider;

/**
 * Admin package service provider.
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

class AdminServiceProvider extends ServiceProvider 
{
	/**
	 * {@inheritDoc}
	 */
	public function boot()
	{ 
		// Now lets boot the admin.
		$this->app['jiro.admin']->boot();
	}

	/**
	 * {@inheritDoc}
	 */
	public function register()
	{  
		$this->registerExtensions();

		$this->registerExtensionContainer();

		$this->registerAdminPackage();
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
	 * Register Admin package.
	 *
	 * @return void
	 */
	protected function registerAdminPackage()
	{ 
		$this->app->singleton('jiro.admin', function($app)
		{
			return new Admin($app, $app['jiro.extensions']);
		});	

		$this->app->alias('jiro.admin', Admin::class); // bind the alias to the class
	}	
}
