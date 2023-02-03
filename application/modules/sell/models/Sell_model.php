<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sell_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	   		//Do your magic here
	}

	public function get_universities()
	{
		$this->db->distinct();
		$this->db->select('university');
		$this->db->where('university !=', NULL);
		$this->db->order_by('university', 'DESC');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}

	public function fields_of_study()
	{
		$this->db->distinct();
		$this->db->select('field_of_study');
		$this->db->where('university', get_session('university'));
		$this->db->order_by('field_of_study', 'ASC');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}

	public function get_semesters()
	{
		$this->db->distinct();
		if(get_session('study_type') == 'Full Time') {
			$this->db->select('full_time_semester as semester');
			$this->db->where('full_time_semester !=', NULL);
		} else {
			$this->db->select('part_time_semester as semester');
			$this->db->where('part_time_semester !=', NULL);
		}
		$this->db->where('university', get_session('university'));
		$this->db->where('field_of_study', get_session('field_of_study'));
		if(get_session('study_type') == 'Full Time') {
			$this->db->order_by('full_time_semester', 'ASC');
		} else {
			$this->db->order_by('part_time_semester', 'ASC');
		}
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}

	public function get_books()
	{
		$this->db->select('*');
		if(get_session('study_type') == 'Full Time') {
			$this->db->select('full_time_semester as semester');
		} else {
			$this->db->select('part_time_semester as semester');
		}
		$this->db->where('university', get_session('university'));
		$this->db->where('field_of_study', get_session('field_of_study'));
		if (get_session('university') == 'ZHAW') {
			if(get_session('study_type') == 'Full Time') {
				$this->db->where_in('full_time_semester',get_session('sell_semester'));
			} else {
				$this->db->where_in('part_time_semester', get_session('sell_semester'));
			}
		}
		$this->db->where('price >', 0);
		if(get_session('study_type') == 'Full Time') {
			$this->db->order_by('full_time_semester', 'ASC');
		} else {
			$this->db->order_by('part_time_semester', 'ASC');
		}
		$this->db->order_by('mandatory_or_optional', 'ASC');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}

	public function get_modules()
	{
		$this->db->select('module');
		$this->db->where('university', get_session('university'));
		// $this->db->where('field_of_study', get_session('field_of_study'));
		if(get_session('study_type') == 'Full Time') {
			$this->db->where('full_time_semester',NULL);
		} else {
			$this->db->where('part_time_semester',NULL);
		}
		$this->db->order_by('module', 'ASC');
		$this->db->group_by('module');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}

	public function get_more_books($op_module = '')
	{
		$this->db->select('*');
		$this->db->where('university', get_session('university'));
		// $this->db->where('field_of_study', get_session('field_of_study'));
		if(get_session('study_type') == 'Full Time') {
			$this->db->select('full_time_semester as semester');
			$this->db->where('full_time_semester',NULL);
		} else {
			$this->db->select('part_time_semester as semester');
			$this->db->where('part_time_semester',NULL);
		}
		$this->db->where('price >', 0);
		$this->db->like('module',$op_module);
		// $this->db->where_in('module',$op_module); // For New Working
		$this->db->order_by('mandatory_or_optional', 'ASC');
		$this->db->group_by('module');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}

	public function add_books_to_market($data)
	{
		$this->db->trans_begin();
		$check = 0;

		$books = array_unique($data['sell_books']);

		foreach ($books as $key => $value) {
			$book = get_books_detail($value);
			$this->db->set('book_name' , $book['book_name']);
			$this->db->set('book_id' , $value);
			$this->db->set('book_condition' ,'1');
			$this->db->set('user_id' , get_session('user_id'));
			$query = $this->db->insert('st_used_books');
			$check = 1;
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		} else {
			$this->db->trans_commit();

			if($check) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function get_book_details($book_id)
	{
		$this->db->select('*');
		$this->db->from('st_books');
		$this->db->where('id' ,$book_id);
		$query = $this->db->get()->row_array();
		return $query;
	}


	public function get_other_uni_books($op_module)
	{
		$this->db->select('*');
		$this->db->where('university', get_session('university'));
		$this->db->where_in('module', $op_module);
		$this->db->where('price >', 0);
		$this->db->group_by('book_name');
		$this->db->order_by('mandatory_or_optional', 'ASC');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}

	public function get_other_modules()
	{
		$this->db->select('module');
		$this->db->where('university', get_session('university'));
		if (get_session('university') == 'Universität St. Gallen (HSG)') {
			$this->db->where('field_of_study', get_session('field_of_study'));
		}
		$this->db->order_by('module', 'ASC');
		$this->db->group_by('module');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}



	/* ------------Working on 27/08/2020-------------- */
	public function get_all_uni_books()
	{
		$this->db->select('*');
		$this->db->where('price >', 0);
		$this->db->order_by('mandatory_or_optional', 'ASC');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}

	public function get_all_modules()
	{
		$this->db->select('module');
		$this->db->order_by('module', 'ASC');
		$this->db->group_by('module');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}

	public function get_all_module_books($op_module)
	{
		$this->db->select('*');
		$this->db->where_in('module', $op_module);
		$this->db->where('price >', 0);
		$this->db->group_by('book_name');
		$this->db->order_by('mandatory_or_optional', 'ASC');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}


}

/* End of file Sell_model.php */
   /* Location: ./application/modules/admin/models/Sell_model.php */