<?php
require($this->__RAD__ . '_head.php');
?>
<link rel="stylesheet" href="<?= $this->__STATIC__ ?>css/zi.css">
</head>
<body>
<?php
require($this->__RAD__ . 'top.php');
?>
<div class="post_overflow">
    <div class="banner"></div>
	<div class="post_blank"></div>
    <div class="challenge_cont">
		<?php
        require($this->__RAD__ . '_avatar.php');
        ?>
		<div class="challenge_a clearboth">
            <div class="post_tree_1"></div>
            <div class="post_tree_2"></div>
            <div class="post_tree_3"></div>
            <div class="post_tree_10"></div>
            <div class="post_tree_11"></div>
            <div class="post_tree_12"></div>
            <div class="post_tree_13"></div>
            <div class="post_tree_14"></div>
            <div class="challenge_a_l">
                <ul>
                    <li class="item"><a id="invite_link" href="javascript:;"><i></i>邀请</a></li>
                    <!--<li class="item2"><a href="#"><i></i>编辑</a></li>
                    <li class="item3"><a href="#"><i></i>审核</a></li>-->
                </ul>
            </div>
            <div class="challenge_a_r">
                <div class="box">
                    <div class="box_t"></div>
                    <div class="box_c">
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="td_l"><img src="<?= $this->__STATIC__ ?>images/content/challenge_icon.png" /></td>
                                <td class="td_c">
                                    <h3>智慧学校-上海市日新实验小学</h3>
                                    <p class="desc">信息时代，想让你的学校变得更加的智能吗？还等什么？来这里，用你的天才想象力，从解决学校的实际问题出发，一起来设计智慧学校吧。</p>
                                    <!--<p><em class="join">316 人参加</em><em class="end">30 天截止</em></p>-->
                                </td>
                                <td class="td_r">
                                    <div class="progress">剩30天</div>
                                </td>
                            </tr>
                        </table>
                        <div class="person">
                            <span class="name">Cyan</span>
                            <div class="img"></div>
                        </div>
                    </div>
                    <div class="box_b"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="challenge_post">
    	
        <div class="challenge_b">
           	<div class="mb25"><img src="<?= $this->__STATIC__ ?>images/content/challenge_title2.png"></div>
            <div class="thumbnail" style="margin-bottom:30px;"><img src="<?= $this->__STATIC__ ?>images/content/work_post_img03.jpg" /></div>
            <div class="desc"><div class="p_left" style="padding-left:0px;"><p class="mb40">信息时代的到来改变着我们的生活，学校也变得“智慧”了，数字图书馆、电子书包、家校互动的云平台等等，这些都让我们的学习变得无处不在并且更加的容易，那么你能为学校设计一个解决方案，让学校变得更加智能化吗？</p></div></div>
            
            
            
<!--            <div class="desc">-->
<!--            	<a href="<?= $this->__STATIC__ ?>resource/resource.zip">-->
<!--            		<div style="width:362px;height:97px;background:url(<?= $this->__STATIC__ ?>images/btn_resource_bg.png);">-->
<!--	            		<div style="padding-left:110px;padding-top:25px;">-->
<!--	            			<div style="color:#7ac543;font: normal 18px 'microsoft yahei','Hiragino Sans GB W3';">-->
<!--	            				Resource.zip-->
<!--	            			</div>-->
<!--	            			<div style="padding-top:2px;color:#999999;font: normal 16px 'microsoft yahei','Hiragino Sans GB W3';">-->
<!--	            				12M-->
<!--	            			</div>-->
<!--	            		</div>-->
<!--	            	</div>-->
<!--            	</a>-->
<!--            </div>-->
            
            <div class="desc">
            	<table cellspacing=0 cellpadding=0 style="width:100%;">
            		<tr>
            			<td width="360">
            				<div class="gallery_a_l">
				                <a class="button" href="/account/topostzuopinfromchallenge?from=<?php echo $_GET['from']?>&challenge_id=4">参与召集</a>
				            </div>
            			</td>
            			<td width="360">
            				<div class="gallery_a_2" style="width:360px;color:#999999;">
				                	加入此召集，拿出你的得意大作向小伙伴<br />show出你自己吧!
				            </div>
            			</td>
            		</tr>
            	</table>
            </div>
            <div class="mb25"><img src="<?= $this->__STATIC__ ?>images/content/challenge_title3.png"></div>
            <ul id="remen_zuopin" class="work_two clearboth">
            	<li><img src="<?= $this->__STATIC__ ?>images/content/indicator.gif"/></li>
