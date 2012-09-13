<?php defined('SYSPATH') or die('No direct script access.');

class View_Page_Main_Views extends Abstract_View_Page {

	protected $_partials = array(
		'welcome' => 'partial/welcome'
	);

	/**
	 * Any public property in this class is accessible from the template
	 */

	public $example_property = 'example property value';

	/**
	 * Any public method in this class is also accessible from the template
	 */
	public function associative_data_array()
	{
		return array(
			'one'   => 'a1',
			'two'   => 'a2',
			'three' => 'a3',
		);
	}

	public function numeric_data_array()
	{
		return array(
			array(
				'one'   => 'a1-1',
				'two'   => 'a1-2',
				'three' => 'a1-3',
			),
			array(
				'one'   => 'a2-1',
				'two'   => 'a2-2',
				'three' => 'a2-3',
			),
			array(
				'one'   => 'a3-1',
				'two'   => 'a3-2',
				'three' => 'a3-3',
			),
		);
	}

	public function sub_view()
	{
		return Kostache::factory('widget/example');
	}
}