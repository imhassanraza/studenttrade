<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trade extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		get_site_language();
	}
	public function index()
	{
		$this->load->view('trade');
	}
}