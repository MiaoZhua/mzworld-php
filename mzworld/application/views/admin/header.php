<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<meta name="format-detection" content="telephone=no" /> 
<title>MZ星球</title>
<link rel="stylesheet" href="<?php echo base_url();?>themes/default/admin.css" />
<link rel="shortcut icon" href="<?php echo base_url()?>themes/default/images/favicon.ico" type="image/ico" />

<?php 
$get_str='';
if($_GET){
	$arr=array('c','m','test','parent','subcategory_ID','first_id','second_id','third_id','tongji_split','row','key','ID');
	for($i=0;$i<count($arr);$i++){
		if(isset($_GET[$arr[$i]])){
			if($get_str!=""){$get_str .='&';}else{$get_str .='?';}
			$get_str .=$arr[$i].'='.$_GET[$arr[$i]];
		}
	}
}
?>
<script type="text/javascript">
<!--
	var baseurl="<?php echo base_url()?>";
	var currenturl="<?php echo current_url().$get_str;?>";
//-->
</script>
<link rel="shortcut icon" href="<?php echo base_url()?>themes/default/images/bitbug_favicon.ico" type="image/ico" />
<script type='text/javascript' src='<?php echo base_url()?>js/jquery-1.7.2.min.js'></script>
<script type='text/javascript' src='<?php echo base_url()?>js/fileuploader.js'></script>
<script type='text/javascript' src='<?php echo base_url()?>js/admin.js'></script>
<script type='text/javascript' src='<?php echo base_url()?>ckeditor/ckeditor.js'></script>

</head>
<body>


<?php 
      $admin=$this->session->userdata('admin');
      $lang=$this->session->userdata('lang');
?>
<?php  
	$current_url_encode=str_replace('/','slash_tag',base64_encode(current_url().$get_str));
?>
<div class="header">
	<div class="header_logo">
		<div class="houtai_header_logo_div">
			<a href="<?php echo site_url('admins/home')?>">
				<img height="30" src="<?php echo base_url().'themes/default/images/logo.png'?>"/>
			</a>
		</div>
	</div>
	<div class="houtai_header_welcome_div" style="width:185px;">
		<span style="float:left;">欢迎, </span>
		<span class="header_adminimg">&nbsp;</span>
		<span style="float:left;margin-left:5px;">
			<?php echo $admin ['username']?>, <a href="<?php echo base_url ()?>index.php/admin/logout" style="color:#000"> 登出</a>
		</span>
	</div>
</div>

<?php $menu = $this->session->userdata('menu');?>
<div class="header_menu">
	<div id="spacing">&nbsp;</div>
	<div id="content">
		<div class="<?php if($menu=='home'){echo 'on';}else{echo 'off';}?>"><a href="<?php echo site_url('admins/home')?>"><?php echo lang('home')?></a></div>
		<div class="<?php if($menu=='cms'){echo 'on';}else{echo 'off';}?>"><a href="<?php echo site_url('admins/cms')?>"><?php echo lang('cms')?></a></div>
		<div class="<?php if($menu=='user'){echo 'on';}else{echo 'off';}?>"><a href="<?php echo base_url().'?c=adminuser&m=index'?>">管理用户</a></div>
		<div class="<?php if($menu=='challenge'){echo 'on';}else{echo 'off';}?>"><a href="<?php echo base_url().'?c=adminchallenge&m=index'?>">管理召集</a></div>
	</div>
</div>

<div class="error_tab">
	<div class="err_box_title">
		<span id="title"></span>
	</div>
	<div class="err_box_content"><span class="loading_indicator">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
	<div class="err_box_control">
		<table width="100%" cellspacing=0 cellpadding=0>
			<tr><td id="content"></td></tr>
		</table>
	</div>
</div>

<div class="success_tab">
	<div class="suc_box_title">
		<span id="title"></span>
	</div>
	<div class="suc_box_content"><span class="loading_indicator">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
	<div class="suc_box_control">
		<table width="100%" cellspacing=0 cellpadding=0>
			<tr><td id="content"></td></tr>
		</table>
	</div>
</div>

<div class="Frame_Body">
	<div class="mainbody">
	<?php if (isset($url)){?>
		<div class="navigation">
			<?php echo $url?>
	    </div>
    <?php }?>
	<div class="notice_taball"></div>
	<div id="notice_tab" class="notice_tab"></div>
	<div id="message_tab" class="message_tab">
		<table cellspacing=0 cellpadding=0 width="100%" style="float:left;width:100%;height:100%;">
			<tr>
				<td>
					<div style="float:left;width:100%;background-color:gray;border:1px solid #4b5344;">
						<div class="box_title">
							<span id="title"></span>
							<span id="close"><a href="javascript:;" onclick="close_msg()">X</a></span>
						</div>
						<div class="box_content"><span class="loading_indicator">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
						<div class="box_control">
							<table width="100%" cellspacing=0 cellpadding=0>
								<tr><td id="content"></td></tr>
							</table>
						</div>
					</div>
				</td>
			</tr>
		</table>
	</div>
