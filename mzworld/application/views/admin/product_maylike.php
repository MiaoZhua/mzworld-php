<?php $this->load->view('admin/header')?>
<?php $product_name=$this->input->get('product_name');?>
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
	<div style="float:left;width:98%;margin-left:2%;">
	<form id="" action="<?php echo base_url().'index.php/admins/product/edit_maylike'?>" method="post" enctype="multipart/form-data">
		<?php 
		if(!empty($productlist)){
			$count=count($productlist);
			$num=8;
			echo '<table border=0 width="100%" cellspacing=0 cellpadding=0>';
				$percent=100/$num;
				for($i=0;$i<$count;$i++){
					$ischecked='';
					if(!empty($maylikelist)){
						for($j=0;$j<count($maylikelist);$j++){
							if($maylikelist[$j]['target_id']==$productlist[$i]['article_id']){
								$ischecked='checked';
								break;
							}
						}
					}
					if($i%$num==0){
						echo '<tr>';}
						$picinfo=$this->ProductModel->getpicinfo($productlist[$i]['pic_1'],100,100);
						echo '<td height="25" width="'.$percent.'%" valign="top">
							<img width="150px" src="'.base_url().''.$picinfo['pic'].'" /><br />
							<input type="checkbox" name="checkbox[]" '.$ischecked.' value="'.$productlist[$i]['article_id'].'"/>
							'.$productlist[$i]['article_name'.$this->langtype].'
							<input name="product_id" type="hidden" value="'.$product_id.'"/>
						</td>';
						if($i==($count-1)){
							for($a=0;$a<$num;$a++){
								if($i%$num==$a){
									$tdnum=($num-$a)-1;
									for($b=1;$b<=$tdnum;$b++){
										echo '<td width="'.$percent.'%"></td>';
									}
									echo '<tr><td colspan="'.$num.'" ></td></tr>';
								}
							}
						}else{
							if($i%$num==($num-1)){
								echo '</tr>';
								echo '<tr><td colspan="'.$num.'" height="10px"></td></tr>';
							}
						}
								
				}
			echo '</table>';
		}
	?>
	<input name="key" type="hidden" value="<?php echo $backurl;?>"/>
	<input name="subcategory_ID" type="hidden" value="<?php echo $subcategory_ID;?>"/>
	
	<input type="submit" value="Save"/>
	</form>
	</div>
<?php $this->load->view('admin/footer')?>