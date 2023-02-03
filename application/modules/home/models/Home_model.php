<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	   		//Do your magic here
	}

	public function get_user_detail($unique_id)
	{
		$this->db->where('unique_id', $unique_id);
		return $this->db->get('users')->row_array();
	}

	public function change_email($data)
	{
		$this->db->set('email2' , NULL);
		$this->db->set('email' , $data['user_detail']['email2']);
		$this->db->where('unique_id' , $data['user_detail']['unique_id']);
		$result = $this->db->update('users');
		return $this->db->affected_rows();
	}

}

/* End of file Home_model.php */
   /* Location: ./application/modules/admin/models/Home_model.php */