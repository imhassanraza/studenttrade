<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Location: ./system/helpers/array_helper.php */
if (!function_exists('admin_url'))
{
	function admin_url()
	{
		$CI = get_instance();
		return $CI->config->item('admin_url');
	}
}

if (!function_exists('no_reply_email'))
{
	function no_reply_email()
	{
		$CI = get_instance();
		return $CI->config->item('no_reply_email');
	}
}

if (!function_exists('admin_email_address'))
{
	function admin_email_address()
	{
		$CI = get_instance();
		return $CI->config->item('admin_email_address');
	}
}

if (!function_exists('admin_controller'))
{
	function admin_controller()
	{
		$CI = get_instance();
		return $CI->config->item('admin_controller');
	}
}

if ( ! function_exists('show_admin404'))
{
	function show_admin404()
	{
		$CI = get_instance();
		return $CI->load->view('common/admin_error_page');
	}
}

if (!function_exists('in_cart'))
{
	function in_cart($book_id) {
		$CI = & get_instance();
		$my_cart = $CI->cart->contents();
		if(!empty($my_cart)) {
			$check = 0;
			foreach($my_cart as $cart_details){
				if($cart_details['id'] == $book_id) {
					$check = 1;
					break;
				}
			}
			if($check) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}

if (!function_exists('get_cart_details'))
{
	function get_cart_details($book_id) {
		$CI = & get_instance();
		$my_cart = $CI->cart->contents();
		if(!empty($my_cart)) {
			foreach($my_cart as $cart_details) {
				if($cart_details['id'] == $book_id) {
					return $cart_details;
				}
			}
			return array();
		} else {
			return array();
		}
	}
}

if (!function_exists('fb_login'))
{
	function fb_login()
	{
		$CI = get_instance();
		return $CI->facebook->login_url();
	}
}

if (!function_exists('get_session'))
{
	function get_session($session_name)
	{
		$CI = get_instance();
		return $CI->session->userdata($session_name);
	}
}

if (!function_exists('set_session'))
{
	function set_session($session_name, $value)
	{
		$CI = get_instance();
		return $CI->session->set_userdata($session_name, $value);
	}
}

if (!function_exists('unset_session'))
{
	function unset_session($session_name)
	{
		$CI = get_instance();
		return $CI->session->unset_userdata($session_name);
	}
}

if (!function_exists('admin_email'))
{
	function admin_email()
	{
		return get_section_content('contactus' , 'contactus_email');
	}
}

if (!function_exists('get_username_old'))
{
	function get_username_old()
	{
		$CI =& get_instance();
		$CI->db->select('CONCAT(first_name," ",last_name) as username');
		$CI->db->where('id',get_session('user_id'));
		$CI->db->from('users');
		$query = $CI->db->get();
		$query = $query->row_array();
		return $query['username'];
	}
}

if (!function_exists('get_username'))
{
	function get_username()
	{
		$CI =& get_instance();
		$CI->db->select('first_name as username');
		$CI->db->where('id', get_session('user_id'));
		$CI->db->from('users');
		$query = $CI->db->get();
		$query = $query->row_array();
		return $query['username'];
	}
}

if (!function_exists('get_paypal_email'))
{
	function get_paypal_email()
	{
		$CI =& get_instance();
		$CI->db->select('paypal_email');
		$CI->db->from('users');
		$CI->db->where('id' , get_session('user_id'));
		$query = $CI->db->get()->row_array();
		return  $query['paypal_email'];
	}
}

if (!function_exists('get_count_users'))
{
	function get_count_users($status)
	{
		$CI =& get_instance();
		return $CI->db->where(['status'=>$status])->from("users")->count_all_results();
	}
}

if (!function_exists('profile_updated'))
{
	function profile_updated()
	{
		$CI =& get_instance();
		$CI->db->select('profile_updated');
		$CI->db->where('id',get_session('user_id'));
		$CI->db->from('users');
		$query = $CI->db->get()->row_array();
		return $query['profile_updated'];

	}
}

if (!function_exists('get_owner_detail'))
{
	function get_owner_detail($id)
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->where('id',$id);
		$CI->db->from('users');
		$query = $CI->db->get();
		return $query->row_array();
	}
}

if (!function_exists('get_section_content'))
{
	function get_section_content($page , $meta_key)
	{
		$CI =& get_instance();
		$CI->db->select('meta_value');
		$CI->db->where('page', $page);
		$CI->db->where('meta_key',$meta_key);
		$CI->db->from('settings');
		$query = $CI->db->get();
		$query = $query->row_array();
		return $query['meta_value'];
	}
}

if (!function_exists('get_used_book_detail'))
{
	function get_used_book_detail($book_name)
	{
		$CI =& get_instance();
		$CI->db->where('book_id is NOT NULL', NULL, FALSE);
		$CI->db->where('book_name', $book_name);
		$CI->db->where('is_orderd', 0);
		$CI->db->order_by('id', 'DESC');
		$CI->db->limit(1);
		return  $CI->db->get('st_used_books')->row_array();
	}
}

if (!function_exists('get_all_users'))
{
	function get_all_users()
	{
		$CI =& get_instance();
		return $CI->db->from("users")->count_all_results();
	}
}

if (!function_exists('get_all_books'))
{
	function get_all_books()
	{
		$CI =& get_instance();
		return $CI->db->from("st_books")->count_all_results();
	}
}

if (!function_exists('get_booking_oders'))
{
	function get_booking_oders($status)
	{
		$CI =& get_instance();
		return $CI->db->from("st_orders")->where_in('status',$status)->where('payment_status',1)->count_all_results();
	}
}

if (!function_exists('get_book_seller')) {
	function get_book_seller($user_id){
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('users');
		$CI->db->where('id', $user_id);
		$query = $CI->db->get();
		return $query->row_array();
	}
}

if (!function_exists('get_site_language')) {
	function get_site_language(){
		if(empty(get_session('site_lang'))) {
			set_session('site_lang','german');
		}
	}
}

if (!function_exists('get_used_books'))
{
	function get_used_books()
	{
		$CI =& get_instance();
		$CI->db->where('book_id is NOT NULL', NULL, FALSE);
		$CI->db->where('book_name is NOT NULL', NULL, FALSE);
		return $CI->db->from("st_used_books")->count_all_results();
	}
}

if (!function_exists('get_books_detail'))
{
	function get_books_detail($id)
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('st_books');
		$CI->db->where('id',$id);
		$query = $CI->db->get();
		return $query->row_array();
	}
}

