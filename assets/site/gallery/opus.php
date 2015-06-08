<?php
require($this->__RAD__ . '_head.php');
?>
<link rel="stylesheet" href="<?= $this->__STATIC__ ?>css/zi.css">
</head>
<body>
<?php
require($this->__RAD__ . 'top.php');
?>
<div class="post_overflow work_bg">
    <div class="work_title"><?= $this->opusRs->title ?></div>
    <div class="work_video">
        <div class="flag">
            <span><img src="<?= $this->__STATIC__ ?>images/content/honor_1.png"></span>
        </div>
        <div class="team">
            <span class="name" id="user-nickname"><?= $this->opusRs->nickname ?></span>
            <span class="img" id="user-avatar"><img src="<?= $this->__CDN__ . "u/{$this->opusRs->user_id}/" ?>avatar_front.png" /></span>
            <div class="cont">
                <h3 class="title">团队成员</h3>
                <ul class="clearboth">
                    <li><img src="<?= $this->__STATIC__ ?>images/content/work_face.png" /></li>
                    <li><img src="<?= $this->__STATIC__ ?>images/content/work_face_2.png" /></li>
                    <li><img src="<?= $this->__STATIC__ ?>images/content/work_face_3.png" /></li>
                </ul>
                <p class="update"><?= \Tools\Auxi::getShortTime($this->opusRs->release_date) ?> 更新</p>
                <s></s>
            </div>
        </div>
        <div class="work_option">
            <?php
            if (intval($this->userId) > 0):
                ?>
                <a class="download" href="<?= $this->__CDN__ . str_replace('\\\\', '/', $this->opusRs->sb2_src) ?>" target="_blank">
                    <em></em>
                    <i>源文件</i>
                </a>
            <?php
            endif;
            ?>
            <a class="share" href="javascript:;">
                <em></em>
                <i>分享</i>
            </a>
            <?php
            if ($this->userId && $this->userId == $this->opusRs->user_id):
                ?>
                <a class="edit" href="/account/opusPost/<?= $this->id ?>">
                    <em></em>
                    <i>编辑</i>
                </a>
            <?php
            endif;
            ?>
        </div>
        <div class="play"></div>
        <div class="work_img">
            <div class="role item">
                <span class="img"><img src="/uploads/u/1126/avatar_front.png"></span>
                <div class="box">
                    <span>My Works Here!</span>
                    <s></s>
                </div>
            </div>
            <div class="role item2">
                <span class="img"><img src="/uploads/u/1126/avatar_front.png"></span>
                <div class="box">
                    <span>My Works Here!</span>
                    <s></s>
                </div>
            </div>
            <div class="role item3">
                <span class="img"><img src="/uploads/u/1126/avatar_front.png"></span>
                <div class="box">
                    <span>My Works Here!</span>
                    <s></s>
                </div>
            </div>
            <div class="role item4">
                <span class="img"><img src="/uploads/u/1126/avatar_front.png"></span>
                <div class="box">
                    <span>My Works Here!</span>
                    <s></s>
                </div>
            </div>
            <div class="role item5">
                <span class="img"><img src="/uploads/u/1126/avatar_front.png"></span>
                <div class="box">
                    <span>My Works Here!</span>
                    <s></s>
                </div>
            </div>
            <div class="role item6">
                <span class="img"><img src="/uploads/u/1126/avatar_front.png"></span>
                <div class="box">
                    <span>My Works Here!</span>
                    <s></s>
                </div>
            </div>
            <div class="role item7">
                <span class="img"><img src="/uploads/u/1126/avatar_front.png"></span>
                <div class="box">
                    <span>My Works Here!</span>
                    <s></s>
                </div>
            </div>
            <div class="role item8">
                <span class="img"><img src="/uploads/u/1126/avatar_front.png"></span>
                <div class="box">
                    <span>My Works Here!</span>
                    <s></s>
                </div>
            </div>
        </div>
        <?php
        	$thisfilepath=$this->__CDN__ . str_replace('\\', '/', $this->opusRs->sb2_src);
        	$testsplit=explode('.',$thisfilepath);
        	$houzuiming=end($testsplit);
        ?>
        <?php if($houzuiming=='sb2'||$houzuiming=='sb'){?>
	        <div class="video_bg">
	            <s class='video_l'></s>
	            <s class='video_r'></s>
	            <s class='video_t'></s>
	            <s class='video_b'></s>
	            <s class='fullscreen'></s>
	            <script>
	                var fwidth = '100%';// flash view width
	                var fheight = '100%'; // flash view height
	                installPlayer("<?= $this->__STATIC__ ?>Scratch.swf", 'scratch');
	                function installPlayer(swfName, swfID) {
	                    var flashvars = {
	                        project: '<?= $this->__CDN__ . str_replace('\\', '/', $this->opusRs->sb2_src) ?>',
	                        autostart: 'false'
	                    };
	                    var params = {
	                        allowscriptaccess: 'always',
	                        allowfullscreen: 'true',
	//                        wmode: 'direct',
	                        wmode: 'transparent',
	                        menu: 'false'
	                    };
	                    var attributes = {};
	                    swfobject.embedSWF(swfName, swfID, fwidth, fheight, '10.2.0', false, flashvars, params, attributes);
	                }
	            </script>
	            <div id="scratch-show" class="video">
	                <div style="width: 670px; height: 480px;" id="scratch"></div>
	            </div>
	        </div>
        <?php }else if($houzuiming=='mp4'){?>
        	<?php 
	            $picthumb=$this->__CDN__ . str_replace('\\', '/', $this->opusRs->thumb);
	            	
	            $picthumb=str_replace('/uploads', 'uploads', $picthumb);
	         ?>
	         <div style="width:840px;height:540px;position: relative;z-index: 2;margin: 0 auto;">
	        	<div style="width:600px;height:400px;overflow:hidden;padding-left:120px;">
	        		<div style="width:600px;height:400px;overflow:hidden;background:black;">
                    <video src="<?= $this->__CDN__ . str_replace('\\', '/', $this->opusRs->sb2_src) ?>" controls width="600" height="400">
                        <object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" style="display:block;width:600px;height:400px;" width="600" height="400">
                            <param name="movie" value="<?= $this->__STATIC__ ?>video/player.swf" />
                            <param name="quality" value="high" />
                            <param name="wmode" value="opaque" />
                            <param name="swfversion" value="9.0.45.0" />
                            <!-- 此 param 标签提示使用 Flash Player 6.0 r65 和更高版本的用户下载最新版本的 Flash Player。如果您不想让用户看到该提示，请将其删除。 -->
                            <param name="expressinstall" value="Scripts/expressInstall.swf" />
                            <!-- 下一个对象标签用于非 IE 浏览器。所以使用 IECC 将其从 IE 隐藏。 -->
                            <!--[if !IE]>-->
                            <object type="application/x-shockwave-flash" data="<?= $this->__STATIC__ ?>video/player.swf?videoUrl=<?= $this->__STATIC__ ?>video/video.flv" width="600" height="400" style="display:block;width:600px;height:400px;">
                                <!--<![endif]-->
                                <param name="quality" value="high" />
                                <param name="allowFullScreen" value="true" />
                                <param name="wmode" value="opaque" />
                                <param name="swfversion" value="9.0.45.0" />
                                <param name="expressinstall" value="Scripts/expressInstall.swf" />
                                <!-- 浏览器将以下替代内容显示给使用 Flash Player 6.0 和更低版本的用户。 -->
                                <div>
                                    <h4>此页面上的内容需要较新版本的 Adobe Flash Player。</h4>
                                    <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="获取 Adobe Flash Player" width="112" height="33" /></a></p>
                                </div>
                                <!--[if !IE]>-->
                            </object>
                            <!--<![endif]-->
                        </object>
                    </video>
                    </div>
                </div>
             </div>
        <?php }else{?>
        	<div style="width:840px;height:540px;position: relative;padding-top:12px;margin: 0 auto;">
	            <div style="width: 500px;height:480px;padding-left:170px;">
	            	<?php 
	            	$picthumb=$this->__CDN__ . str_replace('\\', '/', $this->opusRs->thumb);
	            	
	            	$picthumb=str_replace('/uploads', 'uploads', $picthumb);
	            	if($picthumb!=""&&$picthumb!="uploads/"&&file_exists($picthumb)){
	            	?>
	            		<img style="width:450px;height:450px;" src="<?php echo '/'.$picthumb;?>"/>
	            	<?php }else{?>
	            		<img style="width:450px;height:450px;" src="<?= $this->__STATIC__ ?>images/content/work_img2.png"/>
	            	<?php }?>
	            </div>
	        </div>
        <?php }?>
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        <div class="post_tree_30"></div>
        <div class="post_tree_31"></div>
        <div class="post_tree_32"></div>
        
        <div class="post_tree_41"></div>
        <div class="post_tree_42"></div>
        <div class="post_tree_43"></div>
        <div class="post_tree_44"></div>
    </div>
    <div class="work_cont">
        <div class="post_tree_33"></div>
        <div class="post_tree_34"></div>
        <div class="post_tree_35"></div>
        <div class="post_tree_36"></div>
        <div class="post_tree_37"></div>
        <div class="post_tree_38"></div>
        <div class="post_tree_39"></div>
        <div class="post_tree_40"></div>
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
            <div class="reply"><a href="javascript:;"></a></div>
            <div class="like<?= $this->praise ? ' liked' : '' ?>" id="opus-praise"><a href="javascript:;"></a><i class="num"></i></div>
        </div>
        <?php
        else:
        ?>
        <div id="avatar_m" class="avatar_default">
            <div class="tips"><div class="text">登录，请点我！</div><s></s></div>
            <span class="box login">
                <i class="body"><img style="margin-top:17px;" src="<?= $this->__STATIC__ ?>images/100/body.png"></i>
                <i class="face"><img src="<?= $this->__STATIC__ ?>images/100/face.png"></i>
                <i class="hand"></i>
            </span>
            <div class="reply"><a href="javascript:;"></a></div>
            <div class="like<?= $this->praise ? ' liked' : '' ?>" id="opus-praise"><a href="javascript:;"></a><i class="num"></i></div>
        </div>
        <?php
        endif;
        ?>
        <div class="reply_cont">
            <textarea name="" cols="" rows="">今天分成3个小组讨论，我被指定为一个组的领导。教授说我做的非常好。。。</textarea>
            <div class="submit"><input type="button" value=" " /></div>
        </div>
        <?= $this->opusRs->detail ?>
        <div class="work_label">
            <?php
            if ($this->opusRs->tag != ''):
                $_tag = explode(' ', $this->opusRs->tag);
                foreach ($_tag as $_t):
                    echo "<span>{$_t}</span>";
                endforeach;
            endif;
            ?>
        </div>
        <div class="data"><span class="item">0</span><span id="opus-praise-holder" class="item2"><?= $this->opusRs->praise_count ?></span></div>
        <div class="face_list">
            <ul id="praise-list" class="clearboth">
                <?php
                if (count($this->praiseUser) > 0):
                    foreach ($this->praiseUser as $_pu):
                        ?>
                        <li data-userid="<?= $_pu->user_id ?>"><em class="name"><?= $_pu->nickname ?></em><span class="img"><img src="<?= $this->__CDN__ . "u/{$_pu->user_id}" ?>/avatar_front.png"></span></li>
                    <?php
                    endforeach;
                endif;
                ?>
            </ul>
        </div>
        <!--<div class="title_style"><img src="<?= $this->__STATIC__ ?>images/content/work_title.png" /></div>
        <div class="img_list" id="related-works">
            <ul class="work_two clearboth">
                <li>
                    <p class="title clearboth">
                        <span class="title_l"><em class="text">Title</em><em class="num">316</em></span>
                        <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon5.png"></span>
                    </p>
                    <span class="img"><a href="/gallery/1"><img src="<?= $this->__STATIC__ ?>images/content/challenge_4.jpg"></a></span>
                </li>
                <li>
                    <p class="title clearboth">
                        <span class="title_l"><em class="text">Title</em><em class="num">316</em></span>
                        <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon5.png"></span>
                    </p>
                    <span class="img"><a href="/gallery/1"><img src="<?= $this->__STATIC__ ?>images/content/challenge_4.jpg"></a></span>
                </li>
                <li>
                    <p class="title clearboth">
                        <span class="title_l"><em class="text">Title</em><em class="num">316</em></span>
                        <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon5.png"></span>
                    </p>
                    <span class="img"><a href="/gallery/1"><img src="<?= $this->__STATIC__ ?>images/content/challenge_4.jpg"></a></span>
                </li>
                <li>
                    <p class="title clearboth">
                        <span class="title_l"><em class="text">Title</em><em class="num">316</em></span>
                        <span class="title_r"><img src="<?= $this->__STATIC__ ?>images/home/icon5.png"></span>
                    </p>
                    <span class="img"><a href="/gallery/1"><img src="<?= $this->__STATIC__ ?>images/content/challenge_4.jpg"></a></span>
                </li>
            </ul>
        </div>
        <div class="title_style"><img src="<?= $this->__STATIC__ ?>images/content/work_title2.png" /></div>
        <div class="img_list">
            <ul class="convene_list clearboth">
                <li>
                    <p class="title clearboth">
                        <span class="title_l"><em class="text">Ailey 的召集</em><em class="num">316</em></span>
                        <span class="title_r"><img src="/assets/static/images/home/icon2.png"></span>
                    </p>
                    <span class="img"> 一起玩坏马里奥 </span>
                </li>
                <li>
                    <p class="title clearboth">
                        <span class="title_l"><em class="text">Ailey 的召集</em><em class="num">316</em></span>
                        <span class="title_r"><img src="/assets/static/images/home/icon2.png"></span>
                    </p>
                    <span class="img"> 一起玩坏马里奥 </span>
                </li>
                <li>
                    <p class="title clearboth">
                        <span class="title_l"><em class="text">Ailey 的召集</em><em class="num">316</em></span>
                        <span class="title_r"><img src="/assets/static/images/home/icon2.png"></span>
                    </p>
                    <span class="img"> 一起玩坏马里奥 </span>
                </li>
                <li>
                    <p class="title clearboth">
                        <span class="title_l"><em class="text">Ailey 的召集</em><em class="num">316</em></span>
                        <span class="title_r"><img src="/assets/static/images/home/icon2.png"></span>
                    </p>
                    <span class="img"> 一起玩坏马里奥 </span>
                </li>
            </ul>
        </div>-->
    </div>
