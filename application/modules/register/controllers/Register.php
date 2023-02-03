<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		get_site_language();
		if($this->session->userdata('user_logged_in'))
		{
			redirect(base_url());
		}
		$this->load->model('register_model');
	}

	public function index()
	{
		$this->load->view('register');
	}

	public function submit_user()
	{
		$data = $_POST;

		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|is_unique[users.email]', array('is_unique' => lang('email_already_associated')));
		$this->form_validation->set_rules('phone_no', 'Phone Number', 'trim|required|xss_clean|is_unique[users.phone]', array('is_unique' => lang('phoneno_already_associated')));
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean', array('required' => lang('login_password_required')));
		$this->form_validation->set_rules('c_password', 'Confirm Password', 'required|matches[password]', array('required' => lang('repeat_password') ,'matches' => lang('same_password') ));
		if ($this->form_validation->run($this) == FALSE)
		{
			$finalResult = array('msg' => 'error', 'response'=>validation_errors());
			echo json_encode($finalResult);
			exit;
		}else{
			$data['activation_key'] = md5(uniqid());
			$user_id = $this->register_model->insert_user($data);

			if($user_id > 0){

				$array = array(
					'user_id' => $user_id,
					'username' => '',
					'email' => $data['email'],
					'user_status' => 1,
					'profile_pic' => 'user.png',
					'profile_updated' => '0',
					'user_logged_in' => true
				);

				$this->session->set_userdata($array);

				$this->send_confirmation_email($data);
				$finalResult = array('msg' => 'success');
				echo json_encode($finalResult);
				exit;

			}else{
				$finalResult = array('msg' => 'error', 'response'=>'<p>'.lang('something_went_wrong').'</p>');
				echo json_encode($finalResult);
				exit;
			}
		}
	}


	public function check_email()
	{
		$email = $_POST['email'];
		$status = $this->register_model->check_email($email);
		if($status > 0){
			echo json_encode(FALSE);
		}else {
			echo json_encode(TRUE);
		}
	}

	public function check_phoneno()
	{
		$phone_no = $_POST['phone_no'];
		$status = $this->register_model->check_phone_no($phone_no);
		if($status > 0){
			echo json_encode(FALSE);
		}else {
			echo json_encode(TRUE);
		}
	}

	public function send_confirmation_email($data)
	{
		$email_body = $this->load->view('activate_account_email' , $data,TRUE);

		$to = $data['email'];
		$subject = lang('account_activation');
		$body = $email_body;
		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers
		$headers .= 'From: '. $subject .' <'.no_reply_email().'>' . "\r\n";
		@mail($to,$subject,$body,$headers);
		return true;
	}
}