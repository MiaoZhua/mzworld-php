<?php
class UserModel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function checkUser_login($name,$pwd){
		$sql="select * from px_user where email='$name' and password='$pwd'";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	function checkuser_login_isemail($name){
		$sql="select * from px_user where email='$name'";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	function getuserinfo($uid){
		$sql="select * from px_user where uid=".$uid;
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	function add_user($arr){
		$this->db->insert('px_user',$arr);
	}
	
	function edit_user($uid,$arr){
		$this->db->update('px_user',$arr,array('uid'=>$uid));
	}
	
	
	function getuserlist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['username'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " u.username LIKE '%".addslashes($con['username'])."%'";}
		if(isset($con['keyword'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ((u.username LIKE '%".addslashes($con['keyword'])."%') OR (u.email LIKE '%".addslashes($con['keyword'])."%') OR (Concat(u.firstname,' ',u.lastname) LIKE '%".addslashes($con['keyword'])."%')) ";}
		if(isset($con['key'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " u.key = '".$con['key']."'";}
		if(isset($con['status'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " u.status =".$con['status'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
		
		if($iscount==0){
			$sql="SELECT u.* FROM px_user u $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM px_user u $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}

	
	
	
	
}
