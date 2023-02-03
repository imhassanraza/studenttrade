<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Languageswitcher extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	}

    function switchlang($language = "") {
        $language = ($language != "") ? $language : "german";
        $this->session->set_userdata('site_lang',$language);
        redirect($_SERVER['HTTP_REFERER']);
    }

}