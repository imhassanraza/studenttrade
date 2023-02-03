<?php 
class Admin_lib {

   public function __construct()
   {
	   	parent::__construct();
	   	$this->ci =& get_instance();
		$this->ci->load->model($this->ci->config->item('admin_controller').'admin_model');
   }

}

