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
	<div class="news_cont about_cont">
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
		<h2 class="news_title"><!--Introduction to MiaoZhua-->喵爪简介</h2>
		<em class="time">2014-03-16</em>
		<!--<p>With support of industry professionals, educators, and investors, MiaoZhua is the destination for kids in all levels of schools to interact and present the projects they produce in school, share and communicate with their class mates, parents, and teachers and realize their achievements.</p>
		<p>Kids may participate in projects that may serve a nationwide impact theme like Climate Change with 社会工作坊 or participate in coding projects with their local school’s Scratch initiative or even learn to program a Robot with sensors and share all the data to their network of friends.</p>
		<p>The possibilities are endless with MiaoZhua.  Join us today.</p>-->
		<p>借助于行业专家，教育者和投资者的支持，喵爪是所有学校孩子们互动和展现他们在学校制作的项目的终端。孩子们可以和同学、家长以及老师们共享和交流，并且展现他们的成就。</p>
		<p>孩子们还可以参与一系列带来全国性影响的项目，类似社会工作坊中的气候变化，或者在他们所在学校参与Scratch编程项目，或者学习用感应器对机器人编程并且将所有数据与朋友圈的人共享。</p>
		<p>喵爪蕴藏着无限的可能性。赶快加入我们吧。</p>
		<p class="b">Scratch简介</p>
		<p>Scratch是美国麻省理工学院媒体实验室开发的开源软件。它不需要和传统编程软件一样一行一行地“敲”代码，而采用类似于乐高积木的方式“堆叠”程序，通过拖拽已定义好的编程模块，可以快速地实现程序，适合于中小学生通过实验的方式理解编程思想。</p>
		<p>Scratch编程部件包含了常见的编程概念，如顺序、循环、条件语句、变量和链表（数组）等；还包含了动作、声音、外观等部件组，利用动作部件，可以让角色移动、旋转等；利用外观部件可以设置角色的造型、给造型添加特效等；利用声音部件，可设置各种声音特效。所以利用scratch可以
很方便地制作多媒体程序。</p>
		<p class="b">Scratch界面</p>
		<p>Scratch的标记是一只可爱的小猫，双击桌面上的小猫图标，可以打开scratch软件。</p>
		<img src="<?= $this->__STATIC__ ?>images/yplan/img6.jpg" />
		<p class="b">MZ workshop 社会工作坊－基于解决方案的学习</p>
		<p>MZ workshop 是一个主张以编程思考、展示解决方案的实践工作坊，引导青少年发现问题、思考问题、解决问题，最终以Scratch作品的形式展示自己的idea。<br />
			我们惊喜地发现远在美国彼岸的加州伯克利大学城市与学校中心（CC+S）有一个Y-PLAN项目，与MZ workshop有着一致的理念和共同的情怀。Y-PLAN已于全球超过20个地区和城市有合作项目，遍及美国、日本、印尼等地。<br />
			现在，MZ workshop有幸联合Y-PLAN共同在中国进行试点项目，培养更多中国孩子的逻辑思维、编程技能，以及通过自主思考学习解决问题的实践能力。</p>
		<div class="about_list">
			<div class="about_room clearboth">
			</div>
		</div>	
		
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
