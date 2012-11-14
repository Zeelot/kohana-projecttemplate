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

	/**
	 * Provides a method for more complex page title logic. By default, this
	 * methods simply returns the `$_title` property, so you can set that in
	 * your View if it's a simple string.
	 *
	 * @return mixed   The page title
	 */
	public function title()
	{
		return $this->_title;
	}

	/**
	 * Renders the Kohana profiler.
	 *
	 * @return string  The profiler output
	 */
	public function profiler()
	{
		return View::factory('profiler/stats');
	}

	/**
	 * Renders the view but also replaces the special assets blocks with assets
	 * from the `Assets` class.
	 */
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

	public function media_base_path()
	{
		return Media::url('/');
	}

	/**
	 * Returns a JSON string to be used in the page header. This is useful
	 * when we want to send arrays of data from Kohana to the JS application.
	 *
	 * @return string JSON string
	 */
	public function js_export()
	{
		return json_encode($this->_js_array());
	}

	/**
	 * Array of data to be sent to the JS application. This method is used by
	 * js_export() so it can be extended and the array of data to be exported
	 * can be altered. Don't forget to call parent::js_array()!
	 *
	 * @return array The array of data to be sent to JS applications
	 */
	protected function _js_array()
	{
		return array(
			'base_url'    => URL::base(),
			'environment' => Kohana::$environment_string,
			'media_url'   => Media::url('/'),
		);
	}

	/**
	 * Returns the assets that will be replaced in the head of the document.
	 *
	 * @return string    The assets tags
	 */
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

	/**
	 * Returns the assets that will be replaced in the body of the document.
	 *
	 * @return string    The assets tags
	 */
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
