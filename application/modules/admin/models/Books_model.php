<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Books_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	   		//Do your magic here
	}

	public function get_books_total($keyword = '')
	{
		$this->db->select('*');
		$this->db->from('st_books');
		if(!empty($keyword)) {
			$keyword = trim($keyword);
			$this->db->like('book_name', $keyword);
		}
		$query = $this->db->get();
		return $query->num_rows();
	}


	public function insert_book($data)
	{
		$this->db->set('university', $data["university"]);
		$this->db->set('field_of_study', $data["field_of_study"]);
		if(!empty($data["full_time_semester"])) {
			$this->db->set('full_time_semester',$data["full_time_semester"]);
		} else {
			$this->db->set('full_time_semester',NULL);
		}

		if(!empty($data["part_time_semester"])) {
			$this->db->set('part_time_semester',$data["part_time_semester"]);
		} else {
			$this->db->set('part_time_semester',NULL);
		}

		if(isset($data["only_used"])) {
			$this->db->set('only_used', 1);
		} else {
			$this->db->set('only_used', 0);
		}

		$this->db->set('mandatory_or_optional',  $data["mandatory_or_optional"]);
		$this->db->set('module', $data["module"]);
		$this->db->set('price', $data["price"]);
		$this->db->set('ISBN', $data["ISBN"]);
		$this->db->set('book_name', $data["book_name"]);
		$this->db->set('extra_information', $data["extra_information"]);
		$query = $this->db->insert('st_books');
		if ($this->db->insert_id() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function delete_book($data)
	{
		$this->db->where('id', $data['id']);
		$result = $this->db->delete('st_books');
		return $this->db->affected_rows();
	}

	public function get_books($limit, $start, $keyword = '')
	{
		$this->db->select("*");
		$this->db->from("st_books");
		if(!empty($keyword)) {
			$keyword = trim($keyword);
			$this->db->like('book_name', $keyword);
		}
		$this->db->limit($limit, $start);
		$this->db->order_by("id","desc");
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function get_book_by_id($data)
	{
		$this->db->select("*");
		$this->db->from("st_books");
		$this->db->where('id', $data['id']);
		$query = $this->db->get()->row_array();
		return $query;
	}

	public function update_book($data)
	{
		$this->db->set('university', $data["university"]);
		$this->db->set('field_of_study', $data["field_of_study"]);
		if(!empty($data["full_time_semester"])) {
			$this->db->set('full_time_semester',$data["full_time_semester"]);
		} else {
			$this->db->set('full_time_semester',NULL);
		}

		if(!empty($data["part_time_semester"])) {
			$this->db->set('part_time_semester',$data["part_time_semester"]);
		} else {
			$this->db->set('part_time_semester',NULL);
		}
		if(isset($data["only_used"])) {
			$this->db->set('only_used', 1);
		} else {
			$this->db->set('only_used', 0);
		}
		$this->db->set('mandatory_or_optional',  $data["mandatory_or_optional"]);
		$this->db->set('module', $data["module"]);
		$this->db->set('price', $data["price"]);
		$this->db->set('ISBN', $data["ISBN"]);
		$this->db->set('book_name', $data["book_name"]);
		$this->db->set('extra_information', $data["extra_information"]);
		$this->db->where('id', $data['id']);
		$query = $this->db->update('st_books');
		return true;
	}

	public function get_used_books()
	{
		$this->db->select("st_books.*, users.first_name, users.last_name, users.email, st_used_books.book_condition, st_used_books.is_orderd, st_used_books.id as used_book_id");
		$this->db->from("st_used_books");
		$this->db->join('st_books', 'st_used_books.book_id = st_books.id', 'left');
		$this->db->join('users', 'st_used_books.user_id = users.id', 'left');
		$this->db->where('st_used_books.book_name is NOT NULL', NULL, FALSE);
		$this->db->where('st_used_books.book_id is NOT NULL', NULL, FALSE);
		$this->db->order_by('st_used_books.id', 'desc');
		$query = $this->db->get()->result_array();
		return $query;
	}


	public function insert_books($data)
	{
		$this->db->trans_begin();
		$badge_id = rand(10,100).strtotime(date('Ymdhis'));
		foreach($data['file_data'] as $book)
		{
		  	//  print_r($book); exit;
			//  $this->db->set('user_id',0);
			$this->db->set('university',$book["university"]);
			if(!empty($book["identifier"])) {
				$this->db->set('identifier',$book["identifier"]);
			} else {
				$this->db->set('identifier',NULL);
			}

			$this->db->set('field_of_study',$book["field_of_study"]);
			if(!empty($book["full_time_semester"])) {
				$this->db->set('full_time_semester',$book["full_time_semester"]);
			} else {
				$this->db->set('full_time_semester',NULL);
			}

			if(!empty($book["part_time_semester"])) {
				$this->db->set('part_time_semester',$book["part_time_semester"]);
			} else {
				$this->db->set('part_time_semester',NULL);
			}

			if(empty($book["mandatory_or_optional"])) {
				$this->db->set('mandatory_or_optional',1);
			} elseif($book["mandatory_or_optional"] == 'Ja') {
				$this->db->set('mandatory_or_optional',0);
			} elseif($book["mandatory_or_optional"] == 'Nein') {
				$this->db->set('mandatory_or_optional',1);
			}

			$this->db->set('module',$book["module"]);
			$this->db->set('price',$book["price"]);
			$this->db->set('ISBN',$book["ISBN"]);
			$this->db->set('book_name',$book["book_name"]);
			$this->db->set('extra_information',$book["extra_information"]);
			$this->db->set('only_used', $book["only_used"]);
			$this->db->set('badge_id',$badge_id);
			$this->db->insert('st_books');
		}

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}
	}


	public function delete_used_book($data)
	{
		$this->db->where('id', $data['id']);
		$result = $this->db->delete('st_used_books');
		return $this->db->affected_rows();
	}

	public function export_used_books()
	{
		$this->db->select("st_books.*, users.first_name, users.last_name, users.email, st_used_books.book_condition, st_used_books.is_orderd, st_used_books.id as used_book_id");
		$this->db->from("st_used_books");
		$this->db->join('st_books', 'st_used_books.book_id = st_books.id', 'left');
		$this->db->join('users', 'st_used_books.user_id = users.id', 'left');
		$this->db->order_by('st_used_books.id', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

}

/* End of file Books_model.php */
   /* Location: ./application/modules/admin/models/Books_model.php */