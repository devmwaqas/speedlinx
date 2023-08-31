<?php 
class Tickets_model extends CI_Model
{
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

	public function assign_ticket($data)
	{
		$this->db->set('assign_by', $this->session->userdata('admin_id'));
		$this->db->set('assign_to', $data['employee_id']);
		$this->db->set('assign_at', date('Y-m-d H:i:s'));
		$this->db->set('status', 2);
		$this->db->where('id', $data['ticket_id']);
		$query = $this->db->update('tickets');
		return $this->db->affected_rows();
	}

}

?>