<?php
require($this->__RAD__ . '_head.php');
?>
<link rel="stylesheet" href="<?= $this->__STATIC__ ?>css/zi.css">
</head>
<body>
<?php
require($this->__RAD__ . 'top.php');
?>
<div class="group_bg">
    <div class="banner" style=" height:200px; margin-bottom:-97px;"></div>
    <div class="create_title"><img src="<?= $this->__STATIC__ ?>images/account/title.png"></div>
    <div class="group_a create_a clearboth">
        <div class="group_a_l">
            <span><img src="<?= $this->__STATIC__ ?>images/group/img2.png" /></span>
        </div>
        <div class="create_a_r">
        		<input class="name" type="text" onBlur="if(this.value=='')this.value='输入群名称';this.style.color='#999';" onClick="if(this.value=='输入群名称')this.value='';this.style.color='#000';" value="输入群名称" >
        </div>
    </div>
    <table cellpadding="0" cellspacing="0" class="create_b">
        <tr>
            <td class="add_flag_title">选择队旗</td>
            <td>
              	<ul class="add_flag clearboth">
                	<li class="item"><span class="img"><img src="<?= $this->__STATIC__ ?>images/content/honor_1.png"></span></li>
                  <li class="item"><span class="img"><img src="<?= $this->__STATIC__ ?>images/content/honor_2.png"></span></li>
                  <li class="item"><span class="img"><img src="<?= $this->__STATIC__ ?>images/group/img2.png"></span></li>
                  <li class="add"><a href="javascript:;"><span>从本地<br>上传图片</span></a></li>
                </ul>
            </td>
        </tr>
    </table>
    <span class="create_btn" onClick="location.href='/account/group'">完成</span>
</div>
<!--裁切图片-->
<div class="cut_img">
    <div class="tbox">
        <div class="tclose"></div>
        <div class="tbox_c">
        		<p class="title">调整队旗</p>
            <div class="clearboth">
                <div class="cut_l">
                		<img src="<?= $this->__STATIC__ ?>images/group/img8.png">
                </div>
                <div class="cut_r">
                		<div class="bg">
                    		<div class="img"><img src="<?= $this->__STATIC__ ?>images/content/honor_1.png"></div>
                    </div>
                    预览
                </div>
            </div>
        </div>
    </div>
    <div class="option"><a class="sure" href="javascript:;"></a></div>
</div>
<?php
require($this->__RAD__ . 'footer.php');
?>
<script>
	$(function(){
		$(".add_flag li.item").click(function(){
				var _url=$(this).find("img").attr("src");
				$(".group_a_l img").attr("src",_url);
		});
		$(".add_flag li.add").click(function(){
				$(".cut_img,.layer_mask").show();
		});
		$(".cut_img .option a.sure").click(function(){
				$(".cut_img,.layer_mask").hide();
		});
	})
</script>
</body>
</html>