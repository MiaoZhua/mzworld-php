<?php
class ChallengeModel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getchallengeinfo($challenge_id=0){
		$sql="SELECT * FROM gksel_challenge_list WHERE challenge_id=$challenge_id";
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			return $result;
		}else{
			return null;			
		}
	}
	
	function getchallengelist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " ".$con['other_con'];}
		if(isset($con['parent'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " a.parent =".$con['parent'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
		
		if($iscount==1){
			$sql="SELECT count(*) as count FROM gksel_challenge_list AS a $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}else{
			$sql="
			
			SELECT 
			
			b.nickname, a.* 
			
			FROM gksel_challenge_list AS a 
			
			LEFT JOIN px_user AS b ON a.user_id=b.user_id
			
			$where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;			
			}
		}
	}
	
	function del_challenge($challenge_id=0){
		//配置图片字段
		$picarr=array('pic_1');
		$picstr='';
		for($i=0;$i<count($picarr);$i++){
			if($i!=0){
				$picstr .=',';
			}
			$picstr .=$picarr[$i];
		}
		//同时删除图片
		$sql="SELECT $picstr FROM gksel_challenge_list WHERE challenge_id=$challenge_id";
		$info=$this->db->query($sql)->row_array();
		if(!empty($info)){
			for($i=0;$i<count($picarr);$i++){
				$filename='../uploads/'.$info[$picarr[$i]];  //只能是相对路径
				if($info[$picarr[$i]]!=""&&file_exists($filename)){
					@unlink($filename);
				}
			}
			$this->db->delete('gksel_challenge_list',array('challenge_id'=>$challenge_id));
		}
		
		$sql="SELECT * FROM gksel_challenge_attach WHERE challenge_id=".$challenge_id;
		$attachlist=$this->db->query($sql)->result_array();
		if(!empty($attachlist)){
			for($i=0;$i<count($attachlist);$i++){
				$this->del_attach($attachlist[$i]['id']);
			}
		}
		
		$sql="SELECT * FROM gksel_challenge_description WHERE challenge_id=".$challenge_id;
		$descriptionlist=$this->db->query($sql)->result_array();
		if(!empty($descriptionlist)){
			for($i=0;$i<count($descriptionlist);$i++){
				$this->del_description($descriptionlist[$i]['id']);
			}
		}
	}
	
	function del_attach($id=0){
		//配置图片字段
		$picarr=array('path');
		$picstr='';
		for($i=0;$i<count($picarr);$i++){
			if($i!=0){
				$picstr .=',';
			}
			$picstr .=$picarr[$i];
		}
		//同时删除图片
		$sql="SELECT $picstr FROM gksel_challenge_attach WHERE id=$id";
		$info=$this->db->query($sql)->row_array();
		if(!empty($info)){
			for($i=0;$i<count($picarr);$i++){
				$filename='../uploads/'.$info[$picarr[$i]];  //只能是相对路径
				if($info[$picarr[$i]]!=""&&file_exists($filename)){
					@unlink($filename);
				}
			}
			$this->db->delete('gksel_challenge_attach',array('id'=>$id));
		}
	}
	
	function del_description($id=0){
		$this->db->delete('gksel_challenge_description',array('id'=>$id));
	}
	
	
	//添加分类
	function add_challenge($arr){
		$sql="SELECT * FROM gksel_challenge_list ORDER BY sort DESC LIMIT 0,1";
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			$max=$result['sort'];
		}else{
			$max=0;
		}
		$this->db->insert('gksel_challenge_list',$arr);
		$challenge_id=$this->db->insert_id();
		$this->ChallengeModel->edit_challenge($challenge_id,array('sort'=>($max+1)));
		return $challenge_id;
	}
	

	
	//修改文字
	function edit_challenge($challenge_id,$arr){
		//配置图片字段
//		$picarr=array('pic_1','pic_2','pic_3');
//		$picstr='';
//		for($i=0;$i<count($picarr);$i++){
//			if($i!=0){
//				$picstr .=',';
//			}
//			$picstr .=$picarr[$i];
//		}
//		//同时删除图片
//		$sql="SELECT $picstr FROM gksel_challenge_list WHERE challenge_id=$challenge_id";
//		$info=$this->db->query($sql)->row_array();
//		if(!empty($info)){
//			for($i=0;$i<count($picarr);$i++){
//				$filename=$info[$picarr[$i]];  //只能是相对路径
//				if(isset($arr[$picarr[$i]])&&$arr[$picarr[$i]]!=''&&$filename!=""&&$arr[$picarr[$i]]!=$filename&&file_exists($filename)){
//					@unlink($filename);
//				}
//			}
			$this->db->update('gksel_challenge_list',$arr,array('challenge_id'=>$challenge_id));
//		}
	}
	
	//添加召集描述
	function add_challenge_description($arr){
		if(isset($arr['challenge_id'])){
			$challenge_id=$arr['challenge_id'];
		}else{
			$challenge_id=0;
		}
		$sql="SELECT * FROM gksel_challenge_description WHERE challenge_id=$challenge_id ORDER BY sort DESC LIMIT 0,1";
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			$max=$result['sort'];
		}else{
			$max=0;
		}
		$this->db->insert('gksel_challenge_description',$arr);
		$id=$this->db->insert_id();
		$this->ChallengeModel->edit_challenge_description($id,array('sort'=>($max+1)));
		return $id;
	}
	
	//修改文字
	function edit_challenge_description($id,$arr){
		//配置图片字段
//		$picarr=array('pic_1','pic_2','pic_3');
//		$picstr='';
//		for($i=0;$i<count($picarr);$i++){
//			if($i!=0){
//				$picstr .=',';
//			}
//			$picstr .=$picarr[$i];
//		}
//		//同时删除图片
//		$sql="SELECT $picstr FROM gksel_challenge_description WHERE id=$id";
//		$info=$this->db->query($sql)->row_array();
//		if(!empty($info)){
//			for($i=0;$i<count($picarr);$i++){
//				$filename=$info[$picarr[$i]];  //只能是相对路径
//				if(isset($arr[$picarr[$i]])&&$arr[$picarr[$i]]!=''&&$filename!=""&&$arr[$picarr[$i]]!=$filename&&file_exists($filename)){
//					@unlink($filename);
//				}
//			}
			$this->db->update('gksel_challenge_description',$arr,array('id'=>$id));
//		}
	}
	
	//添加召集描述
	function add_challenge_attach($arr){
		if(isset($arr['challenge_id'])){
			$challenge_id=$arr['challenge_id'];
		}else{
			$challenge_id=0;
		}
		$sql="SELECT * FROM gksel_challenge_attach WHERE challenge_id=$challenge_id ORDER BY sort DESC LIMIT 0,1";
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			$max=$result['sort'];
		}else{
			$max=0;
		}
		$this->db->insert('gksel_challenge_attach',$arr);
		$id=$this->db->insert_id();
		$this->ChallengeModel->edit_challenge_attach($id,array('sort'=>($max+1)));
		return $id;
	}
	
	//修改文字
	function edit_challenge_attach($id,$arr){
		//配置图片字段
//		$picarr=array('pic_1','pic_2','pic_3');
//		$picstr='';
//		for($i=0;$i<count($picarr);$i++){
//			if($i!=0){
//				$picstr .=',';
//			}
//			$picstr .=$picarr[$i];
//		}
//		//同时删除图片
//		$sql="SELECT $picstr FROM gksel_challenge_attach WHERE id=$id";
//		$info=$this->db->query($sql)->row_array();
//		if(!empty($info)){
//			for($i=0;$i<count($picarr);$i++){
//				$filename=$info[$picarr[$i]];  //只能是相对路径
//				if(isset($arr[$picarr[$i]])&&$arr[$picarr[$i]]!=''&&$filename!=""&&$arr[$picarr[$i]]!=$filename&&file_exists($filename)){
//					@unlink($filename);
//				}
//			}
			$this->db->update('gksel_challenge_attach',$arr,array('id'=>$id));
//		}
	}
	
	
}
