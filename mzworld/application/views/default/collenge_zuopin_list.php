<?php 
	$reparr=array();
	$reparr[]=array('name'=>'/mzworld','value'=>'');
	$reparr1=array();
	$reparr1[]=array('name'=>"\\",'value'=>'/');
	
	
	$dobaseurl=replace_content($reparr,base_url());
?>

<?php if(isset($zuopinlist)){for($i=0;$i<count($zuopinlist);$i++){
	$thumb=replace_content($reparr1,$zuopinlist[$i]['thumb']);
	if($thumb!=""&&file_exists('../uploads/'.$thumb)){
		$thumb=$dobaseurl.'uploads/'.$thumb;
	}else{
		$thumb=$dobaseurl.'assets/static/images/content/work_img2.png';
	}
	?>
	<li>
		<p class="title clearboth">
			<span class="title_l"><em class="text"><?php echo $zuopinlist[$i]['title']?></em><em class="num"><?php echo $zuopinlist[$i]['praise_count']?></em></span>
			<span class="title_r"><img src="<?php echo $dobaseurl;?>assets/static/images/home/icon2.png"></span>
		</p>
		<span class="img"><a href="/gallery/<?php echo $zuopinlist[$i]['opus_id'];?>"><img src="<?php echo $thumb;?>"></a></span>
	</li>
<?php }}?>