<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main extends Abstract_Controller_Page {

	public function action_index() {}

	public function action_yform() {}

	public function action_views()
	{
		// We can send any data to views with the set() or bind() methods
		$this->_view
			->set('name', 'Lorenzo')
			->set('username', 'zeelot')
			->bind('valid', $valid);

		// Bound values can be set at any point
		$valid = TRUE;
	}
}
