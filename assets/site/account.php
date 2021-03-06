<?php
require($this->__RAD__ . '_head.php');
?>
<link rel="stylesheet" href="<?= $this->__STATIC__ ?>css/index.css">
</head>
<body>
<?php
require($this->__RAD__ . 'top.php');
?>
<div class="home">
    <div class="home_t">
        <div class="layer" data-0="top:0px;" data-430="top:300px;"></div>
        <div class="layer2" data-0="top:0px;" data-430="top:250px;"></div>
        <div class="layer3" data-0="top:0px;" data-430="top:200px;"></div>
        <div class="layer4" data-0="top:0px;" data-430="top:150px;"></div>
        <div class="layer5" data-0="top:0px;" data-430="top:100px;"></div>
    </div>
    <div class="home_c">
        <div class="welcome welcome_open">
            <div class="welcome_u">
                <span class="text"></span>
                <s class="arrow"></s>
            </div>
            <div class="welcome_d">
                <s class="arrow"></s>
            </div>
        </div>
        <div class="shadow"></div>
        <!--向下滚动查看-->
        <div class="view_more">
            <span class="tip">向下滚动查看</span>
            <span class="arrow"></span>
        </div>
        <!--<div class="login">
            <div class="img"></div>
            <div class="box"><span>登录，请点我！</span><s></s></div>
        </div>-->
        <div class="right_arrow"><a href="gallery">画廊</a></div>
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
        <!--登录成功之后-->
        <div class="balls"></div>
        <div class="ball_1" data-0="top:-132px;" data-700="top:-302px;"><span id="a-opus">0</span>作品</div>
        <div class="ball_2" data-0="top:15px;" data-700="top:-115px;"><span id="a-day">0</span>诞生天数<s></s></div>
        <div class="ball_3" data-0="top:-160px;" data-700="top:-500px;"><span id="a-praise">0</span>赞 !</div>
        <div class="ball_4" data-0="top:-50px;" data-700="top:-260px;"><span id="a-friend">0</span>朋友</div>
    </div>
    <div class="sections home_line">
        <div class="section_a block" data-type="right">
            <div class="section_a_cont">
                <!--背景颜色球-->
                <span class="scroll_ball scroll_ball_1" data-top-top="top:400px;" data-bottom-bottom="top:640px;"></span>
                <span class="scroll_ball scroll_ball_2" data-top-top="top:200px;" data-bottom-bottom="top:375px;"></span>
                <span class="scroll_ball scroll_ball_3" data-top-top="top:350px;" data-bottom-bottom="top:594px;"></span>
                <span class="scroll_ball scroll_ball_4" data-top-top="top:300px;" data-bottom-bottom="top:454px;"></span>
                <span class="scroll_ball scroll_ball_5" data-top-top="top:500px;" data-bottom-bottom="top:650px;"></span>
                <span class="scroll_ball scroll_ball_6" data-top-top="top:600px;" data-bottom-bottom="top:804px;"></span>
                <div class="title_style"><em><?= count($this->opusList) ?></em></div>
                <ul class="work_two clearboth">
                    <?php
                    if (count($this->opusList) > 0):
                        if (count($this->opusList) < 3) echo '<li></li>';
                        foreach($this->opusList as $_opus):
                            ?>
                            <li>
                                <p class="title clearboth">
                                    <span class="title_l"><em class="text"><?= $_opus->title ?></em><em class="num"><?= $_opus->praise_count ?></em></span>
                                </p>
                                <span class="img"><a href="/gallery/<?= $_opus->opus_id ?>" target="_blank"><img src="<?= $this->__CDN__ . \Tools\Auxi::thumb($_opus->thumb) ?>"></a></span>
                            </li>
                        <?php
                        endforeach;
                    endif;
                    ?>
                </ul>
            </div>
        </div>
        <div class="section_b block" data-type="left">
            <div class="section_b_cont">
                <!--背景颜色球-->
                <span class="scroll_ball scroll_ball_7" data-top-top="top:0px;" data-bottom-bottom="top:126px;"></span>
                <span class="scroll_ball scroll_ball_8" data-top-top="top:200px;" data-bottom-bottom="top:404px;"></span>
                <span class="scroll_ball scroll_ball_9" data-top-top="top:0px;" data-bottom-bottom="top:284px;"></span>
                <span class="scroll_ball scroll_ball_10" data-top-top="top:0px;" data-bottom-bottom="top:140px;"></span>
                <span class="scroll_ball scroll_ball_11" data-top-top="top:300px;" data-bottom-bottom="top:420px;"></span>
                <div class="title_style"><em><?php echo count($this->AccountchallengeRs)?></em></div>
                <?php 
			    function getstrlen($str=''){
			    	$str=strip_tags($str);
				    $length = strlen(preg_replace('/[x00-x7F]/', '', $str));
				    if ($length){
				        return strlen($str) - $length + intval($length / 3) * 2;
				    }else{
				        return strlen($str);
				    }
				}
				function get_substr($string,$start,$length = null,$fixStr = 0){
					$string=strip_tags($string);
					$strRes='';
				    if (!$string || empty($string)) {
				        return $string;
				    }
				    $maxLen = ($length) ? $length - $start : $start;
				    $j=$start;
				    for ($i = $start; $i < $maxLen; $i++){
				        if (ord(mb_substr($string, $j, 1,'UTF-8')) > 0xa0) {
				            if ($i + 1 == $maxLen) {
				                break;
				            }else {
				                $strRes .= mb_substr($string, $j, 1,'UTF-8');
				                $i++;
				            }
				        }else {
				            $strRes .= mb_substr($string, $j, 1,'UTF-8');
				        }
				        $j++;
				    }
				    if($fixStr==1){
					     if(getstrlen($string)>$maxLen){
					    	 $strRes .= '…';
					   	 }
				    }
				    return $strRes;
				}
            ?>
                <?php if($this->AccountchallengeRs){$AccountchallengeRs=$this->AccountchallengeRs;for($i=0;$i<count($AccountchallengeRs);$i++){?>
	                <div class="box <?php if($AccountchallengeRs[$i]->user_id!=0){echo 'red_bg';}?> clearboth" onClick="location.href='/challenge/<?php echo $AccountchallengeRs[$i]->challenge_id;?>?from=account'">
	                    <div class="box_l">
	                        <span class="name"><?php if($AccountchallengeRs[$i]->user_id!=0){echo $AccountchallengeRs[$i]->nickname;}?></span>
	                    </div>
	                    <div class="box_r">
	                        <div class="cont">
	                            <div class="cont_t clearboth"><h3 class="title" style="font: normal 32px 'gothamroundedbook','幼圆','Hiragino Sans GB W3';"><?php echo get_substr($AccountchallengeRs[$i]->challenge_name,0,72,1);?></h3><!--<span class="right"><em class="join">316 人参加</em><em class="end">30 天截止</em></span>--></div>
	                            <p class="desc"><?php echo get_substr($AccountchallengeRs[$i]->challenge_profile,0,120,1);?></p>
	                        </div>
	                    </div>
	                </div>
                <?php }}?>
            </div>
        </div>
        <div class="section_c block" data-type="right">
            <div class="section_c_cont">
                <!--背景颜色球-->
                <span class="scroll_ball scroll_ball_12" data-top-top="top:360px;" data-bottom-bottom="top:420px;"></span>
                <span class="scroll_ball scroll_ball_13" data-top-top="top:0px;" data-bottom-bottom="top:420px;"></span>
                <span class="scroll_ball scroll_ball_14" data-top-top="top:300px;" data-bottom-bottom="top:420px;"></span>
                <span class="scroll_ball scroll_ball_15" data-top-top="top:200px;" data-bottom-bottom="top:420px;"></span>
                <div class="title_style"><em><?= $this->friendCount ?></em></div>
                <ul id="follow-list" class="clearboth">
                    <?php
                    if (count($this->friendList) > 0):
                        foreach ($this->friendList as $_fl):
                            ?>
                            <li>
                                <span class="name"><?= $_fl->nickname ?></span>
                                <span class="img" data-userid="<?= $_fl->user_id ?>"><img src="<?= $this->__CDN__ ?>u/<?= $_fl->user_id ?>/avatar_front.png" /></span>
                            </li>
                        <?php
                        endforeach;
                    endif;
                    ?>
                </ul>
                <a class="more" href="/account/myFriends">查看所有</a>
            </div>
        </div>
        <div class="section_d block" data-type="left">
            <div class="section_d_cont">
                <!--背景颜色球-->
                <span class="scroll_ball scroll_ball_16" data-top-top="top:0px;" data-bottom-bottom="top:195px;"></span>
                <span class="scroll_ball scroll_ball_17" data-top-top="top:400px;" data-bottom-bottom="top:658px;"></span>
                <span class="scroll_ball scroll_ball_18" data-top-top="top:300px;" data-bottom-bottom="top:628px;"></span>
                <div class="clearboth">
                    <ul class="convene_list clearboth">
                    	<?php if($this->AccountchallengeRs){$AccountchallengeRs=$this->AccountchallengeRs;for($i=0;$i<4;$i++){
                    	if(isset($AccountchallengeRs[$i])){
                    		?>
                        <li>
                            <p class="title clearboth" style="margin-bottom:50px;">
                            </p>
                                <a href="/challenge/<?php echo $AccountchallengeRs[$i]->challenge_id;?>?from=account" target="_blank" class="img">
                                    <?php echo get_substr($AccountchallengeRs[$i]->challenge_name,0,14,1);?>
                                </a>
                        </li>
                        <?php }}}?>
                        <li class="title_style"></li>
                    </ul>
                </div>
                <ul class="work_two clearboth">
                    <li>
                        <p class="title clearboth">
                            <span class="title_l"><em class="text">足球比赛</em><em class="num">316</em></span>
                            <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon2.png" /></span>
                        </p>
                        <span class="img"><a href="/gallery/259"><img src="<?= $this->__STATIC__ ?>images/content/challenge_001.jpg" /></a></span>
                    </li>
                    <li>
                        <p class="title clearboth">
                            <span class="title_l"><em class="text">智闯迷宫</em><em class="num">316</em></span>
                            <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon4.png" /></span>
                        </p>
                        <span class="img"><a href="/gallery/260"><img src="<?= $this->__STATIC__ ?>images/content/challenge_002.jpg" /></a></span>
                    </li>
                    <li>
                        <p class="title clearboth">
                            <span class="title_l"><em class="text">熊二飞飞飞</em><em class="num">316</em></span>
                            <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon5.png" /></span>
                        </p>
                        <span class="img"><a href="/gallery/256"><img src="<?= $this->__STATIC__ ?>images/content/challenge_003.jpg" /></a></span>
                    </li>
                    <li>
                        <p class="title clearboth">
                            <span class="title_l"><em class="text">Avatar</em><em class="num">316</em></span>
                            <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon2.png" /></span>
                        </p>
                        <span class="img"><a href="/gallery/339"><img src="<?= $this->__STATIC__ ?>images/content/challenge_004.jpg" /></a></span>
                    </li>
                    <!--<li>
                        <p class="title clearboth">
                            <span class="title_l"><em class="text">Title</em><em class="num">316</em></span>
                            <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon4.png" /></span>
                        </p>
                        <span class="img"><a href="/gallery/1"><img src="<?= $this->__STATIC__ ?>images/content/challenge_4.jpg" /></a></span>
                    </li>
                    <li>
                        <p class="title clearboth">
                            <span class="title_l"><em class="text">Once at a night</em><em class="num">316</em></span>
                            <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon2.png" /></span>
                        </p>
                        <span class="img"><a href="/gallery/1"><img src="<?= $this->__STATIC__ ?>images/content/challenge_4.jpg" /></a></span>
                    </li>
                    <li>
                        <p class="title clearboth">
                            <span class="title_l"><em class="text">Title</em><em class="num">316</em></span>
                            <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon4.png" /></span>
                        </p>
                        <span class="img"><a href="/gallery/1"><img src="<?= $this->__STATIC__ ?>images/content/challenge_4.jpg" /></a></span>
                    </li>
                    <li>
                        <p class="title clearboth">
                            <span class="title_l"><em class="text">Once at a night</em><em class="num">316</em></span>
                            <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon2.png" /></span>
                        </p>
                        <span class="img"><a href="/gallery/1"><img src="<?= $this->__STATIC__ ?>images/content/challenge_4.jpg" /></a></span>
                    </li>-->
                </ul>
            </div>
        </div>
        <div class="section_e block" data-type="right">
            <div class="section_e_cont">
                <!--背景颜色球-->
                <span class="scroll_ball scroll_ball_19"></span>
                <span class="scroll_ball scroll_ball_20"></span>
