<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Thank_you extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		get_site_language();
	}

	public function index()
	{
		redirect(base_url());
	}
}