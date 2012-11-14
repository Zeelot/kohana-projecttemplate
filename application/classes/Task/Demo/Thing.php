<?php defined('SYSPATH') or die('No direct script access.');

class Task_Demo_Thing extends Minion_Task {

	protected function _execute(array $options)
	{
		Kohana::$log->add(Log::INFO, 'Hey there! This is the :class class!', array(
			':class' => __CLASS__,
		));
		Kohana::$log->add(Log::ERROR, 'Hey there! This is the :class class!', array(
			':class' => __CLASS__,
		));
	}
}