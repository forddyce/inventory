<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ModuleCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'module:make {module}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Make a module';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$module = $this->argument('module');

		if ($module == '') {
			$this->error('Parameter empty!');
			return false;
		}

		$this->generateModel($module);
		$this->generateRepository($module);
		$this->generateController($module);

		$this->info('Module generated!');
	}

	public function generateModel($module) {
		$moduleName = ucwords($module);
		$path = app_path() . '/Models/' . $moduleName . '.php';

		try {
			$contents = \File::get(app_path() . '/Boilerplate/Model.php');
		}
		catch (Illuminate\Filesystem\FileNotFoundException $exception) {
			$this->error('Cannot generate Model file !');
		}

		$content = str_replace('Sample', $moduleName, $contents);
		\File::put($path, $content);

		$this->info('Model generated!');

		\Artisan::call('make:migration', ['name' => 'create_' . $moduleName . '_table']);

		$this->info('Migration generated!');
	}

	public function generateRepository($module) {
		$moduleName = ucwords($module);
		$path = app_path() . '/Repositories/' . $moduleName . 'Repository.php';

		try {
			$contents = \File::get(app_path() . '/Boilerplate/Repository.php');
		}
		catch (Illuminate\Filesystem\FileNotFoundException $exception) {
			$this->error('Cannot generate Repository file !');
		}

		$content = str_replace('Sample', $moduleName, $contents);
		\File::put($path, $content);

		$this->info('Repository generated!');
	}

	public function generateController($module) {
		$moduleName = ucwords($module);
		$path = app_path() . '/Http/Controllers/' . $moduleName . 'Controller.php';

		try {
			$contents = \File::get(app_path() . '/Boilerplate/Controller.php');
		}
		catch (Illuminate\Filesystem\FileNotFoundException $exception) {
			$this->error('Cannot generate Controller file !');
		}

		$content = str_replace('Sample', $moduleName, $contents);
		\File::put($path, $content);

		$this->info('Controller generated!');
	}
}
