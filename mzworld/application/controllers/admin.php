<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Admin extends CI_Controller {
	
	function Admin() {
		session_start();
		parent::__construct ();
		$this->session->set_userdata('menu','home');
		$lang=$this->session->userdata('lang');
			$this->session->set_userdata('lang','en');
			$this->langtype='_en';
			$this->lang->load('gksel','english');
	}
	
//	function index(){
//		$this->load->view ( 'admin/home_list');
//	}
	
	
	function index(){
		$admin = $this->session->userdata ( 'admin' );
		$uid = $admin ['uid'];
		$username = $admin ['username'];
		if (! empty ( $uid ) && ! empty ( $username )) {
			redirect(base_url().'?c=adminhome&m=index');
		}else {
			$this->load->view ( 'admin/hlogin' );
		}
	}

	function tologin(){
		$aname = strip_tags($this->input->post ( 'aname' ));
		$apass = strip_tags($this->input->post ( 'apass' ));
		$ispass=1;
		$result = $this->AdminModel->checkAdmin ( $aname, md5($apass));
		if($result){
			
			$code=$this->input->post('code');
			if(strtolower($code)!=strtolower ($_SESSION ["yan"])){
				$data ['code_error'] = '验证码错误';
				$ispass=0;
			}else{
				$userinfo = array ('uid' => $result['uid'], 'username' => $result['username'] );
			
				$this->session->set_userdata ('admin',$userinfo,3600*24);
				
				redirect(base_url().'?c=adminhome&m=index');
			}
			
		}else {
			if ($result=="" && $aname!='' && $apass!=''){
				$ispass=0;
				$data ['error'] = '用户名或密码错误';
			}
			
			if ($aname==''){
				$data ['aname_error'] = '请输入用户名';
				$ispass=0;
			}
			
			if ($apass==''){
				$data ['apass_error'] = '请输入密码';
				$ispass=0;
			}
		}
		if ($ispass==0){
			$this->load->view ( 'admin/hlogin', $data );
		}
	}
	
	function logout() {
		$this->session->unset_userdata ( 'admin' );
		redirect ( 'admin/index' );
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */