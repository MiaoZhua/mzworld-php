<?php $this->load->view('admin/header')?>
<?php 
	$langarr=languagelist();//多语言
	for($la=0;$la<count($langarr);$la++){//多语言
		${'name'.$langarr[$la]['langtype']}='';
	}
	${'name_width'}='';
	${'name_required'}='';
	for($tt=1;$tt<=5;$tt++){
		for($la=0;$la<count($langarr);$la++){//多语言
			${'nolaninput_'.$tt.$langarr[$la]['langtype']}='';
		}
		${'nolaninput_'.$tt.'_width'}='';
		${'nolaninput_'.$tt.'_required'}=0;
		${'nolaninput_'.$tt.'_format'}='';
		
		for($la=0;$la<count($langarr);$la++){//多语言
			${'laninput_'.$tt.$langarr[$la]['langtype']}='';
		}
		${'laninput_'.$tt.'_width'}='';
		${'laninput_'.$tt.'_required'}=0;
		
		for($la=0;$la<count($langarr);$la++){//多语言
			${'nolantextarea_'.$tt.$langarr[$la]['langtype']}='';
		}
		${'nolantextarea_'.$tt.'_showtype'}=1;//1：文本框 2：编辑器
		${'nolantextarea_'.$tt.'_width'}='';
		${'nolantextarea_'.$tt.'_height'}='';
		${'nolantextarea_'.$tt.'_required'}='';
		
		for($la=0;$la<count($langarr);$la++){//多语言
			${'lantextarea_'.$tt.$langarr[$la]['langtype']}='';
		}
		${'lantextarea_'.$tt.'_showtype'}=1;//1：文本框 2：编辑器
		${'lantextarea_'.$tt.'_width'}='';
		${'lantextarea_'.$tt.'_height'}='';
		${'lantextarea_'.$tt.'_required'}='';
		
		for($la=0;$la<count($langarr);$la++){//多语言
			${'pic_'.$tt.$langarr[$la]['langtype']}='';
		}
		${'pic_'.$tt.'_showtype'}=1;
		${'pic_'.$tt.'_width'}='';
		${'pic_'.$tt.'_height'}='';
		${'pic_'.$tt.'_required'}='';
	}
	$con=array('name','created');
	for($tt=1;$tt<=5;$tt++){
		$con[]='pic_'.$tt;
		$con[]='nolaninput_'.$tt;
		$con[]='laninput_'.$tt;
		$con[]='nolantextarea_'.$tt;
		$con[]='lantextarea_'.$tt;
	}
	$parameter=$category_info['parameter_post'];
	$parameter=explode('-',$parameter);
	if(!empty($parameter)){
		for($j=0;$j<count($con);$j++){
			${'is_'.$con[$j]}=0;
		}
		for($a=0;$a<count($parameter);$a++){
			for($b=0;$b<count($con);$b++){
				if($parameter[$a]==$con[$b]){
					${'is_'.$con[$b]}=1;
					//关于图片
					for($tt=1;$tt<=5;$tt++){
						if($con[$b]=='pic_'.$tt){
							${'pic_'.$tt.'_showtype_res'}=$parameter[$a+1];
							${'pic_'.$tt.'_showtype_res'}=explode('_',${'pic_'.$tt.'_showtype_res'});
							${'pic_'.$tt.'_showtype'}=${'pic_'.$tt.'_showtype_res'}[3];
							
							${'pic_'.$tt.'_width_res'}=$parameter[$a+2];
							${'pic_'.$tt.'_width_res'}=explode('_',${'pic_'.$tt.'_width_res'});
							${'pic_'.$tt.'_width'}=${'pic_'.$tt.'_width_res'}[3];
							
							${'pic_'.$tt.'_height_res'}=$parameter[$a+3];
							${'pic_'.$tt.'_height_res'}=explode('_',${'pic_'.$tt.'_height_res'});
							${'pic_'.$tt.'_height'}=${'pic_'.$tt.'_height_res'}[3];
							
							${'pic_'.$tt.'_required_res'}=$parameter[$a+4];
							${'pic_'.$tt.'_required_res'}=explode('_',${'pic_'.$tt.'_required_res'});
							${'pic_'.$tt.'_required'}=${'pic_'.$tt.'_required_res'}[3];
							
							for($la=0;$la<count($langarr);$la++){//多语言
								${'pic_'.$tt.$langarr[$la]['langtype'].'_res'}=$parameter[$a+($la+5)];
								${'pic_'.$tt.$langarr[$la]['langtype'].'_res'}=explode('_',${'pic_'.$tt.$langarr[$la]['langtype'].'_res'});
								${'pic_'.$tt.$langarr[$la]['langtype']}=${'pic_'.$tt.$langarr[$la]['langtype'].'_res'}[3];
							}
						}
					}
					//名称
					if($con[$b]=='name'){
						//name-name_en_英文标题-name_ch_中文标题-name_width_500-name_required_500
						${'name_width_res'}=$parameter[$a+1];
						${'name_width_res'}=explode('_',${'name_width_res'});
						${'name_width'}=${'name_width_res'}[2];
						
						${'name_required_res'}=$parameter[$a+2];
						${'name_required_res'}=explode('_',${'name_required_res'});
						${'name_required'}=${'name_required_res'}[2];
						
						for($la=0;$la<count($langarr);$la++){//多语言
							${'name'.$langarr[$la]['langtype'].'_res'}=$parameter[$a+($la+3)];
							${'name'.$langarr[$la]['langtype'].'_res'}=explode('_',${'name'.$langarr[$la]['langtype'].'_res'});
							${'name'.$langarr[$la]['langtype']}=${'name'.$langarr[$la]['langtype'].'_res'}[2];
						}
					}
					//没有多语言的 其他input
					for($tt=1;$tt<=5;$tt++){
						if($con[$b]=='nolaninput_'.$tt){
							${'nolaninput_'.$tt.'_width_res'}=$parameter[$a+1];
							${'nolaninput_'.$tt.'_width_res'}=explode('_',${'nolaninput_'.$tt.'_width_res'});
							${'nolaninput_'.$tt.'_width'}=${'nolaninput_'.$tt.'_width_res'}[3];
							
							${'nolaninput_'.$tt.'_required_res'}=$parameter[$a+2];
							${'nolaninput_'.$tt.'_required_res'}=explode('_',${'nolaninput_'.$tt.'_required_res'});
							${'nolaninput_'.$tt.'_required'}=${'nolaninput_'.$tt.'_required_res'}[3];
							
							${'nolaninput_'.$tt.'_format_res'}=$parameter[$a+3];
							${'nolaninput_'.$tt.'_format_res'}=explode('_',${'nolaninput_'.$tt.'_format_res'});
							${'nolaninput_'.$tt.'_format'}=${'nolaninput_'.$tt.'_format_res'}[3];
							
							for($la=0;$la<count($langarr);$la++){//多语言
								${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'}=$parameter[$a+($la+4)];
								${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'}=explode('_',${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'});
								${'nolaninput_'.$tt.$langarr[$la]['langtype']}=${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'}[3];
							}
						}
					}
					//有多语言的 Input
					for($tt=1;$tt<=5;$tt++){
						if($con[$b]=='laninput_'.$tt){
							${'laninput_'.$tt.'_width_res'}=$parameter[$a+1];
							${'laninput_'.$tt.'_width_res'}=explode('_',${'laninput_'.$tt.'_width_res'});
							${'laninput_'.$tt.'_width'}=${'laninput_'.$tt.'_width_res'}[3];
							
							${'laninput_'.$tt.'_required_res'}=$parameter[$a+2];
							${'laninput_'.$tt.'_required_res'}=explode('_',${'laninput_'.$tt.'_required_res'});
							${'laninput_'.$tt.'_required'}=${'laninput_'.$tt.'_required_res'}[3];
							
							for($la=0;$la<count($langarr);$la++){//多语言
								${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'}=$parameter[$a+($la+3)];
								${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'}=explode('_',${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'});
								${'laninput_'.$tt.$langarr[$la]['langtype']}=${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'}[3];
							}
						}
					}
					//没有多语言的 Textarea
					for($tt=1;$tt<=5;$tt++){
						if($con[$b]=='nolantextarea_'.$tt){
							${'nolantextarea_'.$tt.'_showtype_res'}=$parameter[$a+1];
							${'nolantextarea_'.$tt.'_showtype_res'}=explode('_',${'nolantextarea_'.$tt.'_showtype_res'});
							${'nolantextarea_'.$tt.'_showtype'}=${'nolantextarea_'.$tt.'_showtype_res'}[3];
							
							${'nolantextarea_'.$tt.'_width_res'}=$parameter[$a+2];
							${'nolantextarea_'.$tt.'_width_res'}=explode('_',${'nolantextarea_'.$tt.'_width_res'});
							${'nolantextarea_'.$tt.'_width'}=${'nolantextarea_'.$tt.'_width_res'}[3];
							
							${'nolantextarea_'.$tt.'_height_res'}=$parameter[$a+3];
							${'nolantextarea_'.$tt.'_height_res'}=explode('_',${'nolantextarea_'.$tt.'_height_res'});
							${'nolantextarea_'.$tt.'_height'}=${'nolantextarea_'.$tt.'_height_res'}[3];
							
							${'nolantextarea_'.$tt.'_required_res'}=$parameter[$a+4];
							${'nolantextarea_'.$tt.'_required_res'}=explode('_',${'nolantextarea_'.$tt.'_required_res'});
							${'nolantextarea_'.$tt.'_required'}=${'nolantextarea_'.$tt.'_required_res'}[3];
							
							for($la=0;$la<count($langarr);$la++){//多语言
								${'nolantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}=$parameter[$a+($la+5)];
								${'nolantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}=explode('_',${'nolantextarea_'.$tt.$langarr[$la]['langtype'].'_res'});
								${'nolantextarea_'.$tt.$langarr[$la]['langtype']}=${'nolantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}[3];
							}
						}
					}
					//有多语言的 Textarea
					for($tt=1;$tt<=5;$tt++){
						if($con[$b]=='lantextarea_'.$tt){
							${'lantextarea_'.$tt.'_showtype_res'}=$parameter[$a+1];
							${'lantextarea_'.$tt.'_showtype_res'}=explode('_',${'lantextarea_'.$tt.'_showtype_res'});
							${'lantextarea_'.$tt.'_showtype'}=${'lantextarea_'.$tt.'_showtype_res'}[3];
							
							${'lantextarea_'.$tt.'_width_res'}=$parameter[$a+2];
							${'lantextarea_'.$tt.'_width_res'}=explode('_',${'lantextarea_'.$tt.'_width_res'});
							${'lantextarea_'.$tt.'_width'}=${'lantextarea_'.$tt.'_width_res'}[3];
							
							${'lantextarea_'.$tt.'_height_res'}=$parameter[$a+3];
							${'lantextarea_'.$tt.'_height_res'}=explode('_',${'lantextarea_'.$tt.'_height_res'});
							${'lantextarea_'.$tt.'_height'}=${'lantextarea_'.$tt.'_height_res'}[3];
							
							${'lantextarea_'.$tt.'_required_res'}=$parameter[$a+4];
							${'lantextarea_'.$tt.'_required_res'}=explode('_',${'lantextarea_'.$tt.'_required_res'});
							${'lantextarea_'.$tt.'_required'}=${'lantextarea_'.$tt.'_required_res'}[3];
							
							for($la=0;$la<count($langarr);$la++){//多语言
								${'lantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}=$parameter[$a+($la+5)];
								${'lantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}=explode('_',${'lantextarea_'.$tt.$langarr[$la]['langtype'].'_res'});
								${'lantextarea_'.$tt.$langarr[$la]['langtype']}=${'lantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}[3];
							}
						}
					}
				}
			}
		}
	}
?>
<form action="<?php echo site_url('admins/'.$this->controller.'/add_subcategory')?>" method="post">
<table cellspacing=1 cellpadding=0 width="98%" style="margin-left:1%;color:black;">
	<tr>
		<td>
			<table width="100%">
			<?php 
			for($tt=1;$tt<=5;$tt++){
				//是否包括图片
				if(${'is_pic_'.$tt}==1){?>
					<tr>
						<td width="120" height="31" align="right"><?php echo ${'pic_'.$tt.$this->langtype};?>&nbsp;&nbsp;</td>
						<td>
							<div class="img_gksel_show" id="img<?php echo $tt;?>_gksel_show" style="width:auto;">
								<?php 
									if(set_value('img'.$tt.'_gksel')!=null){
										$pic_path=set_value('img'.$tt.'_gksel');
										echo '<img style="float:left;max-width:700px;max-height:700px;" src="'.base_url().set_value('img'.$tt.'_gksel').'"/>';
									}else{
										$pic_path='';
										if($pic_path!=''&&file_exists($pic_path)){
											echo '<img style="float:left;max-width:700px;max-height:700px;" src="'.base_url().$pic_path.'"/>';
										}else{
											$pic_path='';
										}
									}
								?>
							</div>
							<?php if(${'pic_'.$tt.'_showtype'}==1){//图片上传方法 1：固定尺寸 100*100;?>
								<div style="float:left;margin:10px 0px 0px 20px;padding:10px 10px 10px 10px;background:#EFEFEF;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
									<b>温馨提示：</b><br />
									图片尺寸为 <span style="color:#0086cf;font-weigth:bold;font-size:16px;"><?php echo ${'pic_'.$tt.'_width'}.' x '.${'pic_'.$tt.'_height'}.'px' ?></span><br />
									图片支持（jpg, png, gif）格式
								</div>
							<?php }else if(${'pic_'.$tt.'_showtype'}==2){//图片上传方法2：最大尺寸 1000*1000;?>
								<div style="float:left;margin:10px 0px 0px 20px;padding:10px 10px 10px 10px;background:#EFEFEF;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
									<b>温馨提示：</b><br />
									图片最大显示尺寸为 <span style="color:#0086cf;font-weigth:bold;font-size:16px;"><?php echo ${'pic_'.$tt.'_width'}.' x '.${'pic_'.$tt.'_height'}.'px' ?></span><br />
									图片支持（jpg, png, gif）格式
								</div>
							<?php }?>
							<div style="float:left;width:100%;margin:10px 0px 0px 0px;">
								<?php echo '<input type="hidden" id="img'.$tt.'_gksel" name="img'.$tt.'_gksel" value="'.$pic_path.'"/>';?>
								<div class="img_gksel_choose" id="img<?php echo $tt;?>_gksel_choose">选择图片</div>
								<div id="img<?php echo $tt;?>_gksel_error" style="float:left;"></div>
							</div>
						</td>
					</tr>
					<tr>
					   	<td colspan="2">
					    	<div style="float:left;width:100%;margin:5px 0px 5px 0px;border-top:1px solid #999999;line-height:1px;">&nbsp;</div>
					    </td>
					</tr>
				<?php }?>
			<?php }?>
			<?php if(${'is_name'}==1){?>
				<?php 
					for($la=0;$la<count($langarr);$la++){//多语言
						echo '
						<tr>
							<td width="120" align="right">'.${'name'.$langarr[$la]['langtype']}.'&nbsp;&nbsp;</td>
							<td align="left">
								<div style="float:left;"><input type="text" style="width:500px;" name="category_name'.$langarr[$la]['langtype'].'" value="" /></div>
						    </td>
						</tr>
						';
					}
				?>
				<tr>
				    <td colspan="2">
				    	<div style="float:left;width:100%;margin:5px 0px 5px 0px;border-top:1px solid #999999;line-height:1px;">&nbsp;</div>
				    </td>
				</tr>
			<?php }?>
			<?php 
			//没有多语言的Input
			for($tt=1;$tt<=5;$tt++){if(${'is_nolaninput_'.$tt}==1){?>
				<tr>
					<td width="120" align="right"><?php echo ${'nolaninput_'.$tt.$this->langtype}?>&nbsp;&nbsp;</td>
				    <td align="left">
				    	<div style="float:left;"><input type="text" style="width:500px;" name="nolaninput_<?php echo $tt;?>" value="" /></div>
				    </td>
				</tr>
				<tr>
				    <td colspan="2">
				    	<div style="float:left;width:100%;margin:5px 0px 5px 0px;border-top:1px solid #999999;line-height:1px;">&nbsp;</div>
				    </td>
				</tr>
			<?php }}?>
			<?php 
			//有多语言的Input
			for($tt=1;$tt<=5;$tt++){if(${'is_laninput_'.$tt}==1){?>
					<?php 
						for($la=0;$la<count($langarr);$la++){//多语言
							echo '
							<tr>
								<td width="120" align="right">'.${'laninput_'.$tt.$langarr[$la]['langtype']}.'&nbsp;&nbsp;</td>
							    <td align="left">
							    	<div style="float:left;"><input type="text" style="width:500px;" name="laninput_'.$tt.$langarr[$la]['langtype'].'" value=""/></div>
							    </td>
							</tr>
							';
						}
					?>
					<tr>
					    <td colspan="2">
					    	<div style="float:left;width:100%;margin:5px 0px 5px 0px;border-top:1px solid #999999;line-height:1px;">&nbsp;</div>
					    </td>
					</tr>
			<?php }}?>
			<?php 
			//没有多语言的Textarea
			for($tt=1;$tt<=5;$tt++){if(${'is_nolantextarea_'.$tt}==1){?>
					<tr>
						<td width="120" align="right"><?php echo ${'nolantextarea_'.$tt.$this->langtype}?>&nbsp;&nbsp;</td>
					    <td align="left">
					    	<?php if(${'nolantextarea_'.$tt.'_showtype'}==1){//文本框?>
						    	<div style="float:left;">
						    		<textarea style="float:left;width:<?php echo ${'nolantextarea_'.$tt.'_width'}?>px;height:<?php echo ${'nolantextarea_'.$tt.'_height'}?>px;" id="<?php echo 'nolantextarea_'.$tt?>" name="<?php echo 'nolantextarea_'.$tt?>"></textarea>
						    	</div>
					    	<?php }else if(${'nolantextarea_'.$tt.'_showtype'}==2){//编辑器?>
					    		<div style="float:left;">
						    		<textarea id="<?php echo 'nolantextarea_'.$tt?>" name="<?php echo 'nolantextarea_'.$tt?>"></textarea>
						    	</div>
						    	<script type="text/javascript">
									if(CKEDITOR.instances["<?php echo 'nolantextarea_'.$tt?>"]){
										//判断是否绑定
										CKEDITOR.remove(CKEDITOR.instances["<?php echo 'nolantextarea_'.$tt?>"]); //解除绑定
									}
									CKEDITOR.replace( '<?php echo 'nolantextarea_'.$tt?>');
								</script>
					    	<?php }?>
					    </td>
					</tr>
					<tr>
					    <td colspan="2">
					    	<div style="float:left;width:100%;margin:5px 0px 5px 0px;border-top:1px solid #999999;line-height:1px;">&nbsp;</div>
					    </td>
					</tr>
			<?php }}?>
			<?php 
			//有多语言的Textarea
			for($tt=1;$tt<=5;$tt++){if(${'is_lantextarea_'.$tt}==1){?>
					<?php 
						for($la=0;$la<count($langarr);$la++){//多语言
							echo '
							<tr>
								<td width="120" align="right">'.${'lantextarea_'.$tt.$langarr[$la]['langtype']}.'&nbsp;&nbsp;</td>
							    <td align="left">
							    	<div style="float:left;"><textarea class="ckeditor" id="lantextarea_'.$tt.$langarr[$la]['langtype'].'" name="lantextarea_'.$tt.$langarr[$la]['langtype'].'"></textarea></div>
							    </td>
							</tr>
							';
						}
					?>
					<tr>
					    <td colspan="2">
					    	<div style="float:left;width:100%;margin:5px 0px 5px 0px;border-top:1px solid #999999;line-height:1px;">&nbsp;</div>
					    </td>
					</tr>
			<?php }}?>
			    <tr>
				    <td width="120" align="right"></td>
				    <td align="left">
				    	<input name="backurl" type="hidden" value="<?php echo $backurl;?>" />
				   		<input type="submit" value="Save" style="float:left;background:#018E01;border:0px;color:white;padding:4px 15px 4px 15px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;"/>
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