<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Minion_Daemon extends Minion_Task {

	// Property to inform the worker to stop ASAP
	protected $_terminate = FALSE;

	// Will store the received signal for handling in after()
	protected $last_signal;

	// Default to sleeping for 1 second after each iteration
	protected $_iteration_pause = 1000000;

	// Default memory limit for long running processes
	protected $_memory_limit = '256M';

	protected $_options = array(
		// How many minutes to run for
		'run-time' => '60',
	);

	public function __construct()
	{
		parent::__construct();

		// No time limit on minion daemon tasks
		set_time_limit(0);
		// Set the memory limit this worker requires
		ini_set('memory_limit', $this->_memory_limit);

		// Make sure we have handlers for SIGINT and SIGTERM signals
		pcntl_signal(SIGTERM, array($this, 'handle_signals'));
		pcntl_signal(SIGINT, array($this, 'handle_signals'));
	}

	protected function handle_signals($signal)
	{
		// Store the signal we are handling
		$this->last_signal = $signal;

		// We don't want to exit the script prematurely
		switch ($signal) {
			case SIGINT:
			case SIGTERM:
				$this->_terminate = TRUE;
			break;
			default:
				Kohana::$log->add(Log::ERROR, 'Unknown signal :signal', array(
					':signal' => $signal,
				));
				$this->_terminate = TRUE;
		}
	}

	protected function _execute(array $options)
	{
		$start_time = time();
		$end_time = $start_time + (60 * (int) $options['run-time']);

		$this->_before($options);

		while (time() <= $end_time)
		{
			// Let _loop() do its things
			$this->_loop($options);

			if (pcntl_signal_dispatch() AND $this->_terminate)
        		break;

			usleep($this->_iteration_pause);

			// End the process if we received a signal
			if (pcntl_signal_dispatch() AND $this->_terminate)
        		break;
		}

		$this->_after($options);

		// Time to stop the process
		exit(0);
	}

	public function build_validation(Validation $object)
	{
		return parent::build_validation($object)
			->rule('run-time', 'not_empty')
			->rule('run-time', 'digit');
	}

	abstract protected function _loop(array $config);

	protected function _before(array $config) {}
	protected function _after(array $config) {}
}