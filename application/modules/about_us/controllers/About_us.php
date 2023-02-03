<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About_us extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		get_site_language();
		// $this->load->model('dashboard_model');
	}
	public function index()
	{
		$this->load->view('about_us');
	}
}