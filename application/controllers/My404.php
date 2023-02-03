<?php

class My404 extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

    }



    public function index()

    {

    	if($this->session->userdata('admin_logged_in'))

    	{

    		show_admin404();

    	}

    	else

    	{
            $this->output->set_status_header('404');
    		show_404();

    	}



    }

}