<?php namespace Jiro\Product\Console;

use Illuminate\Console\Command;
use Jiro\Support\Migration\MigrationCreator;
use Jiro\Support\Migration\Migrator;

class InstallCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'jiro:product:install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Install the product package';	

	/**
	 * The path to the migration files.
	 *
	 * @var string
	 */
	protected $migrationsDir = __DIR__ . '/../../database/migrations';

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$this->showWelcomeMessage();

		$this->migrate();

		$this->askMigrationsFileInstalltion();
	}

	/**
	 * Shows the welcome message.
	 *
	 * @return void
	 */
	protected function showWelcomeMessage()
	{
		$this->output->writeln(<<<WELCOME
<fg=white>
*-----------------------------------------------*
|                                               |
|       Welcome to the Jiro Installer           |
|                                               |
*-----------------------------------------------*
</fg=white>
WELCOME
		);
	}	

	/**
	 * Asks if installation of migration file is required
	 *
	 * @return string
	 */
	protected function askMigrationsFileInstalltion()
	{
		// Ask mesage
		$message = '<fg=green>Would you like to create a migrations file?</fg=green>';

		if ($this->confirm($message))
		{
			$this->createMigrationsFile();

			$this->info('Product migrations created successfully!');
		}
	}	

	/**
	 * Create and move the migration files to app directory
	 *
	 * @return void
	 */
	public function createMigrationsFile()
	{	
		$destination = $this->laravel['path.database'].'/migrations';

		$migrationCreator = new MigrationCreator($this->migrationsDir, $destination);

		$migrationCreator->createMigrations();
	}

	/**
	 * run package database migrations
	 *
	 * @return void
	 */
	public function migrate()
	{ 
		(new Migrator)->migrateDirectory( $this->migrationsDir );
	}	

}
