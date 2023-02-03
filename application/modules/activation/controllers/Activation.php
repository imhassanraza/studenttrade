<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activation extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('activation_model');
		get_site_language();
	}
	public function confirm($activation_key = "")
	{
		if(empty($activation_key)){
			$this->session->set_flashdata('error_status' , lang('something_went_wrong'));
			redirect(base_url().'login','refresh');
		}
		$status = $this->activation_model->acctivate_account($activation_key);
		if($status > 0){

			$this->session->set_flashdata('activation_succ_status' , lang('your_account_has_been_successfully_activated'));
			redirect(base_url().'login');
		} else {
			$this->session->set_flashdata('activation_error_status' ,  lang('something_went_wrong'));
			redirect(base_url().'login');
		}
	}
	public function resend()
	{
		$data = $_POST;
		$data['activation_key'] = md5(uniqid());
		$status = $this->activation_model->set_acctivation_key($data);
		if ($status > 0) {

			$data['userdata'] = $this->activation_model->get_detail($data['email']);

			$email_body = $this->load->view('activate_account_email' , $data,TRUE);

			$to = $data['email'];
			$subject = 'Account Activation';
			$body = $email_body;
			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// More headers
			$headers .= 'From:'. $subject .' <'.no_reply_email().'>' . "\r\n";
			if(@mail($to,$subject,$body,$headers))
			{
				$finalResult = array('msg' => 'success', 'response'=>"<p>".lang('activation_email_successfully_sent')."</p>");
				echo json_encode($finalResult);
				exit;
			} else {
				$finalResult = array('msg' => 'error', 'response'=> lang('something_went_wrong'));
				echo json_encode($finalResult);
				exit;
			}
		} else {
			$finalResult = array('msg' => 'error', 'response'=>lang('something_went_wrong'));
			echo json_encode($finalResult);
			exit;
		}
	}
}