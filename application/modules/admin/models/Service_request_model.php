<?php 
class Service_request_model extends CI_Model
{
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

	public function get_employees() {
		$this->db->select('id,first_name,last_name,email,mobile');
		$this->db->where('status', 1);
		$this->db->where('user_type', 2);
		return $this->db->get('users')->result_array();
	}

	public function assign_request($data)
	{
		$this->db->set('assign_by', $this->session->userdata('admin_id'));
		$this->db->set('assign_to', $data['employee_id']);
		$this->db->set('assign_at', date('Y-m-d H:i:s'));
		$this->db->set('status', 1);
		$this->db->where('id', $data['request_id']);
		$query = $this->db->update('service_requests');
		return $this->db->affected_rows();
	}

}

?>