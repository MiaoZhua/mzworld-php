<table cellspacing=0 cellpadding=0 class="tab_post">
	<?php $section=2;?>
	<tr>
		<td colspan="2" onclick="toactionsection(<?php echo $section;?>)" style="font-weight:bold;text-indent:50px;font-size:16px;background:#EFEFEF;padding:5px 0px 5px 0px;">
			<div style="float:left;margin:7px 0px 0px 0px;">产品特征</div>
			<a id="btn_<?php echo $section;?>_plus" href="javascript:;" style="float:right;margin-right:20px;text-decoration:none;line-height:24px;font-size:24px;margin-top:3px;">+</a>
			<a id="btn_<?php echo $section;?>_minus" href="javascript:;" style="display:none;float:right;margin-right:20px;line-height:24px;text-decoration:none;font-size:36px;">-</a>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="line-height:6px;">&nbsp;</td>
	</tr>
</table>
<div style="float:left;width:100%;display:none;" id="section_<?php echo $section;?>_detail">
	<table cellspacing=0 cellpadding=0 class="tab_post" style="margin-bottom:10px;">
			<tr>
				<td width="150" align="right" valign="top">&nbsp;&nbsp;</td>
				<td valign="top">
					<div style="float:left;width:100%;margin:0px 0px 10px 0px;">
						<div style="float:left;width:630px;background-color: #F8F8F8;border: 1px solid #ECECEC;">
							<div style="float:left;width:98%;margin:10px 0px 10px 2%;">
								<div class="tabmes_l">
									<input type="radio" onclick="toselectmuban(1)" name="parameter_muban" id="parameter_muban_1" value="1"/> <label for="parameter_muban_1">模板A (有颜色和大小属性)</label>
									&nbsp;&nbsp;
									<input type="radio" onclick="toselectmuban(2)" name="parameter_muban" id="parameter_muban_2" value="2"/> <label for="parameter_muban_2">模板B (有颜色)</label>
									&nbsp;&nbsp;
									<input type="radio" onclick="toselectmuban(3)" name="parameter_muban" id="parameter_muban_3" value="3" checked/> <label for="parameter_muban_3">模板C (有颜色,大小和其他)</label>
								</div>
							</div>
						</div>
					</div>
					<div style="float:left;width:100%;margin:0px 0px 10px 0px;">
						<div style="float:left;width:630px;background-color: #F8F8F8;border: 1px solid #ECECEC;">
							<div style="float:left;width:98%;margin:10px 0px 10px 2%;">
								<div class="tabmes_l">
									产品重量：<input type="text" name="weight" style="width:70px;" value="<?php echo $productinfo['weight']?>"/>&nbsp;&nbsp;kg
								</div>
								<div class="tabmes_r">
									<font class="fonterror">*</font>
								</div>
								<div class="tabmes_r">
									<font id="weight_error" class="fonterror"></font>
								</div>
							
							</div>
						</div>
					</div>
					<div style="float:left;width:100%;margin:0px 0px 10px 0px;">
						<div style="float:left;width:630px;background-color: #F8F8F8;border: 1px solid #ECECEC;">
							<div style="float:left;width:98%;margin:10px 0px 10px 2%;">
								<div class="tabmes_l">
									产品包装后的尺寸：
									<input type="text" name="size_long" id="size_long" style="width:30px;" value="<?php echo $productinfo['size_long']?>"/>
									&nbsp;&nbsp;X&nbsp;&nbsp;
									<input type="text" name="size_width" id="size_width" style="width:30px;" value="<?php echo $productinfo['size_width']?>"/>
									&nbsp;&nbsp;X&nbsp;&nbsp;
									<input type="text" name="size_height" id="size_height" style="width:30px;" value="<?php echo $productinfo['size_height']?>"/>
								</div>
								<div class="tabmes_r">
									（单位：厘米, 每件/个 <span id="size_info_all" style="color:red;font-weight:bolder;">0</span> <span style="font-size:14px;">cm</span> <span style="vertical-align:super;">3</span>）
								</div>
								<div class="tabmes_r">
									<font id="baozhuangsize_error" class="fonterror"></font>
								</div>
							</div>
						</div>
					</div>
					<div style="float:left;width:100%;">
						<?php 
							$sql="
								SELECT a.* , b.feature_code , b.feature_pic
								
								FROM gksel_product_feature AS a 
								
								LEFT JOIN gksel_condition_feature_list AS b ON a.feature_id=b.feature_id
								
								WHERE a.product_id=".$productinfo['product_id']." AND b.parent=1";
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
								
								WHERE a.product_id=".$productinfo['product_id']." AND b.parent=".$feature_category_id;
							$checkedsizelist=$this->db->query($sql)->result_array();
							//大小的标题
							
							$sql="SELECT * FROM gksel_condition_feature_list WHERE feature_id=".$feature_category_id;
							$sizefeaturecategoryinfo=$this->db->query($sql)->row_array();
							if(!empty($checkedsizelist)){
								$sizecategoryname_ch=$checkedsizelist[0]['feature_category_name_ch'];
								$sizecategoryinput_dis='display:block;';
								$sizecategorytext_dis='display:none;';
							}else{
								$sizecategoryname_ch=$sizefeaturecategoryinfo['feature_name_ch'];
								$sizecategoryinput_dis='display:none;';
								$sizecategorytext_dis='display:block;';
							}
						?>
						<div style="float:left;width:100%;">
							<div style="float:left;width:630px;background-color: #F8F8F8;border: 1px solid #ECECEC;margin:0px 0px 10px 0px;">
								<?php 
									echo '<div style="float:left;width:98%;margin:10px 0px 10px 2%;'.$sizecategoryinput_dis.'"><input name="feature_category_name_ch_'.$feature_category_id.'" type="text" value="'.$sizecategoryname_ch.'"/></div>';
									echo '<div style="float:left;width:98%;margin:10px 0px 10px 2%;'.$sizecategorytext_dis.'" id="feature_category_name_ch_text_'.$feature_category_id.'">'.$sizefeaturecategoryinfo['feature_name_ch'].'</div>';
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
								SELECT a.* , b.feature_code , b.feature_pic
								
								FROM gksel_product_feature AS a 
								
								LEFT JOIN gksel_condition_feature_list AS b ON a.feature_id=b.feature_id
								
								WHERE a.product_id=".$productinfo['product_id']." AND b.parent=".$feature_category_id;
							$checkedzdyonelist=$this->db->query($sql)->result_array();
							//自定义属性的标题
							
							$sql="SELECT * FROM gksel_condition_feature_list WHERE feature_id=".$feature_category_id;
							$zdyonefeaturecategoryinfo=$this->db->query($sql)->row_array();
							if(!empty($checkedzdyonelist)){
								$zdyonecategoryname_ch=$checkedzdyonelist[0]['feature_category_name_ch'];
								$zdyonecategoryinput_dis='display:block;';
								$zdyonecategorytext_dis='display:none;';
							}else{
								$zdyonecategoryname_ch=$zdyonefeaturecategoryinfo['feature_name_ch'];
								$zdyonecategoryinput_dis='display:none;';
								$zdyonecategorytext_dis='display:block;';
							}
						?>
						<div style="float:left;width:100%;">
							<div style="float:left;width:630px;background-color: #F8F8F8;border: 1px solid #ECECEC;margin:0px 0px 10px 0px;">
								<?php 
									echo '<div style="float:left;width:98%;margin:10px 0px 10px 2%;'.$zdyonecategoryinput_dis.'"><input name="feature_category_name_ch_'.$feature_category_id.'" type="text" value="'.$zdyonecategoryname_ch.'"/></div>';
									echo '<div style="float:left;width:98%;margin:10px 0px 10px 2%;'.$zdyonecategorytext_dis.'" id="feature_category_name_ch_text_'.$feature_category_id.'">'.$zdyonefeaturecategoryinfo['feature_name_ch'].'</div>';
								
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
												if(!empty($checkedzdyonelist)){
													for($j=0;$j<count($checkedzdyonelist);$j++){
														if($checkedzdyonelist[$j]['feature_id']==$featurelist[$i]['feature_id']){
															$ischecked='checked';
															$ischecked_name=$checkedzdyonelist[$j]['re_feature_name'.$this->langtype];
															$ischecked_name_dispaly='display:block;';
															$ischecked_show_dispaly='display:none;';
														}
													}
												}
												if($i%$num==0){echo '<tr>';}
													echo '
														<td height="25" width="'.$percent.'%" valign="top">
															<div style="float:left;"><input onclick="tooption_zdyone('.$featurelist[$i]['feature_id'].')" class="zdyonecheckbox" name="zdyonecheckbox[]" id="zdyonecheckbox_'.$featurelist[$i]['feature_id'].'" type="checkbox" value="'.$featurelist[$i]['feature_id'].'" '.$ischecked.'/></div>
															<label for="zdyonecheckbox_'.$featurelist[$i]['feature_id'].'" class="zdyonenametext" id="zdyonenametext_'.$featurelist[$i]['feature_id'].'" style="'.$ischecked_show_dispaly.'float:left;margin:2px 0px 0px 4px;">'.$featurelist[$i]['feature_name'.$this->langtype].'</label>
															<div style="float:left;margin:-4px 0px 0px 4px;'.$ischecked_name_dispaly.'"><input class="zdyonenameinput" id="zdyonenameinput_'.$featurelist[$i]['feature_id'].'" name="zdyonenameinput_'.$featurelist[$i]['feature_id'].'" type="text" value="'.$ischecked_name.'" style="width:100px;"/></div>
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
						
						
						<div style="float:left;width:100%;margin:10px 0px 0px 0px;">
							<div class="product_colorprice_tab" style="<?php if(!empty($checkedcolorlist)&&!empty($checkedsizelist)){}else{echo 'display:none;';}?>">
								<div style="float:left;width:100%;">
									<div class="title_color"><?php echo lang('product_color_categoy')?></div>
									<div class="title_size"><?php if($sizecategoryname_ch!=""){echo $sizecategoryname_ch;}else{echo '&nbsp;';}?></div>
									<div class="title_zdyone"><?php if($zdyonecategoryname_ch!=""){echo $zdyonecategoryname_ch;}else{echo '&nbsp;';}?></div>
									<div class="title_price"><?php echo lang('price')?> <font class="fonterror">*</font></div>
									<div class="title_quantity"><?php echo lang('quantity')?> <font class="fonterror">*</font></div>
									<div class="title_merchantcoding"><?php echo lang('merchant_coding')?></div>
									<div class="title_barcode"><?php echo lang('product_barcode')?></div>
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
											$text_2='<div class="product_allsecondprice_'.$checkedcolorlist[$i]['feature_id'].'" style="float:left;width:100%;">';
											$text_3_pic='';
											if($checkedcolorlist[$i]['re_feature_pic']!=""&&file_exists($checkedcolorlist[$i]['re_feature_pic'])){
												$text_3_pic='<a style="float:left;margin-left:27px;" href="javascript:;" onclick="toview_color_picture(\''.$checkedcolorlist[$i]['re_feature_pic'].'\')"><img style="float:left;width:30px;height:30px;" src="'.base_url().$checkedcolorlist[$i]['re_feature_pic'].'"/></a>';
											}
											$text_3='
												<div class="list_pic">
													<div class="img_gksel_show" id="imgcolor'.$checkedcolorlist[$i]['feature_id'].'_gksel_show">
														'.$text_3_pic.'
													</div>
													<div id="imgcolor'.$checkedcolorlist[$i]['feature_id'].'_gksel_choose" class="img_gksel_choose" style="margin-left:10px;">选择图片</div>
													<div class="tabmes_l"><input type="hidden" id="imgcolor'.$checkedcolorlist[$i]['feature_id'].'_gksel" name="imgcolor'.$checkedcolorlist[$i]['feature_id'].'_gksel" value="'.$checkedcolorlist[$i]['re_feature_pic'].'"/></div>
													<div class="tabmes_l"><font class="fonterror" id="imgcolor'.$checkedcolorlist[$i]['feature_id'].'_gksel_error"></font></div>
												</div>';
											
											if(!empty($checkedsizelist)){
												for($j=0;$j<count($checkedsizelist);$j++){
													$text_a='<div class="list_size list_size_'.$checkedsizelist[$j]['feature_id'].'" style="border-bottom:0px solid red;border-left:0px solid red;border-right:0px solid red;">'.$checkedsizelist[$j]['re_feature_name_ch'].'</div>';
													$text_b='<div id="product_allthirdprice_'.$checkedcolorlist[$i]['feature_id'].'_'.$checkedsizelist[$j]['feature_id'].'" style="float:left;width:100%;">';
													if(!empty($checkedzdyonelist)){
														for($k=0;$k<count($checkedzdyonelist);$k++){
															$sql="SELECT * FROM gksel_product_compose WHERE product_id=".$productinfo['product_id']." AND color_id=".$checkedcolorlist[$i]['feature_id']." AND size_id=".$checkedsizelist[$j]['feature_id']." AND zdyone_id=".$checkedzdyonelist[$k]['feature_id']."";
															$composeinfo=$this->db->query($sql)->row_array();
															if(empty($composeinfo)){
																$composeinfo['re_feature_price']='';
																$composeinfo['re_feature_quantity']='';
																$composeinfo['re_feature_businessnumber']='';
																$composeinfo['re_feature_eancode']='';
															}
															
															
															$text_b .='
																<div id="product_zdyoneprice_tr_'.$checkedcolorlist[$i]['feature_id'].'_'.$checkedsizelist[$j]['feature_id'].'_'.$checkedzdyonelist[$k]['feature_id'].'" style="float:left;width:100%;">
																	<div class="list_zdyone list_zdyone_'.$checkedzdyonelist[$k]['feature_id'].'"">'.$checkedzdyonelist[$k]['re_feature_name_ch'].'</div>
																	<div class="list_price"><input id="re_feature_price_'.$checkedcolorlist[$i]['feature_id'].'_'.$checkedsizelist[$j]['feature_id'].'_'.$checkedzdyonelist[$k]['feature_id'].'" name="re_feature_price_'.$checkedcolorlist[$i]['feature_id'].'_'.$checkedsizelist[$j]['feature_id'].'_'.$checkedzdyonelist[$k]['feature_id'].'" type="text" style="width:70px" value="'.$composeinfo['re_feature_price'].'"/></div>
																	<div class="list_quantity"><input id="re_feature_quantity_'.$checkedcolorlist[$i]['feature_id'].'_'.$checkedsizelist[$j]['feature_id'].'_'.$checkedzdyonelist[$k]['feature_id'].'" name="re_feature_quantity_'.$checkedcolorlist[$i]['feature_id'].'_'.$checkedsizelist[$j]['feature_id'].'_'.$checkedzdyonelist[$k]['feature_id'].'" type="text" style="width:60px" value="'.$composeinfo['re_feature_quantity'].'"/></div>
																	<div class="list_merchantcoding"><input id="re_feature_businessnumber_'.$checkedcolorlist[$i]['feature_id'].'_'.$checkedsizelist[$j]['feature_id'].'_'.$checkedzdyonelist[$k]['feature_id'].'" name="re_feature_businessnumber_'.$checkedcolorlist[$i]['feature_id'].'_'.$checkedsizelist[$j]['feature_id'].'_'.$checkedzdyonelist[$k]['feature_id'].'" type="text" style="width:90px" value="'.$composeinfo['re_feature_businessnumber'].'"/></div>
																	<div class="list_barcode"><input id="re_feature_eancode_'.$checkedcolorlist[$i]['feature_id'].'_'.$checkedsizelist[$j]['feature_id'].'_'.$checkedzdyonelist[$k]['feature_id'].'" name="re_feature_eancode_'.$checkedcolorlist[$i]['feature_id'].'_'.$checkedsizelist[$j]['feature_id'].'_'.$checkedzdyonelist[$k]['feature_id'].'" type="text" style="width:90px" value="'.$composeinfo['re_feature_eancode'].'" /></div>
																</div>
															';
														}
													}
													$text_b .='</div>';
													$text_third='
														<div id="product_colorsizeprice_tr_'.$checkedcolorlist[$i]['feature_id'].'_'.$checkedsizelist[$j]['feature_id'].'" style="float:left;width:100%;">
															<table cellspacing=0 cellpadding=0 border=0 style="float:left;">
																<tr>
																	<td width="150" style="border-left:1px solid #D7D7D7;border-bottom:1px solid #D7D7D7;">'.$text_a.'</td>
																	<td width="526">'.$text_b.'</td>
																</tr>
															</table>
														</div>
													';
													
													
													$text_2=$text_2.$text_third.'
													';
												}
											}
											$text_2=$text_2.'</div>';
												echo '
													<div id="product_colorprice_tr_'.$checkedcolorlist[$i]['feature_id'].'" style="float:left;width:100%;">
														<table cellspacing=0 cellpadding=0 border=0 style="float:left;">
															<tr>
																<td width="90" style="border-left: 1px solid #D7D7D7;border-bottom: 1px solid #D7D7D7;">'.$text_1.'</td>
																<td width="676">'.$text_2.'</td>
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
	function toselectmuban(muban_id){
		$.post(baseurl+'admins/product/tochoosemuban/<?php echo $productinfo['product_id']?>/'+muban_id,function (data){
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
		//判断zdyone
		var zdyonearr=$('input[name="zdyonecheckbox[]"]');
		var checkedzdyonearr=[];
		if(zdyonearr.length>0){
			for(var i=0;i<zdyonearr.length;i++){
				if(zdyonearr[i].checked==true){
					checkedzdyonearr.push(zdyonearr[i].value);
				}
			}
		}
		if($('#colorcheckbox_'+color_id).attr('checked')=='checked'){
			if(checkedsizearr.length>0){

				var text_1='<div class="list_color"><label class="product_colorprice_boxbg" style="'+$('#colorbg_'+color_id).val()+'">&nbsp;</label><label id="re_colorprice_inputname_'+color_id+'" style="float:left;margin:2px 0px 0px 4px;">'+$('#colornametext_'+color_id).html()+'</label></div>';
				var text_2='<div class="product_allsecondprice_'+color_id+'" style="float:left;width:100%;">';
				var text_3='<div class="list_pic"><div class="img_gksel_show" id="imgcolor'+color_id+'_gksel_show"></div><div id="imgcolor'+color_id+'_gksel_choose" class="img_gksel_choose" style="margin-left:10px;">选择图片</div><div class="tabmes_l"><input type="hidden" id="imgcolor'+color_id+'_gksel" name="imgcolor'+color_id+'_gksel" value=""/></div><div class="tabmes_l"><font class="fonterror" id="imgcolor'+color_id+'_gksel_error"></font></div></div>';
				
				if(checkedsizearr.length>0){
					for(var j=0;j<checkedsizearr.length;j++){
						var text_a='<div class="list_size list_size_'+checkedsizearr[j]+'" style="border-bottom:0px solid red;border-left:0px solid red;border-right:0px solid red;">'+$('#sizenameinput_'+checkedsizearr[j]).val()+'</div>';
						var text_b='<div id="product_allthirdprice_'+color_id+'_'+checkedsizearr[j]+'" style="float:left;width:100%;">';
						if(checkedzdyonearr.length>0){
							for(var k=0;k<checkedzdyonearr.length;k++){
								text_b=text_b+'<div id="product_zdyoneprice_tr_'+color_id+'_'+checkedsizearr[j]+'_'+checkedzdyonearr[k]+'" style="float:left;width:100%;">';
								text_b=text_b+'<div class="list_zdyone list_zdyone_'+checkedzdyonearr[k]+'"">'+$('#zdyonenameinput_'+checkedzdyonearr[k]).val()+'</div>';
								text_b=text_b+'<div class="list_price"><input id="re_feature_price_'+color_id+'_'+checkedsizearr[j]+'_'+checkedzdyonearr[k]+'" name="re_feature_price_'+color_id+'_'+checkedsizearr[j]+'_'+checkedzdyonearr[k]+'" type="text" style="width:70px" value=""/></div>';
								text_b=text_b+'<div class="list_quantity"><input id="re_feature_quantity_'+color_id+'_'+checkedsizearr[j]+'_'+checkedzdyonearr[k]+'" name="re_feature_quantity_'+color_id+'_'+checkedsizearr[j]+'_'+checkedzdyonearr[k]+'" type="text" style="width:60px" value=""/></div>';
								text_b=text_b+'<div class="list_merchantcoding"><input id="re_feature_businessnumber_'+color_id+'_'+checkedsizearr[j]+'_'+checkedzdyonearr[k]+'" name="re_feature_businessnumber_'+color_id+'_'+checkedsizearr[j]+'_'+checkedzdyonearr[k]+'" type="text" style="width:90px" value=""/></div>';
								text_b=text_b+'<div class="list_barcode"><input id="re_feature_eancode_'+color_id+'_'+checkedsizearr[j]+'_'+checkedzdyonearr[k]+'" name="re_feature_eancode_'+color_id+'_'+checkedsizearr[j]+'_'+checkedzdyonearr[k]+'" type="text" style="width:90px" value="" /></div>';
								text_b=text_b+'</div>';
							}
						}
						text_b=text_b+'</div>';
						var text_third='<div id="product_colorsizeprice_tr_'+color_id+'_'+checkedsizearr[j]+'" style="float:left;width:100%;">';
						text_third=text_third+'<div id="product_colorsizeprice_tr_'+color_id+'_'+checkedsizearr[j]+'" style="float:left;width:100%;">';
						text_third=text_third+'<table cellspacing=0 cellpadding=0 border=0 style="float:left;">';
						text_third=text_third+'<tr>';
						text_third=text_third+'<td width="150" style="border-left:1px solid #D7D7D7;border-bottom:1px solid #D7D7D7;">'+text_a+'</td>';
						text_third=text_third+'<td width="526">'+text_b+'</td>';
						text_third=text_third+'</tr>';
						text_third=text_third+'</table>';
						text_third=text_third+'</div>';
						
						
						text_2=text_2+text_third;
					}
				}
				text_2=text_2+'</div>';



				var combinecontent='<div id="product_colorprice_tr_'+color_id+'" style="float:left;width:100%;">';
				combinecontent=combinecontent+'<table cellspacing=0 cellpadding=0 border=0 style="float:left;">';
				combinecontent=combinecontent+'<tr>';
				combinecontent=combinecontent+'<td width="90" style="border-left: 1px solid #D7D7D7;border-bottom: 1px solid #D7D7D7;">'+text_1+'</td>';
				combinecontent=combinecontent+'<td width="676">'+text_2+'</td>';
				combinecontent=combinecontent+'<td width="100" style="border-left: 1px solid #D7D7D7;border-bottom: 1px solid #D7D7D7;border-right: 1px solid #D7D7D7;">'+text_3+'</td>';
				combinecontent=combinecontent+'</tr>';
				combinecontent=combinecontent+'</table>';
				combinecontent=combinecontent+'</div>';

				$('#product_colorprice_tbody').append(combinecontent);

				$('#colornameinput_'+color_id).parent().show();
				$('#colornametext_'+color_id).hide();
				//增加图片上传的js
				$.post(baseurl+'admins/product/toaddpicuploadingjs/'+color_id,function (data){
					$('#section_2colorjs').html(data);
				})
			}else{
				//此时没有选择大小

				var text_1='<div class="list_color"><label class="product_colorprice_boxbg" style="'+$('#colorbg_'+color_id).val()+'">&nbsp;</label><label id="re_colorprice_inputname_'+color_id+'" style="float:left;margin:2px 0px 0px 4px;">'+$('#colornametext_'+color_id).html()+'</label></div>';
				var text_2='<div class="product_allsecondprice_'+color_id+'" style="float:left;width:100%;">';
				var text_3='<div class="list_pic"><div class="img_gksel_show" id="imgcolor'+color_id+'_gksel_show"></div><div id="imgcolor'+color_id+'_gksel_choose" class="img_gksel_choose" style="margin-left:10px;">选择图片</div><div class="tabmes_l"><input type="hidden" id="imgcolor'+color_id+'_gksel" name="imgcolor'+color_id+'_gksel" value=""/></div><div class="tabmes_l"><font class="fonterror" id="imgcolor'+color_id+'_gksel_error"></font></div></div>';
				text_2=text_2+'</div>';
				$('#product_colorprice_tbody').append('<div id="product_colorprice_tr_'+color_id+'" style="float:left;width:100%;"><table cellspacing=0 cellpadding=0 style="float:left;"><tr><td width="90" style="border-left: 1px solid #D7D7D7;border-bottom: 1px solid #D7D7D7;">'+text_1+'</td><td width="676">'+text_2+'</td><td width="100" style="border-left: 1px solid #D7D7D7;border-bottom: 1px solid #D7D7D7;border-right: 1px solid #D7D7D7;">'+text_3+'</td></tr></table></div>');
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
		//判断zdyone
		var zdyonearr=$('input[name="zdyonecheckbox[]"]');
		var checkedzdyonearr=[];
		if(zdyonearr.length>0){
			for(var i=0;i<zdyonearr.length;i++){
				if(zdyonearr[i].checked==true){
					checkedzdyonearr.push(zdyonearr[i].value);
				}
			}
		}
		if($('#sizecheckbox_'+size_id).attr('checked')=='checked'){
			if(checkedcolorarr.length>0){
				for(var i=0;i<checkedcolorarr.length;i++){
					var text_2='';

					var text_a='<div class="list_size list_size_'+size_id+'" style="border-bottom:0px solid red;border-left:0px solid red;border-right:0px solid red;">'+$('#sizenameinput_'+size_id).val()+'</div>';
					var text_b='<div id="product_allthirdprice_'+checkedcolorarr[i]+'_'+size_id+'" style="float:left;width:100%;">';
					if(checkedzdyonearr.length>0){
						for(var k=0;k<checkedzdyonearr.length;k++){
							text_b=text_b+'<div id="product_zdyoneprice_tr_'+checkedcolorarr[i]+'_'+size_id+'_'+checkedzdyonearr[k]+'" style="float:left;width:100%;">';
							text_b=text_b+'<div class="list_zdyone list_zdyone_'+checkedzdyonearr[k]+'"">'+$('#zdyonenameinput_'+checkedzdyonearr[k]).val()+'</div>';
							text_b=text_b+'<div class="list_price"><input id="re_feature_price_'+checkedcolorarr[i]+'_'+size_id+'_'+checkedzdyonearr[k]+'" name="re_feature_price_'+checkedcolorarr[i]+'_'+size_id+'_'+checkedzdyonearr[k]+'" type="text" style="width:70px" value=""/></div>';
							text_b=text_b+'<div class="list_quantity"><input id="re_feature_quantity_'+checkedcolorarr[i]+'_'+size_id+'_'+checkedzdyonearr[k]+'" name="re_feature_quantity_'+checkedcolorarr[i]+'_'+size_id+'_'+checkedzdyonearr[k]+'" type="text" style="width:60px" value=""/></div>';
							text_b=text_b+'<div class="list_merchantcoding"><input id="re_feature_businessnumber_'+checkedcolorarr[i]+'_'+size_id+'_'+checkedzdyonearr[k]+'" name="re_feature_businessnumber_'+checkedcolorarr[i]+'_'+size_id+'_'+checkedzdyonearr[k]+'" type="text" style="width:90px" value=""/></div>';
							text_b=text_b+'<div class="list_barcode"><input id="re_feature_eancode_'+checkedcolorarr[i]+'_'+size_id+'_'+checkedzdyonearr[k]+'" name="re_feature_eancode_'+checkedcolorarr[i]+'_'+size_id+'_'+checkedzdyonearr[k]+'" type="text" style="width:90px" value="" /></div>';
							text_b=text_b+'</div>';
						}
					}
					text_b=text_b+'</div>';

					
					var text_third='<div id="product_colorsizeprice_tr_'+checkedcolorarr[i]+'_'+size_id+'" style="float:left;width:100%;">';
					text_third=text_third+'<table cellspacing=0 cellpadding=0 border=0 style="float:left;">';
					text_third=text_third+'<tr>';
					text_third=text_third+'<td width="150" style="border-left:1px solid #D7D7D7;border-bottom:1px solid #D7D7D7;">'+text_a+'</td>';
					text_third=text_third+'<td width="526">'+text_b+'</td>';
					text_third=text_third+'</tr>';
					text_third=text_third+'</table>';
					text_third=text_third+'</div>';

					text_2=text_2+text_third;
					$('.product_allsecondprice_'+checkedcolorarr[i]).append(text_2);
				}
				$('#sizenameinput_'+size_id).parent().show();
				$('#sizenametext_'+size_id).hide();
			}else{
				alert('请选择颜色');
			}
		}else{
			if(checkedcolorarr.length>0){
				for(var i=0;i<checkedcolorarr.length;i++){
					$('#product_colorsizeprice_tr_'+checkedcolorarr[i]+'_'+size_id).remove();
				}
			}
			$('#sizenameinput_'+size_id).parent().hide();
			$('#sizenametext_'+size_id).show();
		}
		tocheckcomposeisshow();//判断配置选择是否显示
	}

	function tooption_zdyone(zdyone_id){
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
		if($('#zdyonecheckbox_'+zdyone_id).attr('checked')=='checked'){
			if(checkedcolorarr.length>0&&checkedsizearr.length>0){
				for(var i=0;i<checkedcolorarr.length;i++){
					if(checkedsizearr.length>0){
						for(var j=0;j<checkedsizearr.length;j++){
							var text_b='<div id="product_zdyoneprice_tr_'+checkedcolorarr[i]+'_'+checkedsizearr[j]+'_'+zdyone_id+'" style="float:left;width:100%;">';
							text_b=text_b+'<div class="list_zdyone">'+$('#zdyonenameinput_'+zdyone_id).val()+'</div>';
							text_b=text_b+'<div class="list_price"><input id="re_feature_price_'+checkedcolorarr[i]+'_'+checkedsizearr[j]+'_'+zdyone_id+'" name="re_feature_price_'+checkedcolorarr[i]+'_'+checkedsizearr[j]+'_'+zdyone_id+'" type="text" style="width:70px" value=""/></div>';
							text_b=text_b+'<div class="list_quantity"><input id="re_feature_quantity_'+checkedcolorarr[i]+'_'+checkedsizearr[j]+'_'+zdyone_id+'" name="re_feature_quantity_'+checkedcolorarr[i]+'_'+checkedsizearr[j]+'_'+zdyone_id+'" type="text" style="width:60px" value=""/></div>';
							text_b=text_b+'<div class="list_merchantcoding"><input id="re_feature_businessnumber_'+checkedcolorarr[i]+'_'+checkedsizearr[j]+'_'+zdyone_id+'" name="re_feature_businessnumber_'+checkedcolorarr[i]+'_'+checkedsizearr[j]+'_'+zdyone_id+'" type="text" style="width:90px" value=""/></div>';
							text_b=text_b+'<div class="list_barcode"><input id="re_feature_eancode_'+checkedcolorarr[i]+'_'+checkedsizearr[j]+'_'+zdyone_id+'" name="re_feature_eancode_'+checkedcolorarr[i]+'_'+checkedsizearr[j]+'_'+zdyone_id+'" type="text" style="width:90px" value="" /></div>';
							text_b=text_b+'</div>';
							$('#product_allthirdprice_'+checkedcolorarr[i]+'_'+checkedsizearr[j]).append(text_b);
						}
					}
				}
				$('#zdyonenameinput_'+zdyone_id).parent().show();
				$('#zdyonenametext_'+zdyone_id).hide();
			}else{
				alert('请选择自定义属性');
			}
		}else{
			if(checkedcolorarr.length>0){
				for(var i=0;i<checkedcolorarr.length;i++){
					for(var j=0;j<checkedsizearr.length;j++){
						$('#product_zdyoneprice_tr_'+checkedcolorarr[i]+'_'+checkedsizearr[j]+'_'+zdyone_id).remove();
					}
				}
			}
			$('#zdyonenameinput_'+zdyone_id).parent().hide();
			$('#zdyonenametext_'+zdyone_id).show();
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
		var ispass_3=0;
		$('.zdyonecheckbox').each(function (){
			if($(this).attr('checked')=='checked'){
				ispass_3=1;
			}
		})
		if(ispass_3==1){
			//可以修改自定义属性1的名称
			$('input[name="feature_category_name_ch_36"]').parent().show();
			$('#feature_category_name_ch_text_36').hide();
		}else{
			$('input[name="feature_category_name_ch_36"]').parent().hide();
			$('#feature_category_name_ch_text_36').show();
		}
		
		
		
		if(ispass_1==1&&ispass_2==1&&ispass_3==1){
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
	$('input[name="feature_category_name_ch_26"]').keyup(function (){
		if($(this).val()!=""){
			$('.title_size').html($(this).val());
		}else{
			$('.title_size').html('&nbsp;');
		}
	})
	$('.sizenameinput').keyup(function (){
		var sizenameinputid=$(this).attr('id');
		var sizenameinputidsplit=sizenameinputid.split('_');
		$('.list_size_'+sizenameinputidsplit[1]).html($(this).val());
	})
	
	
	//修改zdyone 标题
	$('input[name="feature_category_name_ch_36"]').keyup(function (){
		if($(this).val()!=""){
			$('.title_zdyone').html($(this).val());
		}else{
			$('.title_zdyone').html('&nbsp;');
		}
	})
	//修改zdyone名称
	$('.zdyonenameinput').keyup(function (){
		var zdyonenameinputid=$(this).attr('id');
		var zdyonenameinputidsplit=zdyonenameinputid.split('_');
		$('.list_zdyone_'+zdyonenameinputidsplit[1]).html($(this).val());
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