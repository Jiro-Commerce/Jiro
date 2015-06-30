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
			//$this->beforeBoot(); // TODO: Add events

			$this->initExtensions();

			if ($this->isInstalled())
			{
				$this->bootExtensions();
			}

			//$this->afterBoot(); // TODO: Add events

			$this->booted = true;
		}
		else
		{
			if ( ! $this->app->runningInConsole())
			{
				$this->fire('ineligible', [ $this ]);
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
		if ($this->app->runningInConsole())
		{
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

		return (bool) true; // TODO: change this at a later date to check installed version.
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
	public function initExtensions()
	{
		Extension::setEventDispatcher($this->app['events']);

		Extension::setMigrator($this->app['migrator']);

		Extension::setConnectionResolver($this->app['db']);

		$this->extensionContainer->registerExtensions();
	}	

	/**
	 * 
	 *
	 * @return void
	 */
	public function bootExtensions() {}
}