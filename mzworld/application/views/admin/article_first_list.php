<?php $this->load->view('admin/header')?>
<?php 
$langarr=languagelist();//多语言

$get_str='';
if($_GET){
	$arr=array('subcategory_ID','first_id','second_id','third_id','tongji_split','row','key','ID');
	for($i=0;$i<count($arr);$i++){
		if(isset($_GET[$arr[$i]])){
			if($get_str!=""){$get_str .='&';}else{$get_str .='?';}
			$get_str .=$arr[$i].'='.$_GET[$arr[$i]];
		}
	}
}
$current_url_encode=str_replace('/','slash_tag',base64_encode(current_url().$get_str));
?>
<?php 
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
	$con=array('name','created','del','add','edit');
	for($tt=1;$tt<=5;$tt++){
		$con[]='pic_'.$tt;
		$con[]='laninput_'.$tt;
		$con[]='nolaninput_'.$tt;
		$con[]='selection_'.$tt;
		$con[]='manage_'.$tt;
	}
	$parameter=$subcategory_info['parameter_list'];
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
								
								if(count(${'pic_'.$tt.$langarr[$la]['langtype'].'_res'})==4){
									if(${'pic_'.$tt.$langarr[$la]['langtype'].'_res'}[0].'_'.${'pic_'.$tt.$langarr[$la]['langtype'].'_res'}[1].'_'.${'pic_'.$tt.$langarr[$la]['langtype'].'_res'}[2]=='pic_'.$tt.$langarr[$la]['langtype']){
										${'pic_'.$tt.$langarr[$la]['langtype']}=${'pic_'.$tt.$langarr[$la]['langtype'].'_res'}[3];
									}
								}
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
					//有多语言的 input
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
<?php if(isset($subcategory_info)){?>
	<div class="tips_text">
		<div style="float:left;width:500px;line-height:20px;">
			<?php echo $subcategory_info['tips'];?>
		</div>
	</div>
<?php }?>
	<?php 
	if($subcategory_info['parameter_search']!=""){
		$con=array('searchname','searchselection_1');
		$parameter=$subcategory_info['parameter_search'];
		$parameter=explode('-',$parameter);
		if(!empty($parameter)){
			for($b=0;$b<count($con);$b++){
				${'search_'.$con[$b]}=0;
			}
			for($a=0;$a<count($parameter);$a++){
				for($b=0;$b<count($con);$b++){
					if('search'.$parameter[$a]==$con[$b]){
						${'search_'.$con[$b]}=1;
						//关于标题
						if($con[$b]=='searchname'){
							${'searchname_en_res'}=$parameter[$a+1];
							${'searchname_en_res'}=explode('_',${'searchname_en_res'});
							${'searchname_en'}=${'searchname_en_res'}[2];
							
							${'searchname_ch_res'}=$parameter[$a+2];
							${'searchname_ch_res'}=explode('_',${'searchname_ch_res'});
							${'searchname_ch'}=${'searchname_ch_res'}[2];
						}
					}
				}
			}
		}
	?>
	<div style="float:right;margin-right:15px;">
		<form action="<?php echo site_url('admins/'.$this->controller.'/article_list')?>" method="get">
			<?php if(${'search_searchselection_1'}==1){?>
				<?php 
			    	$searchsubcategory_info=$this->ArticleModel->getarticle_categoryinfo(59);
			    	$con=array('category_id'=>59,'subcategory_id'=>60);
					//排序--开始
						$contion=array('orderby');
						$parameter=$searchsubcategory_info['parameter_list'];
						$parameter=explode('-',$parameter);
						$orderby='';
						$orderby_res='';
						if(!empty($parameter)){for($a=0;$a<count($parameter);$a++){for($b=0;$b<count($contion);$b++){if($parameter[$a]==$contion[$b]){$orderby=$parameter[$a+1];$orderby=explode('_',$orderby);$orderby=$orderby[1];$orderby_res=$parameter[$a+2];$orderby_res=explode('_',$orderby_res);$orderby_res=$orderby_res[2];}}}}
						if($orderby=='move'){
							$con['orderby']='sort';
							$con['orderby_res']=$orderby_res;
						}else{
							$con['orderby']='article_id';
							$con['orderby_res']='DESC';
						}
					//排序--结束
					$selection_1list=$this->ArticleModel->getarticlelist($con);
		    	?>
				<select name="selection_1">
					<option value="" <?php if(trim($this->input->get('selection_1'))==''){echo 'selected';} ?>>---- Category ---- </option>
		    		<?php if(isset($selection_1list)){for($a=0;$a<count($selection_1list);$a++){?>
		    			<option value="<?php echo $selection_1list[$a]['article_id'];?>" <?php if(trim($this->input->get('selection_1'))==$selection_1list[$a]['article_id']){echo 'selected';}?>><?php echo $selection_1list[$a]['article_name'.$this->langtype]?></option>
		    		<?php }}?>
				</select>
			<?php }?>
			<?php if(${'search_searchname'}==1){?>
				<input type="text" style="width:180px;" name="keyword" placeholder="Please enter keywords" value="<?php echo $this->input->get('keyword');?>"/>
			<?php }?>
			<input name="subcategory_ID" type="hidden" value="<?php echo $this->input->get('subcategory_ID');?>"/>
			<input name="key" type="hidden" value="<?php echo $this->input->get('key');?>"/>
			<input type="submit" value="<?php echo lang('cy_search')?>" />
		</form>
	</div>
<?php }?>

