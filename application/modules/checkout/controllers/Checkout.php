<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		get_site_language();
		// if(!get_session('user_logged_in'))
		// {
		// 	redirect(base_url().'login');
		// }
		$this->load->model('checkout_model');
	}

	public function index()
	{
		if(empty($this->cart->total_items())) {
			redirect(base_url().'shopping_cart');
		}

		$data['reference_id'] = $this->checkout_model->create_order();
		$this->load->view('checkout', $data);
	}

	public function place_order()
	{
		$post_data = $this->input->post();
		$data['reference_id'] = $post_data['purchase_units']['0']['reference_id'];
		$data['trx_id'] = $post_data['purchase_units']['0']['payments']['captures']['0']['id'];
		$data['trx_amount'] = $post_data['purchase_units']['0']['payments']['captures']['0']['amount']['value'];
		$data['payer_email'] = $post_data['payer']['email_address'];
		$data['first_name'] = $post_data['payer']['name']['given_name'];
		$data['last_name'] = $post_data['payer']['name']['surname'];
		$data['address1'] = $post_data['purchase_units']['0']['shipping']['address']['address_line_1'];
		$data['city'] = $post_data['purchase_units']['0']['shipping']['address']['admin_area_2'];
		$data['state'] = $post_data['purchase_units']['0']['shipping']['address']['country_code'];
		$data['zip_code'] = $post_data['purchase_units']['0']['shipping']['address']['postal_code'];
		$data['order_address'] = $data['address1'].", ".$data['zip_code']." ".$data['city'];
		$data['trx_response'] = $post_data;

		$data['order_response'] = $this->checkout_model->place_order($data);
		$data['order_id'] = $data['order_response']['order_id'];

		$this->send_order_placed_email_to_buyer($data);
		$this->send_order_placed_email_to_admin($data);
		$this->send_order_placed_email_to_seller($data);
		$this->send_order_placed_email_to_seller_admin($data);

		// if($data['order_response']['user_account'] == 'new registered') {
		// 	$data['activation_key'] = $data['order_response']['activation_key'];
		// 	$data['password'] = $data['order_response']['password'];
		// 	$this->send_confirmation_email($data);
		// }

		if($data['order_id'] > 0) {
			$data['order_products'] = $this->cart->contents();
			$data['products'] = count($this->cart->contents());
			$data['cart_total_amount'] = $this->cart->total();
			$this->cart->destroy();
			$data['discount_code_applied_or_not'] = get_session('discount_code_applied_for_click');
			unset_session('discount_code_applied_for_click');
			$response = $this->load->view('thank_you_ajax', $data, TRUE);
			$finalResult = array('msg' => 'success', 'response'=>$response, 'new_url'=> base_url()."thank_you");
			echo json_encode($finalResult);
			exit;
		} else {

			$finalResult = array('msg' => 'error');
			echo json_encode($finalResult);
			exit;
		}

	}

	public function send_confirmation_email($data)
	{
		$email_body = $this->load->view('activate_account_email' , $data,TRUE);

		$to = $data['payer_email'];
		$subject = 'Account Activation';
		$body = $email_body;
		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers
		$headers .= 'From: '. $subject .' <'.no_reply_email().'>' . "\r\n";
		@mail($to,$subject,$body,$headers);
		return true;
	}

	public function send_order_placed_email_to_buyer($data)
	{
		if($data['order_response']['user_account'] == 'loggedin') {
			$data['user_detail'] = get_owner_detail(get_session('user_id'));
		} else if($data['order_response']['user_account'] == 'registered') {
			$data['user_detail'] = array(
				'email' => $data['order_response']['user_details']['email'],
				'first_name' => $data['order_response']['user_details']['first_name'],
				'last_name' => $data['order_response']['user_details']['last_name']
			);
		} else {
			$data['user_detail'] = array(
				'email' => $data['payer_email'],
				'first_name' => $data['first_name'],
				'last_name' => $data['last_name']
			);
		}

		$to = $data['user_detail']['email'];
		$subject = "New Order Placed";
		$body = $this->load->view('send_email_to_buyer', $data, TRUE);
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: '. $subject .' <'.no_reply_email().'>' . "\r\n";
		@mail($to,$subject,$body,$headers);
	}

	public function send_order_placed_email_to_admin($data)
	{
		if($data['order_response']['user_account'] == 'loggedin') {
			$data['user_detail'] = get_owner_detail(get_session('user_id'));
		} else if($data['order_response']['user_account'] == 'registered') {
			$data['user_detail'] = array(
				'email' => $data['order_response']['user_details']['email'],
				'first_name' => $data['order_response']['user_details']['first_name'],
				'last_name' => $data['order_response']['user_details']['last_name']
			);
		} else {
			$data['user_detail'] = array(
				'email' => $data['payer_email'],
				'first_name' => $data['first_name'],
				'last_name' => $data['last_name']
			);
		}
		$to = admin_email();
		$subject = "New Order Placed";
		$body = $this->load->view('send_email_to_admin', $data, TRUE);
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: '. $subject .' <'.no_reply_email().'>' . "\r\n";
		@mail($to,$subject,$body,$headers);
	}

	public function send_order_placed_email_to_seller($data)
	{
		if($data['order_response']['user_account'] == 'loggedin') {
			$data['user_detail'] = get_owner_detail(get_session('user_id'));
		} else if($data['order_response']['user_account'] == 'registered') {
			$data['user_detail'] = array(
				'email' => $data['order_response']['user_details']['email'],
				'first_name' => $data['order_response']['user_details']['first_name'],
				'last_name' => $data['order_response']['user_details']['last_name']
			);
		} else {
			$data['user_detail'] = array(
				'email' => $data['payer_email'],
				'first_name' => $data['first_name'],
				'last_name' => $data['last_name']
			);
		}
		$sellers = $this->checkout_model->get_order_sellers($data['order_id']);
		foreach ($sellers as $seller) {
			$data['order_books'] = $this->checkout_model->get_order_detail($data['order_id'] , $seller['user_id']);
			$data['seller_detail'] = get_owner_detail($seller['user_id']);
			$to = $data['seller_detail']['email'];
			$subject = "New Order Placed";
			$body = $this->load->view('send_email_to_seller', $data, TRUE);
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: '. $subject .' <'.no_reply_email().'>' . "\r\n";
			@mail($to,$subject,$body,$headers);
		}

	}

	public function send_order_placed_email_to_seller_admin($data)
	{
		if($data['order_response']['user_account'] == 'loggedin') {
			$data['user_detail'] = get_owner_detail(get_session('user_id'));
		} else if($data['order_response']['user_account'] == 'registered') {
			$data['user_detail'] = array(
				'email' => $data['order_response']['user_details']['email'],
				'first_name' => $data['order_response']['user_details']['first_name'],
				'last_name' => $data['order_response']['user_details']['last_name']
			);
		} else {
			$data['user_detail'] = array(
				'email' => $data['payer_email'],
				'first_name' => $data['first_name'],
				'last_name' => $data['last_name']
			);
		}

		$data['order_books'] = $this->checkout_model->get_order_detail($data['order_id'] , 0);
		if (!empty($data['order_books'])) {
			$to = admin_email_address();
			$subject = "New Order Placed";
			$body = $this->load->view('send_email_to_seller_admin', $data, TRUE);
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: '. $subject .' <'.no_reply_email().'>' . "\r\n";
			@mail($to,$subject,$body,$headers);
		}


	}


	public function get_discount_code()
	{
		$data = $_POST;
		// if(empty(get_session('user_logged_in'))) {
		// 	unset_session('discount_code_applied');
		// 	unset_session('discount_code_applied_for_click');
		// 	unset_session('discount_code');
		// 	$finalResult = array('msg' => 'not_login', 'response'=>lang('please_login_to_proceed'));
		// 	echo json_encode($finalResult);
		// 	exit;
		// } else {
			$code_details = $this->checkout_model->get_discount_code($data);
			if(!empty($code_details)) {
				// $check = $this->checkout_model->check_already_used($code_details);
				// if($check) {
				// 	unset_session('discount_code_applied');
				// 	unset_session('discount_code_applied_for_click');
				// 	unset_session('discount_code');
				// 	$finalResult = array('msg' => 'error', 'response'=>lang('already_used_code'));
				// 	echo json_encode($finalResult);
				// 	exit;
				// } else {
					set_session('discount_code_applied', '1');
					set_session('discount_code_applied_for_click', '1');
					set_session('discount_code', $data['discount_code']);
					$data['code_detail'] = $code_details;
					$response = $this->load->view('discount_code_ajax', $data, TRUE);
					$finalResult = array('msg' => 'success', 'response'=>$response);
					echo json_encode($finalResult);
					exit;
				// }
			} else {
				unset_session('discount_code_applied');
				unset_session('discount_code_applied_for_click');
				unset_session('discount_code');
				$finalResult = array('msg' => 'error', 'response'=>lang('invalid_code'));
				echo json_encode($finalResult);
				exit;
			}
		// }
	}

}