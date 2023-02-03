<?php 
class Login_model extends CI_Model
{
	
	public function get_login($email,$password)
	{
		$hash_pass="password('".$password."')";	
		$this->db->select('userid');
		$this->db->select('username');
		$this->db->select('email');
		$this->db->where('email',$email);		
		$this->db->where('password',$hash_pass, FALSE);		
		$query=$this->db->get('admin_users');	
		return $query->row();	
	}
	public function check_email($email)
	{
		$this->db->select('*');
		$this->db->where('email',$email);
		$query = $this->db->get('admin_users');
		return $query->num_rows();
	}

	public function set_admin_password($email, $new_password)
	{
		$hash_pass="password('".$new_password."')";
		$this->db->set('password',$hash_pass, FALSE);	
		$this->db->where('email',$email);		
		$query=$this->db->update('admin_users');	
		return $this->db->affected_rows();
	}		
}

?>