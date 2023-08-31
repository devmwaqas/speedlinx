<?php 
class Customer_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_login($data) {

		$email = $data['email'];
		$password = $data['password'];
		$hash_pass="password('".$password."')";
		$this->db->select('id,is_guest');
		$this->db->where('email',$email);
		$this->db->where('password',$hash_pass, FALSE);
		$this->db->where('status',1);
		$this->db->where('user_type',3);
		$query=$this->db->get('users');
		$user = $query->row_array();

		if(!empty($user['id'])) {

			$auth_token = uniqid('',TRUE);
			$this->db->set('auth_token', $auth_token);

			if(!empty($data['platform'])) {
				$this->db->set('platform', $data['platform']);
			}

			if(!empty($data['device_reg_id'])) {
				$this->db->set('device_reg_id', $data['device_reg_id']);
			}

			$this->db->where('id', $user['id']);
			$this->db->update('users');

			if($this->db->affected_rows()) {
				$user['auth_token'] = $auth_token;
				return $user;
			} else {
				return array();
			}

		} else {
			return array();
		}
	}

	public function guestuser() {
		$auth_token = uniqid('',TRUE);
		$this->db->set('auth_token', $auth_token);
		$this->db->set('first_name', 'Guest');
		$this->db->set('last_name', 'User');
		$this->db->set('email', uniqid().'@speedlinx.com');
		$this->db->set('password', uniqid());
		$this->db->set('user_type',3);
		$this->db->set('created_by',0);
		$this->db->set('is_guest',1);
		$this->db->set('created_at', date('Y-m-d H:i:s'));
		$this->db->insert('users');
		if($this->db->insert_id() > 0) {
			return $auth_token;
		} else {
			return false;
		}
	}

	public function logoutuser($token) {

		$auth_token = uniqid('',TRUE);
		$this->db->set('auth_token', $auth_token);
		$this->db->where('auth_token', $token);
		$this->db->get('users');
		if($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getuserdetail($token) {
		$this->db->select('first_name, last_name, email, mobile');
		$this->db->from('users');
		$this->db->where('status', 1);
		$this->db->where('user_type',3);
		$this->db->where('auth_token', $token);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function get_service_types() {
		$this->db->select('id,name');
		$this->db->from('service_types');
		$this->db->where('status', 1);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_service_areas() {
		$this->db->select('lat_long');
		$this->db->from('service_areas');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function submit_request($data) {

		$this->db->select('id');
		$this->db->where('auth_token', $data['auth_token']);
		$user = $this->db->get('users')->row_array();

		$this->db->set('user_id', $user['id']);

		$this->db->set('full_name', $data['full_name']);
		$this->db->set('phone', $data['phone']);
		$this->db->set('email', $data['email']);
		$this->db->set('cnic', $data['cnic']);
		$this->db->set('address_line_1', $data['address_line_1']);
		$this->db->set('address_line_2', $data['address_line_2']);
		$this->db->set('service_type', $data['service_type']);
		$this->db->set('connection_type', $data['connection_type']);
		$this->db->set('tv_service_type', $data['tv_service_type']);
		$this->db->set('no_digital_boxes', $data['no_digital_boxes']);

		$this->db->set('created_at', date('Y-m-d H:i:s'));
		$this->db->insert('service_requests');
		return $this->db->insert_id();
	}

	public function submit_feedback($data) {
		$this->db->set('mobile', $data['mobile']);
		$this->db->set('message', $data['message']);
		$this->db->set('created_at', date('Y-m-d H:i:s'));
		$this->db->insert('feedbacks');
		return $this->db->insert_id();
	}

	public function submit_ticket($data) {

		$this->db->select('id');
		$this->db->where('auth_token', $data['auth_token']);
		$user = $this->db->get('users')->row_array();

		$this->db->set('user_id', $user['id']);
		$this->db->set('service_type', $data['service_type']);
		$this->db->set('issue_type', $data['issue_type']);
		$this->db->set('description', $data['description']);
		$this->db->set('availablity_time', $data['availablity_time']);
		$this->db->set('created_at', date('Y-m-d H:i:s'));
		$this->db->insert('tickets');
		return $this->db->insert_id();
	}

}

?>