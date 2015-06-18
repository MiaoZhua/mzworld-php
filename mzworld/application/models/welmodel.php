<?php
class WelModel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	//添加临时文件
	function add_file_interim($arr){
		$this->db->insert('gksel_file_interim',$arr);
		return $this->db->insert_id();
	}
	
	//删除临时文件信息
	function delete_file_interim($path){
		$this->db->delete('gksel_file_interim',array('file_path'=>$path));
	}
	
	//删除临时文件
	function truncate_file_interim(){
		$sql="SELECT * FROM gksel_file_interim";
		$result=$this->db->query($sql)->result_array();
		if(!empty($result)){
			for($i=0;$i<count($result);$i++){
				$filename="".$result[$i]['file_path'];  //只能是相对路径
				@unlink($filename);
				$this->db->delete('gksel_file_interim',array('file_path'=>$result[$i]['file_path']));
			}
		}
	}
	
	//获取产品的图片
	function getpicinfo($filename,$target_width,$target_height,$leftadd=0,$topadd=0){
		if($filename!=""&&file_exists($filename)){
		
		}else{
			$filename='themes/default/images/no_img.jpg';
		}
		$width = getImgWidth ($filename);
		$height = getImgHeight ($filename);
		if($width>=$height*($target_width/$target_height)&&$width>$target_width){
			$caijian_width=floor($target_width);
			$caijian_height=floor(($target_width/$width)*$height);
		}else if($height>$width*($target_height/$target_width)&&$height>$target_height){
			$caijian_width=floor(($target_height/$height)*$width);
			$caijian_height=floor($target_height);
		}else{
			$caijian_width=$width;
			$caijian_height=$height;
		}
		$cha_width=$target_width-$caijian_width;
		$cha_height=$target_height-$caijian_height;
		
		$marginleft=floor($cha_width/2)+$leftadd;
		$margintop=floor($cha_height/2)+$topadd;
		
		return array('pic'=>$filename,'width'=>$caijian_width,'height'=>$caijian_height,'marginleft'=>$marginleft,'margintop'=>$margintop);
	}
	
	//获取语言列表
	function getlanguage_list($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['status'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " status = ".$con['status'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
		
		if($iscount==0){
			$sql="SELECT * FROM gksel_language $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM gksel_language $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	
	function getemaillist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['id'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " c.id =".$con['id'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
		if($iscount==0){
			$sql="SELECT c.* FROM gksel_newsletter c $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM gksel_newsletter c $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	
	function getemailinfo($email){
		$sql="SELECT * FROM gksel_newsletter WHERE email='$email'";
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			return $result;
		}else{
			return null;
		}
	}
	
	function add_email($arr){
		$this->db->insert('gksel_newsletter',$arr);
	}
	
	function insert_email($email){
		$this->db->insert('gksel_newsletter',array('email'=>$email,'created'=>mktime(),'edited'=>mktime()));
	}
	
	function del_email($id){
		$this->db->delete('gksel_newsletter',array('id'=>$id));
	}
	
	
}
