<?php
class AdminModel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function checkAdmin($name,$pwd){
		$sql="select * from gksel_admin where username='$name' and password='$pwd' AND isadmin=1";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	function checkpassword($password){
		$sql="select * from gksel_admin where password='$password'";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	function getadmininfo(){
		$sql="select * from gksel_admin where username='admin'";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	function updateadmin($uid,$arr){
		$this->db->where('uid',$uid);
		$this->db->update('gksel_admin',$arr);
	}
	

	
	
	
	
}
