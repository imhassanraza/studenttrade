<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_jobs extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function refresh_orders()
	{
		$this->db->select('*');
		$this->db->from('st_orders');
		$this->db->where('payment_status',0);
		$this->db->where('order_date <=', date('Y-m-d H:i:s', strtotime('-1 hour')));
		$orders = $this->db->get()->result_array();

		if(count($orders) > 0) {

			foreach ($orders as $order) {

				$this->db->select('user_id,book_id');
				$this->db->from('st_order_books');
				$this->db->where('book_condition',1);
				$this->db->where('order_id',$order['id']);
				$order_books = $this->db->get()->result_array();

				foreach ($order_books as $book) {
					$this->db->set('is_orderd', 0);
					$this->db->set('order_id', NULL);
					$this->db->where('order_id',$order['id']);
					$this->db->where('user_id',$book['user_id']);
					$this->db->where('book_id',$book['book_id']);
					$this->db->update('st_used_books');
				}

				$this->db->set('is_cron_deleted',1);
				$this->db->where('order_id',$order['id']);
				$this->db->update('st_order_books');

				$this->db->set('is_deleted',1);
				$this->db->where('id',$order['id']);
				$this->db->update('st_orders');

			}

		}

	}

}