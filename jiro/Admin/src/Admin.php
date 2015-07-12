<?php namespace Jiro\Admin;

use Illuminate\Container\Container as AppContainer;
use Jiro\Admin\Extension\Container as ExtensionContainer;
use Jiro\Admin\Extension\Extension;

/**
 * Admin Package
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

class Admin 
{
	/**
	 * Laravel instance.
	 *
	 * @var \Illuminate\Container\Container
	 */
	protected $app;

	/**
	 * Extension Container
	 *
	 * @var \Jiro\Admin\Extension\Container
	 */
	protected $extensionContainer;

	/**
	 * An array of whitelisted URIs only valid for uninstalled cases
	 *
	 * @var array
	 */
	protected $routeWhitelist = [];		

	/**
	 * The has booted flag.
	 *
	 * @var bool
	 */
	protected $booted = false;

	/**
	 * Object Constructor.
	 *
	 * @param  \Illuminate\Container\Container  $app
	 * @param  \Jiro\Extension\Container  $extensionBag
	 * @return void
	 */
	public function __construct(AppContainer $app, ExtensionContainer $extensionContainer)
	{
		$this->app = $app;

		$this->extensionContainer = $extensionContainer;
	}
	/**
	 * Boots admin and its requirements.
	 *
	 * @return void
	 */
	public function boot()
	{ 
		// Check enviroment and running eligibility
		if ($this->canBoot())
		{ 
			$this->beforeBoot(); 

			if ($this->isInstalled())
			{ 
				$this->bootExtensions(); 
			}

			$this->afterBoot();

			$this->booted = true;
		}
		else
		{ 
			if ( ! $this->app->runningInConsole())
			{ 
				$this->fire('cannotBoot', [ $this ]);
			} 
		}
	}

	/**
	 * Checks for web enviroment, installation and other needed parameters.
	 *
	 * @return bool
	 * @throws \Symfony\Component\HttpKernel\Exception\HttpException
	 */
	public function canBoot()
	{ 
		// If we're running in console ok, although disallow if in test enviroment
		if ($this->app->runningInConsole()) {
			return ! $this->isTestingEnviroment();
		}

		if ($this->isInstalled())
		{
			// Check database connectivity
			try
			{
				$this->app['db']->connection();

				return true;
			}
			catch (PDOException $e)
			{
				throw new HttpException(503, 'Database connection could not be established.');
			}
		} 
		else 
		{ 
			// Check if the path is contained in the route whitelist
			return in_array($this->app['request']->path(), $this->getRouteWhitelist());			
		}
	}	

	/**
	 * Returns installation status
	 *
	 * @return bool
	 */
	public function isInstalled()
	{
		// Always return true for the testing environment.
		if ($this->isTestingEnviroment())
		{
			return true;
		}

		return true; // TODO :: installation will be defined by extensions returning isInstalled() == true. (lets spoof that for now)
	}	

	/**
	 * Returns flag on testing enviroment
	 *
	 * @return bool
	 */
	public function isTestingEnviroment()
	{
		return $this->app->runningInConsole() && $this->app->environment() === 'testing';
	}	

	/**
	 * Initializes admin extensions.
	 *
	 * @return void
	 */
	public function bootExtensions()
	{
		Extension::setEventDispatcher($this->app['events']);

		Extension::setMigrator($this->app['migrator']);

		Extension::setConnectionResolver($this->app['db']);

		$this->extensionContainer->registerExtensions();
	}	

	/**
	 * Adds an item to the routes whitelist.
	 *
	 * @param  string  $uri
	 * @return void
	 */
	public function addRouteWhitelist($uri)
	{
		$this->routeWhitelist[] = $uri;
	}

	/**
	 * Returns the whitelisted routes.
	 *
	 * @return array
	 */
	public function getRouteWhitelist()
	{
		return $this->routeWhitelist;
	}		

	/**
	 * Listens to the passed event
	 *
	 * @param  string  $name
	 * @param  \Closure  $callback
	 * @return void
	 */
	protected function listen($name, Closure $callback)
	{
		$this->app['events']->listen('jiro.'.$name, $callback);
	}

	/**
	 * Fires passed given event
	 *
	 * @param  string  $name
	 * @param  mixed  $params
	 * @return void
	 */
	protected function fire($name, $params)
	{
		$this->app['events']->fire('jiro.'.$name, $params);
	}	

	/**
	 * Fires the 'jiro.booted' event.
	 *
	 * @return void
	 */
	public function beforeBoot()
	{
		$this->fire('booting', [ $this ]);
	}

	/**
	 * Fires the 'jiro.booted' event.
	 *
	 * @return void
	 */
	public function afterBoot()
	{
		$this->fire('booted', [ $this ]);
	}	

	/**
	 * Registers "jiro.cannotBoot" callback
	 *
	 * @param  \Closure  $callback
	 * @return void
	 */
	public function cannotBoot(Closure $callback)
	{
		$this->listen('cannotBoot', $callback);
	}

	/**
	 * Registers "jiro.booting" callback
	 *
	 * @param  \Closure  $callback
	 * @return void
	 */
	public function booting(Closure $callback)
	{
		$this->listen('booting', $callback);
	}

	/**
	 * Registers "jiro.booted" callback
	 *
	 * @param  \Closure  $callback
	 * @return void
	 */
	public function booted(Closure $callback)
	{
		$this->listen('booted', $callback);
	}			
}