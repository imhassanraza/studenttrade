<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		get_site_language();
		if(!$this->session->userdata('user_logged_in'))
		{
			set_session('from_checkout' , false);
			redirect(base_url().'login');
		}
		$this->load->model('dashboard_model');
	}
	public function index()
	{
		$data['user_detail'] = $this->dashboard_model->get_user_detail();
		$this->load->view('dashboard' , $data);
	}
	public function dashboard()
	{
		$data['user_detail'] = $this->dashboard_model->get_user_detail();
		$this->load->view('dashboard' , $data);
	}
	public function buyer_orders()
	{
		$data['orders'] = $this->dashboard_model->get_orders(array('1','2'));
		$data['completed_orders'] = $this->dashboard_model->get_orders(array('3'));
		// $data['refund_orders'] = $this->dashboard_model->get_refunded_orders(array('4'));
		$data['cancel_orders'] = $this->dashboard_model->get_orders(array('5'));

		$this->load->view('buyer_orders' , $data);
	}
	public function seller_orders()
	{
		$data['orders'] = $this->dashboard_model->get_seller_order(array('1','2'));
		$data['completed_orders'] = $this->dashboard_model->get_seller_order(array('3'));
		// $data['refund_orders'] = $this->dashboard_model->get_seller_order(array('4'));
		$data['cancel_orders'] = $this->dashboard_model->get_seller_order(array('5'));
		$this->load->view('seller_order' , $data);
	}
	public function active_buyer_orders_detail()
	{
		$data = $this->input->post();
		$details['orders'] = $this->dashboard_model->get_active_buyer_orders_detail($data);
		if(!empty($details['orders'])) {
			$htmlrespon = $this->load->view('active_buyer_orders_ajax', $details, TRUE);
			$finalResult = array('msg' => 'success', 'response'=>$htmlrespon);
			echo json_encode($finalResult);
			exit;
		} else {
			$finalResult = array('msg' => 'error', 'response'=>'<p>'.lang('something_went_wrong').'</p>');
			echo json_encode($finalResult);
			exit;
		}
	}

	public function completed_buyer_orders_detail()
	{
		$data = $this->input->post();
		$details['orders'] = $this->dashboard_model->get_active_buyer_orders_detail($data);
		if(!empty($details['orders'])) {
			$htmlrespon = $this->load->view('completed_buyer_orders_ajax', $details, TRUE);
			$finalResult = array('msg' => 'success', 'response'=>$htmlrespon);
			echo json_encode($finalResult);
			exit;
		} else {
			$finalResult = array('msg' => 'error', 'response'=>'<p>'.lang('something_went_wrong').'</p>');
			echo json_encode($finalResult);
			exit;
		}
	}
	public function active_seller_orders_detail()
	{
		$data = $this->input->post();
		$details['orders'] = $this->dashboard_model->get_active_seller_orders_detail($data);
		if(!empty($details['orders'])) {
			$htmlrespon = $this->load->view('active_seller_orders_ajax', $details, TRUE);
			$finalResult = array('msg' => 'success', 'response'=>$htmlrespon);
			echo json_encode($finalResult);
			exit;
		} else {
			$finalResult = array('msg' => 'error', 'response'=>'<p>'.lang('something_went_wrong').'</p>');
			echo json_encode($finalResult);
			exit;
		}
	}
	public function profile()
	{
		$data['user_detail'] = $this->dashboard_model->get_user_detail();
		$this->load->view('profile' , $data);
	}
	public function edit_profile()
	{
		$data['user_detail'] = $this->dashboard_model->get_user_detail();
		$this->load->view('edit_profile' , $data);
	}
	public function settings()
	{
		$data['user_detail'] = $this->dashboard_model->get_user_detail();
		$this->load->view('settings' , $data);
	}
	public function books()
	{
		$data['books'] = $this->dashboard_model->get_books();
		$data['order_books'] = $this->dashboard_model->get_order_books();
		$this->load->view('books' , $data);
	}
	public function delete_book()
	{
		$data = $this->input->post();
		$status = $this->dashboard_model->delete_books($data);
		if($status){
			$finalResult = array('msg' => 'success', 'response'=>lang('book_successfully_deleted'));
			echo json_encode($finalResult);
			exit;
		}else{
			$finalResult = array('msg' => 'error', 'response'=>lang('something_went_wrong'));
			echo json_encode($finalResult);
			exit;
		}
	}
	public function update_user()
	{
		$data = $_POST;

		$this->form_validation->set_rules('first_name', 'First name', 'trim|required|xss_clean', array('required' => lang('first_name_field_is_required')));
		$this->form_validation->set_rules('last_name', 'Last name', 'trim|required|xss_clean', array('required' => lang('last_name_field_is_required')));
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required|xss_clean', array('required' => lang('gender_field_is_required')));
		// $this->form_validation->set_rules('phone', 'Phone number', 'trim|required|xss_clean', array('required' => lang('phone_number_field_is_required')));
		$this->form_validation->set_rules('phone', 'Phone number', 'trim|required|xss_clean|callback_check_old_phoneno', array('required' => lang('phone_number_field_is_required')));
		$this->form_validation->set_rules('address1', 'Street Address Line 1', 'trim|required|xss_clean', array('required' => lang('street_address_line_1_field_is_required')));
		$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean', array('required' => lang('city_field_is_required')));
		$this->form_validation->set_rules('state', 'State', 'trim|required|xss_clean', array('required' => lang('state_field_is_required')));
		$this->form_validation->set_rules('zip', 'Zip', 'trim|required|xss_clean', array('required' => lang('zip_field_is_required')));

		if(empty($data['amount_tranfer'])) {
			$this->form_validation->set_rules('paypal_email', 'Paypal Email', 'trim|required|xss_clean|valid_email', array('required' => lang('please_provide_paypal_email'), 'valid_email' => lang('login_email_valid')));
		} else {
			$this->form_validation->set_rules('paypal_email', 'Paypal Email', 'trim|valid_email|xss_clean', array('valid_email' => lang('login_email_valid')));
			$this->form_validation->set_rules('iban_number', 'IBAN (bank) Number', 'trim|required|xss_clean',array('required' => lang('please_provide_iban_number')));
		}

		if ($this->form_validation->run($this) == FALSE)
		{
			$finalResult = array('msg' => 'error', 'response'=>validation_errors());
			echo json_encode($finalResult);
			exit;

		} else {

			$status = $this->dashboard_model->update_details($data);
			if($status){
				$this->session->set_userdata('profile_updated' , 1);
				$finalResult = array('msg' => 'success', 'response'=>'<p>'.lang('profile_successfully_updated').'</p>');
				echo json_encode($finalResult);
				exit;
			}else{
				$finalResult = array('msg' => 'error', 'response'=>'<p>'.lang('something_went_wrong').'</p>');
				echo json_encode($finalResult);
				exit;
			}

		}
	}
	public function change_email()
	{
		$data = $_POST;
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]', array('is_unique' => lang('email_already_associated'), 'valid_email' => lang('login_email_valid'), 'required' => lang('email_is_required')));
		if ($this->form_validation->run() == false) {
			$finalResult = array('msg' => 'error', 'response'=> validation_errors());
			echo json_encode($finalResult);
			exit;
		}
		$status = $this->dashboard_model->change_email($data);
		$data['user_detail'] = $this->dashboard_model->get_user_detail();

		$data['unique_id'] = $data['user_detail']['unique_id'];
		$data['email2'] = $data['user_detail']['email2'];
		$this->send_change_email($data);

		$finalResult = array('msg' => 'success', 'response'=>'<p>'.lang('check_your_email_inbox').'</p>');
		echo json_encode($finalResult);
		exit;
	}
	public function update_password()
	{
		$data = $_POST;
		$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|xss_clean|callback_check_old_password', array('required' => lang('old_password_is_required')));
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean', array('required' => lang('password_field_is_required')));
		$this->form_validation->set_rules('c_password', 'Confirm Password', 'trim|required|matches[password]|xss_clean', array('required' => lang('c_password_field_is_required') , 'matches' => lang('same_password') ));
		if ($this->form_validation->run($this) == FALSE)
		{
			$finalResult = array('msg' => 'error', 'response'=>validation_errors());
			echo json_encode($finalResult);
			exit;
		}else{
			$status = $this->dashboard_model->update_password($data);
			if($status){

				$this->send_password_email();

				$finalResult = array('msg' => 'success', 'response'=>'<p>'.lang('password_has_been_changed_successfully').'</p>');
				echo json_encode($finalResult);
				exit;
			}else{
				$finalResult = array('msg' => 'error', 'response'=>'<p>'.lang('something_went_wrong').'</p>');
				echo json_encode($finalResult);
				exit;
			}
		}
	}
	public function check_old_password()
	{
		$data = $_POST;
		$status = $this->dashboard_model->check_old_password($data);
		if ($status > 0)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('check_old_password', lang('old_password_is_wrong'));
			return FALSE;
		}
	}
	public function update_dp()
	{

		$data['profile_dp'] = '';

		if(!empty($_FILES['profile_dp']['name'])){

			$config['upload_path']          = FCPATH.'assets/profile_pictures/';
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 5000;
			$config['max_width']            = 600;
			$config['max_height']           = 600;
			$config['encrypt_name'] 		= TRUE;

			$this->load->library('upload', $config);

			if($this->upload->do_upload('profile_dp'))
			{
				$upload_data = $this->upload->data();
				$data['profile_dp'] = $upload_data['file_name'];

				$status = $this->dashboard_model->update_profile_dp($data);
				if ($status) {

					$array=array(
						'profile_pic'=>$data['profile_dp'],
					);

					$this->session->set_userdata($array);

					$response_arr = array(
						'msg'=> 'success',
						'response'=> lang('your_profile_picture_successfully_updated'),
					);
					echo json_encode($response_arr);
					exit;

				}else{
					$finalResult = array('msg' => 'error', 'response'=>lang('something_went_wrong'));
					echo json_encode($finalResult);
					exit;
				}

			}else{
				$finalResult = array('msg' => 'error', 'response'=> $this->upload->display_errors());
				echo json_encode($finalResult);
				exit;
			}

		} else {
			$finalResult = array('msg' => 'error', 'response'=>lang('please_select_a_picture'));
			echo json_encode($finalResult);
			exit;
		}

	}
	public function send_change_email($data)
	{
		$to = $data['user_detail']['email'];
		$subject = "Change Email Request";
		$body = $this->load->view('home/email_template' , $data,TRUE);
		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		// More headers
		$headers .= 'From: '. $subject .' <'.no_reply_email().'>' . "\r\n";
         //Send mail
		@mail($to,$subject,$body,$headers);
	}
	public function send_password_email()
	{
		$data = array();
		$to = get_session('email');
		$subject = "Password Changed";

		$body = $this->load->view('change_pass_email.php' , $data,TRUE);
		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers
		$headers .= 'From: '. $subject .' <'.no_reply_email().'>' . "\r\n";

         //Send mail
		@mail($to,$subject,$body,$headers);
	}


	public function submit_user_books_data()
	{
		$data = $_POST;

		if($_POST){
			if(empty($data['user_sell_books'])) {
				$finalResult = array('msg' => 'error', 'response'=>lang('please_select_atleast_1_book_to_proceed'));
				echo json_encode($finalResult);
				exit;
			}
			$status = $this->dashboard_model->add_user_books_to_market($data);
			if($status) {
				$finalResult = array('msg' => 'success', 'response'=>lang('thanks_for_adding_your_books_to_our_marketplace'));
				echo json_encode($finalResult);
				exit;
			} else {
				$finalResult = array('msg' => 'error', 'response'=>lang('something_went_wrong'));
				echo json_encode($finalResult);
				exit;
			}
		}else{
			$finalResult = array('msg' => 'error', 'response'=>lang('please_select_atleast_1_book_to_proceed'));
			echo json_encode($finalResult);
			exit;
		}

	}

	public function check_old_phoneno()
	{
		$data = $_POST;
		$status = $this->dashboard_model->check_old_phoneno($data);
		if ($status > 0) {
			$this->form_validation->set_message('check_old_phoneno', lang('phoneno_already_associated'));
			return FALSE;
		} else {
			return TRUE;
		}
	}

}