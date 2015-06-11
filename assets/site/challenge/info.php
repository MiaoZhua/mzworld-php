<?php
require($this->__RAD__ . '_head.php');
?>
<link rel="stylesheet" href="<?= $this->__STATIC__ ?>css/zi.css">
</head>
<body>
<?php
require($this->__RAD__ . 'top.php');
?>

<style>
.easyPieChart {
position: relative;
text-align: center;
}
</style>
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
<!--                    <li class="item"><a id="invite_link" href="javascript:;"><i></i>邀请</a></li>-->
                    <!--<li class="item2"><a href="#"><i></i>编辑</a></li>
                    <li class="item3"><a href="#"><i></i>审核</a></li>-->
                </ul>
            </div>
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
	            <div class="challenge_a_r">
	                <div class="box <?php if($this->challengeRs->user_id==0){echo 'red_box';}?>">
	                    <div class="box_t"></div>
	                    <div class="box_c">
	                        <table cellpadding="0" cellspacing="0">
	                            <tr>
	                                <td class="td_l"><img src="<?= $this->__STATIC__ ?><?php if($this->challengeRs->user_id==0){echo 'images/content/img4.png';}else{echo 'images/content/challenge_icon.png';}?>" /></td>
	                                <td class="td_c">
	                                    <h3><?php echo get_substr($this->challengeRs->challenge_name,0,60,1);?></h3>
	                                    <p class="desc">
	                                    	<?php 
		                                    	if(getstrlen(get_substr($this->challengeRs->challenge_name,0,60,0))>32){//如果标题有两行
		                                    		echo get_substr($this->challengeRs->challenge_profile,0,220,1);
		                                    	}else{
		                                    		echo get_substr($this->challengeRs->challenge_profile,0,144,1);
		                                    	}
	                                    	?></p>
	                                    <!--<p><em class="join">316 人参加</em><em class="end">30 天截止</em></p>-->
	                                </td>
	                                <td class="td_r">
	                                	<?php 
	                                		$totalday=$this->challengeRs->challenge_shichang;//总天数
	                                		$created=$this->challengeRs->created;//创建时间
	                                	?>
	                                	<?php 
	                                	if($totalday==-1){?>
<!--	                                		//已关闭-->
	                                		<div class="percentage" data-color="#FFFFFF" data-percent="0" data-size="100" style="float:left;margin:-10px 0px 0px 35px;font-size: 14px;font-weight: bold;display: inline-block;vertical-align: top;">
												<table cellspacing=0 cellpadding=0 style="position:absolute;width:100px;height:100px;">
													<tr>
														<td align="center">
															<span class="percent" style="font-size: 14px;font-weight: bold;
													display: inline-block;vertical-align: top;">已关闭</span>
														</td>
													</tr>
												</table>
											</div>
		                                    <script src="<?= $this->__STATIC__ ?>js/jquery.easy-pie-chart.min.js"></script>
	
											<script type="text/javascript">
												jQuery(function($) {
													$('.percentage').each(function(){
														var $box = $(this).closest('.infobox');
														var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
														var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#F09B17';
														var size = parseInt($(this).data('size')) || 50;
														$(this).easyPieChart({
															barColor: barColor,
															trackColor: trackColor,
															scaleColor: false,
															lineCap: 'butt',
															lineWidth: parseInt(size/10),
															animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
															size: size
														});
													})
												})
											</script>
	                                	<?php }else if($totalday==0){?>
<!--	                                		//不限时-->
	                                		<div class="percentage" data-color="#FFFFFF" data-percent="100" data-size="100" style="float:left;margin:-10px 0px 0px 35px;font-size: 14px;font-weight: bold;display: inline-block;vertical-align: top;">
												<table cellspacing=0 cellpadding=0 style="position:absolute;width:100px;height:100px;">
													<tr>
														<td align="center">
															<span class="percent" style="font-size: 14px;font-weight: bold;
													display: inline-block;vertical-align: top;">无限时</span>
														</td>
													</tr>
												</table>
											</div>
		                                    <script src="<?= $this->__STATIC__ ?>js/jquery.easy-pie-chart.min.js"></script>
	
											<script type="text/javascript">
												jQuery(function($) {
													$('.percentage').each(function(){
														var $box = $(this).closest('.infobox');
														var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
														var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#F09B17';
														var size = parseInt($(this).data('size')) || 50;
														$(this).easyPieChart({
															barColor: barColor,
															trackColor: trackColor,
															scaleColor: false,
															lineCap: 'butt',
															lineWidth: parseInt(size/10),
															animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
															size: size
														});
													})
												})
											</script>
	                                	<?php }else{?>
	                                	<?php 
	                                		$startdate=mktime();
											$enddate=strtotime(date('Y-m-d',strtotime(date('Y-m-d',$created)."   + ".$totalday." day")));//上面的php时间日期函数已经把日期变成了时间戳，就是变成了秒。这样只要让两数值相减，然后把秒变成天就可以了，比较的简单，如下：
											$days=round(($enddate-$startdate)/3600/24);
											if($enddate<$startdate){?>
												<div class="percentage" data-color="#FFFFFF" data-percent="0" data-size="100" style="float:left;margin:-10px 0px 0px 35px;font-size: 14px;font-weight: bold;display: inline-block;vertical-align: top;">
													<table cellspacing=0 cellpadding=0 style="position:absolute;width:100px;height:100px;">
														<tr>
															<td align="center">
																<span class="percent" style="font-size: 14px;font-weight: bold;
														display: inline-block;vertical-align: top;">已截止</span>
															</td>
														</tr>
													</table>
												</div>
											<?php }else{?>
												<div class="percentage" data-color="#FFFFFF" data-percent="<?php echo round(($days/$totalday)*100)?>" data-size="100" style="float:left;margin:-10px 0px 0px 35px;font-size: 14px;font-weight: bold;display: inline-block;vertical-align: top;">
													<table cellspacing=0 cellpadding=0 style="position:absolute;width:100px;height:100px;">
														<tr>
															<td align="center">
																<span class="percent" style="font-size: 14px;font-weight: bold;
														display: inline-block;vertical-align: top;">剩<?php echo $days?>天</span>
															</td>
														</tr>
													</table>
												</div>
											<?php }?>
	                                    
	                                    <script src="<?= $this->__STATIC__ ?>js/jquery.easy-pie-chart.min.js"></script>

										<script type="text/javascript">
											jQuery(function($) {
												$('.percentage').each(function(){
													var $box = $(this).closest('.infobox');
													var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
													var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#F09B17';
													var size = parseInt($(this).data('size')) || 50;
													$(this).easyPieChart({
														barColor: barColor,
														trackColor: trackColor,
														scaleColor: false,
														lineCap: 'butt',
														lineWidth: parseInt(size/10),
														animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
														size: size
													});
												})
											})
										</script>
	                                	<?php }?>
	                                	
	                                    
	                                </td>
	                            </tr>
	                        </table>
	                        <div class="person">
	                            <span class="name"><?php if($this->challengeRs->user_id!=0){echo $this->challengeRs->nickname;}?></span>
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
            <div class="thumbnail" style="margin-bottom:30px;"><img src="<?= $this->__CDN__ . $this->challengeRs->pic_1?>" /></div>
            <div class="desc"><div class="p_left"><p class="mb40"><?= $this->challengeRs->challenge_description?></p></div></div>
            <div class="desc">
				<?php if ($this->descriptionRs){
					$descriptionRs=$this->descriptionRs;
					for($i=0;$i<count($descriptionRs);$i++){?>
					<div style="width:100%;">
						<p class="title_style3"><?php echo $descriptionRs[$i]->title;?></p>
						<div class="p_left"><p class="mb10"><?php echo $descriptionRs[$i]->description;?></p>
						<p class="mb10">&nbsp;</p>
					</div>
				<?php }}?>
            </div>
            
            <?php if ($this->attachRs){
					$attachRs=$this->attachRs;
					for($i=0;$i<count($attachRs);$i++){?>
		            <div class="desc">
		            	<a href="/mzworld/?c=challenge&m=todownloadfile&path=<?php echo 'uploads/'.$attachRs[$i]->path;?>&name_start=<?php echo $attachRs[$i]->name;?>&name_end=<?php echo $attachRs[$i]->houzui;?>">
		            		<div style="width:362px;height:97px;background:url(<?= $this->__STATIC__ ?>images/btn_resource_bg.png);">
			            		<div style="padding-left:110px;padding-top:25px;">
			            			<div style="color:#7ac543;font: normal 18px 'microsoft yahei','Hiragino Sans GB W3';">
			            				<?php echo $attachRs[$i]->name.'.'.$attachRs[$i]->houzui;?>
			            			</div>
			            			<div style="padding-top:2px;color:#999999;font: normal 16px 'microsoft yahei','Hiragino Sans GB W3';">
			            				<?php 
											if($attachRs[$i]->size<1024){
												echo $attachRs[$i]->size.'B';
											}else if($attachRs[$i]->size>=1024&&$attachRs[$i]->size<1048576){
												echo intval(($attachRs[$i]->size)/1024).'KB';
											}else if($attachRs[$i]->size>=1048576&&$attachRs[$i]->size<1073741824){
												echo intval(($attachRs[$i]->size)/1048576).'MB';
											}else{
												echo intval(($attachRs[$i]->size)/1073741824).'GB';
											}
			            				?>
			            			</div>
			            		</div>
			            	</div>
		            	</a>
		            </div>
			<?php }}?>

            
            <div class="desc">
            	<table cellspacing=0 cellpadding=0 style="width:100%;">
            		<tr>
            			<td width="360">
            				<?php if($totalday==-1){?>
	            				<div class="gallery_a_l">
					                <a class="button" href="javascript:;" style="background: url(<?= $this->__STATIC__ ?>images/gallery/a_1_close.png) no-repeat;color:#ef6a19;">已关闭</a>
					            </div>
				            <?php }else if($totalday==0){?>
	            				<div class="gallery_a_l">
					                <a class="button" href="/account/topostzuopinfromchallenge?from=<?php echo $_GET['from']?>&challenge_id=<?php echo $this->challengeRs->challenge_id;?>">参与召集</a>
					            </div>
				            <?php }else{?>
				            	<?php if($enddate<$startdate){?>
					            	<div class="gallery_a_l">
						                <a class="button" href="javascript:;" style="background: url(<?= $this->__STATIC__ ?>images/gallery/a_1_close.png) no-repeat;color:#ef6a19;">已截止</a>
						            </div>
					            <?php }else{?>
					            	<div class="gallery_a_l">
						                <a class="button" href="/account/topostzuopinfromchallenge?from=<?php echo $_GET['from']?>&challenge_id=<?php echo $this->challengeRs->challenge_id;?>">参与召集</a>
						            </div>
					            <?php }?>
				            <?php }?>
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
            </ul>
            <script>
            	$.post('/mzworld/?c=challenge&m=gethotzuopinlist&from=<?php echo $_GET['from']?>&challenge_id=<?php echo $this->challengeRs->challenge_id;?>',function (data){
					$('#remen_zuopin').html(data);
                })
            </script>
            
            
            <div class="mb25"><img src="<?= $this->__STATIC__ ?>images/content/challenge_title4.png"></div>
            <ul id="all_zuopin" class="work_two clearboth">
            	<li><img src="<?= $this->__STATIC__ ?>images/content/indicator.gif"/></li>
            </ul>
            <script>
            	$.post('/mzworld/?c=challenge&m=getcollengezuopinlist&from=<?php echo $_GET['from']?>&challenge_id=<?php echo $this->challengeRs->challenge_id;?>',function (data){
					$('#all_zuopin').html(data);
                })
            </script>
        </div>
    </div>
</div>
<!------参与召集添加作品----->
<div class="select_challenge">
    <div class="tbox">
    	<div class="tclose"></div>
        <div class="tbox_t">
        	<span class="title">选择作品</span><a href="/account/opusPost">发布新作品</a>
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