<?php if($is_add==1){?>
<div class="ma_actions">
	<ul>
		<li><b>操作 :</b></li>
		<li>
			<a href="javascript:;"><font class="nav_on"><?php echo ${'manage_1'.$this->langtype}?></font></a>
			<br/><a href="<?php echo site_url('admins/'.$this->controller.'/toadd_article?subcategory_ID='.$subcategory_info['category_id'].'&key='.$subcategory_info['key'])?>"><font class="nav_off"><?php echo ${'add'.$this->langtype}?></font></a>
		</li>
	</ul>
</div>
<?php }?>




<table cellspacing=0 cellpadding=0 class="tab_list">
	<tr>
		<th width="50">S/N</th>
		<?php for($tt=1;$tt<=5;$tt++){?>
			<?php if(${'is_pic_'.$tt}==1){echo '<th width="120">'.${'pic_'.$tt.$this->langtype}.'</th>';}?> 	
		<?php }?>
		<?php if($is_name==1){echo '<th style="text-align:left;">'.${'name'.$this->langtype}.'</th>';}?> 
		<?php if($is_selection_2==1){echo '<th width="90" align="center">City</th>';}?>
		<?php for($tt=1;$tt<=5;$tt++){?>
			<?php if(${'is_nolaninput_'.$tt}==1){echo '<th width="200" align="center">'.${'nolaninput_'.$tt.$this->langtype}.'</th>';}?>
		<?php }?>
		<?php if($is_created==1){echo '<th width="130">'.lang('cy_date').'</th>';}?>
		<th width="200">
			操作
		</th>
	</tr>
