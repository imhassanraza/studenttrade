<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buy_model extends CI_Model {

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
		$this->db->where('university', get_session('university'));
		$this->db->where('field_of_study', get_session('field_of_study'));
		if (get_session('university') == 'ZHAW') {
			if(get_session('study_type') == 'Full Time') {
				$this->db->where('full_time_semester',get_session('semester'));
			} else {
				$this->db->where('part_time_semester', get_session('semester'));
			}
		}
		$this->db->order_by('price', 'DESC');
		$this->db->order_by('mandatory_or_optional', 'ASC');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}

	public function get_modules()
	{
		$this->db->select('module');
		$this->db->where('university', get_session('university'));
		if (get_session('university') == 'ZHAW') {
			if(get_session('study_type') == 'Full Time') {
				$this->db->where('full_time_semester',NULL);
			} else {
				$this->db->where('part_time_semester',NULL);
			}
		}
		if (get_session('university') == 'Universität St. Gallen (HSG)') {
			$this->db->where('field_of_study', get_session('field_of_study'));
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
			$this->db->where('full_time_semester',NULL);
		} else {
			$this->db->where('part_time_semester',NULL);
		}
		$this->db->like('module',$op_module);
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

	public function get_other_uni_books($op_module)
	{
		$this->db->select('*');
		$this->db->where('university', get_session('university'));
		$this->db->where_in('module',$op_module);
		$this->db->group_by('book_name');
		$this->db->order_by('price', 'DESC');
		$this->db->order_by('mandatory_or_optional', 'ASC');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}

	public function close_alert()
	{
		$this->db->set('show_payout_alert', 0);
		$this->db->where('id', get_session('user_id'));
		$this->db->update('users');
		return $this->db->affected_rows();
	}

	/* -------------- Working on 27/08/2020 ------------ */

	public function get_all_modules()
	{
		$this->db->select('module');
		$this->db->order_by('module', 'ASC');
		$this->db->group_by('module');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}

	public function get_all_uni_books()
	{
		$this->db->select('*');
		$this->db->order_by('mandatory_or_optional', 'ASC');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}

	public function get_all_module_books($op_module)
	{
		$this->db->select('*');
		$this->db->where_in('module', $op_module);
		$this->db->group_by('book_name');
		$this->db->order_by('mandatory_or_optional', 'ASC');
		$query = $this->db->get('st_books')->result_array();
		return $query;
	}


}

/* End of file Home_model.php */
   /* Location: ./application/modules/admin/models/Add_listing_model.php */