<!--                <li>-->
<!--                    <p class="title clearboth">-->
<!--                        <span class="title_l"><em class="text">SOS按钮</em><em class="num">216</em></span>-->
<!--                        <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon2.png"></span>-->
<!--                    </p>-->
<!--                    <span class="img"><a href="/gallery/366"><img src="<?= $this->__STATIC__ ?>images/delete/10.jpg"></a></span>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <p class="title clearboth">-->
<!--                        <span class="title_l"><em class="text">智慧学校</em><em class="num">132</em></span>-->
<!--                        <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon4.png"></span>-->
<!--                    </p>-->
<!--                    <span class="img"><a href="/gallery/363"><img src="<?= $this->__STATIC__ ?>images/delete/11.jpg"></a></span>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <p class="title clearboth">-->
<!--                        <span class="title_l"><em class="text">Eating</em><em class="num">56</em></span>-->
<!--                        <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon5.png"></span>-->
<!--                    </p>-->
<!--                    <span class="img"><a href="/gallery/361"><img src="<?= $this->__STATIC__ ?>images/delete/12.jpg"></a></span>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <p class="title clearboth">-->
<!--                        <span class="title_l"><em class="text">垃圾感应器</em><em class="num">83</em></span>-->
<!--                        <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon2.png"></span>-->
<!--                    </p>-->
<!--                    <span class="img"><a href="/gallery/362"><img src="<?= $this->__STATIC__ ?>images/delete/13.jpg"></a></span>-->
<!--                </li>-->
            </ul>
            <script>
            	$.post('/mzworld/?c=challenge&m=gethotzuopinlist&from=<?php echo $_GET['from']?>&collenge_id=4',function (data){
					$('#remen_zuopin').html(data);
                })
            </script>
            <div class="mb25"><img src="<?= $this->__STATIC__ ?>images/content/challenge_title4.png"></div>
            <ul id="all_zuopin" class="work_two clearboth">
            	<li><img src="<?= $this->__STATIC__ ?>images/content/indicator.gif"/></li>
<!--                <li>-->
<!--                    <p class="title clearboth">-->
<!--                        <span class="title_l"><em class="text">SOS按钮</em><em class="num">216</em></span>-->
<!--                        <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon2.png"></span>-->
<!--                    </p>-->
<!--                    <span class="img"><a href="/gallery/366"><img src="<?= $this->__STATIC__ ?>images/delete/10.jpg"></a></span>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <p class="title clearboth">-->
<!--                        <span class="title_l"><em class="text">智慧学校</em><em class="num">132</em></span>-->
<!--                        <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon4.png"></span>-->
<!--                    </p>-->
<!--                    <span class="img"><a href="/gallery/363"><img src="<?= $this->__STATIC__ ?>images/delete/11.jpg"></a></span>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <p class="title clearboth">-->
<!--                        <span class="title_l"><em class="text">Eating</em><em class="num">56</em></span>-->
<!--                        <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon5.png"></span>-->
<!--                    </p>-->
<!--                    <span class="img"><a href="/gallery/361"><img src="<?= $this->__STATIC__ ?>images/delete/12.jpg"></a></span>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <p class="title clearboth">-->
<!--                        <span class="title_l"><em class="text">垃圾感应器</em><em class="num">83</em></span>-->
<!--                        <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon2.png"></span>-->
<!--                    </p>-->
<!--                    <span class="img"><a href="/gallery/362"><img src="<?= $this->__STATIC__ ?>images/delete/13.jpg"></a></span>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <p class="title clearboth">-->
<!--                        <span class="title_l"><em class="text">智慧学校</em><em class="num">92</em></span>-->
<!--                        <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon4.png"></span>-->
<!--                    </p>-->
<!--                    <span class="img"><a href="/gallery/368"><img src="<?= $this->__STATIC__ ?>images/delete/14.jpg"></a></span>-->
<!--                </li>-->
            </ul>
            <script>
            	$.post('/mzworld/?c=challenge&m=getcollengezuopinlist&from=<?php echo $_GET['from']?>&collenge_id=4',function (data){
					$('#all_zuopin').html(data);
                })
            </script>

        </div>
        
    </div>
