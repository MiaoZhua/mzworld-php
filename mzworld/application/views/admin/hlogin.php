<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="<?php echo base_url()?>themes/default/images/favicon.ico" type="image/ico" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<meta name="format-detection" content="telephone=no" /> 
<link rel="stylesheet" href="<?php echo base_url();?>themes/default/admin.css" />
<title>MZ星球</title>
<script type="text/javascript">
<!--
function getauthimg(authur) {
	document.getElementById('authimg').src = authur+"?"+Math.random(1);
	document.getElementById('authimg1').src = document.getElementById('authimg').src;
}
//-->
</script>
</head>
<body>
<div class="main" style="-webkit-box-reflect: below 0px -webkit-gradient(linear, left top, left bottom, from(transparent), color-stop(80%, transparent), to(rgba(255, 255, 255, 0.5)));">
	<table width="100%" cellpadding="0" cellspacing="0" border=0 style="margin-top:20%; ">
		<tr>
			<td width="50%" valign="middle" align="right">
				<div style="float:right;margin-right:70px;">
					<a href="<?php echo site_url('admin/index')?>">
						<img height="30" src="<?php echo base_url().'themes/default/images/logo.png'?>"/>
					</a>
				</div>	
				<div style="float:left;width:100%;">
					<div style="float:right;margin:5px 160px 0px 0px;">
						
					</div>
				</div>
			</td>
			<td width="50%" valign="middle" align="left" style="background:#000000;">
				<ul class="loginmain_right" >
					<li class="login_line">
						<form name="loginform" action="<?php echo base_url().'?c=admin&m=tologin'?>" method="post">
							<table cellpadding="0" cellspacing="0" border=0 style="color:white; font-weight:bolder; margin-left:20px;">
								<tr>
									<td height="35" align="right">Username&nbsp;&nbsp;</td>
									<td><input class="houtai_login_input" name="aname" type="text" value="<?php echo set_value('aname')?>"/></td>
									<td>
										<p class="logmsg" align="left">&nbsp;&nbsp;&nbsp;<?php if(isset($aname_error)) echo $aname_error;?></p>
									</td>
								</tr>
								<tr>
									<td height="35" align="right"><?php echo lang('password');?>&nbsp;&nbsp;</td>
									<td><input class="houtai_login_input" name="apass" type="password"/></td>
									<td>
										<p class="logmsg" align="left">&nbsp;&nbsp;&nbsp;<?php if(isset($apass_error)) echo $apass_error;?></p>
									</td>
								</tr>
								<tr>
									<td height="35"><?php echo lang('verificationcode')?>&nbsp;&nbsp;</td>
									<td>
										<div class="houtai_login_code_div">
											<?php $authurl = base_url()."authimg.php"; ?>
											<img class="houtai_login_code_img" src="<?php echo $authurl ?>" onclick="this.src=this.src+'?'+Math.random();" />
										</div>
										&nbsp;
										<input type="text" name="code" id="code" value="" size="4"/>
									</td>
								</tr>
								<tr>
									<td></td>
									<td align="left">
										<input style="float:left;border:0;width:60px;height:30px;color:white;font-weight:bold;background:url('<?php echo base_url()?>themes/default/images/logo_anniu.png')"  type="submit" value=<?php echo lang('login')?> "  />
									</td>
									<td>
										<div class="logmsg" align="left">
											&nbsp;&nbsp;&nbsp;<?php if(isset($error)) echo $error;?>
										</div>
									</td>
								</tr>
							</table>
						</form>	
					</li>
				</ul>
			</td>
		</tr>
	</table>
</div>

</body>
</html>