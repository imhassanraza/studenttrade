<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Books extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model(admin_controller().'admin_model');
		if(!$this->session->userdata('admin_logged_in'))
		{
			redirect(admin_url().'login');
		}
		$this->load->model(admin_controller().'books_model');
		$this->load->library('csvimport');
		$this->load->library('excel');
		ini_set('memory_limit', '-1');
	}

	public function index()
	{

		$limit_per_page = 50;
		$start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		if($start_index != 0) {
			$start_index = ($start_index * $limit_per_page) - $limit_per_page;
		}

		$total_records = $this->books_model->get_books_total();
		$data['total_books'] = $total_records;
		$data['start_index'] = $start_index;

		if($total_records > 0) {
			$data['books'] = $this->books_model->get_books($limit_per_page, $start_index);


			$config['base_url'] = admin_url() . 'books/index';
			$config['total_rows'] = $total_records;
			$config['per_page'] = $limit_per_page;
			$config["uri_segment"] = 4;

			$config['num_links'] = 5;
			$config['use_page_numbers'] = TRUE;
			$config['reuse_query_string'] = TRUE;

			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';

			$config['first_link'] = 'First';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';

			$config['last_link'] = 'Last';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';

			$config['next_tag_open'] = '<li class="paginate_button page-item next" id="simpletable_next">';
			$config['next_tag_close'] = '</li>';

			$config['prev_tag_open'] = '<li class="paginate_button page-item previous" id="simpletable_previous">';
			$config['prev_tag_close'] = '</li>';

			$config['cur_tag_open'] = '<li class="paginate_button page-item active"><a href="#" class="page-link">';
			$config['cur_tag_close'] = '</a></li>';

			$config['num_tag_open'] = '<li class="paginate_button page-item">';
			$config['num_tag_close'] = '</li>';
			$config['attributes'] = array('class' => 'page-link');

			$this->pagination->initialize($config);

            // build paging links
			$data["links"] = $this->pagination->create_links();


		} else {
			$data['books'] = array();
		}


		$this->load->view('books' , $data);
	}

	public function used_books()
	{
		$data['books'] = $this->books_model->get_used_books();
		$this->load->view('used_books' , $data);
	}

	public function add()
	{
		$data = $_POST;
		$status = $this->books_model->insert_book($data);
		if($status){
			$finalResult = array('msg' => 'success', 'response'=>'<p>Book successfully inserted!</p>');
			echo json_encode($finalResult);
			exit;
		}else{
			$finalResult = array('msg' => 'error', 'response'=>'<p>Something went wrong!</p>');
			echo json_encode($finalResult);
			exit;
		}
	}

	public function edit()
	{
		$data = $_POST;
		$details['book'] = $this->books_model->get_book_by_id($data);
		if(!empty($details['book'])) {
			$htmlrespon = $this->load->view('edit_books_ajax', $details, TRUE);
			$finalResult = array('msg' => 'success', 'response'=>$htmlrespon);
			echo json_encode($finalResult);
			exit;
		} else {
			$finalResult = array('msg' => 'error', 'response'=>'Something went wrong!');
			echo json_encode($finalResult);
			exit;
		}
	}


	public function update()
	{
		$data = $_POST;
		$status = $this->books_model->update_book($data);
		if($status){
			$finalResult = array('msg' => 'success', 'response'=>'<p>Book successfully updated!</p>');
			echo json_encode($finalResult);
			exit;
		}else{
			$finalResult = array('msg' => 'error', 'response'=>'<p>Something went wrong!</p>');
			echo json_encode($finalResult);
			exit;
		}
	}

	public function delete()
	{
		$data = $_POST;
		$status = $this->books_model->delete_book($data);
		if($status){
			$finalResult = array('msg' => 'success', 'response'=>'Book successfully deleted!');
			echo json_encode($finalResult);
			exit;
		}else{
			$finalResult = array('msg' => 'error', 'response'=>'<p>Something went wrong!</p>');
			echo json_encode($finalResult);
			exit;
		}
	}

		//upload CSV file
	function upload_books_csv_old()
	{

		if(!empty($_FILES['bookscsv']['name'])) {

			$filename = $_FILES['bookscsv']['name'];
			$ext=substr($filename,strrpos($filename,"."),(strlen($filename)-strrpos($filename,".")));

			if($ext == ".csv")
			{


				$file_data = $this->csvimport->get_array($_FILES['bookscsv']['tmp_name']);

				//get CSV file columns
				$csvfields = xss_clean(array_keys(($file_data[0])));

				//get stores database table columns list
				$dbfields = $this->db->list_fields('st_books');

				//extra columns array
				$delete_val  = array('id','badge_id');

				//remove extra colums from database stores colums array
				foreach($delete_val as $key){
					$keyToDelete = array_search($key, $dbfields);
					unset($dbfields[$keyToDelete]);
				}

				//calculate CSV file columns and database table columns
				$feilds_required = array_diff($dbfields,$csvfields);

				//if feilds are missing in CSV file
				if(!empty($feilds_required)) {
					$errors = 'Missing fields in CSV<br>';
					foreach ($feilds_required as $key => $value) {
						$errors .= $value."<br>";
					}
					$finalResult = array('msg' => 'error', 'response'=>$errors);
					echo json_encode($finalResult);
					exit;
				}

				$data['file_data'] = $file_data;

				$result = $this->books_model->insert_books($data);

				if($result) {
					$finalResult = array('msg' => 'success', 'response'=>"CSV File has been successfully Imported.");
					echo json_encode($finalResult);
					exit;
				} else {
					$finalResult = array('msg' => 'error', 'response'=>"Failed to insert the file.");
					echo json_encode($finalResult);
					exit;
				}

			} else {
				$finalResult = array('msg' => 'error', 'response'=>"Please Upload only CSV File.");
				echo json_encode($finalResult);
				exit;
			}

		} else {
			$finalResult = array('msg' => 'error', 'response'=>"Please Select a CSV File.");
			echo json_encode($finalResult);
			exit;
		}
	}

	function upload_books_csv()
	{
		$data['file_data'] = array();

		if(!empty($_FILES['bookscsv']['name'])) {

			$filename = $_FILES['bookscsv']['name'];
			$ext=substr($filename,strrpos($filename,"."),(strlen($filename)-strrpos($filename,".")));
			if($ext == ".xlsx")
			{

				$path = $_FILES["bookscsv"]["tmp_name"];
				$object = PHPExcel_IOFactory::load($path);

				$dbfields = $this->db->list_fields('st_books');
				$delete_val  = array('id','badge_id');

				$csvfields = array();

				foreach($object->getWorksheetIterator() as $worksheet)
				{
					$csvfields[] = $worksheet->getCellByColumnAndRow(0, 1)->getValue();
					$csvfields[] = $worksheet->getCellByColumnAndRow(1, 1)->getValue();
					$csvfields[] = $worksheet->getCellByColumnAndRow(2, 1)->getValue();
					$csvfields[] = $worksheet->getCellByColumnAndRow(3, 1)->getValue();
					$csvfields[] = $worksheet->getCellByColumnAndRow(4, 1)->getValue();
					$csvfields[] = $worksheet->getCellByColumnAndRow(5,1)->getValue();
					$csvfields[] = $worksheet->getCellByColumnAndRow(6,1)->getValue();
					$csvfields[] = $worksheet->getCellByColumnAndRow(7,1)->getValue();
					$csvfields[] = $worksheet->getCellByColumnAndRow(8,1)->getValue();
					$csvfields[] = $worksheet->getCellByColumnAndRow(9,1)->getValue();
					$csvfields[] = $worksheet->getCellByColumnAndRow(10,1)->getValue();
					$csvfields[] = $worksheet->getCellByColumnAndRow(11,1)->getValue();
					break;
				}

				foreach($delete_val as $key){
					$keyToDelete = array_search($key, $dbfields);
					unset($dbfields[$keyToDelete]);
				}
				$feilds_required = array_diff($dbfields,$csvfields);

				if(!empty($feilds_required)) {
					$errors = 'Missing fields in XLSX<br>';
					foreach ($feilds_required as $key => $value) {
						$errors .= $value."<br>";
					}
					$finalResult = array('msg' => 'error', 'response'=>$errors);
					echo json_encode($finalResult);
					exit;
				}


				foreach($object->getWorksheetIterator() as $worksheet)
				{
					$highestRow = $worksheet->getHighestRow();
					$highestColumn = $worksheet->getHighestColumn();

					for($row=2; $row <= $highestRow; $row++)
					{
						$university = $worksheet->getCellByColumnAndRow(0, $row)->getValue();

				// 		if(empty($university)) {
				// 			continue;
				// 		}

						$identifier = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
						$field_of_study = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
						$full_time_semester = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
						$part_time_semester = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
						$mandatory_or_optional = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
						$module = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
						$price = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
						$ISBN = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
						$book_name = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
						$extra_information = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
						$only_used = $worksheet->getCellByColumnAndRow(11, $row)->getValue();

				// 		echo $book_name."<br>";
						$data['file_data'][] = array(
							'university' =>	$university,
							'identifier' =>	$identifier,
							'field_of_study' =>	$field_of_study,
							'full_time_semester' =>	$full_time_semester,
							'part_time_semester' =>	$part_time_semester,
							'mandatory_or_optional'	=>	$mandatory_or_optional,
							'module' =>	$module,
							'price' =>	$price,
							'ISBN' => $ISBN,
							'book_name' =>	$book_name,
							'extra_information' =>	$extra_information,
							'only_used' =>	$only_used
						);


					}

				}

				$result = $this->books_model->insert_books($data);

				if($result) {
					$finalResult = array('msg' => 'success', 'response'=>"XLSX File has been successfully Imported.");
					echo json_encode($finalResult);
					exit;
				} else {
					$finalResult = array('msg' => 'error', 'response'=>"Failed to insert the file.");
					echo json_encode($finalResult);
					exit;
				}

			} else {
				$finalResult = array('msg' => 'error', 'response'=>"Please Upload only xlsx File.");
				echo json_encode($finalResult);
				exit;
			}

		} else {
			$finalResult = array('msg' => 'error', 'response'=>"Please Select a xlsx File.");
			echo json_encode($finalResult);
			exit;
		}
	}


	public function downloadbookscsv()
	{

		//get stores database table columns list
		$dbfields = $this->db->list_fields('st_books');

		//extra columns array
		$delete_val  = array('id','badge_id');

		//remove extra colums from database stores colums array
		foreach($delete_val as $key){
			$keyToDelete = array_search($key, $dbfields);
			unset($dbfields[$keyToDelete]);
		}

				// file name
		$filename = date('dmY').'_books.csv';
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=$filename");
		// header("Content-Type: application/csv; ");
		header('Content-Type: text/csv; charset=UTF-8');

   				// file creation
		$file = fopen('php://output', 'w+');

		fputcsv($file, $dbfields);

		foreach ($dbfields as $key) {
			$this->db->select($key);
		}
		$books = $this->db->get('st_books')->result_array();

		foreach ($books as $key=>$line){
			fputcsv($file,$line);
		}

		fclose($file);
		exit;

	}


	public function downloadcsv()
	{

		//get stores database table columns list
		$dbfields = $this->db->list_fields('st_books');

		//extra columns array
		$delete_val  = array('id','badge_id');

		//remove extra colums from database stores colums array
		foreach($delete_val as $key){
			$keyToDelete = array_search($key, $dbfields);
			unset($dbfields[$keyToDelete]);
		}

				// file name
		$filename = date('dmY').'_books.csv';
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=$filename");
		header("Content-Type: application/csv; ");

   				// file creation
		$file = fopen('php://output', 'w+');

		fputcsv($file, $dbfields);

		fclose($file);
		exit;

	}

	public function delete_used_books()
	{
		$data = $_POST;
		$status = $this->books_model->delete_used_book($data);
		if($status){
			$finalResult = array('msg' => 'success', 'response'=>'Book successfully deleted!');
			echo json_encode($finalResult);
			exit;
		}else{
			$finalResult = array('msg' => 'error', 'response'=>'<p>Something went wrong!</p>');
			echo json_encode($finalResult);
			exit;
		}
	}

}