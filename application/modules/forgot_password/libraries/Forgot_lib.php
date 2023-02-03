<?php 
class Forgot_lib {

	public function validate_login($email,$password)
	{	
		$this->ci =& get_instance();
		$this->ci->load->model('login/login_model');
		$result=$this->ci->login_model->get_login($email,$password);

		if(count($result)>0)		
			{	
				$array=array(
				'user_id'=>$result->id,
				'username'=>$result->first_name." ".$result->last_name,
				'email'=>$result->email,
				'type'=>$result->type,
				'user_logged_in'=>true
			);
			$this->ci->session->set_userdata($array);
			return true;
			}
			else
			{			
				return false;			
			}
		
	}
	
}

