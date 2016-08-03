<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_sibscribe extends CI_Model {

	private $table = "tbl_subscriber";
	private $id = "subscriber_id";
	
	function getAll($where='', $like='', $limit='', $offset='') {
		
		if($where)
			$this->db->where($where);
		
		if($like)
			$this->db->where($where);
		
		if(!$limit && !$offset)
			$query = $this->db->get($this->table);
		else                                     
			$query = $this->db->get($this->table, $limit, $offset);
		
		return $query;
		$query->free_result();
	}
	
	function getCount($where='', $like='') {
		
		if($where)
			$this->db->where($where);
		
		if($like)
			$this->db->where($where);
		
		$query = $this->db->get($this->table);
		
		return $query->num_rows();
		$query->free_result();
	}
	
	function getInsert($data){
		return $this->db->set($data)->insert($this->table);
	}
	
	function getUpdate($data,$id){
		return $this->db->set($data)->where($this->id,$id)->update($this->table);
	}
	
	function getDelete($id_ktgr){
		return $this->db->where($this->id,$id_ktgr)->delete($this->table);
	}
}