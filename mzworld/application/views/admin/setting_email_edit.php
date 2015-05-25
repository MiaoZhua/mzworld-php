<?php $this->load->view('admin/header')?>
<div class="tips_text">
	<div style="float:left;width:500px;line-height:20px;">
		<?php echo lang('password_desc')?>
	</div>
</div>

<?php $submenu=$this->session->userdata('submenu');?>
<div class="ma_actions" >
	<div class="<?php if($submenu=='setting'){echo 'nav_on_main';}else{echo 'nav_off_main';}?>">
		<a href="<?php echo site_url('admins/setting')?>"><font style="text-decoration:none;" class="<?php if($submenu=='setting'){echo 'nav_on';}else{echo 'nav_off';}?>"><?php echo lang('company_infomation')?></font></a>
	</div>
	<div class="<?php if($submenu=='editpassword'){echo 'nav_on_main';}else{echo 'nav_off_main';}?>">
		<a href="<?php echo site_url('admins/setting/editpassword')?>"><font style="text-decoration:none;" class="<?php if($submenu=='editpassword'){echo 'nav_on';}else{echo 'nav_off';}?>"><?php echo lang('password_manage')?></font></a>
	</div>
	<div class="<?php if($submenu=='email'){echo 'nav_on_main';}else{echo 'nav_off_main';}?>">
		<a href="<?php echo site_url('admins/setting/emaillist')?>"><font style="text-decoration:none;" class="<?php if($submenu=='email'){echo 'nav_on';}else{echo 'nav_off';}?>"><?php echo lang('email_manage')?></font></a>
	</div>
