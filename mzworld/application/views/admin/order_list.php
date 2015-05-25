<?php $this->load->view('admin/header');?>
	<?php $order_number=$this->input->get('order_number');?>
	<div class="tips_text">
		<table cellspacing="0" cellpadding="0" width="100%;">
			<tr>
				<td align="left">
					<div style="float:left;width:500px;line-height:20px;">
						
					</div>
				</td>
				<td width="380" valign="bottom">
					<form action="<?php echo base_url().'admins/order/index'?>" method="get">
						<table cellspacing=0 cellpadding=0 border=0>
							<tr>
								<td>
									<input type="hidden" name="page" style="width:30px;" value="<?php echo $page?>"/>
									<input type="text" name="order_number" value="<?php echo $order_number?>" placeholder="<?php echo lang('cy_enter_search_name')?>" class="user_list_search_input"/></td>
								<td width="80"><input class="btn_2" type="submit" value="<?php echo lang('cy_search')?>" /></td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
		</table>
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
	
	<div style="float:left;width:100%;margin-top:10px;">
		<?php 
			$valueinfo=$this->session->userdata('search_order_status');
			if ($valueinfo!=''){
				$select_zero='';
				$select_one='';
				$select_two='';
				$select_three='';
				
				if ($valueinfo==0){
					$select_zero='selected="selected"';
				}else if ($valueinfo==1){
					$select_one='selected="selected"';
				}else if ($valueinfo==2){
					$select_two='selected="selected"';
				}else if ($valueinfo==3){
					$select_three='selected="selected"';
				}
			}else{
				$select_zero='';
				$select_one='';
				$select_two='';
				$select_three='';
			}
			
		?>
		<table width="100%" cellpadding="0" cellspacing="0" border=0>
			<tr>
				<td width="150">
					<div style="float:left;margin:10px 0px 10px 0px;">
						<input onclick="tooptionallqwe()" name="tooptionall" id="tooptionall" type="checkbox" />
						<label class="quanxuan" for="tooptionall">全选</label>
						<label class="fanxuan" for="tooptionall" style="display:none;">反选</label>
					</div>
					<div style="float:left;margin:10px 0px 10px 10px;">
						<input onclick="topiliangaction('delete')" type="button" value="<?php echo '批量删除'?>"/>
					</div>
				</td>
				<td width="150">
					<span style="font-weight: bolder;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;选择订单状态信息:&nbsp;&nbsp;</span>
				</td>
				
				<td width="10px">
					<select style="width:290px;" id="search_order_status">
						<option value="" >选择订单状态</option>
						<option value="0" <?php echo $select_zero;?>>买家还未付款</option>
						<option value="1" <?php echo $select_one;?>>等待卖家发货/买家已付款</option>
						<option value="2" <?php echo $select_two;?>>卖家已发货</option>
						<option value="3" <?php echo $select_three;?>>交易成功</option>
					</select>
				</td>
				<td width="10px">
					&nbsp;
				</td>
				<td>
					&nbsp;
				</td>
				<td>
				</td>
			</tr>
			<tr><td height="10px"></td></tr>
		</table>
		<script>
			$(document).ready(function (){
				$('#search_order_status').change(function (){
					var valueinfo = $(this).val();
					$.post(baseurl+"admins/order/search_order_status",{valueinfo:valueinfo},function (data){
						location.href=baseurl+"admins/order/index/";
					});
				})
			})
		</script>
	</div>
	<div style="float:left;width:100%;">
		<table class="tab_list" cellpadding="0" cellspacing="0">
			<tr valign="top">
				<th width="50"></th>
				<th width="120" align="left"><a href="<?php echo site_url('admins/order/index?order_number='.$order_number.'&page='.$page.'&orderby=order_number&orderby_res='.$orderby_res)?>"><?php echo lang('order_number')?></a></th>
				<th width="150" align="left">&nbsp;&nbsp;<a href="<?php echo site_url('admins/order/index?order_number='.$order_number.'&page='.$page.'&orderby=username&orderby_res='.$orderby_res)?>">User Information</a></th>
				<th width="100" align="center">Product Price</th>
				<th width="80" align="center">Express Price</th>
				<th width="80" align="center"><a href="<?php echo site_url('admins/order/index?order_number='.$order_number.'&page='.$page.'&orderby=total_price_rmb&orderby_res='.$orderby_res)?>">Total Price</a></th>
				<th width="100"><a href="<?php echo site_url('admins/order/index?order_number='.$order_number.'&page='.$page.'&orderby=created&orderby_res='.$orderby_res)?>">Order Date</a></th>
				<th width="80"><a href="<?php echo site_url('admins/order/index?order_number='.$order_number.'&page='.$page.'&orderby=status&orderby_res='.$orderby_res)?>">Order Status</a></th>
				<th width="250">Actions</th>
			</tr>
		<?php if(isset($order)){for($i=0;$i<count($order);$i++){?>
	  	 	<tr style="background-color:<?php if($i%2==0){echo '#FFFFFF;';}else{echo '#f6f5f5;';}?>">
				<td align="center">
					<input type="checkbox" name="order_id[]" value="<?php echo $order[$i]['order_id'];?>"/>
				</td>
				<td align="left">
					<?php 
						if($_GET){
							echo str_ireplace($order_number,'<font class="fonterror">'.$order_number.'</font>',$order[$i]['order_number']);
						}else{
							echo $order[$i]['order_number'];
						}
					?>
				</td>
				<td align="left">
					<div style="float:left;width:100%;">
						<?php echo $order[$i]['username']?>
					</div>
					<div style="float:left;width:100%;margin:3px 0px 0px 0px;">
						<?php echo $order[$i]['phone'];?>
					</div>
					<div style="float:left;width:100%;margin:3px 0px 0px 0px;">
						<?php echo $order[$i]['email'];?>
					</div>
				</td>
				<td align="center">
					<?php 
						$product_price_geshi=number_format($order[$i]['product_price'.$order[$i]['moneytype']],2,".","");
						$youhui_price_geshi=number_format($order[$i]['youhui_price'.$order[$i]['moneytype']],2,".","");
						
						if($order[$i]['youhui_zhekou']==1){
							echo $order[$i]['moneysign'].' '.number_format(($product_price_geshi-$youhui_price_geshi),2,".","");
						}else{
							echo $order[$i]['moneysign'].' '.number_format(($product_price_geshi-$youhui_price_geshi),2,".","");
							echo '<br /><font style="color:gray;">优惠了<font style="color:#EAA228;font-weight:bold;">'.$order[$i]['moneysign'].' '.$youhui_price_geshi.'</font></font>';
						}
						
					?>
				</td>
				<td align="center">
					<?php 
						$express_price_geshi=number_format($order[$i]['express_price'.$order[$i]['moneytype']],2,".","");
						echo $order[$i]['moneysign'].' '.$express_price_geshi;
					?>
				</td>
				<td align="center">
					<?php 
						$total_price_geshi=number_format($order[$i]['total_price'.$order[$i]['moneytype']],2,".","");
						$youhui_price_geshi=number_format($order[$i]['youhui_price'.$order[$i]['moneytype']],2,".","");
						
						if($order[$i]['youhui_zhekou']==1){
							echo $order[$i]['moneysign'].' '.number_format(($total_price_geshi-$youhui_price_geshi),2,".","");
						}else{
							echo $order[$i]['moneysign'].' '.number_format(($total_price_geshi-$youhui_price_geshi),2,".","");
						}
						
					?>
				</td>
				<td align="center"><?php echo date('m/d/Y',$order[$i]["created"]);?></td>
				<td align="center">
					<?php 
						if($order[$i]['status']==0){
							echo '买家还未付款';
						}else if($order[$i]['status']==1){
							if($order[$i]['payment_type']==0){
								echo '<font class="houtai_order_return_color">等待卖家发货</font>';
							}else{
								echo '<font class="houtai_order_return_color">买家已付款</font>';
							}
						}else if($order[$i]['status']==2){
							echo '<font class="houtai_order_return_color">卖家已发货</font>';
						}else if($order[$i]['status']==3){
							echo '<font class="houtai_order_return_color">交易成功</font>';
						}
					?>
				</td>
				<td align="center">
					<a class="btn_2" href="<?php echo base_url().'index.php/admins/order/view_order/'.$order[$i]["order_id"]?>">View</a>
					<?php if($order[$i]['status']==2){?>
						&nbsp;&nbsp;
						<a class="btn_2" href="javascript:;" onclick="view_wuliu(<?php echo $order[$i]["express_type"]?>,'<?php echo $order[$i]["express_number"]?>')"><?php echo lang('express_view')?></a>
					<?php }?>
					&nbsp;&nbsp;
					<input type="hidden" name="name_<?php echo $order[$i]["order_id"]?>" value="<?php echo $order[$i]['order_number']?>"/>
					<a class="btn_2" href="javascript:;" onclick="todel_order('<?php echo $order[$i]["order_id"]?>')"><?php echo lang('cy_delete')?></a>
				</td>
		    </tr>
	  	<?php }}else{?>
	  		<?php if ($_GET){?>
	  			<tr><td colspan="7" align="center"><?php echo lang('nomatching_orders')?></td></tr>
		    <?php }else{?>
		    	<tr><td colspan="7" align="center"><?php echo lang('nomatching_orders')?></td></tr>
		    <?php }?>
	  	<?php }?>
		</table>
		<script>
		function tooptionallqwe(){
			var order_idarr=$('input[name="order_id[]"]');
			var tooptionallarr=$('input[name="tooptionall"]');
			for(var i=0;i<tooptionallarr.length;i++){
				if(tooptionallarr[i].checked==true){
					$('input[name="tooptionallbottom"]')[0].checked=true;
					$('.quanxuan').hide();
					$('.fanxuan').show();
					for(var j=0;j<order_idarr.length;j++){
						order_idarr[j].checked=true;
					}
				}else{
					$('input[name="tooptionallbottom"]')[0].checked=false;
					$('.fanxuan').hide();
					$('.quanxuan').show();
					for(var j=0;j<order_idarr.length;j++){
						order_idarr[j].checked=false;
					}
				}
			}
		}

		function tooptionallbottom(){
			var order_idarr=$('input[name="order_id[]"]');
			var tooptionallbottomarr=$('input[name="tooptionallbottom"]');
			for(var i=0;i<tooptionallbottomarr.length;i++){
				if(tooptionallbottomarr[i].checked==true){
					$('input[name="tooptionall"]')[0].checked=true;
					$('.quanxuan').hide();
					$('.fanxuan').show();
					for(var j=0;j<order_idarr.length;j++){
						order_idarr[j].checked=true;
					}
				}else{
					$('input[name="tooptionall"]')[0].checked=false;
					$('.fanxuan').hide();
					$('.quanxuan').show();
					for(var j=0;j<order_idarr.length;j++){
						order_idarr[j].checked=false;
					}
				}
			}
		}

		function topiliangaction(type){
			var order_id_arr=$('input[type="checkbox"][name="order_id[]"]');
			var order_id=[];
			if(order_id_arr.length>0){
				for(var i=0;i<order_id_arr.length;i++){
					if(order_id_arr[i].checked==true){
						order_id.push(order_id_arr[i].value);
					}
				}
			}
			
			if(order_id.length>0){
				if(type=='delete'){//批量删除
					//删除产品
					var width=350;
					$('.notice_taball').show();
					$(".message_tab").show();
					auto_box_location(width);
					$('.message_tab').find('.box_title').find("#title").html('批量删除');
					$.post(baseurl+"welcome/topiliang_order_del",function (data){
						$('.message_tab').find(".box_content").html(data);
						$('.message_tab').find('.box_control').find("#content").html('<div style="width:170px;margin:0 auto;"><input onclick="piliangaction(\''+type+'\')" type="button" class="btn_1" value="'+L['ok']+'" /><input onclick="close_msg(0)" type="button" class="btn_1" value="'+L['cancel']+'"  style="margin-left:30px;"/></div>');
						auto_box_location(width);
					});
				}
			}
		}

		function piliangaction(type){
			var order_id_arr=$('input[type="checkbox"][name="order_id[]"]');
			var order_id=[];
			if(order_id_arr.length>0){
				for(var i=0;i<order_id_arr.length;i++){
					if(order_id_arr[i].checked==true){
						order_id.push(order_id_arr[i].value);
					}
				}
			}
			if(order_id.length>0){
				$.post(baseurl+'admins/order/topiliangaction/'+type,{order_id:order_id},function (data){
					location.href=currenturl;
				})
			}
		}
	</script>
		<div class="houtai_fy">
	  		<div id="fyarea">
			<div style="float:left;margin:10px 0px 10px 0px;">
				<input onclick="tooptionallbottom()" name="tooptionallbottom" id="tooptionallbottom" type="checkbox" />
				<label class="quanxuan" for="tooptionallbottom">全选</label>
				<label class="fanxuan" for="tooptionallbottom" style="display:none;">反选</label>
			</div>
			<div style="float:left;margin:10px 0px 10px 10px;">
				<input onclick="topiliangaction('delete')" type="button" value="<?php echo '批量删除'?>"/>
			</div>
			<div style="float:left;margin:15px 0px 10px 10px;">
				<?php if(isset($fy)){echo $fy;}?> 
			</div>
		</div>
	  		<div id="control">
				<form action="<?php echo base_url().'admins/order/index'?>" method="get">
					共 [ <?php echo $count?> ] 条
					每页显示
					<input type="text" name="page" style="width:30px;" value="<?php echo $page?>"/> 条
					<input type="hidden" name="order_number" value="<?php echo $order_number?>"/>
					<input type="hidden" name="orderby" value="<?php echo $this->input->get('orderby')?>"/>
					<input type="hidden" name="orderby_res" value="<?php echo $this->input->get('orderby_res')?>"/>
					<input type="submit" value="<?php echo lang('cy_submit')?>"/>
				</form>
			</div>
		</div>
	</div>
<?php $this->load->view('admin/footer')?>