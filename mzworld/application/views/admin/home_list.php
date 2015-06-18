<?php $this->load->view('admin/header')?>

<div class="tips_text">
	<div style="float:left;width:500px;line-height:20px;">
		Welcome to your backend administrator control. Through these quick links you can manage and obtain information regarding your website and its statistics
	</div>
</div>
<?php 
$get_str='';
if($_GET){
	$arr=array('subcategory_ID','row','key','keyword','ID');
	for($i=0;$i<count($arr);$i++){
		if(isset($_GET[$arr[$i]])){
			if($get_str!=""){$get_str .='&';}else{$get_str .='?';}
			$get_str .=$arr[$i].'='.$_GET[$arr[$i]];
		}
	}
}
$current_url_encode=str_replace('/','slash_tag',base64_encode(current_url().$get_str));
?>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery/plugins/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery/plugins/jqplot.donutRenderer.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>css/jquery/jquery.jqplot.min.css" />
<div style="float:left;width:100%;">
	<table width="100%" cellpadding="10" cellspacing="0" border=0> 
		<tr>
			<td width="400px" valign="top" align="left">
				<div style="float:left;width:100%;border:0px solid red;">
					<div class="home_pad">
						<span style="font-size:18px;font-weight:bolder;">网站统计</span>
					</div>
				</div>
				<div style="float:left;width:100%;border-top:2px solid #ececec; height:1px; margin:2px 0px;">&nbsp;</div>
				<div style="float:left;width:100%;border:0px solid red;">
				
					 <script type="text/javascript" class="code">
						 $(document).ready(function(){
							  var data = [
							    ['Projects&nbsp;&nbsp;', 33], 
							    ['Cities&nbsp;&nbsp;', 21],
							    ['Tags&nbsp;&nbsp;', 21]
							  ];
							  var plot1 = jQuery.jqplot ('chart1', [data], 
							    { 
							      seriesDefaults: {
							        // Make this a pie chart.
							        renderer: jQuery.jqplot.PieRenderer, 
							        rendererOptions: {
							          // Put data labels on the pie slices.
							          // By default, labels show the percentage of the slice.
							          showDataLabels: true
							        }
							      }, 
							      legend: { show:true, location: 'e' }
							    }
							  );
							});					
					</script>
					<div id="chart1" style="height:250px;">
					</div>
				</div>
			</td>
			<td valign="top" align="left">
				<div style="float:left;width:100%;border:0px solid red;">
					<div class="home_pad">
						<span style="font-size:18px;font-weight:bolder;">最新召集</span>
					</div>
				</div>
				<div style="float:left;width:100%;border-top:2px solid #ececec; height:1px; margin:2px 0px;">&nbsp;</div>
				<div style="float:left;width:100%;height:205px;overflow:hidden;">
				<div style="float:left;width:100%;margin-top:3px;">
