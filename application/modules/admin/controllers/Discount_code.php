<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discount_code extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model(admin_controller().'admin_model');
		if(!$this->session->userdata('admin_logged_in'))
		{
			redirect(admin_url().'login');
		}
		$this->load->model(admin_controller().'discount_model');
	}

	public function index() {
		$data['codes'] = $this->discount_model->get_discount_codes('1');
		$this->load->view('discount_codes' , $data);
	}
	public function add() {
		$data = $_POST;
		$this->form_validation->set_rules('code', 'Discount Code', 'trim|required|xss_clean|is_unique[discount_codes.code]');
		$this->form_validation->set_rules('code_type', 'Discount Type', 'trim|required|xss_clean');
		$this->form_validation->set_rules('code_value', 'Code Value','trim|required|xss_clean');
		$this->form_validation->set_rules('daterange', 'Valid From To', 'trim|required|xss_clean');
		if ($this->form_validation->run($this) == FALSE) {
			$finalResult = array('msg' => 'error', 'response'=>validation_errors());
			echo json_encode($finalResult);
			exit;
		} else {
			$status = $this->discount_model->add_discount_code($data);
			if($status){
				$finalResult = array('msg' => 'success', 'response'=>'<p>Discount Code Successfully Saved!</p>');
				echo json_encode($finalResult);
				exit;
			}else{
				$finalResult = array('msg' => 'error', 'response'=>'<p>Something went wrong!</p>');
				echo json_encode($finalResult);
				exit;
			}
		}
	}
	public function delete() {
		$data = $_POST;
		$status = $this->discount_model->delete_code($data);
		if($status){
			$finalResult = array('msg' => 'success', 'response'=>'Discount Code Successfully Deleted!');
			echo json_encode($finalResult);
			exit;
		}else{
			$finalResult = array('msg' => 'error', 'response'=>'Something went wrong!');
			echo json_encode($finalResult);
			exit;
		}
	}

	public function edit() {
		$data = $_POST;
		$detail['code'] = $this->discount_model->get_code_detail($data);
		if(!empty($detail['code'])) {
			$htmlrespon = $this->load->view('edit_discount_code_ajax', $detail, TRUE);
			$finalResult = array('msg' => 'success', 'response'=>$htmlrespon);
			echo json_encode($finalResult);
			exit;
		} else {
			$finalResult = array('msg' => 'error', 'response'=>'Something went wrong!');
			echo json_encode($finalResult);
			exit;
		}
	}

	public function update() {
		$data = $_POST;
		$this->form_validation->set_rules('code', 'Discount Code', 'trim|required|xss_clean|callback_check_old_code');
		$this->form_validation->set_rules('code_type', 'Discount Type', 'trim|required|xss_clean');
		$this->form_validation->set_rules('code_value', 'Code Value','trim|required|xss_clean');
		$this->form_validation->set_rules('daterange', 'Valid From To', 'trim|required|xss_clean');
		if ($this->form_validation->run($this) == FALSE) {
			$finalResult = array('msg' => 'error', 'response'=>validation_errors());
			echo json_encode($finalResult);
			exit;
		} else {
			$status = $this->discount_model->update_discount_code($data);
			if($status){
				$finalResult = array('msg' => 'success', 'response'=>'<p>Discount Code Successfully Updated!</p>');
				echo json_encode($finalResult);
				exit;
			}else{
				$finalResult = array('msg' => 'error', 'response'=>'<p>Something went wrong!</p>');
				echo json_encode($finalResult);
				exit;
			}
		}
	}

	public function check_old_code()
	{
		$data = $_POST;
		$status = $this->discount_model->check_old_code($data);
		if ($status > 0) {
			$this->form_validation->set_message('check_old_code', 'Discount Code Already Exist.');
			return FALSE;
		} else {
			return TRUE;
		}
	}
}