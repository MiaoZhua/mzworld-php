<?php
require($this->__RAD__ . '_head.php');
?>
<link rel="stylesheet" href="<?= $this->__STATIC__ ?>css/index.css">
</head>
<body>
<?php
require($this->__RAD__ . 'top.php');
?>
<!--作品展览馆-->
<div class="gallery">
    <div class="gallery_top">
        <div class="layer" data-0="top:0px;" data-430="top:200px;"></div>
        <div class="layer2" data-0="top:0px;" data-430="top:150px;"></div>
        <div class="layer3" data-0="top:0px;" data-430="top:100px;"></div>
    </div>
    <div class="gallery_center">
        <div class="tree">
            <span class="mask"></span>
            <span class="img"><img src="<?= $this->__STATIC__ ?>images/works_5.jpg" /></span>
            <div class="tip">
                <span>最新召集</span>
                <strong><a href="/challenge/3?from=gallery" target="_blank">奇妙随机数 !</a></strong>
            </div>
        </div>
        <div class="mountain" data-10="top:-30px;" data-450="top:-50px;"></div>
        <div class="tree_style tree_1" data-top-top="top:-16px;" data-bottom-bottom="top:110px;"></div>
        <div class="tree_style2 tree_2" data-top-top="top:68px;" data-bottom-bottom="top:118px;"></div>
        <div class="tree_style tree_3" data-top-top="top:44px;" data-bottom-bottom="top:120px;"></div>
        <div class="tree_style2 tree_4" data-top-top="top:-30px;" data-bottom-bottom="top:70px;"></div>
        <div class="pepole p_1">
            <div class="img"></div>
            <div class="box">
                <span></span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_2">
            <div class="img"></div>
            <div class="box">
                <span></span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_3">
            <div class="img"></div>
            <div class="box">
                <span></span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_4">
            <div class="img"></div>
            <div class="box">
                <span></span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_5">
            <div class="img"></div>
            <div class="box">
                <span></span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_6">
            <div class="img"></div>
            <div class="box">
                <span></span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_7">
            <div class="img"></div>
            <div class="box">
                <span>Hello!</span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_8">
            <div class="img"></div>
            <div class="box">
                <span></span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_9">
            <div class="img"></div>
            <div class="box">
                <span></span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_10">
            <div class="img"></div>
            <div class="box">
                <span></span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_11">
            <div class="img"></div>
            <div class="box">
                <span></span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_12">
            <div class="img"></div>
            <div class="box">
                <span></span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_13">
            <div class="img"></div>
            <div class="box">
                <span></span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_14">
            <div class="img"></div>
            <div class="box">
                <span></span>
                <s></s>
            </div>
        </div>
        <!--向下滚动查看-->
        <div class="view_more">
            <span class="tip">向下滚动查看</span>
            <span class="arrow"></span>
        </div>
        <div class="left_arrow"><a href="/">我的空间</a></div>
        <div class="right_arrow"><a href="/tutorial">微课</a></div>
		<?php
        require($this->__RAD__ . '_avatar.php');
        ?>
    </div>
    <div class="gallery_cont">
        <div class="gallery_a block" data-type="right">
            <div class="tree_style tree_5" data-top-top="top:324px;" data-bottom-bottom="top:555px;"></div>
            <div class="tree_style2 tree_6" data-top-top="top:500px;" data-bottom-bottom="top:700px;"></div>
            <div class="tree_style tree_7" data-top-top="top:205px;" data-bottom-bottom="top:455px;"></div>
            <div class="gallery_a_l">
                <a class="button" href="/account/opusPost">发布作品</a>
                发布你的作品<br />来向小伙伴show出你自己
            </div>
            <?php /*?><div class="gallery_a_r">
                <a class="button2" href="/account/challengePost">发布召集</a>
                发布召集活动<br />招呼大家一起来创造新作
            </div><?php */?>
        </div>
        <div class="gallery_b block" data-type="left">
            <div class="tree_style tree_11" data-top-top="top:735px;" data-bottom-bottom="top:875px;"></div>
            <div class="tree_style2 tree_12" data-top-top="top:670px;" data-bottom-bottom="top:870px;"></div>
            <div class="tree_style2 tree_13" data-top-top="top:1008px;" data-bottom-bottom="top:1108px;"></div>
            <div class="tree_style tree_14" data-top-top="top:858px;" data-bottom-bottom="top:1058px;"></div>
            <div class="tree_style3 tree_19"></div>
            <div class="title_style"></div>
            <div class="clearboth">
                <ul id="order-type" class="type_list clearboth">
                    <li class="cur">最多人看</li>
                    <li>最多人赞</li>
                    <li>最新发布</li>
                </ul>
            </div>
            <div class="gallery_b_a" id="gallery-top">

            </div>
            <div class="gallery_b_b clearboth">
                <div class="cont">
                    <div class="left_btn"></div>
                    <div class="right_btn"></div>
                    <div class="gallery_scroll">
                        <div class="box clearboth" id="gallery-data">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="gallery_c block" data-type="right">
            <div class="tree_style tree_15" data-top-top="top:480px;" data-bottom-bottom="top:680px;"></div>
            <div class="tree_style2 tree_16" data-top-top="top:420px;" data-bottom-bottom="top:680px;"></div>
            <div class="tree_style tree_17" data-top-top="top:619px;" data-bottom-bottom="top:740px;"></div>
            <div class="tree_style4 tree_18"></div>
            <div class="title_style" id="p_gallery"></div>
            <div class="box clearboth">
            	<a href="/challenge/7?from=gallery" target="_blank">
	                <div class="box_l">
	                    <span class="name"></span>
	                    <div class="people"><img src="<?= $this->__STATIC__ ?>images/gallery/people2.png" /></div>
	                </div>
	                <div class="box_r">
	                    <div class="cont">
	                        <div class="cont_t clearboth"><h3 class="title"><a href="/challenge/7?from=gallery" target="_blank" style="font: normal 32px 'gothamroundedbook','幼圆','Hiragino Sans GB W3';">少年强则中国强</a></h3><!--<span class="right"><em class="join">316 人参加</em><em class="end">30 天截止</em></span>--></div>
	                        <a href="/challenge/7?from=gallery" style="color:white;" target="_blank"><p class="desc">Scratch 是由美国麻省理工学院媒体实验室专门针对儿童编程学习，设计的应用软件。为此，美国MIT创办了Scratch Day, 为Scratch编程爱好者提供了...</p></a>
	                    </div>
	                    <div class="list">
	                        <ul id="gallerycollenges_7" class="work_list clearboth">
	<!--                            <li>-->
	<!--                                <span class="img"><img src="<?= $this->__STATIC__ ?>images/content/challenge_01.jpg"></span>-->
	<!--                            </li>-->
	<!--                            <li>-->
	<!--                                <span class="img"><img src="<?= $this->__STATIC__ ?>images/content/challenge_02.jpg"></span>-->
	<!--                            </li>-->
	<!--                            <li>-->
	<!--                                <span class="img"><img src="<?= $this->__STATIC__ ?>images/content/challenge_03.jpg"></span>-->
	<!--                            </li>-->
	                        </ul>
	                        <script>
				            	$.post('/mzworld/?c=challenge&m=getgalleryzuopinlist&collenge_id=7',function (data){
									$('#gallerycollenges_7').html(data);
				                })
				            </script>
	                    </div>
	                </div>
                </a>
            </div>
            <div class="box clearboth">
            	<a href="/challenge/6?from=gallery" target="_blank">
	                <div class="box_l">
	                    <span class="name"></span>
	                    <div class="people"><img src="<?= $this->__STATIC__ ?>images/gallery/people2.png" /></div>
	                </div>
	                <div class="box_r">
	                    <div class="cont">
	                        <div class="cont_t clearboth"><h3 class="title"><a href="/challenge/6?from=gallery" target="_blank" style="font: normal 32px 'gothamroundedbook','幼圆','Hiragino Sans GB W3';">Happy Scratch Day, Hot Scratch Show</a></h3><!--<span class="right"><em class="join">316 人参加</em><em class="end">30 天截止</em></span>--></div>
	                        <a href="/challenge/6?from=gallery" style="color:white;" target="_blank"><p class="desc">Scratch 是由美国麻省理工学院媒体实验室专门针对儿童编程学习，设计的应用软件。为此，美国MIT创办了Scratch Day, 为Scratch编程爱好者提供了...</p></a>
	                    </div>
	                    <div class="list">
	                        <ul id="gallerycollenges_6" class="work_list clearboth">
	<!--                            <li>-->
	<!--                                <span class="img"><img src="<?= $this->__STATIC__ ?>images/content/challenge_01.jpg"></span>-->
	<!--                            </li>-->
	<!--                            <li>-->
	<!--                                <span class="img"><img src="<?= $this->__STATIC__ ?>images/content/challenge_02.jpg"></span>-->
	<!--                            </li>-->
	<!--                            <li>-->
	<!--                                <span class="img"><img src="<?= $this->__STATIC__ ?>images/content/challenge_03.jpg"></span>-->
	<!--                            </li>-->
	                        </ul>
	                        <script>
				            	$.post('/mzworld/?c=challenge&m=getgalleryzuopinlist&collenge_id=6',function (data){
									$('#gallerycollenges_6').html(data);
				                })
				            </script>
	                    </div>
	                </div>
                </a>
            </div>
            <div class="box clearboth">
            	<a href="/challenge/1?from=gallery" target="_blank">
	                <div class="box_l">
	                    <span class="name"></span>
	                    <div class="people"><img src="<?= $this->__STATIC__ ?>images/gallery/people2.png" /></div>
	                </div>
	                <div class="box_r">
	                    <div class="cont">
	                        <div class="cont_t clearboth"><h3 class="title"><a href="/challenge/1?from=gallery" target="_blank">电子废弃物</a></h3><!--<span class="right"><em class="join">316 人参加</em><em class="end">30 天截止</em></span>--></div>
	                        <a href="/challenge/1?from=gallery" style="color:white;" target="_blank"><p class="desc">你知道如何回收电子废弃物吗？你知道电子废弃物的回收过程是怎样的吗？大胆设想如何在学校/社区回收电子废弃物！你就是那个可以变废为...</p></a>
	                    </div>
	                    <div class="list">
	                        <ul id="gallerycollenges_1" class="work_list clearboth">
	<!--                            <li>-->
	<!--                                <span class="img"><img src="<?= $this->__STATIC__ ?>images/content/challenge_01.jpg"></span>-->
	<!--                            </li>-->
	<!--                            <li>-->
	<!--                                <span class="img"><img src="<?= $this->__STATIC__ ?>images/content/challenge_02.jpg"></span>-->
	<!--                            </li>-->
	<!--                            <li>-->
	<!--                                <span class="img"><img src="<?= $this->__STATIC__ ?>images/content/challenge_03.jpg"></span>-->
	<!--                            </li>-->
	                        </ul>
	                        <script>
				            	$.post('/mzworld/?c=challenge&m=getgalleryzuopinlist&collenge_id=1',function (data){
									$('#gallerycollenges_1').html(data);
				                })
				            </script>
	                    </div>
	                </div>
                </a>
            </div>
            <!--<div class="box clearboth red_bg">
                <div class="box_l">
                    <span class="name">Cyan</span>
                    <div class="people"><img src="<?= $this->__STATIC__ ?>images/gallery/people3.png" /></div>
                </div>
                <div class="box_r">
                    <div class="cont">
                        <div class="cont_t clearboth"><h3 class="title"><a href="/challenge/1?from=gallery">一起玩坏马里奥</a></h3><span class="right"><em class="join">316 人参加</em><em class="end">30 天截止</em></span></div>
                        <p class="desc">马里奥Remix召集日起，根据发布的马里奥原型，重新设计马里奥玩法，最受欢...</p>
                    </div>
                    <div class="list">
                        <ul class="work_list clearboth">
                            <li>
                                <span class="img"><a href="/gallery/1"><img src="<?= $this->__STATIC__ ?>images/content/challenge_4.jpg"></a></span>
                            </li>
                            <li>
                                <span class="img"><a href="/gallery/1"><img src="<?= $this->__STATIC__ ?>images/content/challenge_4.jpg"></a></span>
                            </li>
                            <li>
                                <span class="img"><a href="/gallery/1"><img src="<?= $this->__STATIC__ ?>images/content/challenge_4.jpg"></a></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>-->
            <div class="box clearboth">
            	<a href="/challenge/2?from=gallery" target="_blank">
	                <div class="box_l">
	                    <span class="name"></span>
	                    <div class="people"><img src="<?= $this->__STATIC__ ?>images/gallery/people2.png" /></div>
	                </div>
	                <div class="box_r">
	                    <div class="cont">
	                        <div class="cont_t clearboth"><h3 class="title"><a href="/challenge/2?from=gallery" target="_blank">空气污染</a></h3><!--<span class="right"><em class="join">316 人参加</em><em class="end">30 天截止</em></span>--></div>
	                        <a href="/challenge/2?from=gallery" target="_blank" style="color:white;"><p class="desc">想像柴静姐姐一样为城市蓝天出一份自己的力吗？现在就行动起来，从自己做起，从生活的家庭学校做起，让我们一起来畅想可以减少污染恢...</p></a>
	                    </div>
	                    <div class="list">
	                        <ul id="gallerycollenges_2" class="work_list clearboth">
	                            <!--<li class="add">
	                                <span class="img"><a class="btn" href="javascript:;"></a></span>
	                            </li>-->
	<!--                            <li>-->
	<!--                                <span class="img"><img src="<?= $this->__STATIC__ ?>images/content/challenge_04.jpg"></span>-->
	<!--                            </li>-->
	<!--                            <li>-->
	<!--                                <span class="img"><img src="<?= $this->__STATIC__ ?>images/content/challenge_05.jpg"></span>-->
	<!--                            </li>-->
	<!--                            <li>-->
	<!--                                <span class="img"><img src="<?= $this->__STATIC__ ?>images/content/challenge_06.jpg"></span>-->
	<!--                            </li>-->
	                        </ul>
	                        <script>
				            	$.post('/mzworld/?c=challenge&m=getgalleryzuopinlist&collenge_id=2',function (data){
									$('#gallerycollenges_2').html(data);
				                })
				            </script>
	                    </div>
	                </div>
                </a>
            </div>
            <div class="box clearboth red_bg">
                <div class="box_l">
                    <span class="name">admin</span>
                    <div class="people"><img src="<?= $this->__STATIC__ ?>images/gallery/people.png" /></div>
                </div>
                <div class="box_r">
                	<a href="/challenge/3?from=gallery" target="_blank">
	                    <div class="cont">
	                        <div class="cont_t clearboth"><h3 class="title"><a href="/challenge/3?from=gallery" target="_blank">奇妙随机数-上海市日新实验小学</a></h3><!--<span class="right"><em class="join">316 人参加</em><em class="end">30 天截止</em></span>--></div>
	                        <a href="/challenge/3?from=gallery" target="_blank" style="color:white;"><p class="desc">Scratch中的“在1到10间随机选一个数”的脚本可以帮助我们做好多有趣的游戏和酷炫的效果，一起来玩奇妙的随机数吧</p></a>
	                    </div>
	                    <div class="list">
	                        <ul id="gallerycollenges_3" class="work_list clearboth">
	                            <!--<li class="add">
	                                <span class="img"><a class="btn" href="javascript:;"></a></span>
	                            </li>-->
	<!--                            <li>-->
	<!--                                <span class="img"><img src="<?= $this->__STATIC__ ?>images/delete/01.jpg"></span>-->
	<!--                            </li>-->
	<!--                            <li>-->
	<!--                                <span class="img"><img src="<?= $this->__STATIC__ ?>images/delete/2.jpg"></span>-->
	<!--                            </li>-->
	<!--                            <li>-->
	<!--                                <span class="img"><img src="<?= $this->__STATIC__ ?>images/delete/6.jpg"></span>-->
	<!--                            </li>-->
	                        </ul>
	                        <script>
				            	$.post('/mzworld/?c=challenge&m=getgalleryzuopinlist&collenge_id=3',function (data){
									$('#gallerycollenges_3').html(data);
				                })
				            </script>
	                    </div>
                    </a>
                </div>
            </div>
            <div class="box clearboth red_bg">
                <div class="box_l">
                    <span class="name">admin</span>
                    <div class="people"><img src="<?= $this->__STATIC__ ?>images/gallery/people.png" /></div>
                </div>
                <div class="box_r">
                	<a href="/challenge/4?from=gallery" target="_blank">
	                    <div class="cont">
	                        <div class="cont_t clearboth"><h3 class="title"><a href="/challenge/4?from=gallery" target="_blank">智慧学校-上海市日新实验小学</a></h3><!--<span class="right"><em class="join">316 人参加</em><em class="end">30 天截止</em></span>--></div>
	                        <a href="/challenge/4?from=gallery" target="_blank" style="color:white;"><p class="desc">信息时代，想让你的学校变得更加的智能吗？还等什么？来这里，用你的天才想象力，从解决学校的实际问题出发，一起来设计智慧学校吧。</p></a>
	                    </div>
	                    <div class="list">
	                        <ul id="gallerycollenges_4" class="work_list clearboth">
	                            <!--<li class="add">
	                                <span class="img"><a class="btn" href="javascript:;"></a></span>
	                            </li>-->
	                            <li>
	                                <span class="img"><img src="<?= $this->__STATIC__ ?>images/delete/10.jpg"></span>
	                            </li>
	                            <li>
	                                <span class="img"><img src="<?= $this->__STATIC__ ?>images/delete/11.jpg"></span>
	                            </li>
	                            <li>
	                                <span class="img"><img src="<?= $this->__STATIC__ ?>images/delete/12.jpg"></span>
	                            </li>
	                        </ul>
	                        <script>
				            	$.post('/mzworld/?c=challenge&m=getgalleryzuopinlist&collenge_id=4',function (data){
									$('#gallerycollenges_4').html(data);
				                })
				            </script>
	                    </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php
    require($this->__RAD__ . 'footer.php');
    ?>
</div>
<script>
    var _opusCount = '<?= $this->opusCount ?>' >> 0, _cdn = '<?= $this->__CDN__ ?>';
    $(function(){
        fun.gallery();
        var s = skrollr.init({
            edgeStrategy: 'set',
            easing: {
                WTF: Math.random,
                inverted: function(p) {
                    return 1-p;
                }
            }
        });
    })
</script>
<script src="<?= $this->__STATIC__ ?>js/gallery.js"></script>
</body>
</html>
