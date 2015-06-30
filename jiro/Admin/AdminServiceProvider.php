<?php namespace Jiro\Admin;

use Illuminate\Support\ServiceProvider;
use Jiro\Admin\Extension\Container as ExtensionContainer;
use Jiro\Admin\Extension\FileFinder;

/**
 * Admin package service provider.
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

class AdminServiceProvider extends ServiceProvider {

	/**
	 * {@inheritDoc}
	 */
	public function boot()
	{
		// Now lets boot the admin.
		$this->app['admin']->boot();
	}

	/**
	 * {@inheritDoc}
	 */
	public function register()
	{ 
		$this->registerExtensionsFinder();

		$this->registerExtensions();

		$this->registerAdminPackage();
	}	

	/**
	 * Register Admin package.
	 *
	 * @return void
	 */
	protected function registerAdminPackage()
	{
		$this->app['admin'] = $this->app->share(function($app)
		{ 
			return new Admin($app, $app['extensions']);
		});	
	}

    /**
     * Register Extension finder.
     *
     * @return void
     */
    protected function registerExtensionsFinder()
    {
        $this->app['extensions.finder'] = $this->app->share(function ($app) {
            
            $paths = $app['config']->get('jiro.paths');

            $paths[] = base_path() . '/jiro'; // TODO: remove this line after 0.1.0 break extensions/packages into repositories

            $exclude = [base_path() . '/jiro/Admin/Extension/Extension.php']; // TODO: remove this line after 0.1.0 break extensions/packages into repositories

            return new FileFinder($app['files'], $paths, $exclude);
        });
    }	

	/**
	 * Register Extensions.
	 *
	 * @return void
	 */
	protected function registerExtensions()
	{
		$this->app['extensions'] = $this->app->share(function($app)
		{ 
			return new ExtensionContainer($app['files'], $app['extensions.finder'], $app, [], $app['cache']);
		});	
	}	
}
