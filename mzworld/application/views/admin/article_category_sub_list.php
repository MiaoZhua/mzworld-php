<?php $this->load->view('admin/header')?>
<?php 
	$langarr=languagelist();//多语言

	$have_count=0;//个数
	for($tt=1;$tt<=5;$tt++){
		for($la=0;$la<count($langarr);$la++){//多语言
			${'nolaninput_'.$tt.$langarr[$la]['langtype']}='';
			${'laninput_'.$tt.$langarr[$la]['langtype']}='';
			${'pic_'.$tt.$langarr[$la]['langtype']}='';
			${'manage_'.$tt.$langarr[$la]['langtype']}='';
		}
	}
	$sectionandname=array();//模块和名称
	$sectionandname[]=array('code'=>'name','name'=>'标题');
	$sectionandname[]=array('code'=>'add','name'=>'添加文章');
	$sectionandname[]=array('code'=>'edit','name'=>'修改');
	
	for($la=0;$la<count($langarr);$la++){//多语言
		for($sn=0;$sn<count($sectionandname);$sn++){
			${$sectionandname[$sn]['code'].$langarr[$la]['langtype']}=$sectionandname[$sn]['name'];
		}
	}
	$con=array('name','author','created','del','add','edit');
	for($tt=1;$tt<=5;$tt++){
		$con[]='pic_'.$tt;
		$con[]='laninput_'.$tt;
		$con[]='nolaninput_'.$tt;
		$con[]='selection_'.$tt;
		$con[]='manage_'.$tt;
	}
	$parameter=$category_info['parameter_list'];
	$parameter=explode('-',$parameter);
	if(!empty($parameter)){
		for($b=0;$b<count($con);$b++){
			${'is_'.$con[$b]}=0;
		}
		for($a=0;$a<count($parameter);$a++){
			for($b=0;$b<count($con);$b++){
				if($parameter[$a]==$con[$b]){
					${'is_'.$con[$b]}=1;
					//关于图片
					for($tt=1;$tt<=5;$tt++){
						if($con[$b]=='pic_'.$tt){
							for($la=0;$la<count($langarr);$la++){//多语言
								${'pic_'.$tt.$langarr[$la]['langtype'].'_res'}=$parameter[$a+($la+1)];
								${'pic_'.$tt.$langarr[$la]['langtype'].'_res'}=explode('_',${'pic_'.$tt.$langarr[$la]['langtype'].'_res'});
								${'pic_'.$tt.$langarr[$la]['langtype']}=${'pic_'.$tt.$langarr[$la]['langtype'].'_res'}[3];
							}
						}
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
								${'manage_'.$tt.$langarr[$la]['langtype'].'_res'}=$parameter[$a+($la+1)];
								${'manage_'.$tt.$langarr[$la]['langtype'].'_res'}=explode('_',${'manage_'.$tt.$langarr[$la]['langtype'].'_res'});
								${'manage_'.$tt.$langarr[$la]['langtype']}=${'manage_'.$tt.$langarr[$la]['langtype'].'_res'}[3];
							}
						}
					}
					//有多语言的 input
					for($tt=1;$tt<=5;$tt++){
						if($con[$b]=='laninput_'.$tt){
							for($la=0;$la<count($langarr);$la++){//多语言
								${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'}=$parameter[$a+($la+1)];
								${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'}=explode('_',${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'});
								${'laninput_'.$tt.$langarr[$la]['langtype']}=${'laninput_'.$tt.$langarr[$la]['langtype'].'_res'}[3];
							}
						}
					}
					//没有多语言的 其他input
					for($tt=1;$tt<=5;$tt++){
						if($con[$b]=='nolaninput_'.$tt){
							for($la=0;$la<count($langarr);$la++){//多语言
								${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'}=$parameter[$a+($la+1)];
								${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'}=explode('_',${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'});
								${'nolaninput_'.$tt.$langarr[$la]['langtype']}=${'nolaninput_'.$tt.$langarr[$la]['langtype'].'_res'}[3];
							}
						}
					}
				}
			}
			
		}
		for($b=0;$b<count($con);$b++){
			if(${'is_'.$con[$b]}==1){
				if($con[$b]!="add"&&$con[$b]!="edit"&&$con[$b]!="del"){
					$have_count++;
				}
			}
		}
	}
