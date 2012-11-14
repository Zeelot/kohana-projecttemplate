<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * STDERR log writer. Writes out messages to STDERR.
 *
 * @package    Kohana
 * @category   Logging
 * @author     Kohana Team
 * @copyright  (c) 2008-2012 Kohana Team
 * @license    http://kohanaphp.com/license
 */
class Log_StdErr extends Kohana_Log_StdErr {

	protected static $_foreground_colors = array(
		Log::EMERGENCY => 'red',
		Log::ALERT     => 'red',
		Log::CRITICAL  => 'red',
		Log::ERROR     => 'red',
		Log::WARNING   => 'red',
		Log::NOTICE    => 'yellow',
		Log::INFO      => 'green',
		Log::DEBUG     => 'blue',
	);

	protected static $_background_colors = array(
		Log::EMERGENCY => 'black',
		Log::ALERT     => 'black',
		Log::CRITICAL  => 'black',
		Log::ERROR     => 'black',
		Log::WARNING   => 'black',
		Log::NOTICE    => 'black',
		Log::INFO      => 'black',
		Log::DEBUG     => 'black',
	);

	/**
	 * Writes each of the messages to STDERR.
	 *
	 *     $writer->write($messages);
	 *
	 * @param   array   $messages
	 * @return  void
	 */
	public function write(array $messages)
	{
		foreach ($messages as $message)
		{
			$formatted = $this->format_message($message);
			$foreground = Log_StdErr::$_foreground_colors[$message['level']];
			$background = Log_StdErr::$_background_colors[$message['level']];
			$colored = Minion_CLI::color($formatted, $foreground, $background);

			// Writes out each message
			fwrite(STDOUT, $colored.PHP_EOL);
		}
	}

} // End Kohana_Log_StdErr