<?php /*?>                <span class="scroll_ball scroll_ball_19" data-top-top="top:0px;" data-bottom-bottom="top:184px;"></span>
                <span class="scroll_ball scroll_ball_20" data-top-top="top:100px;" data-bottom-bottom="top:226px;"></span><?php */?>
                <div class="title_style"></div>
                <ul class="work_two clearboth">
                    <li>
                        <p class="title clearboth">
                            <span class="title_l"><em class="text">FlappyBird</em><em class="num">316</em></span>
                            <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon2.png" /></span>
                        </p>
                        <span class="img"><a href="/gallery/332"><img src="<?= $this->__STATIC__ ?>images/content/challenge_005.jpg" /></a></span>
                    </li>
                    <li>
                        <p class="title clearboth">
                            <span class="title_l"><em class="text">Dog Salon</em><em class="num">316</em></span>
                            <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon4.png" /></span>
                        </p>
                        <span class="img"><a href="/gallery/353"><img src="<?= $this->__STATIC__ ?>images/content/challenge_006.jpg" /></a></span>
                    </li>
                    <li>
                        <p class="title clearboth">
                            <span class="title_l"><em class="text">AngryBirds</em><em class="num">316</em></span>
                            <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon5.png" /></span>
                        </p>
                        <span class="img"><a href="/gallery/330"><img src="<?= $this->__STATIC__ ?>images/content/challenge_007.jpg" /></a></span>
                    </li>
                    <li>
                        <p class="title clearboth">
                            <span class="title_l"><em class="text">FrameAnimation</em><em class="num">316</em></span>
                            <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon2.png" /></span>
                        </p>
                        <span class="img"><a href="/gallery/333"><img src="<?= $this->__STATIC__ ?>images/content/challenge_008.jpg" /></a></span>
                    </li>
                </ul>
            </div>
        </div>
        <?php /*?><div class="section_g block" data-type="left">
            <span class="scroll_ball scroll_ball_21" ></span>
            <span class="scroll_ball scroll_ball_22"></span>
            <span class="scroll_ball scroll_ball_23"></span>
            <span class="scroll_ball scroll_ball_24"></span>
            <div class="section_g_cont clearboth">
                <div class="title_style"><em>2</em></div>
                <ul class="clearboth">
                    <li>
                        <span class="title">大同的三年二班</span>
                        <span class="img"><a href="/account/group"><img src="<?= $this->__STATIC__ ?>images/content/honor_1.png" /></a></span>
                    </li>
                    <li>
                        <span class="title">马里奥联盟</span>
                        <span class="img"><a href="/account/groupUser"><img src="<?= $this->__STATIC__ ?>images/content/honor_2.png" /></a></span>
                    </li>
                    <li class="add">
                        <span class="title"></span>
                        	<span class="img">
                            	<a href="/account/groupCreate">创建群组</a>
                            </span>
                    </li>
                </ul>
            </div>
        </div><?php */?>
        <div class="section_f block" data-type="right">
            <div class="section_f_cont clearboth">
                <div class="title_style2"><span class="cn"><img src="<?= $this->__STATIC__ ?>images/title/2.png"></span></div>
                <div class="apple">
                    <a class="title" href="javascript:;">
                        <span class="type">Mac 版</span>
                        <span class="mb">12 MB</span>
                        <i></i>
                    </a>
                    <ul class="cont">
                        <li><a href="/uploads/files/ScratchInstall-MacOSX.rar">Mac OS X -下载</a></li>
                        <li><a href="/uploads/files/ScratchInstall-Mac10.5&older.rar">Mac OS 10.5 &amp; Older - 下载</a></li>
                    </ul>
                </div>
                <div class="microsoft">
                    <a class="title" href="/uploads/files/ScratchInstall-PC.rar">
                        <span class="type">PC 版</span>
                        <span class="mb">12 MB</span>
                        <i></i>
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
    $(function(){
        fun.account();
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
</body>
</html>
