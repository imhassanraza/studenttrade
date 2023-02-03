<?php
class login_lib {

		function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->model($this->ci->config->item('admin_controller').'login_model');
		//$this->ci->load->model($this->ci->config->item('admin_controller').'dashboard_model');
	}
	public function validate_login($email,$password)
	{

		$result=$this->ci->login_model->get_login($email,$password);

		if(!empty($result->userid)) {
				$array=array(
					'admin_id'=>$result->userid,
					'admin_username'=>$result->username,
					'admin_email'=>$result->email,
					'admin_login'=>true,
					'admin_logged_in'=>true
				);
				$this->ci->session->set_userdata($array);
				return true;
			}else {
				return false;
			}
	}

}

