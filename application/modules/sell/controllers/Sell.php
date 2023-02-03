<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sell extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('sell_model');
		get_site_language();
	}

	public function university()
	{
		$data['universities'] = $this->sell_model->get_universities();
		$this->load->view('sell_university' , $data);
	}

	public function back_to_university()
	{
		$data['universities'] = $this->sell_model->get_universities();
		$response = $this->load->view('sell_university_ajax', $data, TRUE);

		$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."sell/university");
		echo json_encode($finalResult);
		exit;
	}

	public function field_of_study()
	{
		if(!empty(get_session('university'))) {
			$data['fields_of_study'] = $this->sell_model->fields_of_study();
			$this->load->view('sell_field_of_study' , $data);
		} else {
			redirect(base_url().'sell/university');
		}
	}

	public function back_to_field_of_study()
	{

		$data['fields_of_study'] = $this->sell_model->fields_of_study();
		$response = $this->load->view('sell_field_of_study_ajax', $data, TRUE);
		$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."sell/field_of_study");
		echo json_encode($finalResult);
		exit;
	}

	public function study_type()
	{
		if(!empty(get_session('field_of_study'))) {
			$this->load->view('sell_study_type');
		} else {
			redirect(base_url().'sell/field_of_study');
		}
	}

	public function back_to_study_type()
	{
		$response = $this->load->view('sell_study_type_ajax', '', TRUE);
		$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."sell/study_type");
		echo json_encode($finalResult);
		exit;
	}


	public function semester()
	{
		if(!empty(get_session('study_type'))) {
			$data['semesters'] = $this->sell_model->get_semesters();
			$this->load->view('sell_semester', $data);
		} else {
			redirect(base_url().'sell/study_type');
		}
	}

	public function back_to_semester()
	{
		unset_session('sell_session');
		unset_session('sell_session_optional_module');
		$data['semesters'] = $this->sell_model->get_semesters();
		$response = $this->load->view('sell_semester_ajax', $data, TRUE);
		$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."sell/semester");
		echo json_encode($finalResult);
		exit;
	}

	public function books()
	{
		if(empty(get_session('university'))) {
			redirect(base_url().'sell/university');
		}
		if (get_session('university') == 'ZHAW') {
			if(empty(get_session('field_of_study'))) {
				redirect(base_url().'sell/field_of_study');
			} else if (empty(get_session('study_type'))) {
				redirect(base_url().'sell/study_type');
			} else if(empty(get_session('sell_semester'))) {
				redirect(base_url().'sell/semester');
			}
		}
		if (get_session('university') == 'other_university') {
			$data['books'] = $this->sell_model->get_all_uni_books();
		}else{
			$data['books'] = $this->sell_model->get_books();
		}

		if (get_session('university') == 'ZHAW') {
			$data['modules'] = $this->sell_model->get_modules();
			$this->load->view('sell_list_of_books',$data);
		} elseif (get_session('university') == 'other_university') {
			//$data['modules'] = $this->sell_model->get_all_modules();
			$this->load->view('sell_list_of_books_other_uni', $data);
		} else {
			$data['modules'] = $this->sell_model->get_other_modules();
			$this->load->view('sell_list_of_books_other_uni', $data);
		}
	}

	public function get_more_books_for_new_working()
	{
		unset_session('sell_session_multi');
		$data = $_POST;
		// $op_module = $this->input->post('op_module');
		$data['books'] = $this->sell_model->get_more_books(@$data['optional_module']);
		set_session('sell_session_multi', @$data['sell_books']);
		$response = $this->load->view('optional_modules_ajax', $data, TRUE);
		$finalResult = array('msg' => 'success', 'response'=>$response);
		echo json_encode($finalResult);
		exit;
	}

	public function get_more_books()
	{
		$op_module = $this->input->post('op_module');
		$data['books'] = $this->sell_model->get_more_books($op_module);
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
					$data['fields_of_study'] = $this->sell_model->fields_of_study();
					$response = $this->load->view('sell_field_of_study_ajax', $data, TRUE);
					$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."sell/field_of_study");
					echo json_encode($finalResult);
					exit;
				} else if ($_POST['university'] === 'Universität St. Gallen (HSG)') {
					unset_session('new_university');
					$data['fields_of_study'] = $this->sell_model->fields_of_study();
					$response = $this->load->view('sell_field_of_study_ajax', $data, TRUE);
					$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."sell/field_of_study");
					echo json_encode($finalResult);
					exit;

				} else if ($other_university == 'other_university') {
					unset_session('university');
					set_session('university' , 'other_university');
					set_session('new_university' , $_POST['university']);

					// $data['modules'] = $this->sell_model->get_all_modules();
					$response = $this->load->view('sell_list_of_books_other_uni_ajax', $data, TRUE);
					$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."sell/books/");
					echo json_encode($finalResult);
					exit;
				} else {
					unset_session('new_university');
					// $data['books'] = $this->sell_model->get_books();
					$data['modules'] = $this->sell_model->get_other_modules();
					$response = $this->load->view('sell_list_of_books_other_uni_ajax', $data, TRUE);
					$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."sell/books/");
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
					set_session('university', 'other_university');
					$response = $this->load->view('sell_list_of_books_other_uni_ajax', $data, TRUE);
					$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."sell/books/");
					echo json_encode($finalResult);
					exit;
				} else if ($_POST['field_of_study'] == 'Assessment Juristisch' || $_POST['field_of_study'] == 'Bachelor' || $_POST['field_of_study'] == 'Master' || $_POST['field_of_study'] == 'Assessment WiWi (deutsch)'|| $_POST['field_of_study'] == 'Assessment WiWi (englisch)') {

					$data['modules'] = $this->sell_model->get_other_modules();
					$response = $this->load->view('sell_list_of_books_other_uni_ajax', $data, TRUE);
					$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."sell/books/");
					echo json_encode($finalResult);
					exit;

				} else{
					$response = $this->load->view('sell_study_type_ajax', $data, TRUE);
					$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."sell/study_type");
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
				$data['semesters'] = $this->sell_model->get_semesters();
				$response = $this->load->view('sell_semester_ajax', $data, TRUE);
				$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."sell/semester");
				echo json_encode($finalResult);
				exit;
			} elseif($data['form_id'] == 'semester') {
				if(empty($_POST['semester'])) {
					$finalResult = array('msg' => 'error', 'response'=>lang('semester_is_required'));
					echo json_encode($finalResult);
					exit;
				}
				set_session('sell_semester' , $_POST['semester']);
				$data['books'] = $this->sell_model->get_books();
				$data['modules'] = $this->sell_model->get_modules();
				$response = $this->load->view('sell_list_of_books_ajax', $data, TRUE);
				$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."sell/books/");
				echo json_encode($finalResult);
				exit;
			} elseif($data['form_id'] == 'add_books_to_market') {
				if(empty($data['sell_books'])) {
					$finalResult = array('msg' => 'error', 'response'=>lang('please_select_atleast_1_book_to_proceed'));
					echo json_encode($finalResult);
					exit;
				}
				if(empty($data['sell_affidavit'])) {
					$finalResult = array('msg' => 'error', 'response'=>lang('confirm_i_hereby'));
					echo json_encode($finalResult);
					exit;
				}
				if(empty(get_session('user_logged_in'))) {

					set_session('redirect_login', 'redirect_login');
					set_session('verify_checkbox', true);
					unset_session('sell_session_multi');
					set_session('sell_session', $data['sell_books']);
					if (get_session('university') == 'other_university') {
						set_session('book_name', $data['book_name']);
					}elseif (get_session('university') == 'ZHAW') {
						set_session('book_name', $data['book_name']);
					}else{
						set_session('sell_session_optional_module', @$data['optional_module']);
						set_session('book_name', $data['book_name']);
					}
					$finalResult = array('msg' => 'not_login', 'response'=>lang('please_login_to_proceed'));
					echo json_encode($finalResult);
					exit;
				}

				$status = $this->sell_model->add_books_to_market($data);

				if($status) {
					unset_session('sell_session');
					unset_session('sell_session_multi');
					unset_session('sell_session_optional_module');
					unset_session('book_name');
					unset_session('verify_checkbox');
					$response = $this->load->view('thank_you_ajax','', TRUE);
					$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."thank_you");
					echo json_encode($finalResult);
					exit;
				} else {
					$finalResult = array('msg' => 'error', 'response'=>lang('something_went_wrong'));
					echo json_encode($finalResult);
					exit;
				}
			}
		}
	}



	public function get_other_uni_books()
	{
		unset_session('sell_session_multi');
		$data = $_POST;
		// echo "<pre>";
		// print_r($data);
		// exit();
		if (get_session('university') == 'other_university') {
			$data['books'] = $this->sell_model->get_all_module_books(@$data['optional_module']);
		}else{
			$data['books'] = $this->sell_model->get_other_uni_books(@$data['optional_module']);
		}
		set_session('sell_session_multi', @$data['sell_books']);
		$response = $this->load->view('optional_modules_ajax', $data, TRUE);

		$finalResult = array('msg' => 'success', 'response'=>$response);
		echo json_encode($finalResult);
		exit;
	}
}