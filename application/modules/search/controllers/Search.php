<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('search_model');
		get_site_language();
	}

	public function index()
	{
		$this->load->view('search');
	}

	public function get_search_result()
	{
		$book_name = $this->input->post('book_name');
		$data['books'] = $this->search_model->get_search_result($book_name);
		$response = $this->load->view('search_result_ajax', $data, TRUE);
		$finalResult = array('msg' => 'success', 'response'=>$response);
		echo json_encode($finalResult);
		exit;
	}

	public function get_search_books_for_sell()
	{
		unset_session('sell_session_multi');
		$data = $_POST;
		set_session('sell_session_new', get_session('sell_session'));
		if(get_session('redirect_login')) {
			$data['selected_books'] = $this->search_model->get_selected_books1();
			$data['books'] = $this->search_model->get_search_books_for_sell1(@$data['book_name']);
			set_session('sell_session', get_session('sell_session'));
			unset_session('redirect_login');
		}else{
			$data['selected_books'] = $this->search_model->get_selected_books($data);
			$data['books'] = $this->search_model->get_search_books_for_sell(@$data['book_name'], @$data['sell_books']);
			set_session('sell_session', @$data['sell_books']);
		}
		if (get_session('university') == 'ZHAW') {
			unset_session('optional_module_books');
			$zhaw_books = $this->search_model->get_books_serach_field();
			$book_ids = array();
			foreach ($zhaw_books as $value) {
				$book_ids[] = $value['id'];
			}
			set_session('optional_module_books', $book_ids);
		}
		set_session('sell_session_multi', @$data['sell_books']);
		$response = $this->load->view('search_sell_books_ajax', $data, TRUE);
		$finalResult = array('msg' => 'success', 'response'=>$response);
		echo json_encode($finalResult);
		exit;
	}
}