<!--					<input type="button" onclick="togotoyijianfahuo()" value="一键发货"/>-->
				</div>
				</div>
			</td>
		</tr>	
		<tr>
			<td width="400px" valign="top" align="left">
				<div style="float:left;width:100%;border:0px solid red;">
					<div class="home_pad">
						<span style="font-size:18px;font-weight:bolder;">每周统计</span>
					</div>
				</div>
				<div style="float:left;width:100%;border-top:2px solid #ececec; height:1px; margin:2px 0px;">&nbsp;</div>
				<div style="float:left;width:100%;border:0px solid red;">
					  <script type="text/javascript" class="code">
						 $(document).ready(function(){
							  var data = [
							    ['Monday&nbsp;&nbsp;', 1],['Tuesday', 1], ['Wednesday', 1], 
							    ['Thursday', 1],['Friday', 1], ['Saturday', 1], ['Sunday', 1]
							  ];
							  var plot1 = jQuery.jqplot ('chart3', [data], 
							    { 
							      seriesDefaults: {
							        // Make this a pie chart.
							        renderer: jQuery.jqplot.PieRenderer, 
							        rendererOptions: {
							          // Put data labels on the pie slices.
							          // By default, labels show the percentage of the slice.
							          showDataLabels: true
							        }
							      }, 
							      legend: { show:true, location: 'e' }
							    }
							  );
							});					
					</script>
					<div  id="chart3"  style="height:250px;" >
					</div>
				</div>
			</td>
			<td valign="top" align="left">
				<div style="float:left;width:100%;border:0px solid red;">
					<div class="home_pad">
						<span style="font-size:18px;font-weight:bolder;">快速链接</span>
					</div>
				</div>
				<div style="float:left;width:100%;border-top:2px solid #ececec; height:1px; margin:2px 0px;">&nbsp;</div>
				<div style="float:left;width:100%;border:0px solid red;font-size:18px;">
					<table cellspacing="0" cellpadding="0" width="100%">
						<tr>
							<td width="100" height="100">
								<a href="<?php echo base_url();?>index.php/admins/cms">
									<img width="70%" src="<?php echo base_url();?>themes/default/images/cms.png"/>
								</a>
							</td>
							<td>								
								<a href="<?php echo base_url();?>index.php/admins/cms">
									CMS							</a>								
							</td>
							<td width="100">
								<a href="<?php echo base_url();?>index.php/admins/user">
									<img width="70%" src="<?php echo base_url();?>themes/default/images/neirong.png"/>
								</a>
							</td>
							<td>
								<a href="<?php echo base_url();?>index.php/admins/category">
									Manage Categories								</a>
							</td>
							<td width="100">
								<a href="<?php echo base_url();?>admins/product">
									<img width="70%" src="<?php echo base_url();?>themes/default/images/chanpin.png"/>
								</a>
							</td>
							<td>
								<a href="<?php echo base_url();?>index.php/admins/project">
									Manage Projects								</a>
							</td>
						</tr>
						<tr><td colspan="8"><div style="float:left;width:100%;border-top:2px solid #ececec; height:1px; margin:2px 0px;">&nbsp;</div></td></tr>
						<tr>
							<td width="100" height="100">
								<a href="<?php echo base_url();?>admins/order/index">
									<img width="70%" src="<?php echo base_url();?>themes/default/images/neirong.png"/>
								</a>
							</td>
							<td>
								<a href="<?php echo base_url();?>index.php/admins/city">
									Manage Cities								</a>
							</td>
							<td width="100">
								<a href="<?php echo base_url();?>index.php/admins/tag/article_list?subcategory_ID=65&key=">
									<img width="70%" src="<?php echo base_url();?>themes/default/images/peijian.png"/>
								</a>
							</td>
							<td>
								<a href="<?php echo base_url();?>index.php/admins/othersetting/article_list?subcategory_ID=65&key=">
									Manage Tags								</a>
							</td>
							<td width="100">
								<a href="<?php echo base_url()?>index.php/admins/othersetting/toedit_article?subcategory_ID=91&ID=731&key=&backurl=aHR0cDovL2xvY2FsaG9zdC9nbS9pbmRleC5waHAvYWRtaW5zL290aGVyc2V0dGluZy9hcnRpY2xlX2xpc3Qslash_tagc3ViY2F0ZWdvcnlfSUQ9OTEma2V5PQ==">
									<img width="70%" src="<?php echo base_url();?>themes/default/images/peijian.png"/>
								</a>
							</td>
							<td>
								<a href="<?php echo base_url()?>index.php/admins/othersetting/toedit_article?subcategory_ID=91&ID=731&key=&backurl=aHR0cDovL2xvY2FsaG9zdC9nbS9pbmRleC5waHAvYWRtaW5zL290aGVyc2V0dGluZy9hcnRpY2xlX2xpc3Qslash_tagc3ViY2F0ZWdvcnlfSUQ9OTEma2V5PQ==">
									Manage SEO								</a>
							</td>
							
						</tr>
					</table>
				</div>
			</td>
		</tr>
	</table>
</div>
<script>
	$(document).ready(function (){
		$('#chart103').css('display','none');
		$('#chart104').css('display','none');
	})
</script>
<?php $this->load->view('admin/footer')?>