<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	   		//Do your magic here
	}

	public function get_users($status = '1')
	{
		$this->db->where('status' , $status);
		$this->db->where('is_deleted' ,0);
		$result = $this->db->get('users')->result_array();
		return $result;
	}

	public function get_deleted_users()
	{
		$this->db->where('is_deleted' ,1);
		$result = $this->db->get('users')->result_array();
		return $result;
	}

	public function insert_user($data)
	{
		$hash_pass="password('".trim($data['password'])."')";
		$this->db->set('first_name', $data['first_name']);
		$this->db->set('last_name', $data['last_name']);
		$this->db->set('email', $data['email']);
		$this->db->set('password',$hash_pass, FALSE);
		$this->db->set('gender', $data['gender']);
		$this->db->set('phone', $data['phone']);
		$this->db->set('address1', $data['address1']);
		$this->db->set('address2', $data['address2']);
		$this->db->set('city', $data['city']);
		$this->db->set('state', $data['state']);
		$this->db->set('zip', $data['zip']);
		if(empty($data['amount_transfer'])) {
			$this->db->set('paypal_email', $data['paypal_email']);
			if(!empty($data['iban_number'])) {
				$this->db->set('iban_number', $data['iban_number']);
			}
			$this->db->set('amount_tranfer', 0);
		} else {
			$this->db->set('iban_number', $data['iban_number']);
			if(!empty($data['paypal_email'])) {
				$this->db->set('paypal_email', $data['paypal_email']);
			}
			$this->db->set('amount_tranfer', 1);
		}

		$query = $this->db->insert('users');
		if ($this->db->insert_id() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function update_user($data)
	{
		$this->db->set('first_name', $data['first_name']);
		$this->db->set('last_name', $data['last_name']);
		$this->db->set('gender', $data['gender']);
		$this->db->set('phone', $data['phone']);
		$this->db->set('address1', $data['address1']);
		$this->db->set('address2', $data['address2']);
		$this->db->set('city', $data['city']);
		$this->db->set('state', $data['state']);
		$this->db->set('zip', $data['zip']);
		if(empty($data['amount_tranfer'])) {
			$this->db->set('paypal_email', $data['paypal_email']);
			if(!empty($data['iban_number'])) {
				$this->db->set('iban_number', $data['iban_number']);
			}
			$this->db->set('amount_tranfer', 0);
		} else {
			$this->db->set('iban_number', $data['iban_number']);
			if(!empty($data['paypal_email'])) {
				$this->db->set('paypal_email', $data['paypal_email']);
			}
			$this->db->set('amount_tranfer', 1);
		}
		$this->db->where('id', $data['user_id']);
		$query = $this->db->update('users');
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function inactive_status($user_id)
	{
		$this->db->set('status', 0);
		$this->db->where('id', $user_id);
		$result = $this->db->update('users');
		return $this->db->affected_rows();
	}
	public function active_status($user_id)
	{
		$this->db->set('status', 1);
		$this->db->where('id', $user_id);
		$result = $this->db->update('users');
		return $this->db->affected_rows();
	}

	public function get_user_detail($user_id)
	{
		$this->db->where('id', $user_id);
		$result = $this->db->get('users')->row_array();
		return $result;
	}

	public function add_banned($user_id)
	{
		$this->db->where('is_orderd',0);
		$this->db->where('user_id', $user_id);
		$query = $this->db->delete('st_used_books');

		$this->db->set('is_banned',1);
		$this->db->where('id', $user_id);
		$query = $this->db->update('users');

		return $this->db->affected_rows();
	}

	public function restore_user($user_id)
	{
		$this->db->set('is_deleted',0);
		$this->db->where('id', $user_id);
		$query = $this->db->update('users');
		return $this->db->affected_rows();
	}
	public function delete_user($user_id)
	{
		$this->db->set('is_deleted',1);
		$this->db->where('id', $user_id);
		$query = $this->db->update('users');
		return $this->db->affected_rows();
	}
	public function user_permanent_delete($user_id)
	{
		$this->db->where('id', $user_id);
		$query = $this->db->delete('users');
		return $this->db->affected_rows();
	}

	public function remove_banned($user_id)
	{
		$this->db->set('is_banned',0);
		$this->db->where('id', $user_id);
		$query = $this->db->update('users');

		return $this->db->affected_rows();
	}

	public function get_user_profile($user_id)
	{
		$this->db->where('id', $user_id);
		$query = $this->db->get('users');
		return $query->row_array();
	}


	public function get_user_orders($user_id)
	{
		$this->db->select("*");
		$this->db->from("st_orders");
		$this->db->where('user_id', $user_id);
		$this->db->order_by('id','DESC');
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function check_old_phoneno($data)
	{
		$this->db->select('*');
		$this->db->where('phone', $data['phone']);
		$this->db->where('id !=', $data['user_id']);
		$query = $this->db->get('users');
		return $query->num_rows();
	}

	public function get_users_excel(){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('is_deleted' ,0);
		$query = $this->db->get();
		return $query->result();
	}

}

/* End of file user_model.php */
   /* Location: ./application/modules/admin/models/user_model.php */