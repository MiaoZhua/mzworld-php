<?php $this->load->view('admin/header')?>
<?php 
	$langarr=languagelist();//多语言
?>
<form action="<?php echo site_url('admins/'.$this->controller.'/add_town')?>" method="post">
<table cellspacing=1 cellpadding=0 width="98%" style="margin-left:1%;color:black;">
	<tr>
		<td>
			<table width="100%">
				<?php 
					for($la=0;$la<count($langarr);$la++){//多语言
						echo '
						<tr>
							<td width="120" align="right">Name&nbsp;&nbsp;</td>
							<td align="left">
								<div style="float:left;"><input type="text" style="width:500px;" name="article_name'.$langarr[$la]['langtype'].'" value="" /></div>
						    </td>
						</tr>
						';
					}
				?>
				<tr>
				    <td colspan="2">
				    	<div style="float:left;width:100%;margin:5px 0px 5px 0px;border-top:1px solid #999999;line-height:1px;">&nbsp;</div>
				    </td>
				</tr>
				<tr>
					<td width="120" align="right">Longitude&nbsp;&nbsp;</td>
				    <td align="left">
				    	<div style="float:left;"><input type="text" style="width:200px;" name="nolaninput_1" value="" /></div>
				    </td>
				</tr>
				<tr>
				    <td colspan="2">
				    	<div style="float:left;width:100%;margin:5px 0px 5px 0px;border-top:1px solid #999999;line-height:1px;">&nbsp;</div>
				    </td>
				</tr>
				<tr>
					<td width="120" align="right">Latitude&nbsp;&nbsp;</td>
				    <td align="left">
				    	<div style="float:left;"><input type="text" style="width:200px;" name="nolaninput_2" value="" /></div>
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
				    	<input name="key" type="hidden" value="" />
				    	<input name="subcategory_id" type="hidden" value="<?php echo $subcategory_info['category_id'];?>" />
				   		<input name="first_id" type="hidden" value="<?php echo $firstinfo['article_id'];?>" />
				   		<input name="second_id" type="hidden" value="<?php echo $secondinfo['article_id'];?>" />
				   		<input name="tongji_split" type="hidden" value="<?php echo $tongji_split;?>" />
				   		<input type="submit" value="添加"/>
				    </td>
			    </tr>
			</table>
		</td>
	</tr>
</table>
</form>


<?php if($this->category_id==81){?>
<div style="float:left;width:100%;height:475px;margin-top:5px;">
	<div id="map_canvas" style="float:left;width:100%;height:475px;"></div>
</div>


<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true&language=en"></script>
<script type="text/javascript">
//地图--开始
var map;
var gzLatLng;
var geocoder;
var mylistener;
var markersArray = [];
//num:从0开始
function addMarker(num,imgpath,location,title,address){
		var image = new google.maps.MarkerImage(imgpath,
		// 这标志是30像素宽48像素高。
		new google.maps.Size(30, 48),
		// 原来的点是0,0。
		new google.maps.Point(0,0),
		// 锚这个形象是旗杆的基地0,48。
		new google.maps.Point(15, 48));
	
		var thismark = new google.maps.Marker({
			position: location,
			map: map,
			icon:image,
			
			animation: google.maps.Animation.DROP,//DROP 表明Marker初次放置于地图上时，应当从地图顶端落到目标位置。当Marker停止移动时，动画也会立即结束，且 animation值还原为 null。通常，该类型动画应用在Marker 创建过程中。
			title:title
		});
		thismark.setDraggable(false);
		
		var markLatLng = new google.maps.LatLng(location.lat(),location.lng());
		if(num==0){
			//设置标签--不停的跳动--START
				thismark.setAnimation(google.maps.Animation.BOUNCE);//BOUNCE 表明Marker会在相应的位置上“弹跳”。Marker会不停“弹跳”，直到Marker的animation属性设置为null。
			//设置标签--不停的跳动--END
		}
		markersArray.push(thismark);
}

//地图--结束
gzLatLng = new google.maps.LatLng(31.223243,121.44552299999998);
var myOptions = {
	zoom: 12,
	center:gzLatLng,
	mapTypeId : google.maps.MapTypeId.ROADMAP, //常量ROADMAP以地图显示 常量SATELLITE为卫星显示
    disableDoubleClickZoom : true //禁用双击缩放地图
};
map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
geocoder = new google.maps.Geocoder();




function tokeywordaddmark(address){
	//根据地址搜索  经纬度
	geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			latLng=results[0].geometry.location;


			addMarker(0,baseurl+'upload/article/2015/04/article_1_2015_04_09_10_56_00.png',eval( "latLng"),'Address 0','Address 0');
			map.setCenter(eval( "latLng"));

			$('input[name="nolaninput_1"]').val(latLng.lng());

			$('input[name="nolaninput_2"]').val(latLng.lat());
		}
	});
}


$(document).ready(function (){
	$('input[name="article_name_en"]').keyup(function(){
		if($(this).val().length>=1){
			tokeywordaddmark($(this).val());
		}
	});
})

</script>

<script type="text/javascript">
//	tokeywordaddmark('');
</script>
<?php }?>



<?php $this->load->view('admin/footer')?>