<?php $this->load->view('admin/header')?>
<div class="tips_text">
	<div style="float:left;width:500px;line-height:20px;">
		This is you User section. you can add, edit and delete user(s).
	</div>
</div>
	<?php $submenu=$this->session->userdata('submenu');?>
<div class="ma_actions" style="float:left;width:50%;">
	<ul>
		<li><b>操作 :</b></li>
		<li>
			<a href="<?php echo site_url('admins/user')?>"><font class="<?php if($submenu=='user'){echo 'nav_on';}else{echo 'nav_off';}?>">管理用户</font></a>
				<br/>
			<a href="<?php echo site_url('admins/user/toadd_user')?>"><font class="nav_off">添加用户</font></a>
		</li>
	</ul>
</div>
<div style="float:left;width:50%;">
	<form action="<?php echo site_url('admins/user/index')?>" method="get">
		<?php 
			$keyword=$this->input->get('keyword');
			$status=$this->input->get('status');
			$orderby=$this->input->get('orderby');
			$orderby_res=$this->input->get('orderby_res');
		?>
		<input name="keyword" type="text" placeholder="Enter your keywords" value="<?php echo $keyword;?>"/>
		<select name="status">
			<option value="">All</option>
			<option value="1" <?php if($status!=""&&$status==1){echo 'selected';}?>>Online</option>
			<option value="0" <?php if($status!=""&&$status==0){echo 'selected';}?>>Offline</option>
		</select>
		
		<input name="orderby" type="hidden" value="<?php echo $orderby;?>"/>
		<input name="orderby_res" type="hidden" value="<?php echo $orderby_res;?>"/>
		<input name="page" type="hidden" value="<?php echo $page;?>"/>
		<input type="submit" class="btn_2" value="<?php echo lang('cy_search')?>"/>
	</form>
	
	
</div>
	<?php 
		$orderby_res='ASC';
		if($this->input->get('orderby_res')!=''){
			if($this->input->get('orderby_res')=='ASC'){
				$orderby_res='DESC';
			}else{
				$orderby_res='ASC';
			}
		}
	?>
	<table class="tab_list" cellpadding="0" cellspacing="0">
		<tr valign="top">
			<th width="120" align="center"></th>
			<th width="150" align="left">昵称</th>
			<th align="left">邮箱</th>
			<th width="100">姓名</th>
			<th width="120">手机号码</th>
			<th width="60">状态</th>
			<th width="300">操作</th>
		</tr>
	<?php if(isset($user)){for($i=0;$i<count($user);$i++){?>
  	 	<tr style="background-color:<?php if($i%2==0){echo '#FFFFFF;';}else{echo '#f6f5f5;';}?>">
			<td align="center">
				<?php echo $i+1;?>
			</td>
			<td align="left">
			<?php 
				if($_GET){
					echo str_ireplace($keyword,'<font class="fonterror">'.$keyword.'</font>',$user[$i]['nickname']);
				}else{
					echo $user[$i]['nickname'];
				}
			?>
			</td>
			<td align="left">
			<?php 
				if($_GET){
					echo str_ireplace($keyword,'<font class="fonterror">'.$keyword.'</font>',$user[$i]['email']);
				}else{
					echo $user[$i]['email'];
				}
			?>
			</td>
			<td align="center"><?php $user[$i]['name']?>
			</td>
			<td align="center"><?php echo $user[$i]["mobile"];?></td>
			<td align="center">
				<?php if($user[$i]['is_status']==2){ ?>
					<?php echo '正常';?>
				<?php }else{?>
					<?php echo '已被删除';?>
				<?php } ?>
			</td>
			<td align="center">
				<a class="btn_2" href="<?php echo base_url().'index.php/admins/user/toedit_user/'.$user[$i]["user_id"]?>"><?php echo lang('cy_edit')?></a>
				&nbsp;&nbsp;
				<a class="btn_2" href="javascript:;" onclick="todel_user('<?php echo $user[$i]["user_id"]?>')"><?php echo lang('cy_delete')?></a>
			</td>
	    </tr>
  	<?php }}else{?>
  		<?php if ($_GET){?>
  			<tr><td colspan="7" align="center"><?php echo lang('nomatching_users')?></td></tr>
	    <?php }else{?>
	    	<tr><td colspan="7" align="center"><?php echo lang('no_users')?></td></tr>
	    <?php }?>
  	<?php }?>
	</table>
	<div class="houtai_fy">
