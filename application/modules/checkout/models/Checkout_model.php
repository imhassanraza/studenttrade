<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	   		//Do your magic here
	}


	public function create_order()
	{
		$my_cart = $this->cart->contents();

		if(empty($this->cart->total_items())) {
			return 0;
		}

		$this->db->set('order_date' , date('Y-m-d H:i:s'));
		$this->db->set('payment_status' , 0);

		if(get_session('discount_code_applied_for_click') == '1') {
			$code_detail = get_session('discount_code_detail');
			$this->db->set('discount_code', $code_detail['code']);
			$this->db->set('code_type', $code_detail['code_type']);
			$this->db->set('is_discount_code_used', 1);
			$this->db->set('code_amount', $code_detail['code_value']);
			$this->db->set('sub_total', $this->cart->total());
		}

		$str = get_session('university');
		$str_con = explode("_", $str);
		@$str_con[0];
		@$str_con[1];

		$other_university = @$str_con[0].'_'.@$str_con[1];
		if (get_session('university') == 'ZHAW') {
			$this->db->set('selected_university', 'ZHAW');
		} else if ($other_university == 'other_university') {

			if(get_session('new_university') == 'other_university_usg'){
				$this->db->set('selected_university', lang('other_university_usg'));
			}else if(get_session('new_university') == 'other_university_kzn'){
				$this->db->set('selected_university', lang('other_university_kzn'));
			}else if(get_session('new_university') == 'other_university_ke'){
				$this->db->set('selected_university', lang('other_university_ke'));
			}else if(get_session('new_university') == 'other_university_kr'){
				$this->db->set('selected_university', lang('other_university_kr'));
			}else if(get_session('new_university') == 'other_university_kw'){
				$this->db->set('selected_university', lang('other_university_kw'));
			}else if(get_session('new_university') == 'other_university_kzu'){
				$this->db->set('selected_university', lang('other_university_kzu'));
			}else if(get_session('new_university') == 'other_university_gbb'){
				$this->db->set('selected_university', lang('other_university_gbb'));
			}else if(get_session('new_university') == 'other_university_kzbs'){
				$this->db->set('selected_university', lang('other_university_kzbs'));
			}else if(get_session('new_university') == 'other_university_ub'){
				$this->db->set('selected_university', lang('other_university_ub'));
			}else if(get_session('new_university') == 'other_university_uba'){
				$this->db->set('selected_university', lang('other_university_uba'));
			}else if(get_session('new_university') == 'other_university'){
				$this->db->set('selected_university', lang('other_university'));
			}
		} else if (!empty(get_session('university'))) {
			$this->db->set('selected_university', get_session('university'));
		}else{
			$this->db->set('selected_university', lang('other_university'));
		}

		$uquery = $this->db->insert('st_orders');

		$order_id = $this->db->insert_id();

		foreach ($my_cart as $book) {

			$this->db->select('*');
			$this->db->where('id', $book['id']);
			$book_detail = $this->db->get('st_books')->row_array();

			$this->db->set('order_id' , $order_id);
			$this->db->set('user_id',$book['options']['user_id']);
			$this->db->set('book_condition',$book['options']['book_condition']);
			$this->db->set('university',$book_detail["university"]);
			$this->db->set('field_of_study',$book_detail["field_of_study"]);
			if(!empty($book_detail["full_time_semester"])) {
				$this->db->set('full_time_semester',$book_detail["full_time_semester"]);
			} else {
				$this->db->set('full_time_semester',NULL);
			}

			if(!empty($book_detail["part_time_semester"])) {
				$this->db->set('part_time_semester',$book_detail["part_time_semester"]);
			} else {
				$this->db->set('part_time_semester',NULL);
			}
			$this->db->set('mandatory_or_optional',$book_detail["mandatory_or_optional"]);
			$this->db->set('module',$book_detail["module"]);
			$this->db->set('price', number_format($book["price"], 0));
			$this->db->set('orignal_price', number_format($book_detail['price'], 0));
			$this->db->set('ISBN',$book_detail["ISBN"]);
			$this->db->set('book_id',$book_detail["id"]);
			$this->db->set('book_name',$book_detail["book_name"]);
			$this->db->set('extra_information',$book_detail["extra_information"]);
			$book_insert = $this->db->insert('st_order_books');

			if($book['options']['user_id'] != 0) {
				$this->db->set('is_orderd', 1);
				$this->db->set('order_id' , $order_id);
				$this->db->where('id', $book['options']['used_book_id']);
				$this->db->where('user_id', $book['options']['user_id']);
				$update_used_books = $this->db->update('st_used_books');
			}
		}

		$this->db->select('user_id');
		$this->db->from("st_order_books");
		$this->db->where('order_id', $order_id);
		$this->db->group_by('user_id');
		$query = $this->db->get();
		$users =  $query->result_array();

		foreach ($users as $user) {

			$margin1 = 0;
			$book_price1 = 0;

			$this->db->select('*');
			$this->db->from("st_order_books");
			$this->db->where('order_id', $order_id);
			$this->db->where('user_id', $user['user_id']);
			$query = $this->db->get();
			$user_books =  $query->result_array();

			foreach ($user_books as $books) {
				if($user['user_id'] == 0) {
					$book_price1 += $books['price'];
					$margin1 += $books['price'];
				} else {
					$half_price = number_format(($books['orignal_price'] * (50/100)),0);
					$book_price1 += $books['price'];
					$margin1 += $books['price'] - $half_price;
				}
			}
			$total_amount =  number_format($book_price1, 0);
			$profit =  number_format($margin1, 0);
			$this->db->set('order_id' , $order_id);
			$this->db->set('user_id' , $user['user_id']);
			$this->db->set('total_amount' , $total_amount);
			$this->db->set('profit' , $profit);
			$this->db->set('date_added' , date('Y-m-d H:i:s'));
			$book_users = $this->db->insert('st_orders_payment');
		}

		return $order_id;

	}

	public function place_order($data)
	{
		$user_id = get_session('user_id');
		$this->db->select('*');
		$this->db->where('email', $data['payer_email']);
		$user_details = $this->db->get('users')->row_array();
		if(empty($user_id)) {
			if(empty($user_details['id'])) {
				$activation_key = uniqid();
				$password = rand(1000, 9999);
				$hash_pass="password('".trim($password)."')";
				$this->db->set('unique_id' , uniqid());
				$this->db->set('email', $data['payer_email']);
				$this->db->set('first_name', $data['first_name']);
				$this->db->set('last_name', $data['last_name']);
				$this->db->set('address1', $data['address1']);
				$this->db->set('city', $data['city']);
				if($data['state'] == 'CH') {
					$this->db->set('state', 'Zurich');
				} else {
					$this->db->set('state', $data['state']);
				}
				$this->db->set('zip', $data['zip_code']);
				$this->db->set('password',$hash_pass, FALSE);
				$this->db->set('activation_key', $activation_key);
				$query = $this->db->insert('users');
				$user_id = $this->db->insert_id();
			} else {
				$user_id = $user_details['id'];
				if(empty($user_details['first_name'])) {
					$this->db->set('first_name', $data['first_name']);
					$this->db->set('last_name', $data['last_name']);
				}
				$this->db->set('address1', $data['address1']);
				$this->db->set('city', $data['city']);
				$this->db->set('state', $data['state']);
				$this->db->set('zip', $data['zip_code']);
				$this->db->where('id',$user_id);
				$up_user = $this->db->update('users');
			}
		} else {
			if(empty($user_details['first_name'])) {
				$this->db->set('first_name', $data['first_name']);
				$this->db->set('last_name', $data['last_name']);
			}
			$this->db->set('address1', $data['address1']);
			$this->db->set('city', $data['city']);
			$this->db->set('state', $data['state']);
			$this->db->set('zip', $data['zip_code']);
			$this->db->where('id',$user_id);
			$up_user = $this->db->update('users');
		}

		$this->db->set('user_id' , $user_id);
		$this->db->set('order_date' , date('Y-m-d H:i:s'));
		$this->db->set('trx_id' , $data['trx_id']);
		$this->db->set('trx_amount' , $data['trx_amount']);
		$this->db->set('payer_email' , $data['payer_email']);
		$this->db->set('payment_status' , 1);
		$this->db->set('shipping_address' , $data['order_address']);
		$this->db->set('trx_response' , json_encode($data['trx_response']));
		$this->db->where('id', $data['reference_id']);
		$uquery = $this->db->update('st_orders');

		$order_id = $data['reference_id'];

		if(!empty(get_session('user_id'))) {
			$response = array('order_id' => $order_id, 'user_account' => 'loggedin');
		} else if(!empty($user_details['id'])) {
			$response = array('order_id' => $order_id, 'user_account' => 'registered','user_details' => $user_details);
		} else {
			$response = array('order_id' => $order_id, 'user_account' => 'new registered','user_id' => $user_id,'activation_key' => $activation_key,'password' => $password);
		}

		return $response;
	}

	public function get_order_sellers($order_id)
	{
		$this->db->distinct();
		$this->db->select('user_id');
		$this->db->from("st_order_books");
		$this->db->where('order_id', $order_id);
		$this->db->where('user_id !=',0);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_order_detail($order_id,$seller_id)
	{
		$this->db->select('*');
		$this->db->from("st_order_books");
		$this->db->where('order_id', $order_id);
		$this->db->where('user_id',$seller_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_discount_code($data)
	{
		$this->db->select('*');
		$this->db->from("discount_codes");
		$this->db->where('code', $data['discount_code']);
		$this->db->where('valid_from <=', date('Y-m-d'));
		$this->db->where('valid_to >=', date('Y-m-d'));
		$query = $this->db->get();
		return $query->row_array();
	}

	public function check_already_used($data)
	{
		$this->db->select('*');
		$this->db->from("st_orders");
		$this->db->where('is_discount_code_used', 1);
		$this->db->where('user_id', get_session('user_id'));
		$this->db->where('discount_code', $data['code']);
		$query = $this->db->get()->num_rows();
		if($query >= 1) {
			return true;
		} else {
			return false;
		}
	}

}

/* End of file Checkout_model.php */
   /* Location: ./application/modules/admin/models/Checkout_model.php */