</div>
<!------参与召集添加作品----->
<div class="select_challenge" style="display:none;">
    <div class="tbox">
    	<div class="tclose"></div>
        <div class="tbox_t">
        	<span class="title">选择作品</span><a href="/account/topostzuopinfromchallenge?challenge_id=4">发布新作品</a>
        </div>
        <div class="tbox_b clearboth">
        	<div class="scroll">
                <ul class="work_list clearboth">
                    <li class="cur">
                        <span class="title clearboth"><em class="text">Pixel Mount</em></span>
                        <span class="img"><img src="/assets/static/images/content/challenge_4.jpg"></span>
                        <i></i>
                    </li>
                    <li>
                        <span class="title clearboth"><em class="text">Pixel Mount</em></span>
                        <span class="img"><img src="/assets/static/images/content/challenge_4.jpg"></span>
                        <i></i>
                    </li>
                    <li>
                        <span class="title clearboth"><em class="text">Pixel Mount</em></span>
                        <span class="img"><img src="/assets/static/images/content/challenge_4.jpg"></span>
                        <i></i>
                    </li>
                    <li>
                        <span class="title clearboth"><em class="text">Pixel Mount</em></span>
                        <span class="img"><img src="/assets/static/images/content/challenge_4.jpg"></span>
                        <i></i>
                    </li>
                    <li>
                        <span class="title clearboth"><em class="text">Pixel Mount</em></span>
                        <span class="img"><img src="/assets/static/images/content/challenge_4.jpg"></span>
                        <i></i>
                    </li>
                    <li>
                        <span class="title clearboth"><em class="text">Pixel Mount</em></span>
                        <span class="img"><img src="/assets/static/images/content/challenge_4.jpg"></span>
                        <i></i>
                    </li>
                    <li>
                        <span class="title clearboth"><em class="text">Pixel Mount</em></span>
                        <span class="img"><img src="/assets/static/images/content/challenge_4.jpg"></span>
                        <i></i>
                    </li>
                    <li>
                        <span class="title clearboth"><em class="text">Pixel Mount</em></span>
                        <span class="img"><img src="/assets/static/images/content/challenge_4.jpg"></span>
                        <i></i>
                    </li>
                    <li>
                        <span class="title clearboth"><em class="text">Pixel Mount</em></span>
                        <span class="img"><img src="/assets/static/images/content/challenge_4.jpg"></span>
                        <i></i>
                    </li>
                    <li>
                        <span class="title clearboth"><em class="text">Pixel Mount</em></span>
                        <span class="img"><img src="/assets/static/images/content/challenge_4.jpg"></span>
                        <i></i>
                    </li>
                    <li>
                        <span class="title clearboth"><em class="text">Pixel Mount</em></span>
                        <span class="img"><img src="/assets/static/images/content/challenge_4.jpg"></span>
                        <i></i>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
