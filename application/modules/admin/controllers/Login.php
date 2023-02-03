<?php
defined('BASEPATH') OR exit('No direct script access allowed');

 class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(admin_controller().'login_lib');
		$this->load->model(admin_controller().'login_model');
		if($this->session->userdata('admin_logged_in'))
		{
			redirect(admin_url().'dashboard/');
		}

	}
	public function index()
	{
		$this->load->view('login');
	}
	public function login_verify()
	{
		if($_POST){
			$email=trim($this->input->post('email'));
			$password=trim($this->input->post('password'));
			if($this->login_lib->validate_login($email, $password))
			{
				redirect(admin_url().'dashboard/');
			}
			else
			{
				$this->session->set_flashdata('email',$this->input->post('email'));
				$this->session->set_flashdata('login_error','Incorrect Email/Password or Combination');
				redirect(admin_url().'login');
			}
		}else{
			$this->session->set_flashdata('email','');
			$this->session->set_flashdata('login_error','Incorrect Email/Password or Combination');
			redirect(admin_url().'login');
		}

	}
	public function forgot_password()
	{
		$this->load->view('forgot_password');
	}
	public function retrieve_password()
	{
	   $data = $_POST;
	   $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|callback_email_exist');

	   if ($this->form_validation->run($this) == FALSE)
	   	{
	   		$finalResult = array('msg' => 'error', 'response'=>validation_errors());
			echo json_encode($finalResult);
			exit;
	   	}else{
	   		$this->load->helper('string');
            $data['password'] = random_string('alnum',8);
	   		$status = $this->login_model->set_admin_password($data['email'] , $data['password']);
	   		if($status){
				$htmlresponse = $this->load->view('recover_admin_pass_email', $data, TRUE);
				$this->send_confirmation_email( $data['email'] , $htmlresponse);
				$finalResult = array('msg' => 'success', 'response'=>'<p>Password Updated Please check Your Email Inbox!</p>');
				echo json_encode($finalResult);
				exit;
			} else {
				$finalResult = array('msg' => 'error', 'response'=>'<p>Something went wrong !</p>');
				echo json_encode($finalResult);
				exit;
			}
	   	}
	}
	public function email_exist($email)
	{
		$email = $this->login_model->check_email($email);
		if ($email > 0)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('email_exist', 'This email is not exist.');
			return FALSE;
		}
	}

	public function send_confirmation_email($user_email , $email_body)
	{
		$to = $user_email;
		$subject = 'Recover Password';
		$body = $email_body;
		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers
		$headers .= 'From: '. $subject .' <noreply@explorelogics.com>' . "\r\n";
		@mail($to,$subject,$body,$headers);
	}
}
