<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('admin_logged_in'))
		{
			redirect(admin_url().'login');
		}
		$this->load->model(admin_controller().'orders_model');
		$this->load->library('excel');
		ini_set('memory_limit', '-1');
	}

	public function index()
	{
		$data['orders'] = $this->orders_model->get_orders(array('1','2'));
		$this->load->view('orders' , $data);
	}

	public function new_orders_detail()
	{
		$data = $this->input->post();
		$details['orders'] = $this->orders_model->get_new_orders_detail($data);
		if(!empty($details['orders'])) {
			$htmlrespon = $this->load->view('new_orders_detail_ajax', $details, TRUE);
			$finalResult = array('msg' => 'success', 'response'=>$htmlrespon);
			echo json_encode($finalResult);
			exit;
		} else {
			$finalResult = array('msg' => 'error', 'response'=>'Something went wrong!');
			echo json_encode($finalResult);
			exit;
		}
	}

	public function orders_detail()
	{
		$data = $this->input->post();
		$details['orders'] = $this->orders_model->get_orders_detail($data);
		if(!empty($details['orders'])) {
			$htmlrespon = $this->load->view('orders_detail_ajax', $details, TRUE);
			$finalResult = array('msg' => 'success', 'response'=>$htmlrespon);
			echo json_encode($finalResult);
			exit;
		} else {
			$finalResult = array('msg' => 'error', 'response'=>'Something went wrong!');
			echo json_encode($finalResult);
			exit;
		}
	}

	public function update_status()
	{
		$data = $this->input->post();
		$status = $this->orders_model->update_order_status($data);
		if($status){
			$finalResult = array('msg' => 'success', 'response'=>'Orders status successfully updated.');
			echo json_encode($finalResult);
			exit;
		}else{
			$finalResult = array('msg' => 'error', 'response'=>'Something went wrong!');
			echo json_encode($finalResult);
			exit;
		}
	}

	public function completed()
	{
		$data['orders'] = $this->orders_model->get_orders(array('3'));
		$this->load->view('completed_orders' , $data);
	}

	public function cancelled()
	{
		$data['orders'] = $this->orders_model->get_orders(array('5'));
		$this->load->view('cancelled_orders' , $data);
	}

	// public function refunded()
	// {
	// 	$data['orders'] = $this->orders_model->get_refunded_orders();
	// 	$this->load->view('refunded_orders' , $data);
	// }


	public function refund_order_payment()
	{
		$data = $this->input->post();
		$details['orders'] = $this->orders_model->get_refund_order_detail($data);
		if(!empty($details['orders'])) {
			$htmlrespon = $this->load->view('refund_order_payment_ajax', $details, TRUE);
			$finalResult = array('msg' => 'success', 'response'=>$htmlrespon);
			echo json_encode($finalResult);
			exit;
		} else {
			$finalResult = array('msg' => 'error', 'response'=>'Something went wrong!');
			echo json_encode($finalResult);
			exit;
		}
	}

	public function add_refund_payment()
	{
		$data = $this->input->post();
		$status= $this->orders_model->refund_payment($data);
		if(!empty($status)) {
			$this->send_refund_email($data);
			$finalResult = array('msg' => 'success', 'response'=>'Orders payment successfully refunded.');
			echo json_encode($finalResult);
			exit;
		} else {
			$finalResult = array('msg' => 'error', 'response'=>'Something went wrong!');
			echo json_encode($finalResult);
			exit;
		}
	}

	public function release_payment()
	{
		$data = $this->input->post();
		$details['orders'] = $this->orders_model->get_release_order_detail($data);
		if(!empty($details['orders'])) {
			$htmlrespon = $this->load->view('release_order_payment_ajax', $details, TRUE);
			$finalResult = array('msg' => 'success', 'response'=>$htmlrespon);
			echo json_encode($finalResult);
			exit;
		} else {
			$finalResult = array('msg' => 'error', 'response'=>'Something went wrong!');
			echo json_encode($finalResult);
			exit;
		}
	}

	public function add_release_payment()
	{
		$data = $this->input->post();
		$status= $this->orders_model->release_payments($data);
		if(!empty($status)) {
			$this->send_refund_email($data);
			$finalResult = array('msg' => 'success', 'response'=>'Orders payment successfully released.');
			echo json_encode($finalResult);
			exit;
		} else {
			$finalResult = array('msg' => 'error', 'response'=>'Something went wrong!');
			echo json_encode($finalResult);
			exit;
		}
	}

	public function send_refund_email($data)
	{
		$to = $data['user_email'];
		$subject = "Refund Payment";
		$body = $this->load->view('refund_payment_email', $data, TRUE);
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: '. $subject .' <'.no_reply_email().'>' . "\r\n";
		@mail($to,$subject,$body,$headers);
	}

	public function delete_books()
	{
		$data = $this->input->post();
		$status = $this->orders_model->delete_books($data);
		if($status){
			$finalResult = array('msg' => 'success', 'response'=>'Book successfully deleted.');
			echo json_encode($finalResult);
			exit;
		}else{
			$finalResult = array('msg' => 'error', 'response'=>'Something went wrong!');
			echo json_encode($finalResult);
			exit;
		}
	}

	public function get_export_orders(){
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Order ID');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Order Date');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Buyer Name');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Transaction ID');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Amount');
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Payment Status');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Orders Status');
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Payer Email');
		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'University');
		$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Discount Code');
		$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Discount Type');
		$objPHPExcel->getActiveSheet()->setCellValue('L1', 'Discount Value');
		$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Sub Total');
		$orders = $this->orders_model->get_export_orders(array('1','2'));
		$excel_row = 2;
		foreach($orders as $order){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $order->id);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, date('d/m/Y' , strtotime($order->order_date)));
			if (!empty($order->first_name)) {
				$full_name = $order->first_name.' '.$order->last_name;
			}else{
				$full_name = $order->email;
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $full_name);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $order->trx_id);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $order->trx_amount.' '.'CHF');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, 'Completed');
			if ($order->status == 1) {
				$order_status = 'Pending';
			}else{
				$order_status = 'Processing';
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $order_status);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $order->payer_email);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $order->selected_university);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $order->discount_code);
			if ($order->code_type == 1) {
				$code_type = 'Fixed Value';
			}else if($order->code_type == 2) {
				$code_type = 'Percentage';
			}else{
				$code_type = '';
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $code_type);
			if ($order->code_type == 1) {
				$code_value = $order->code_amount;
			}else if ($order->code_type == 2) {
				$code_value = $order->code_amount.'%';
			}else{
				$code_value = '';
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $code_value);
			if (!empty($order->discount_code)) {
				$sub_total = $order->sub_total.' '.'CHF';
			}else{
				$sub_total = '';
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $sub_total);
			$excel_row++;
		}
		$objPHPExcel_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$filename = 'orders-list'.time().'.xlsx';
		header('Content-Type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=$filename");
		$objPHPExcel_writer->save('php://output');
	}

	public function get_completed_orders(){
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Order ID');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Order Date');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Buyer Name');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Transaction ID');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Amount');
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Payment Status');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Orders Status');
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Payer Email');
		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'University');
		$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Discount Code');
		$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Discount Type');
		$objPHPExcel->getActiveSheet()->setCellValue('L1', 'Discount Value');
		$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Sub Total');
		$orders = $this->orders_model->get_export_orders(array('3'));
		$excel_row = 2;
		foreach($orders as $order){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $order->id);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, date('d/m/Y' , strtotime($order->order_date)));
			if (!empty($order->first_name)) {
				$full_name = $order->first_name.' '.$order->last_name;
			}else{
				$full_name = $order->email;
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $full_name);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $order->trx_id);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $order->trx_amount.' '.'CHF');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, 'Completed');
			if ($order->status == 1) {
				$order_status = 'Pending';
			}else{
				$order_status = 'Processing';
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $order_status);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $order->payer_email);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $order->selected_university);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $order->discount_code);
			if ($order->code_type == 1) {
				$code_type = 'Fixed Value';
			}else if($order->code_type == 2) {
				$code_type = 'Percentage';
			}else{
				$code_type = '';
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $code_type);
			if ($order->code_type == 1) {
				$code_value = $order->code_amount;
			}else if ($order->code_type == 2) {
				$code_value = $order->code_amount.'%';
			}else{
				$code_value = '';
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $code_value);
			if (!empty($order->discount_code)) {
				$sub_total = $order->sub_total.' '.'CHF';
			}else{
				$sub_total = '';
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $sub_total);
			$excel_row++;
		}
		$objPHPExcel_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$filename = 'completed-orders-list'.time().'.xlsx';
		header('Content-Type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=$filename");
		$objPHPExcel_writer->save('php://output');
	}

	public function get_cancelled_orders(){
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Order ID');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Order Date');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Buyer Name');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Transaction ID');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Amount');
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Payment Status');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Orders Status');
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Payer Email');
		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'University');
		$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Discount Code');
		$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Discount Type');
		$objPHPExcel->getActiveSheet()->setCellValue('L1', 'Discount Value');
		$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Sub Total');
		$orders = $this->orders_model->get_export_orders(array('5'));
		$excel_row = 2;
		foreach($orders as $order){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $order->id);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, date('d/m/Y' , strtotime($order->order_date)));
			if (!empty($order->first_name)) {
				$full_name = $order->first_name.' '.$order->last_name;
			}else{
				$full_name = $order->email;
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $full_name);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $order->trx_id);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $order->trx_amount.' '.'CHF');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, 'Completed');
			if ($order->status == 1) {
				$order_status = 'Pending';
			}else{
				$order_status = 'Processing';
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $order_status);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $order->payer_email);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $order->selected_university);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $order->discount_code);
			if ($order->code_type == 1) {
				$code_type = 'Fixed Value';
			}else if($order->code_type == 2) {
				$code_type = 'Percentage';
			}else{
				$code_type = '';
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $code_type);
			if ($order->code_type == 1) {
				$code_value = $order->code_amount;
			}else if ($order->code_type == 2) {
				$code_value = $order->code_amount.'%';
			}else{
				$code_value = '';
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $code_value);
			if (!empty($order->discount_code)) {
				$sub_total = $order->sub_total.' '.'CHF';
			}else{
				$sub_total = '';
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $sub_total);
			$excel_row++;
		}
		$objPHPExcel_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$filename = 'cancelled-orders-list'.time().'.xlsx';
		header('Content-Type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=$filename");
		$objPHPExcel_writer->save('php://output');
	}

}