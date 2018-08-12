<?php

class M_login extends CI_Model {

	public $table = 'tm_user';
	
	function check_login($username, $password) {
		$query = $this->db->get_where($this->table, array('user_name' => $username, 'user_password' => $password), 1, 0);
		
		if ($query->num_rows() > 0) {
			return TRUE;
		}
		else {
			return FALSE;
		}	
	}
	
	function get_detail_user($username, $password) {
		$query = $this->db->get_where($this->table, array('user_name' => $username, 'user_password' => $password), 1, 0);
		return $query->result();
	}
	
	function set_lastlogin() {
        $this->db->set('last_login', get_ymdhis());
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$this->db->update($this->table);
		
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 0;
		}
		else {
			$this->db->trans_commit();
			return 1;
		}
    }
}		