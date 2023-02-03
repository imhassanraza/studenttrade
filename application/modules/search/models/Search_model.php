<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	   		//Do your magic here
	}

	public function get_search_result($book_name = '')
	{
		$clean_query = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $book_name)));
		$search_queries = explode(' ', $clean_query);
		$this->db->select('*');
		$this->db->from('st_books');
		$this->db->like('book_name', $book_name);

		foreach($search_queries as $search_query){
			$this->db->or_like('book_name', $search_query);
		}

		if( count($search_queries) > 1) {
			$this->db->limit(100);
		}

		$this->db->group_by('book_name');
		$this->db->order_by('price', 'DESC');
		$this->db->order_by('mandatory_or_optional', 'ASC');
		$books = $this->db->get()->result_array();
		$final_books = array();
		foreach ($books as $book) {
			if($book['only_used']) {
				if(!empty(get_used_book_detail($book['book_name']))) {
					$final_books[] = $book;
				}
			} else {
				$final_books[] = $book;
			}
		}
		return $final_books;
	}

	public function get_search_books_for_sell($book_name = '', $sell_books = array())
	{
		$this->db->select('*');
		if (get_session('university') == 'ZHAW') {
			$this->db->where("(price > 0 ) AND (book_name LIKE '%".$book_name."%' OR module LIKE '%".$book_name."%')");
		}else{
			$this->db->where('price > ', 0);
			$this->db->like('book_name', $book_name);
		}
		if(!empty($sell_books)) {
			$this->db->where_not_in('id', array_unique($sell_books));
		}
		$this->db->group_by('book_name');
		$this->db->order_by('mandatory_or_optional', 'ASC');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}

	public function get_search_books_for_sell1($book_name = '')
	{
		$this->db->select('*');
		if (get_session('university') == 'ZHAW') {
			$this->db->where("(price > 0 ) AND (book_name LIKE '%".$book_name."%' OR module LIKE '%".$book_name."%')");
		}else{
			$this->db->where('price > ', 0);
			$this->db->like('book_name', $book_name);
		}
		$this->db->where_not_in('id', array_unique(get_session('sell_session_new')));
		$this->db->group_by('book_name');
		$this->db->order_by('mandatory_or_optional', 'ASC');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}

	public function get_selected_books($data = '')
	{
		if(!empty($data['sell_books'])) {
			$this->db->select('*');
			$this->db->where('price > ', 0);
			$this->db->where_in('id', array_unique($data['sell_books']));
			// $this->db->group_by('book_name');
			$this->db->order_by('mandatory_or_optional', 'ASC');
			$query = $this->db->get('st_books')->result_array();
			return $query;
		} else {
			return array();
		}
	}

	public function get_selected_books1()
	{
		$this->db->select('*');
		$this->db->where('price > ', 0);
		$this->db->where_in('id', array_unique(get_session('sell_session_new')));
		// $this->db->group_by('book_name');
		$this->db->order_by('mandatory_or_optional', 'ASC');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}

	public function get_books_serach_field()
	{
		$this->db->select('*');
		if(get_session('study_type') == 'Full Time') {
			$this->db->select('full_time_semester as semester');
		} else {
			$this->db->select('part_time_semester as semester');
		}
		$this->db->where('university', get_session('university'));
		$this->db->where('field_of_study', get_session('field_of_study'));
		if(get_session('study_type') == 'Full Time') {
			$this->db->where_in('full_time_semester',get_session('sell_semester'));
		} else {
			$this->db->where_in('part_time_semester', get_session('sell_semester'));
		}
		$this->db->where('price >', 0);
		$this->db->order_by('mandatory_or_optional', 'ASC');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}

}

/* End of file search_model.php */