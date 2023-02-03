<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	   		//Do your magic here
	}
	public function get_user_detail()
	{
		$this->db->where('id', get_session('user_id'));
		return $this->db->get('users')->row_array();
	}
}