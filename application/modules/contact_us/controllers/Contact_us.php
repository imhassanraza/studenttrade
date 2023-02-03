<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_us extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		get_site_language();
	}
	public function index()
	{
		$this->load->view('contact_us');
	}

	public function send_contact_email()
	{
		$data = $_POST;

		$this->form_validation->set_rules('full_name', 'Full Name', 'required|trim|callback_alpha_space');
		$this->form_validation->set_rules('email', 'Email Address', 'required|trim|valid_email', array('required' => lang('the_email_address_field_is_required'), 'valid_email' => lang('login_email_valid')));
		$this->form_validation->set_rules('subject', 'Subject', 'trim|required', array('required' => lang('the_subject_field_is_required')));
		$this->form_validation->set_rules('message', 'Message', 'trim|required', array('required' => lang('the_message_field_is_required')));

		if ($this->form_validation->run() == FALSE)
		{
			$finalResult = array('msg' => 'error', 'response'=>validation_errors());
			echo json_encode($finalResult);
			exit;
		}

		$to = get_section_content('contactus' , 'contactus_email');
		$subject = $data['subject'];

		$body = $this->load->view('contact_email.php' , $data,TRUE);
		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers
		$headers .= 'From: '. $subject .' <'.$data['email'].'>' . "\r\n";

         //Send mail
		if(@mail($to,$subject,$body,$headers)){
			$finalResult = array('msg' => 'success', 'response'=>lang('message_successfully_sent_we_will_contact_with_you_soon'));
			echo json_encode($finalResult);
			exit;
		}else{
			$finalResult = array('msg' => 'error', 'response'=>'<p>'.lang('something_went_wrong').'</p>');
			echo json_encode($finalResult);
			exit;
		}
	}
	public function alpha_space($full_name){
		if(empty($full_name)){
			$this->form_validation->set_message('alpha_space', lang('the_full_name_field_is_required'));
			return FALSE;
		}
		elseif (! preg_match('/^[a-zA-Z\s]+$/', $full_name)) {
			$this->form_validation->set_message('alpha_space', lang('please_enter_a_valid_full_name'));
			return FALSE;
		} else {
			return TRUE;
		}
	}
}