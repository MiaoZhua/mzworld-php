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
		if(isset($con['parent'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " parent =".$con['parent'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
		
		if($iscount==1){
			$sql="SELECT count(*) as count FROM gksel_challenge_list $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}else{
			$sql="SELECT * FROM gksel_challenge_list $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;			
			}
		}
	}
	
	function del_challenge($challenge_id=0){
		$con=array('subchallenge_id'=>$challenge_id);
		$articlelist=$this->ArticleModel->getarticlelist($con);
		if(!empty($articlelist)){
			for($i=0;$i<count($articlelist);$i++){
				$this->ArticleModel->del_article($articlelist[$i]['article_id']);
			}
		}
		
		
		//配置图片字段
		$picarr=array('pic_1','pic_2','pic_3','pic_4','pic_5');
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
				$filename=$info[$picarr[$i]];  //只能是相对路径
				if($filename!=""&&file_exists($filename)){
					@unlink($filename);
				}
			}
			$this->db->delete('gksel_challenge_list',array('challenge_id'=>$challenge_id));
		}
	}
	
	function del_article($article_id=0){
		//配置图片字段
		$picarr=array('pic_1','pic_2','pic_3','pic_4','pic_5');
		$picstr='';
		for($i=0;$i<count($picarr);$i++){
			if($i!=0){
				$picstr .=',';
			}
			$picstr .=$picarr[$i];
		}
		//同时删除图片
		$sql="SELECT $picstr FROM gksel_article_list WHERE article_id=$article_id";
		$info=$this->db->query($sql)->row_array();
		if(!empty($info)){
			for($i=0;$i<count($picarr);$i++){
				$filename=$info[$picarr[$i]];  //只能是相对路径
				if($filename!=""&&file_exists($filename)){
					@unlink($filename);
				}
			}
			$this->db->delete('gksel_article_list',array('article_id'=>$article_id));
		}
	}
	
	//添加文章
	function add_article($arr){
		if(isset($arr['challenge_id'])){
			$challenge_id=$arr['challenge_id'];
		}else{
			$challenge_id=0;
		}
		
		if(isset($arr['subchallenge_id'])){
			$subchallenge_id=$arr['subchallenge_id'];
		}else{
			$subchallenge_id=0;
		}
		
		if(isset($arr['parent'])){
			$parent=$arr['parent'];
		}else{
			$parent=0;
		}
	
		if(isset($arr['tongji_split'])){
			$tongji_split=$arr['tongji_split'];
		}else{
			$tongji_split=1;
		}
		
		$sql="SELECT * FROM gksel_article_list WHERE challenge_id=".$challenge_id." AND subchallenge_id=".$subchallenge_id." AND parent=".$parent." AND tongji_split=".$tongji_split." ORDER BY sort DESC LIMIT 0,1";
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			$max=$result['sort'];
		}else{
			$max=0;
		}
		
		
		$this->db->insert('gksel_article_list',$arr);
		$article_id=$this->db->insert_id();
		$this->ArticleModel->edit_article($article_id,array('sort'=>($max+1)));
		return $article_id;
	}
	
	//添加分类
	function add_challenge($arr){
		if(isset($arr['parent'])){
			$parent=$arr['parent'];
		}else{
			$parent=0;
		}
		
		$sql="SELECT * FROM gksel_challenge_list WHERE parent=".$parent.' ORDER BY sort DESC LIMIT 0,1';
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			$max=$result['sort'];
		}else{
			$max=0;
		}
		$this->db->insert('gksel_challenge_list',$arr);
		$challenge_id=$this->db->insert_id();
		$this->ArticleModel->edit_challenge($challenge_id,array('sort'=>($max+1)));
		return $challenge_id;
	}
	
	//修改文字
	function edit_challenge($challenge_id,$arr){
		//配置图片字段
		$picarr=array('pic_1','pic_2','pic_3');
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
				$filename=$info[$picarr[$i]];  //只能是相对路径
				if(isset($arr[$picarr[$i]])&&$arr[$picarr[$i]]!=''&&$filename!=""&&$arr[$picarr[$i]]!=$filename&&file_exists($filename)){
					@unlink($filename);
				}
			}
			$this->db->update('gksel_challenge_list',$arr,array('challenge_id'=>$challenge_id));
		}
	}
	
	//修改文字
	function edit_article($article_id,$arr){
		//配置图片字段
		$picarr=array('pic_1','pic_2','pic_3');
		$picstr='';
		for($i=0;$i<count($picarr);$i++){
			if($i!=0){
				$picstr .=',';
			}
			$picstr .=$picarr[$i];
		}
		//同时删除图片
		$sql="SELECT $picstr FROM gksel_article_list WHERE article_id=$article_id";
		$info=$this->db->query($sql)->row_array();
		if(!empty($info)){
			for($i=0;$i<count($picarr);$i++){
				$filename=$info[$picarr[$i]];  //只能是相对路径
				if(isset($arr[$picarr[$i]])&&$arr[$picarr[$i]]!=''&&$filename!=""&&$arr[$picarr[$i]]!=$filename&&file_exists($filename)){
					@unlink($filename);
				}
			}
			$this->db->update('gksel_article_list',$arr,array('article_id'=>$article_id));
		}
	}
	
	//获取产品的图片
	function getproduct_picinfo($product_id,$target_width,$target_height,$leftadd=0,$topadd=0){
		$sql="SELECT * FROM gksel_article_list WHERE challenge_id=1 AND subchallenge_id=2 AND parent=".$product_id." ORDER BY sort ASC";
		$result=$this->db->query($sql)->result_array();
		$filename='themes/default/images/no_img.jpg';
		if(!empty($result)){
			for($i=0;$i<count($result);$i++){
				if($result[$i]['pic_1']!=""&&file_exists($result[$i]['pic_1'])){
					$filename=$result[$i]['pic_1'];
					break;
				}
			}
		}
		$arr=$this->getpicinfo($filename,$target_width,$target_height,$leftadd,$topadd);
		return $arr;
	}
	
	//获取产品的图片
	function getpicinfo($filename,$target_width,$target_height,$leftadd=0,$topadd=0){
		if($filename!=""&&file_exists($filename)){
			
		}else{
			$filename='';
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
	
	function getemaillist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= "".$con['other_con'];}
		if(isset($con['status'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " status =".$con['status'];}
		if(isset($con['parent'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " parent =".$con['parent'];}
		if(isset($con['product_id'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " product_id =".$con['product_id'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
		
		if($iscount==0){
			$sql="SELECT * FROM gksel_email_list $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM gksel_email_list $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	function getemailinfo($email_id=0){
		$sql="SELECT * FROM gksel_email_list WHERE email_id=$email_id";
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			return $result;
		}else{
			return null;
		}
	}
	function edit_email($email_id,$arr){
		$this->db->update('gksel_email_list',$arr,array('email_id'=>$email_id));
	}
	
	function add_email($arr){
		$this->db->insert('gksel_email_list',$arr);
		return $this->db->insert_id();
	}
	
	
}
