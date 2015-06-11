<?php
class ShoppingcartModel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	//保存到购物车
	function saveshoppingcart($uid,$product_id,$size_id,$color_id,$zdyone_id,$arr){
		if(isset($arr['price_xiaoji_rmb'])&&isset($arr['count'])&&isset($arr['price_unit_rmb'])){
			$sql="SELECT * FROM gksel_order_cart WHERE uid=$uid AND product_id=$product_id AND size_id=$size_id AND color_id=$color_id AND zdyone_id=$zdyone_id";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				$count=$result['count']+$arr['count'];
				$price_xiaoji_rmb=($count*$arr['price_unit_rmb']);
				$this->db->update('gksel_order_cart',array('count'=>$count,'price_xiaoji_rmb'=>$price_xiaoji_rmb,'price_unit_rmb'=>$arr['price_unit_rmb']),array('cart_id'=>$result['cart_id']));
			}else{
				$arr['uid']=$uid;
				$arr['product_id']=$product_id;
				$arr['size_id']=$size_id;
				$arr['color_id']=$color_id;
				$arr['zdyone_id']=$zdyone_id;
				$arr['count']=$arr['count'];
				$arr['price_xiaoji_rmb']=$arr['price_xiaoji_rmb'];
				$arr['price_unit_rmb']=$arr['price_unit_rmb'];
				$arr['created']=mktime();
				$arr['edited']=mktime();
				$this->db->insert('gksel_order_cart',$arr);
			}
		}
	}
	//保存到购物车未登录
	function saveshoppingcartnouser($product_id,$size_id,$color_id,$zdyone_id,$arr){
		@session_start();
		if(isset($_SESSION['cart'])){
			$cart = unserialize($_SESSION['cart']);
		}else{
			$cart = null;
		}
		if(!empty($cart)){
			if(isset($cart[$product_id.'_'.$size_id.'_'.$color_id.'_'.$zdyone_id])){
				if(isset($arr['price_xiaoji_rmb'])&&isset($arr['count'])&&isset($arr['price_unit_rmb'])){
					$result=$cart[$product_id.'_'.$size_id.'_'.$color_id.'_'.$zdyone_id];
					$count=$result['count']+$arr['count'];
					$price_xiaoji_rmb=($count*$arr['price_unit_rmb']);
					$cart[$product_id.'_'.$size_id.'_'.$color_id.'_'.$zdyone_id]['count'] = $count;
					$cart[$product_id.'_'.$size_id.'_'.$color_id.'_'.$zdyone_id]['price_xiaoji_rmb'] = $price_xiaoji_rmb;
				}
			}else{
				$cart[$product_id.'_'.$size_id.'_'.$color_id.'_'.$zdyone_id] = array('product_id'=>$product_id,'size_id'=>$size_id,'color_id'=>$color_id,'zdyone_id'=>$zdyone_id,'count'=>$arr['count'],'price_xiaoji_rmb'=>$arr['price_xiaoji_rmb'],'price_unit_rmb'=>$arr['price_unit_rmb']);
			}
			$_SESSION['cart'] = serialize($cart);
		}else{
			$cart[$product_id.'_'.$size_id.'_'.$color_id.'_'.$zdyone_id] = array('product_id'=>$product_id,'size_id'=>$size_id,'color_id'=>$color_id,'zdyone_id'=>$zdyone_id,'count'=>$arr['count'],'price_xiaoji_rmb'=>$arr['price_xiaoji_rmb'],'price_unit_rmb'=>$arr['price_unit_rmb']);
			$_SESSION['cart'] = serialize($cart);
		}
	}
	
	
	//获取购物车列表
	function getcartlist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['uid'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " uid = ".$con['uid'];}
		if(isset($con['product_id'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " product_id = ".$con['product_id'];}
		if(isset($con['size_id'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " size_id = ".$con['size_id'];}
		if(isset($con['color_id'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " color_id = ".$con['color_id'];}
		if(isset($con['zdyone_id'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " zdyone_id = ".$con['zdyone_id'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
		
		if($iscount==0){
			$sql="SELECT * FROM gksel_order_cart $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else if($iscount==2){
			$sql="SELECT sum(price_xiaoji_rmb) as totalprice FROM gksel_order_cart $where $order_by $limit";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return number_format($result['totalprice'],2);
			}else{
				return number_format(0,2);
			}
		}else{
			$sql="SELECT count(*) as count FROM gksel_order_cart $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	//购物车服装数量+1
	function cartcount_increase($cart_id){
		$userinfo=$this->session->userdata('userinfo');
		if(!empty($userinfo)){
			$sql="SELECT * FROM gksel_order_cart WHERE cart_id=$cart_id";
			$cartinfo=$this->db->query($sql)->row_array();
		}else{
			@session_start();
			if(isset($_SESSION['cart'])){
				$cart = unserialize($_SESSION['cart']);
				$cartinfo = $cart[$cart_id];
			}else{
				$cartinfo = null;
			}
		}
		if(!empty($cartinfo)){
				$product_id=$cartinfo['product_id'];
				$color_id=$cartinfo['color_id'];
				$size_id=$cartinfo['size_id'];
				$zdyone_id=$cartinfo['zdyone_id'];
				$count=$cartinfo['count'];
				$productinfo=$this->ProductModel->getproductinfo($product_id);
				if(!empty($productinfo)){
					$sql="SELECT * FROM gksel_product_compose WHERE product_id=$product_id AND size_id=$size_id AND color_id=$color_id AND zdyone_id=$zdyone_id ORDER BY id ASC";
					$sizecolormes=$this->db->query($sql)->row_array();
					if(!empty($sizecolormes)){
						$price_unit=$sizecolormes['re_feature_price'];
						if(!empty($userinfo)){
							$total_count = 0;
							$this->db->update('gksel_order_cart',array('count'=>$count+1,'price_xiaoji_rmb'=>($price_unit*($count+1)),'price_unit_rmb'=>$price_unit),array('cart_id'=>$cartinfo['cart_id']));
							$total_price=$this->ShoppingcartModel->getcartlist(array('uid'=>$cartinfo['uid']),2);//购物车商品的总价格
								
							$sql="SELECT sum(count) as totalcount FROM gksel_order_cart WHERE uid=".$cartinfo['uid'];
							$totalcount_res=$this->db->query($sql)->row_array();
							if(!empty($totalcount_res)){
								$total_count=$totalcount_res['totalcount'];
							}
						}else{
							$total_price = 0;
							$total_count = 0;
							$cartinfo['count'] +=1;
							$cartinfo['price_xiaoji_rmb'] =$cartinfo['price_unit_rmb']*$cartinfo['count'];
							$cart[$cart_id] = $cartinfo;
							foreach ($cart as $k=>$v){
								$total_price +=$v['price_xiaoji_rmb'];
								$total_count +=$v['count'];
							}
							$_SESSION['cart'] = serialize($cart);
						}
						
						$color_count=$sizecolormes['re_feature_quantity'];
						if(($count+1)>$color_count){
							//购买的数量已经大于库存
							return json_encode(array('inres'=>'yes','status'=>2,'color_count'=>$color_count,'price_unit_rmb'=>number_format($price_unit,2),'price_noformat'=>$price_unit*($count+1),'price_xiaoji_rmb'=>$price_unit*($count+1),'total_price'=>$total_price,'total_count'=>$total_count));
						}else{
							//ok
							return json_encode(array('inres'=>'yes','status'=>1,'color_count'=>$color_count,'price_unit_rmb'=>number_format($price_unit,2),'price_noformat'=>$price_unit*($count+1),'price_xiaoji_rmb'=>$price_unit*($count+1),'total_price'=>$total_price,'total_count'=>$total_count));
						}
					}else{
						//此尺寸和颜色的服装已不存在
						return json_encode(array('inres'=>'no','status'=>3));
					}
				}else{
					//此服装已不存在
					return json_encode(array('inres'=>'no','status'=>4));
				}
		}else{
			//此购物车已被删除
			return json_encode(array('inres'=>'no'));
		}
	}
	//购物车服装数量-1
	function cartcount_decrease($cart_id){
		$userinfo=$this->session->userdata('userinfo');
		if(!empty($userinfo)){
			$sql="SELECT * FROM gksel_order_cart WHERE cart_id=$cart_id";
			$cartinfo=$this->db->query($sql)->row_array();
		}else{
			@session_start();
			if(isset($_SESSION['cart'])){
				$cart = unserialize($_SESSION['cart']);
				$cartinfo = $cart[$cart_id];
			}else{
				$cartinfo = null;
			}
		}
		
		if(!empty($cartinfo)){
			$count=$cartinfo['count'];
			if($count>1){
					$product_id=$cartinfo['product_id'];
					$color_id=$cartinfo['color_id'];
					$size_id=$cartinfo['size_id'];
					$zdyone_id=$cartinfo['zdyone_id'];
					$productinfo=$this->ProductModel->getproductinfo($product_id);
					if(!empty($productinfo)){
						$sql="SELECT * FROM gksel_product_compose WHERE product_id=$product_id AND size_id=$size_id AND color_id=$color_id AND zdyone_id=$zdyone_id ORDER BY id ASC";
						$sizecolormes=$this->db->query($sql)->row_array();
						if(!empty($sizecolormes)){
							$price_unit=$sizecolormes['re_feature_price'];
							if(!empty($userinfo)){
								$total_count = 0;
								$this->db->update('gksel_order_cart',array('count'=>$count-1,'price_xiaoji_rmb'=>($price_unit*($count-1)),'price_unit_rmb'=>$price_unit),array('cart_id'=>$cartinfo['cart_id']));
								$total_price=$this->ShoppingcartModel->getcartlist(array('uid'=>$cartinfo['uid']),2);//购物车商品的总价格
								
								$sql="SELECT sum(count) as totalcount FROM gksel_order_cart WHERE uid=".$cartinfo['uid'];
								$totalcount_res=$this->db->query($sql)->row_array();
								if(!empty($totalcount_res)){
									$total_count=$totalcount_res['totalcount'];
								}
							}else{
								$total_count = 0;
								$total_price = 0;
								$cartinfo['count'] -=1;
								$cartinfo['price_xiaoji_rmb'] =$cartinfo['price_unit_rmb']*$cartinfo['count'];
								$cart[$cart_id] = $cartinfo;
								foreach ($cart as $k=>$v){
									$total_price +=$v['price_xiaoji_rmb'];
									$total_count +=$v['count'];
								}
								$_SESSION['cart'] = serialize($cart);
							}
							$color_count=$sizecolormes['re_feature_quantity'];
							if(($count-1)>$color_count){
								//购买的数量已经大于库存
								return json_encode(array('inres'=>'yes','status'=>2,'color_count'=>$color_count,'price_unit_rmb'=>number_format($price_unit,2),'price_noformat'=>$price_unit*($count-1),'price_xiaoji_rmb'=>number_format($price_unit*($count-1),2),'total_price'=>$total_price,'total_count'=>$total_count));
							}else{
								//ok
								return json_encode(array('inres'=>'yes','status'=>1,'color_count'=>$color_count,'price_unit_rmb'=>number_format($price_unit,2),'price_noformat'=>$price_unit*($count-1),'price_xiaoji_rmb'=>number_format($price_unit*($count-1),2),'total_price'=>$total_price,'total_count'=>$total_count));
							}
						}else{
							//此尺寸和颜色的服装已不存在
							return json_encode(array('inres'=>'no','status'=>3));
						}
					}else{
						//此服装已不存在
						return json_encode(array('inres'=>'no','status'=>4));
					}
			}else{
				//数量必须>=1
				return json_encode(array('inres'=>'no'));
			}
		}else{
			//此购物车已被删除
			return json_encode(array('inres'=>'no'));
		}
		
	}
		
	//删除购物车产品
	function del_cart($cart_id){
		$userinfo=$this->session->userdata('userinfo');
		if(!empty($userinfo)){
			$sql="SELECT * FROM gksel_order_cart WHERE cart_id=$cart_id";
			$cartinfo=$this->db->query($sql)->row_array();
		}else{
			@session_start();
			if(isset($_SESSION['cart'])){
				$cart = unserialize($_SESSION['cart']);
			}else{
				$cart = null;
			}
		}
		if(!empty($userinfo)){
			$this->db->delete('gksel_order_cart',array('cart_id'=>$cart_id));
		}else{
			unset($cart[$cart_id]);
			$_SESSION['cart'] = serialize($cart);
		}
	}
	//删除用户购物车
	function del_cart_user(){
		$userinfo=$this->session->userdata('userinfo');
		if(!empty($userinfo)){
			$this->db->delete('gksel_order_cart',array('uid'=>$userinfo['uid']));
		}
	}
	//获取购物车的信息
	function getcartinfo($cart_id){
		$sql="SELECT * FROM gksel_order_cart WHERE cart_id=".$cart_id;
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			return $result;
		}else{
			return null;
		}
	}
	//计算快递的价格
	function calculate_express_price($address_id){
		$discount_info=$this->ExpressModel->getexpress_info(1);
		$discount_info=$discount_info['discount']/100;
		
		$addressinfo=$this->UserModel->getuseraddressinfo($address_id);
		$country_id=$addressinfo['country_id'];//国家id
		
		
		$sql="SELECT * FROM gksel_hat_country WHERE countryID=".$country_id;
		$countryinfo=$this->db->query($sql)->row_array($sql);
		
		//计算产品重量--START
		$total_weight=0;
		$shoppingcart=$this->ShoppingcartModel->getcartlist(array('uid'=>$this->uid,'orderby'=>'cart_id','orderby_res'=>'ASC'));
		if(!empty($shoppingcart)){
			for($i=0;$i<count($shoppingcart);$i++){
				$productinfo=$this->ProductModel->getproductinfo($shoppingcart[$i]['product_id']);
				$total_weight +=$productinfo['weight'];
			}
		}
		//计算产品重量--END
		
		$discount=$discount_info;//目前没有折扣
		$booked=8;//挂号费
		
		$express_price=($total_weight*$countryinfo['price'])*$discount+$booked;
		
		return number_format($express_price,2);
		
	}
	
	function get_weight($price=0){
		$discount_info=$this->ExpressModel->getexpress_info(1);
		$discount_info=$discount_info['discount']/100;
		
		//计算产品重量--START
		$total_weight=0;
		$shoppingcart=$this->ShoppingcartModel->getcartlist(array('uid'=>$this->uid,'orderby'=>'cart_id','orderby_res'=>'ASC'));
		if(!empty($shoppingcart)){
			for($i=0;$i<count($shoppingcart);$i++){
				$productinfo=$this->ProductModel->getproductinfo($shoppingcart[$i]['product_id']);
				$total_weight +=$productinfo['weight'];
			}
		}
//		echo $total_weight;exit;
		//计算产品重量--END
		
		$discount=$discount_info;//折扣
		$booked=8;//挂号费
		
//		$express_price=($total_weight*$price+$booked)*$discount;
		
		$express_price=($total_weight*$price)*$discount+$booked;
//		var check_all = (Number(check_weight)*Number(check_country))*Number(check_discount)+Number(check_booked);
		
		
		return number_format($express_price,2);
	}
	
	
}