?>
<?php if(isset($category_info)){?>
	<div class="tips_text">
		<div style="float:left;width:500px;line-height:20px;">
			<?php echo $category_info['tips'];?>
		</div>
	</div>
<?php }?>


<?php if($is_add==1){?>
<div class="ma_actions">
	<ul>
		<li><b>操作 :</b></li>
		<li>
			<a href="javascript:;"><font class="nav_on"><?php echo ${'manage_1'.$this->langtype}?></font></a>
			<br/><a href="<?php echo site_url('admins/'.$this->controller.'/toadd_subcategory')?>"><font class="nav_off"><?php echo ${'add'.$this->langtype}?></font></a>
		</li>
	</ul>
</div>
<?php }?>


	
<table cellspacing=0 cellpadding=0 class="tab_list">
	<tr>
		<th height="30" width="100">S/N</th>  	
		<?php for($tt=1;$tt<=5;$tt++){?>
			<?php if(${'is_pic_'.$tt}==1){echo '<th width="120">'.${'pic_'.$tt.$this->langtype}.'</th>';}?> 	
		<?php }?>
		<?php if($is_name==1){echo '<th style="text-align:left;">'.${'name'.$this->langtype}.'</th>';}?>
		<?php if($is_selection_1==1){echo '<th width="250" align="center">Category</th>';}?>
		<?php for($tt=1;$tt<=5;$tt++){?>
			<?php if(${'is_laninput_'.$tt}==1){echo '<th width="200" align="center">'.${'laninput_'.$tt.$this->langtype}.'</th>';}?>
		<?php }?>
		<?php for($tt=1;$tt<=5;$tt++){?>
			<?php if(${'is_nolaninput_'.$tt}==1){echo '<th width="200" align="center">'.${'nolaninput_'.$tt.$this->langtype}.'</th>';}?>
		<?php }?>
		<?php if($is_created==1){echo '<th width="130">'.lang('cy_date').'</th>';}?>
		<?php if($is_author==1){echo '<th width="130">Author</th>';}?>
		<th width="200">
			操作
		</th>
	</tr>