<!--		<div style="float:left;margin:0px 10px 0px 15px;">-->
<!--			<input name="tooptionall" onclick="tooptionall()" type="checkbox"/> -->
<!--		</div>-->
<!--		<div style="float:left;margin:0px 10px 0px 15px;">-->
<!--			<input onclick="tosendemailtoresetpassword()" type="button" value=" Send "/>-->
<!--		</div>-->
		<div style="float:left;">
			<div id="fyarea">
				<?php if(isset($fy)){echo $fy;}?> 
			</div>
		</div>
	</div>
<script type="text/javascript">
<!--
	function tooptionall(){
		var uidarr=$('input[name="uid[]"]');
		var uidsendarr=$('input[name="uidsend[]"]');
		var tooptionallarr=$('input[name="tooptionall"]');
		for(var i=0;i<tooptionallarr.length;i++){
			if(tooptionallarr[i].checked==true){
				for(var j=0;j<uidarr.length;j++){
					if(uidsendarr[j].value==0){
						uidarr[j].checked=true;
					}else{
						uidarr[j].checked=false;
					}
				}
			}else{
				for(var j=0;j<uidarr.length;j++){
					uidarr[j].checked=false;
				}
			}
		}
	}

	function tosendemailtoresetpassword(){
		var width=350;
		$('.notice_taball').show();
		$(".message_tab").show();
		auto_box_location(width);
		$('.box_title').find("#title").html('email invitation');
		$.post(baseurl+"index.php/welcome/del_msgnotice_new",{text:'Do you want to send an email invitation?'},function (data){
			$(".box_content").html(data);
			$('.box_control').find("#content").html('<div style="width:170px;margin:0 auto;"><input onclick="sendemailtoresetpassword()" type="button" class="btn_1" value="'+L['ok']+'" /><input onclick="close_msg(0)" type="button" class="btn_1" value="'+L['cancel']+'"  style="margin-left:30px;"/></div>');
			auto_box_location(width);
		});
	}

	function sendemailtoresetpassword(){
		var newuidarr=[];
		var uidarr=$('input[name="uid[]"]');
		for(var i=0;i<uidarr.length;i++){
			if(uidarr[i].checked==true){
				newuidarr.push(uidarr[i].value);
			}
		}
		if(newuidarr.length>0){
			var j=0;
			var currentuid=0;
			$(".box_content").html('<table cellspacing=0 cellpadding=0 width="100%"><tr><td align="left"><div style="float:left;font-weight:bold;font-size:14px;margin:4px 0px 0px 150px;"><img src="'+baseurl+'themes/default/images/indicator.gif"/></div></td></tr></table>');
			$('.box_control').find("#content").html('');
			for(var aa=0;aa<newuidarr.length;aa++){
				currentuid=newuidarr[aa];
				$.post(baseurl+'index.php/member/tosendemailtoresetpassword/'+currentuid,function (data){
					$('#sentedddd_'+data).show();
					$('#reset_'+data).show();
					$('#close_'+data).hide();
					$('#uid_'+data).hide();
					$('#uidsend_'+data).val(1);
					$('input[id="uid_'+data+'"]')[0].checked=false;

					j++;
					if(j==newuidarr.length){
						$(".box_content").html('<table cellspacing=0 cellpadding=0 width="100%"><tr><td align="left" width="32"><div class="box_tips_yes"></td><td align="left"><div style="float:left;font-weight:bold;font-size:14px;margin:4px 0px 0px 10px;">'+j+' users has been sent</div></td></tr></table>');
						$('.box_control').find("#content").html('<div style="width:80px;margin:0 auto;"><input onclick="close_msg(0)" type="button" class="btn_1" value="'+L['cancel']+'"/></div>');
					}
				})
			}
		}
	}
	$('.section_tips #tips_text').css('behavior','url('+baseurl+'themes/default/pie.htc)');
//-->
</script>
<?php $this->load->view('admin/footer')?>