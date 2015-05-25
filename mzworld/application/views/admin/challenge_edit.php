<?php $this->load->view('admin/header')?>
<form action="<?php echo site_url('admins/'.$this->controller.'/edit_challenge')?>" method="post">
<table cellspacing=1 cellpadding=0 width="98%" style="margin-left:1%;color:black;">
	<tr>
		<td>
			<table width="100%">
				<tr>
					<td width="120" align="right">名称&nbsp;&nbsp;</td>
					<td align="left">
						<div style="float:left;"><input type="text" style="width:500px;" name="challenge_name" value="<?php echo $challengeinfo['challenge_name'];?>" /></div>
				    </td>
				</tr>
				<tr>
				    <td colspan="2">
				    	<div style="float:left;width:100%;margin:5px 0px 5px 0px;border-top:1px solid #999999;line-height:1px;">&nbsp;</div>
				    </td>
				</tr>
			
			
			
			
			    <tr>
				    <td width="120" align="right"></td>
				    <td align="left">
				    	<input name="backurl" type="hidden" value="<?php echo $backurl;?>" />
				    	<input name="challenge_id" type="hidden" value="<?php echo $challengeinfo['challenge_id'];?>" />
				    	<input name="key" type="hidden" value="<?php echo $challengeinfo['key'];?>" />
				   		<input type="submit" value="保存" style="float:left;background:#018E01;border:0px;color:white;padding:4px 15px 4px 15px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;"/>
				    </td>
			    </tr>
			</table>
		</td>
	</tr>
</table>
</form>
<script type="text/javascript">
<!--
$(document).ready(function(){
	var button_gksel1 = $('#img1_gksel_choose'), interval;
	if(button_gksel1.length>0){
		new AjaxUpload(button_gksel1,{
			<?php if(${'pic_1_showtype'}==1){//图片上传方法 1：固定尺寸 100*100;?>
				action: baseurl+'index.php/welcome/uplogo/<?php echo $pic_1_width;?>/<?php echo $pic_1_height;?>', 
			<?php }else if(${'pic_1_showtype'}==2){//图片上传方法2：最大尺寸 1000*1000;?>
				action: baseurl+'index.php/welcome/uplogo_deng/<?php echo $pic_1_width;?>/<?php echo $pic_1_height;?>', 
			<?php }?>
			name: 'logo',onSubmit : function(file, ext){
				if (ext && /^(jpg|png|jpeg|gif)$/.test(ext)){
					button_gksel1.text('上传中');
					this.disable();
					interval = window.setInterval(function(){
						var text = button_gksel1.text();
						if (text.length < 13){
							button_gksel1.text(text + '.');					
						} else {
							button_gksel1.text('上传中');				
						}
					}, 200);

				} else {
					$('#img1_gksel_error').html('上传失败');
					return false;
				}
			},
			onComplete: function(file, response){
				button_gksel1.text('选择图片');						
				window.clearInterval(interval);
				this.enable();
				if(response=='false'){
					$('#img1_gksel_error').html('上传失败');
				}else{
					var pic = eval("("+response+")");
					$('#img1_gksel_show').html('<img id="thumbnail" style="float:left;" src="'+baseurl+pic.logo+'" />');
					$('#img1_gksel').attr('value',pic.logo);
					$('#img1_gksel_error').html('');
				}	
			}
		});
	}
	var button_gksel2 = $('#img2_gksel_choose'), interval;
	if(button_gksel2.length>0){
		new AjaxUpload(button_gksel2,{
			<?php if(${'pic_2_showtype'}==1){//图片上传方法 1：固定尺寸 100*100;?>
				action: baseurl+'index.php/welcome/uplogo/<?php echo $pic_2_width;?>/<?php echo $pic_2_height;?>', 
			<?php }else if(${'pic_2_showtype'}==2){//图片上传方法2：最大尺寸 1000*1000;?>
				action: baseurl+'index.php/welcome/uplogo_deng/<?php echo $pic_2_width;?>/<?php echo $pic_2_height;?>', 
			<?php }?>
			name: 'logo',onSubmit : function(file, ext){
				if (ext && /^(jpg|png|jpeg|gif)$/.test(ext)){
					button_gksel2.text('上传中');
					this.disable();
					interval = window.setInterval(function(){
						var text = button_gksel2.text();
						if (text.length < 13){
							button_gksel2.text(text + '.');					
						} else {
							button_gksel2.text('上传中');				
						}
					}, 200);

				} else {
					$('#img2_gksel_error').html('上传失败');
					return false;
				}
			},
			onComplete: function(file, response){
				button_gksel2.text('选择图片');						
				window.clearInterval(interval);
				this.enable();
				if(response=='false'){
					$('#img2_gksel_error').html('上传失败');
				}else{
					var pic = eval("("+response+")");
					$('#img2_gksel_show').html('<img id="thumbnail" style="float:left;" src="'+baseurl+pic.logo+'" />');
					$('#img2_gksel').attr('value',pic.logo);
					$('#img2_gksel_error').html('');
				}	
			}
		});
	}
	var button_gksel3 = $('#img3_gksel_choose'), interval;
	if(button_gksel3.length>0){
		new AjaxUpload(button_gksel3,{
			<?php if(${'pic_3_showtype'}==1){//图片上传方法 1：固定尺寸 100*100;?>
				action: baseurl+'index.php/welcome/uplogo/<?php echo $pic_3_width;?>/<?php echo $pic_3_height;?>', 
			<?php }else if(${'pic_3_showtype'}==2){//图片上传方法2：最大尺寸 1000*1000;?>
				action: baseurl+'index.php/welcome/uplogo_deng/<?php echo $pic_3_width;?>/<?php echo $pic_3_height;?>', 
			<?php }?>
			name: 'logo',onSubmit : function(file, ext){
				if (ext && /^(jpg|png|jpeg|gif)$/.test(ext)){
					button_gksel3.text('上传中');
					this.disable();
					interval = window.setInterval(function(){
						var text = button_gksel3.text();
						if (text.length < 13){
							button_gksel3.text(text + '.');					
						} else {
							button_gksel3.text('上传中');				
						}
					}, 200);

				} else {
					$('#img3_gksel_error').html('上传失败');
					return false;
				}
			},
			onComplete: function(file, response){
				button_gksel3.text('选择图片');						
				window.clearInterval(interval);
				this.enable();
				if(response=='false'){
					$('#img3_gksel_error').html('上传失败');
				}else{
					var pic = eval("("+response+")");
					$('#img3_gksel_show').html('<img id="thumbnail" style="float:left;" src="'+baseurl+pic.logo+'" />');
					$('#img3_gksel').attr('value',pic.logo);
					$('#img3_gksel_error').html('');
				}	
			}
		});
	}
})
//-->
</script>
<?php $this->load->view('admin/footer')?>