//        var top=$(window).scrollTop()+100;
//        $(".select_challenge,.layer_mask").show();
//        $(".select_challenge").css("top",top+"px");

        
</script>
<!------退出召集删除作品----->
<div class="exit_challenge">
    <div class="tbox">
    	<div class="tclose"></div>
        <input type="button" value="移出召集" class="submit">
        <div class="tbox_t">
        	<span class="title">选择作品</span>
        </div>
        <div class="tbox_b clearboth">
        	<div class="scroll">
                <ul class="work_list clearboth">
                    <li class="cur">
                        <span class="title clearboth"><em class="text">Pixel Mount</em></span>
                        <span class="img"><img src="/assets/static/images/content/challenge_4.jpg"></span>
                        <i></i>
                    </li>
                    <li>
                        <span class="title clearboth"><em class="text">Pixel Mount</em></span>
                        <span class="img"><img src="/assets/static/images/content/challenge_4.jpg"></span>
                        <i></i>
                    </li>
                    <li>
                        <span class="title clearboth"><em class="text">Pixel Mount</em></span>
                        <span class="img"><img src="/assets/static/images/content/challenge_4.jpg"></span>
                        <i></i>
                    </li>
                    <li>
                        <span class="title clearboth"><em class="text">Pixel Mount</em></span>
                        <span class="img"><img src="/assets/static/images/content/challenge_4.jpg"></span>
                        <i></i>
                    </li>
                    <li>
                        <span class="title clearboth"><em class="text">Pixel Mount</em></span>
                        <span class="img"><img src="/assets/static/images/content/challenge_4.jpg"></span>
                        <i></i>
                    </li>
                    <li>
                        <span class="title clearboth"><em class="text">Pixel Mount</em></span>
                        <span class="img"><img src="/assets/static/images/content/challenge_4.jpg"></span>
                        <i></i>
                    </li>
                    <li>
                        <span class="title clearboth"><em class="text">Pixel Mount</em></span>
                        <span class="img"><img src="/assets/static/images/content/challenge_4.jpg"></span>
                        <i></i>
                    </li>
                    <li>
                        <span class="title clearboth"><em class="text">Pixel Mount</em></span>
                        <span class="img"><img src="/assets/static/images/content/challenge_4.jpg"></span>
                        <i></i>
                    </li>
                    <li>
                        <span class="title clearboth"><em class="text">Pixel Mount</em></span>
                        <span class="img"><img src="/assets/static/images/content/challenge_4.jpg"></span>
                        <i></i>
                    </li>
                    <li>
                        <span class="title clearboth"><em class="text">Pixel Mount</em></span>
                        <span class="img"><img src="/assets/static/images/content/challenge_4.jpg"></span>
                        <i></i>
                    </li>
                    <li>
                        <span class="title clearboth"><em class="text">Pixel Mount</em></span>
                        <span class="img"><img src="/assets/static/images/content/challenge_4.jpg"></span>
                        <i></i>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!----------------------邀请他人----------------------->
<div class="invite_other">
    <div class="fbox_t clearboth">
        <a class="close" href="javascript:;"></a>
    </div>
    <div class="fbox_c clearboth">
    		<div class="title">邀请朋友查看召集</div>
        <input type="text" class="link" value="http://www.scratchworld.com/calling/1730723" />
        <input type="button" class="copybutton" value="复制邀请链接" />
    </div>
</div>
<?php
require($this->__RAD__ . 'footer.php');
?>
<script src="<?= $this->__STATIC__ ?>js/jquery.zclip.min.js"></script>
<script type="text/javascript">
	$(function(){
		fun.challenge();
		var copy=true;
		$("#invite_link").click(function(){
			$(".invite_other,.layer_mask").show();
			if(copy==true){
				copy=false;
				$(".copybutton").zclip({
						path: "<?= $this->__STATIC__ ?>js/ZeroClipboard.swf",
						copy: function(){
								return $(this).parent().find(".link").val();
						},
						afterCopy:function(){/* 复制成功后的操作 */
								var $copysuc = $("<div class='copy-tips'><div class='copy-tips-wrap'>复制成功 !</div></div>");
								$("body").find(".copy-tips").remove().end().append($copysuc);
								$(".copy-tips").fadeOut(3000);
						}
				});
			}
		});
	})
</script>
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
							if(scroll_top<120){
								$("#avatar_m").stop().css({"top":move_up-130+"px"});
								$("#avatar_m").animate({top:"270px"},2000,function(){
									$("#avatar_m").removeClass().addClass("avatar_right");
								});
							}else{
									$("#avatar_m").stop().css({"top":move_up-130+"px"});
									$("#avatar_m").animate({top:move_up-480+"px"},2000,function(){
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