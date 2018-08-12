<?php

class M_global extends CI_Model {

	function get_all($table) {
		$query = $this->db->get($table);
        return $query->result();
	}
	
	function get_order_group($table, $by, $order) {
		$query = $this->db->order_by($by, $order)->group_by($by, $order)->get($table);
        return $query->result();
	}

	function get_all_limit_order($table, $limit, $by, $order) {
		$query = $this->db->limit($limit)->order_by($by, $order)->get($table);
        return $query->result();
	}
	
	function get_order($table, $by, $order) {
		$query = $this->db->order_by($by, $order)->get($table);
        return $query->result();
	}
	
	function get_double_order($table, $by, $order, $bys, $orders) {
		$query = $this->db->order_by($by, $order)->order_by($bys, $orders)->get($table);
        return $query->result();
	}
	
	function get_list($table, $field) {
		$query = $this->db->get_where($table, array($field => 1));
        return $query->result();
	}
	
	function get_by_id($table, $field, $id) {
		$query = $this->db->get_where($table, array($field => $id));
        return $query->result();
	}
	function get_by_id2($table, $field, $id) {
		$query = $this->db->get_where($table, array($field => $id));
        return $query->row_array();
	}
	function insertData($table,$data)
	{
		$this->db->insert($table,$data);
	}
	function deleteData($table,$field, $id)
	{
		$this->db->delete($table, array($field => $id));
	}
	
	function get_by_id_and_order($table, $field, $id, $by, $order) {
		$query = $this->db->order_by($by, $order)->get_where($table, array($field => $id));
        return $query->result();
	}
	
	function get_by_double_id_and_order($table, $field, $id, $fields, $ids, $by, $order) {
		$query = $this->db->order_by($by, $order)->get_where($table, array($field => $id, $fields => $ids));
        return $query->result();
	}
	function get_by_double_id_limit_order($table, $field, $id, $field2, $id2, $limit, $by, $order) {
		$query = $this->db->limit($limit)->order_by($by, $order)->get_where($table, array($field => $id, $field2 => $id2));
        return $query->result();
	}
	
	function get_by_triple_id_limit_order($table, $field, $id, $field2, $id2, $field3, $id3, $limit, $by, $order) {
		$query = $this->db->limit($limit)->order_by($by, $order)->get_where($table, array($field => $id, $field2 => $id2, $field3 => $id3));
        return $query->result();
	}
	
	function get_by_id_limit_order($table, $field, $id, $limit, $by, $order,  $offset=0) {
		$query = $this->db->limit($limit, $offset)->order_by($by, $order)->get_where($table, array($field => $id));
        return $query->result();
	}
	
	function get_by_id_order($table, $field, $id, $by, $order) {
		$query = $this->db->order_by($by, $order)->get_where($table, array($field => $id));
        return $query->result();
	}

	function get_by_double_id_order($table, $field, $id, $field2, $id2, $by, $order) {
		$query = $this->db->order_by($by, $order)->get_where($table, array($field => $id, $field2 => $id2));
        return $query->result();
	}
	
	function get_by_triple_id_order($table, $field, $id, $field2, $id2, $field3, $id3, $by, $order) {
		$query = $this->db->order_by($by, $order)->get_where($table, array($field => $id, $field2 => $id2, $field3 => $id3));
        return $query->result();
	}
	
	function get_by_limit($table, $field, $id, $limit) {
		$query = $this->db->limit($limit)->get_where($table, array($field => $id));
        return $query->result();
	}
	
	function get_by_status($table, $field, $status) {
		$query = $this->db->get_where($table, array($field => $status));
        return $query->result();
	}
	
	function get_by_status_arr($table, $field, $status) {
		$query = $this->db->where_in($field, $status)->get($table);
        return $query->result();
	}
	
	function get_by_arr_limit_order($table, $field, $status, $limit, $by, $order) {
		$query = $this->db->limit($limit)->where_in($field, $status)->get($table);
        return $query->result();
	}
	
	function get_by_double_arr_order($table, $field, $status, $fields, $statuss, $by, $order) {
		$query = $this->db->where_in($field, $status)->where_in($field, $status)->get($table);
        return $query->result();
	}
	
	function get_by_double_arr_limit_order($table, $field, $status, $fields, $statuss, $limit, $by, $order) {
		$query = $this->db->limit($limit)->where_in($field, $status)->where_in($field, $status)->get($table);
        return $query->result();
	}
	
	function get_by_id_not_in($table, $field, $id, $not, $not_id) {
		$query = $this->db->where_not_in($not, $not_id)->get_where($table, array($field => $id));
        return $query->result();
	}
	
	function get_select($table, $field, $id) {
		$query = $this->db->where_not_in($field, $id)->get($table);
        return $query->result();
	}
	
	function get_select_in_id($table, $field, $id, $in, $in_id) {
		$query = $this->db->where_not_in($field, $id)->where($in, $in_id)->get($table);
        return $query->result();
	}
	
	function get_count_by_id($tb, $fd, $id) {
        $this->db->select('count(*) as count');
		$this->db->from($tb);
		$this->db->where($fd, $id); 
		$query = $this->db->get();    
        
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$count = $row->count;
			}    

			return $count;
		}
		else {
			return "";
		}	
    }
    function get_num_by_id($table, $field, $id) {
       	$query = $this->db->get_where($table, array($field => $id));
        return $query->num_rows();
    }
	function set_status($table, $field, $id, $stat, $status) {
		$this->db->set($stat, $status);
		$this->db->where($field, $id);
		$this->db->update($table);
		
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 0;
		}
		else {
			$this->db->trans_commit();
			return 1;
		}
	}
	
	function check_exist($table, $field, $value) {
		$query = $this->db->get_where($table, array($field => $value), 1, 0);
		
		if ($query->num_rows() > 0) {
			return TRUE;
		}
		else {
			return FALSE;
		}	
	}
	
	function check_existing($table, $field1, $value1, $field2, $value2) {
		$query = $this->db->get_where($table, array($field1 => $value1, $field2 => $value2), 1, 0);
		
		if ($query->num_rows() > 0) {
			return TRUE;
		}
		else {
			return FALSE;
		}	
	}
	
	function check_existings($table, $field1, $value1, $field2, $value2,  $field3, $value3) {
		$query = $this->db->get_where($table, array($field1 => $value1, $field2 => $value2, $field3 => $value3), 1, 0);
		
		if ($query->num_rows() > 0) {
			return TRUE;
		}
		else {
			return FALSE;
		}	
	}
	
	function get_search_order($tb, $field, $fields, $fd, $key, $by, $order) {
        $this->db->select('*');
		$this->db->from($tb);
		$this->db->where($field, $fields); 
		$this->db->like($fd, $key, 'both'); 
		$this->db->order_by($by, $order);
		$query = $this->db->get();    
		return $query->result();
    }
	
	function count_by_preq($tb, $fd, $like, $preq) {
        $this->db->select($fd);
		$this->db->from($tb);
		$this->db->like($like, $preq, 'after'); 
		$query = $this->db->get();    

		return $query->num_rows();	
	}
	function getValueFieldHigh($table,$field, $order) {
        $this->db->select($field);
        $this->db->order_by($order,'DESC');
        $query = $this->db->get($table);
        return $query->row();
    }
}		