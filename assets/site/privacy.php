<?php
require($this->__RAD__ . '_head.php');
?>
<link rel="stylesheet" href="<?= $this->__STATIC__ ?>css/animate.css">
<link rel="stylesheet" href="<?= $this->__STATIC__ ?>css/index.css">
<link rel="stylesheet" href="<?= $this->__STATIC__ ?>css/yplan.css">
</head>
<body class="plan_bg">
<?php
require($this->__RAD__ . 'top.php');
?>
<!--社会工作坊-->
<div class="plan">
    <div class="plan_t news_t">
        <div class="layer"></div>
        <div class="layer2"></div>
        <div class="layer3"></div>
		<div class="windmill item_1"><span class="fan"></span><span class="pillar"></span></div>
		<div class="windmill item_2"><span class="fan"></span><span class="pillar"></span></div>
		<div class="cloud news"></div>
    </div>
	<div class="news_cont about_cont privacy">
			<div class="windmill white big item_1"><span class="fan"></span><span class="pillar"></span></div>
			<div class="windmill white big item_2"><span class="fan"></span><span class="pillar"></span></div>
			<img class="circle_roll big item_1" src="<?= $this->__STATIC__ ?>images/yplan/circle_white.png" />
			<img class="circle_roll big item_2" src="<?= $this->__STATIC__ ?>images/yplan/circle_white.png" />
		<span class="road"></span>
		<?php
    if (intval($this->userId) > 0):
    ?>
    <div id="avatar_m" class="avatar_right avatar_loading">
    	<span class="load"></span>
      <span class="box">
          <i class="body"><img src="<?= $this->__STATIC__ ?>images/01/body.png"></i>
            <i class="cloth"><img src="<?= $this->__STATIC__ ?>images/01/cloth_front.png"></i>
            <i class="cloth_b"><img src="<?= $this->__STATIC__ ?>images/01/cloth_rear.png"></i>
            <i class="face"><img src="<?= $this->__STATIC__ ?>images/01/face.png"></i>
            <i class="hair"><img src="<?= $this->__STATIC__ ?>images/01/hair.png"></i>
            <i class="hair_l"><img src="<?= $this->__STATIC__ ?>images/01/left.png"></i>
            <i class="hair_r"><img src="<?= $this->__STATIC__ ?>images/01/right.png"></i>
            <i class="mask"><img src="<?= $this->__STATIC__ ?>images/mask.png"></i>
            <i class="hand"></i>
        </span>
    </div>
    <?php
    else:
    ?>
      <div class="login">
          <div class="img"></div>
          <div class="box"><span>登录，请点我！</span><s></s></div>
      </div>
    <?php
    endif;
    ?>
		<h2 class="news_title">MZ World隐私政策</h2>
		<em class="time">2014-03-16</em>
		<p>1. 本公司不会通过应用程序收集儿童的个人信息。</p>
		<p>我们深知用户个人信息的重要性，特别是对于未成年人。在我们的APP中，不要求用户输入详细个人信息资料，用户使用软件时也不会记录任何终端信息。如果您觉得由于我们的疏忽，搜集了此类信息。请联系我们，以便我们能够立即获得家长的同意或删除此信息。</p>
		<p>2. 本公司遵守“儿童在线隐私保护法案”</p>
		<p>我们的所有儿童类APP及网站遵循有关儿童在线隐私保护条款。我们不会有意收集任何未满13周岁儿童的个人信息，如检测到年龄小于13周岁，我们将会及时删除相关信息，不会予以保留、存储。</p>
		<p>3. 第三方网站链接</p>
		<p>我们可能会提供从我们的网站链接到第三方网站或服务，对第三方网站的隐私做法或内容，我们不予负责。</p>
		<p>4. 隐私政策修改</p>
		<p>我们可能会对隐私条款进行随时修改，并保留最终解释权。如果我们的政策有任何本质的变动，我们会在网页或者应用上发布通知。</p>
		<p>5. 联系我们</p>
		<p>如果您有关于本隐私政策的任何问题或疑虑，请联系我们：<br /><span style="margin-top:10px;display:inline-block;">邮件：<a style="color:#000;" href="mailto:info@mzworld.cn">info@mzworld.cn</a></span></p>
		
	</div>
</div>
<?php
require($this->__RAD__ . 'footer.php');
?>
<script>
	$(function(){
			if($("#avatar_m").size()>0){
				var timer=null;
				var direction="left";
				var block_nums=$(".block").size();				
				$(window).scroll(function(){
					clearTimeout(timer);
					timer=setTimeout(function(){
						var move;
						var new_position=$(window).scrollTop();
						if(new_position-bar_position>0){
							move="down";
						}else{
							move="up";
						}
						bar_position=new_position;
						///////////人物向下移动
						var scroll_top=$(window).scrollTop();
						var pepole_top=320+$("#avatar_m")[0].offsetTop+118;
						if(scroll_top>pepole_top && move=="down"){
							$("#avatar_m").removeClass().addClass("avatar_m_down");
							$("#avatar_m").stop().css({"top":scroll_top-450+"px"});
							$("#avatar_m").animate({top:scroll_top-150+"px"},2000,function(){
								$("#avatar_m").removeClass().addClass("avatar_right");
							});
						}
						///////////人物向上移动
						var move_up=scroll_top+$(window).height();
						var pepole_top2=320+$("#avatar_m")[0].offsetTop;
						if(move_up<pepole_top2 && move=="up"){
							$("#avatar_m").removeClass().addClass("avatar_m_up");
							if(scroll_top<220){
								$("#avatar_m").stop().css({"top":move_up-130+"px"});
								$("#avatar_m").animate({top:"200px"},2000,function(){
									$("#avatar_m").removeClass().addClass("avatar_right");
								});
							}else{
								$("#avatar_m").stop().css({"top":move_up-250+"px"});
								$("#avatar_m").animate({top:move_up-590+"px"},2000,function(){
									$("#avatar_m").removeClass().addClass("avatar_right");
								});
							}
						}
					},200);
				});
			}
	})
</script>
</body>
</html>