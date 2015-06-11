<?php $this->load->view('admin/header')?>
<form action="<?php echo base_url().'?c=adminchallenge&m=edit_challenge'?>" method="post">
<table cellspacing=1 cellpadding=0 width="98%" style="margin-left:1%;color:black;">
	<tr>
		<td>
			<table width="100%">
				<tr>
					<td width="120" align="right">名称&nbsp;&nbsp;</td>
					<td align="left">
						<div style="float:left;"><input type="text" style="width:500px;" name="challenge_name" value="<?php echo $challengeinfo['challenge_name'];?>" /></div>
				    </td>
				</tr>
				<tr>
				    <td colspan="2">
				    	<div style="float:left;width:100%;margin:5px 0px 5px 0px;border-top:1px solid #999999;line-height:1px;">&nbsp;</div>
				    </td>
				</tr>
			
				<tr>
					<td width="120" align="right">开放时间&nbsp;&nbsp;</td>
					<td align="left">
						<div style="float:left;">
							<input type="radio" name="challenge_shichang" id="shichang_1" onclick="tochooseshichang(1)" value="-1" <?php if($challengeinfo['challenge_shichang']==-1){echo 'checked';}?>/> <label for="shichang_1">关闭</label>
	                		<input type="radio" name="challenge_shichang" id="shichang_2" onclick="tochooseshichang(2)" value="0" <?php if($challengeinfo['challenge_shichang']==0){echo 'checked';}?>/> <label for="shichang_2">无限时</label>
	                		<input type="radio" name="challenge_shichang" id="shichang_3" onclick="tochooseshichang(3)" value="30" <?php if($challengeinfo['challenge_shichang']==30){echo 'checked';}?>/> <label for="shichang_3">30天</label>
	                		<input type="radio" name="challenge_shichang" id="shichang_4" onclick="tochooseshichang(4)" value="60" <?php if($challengeinfo['challenge_shichang']==60){echo 'checked';}?>/> <label for="shichang_4">60天</label>
	                		<input type="radio" name="challenge_shichang" id="shichang_5" onclick="tochooseshichang(5)" value="-2" <?php if($challengeinfo['challenge_shichang']!=-1&&$challengeinfo['challenge_shichang']!=0&&$challengeinfo['challenge_shichang']!=30&&$challengeinfo['challenge_shichang']!=60){echo 'checked';}?>/> <label for="shichang_5">自定义</label>
							<span id="didingyi_area" <?php if($challengeinfo['challenge_shichang']!=-1&&$challengeinfo['challenge_shichang']!=0&&$challengeinfo['challenge_shichang']!=30&&$challengeinfo['challenge_shichang']!=60){echo '';}else{echo 'style="display:none;"';}?>>
								<input type="text" style="width:50px;" name="zidingyi_shichang"  value="<?php echo $challengeinfo['challenge_shichang'];?>"/> 天
							</span>
						</div>
						<script>
							function tochooseshichang(num){
								if(num==5){
									$('#didingyi_area').show();
								}else{
									$('#didingyi_area').hide();
								}
							}
						</script>
				    </td>
				</tr>
				<tr>
				    <td colspan="2">
				    	<div style="float:left;width:100%;margin:5px 0px 5px 0px;border-top:1px solid #999999;line-height:1px;">&nbsp;</div>
				    </td>
				</tr>
				
				<tr>
					<td width="120" align="right">简要描述 &nbsp;&nbsp;<br />(显示在列表)&nbsp;&nbsp;</td>
					<td align="left">
						<div style="float:left;">
							<textarea name="challenge_profile" style="float:left;width:800px;height:80px;"><?php echo $challengeinfo['challenge_profile'];?></textarea>
						</div>
				    </td>
				</tr>
				<tr>
				    <td colspan="2">
				    	<div style="float:left;width:100%;margin:5px 0px 5px 0px;border-top:1px solid #999999;line-height:1px;">&nbsp;</div>
				    </td>
				</tr>
			
				<tr>
					<td width="120" align="right">简要描述 &nbsp;&nbsp;<br />(显示在详细页)&nbsp;&nbsp;</td>
					<td align="left">
						<div style="float:left;">
							<textarea name="challenge_description" style="float:left;width:800px;height:200px;"><?php echo $challengeinfo['challenge_description'];?></textarea>
						</div>
				    </td>
				</tr>
				<tr>
				    <td colspan="2">
				    	<div style="float:left;width:100%;margin:5px 0px 5px 0px;border-top:1px solid #999999;line-height:1px;">&nbsp;</div>
				    </td>
				</tr>
			    <tr>
				    <td width="120" align="right"></td>
				    <td align="left">
				    	<input name="backurl" type="hidden" value="<?php echo $backurl;?>" />
				    	<input name="challenge_id" type="hidden" value="<?php echo $challengeinfo['challenge_id'];?>" />
				    	<input name="key" type="hidden" value="<?php echo $challengeinfo['key'];?>" />
				   		<input type="submit" value="保存" style="float:left;background:#018E01;border:0px;color:white;padding:4px 15px 4px 15px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;"/>
				    </td>
			    </tr>
			</table>
		</td>
	</tr>
</table>
</form>
<?php $this->load->view('admin/footer')?>