</div>

	<form action="<?php echo base_url().'index.php/admins/setting/editemail'?>" method="post" enctype="multipart/form-data">
		<table cellspacing=0 cellpadding=0 class="tab_post">
				<tr>
					<td align="right"><?php echo lang('email_parameter');?> &nbsp;&nbsp;</td>
					<td>
						<div style="float:left;border:1px solid #ccc;width:720px;padding:10px 10px 10px 10px;">
							<?php 
							$parameter=$emailinfo['email_parameter'];
							if($parameter!=""){
								$parameter=unserialize($parameter);
							}else{
								$parameter=array();
							}
							if(!empty($parameter)){
								for($i=0;$i<count($parameter);$i++){
									echo '<div style="float:left;width:180px;line-height:30px;">'.$parameter[$i].'</div>';
								}
							}
							?>
							
						</div>
					</td>
				</tr>
				<tr>
					<td align="right"><?php echo lang('email_from');?>&nbsp;&nbsp;</td>
					<td><input style="width:700px;" type="text" name="email_from" id="email_from" class="validate[required] text-input" value="<?php if(set_value('email_from')!=""){echo set_value('email_from');}else{echo $emailinfo['email_from'];}?>"/> <font color="red">* <?php echo form_error('email_from')?></font></td>
				</tr>
				<tr>
					<td align="right"><?php echo lang('email_sender');?>&nbsp;&nbsp;</td>
					<td><input style="width:700px;" type="text" name="email_sender" id="email_sender" value="<?php if(set_value('email_sender')!=""){echo set_value('email_sender');}else{echo $emailinfo['email_sender'];}?>"/> <font color="red"><?php echo form_error('email_sender')?></font></td>
				</tr>
				<tr>
					<td align="right"><?php echo lang('email_reply_to');?> &nbsp;&nbsp;</td>
					<td><input style="width:700px;" type="text" name="email_replyto" id="email_replyto" value="<?php if(set_value('email_replyto')!=""){echo set_value('email_replyto');}else{echo $emailinfo['email_replyto'];}?>"/> <font color="red"><?php echo form_error('email_replyto')?></font></td>
				</tr>
				<tr>
					<td align="right"><?php echo lang('email_to');?> &nbsp;&nbsp;</td>
					<td><input style="width:700px;" type="text" name="email_to" id="email_to" class="validate[required] text-input" value="<?php if(set_value('email_to')!=""){echo set_value('email_to');}else{echo $emailinfo['email_to'];}?>"/> <font color="red">* <?php echo form_error('email_to')?></font></td>
				</tr>
				<tr>
					<td align="right"><?php echo lang('email_cc');?> &nbsp;&nbsp;</td>
					<td><input style="width:700px;" type="text" name="email_cc" id="email_cc" value="<?php if(set_value('email_cc')!=""){echo set_value('email_cc');}else{echo $emailinfo['email_cc'];}?>"/> <font color="red"><?php echo form_error('email_cc')?></font></td>
				</tr>
				<tr>
					<td align="right"><?php echo lang('email_bcc');?> &nbsp;&nbsp;</td>
					<td><input style="width:700px;" type="text" name="email_bcc" id="email_bcc" value="<?php if(set_value('email_bcc')!=""){echo set_value('email_bcc');}else{echo $emailinfo['email_bcc'];}?>"/> <font color="red"><?php echo form_error('email_bcc')?></font></td>
				</tr>
				<?php 
				$langarr=languagelist();
				for($i=0;$i<count($langarr);$i++){
				?>
				<tr>
					<td colspan="2" align="left" class="gksel_languageline"><?php echo $langarr[$i]['lang_name_ch']?></td>
				</tr>
				
				<tr>
					<td width="150" align="right"><?php echo lang('email_list_name');?> &nbsp;&nbsp;</td>
					<td><input style="width:700px;" type="text" name="email_name<?php echo $langarr[$i]['langtype']?>" id="email_name<?php echo $langarr[$i]['langtype']?>" class="validate[required] text-input" value="<?php if(set_value('email_name'.$langarr[$i]['langtype'])!=""){echo set_value('email_name'.$langarr[$i]['langtype']);}else{if(isset($emailinfo)){echo $emailinfo['email_name'.$langarr[$i]['langtype']];}}?>"/> <font color="red">* <?php echo form_error('email_name'.$langarr[$i]['langtype'])?></font></td>
				</tr>
				<tr>
					<td width="120px" align="right"><?php echo lang('email_subject_name');?> &nbsp;&nbsp;</td>
					<td><input style="width:700px;" type="text" name="email_subject<?php echo $langarr[$i]['langtype'];?>" id="email_subject<?php echo $langarr[$i]['langtype'];?>" class="validate[required] text-input" value="<?php if(set_value('email_subject'.$langarr[$i]['langtype'])!=""){echo set_value('email_subject'.$langarr[$i]['langtype']);}else{echo $emailinfo['email_subject'.$langarr[$i]['langtype']];}?>"/> <font color="red">* <?php echo form_error('email_subject'.$langarr[$i]['langtype'])?></font></td>
				</tr>
				<tr>
					<td width="120px" align="right"><?php echo lang('email_desc')?>&nbsp;&nbsp;</td>
					<td>
						<textarea class="ckeditor" name="email_content<?php echo $langarr[$i]['langtype']?>" id="email_content<?php echo $langarr[$i]['langtype']?>"><?php if(set_value('email_content'.$langarr[$i]['langtype'])!=null){echo set_value('email_content'.$langarr[$i]['langtype']);}else{echo $emailinfo['email_content'.$langarr[$i]['langtype']];}?></textarea>				
						<font class="fonterror"><?php echo form_error('content'.$langarr[$i]['langtype']);?><?php if(isset(${'contenterror'.$langarr[$i]['langtype']}))echo ${'contenterror'.$langarr[$i]['langtype']};?></font>
					</td>
				</tr>
				<?php }?>
				<tr>
					<td>
						<input name="email_id" type="hidden" value="<?php echo $emailinfo['email_id'];?>"/>
					</td>
					<td>
<!--						<input type="button" value="Preview" onclick="topreviewemail()"/>-->
						<input type="submit" value="<?php echo lang('cy_save');?>" />
					</td>
				</tr>
			</table>
	</form>
<!--<script type="text/javascript">-->
<!--var langarr=[];-->
<!--var langtext=[];-->
<!--<?php //for($i=0;$i<count($langarr);$i++){?>-->
<!--		langarr.push('<?php //echo $langarr[$i]['langtype'];?>');-->
<!--		langtext.push('<?php //echo $langarr[$i]['lang_name_ch'];?>');-->
<!--		var email_content<?php //echo $langarr[$i]['langtype'];?> = CKEDITOR.replace('email_content<?php echo $langarr[$i]['langtype']?>', {-->
<!--		width:850,height:250,-->
<!--		toolbar: [-->
<!--					[ 'Bold', 'Italic', 'Underline','Strike', '-','Subscript','Superscript' ],-->
<!--					[ 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink' ],-->
<!--					[ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ],-->
<!--					[ 'Font', 'FontSize', 'TextColor', 'BGColor' ],-->
<!--					[ 'Image', 'Table', 'SpecialChar']-->
<!--				]-->
<!--		});-->
<!--<?php //}?>-->
<!--</script>-->

<?php $this->load->view('admin/footer')?>
