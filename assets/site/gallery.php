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
            <?php ?><div class="gallery_a_r">
                <a class="button2" href="/account/challengePost">发布召集</a>
                发布召集活动<br />招呼大家一起来创造新作
            </div><?php ?>
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
            <?php if($this->GallerychallengeRs){$GallerychallengeRs=$this->GallerychallengeRs;for($i=0;$i<count($GallerychallengeRs);$i++){?>
            <div class="box clearboth <?php if($GallerychallengeRs[$i]->user_id!=0){echo 'red_bg';}?>">
            	<a href="/challenge/<?php echo $GallerychallengeRs[$i]->challenge_id;?>?from=gallery" target="_blank">
	                <div class="box_l">
	                    <span class="name"><?php if($GallerychallengeRs[$i]->user_id!=0){echo $GallerychallengeRs[$i]->nickname;}?></span>
	                    <div class="people"><img src="<?= $this->__STATIC__ ?><?php if($GallerychallengeRs[$i]->user_id==0){echo 'images/gallery/people2.png';}else{echo 'images/gallery/people3.png';}?>" /></div>
	                </div>
	                <div class="box_r">
	                    <div class="cont">
	                        <div class="cont_t clearboth"><h3 class="title"><a href="/challenge/<?php echo $GallerychallengeRs[$i]->challenge_id;?>?from=gallery" target="_blank" style="font: normal 32px 'gothamroundedbook','幼圆','Hiragino Sans GB W3';"><?php echo get_substr($GallerychallengeRs[$i]->challenge_name,0,72,1);?></a></h3><!--<span class="right"><em class="join">316 人参加</em><em class="end">30 天截止</em></span>--></div>
	                        <a href="/challenge/<?php echo $GallerychallengeRs[$i]->challenge_id;?>?from=gallery" style="color:white;" target="_blank"><p class="desc"><?php echo get_substr($GallerychallengeRs[$i]->challenge_profile,0,120,1);?></p></a>
	                    </div>
	                    <div class="list">
	                        <ul id="gallerycollenges_<?php echo $GallerychallengeRs[$i]->challenge_id;?>" class="work_list clearboth">
	                        </ul>
	                        <script>
				            	$.post('/mzworld/?c=challenge&m=getgalleryzuopinlist&challenge_id=<?php echo $GallerychallengeRs[$i]->challenge_id;?>',function (data){
									$('#gallerycollenges_<?php echo $GallerychallengeRs[$i]->challenge_id;?>').html(data);
				                })
				            </script>
	                    </div>
	                </div>
                </a>
            </div>
            <?php }}?>
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
