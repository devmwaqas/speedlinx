<?php 
class Feedback_model extends CI_Model
{
	public function get_feedbacks()
	{
		$this->db->select('*');
		$this->db->from('feedbacks');
		$query = $this->db->get();
		return $query->result_array();
	}
}

?>