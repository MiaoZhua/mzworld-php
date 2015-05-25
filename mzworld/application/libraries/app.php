<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class App {
	public $CI;
    function App(){
    	$this->CI->CI =& get_instance();
		$this->CI->CI->load->helper('url');
		$this->CI->CI->load->helper('form');
		$this->CI->CI->load->helper('cookie');
		$this->CI->CI->load->library('session');
		$this->CI->CI->load->library('form_validation');
		$this->CI->CI->load->library('image_lib');
		$this->CI->CI->config->item('base_url');
    }
    
    function email_header(){
		$content = '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>Mr Right</title>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
			</head>
			<body>
				<div style="float:center;width:100%;max-width:740px;margin:0 auto;">
				<div style="float:left;width:100%;padding:10px 0px 10px 0px;border:1px solid #fbc436;background:#fbc436;border-border-top-right-radius:6px;-moz-border-top-right-radius:6px;-webkit-border-top-right-radius:6px;border-border-top-left-radius:6px;-moz-border-top-left-radius:6px;-webkit-border-top-left-radius:6px;">	
					<font style="font-weight:bold;font-size:20px;color:white;">&nbsp;Mr Right</font>
				</div>	
				<div style="float:left;font-family: Arial, Helvetica, SimSun, sans-serif;width: 100%;margin-top: 0px;border:1px solid #fbc436;">
				<table cellspacing="0" cellpadding=0 width:100%; style="float:left;">
				<tr><td style="padding:20px;font-size:14px;line-height:22px;">
				';
		return $content;
	}
	
    function email_fooder(){
		$content = '
			</td></tr></table>
				    </div>
				  	<div style="float:left;border:1px solid #fbc436;font-family: Arial, Helvetica, SimSun, sans-serif;width:100%;font-size:13px;font-weight:normal;margin:0 auto;padding:10px 0px 10px 0px;float:left;text-align:right;color:#000000;background:#fbc436;border-border-bottom-right-radius:6px;-moz-border-bottom-right-radius:6px;-webkit-border-bottom-right-radius:6px;border-border-bottom-left-radius:6px;-moz-border-bottom-left-radius:6px;-webkit-border-bottom-left-radius:6px;">
				  	    <span style="float:left;color:white;">&nbsp;&nbsp;';
				$content .= lang('cy_copyright');
			
			$content .= ' © 2015 Mr Right</span>
				  	    <span style="float:right;color:white;">
				  	     ';
			
				$content .= lang('cy_allrightsreserved');
			$content .= '  &nbsp;&nbsp;&nbsp;&nbsp; 
					    </span>
					</div>
				</div>
			</body>
			</html>
			';
		return $content;
	}
		
  
	function tocutsise_user($img_user,$new_name,$x1,$y1,$w,$h){
		$config ['image_library'] = 'GD2';
		$config['source_image'] = $img_user;//(必须)设置原始图像的名字/路径
		$config['dynamic_output'] = FALSE;//决定新图像的生成是要写入硬盘还是动态的存在  
		$config['quality'] = '100%';//设置图像的品质。品质越高，图像文件越大  
		$config['new_image'] = 'upload/user/'.$new_name;//(必须)设置图像的目标名/路径。  
		$config['width'] = $w;//(必须)设置你想要得图像宽度  
		$config['height'] = $h;//(必须)设置你想要得图像高度
		$config['maintain_ratio'] = FALSE;//维持比例  
		$config['x_axis'] = $x1;//(必须)从左边取的像素值  
		$config['y_axis'] = $y1;//(必须)从左边取的像素值  
		$this->CI->CI->image_lib->initialize($config);
		if (!$this->CI->CI->image_lib->crop()){
			return $this->CI->CI->image_lib->display_errors();
		}else{
			return $config['new_image'];
		}
	}
    
	
	function uploadimages($filename,$tmp_name,$id=1,$width=70,$height=20) {
		$uploaddir = "upload/$id/";
		$image = array();
		$errorimage = array();
			$iconyuan = "upload/$id/" . $filename;
			$icon = "upload/$id/". 'small'.$filename;
		$uploadfile = $uploaddir . $filename;
		$uploadfile1 = $uploaddir .'small'.$filename;
		
		$uploadfile = iconv('utf-8','gb2312',$uploadfile);
		$uploadfile1 = iconv('utf-8','gb2312',$uploadfile1);
		if(file_exists($uploadfile)){
			$uploadfile = $uploaddir .mktime(). $filename;
			$uploadfile = iconv('utf-8','gb2312',$uploadfile);
		}
		if(file_exists($uploadfile1)){
			$uploadfile1 = $uploaddir .mktime().'small'.$filename;
			$uploadfile1 = iconv('utf-8','gb2312',$uploadfile1);
		}
		 
			if (move_uploaded_file ( $tmp_name, $uploadfile )) {
				$this->imgwatermark($uploadfile);
				move_uploaded_file ($filename, $uploadfile1 );			
				$this->createthumb ( $uploadfile, $uploadfile1, $width, $height );
				$uploadfile = iconv('gb2312','utf-8',$uploadfile);
				$uploadfile1 = iconv('gb2312','utf-8',$uploadfile1);
				$image[] = array ('pic' => $uploadfile ,'smallpic'=>$uploadfile1);
			} else {
				return FALSE;
			}
	}
	
	function createthumb($name, $filename, $new_w, $new_h,$width=null) {
		$system = explode ( ".", $name );
		$type = $system[count($system)-1];
		if (preg_match ( "/gif/", strtolower($type) )) {
			$src_img = imagecreatefromgif ( $name );
		}
		if (preg_match ( "/jpg|jpeg/", strtolower($type) )) {
			$src_img = imagecreatefromjpeg ( $name );
		}
		if (preg_match ( "/png/", strtolower($type) )) {
			$src_img = imagecreatefrompng ( $name );
		}
		$old_x = imageSX ( $src_img );
		$old_y = imageSY ( $src_img );
		if ($old_x > $old_y) {
			if ($old_x > $new_w) {
				$new_x = $new_w;
			} else {
				$new_x = $old_x;
			}
			$thumb_w = $new_x;
			if ($old_y > $new_w) {
				$new_y = $old_y * ($new_w / $old_x);
				if ($new_y > $new_w) {
					$new_y = $new_h;
				}
				$thumb_h = $new_y;
			} else {
				$thumb_h = $old_y;
			}
		
		} elseif ($old_x < $old_y) {
			if ($old_y > $new_w) {
				$new_y = $new_w;
			} else {
				$new_y = $old_y;
			}
			$thumb_h = $new_y;
			if ($old_x > $new_w) {
				$new_x = $old_x * ($new_w / $old_y);
				if ($new_x > $new_w) {
					$new_x = $new_h;
				}
				$thumb_w = $new_x;
			} else {
				$thumb_w = $old_x;
			}
		
		} else {
			if ($old_x > $new_w) {
				$thumb_w = $new_w;
				$thumb_h = $new_w;
			} else {
				$thumb_w = $old_x;
				$thumb_h = $old_y;
			}
		}
		if($width!=null){
			$thumb_w = $width;
			$thumb_h = $width;
		}
		$dst_img=imagecreatetruecolor($thumb_w, $thumb_h);
		imagealphablending($dst_img,false);//这里很重要,意思是不合并颜色,直接用$img图像颜色替换,包括透明色;
		imagesavealpha($dst_img,true);//这里很重要,意思是不要丢了$thumb图像的透明色;
//		$dst_img = ImageCreateTrueColor ( $thumb_w, $thumb_h );
		
		imagecopyresampled ( $dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y );
		
		if (preg_match ( "/png/", $system [1] )) {
			imagepng ( $dst_img, $filename );
		} else {
			imagejpeg ( $dst_img, $filename );
		}
		imagedestroy ( $dst_img );
		imagedestroy ( $src_img );
		//    echo $url.$filename;
	}
	
	function imgwatermark($path) {
		$config ['image_library'] = 'GD2';
		$config ['source_image'] = $path; //包括文件名的原文件路径
		$config ['dynamic_output'] = FALSE;
		$config ['quality'] = '90%';
		$config ['wm_type'] = 'overlay';
		$config ['wm_padding'] = '0';
		$config ['wm_vrt_alignment'] = 'buttom';
		$config ['wm_hor_alignment'] = 'right';
		$config ['wm_vrt_offset'] = '0';
		$config ['wm_hor_offset'] = '0';
		$config ['wm_overlay_path'] = '././img/watermark.png'; //$this->setting['watermark_path']['value'];//水印图像的名字和路径
		$config ['wm_opacity'] = 100; //$this->setting['watermark_trans']['value'];//水印图像的透明度
		$config ['wm_x_transp'] = '4'; //水印图像通道
		$config ['wm_y_transp'] = '4'; //水印图像通道
		$this->CI->CI->image_lib->initialize ( $config );
		$this->CI->CI->image_lib->watermark ();
		$this->CI->CI->image_lib->clear ();
	}
	
	function my_image_resize($src_file, $dst_file , $new_width , $new_height) {
		if($new_width <1 || $new_height <1) {
			echo "params width or height error !";
			exit();
		}
		if(!file_exists($src_file)) {
			echo $src_file . " is not exists !";
			exit();
		}
		// 图像类型
		$type=exif_imagetype($src_file);
		$support_type=array(IMAGETYPE_JPEG , IMAGETYPE_PNG , IMAGETYPE_GIF);
//		print_r($support_type);exit;
		if(!in_array($type, $support_type,true)) {
			echo "this type of image does not support! only support jpg , gif or png";
			exit();
		}
	
	//Load image
	switch($type) {
		case IMAGETYPE_JPEG :
			$src_img=imagecreatefromjpeg($src_file);
			break;
		case IMAGETYPE_PNG :
			$src_img=imagecreatefrompng($src_file);
			break;
		case IMAGETYPE_GIF :
			$src_img=imagecreatefromgif($src_file);
			break;
		default:
			echo "Load image error!";
			exit();
	}
	$w=imagesx($src_img);
	$h=imagesy($src_img);
	$ratio_w=1.0 * $new_width / $w;
	$ratio_h=1.0 * $new_height / $h;
	$ratio=1.0;
	// 生成的图像的高宽比原来的都小，或都大 ，原则是 取大比例放大，取大比例缩小（缩小的比例就比较小了）
	if( ($ratio_w < 1 && $ratio_h < 1) || ($ratio_w > 1 && $ratio_h > 1)) {
		if($ratio_w < $ratio_h) {
			$ratio = $ratio_h ; // 情况一，宽度的比例比高度方向的小，按照高度的比例标准来裁剪或放大
		}else {
			$ratio = $ratio_w ;
		}
		// 定义一个中间的临时图像，该图像的宽高比 正好满足目标要求
		$inter_w=(int)($new_width / $ratio);
		$inter_h=(int) ($new_height / $ratio);
		$inter_img=imagecreatetruecolor($inter_w , $inter_h);
		imagealphablending($inter_img,false);//这里很重要,意思是不合并颜色,直接用$img图像颜色替换,包括透明色;
		imagesavealpha($inter_img,true);//这里很重要,意思是不要丢了$thumb图像的透明色;
		
		imagecopy($inter_img, $src_img, 0,0,0,0,$inter_w,$inter_h);
		if($w>$h){
			$cut =(int) ($w-$inter_w)/2;
			imagecopy($inter_img, $src_img, 0,0,$cut,0,$inter_w,$inter_h);
		}
		if($w<$h){
			$cut =(int) ($h-$inter_h)/2;
			imagecopy($inter_img, $src_img, 0,0,0,$cut,$inter_w,$inter_h);
		}
//		if($w==$h){
//			$cut =(int) ($h-$inter_h)/2;
//			imagecopy($inter_img, $src_img, 0,0,0,$cut,$inter_w,$inter_h);
//		}
	
		// 生成一个以最大边长度为大小的是目标图像$ratio比例的临时图像
		// 定义一个新的图像
		$new_img=imagecreatetruecolor($new_width,$new_height);
		imagealphablending($new_img,false);//这里很重要,意思是不合并颜色,直接用$img图像颜色替换,包括透明色;
		imagesavealpha($new_img,true);//这里很重要,意思是不要丢了$thumb图像的透明色;
		
		
		imagecopyresampled($new_img,$inter_img,0,0,0,0,$new_width,$new_height,$inter_w,$inter_h);
	
		switch($type) {
			case IMAGETYPE_JPEG :
				imagejpeg($new_img, $dst_file,100); // 存储图像
				break;
			case IMAGETYPE_PNG :
				imagepng($new_img,$dst_file);
				break;
			case IMAGETYPE_GIF :
				imagegif($new_img,$dst_file,100);
				break;
			default:
				break;
		}
	} // end if 1
	// 2 目标图像 的一个边大于原图，一个边小于原图 ，先放大平普图像，然后裁剪
	// =if( ($ratio_w < 1 && $ratio_h > 1) || ($ratio_w >1 && $ratio_h <1) )
	else{
		$ratio=$ratio_h>$ratio_w? $ratio_h : $ratio_w; //取比例大的那个值
		// 定义一个中间的大图像，该图像的高或宽和目标图像相等，然后对原图放大
		$inter_w=(int)($w * $ratio);
		$inter_h=(int) ($h * $ratio);
		$inter_img=imagecreatetruecolor($inter_w , $inter_h);
		imagealphablending($inter_img,false);//这里很重要,意思是不合并颜色,直接用$img图像颜色替换,包括透明色;
		imagesavealpha($inter_img,true);//这里很重要,意思是不要丢了$thumb图像的透明色;
		
		
		//将原图缩放比例后裁剪
		imagecopyresampled($inter_img,$src_img,0,0,0,0,$inter_w,$inter_h,$w,$h);
		if($w>$h){
			$inter_w1=(int)($new_width / $ratio);
			$cut =(int) ($w-$inter_w1)/2;
			imagecopyresampled($inter_img,$src_img,0,0,$cut,0,$inter_w,$inter_h,$w,$h);
		}
		if($w<$h){ 
			$inter_h1=(int)($new_height / $ratio);
			$cut =(int) ($h-$inter_h1)/2;
			imagecopyresampled($inter_img,$src_img,0,0,0,$cut,$inter_w,$inter_h,$w,$h);
		}
//		imagecopyresampled($inter_img,$src_img,0,0,0,0,$inter_w,$inter_h,$w,$h);
		// 定义一个新的图像
		$new_img=imagecreatetruecolor($new_width,$new_height);
		imagealphablending($new_img,false);//这里很重要,意思是不合并颜色,直接用$img图像颜色替换,包括透明色;
		imagesavealpha($new_img,true);//这里很重要,意思是不要丢了$thumb图像的透明色;
		
		
		imagecopy($new_img, $inter_img, 0,0,0,0,$new_width,$new_height);
	
		switch($type) {
			case IMAGETYPE_JPEG :
			imagejpeg($new_img, $dst_file,100); // 存储图像
			break;
			case IMAGETYPE_PNG :
			imagepng($new_img,$dst_file,9);
			break;
			case IMAGETYPE_GIF :
			imagegif($new_img,$dst_file,100);
			break;
			default:
			break;
		}
	}// if3
}// end function


//error_reporting( E_ALL ); 
//// 测试 
//imagezoom('1.jpg', '2.jpg', 400, 300, '#FFFFFF');  
/* 
php缩略图函数： 
等比例无损压缩，可填充补充色 author: 华仔 
主持格式： 
bmp 、jpg 、gif、png 
param: 
@srcimage : 要缩小的图片 
@dstimage : 要保存的图片 
@dst_width: 缩小宽 
@dst_height: 缩小高 
@backgroundcolor: 补充色 如：#FFFFFF 支持 6位 不支持3位 
*/ 
function imagezoom( $srcimage, $dstimage, $dst_width, $dst_height, $backgroundcolor ) { 
	// 中文件名乱码 
//	echo "123";exit;
	if ( PHP_OS == 'WINNT' ) { 
	$srcimage = iconv('UTF-8', 'GBK', $srcimage); 
	$dstimage = iconv('UTF-8', 'GBK', $dstimage); 
	} 
	$dstimg = imagecreatetruecolor( $dst_width, $dst_height ); 
	$color = imagecolorallocate($dstimg 
	, hexdec(substr($backgroundcolor, 1, 2)) 
	, hexdec(substr($backgroundcolor, 3, 2)) 
	, hexdec(substr($backgroundcolor, 5, 2)) 
	); 
	imagefill($dstimg, 0, 0, $color); 
	if ( !$arr=getimagesize($srcimage) ) { 
	echo "要生成缩略图的文件不存在"; 
	exit; 
	} 
	$src_width = $arr[0]; 
	$src_height = $arr[1]; 
	$srcimg = null; 
	$method = $this->getcreatemethod( $srcimage ); 
	if ( $method ) { 
	eval( '$srcimg = ' . $method . ';' ); 
	} 
	$dst_x = 0; 
	$dst_y = 0; 
	$dst_w = $dst_width; 
	$dst_h = $dst_height; 
	if ( ($dst_width / $dst_height - $src_width / $src_height) > 0 ) { 
	$dst_w = $src_width * ( $dst_height / $src_height ); 
	$dst_x = ( $dst_width - $dst_w ) / 2; 
	} elseif ( ($dst_width / $dst_height - $src_width / $src_height) < 0 ) { 
	$dst_h = $src_height * ( $dst_width / $src_width ); 
	$dst_y = ( $dst_height - $dst_h ) / 2; 
	} 
	imagecopyresampled($dstimg, $srcimg, $dst_x 
	, $dst_y, 0, 0, $dst_w, $dst_h, $src_width, $src_height); 
	// 保存格式 
	$arr = array( 
	'jpg' => 'imagejpeg' 
	, 'jpeg' => 'imagejpeg' 
	, 'png' => 'imagepng' 
	, 'gif' => 'imagegif' 
	, 'bmp' => 'imagebmp' 
	); 
	$suffix = strtolower( array_pop(explode('.', $dstimage ) ) ); 
	if (!in_array($suffix, array_keys($arr)) ) { 
	echo "保存的文件名错误"; 
	exit; 
	} else { 
	eval( $arr[$suffix] . '($dstimg, "'.$dstimage.'");' ); 
	} 
	imagejpeg($dstimg, $dstimage); 
	imagedestroy($dstimg); 
	imagedestroy($srcimg); 
} 
function str2hex( $str ) { 
	$ret = ""; 
	for( $i = 0; $i < strlen( $str ) ; $i++ ) { 
	$ret .= ord($str[$i]) >= 16 ? strval( dechex( ord($str[$i]) ) ) 
	: '0'. strval( dechex( ord($str[$i]) ) ); 
	} 
	return strtoupper( $ret ); 
} 
function getcreatemethod( $file ) { 
	$arr = array( 
	'474946' => "imagecreatefromgif('$file')" 
	, 'FFD8FF' => "imagecreatefromjpeg('$file')" 
	, '424D' => "imagecreatefrombmp('$file')" 
	, '89504E' => "imagecreatefrompng('$file')" 
	); 
	$fd = fopen( $file, "rb" ); 
	$data = fread( $fd, 3 ); 
	$data = $this->str2hex( $data ); 
	if ( array_key_exists( $data, $arr ) ) { 
	return $arr[$data]; 
	} elseif ( array_key_exists( substr($data, 0, 4), $arr ) ) { 
	return $arr[substr($data, 0, 4)]; 
	} else { 
	return false; 
	} 
}
// BMP 创建函数 php本身无 
function imagecreatefrombmp($filename) 
{ 
	if (! $f1 = fopen($filename,"rb")) return FALSE; 
	$FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1,14)); 
	if ($FILE['file_type'] != 19778) return FALSE; 
	$BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel'. 
	'/Vcompression/Vsize_bitmap/Vhoriz_resolution'. 
	'/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1,40)); 
	$BMP['colors'] = pow(2,$BMP['bits_per_pixel']); 
	if ($BMP['size_bitmap'] == 0) $BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset']; 
	$BMP['bytes_per_pixel'] = $BMP['bits_per_pixel']/8; 
	$BMP['bytes_per_pixel2'] = ceil($BMP['bytes_per_pixel']); 
	$BMP['decal'] = ($BMP['width']*$BMP['bytes_per_pixel']/4); 
	$BMP['decal'] -= floor($BMP['width']*$BMP['bytes_per_pixel']/4); 
	$BMP['decal'] = 4-(4*$BMP['decal']); 
	if ($BMP['decal'] == 4) $BMP['decal'] = 0; 
	$PALETTE = array(); 
	if ($BMP['colors'] < 16777216) 
	{ 
	$PALETTE = unpack('V'.$BMP['colors'], fread($f1,$BMP['colors']*4)); 
	} 
	$IMG = fread($f1,$BMP['size_bitmap']); 
	$VIDE = chr(0); 
	$res = imagecreatetruecolor($BMP['width'],$BMP['height']); 
	$P = 0; 
	$Y = $BMP['height']-1; 
	while ($Y >= 0) 
	{ 
	$X=0; 
	while ($X < $BMP['width']) 
	{ 
	if ($BMP['bits_per_pixel'] == 24) 
	$COLOR = unpack("V",substr($IMG,$P,3).$VIDE); 
	elseif ($BMP['bits_per_pixel'] == 16) 
	{ 
	$COLOR = unpack("n",substr($IMG,$P,2)); 
	$COLOR[1] = $PALETTE[$COLOR[1]+1]; 
	} 
	elseif ($BMP['bits_per_pixel'] == 8) 
	{ 
	$COLOR = unpack("n",$VIDE.substr($IMG,$P,1)); 
	$COLOR[1] = $PALETTE[$COLOR[1]+1]; 
	} 
	elseif ($BMP['bits_per_pixel'] == 4) 
	{ 
	$COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1)); 
	if (($P*2)%2 == 0) $COLOR[1] = ($COLOR[1] >> 4) ; else $COLOR[1] = ($COLOR[1] & 0x0F); 
	$COLOR[1] = $PALETTE[$COLOR[1]+1]; 
	} 
	elseif ($BMP['bits_per_pixel'] == 1) 
	{ 
	$COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1)); 
	if (($P*8)%8 == 0) $COLOR[1] = $COLOR[1] >>7; 
	elseif (($P*8)%8 == 1) $COLOR[1] = ($COLOR[1] & 0x40)>>6; 
	elseif (($P*8)%8 == 2) $COLOR[1] = ($COLOR[1] & 0x20)>>5; 
	elseif (($P*8)%8 == 3) $COLOR[1] = ($COLOR[1] & 0x10)>>4; 
	elseif (($P*8)%8 == 4) $COLOR[1] = ($COLOR[1] & 0x8)>>3; 
	elseif (($P*8)%8 == 5) $COLOR[1] = ($COLOR[1] & 0x4)>>2; 
	elseif (($P*8)%8 == 6) $COLOR[1] = ($COLOR[1] & 0x2)>>1; 
	elseif (($P*8)%8 == 7) $COLOR[1] = ($COLOR[1] & 0x1); 
	$COLOR[1] = $PALETTE[$COLOR[1]+1]; 
	} 
	else 
	return FALSE; 
	imagesetpixel($res,$X,$Y,$COLOR[1]); 
	$X++; 
	$P += $BMP['bytes_per_pixel']; 
	} 
	$Y--; 
	$P+=$BMP['decal']; 
	} 
	fclose($f1); 
	return $res; 
} 
// BMP 保存函数，php本身无 
function imagebmp ($im, $fn = false) 
{ 
	if (!$im) return false; 
	if ($fn === false) $fn = 'php://output'; 
	$f = fopen ($fn, "w"); 
	if (!$f) return false; 
	$biWidth = imagesx ($im); 
	$biHeight = imagesy ($im); 
	$biBPLine = $biWidth * 3; 
	$biStride = ($biBPLine + 3) & ~3; 
	$biSizeImage = $biStride * $biHeight; 
	$bfOffBits = 54; 
	$bfSize = $bfOffBits + $biSizeImage; 
	fwrite ($f, 'BM', 2); 
	fwrite ($f, pack ('VvvV', $bfSize, 0, 0, $bfOffBits)); 
	fwrite ($f, pack ('VVVvvVVVVVV', 40, $biWidth, $biHeight, 1, 24, 0, $biSizeImage, 0, 0, 0, 0)); 
	$numpad = $biStride - $biBPLine; 
	for ($y = $biHeight - 1; $y >= 0; --$y) 
	{ 
	for ($x = 0; $x < $biWidth; ++$x) 
	{ 
	$col = imagecolorat ($im, $x, $y); 
	fwrite ($f, pack ('V', $col), 3); 
	} 
	for ($i = 0; $i < $numpad; ++$i) 
	fwrite ($f, pack ('C', 0)); 
	} 
	fclose ($f); 
	return true; 
}

function substr_CN($str,$mylen)
{                                                                                                                                        
	$len=strlen($str);
	$content='';
	$count=0;
	for($i=0;$i<$len;$i++)
	{
   		if(ord(substr($str,$i,1))>127)
   		{
    		$content.=substr($str,$i,2);
    		$i++;
   		}else{
   			$content.=substr($str,$i,1);
   		}
   		if(++$count==$mylen){
    	break;
   		}
	}
	echo $content;
}









}