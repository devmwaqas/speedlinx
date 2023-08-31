<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('admin_url'))
{
	function admin_url()
	{
		$CI = get_instance();
		return $CI->config->item('admin_url');
	}
}

if ( ! function_exists('admin_controller'))
{
	function admin_controller()
	{
		$CI = get_instance();
		return $CI->config->item('admin_controller');
	}

}

if ( ! function_exists('sendNotification'))
{
	function sendNotification($device_tokens, $message)
	{
		$CI = get_instance();
		$SERVER_API_KEY = $CI->config->item('firebase_api_key');

		$data = [
            "registration_ids" => $device_tokens,
            "data" => $message
        ];
        $dataString = json_encode($data);

        $headers = [
        	'Authorization: key=' . $SERVER_API_KEY,
        	'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

}

if ( ! function_exists('authicate_admin'))
{
	function authicate_admin($token)
	{
		if(empty($token)) {
			return false;
		}

		$CI = get_instance();
		$CI->db->select('id');
		$CI->db->where('auth_token', $token);
		$CI->db->where('user_type', 1);
		$CI->db->where('status', 1);
		$query = $CI->db->get('users');
		if($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
}

if ( ! function_exists('authicate_user'))
{
	function authicate_user($token, $user_type = 3)
	{

		if(empty($token)) {
			return false;
		}

		$CI = get_instance();
		$CI->db->select('id');
		$CI->db->where('auth_token', $token);
		$CI->db->where('user_type', $user_type);
		$CI->db->where('status', 1);
		$query = $CI->db->get('users');
		if($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}

	}
}

if ( ! function_exists('is_registered_user'))
{
	function is_registered_user($token)
	{

		if(empty($token)) {
			return false;
		}

		$CI = get_instance();
		$CI->db->select('id,is_guest');
		$CI->db->where('auth_token', $token);
		$CI->db->where('user_type', 3);
		$CI->db->where('status', 1);
		$user = $CI->db->get('users')->row_array();
		if($user['is_guest']) {
			return false;
		} else {
			return true;
		}

	}
}


if ( ! function_exists('service_requests'))
{
	function service_requests($type = 'received')
	{
		$CI = get_instance();
		$CI->db->select('id');
		if($type == 'resolved') {
			$CI->db->where('status', 1);
		} elseif($type = 'inprogress') {

		} else if($type = 'pending_approval') {

		} else if($type = 'pending_by_team') {

		}
		return $CI->db->get('service_requests')->num_rows();
	}
}

if ( ! function_exists('tickets'))
{
	function tickets($type = 'received')
	{
		$CI = get_instance();
		$CI->db->select('id');
		$CI->db->where('status', 1);
		return $CI->db->get('tickets')->num_rows();
	}
}

if ( ! function_exists('feedbacks'))
{
	function feedbacks($type = 'received')
	{
		$CI = get_instance();
		$CI->db->select('id');
		return $CI->db->get('feedbacks')->num_rows();
	}
}


if ( ! function_exists('get_time_ago'))
{
	function get_time_ago($time, $short = false)
	{
		$SECOND = 1;
		$MINUTE = 60 * $SECOND;
		$HOUR = 60 * $MINUTE;
		$DAY = 24 * $HOUR;
		$MONTH = 30 * $DAY;
		$before = time() - strtotime($time);

		if ($before < 0)
		{
			return "not yet";
		}

		if ($short){
			if ($before < 1 * $MINUTE)
			{
				return ($before <5) ? "just now" : $before . " ago";
			}

			if ($before < 2 * $MINUTE)
			{
				return "1m ago";
			}

			if ($before < 45 * $MINUTE)
			{
				return floor($before / 60) . "m ago";
			}

			if ($before < 90 * $MINUTE)
			{
				return "1h ago";
			}

			if ($before < 24 * $HOUR)
			{

				return floor($before / 60 / 60). "h ago";
			}

			if ($before < 48 * $HOUR)
			{
				return "1d ago";
			}

			if ($before < 30 * $DAY)
			{
				return floor($before / 60 / 60 / 24) . "d ago";
			}


			if ($before < 12 * $MONTH)
			{
				$months = floor($before / 60 / 60 / 24 / 30);
				return $months <= 1 ? "1mo ago" : $months . "mo ago";
			}
			else
			{
				$years = floor  ($before / 60 / 60 / 24 / 30 / 12);
				return $years <= 1 ? "1y ago" : $years."y ago";
			}
		}

		if ($before < 1 * $MINUTE)
		{
			return ($before <= 1) ? "just now" : $before . " seconds ago";
		}

		if ($before < 2 * $MINUTE)
		{
			return "a minute ago";
		}

		if ($before < 45 * $MINUTE)
		{
			return floor($before / 60) . " minutes ago";
		}

		if ($before < 90 * $MINUTE)
		{
			return "an hour ago";
		}

		if ($before < 24 * $HOUR)
		{

			return (floor($before / 60 / 60) == 1 ? 'about an hour' : floor($before / 60 / 60).' hours'). " ago";
		}

		if ($before < 48 * $HOUR)
		{
			return "yesterday";
		}

		if ($before < 30 * $DAY)
		{
			return floor($before / 60 / 60 / 24) . " days ago";
		}

		if ($before < 12 * $MONTH)
		{

			$months = floor($before / 60 / 60 / 24 / 30);
			return $months <= 1 ? "one month ago" : $months . " months ago";
		}
		else
		{
			$years = floor  ($before / 60 / 60 / 24 / 30 / 12);
			return $years <= 1 ? "one year ago" : $years." years ago";
		}

		return "$time";
	}

}