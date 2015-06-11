<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MZ星球</title>
<script  language="JavaScript" type="text/javascript">
<!--
	var baseurl='<?php echo base_url()?>';
	var currenturl='<?php echo base_url()?>index.php/admins/setting/toedit_parameter';
	var themes='default/';
//-->
</script>
<script type='text/javascript' src='<?php echo base_url()?>js/jquery-1.7.2.min.js'></script>
<script type='text/javascript' src='<?php echo base_url()?>js/fileuploader.js'></script>
<script type="text/javascript" src="<?php echo base_url()?>js/admin/admin.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>themes/default/admin.css" />

<style type="text/css">
html,body{
	overflow-x:hidden;overflow-y:auto;
}
</style>

</head>
<body>
<?php 
	$langarr=languagelist();
?>
<div style="float:left;width:100%;font-size:12px;line-height:25px;">
	<a href="<?php echo site_url('admins/setting/toedit_parameter')?>">分类列表(<?php echo $categoryinfo['category_name'.$this->langtype];?>) </a>
	&gt;&gt; 子分类列表
</div>
<div style="float:left;width:100%;">
<table cellspacing=0  cellpadding=0 width="100%" style="line-height:22px;">
	<tr>
		<td>
			<table cellspacing=1 cellpadding=0 class="list_table">
				<tr>
					<th width="80"></th>
					<th>列表</th>
				</tr>
			<?php if(isset($subcategorylist)){for($i=0;$i<count($subcategorylist);$i++){?>
				<tr>
					<td>
						<?php echo '<a href="'.site_url('admins/setting/toedit_articleparameter/'.$categoryinfo['category_id'].'/'.$subcategorylist[$i]['category_id']).'">'.$subcategorylist[$i]['category_name'.$this->langtype].'</a>'?>
						<?php $id=$subcategorylist[$i]['category_id']?>
					</td>
					<td>
						<form action="<?php echo site_url('admins/setting/edit_subcategoryparameter/'.$categoryinfo['category_id'].'/'.$id)?>" method="post">
						<table cellspacing=0 cellpadding=0 style="float:left;width:100%;">
							<tr>
								<td valign="top">
										<?php 
											${'orderby'}='';
											${'orderby_res'}='';
											
											$sectionandname=array();//模块和名称
											$sectionandname[]=array('code'=>'name','name'=>'标题');
											$sectionandname[]=array('code'=>'add','name'=>'添加');
											$sectionandname[]=array('code'=>'edit','name'=>'修改');
											
											
											for($la=0;$la<count($langarr);$la++){//多语言
												for($sn=0;$sn<count($sectionandname);$sn++){
													${$sectionandname[$sn]['code'].$langarr[$la]['langtype']}='';
												}
											}
											for($tt=1;$tt<=5;$tt++){
												for($la=0;$la<count($langarr);$la++){//多语言
													${'nolaninput_'.$tt.$langarr[$la]['langtype']}='';
													${'laninput_'.$tt.$langarr[$la]['langtype']}='';
													${'nolantextarea_'.$tt.$langarr[$la]['langtype']}='';
													${'lantextarea_'.$tt.$langarr[$la]['langtype']}='';
													${'pic_'.$tt.$langarr[$la]['langtype']}='';
													${'manage_'.$tt.$langarr[$la]['langtype']}='';
												}
											}
											$con=array('name','created','edited','author','orderby','add','edit','del','muldel');
											for($tt=1;$tt<=5;$tt++){
												$con[]='pic_'.$tt;
												$con[]='nolaninput_'.$tt;
												$con[]='laninput_'.$tt;
												$con[]='nolantextarea_'.$tt;
												$con[]='lantextarea_'.$tt;
												$con[]='selection_'.$tt;
												$con[]='checkboxion_'.$tt;
												$con[]='manage_'.$tt;
											}
											
											$parameter=$subcategorylist[$i]['parameter_list'];
											$parameter=explode('-',$parameter);
											
											if(!empty($parameter)){
												for($b=0;$b<count($con);$b++){
													${'is_'.$con[$b]}=0;
												}
												for($a=0;$a<count($parameter);$a++){
													for($b=0;$b<count($con);$b++){
														if($parameter[$a]==$con[$b]){
															${'is_'.$con[$b]}=1;
															for($tt=1;$tt<=5;$tt++){
																//关于图片
																if($con[$b]=='pic_'.$tt){
																	for($la=0;$la<count($langarr);$la++){//多语言
																		${'pic_'.$tt.$langarr[$la]['langtype'].'_res'}=$parameter[$a+($la+1)];
																		${'pic_'.$tt.$langarr[$la]['langtype'].'_res'}=explode('_',${'pic_'.$tt.$langarr[$la]['langtype'].'_res'});
																		if(count(${'pic_'.$tt.$langarr[$la]['langtype'].'_res'})==4){
																			if(${'pic_'.$tt.$langarr[$la]['langtype'].'_res'}[0].'_'.${'pic_'.$tt.$langarr[$la]['langtype'].'_res'}[1].'_'.${'pic_'.$tt.$langarr[$la]['langtype'].'_res'}[2]=='pic_'.$tt.$langarr[$la]['langtype']){
																				${'pic_'.$tt.$langarr[$la]['langtype']}=${'pic_'.$tt.$langarr[$la]['langtype'].'_res'}[3];
																			}
																		}
																	}
																}
															}
															//排序
															if($con[$b]=='orderby'){
																${'orderby_res'}=$parameter[$a+1];
																${'orderby_res'}=explode('_',${'orderby_res'});
																${'orderby'}=${'orderby_res'}[1];
																
																${'orderby_res_res'}=$parameter[$a+2];
																${'orderby_res_res'}=explode('_',${'orderby_res_res'});
																${'orderby_res'}=${'orderby_res_res'}[2];
															}
														
															//模块和名称
															for($sn=0;$sn<count($sectionandname);$sn++){
																if($con[$b]==$sectionandname[$sn]['code']){
																	for($la=0;$la<count($langarr);$la++){//多语言
																		if(isset($parameter[$a+($la+1)])){
																			${$sectionandname[$sn]['code'].$langarr[$la]['langtype'].'_res'}=$parameter[$a+($la+1)];
																			${$sectionandname[$sn]['code'].$langarr[$la]['langtype'].'_res'}=explode('_',${$sectionandname[$sn]['code'].$langarr[$la]['langtype'].'_res'});
																			if(count(${$sectionandname[$sn]['code'].$langarr[$la]['langtype'].'_res'})==3){
																				if(${$sectionandname[$sn]['code'].$langarr[$la]['langtype'].'_res'}[0].'_'.${$sectionandname[$sn]['code'].$langarr[$la]['langtype'].'_res'}[1]==$sectionandname[$sn]['code'].$langarr[$la]['langtype']){
																					${$sectionandname[$sn]['code'].$langarr[$la]['langtype']}=${$sectionandname[$sn]['code'].$langarr[$la]['langtype'].'_res'}[2];
																				}
																			}
																		}
																	}
																}
															}
															//管理
															for($tt=1;$tt<=5;$tt++){
																if($con[$b]=='manage_'.$tt){
																	for($la=0;$la<count($langarr);$la++){//多语言
																		if(isset($parameter[$a+($la+1)])){
																			${'manage_'.$tt.$langarr[$la]['langtype'].'_res'}=$parameter[$a+($la+1)];
																			${'manage_'.$tt.$langarr[$la]['langtype'].'_res'}=explode('_',${'manage_'.$tt.$langarr[$la]['langtype'].'_res'});
																			
																			if(count(${'manage_'.$tt.$langarr[$la]['langtype'].'_res'})==4){
																				if(${'manage_'.$tt.$langarr[$la]['langtype'].'_res'}[0].'_'.${'manage_'.$tt.$langarr[$la]['langtype'].'_res'}[1].'_'.${'manage_'.$tt.$langarr[$la]['langtype'].'_res'}[2]=='manage_'.$tt.$langarr[$la]['langtype']){
																					${'manage_'.$tt.$langarr[$la]['langtype']}=${'manage_'.$tt.$langarr[$la]['langtype'].'_res'}[3];
																				}
																			}
																		}
																	}
																}
															}
															//没有多语言的 其他input
															for($tt=1;$tt<=5;$tt++){
																if($con[$b]=='nolaninput_'.$tt){
																	for($la=0;$la<count($langarr);$la++){//多语言
																		if(isset($parameter[$a+($la+1)])){
																			${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'}=$parameter[$a+($la+1)];
																			${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'}=explode('_',${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'});
																			if(count(${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'})==4){
																				if(${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'}[0].'_'.${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'}[1].'_'.${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'}[2]=='nolaninput_'.$tt.$langarr[$la]['langtype']){
																					${'nolaninput_'.$tt.$langarr[$la]['langtype']}=${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'}[3];
																				}
																			}
																		}
																	}
																}
															}
															//有多语言的 Input
															for($tt=1;$tt<=5;$tt++){
																if($con[$b]=='laninput_'.$tt){
																	for($la=0;$la<count($langarr);$la++){//多语言
																		if(isset($parameter[$a+($la+1)])){
																			${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'}=$parameter[$a+($la+1)];
																			${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'}=explode('_',${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'});
																			if(count(${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'})==4){
																				if(${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'}[0].'_'.${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'}[1].'_'.${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'}[2]=='laninput_'.$tt.$langarr[$la]['langtype']){
																					${'laninput_'.$tt.$langarr[$la]['langtype']}=${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'}[3];
																				}
																			}
																		}
																	}
																}
															}
															//没有多语言的 Textarea
															for($tt=1;$tt<=5;$tt++){
																if($con[$b]=='nolantextarea_'.$tt){
																	for($la=0;$la<count($langarr);$la++){//多语言
																		if(isset($parameter[$a+($la+1)])){
																			${'nolantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}=$parameter[$a+($la+1)];
																			${'nolantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}=explode('_',${'nolantextarea_'.$tt.$langarr[$la]['langtype'].'_res'});
																			if(count(${'nolantextarea_'.$tt.$langarr[$la]['langtype'].'_res'})==4){
																				if(${'nolantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}[0].'_'.${'nolantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}[1].'_'.${'nolantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}[2]=='nolantextarea_'.$tt.$langarr[$la]['langtype']){
																					${'nolantextarea_'.$tt.$langarr[$la]['langtype']}=${'nolantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}[3];
																				}
																			}
																		}
																	}
																}
															}
															//有多语言的 Textarea
															for($tt=1;$tt<=5;$tt++){
																if($con[$b]=='lantextarea_'.$tt){
																	for($la=0;$la<count($langarr);$la++){//多语言
																		if(isset($parameter[$a+($la+1)])){
																			${'lantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}=$parameter[$a+($la+1)];
																			${'lantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}=explode('_',${'lantextarea_'.$tt.$langarr[$la]['langtype'].'_res'});
																			if(count(${'lantextarea_'.$tt.$langarr[$la]['langtype'].'_res'})==4){
																				if(${'lantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}[0].'_'.${'lantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}[1].'_'.${'lantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}[2]=='lantextarea_'.$tt.$langarr[$la]['langtype']){
																					${'lantextarea_'.$tt.$langarr[$la]['langtype']}=${'lantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}[3];
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
											}
										?>
										
										
										
											<div style="float:left;width:100%;">
												<div style="float:left;margin:6px 0px 0px 0px;">
													<input onclick="toactionparameter_list('<?php echo $id;?>list_orderby')" type="checkbox" name="<?php echo $id;?>list_orderby" id="<?php echo $id;?>list_orderby" value="orderby" <?php if(${'is_orderby'}==1){echo 'checked';}?>/> <label for="<?php echo $id;?>list_orderby">排序</label> 
												</div>
												<div id="<?php echo $id;?>list_orderby_area" style="float:left;<?php if(${'is_orderby'}==1){echo 'display:block;';}else{echo 'display:none;';}?>">
													&nbsp;&nbsp;:&nbsp;&nbsp;
													根据 <select name="<?php echo $id;?>list_orderby"><option value="created" <?php if(${'orderby'}=='created'){echo 'selected';}?>>创建时间</option><option value="move" <?php if(${'orderby'}=='move'){echo 'selected';}?>>自定义拖动排序</option><option value="sort" <?php if(${'orderby'}=='sort'){echo 'selected';}?>>自定义输入排序</option></select> 
													方式 <select name="<?php echo $id;?>list_orderby_res"><option value="ASC" <?php if(${'orderby_res'}=='ASC'){echo 'selected';}?>>正序</option><option value="DESC" <?php if(${'orderby_res'}=='DESC'){echo 'selected';}?>>倒排</option></select> 
												</div>
											</div>
											<div style="float:left;width:100%;">
												<div style="float:left;margin:6px 0px 0px 0px;">
													<input onclick="toactionparameter_list('<?php echo $id;?>list_created')" type="checkbox" name="<?php echo $id;?>list_created" id="<?php echo $id;?>list_created" value="created" <?php if(${'is_created'}==1){echo 'checked';}?>/> <label for="<?php echo $id;?>list_created">创建时间</label> 
												</div>
												<div style="float:left;margin:6px 0px 0px 0px;">
													<input onclick="toactionparameter_list('<?php echo $id;?>list_edited')" type="checkbox" name="<?php echo $id;?>list_edited" id="<?php echo $id;?>list_edited" value="edited" <?php if(${'is_edited'}==1){echo 'checked';}?>/> <label for="<?php echo $id;?>list_edited">修改时间</label> 
												</div>
												<div style="float:left;margin:6px 0px 0px 0px;">
													<input onclick="toactionparameter_list('<?php echo $id;?>list_author')" type="checkbox" name="<?php echo $id;?>list_author" id="<?php echo $id;?>list_author" value="author" <?php if(${'is_author'}==1){echo 'checked';}?>/> <label for="<?php echo $id;?>list_author">作者</label> 
												</div>
												<div style="float:left;margin:6px 0px 0px 0px;">
													<input onclick="toactionparameter_list('<?php echo $id;?>list_del')" type="checkbox" name="<?php echo $id;?>list_del" id="<?php echo $id;?>list_del" value="del" <?php if(${'is_del'}==1){echo 'checked';}?>/> <label for="<?php echo $id;?>list_del">删除</label> 
												</div>
												<div style="float:left;margin:6px 0px 0px 0px;">
													<input onclick="toactionparameter_list('<?php echo $id;?>list_muldel')" type="checkbox" name="<?php echo $id;?>list_muldel" id="<?php echo $id;?>list_muldel" value="muldel" <?php if(${'is_muldel'}==1){echo 'checked';}?>/> <label for="<?php echo $id;?>list_muldel">批量删除</label> 
												</div>
											</div>
											<div style="float:left;width:100%;">
												<div style="float:left;margin:6px 0px 0px 0px;">
													<input onclick="toactionparameter_list('<?php echo $id;?>list_selection_1')" type="checkbox" name="<?php echo $id;?>list_selection_1" id="<?php echo $id;?>list_selection_1" value="selection_1" <?php if(${'is_selection_1'}==1){echo 'checked';}?>/> <label for="<?php echo $id;?>list_selection_1">第一选择</label> 
												</div>
												<div style="float:left;margin:6px 0px 0px 0px;">
													<input onclick="toactionparameter_list('<?php echo $id;?>list_selection_2')" type="checkbox" name="<?php echo $id;?>list_selection_2" id="<?php echo $id;?>list_selection_2" value="selection_2" <?php if(${'is_selection_2'}==1){echo 'checked';}?>/> <label for="<?php echo $id;?>list_selection_2">第二选择</label> 
												</div>
												<div style="float:left;margin:6px 0px 0px 0px;">
													<input onclick="toactionparameter_list('<?php echo $id;?>list_selection_3')" type="checkbox" name="<?php echo $id;?>list_selection_3" id="<?php echo $id;?>list_selection_3" value="selection_3" <?php if(${'is_selection_3'}==1){echo 'checked';}?>/> <label for="<?php echo $id;?>list_selection_3">第三选择</label> 
												</div>
											</div>
											<div style="float:left;width:100%;">
												<div style="float:left;margin:6px 0px 0px 0px;">
													<input onclick="toactionparameter_list('<?php echo $id;?>list_checkboxion_1')" type="checkbox" name="<?php echo $id;?>list_checkboxion_1" id="<?php echo $id;?>list_checkboxion_1" value="checkboxion_1" <?php if(${'is_checkboxion_1'}==1){echo 'checked';}?>/> <label for="<?php echo $id;?>list_checkboxion_1">第一多选</label> 
												</div>
												<div style="float:left;margin:6px 0px 0px 0px;">
													<input onclick="toactionparameter_list('<?php echo $id;?>list_checkboxion_2')" type="checkbox" name="<?php echo $id;?>list_checkboxion_2" id="<?php echo $id;?>list_checkboxion_2" value="checkboxion_2" <?php if(${'is_checkboxion_2'}==1){echo 'checked';}?>/> <label for="<?php echo $id;?>list_checkboxion_2">第二多选</label> 
												</div>
												<div style="float:left;margin:6px 0px 0px 0px;">
													<input onclick="toactionparameter_list('<?php echo $id;?>list_checkboxion_3')" type="checkbox" name="<?php echo $id;?>list_checkboxion_3" id="<?php echo $id;?>list_checkboxion_3" value="checkboxion_3" <?php if(${'is_checkboxion_3'}==1){echo 'checked';}?>/> <label for="<?php echo $id;?>list_checkboxion_3">第三多选</label> 
												</div>
											</div>
<!--										//管理1-->
											<div style="float:left;width:100%;line-height:1px;border-bottom:1px dashed gray;margin:2px 0px 2px 0px;">&nbsp;</div>
											<div style="float:left;width:100%;">
												<div style="float:left;margin:6px 0px 0px 0px;">
													<input onclick="toactionparameter_list('<?php echo $id;?>list_manage_1')" type="checkbox" name="<?php echo $id;?>list_manage_1" id="<?php echo $id;?>list_manage_1" value="manage_1" <?php if(${'is_manage_1'}==1){echo 'checked';}?>/> <label for="<?php echo $id;?>list_manage_1">管理1</label> 
												</div>
												<div id="<?php echo $id;?>list_manage_1_area" style="float:left;<?php if(${'is_manage_1'}==1){echo 'display:block;';}else{echo 'display:none;';}?>">
													&nbsp;&nbsp;:&nbsp;&nbsp; 
													<?php for($la=0;$la<count($langarr);$la++){//多语言?>
														<?php echo $langarr[$la]['lang_name'.$langarr[$la]['langtype']]?> <input name="<?php echo $id;?>list_manage_1<?php echo $langarr[$la]['langtype']?>" type="text" value="<?php echo ${'manage_1'.$langarr[$la]['langtype']}?>" style="width:60px;"/>
													<?php }?>
												</div>
											</div>
											
<!--										//模块和名称-->
											<?php for($sn=0;$sn<count($sectionandname);$sn++){?>
												<div style="float:left;width:100%;line-height:1px;border-bottom:1px dashed gray;margin:2px 0px 2px 0px;">&nbsp;</div>
												<div style="float:left;width:100%;">
													<div style="float:left;margin:6px 0px 0px 0px;">
														<input onclick="toactionparameter_list('<?php echo $id;?>list_<?php echo $sectionandname[$sn]['code']?>')" type="checkbox" name="<?php echo $id;?>list_<?php echo $sectionandname[$sn]['code']?>" id="<?php echo $id;?>list_<?php echo $sectionandname[$sn]['code']?>" value="<?php echo $sectionandname[$sn]['code']?>" <?php if(${'is_'.$sectionandname[$sn]['code']}==1){echo 'checked';}?>/> <label for="<?php echo $id;?>list_<?php echo $sectionandname[$sn]['code']?>"><?php echo $sectionandname[$sn]['name']?></label> 
													</div>
													<div id="<?php echo $id;?>list_<?php echo $sectionandname[$sn]['code']?>_area" style="float:left;<?php if(${'is_'.$sectionandname[$sn]['code']}==1){echo 'display:block;';}else{echo 'display:none;';}?>">
														&nbsp;&nbsp;:&nbsp;&nbsp; 
														<?php for($la=0;$la<count($langarr);$la++){//多语言?>
															<?php echo $langarr[$la]['lang_name'.$langarr[$la]['langtype']]?> <input name="<?php echo $id;?>list_<?php echo $sectionandname[$sn]['code']?><?php echo $langarr[$la]['langtype']?>" type="text" value="<?php echo ${$sectionandname[$sn]['code'].$langarr[$la]['langtype']}?>" style="width:60px;"/>
														<?php }?>
													</div>
												</div>
											<?php }?>
											
											
											<div style="float:left;width:100%;line-height:1px;border-bottom:1px dashed gray;margin:2px 0px 2px 0px;">&nbsp;</div>
											<div style="float:left;width:100%;">
												<?php for($tt=1;$tt<=5;$tt++){?>
													<div style="float:left;width:100%;">
														<div style="float:left;margin:6px 0px 0px 0px;">
															<input onclick="toactionparameter_list('<?php echo $id;?>list_pic_<?php echo $tt;?>')" type="checkbox" name="<?php echo $id;?>list_pic_<?php echo $tt;?>" id="<?php echo $id;?>list_pic_<?php echo $tt;?>" <?php if(${'is_pic_'.$tt}==1){echo 'checked';}?> value="pic_<?php echo $tt;?>"/> <label for="<?php echo $id;?>list_pic_<?php echo $tt;?>">图片 <?php echo $tt;?></label> 
														</div>
														<div id="<?php echo $id;?>list_pic_<?php echo $tt;?>_area" style="float:left;<?php if(${'is_pic_'.$tt}==1){echo 'display:block;';}else{echo 'display:none;';}?>">
															 &nbsp;&nbsp;:&nbsp;&nbsp;
															<?php for($la=0;$la<count($langarr);$la++){//多语言?>
																<?php echo $langarr[$la]['lang_name'.$langarr[$la]['langtype']]?> <input name="<?php echo $id;?>list_pic_<?php echo $tt.$langarr[$la]['langtype'];?>" type="text" value="<?php echo ${'pic_'.$tt.$langarr[$la]['langtype']}?>" style="width:60px;"/>
															<?php }?>
														</div>
													</div>
												<?php }?>
											</div>
											<div style="float:left;width:100%;line-height:1px;border-bottom:1px dashed gray;margin:2px 0px 2px 0px;">&nbsp;</div>
											<div style="float:left;width:100%;">
												<?php for($tt=1;$tt<=5;$tt++){?>
													<div style="float:left;width:100%;">
														<div style="float:left;margin:6px 0px 0px 0px;">
															<input onclick="toactionparameter_list('<?php echo $id;?>list_nolaninput_<?php echo $tt;?>')" type="checkbox" name="<?php echo $id;?>list_nolaninput_<?php echo $tt;?>" id="<?php echo $id;?>list_nolaninput_<?php echo $tt;?>" <?php if(${'is_nolaninput_'.$tt}==1){echo 'checked';}?> value="nolaninput_<?php echo $tt;?>"/> <label for="<?php echo $id;?>list_nolaninput_<?php echo $tt;?>">不分Input <?php echo $tt;?></label> 
														</div>
														<div id="<?php echo $id;?>list_nolaninput_<?php echo $tt;?>_area" style="float:left;<?php if(${'is_nolaninput_'.$tt}==1){echo 'display:block;';}else{echo 'display:none;';}?>">
															&nbsp;&nbsp;:&nbsp;&nbsp; 
															<?php for($la=0;$la<count($langarr);$la++){//多语言?>
																<?php echo $langarr[$la]['lang_name'.$langarr[$la]['langtype']]?> <input name="<?php echo $id;?>list_nolaninput_<?php echo $tt.$langarr[$la]['langtype'];?>" type="text" value="<?php echo ${'nolaninput_'.$tt.$langarr[$la]['langtype']}?>" style="width:60px;"/>
															<?php }?>
														</div>
													</div>
												<?php }?>
											</div>
											<div style="float:left;width:100%;line-height:1px;border-bottom:1px dashed gray;margin:2px 0px 2px 0px;">&nbsp;</div>
											<div style="float:left;width:100%;">
												<?php for($tt=1;$tt<=5;$tt++){?>
													<div style="float:left;width:100%;">
														<div style="float:left;margin:6px 0px 0px 0px;">
															<input onclick="toactionparameter_list('<?php echo $id;?>list_laninput_<?php echo $tt;?>')" type="checkbox" name="<?php echo $id;?>list_laninput_<?php echo $tt;?>" id="<?php echo $id;?>list_laninput_<?php echo $tt;?>" <?php if(${'is_laninput_'.$tt}==1){echo 'checked';}?> value="laninput_<?php echo $tt;?>"/> <label for="<?php echo $id;?>list_laninput_<?php echo $tt;?>">区分Input <?php echo $tt;?></label> 
														</div>
														<div id="<?php echo $id;?>list_laninput_<?php echo $tt;?>_area" style="float:left;<?php if(${'is_laninput_'.$tt}==1){echo 'display:block;';}else{echo 'display:none;';}?>">
															&nbsp;&nbsp;:&nbsp;&nbsp; 
															<?php for($la=0;$la<count($langarr);$la++){//多语言?>
																<?php echo $langarr[$la]['lang_name'.$langarr[$la]['langtype']]?> <input name="<?php echo $id;?>list_laninput_<?php echo $tt.$langarr[$la]['langtype'];?>" type="text" value="<?php echo ${'laninput_'.$tt.$langarr[$la]['langtype']}?>" style="width:60px;"/>
															<?php }?>
														</div>
													</div>
												<?php }?>
											</div>
											<div style="float:left;width:100%;display:none;">
												<?php for($tt=1;$tt<=5;$tt++){?>
													<div style="float:left;width:100%;">
														<div style="float:left;margin:6px 0px 0px 0px;">
															<input onclick="toactionparameter_list('<?php echo $id;?>list_nolantextarea_<?php echo $tt;?>')" type="checkbox" name="<?php echo $id;?>list_nolantextarea_<?php echo $tt;?>" id="<?php echo $id;?>list_nolantextarea_<?php echo $tt;?>" <?php if(${'is_nolantextarea_'.$tt}==1){echo 'checked';}?> value="nolantextarea_<?php echo $tt;?>"/> <label for="<?php echo $id;?>list_nolantextarea_<?php echo $tt;?>">不分Textarea <?php echo $tt;?></label> 
														</div>
														<div id="<?php echo $id;?>list_nolantextarea_<?php echo $tt;?>_area" style="float:left;<?php if(${'is_nolantextarea_'.$tt}==1){echo 'display:block;';}else{echo 'display:none;';}?>">
															&nbsp;&nbsp;:&nbsp;&nbsp; 
															<?php for($la=0;$la<count($langarr);$la++){//多语言?>
																<?php echo $langarr[$la]['lang_name'.$langarr[$la]['langtype']]?> <input name="<?php echo $id;?>list_nolantextarea_<?php echo $tt.$langarr[$la]['langtype'];?>" type="text" value="<?php echo ${'nolantextarea_'.$tt.$langarr[$la]['langtype']};?>" style="width:60px;"/>
															<?php }?>
														</div>
													</div>
												<?php }?>
											</div>
											<div style="float:left;width:100%;display:none;">
												<?php for($tt=1;$tt<=5;$tt++){?>
													<div style="float:left;width:100%;">
														<div style="float:left;margin:6px 0px 0px 0px;">
															<input onclick="toactionparameter_list('<?php echo $id;?>list_lantextarea_<?php echo $tt;?>')" type="checkbox" name="<?php echo $id;?>list_lantextarea_<?php echo $tt;?>" id="<?php echo $id;?>list_lantextarea_<?php echo $tt;?>" <?php if(${'is_lantextarea_'.$tt}==1){echo 'checked';}?> value="lantextarea_<?php echo $tt;?>"/> <label for="<?php echo $id;?>list_lantextarea_<?php echo $tt;?>">区分Textarea <?php echo $tt;?></label>
														</div>
														<div id="<?php echo $id;?>list_lantextarea_<?php echo $tt;?>_area" style="float:left;<?php if(${'is_lantextarea_'.$tt}==1){echo 'display:block;';}else{echo 'display:none;';}?>">
															&nbsp;&nbsp;:&nbsp;&nbsp; 
															<?php for($la=0;$la<count($langarr);$la++){//多语言?>
																<?php echo $langarr[$la]['lang_name'.$langarr[$la]['langtype']]?> <input name="<?php echo $id;?>list_lantextarea_<?php echo $tt.$langarr[$la]['langtype'];?>" type="text" value="<?php echo ${'lantextarea_'.$tt.$langarr[$la]['langtype']};?>" style="width:60px;"/>
															<?php }?>
														</div>
													</div>
												<?php }?>
											</div>
										
										
								</td>
								<td>
										<?php 
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
											
											$parameter=$subcategorylist[$i]['parameter_post'];
											$parameter=explode('-',$parameter);
											
											if(!empty($parameter)){
												for($b=0;$b<count($con);$b++){
													${'is_'.$con[$b]}=0;
												}
												for($a=0;$a<count($parameter);$a++){
													for($b=0;$b<count($con);$b++){
														if($parameter[$a]==$con[$b]){
															${'is_'.$con[$b]}=1;
															for($tt=1;$tt<=5;$tt++){
																//关于图片
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
																		
																		if(count(${'pic_'.$tt.$langarr[$la]['langtype'].'_res'})==4){
																			if(${'pic_'.$tt.$langarr[$la]['langtype'].'_res'}[0].'_'.${'pic_'.$tt.$langarr[$la]['langtype'].'_res'}[1].'_'.${'pic_'.$tt.$langarr[$la]['langtype'].'_res'}[2]=='pic_'.$tt.$langarr[$la]['langtype']){
																				${'pic_'.$tt.$langarr[$la]['langtype']}=${'pic_'.$tt.$langarr[$la]['langtype'].'_res'}[3];
																			}
																		}
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
																	if(isset($parameter[$a+($la+3)])){
																		${'name'.$langarr[$la]['langtype'].'_res'}=$parameter[$a+($la+3)];
																		${'name'.$langarr[$la]['langtype'].'_res'}=explode('_',${'name'.$langarr[$la]['langtype'].'_res'});
																		if(count(${'name'.$langarr[$la]['langtype'].'_res'})==3){
																			if(${'name'.$langarr[$la]['langtype'].'_res'}[0].'_'.${'name'.$langarr[$la]['langtype'].'_res'}[1]=='name'.$langarr[$la]['langtype']){
																				${'name'.$langarr[$la]['langtype']}=${'name'.$langarr[$la]['langtype'].'_res'}[2];
																			}
																		}
																	}
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
																		if(isset($parameter[$a+($la+4)])){
																			${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'}=$parameter[$a+($la+4)];
																			${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'}=explode('_',${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'});
																			
																			if(count(${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'})==4){
																				if(${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'}[0].'_'.${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'}[1].'_'.${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'}[2]=='nolaninput_'.$tt.$langarr[$la]['langtype']){
																					${'nolaninput_'.$tt.$langarr[$la]['langtype']}=${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'}[3];
																				}
																			}
																		}
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
																		if(isset($parameter[$a+($la+3)])){
																			${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'}=$parameter[$a+($la+3)];
																			${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'}=explode('_',${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'});
																			
																			if(count(${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'})==4){
																				if(${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'}[0].'_'.${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'}[1].'_'.${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'}[2]=='laninput_'.$tt.$langarr[$la]['langtype']){
																					${'laninput_'.$tt.$langarr[$la]['langtype']}=${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'}[3];
																				}
																			}
																		}
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
																		if(isset($parameter[$a+($la+5)])){
																			${'nolantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}=$parameter[$a+($la+5)];
																			${'nolantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}=explode('_',${'nolantextarea_'.$tt.$langarr[$la]['langtype'].'_res'});
																			
																			if(count(${'nolantextarea_'.$tt.$langarr[$la]['langtype'].'_res'})==4){
																				if(${'nolantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}[0].'_'.${'nolantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}[1].'_'.${'nolantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}[2]=='nolantextarea_'.$tt.$langarr[$la]['langtype']){
																					${'nolantextarea_'.$tt.$langarr[$la]['langtype']}=${'nolantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}[3];
																				}
																			}
																		}
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
																		if(isset($parameter[$a+($la+5)])){
																			${'lantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}=$parameter[$a+($la+5)];
																			${'lantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}=explode('_',${'lantextarea_'.$tt.$langarr[$la]['langtype'].'_res'});
																			
																			if(count(${'lantextarea_'.$tt.$langarr[$la]['langtype'].'_res'})==4){
																				if(${'lantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}[0].'_'.${'lantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}[1].'_'.${'lantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}[2]=='lantextarea_'.$tt.$langarr[$la]['langtype']){
																					${'lantextarea_'.$tt.$langarr[$la]['langtype']}=${'lantextarea_'.$tt.$langarr[$la]['langtype'].'_res'}[3];
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
											}
										?>
											<div style="float:left;width:100%;">
												<div style="float:left;margin:6px 0px 0px 0px;">
													<input onclick="toactionparameter_post('<?php echo $id;?>post_name')" type="checkbox" name="<?php echo $id;?>post_name" id="<?php echo $id;?>post_name" value="name" <?php if(${'is_name'}==1){echo 'checked';}?>/> <label for="<?php echo $id;?>post_name">标题</label> 
												</div>
												<div id="<?php echo $id;?>post_name_area" style="float:left;<?php if(${'is_name'}==1){echo 'display:block;';}else{echo 'display:none;';}?>">
													&nbsp;&nbsp;:&nbsp;&nbsp; 
													宽度 <input name="<?php echo $id;?>post_name_width" type="text" value="<?php echo ${'name_width'}?>" style="width:32px;"/>
													必填 <input name="<?php echo $id;?>post_name_required" type="checkbox" value="1" <?php if(${'name_required'}==1){echo 'checked';}?>/>
													<?php for($la=0;$la<count($langarr);$la++){//多语言?>
														<?php echo $langarr[$la]['lang_name'.$langarr[$la]['langtype']]?> <input name="<?php echo $id;?>post_name<?php echo $langarr[$la]['langtype']?>" type="text" value="<?php echo ${'name'.$langarr[$la]['langtype']}?>" style="width:60px;"/>
													<?php }?>
												</div>
											</div>
											<div style="float:left;width:100%;">
												<div style="float:left;margin:6px 0px 0px 0px;">
													<input type="checkbox" name="<?php echo $id;?>post_selection_1" id="<?php echo $id;?>post_selection_1" value="selection_1" <?php if(${'is_selection_1'}==1){echo 'checked';}?>/> <label for="<?php echo $id;?>post_selection_1">第一选择</label> 
												</div>
												<div style="float:left;margin:6px 0px 0px 0px;">
													<input type="checkbox" name="<?php echo $id;?>post_selection_2" id="<?php echo $id;?>post_selection_2" value="selection_2" <?php if(${'is_selection_2'}==1){echo 'checked';}?>/> <label for="<?php echo $id;?>post_selection_2">第二选择</label> 
												</div>
												<div style="float:left;margin:6px 0px 0px 0px;">
													<input type="checkbox" name="<?php echo $id;?>post_selection_3" id="<?php echo $id;?>post_selection_3" value="selection_3" <?php if(${'is_selection_3'}==1){echo 'checked';}?>/> <label for="<?php echo $id;?>post_selection_3">第三选择</label> 
												</div>
											</div>
											<div style="float:left;width:100%;">
												<div style="float:left;margin:6px 0px 0px 0px;">
													<input type="checkbox" name="<?php echo $id;?>post_checkboxion_1" id="<?php echo $id;?>post_checkboxion_1" value="checkboxion_1" <?php if(${'is_checkboxion_1'}==1){echo 'checked';}?>/> <label for="<?php echo $id;?>post_checkboxion_1">第一多选</label> 
												</div>
												<div style="float:left;margin:6px 0px 0px 0px;">
													<input type="checkbox" name="<?php echo $id;?>post_checkboxion_2" id="<?php echo $id;?>post_checkboxion_2" value="checkboxion_2" <?php if(${'is_checkboxion_2'}==1){echo 'checked';}?>/> <label for="<?php echo $id;?>post_checkboxion_2">第二多选</label> 
												</div>
												<div style="float:left;margin:6px 0px 0px 0px;">
													<input type="checkbox" name="<?php echo $id;?>post_checkboxion_3" id="<?php echo $id;?>post_checkboxion_3" value="checkboxion_3" <?php if(${'is_checkboxion_3'}==1){echo 'checked';}?>/> <label for="<?php echo $id;?>post_checkboxion_3">第三多选</label> 
												</div>
											</div>
											<div style="float:left;width:100%;line-height:1px;border-bottom:1px dashed gray;margin:2px 0px 2px 0px;">&nbsp;</div>
											<div style="float:left;width:100%;">
												<?php for($tt=1;$tt<=5;$tt++){?>
													<div style="float:left;width:100%;">
														<div style="float:left;margin:6px 0px 0px 0px;">
															<input onclick="toactionparameter_post('<?php echo $id;?>post_pic_<?php echo $tt;?>')" type="checkbox" name="<?php echo $id;?>post_pic_<?php echo $tt;?>" id="<?php echo $id;?>post_pic_<?php echo $tt;?>" <?php if(${'is_pic_'.$tt}==1){echo 'checked';}?> value="pic_<?php echo $tt;?>"/> <label for="<?php echo $id;?>post_pic_<?php echo $tt;?>">图片 <?php echo $tt;?></label> 
														</div>
														<div id="<?php echo $id;?>post_pic_<?php echo $tt;?>_area" style="float:left;<?php if(${'is_pic_'.$tt}==1){echo 'display:block;';}else{echo 'display:none;';}?>">
															 &nbsp;&nbsp;:&nbsp;&nbsp;
															上传方式 <select name="<?php echo $id;?>post_pic_<?php echo $tt;?>_showtype"><option value="1" <?php if(${'pic_'.$tt.'_showtype'}==1){echo 'selected';}?>>固定尺寸</option><option value="2" <?php if(${'pic_'.$tt.'_showtype'}==2){echo 'selected';}?>>等比例缩放</option><option value="3" <?php if(${'pic_'.$tt.'_showtype'}==3){echo 'selected';}?>>上传后裁剪</option></select>
															宽度 <input name="<?php echo $id;?>post_pic_<?php echo $tt;?>_width" type="text" value="<?php echo ${'pic_'.$tt.'_width'}?>" style="width:32px;"/>
															高度 <input name="<?php echo $id;?>post_pic_<?php echo $tt;?>_height" type="text" value="<?php echo ${'pic_'.$tt.'_height'}?>" style="width:24px;"/>
															必填 <input name="<?php echo $id;?>post_pic_<?php echo $tt;?>_required" type="checkbox" value="1" <?php if(${'pic_'.$tt.'_required'}==1){echo 'checked';}?>/>
															<?php for($la=0;$la<count($langarr);$la++){//多语言?>
																<?php echo $langarr[$la]['lang_name'.$langarr[$la]['langtype']]?> <input name="<?php echo $id;?>post_pic_<?php echo $tt.$langarr[$la]['langtype'];?>" type="text" value="<?php echo ${'pic_'.$tt.$langarr[$la]['langtype']}?>" style="width:60px;"/>
															<?php }?>
														</div>
													</div>
												<?php }?>
											</div>
											<div style="float:left;width:100%;line-height:1px;border-bottom:1px dashed gray;margin:2px 0px 2px 0px;">&nbsp;</div>
											<div style="float:left;width:100%;">
												<?php for($tt=1;$tt<=5;$tt++){?>
													<div style="float:left;width:100%;">
														<div style="float:left;margin:6px 0px 0px 0px;">
															<input onclick="toactionparameter_post('<?php echo $id;?>post_nolaninput_<?php echo $tt;?>')" type="checkbox" name="<?php echo $id;?>post_nolaninput_<?php echo $tt;?>" id="<?php echo $id;?>post_nolaninput_<?php echo $tt;?>" <?php if(${'is_nolaninput_'.$tt}==1){echo 'checked';}?> value="nolaninput_<?php echo $tt;?>"/> <label for="<?php echo $id;?>post_nolaninput_<?php echo $tt;?>">不分Input <?php echo $tt;?></label> 
														</div>
														<div id="<?php echo $id;?>post_nolaninput_<?php echo $tt;?>_area" style="float:left;<?php if(${'is_nolaninput_'.$tt}==1){echo 'display:block;';}else{echo 'display:none;';}?>">
															&nbsp;&nbsp;:&nbsp;&nbsp; 
															宽度 <input name="<?php echo $id;?>post_nolaninput_<?php echo $tt;?>_width" type="text" value="<?php echo ${'nolaninput_'.$tt.'_width'}?>" style="width:32px;"/>
															必填 <input name="<?php echo $id;?>post_nolaninput_<?php echo $tt;?>_required" type="checkbox" value="1" <?php if(${'nolaninput_'.$tt.'_required'}==1){echo 'checked';}?>/>
															格式 <select name="<?php echo $id;?>post_nolaninput_<?php echo $tt;?>_format"><option value="vachar" <?php if(${'nolaninput_'.$tt.'_format'}=='vachar'){echo 'selected';}?>>字符串</option><option value="numeric" <?php if(${'nolaninput_'.$tt.'_format'}=='numeric'){echo 'selected';}?>>数字</option><option value="email" <?php if(${'nolaninput_'.$tt.'_format'}=='email'){echo 'selected';}?>>邮箱</option><option value="date" <?php if(${'nolaninput_'.$tt.'_format'}=='date'){echo 'selected';}?>>日期</option></select>
															<?php for($la=0;$la<count($langarr);$la++){//多语言?>
																<?php echo $langarr[$la]['lang_name'.$langarr[$la]['langtype']]?> <input name="<?php echo $id;?>post_nolaninput_<?php echo $tt.$langarr[$la]['langtype'];?>" type="text" value="<?php echo ${'nolaninput_'.$tt.$langarr[$la]['langtype']}?>" style="width:60px;"/>
															<?php }?>
														</div>
													</div>
												<?php }?>
											</div>
											<div style="float:left;width:100%;line-height:1px;border-bottom:1px dashed gray;margin:2px 0px 2px 0px;">&nbsp;</div>
											<div style="float:left;width:100%;">
												<?php for($tt=1;$tt<=5;$tt++){?>
													<div style="float:left;width:100%;">
														<div style="float:left;margin:6px 0px 0px 0px;">
															<input onclick="toactionparameter_post('<?php echo $id;?>post_laninput_<?php echo $tt;?>')" type="checkbox" name="<?php echo $id;?>post_laninput_<?php echo $tt;?>" id="<?php echo $id;?>post_laninput_<?php echo $tt;?>" <?php if(${'is_laninput_'.$tt}==1){echo 'checked';}?> value="laninput_<?php echo $tt;?>"/> <label for="<?php echo $id;?>post_laninput_<?php echo $tt;?>">区分Input <?php echo $tt;?></label> 
														</div>
														<div id="<?php echo $id;?>post_laninput_<?php echo $tt;?>_area" style="float:left;<?php if(${'is_laninput_'.$tt}==1){echo 'display:block;';}else{echo 'display:none;';}?>">
															&nbsp;&nbsp;:&nbsp;&nbsp; 
															宽度 <input name="<?php echo $id;?>post_laninput_<?php echo $tt;?>_width" type="text" value="<?php echo ${'laninput_'.$tt.'_width'}?>" style="width:32px;"/>
															必填 <input name="<?php echo $id;?>post_laninput_<?php echo $tt;?>_required" type="checkbox" value="1" <?php if(${'laninput_'.$tt.'_required'}==1){echo 'checked';}?>/>
															<?php for($la=0;$la<count($langarr);$la++){//多语言?>
																<?php echo $langarr[$la]['lang_name'.$langarr[$la]['langtype']]?> <input name="<?php echo $id;?>post_laninput_<?php echo $tt.$langarr[$la]['langtype'];?>" type="text" value="<?php echo ${'laninput_'.$tt.$langarr[$la]['langtype']}?>" style="width:60px;"/>
															<?php }?>
														</div>
													</div>
												<?php }?>
											</div>
											<div style="float:left;width:100%;line-height:1px;border-bottom:1px dashed gray;margin:2px 0px 2px 0px;">&nbsp;</div>
											<div style="float:left;width:100%;">
												<?php for($tt=1;$tt<=5;$tt++){?>
													<div style="float:left;width:100%;">
														<div style="float:left;margin:6px 0px 0px 0px;">
															<input onclick="toactionparameter_post('<?php echo $id;?>post_nolantextarea_<?php echo $tt;?>')" type="checkbox" name="<?php echo $id;?>post_nolantextarea_<?php echo $tt;?>" id="<?php echo $id;?>post_nolantextarea_<?php echo $tt;?>" <?php if(${'is_nolantextarea_'.$tt}==1){echo 'checked';}?> value="nolantextarea_<?php echo $tt;?>"/> <label for="<?php echo $id;?>post_nolantextarea_<?php echo $tt;?>">不分Textarea <?php echo $tt;?></label> 
														</div>
														<div id="<?php echo $id;?>post_nolantextarea_<?php echo $tt;?>_area" style="float:left;<?php if(${'is_nolantextarea_'.$tt}==1){echo 'display:block;';}else{echo 'display:none;';}?>">
															&nbsp;&nbsp;:&nbsp;&nbsp; 
															显示方式 <select name="<?php echo $id;?>post_nolantextarea_<?php echo $tt;?>_showtype"><option value="1" <?php if(${'nolantextarea_'.$tt.'_showtype'}==1){echo 'selected';}?>>文本框</option><option value="2" <?php if(${'nolantextarea_'.$tt.'_showtype'}==2){echo 'selected';}?>>编辑器</option></select>
															宽度 <input name="<?php echo $id;?>post_nolantextarea_<?php echo $tt;?>_width" type="text" value="<?php echo ${'nolantextarea_'.$tt.'_width'};?>" style="width:24px;"/>
															高度 <input name="<?php echo $id;?>post_nolantextarea_<?php echo $tt;?>_height" type="text" value="<?php echo ${'nolantextarea_'.$tt.'_height'};?>" style="width:24px;"/>
															必填 <input name="<?php echo $id;?>post_nolantextarea_<?php echo $tt;?>_required" type="checkbox" value="1" <?php if(${'nolantextarea_'.$tt.'_required'}==1){echo 'checked';}?>/>
															<?php for($la=0;$la<count($langarr);$la++){//多语言?>
																<?php echo $langarr[$la]['lang_name'.$langarr[$la]['langtype']]?> <input name="<?php echo $id;?>post_nolantextarea_<?php echo $tt.$langarr[$la]['langtype'];?>" type="text" value="<?php echo ${'nolantextarea_'.$tt.$langarr[$la]['langtype']};?>" style="width:60px;"/>
															<?php }?>
														</div>
													</div>
												<?php }?>
											</div>
											<div style="float:left;width:100%;line-height:1px;border-bottom:1px dashed gray;margin:2px 0px 2px 0px;">&nbsp;</div>
											<div style="float:left;width:100%;">
												<?php for($tt=1;$tt<=5;$tt++){?>
													<div style="float:left;width:100%;">
														<div style="float:left;margin:6px 0px 0px 0px;">
															<input onclick="toactionparameter_post('<?php echo $id;?>post_lantextarea_<?php echo $tt;?>')" type="checkbox" name="<?php echo $id;?>post_lantextarea_<?php echo $tt;?>" id="<?php echo $id;?>post_lantextarea_<?php echo $tt;?>" <?php if(${'is_lantextarea_'.$tt}==1){echo 'checked';}?> value="lantextarea_<?php echo $tt;?>"/> <label for="<?php echo $id;?>post_lantextarea_<?php echo $tt;?>">区分Textarea <?php echo $tt;?></label>
														</div>
														<div id="<?php echo $id;?>post_lantextarea_<?php echo $tt;?>_area" style="float:left;<?php if(${'is_lantextarea_'.$tt}==1){echo 'display:block;';}else{echo 'display:none;';}?>">
															&nbsp;&nbsp;:&nbsp;&nbsp; 
															显示方式 <select name="<?php echo $id;?>post_lantextarea_<?php echo $tt;?>_showtype"><option value="1" <?php if(${'lantextarea_'.$tt.'_showtype'}==1){echo 'selected';}?>>文本框</option><option value="2" <?php if(${'lantextarea_'.$tt.'_showtype'}==2){echo 'selected';}?>>编辑器</option></select>
															宽度 <input name="<?php echo $id;?>post_lantextarea_<?php echo $tt;?>_width" type="text" value="<?php echo ${'lantextarea_'.$tt.'_width'};?>" style="width:24px;"/>
															高度 <input name="<?php echo $id;?>post_lantextarea_<?php echo $tt;?>_height" type="text" value="<?php echo ${'lantextarea_'.$tt.'_height'};?>" style="width:24px;"/>
															必填 <input name="<?php echo $id;?>post_lantextarea_<?php echo $tt;?>_required" type="checkbox" value="1" <?php if(${'lantextarea_'.$tt.'_required'}==1){echo 'checked';}?>/>
															<?php for($la=0;$la<count($langarr);$la++){//多语言?>
																<?php echo $langarr[$la]['lang_name'.$langarr[$la]['langtype']]?> <input name="<?php echo $id;?>post_lantextarea_<?php echo $tt.$langarr[$la]['langtype'];?>" type="text" value="<?php echo ${'lantextarea_'.$tt.$langarr[$la]['langtype']};?>" style="width:60px;"/>
															<?php }?>
														</div>
													</div>
												<?php }?>
											</div>
								</td>
								<td>
									<input type="submit" value="Save" style="float:left;background:#018E01;border:0px;color:white;padding:4px 15px 4px 15px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;"/>
								</td>
							</tr>
						</table>
						</form>
					</td>
				</tr>
			<?php }}?>
			</table>
		</td>
	</tr>
</table>
<script>
	function toactionparameter_post(id){
		if($('#'+id+'_area').css('display')=='none'){
			$('#'+id+'_area').show();
		}else{
			$('#'+id+'_area').hide();
		}
	}
	function toactionparameter_list(id){
		if($('#'+id+'_area').css('display')=='none'){
			$('#'+id+'_area').show();
		}else{
			$('#'+id+'_area').hide();
		}
	}
</script>


		</div>
	</body>
</html>
