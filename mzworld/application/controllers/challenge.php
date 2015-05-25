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
		$collenge_id=$this->input->get('collenge_id');
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
			
			WHERE type_id=$collenge_id AND is_status NOT IN (3) $where
			
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
		$collenge_id=$this->input->get('collenge_id');
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
			
			WHERE type_id=$collenge_id AND is_status NOT IN (3) $where
			
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
		$collenge_id=$this->input->get('collenge_id');
		$sql="
			SELECT * 
			
			FROM px_opus 
			
			WHERE type_id=$collenge_id AND is_status NOT IN (3) AND ((issue_to='1') OR (issue_to=1) OR (issue_to='2') OR (issue_to=2))
			
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
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */