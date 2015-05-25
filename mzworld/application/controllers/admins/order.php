<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->temp=$this->config->item('template');
		$this->langtype='_ch';
		$this->lang->load('gksel','chinese');
		$this->session->set_userdata('menu','order');
		
		$admin=$this->session->userdata ( 'admin' );
		if(empty($admin)){
		    redirect(base_url().'admin');
		}
	}
	
	function index($row=0){
		$this->session->set_userdata('submenu','order_manage');
		$data['page']=20;
		$data['url']='<font class="nav_underline">'.lang('order_manage').'</font>';
		if ($_GET){
			$row=$this->input->get('row');
			if($row==""){$row=0;}
			$page=$this->input->get('page');
			$data['page']=$page;
			$order_number=$this->input->get('order_number');
			//排序--开始
				$orderby=$this->input->get('orderby');
				$orderby_old=$this->input->get('orderby');
				$orderby_res=$this->input->get('orderby_res');
				if($orderby!=''&&$orderby_res!=''){
					$orderby='o.'.$orderby;
				}else{
					$orderby='o.order_id';
					$orderby_res='DESC';
				}
			//排序--结束
			$con=array('isreturn'=>0,'orderby'=>$orderby,'orderby_res'=>$orderby_res,'row'=>$row,'page'=>$data['page']);
		
			$valueinfo=$this->session->userdata('search_order_status');
			if ($valueinfo!=''){
				$con['status']=$valueinfo;
			}
			
			if($order_number!=""){$con['order_number']=$order_number;}
			$data['order']=$this->OrderModel->getorderlist($con);
			$data['count']=$this->OrderModel->getorderlist($con,1);
			$url = base_url().'admins/order/index?order_number='.$order_number.'&orderby='.$orderby_old.'&orderby_res='.$orderby_res.'&page='.$page;
			$data['fy'] = fy_backend($data['count'],$row,$url,$data['page'],5,2);
		}else{
			$con=array('isreturn'=>0,'orderby'=>'o.order_id','orderby_res'=>'DESC','row'=>$row,'page'=>$data['page']);
			
			$valueinfo=$this->session->userdata('search_order_status');
			if ($valueinfo!=''){
				$con['status']=$valueinfo;
			}
			
			$data['order']=$this->OrderModel->getorderlist($con);
			$data['count']=$this->OrderModel->getorderlist($con,1);
			$url = base_url().'admins/order/index';
			$data['fy'] = fy_backend($data['count'],$row,$url,$data['page']);
		}
		$this->load->view('admin/order_list',$data);
	}
	
	function search_order_status(){
		$valueinfo=$this->input->post('valueinfo');
		$this->session->set_userdata('search_order_status',$valueinfo);
	}
	
	function view_order($order_id){
		$data['url']='<a href="'.base_url().'admins/order/index'.'"><font>'.lang('order_manage').'</font></a> > <font class="nav_underline">'.lang('order_view').'</font>';
		$data['orderinfo']=$this->OrderModel->getorderinfo($order_id);
		$data['order_detaillist']=$this->OrderModel->getorder_productlist(array('order_id'=>$order_id,'orderby'=>'id','ASC'));
		//获取退货记录日志
		$data['log_arr']=$this->OrderModel->getorder_loglist(array('order_id'=>$order_id,'orderby'=>'log_id','orderby_res'=>'ASC'));
		$this->load->view('admin/order_view',$data);
	}
	
	function toedit_order($order_id){
		$data['url']='<a href="'.base_url().'admins/order/index'.'"><font>'.lang('order_manage').'</font></a> > <font class="nav_underline">'.lang('order_view').'</font>';
		$data['orderinfo']=$this->OrderModel->getorderinfo($order_id);
		$data['order_detaillist']=$this->OrderModel->getorder_productlist(array('order_id'=>$order_id,'orderby'=>'id','ASC'));
		//获取退货记录日志
		$data['log_arr']=$this->OrderModel->getorder_loglist(array('order_id'=>$order_id,'orderby'=>'log_id','orderby_res'=>'ASC'));
		$this->load->view('admin/order_edit',$data);
	}
	
	function edit_order($order_id){
		$phone=$this->input->post('phone');
		$address=$this->input->post('address');
		$country=$this->input->post('country');
		$province='';
		$city='';
		$area='';
		$this->OrderModel->edit_order($order_id,array('phone'=>$phone,'address'=>$address,'country'=>$country,'province'=>$province,'city'=>$city,'area'=>$area));
		redirect('admins/order/toedit_order/'.$order_id);
	}
	
	function view_returnorder($order_id){
		$data['url']='<a href="'.base_url().'admins/order/returned'.'"><font>退货管理</font></a> > <font class="nav_underline">'.lang('order_view').'</font>';
		$data['orderinfo']=$this->OrderModel->getorderinfo($order_id);
		$data['order_detaillist']=$this->OrderModel->getorder_productlist(array('order_id'=>$order_id,'orderby'=>'id','ASC'));
		$this->load->view('admin/order_view',$data);
	}
	
	function del_order($order_id){
		$orderinfo=$this->OrderModel->getorderinfo($order_id);
		$this->OrderModel->del_order($order_id);
	}
	
	
	//查看物流
	function view_wuliu(){
		$express_type=$this->input->post('express_type');
		$express_number=$this->input->post('express_number');
		$express = $this->OrderModel->getexpressinfo(intval($express_type));
		if(!empty($express)){
			$ejson = file_get_contents('http://api.ickd.cn/?id=102102&secret=c036f84228cb0cd6d5334338467278e0&com='.$express['code_name'].'&nu='.$express_number.'&type=html');
			$data['expressstr'] = $ejson;
		}
		$express['express_number'] = $express_number;
		$data['express'] = $express;
		$this->load->view('admin/express_view',$data);
	}
	
	function adminactiontopay($order_id){
		$orderinfo=$this->OrderModel->getorderinfo($order_id);
		$this->OrderModel->edit_order($order_id,array('status'=>1));
		//添加退换货记录--开始
			addorder_log(array('order_id'=>$order_id,'content'=>'管理员已操作此订单为付款订单'));
		//添加退换货记录--结束
	}
	
	/*
	 * 我的求购 
	 * 全部列表
	 * */
	function myqiugou_manage_all($row=0){
		$this->session->set_userdata('submenu','myqiugou_manage_all');
		$data['page']=40;
		$data['row']=$row;
		$data['url']='<font class="nav_underline">'.lang('myqiugou_manage').'</font>';
		if ($_GET){
			$page=$this->input->get('page');
			$data['page']=$page;
			
			$row=$this->input->get('row');
			if($row==""){$row=0;}
			$data['row']=$row;
			$search_key=$this->input->get('search_key');
			//排序--开始
				$orderby=$this->input->get('orderby');
				$orderby_res=$this->input->get('orderby_res');
				$orderby='id';
				$orderby_res='DESC';
			//排序--结束
			$con=array('orderby'=>$orderby,'orderby_res'=>$orderby_res,'row'=>$row,'page'=>$data['page']);
			if($search_key!=""){
				$con['search_key']=$search_key;
			}
			$data['qiugou']=$this->UserModel->getqiugoulist($con);
			$data['count']=$this->UserModel->getqiugoulist($con,1);
			
			$url = base_url().'admins/order/myqiugou_manage_all?search_key='.$search_key.'&orderby='.$orderby.'&orderby_res='.$orderby_res.'&page='.$page;
			$data['fy'] = fy_backend($data['count'],$row,$url,$data['page'],5,2);
		}else{
			$con=array('orderby'=>'f.id','orderby_res'=>'DESC','row'=>$row,'page'=>$data['page']);
			$data['qiugou']=$this->UserModel->getqiugoulist($con);
			$data['count']=$this->UserModel->getqiugoulist($con,1);
			$url = base_url().'admins/order/myqiugou_manage_all';
			$data['fy'] = fy_backend($data['count'],$row,$url,$data['page']);
		}
		$this->load->view('admin/order_qiugou_list',$data);
	}
	
	function change_myqiugou_status($id=0,$status=0){
		if($status==1){
			$arr=array('status'=>0);
			$this->UserModel->edit_myqiugou($id,$arr);	
		}else{
			$arr=array('status'=>1);
			$this->UserModel->edit_myqiugou($id,$arr);
		}
		redirect(base_url().'admins/order/myqiugou_manage_all');
	}
	
	function topiliangaction($type='delete'){
		$order_id=$this->input->post('order_id');
		if(!empty($order_id)){
			if($type=='delete'){
				for($i=0;$i<count($order_id);$i++){
					$this->OrderModel->del_order($order_id[$i]);
				}
			}
		}
	}
	
	function view_qiugou_info($id){
		$data['info']=$this->UserModel->get_myqiugou_info($id);
		$this->load->view('admin/order_qiugou_info',$data);
	}
	
}