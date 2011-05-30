<?php defined('SYSPATH') or die('No direct script access.');

class Minion_Task_App_Watch extends Minion_Task {

	public function execute(array $config)
	{
		$watch_path = APPPATH.'media/js/app';
		$events = '-e modify -e move -e create -e delete';
		$compile_dir = APPPATH.'media/js/app/compiled/';
		$cmd = 'inotifywait '.$events.' -r -q --format \'%w%f\' @"'.$compile_dir.'" "'.$watch_path.'"';

		// Compile right away
		$this->compile();

		Minion_CLI::write('Watching: '.$watch_path);
		while ($altered = exec($cmd))
		{
			Minion_CLI::write($altered);
			$this->compile();
		}
	}

	protected function compile()
	{
		// Concat all the files
		$files = Kohana::list_files('media/js/app/components');
		$contents = $this->recursive_concat_contents($files, 'js');

		$compile_dir = APPPATH.'media/js/app/compiled/';

		// The components without minification (use in dev environments)
		$concat_path = $compile_dir.'app.components.js';
		// Minified components for production
		$components_path = $compile_dir.'app.components.min.js';
		// For dev environment
		$app_path = APPPATH.'media/js/app/app.js';
		// Minified app for production
		$app_compiled_path = $compile_dir.'app.min.js';

		file_put_contents($concat_path, $contents);
		file_put_contents($components_path, exec('uglifyjs "'.$concat_path.'"'));
		file_put_contents($app_compiled_path, exec('uglifyjs "'.$app_path.'"'));
	}

	protected function recursive_concat_contents(array $files, $ext)
	{
		$content = '';
		foreach ($files as $path)
		{
			if (is_array($path))
			{
				$content .= $this->recursive_concat_contents($path, $ext);
			}
			else
			{
				$extension = pathinfo($path, PATHINFO_EXTENSION);
				if ($extension !== $ext)
					continue;

				$content .= file_get_contents($path);
			}
		}

		return $content;
	}
}