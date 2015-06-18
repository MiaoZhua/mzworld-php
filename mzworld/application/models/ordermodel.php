<?php
class OrderModel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getorderlist($con=array(),$iscount=0){
		if(isset($con['keyword'])){
			$where=" , gksel_order_detail od WHERE od.order_id=o.order_id AND od.product_name_ch LIKE '%".$con['keyword']."%'";
			$group_by=" GROUP BY od.order_id";
		}else{
			$where="";
			$group_by="";
		}
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['status'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " o.status = ".$con['status'];}
		if(isset($con['isquehuo'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " o.isquehuo = ".$con['isquehuo'];}
		if(isset($con['isreturn'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " o.isreturn = ".$con['isreturn'];}
		if(isset($con['uid'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " o.uid = ".$con['uid'];}
		if(isset($con['order_id'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " o.order_id = ".$con['order_id'];}
		if(isset($con['order_number'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " o.order_number LIKE '%".$con['order_number']."%'";}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
		
		if($iscount==0){
			$sql="SELECT o.* FROM gksel_order_list o $where $group_by $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM gksel_order_list o $where $group_by $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	
	function getorder_productlist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		$group_by="";
		if(isset($con['product_name_ch'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " od.product_name_ch LIKE '%".$con['product_name_ch']."%'";}
		if(isset($con['id'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " od.id =".$con['id'];}
		if(isset($con['refunt_status_all'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " od.refund_status !=".$con['refunt_status_all'];}
		if(isset($con['order_id'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " od.order_id =".$con['order_id'];}
		if(isset($con['product_id'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " od.product_id =".$con['product_id'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
		
		if($iscount==0){
			$sql="SELECT od.* FROM gksel_order_detail od $where $group_by $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM gksel_order_detail od $where $group_by $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	
	function get_product_order_count($product_id=0){
		$sql="SELECT sum(count) as count FROM gksel_order_detail od where product_id=$product_id ";
		$result=$this->db->query($sql)->row_array();
		if(!empty($result['count'])){
			return $result['count'];
		}else{
			return 0;
		}
	}
	
	function get_ordernumber($order_id){
		if($order_id<10){
			return '00000000000000'.$order_id;
		}else if($order_id<100){
			return '0000000000000'.$order_id;
		}else if($order_id<1000){
			return '000000000000'.$order_id;
		}else if($order_id<10000){
			return '00000000000'.$order_id;
		}else if($order_id<100000){
			return '0000000000'.$order_id;
		}else if($order_id<1000000){
			return '000000000'.$order_id;
		}else if($order_id<10000000){
			return '00000000'.$order_id;
		}else if($order_id<100000000){
			return '0000000'.$order_id;
		}else if($order_id<1000000000){
			return '000000'.$order_id;
		}else if($order_id<10000000000){
			return '00000'.$order_id;
		}else if($order_id<100000000000){
			return '0000'.$order_id;
		}else if($order_id<1000000000000){
			return '000'.$order_id;
		}else if($order_id<10000000000000){
			return '00'.$order_id;
		}else if($order_id<100000000000000){
			return '0'.$order_id;
		}else{
			return ''.$order_id;
		}
	}
	
	function add_order($arr){
		$this->db->insert('gksel_order_list',$arr);
		$order_id=$this->db->insert_id();
		$order_number=$this->get_ordernumber($order_id);
		$this->db->update('gksel_order_list',array('order_number'=>$order_number),array('order_id'=>$order_id));
		return $order_id;
	}
	
	
	function add_order_detail($arr){
		$this->db->insert('gksel_order_detail',$arr);
		return $this->db->insert_id();
	}
	
	function edit_order_detail($id,$arr){
		$this->db->update('gksel_order_detail',$arr,array('id'=>$id));
	}
	
	function getorderinfo($order_id){
		$sql="select * from gksel_order_list where order_id=$order_id";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){           
			return $query->row_array();    
		}else{
			return null;   
		}
	}
	
	function get_and_check_orderinfo($order_id,$uid=0){
		$sql="select * from gksel_order_list where order_id=$order_id and uid=$uid";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){           
			return $query->row_array();    
		}else{
			return null;   
		}
	}
	
	function edit_order($order_id,$arr){
		$this->db->update('gksel_order_list',$arr,array('order_id'=>$order_id));
	}
	
	function del_order($order_id){
		//同时删除订单的详细产品--开始
			$sql="SELECT * FROM gksel_order_detail WHERE order_id=$order_id";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				for($i=0;$i<count($result);$i++){
					$this->del_gksel_order_detail($result[$i]['id']);
				}
			}
		//同时删除订单的详细产品--结束
		$this->db->delete('gksel_order_list',array('order_id'=>$order_id));
		$this->db->delete('gksel_order_log',array('order_id'=>$order_id));
	}
	
	function del_gksel_order_detail($id=0){
		$this->db->delete('gksel_order_detail',array('id'=>$id));
	}
	
	function getexpress($order_id){
		$sql = "select orders.express_number,express.code,express.name from gksel_order_list orders left join gksel_express_list exp on exp.id=orders.express_type left join gksel_express_code express on express.id=exp.code where orders.order_id=$order_id";
		return $this->db->query($sql)->row_array();
	}
	
	function getexpressinfo($express_id){
		$subsql="SELECT code FROM gksel_express_code code WHERE id=exp.code";
		$sql = "select exp.*,($subsql) as code_name from gksel_express_list exp WHERE exp.id=$express_id";
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			return $result;
		}else{
			return null;
		}
	}
	
	function gksel_order_detail_info($order_id,$product_id){
		$sql="SELECT * FROM gksel_order_detail WHERE order_id=$order_id AND product_id=$product_id";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){           
			return $query->row_array();    
		}else{
			return null;   
		}
	}
	
	function is_review($pid,$oid,$uid){
		$sql="SELECT * FROM order_pingjia WHERE pid=$pid AND oid=$oid AND uid=$uid";
		$result=$this->db->query($sql)->result_array();
		if(!empty($result)){
			return $result;
		}else{
			return null;
		}
	}
	
	function get_review_info($id){
		$sql="select * from order_pingjia where id=$id";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){           
			return $query->row_array();    
		}else{
			return null;   
		}
	}
	
	function add_order_review($arr){
		$this->db->insert('order_pingjia',$arr);
	}
	
	//添加订单的记录
	function addorder_log($con=array()){
		if(isset($con['order_id'])&&isset($con['content'])){
			$con['created']=mktime();
			$this->db->insert('gksel_order_log',$con);
		}
	}
	//获取订单的记录
	function getorder_loglist($con="",$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['order_id'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " order_id =".$con['order_id'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
				
		if($iscount==0){
			$sql="SELECT * FROM gksel_order_log  $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM gksel_order_log  $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	
	//获取用户所有订单
	function getuserorders($uid){
		$this->db->order_by('created','desc');
		return $this->db->get_where('gksel_order_list',array('uid'=>$uid))->result_array();
	}
	
	function getreviewlist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['status'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " status =".$con['status'];}
		if(isset($con['pid'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " pid =".$con['pid'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
		if($iscount==0){
			$sql="SELECT * FROM order_pingjia $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM order_pingjia $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	
	function edit_product_pingjia($id,$arr){
		$this->db->update('order_pingjia',$arr,array('id'=>$id));
	}
	
	function del_product_pingjia($id){
		$this->db->delete('order_pingjia',array('id'=>$id));
	}
	
	/*
	 * 验证当前的订单是否存在评论 
	 * */
	function check_gksel_product_reviews($con){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['detail_id'])){if($where!=""){$where .=" AND ";}else{$where .=" WHERE ";} $where .= " detail_id =".$con['detail_id'];}
		$sql="SELECT * FROM gksel_product_reviews $where $order_by $limit";
		$result=$this->db->query($sql)->result_array();
		if(!empty($result)){
			return $result;
		}else{
			return null;
		}
	}
	
	function insert_gksel_product_reviews($arr){
		$this->db->insert('gksel_product_reviews',$arr);
	}
	
}
