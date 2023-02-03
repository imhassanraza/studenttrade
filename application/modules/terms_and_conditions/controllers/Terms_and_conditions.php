<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Terms_and_conditions extends CI_Controller {

    public function __construct() {
        parent::__construct();
        get_site_language();
    }

    public function index() {
        $this->load->view('terms_and_conditions');
    }
}
