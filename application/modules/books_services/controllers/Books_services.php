<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Books_services extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('app_model');
		get_site_language();
	}

	public function find()
	{
		$finalResult = array();
		$final_books = array();
		$identifiers = $this->security->xss_clean($_GET['identifiers']);
		$university = $this->security->xss_clean($_GET['university']);

		if(empty($university)) {
			$finalResult = array('success' => 0, 'result' => "University is required.");
			echo json_encode($finalResult);
			exit;
		}

		$university_status = $this->app_model->is_valid_university($university);
		if(!($university_status > 0)) {
			$finalResult = array('success' => 0, 'result' => "Invalid university.");
			echo json_encode($finalResult);
			exit;
		}

		if (!empty($identifiers)) {

			$identifiers = explode(',', $identifiers);
			$final_books = array();
			foreach ($identifiers as $identifier)
			{

				$uni =  $this->app_model->get_university($identifier);
				if (empty($uni)) {
					continue;
				}

				$result = $this->app_model->get_books($identifier,$university);

				if(empty($result)) {
					continue;
				} else {

					$f_books = array();

					for ($i = 0; $i < count($result); $i++) {
						$used_book = get_used_book_detail($result[$i]['title']);
						if(($result[$i]['only_used'] == 1) && (empty($used_book))) {
							continue;
						} else if(($result[$i]['only_used'] == 1) && (!empty($used_book))) {
							$new_prince = number_format($result[$i]['priceInFrancs'] * (60/100), 0);
							$result[$i]['priceInFrancs'] = $new_prince;
						}
						unset($result[$i]['only_used']);
						$f_books[] = $result[$i];
					}

					$identifier = array(
						'id' => $identifier,
						'university' => $uni['university'],
						'books' => $f_books
					);
					$final_books[] = $identifier;

				}

				// $identifier = array(
				// 	'id' => $identifier,
				// 	'university' => $uni['university'],
				// 	'books' => $result
				// );
				// $final_books[] = $identifier;
			}
			// echo "<pre>";
			// print_r($final_books);
			// exit();
			if (!empty($final_books))
			{
				$finalResult = array('success' => 1, 'courses' => $final_books);
			}else{
				$finalResult = array('success' => 0, 'result' => $final_books);
			}
		} else {
			$finalResult = array('success' => 0, 'result' => $final_books);
		}
		echo json_encode($finalResult);
		exit;
	}

	public function buy()
	{
		unset_session('buy_session_optional_module');
		$identifiers = $this->security->xss_clean($_GET['identifiers']);
		$university = $this->security->xss_clean($_GET['university']);

		if(empty($university)) {
			$finalResult = array('success' => 0, 'result' => "University is required.");
			echo json_encode($finalResult);
			exit;
		}

		$university_status = $this->app_model->is_valid_university($university);
		if(!($university_status > 0)) {
			$finalResult = array('success' => 0, 'result' => "Invalid university.");
			echo json_encode($finalResult);
			exit;
		}

		if (!empty($identifiers)) {
			$data['books'] = $this->app_model->get_books_by_identifier($identifiers,$university);
			$selected_modules = $this->app_model->get_selected_modules($identifiers,$university);
			$data['modules'] = $this->app_model->get_modules($university);
			foreach ($data['books'] as $book) {
				if($book['price'] > 0) {
					if($book['mandatory_or_optional'] == '0' && !(in_cart($book['id']))) {
						$this->add_mandatory_to_cart($book['id']);
					}
				}
			}

			$selected_array = array();
			foreach ($selected_modules as $value) {
				$selected_array[] = $value['module'];
			}
			$data['req_university'] = $university;
			set_session('buy_session_optional_module', $selected_array);
			$this->load->view('buy_list_of_books', $data);
		} else {
			show_404();
		}
	}

	public function add_mandatory_to_cart($book_id)
	{
		$book_details = $this->app_model->get_book_details($book_id);
		$data = array(
			'id'      => $book_details['id'],
			'qty'     => 1,
			'price'   => number_format($book_details['price'], 0),
			'name'    => $book_details['book_name'],
			'options' => array('module' => $book_details['module'], 'user_id' => $book_details['user_id'], 'book_condition' => $book_details['book_condition'], 'used_book_id' => $book_details['used_book_id'])
		);
		$this->cart->insert($data);
		return true;
	}

	public function get_more_buy_books()
	{
		$identifiers = $this->input->post('identifiers');
		$op_module = $this->input->post('op_module');
		$university = $this->security->xss_clean($this->input->post('university'));

		$data['books'] = $this->app_model->get_buy_books($university, $identifiers, $op_module);
		$response = $this->load->view('buy_optional_modules_ajax', $data, TRUE);
		$finalResult = array('msg' => 'success', 'response'=>$response);
		echo json_encode($finalResult);
		exit;
	}

	public function sell()
	{
		unset_session('sell_api_session');
		$identifiers = $this->security->xss_clean($_GET['identifiers']);
		$university = $this->security->xss_clean($_GET['university']);

		if(empty($university)) {
			$finalResult = array('success' => 0, 'result' => "University is required.");
			echo json_encode($finalResult);
			exit;
		}

		$university_status = $this->app_model->is_valid_university($university);
		if(!($university_status > 0)) {
			$finalResult = array('success' => 0, 'result' => "Invalid university.");
			echo json_encode($finalResult);
			exit;
		}

		if (!empty($identifiers)) {
			$data['books'] = $this->app_model->get_sell_books_by_identifier($identifiers,$university);

			$selected_modules = $this->app_model->get_selected_modules($identifiers,$university);
			$data['modules'] = $this->app_model->get_modules($university);

			$selected_array = array();
			foreach ($selected_modules as $value) {
				$selected_array[] = $value['module'];
			}
			if (empty(get_session('sell_session_optional_module'))) {
				set_session('sell_api_session', $selected_array);
			}

			$data['req_university'] = $university;

			$this->load->view('sell_list_of_books', $data);

		} else {
			show_404();
		}
	}

	public function get_more_sell_books()
	{
		//
		$data = $_POST;
		$data['books'] = $this->app_model->get_sell_books($data);
		unset_session('sell_session_multi');
		set_session('sell_session_multi', @$data['sell_books']);
		$response = $this->load->view('sell_optional_modules_ajax', $data, TRUE);
		$finalResult = array('msg' => 'success', 'response'=>$response);
		echo json_encode($finalResult);
		exit;
	}
}