</table>
<ul id="tasks" style="float:left;width:100%;padding:0px;margin:0px;list-style-type: none;">
	<?php 
		if(!empty($subcategory)){
			for($i=0;$i<count($subcategory);$i++){
	?>
		<li class="articlelist" id="<?php echo $subcategory[$i]['category_id']?>" iid="<?php echo $i+1?>" style="width:100%;padding:0px;margin:0px;list-style-type: none;">
			<table cellspacing=0 cellpadding=0 class="tab_list">
				<tr>  	
					<td width="100" align="center" height="30"><?php echo $i+1;?></td>
					<?php for($tt=1;$tt<=5;$tt++){?>
						<?php if(${'is_pic_'.$tt}==1){?>
							<td width="120" align="center" style="padding:8px 0px 8px 0px;">
								<?php 
								echo '<div style="float:left;width:100%;height:70px;">';
								$filename=$subcategory[$i]['pic_'.$tt];
								if($filename!=null&&file_exists($filename)){
									$picinfo=$this->WelModel->getpicinfo($filename,100,70,$leftadd=0,$topadd=0);
									echo '<img style="float:left;width:'.$picinfo['width'].'px;height:'.$picinfo['height'].'px;margin-left:'.$picinfo['marginleft'].'px;margin-top:'.$picinfo['margintop'].'px;" src="'.base_url().$picinfo['pic'].'"/>';
								}else{
									$pic='';
								}
								echo '</div>';
								?>
								
							</td>
						<?php }?>
					<?php }?>
					<?php if($is_name==1){?>
						<td align="left"><?php echo $subcategory[$i]['category_name'.$this->langtype];?></td>
					<?php }?>
					<?php if($is_selection_1==1){?>
						<td width="250" align="center">
							<?php 
								$info=$this->ArticleModel->getarticle_categoryinfo($subcategory[$i]['selection_1']);
								echo '<div style="float:left;margin:3px 0px 0px 20px;">';
									if($info['pic_1']!=""){
										echo '
											<div style="float:left;margin:0px 0px 0px 0px;">
												<img src="'.base_url().$info['pic_1'].'"/>
											</div>
											<div style="float:left;margin:15px 0px 0px 10px;color:gray;">
												'.$info['category_name'.$this->langtype].'
											</div>
										';
									}
								echo '</div>';
							?>
						</td>
					<?php }?>
					<?php for($tt=1;$tt<=5;$tt++){
						if(${'is_laninput_'.$tt}==1){?>
						<td width="200" align="center"><?php echo debaseurlcontent($subcategory[$i]['laninput_'.$tt.$this->langtype]);?></td>
					<?php }}?>
					<?php for($tt=1;$tt<=5;$tt++){
						if(${'is_nolaninput_'.$tt}==1){?>
						<td width="200" align="center"><?php echo debaseurlcontent($subcategory[$i]['nolaninput_'.$tt]);?></td>
					<?php }}?>
					<?php if($is_created==1){?>
						<td width="130" align="center"><?php echo date('Y-m-d',$subcategory[$i]['created'])?></td>
					<?php }?>
					<?php if($is_author==1){?>
						<td width="130" align="center"><?php echo $subcategory[$i]['author']?></td>
					<?php }?>
					<td width="200" align="center">
						<?php 
						//判断是否有子文章
						if($subcategory[$i]['parameter_list']!=""){
							$manage_1_text='';
							$con=array('manage_1');
							$parameter=$subcategory[$i]['parameter_list'];
							$parameter=explode('-',$parameter);
							if(!empty($parameter)){
								for($b=0;$b<count($con);$b++){
									${'is_'.$con[$b]}=0;
								}
								for($a=0;$a<count($parameter);$a++){
									for($b=0;$b<count($con);$b++){
										if($parameter[$a]==$con[$b]){
											${'is_'.$con[$b]}=1;
											$manage_1_text=$parameter[$a+1];
											$manage_1_text=explode('_',$manage_1_text);
											$manage_1_text=$manage_1_text[3];
										}
									}
								}
							}
							if($is_manage_1==1){
								//获取子文章的数量
								$con=array('parent'=>0,'category_id'=>$this->category_id,'subcategory_id'=>$subcategory[$i]['category_id']);
								$count=$this->ArticleModel->getarticlelist($con,1);
								if($count>0){
									$count_text='<font style="color:red;">('.$count.')</font>';
								}else{
									$count_text='';
								}
								echo '<a href="'.site_url('admins/'.$this->controller.'/article_list?subcategory_ID='.$subcategory[$i]['category_id'].'&key='.$subcategory[$i]['key']).'">'.$manage_1_text.' '.$count_text.'</a>';
								echo '&nbsp;&nbsp;';
							}
						}
					?>
						
						
						<?php if($is_edit==1){?>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="<?php echo site_url('admins/'.$this->controller.'/toedit_subcategory?subcategory_ID='.$subcategory[$i]['category_id'].'&key='.$subcategory[$i]['key'])?>"><?php echo lang('cy_edit')?></a>
						<?php }?>
						<?php if($is_del==1){?>
							&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="javascript:;" onclick="todel_category(<?php echo $subcategory[$i]['category_id'];?>)"><?php echo lang('cy_delete')?></a>
						<?php }?>
					</td>
				</tr>
			</table>
		</li>
	<?php }}?>
</ul>
	
	
	
<?php if($oldorderby=='move'){?>
	<script src="<?php echo base_url()?>js/jquery-ui-1.10.3.custom.min.js"></script>
	<script type="text/javascript">
		jQuery(function($) {
			$('.articlelist').each(function (){
				var height=$(this).find('table').height();
				$(this).css({'height':height+'px'});
			})
			$('#tasks').sortable({
				opacity:0.8,
				revert:true,
				forceHelperSize:true,
				placeholder: 'draggable-placeholder',
				forcePlaceholderSize:true,
				tolerance:'pointer',
				stop: function( event,ui) {//just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
					$(ui.item).css('z-index', 'auto');
					var newsrot=[];
					var idarr=[];
					var i=0;
					$('.articlelist').each(function (){
						i++;
						newsrot.push(i);
						idarr.push($(this).attr('id'));
					})
					$.post(baseurl+'index.php/admins/home/editcategorysort',{idarr:idarr,newsrot:newsrot},function (data){
						
					})
				},
				scroll: true,
			});
			
		})
	</script>
<?php }?>
<?php $this->load->view('admin/footer')?>



