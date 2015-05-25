<?php $this->load->view('admin/header')?>
	<div class="tips_text">
		<div style="float:left;width:500px;line-height:20px;">
			<?php //echo $category_info['tips'];?>
		</div>
	</div>


<div class="ma_actions">
	<ul>
		<li><b>操作 :</b></li>
		<li>
			<a href="javascript:;"><font class="nav_on">管理召集</font></a>
			<br/><a href="<?php echo site_url('admins/'.$this->controller.'/toadd_subcategory')?>"><font class="nav_off">添加召集</font></a>
		</li>
	</ul>
</div>


	
<table cellspacing=0 cellpadding=0 class="tab_list">
	<tr>
		<th height="30" width="100">S/N</th>  	
		<th style="text-align:left;">名称</th>
		<th width="130">创建时间</th>
		<th width="200">
			操作
		</th>
	</tr>
	<?php 
		if(!empty($challengelist)){
			for($i=0;$i<count($challengelist);$i++){
	?>
				<tr>  	
					<td width="100" align="center" height="30"><?php echo $i+1;?></td>
					<td align="left"><?php echo $challengelist[$i]['challenge_name'];?></td>
					<td width="130" align="center"><?php echo date('Y-m-d',$challengelist[$i]['created'])?></td>
					<td width="200" align="center">
						<a href="<?php echo base_url().'?c=adminchallenge&m=article_list&challenge_id='.$challengelist[$i]['challenge_id'].'&key='.$challengelist[$i]['key']?>">参赛作品</a>
						&nbsp;&nbsp;
						<a href="<?php echo base_url().'?c=adminchallenge&m=toedit_challenge&challenge_id='.$challengelist[$i]['challenge_id'].'&key='.$challengelist[$i]['key']?>">修改</a>
						&nbsp;&nbsp;
						<a href="javascript:;" onclick="todel_category(<?php echo $challengelist[$i]['challenge_id'];?>)">删除</a>
					</td>
				</tr>
	<?php }}?>
</table>
<?php $this->load->view('admin/footer')?>



