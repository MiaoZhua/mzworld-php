<?php $this->load->view('admin/header')?>
<?php $emaillist_name=$this->input->get('cms_name');?>
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
<div class="tips_text">
	<div style="float:left;width:500px;line-height:20px;">
		<?php echo lang('email_desc')?>
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

	<table class="tab_list" cellpadding="0" cellspacing="0">
		<tr valign="top">
			<th width="50" align="center"></th>
			<th align="left"><?php echo lang('cy_name')?></th>
			<th align="left">From</th>
			<th align="left">To</th>
			<th width="100"><?php echo lang('cy_created')?></th>
			<th width="300">操作</th>
		</tr>
	<?php if(isset($emaillist)){for($i=0;$i<count($emaillist);$i++){?>
  	 	<tr style="background-color:<?php if($i%2==0){echo '#FFFFFF;';}else{echo '#f6f5f5;';}?>">
			<td align="center"><?php echo $i+1;?></td>
			<td align="left"><?php echo $emaillist[$i]['email_name'.$this->langtype];?></td>
			<td align="left"><?php echo $emaillist[$i]['email_from'];?></td>
			<td align="left"><?php echo $emaillist[$i]['email_to'];?></td>
			<td align="center"><?php echo date('Y-m-d',$emaillist[$i]["edited"]);?></td>
			<td align="center">
				<?php if($i==1){?>
<!--					<a class="btn_2" href="<?php echo base_url().'index.php/admins/setting/tomanage_Elpepcb_emaillist'?>">Product emails</a>-->
<!--					&nbsp;&nbsp;-->
				<?php }else if($i==2){?>
<!--					<a class="btn_2" href="<?php echo base_url().'index.php/admins/setting/tomanage_Elpeguard_emaillist'?>">Product emails</a>-->
<!--					&nbsp;&nbsp;-->
				<?php }?>
				<a class="btn_2" href="<?php echo base_url().'index.php/admins/setting/toeditemail/'.$emaillist[$i]["email_id"]?>"><?php echo lang('cy_edit')?></a>
			</td>
	    </tr>
  	<?php }}?>
	</table>
	<div class="houtai_fy"><?php if(isset($fy)){echo $fy;}?></div>
<?php $this->load->view('admin/footer')?>