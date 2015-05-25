<?php
class ArticleModel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function getarticlelist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= $con['other_con'];}
		if(isset($con['parent'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " a.parent =".$con['parent'];}
		if(isset($con['tongji_split'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " a.tongji_split ='".$con['tongji_split']."'";}
		if(isset($con['category_id'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " a.category_id =".$con['category_id'];}
		if(isset($con['subcategory_id'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " a.subcategory_id =".$con['subcategory_id'];}
		if(isset($con['type'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " a.type ='".$con['type']."'";}
		if(isset($con['size'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " a.size ='".$con['size']."'";}
		if(isset($con['taste'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " a.taste ='".$con['taste']."'";}
		if(isset($con['shoptype'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " a.shoptype ='".$con['shoptype']."'";}
		if(isset($con['keyword'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " (a.article_name_ch LIKE '%".$con['keyword']."%' OR a.article_name_en LIKE '%".$con['keyword']."%')";}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
		
		
		if($iscount==0){
			$sql="SELECT a.* FROM gksel_article_list a $where $order_by $limit";
//			echo $sql;exit;
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM gksel_article_list a $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	
	function getarticle_categoryinfo($category_id=0){
		$sql="SELECT * FROM gksel_category_list WHERE category_id=$category_id";
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			return $result;
		}else{
			return null;			
		}
	}
	
	function getarticle_categorylist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " ".$con['other_con'];}
		if(isset($con['parent'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " parent =".$con['parent'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
		
		if($iscount==1){
			$sql="SELECT count(*) as count FROM gksel_category_list $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}else{
			$sql="SELECT * FROM gksel_category_list $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;			
			}
		}
	}
	
	function getarticleinfo($article_id=0){
		$sql="SELECT * FROM gksel_article_list WHERE article_id=$article_id";
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			return $result;
		}else{
			return null;			
		}
	}
	//获取项目的详细
	function getprojectinfo($article_id=0){
		$sql="
			SELECT 
			b.category_name_en, b.category_id AS fenleicategory_id, b.pic_1 AS feilei_pic,
			d.pic_1 AS project_firstpic,
			a.* 
			
			FROM gksel_article_list a 
			
			LEFT JOIN gksel_category_list AS b ON a.selection_1=b.category_id
			LEFT JOIN gksel_article_list AS d ON d.parent=a.article_id
			
			WHERE a.parent =0 AND a.category_id =78 AND a.subcategory_id =80 AND a.article_id=".$article_id."
			
			GROUP BY a.article_id 
			
			ORDER BY a.article_id ASC, d.sort ASC
		";
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			return $result;
		}else{
			return null;			
		}
	}
	
	//获取最新的一个项目的详细
	function getprojectinfo_new(){
		$sql="
			SELECT 
			b.category_name_en, b.category_id AS fenleicategory_id, b.pic_1 AS feilei_pic,
			d.pic_1 AS project_firstpic,
			a.* 
			
			FROM gksel_article_list a 
			
			LEFT JOIN gksel_category_list AS b ON a.selection_1=b.category_id
			LEFT JOIN gksel_article_list AS d ON d.parent=a.article_id
			
			WHERE a.parent =0 AND a.category_id =78 AND a.subcategory_id =80 AND a.status=1 AND a.audit_status=1
			
			GROUP BY a.article_id 
			
			ORDER BY a.article_id DESC, d.sort ASC
			
			LIMIT 0,1
		";
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			return $result;
		}else{
			return null;			
		}
	}
	//获取随机的一个项目的详细
	function getprojectinfo_rand(){
		$sql="
			SELECT 
			b.category_name_en, b.category_id AS fenleicategory_id, b.pic_1 AS feilei_pic,
			d.pic_1 AS project_firstpic,
			a.* 
			
			FROM gksel_article_list a 
			
			LEFT JOIN gksel_category_list AS b ON a.selection_1=b.category_id
			LEFT JOIN gksel_article_list AS d ON d.parent=a.article_id
			
			WHERE a.parent =0 AND a.category_id =78 AND a.subcategory_id =80 AND a.status=1 AND a.audit_status=1
			
			GROUP BY a.article_id 
			
			ORDER BY rand(), d.sort ASC
			
			LIMIT 0,1
		";
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			return $result;
		}else{
			return null;			
		}
	}
	
		
	function del_category($category_id=0){
		$con=array('subcategory_id'=>$category_id);
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
		$sql="SELECT $picstr FROM gksel_category_list WHERE category_id=$category_id";
		$info=$this->db->query($sql)->row_array();
		if(!empty($info)){
			for($i=0;$i<count($picarr);$i++){
				$filename=$info[$picarr[$i]];  //只能是相对路径
				if($filename!=""&&file_exists($filename)){
					@unlink($filename);
				}
			}
			$this->db->delete('gksel_category_list',array('category_id'=>$category_id));
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
		if(isset($arr['category_id'])){
			$category_id=$arr['category_id'];
		}else{
			$category_id=0;
		}
		
		if(isset($arr['subcategory_id'])){
			$subcategory_id=$arr['subcategory_id'];
		}else{
			$subcategory_id=0;
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
		
		$sql="SELECT * FROM gksel_article_list WHERE category_id=".$category_id." AND subcategory_id=".$subcategory_id." AND parent=".$parent." AND tongji_split=".$tongji_split." ORDER BY sort DESC LIMIT 0,1";
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
	function add_category($arr){
		if(isset($arr['parent'])){
			$parent=$arr['parent'];
		}else{
			$parent=0;
		}
		
		$sql="SELECT * FROM gksel_category_list WHERE parent=".$parent.' ORDER BY sort DESC LIMIT 0,1';
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			$max=$result['sort'];
		}else{
			$max=0;
		}
		$this->db->insert('gksel_category_list',$arr);
		$category_id=$this->db->insert_id();
		$this->ArticleModel->edit_category($category_id,array('sort'=>($max+1)));
		return $category_id;
	}
	
	//修改文字
	function edit_category($category_id,$arr){
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
		$sql="SELECT $picstr FROM gksel_category_list WHERE category_id=$category_id";
		$info=$this->db->query($sql)->row_array();
		if(!empty($info)){
			for($i=0;$i<count($picarr);$i++){
				$filename=$info[$picarr[$i]];  //只能是相对路径
				if(isset($arr[$picarr[$i]])&&$arr[$picarr[$i]]!=''&&$filename!=""&&$arr[$picarr[$i]]!=$filename&&file_exists($filename)){
					@unlink($filename);
				}
			}
			$this->db->update('gksel_category_list',$arr,array('category_id'=>$category_id));
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
		$sql="SELECT * FROM gksel_article_list WHERE category_id=1 AND subcategory_id=2 AND parent=".$product_id." ORDER BY sort ASC";
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
