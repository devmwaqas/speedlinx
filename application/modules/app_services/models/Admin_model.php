<?php 
class Admin_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_login($email, $password) {

		$hash_pass="password('".$password."')";
		$this->db->select('id');
		$this->db->where('email',$email);
		$this->db->where('password',$hash_pass, FALSE);
		$this->db->where('status',1);
		$this->db->where('user_type',1);
		$query=$this->db->get('users');
		$user = $query->row_array();
		if(!empty($user['id'])) {

			$auth_token = uniqid('',TRUE);
			$this->db->set('auth_token', $auth_token);
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

	public function logout($token) {
		$auth_token = uniqid('',TRUE);
		$this->db->set('auth_token', $auth_token);
		$this->db->where('auth_token', $auth_token);
		$this->db->update('users');
		if($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}

	public function get_service_areas()
	{
		$this->db->select('lat_long');
		$this->db->from('service_areas');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_service_types()
	{
		$this->db->select('*');
		$this->db->from('service_types');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_service_requests()
	{
		$this->db->select('service_requests.*, CONCAT(u1.first_name, " ", u1.last_name) as assigned_to');
		$this->db->select('CONCAT(u2.first_name, " ", u2.last_name) as assigned_by');
		$this->db->select('service_types.name as service_name');
		$this->db->from('service_requests');
		$this->db->join('service_types', 'service_requests.service_type = service_types.id', 'left');
		$this->db->join('users as u1', 'service_requests.assign_to = u1.id', 'left');
		$this->db->join('users as u2', 'service_requests.assign_by = u2.id', 'left');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getallrequestswithlazyload($page, $page_size)
	{
		$to_limit = $page * $page_size;
		$from_limit = $to_limit - $page_size;

		$this->db->select('service_requests.*, CONCAT(u1.first_name, " ", u1.last_name) as assigned_to');
		$this->db->select('CONCAT(u2.first_name, " ", u2.last_name) as assigned_by');
		$this->db->select('service_types.name as service_name');
		$this->db->from('service_requests');
		$this->db->join('service_types', 'service_requests.service_type = service_types.id', 'left');
		$this->db->join('users as u1', 'service_requests.assign_to = u1.id', 'left');
		$this->db->join('users as u2', 'service_requests.assign_by = u2.id', 'left');
		$this->db->limit($to_limit, $from_limit);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_request_detail($id)
	{
		$this->db->select('service_requests.*, CONCAT(u1.first_name, " ", u1.last_name) as assigned_to');
		$this->db->select('CONCAT(u2.first_name, " ", u2.last_name) as assigned_by');
		$this->db->select('service_types.name as service_name');
		$this->db->from('service_requests');
		$this->db->join('service_types', 'service_requests.service_type = service_types.id', 'left');
		$this->db->join('users as u1', 'service_requests.assign_to = u1.id', 'left');
		$this->db->join('users as u2', 'service_requests.assign_by = u2.id', 'left');
		$this->db->where('service_requests.id', $id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function get_feedbacks()
	{
		$this->db->select('*');
		$this->db->from('feedbacks');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_feedback_detail($id)
	{
		$this->db->select('*');
		$this->db->from('feedbacks');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function getallticketswithlazyload($page, $page_size)
	{
		$to_limit = $page * $page_size;
		$from_limit = $to_limit - $page_size;

		$this->db->select('tickets.*, CONCAT(u1.first_name, " ", u1.last_name) as assigned_to');
		$this->db->select('CONCAT(u2.first_name, " ", u2.last_name) as assigned_by');
		$this->db->select('CONCAT(users.first_name, " ", users.last_name) as created_by');
		$this->db->select('service_types.name as service_name');
		$this->db->from('tickets');
		$this->db->join('service_types', 'tickets.service_type = service_types.id', 'left');
		$this->db->join('users', 'tickets.user_id = users.id', 'left');
		$this->db->join('users as u1', 'tickets.assign_to = u1.id', 'left');
		$this->db->join('users as u2', 'tickets.assign_by = u2.id', 'left');
		$this->db->limit($to_limit, $from_limit);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_tickets()
	{
		$this->db->select('tickets.*, CONCAT(u1.first_name, " ", u1.last_name) as assigned_to');
		$this->db->select('CONCAT(u2.first_name, " ", u2.last_name) as assigned_by');
		$this->db->select('CONCAT(users.first_name, " ", users.last_name) as created_by');
		$this->db->select('service_types.name as service_name');
		$this->db->from('tickets');
		$this->db->join('service_types', 'tickets.service_type = service_types.id', 'left');
		$this->db->join('users', 'tickets.user_id = users.id', 'left');
		$this->db->join('users as u1', 'tickets.assign_to = u1.id', 'left');
		$this->db->join('users as u2', 'tickets.assign_by = u2.id', 'left');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_ticket_detail($id)
	{
		$this->db->select('tickets.*, CONCAT(u1.first_name, " ", u1.last_name) as assigned_to');
		$this->db->select('CONCAT(u2.first_name, " ", u2.last_name) as assigned_by');
		$this->db->select('CONCAT(users.first_name, " ", users.last_name) as created_by');
		$this->db->select('service_types.name as service_name');
		$this->db->from('tickets');
		$this->db->join('service_types', 'tickets.service_type = service_types.id', 'left');
		$this->db->join('users', 'tickets.user_id = users.id', 'left');
		$this->db->join('users as u1', 'tickets.assign_to = u1.id', 'left');
		$this->db->join('users as u2', 'tickets.assign_by = u2.id', 'left');
		$this->db->where('tickets.id', $id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function get_employees() {
		$this->db->select('id,first_name,last_name,email,mobile');
		$this->db->where('status', 1);
		$this->db->where('user_type', 2);
		return $this->db->get('users')->result_array();
	}

}

?>