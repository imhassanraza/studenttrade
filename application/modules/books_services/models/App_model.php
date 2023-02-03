<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_university($identifier)
	{
		$this->db->distinct();
		$this->db->select("university");
		$this->db->from("st_books");
		$this->db->where('identifier', $identifier);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function is_valid_university($university)
	{
		$this->db->distinct();
		$this->db->select("university");
		$this->db->from("st_books");
		$this->db->where('university', $university);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_books($identifiers,$university)
	{
		$this->db->select("book_name as title, only_used, price as priceInFrancs, IF(price > 0.00, true,false) as available", FALSE);
		$this->db->from("st_books");
		$this->db->where('university', $university);
		$this->db->where('identifier', $identifiers);
		// $this->db->where('only_used', 1);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_books_by_identifier($identifiers,$university)
	{
		$this->db->select('*');
		$this->db->where('university', $university);
		$this->db->where_in('identifier', explode(",", $identifiers));
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}

	public function get_universities($identifiers)
	{
		$this->db->distinct();
		$this->db->select('university');
		$this->db->where_in('identifier', explode(",", $identifiers));
		$this->db->order_by('university', 'ASC');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}

	public function get_selected_modules($identifiers,$university)
	{
		$this->db->select('module');
		$this->db->where('university', $university);
		$this->db->where_in('identifier', explode(",", $identifiers));
		$this->db->order_by('module', 'ASC');
		$this->db->group_by('module');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}

	public function get_modules($university)
	{
		$this->db->select('module, identifier');
		$this->db->where('identifier != ', NULL);
		// $this->db->where_in('university', $universities);
		$this->db->where('university', $university);
		$this->db->order_by('module', 'ASC');
		$this->db->group_by('module');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}

	public function get_buy_books($university, $identifiers, $op_module)
	{
		$this->db->select('*');
		$this->db->where('university', $university);
		$this->db->where_in('identifier', $identifiers);
		$this->db->where_in('module', $op_module);
		$this->db->group_by('book_name');
		$this->db->order_by('mandatory_or_optional', 'ASC');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}

	public function get_sell_books_by_identifier($identifiers,$university)
	{
		$this->db->select('*');
		$this->db->where('university', $university);
		$this->db->where_in('identifier', explode(",", $identifiers));
		$this->db->where('price >', 0);
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}

	public function get_sell_books($data)
	{
		$this->db->select('*');
		$this->db->where('identifier != ', NULL);
		$this->db->where('price >', 0);
		$this->db->where('university', $data['university']);
		$this->db->where_in('module', $data['optional_module']);
		$this->db->group_by('book_name');
		$this->db->order_by('mandatory_or_optional', 'ASC');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}


	public function get_book_details($book_id)
	{
		$this->db->select('*');
		$this->db->from('st_books');
		$this->db->where('id' ,$book_id);
		$query = $this->db->get()->row_array();

		$this->db->where('book_name', $query['book_name']);
		$this->db->where('is_orderd', 0);
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$used_book = $this->db->get('st_used_books')->row_array();

		$query['book_condition'] = 0;
		$query['user_id'] = 0;
		$query['used_book_id'] = 0;
		if(!empty($used_book['id'])) {
			$query['user_id'] = $used_book['user_id'];
			$query['book_condition'] = $used_book['book_condition'];
			$query['used_book_id'] = $used_book['id'];

			if($used_book['book_condition']) {
				$query['price'] = $query['price'] * (60/100);
			} else {
				$query['price'] = $query['price'] * (70/100);
			}
		}
		return $query;
	}

}
