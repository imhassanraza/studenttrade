<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('home_model');
		get_site_language();
	}
	public function index()
	{
		$this->load->view('home');
	}

	public function insert_used_book_ids()
	{
		$used_books = $this->db->get("st_used_books")->result_array();

		foreach ($used_books as $used_book) {

			if(empty($used_book['book_id'])) {

				$this->db->set('is_orderd' , 0);
				$this->db->set('order_id' , 0);
				$this->db->where('id' , $used_book['id']);
				$this->db->update('st_used_books');
				echo "else ".$used_book['id']."<br>";

			} else {

				$this->db->select('*');
				$this->db->where('book_id' , $used_book['book_id']);
				$this->db->where('user_id' , $used_book['user_id']);
				$order_book = $this->db->get('st_order_books')->row_array();

				if(!empty($order_book['id'])) {

					$this->db->set('is_orderd' , 1);
					$this->db->set('order_id' , $order_book['order_id']);
					$this->db->where('book_id' , $used_book['book_id']);
					$this->db->where('user_id' , $used_book['user_id']);
					$this->db->update('st_used_books');
					echo "if ".$order_book['id']."<br>";

				} else {
					$this->db->set('is_orderd' , 0);
					$this->db->where('book_id' , $used_book['book_id']);
					$this->db->where('user_id' , $used_book['user_id']);
					$this->db->update('st_used_books');
					echo "else ".$used_book['id']."<br>";
				}

			}

		}
	}

	public function insert_book_ids()
	{
		$orders = $this->db->get("st_order_books")->result_array();

		foreach ($orders as $order) {

			$this->db->select('id');
			$this->db->where('university' , $order['university']);
			$this->db->where('field_of_study' , $order['field_of_study']);
			$this->db->where('module' , $order['module']);
			$this->db->where('book_name' , $order['book_name']);
			$this->db->where('ISBN' , $order['ISBN']);
			$book = $this->db->get('st_books')->row_array();

			if(!empty($book['id'])) {

				$this->db->set('book_id_new' , $book['id']);
				$this->db->where('id' , $order['id']);
				$this->db->update('st_order_books');
				echo "book id ".$book['id']."<br>";

			} else {
				$this->db->set('book_id_new' , NULL);
				$this->db->where('id' , $order['id']);
				$this->db->update('st_order_books');
				echo "book id NULL.<br>";
			}
		}
	}

	public function update_used_books_old()
	{
		$used_books = $this->db->get("st_used_books")->result_array();

		foreach ($used_books as $used_book) {

			$this->db->select('id');
			$this->db->like('book_name' , $used_book['book_name']);
			$book = $this->db->get('st_books')->row_array();

			if(!empty($book['id'])) {
				$this->db->set('book_id', $book['id']);
				$this->db->where('user_id' , $used_book['user_id']);
				$this->db->where('id' , $used_book['id']);
				$this->db->update('st_used_books');
				echo "ordered ".$book['id'].", ".$used_book['user_id']."<br>";
			} else {
				$this->db->set('book_id', NULL);
				$this->db->where('user_id' , $used_book['user_id']);
				$this->db->where('id' , $used_book['id']);
				$this->db->update('st_used_books');
				echo $used_book['book_name']."<br>";
			}
		}
	}


	public function update_used_books()
	{
		$used_books = $this->db->get("st_used_books")->result_array();

		foreach ($used_books as $used_book) {

			$this->db->select('book_id');
			$this->db->where('user_id' , $used_book['user_id']);
			$this->db->where('book_name' , $used_book['book_name']);
			$book = $this->db->get('st_order_books')->row_array();

			if(!empty($book['book_id'])) {
				$this->db->set('book_id', $book['book_id']);
				$this->db->set('is_orderd', 1);
				$this->db->where('user_id' , $used_book['user_id']);
				$this->db->where('id' , $used_book['id']);
				$this->db->update('st_used_books');
				echo "ordered ".$book['book_id'].", ".$used_book['user_id']."<br>";
			}

		}
	}


	public function insert_missing_used_books()
	{
		$orders = $this->db->get("st_order_books")->result_array();

		foreach ($orders as $order) {

			if($order['user_id'] == 0) {
				continue;
			}

			$this->db->select('id');
			$this->db->where('book_name' , $order['book_name']);
			$this->db->where('user_id' , $order['user_id']);
			$book = $this->db->get('st_used_books')->row_array();

			if(empty($book['id'])) {
				$this->db->set('book_id' , $order['book_id']);
				$this->db->set('book_name' , $order['book_name']);
				$this->db->set('book_condition' , 1);
				$this->db->set('user_id' , $order['user_id']);
				$this->db->set('is_orderd' , 1);
				$this->db->set('order_id' , $order['order_id']);
				$this->db->insert('st_used_books');
				echo "book id ".$order['book_id'].", ".$order['user_id']."<br>";
			}

		}
	}

	public function change_email($unique_id = '')
	{

		$data['user_detail'] = $this->home_model->get_user_detail(trim($unique_id));

		if (empty($data['user_detail'])) {
			show_404();
		}

		if (empty($data['user_detail']['email2'])) {
			show_404();
		}

		$status = $this->home_model->change_email($data);

		if($status > 0){

			if($this->session->userdata('user_logged_in'))
			{
				set_session('email' , $data['user_detail']['email2']);
				$this->session->set_flashdata('activation_success_status' , lang('email_changed'));
				redirect(base_url().'user/settings');
			} else {
				$this->session->set_flashdata('activation_success_status' , lang('email_changed'));
				redirect(base_url().'login');
			}

		} else {
			$this->session->set_flashdata('activation_error_status' , lang('something_went_wrong'));
			redirect(base_url());
		}

	}
}