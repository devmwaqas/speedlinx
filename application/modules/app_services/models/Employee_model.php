<?php 
class Employee_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_login($data) {

		$email = $data['email'];
		$password = $data['password'];
		$hash_pass="password('".$password."')";

		$this->db->select('id');
		$this->db->where('email',$email);
		$this->db->where('password',$hash_pass, FALSE);
		$this->db->where('status',1);
		$this->db->where('user_type',2);
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
				$data['auth_token'] = $auth_token;
				return array('auth_token' => $auth_token);
			} else {
				return array();
			}

		} else {
			return array();
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
		$this->db->where('user_type',2);
		$this->db->where('auth_token', $token);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function getassignedjobs($token) {
		$this->db->select('id');
		$this->db->from('users');
		$this->db->where('status', 1);
		$this->db->where('user_type',2);
		$this->db->where('auth_token', $token);
		$query = $this->db->get();
		$emp = $query->row_array();

		if(!empty($emp['id'])) {

			$this->db->select('service_requests.*, u1.first_name as assigned_to');
			$this->db->select('u2.first_name as assigned_by');
			$this->db->select('service_types.name as service_name');
			$this->db->from('service_requests');
			$this->db->join('service_types', 'service_requests.service_type = service_types.id', 'left');
			$this->db->join('users as u1', 'service_requests.assign_to = u1.id', 'left');
			$this->db->join('users as u2', 'service_requests.assign_by = u2.id', 'left');
			$this->db->where('service_requests.assign_to', $emp['id']);
			$query = $this->db->get();
			return $query->result_array();

		} else {
			return array();
		}
	}
}

?>