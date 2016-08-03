<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_ilmu extends CI_Model {

	private $table = "tbl_ilmu";
	private $id = "ilmu_id";
	
	function getAll($where='', $like='', $limit='', $offset='') {
		$this->db->order_by("tgl_input","DESC");
		
		if($where)
			$this->db->where($where);
		
		if($like)
			$this->db->where($like);
		
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
			$this->db->where($like);
		
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
	
	function getDelete($where){
		return $this->db->where($where)->delete($this->table);
	}
	
	//get ilmu terkait
	function getIlmuTerkait($where){
		$this->db->where($where);
		$this->db->where(array("ilmustatus_id" => 1, "statuspublish_id" => 1));
		$this->db->order_by("ilmu_id","rand");
		$this->db->limit(3);
		return $this->db->get($this->table);	
	}
	
	//get id kategori berdasarkan id ilmu
	function getIdKatByIdIlmu($where){
		$this->db->where($where);
		return $this->db->get('tbl_kategoriilmudetail');
	}
	
	//get five latest
	function getFiveLatest(){
		$this->db->where(array("ilmustatus_id" => 1, "statuspublish_id" => 1));
		$this->db->order_by("tgl_input","DESC")->limit(5);
		
		$query = $this->db->get($this->table);
		
		return $query;
		$query->free_result();
	}
	
	//get kateori id
	function getIdKategori(){
		
		$this->db->select("kategoriilmu_id");
		$this->db->group_by("kategoriilmu_id");
		
		$query = $this->db->get("tbl_kategoriilmudetail");
		
		return $query;
		$query->free_result();
	}
	
	function getIdIlmuByIdKategori($where){
		return $this->db->where($where)->get("tbl_kategoriilmudetail");
	}
	
	//kategori ilmu detail
	function getInsertKategoriDetail($data){
		return $this->db->set($data)->insert("tbl_kategoriilmudetail");
	}
	
	//kategori delete
	function getDeleteKatDetail($where){
		return $this->db->where($where)->delete("tbl_kategoriilmudetail");
	}
}