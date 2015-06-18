<?php
class ProductModel extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	/*
	 * 获取商品列表 
	 * 可多个条件
	 * */
	function getproductlist($con=array(),$iscount=0){
		$langarr=languagelist();
		$str='p.*';
		for($i=0;$i<count($langarr);$i++){
			
		}
		$where="";
		$order_by="";
		$limit="";
		$from="gksel_product_list AS p";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " ".$con['other_con'];}
		if(isset($con['product_id'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " p.product_id =".$con['product_id'];}
		if(isset($con['category_first'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " p.category_first =".$con['category_first'];}
		if(isset($con['category_two'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " p.category_two =".$con['category_two'];}
		if(isset($con['category_three'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " p.category_three =".$con['category_three'];}
		if(isset($con['product_id_in'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " p.product_id in (".$con['product_id_in'].")";}
		if(isset($con['product_name'])){
			if($where!=""){$where .=" AND";}else{$where .=" WHERE";}
			$where .= " 
			(
				(p.product_name_ch LIKE '%".addslashes($con['product_name'])."%') 
				OR (p.product_code LIKE '%".addslashes($con['product_name'])."%')
				OR (aa.re_feature_businessnumber LIKE '%".addslashes($con['product_name'])."%')
			)
			
			";
		}
		if(isset($con['status'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " p.status =".$con['status'];}
		if(isset($con['short_url'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " p.short_url ='".$con['short_url']."'";}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
		if($iscount==0){
			//re_feature_businessnumber
			$sql="
			
			SELECT ".$str." 
			
			FROM  
			
			".$from." 
			
			LEFT JOIN gksel_product_compose AS aa ON p.product_id=aa.product_id
			
			$where 
			
			GROUP BY p.product_id $order_by $limit 
			
			";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="
			
			SELECT ".$str." 
			
			FROM  
			
			".$from." 
			
			LEFT JOIN gksel_product_compose AS aa ON p.product_id=aa.product_id
			
			$where 
			
			GROUP BY p.product_id $order_by
			
			";
			$count=$this->db->query($sql)->num_rows() ;
			if($count>0){
				return $count;
			}else{
				return 0;
			}
		}
	}
	
	
	/*
	 * 获取产品图片
	 * */
	function getpicturelist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " ".$con['other_con'];}
		if(isset($con['product_id'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " product_id=".$con['product_id'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
		
		if($iscount==0){
			$sql="SELECT * FROM gksel_product_picture $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM gksel_product_picture $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	/*
	/*
	 * 获取特征列表
	 * */
	function getfeaturelist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['product_id'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " section =".$con['section'];}
		if(isset($con['parent'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " parent =".$con['parent'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
		if($iscount==0){
			$sql=" SELECT * FROM gksel_condition_feature_list $where $order_by $limit ";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql=" SELECT count(*) AS count FROM  gksel_condition_feature_list $where $order_by ";
			$count=$this->db->query($sql)->num_rows() ;
			if($count>0){
				return $count;
			}else{
				return 0;
			}
		}
	}
	/*
	 * 添加商品 
	 * */
	function add_product($arr){
		$this->db->insert('gksel_product_list',$arr);
		return $this->db->insert_id();
	}
	
	/*根据pid 获取商品信息*/
	function getproductinfo($product_id){
		$langarr=languagelist();
		$str='a.*';
		for($i=0;$i<count($langarr);$i++){
			
		}
		$sql="
			SELECT  ".$str."
			
			FROM gksel_product_list AS a 
			
			WHERE a.product_id=$product_id
		";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){           
			return $query->row_array();    
		}else{
			return null;   
		}
	}
	
	function getproductinfoByshorturl($short_url=''){
		$sql="
			SELECT  a.*
			
			FROM gksel_product_list AS a 
			
			WHERE a.short_url='".$short_url."'
		";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){           
			return $query->row_array();    
		}else{
			return null;   
		}
	}
	

	//修改product
	function edit_product($product_id,$arr){
		$this->db->update('gksel_product_list',$arr,array('product_id'=>$product_id));
	}
	
	//删除product feature
	function del_product_feature($id){
		//配置图片字段
		$picarr=array('re_feature_pic');
		$picstr='';
		for($i=0;$i<count($picarr);$i++){
			if($i!=0){
				$picstr .=',';
			}
			$picstr .=$picarr[$i];
		}
		//同时删除图片
		$sql="SELECT $picstr FROM gksel_product_feature WHERE id=$id";
		$info=$this->db->query($sql)->row_array();
		if(!empty($info)){
			for($i=0;$i<count($picarr);$i++){
				$filename=$info[$picarr[$i]];  //只能是相对路径
				if($filename!=""&&file_exists($filename)){
					//删除此图片
					@unlink($filename);
				}
			}
			$this->db->delete('gksel_product_feature',array('id'=>$id));
		}
	}
	
	//删除product feature
	function del_product_featurebyIDandfeatureid($product_id,$feature_id){
		//配置图片字段
		$picarr=array('re_feature_pic');
		$picstr='';
		for($i=0;$i<count($picarr);$i++){
			if($i!=0){
				$picstr .=',';
			}
			$picstr .=$picarr[$i];
		}
		//同时删除图片
		$sql="SELECT $picstr FROM gksel_product_feature WHERE product_id=$product_id AND feature_id=$feature_id";
		$info=$this->db->query($sql)->row_array();
		if(!empty($info)){
			for($i=0;$i<count($picarr);$i++){
				$filename=$info[$picarr[$i]];  //只能是相对路径
				if($filename!=""&&file_exists($filename)){
					//删除此图片
					@unlink($filename);
				}
			}
			$this->db->delete('gksel_product_feature',array('product_id'=>$product_id,'feature_id'=>$feature_id));
		}
	}
	
	//添加product feature
	function add_product_feature($arr){
		$this->db->insert('gksel_product_feature',$arr);
		return $this->db->insert_id();
	}
	//修改product feature
	function edit_product_feature($id,$arr){
		//配置图片字段
		$picarr=array('re_feature_pic');
		$picstr='';
		for($i=0;$i<count($picarr);$i++){
			if($i!=0){
				$picstr .=',';
			}
			$picstr .=$picarr[$i];
		}
		//同时删除图片
		$sql="SELECT $picstr FROM gksel_product_feature WHERE id=$id";
		$info=$this->db->query($sql)->row_array();
		if(!empty($info)){
			for($i=0;$i<count($picarr);$i++){
				$filename=$info[$picarr[$i]];  //只能是相对路径
				if(isset($arr[$picarr[$i]])&&$arr[$picarr[$i]]!=''&&$filename!=""&&$arr[$picarr[$i]]!=$filename&&file_exists($filename)){
					//删除此图片
					@unlink($filename);
				}
			}
			$this->db->update('gksel_product_feature',$arr,array('id'=>$id));
		}
	}
	
	function del_product($product_id=0){
		$this->db->delete('gksel_product_list',array('product_id'=>$product_id));
		$this->db->delete('gksel_product_feature',array('product_id'=>$product_id));
		$this->db->delete('gksel_product_remen',array('product_id'=>$product_id));
		$this->db->delete('gksel_product_xiangguan',array('product_id'=>$product_id));
		$this->db->delete('gksel_product_zuixin',array('product_id'=>$product_id));
		$this->db->delete('gksel_user_product_guanzhu',array('pid'=>$product_id));
		$this->db->delete('gksel_product_picture',array('product_id'=>$product_id));
//		$this->db->delete('gksel_product_reviews',array('product_id'=>$product_id));
	}
	
	function get_product_option($langtype='_ch',$product_id=0){
		$str='';
		$sql="SELECT * FROM gksel_product_list WHERE status=1 ORDER BY product_id ASC";
		$result=$this->db->query($sql)->result_array();
		for($i=0;$i<count($result);$i++){
			$selected="";if($product_id==$result[$i]['product_id']){$selected='selected';}
			$str .='<option value="'.$result[$i]['product_id'].'" '.$selected.'>'.$result[$i]['product_name'.$langtype].'</option>';
		}
		return $str;
	}
	
	/*获取产品图片信息*/
	function getpictureinfo($picture_id){
		$sql="
			SELECT  *
			
			FROM gksel_product_picture
			
			WHERE picture_id=$picture_id
		";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){           
			return $query->row_array();    
		}else{
			return null;   
		}
	}
	
	//删除产品图片
	function del_product_picture($picture_id){
		//配置图片字段
		$picarr=array('pic','pic_middle','pic_small');
		$picstr='';
		for($i=0;$i<count($picarr);$i++){
			if($i!=0){
				$picstr .=',';
			}
			$picstr .=$picarr[$i];
		}
		//同时删除图片
		$sql="SELECT $picstr FROM gksel_product_picture WHERE picture_id=$picture_id";
		$info=$this->db->query($sql)->row_array();
		if(!empty($info)){
			for($i=0;$i<count($picarr);$i++){
				$filename=$info[$picarr[$i]];  //只能是相对路径
				if($filename!=""&&file_exists($filename)){
					//删除此图片
					@unlink($filename);
				}
			}
			$this->db->delete('gksel_product_picture',array('picture_id'=>$picture_id));
		}
	}
	//添加图片
	function add_picture($arr){
		$sql="SELECT sort FROM gksel_product_picture WHERE product_id=".$arr['product_id']." ORDER BY sort DESC LIMIT 0,1";
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			$max=intval($result['sort']);
		}else{
			$max=0;
		}
		$this->db->insert('gksel_product_picture',$arr);
		$picture_id=$this->db->insert_id();
		$this->ProductModel->edit_picture($picture_id,array('sort'=>($max+1)));
		return $picture_id;
	}
	
	//修改图片
	function edit_picture($picture_id,$arr){
		//配置图片字段
		$picarr=array('pic','pic_middle','pic_small');
		$picstr='';
		for($i=0;$i<count($picarr);$i++){
			if($i!=0){
				$picstr .=',';
			}
			$picstr .=$picarr[$i];
		}
		//同时删除图片
		$sql="SELECT $picstr FROM gksel_product_picture WHERE picture_id=$picture_id";
		$info=$this->db->query($sql)->row_array();
		if(!empty($info)){
			for($i=0;$i<count($picarr);$i++){
				$filename=$info[$picarr[$i]];  //只能是相对路径
				if(isset($arr[$picarr[$i]])&&$arr[$picarr[$i]]!=''&&$filename!=""&&$arr[$picarr[$i]]!=$filename&&file_exists($filename)){
					//删除此图片
					@unlink($filename);
				}
			}
			$this->db->update('gksel_product_picture',$arr,array('picture_id'=>$picture_id));
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
		
		return array('pic'=>$filename,'pic_small'=>$filename,'width'=>$caijian_width,'height'=>$caijian_height,'marginleft'=>$marginleft,'margintop'=>$margintop);
	}
	
	
	function getmaylikelist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['product_id'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " a.product_id =".$con['product_id'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
		if($iscount==0){
			$sql="
			
			SELECT 
			
			b.article_name_en, b.article_name_ch, b.nolaninput_1 AS price, b.nolaninput_2 AS price_fenxiao,
			b.pic_1, 
			
			a.* 
			
			FROM gksel_product_maylike AS a 
			
			LEFT JOIN gksel_article_list AS b ON a.target_id=b.article_id
			
			$where $order_by $limit
			
			";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="
			
			SELECT count(*) as count 
			
			FROM gksel_product_maylike AS a
			
			LEFT JOIN gksel_article_list AS b ON a.product_id=b.article_id
			
			$where $order_by
			
			";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	function add_maylike($arr){
		$this->db->insert('gksel_product_maylike',$arr);
	}
	function delete_maylike($product_id){
		$this->db->delete('gksel_product_maylike',array('product_id'=>$product_id));
	}
}
