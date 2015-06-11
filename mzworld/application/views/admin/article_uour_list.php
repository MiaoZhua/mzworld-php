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
<div class="ma_actions">
	<ul>
		<li><b>操作 :</b></li>
		<li>
			<a href="<?php echo site_url('admins/'.$this->controller.'/toadd_vallage?subcategory_ID='.$subcategory_info['category_id'].'&first_id='.$firstinfo['article_id'].'&second_id='.$secondinfo['article_id'].'&third_id='.$thirdinfo['article_id'].'&tongji_split='.$tongji_split.'&key='.$subcategory_info['key'])?>"><font class="nav_off">Add Vallage</font></a>
		</li>
	</ul>
</div>
<table cellspacing=0 cellpadding=0 class="tab_list">
	<tr>
		<th width="100">S/N</th>
		<th style="text-align:left;">Name</th>
		<th width="200" align="center">Longitude</th>
		<th width="200" align="center">Latitude</th>
		<th width="130"><?php echo lang('cy_date')?></th>
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
				<td width="100" align="center"><?php echo $i+1;?></td>
				<td align="left"><?php echo '<div style="float:left;">'.$article[$i]['article_name'.$this->langtype].'</div>';?></td>
				<td width="200" align="center"><?php echo debaseurlcontent($article[$i]['nolaninput_1']);?></td>
				<td width="200" align="center"><?php echo debaseurlcontent($article[$i]['nolaninput_2']);?></td>			
				<td width="130" align="center"><?php echo date('Y-m-d',$article[$i]['created'])?></td>
				<td width="200" align="center">
					<a href="<?php echo site_url('admins/'.$this->controller.'/toedit_vallage?subcategory_ID='.$subcategory_info['category_id'].'&first_id='.$firstinfo['article_id'].'&second_id='.$secondinfo['article_id'].'&third_id='.$thirdinfo['article_id'].'&tongji_split='.$tongji_split.'&ID='.$article[$i]['article_id'].'&key='.$article[$i]['key'].'&backurl='.$current_url_encode)?>"><?php echo lang('cy_edit')?></a>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="javascript:;" onclick="todel_article(<?php echo $article[$i]['article_id'];?>)"><?php echo lang('cy_delete')?></a>
				</td>
			</tr>
		</table>
	</li>
	<?php }}?>
</ul>
<table cellspacing=0 cellpadding=0 class="tab_list">
	<tr>
		<th align="center"></th>
		<th colspan="5"><div style="float:left;width:99%;margin-right:1%;text-align:left;"><?php if(isset($fy)){echo $fy;}?></div></th>
	</tr>
</table>

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






<?php $this->load->view('admin/footer')?>



