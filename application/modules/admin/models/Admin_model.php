<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	   		//Do your magic here
	}

	public function change_admin_password($data)
	{
		$hash_pass="password('".$data['new_password']."')";
		$this->db->set('password',$hash_pass, FALSE);
		$this->db->where('userid', $this->session->userdata('admin_id'));
		$result = $this->db->update('admin_users');
		return $this->db->affected_rows();
	}
	public function check_old_password($data)
	{
		$hash_pass="password('".$data['old_password']."')";
		$this->db->select('*');
		$this->db->where('password',$hash_pass,FALSE);
		$this->db->where('userid', $this->session->userdata('admin_id'));
		$query = $this->db->get('admin_users');
		return $query->num_rows();
	}
}

/* End of file admin_model.php */
   /* Location: ./application/modules/admin/models/admin_model.php */