<div style="float:left;width:100%;">
	<table cellspacing=0 cellpadding=0 class="tab_post" style="margin-bottom:10px;">
			<tr>
				<td width="120" align="right" valign="top">产品特征&nbsp;&nbsp;</td>
				<td valign="top">
					<div style="float:left;width:100%;">
						<?php 
							$sql="
								SELECT a.* , b.feature_code , b.feature_pic
								
								FROM gksel_product_feature AS a 
								
								LEFT JOIN gksel_condition_feature_list AS b ON a.feature_id=b.feature_id
								
								WHERE a.product_id=".$articleinfo['article_id']." AND b.parent=1
								
								ORDER BY b.feature_id ASC
								";
								$checkedcolorlist=$this->db->query($sql)->result_array();
						?>
						<div style="float:left;width:100%;">
							<div style="float:left;width:630px;background-color: #F8F8F8;border: 1px solid #ECECEC;margin:0px 0px 10px 0px;">
								<?php 
								echo '<div style="float:left;width:98%;margin:10px 0px 10px 2%;">颜色分类：</div>';
									$featurelist=$this->ProductModel->getfeaturelist(array('parent'=>1,'section'=>2,'orderby'=>'sort','orderby_res'=>'ASC'));
									if(!empty($featurelist)){
										$count=count($featurelist);
										$num=4;
										echo '<div style="float:left;width:98%;margin:0px 0px 0px 2%;">';
										echo '<table border=0 cellspacing=0 cellpadding=0 style="float:left;width:100%;">';
											$percent=100/$num;
											for($i=0;$i<$count;$i++){
												$ischecked='';
												$ischecked_name=$featurelist[$i]['feature_name'.$this->langtype];
												$ischecked_name_dispaly='display:none;';
												$ischecked_show_dispaly='display:block;';
												if(!empty($checkedcolorlist)){
													for($j=0;$j<count($checkedcolorlist);$j++){
														if($checkedcolorlist[$j]['feature_id']==$featurelist[$i]['feature_id']){
															$ischecked='checked';
															$ischecked_name=$checkedcolorlist[$j]['re_feature_name'.$this->langtype];
															$ischecked_name_dispaly='display:block;';
															$ischecked_show_dispaly='display:none;';
														}
													}
												}
												//
												
												
												if($featurelist[$i]['feature_pic']!=""){
													$bg="background:url('".base_url().$featurelist[$i]['feature_pic']."')";
												}else{
													$bg="background-color:".$featurelist[$i]['feature_code'].";";
												}
												if($i%$num==0){echo '<tr>';}
													
														echo '
															<td height="25" width="'.$percent.'%" valign="top">
																<input type="hidden" id="colorbg_'.$featurelist[$i]['feature_id'].'" value="'.$bg.'"/>
																<div style="float:left;"><input onclick="tooption_color('.$featurelist[$i]['feature_id'].')" class="colorcheckbox" name="colorcheckbox[]" id="colorcheckbox_'.$featurelist[$i]['feature_id'].'" type="checkbox" value="'.$featurelist[$i]['feature_id'].'" '.$ischecked.'/></div>
																<label for="colorcheckbox_'.$featurelist[$i]['feature_id'].'" class="product_colorprice_boxbg" style="'.$bg.'">&nbsp;</label>
																<label for="colorcheckbox_'.$featurelist[$i]['feature_id'].'" class="colornametext" id="colornametext_'.$featurelist[$i]['feature_id'].'" style="'.$ischecked_show_dispaly.'float:left;margin:2px 0px 0px 4px;">'.$featurelist[$i]['feature_name'.$this->langtype].'</label>
																<div style="float:left;margin:-4px 0px 0px 4px;'.$ischecked_name_dispaly.'"><input class="colornameinput" id="colornameinput_'.$featurelist[$i]['feature_id'].'" name="colornameinput_'.$featurelist[$i]['feature_id'].'" type="text" value="'.$ischecked_name.'" style="width:70px;"/></div>
															</td>
														';
													
												if($i==($count-1)){for($a=0;$a<$num;$a++){if($i%$num==$a){$tdnum=($num-$a)-1;for($b=1;$b<=$tdnum;$b++){echo '<td width="'.$percent.'%"></td>';}echo '</tr>';}}}else{if($i%$num==($num-1)){echo '</tr>';}}
											}
										echo '</table>';
										echo '</div>';
									}
								?>
							</div>
						</div>
						
						
						<?php 
							//大小
							$feature_category_id=26;
							$sql="
								SELECT a.* , b.feature_code , b.feature_pic
								
								FROM gksel_product_feature AS a 
								
								LEFT JOIN gksel_condition_feature_list AS b ON a.feature_id=b.feature_id
								
								WHERE a.product_id=".$articleinfo['article_id']." AND b.parent=".$feature_category_id;
							$checkedsizelist=$this->db->query($sql)->result_array();
							//大小的标题
							
							$sql="SELECT * FROM gksel_condition_feature_list WHERE feature_id=".$feature_category_id;
							$sizefeaturecategoryinfo=$this->db->query($sql)->row_array();
							if(!empty($checkedsizelist)){
								$sizecategoryname_ch=$checkedsizelist[0]['feature_category_name_en'];
								$sizecategoryinput_dis='display:block;';
								$sizecategorytext_dis='display:none;';
							}else{
								$sizecategoryname_ch=$sizefeaturecategoryinfo['feature_name_en'];
								$sizecategoryinput_dis='display:none;';
								$sizecategorytext_dis='display:block;';
							}
						?>
						<div style="float:left;width:100%;">
							<div style="float:left;width:630px;background-color: #F8F8F8;border: 1px solid #ECECEC;margin:0px 0px 10px 0px;">
								<?php 
									echo '<div style="float:left;width:98%;margin:10px 0px 10px 2%;'.$sizecategoryinput_dis.'"><input name="feature_category_name_en_'.$feature_category_id.'" type="text" value="'.$sizecategoryname_ch.'"/></div>';
									echo '<div style="float:left;width:98%;margin:10px 0px 10px 2%;'.$sizecategorytext_dis.'" id="feature_category_name_en_text_'.$feature_category_id.'">'.$sizefeaturecategoryinfo['feature_name_en'].'</div>';
									$featurelist=$this->ProductModel->getfeaturelist(array('parent'=>$feature_category_id,'section'=>2,'orderby'=>'sort','orderby_res'=>'ASC'));
									if(!empty($featurelist)){
										$count=count($featurelist);
										$num=4;
										echo '<div style="float:left;width:98%;margin:0px 0px 0px 2%;">';
										echo '<table border=0 cellspacing=0 cellpadding=0 style="float:left;width:100%;">';
											$percent=100/$num;
											for($i=0;$i<$count;$i++){
												$ischecked='';
												$ischecked_name=$featurelist[$i]['feature_name'.$this->langtype];
												$ischecked_name_dispaly='display:none;';
												$ischecked_show_dispaly='display:block;';
												if(!empty($checkedsizelist)){
													for($j=0;$j<count($checkedsizelist);$j++){
														if($checkedsizelist[$j]['feature_id']==$featurelist[$i]['feature_id']){
															$ischecked='checked';
															$ischecked_name=$checkedsizelist[$j]['re_feature_name'.$this->langtype];
															$ischecked_name_dispaly='display:block;';
															$ischecked_show_dispaly='display:none;';
														}
													}
												}
												if($i%$num==0){echo '<tr>';}
													echo '
														<td height="25" width="'.$percent.'%" valign="top">
															<div style="float:left;"><input onclick="tooption_size('.$featurelist[$i]['feature_id'].')" class="sizecheckbox" name="sizecheckbox[]" id="sizecheckbox_'.$featurelist[$i]['feature_id'].'" type="checkbox" value="'.$featurelist[$i]['feature_id'].'" '.$ischecked.'/></div>
															<label for="sizecheckbox_'.$featurelist[$i]['feature_id'].'" class="sizenametext" id="sizenametext_'.$featurelist[$i]['feature_id'].'" style="'.$ischecked_show_dispaly.'float:left;margin:2px 0px 0px 4px;">'.$featurelist[$i]['feature_name'.$this->langtype].'</label>
															<div style="float:left;margin:-4px 0px 0px 4px;'.$ischecked_name_dispaly.'"><input class="sizenameinput" id="sizenameinput_'.$featurelist[$i]['feature_id'].'" name="sizenameinput_'.$featurelist[$i]['feature_id'].'" type="text" value="'.$ischecked_name.'" style="width:100px;"/></div>
														</td>
													';
												if($i==($count-1)){for($a=0;$a<$num;$a++){if($i%$num==$a){$tdnum=($num-$a)-1;for($b=1;$b<=$tdnum;$b++){echo '<td width="'.$percent.'%"></td>';}echo '</tr>';}}}else{if($i%$num==($num-1)){echo '</tr>';}}
											}
										echo '</table>';
										echo '</div>';
									}
								?>
							</div>
						</div>
						
						<?php 
								//自定义属性1
								$feature_category_id=36;
								$sql="
									SELECT *
									
									FROM gksel_condition_feature_list
									
									WHERE parent=".$feature_category_id." ORDER BY feature_id ASC LIMIT 0,1";
								$checkedzdyonelist=$this->db->query($sql)->result_array();
						
						?>
						<div style="float:left;width:100%;margin:10px 0px 0px 0px;">
							<div class="product_colorprice_tab" style="<?php if(!empty($checkedcolorlist)&&!empty($checkedsizelist)){}else{echo 'display:none;';}?>">
								<div style="float:left;width:100%;">
									<div class="title_color">Color</div>
									<div class="title_size"><?php if($sizecategoryname_ch!=""){echo $sizecategoryname_ch;}else{echo '&nbsp;';}?></div>
									<div class="title_price">Price <font class="fonterror">*</font></div>
									<div class="title_quantity">数量 <font class="fonterror">*</font></div>
									<div class="title_merchantcoding">商家编码</div>
									<div class="title_barcode">商品条形码</div>
									<div class="title_pic">图片</div>
								</div>
								<div id="product_colorprice_tbody" style="float:left;width:100%;">
									<?php 
									if(!empty($checkedcolorlist)){
										for($i=0;$i<count($checkedcolorlist);$i++){
											if($checkedcolorlist[$i]['feature_pic']!=""){
												$bg="background:url('".base_url().$checkedcolorlist[$i]['feature_pic']."')";
											}else{
												$bg="background-color:".$checkedcolorlist[$i]['feature_code'].";";
											}
											
											
											$text_1='<div class="list_color"><label class="product_colorprice_boxbg" style="'.$bg.'">&nbsp;</label><label id="re_colorprice_inputname_'.$checkedcolorlist[$i]['feature_id'].'" style="float:left;margin:2px 0px 0px 4px;">'.$checkedcolorlist[$i]['re_feature_name'.$this->langtype].'</label></div>';
											$text_2='<div class="product_sizeprice_tr_'.$checkedcolorlist[$i]['feature_id'].'" style="float:left;width:100%;">';
											$text_3_pic='';
											if($checkedcolorlist[$i]['re_feature_pic']!=""&&file_exists($checkedcolorlist[$i]['re_feature_pic'])){
												$text_3_pic='<a style="float:left;margin-left:27px;" href="javascript:;" onclick="toview_color_picture(\''.$checkedcolorlist[$i]['re_feature_pic'].'\')"><img style="float:left;width:30px;height:30px;" src="'.base_url().$checkedcolorlist[$i]['re_feature_pic'].'"/></a>';
											}
											$text_3='
												<div class="list_pic">
													<div class="img_gksel_show" id="imgcolor'.$checkedcolorlist[$i]['feature_id'].'_gksel_show">
														'.$text_3_pic.'
													</div>
													<div id="imgcolor'.$checkedcolorlist[$i]['feature_id'].'_gksel_choose" class="img_gksel_choose" style="margin-left:10px;line-height:17px;">选择图片</div>
													<div class="tabmes_l"><input type="hidden" id="imgcolor'.$checkedcolorlist[$i]['feature_id'].'_gksel" name="imgcolor'.$checkedcolorlist[$i]['feature_id'].'_gksel" value="'.$checkedcolorlist[$i]['re_feature_pic'].'"/></div>
													<div class="tabmes_l"><font class="fonterror" id="imgcolor'.$checkedcolorlist[$i]['feature_id'].'_gksel_error"></font></div>
												</div>';
											
											if(!empty($checkedsizelist)){
												for($j=0;$j<count($checkedsizelist);$j++){
													$sql="SELECT * FROM gksel_product_compose WHERE product_id=".$articleinfo['article_id']." AND color_id=".$checkedcolorlist[$i]['feature_id']." AND size_id=".$checkedsizelist[$j]['feature_id']." AND zdyone_id=".$checkedzdyonelist[0]['feature_id']."";
													$composeinfo=$this->db->query($sql)->row_array();
													if(empty($composeinfo)){
														$composeinfo['re_feature_price']='';
														$composeinfo['re_feature_quantity']='';
														$composeinfo['re_feature_businessnumber']='';
														$composeinfo['re_feature_eancode']='';
													}
														$text_2=$text_2.'
															<div id="product_sizeprice_tr_'.$checkedcolorlist[$i]['feature_id'].'_'.$checkedsizelist[$j]['feature_id'].'" style="float:left;width:100%;">
																<div class="list_size list_size_'.$checkedsizelist[$j]['feature_id'].'">'.$checkedsizelist[$j]['re_feature_name_en'].'</div>
																<div class="list_price"><input id="re_feature_price_'.$checkedcolorlist[$i]['feature_id'].'_'.$checkedsizelist[$j]['feature_id'].'_'.$checkedzdyonelist[0]['feature_id'].'" name="re_feature_price_'.$checkedcolorlist[$i]['feature_id'].'_'.$checkedsizelist[$j]['feature_id'].'_'.$checkedzdyonelist[0]['feature_id'].'" type="text" style="width:70px" value="'.$composeinfo['re_feature_price'].'"/></div>
																<div class="list_quantity"><input id="re_feature_quantity_'.$checkedcolorlist[$i]['feature_id'].'_'.$checkedsizelist[$j]['feature_id'].'_'.$checkedzdyonelist[0]['feature_id'].'" name="re_feature_quantity_'.$checkedcolorlist[$i]['feature_id'].'_'.$checkedsizelist[$j]['feature_id'].'_'.$checkedzdyonelist[0]['feature_id'].'" type="text" style="width:60px" value="'.$composeinfo['re_feature_quantity'].'"/></div>
																<div class="list_merchantcoding"><input id="re_feature_businessnumber_'.$checkedcolorlist[$i]['feature_id'].'_'.$checkedsizelist[$j]['feature_id'].'_'.$checkedzdyonelist[0]['feature_id'].'" name="re_feature_businessnumber_'.$checkedcolorlist[$i]['feature_id'].'_'.$checkedsizelist[$j]['feature_id'].'_'.$checkedzdyonelist[0]['feature_id'].'" type="text" style="width:90px" value="'.$composeinfo['re_feature_businessnumber'].'"/></div>
																<div class="list_barcode"><input id="re_feature_eancode_'.$checkedcolorlist[$i]['feature_id'].'_'.$checkedsizelist[$j]['feature_id'].'_'.$checkedzdyonelist[0]['feature_id'].'" name="re_feature_eancode_'.$checkedcolorlist[$i]['feature_id'].'_'.$checkedsizelist[$j]['feature_id'].'_'.$checkedzdyonelist[0]['feature_id'].'" type="text" style="width:90px" value="'.$composeinfo['re_feature_eancode'].'" /></div>
															</div>
														';
												}
											}
											$text_2=$text_2.'</div>';
												echo '
													<div id="product_colorprice_tr_'.$checkedcolorlist[$i]['feature_id'].'" style="float:left;width:100%;">
														<table cellspacing=0 cellpadding=0 border=0 style="float:left;">
															<tr>
																<td width="90" style="border-left: 1px solid #D7D7D7;border-bottom: 1px solid #D7D7D7;">'.$text_1.'</td>
																<td width="525">'.$text_2.'</td>
																<td width="100" style="border-left: 1px solid #D7D7D7;border-bottom: 1px solid #D7D7D7;border-right: 1px solid #D7D7D7;">'.$text_3.'</td>
															</tr>
														</table>
													</div>
												';
											$colorpicnum['colorpicnum']=$checkedcolorlist[$i]['feature_id'];
											$this->load->view('admin/product_edit_section_2_colorpicjs',$colorpicnum);
										}
									}
									?>
								</div>
							</div>
						</div>
						
						<div style="float:left;width:100%;margin:10px 0px 0px 0px;">
							<?php 
								$sql="SELECT * FROM gksel_condition_feature_list WHERE feature_id=36";
								$zdyonefeaturecategoryinfo=$this->db->query($sql)->row_array();
							//zdyonecheckbox[]
									echo '<div style="float:left;width:100%;display:none;">';
									echo '<input name="feature_category_name_en_36" type="hidden" value="'.$zdyonefeaturecategoryinfo['feature_name_ch'].'"/>';
									echo '<input name="zdyonecheckbox[]" type="checkbox" checked value="'.$checkedzdyonelist[0]['feature_id'].'"/>';
									echo '<input name="zdyonenameinput_'.$checkedzdyonelist[0]['feature_id'].'" type="hidden" value="'.$checkedzdyonelist[0]['feature_name_ch'].'"/>';
									echo '</div>';
							?>
							<div class="fonterror" id="color_size_error"></div>
						</div>
					</div>
				</td>
			</tr>
	</table>
