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
		$con[]='selection_'.$tt;
		$con[]='checkboxion_'.$tt;
	}
	if($articleinfo['parameter_ben']!=""){
		$parameter=$articleinfo['parameter_ben'];
	}else{
		$parameter=$firstinfo['parameter_post'];
	}
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
<form action="<?php echo site_url('admins/'.$this->controller.'/edit_subarticle')?>" method="post">
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
										$pic_path=$articleinfo['pic_'.$tt];
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
								<div style="float:left;"><input type="text" style="width:500px;" name="article_name'.$langarr[$la]['langtype'].'" value="'.$articleinfo['article_name'.$langarr[$la]['langtype']].'" /></div>
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
			<?php if($is_selection_1==1){?>
				<tr>
					<td width="120" align="right">Category&nbsp;&nbsp;</td>
				    <td align="left">
				    	<?php 
					    	$postsubcategory_info=$this->ArticleModel->getarticle_categoryinfo(59);
					    	$con=array('category_id'=>59,'subcategory_id'=>60);
							//排序--开始
								$actionorderby=doactionorderby($postsubcategory_info['parameter_list']);
								if($actionorderby['orderby']=='move'){
									$con['orderby']='sort';
									$con['orderby_res']=$actionorderby['orderby_res'];
								}else{
									$con['orderby']='article_id';
									$con['orderby_res']='DESC';
								}
							//排序--结束
							$selection_1list=$this->ArticleModel->getarticlelist($con);
				    	?>
				    	<select name="selection_1">
				    		<?php if(isset($selection_1list)){for($i=0;$i<count($selection_1list);$i++){?>
				    			<option value="<?php echo $selection_1list[$i]['article_id'];?>" <?php if($articleinfo['selection_1']==$selection_1list[$i]['article_id']){echo 'selected';}?>><?php echo $selection_1list[$i]['article_name'.$this->langtype]?></option>
				    		<?php }}?>
				    	</select>
				    </td>
				</tr>
				<tr>
				    <td colspan="2">
				    	<div style="float:left;width:100%;margin:5px 0px 5px 0px;border-top:1px solid #999999;line-height:1px;">&nbsp;</div>
				    </td>
				</tr>
			<?php }?>
			<?php if($is_selection_2==1){?>
				<tr>
					<td width="120" align="right">City&nbsp;&nbsp;</td>
				    <td align="left">
				    	<?php 
					    	$postsubcategory_info=$this->ArticleModel->getarticle_categoryinfo(59);
					    	$con=array('category_id'=>59,'subcategory_id'=>61);
							//排序--开始
								$actionorderby=doactionorderby($postsubcategory_info['parameter_list']);
								if($actionorderby['orderby']=='move'){
									$con['orderby']='sort';
									$con['orderby_res']=$actionorderby['orderby_res'];
								}else{
									$con['orderby']='article_id';
									$con['orderby_res']='DESC';
								}
							//排序--结束
							$selection_2list=$this->ArticleModel->getarticlelist($con);
				    	?>
				    	<select name="selection_2">
				    		<?php if(isset($selection_2list)){for($i=0;$i<count($selection_2list);$i++){?>
				    			<option value="<?php echo $selection_2list[$i]['article_id'];?>" <?php if($articleinfo['selection_2']==$selection_2list[$i]['article_id']){echo 'selected';}?>><?php echo $selection_2list[$i]['article_name'.$this->langtype]?></option>
				    		<?php }}?>
				    	</select>
				    </td>
				</tr>
				<tr>
				    <td colspan="2">
				    	<div style="float:left;width:100%;margin:5px 0px 5px 0px;border-top:1px solid #999999;line-height:1px;">&nbsp;</div>
				    </td>
				</tr>
			<?php }?>
			<?php if($is_selection_3==1){?>
				<tr>
					<td width="120" align="right">第三选择&nbsp;&nbsp;</td>
				    <td align="left">
				    	<?php 
					    	$postsubcategory_info=$this->ArticleModel->getarticle_categoryinfo(59);
					    	$con=array('category_id'=>59,'subcategory_id'=>62);
							//排序--开始
								$actionorderby=doactionorderby($postsubcategory_info['parameter_list']);
								if($actionorderby['orderby']=='move'){
									$con['orderby']='sort';
									$con['orderby_res']=$actionorderby['orderby_res'];
								}else{
									$con['orderby']='article_id';
									$con['orderby_res']='DESC';
								}
							//排序--结束
							$selection_3list=$this->ArticleModel->getarticlelist($con);
				    	?>
				    	<select name="selection_3">
				    		<?php if(isset($selection_3list)){for($i=0;$i<count($selection_3list);$i++){?>
				    			<option value="<?php echo $selection_3list[$i]['article_id'];?>" <?php if($articleinfo['selection_3']==$selection_3list[$i]['article_id']){echo 'selected';}?>><?php echo $selection_3list[$i]['article_name'.$this->langtype]?></option>
				    		<?php }}?>
				    	</select>
				    </td>
				</tr>
				<tr>
				    <td colspan="2">
				    	<div style="float:left;width:100%;margin:5px 0px 5px 0px;border-top:1px solid #999999;line-height:1px;">&nbsp;</div>
				    </td>
				</tr>
			<?php }?>
			<?php if($is_checkboxion_1==1){?>
				<tr>
					<td width="120" align="right">颜色&nbsp;&nbsp;</td>
				    <td align="left">
				    	<?php 
					    	$postsubcategory_info=$this->ArticleModel->getarticle_categoryinfo(59);
					    	$con=array('category_id'=>59,'subcategory_id'=>65);
							//排序--开始
								$actionorderby=doactionorderby($postsubcategory_info['parameter_list']);
								if($actionorderby['orderby']=='move'){
									$con['orderby']='sort';
									$con['orderby_res']=$actionorderby['orderby_res'];
								}else{
									$con['orderby']='article_id';
									$con['orderby_res']='DESC';
								}
							//排序--结束
							$checkboxion_1list=$this->ArticleModel->getarticlelist($con);
				    	?>
				    	<?php 
				    	if(isset($checkboxion_1list)){
				    		for($i=0;$i<count($checkboxion_1list);$i++){
				    			$sql="SELECT * FROM gksel_article_checkboxion WHERE checkboxion_num=1 AND article_id=".$articleinfo['article_id']." AND condition_id=".$checkboxion_1list[$i]['article_id'];
				    			$checkedres=$this->db->query($sql)->row_array();
				    			if(!empty($checkedres)){
				    				$ischecked='checked';
				    			}else{
				    				$ischecked='';
				    			}
				    		?>
				    		<input type="checkbox" name="checkboxion_1[]" id="checkboxion_1_<?php echo $checkboxion_1list[$i]['article_id'];?>" value="<?php echo $checkboxion_1list[$i]['article_id'];?>" <?php echo $ischecked;?> /> <label for="checkboxion_1_<?php echo $checkboxion_1list[$i]['article_id'];?>"><?php echo $checkboxion_1list[$i]['article_name'.$this->langtype]?></label>
				    	<?php }}?>
				    </td>
				</tr>
				<tr>
				    <td colspan="2">
				    	<div style="float:left;width:100%;margin:5px 0px 5px 0px;border-top:1px solid #999999;line-height:1px;">&nbsp;</div>
				    </td>
				</tr>
			<?php }?>
			<?php if($is_checkboxion_2==1){?>
				<tr>
					<td width="120" align="right">第二多选&nbsp;&nbsp;</td>
				    <td align="left">
				    	<?php 
					    	$postsubcategory_info=$this->ArticleModel->getarticle_categoryinfo(59);
					    	$con=array('category_id'=>59,'subcategory_id'=>66);
							//排序--开始
								$actionorderby=doactionorderby($postsubcategory_info['parameter_list']);
								if($actionorderby['orderby']=='move'){
									$con['orderby']='sort';
									$con['orderby_res']=$actionorderby['orderby_res'];
								}else{
									$con['orderby']='article_id';
									$con['orderby_res']='DESC';
								}
							//排序--结束
							$checkboxion_2list=$this->ArticleModel->getarticlelist($con);
				    	?>
				    	<?php 
				    	if(isset($checkboxion_2list)){
				    		for($i=0;$i<count($checkboxion_2list);$i++){
				    			$sql="SELECT * FROM gksel_article_checkboxion WHERE checkboxion_num=2 AND article_id=".$articleinfo['article_id']." AND condition_id=".$checkboxion_2list[$i]['article_id'];
				    			$checkedres=$this->db->query($sql)->row_array();
				    			if(!empty($checkedres)){
				    				$ischecked='checked';
				    			}else{
				    				$ischecked='';
				    			}
				    		?>
				    		<input type="checkbox" name="checkboxion_2[]" id="checkboxion_2_<?php echo $checkboxion_2list[$i]['article_id'];?>" value="<?php echo $checkboxion_2list[$i]['article_id'];?>" <?php echo $ischecked;?> /> <label for="checkboxion_2_<?php echo $checkboxion_2list[$i]['article_id'];?>"><?php echo $checkboxion_2list[$i]['article_name'.$this->langtype]?></label>
				    	<?php }}?>
				    </td>
				</tr>
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
				    	<div style="float:left;"><input type="text" style="width:<?php echo ${'nolaninput_'.$tt.'_width'}?>px;" name="nolaninput_<?php echo $tt;?>" value="<?php echo $articleinfo['nolaninput_'.$tt]?>" /></div>
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
							    	<div style="float:left;"><input type="text" style="width:'.${'laninput_'.$tt.'_width'}.'px;" name="laninput_'.$tt.$langarr[$la]['langtype'].'" value="'.$articleinfo['laninput_'.$tt.$langarr[$la]['langtype']].'"/></div>
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
						    		<textarea style="float:left;width:<?php echo ${'nolantextarea_'.$tt.'_width'}?>px;height:<?php echo ${'nolantextarea_'.$tt.'_height'}?>px;" id="<?php echo 'nolantextarea_'.$tt?>" name="<?php echo 'nolantextarea_'.$tt?>"><?php echo $articleinfo['nolantextarea_'.$tt]?></textarea>
						    	</div>
					    	<?php }else if(${'nolantextarea_'.$tt.'_showtype'}==2){//编辑器?>
					    		<div style="float:left;">
						    		<textarea id="<?php echo 'nolantextarea_'.$tt?>" name="<?php echo 'nolantextarea_'.$tt?>"><?php echo $articleinfo['nolantextarea_'.$tt]?></textarea>
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
							    	<div style="float:left;"><textarea class="ckeditor" id="lantextarea_'.$tt.$langarr[$la]['langtype'].'" name="lantextarea_'.$tt.$langarr[$la]['langtype'].'">'.$articleinfo['lantextarea_'.$tt.$langarr[$la]['langtype']].'</textarea></div>
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
				    	<input name="id" type="hidden" value="<?php echo $articleinfo['article_id'];?>" />
				    	<input name="key" type="hidden" value="<?php echo $articleinfo['key'];?>" />
				    	<input name="subcategory_id" type="hidden" value="<?php echo $subcategory_info['category_id'];?>" />
				    	<input name="first_id" type="hidden" value="<?php echo $firstinfo['article_id'];?>" />
				    	<input name="tongji_split" type="hidden" value="<?php echo $tongji_split;?>" />
				   		<input type="submit" value="Save" style="float:left;background:#018E01;border:0px;color:white;padding:4px 15px 4px 15px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;"/>
				    </td>
			    </tr>
			</table>
		</td>
	</tr>
</table>
</form>




<?php if($this->category_id==81){?>
<div style="float:left;width:100%;height:475px;margin-top:5px;">
	<div id="map_canvas" style="float:left;width:100%;height:475px;"></div>
</div>


<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true&language=en"></script>
<script type="text/javascript">
//地图--开始
var map;
var gzLatLng;
var geocoder;
var mylistener;
var markersArray = [];
//num:从0开始
function addMarker(num,imgpath,location,title,address){
		var image = new google.maps.MarkerImage(imgpath,
		// 这标志是30像素宽48像素高。
		new google.maps.Size(30, 48),
		// 原来的点是0,0。
		new google.maps.Point(0,0),
		// 锚这个形象是旗杆的基地0,48。
		new google.maps.Point(15, 48));
	
		var thismark = new google.maps.Marker({
			position: location,
			map: map,
			icon:image,
			
			animation: google.maps.Animation.DROP,//DROP 表明Marker初次放置于地图上时，应当从地图顶端落到目标位置。当Marker停止移动时，动画也会立即结束，且 animation值还原为 null。通常，该类型动画应用在Marker 创建过程中。
			title:title
		});
		thismark.setDraggable(false);
		
		var markLatLng = new google.maps.LatLng(location.lat(),location.lng());
		if(num==0){
			//设置标签--不停的跳动--START
				thismark.setAnimation(google.maps.Animation.BOUNCE);//BOUNCE 表明Marker会在相应的位置上“弹跳”。Marker会不停“弹跳”，直到Marker的animation属性设置为null。
			//设置标签--不停的跳动--END
		}
		markersArray.push(thismark);
}

//地图--结束
gzLatLng = new google.maps.LatLng(31.223243,121.44552299999998);
var myOptions = {
	zoom: 6,
	center:gzLatLng,
	mapTypeId : google.maps.MapTypeId.ROADMAP, //常量ROADMAP以地图显示 常量SATELLITE为卫星显示
    disableDoubleClickZoom : true //禁用双击缩放地图
};
map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
geocoder = new google.maps.Geocoder();




function tokeywordaddmark(address){
	//根据地址搜索  经纬度
	geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			latLng=results[0].geometry.location;

			

			addMarker(0,baseurl+'upload/article/2015/04/article_1_2015_04_09_10_56_00.png',eval( "latLng"),'Address 0','Address 0');
			map.setCenter(eval( "latLng"));

			$('input[name="nolaninput_1"]').val(latLng.lng());

			$('input[name="nolaninput_2"]').val(latLng.lat());

		}
	});
}


$(document).ready(function (){
	$('input[name="article_name_en"]').keyup(function(){
		if($(this).val().length>=1){
			tokeywordaddmark($(this).val());
		}
	});
})

</script>

<script type="text/javascript">
	tokeywordaddmark('<?php echo $articleinfo['article_name'.$this->langtype]?>');
</script>
<?php }?>


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
					$('#img1_gksel_show').html('<img id="thumbnail" style="float:left;max-height:400px;" src="'+baseurl+pic.logo+'" />');
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
					$('#img2_gksel_show').html('<img id="thumbnail" style="float:left;max-height:400px;" src="'+baseurl+pic.logo+'" />');
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
					$('#img3_gksel_show').html('<img id="thumbnail" style="float:left;max-height:400px;" src="'+baseurl+pic.logo+'" />');
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