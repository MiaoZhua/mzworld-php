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
    <div class="post_title"></div>
    <div class="post_cont">
        <div class="post_tree_1"></div>
        <div class="post_tree_2"></div>
        <div class="post_tree_3"></div>
        <div class="post_tree_4"></div>
        <div class="post_tree_5"></div>
        <div class="post_tree_6"></div>
        <div class="post_tree_7"></div>
        <div class="post_tree_8"></div>
        <div class="post_tree_9"></div>
		<?php
        require($this->__RAD__ . '_avatar.php');
        ?>
        <div class="challenge_box">
            <div class="challenge_box_t"></div>
            <div class="challenge_box_c">
                <div class="box_cont clearboth">
                    <div class="box_cont_l"><img src="<?= $this->__STATIC__ ?>images/content/post_icon_1.png" /></div>
                    <div class="box_cont_r">
                        <div class="title"><input name="" type="text" value="召集名称" onBlur="if(this.value=='')this.value='召集名称';this.style.color='#8C8C8C';" onClick="if(this.value=='召集名称')this.value='';this.style.color='#333333';" /></div>
                        <div class="desc"><textarea name="" cols="" rows="" onBlur="if(this.value=='')this.value='召集的简要描述';this.style.color='#8C8C8C';" onClick="if(this.value=='召集的简要描述')this.value='';this.style.color='#333333';">召集的简要描述</textarea></div>
                    </div>
                </div>
            </div>
            <div class="box_b"></div>
        </div>
    </div>
    <div class="challenge_post">
        <table cellpadding="0" cellspacing="0" border="0" class="work_post_table">
            <tr>
                <td class="td_l">开放时间</td>
                <td><div class="timer"><span>关闭</span><span>无限时</span><span class="cur">30天</span><span>60天</span><span>自定义</span></div></td>
            </tr>
            <tr>
                <td class="td_l"></td>
                <td><div class="tips">对应截止日期：2015-05-01</div></td>
            </tr>
            <tr>
                <td class="td_l">额外介绍</td>
                <td>
                	<div class="sections">
                    	<div class="section">
                        	<div class="thumbnail"><img src="<?= $this->__STATIC__ ?>images/content/work_post_img2.png" /><s class="mask"></s><span><em>presentation 01.jpg</em></span></div>
                            <a class="close" href="javascript:;"></a>
                            <span class="move_t"></span>
                            <span class="move_b"></span>
                        </div>
                        <div class="section">
                            <div class="files clearboth">
                                <a class="clearboth" href="javascript:;">
                                    <span class="icon"></span>
                                    <span class="info">
                                        <strong>Pictures.zip</strong>
                                        12 MB
                                    </span>
                                </a>
                            </div>
                            <a class="close" href="javascript:;"></a>
                            <span class="move_t"></span>
                            <span class="move_b"></span>
                        </div>
                        <div class="section">
                            <div class="post_textarea">
                                <textarea name="" cols="" rows="" class="textarea" onBlur="if(this.value=='')this.value='在此输入描述文本';this.style.color='#999';" onClick="if(this.value=='在此输入描述文本')this.value='';this.style.color='#333333';">在此输入描述文本</textarea>
                            </div>
                            <a class="close" href="javascript:;"></a>
                            <span class="move_t"></span>
                            <span class="move_b"></span>
                        </div>
                    </div>
                    <ul class="buttons clearboth">
                        <li class="item"><a href="javascript:;">添加图片</a></li>
                        <li class="item2"><a href="javascript:;">添加附件</a></li>
                        <li class="item3"><a href="javascript:;">添加描述</a></li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td class="td_l">添加Tag</td>
                <td>
                    <input class="tag_add" type="text" value="最多不超过5个，空格隔开" onBlur="if(this.value=='')this.value='最多不超过5个，空格隔开';this.style.color='#999';" onClick="if(this.value=='最多不超过5个，空格隔开')this.value='';this.style.color='#333333';" />
                    <div class="tag_tips"></div>
                </td>
            </tr>
            <tr>
                <td class="td_l"></td>
                <td>
                    <div class="tag_recommend">推荐Tag<a href="javascript:;">游戏</a><a href="javascript:;">动画</a><a href="javascript:;">音乐</a><a href="javascript:;">美术</a></div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input class="dissolve" name="" type="button" value="解散召集" /> <input class="submit" name="" type="button" value="发布召集" /></td>
            </tr>
        </table>
    </div>
</div>
<!------解散召集提示----->
<div class="dissolve_challenge">
    <div class="tbox">
    	<div class="tclose"></div>
        <div class="tbox_b clearboth">
        	<div class="tbox_b_l">
                <ul class="convene_list clearboth">
                    <li>
                        <p class="title clearboth">
                            <span class="title_l"><em class="text">Ailey 的召集</em><em class="num">316</em></span>
                            <span class="title_r"><img src="/assets/static/images/home/icon2.png"></span>
                        </p>
                        <span class="img"> 一起玩坏马里奥 </span>
                    </li>
                </ul>
            </div>
            <div class="tbox_b_r">
            	<span class="tips">确定解散召集吗？</span>
                <span class="cancel_btn">取消</span><span class="dissolve_btn">解散</span>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(function(){
		fun.challengePost();	
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
<?php
require($this->__RAD__ . 'footer.php');
?>
</body>
</html>