</table>
<ul id="tasks" style="float:left;width:100%;padding:0px;margin:0px;list-style-type: none;">
	<?php 
	if(!empty($article)){
		for($i=0;$i<count($article);$i++){
	?>
	<li class="articlelist" id="<?php echo $article[$i]['article_id']?>" iid="<?php echo $i+1?>" style="width:100%;padding:0px;margin:0px;list-style-type: none;">
	<table cellspacing=0 cellpadding=0 class="tab_list">
	<tr>  	
		<td width="50" align="center"><?php echo $i+1;?></td>
		<?php for($tt=1;$tt<=5;$tt++){?>
			<?php if(${'is_pic_'.$tt}==1){?>
				<td width="120" align="center" style="padding:8px 0px 8px 0px;">
					<?php 
					echo '<div style="float:left;width:100%;height:70px;">';
					$filename=$article[$i]['pic_'.$tt];
					if($filename!=null&&file_exists($filename)){
						$picinfo=$this->WelModel->getpicinfo($filename,100,70,$leftadd=0,$topadd=0);
						echo '<img title="'.$article[$i]['pic_'.$tt.$this->langtype].'" style="float:left;width:'.$picinfo['width'].'px;height:'.$picinfo['height'].'px;margin-left:'.$picinfo['marginleft'].'px;margin-top:'.$picinfo['margintop'].'px;" src="'.base_url().$picinfo['pic'].'"/>';
					}else{
						$pic='';
					}
					echo '</div>';
					?>
				</td>
			<?php }?>
		<?php }?>
		<?php if($is_name==1){?>
			<td align="left">
				<?php echo '<div style="float:left;width:100%;">'.$article[$i]['article_name'.$this->langtype].'</div>';?>
				<?php if($subcategory_info['category_id']==80){?>
					<?php echo '<div style="float:left;width:100%;color:gray;">'.base_url().'index.php/product/info/'.$article[$i]['shorturl'].'</div>';?>
				<?php }?>
			</td>
		<?php }?>
		<?php if($is_selection_2==1){?>
			<td width="90" align="center">
				<?php 
					$info=$this->ArticleModel->getarticleinfo($article[$i]['selection_2']);
					if(!empty($info)){
						echo $info['article_name'.$this->langtype];
					}
				?>
			</td>
		<?php }?>
		<?php for($tt=1;$tt<=5;$tt++){
			if(${'is_nolaninput_'.$tt}==1){?>
			<td width="200" align="center"><?php echo debaseurlcontent($article[$i]['nolaninput_'.$tt]);?></td>
		<?php }}?>
		<?php if($is_created==1){?>
		<td width="130" align="center"><?php echo date('Y-m-d',$article[$i]['created'])?></td>
		<?php }?>
		<td width="200" align="center">
			<?php 
				//判断是否有子文章
				if($article[$i]['parameter_list']!=""){
					$manage_1_text='';
					$con=array('manage_1');
					$parameter=$article[$i]['parameter_list'];
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
						$con=array('parent'=>$article[$i]['article_id'],'category_id'=>$this->category_id,'subcategory_id'=>$subcategory_info['category_id']);
						$count=$this->ArticleModel->getarticlelist($con,1);
						if($count>0){
							$count_text='<font style="color:red;">('.$count.')</font>';
						}else{
							$count_text='';
						}
					echo '<a href="'.site_url('admins/'.$this->controller.'/subarticle_list?subcategory_ID='.$subcategory_info['category_id'].'&first_id='.$article[$i]['article_id'].'&tongji_split=1&key='.$article[$i]['key']).'">'.$manage_1_text.' '.$count_text.'</a>';
						echo '&nbsp;&nbsp;';
					}
				}
			?>
			<?php if($this->category_id==78){?>
				<?php 
					$count=$this->ProductModel->getmaylikelist(array('product_id'=>$article[$i]['article_id']),1);
				?>
				<a href="<?php echo site_url('admins/'.$this->controller.'/tomanage_maylike?subcategory_ID='.$article[$i]['subcategory_id'].'&ID='.$article[$i]['article_id'].'&key='.$article[$i]['key'].'&backurl='.$current_url_encode)?>">Related Products <?php if($count>0){echo '<font style="color:red;">('.$count.')</font>';}?></a>
				&nbsp;&nbsp;&nbsp;&nbsp;
			<?php }?>
		
			<?php if($is_edit==1){?>
				<a href="<?php echo site_url('admins/'.$this->controller.'/toedit_article?subcategory_ID='.$article[$i]['subcategory_id'].'&ID='.$article[$i]['article_id'].'&key='.$article[$i]['key'].'&backurl='.$current_url_encode)?>"><?php echo lang('cy_edit')?></a>
			<?php }?>
			<?php if($is_del==1){?>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="javascript:;" onclick="todel_article(<?php echo $article[$i]['article_id'];?>)"><?php echo lang('cy_delete')?></a>
			<?php }?>
		</td>
	</tr>
</table>
</li>
<?php }}?>
</ul>
<table cellspacing=0 cellpadding=0 class="tab_list">
	<tr>
		<th align="center"></th>
		<th colspan="<?php echo ($have_count+1)?>"><div style="float:left;width:99%;margin-right:1%;text-align:left;"><?php if(isset($fy)){echo $fy;}?></div></th>
	</tr>
</table>
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
					$.post(baseurl+'index.php/admins/home/editarticlesort',{idarr:idarr,newsrot:newsrot},function (data){
						
					})
				},
				scroll: true,
			});
			
		})
	</script>
<?php }?>
<?php $this->load->view('admin/footer')?>



