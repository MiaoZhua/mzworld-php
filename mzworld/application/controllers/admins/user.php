<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->session->set_userdata('menu','user');
		$admin=$this->session->userdata ( 'admin' );
		if(empty($admin)){
		    redirect('admin');
		}
//		$lang=$this->session->userdata('lang');
//		if($lang=='ch'){
//			$this->session->set_userdata('lang','ch');
//			$this->langtype='_ch';
//			$this->lang->load('gksel','chinese');
//		}else if($lang=='it'){
//			$this->session->set_userdata('lang','it');
//			$this->langtype='_it';
//			$this->lang->load('gksel','italy');
//		}else if($lang=='de'){
//			$this->session->set_userdata('lang','de');
//			$this->langtype='_de';
//			$this->lang->load('gksel','germany');
//		}else{
//			$this->session->set_userdata('lang','en');
			$this->langtype='_en';
			$this->lang->load('gksel','english');
//		}
	}
	
	function index($row=0){
		$this->WelModel->truncate_file_interim();//清理没有用的图片或附件
		$this->session->set_userdata('submenu','user');
		$data['page']=20;
		$data['url']='<font class="nav_underline">管理用户</font>';
		if ($_GET){
			$row=$this->input->get('row');
			if($row==""){$row=0;}
			$page=$this->input->get('page');
			$data['page']=$page;
			$keyword=$this->input->get('keyword');
			$status=$this->input->get('status');
			//排序--开始
				$orderby_old=$this->input->get('orderby');
				$orderby=$this->input->get('orderby');
				$orderby_res=$this->input->get('orderby_res');
				if($orderby!=''&&$orderby_res!=''){
					if($orderby=='phone'){
						$orderby='ud.'.$orderby;
					}else if($orderby=='role_name'){
						$orderby='r.'.$orderby;
					}else if($orderby=='group_name'){
						$orderby='g.'.$orderby;
					}else{
						$orderby='u.'.$orderby;
					}
				}else{
					$orderby='u.uid';
					$orderby_res='DESC';
				}
			//排序--结束
			$con=array('orderby'=>$orderby,'orderby_res'=>$orderby_res,'row'=>$row,'page'=>$data['page']);
			if($keyword!=""){
				$con['keyword']=$keyword;
			}
			if($status!=""){
				$con['status']=$status;
			}
			$data['user']=$this->UserModel->getuserlist($con);
			$data['count']=$this->UserModel->getuserlist($con,1);
			$url = site_url('admins/user/index?keyword='.$keyword.'&orderby='.$orderby_old.'&orderby_res='.$orderby_res.'&page='.$page);
			$data['fy'] = fy_backend($data['count'],$row,$url,$data['page'],5,2);
		}else{
			$con=array('orderby'=>'u.uid','orderby_res'=>'DESC','row'=>$row,'page'=>$data['page']);
			$data['user']=$this->UserModel->getuserlist($con);
			$data['count']=$this->UserModel->getuserlist($con,1);
			$url = site_url('admins/user/index');
			$data['fy'] = fy_backend($data['count'],$row,$url,$data['page']);
		}
		$this->load->view('admin/user_list',$data);
	}
	
	function manageadmin($row=0){
		$this->WelModel->truncate_file_interim();//清理没有用的图片或附件
		$this->session->set_userdata('submenu','user');
		$data['page']=10;
		$data['url']='<font class="nav_underline">Manage administrator</font>';
		$con=array('orderby'=>'uid','orderby_res'=>'ASC','row'=>$row,'page'=>$data['page']);
		$data['user']=$this->AdminModel->getadminlist($con);
		$data['count']=$this->AdminModel->getadminlist($con,1);
		$url = site_url('admins/user/manageadmin');
		$data['fy'] = fy_backend($data['count'],$row,$url,$data['page']);
		$this->load->view('admin/user_admin_list',$data);
	}
	
	//裁剪用户头像
	function tocutsise_user(){
		$this->load->library('app');
		$img_user=$this->input->post('img_user');
		
		$img_user_fege = explode ( '.', $img_user );
		$new_name = mktime().rand(10000,100000) . '.' . $img_user_fege [count ( $img_user_fege ) - 1];
		
		$x1=$this->input->post('x1');
		$x2=$this->input->post('x2');
		$y1=$this->input->post('y1');
		$y2=$this->input->post('y2');
		$w=$this->input->post('w');
		$h=$this->input->post('h');
		$img_new=$this->app->tocutsise_user($img_user,$new_name,$x1,$y1,$w,$h);
		//将图片缩放成100*100
		$width = $this->getWidth($img_new);
		$height = $this->getHeight($img_new);
		
		$scale = 100/$width;
		$this->resizeImage($img_new,$width,$height,$scale);
		//添加到临时文件表中
		$this->WelModel->add_file_interim(array('file_path'=>$img_new,'created'=>mktime()));
		echo $img_new;
	}
	

	
	function toadd_admin(){
		$data['url']='<a href="'.site_url('admins/user/manageadmin').'"><font>Manage administrator</font></a> > <font class="nav_underline">Add administrator</font>';
		$this->load->view('admin/user_admin_add',$data);
	}
	
	function add_admin(){
		$username=$this->input->post('username');
		$email=$this->input->post('email');
		$password=$this->input->post('password');
		$cpassword=$this->input->post('cpassword');
		$this->form_validation->set_rules('username','Username','trim|required');
		$this->form_validation->set_rules('password','Password','trim|required');
		$this->form_validation->set_rules('cpassword','Comfirm Password','trim|matches[password]|required');
		
		$this->form_validation->set_message('required', '%s can not be empty');
		
		if($this->form_validation->run()==false){
			$data['url']='<a href="'.site_url('admins/user/manageadmin').'"><font>Manage administrator</font></a> > <font class="nav_underline">Add administrator</font>';
			$this->load->view('admin/user_admin_add',$data);
			return;
		}
		$arr=array('username'=>$username,'email'=>$email,'password'=>md5($password),'status'=>1,'created'=>mktime(),'edited'=>mktime());
		$this->AdminModel->addadmin($arr);
		redirect('admins/user/manageadmin');
	}
	
	function toedit_admin($uid){
		$data['url']='<a href="'.site_url('admins/user/manageadmin').'"><font>Manage administrator</font></a> > <font class="nav_underline">Edit administrator</font>';
		$data['userinfo']=$this->AdminModel->getotheradmininfo($uid);
		$this->load->view('admin/user_admin_edit',$data);
	}
	
	function edit_admin(){
		$uid=$this->input->post('uid');
		$username=$this->input->post('username');
		$email=$this->input->post('email');
		$password=$this->input->post('password');
		$status=$this->input->post('status');
		$this->form_validation->set_rules('username','Username','trim|required');
		
		$this->form_validation->set_message('required', '%s can not be empty');
		
		if($this->form_validation->run()==false){
			$data['url']='<a href="'.site_url('admins/user/manageadmin').'"><font>Manage administrator</font></a> > <font class="nav_underline">Edit administrator</font>';
			$data['userinfo']=$this->AdminModel->getotheradmininfo($uid);
			$this->load->view('admin/user_admin_edit',$data);
			return;
		}
		$arr=array('username'=>$username,'email'=>$email,'password'=>md5($password),'status'=>$status,'edited'=>mktime());
		if($password!=null){
			$arr['password']=md5($password);
		}
		$this->AdminModel->updateadmin($uid,$arr);
		redirect('admins/user/manageadmin');
	}
	
	
	function toadd_user(){
		$data['url']='<a href="'.site_url('admins/user').'"><font>管理用户</font></a> > <font class="nav_underline">添加用户</font>';
		$this->load->view('admin/user_add',$data);
	}
	
	function add_user(){
		$email=$this->input->post('email');
		$firstname=$this->input->post('firstname');
		$lastname=$this->input->post('lastname');
		$phone=$this->input->post('phone');
		$company_name=$this->input->post('company_name');
		$country=$this->input->post('country');
		$password=$this->input->post('password');
		
		
		$this->form_validation->set_rules('email','Email','trim|required');
		$this->form_validation->set_rules('firstname','firstname','trim|required');
		$this->form_validation->set_rules('lastname','Lastname','trim|required');
		$this->form_validation->set_rules('company_name','Company Name','trim|required');
		$this->form_validation->set_rules('country','Country','trim|required');
		
		$this->form_validation->set_message('required', '%s can not be empty');
		
		if($this->form_validation->run()==false){
			$data['url']='<a href="'.site_url('admins/user').'"><font>管理用户</font></a> > <font class="nav_underline">添加用户</font>';
			$this->load->view('admin/user_add',$data);
			return;
		}
		$group_id=explode('|',$group_id);
		$arr=array('username'=>$firstname.' '.$lastname,'firstname'=>$firstname,'lastname'=>$lastname,'email'=>$email,'phone'=>$phone,'company_name'=>$company_name,'country'=>$country,'password'=>md5($password),'status'=>0,'created'=>mktime(),'edited'=>mktime());
		
		$this->UserModel->add_user($arr);
		redirect('admins/user');
	}
	
	function toedit_user($uid){
		$data['url']='<a href="'.site_url('admins/user').'"><font>管理用户</font></a> > <font class="nav_underline">Edit User</font>';
		$data['userinfo']=$this->UserModel->getuserinfo($uid);
		$this->load->view('admin/user_edit',$data);
	}
	
	function edit_user(){
		$uid=$this->input->post('uid');
		$type=$this->input->post('type');
		$firstname=$this->input->post('firstname');
		$lastname=$this->input->post('lastname');
		$phone=$this->input->post('phone');
		$company_name=$this->input->post('company_name');
		$country=$this->input->post('country');
		$password=$this->input->post('password');
		$status=$this->input->post('status');
		
		$this->form_validation->set_rules('type','Type','trim');
		$this->form_validation->set_rules('firstname','Firstname','trim|required');
		$this->form_validation->set_rules('lastname','Lastname','trim|required');
		$this->form_validation->set_rules('phone','Phone','trim|required');
		$this->form_validation->set_rules('company_name','Company Name','trim|required');
		$this->form_validation->set_rules('country','Country','trim|required');
		
		$this->form_validation->set_message('required', '%s can not be empty');
		
		if($this->form_validation->run()==false){
			$data['url']='<a href="'.site_url('admins/user').'"><font>管理用户</font></a> > <font class="nav_underline">Edit User</font>';
			$data['userinfo']=$this->UserModel->getuserinfo($uid);
			$this->load->view('admin/user_edit',$data);
			return;
		}
		$arr=array('type'=>$type,'username'=>$firstname.' '.$lastname,'firstname'=>$firstname,'lastname'=>$lastname,'phone'=>$phone,'company_name'=>$company_name,'country'=>$country,'status'=>$status,'edited'=>mktime(),'created'=>mktime());
		if($password!=null){
			$arr['password']=md5($password);
		}
		
		$this->UserModel->edit_user($uid,$arr);
		redirect('admins/user');
	}
	
	/*
	 * 注册 邮件
	 * */
	function send_audit_email($uid=0,$langtype='_en'){
		//发送邮件
		$issend=1;
		$str_1='192.168.1';
		$str_2='localhost';
		$baseurl_test=base_url();
		$baseurl_test_1=explode($str_1,$baseurl_test);
		if(count($baseurl_test_1)>=2){
			$issend=0;
		}
		$baseurl_test_2=explode($str_2,$baseurl_test);
		if(count($baseurl_test_2)>=2){
			$issend=0;
		}
//		$issend=1;
		$userinfo=$this->UserModel->getuserinfo($uid);
		$emailinfo=$this->CmsModel->getemailinfo(4);
		if($issend==1&&!empty($emailinfo)&&!empty($userinfo)){
			$reparr=array();
			$reparr[]=array('name'=>'{user_firstname}','value'=>$userinfo['firstname']);
			$reparr[]=array('name'=>'{user_lastname}','value'=>$userinfo['lastname']);
			$reparr[]=array('name'=>'{user_email}','value'=>$userinfo['email']);
			
			$email_content=replace_content($reparr,$emailinfo['email_content'.$langtype]);
			$email_sender=replace_content($reparr,$emailinfo['email_sender']);
			$email_from=replace_content($reparr,$emailinfo['email_from']);
			$email_replyto=replace_content($reparr,$emailinfo['email_replyto']);
			$email_to=replace_content($reparr,$emailinfo['email_to']);
			$email_cc=replace_content($reparr,$emailinfo['email_cc']);
			$email_bcc=replace_content($reparr,$emailinfo['email_bcc']);
			$email_subject=replace_content($reparr,$emailinfo['email_subject'.$langtype]);
			
			//内容
			$this->load->library('app');
			if($email_cc!=""&&$email_bcc!=""){
				$header = "From: ".$email_sender."<".$email_from.">\r\n" . "Reply-To: <".$email_replyto.">\r\n" . "CC: <".$email_cc.">\r\n" . "BCC: <".$email_bcc.">\r\n" ."X-Mailer: PHP/" . phpversion () . "\r\n" . "MIME-Version: 1.0\r\n" . "Content-type: text/html; charset=UTF-8\r\n";
			}else if($email_cc==""&&$email_bcc!=""){
				$header = "From: ".$email_sender."<".$email_from.">\r\n" . "Reply-To: <".$email_replyto.">\r\n" . "BCC: <".$email_bcc.">\r\n" ."X-Mailer: PHP/" . phpversion () . "\r\n" . "MIME-Version: 1.0\r\n" . "Content-type: text/html; charset=UTF-8\r\n";
			}else if($email_cc!=""&&$email_bcc==""){
				$header = "From: ".$email_sender."<".$email_from.">\r\n" . "Reply-To: <".$email_replyto.">\r\n" . "CC: <".$email_cc.">\r\n" ."X-Mailer: PHP/" . phpversion () . "\r\n" . "MIME-Version: 1.0\r\n" . "Content-type: text/html; charset=UTF-8\r\n";
			}else{
				$header = "From: ".$email_sender."<".$email_from.">\r\n" . "Reply-To: <".$email_replyto.">\r\n" ."X-Mailer: PHP/" . phpversion () . "\r\n" . "MIME-Version: 1.0\r\n" . "Content-type: text/html; charset=UTF-8\r\n";
			}
			$subject = $email_subject;
			$subject = "=?UTF-8?B?" . base64_encode ( $subject ) . "?=";
			
			$content = '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>'.lang('cy_website_name').'</title>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
			</head>
			<body>
				<div style="float:center;width:100%;max-width:740px;margin:0 auto;">
				<div style="float:left;width:100%;padding:10px 0px 10px 0px;border:1px solid #D5D5D5;border-border-top-right-radius:6px;-moz-border-top-right-radius:6px;-webkit-border-top-right-radius:6px;border-border-top-left-radius:6px;-moz-border-top-left-radius:6px;-webkit-border-top-left-radius:6px;">	
					<font style="float:left;color:white;">
						<img style="float:left;width:160px;margin-left:10px;height:91px;" src="'.base_url().'themes/default/images/logo-2x-res.png"/>
					</font>
					<font style="float:left;text-indent:10px;margin:20px 0px 0px 20px;font-size:20px;color:black;">
						'.$emailinfo['welcome'.$langtype].'
					</font>
				</div>	
				<div style="float:left;font-family: Arial, Helvetica, SimSun, sans-serif;width: 100%;margin-top: 0px;border:1px solid #D5D5D5;">
				<table cellspacing="0" cellpadding=0 width:100%; style="float:left;">
				<tr><td style="padding:20px;font-size:14px;line-height:22px;">
				';
			
			$content .= '
				<div style="float:left;width:100%;line-height:25px;">
					'.$email_content.'
				</div>
			';
			$content .= $this->app->email_fooder();
//			echo $content;exit;
			mail ( $email_to, $subject, $content,$header ,'-f '.$email_from);
		}
	}
	
	function del_user($uid){
		$this->UserModel->del_user($uid);
	}
	
	function del_admin($uid){
		$this->AdminModel->del_admin($uid);
	}
	
	function role($row=0){
		$this->session->set_userdata('submenu','role');
		$page=20;
		$data['url']='<font class="nav_underline">'.lang('role_manage').'</font>';
		if ($_GET){
			$row=$this->input->get('row');
			if($row==""){$row=0;}
			$role_name=$this->input->get('role_name');
			//排序--开始
				$orderby=$this->input->get('orderby');
				$orderby_res=$this->input->get('orderby_res');
				if($orderby!=''&&$orderby_res!=''){
					$orderby='r.'.$orderby;
				}else{
					$orderby='r.role_id';
					$orderby_res='DESC';
				}
			//排序--结束
			
			$con=array('type'=>1,'orderby'=>$orderby,'orderby_res'=>$orderby_res,'row'=>$row,'page'=>$page);
			if($role_name!=""){
				$con['role_name']=$role_name;
			}
			$data['role']=$this->UserModel->getrolelist($con);
			$data['count']=$this->UserModel->getrolelist($con,1);
			$url = site_url('admins/user/role?role_name='.$role_name);
			$data['fy'] = fy_backend($data['count'],$row,$url,$page,5,2);
		}else{
			$con=array('type'=>1,'orderby'=>'r.role_id','orderby_res'=>'DESC','row'=>$row,'page'=>$page);
			$data['role']=$this->UserModel->getrolelist($con);
			$data['count']=$this->UserModel->getrolelist($con,1);
			$url = site_url('admins/user/role');
			$data['fy'] = fy_backend($data['count'],$row,$url,$page);
		}
		$this->load->view('admin/role_list',$data);
	}
	
	function change_user_status($uid=0,$status=0){
		if($status==1){
			$arr=array('status'=>0);
			$this->UserModel->edit_user($uid,$arr);	
		}else{
			$arr=array('status'=>1);
			$this->UserModel->edit_user($uid,$arr);
		}
		redirect('admins/user');
	}
	
	function change_admin_status($id=0,$status=0){
		if($status==1){
			$arr=array('status'=>0);
			$this->AdminModel->updateadmin($id,$arr);	
		}else{
			$arr=array('status'=>1);
			$this->AdminModel->updateadmin($id,$arr);
		}
		redirect('admins/user/manageadmin');
	}
	
	
}