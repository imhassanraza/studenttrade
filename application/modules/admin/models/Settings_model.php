<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	   		//Do your magic here
	}
	public function get_all_settings($page,$meta_key)
	{
		$this->db->where('page' , $page);
		$this->db->where('meta_key' , $meta_key);
		$query = $this->db->get('settings');
		return $query->row_array();
	}
}

/* End of file user_model.php */
   /* Location: ./application/modules/admin/models/user_model.php */