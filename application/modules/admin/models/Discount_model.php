<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discount_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_discount_codes()
	{
		$this->db->select('*');
		$this->db->from('discount_codes');
		$result = $this->db->get();
		return $result->result_array();
	}

	public function add_discount_code($data)
	{
		$dates = explode('-', $data['daterange']);
		$from_date = date("Y/m/d", strtotime($dates[0]));
		$to_date = date("Y/m/d", strtotime($dates[1]));
		$this->db->set('code', $data['code']);
		$this->db->set('code_type', $data['code_type']);
		$this->db->set('code_value', $data['code_value']);
		$this->db->set('valid_from', $from_date);
		$this->db->set('valid_to', $to_date);
		$this->db->set('created_at', date('Y-m-d H:s:i'));
		$query = $this->db->insert('discount_codes');
		return true;
	}

	public function update_discount_code($data)
	{
		$dates = explode('-', $data['daterange']);
		$from_date = date("Y/m/d", strtotime($dates[0]));
		$to_date = date("Y/m/d", strtotime($dates[1]));
		$this->db->set('code', $data['code']);
		$this->db->set('code_type', $data['code_type']);
		$this->db->set('code_value', $data['code_value']);
		$this->db->set('valid_from', $from_date);
		$this->db->set('valid_to', $to_date);
		$this->db->where('id', $data['id']);
		$query = $this->db->update('discount_codes');
		return true;
	}

	public function get_code_detail($data)
	{
		$this->db->where('id', $data['id']);
		$result = $this->db->get('discount_codes')->row_array();
		return $result;
	}
	public function delete_code($data)
	{
		$this->db->where('id', $data['id']);
		$query = $this->db->delete('discount_codes');
		return $this->db->affected_rows();
	}

	public function check_old_code($data)
	{
		$this->db->select('*');
		$this->db->where('code', $data['code']);
		$this->db->where('id !=', $data['id']);
		$query = $this->db->get('discount_codes');
		return $query->num_rows();
	}
}