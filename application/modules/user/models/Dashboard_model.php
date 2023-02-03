<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

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

	public function get_orders($status)
	{
		$this->db->select("*");
		$this->db->from("st_orders");
		$this->db->where('user_id' ,get_session('user_id'));
		$this->db->where_in('status' ,$status);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function get_refunded_orders($status)
	{
		$this->db->select("st_orders.*, st_orders_payment.amount as amount_refund, st_orders_payment.trx_id as refund_trx_id");
		$this->db->from("st_orders");
		$this->db->join('st_orders_payment', 'st_orders_payment.order_id = st_orders.id', 'left');
		$this->db->where('st_orders.user_id' ,get_session('user_id'));
		$this->db->where('st_orders_payment.payment_type','refund');
		$this->db->where_in('st_orders.status' ,$status);
		$this->db->order_by('id','DESC');
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function get_seller_order_old($status)
	{
		$this->db->select("st_orders.*, SUM(st_order_books.price) as total_price");
		$this->db->from("st_order_books");
		$this->db->join('st_orders', 'st_orders.id = st_order_books.order_id', 'left');
		$this->db->where_in('st_orders.status' ,$status);
		$this->db->where('st_order_books.user_id', get_session('user_id'));
		$this->db->group_by('st_order_books.order_id');
		$this->db->group_by('st_order_books.user_id');
		$this->db->order_by('st_orders.id', 'DESC');
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function get_seller_order($status)
	{
		$this->db->select("st_orders.*, (st_orders_payment.total_amount - st_orders_payment.profit) as total_price");
		$this->db->from("st_orders");
		$this->db->join('st_orders_payment', 'st_orders.id = st_orders_payment.order_id', 'left');
		$this->db->where_in('st_orders.status' ,$status);
		$this->db->where('st_orders_payment.user_id', get_session('user_id'));
		$this->db->order_by('st_orders.id', 'DESC');
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function get_active_buyer_orders_detail($data)
	{
		$this->db->select("o.*, b.id as detail_id, b.user_id as seller_id, b.university, b.field_of_study, b.full_time_semester, b.part_time_semester, b.mandatory_or_optional, b.module, b.price, b.ISBN, b.book_name, b.book_id, b.extra_information, b.is_deleted, b.deleted_reason");
		$this->db->from("st_orders as o");
		$this->db->join('st_order_books as b', 'o.id = b.order_id', 'left');
		$this->db->where('o.user_id' ,get_session('user_id'));
		$this->db->where('o.id', $data['id']);
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function get_active_seller_orders_detail($data)
	{
		$this->db->select("o.*, b.id as detail_id, b.user_id as seller_id, b.orignal_price, b.university, b.field_of_study, b.full_time_semester, b.part_time_semester, b.mandatory_or_optional, b.module, b.price, b.ISBN, b.book_name, b.book_id, b.extra_information, b.is_deleted, b.deleted_reason");
		$this->db->from("st_orders as o");
		$this->db->join('st_order_books as b', 'o.id = b.order_id', 'left');
		$this->db->where('b.user_id' ,get_session('user_id'));
		$this->db->where('o.id', $data['id']);
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function get_books()
	{
		$this->db->select("st_books.*, st_used_books.id as b_id, st_used_books.book_id as used_book_id, st_used_books.book_condition, st_used_books.is_orderd");
		$this->db->from("st_used_books");
		$this->db->join('st_books', 'st_books.id = st_used_books.book_id', 'left');
		// $this->db->join('st_books as st_b', 'st_b.book_name = st_used_books.book_name', 'left');
		$this->db->where('st_used_books.user_id', get_session('user_id'));
		$this->db->where('st_books.price !=', 0);
		$this->db->where('st_used_books.book_id !=', NULL);
		$this->db->order_by('st_used_books.id', 'DESC');
		$query = $this->db->get()->result_array();
		// echo $this->db->last_query(); exit;
		return $query;
	}

	public function get_order_books()
	{
		$this->db->select('module,book_name,orignal_price');
		$this->db->from('st_order_books');
		$this->db->where('user_id', get_session('user_id'));
		$this->db->where('book_id', NULL);
		return $this->db->get()->result_array();
	}

	public function delete_books($data)
	{
		$this->db->where('id', $data['id']);
		$this->db->where('is_orderd', '0');
		$this->db->delete('st_used_books');
		return $this->db->affected_rows();
	}


	public function update_details($data)
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

		$this->db->set('profile_updated', 1);
		$this->db->where('id', get_session('user_id'));
		$query = $this->db->update('users');
		return true;
	}

	public function update_profile_dp($data)
	{
		$this->db->set('profile_dp', $data['profile_dp']);
		$this->db->where('id',get_session('user_id'));
		$query = $this->db->update('users');
		if($this->db->affected_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}

	public function check_old_password($data)
	{
		$hash_pass="password('".$data['old_password']."')";
		$this->db->select('*');
		$this->db->where('password',$hash_pass,FALSE);
		$this->db->where('id', $this->session->userdata('user_id'));
		$query = $this->db->get('users');
		return $query->num_rows();
	}

	public function change_email($data)
	{
		$this->db->set('email2',$data['email']);
		$this->db->where('id', $this->session->userdata('user_id'));
		$result = $this->db->update('users');
		return $this->db->affected_rows();
	}

	public function update_password($data)
	{
		$hash_pass="password('".$data['password']."')";
		$this->db->set('password',$hash_pass, FALSE);
		$this->db->where('id', $this->session->userdata('user_id'));
		$result = $this->db->update('users');
		return $this->db->affected_rows();
	}

	public function add_user_books_to_market($data)
	{
		$this->db->trans_begin();
		$check = 0;

		$books = array_unique($data['user_sell_books']);

		foreach ($books as $key => $value) {
			$book = get_books_detail($value);
			$this->db->set('book_id', $value);
			$this->db->set('book_name', $book['book_name']);
			$this->db->set('book_condition' ,'1');
			$this->db->set('user_id', get_session('user_id'));
			$query = $this->db->insert('st_used_books');
			$check = 1;
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		} else {
			$this->db->trans_commit();

			if($check) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function check_old_phoneno($data)
	{
		$this->db->select('*');
		$this->db->where('phone', $data['phone']);
		$this->db->where('id !=', $this->session->userdata('user_id'));
		$query = $this->db->get('users');
		return $query->num_rows();
	}

}