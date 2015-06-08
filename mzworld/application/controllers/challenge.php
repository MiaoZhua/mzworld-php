<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Challenge extends CI_Controller {

	function __construct(){
		session_start();
		parent::__construct();
		$this->temp=$this->config->item('template');
		
		$this->langtype='_en';
	}
	
	
	function getcollengezuopinlist(){
		$from=$this->input->get('from');
		$challenge_id=$this->input->get('challenge_id');
		$where='';
		if($from=='yplan'){
			$where=" AND ((issue_to='3') OR (issue_to=3))";
		}else if($from=='gallery'){
			$where=" AND ((issue_to='1') OR (issue_to=1) OR (issue_to='2') OR (issue_to=2))";
		}else{
			$where=" AND ((issue_to='1') OR (issue_to=1) OR (issue_to='2') OR (issue_to=2))";
		}
		$sql="
			SELECT 
			
			* 
			
			FROM px_opus 
			
			WHERE type_id=$challenge_id AND is_status NOT IN (3) $where
			
			ORDER BY opus_id DESC
		";
		
		$result=$this->db->query($sql)->result_array();
		if(!empty($result)){
			$data['zuopinlist']=$result;
		}else{
			$data['zuopinlist']=null;
		}
		$this->load->view($this->temp.'collenge_zuopin_list',$data);
	}
	
	
	function gethotzuopinlist(){
		$from=$this->input->get('from');
		$challenge_id=$this->input->get('challenge_id');
		$where='';
		if($from=='yplan'){
			$where=" AND ((issue_to='3') OR (issue_to=3))";
		}else if($from=='gallery'){
			$where=" AND ((issue_to='1') OR (issue_to=1) OR (issue_to='2') OR (issue_to=2))";
		}else{
			$where=" AND ((issue_to='1') OR (issue_to=1) OR (issue_to='2') OR (issue_to=2))";
		}
		$sql="
			SELECT * 
			
			FROM px_opus 
			
			WHERE type_id=$challenge_id AND is_status NOT IN (3) $where
			
			ORDER BY praise_count DESC, opus_id DESC 
			
			LIMIT 0,4
		";
		$result=$this->db->query($sql)->result_array();
		if(!empty($result)){
			$data['zuopinlist']=$result;
		}else{
			$data['zuopinlist']=null;
		}
		$this->load->view($this->temp.'collenge_zuopin_list',$data);
	}
	
	
	
	//获取画廊的    召集的前3个作品
	function getgalleryzuopinlist(){
		$challenge_id=$this->input->get('challenge_id');
		$sql="
			SELECT * 
			
			FROM px_opus 
			
			WHERE type_id=$challenge_id AND is_status NOT IN (3) AND ((issue_to='1') OR (issue_to=1) OR (issue_to='2') OR (issue_to=2))
			
			ORDER BY opus_id DESC 
			
			LIMIT 0,3
		";
		$result=$this->db->query($sql)->result_array();
		if(!empty($result)){
			$data['zuopinlist']=$result;
		}else{
			$data['zuopinlist']=null;
		}
		$this->load->view($this->temp.'gallery_zuopin_list',$data);
	}
	
	
	//添加召集
	function toaddchallenge(){
//		$user_id=1560;
//		$challenge_name='test';
//		$challenge_profile='tetest';
//		$challenge_shichang='30';
//		$challenge_tag='teg';
//		$pic_1='123.jpg';
//		$description=array('asdfasdf ');
//		$attach=array();
//		$attach[]='attach.zip';
		
		$user_id=$this->input->post('user_id');
		$challenge_name=$this->input->post('challenge_name');
		$challenge_profile=$this->input->post('challenge_profile');
		$challenge_shichang=$this->input->post('challenge_shichang');
		$challenge_tag=$this->input->post('challenge_tag');
		$pic_1=$this->input->post('pic_1');
		
		$arr=array('user_id'=>$user_id,'challenge_name'=>$challenge_name,'pic_1'=>$pic_1,'challenge_profile'=>$challenge_profile,'challenge_description'=>$challenge_profile,'challenge_shichang'=>$challenge_shichang,'challenge_tag'=>$challenge_tag,'created'=>mktime(),'edited'=>mktime());
		$challenge_id=$this->ChallengeModel->add_challenge($arr);
		
		
		
		
		$title=$this->input->post('title');
		$description=$this->input->post('description');
		if(!empty($description)){for($i=0;$i<count($description);$i++){
			$arr=array('challenge_id'=>$challenge_id,'title'=>$title[$i],'description'=>$description[$i],'created'=>mktime(),'edited'=>mktime());
			$this->ChallengeModel->add_challenge_description($arr);
		}}
		
		
		$attach=$this->input->post('attach');
		$attach_truename=$this->input->post('attach_truename');
		$attach_size=$this->input->post('attach_size');
		$attach_houzui=$this->input->post('attach_houzui');
		if(!empty($attach)){for($i=0;$i<count($attach);$i++){
			$arr=array('challenge_id'=>$challenge_id,'name'=>$attach_truename[$i],'size'=>$attach_size[$i],'houzui'=>$attach_houzui[$i],'path'=>$attach[$i],'created'=>mktime(),'edited'=>mktime());
			$this->ChallengeModel->add_challenge_attach($arr);
		}}
		
	}
	
	function todownloadfile(){
		$path=$this->input->get('path');
		$name_start=$this->input->get('name_start');
		$name_end=$this->input->get('name_end');
		if($name_end=='pdf'){
			// We'll be outputting a PDF  
			header('Content-type: application/pdf');  
			// It will be called downloaded.pdf  
			header('Content-Disposition: attachment; filename="'.$name_start.'.'.$name_end.'"');  
			// The PDF source is in original.pdf  
			readfile($path);
		}else if($name_end=='doc'||$name_end=='docx'){
			// We'll be outputting a PDF  
			header('Content-type: application/msword');  
			// It will be called downloaded.pdf  
			header('Content-Disposition: attachment; filename="'.$name_start.'.'.$name_end.'"');  
			// The PDF source is in original.pdf  
			readfile($path);
		}else if($name_end=='xls'||$name_end=='xlsx'||$name_end=='csv'){
			// We'll be outputting a PDF  
			header('Content-type: application/vnd.ms-excel');  
			// It will be called downloaded.pdf  
			header('Content-Disposition: attachment; filename="'.$name_start.'.'.$name_end.'"');  
			// The PDF source is in original.pdf  
			readfile($path);
		}else if($name_end=='zip'){
			// We'll be outputting a PDF  
			header('Content-type: application/zip');  
			// It will be called downloaded.pdf  
			header('Content-Disposition: attachment; filename="'.$name_start.'.'.$name_end.'"');  
			// The PDF source is in original.pdf  
			readfile($path);
		}else if($name_end=='rar'){
			// We'll be outputting a PDF  
			header('Content-type: application/x-rar-compressed');  
			// It will be called downloaded.pdf  
			header('Content-Disposition: attachment; filename="'.$name_start.'.'.$name_end.'"');  
			// The PDF source is in original.pdf  
			readfile($path);
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */