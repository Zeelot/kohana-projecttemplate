<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'loggers' => array(
		'File' => array(
			'enabled'   => TRUE,
			'class'     => 'Log_File',
			'params'    => array(APPPATH.'logs'),
			'levels'    => array(),
			'min_level' => 0,
		),
		'StdOut' => array(
			'enabled'   => PHP_SAPI === 'cli', // Only enable this when in CLI
			'class'     => 'Log_StdOut',
			'params'    => array(),
			'levels'    => Log::DEBUG,
			'min_level' => Log::NOTICE,
		),
		'StdErr' => array(
			'enabled'   => PHP_SAPI === 'cli', // Only enable this when in CLI
			'class'     => 'Log_StdErr',
			'params'    => array(),
			'levels'    => Log::WARNING,
			'min_level' => 0,
		),
	),
);