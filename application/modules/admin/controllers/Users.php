<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model(admin_controller().'admin_model');
		if(!$this->session->userdata('admin_logged_in'))
		{
			redirect(admin_url().'login');
		}
		$this->load->model(admin_controller().'user_model');
	}
	public function index()
	{
		$data['users'] = $this->user_model->get_users('1');
		$this->load->view('users' , $data);
	}
	public function inactive_users()
	{
		$data['users'] = $this->user_model->get_users('0');
		$this->load->view('inactive_users' , $data);
	}

	public function deleted_users()
	{
		$data['users'] = $this->user_model->get_deleted_users();
		$this->load->view('deleted_users' , $data);
	}

	public function add_user()
	{
		$this->load->view('add_user');
	}

	public function insert_user()
	{
		$data = $_POST;
		// show($data);
		// exit;

		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');

		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('phone', 'Phone Number','trim|required|xss_clean|is_unique[users.phone]', array('is_unique' => 'Phone Number Already Associated With Another Account.'));
		$this->form_validation->set_rules('email', 'Email','trim|required|xss_clean|is_unique[users.email]', array('is_unique' => 'Email Already Associated With Another Account.'));

		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

		$this->form_validation->set_rules('c_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');

		if(empty($data['amount_transfer'])) {
			$this->form_validation->set_rules('paypal_email', 'Paypal Email', 'trim|required|xss_clean', array('required' => 'Please provide paypal email.'));
		} else {
			$this->form_validation->set_rules('iban_number', 'IBAN (bank) Number', 'trim|required|xss_clean',array('required' => 'Please provide IBAN (bank) Number.'));
		}

		if ($this->form_validation->run($this) == FALSE)
		{
			$finalResult = array('msg' => 'error', 'response'=>validation_errors());
			echo json_encode($finalResult);
			exit;
		}else{

			$status = $this->user_model->insert_user($data);
			if($status){
				$finalResult = array('msg' => 'success', 'response'=>'<p>User Successfully Saved!</p>');
				echo json_encode($finalResult);
				exit;
			}else{
				$finalResult = array('msg' => 'error', 'response'=>'<p>Something went wrong!</p>');
				echo json_encode($finalResult);
				exit;
			}

		}
	}

	public function inactive_status()
	{
		$user_id = $this->input->post('user_id');
		$status = $this->user_model->inactive_status($user_id);
		if($status){
			$finalResult = array('msg' => 'success', 'response'=>'User Successfully inactive.');
			echo json_encode($finalResult);
			exit;
		}else{
			$finalResult = array('msg' => 'error', 'response'=>'Unable to inactive user.');
			echo json_encode($finalResult);
			exit;
		}

	}
	public function active_status()
	{
		$user_id = $this->input->post('user_id');
		$status = $this->user_model->active_status($user_id);
		if($status){
			$finalResult = array('msg' => 'success', 'response'=>'User Successfully Active.');
			echo json_encode($finalResult);
			exit;
		}else{
			$finalResult = array('msg' => 'error', 'response'=>'Unable to active user.');
			echo json_encode($finalResult);
			exit;
		}

	}

	public function edit_user($user_id)
	{
		$data['user_detail'] = $this->user_model->get_user_detail($user_id);
		if (empty($data['user_detail'])) {
			show_admin404();
		}else{
			$this->load->view('edit_user' , $data);
		}
	}

	public function update_user()
	{
		$data = $_POST;

		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');

		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('phone', 'Phone number', 'trim|required|xss_clean|callback_check_old_phoneno');
		if(empty($data['amount_transfer'])) {
			$this->form_validation->set_rules('paypal_email', 'Paypal Email', 'trim|required|xss_clean', array('required' => 'Please provide paypal email.'));
		} else {
			$this->form_validation->set_rules('iban_number', 'IBAN (bank) Number', 'trim|required|xss_clean',array('required' => 'Please provide IBAN (bank) Number.'));
		}

		if ($this->form_validation->run($this) == FALSE)
		{
			$finalResult = array('msg' => 'error', 'response'=>validation_errors());
			echo json_encode($finalResult);
			exit;
		}else{

			$status = $this->user_model->update_user($data);
			if($status){
				$finalResult = array('msg' => 'success', 'response'=>'<p>User Successfully updated!</p>');
				echo json_encode($finalResult);
				exit;
			}else{
				$finalResult = array('msg' => 'error', 'response'=>'<p>Something went wrong!</p>');
				echo json_encode($finalResult);
				exit;
			}

		}
	}

	public function add_banned()
	{
		$user_id = $_POST['user_id'];

		$status = $this->user_model->add_banned($user_id);

		if($status > 0){

			$finalResult = array('msg' => 'success', 'response'=>"Successfully banned.");
			echo json_encode($finalResult);
			exit;

		} else {
			$finalResult = array('msg' => 'error', 'response'=>"Something went wrong please try again.");
			echo json_encode($finalResult);
			exit;
		}
	}

	public function remove_banned()
	{
		$user_id = $_POST['user_id'];

		$status = $this->user_model->remove_banned($user_id);

		if($status > 0){

			$finalResult = array('msg' => 'success', 'response'=>"Successfully remove banned.");
			echo json_encode($finalResult);
			exit;

		} else {
			$finalResult = array('msg' => 'error', 'response'=>"Something went wrong please try again.");
			echo json_encode($finalResult);
			exit;
		}
	}

	public function delete_user()
	{
		$user_id = $_POST['user_id'];

		$status = $this->user_model->delete_user($user_id);

		if($status > 0){

			$finalResult = array('msg' => 'success', 'response'=>"Successfully deleted.");
			echo json_encode($finalResult);
			exit;

		} else {
			$finalResult = array('msg' => 'error', 'response'=>"Something went wrong please try again.");
			echo json_encode($finalResult);
			exit;
		}
	}

	public function restore_user()
	{
		$user_id = $_POST['user_id'];

		$status = $this->user_model->restore_user($user_id);

		if($status > 0){

			$finalResult = array('msg' => 'success', 'response'=>"Successfully restored.");
			echo json_encode($finalResult);
			exit;

		} else {
			$finalResult = array('msg' => 'error', 'response'=>"Something went wrong please try again.");
			echo json_encode($finalResult);
			exit;
		}
	}

	public function user_permanent_delete()
	{
		$user_id = $_POST['user_id'];

		$status = $this->user_model->user_permanent_delete($user_id);

		if($status > 0){

			$finalResult = array('msg' => 'success', 'response'=>"Successfully permanent deleted.");
			echo json_encode($finalResult);
			exit;

		} else {
			$finalResult = array('msg' => 'error', 'response'=>"Something went wrong please try again.");
			echo json_encode($finalResult);
			exit;
		}
	}

	public function detail($id)
	{
		$data['user'] = $this->user_model->get_user_profile($id);
		$data['orders'] = $this->user_model->get_user_orders($id);
		if (empty($data['user'])) {
			show_admin404();
		}else{
			$this->load->view('user_profile' , $data);
		}
	}

	public function check_old_phoneno()
	{
		$data = $_POST;
		$status = $this->user_model->check_old_phoneno($data);
		if ($status > 0) {
			$this->form_validation->set_message('check_old_phoneno', 'Phone Number Already Associated With Another Account.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function get_users_email_addresses_csv()
	{
		$dbfields = array('first_name','last_name','email','address1','city','state','zip');
		$filename = 'users-email-addresses'.time().'.csv';
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=$filename");
		header('Content-Type: text/csv; charset=UTF-8');
		$file = fopen('php://output', 'w+');
		fputcsv($file, $dbfields);
		foreach ($dbfields as $key) {
			$this->db->select($key);
		}
		$emails = $this->db->get('users')->result_array();
		foreach ($emails as $key=>$line){
			fputcsv($file,$line);
		}
		fclose($file);
		exit;
	}

	public function get_users_email_addresses(){
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Name');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Email');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Address');

		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Gender');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Transfer Payment');
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'PayPal Email');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'IBAN Number');
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Phone Number');
		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Status');
		$feedbackInfo = $this->user_model->get_users_excel();
		$excel_row = 2;
		foreach($feedbackInfo as $row){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->first_name.' '.$row->last_name);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->email);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->address1.' '.$row->address2.' '.$row->city.' '.$row->state.' '.$row->zip);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->gender);
			if ($row->amount_tranfer == 0) {
				$payment_method = 'PayPal';
			}else{
				$payment_method = 'Bank Account';
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $payment_method);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->paypal_email);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->iban_number);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->phone);
			if ($row->status == 1) {
				$user_status = 'Active';
			}else{
				$user_status = 'Inactive';
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $user_status);

			$excel_row++;
		}
		$objPHPExcel_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$filename = 'users-list'.time().'.xlsx';
		header('Content-Type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=$filename");
		$objPHPExcel_writer->save('php://output');
	}

}