if (!function_exists('confirm_money_transfer'))
{
	function confirm_money_transfer()
	{
		$CI =& get_instance();
		$CI->db->select('order_id');
		$CI->db->from('st_order_books');
		$CI->db->where('user_id', get_session('user_id'));
		$query = $CI->db->get();
		if($query->num_rows() > 0) {
			$CI->db->select('amount_tranfer,paypal_email,iban_number,show_payout_alert');
			$CI->db->from('users');
			$CI->db->where('id', get_session('user_id'));
			$u_detail = $CI->db->get()->row_array();
			if ($u_detail['show_payout_alert'] == 1) {
				if(($u_detail['amount_tranfer'] == 0) && (empty($u_detail['paypal_email']))) {
					return true;
				} else if(($u_detail['amount_tranfer'] == 1) && (empty($u_detail['iban_number']))) {
					return true;
				} else {
					return false;
				}
			}else {
				return false;
			}
		}
	}
}

if (!function_exists('check_add_to_marketplace'))
{
	function check_add_to_marketplace($book_id)
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('st_used_books');
		$CI->db->where('user_id', get_session('user_id'));
		$CI->db->where('book_id', $book_id);
		$query = $CI->db->get();
		if($query->num_rows() > 0) {
			return true;
		}else {
			return false;
		}
	}
}

if ( ! function_exists('st_url_title'))
{
	function st_url_title($str, $separator = 'dash', $lowercase = FALSE)
	{
		if ($separator == 'dash')
		{
			$search		= '_';
			$replace	= '-';
		}
		else
		{
			$search		= '-';
			$replace	= '_';
		}
		$trans = array(
			'&\#\d+?;'				=> '',
			'&\S+?;'				=> '',
			'\s+'					=> $replace,
			$replace.'+'			=> $replace,
			$replace.'$'			=> $replace,
			'^'.$replace			=> $replace,
			'\.+$'					=> ''
		);
		$str = strip_tags($str);
		foreach ($trans as $key => $val)
		{
			$str = preg_replace("#".$key."#i", $val, $str);
		}
		if ($lowercase === TRUE)
		{
			$str = strtolower($str);
		}
		$str = str_replace('&','and',$str);
		$str = str_replace(' ','-',$str);
		$str = str_replace('/','-',$str);
		$str = str_replace('?','-',$str);
		$str = str_replace(',','',$str);
		$str = str_replace('(','',$str);
		$str = str_replace(')','',$str);
		$str = str_replace('+','',$str);
		$str = str_replace("'",'',$str);
		return trim(stripslashes($str));
	}
}

/* End of file connect_helper.php */