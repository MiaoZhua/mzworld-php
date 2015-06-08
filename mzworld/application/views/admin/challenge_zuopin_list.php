<?php $this->load->view('admin/header')?>
	<div class="tips_text">
		<div style="float:left;width:500px;line-height:20px;">
			<?php //echo $category_info['tips'];?>
		</div>
	</div>


<?php 
	$reparr=array();
	$reparr[]=array('name'=>'/mzworld','value'=>'');
	$reparr1=array();
	$reparr1[]=array('name'=>"\\",'value'=>'/');
	
	
	$dobaseurl=replace_content($reparr,base_url());
?>
<table cellspacing=0 cellpadding=0 class="tab_list">
	<tr>
		<th height="30" width="100">S/N</th>  
		<th width="120">缩略图</th>
		<th style="text-align:left;">名称</th>
		<th width="130">创建时间</th>
		<th width="200">
			操作
		</th>
	</tr>
	<?php 
		if(!empty($zuopin_list)){
			for($i=0;$i<count($zuopin_list);$i++){
	?>
				<tr>  	
					<td width="100" align="center" height="30"><?php echo $i+1;?></td>
					<td width="120" align="center">
						<?php 
						$thumb=$zuopin_list[$i]['thumb'];
						if($thumb!=""&&file_exists('../uploads/'.$thumb)){
							$thumb=$dobaseurl.'uploads/'.$thumb;
						}else{
							$thumb=$dobaseurl.'assets/static/images/content/work_img2.png';
						}
						?>
						<img style="float:left;width:100px;padding:0px 10px 0px 10px;" src="<?php echo $thumb;?>"/>
					</td>
					<td align="left"><?php echo $zuopin_list[$i]['title'];?></td>
					<td width="130" align="center"><?php echo date('Y-m-d',$zuopin_list[$i]['add_date'])?></td>
					<td width="200" align="center">
<!--						<a href="<?php echo base_url().'?c=adminchallenge&m=toedit_challenge&opus_id='.$zuopin_list[$i]['opus_id']?>">修改</a>-->
<!--						&nbsp;&nbsp;-->
<!--						<a href="javascript:;" onclick="todel_category(<?php echo $zuopin_list[$i]['opus_id'];?>)">删除</a>-->
					</td>
				</tr>
	<?php }}?>
</table>
<?php $this->load->view('admin/footer')?>



