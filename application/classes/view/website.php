<?php defined('SYSPATH') or die('No direct script access.');

abstract class View_Website extends View_Layout {

	public function i18n()
	{
		return function($string)
		{
			return __($string);
		};
	}

	public function title()
	{
		$class = get_class($this);
		$title = str_replace('_', ' ', substr($class, 5));

		return $this->title = __($title);
	}

	public function notices()
	{
		return Notices::display();
	}

	public function profiler()
	{
		return View::factory('profiler/stats');
	}

	public function assets_head()
	{
		$assets = '';
		foreach (Assets::get('head') as $asset)
		{
			$assets .= $asset."\n";
		}

		return $assets;
	}

	public function assets_body()
	{
		$assets = '';
		foreach (Assets::get('body') as $asset)
		{
			$assets .= $asset;
		}

		return $assets;
	}

	public function render($template = null, $view = null, $partials = null)
	{
		$content = parent::render($template, $view, $partials);

		return str_replace(array
		(
			'[[assets_head]]',
			'[[assets_body]]'
		), array
		(
			$this->assets_head(),
			$this->assets_body()
		), $content);
	}
}
