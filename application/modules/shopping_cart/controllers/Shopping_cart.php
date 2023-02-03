<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shopping_cart extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		get_site_language();
	}

	public function index()
	{
		$this->load->view('shopping_cart');
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
				$total_amount = number_format($this->cart->total(),0);

				$finalResult = array('msg' => 'success', 'response'=>lang('successfully_removed_from_cart') , 'items'=>$items, 'total_amount'=>$total_amount);
				echo json_encode($finalResult);
				exit;
			}
		}

		$items = count($this->cart->contents());
		$total_amount = number_format($this->cart->total(),0);

		$finalResult = array('msg' => 'success', 'response'=>lang('successfully_removed_from_cart') , 'items'=>$items, 'total_amount'=>$total_amount);
		echo json_encode($finalResult);
		exit;

	}

	public function check_login()
	{
		if(empty(get_session('user_logged_in'))) {
			$finalResult = array('msg' => 'not_login', 'response'=>lang('please_login_to_proceed'));
			echo json_encode($finalResult);
			exit;
		} else {
			$finalResult = array('msg' => 'success');
			echo json_encode($finalResult);
			exit;
		}
	}
}