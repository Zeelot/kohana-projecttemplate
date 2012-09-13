<?php defined('SYSPATH') or die('No direct script access.');

class View_Page_Main_Yform extends Abstract_View_Page
{
	public $values;

	public function form()
	{
		$yf = YForm::factory()
			->add_values((array)$this->_values)
			->add_messages('errors', array
			(
				'checkboxes' => 'some error',
				'radios' => 'another error',
			));

		return array
		(
			array('element' => $yf->open($this->_request->uri())),
			array('element' => $yf->text('text')),
			array('element' => $yf->checkboxGroup('checkboxes')
				->add_options(array('one' => 'hello', 'two' => 'world'))),
			
			array('element' => $yf->radioGroup('radios')
				->add_options(array('one' => 'hello', 'two' => 'world'))),
			array('element' => $yf->submit('submit')),
			array('element' => $yf->close()),
		);
	}
}
