<?php defined('SYSPATH') or die('No direct script access.');

class Task_Demo_LongThing extends Minion_Daemon {

	protected function _loop(array $config)
	{
		// Add some random sleepyness
		usleep(rand(0, 10) * 100000);
		Minion_Task::factory(array('demo:thing'))->execute();
	}
}