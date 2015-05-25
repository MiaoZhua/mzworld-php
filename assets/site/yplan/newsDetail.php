<?php
require($this->__RAD__ . '_head.php');
?>
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
	<div class="news_cont">
			<div class="windmill white big item_1"><span class="fan"></span><span class="pillar"></span></div>
			<div class="windmill white big item_2"><span class="fan"></span><span class="pillar"></span></div>
			<img class="circle_roll big item_1" src="<?= $this->__STATIC__ ?>images/yplan/circle_white.png" />
			<img class="circle_roll big item_2" src="<?= $this->__STATIC__ ?>images/yplan/circle_white.png" />
			<span class="road"></span>
			<?php
            require($this->__RAD__ . '_avatar.php');
            ?>
    
        <?php
        if ($this->rs->article_img):
        ?>
		<div class="news_img">
			<div class="img_room">
				<span></span>
				<img src="<?= $this->__CDN__ . ($this->rs->article_img ? 'pics/l/' . $this->rs->article_img : 'no_img.png') ?>">
			</div>
			<span class="circle"></span>
		</div>
        <?php
        endif;
        ?>
		<h2 class="news_title"><?= $this->rs->article_title ?></h2>
		<em class="time"><?= \Tools\Auxi::getShortTime($this->rs->release_date) ?></em>
        <?= \Tools\Html::outputToText($this->rs->content) ?>
		<!--<div class="btn_box">
			<a href="#" class="a1">TUTORIAL ACT</a>
			<a href="#" class="a2">社会工作坊 ACT</a>
		</div>-->
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
						var pepole_top=160+$("#avatar_m")[0].offsetTop+118;
						if(scroll_top>pepole_top && move=="down"){
								$("#avatar_m").removeClass().addClass("avatar_m_down");
								$("#avatar_m").stop().css({"top":scroll_top-300+"px"});
								$("#avatar_m").animate({top:scroll_top+"px"},2000,function(){
									$("#avatar_m").removeClass().addClass("avatar_right");
								});
						}
						///////////人物向上移动
						var move_up=scroll_top+$(window).height();
						var pepole_top2=160+$("#avatar_m")[0].offsetTop;
						if(move_up<pepole_top2 && move=="up"){
							$("#avatar_m").removeClass().addClass("avatar_m_up");
							if(scroll_top<220){
								$("#avatar_m").stop().css({"top":move_up-130+"px"});
								$("#avatar_m").animate({top:"200px"},2000,function(){
									$("#avatar_m").removeClass().addClass("avatar_right");
								});
							}else{
									$("#avatar_m").stop().css({"top":move_up-130+"px"});
									$("#avatar_m").animate({top:move_up-420+"px"},2000,function(){
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