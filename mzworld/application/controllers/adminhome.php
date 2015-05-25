<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Adminhome extends CI_Controller {
	
	function Adminhome() {
		session_start();
		parent::__construct ();
		$this->session->set_userdata('menu','home');
		$lang=$this->session->userdata('lang');
		$this->session->set_userdata('lang','ch');
		$this->langtype='_en';
		$this->lang->load('gksel','english');
		
		$this->category_id=30;//category_id
		$this->category_key='eDkv5Sf59btGZikJIqGeUhSCG5KTByDv';//category_id
		$this->controller='home';
	}
	
	function index(){
		$this->load->view ( 'admin/home_list');
	}
	
	//删除产品
	function del_article($article_id){
		$this->ArticleModel->del_article($article_id);
	}
	
	function del_cagetory($id){
		$this->ArticleModel->del_category($id);
	}
	
	//修改文章的排序
	function editarticlesort(){
		$idarr=$this->input->post('idarr');
		$newsrot=$this->input->post('newsrot');
		if(!empty($idarr)){
			for($i=0;$i<count($idarr);$i++){
				$this->ArticleModel->edit_article($idarr[$i],array('sort'=>$newsrot[$i]));
			}
		}
	}
	
	//修改类别的排序
	function editcategorysort(){
		$idarr=$this->input->post('idarr');
		$newsrot=$this->input->post('newsrot');
		if(!empty($idarr)){
			for($i=0;$i<count($idarr);$i++){
				$this->ArticleModel->edit_category($idarr[$i],array('sort'=>$newsrot[$i]));
			}
		}
	}
	
	
	function toevent_calendar_pick($year=0,$month=0){
		$id=$this->input->post('id');
		
		$prefs = array (
               'show_next_prev'  => TRUE,
		 	   'day_type'     => 'lshort'
//		 		'next_prev_url'   => 'javascript:;'
             );
             
             
		$prefs['template'] = '

		   {table_open}<table border="0" cellpadding="0" cellspacing="0" style="float:left;width:250px;padding:0px;border:1px solid #CCC;text-align:center;-moz-border-radius: 5px;-webkit-border-radius: 5px;background:white;">{/table_open}
		
		  
		   {heading_row_start}<tr style="background-color:#0C3E74;">{/heading_row_start}
		   {heading_previous_cell}<th height="50" colspan="2" style="padding:0px;-moz-border-top-left-radius: 4px;-webkit-border-top-left-radius: 4px;"><a style="color:white;" href="javascript:;" onclick="togetshiwucalendar_month(\''.$id.'\',{previous_url})">上一月</a></th>{/heading_previous_cell}
		   {heading_title_cell}<th colspan="3" style="font-size:14px;padding:0px;color:white;">{heading}</th>{/heading_title_cell}
		   {heading_next_cell}<th colspan="2" style="padding:0px;-moz-border-top-right-radius: 4px;-webkit-border-top-right-radius: 4px;"><a style="color:white;" href="javascript:;" onclick="togetshiwucalendar_month(\''.$id.'\',{next_url})">下一月</a></th>{/heading_next_cell}
		   {heading_row_end}</tr>{/heading_row_end}
		  
		  
		   {week_row_start}<tr>{/week_row_start}
		   {week_day_cell}<td height="25" style="color:gray;border-bottom:1px solid #CCC;padding:0px;">{week_day}</td>{/week_day_cell}
		   {week_row_end}</tr>{/week_row_end}
		  
		
		   {cal_row_start}<tr>{/cal_row_start}
		   {cal_cell_start}<td style="width:'.((1/7)*100).'%;padding:0px;"><div style="float:left;text-align:center;width:90%;height:20px;line-height:20px;margin-left:3.5%;margin-top:5px;border:1px solid #EFEFEF;">{/cal_cell_start}
		
		   {cal_cell_content}<a href="{content}" id="shiwu_{day_id}" onclick="togetrilidatatoinput(\''.$id.'\',{showthings})"><font style="float:left;width:100%;height:20px;line-height:20px;text-align:center;background:#0C3E74;color:white;font-weight:bold;-moz-border-radius: 3px;-webkit-border-radius: 3px;">{day}</font></a>{/cal_cell_content}
		   {cal_cell_content_today}<a href="{content}" id="shiwu_{day_id}" onclick="togetrilidatatoinput(\''.$id.'\',{showthings})"><font style="float:left;width:100%;height:20px;line-height:20px;text-align:center;background:#0C3E74;color:white;font-weight:bold;-moz-border-radius: 3px;-webkit-border-radius: 3px;">{day}</font></a>{/cal_cell_content_today}
		
		   {cal_cell_no_content}<a href="javascript:;" id="shiwu_{day_id}" onclick="togetrilidatatoinput(\''.$id.'\',{showthings})"><font style="float:left;width:100%;height:20px;line-height:20px;text-align:center;background:#efefef;color:gray;-moz-border-radius: 3px;-webkit-border-radius: 3px;">{day}</font></a>{/cal_cell_no_content}
		   {cal_cell_no_content_today}<a href="javascript:;" id="shiwu_{day_id}" onclick="togetrilidatatoinput(\''.$id.'\',{showthings})"><font style="float:left;width:100%;height:20px;line-height:20px;text-align:center;background:#efefef;color:gray;-moz-border-radius: 3px;-webkit-border-radius: 3px;">{day}</font></a>{/cal_cell_no_content_today}
		
		   {cal_cell_blank}&nbsp;{/cal_cell_blank}
		
		   {cal_cell_end}</div></td>{/cal_cell_end}
		   {cal_row_end}</tr>{/cal_row_end}
		
		   {table_close}</table>{/table_close}
		';
		
		$this->load->library('calendar', $prefs);
		
		$data=array();
		$default_val=$this->input->post('default_val');
		if($default_val!=""){
			$val_arr=explode('-',$default_val);
			if(isset($val_arr[0])&&isset($val_arr[1])&&isset($val_arr[2])){
				$data[intval($val_arr[2])]='javascript:;';
			}
		}
		
		
		if($year==0&&$month==0){
			if($default_val!=""){
				$val_arr=explode('-',$default_val);
				if(isset($val_arr[0])&&isset($val_arr[1])&&isset($val_arr[2])){
					echo $this->calendar->generate(intval($val_arr[0]),intval($val_arr[1]),$data);
				}else{
					echo $this->calendar->generate(date('Y'),date('m'),$data);
				}
			}else{
				echo $this->calendar->generate(date('Y'),date('m'),$data);
			}
		}else{
			echo $this->calendar->generate($year, $month,$data);
		}
		
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */