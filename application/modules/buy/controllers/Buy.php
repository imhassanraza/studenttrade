<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buy extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('buy_model');
		$this->load->model('search/search_model');
		get_site_language();
	}

	public function university()
	{
		$data['universities'] = $this->buy_model->get_universities();
		$this->load->view('buy_university' , $data);
	}

	public function back_to_university()
	{
		$data['universities'] = $this->buy_model->get_universities();
		$response = $this->load->view('buy_university_ajax', $data, TRUE);

		$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."buy/university");
		echo json_encode($finalResult);
		exit;
	}



	public function field_of_study()
	{
		if(!empty(get_session('university'))) {
			$data['fields_of_study'] = $this->buy_model->fields_of_study();
			$this->load->view('buy_field_of_study' , $data);
		} else {
			redirect(base_url().'buy/university');
		}
	}

	public function back_to_field_of_study()
	{

		$data['fields_of_study'] = $this->buy_model->fields_of_study();
		$response = $this->load->view('buy_field_of_study_ajax', $data, TRUE);
		$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."buy/field_of_study");
		echo json_encode($finalResult);
		exit;
	}

	public function study_type()
	{
		if(!empty(get_session('field_of_study'))) {
			$this->load->view('buy_study_type');
		} else {
			redirect(base_url().'buy/field_of_study');
		}
	}

	public function back_to_study_type()
	{
		$response = $this->load->view('buy_study_type_ajax', '', TRUE);
		$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."buy/study_type");
		echo json_encode($finalResult);
		exit;
	}


	public function semester()
	{
		if(!empty(get_session('study_type'))) {
			$data['semesters'] = $this->buy_model->get_semesters();
			$this->load->view('buy_semester', $data);
		} else {
			redirect(base_url().'buy/study_type');
		}
	}

	public function back_to_semester()
	{
		$data['semesters'] = $this->buy_model->get_semesters();
		$response = $this->load->view('buy_semester_ajax', $data, TRUE);
		$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."buy/semester");
		echo json_encode($finalResult);
		exit;
	}



	public function books()
	{
		if(empty(get_session('university'))) {
			redirect(base_url().'buy/university');
		}
		if (get_session('university') == 'ZHAW') {
			if(empty(get_session('field_of_study'))) {
				redirect(base_url().'buy/field_of_study');
			} else if (empty(get_session('study_type'))) {
				redirect(base_url().'buy/study_type');
			} else if(empty(get_session('semester'))) {
				redirect(base_url().'buy/semester');
			}
		}
		if (get_session('university') == 'other_university') {
			$data['books'] = $this->buy_model->get_all_uni_books();
		}else{
			$data['books'] = $this->buy_model->get_books();
			foreach ($data['books'] as $book) {
				if($book['price'] > 0) {
					if($book['mandatory_or_optional'] == '0' && !(in_cart($book['id']))) {
						$this->add_mandatory_to_cart($book['id']);
					}
				}
			}
		}

		if (get_session('university') == 'other_university') {
			// $data['modules'] = $this->buy_model->get_all_modules();
		}else{
			$data['modules'] = $this->buy_model->get_modules();
		}
		if (get_session('university') == 'ZHAW') {
			$this->load->view('list_of_books', $data);
		} else {
			$this->load->view('list_of_books_other_uni', $data);
		}
	}

	public function get_more_books()
	{
		$op_module = $this->input->post('op_module');
		$data['books'] = $this->buy_model->get_more_books($op_module);
		$response = $this->load->view('optional_modules_ajax', $data, TRUE);

		$finalResult = array('msg' => 'success', 'response'=>$response);
		echo json_encode($finalResult);
		exit;
	}


	public function submit_data()
	{
		$data = $_POST;

		if($_POST){

			if($data['form_id'] == 'university') {

				if(empty($_POST['university'])) {
					$finalResult = array('msg' => 'error', 'response'=>lang('university_is_required'));
					echo json_encode($finalResult);
					exit;
				}

				$str = $_POST['university'];
				$str_con = explode("_", $str);
				@$str_con[0];
				@$str_con[1];
				$other_university = @$str_con[0].'_'.@$str_con[1];
				set_session('university' , $_POST['university']);

				if ($_POST['university'] == 'ZHAW') {
					unset_session('new_university');
					$data['fields_of_study'] = $this->buy_model->fields_of_study();
					$response = $this->load->view('buy_field_of_study_ajax', $data, TRUE);
					$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."buy/field_of_study");
					echo json_encode($finalResult);
					exit;
				} else if ($_POST['university'] === 'Universität St. Gallen (HSG)') {
					unset_session('new_university');
					$data['fields_of_study'] = $this->buy_model->fields_of_study();
					$response = $this->load->view('buy_field_of_study_ajax', $data, TRUE);
					$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."buy/field_of_study");
					echo json_encode($finalResult);
					exit;

				} else if ($other_university === 'other_university') {
					unset_session('university');
					set_session('university' , 'other_university');
					set_session('new_university' , $_POST['university']);

					//$data['modules'] = $this->buy_model->get_all_modules();
					$items = count($this->cart->contents());
					$response = $this->load->view('list_of_books_other_uni_ajax', $data, TRUE);
					$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."buy/books/", 'items'=>$items);
					echo json_encode($finalResult);
					exit;

				}else{
					unset_session('new_university');
					// $data['books'] = $this->buy_model->get_books();
					$data['modules'] = $this->buy_model->get_modules();
					// foreach ($data['books'] as $book) {
					// 	if($book['price'] > 0) {
					// 		if($book['mandatory_or_optional'] == '0' && !(in_cart($book['id']))) {
					// 			$this->add_mandatory_to_cart($book['id']);
					// 		}
					// 	}
					// }
					$items = count($this->cart->contents());
					$response = $this->load->view('list_of_books_other_uni_ajax', $data, TRUE);
					$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."buy/books/", 'items'=>$items);
					echo json_encode($finalResult);
					exit;
				}

			} elseif($data['form_id'] == 'field_of_study') {
				if(empty($_POST['field_of_study'])) {
					$finalResult = array('msg' => 'error', 'response'=>lang('field_of_study_is_required'));
					echo json_encode($finalResult);
					exit;
				}
				set_session('field_of_study' , $_POST['field_of_study']);
				if ($_POST['field_of_study'] == 'other_degree') {
					unset_session('university');
					set_session('university' , 'other_university');
					$items = count($this->cart->contents());
					$response = $this->load->view('list_of_books_other_uni_ajax', $data, TRUE);
					$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."buy/books/", 'items'=>$items);
					echo json_encode($finalResult);
					exit;
				} else if ($_POST['field_of_study'] == 'Assessment Juristisch' || $_POST['field_of_study'] == 'Bachelor' || $_POST['field_of_study'] == 'Master' || $_POST['field_of_study'] == 'Assessment WiWi (deutsch)'|| $_POST['field_of_study'] == 'Assessment WiWi (englisch)') {
					$data['modules'] = $this->buy_model->get_modules();
					$items = count($this->cart->contents());
					$response = $this->load->view('list_of_books_other_uni_ajax', $data, TRUE);
					$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."buy/books/", 'items'=>$items);
					echo json_encode($finalResult);
					exit;
				} else {
					$response = $this->load->view('buy_study_type_ajax', $data, TRUE);
					$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."buy/study_type");
					echo json_encode($finalResult);
					exit;
				}


			} elseif($data['form_id'] == 'study_type') {

				if(empty($_POST['study_type'])) {
					$finalResult = array('msg' => 'error', 'response'=>lang('type_of_study_is_required'));
					echo json_encode($finalResult);
					exit;
				}

				set_session('study_type' , $_POST['study_type']);

				$data['semesters'] = $this->buy_model->get_semesters();

				$response = $this->load->view('buy_semester_ajax', $data, TRUE);
				$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."buy/semester");
				echo json_encode($finalResult);
				exit;

			} elseif($data['form_id'] == 'semester') {

				if(empty($_POST['semester'])) {
					$finalResult = array('msg' => 'error', 'response'=>lang('semester_is_required'));
					echo json_encode($finalResult);
					exit;
				}

				set_session('semester' , $_POST['semester']);

				$data['books'] = $this->buy_model->get_books();
				$data['modules'] = $this->buy_model->get_modules();

				foreach ($data['books'] as $book) {

					if($book['price'] > 0) {
						if($book['mandatory_or_optional'] == '0' && !(in_cart($book['id']))) {
							$this->add_mandatory_to_cart($book['id']);
						}
					}
				}

				$items = count($this->cart->contents());

				$response = $this->load->view('list_of_books_ajax', $data, TRUE);

				$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."buy/books/", 'items'=>$items);
				echo json_encode($finalResult);
				exit;

			}
		}
	}


	public function add_mandatory_to_cart($book_id)
	{
		$book_details = $this->buy_model->get_book_details($book_id);

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



	public function add_to_cart()
	{
		$book_id = $this->input->post('book_id');
		$book_details = $this->buy_model->get_book_details($book_id);

		if (empty($book_details['book_name'])) {
			$finalResult = array('msg' => 'error', 'response'=>lang('book_details_not_found'));
			echo json_encode($finalResult);
			exit;
		}

		$my_cart = $this->cart->contents();

		if(empty($my_cart)) {

			$data = array(
				'id'      => $book_id,
				'qty'     => 1,
				'price'   => number_format($book_details['price'], 0),
				'name'    => $book_details['book_name'],
				'options' => array('module' => $book_details['module'], 'user_id' => $book_details['user_id'], 'book_condition' => $book_details['book_condition'], 'used_book_id' => $book_details['used_book_id'])
			);


			$this->cart->insert($data);
			$items = count($this->cart->contents());

			$finalResult = array('msg' => 'success', 'response'=>lang('successfully_added_to_cart'), 'items'=>$items);
			echo json_encode($finalResult);
			exit;
		}

		$check = 0;

		foreach($my_cart as $cart_details) {

			if($cart_details['id'] == $book_id) {

				$check = 1;

				$data = array(
					'id'      => $book_id,
					'qty'     => 1,
					'price'   => number_format($book_details['price'], 0),
					'name'    => $book_details['book_name'],
					'options' => array('module' => $book_details['module'], 'user_id' => $book_details['user_id'], 'book_condition' => $book_details['book_condition'], 'used_book_id' => $book_details['used_book_id'])
				);

				$this->cart->update($data);
				$items = count($this->cart->contents());

				$finalResult = array('msg' => 'success', 'response'=>lang('successfully_added_to_cart') , 'items'=>$items);
				echo json_encode($finalResult);
				exit;
			}
		}

		if($check == 0) {

			$data = array(
				'id'      => $book_id,
				'qty'     => 1,
				'price'   => number_format($book_details['price'], 0),
				'name'    => $book_details['book_name'],
				'options' => array('module' => $book_details['module'], 'user_id' => $book_details['user_id'], 'book_condition' => $book_details['book_condition'], 'used_book_id' => $book_details['used_book_id'])
			);

			$this->cart->insert($data);
			$items = count($this->cart->contents());

			$finalResult = array('msg' => 'success', 'response'=>lang('successfully_added_to_cart') , 'items'=>$items);
			echo json_encode($finalResult);
			exit;
		}
	}

	public function remove_from_cart()
	{
		$book_id = $this->input->post('book_id');
		$my_cart = $this->cart->contents();

		foreach($my_cart as $cart_details) {

			if($cart_details['id'] == $book_id) {

				$data = array(
					'rowid' => $cart_details['rowid'],
					'qty'   => 0
				);

				$this->cart->update($data);
				$items = count($this->cart->contents());

				$finalResult = array('msg' => 'success', 'response'=>lang('successfully_removed_from_cart') , 'items'=>$items);
				echo json_encode($finalResult);
				exit;
			}
		}

		$items = count($this->cart->contents());
		$finalResult = array('msg' => 'success', 'response'=>lang('successfully_removed_from_cart') , 'items'=>$items);
		echo json_encode($finalResult);
		exit;

	}

	public function get_other_uni_books()
	{
		$op_module = $this->input->post('op_module');
		if (get_session('university') == 'other_university') {
			$data['books'] = '';
			//$data['books'] = $this->buy_model->get_all_module_books($op_module);
		}else{
			$data['books'] = $this->buy_model->get_other_uni_books($op_module);
		}
		$response = $this->load->view('optional_modules_ajax', $data, TRUE);

		$finalResult = array('msg' => 'success', 'response'=>$response);
		echo json_encode($finalResult);
		exit;
	}

	public function close_alert()
	{
		$data['status'] = $this->buy_model->close_alert();
		$finalResult = array('msg' => 'success');
		echo json_encode($finalResult);
		exit;
	}


	public function get_search_result()
	{
		$book_name = $this->input->post('book_name');
		$data['books'] = $this->search_model->get_search_result($book_name);
		$response = $this->load->view('search/search_result_ajax', $data, TRUE);
		$finalResult = array('msg' => 'success', 'response'=>$response);
		echo json_encode($finalResult);
		exit;
	}


}