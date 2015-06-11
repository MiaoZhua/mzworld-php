<?php $this->load->view('admin/header');?>
	<div class="tips_text">
		<table cellspacing="0" cellpadding="0" width="100%;">
			<tr>
				<td align="left">
					<div class="tips_text">
						<div style="float:left;width:500px;line-height:20px;">
							<?php echo lang('order_section_desc_view')?>
						</div>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<table width="100%" cellspacing=0 cellpadding=0>
			<tr><td height="10px"></td></tr>
			<tr>
				<td align="left" colspan="2" style="font-weight:bold;font-size:16px;">
					&nbsp;<?php echo lang('order_number')?>&nbsp;&nbsp;<?php echo $orderinfo['order_number']?>
					
					<?php if($orderinfo['sumaitong_ID']!=""){?>
						&nbsp;&nbsp;&nbsp;&nbsp;速卖通Order ID&nbsp;&nbsp;<?php echo $orderinfo['sumaitong_ID']?>
						
						<span id="sumaitong_ID_error" style="color:red;"></span>
					<?php }?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table class="tab_list" cellpadding="0" cellspacing="0">
						<tr valign="top">
							<th width="50" align="center"></th>
							<th width="80" align="center"><?php echo lang('cy_picture')?></th>
							<th align="left"><?php echo lang('costume_name')?></th>
							<th align="center"><?php echo lang('price_unit_rmb')?></th>
							<th align="center"><?php echo lang('cy_count')?></th>
							<th align="center"><?php echo lang('price_subtotal_rmb')?></th>
							<th width="150"><?php echo lang('cy_date_buy');?></th>
						</tr>
						<?php if(isset($order_detaillist)){for($i=0;$i<count($order_detaillist);$i++){?>
						
					  	 	<tr style="background-color:<?php if($i%2==0){echo '#FFFFFF;';}else{echo '#f6f5f5;';}?>">
								<td align="center">&nbsp;&nbsp;<?php echo $i+1;?></td>
								<td align="center">
									<?php 
										$product_picinfo=$this->ProductModel->getproduct_picinfo($order_detaillist[$i]['product_id'],60,60,0,0);
										echo '<img style="float:left;width:'.$product_picinfo['width'].'px;height:'.$product_picinfo['height'].'px;margin-left:'.$product_picinfo['marginleft'].'px;margin-top:'.$product_picinfo['margintop'].'px;" src="'.base_url().$product_picinfo['pic'].'"/>';
									?>
								</td>
								<td align="left" valign="top">
									<div style="float:left;width:100%;font-size:12px;line-height:20px;font-weight:bold;"><?php echo $order_detaillist[$i]['product_name'.$this->langtype];?></div>
									<div style="float:left;width:100%;font-size:12px;line-height:22px;">
										<?php 
										if($order_detaillist[$i]['product_color_isshow']==1){
											echo '<div style="float:left;border:1px solid gray;padding:0px 4px 0px 4px;margin:0px 8px 0px 0px;">'.$order_detaillist[$i]['product_color'.$this->langtype].'</div>';
										}
										if($order_detaillist[$i]['product_size_isshow']==1){
											echo '<div style="float:left;border:1px solid gray;padding:0px 4px 0px 4px;margin:0px 8px 0px 0px;">'.$order_detaillist[$i]['product_size'.$this->langtype].'</div>';
										}
										if($order_detaillist[$i]['product_zdyone_isshow']==1){
											echo '<div style="float:left;border:1px solid gray;padding:0px 4px 0px 4px;margin:0px 8px 0px 0px;">'.$order_detaillist[$i]['product_zdyone'.$this->langtype].'</div>';
										}
										?>
									</div>
								</td>
								<td align="center"><?php echo number_format($order_detaillist[$i]['price_unit'.$orderinfo['moneytype']],2,".","").' '.$orderinfo['moneysign']?></td>
								<td align="center"><?php echo $order_detaillist[$i]['count'];?></td>
								<td align="center"><?php echo number_format($order_detaillist[$i]['price_unit'.$orderinfo['moneytype']],2,".","").' '.$orderinfo['moneysign'];?></td>
								<td align="center"><?php echo date('m/d/Y',$order_detaillist[$i]["created"]);?></td>
						    </tr>
					  	<?php }}?>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="order_view_l_info">
						<table width="100%" cellspacing=0 cellpadding=0>
							<tr>
								<td colspan="2">
									<div class="refund_loglist_l">
										<table width="100%" cellpadding="0" cellspacing="0" border=0>
											<tr>
												<th colspan="2" align="center">订单信息</th>
											</tr>
											<tr>
												<td align="center"><?php echo lang('user_name')?>&nbsp;&nbsp;</td>
												<td><?php echo $orderinfo['username']?></td>
											</tr>
											<tr>
												<td width="150" align="center"><?php echo lang('email')?>&nbsp;&nbsp;</td>
												<td><?php echo $orderinfo['email']?></td>
											</tr>
											<tr>
												<td align="center"><?php echo lang('cy_status')?>&nbsp;&nbsp;</td>
												<td>
													<?php 
														if($orderinfo['status']==0){
															echo lang('product_buyer_pay_not');
														}else if($orderinfo['status']==1){
															echo '<font class="houtai_order_return_color">'.lang('product_buyer_pay_has').'</font>';
														}else if($orderinfo['status']==2){
															echo '<font class="houtai_order_return_color">'.lang('product_fahuo_seller_has').'</font>';
														}else if($orderinfo['status']==3){
															echo '<font class="houtai_order_return_color">交易完成</font>';
														}
													?>
												</td>
											</tr>
											<tr>
												<td align="center"><?php echo lang('order_date');?>&nbsp;&nbsp;</td>
												<td><?php echo date('Y-m-d H:i:s',$orderinfo['created'])?></td>
											</tr>
										</table>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div class="refund_loglist_l">
										<?php 
											$product_price_geshi=number_format($orderinfo['product_price'.$orderinfo['moneytype']],2,".","");
											$total_price_geshi=number_format($orderinfo['total_price'.$orderinfo['moneytype']],2,".","");
											$express_price_geshi=number_format($orderinfo['express_price'.$orderinfo['moneytype']],2,".","");
											$youhui_price_geshi=number_format($orderinfo['youhui_price'.$orderinfo['moneytype']],2,".","");
											
										?>
										<table width="100%" cellpadding="0" cellspacing="0" border=0>
											<tr>
												<th colspan="2" align="center">价格</th>
											</tr>
											<tr>
												<td align="center">产品价格&nbsp;&nbsp;</td>
												<td>
													<?php 
														echo $orderinfo['moneysign'].number_format(($product_price_geshi-$youhui_price_geshi),2,".",",");
														
															if($orderinfo['youhui_zhekou']==1){
																$youhuides='不享受打折优惠';
															}else if($orderinfo['youhui_zhekou']==0.95){
																$youhuides='享受九五折优惠';
															}else if($orderinfo['youhui_zhekou']==0.9){
																$youhuides='享受九折优惠';
															}else if($orderinfo['youhui_zhekou']==0.85){
																$youhuides='享受八五折优惠';
															}else if($orderinfo['youhui_zhekou']==0.8){
																$youhuides='享受八折优惠';
															}else if($orderinfo['youhui_zhekou']==0.75){
																$youhuides='享受七五折优惠';
															}else if($orderinfo['youhui_zhekou']==0.7){
																$youhuides='享受七折优惠';
															}else if($orderinfo['youhui_zhekou']==0.65){
																$youhuides='享受六五折优惠';
															}else if($orderinfo['youhui_zhekou']==0.6){
																$youhuides='享受六折优惠';
															}else if($orderinfo['youhui_zhekou']==0.55){
																$youhuides='享受五五折优惠';
															}else if($orderinfo['youhui_zhekou']==0.5){
																$youhuides='享受五折优惠';
															}else if($orderinfo['youhui_zhekou']==0.45){
																$youhuides='享受四五折优惠';
															}else if($orderinfo['youhui_zhekou']==0.4){
																$youhuides='享受四折优惠';
															}else if($orderinfo['youhui_zhekou']==0.35){
																$youhuides='享受三五折优惠';
															}else if($orderinfo['youhui_zhekou']==0.3){
																$youhuides='享受三折优惠';
															}else if($orderinfo['youhui_zhekou']==0.25){
																$youhuides='享受二五折优惠';
															}else if($orderinfo['youhui_zhekou']==0.2){
																$youhuides='享受二折优惠';
															}else if($orderinfo['youhui_zhekou']==0.15){
																$youhuides='享受一五折优惠';
															}else if($orderinfo['youhui_zhekou']==0.1){
																$youhuides='享受一折优惠';
															}else{
																$youhuides='';
															}
														if($orderinfo['youhui_zhekou']!=1){
															echo '<br /><font style="color:gray;">优惠了<font style="color:#EAA228;font-weight:bold;">'.$orderinfo['moneysign'].' '.$youhui_price_geshi.'</font>&nbsp;&nbsp;&nbsp;&nbsp;'.$orderinfo['youhui_name'.$this->langtype].' '.$youhuides.'</font>';
														}else{
															echo '<br /><font style="color:gray;">'.$orderinfo['youhui_name'.$this->langtype].' '.$youhuides.'</font>';
														}
													?>
												</td>
											</tr>
											<tr>
												<td width="150" align="center">快递价格&nbsp;&nbsp;</td>
												<td><?php echo $orderinfo['moneysign'].$express_price_geshi?></td>
											</tr>
											<tr>
												<td align="center"><?php echo lang('price_total');?>&nbsp;&nbsp;</td>
												<td><?php echo $orderinfo['moneysign'].number_format(($total_price_geshi-$youhui_price_geshi),2,".","")?></td>
											</tr>
										</table>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div class="refund_loglist_l">
										<table width="100%" cellpadding="0" cellspacing="0" border=0>
											<tr>
												<th colspan="2" align="center">
													<?php echo lang('payment_type')?>
												</th>
											</tr>
												<tr>
													<td width="150" align="center"><?php echo lang('payment_type')?>&nbsp;&nbsp;</td>
													<td>支付宝</td>
												</tr>
										</table>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div class="refund_loglist_l">
										<table width="100%" cellpadding="0" cellspacing="0" border=0>
											<tr>
												<th colspan="2" align="center">
													<?php echo lang('invoice_type')?>
												</th>
											</tr>
											<?php if($orderinfo['invoice_type']==1){?>
												<tr>
													<td width="150" align="center"><?php echo lang('invoice_people')?>&nbsp;&nbsp;</td>
													<td><?php if($orderinfo['invoice_title']==1){echo lang('invoice_pesonal').'<br />';}else if($orderinfo['invoice_title']==2){echo lang('invoice_unit').'<br />';}?></td>
												</tr>
												<tr>
													<td align="center"><?php echo lang('invoice_content')?>&nbsp;&nbsp;</td>
													<td><?php echo $orderinfo['invoice_content'].'<br />';?></td>
												</tr>
												<tr>
													<td align="center"><?php echo lang('invoice_to')?>&nbsp;&nbsp;</td>
													<td><?php echo $orderinfo['invoice_address'].'<br />';?></td>
												</tr>
											<?php }else{?>
												<tr>
													<td align="center"><?php echo lang('invoice_to')?>&nbsp;&nbsp;</td>
													<td><?php echo lang('no_invoice');?></td>
												</tr>
											<?php }?>
										</table>
									</div>
								</td>
							</tr>
							<tr><td colspan="2">&nbsp;</td></tr>
							<?php //if($orderinfo['status']==0){?>
