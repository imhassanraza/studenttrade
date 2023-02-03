<?php defined('BASEPATH') OR exit('No direct script access allowed');
  
  class Activation_model extends CI_Model {
  
  	public function acctivate_account($activation_key)
	{
		$this->db->set('status', 1);
		$this->db->where('activation_key', $activation_key);
		$query = $this->db->update('users');
        
        $this->db->set('activation_key', null);
        $this->db->where('activation_key', $activation_key);
		$query = $this->db->update('users');

		return $this->db->affected_rows();
	}
	public function set_acctivation_key($data)
	{
		$this->db->set('activation_key', $data['activation_key']);
		$this->db->where('email', $data['email']);
		$this->db->where('activation_key !=',NULL);
		$this->db->where('status',0);
		$query = $this->db->update('users');
		return $this->db->affected_rows();
	}

	public function get_detail($email)
	{
		$this->db->where('email' , $email);
		return $this->db->get('users')->row_array();
	}
	
  }
  
  /* End of file home_model.php */
  /* Location: ./application/modules/home/models/home_model.php */