</div>

<!--团队信息-->
<div class="layer layer_work_1">
    <div class="layer_close clearboth"><span class="btn"></span></div>
    <div class="layer_box">
        <h2>My Skateboard Shoe</h2>
        <div class="author">By <span>Johnson</span> <em>2015.1.26 20:49</em></div>
        <div class="desc">One lucky character sees his day transformed when his Samsung pen is transformed into a series of tools carrying him to a playful dreamland. The film invites you to take a magical turn in your daily life while illustrating the various features of the Samsung Galaxy Note 4 S-Pen .</div>
        <h3>Team Members</h3>
        <ul class="clearboth">
            <li>
                <span class="img"><img src="<?= $this->__STATIC__ ?>images/content/work_face.png" /></span>
                <em>One</em>
                <i>Code</i>
            </li>
            <li>
                <span class="img"><img src="<?= $this->__STATIC__ ?>images/content/work_face_2.png" /></span>
                <em>Two</em>
                <i>Graphic</i>
            </li>
            <li>
                <span class="img"><img src="<?= $this->__STATIC__ ?>images/content/work_face_3.png" /></span>
                <em>Two</em>
                <i>Graphic</i>
            </li>
            <li></li>
            <li></li>
        </ul>
    </div>
</div>
<!--下载资料-->
<div class="layer layer_work_2">
    <div class="layer_close clearboth"><span class="btn"></span></div>
    <div class="layer_box">
        <div class="layer_box_file">
            <ul class="clearboth">
                <li class="zip">
                    <a class="clearboth" href="#">
                        <span class="icon"></span>
                            <span class="info">
                                <strong>Pictures.zip</strong>
                                12 MB
                            </span>
                        <em></em>
                    </a>
                </li>
                <li class="video">
                    <a class="clearboth" href="#">
                        <span class="icon"></span>
                            <span class="info">
                                <strong>Instruction.mov</strong>
                                89 MB
                            </span>
                        <em></em>
                    </a>
                </li>
                <li class="txt">
                    <a class="clearboth" href="#">
                        <span class="icon"></span>
                            <span class="info">
                                <strong>Readme.txt</strong>
                                1 KB
                            </span>
                        <em></em>
                    </a>
                </li>
            </ul>
            <div class="add_file"><a href="javascript:;">Add files...</a><input name="" type="file"></div>
        </div>
        <div class="file_num clearboth"><span class="num">3 Files&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;101 MB</span>  <a class="btn" href="#">Download All</a></div>
    </div>