<!--							<tr>-->
<!--								<td height="30" align="right"></td>-->
<!--								<td><a href="javascript:;" onclick="toadminactiontopay(<?php echo $orderinfo['order_id']?>)" class="btn_1">Pay</a></td>-->
<!--							</tr>-->
							<?php //}?>
						</table>
					</div>
					<div class="order_view_r_info">
						<table width="100%" cellspacing=0 cellpadding=0>
							<tr>
								<td colspan="2">
									<div class="refund_loglist_r">
										<table width="100%" cellpadding="0" cellspacing="0" border=0>
											<tr>
												<th colspan="2" align="center">
													物流信息
												</th>
											</tr>
											<tr>
												<td align="center"><?php echo lang('express_consignee_name')?>&nbsp;&nbsp;</td>
												<td>
													<?php echo $orderinfo['consignee_firstname'].' '.$orderinfo['consignee_lastname']?>
												</td>
											</tr>
											<tr>
												<td align="center"><?php echo lang('phone')?>&nbsp;&nbsp;</td>
												<td>
													<?php echo $orderinfo['phone']?>
												</td>
											</tr>
											<tr>
												<td align="center">国家&nbsp;&nbsp;</td>
												<td>
													<?php 
														echo $orderinfo['country'];
													?>
												</td>
											</tr>
											<tr>
												<td align="center"><?php echo lang('address')?>&nbsp;&nbsp;</td>
												<td>
													<?php 
													
													
													$newyin_str = '';
													$str = trim($orderinfo['country']);
													for ($i=0;$i<strlen($str);$i++){
														 $s = substr($str,$i,1);
														 if($s==' '){
															$newyin_str .= $s;
														 }else{
														 	if (preg_match ("/^[A-Za-z]/",  $s)) {
											   					$newyin_str .= $s;
															} else {
											//    				echo "不是字母";
															}
														 }
													}
																							
														echo $orderinfo['province'].' '.$orderinfo['city'].' '.$orderinfo['area'].' '.$orderinfo['address'];
													?>
													<input style="width:9%" name="country" type="hidden" value="<?php echo trim($orderinfo['country']);?>"/>
													&nbsp;
													<input style="width:9%" name="country_en" type="hidden" value="<?php echo trim($newyin_str);?>"/>
													&nbsp;
													<input style="width:90%" name="address" type="hidden" value="<?php echo trim($orderinfo['province'].' '.$orderinfo['city'].' '.$orderinfo['area'].' '.$orderinfo['address']);?>"/>
												</td>
											</tr>
											<tr>
												<td align="center"><?php echo lang('deliver_time')?>&nbsp;&nbsp;</td>
												<td>
													<?php 
													if($orderinfo['delivery_time']==1){
														echo lang('any_day');
													}else if($orderinfo['delivery_time']==2){
														echo lang('weekday');
													}else if($orderinfo['delivery_time']==3){
														echo lang('weekend');
													}
													?>
												</td>
											</tr>
											<?php if($orderinfo['status']==2||$orderinfo['status']==3){?>
												<tr>
													<td align="center"><?php echo lang('express_name')?>&nbsp;&nbsp;</td>
													<td>
														<?php echo $this->ExpressModel->getexpress_name(1)?>
													</td>
												</tr>
												<tr>
													<td align="center"><?php echo lang('express_number')?>&nbsp;&nbsp;</td>
													<td>
														<?php echo $orderinfo['express_number']?> <input class="btn_5" type="button" onclick="view_wuliu(<?php echo $orderinfo['express_type']?>,'<?php echo $orderinfo['express_number']?>')" value="<?php echo lang('express_view')?>"/>
													</td>
												</tr>
											<?php }?>
										</table>
									</div>
								</td>
							</tr>
							<tr><td colspan="2"><?php $this->load->view('admin/order_log_list')?></td></tr>
							<tr><td colspan="2">&nbsp;</td></tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
<?php if($orderinfo['sumaitong_ID']!=""){?>
<script type="text/javascript">
<!--
function tosavezhantiela(){
	var address=$('input[name="address"]').val();
	var address_split=address.split(',');
	var ishave=0;
	var address_country=address_split[(address_split.length-1)];
	if(trim(address_country)==trim($('input[name="country_en"]').val())){
//		alert('ok');
	}else{
		$('#sumaitong_ID_error').html('当前的国家地址出现异常');
	}
		
}
tosavezhantiela();


function trim(str){ //删除左右两端的空格
	return str.replace(/(^\s*)|(\s*$)/g, "");
}
function cutstr(text,start,end){
	var s = text.indexOf(start)
	if(s>-1){
		var text2 = text.substr(s+start.length);
		var s2 = text2.indexOf(end);
	if(s2>-1){
		result = text2.substr(0,s2);
	}else result = '';
	}else result = '';
		return result;
}
//-->
</script>
<?php }?>
<?php $this->load->view('admin/footer')?>
