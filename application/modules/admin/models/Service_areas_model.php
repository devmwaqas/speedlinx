<?php 
class Service_areas_model extends CI_Model
{
	public function get_service_areas()
	{
		$this->db->select('*');
		$this->db->from('service_areas');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_service_areas_detail($id)
	{
		$this->db->select('*');
		$this->db->from('service_areas');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function delete_service_areas($service_areas_id) {
		$this->db->where('id', $service_areas_id);
		$query = $this->db->delete('service_areas');
		return $this->db->affected_rows();
	}

	public function create_service_areas($data)
	{
		$this->db->set('area_title', $data['area_title']);
		$this->db->set('lat_long', $data['vertices']);
		$query = $this->db->insert('service_areas');
		$area_id = $this->db->insert_id();
		if($area_id > 0)
		{
			return $area_id;
		} else {
			return false;
		}
	}


	public function update_service_areas($data)
	{
		$this->db->set('area_title', $data['area_title']);
		$this->db->set('lat_long', $data['vertices']);
		$this->db->where('id', $data['area_id']);
		$query = $this->db->update('service_areas');
		return $this->db->affected_rows();
	}

}

?>