</div>
<?php
require($this->__RAD__ . 'footer.php');
?>
<!----------------------分享链接----------------------->
<div class="share_box">
    <div class="fbox_t clearboth">
        <a class="close" href="javascript:;"></a>
    </div>
    <div class="fbox_c clearboth">
        <div class="cont">
            <div class="title">分享到</div>
            <div class="bdsharebuttonbox"><a title="分享到复制网址" href="#" class="bds_copy" data-cmd="copy"></a><a title="分享到邮件分享" href="#" class="bds_mail" data-cmd="mail"></a><a title="分享到QQ空间" href="#" class="bds_qzone" data-cmd="qzone"></a><a title="分享到新浪微博" href="#" class="bds_tsina" data-cmd="tsina"></a><a title="分享到微信" href="#" class="bds_weixin" data-cmd="weixin"></a></div>
            <ul class="clearboth"><li>复制链接</li><li>邮件</li><li>QQ空间</li><li>新浪微博</li></ul>
        </div>
    </div>
</div>
<div id="flash_cont">
    <div class="fbox_t clearboth">
        <a class="close" href="javascript:;"></a>
    </div>
    <div class="fbox_c clearboth"></div>
</div>

<script>
    $(function(){
        $(".fullscreen").click(function(){
            $("#scratch-show").append("<div class='close'></div>");
            $(".work_video .video_bg").css({"position":"inherit"});
            $(".work_video").css({"position":"inherit"});
            $("body,html").css({"overflow":"hidden"});
            $(".video").css({"position":"fixed","width":"100%","height":"100%","top":"0","left":"0","z-index":"52"});
        });
        $("#scratch-show").delegate(".close","click",function(){
            $(".work_video .video_bg").css({"position":"relative"});
            $(".work_video").css({"position":"relative"});
            $("body,html").css({"overflow":"auto"});
            $(".video").css({"position":"inherit","width":"588px","height":"478px","top":"0","left":"0","z-index":"1"});
        });
		//查看他人信息
        if ($('#opus-owner-wrap').length > 0) {
            $('#user-avatar').click(function(){
                fun.userProfileOpus('<?= $this->opusRs->user_id ?>');
                var _top=$(window).scrollTop()+30;
                $(".layer_mask").show();
                $(".profile_other").show().css("top",_top+"px");
            });
        }

        //点赞
        var like_time=null;
        $('#opus-praise').unbind('click').click(function(){
            if ($(this).hasClass('liked')) {//del
                $.post('/api/account/opus/praiseRemove', {
                    opusId : '<?= $this->id ?>'
                }, function(data){
                    switch (data.status) {
                        case 'SUCCESS':
                            //fun.right_tip("点赞移除成功！");
                            _like("-1");
                            $('#opus-praise').removeClass('liked');
                            $('#user-praise').html(($('#user-praise').html() >> 0) - 1)
                            $('#opus-praise-holder').html(($('#opus-praise-holder').html() >> 0) - 1);
                            $('#praise-list > li').each(function(){
                                if ($(this).data('userid') == avatar.id) {
                                    $(this).remove();
                                }
                            });
                            break;
                        case 'INTERCEPTOR':
                            fun.right_tip("请登录后点赞！");
                            break;
                        default:
                            break;
                    }
                }, 'json');
            } else {
                $.post('/api/account/opus/praise', {
                    opusId : '<?= $this->id ?>'
                }, function(data){
                    switch (data.status) {
                        case 'SUCCESS':
                            //fun.right_tip("点赞成功！");
                            _like("+1");
                            $('#opus-praise').addClass('liked');
                            $('#user-praise').html(($('#user-praise').html() >> 0) + 1)
                            $('#opus-praise-holder').html(($('#opus-praise-holder').html() >> 0) + 1);
                            $('#praise-list').append('<li data-userid="' + avatar.id + '"><em class="name">'+avatar.nickname+'</em><span class="img"><img src="' + avatar.front + '"></span></li>');
                            break;
                        case 'INTERCEPTOR':
                            fun.right_tip("请登录后点赞！");
                            break;
                        default:
                            break;
                    }
                }, 'json');
            }
        });
        function _like(text){
            clearTimeout(like_time);
            like_time=setTimeout(function(){
                $("#opus-praise i.num").show().text(text).stop().animate({bottom:"80px",opacity:"1"},300).delay(300).animate({bottom:"110px",opacity:"0"},300,function(){
                    $("#opus-praise i.num").css({"bottom":"50px","display":"none"});
                });
            },200);
        }
        //分享
        $(".work_option .share").click(function(){
            $(".share_box,.layer_mask").show();
        });

        $("#praise-list li").click(function(){
            fun.userProfileOpus($(this).data('userid'));
            var _top=$(window).scrollTop()+30;
            $(".layer_mask").show();
            $(".profile_other").show().css("top",_top+"px");
        });
        //人物滚动
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
                    var pepole_top=860+$("#avatar_m")[0].offsetTop+118;
                    if(scroll_top>pepole_top && move=="down"){
                        $("#avatar_m").removeClass().addClass("avatar_m_down");
						$("#avatar_m").stop().css({"top":scroll_top-1020+"px"});
						$("#avatar_m").animate({top:scroll_top-740+"px"},2000,function(){
							$("#avatar_m").removeClass().addClass("avatar_right");
							reply_show();
						});
                    }
                    ///////////人物向上移动
                    var move_up=scroll_top+$(window).height();
                    var pepole_top2=860+$("#avatar_m")[0].offsetTop;
                    if(move_up<pepole_top2 && move=="up"){
                        $("#avatar_m").removeClass().addClass("avatar_m_up");
                        if(scroll_top<480){
                            $("#avatar_m").stop().css({"top":move_up-780+"px"});
                            $("#avatar_m").animate({top:"-150px"},2000,function(){
                                $("#avatar_m").removeClass().addClass("avatar_right");
								reply_show();
                            });
                        }else{
							$("#avatar_m").stop().css({"top":move_up-780+"px"});
							$("#avatar_m").animate({top:move_up-1220+"px"},2000,function(){
								$("#avatar_m").removeClass().addClass("avatar_right");
								reply_show();
							});
                        }
                    }
                },200);
            });
        }
		reply_show=function(){
			var avatar_top=$("#avatar_m")[0].offsetTop;
			if(avatar_top>440){
				$("#avatar_m .reply,#avatar_m .like").fadeOut(300);
			}else{
				$("#avatar_m .reply,#avatar_m .like").fadeIn(300);	
			}		
		}
        //随机评论
        var tips=[
            "我也要试着做做看",
            "Awesome",
            "好神奇，到底是怎么做的？",
            "让我看看他的源文件",
            "我也要用这个人物做一个",
            "哎哟，有bug",
            "作者好厉害，我要关注他",
            "我们做个朋友吧"
        ]
        $people=$(".work_img .role");
        setInterval(function(){
            var p=parseInt(Math.random()*8);
            var t=parseInt(Math.random()*tips.length);
            $people.eq(p).css("z-index","6");
            $people.eq(p).find(".box span").html(tips[t]);
            $people.eq(p).find(".box").show().animate({"bottom":"140px","opacity":"1"},200).delay(2000).animate({"bottom":"120px","opacity":"0"},200,function(){
                $(this).hide();
                $people.eq(p).css("z-index","5");
            });
        },2440);
    });
</script>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
</body>
</html>