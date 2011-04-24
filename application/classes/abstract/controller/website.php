<?php defined('SYSPATH') or die('No direct script access.');

abstract class Abstract_Controller_Website extends Controller {

	/**
	 * @var object the content View object
	 */
	public $view;

	public function before()
	{
		// Set default title and content views (path only)
		$directory = $this->request->directory();
		$controller = $this->request->controller();
		$action = $this->request->action();

		// Removes leading slash if this is not a subdirectory controller
		$controller_path = trim($directory.'/'.$controller.'/'.$action, '/');

		try
		{
			$this->view = Kostache::factory('page/'.$controller_path);
		}
		catch (Kohana_View_Exception $x)
		{
			/*
			 * The View class could not be found, so the controller action is
			 * repsonsible for making sure this is resolved.
			 */
			$this->view = NULL;
		}
	}

	/**
	 * Assigns the title to the template.
	 *
	 * @param   string   request method
	 * @return  void
	 */
	public function after()
	{
		// If content is NULL, then there is no View to render
		if ($this->view === NULL)
			throw new Kohana_View_Exception('There was no View created for this request.');

		$this->response->body($this->view);
	}

	/**
	 * Returns true if the post has a valid CSRF
	 * 
	 * @return  bool
	 */
	public function valid_post()
	{
		if (Request::post_max_size_exceeded())
		{
			Notices::add('error', __('Max filesize of :max exceeded.', array(':max' => ini_get('post_max_size').'B')));
			return FALSE;
		}

		$has_csrf = isset($_POST['csrf-token']);

		$valid_csrf = $has_csrf 
			? CSRF::valid($_POST['csrf-token'])
			: FALSE;

		if ($has_csrf AND ! $valid_csrf)
		{
			Notices::add('error', __('This form has expired. Please try submitting it again.'));
			return FALSE;
		}

		return $has_csrf AND $valid_csrf;
	}
}
