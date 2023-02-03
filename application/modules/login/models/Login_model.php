<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

	public function get_login($email,$password)
	{
		$hash_pass="password('".$password."')";	
		$this->db->select('*');
		$this->db->where('email',$email);
		$this->db->where('password',$hash_pass, FALSE);				
		$query=$this->db->get('users');	
		return $query->row();	
	}

	public function checkUser($data = array()){
		$this->db->select('id');
		$this->db->from('users');
		$this->db->where(array('oauth_provider'=>$data['oauth_provider'],'oauth_uid'=>$data['oauth_uid']));
		$this->db->or_where('email',$data['email']);
		$prevQuery = $this->db->get();
		$prevCheck = $prevQuery->num_rows();

		if($prevCheck > 0){
			$prevResult = $prevQuery->row_array();
			$update = $this->db->update('users',$data,array('id'=>$prevResult['id']));
			$userID = $prevResult['id'];
		}else{
			$insert = $this->db->insert('users',$data);
			$userID = $this->db->insert_id();
		}

		return $userID?$userID:FALSE;
	}

}

/* End of file home_model.php */
  /* Location: ./application/modules/home/models/home_model.php */