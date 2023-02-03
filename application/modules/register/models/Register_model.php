<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	   		//Do your magic here
	}

	public function check_email($email)
	{
		$this->db->where('email' , $email);
		$record = $this->db->get('users')->result_array();
		return count($record);
	}

	public function check_phone_no($phone_no)
	{
		$this->db->where('phone', $phone_no);
		$record = $this->db->get('users')->result_array();
		return count($record);
	}

	public function insert_user($data)
	{
		$hash_pass="password('".trim($data['password'])."')";

		$this->db->set('unique_id' , uniqid());
		$this->db->set('email', $data['email']);
		$this->db->set('phone', $data['phone_no']);
		$this->db->set('password',$hash_pass, FALSE);
		$this->db->set('activation_key', $data['activation_key']);
		$query = $this->db->insert('users');
		$insertdId = $this->db->insert_id();

		if($insertdId > 0){
			return $insertdId;
		}
		else{
			return false;
		}
	}

}

/* End of file Home_model.php */
   /* Location: ./application/modules/admin/models/Home_model.php */