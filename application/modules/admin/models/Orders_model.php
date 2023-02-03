<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_orders($status)
	{
		$this->db->select("st_orders.*, users.first_name, users.last_name,users.email");
		$this->db->from("st_orders");
		$this->db->join('users', 'st_orders.user_id = users.id', 'left');
		$this->db->where_in('st_orders.status', $status);
		$this->db->where('st_orders.payment_status',1);
		$this->db->order_by('st_orders.id','DESC');
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function get_refunded_orders()
	{
		$this->db->select("st_orders.*, users.first_name, users.last_name,st_orders_payment.amount,st_orders_payment.trx_id as refund_trx_id");
		$this->db->from("st_orders");
		$this->db->join('st_orders_payment', 'st_orders_payment.order_id = st_orders.id', 'left');
		$this->db->join('users', 'st_orders.user_id = users.id', 'left');
		$this->db->where('st_orders_payment.payment_type','refund');
		$this->db->order_by('st_orders.id','DESC');
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function get_new_orders_detail($data)
	{
		$this->db->select("st_orders.*, st_order_books.id as detail_id, st_order_books.user_id as seller_id, st_order_books.university, st_order_books.field_of_study, st_order_books.full_time_semester, st_order_books.part_time_semester, st_order_books.mandatory_or_optional, st_order_books.module, st_order_books.price, st_order_books.ISBN, st_order_books.book_name, st_order_books.extra_information, st_order_books.is_deleted, st_order_books.deleted_reason, users.id as buyer_id, users.first_name, users.last_name, users.paypal_email, users.phone, users.address1, users.address2, users.city, users.state, users.zip, users.amount_tranfer, users.iban_number, users.email");
		$this->db->from("st_orders");
		$this->db->join('users', 'st_orders.user_id = users.id', 'left');
		$this->db->join('st_order_books', 'st_orders.id = st_order_books.order_id', 'left');
		$this->db->where('st_orders.id', $data['id']);
		$query = $this->db->get()->result_array();
		return $query;
	}
	public function get_orders_detail($data)
	{
		$this->db->select("st_orders.*, st_order_books.id as detail_id, st_order_books.user_id as seller_id, st_order_books.university, st_order_books.field_of_study, st_order_books.full_time_semester, st_order_books.part_time_semester, st_order_books.mandatory_or_optional, st_order_books.module, st_order_books.price, st_order_books.ISBN, st_order_books.book_name, st_order_books.extra_information, st_order_books.is_deleted, st_order_books.deleted_reason, users.id as buyer_id, users.first_name, users.last_name, users.paypal_email, users.phone, users.address1, users.address2, users.city, users.state, users.zip, users.amount_tranfer, users.iban_number, users.email");
		$this->db->from("st_orders");
		$this->db->join('users', 'st_orders.user_id = users.id', 'left');
		$this->db->join('st_order_books', 'st_orders.id = st_order_books.order_id', 'left');
		$this->db->where('st_orders.id', $data['id']);
		$this->db->where('st_orders.payment_status',1);
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function update_order_status($data)
	{
		$this->db->set('status', $data['status']);
		$this->db->where('id', $data['id']);
		$result = $this->db->update('st_orders');
		return $this->db->affected_rows();
	}

	public function get_refund_order_detail($data)
	{
		$this->db->select("st_orders.*, users.paypal_email, users.email");
		$this->db->from("st_orders");
		$this->db->join('users', 'st_orders.user_id = users.id');
		$this->db->where('st_orders.id', $data['id']);
		$query = $this->db->get()->row_array();
		return $query;
	}

	public function refund_payment($data)
	{
		$this->db->set('order_id', $data['order_id']);
		$this->db->set('user_id', $data['user_id']);
		$this->db->set('trx_id', $data['trx_id']);
		$this->db->set('total_amount', $data['total_amount']);
		$this->db->set('amount', $data['trx_amount']);
		$this->db->set('payment_type', 'refund');
		$this->db->set('date_added', date('Y-m-d'));
		$query = $this->db->insert('st_orders_payment');
		$refund_id = $this->db->insert_id();
		if ($refund_id > 0) {
			$this->db->set('status', '4');
			$this->db->where('id', $data['order_id']);
			$this->db->update('st_orders');
		}
		return $refund_id;
	}

	public function get_release_order_detail($data)
	{
		$this->db->select("st_orders.*, users.paypal_email, users.email");
		$this->db->from("st_orders");
		$this->db->join('users', 'st_orders.user_id = users.id');
		$this->db->where('st_orders.id', $data['id']);
		$query = $this->db->get()->row_array();
		return $query;
	}

	public function release_payments($data)
	{
		$this->db->set('order_id', $data['order_id']);
		$this->db->set('user_id', $data['user_id']);
		$this->db->set('trx_id', $data['trx_id']);
		$this->db->set('total_amount', $data['total_amount']);
		$this->db->set('amount', $data['trx_amount']);
		$this->db->set('payment_type', 'refund');
		$this->db->set('date_added', date('Y-m-d'));
		$query = $this->db->insert('st_orders_payment');
		$refund_id = $this->db->insert_id();
		if ($refund_id > 0) {
			$this->db->set('status', '4');
			$this->db->where('id', $data['order_id']);
			$this->db->update('st_orders');
		}
		return $refund_id;
	}

	public function delete_books($data)
	{
		$this->db->select("order_id, user_id, price");
		$this->db->from("st_order_books");
		$this->db->where('id', $data['detail_id']);
		$query = $this->db->get();
		$order_detail = $query->row_array();

		$this->db->select("trx_amount");
		$this->db->from("st_orders");
		$this->db->where('id', $order_detail['order_id']);
		$query = $this->db->get();
		$order = $query->row_array();

		$this->db->select("total_amount, profit");
		$this->db->from("st_orders_payment");
		$this->db->where('order_id', $order_detail['order_id']);
		$this->db->where('user_id', $order_detail['user_id']);
		$query = $this->db->get();
		$payment = $query->row_array();

		$trx_amount = number_format($order['trx_amount'] - $order_detail['price'], 0);
		$this->db->set('trx_amount', $trx_amount);
		$this->db->where('id', $order_detail['order_id']);
		$result = $this->db->update('st_orders');

		$total_amount = number_format($payment['total_amount'] - $order_detail['price'], 0);
		$margin = number_format($order_detail['price'] * (10/100), 0);
		$profit = number_format($payment['profit'] - $margin, 0);
		$this->db->set('profit', $profit);
		$this->db->set('total_amount', $total_amount);
		$this->db->where('order_id', $order_detail['order_id']);
		$this->db->where('user_id', $order_detail['user_id']);
		$result = $this->db->update('st_orders_payment');

		$this->db->set('is_deleted',1);
		$this->db->set('deleted_reason', $data['deleted_reason']);
		$this->db->where('id', $data['detail_id']);
		$result = $this->db->update('st_order_books');

		$this->db->select('order_id');
		$this->db->from("st_order_books");
		$this->db->where('order_id', $order_detail['order_id']);
		$this->db->where('is_deleted', 0);
		$query = $this->db->get();
		$order_count = $query->num_rows();

		if ($order_count == 0) {
			$this->db->set('status', 5);
			$this->db->where('id', $order_detail['order_id']);
			$result = $this->db->update('st_orders');
		}
		return true;
	}


	public function get_export_orders($status)
	{
		$this->db->select("st_orders.*, users.first_name, users.last_name, users.email");
		$this->db->from("st_orders");
		$this->db->join('users', 'st_orders.user_id = users.id', 'left');
		$this->db->where_in('st_orders.status', $status);
		$this->db->where('st_orders.payment_status',1);
		$this->db->order_by('st_orders.id','ASC');
		$query = $this->db->get();
		return $query->result();
	}

}