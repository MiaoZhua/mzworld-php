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
		<span class="img"><a href="/gallery/<?php echo $zuopinlist[$i]['opus_id'];?>"><img src="<?php echo $thumb;?>"></a></span>
	</li>
<?php }}?>