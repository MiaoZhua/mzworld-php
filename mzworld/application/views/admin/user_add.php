<?php $this->load->view('admin/header')?>
	<form action="<?php echo base_url().'index.php/admins/user/add_user'?>" method="post" enctype="multipart/form-data">
		<table cellspacing=0 cellpadding=0 class="tab_post">
			<tr><td height="10px"></td></tr>
			<tr>
				<td width="120" height="32" align="right">Email&nbsp;&nbsp;</td>
				<td>
					<div class="tabmes_l"><input type="text" autocomplete="off" class="houtai_input" name="email" value="<?php if(set_value('email')!=null){echo set_value('email');}else{if(form_error('email')!=""){echo '';}else{echo '';}}?>"/></div>
					<div class="tabmes_r"><font class="fonterror">*</font></div>
				</td>
				<td class="houtai_td_bg">
					<font class="fonterror"><?php echo form_error('email')?></font>
				</td>
			</tr>
			<tr>
				<td width="120" height="32" align="right">Type&nbsp;&nbsp;</td>
				<td>
					<div class="tabmes_l">
						<?php 
							if(set_value('type')!=null){
								$type=set_value('type');
							}else{
								if(form_error('type')!=""){
									$type='';
								}else{
									$type='';
								}
							}
						?>
						<select name="type">
							<option value="1" <?php if($type==1){echo 'selected';}?>>Normal Profile</option>
							<option value="2" <?php if($type==2){echo 'selected';}?>>Distributor</option>
						</select>
					</div>
				</td>
				<td class="houtai_td_bg">
					
				</td>
			</tr>
			<tr>
				<td width="120" height="32" align="right">Firstname&nbsp;&nbsp;</td>
				<td>
					<div class="tabmes_l"><input type="text" autocomplete="off" class="houtai_input" name="firstname" value="<?php if(set_value('firstname')!=null){echo set_value('firstname');}else{if(form_error('firstname')!=""){echo '';}else{echo '';}}?>"/></div>
					<div class="tabmes_r"><font class="fonterror">*</font></div>
				</td>
				<td class="houtai_td_bg">
					<?php if(form_error('firstname')!=''){?>
						<div class="input_tips_error"><font class="fonterror"><?php echo form_error('firstname')?></font></div>
					<?php }else{?>
						<div class="input_tips" id="firstname_tips"><?php echo lang('user_enter_firstname')?></div>
					<?php }?>
				</td>
			</tr>
			<tr>
				<td height="32" align="right">Lastname&nbsp;&nbsp;</td>
				<td>
					<div class="tabmes_l"><input type="text" autocomplete="off" class="houtai_input" name="lastname" value="<?php if(set_value('lastname')!=null){echo set_value('lastname');}else{if(form_error('lastname')!=""){echo '';}else{echo '';}}?>"/></div>
					<div class="tabmes_r"><font class="fonterror">*</font></div>
				</td>
				<td class="houtai_td_bg">
					<?php if(form_error('lastname')!=''){?>
						<div class="input_tips_error"><font class="fonterror"><?php echo form_error('lastname')?></font></div>
					<?php }else{?>
						<div class="input_tips" id="lastname_tips"><?php echo lang('user_enter_lastname')?></div>
					<?php }?>
				</td>
			</tr>
			<tr>
				<td height="32" align="right">Phone&nbsp;&nbsp;</td>
				<td>
					<div class="tabmes_l"><input type="text" autocomplete="off" class="houtai_input" name="phone" value="<?php if(set_value('phone')!=null){echo set_value('phone');}else{if(form_error('phone')!=""){echo '';}else{echo '';}}?>"/></div>
					<div class="tabmes_r"><font class="fonterror">*</font></div>
				</td>
				<td class="houtai_td_bg">
					<?php if(form_error('phone')!=''){?>
						<div class="input_tips_error"><font class="fonterror"><?php echo form_error('phone')?></font></div>
					<?php }else{?>
						<div class="input_tips" id="phone_tips"><?php echo lang('user_enter_phone')?></div>
					<?php }?>
				</td>
			</tr>
			
			
			<tr>
				<td height="32" align="right">Company Name&nbsp;&nbsp;</td>
				<td>
					<div class="tabmes_l"><input type="text" class="houtai_input" name="company_name" value="<?php if(set_value('company_name')!=null){echo set_value('company_name');}else{if(form_error('company_name')!=""){echo '';}else{echo '';}}?>"/></div>
					<div class="tabmes_r"><font class="fonterror">*</font></div>
				</td>
				<td class="houtai_td_bg">
					<?php if(form_error('company_name')!=''){?>
						<div class="input_tips_error"><font class="fonterror"><?php echo form_error('company_name')?></font></div>
					<?php }else{?>
						<div class="input_tips" id="company_name_tips"><?php echo lang('user_enter_company_name')?></div>
					<?php }?>
				</td>
			</tr>
			
			<tr>
				<td height="32" align="right">Country&nbsp;&nbsp;</td>
				<td>
					<div class="tabmes_l"><input type="text" class="houtai_input" name="country" value="<?php if(set_value('country')!=null){echo set_value('country');}else{if(form_error('country')!=""){echo '';}else{echo '';}}?>"/></div>
					<div class="tabmes_r"><font class="fonterror">*</font></div>
				</td>
				<td class="houtai_td_bg">
					<?php if(form_error('country')!=''){?>
						<div class="input_tips_error"><font class="fonterror"><?php echo form_error('country')?></font></div>
					<?php }else{?>
						<div class="input_tips" id="country_tips"><?php echo lang('user_enter_country')?></div>
					<?php }?>
				</td>
			</tr>
			
			
			
			<tr>
				<td height="32" align="right" >Password&nbsp;&nbsp;</td>
				<td width="170" >
					<div class="tabmes_l"><input type="password" autocomplete="off" class="houtai_input" name="password" value=""/></div>
				</td>
				<td class="houtai_td_bg" >
					<font class="fonterror"><?php echo form_error('password')?></font>
				</td>
			</tr>
			<tr>
				<td height="32" align="right">
					
				</td>
				<td><input type="submit" value=" Save " class="btn_5" /></td>
			</tr>
		</table>
	</form>	
	
	
	
<?php $this->load->view('admin/footer')?>
