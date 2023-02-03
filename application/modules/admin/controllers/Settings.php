<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('admin_logged_in'))
		{
			redirect(admin_url().'login');
		}
		$this->load->model(admin_controller().'settings_model');
	}

	public function index()
	{
		$this->load->view('settings');
	}

	function general_settings($para1 = "")
	{

		if ($para1 == "") {
			redirect(admin_url().'settings', 'refresh');
		}elseif ($para1=="update_home") {
			$this->db->set('meta_value' , $this->input->post('welcome_text_english'));
			$this->db->where('page', 'home');
			$this->db->where('meta_key', 'welcome_text_english');
			$this->db->update('settings');

			$this->db->set('meta_value' , $this->input->post('welcome_text_german'));
			$this->db->where('page', 'home');
			$this->db->where('meta_key', 'welcome_text_german');
			$this->db->update('settings');

			$this->db->set('meta_value' , $this->input->post('welcome_desc_english'));
			$this->db->where('page', 'home');
			$this->db->where('meta_key', 'welcome_desc_english');
			$this->db->update('settings');

			$this->db->set('meta_value' , $this->input->post('welcome_desc_german'));
			$this->db->where('page', 'home');
			$this->db->where('meta_key', 'welcome_desc_german');
			$this->db->update('settings');

			$this->db->set('meta_value' , $this->input->post('footer_text_english'));
			$this->db->where('page', 'home');
			$this->db->where('meta_key', 'footer_text_english');
			$this->db->update('settings');

			$this->db->set('meta_value' , $this->input->post('footer_text_german'));
			$this->db->where('page', 'home');
			$this->db->where('meta_key', 'footer_text_german');
			$this->db->update('settings');

			$this->session->set_flashdata('alert_success', 'You Have Successfully Edited The Settings!');

			if(!empty($_FILES['banner_image']['name'])){

				$config['upload_path']          = FCPATH.'assets/images/';
				$config['allowed_types']        = 'gif|jpg|png|jpeg';
				$config['max_size']             = 5000;
				$config['max_width']            = 1950;
				$config['max_height']           = 1060;
				$config['encrypt_name'] 		= TRUE;

				$this->load->library('upload', $config);

				if($this->upload->do_upload('banner_image')){

					$upload_data = $this->upload->data();
					$data['banner_image'] = $upload_data['file_name'];

					$this->db->set('meta_value' , $data['banner_image']);
					$this->db->where('page', 'home');
					$this->db->where('meta_key', 'banner_image');
					$this->db->update('settings');

					$this->session->set_flashdata('alert_success', 'You Have Successfully Edited The Settings!');

				}else{
					$this->session->set_flashdata('alert_error', $this->upload->display_errors());
				}
			}

			redirect(admin_url().'settings', 'refresh');
		} elseif ($para1 == "update_contact_us") {

			$this->db->set('meta_value' , $this->input->post('contactus_address'));
			$this->db->where('page', 'contactus');
			$this->db->where('meta_key', 'contactus_address');
			$this->db->update('settings');

			$this->db->set('meta_value' , $this->input->post('contactus_phone'));
			$this->db->where('page', 'contactus');
			$this->db->where('meta_key', 'contactus_phone');
			$this->db->update('settings');


			$this->db->set('meta_value' , $this->input->post('contactus_email'));
			$this->db->where('page', 'contactus');
			$this->db->where('meta_key', 'contactus_email');
			$this->db->update('settings');


			$this->session->set_flashdata('alert_success', 'You Have Successfully Edited The Settings!');
			redirect(admin_url().'settings', 'refresh');

		} elseif ($para1=="update_social_links") {

			$this->db->set('meta_value' , $this->input->post('facebook'));
			$this->db->where('page', 'social_links');
			$this->db->where('meta_key', 'facebook');
			$this->db->update('settings');

			$this->db->set('meta_value' , $this->input->post('twitter'));
			$this->db->where('page', 'social_links');
			$this->db->where('meta_key', 'twitter');
			$this->db->update('settings');

			$this->db->set('meta_value' , $this->input->post('instagram'));
			$this->db->where('page', 'social_links');
			$this->db->where('meta_key', 'instagram');
			$this->db->update('settings');

			$this->session->set_flashdata('alert_success', 'You Have Successfully Edited The Settings!');
			redirect(admin_url().'settings', 'refresh');
		} elseif ($para1=="update_aboutus") {
			
			$this->db->set('meta_value' , $this->input->post('aboutus_text1_english'));
			$this->db->where('page', 'aboutus');
			$this->db->where('meta_key', 'about_us_english');
			$this->db->update('settings');

			$this->db->set('meta_value' , $this->input->post('aboutus_text1_german'));
			$this->db->where('page', 'aboutus');
			$this->db->where('meta_key', 'about_us_german');
			$this->db->update('settings');

			$this->session->set_flashdata('alert_success', 'You Have Successfully Edited The Settings!');
			redirect(admin_url().'settings', 'refresh');

		} elseif ($para1=="update_charity") {

			$this->db->set('meta_value' , $this->input->post('charity1_english'));
			$this->db->where('page', 'charity');
			$this->db->where('meta_key', 'charity_english');
			$this->db->update('settings');

			$this->db->set('meta_value' , $this->input->post('charity1_german'));
			$this->db->where('page', 'charity');
			$this->db->where('meta_key', 'charity_german');
			$this->db->update('settings');


			$this->session->set_flashdata('alert_success', 'You Have Successfully Edited The Settings!');
			redirect(admin_url().'settings', 'refresh');
		} elseif ($para1=="how_it_works") {

			$this->db->set('meta_value' , $this->input->post('how_it_works_english'));
			$this->db->where('page', 'how_it_works');
			$this->db->where('meta_key', 'how_it_works_english');
			$this->db->update('settings');

			$this->db->set('meta_value' , $this->input->post('how_it_works_german'));
			$this->db->where('page', 'how_it_works');
			$this->db->where('meta_key', 'how_it_works_german');
			$this->db->update('settings');


			$this->session->set_flashdata('alert_success', 'You Have Successfully Edited The Settings!');
			redirect(admin_url().'settings', 'refresh');
		} elseif ($para1=="update_terms_and_conditions") {
			$this->db->set('meta_value' , $this->input->post('tcondition1_english'));
			$this->db->where('page', 'termconditions');
			$this->db->where('meta_key', 'termconditions_english');
			$this->db->update('settings');

			$this->db->set('meta_value' , $this->input->post('tcondition1_german'));
			$this->db->where('page', 'termconditions');
			$this->db->where('meta_key', 'termconditions_german');
			$this->db->update('settings');

			$this->session->set_flashdata('alert_success', 'You Have Successfully Edited The Settings!');
			redirect(admin_url().'settings', 'refresh');
		}elseif ($para1=="update_privacy_policy") {
			$this->db->set('meta_value' , $this->input->post('ppolicy1_english'));
			$this->db->where('page', 'privacypolicy');
			$this->db->where('meta_key', 'privacypolicy_english');
			$this->db->update('settings');

			$this->db->set('meta_value' , $this->input->post('ppolicy1_german'));
			$this->db->where('page', 'privacypolicy');
			$this->db->where('meta_key', 'privacypolicy_german');
			$this->db->update('settings');

			$this->session->set_flashdata('alert_success', 'You Have Successfully Edited The Settings!');
			redirect(admin_url().'settings', 'refresh');
		}
	}

}