</div>
<div id="section_2colorjs"></div>
<script type="text/javascript">
<!--
	//选择模板muban_id
	var zdyone_id=<?php echo $checkedzdyonelist[0]['feature_id'];?>;
	function toselectmuban(muban_id){
		$.post(baseurl+'admins/product/tochoosemuban/<?php echo $articleinfo['article_id']?>/'+muban_id,function (data){
			$('#section_2_parent').html(data);
		})
	}
	function tooption_color(color_id){
		//判断size
		var sizearr=$('input[name="sizecheckbox[]"]');
		var checkedsizearr=[];
		if(sizearr.length>0){
			for(var i=0;i<sizearr.length;i++){
				if(sizearr[i].checked==true){
					checkedsizearr.push(sizearr[i].value);
				}
			}
		}
		if($('#colorcheckbox_'+color_id).attr('checked')=='checked'){
			if(checkedsizearr.length>0){
				var text_1='<div class="list_color"><label class="product_colorprice_boxbg" style="'+$('#colorbg_'+color_id).val()+'">&nbsp;</label><label id="re_colorprice_inputname_'+color_id+'" style="float:left;margin:2px 0px 0px 4px;">'+$('#colornametext_'+color_id).html()+'</label></div>';
				var text_2='<div class="product_sizeprice_tr_'+color_id+'" style="float:left;width:100%;">';
				var text_3='<div class="list_pic"><div class="img_gksel_show" id="imgcolor'+color_id+'_gksel_show"></div><div id="imgcolor'+color_id+'_gksel_choose" class="img_gksel_choose" style="margin-left:10px;line-height:17px;">选择图片</div><div class="tabmes_l"><input type="hidden" id="imgcolor'+color_id+'_gksel" name="imgcolor'+color_id+'_gksel" value=""/></div><div class="tabmes_l"><font class="fonterror" id="imgcolor'+color_id+'_gksel_error"></font></div></div>';
				for(var i=0;i<checkedsizearr.length;i++){
					text_2=text_2+'<div id="product_sizeprice_tr_'+color_id+'_'+checkedsizearr[i]+'" style="float:left;width:100%;">';
					text_2=text_2+'<div class="list_size list_size_'+checkedsizearr[i]+'">'+$('#sizenameinput_'+checkedsizearr[i]).val()+'</div>';
					text_2=text_2+'<div class="list_price"><input id="re_feature_price_'+color_id+'_'+checkedsizearr[i]+'_'+zdyone_id+'" name="re_feature_price_'+color_id+'_'+checkedsizearr[i]+'_'+zdyone_id+'" type="text" style="width:70px" /></div>';
					text_2=text_2+'<div class="list_quantity"><input id="re_feature_quantity_'+color_id+'_'+checkedsizearr[i]+'_'+zdyone_id+'" name="re_feature_quantity_'+color_id+'_'+checkedsizearr[i]+'_'+zdyone_id+'" type="text" style="width:60px" /></div>';
					text_2=text_2+'<div class="list_merchantcoding"><input id="re_feature_businessnumber_'+color_id+'_'+checkedsizearr[i]+'_'+zdyone_id+'" name="re_feature_businessnumber_'+color_id+'_'+checkedsizearr[i]+'_'+zdyone_id+'" type="text" style="width:90px" /></div>';
					text_2=text_2+'<div class="list_barcode"><input id="re_feature_eancode_'+color_id+'_'+checkedsizearr[i]+'_'+zdyone_id+'" name="re_feature_eancode_'+color_id+'_'+checkedsizearr[i]+'_'+zdyone_id+'" type="text" style="width:90px" /></div>';
					text_2=text_2+'</div>';
				}
				text_2=text_2+'</div>';
				$('#product_colorprice_tbody').append('<div id="product_colorprice_tr_'+color_id+'" style="float:left;width:100%;"><table cellspacing=0 cellpadding=0 style="float:left;"><tr><td width="90" style="border-left: 1px solid #D7D7D7;border-bottom: 1px solid #D7D7D7;">'+text_1+'</td><td width="525">'+text_2+'</td><td width="100" style="border-left: 1px solid #D7D7D7;border-bottom: 1px solid #D7D7D7;border-right: 1px solid #D7D7D7;">'+text_3+'</td></tr></table></div>');
				$('#colornameinput_'+color_id).parent().show();
				$('#colornametext_'+color_id).hide();

				//增加图片上传的js
				$.post(baseurl+'admins/product/toaddpicuploadingjs/'+color_id,function (data){
					$('#section_2colorjs').html(data);
				})
			}else{
				//此时没有选择大小

				var text_1='<div class="list_color"><label class="product_colorprice_boxbg" style="'+$('#colorbg_'+color_id).val()+'">&nbsp;</label><label id="re_colorprice_inputname_'+color_id+'" style="float:left;margin:2px 0px 0px 4px;">'+$('#colornametext_'+color_id).html()+'</label></div>';
				var text_2='<div class="product_sizeprice_tr_'+color_id+'" style="float:left;width:100%;">';
				var text_3='<div class="list_pic"><div class="img_gksel_show" id="imgcolor'+color_id+'_gksel_show"></div><div id="imgcolor'+color_id+'_gksel_choose" class="img_gksel_choose" style="margin-left:10px;line-height:17px;">选择图片</div><div class="tabmes_l"><input type="hidden" id="imgcolor'+color_id+'_gksel" name="imgcolor'+color_id+'_gksel" value=""/></div><div class="tabmes_l"><font class="fonterror" id="imgcolor'+color_id+'_gksel_error"></font></div></div>';
				text_2=text_2+'</div>';
				$('#product_colorprice_tbody').append('<div id="product_colorprice_tr_'+color_id+'" style="float:left;width:100%;"><table cellspacing=0 cellpadding=0 style="float:left;"><tr><td width="90" style="border-left: 1px solid #D7D7D7;border-bottom: 1px solid #D7D7D7;">'+text_1+'</td><td width="525">'+text_2+'</td><td width="100" style="border-left: 1px solid #D7D7D7;border-bottom: 1px solid #D7D7D7;border-right: 1px solid #D7D7D7;">'+text_3+'</td></tr></table></div>');
				$('#colornameinput_'+color_id).parent().show();
				$('#colornametext_'+color_id).hide();

				//增加图片上传的js
				$.post(baseurl+'admins/product/toaddpicuploadingjs/'+color_id,function (data){
					$('#section_2colorjs').html(data);
				})
			}
		}else{
			$('#product_colorprice_tr_'+color_id).remove();
			$('#colornameinput_'+color_id).parent().hide();
			$('#colornametext_'+color_id).show();
		}
		tocheckcomposeisshow();//判断配置选择是否显示
	}

	function tooption_size(size_id){
		//判断color
		var colorarr=$('input[name="colorcheckbox[]"]');
		var checkedcolorarr=[];
		if(colorarr.length>0){
			for(var i=0;i<colorarr.length;i++){
				if(colorarr[i].checked==true){
					checkedcolorarr.push(colorarr[i].value);
				}
			}
		}
		if($('#sizecheckbox_'+size_id).attr('checked')=='checked'){
			if(checkedcolorarr.length>0){
				for(var i=0;i<checkedcolorarr.length;i++){
					var text_2='<div id="product_sizeprice_tr_'+checkedcolorarr[i]+'_'+size_id+'" style="float:left;width:100%;">';
					text_2=text_2+'<div class="list_size list_size_'+size_id+'">'+$('#sizenameinput_'+size_id).val()+'</div>';
					text_2=text_2+'<div class="list_price"><input id="re_feature_price_'+checkedcolorarr[i]+'_'+size_id+'_'+zdyone_id+'" name="re_feature_price_'+checkedcolorarr[i]+'_'+size_id+'_'+zdyone_id+'" type="text" style="width:70px" /></div>';
					text_2=text_2+'<div class="list_quantity"><input id="re_feature_quantity_'+checkedcolorarr[i]+'_'+size_id+'_'+zdyone_id+'" name="re_feature_quantity_'+checkedcolorarr[i]+'_'+size_id+'_'+zdyone_id+'" type="text" style="width:60px" /></div>';
					text_2=text_2+'<div class="list_merchantcoding"><input id="re_feature_businessnumber_'+checkedcolorarr[i]+'_'+size_id+'_'+zdyone_id+'" name="re_feature_businessnumber_'+checkedcolorarr[i]+'_'+size_id+'_'+zdyone_id+'" type="text" style="width:90px" /></div>';
					text_2=text_2+'<div class="list_barcode"><input id="re_feature_eancode_'+checkedcolorarr[i]+'_'+size_id+'_'+zdyone_id+'" name="re_feature_eancode_'+checkedcolorarr[i]+'_'+size_id+'_'+zdyone_id+'" type="text" style="width:90px" /></div>';
					text_2=text_2+'</div>';
					$('.product_sizeprice_tr_'+checkedcolorarr[i]).append(text_2);
				}
				$('#sizenameinput_'+size_id).parent().show();
				$('#sizenametext_'+size_id).hide();
			}else{
				alert('请选择颜色');
			}
		}else{
			if(checkedcolorarr.length>0){
				for(var i=0;i<checkedcolorarr.length;i++){
					$('#product_sizeprice_tr_'+checkedcolorarr[i]+'_'+size_id).remove();
				}
			}
			$('#sizenameinput_'+size_id).parent().hide();
			$('#sizenametext_'+size_id).show();
		}
		tocheckcomposeisshow();//判断配置选择是否显示
	}
	
	//判断配置选择是否显示
	function tocheckcomposeisshow(){
		var ispass_1=0;
		$('.colorcheckbox').each(function (){
			if($(this).attr('checked')=='checked'){
				ispass_1=1;
			}
		})
		var ispass_2=0;
		$('.sizecheckbox').each(function (){
			if($(this).attr('checked')=='checked'){
				ispass_2=1;
			}
		})
		if(ispass_1==1&&ispass_2==1){
			$('.product_colorprice_tab').show();
		}else{
			$('.product_colorprice_tab').hide();
		}
	}

	//修改color名称
	$('.colornameinput').keyup(function (){
		var colornameinputid=$(this).attr('id');
		var colornameinputidsplit=colornameinputid.split('_');
		$('#re_colorprice_inputname_'+colornameinputidsplit[1]).html($(this).val());
	})
	//修改size 标题
	$('input[name="feature_category_name_en_26"]').keyup(function (){
		if($(this).val()!=""){
			$('.title_size').html($(this).val());
		}else{
			$('.title_size').html('&nbsp;');
		}
	})
	//修改size名称
	$('.sizenameinput').keyup(function (){
		var sizenameinputid=$(this).attr('id');
		var sizenameinputidsplit=sizenameinputid.split('_');
		$('.list_size_'+sizenameinputidsplit[1]).html($(this).val());
	})
	
	//查看color的图片
	function toview_color_picture(path){
		$('.notice_taball').show();
		$(".quickview_tab").show();
		$.post(baseurl+"admins/product/toview_color_picture",{path:path},function (data){
			$(".quickview_tab").find('.box_content').html(data);
		});
	}
	<?php if(isset($isopen)==1){?>
		toactionsection(2);
	<?php }?>
//-->
</script>