<?php $this->load->view('admin/header')?>
<form action="<?php echo base_url().'?c=adminchallenge&m=add_challenge'?>" method="post">
<table cellspacing=1 cellpadding=0 width="98%" style="margin-left:1%;color:black;">
	<tr>
		<td>
			<table width="100%">
				<tr>
					<td width="120" align="right">名称&nbsp;&nbsp;</td>
					<td align="left">
						<div style="float:left;"><input type="text" style="width:500px;" name="challenge_name" value="" /></div>
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
				   		<input type="submit" value="保存" style="float:left;background:#018E01;border:0px;color:white;padding:4px 15px 4px 15px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;"/>
				    </td>
			    </tr>
			</table>
		</td>
	</tr>
</table>
</form>
<?php $this->load->view('admin/footer')?>