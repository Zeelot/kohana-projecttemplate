<?php defined('SYSPATH') or die('No direct script access.');

return array
(
	'default-template' => array
	(
		array('style', Media::url('css/compiled/styles.css'), 'head'),
		array('script', Media::url('lib/vendor/require-2.1.1.js'), 'body'),
	),
);