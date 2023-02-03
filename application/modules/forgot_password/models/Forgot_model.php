<?php defined('BASEPATH') OR exit('No direct script access allowed');
  
  class Forgot_model extends CI_Model {
  
  	public function get_user($email)
	{
		$this->db->select('*');
		$this->db->where('email',$email);		
		$query=$this->db->get('users');	
		return $query->row();	
	}	
	public function check_email($email)
	{
		$this->db->select('*');
		$this->db->where('email',$email);
		$query = $this->db->get('users');
		return $query->num_rows();
	}

	public function set_uniquekey($email, $forgot_pass_key)
	{
		$this->db->set('password',md5(uniqid()));	
		$this->db->set('forgot_pass_key',$forgot_pass_key);	
		$this->db->where('email',$email);	
		$query=$this->db->update('users');	
		return $this->db->affected_rows();
	}

	public function set_new_password($data)
	{
		$hash_pass="password('".trim($data['password'])."')";		 
		
		$this->db->set('password',$hash_pass, FALSE);
		$this->db->set('forgot_pass_key', NULL);
		$this->db->where('forgot_pass_key',$data['forgot_pass_key']);	
		$this->db->where('email',$data['email']);	
		$query = $this->db->update('users');

		return $this->db->affected_rows();
	}
  }
  /* End of file home_model.php */
  /* Location: ./application/modules/home/models/home_model.php */