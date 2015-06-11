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
			<br/><a href="<?php echo base_url().'?c=adminchallenge&m=toadd_challenge'?>"><font class="nav_off">添加召集</font></a>
		</li>
	</ul>
</div>


	
<table cellspacing=0 cellpadding=0 class="tab_list">
	<tr>
		<th height="30" width="100">S/N</th>  	
		<th style="text-align:left;">名称</th>
		<th width="130">作者</th>
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
					<td align="left">
						<div style="float:left;width:100%;">
							<?php echo $challengelist[$i]['challenge_name'];?>
						</div>
						<div style="float:left;width:100%;color:gray;margin:5px 0px 0px 0px;">
							<?php 
								echo '开放时长：';
								if($challengelist[$i]['challenge_shichang']==-1){
									echo '关闭';
								}else if($challengelist[$i]['challenge_shichang']==0){
									echo '无限时';
								}else{
									echo $challengelist[$i]['challenge_shichang'].'天';
//									$d   =   "2009-07-08 10:19:00";
//									echo   date("Y-m-d",strtotime("$d   +1   day"));   //日期天数相加函数
									echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;对应截止日期：'.date('Y-m-d',strtotime(date('Y-m-d',$challengelist[$i]['created'])."   + ".$challengelist[$i]['challenge_shichang']." day"));
								}
							?>
						</div>
					</td>
					<td width="130" align="center">
						<?php 
						if($challengelist[$i]['user_id']>0){
							echo $challengelist[$i]['nickname'];
						}else{
							echo '官方';
						}
						?>
					</td>
					<td width="130" align="center"><?php echo date('Y-m-d',$challengelist[$i]['created'])?></td>
					<td width="200" align="center">
						<?php 
							//获取召集的作品的数量
							$sql="SELECT count(*) AS count FROM px_opus WHERE type_id=".$challengelist[$i]['challenge_id']." ORDER BY opus_id ASC";
							$num_res=$this->db->query($sql)->row_array();
							if(!empty($num_res)){
								$num=$num_res['count'];
							}else{
								$num=0;
							}
						?>
						<a href="<?php echo base_url().'?c=adminchallenge&m=zuopin_list&challenge_id='.$challengelist[$i]['challenge_id'].'&key='.$challengelist[$i]['key']?>">参赛作品 <?php if($num>0){echo '<font style="color:red;">('.$num.')</font>';}?></a>
						&nbsp;&nbsp;
						<a href="<?php echo base_url().'?c=adminchallenge&m=toedit_challenge&challenge_id='.$challengelist[$i]['challenge_id'].'&key='.$challengelist[$i]['key']?>">修改</a>
						&nbsp;&nbsp;
						<a href="javascript:;" onclick="todel_challenge(<?php echo $challengelist[$i]['challenge_id'];?>)">删除</a>
					</td>
				</tr>
	<?php }}?>
</table>
<?php $this->load->view('admin/footer')?>



