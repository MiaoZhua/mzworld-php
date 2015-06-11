<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->temp=$this->config->item('template');
		
		$this->langtype='_en';
	}
	
	function index(){
		
	}
		
	/*删除提示框*/
	function del_msgnotice_new(){
		$text=$this->input->post('text');
		echo '
			<table cellspacing=0 cellpadding=0 width="100%">
				<tr>
					<td align="left" width="32"><div class="box_tips_not"></td>
					<td align="left">
						<div style="float:left;font-weight:bold;font-size:14px;margin:4px 0px 0px 10px;">
							'.$text.'
						</div>
					</td>
				</tr>
			</table>
		';
	}
	
	/* 上传文件
	 * */
	function upfile(){
		$pic = $_FILES ['newfile'];
		
		$picname = explode ( '.', $pic ['name'] );
		
		$houzuiming=$picname [count ( $picname ) - 1];
		$pic ['name'] = date('Y_m_d_H_i_s').rand(0,1000) . '.' . $houzuiming;
		
		$uploaddir = "../uploads/";
		if (! is_dir ( $uploaddir )) {
			mkdir ( $uploaddir, 0777 );
		}
		$uploaddir = "../uploads/challenge/";
		if (! is_dir ( $uploaddir )) {
			mkdir ( $uploaddir, 0777 );
		}
		$uploaddir = "../uploads/challenge/".date('Y')."/";
		if (! is_dir ( $uploaddir )) {
			mkdir ( $uploaddir, 0777 );
		}
		$uploaddir = "../uploads/challenge/".date('Y')."/".date('m')."/";
		if (! is_dir ( $uploaddir )) {
			mkdir ( $uploaddir, 0777 );
		}
		$path = $uploaddir . $pic ['name'];
		$pathparent = "uploads/challenge/".date('Y')."/".date('m')."/" . $pic ['name'];
		$pathshiji = "challenge/".date('Y')."/".date('m')."/" . $pic ['name'];
//		if (file_exists ( $path )) {
//			$path = 'upload/'.'(new)'.$pic ['name'];
//		}
		move_uploaded_file ( $pic ['tmp_name'], $path );
//		//添加到临时文件表中
		$this->WelModel->add_file_interim(array('file_path'=>$path,'created'=>mktime()));
		
		$jsonarr = array('name'=>$pic ['name'],'size'=>$pic ['size'],'logo'=>$path,'logoparent'=>$pathparent,'logoshiji'=>$pathshiji,'houzuiming'=>$houzuiming);
		$jsonarr = json_encode($jsonarr);
		echo $jsonarr;
	}
	
	/* 上传图片
	 * */
	function uplogo(){
		$default_width=$this->input->get('maxwidth');
		$default_height=$this->input->get('maxheight');
		
		$this->load->library ( 'app' );
		$pic = $_FILES ['logo'];
		$picname = explode ( '.', $pic ['name'] );
		$pic ['name'] = date('Y_m_d_H_i_s').rand(0,1000) . '.' . $picname [count ( $picname ) - 1];
		
		$uploaddir = "../uploads/";
		if (! is_dir ( $uploaddir )) {
			mkdir ( $uploaddir, 0777 );
		}
		$uploaddir = "../uploads/challenge/";
		if (! is_dir ( $uploaddir )) {
			mkdir ( $uploaddir, 0777 );
		}
		$uploaddir = "../uploads/challenge/".date('Y')."/";
		if (! is_dir ( $uploaddir )) {
			mkdir ( $uploaddir, 0777 );
		}
		$uploaddir = "../uploads/challenge/".date('Y')."/".date('m')."/";
		if (! is_dir ( $uploaddir )) {
			mkdir ( $uploaddir, 0777 );
		}
		$path = $uploaddir . $pic ['name'];
		$pathparent = "uploads/challenge/".date('Y')."/".date('m')."/" . $pic ['name'];
		$pathshiji = "challenge/".date('Y')."/".date('m')."/" . $pic ['name'];
//		if (file_exists ( $path )) {
//			$path = '../uploads/challenge/'.'(new)'.$pic ['name'];
//		}
		move_uploaded_file ( $pic ['tmp_name'], $path );
		if($default_width>0&&$default_height>0){
			$img_width=getImgWidth($path);/*获取宽度*/
			$img_height=getImgHeight($path);/*获取高度*/
			if($img_width>=$img_height&&$img_width>$default_width){
				resizeImage($path,$img_width,$img_height,($default_width/$img_width));//等比例压缩
			}else if($img_height>$img_width&&$img_height>$default_width){
				resizeImage($path,$img_width,$img_height,($default_width/$img_height));//等比例压缩
			}
		}
		//添加到临时文件表中
		$this->WelModel->add_file_interim(array('file_path'=>$path,'created'=>mktime()));
		
		$jsonarr = array('name'=>$pic ['name'],'logo'=>$path,'logoparent'=>$pathparent,'logoshiji'=>$pathshiji);
		$jsonarr = json_encode($jsonarr);
		echo $jsonarr;
	}
	
	/* 等比例缩放
	 * */
	function uplogo_deng($default_width=0,$default_height=0){
		$this->load->library ( 'app' );
		$pic = $_FILES ['logo'];
		$picname = explode ( '.', $pic ['name'] );
		$pic ['name'] = mktime ().rand(0,1000) . '.' . $picname [count ( $picname ) - 1];
		
		$uploaddir = "upload/";
		if (! is_dir ( $uploaddir )) {
			mkdir ( $uploaddir, 0777 );
		}
		$path = $uploaddir . $pic ['name'];
		if (file_exists ( $path )) {
			$path = 'upload/'.'(new)'.$pic ['name'];
		}
		move_uploaded_file ( $pic ['tmp_name'], $path );
		$img_width=getImgWidth($path);/*获取宽度*/
		$img_height=getImgHeight($path);/*获取高度*/
		if($img_width>=$img_height&&$img_width>$default_width){
			resizeImage($path,$img_width,$img_height,($default_width/$img_width));//等比例压缩
		}else if($img_height>$img_width&&$img_height>$default_width){
			resizeImage($path,$img_width,$img_height,($default_width/$img_height));//等比例压缩
		}
		//添加到临时文件表中
		$this->WelModel->add_file_interim(array('file_path'=>$path,'created'=>mktime()));
		
		$jsonarr = array('name'=>$pic ['name'],'logo'=>$path);
		$jsonarr = json_encode($jsonarr);
		echo $jsonarr;
	}
	
	
	
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */