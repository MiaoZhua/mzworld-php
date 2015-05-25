<script type="text/javascript">
	$(document).ready(function (){
		var imgcolor<?php echo $colorpicnum;?>_gksel_choose = $("#imgcolor<?php echo $colorpicnum;?>_gksel_choose"), interval;
		if(imgcolor<?php echo $colorpicnum;?>_gksel_choose.length>0){
			new AjaxUpload(imgcolor<?php echo $colorpicnum;?>_gksel_choose,{
				action: baseurl+"welcome/uplogo_product", 
				name: "logo",onSubmit : function(file, ext){
					if (ext && /^(jpg|png|jpeg|gif)$/.test(ext)){
						imgcolor<?php echo $colorpicnum;?>_gksel_choose.text("上传中");
						this.disable();
						interval = window.setInterval(function(){
							var text = imgcolor<?php echo $colorpicnum;?>_gksel_choose.text();
							if (text.length < 13){imgcolor<?php echo $colorpicnum;?>_gksel_choose.text(text + '.');}else{imgcolor<?php echo $colorpicnum;?>_gksel_choose.text("上传中");}
						},200);
					}else{
						$("#img<?php echo $colorpicnum;?>_gksel_error").html("图片格式只能为jpg, png ,gif");
						return false;
					}
				},onComplete: function(file, response){
					imgcolor<?php echo $colorpicnum;?>_gksel_choose.text("选择图片");						
					window.clearInterval(interval);
					this.enable();
					if(response=="false"){
						$("#img<?php echo $colorpicnum;?>_gksel_error").html("上传失败");
					}else{
						var pic = eval("("+response+")");
						$("#imgcolor<?php echo $colorpicnum;?>_gksel_show").html('<a style="float:left;margin-left:27px;" href="javascript:;" onclick="toview_color_picture(\''+pic.logo+'\')"><img style="float:left;width:30px;height:30px;" src="'+baseurl+pic.logo+'" /></a>');
						$("#imgcolor<?php echo $colorpicnum;?>_gksel").attr("value",pic.logo);
						$("#imgcolor<?php echo $colorpicnum;?>_gksel_error").html("");
					}
				}
			});
		}
	})
</script>