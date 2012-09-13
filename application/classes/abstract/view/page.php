<?php defined('SYSPATH') or die('No direct script access.');

abstract class Abstract_View_Page extends Abstract_View_Layout {

	/**
	 * The page title
	 * @var string
	 */
	protected $_title = NULL;

	public function assets($assets)
	{
		$assets->group('default-template');
		return parent::assets($assets);
	}

	public function main_navigation()
	{
		$nav = array();
		$actions = get_class_methods('Controller_Main');

		foreach ($actions as $action)
		{
			if (substr($action, 0, 7) === 'action_')
			{
				$action = substr($action, 7);
				$nav[] = array(
					'url' => Route::url('default', array(
						'controller' => 'main',
						'action'     => $action,
					)),
					'text' => $action === 'index'
						? 'home'
						: str_replace('_', ' ', $action),
				);
			}
		}

		return $nav;
	}

	/**
	 * Array of data to be sent to the JS application. This method is used by
	 * js_export() so it can be extended and the array of data to be exported
	 * can be altered. Don't forget to call parent::js_array()!
	 *
	 * @return array The array of data to be sent to JS applications
	 */
	public function js_array()
	{
		return array(
			'base_url'    => URL::base(),
			'environment' => Kohana::$environment_string,
			'media_url'   => Media::url('/'),
		);
	}

	/**
	 * Returns a JSON string to be used in the page header. This is useful
	 * when we want to send arrays of data from Kohana to the JS application.
	 *
	 * @return string JSON string
	 */
	public function js_export()
	{
		return json_encode($this->js_array());
	}

	public function site_name()
	{
		return array(
			'title' => 'Project Template',
			'url'   => URL::site(''),
		);
	}

	public function title()
	{
		return $this->_title;
	}

	public function profiler()
	{
		return View::factory('profiler/stats');
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
			$this->_assets_head(),
			$this->_assets_body()
		), $content);
	}

	protected function _assets_head()
	{
		if ( ! $this->_assets)
			return '';

		$assets = '';
		foreach ($this->_assets->get('head') as $asset)
		{
			$assets .= $asset."\n";
		}

		return $assets;
	}

	protected function _assets_body()
	{
		if ( ! $this->_assets)
			return '';

		$assets = '';
		foreach ($this->_assets->get('body') as $asset)
		{
			$assets .= $asset;
		}

		return $assets;
	}
}
