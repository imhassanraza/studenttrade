<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Privacy_policy extends CI_Controller {

    public function __construct() {
        parent::__construct();
        get_site_language();
    }

    public function index() {
    	$data['content'] = "";
        $this->load->view('privacy_policy/index');
    }
}
