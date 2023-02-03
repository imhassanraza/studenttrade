<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Charity extends CI_Controller {

    public function __construct() {
        parent::__construct();
    	get_site_language();
    }

    public function index() {
        $this->load->view('charity');
    }
}
