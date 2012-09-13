<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main extends Abstract_Controller_Page {

	public function action_index() {}

	public function action_yform()
	{
		$this->_view->bind('values', $_POST);
	}
}
