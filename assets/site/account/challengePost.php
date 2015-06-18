<?php
require($this->__RAD__ . '_head_challenge.php');
?>
<link rel="stylesheet" href="<?= $this->__STATIC__ ?>css/zi.css">
<script type="text/javascript">
    var baseurl = 'http://<?php echo $_SERVER['HTTP_HOST'];?>/';
</script>

<link rel="stylesheet" href="../assets/site/account/kindeditor/themes/default/default.css"/>
<script type="text/javascript" src="../assets/site/account/kindeditor/kindeditor-min.js"></script>


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
                <div class="box_cont_l"><img src="<?= $this->__STATIC__ ?>images/content/post_icon_1.png"/></div>
                <div class="box_cont_r">
                    <div class="title"><input name="challenge_name" type="text" value="召集名称"
                                              onBlur="if(this.value=='')this.value='召集名称';this.style.color='#8C8C8C';"
                                              onClick="if(this.value=='召集名称')this.value='';this.style.color='#333333';"/>
                    </div>
                    <div class="desc"><textarea name="challenge_profile" cols="" rows=""
                                                onBlur="if(this.value=='')this.value='召集的简要描述';this.style.color='#8C8C8C';"
                                                onClick="if(this.value=='召集的简要描述')this.value='';this.style.color='#333333';">召集的简要描述</textarea>
                    </div>
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
            <td>
                <div class="timer">
                    <span iid="-1" onclick="tochooseshichang(1)">关闭</span>
                    <span iid="0" class="cur" onclick="tochooseshichang(2)">无限时</span>
                    <span iid="30" onclick="tochooseshichang(3)">30天</span>
                    <span iid="60" onclick="tochooseshichang(4)">60天</span>
                    <span iid="-2" onclick="tochooseshichang(5)">自定义</span>
                    <label id="didingyi_area" style="display:none;height: 46px;
float: left;margin-right: 10px;border-radius: 100px;
padding: 0 30px;
cursor: pointer;
font: normal 18px/46px 'arial','microsoft yahei','Hiragino Sans GB W3';
border: 2px solid #7AC443;background: #fff;color: #7AC443;">
                        <input name="zidingyi_shichang"
                               style="width:30px;border:0px;line-height:40px;font-size:16px;text-align:center;"/>
                    </label>
                </div>
                <script>
                    function tochooseshichang(num) {
                        for (var i = 1; i <= 5; i++) {
                            if (i == num) {
                                $('#jiezhidate_' + i).show();
                            } else {
                                $('#jiezhidate_' + i).hide();
                            }
                        }
                        if (num == 5) {
                            $('#didingyi_area').show();
                        } else {
                            $('#didingyi_area').hide();
                        }
                    }

                    function addDate(dd, dadd) {
                        var a = new Date(dd);
                        a = a.valueOf();
                        a = a + dadd * 24 * 60 * 60 * 1000;
                        a = new Date(a);
                        return a;
                    }

                    $('input[name="zidingyi_shichang"]').keyup(function () {
                        var tt = /^\d+$/g;
                        var zidingyitian = 0;
                        if (tt.test($(this).val())) {
                            zidingyitian = $(this).val();
//								alert('正整数');
                        }
                        $.post('/mzworld/?c=challenge&m=tojisuan_jiezhiriqi', {dayadd: zidingyitian}, function (data) {
                            $('#jiezhidate_5').html('对应截止日期：' + data);
                        })
                    })
                </script>
            </td>
        </tr>
        <tr>
            <td class="td_l"></td>
            <td style="padding-bottom:20px;">
                <div class="tips">
                		<span id="jiezhidate_1" style="display:none;">
                			
                		</span>
                		<span id="jiezhidate_2">
                			
                		</span>
                		<span id="jiezhidate_3" style="display:none;">
                			对应截止日期：<?php echo date('Y-m-d', strtotime(date('Y-m-d') . "   + 30 day")) ?>
                		</span>
                		<span id="jiezhidate_4" style="display:none;">
                			对应截止日期：<?php echo date('Y-m-d', strtotime(date('Y-m-d') . "   + 60 day")) ?>
                		</span>
                		<span id="jiezhidate_5" style="display:none;">
                			对应截止日期：<?php echo date('Y-m-d', strtotime(date('Y-m-d'))) ?>
                		</span>
                </div>
            </td>
        </tr>
        <tr>
            <td class="td_l">额外介绍</td>
            <td>
                <div id="addnewpicture"
                     style="margin:0 0 10px 0;border-radius: 10px;position: relative;overflow: hidden;line-height: 0;box-shadow: 2px 2px 8px rgba(0,0,0,0.1);display: inline-block;">
                    <!--                    		<img src="/uploads/challenge/2015/06/shaonianqiang.jpg">-->
                </div>

                <div id="addnewattach" style="width:100%;">

                </div>

                <input name="pic_1" type="hidden" value=""/>

                <div class="sections" id="attach-area">
                    <div id="textareackeditor_test" class="section" style="display:none;">
                        <div class="cont">
                            <div class="post_textarea">

                                <textarea name="content" id="editor_html_id"
                                          style="width:810px;height:260px;visibility:hidden;display: block;margin: 20px;"></textarea>
                            </div>
                            <a class="close_ckeditor" onclick="toclosenewmiaoshu()" href="javascript:;"></a>
                        </div>
                    </div>

                </div>
                <div id="attach-file-value" style="">

                </div>
                <ul class="buttons clearboth">
                    <li class="item"><input type="file" id="attach-img" name="opus-file"><a
                            href="javascript:;">添加图片</a></li>
                    <li class="item2"><input type="file" id="attach-file" name="opus-file"><a
                            href="javascript:;">添加附件</a>
                    </li>
                    <li class="item3"><a href="javascript:;" onclick="toaddnewmiaoshu()"
                                         id="btn-attach-text_bak">添加描述</a>
                    </li>
                </ul>
                <script>

                    function toaddnewmiaoshu() {
                        $('#textareackeditor_test').show();
                    }
                    function toclosenewmiaoshu() {
//								var content=CKEDITOR.instances.a_content.getData();
//								CKEDITOR.instances.a_content.setData("");
                        $('#textareackeditor_test').hide();
                    }
                    function toonmouse_onbutton(id) {
                        if (id == '2') {
                            $('.buttons').find('.item2').find('a').css({'color': '#81c64d'})
                        } else {
                            $('.buttons').find('.item').find('a').css({'color': '#81c64d'})
                        }
                    }
                    function toonmouse_offbutton(id) {
                        if (id == '2') {
                            $('.buttons').find('.item2').find('a').css({'color': '#767B7E'})
                        } else {
                            $('.buttons').find('.item').find('a').css({'color': '#767B7E'})
                        }
                    }
                </script>
            </td>
        </tr>
        <tr>
            <td class="td_l">添加标签</td>
            <td>
                <input name="challenge_tag" class="tag_add" type="text" placeholder="最多不超过5个，空格隔开" value=""/>

                <div class="tag_tips"></div>
            </td>
        </tr>
        <tr>
            <td class="td_l"></td>
            <td>
                <div class="tag_recommend">推荐标签<a href="javascript:;">游戏</a><a href="javascript:;">动画</a><a
                        href="javascript:;">音乐</a><a href="javascript:;">美术</a></div>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <!--                	<input class="dissolve" name="" type="button" value="解散召集" />-->
                <input class="submit add-challenge-submit" name="" type="button" value="发布召集"/>
            </td>
        </tr>
    </table>
</div>
</div>

<script>

    var description = [];
    var editor;
    KindEditor.ready(function (K) {
        editor = K.create('textarea[name="content"]', {

            uploadJson: '/assets/site/account/kindeditor/php/upload_json.php',
            fileManagerJson: '/assets/site/account/kindeditor/php/file_manager_json.php',
            allowFileManager: true,

            resizeType: 2,
            allowPreviewEmoticons: false,
            allowImageUpload: true,
            items: [
                'undo', 'redo', 'preview', '|', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline', 'table', 'hr',
                'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                'insertunorderedlist', 'quickformat', '|', 'emoticons', 'image','media', 'link', 'unlink', 'fullscreen']
        });

    });

    //发不召集事件
    $('.add-challenge-submit').click(function () {
        editor.sync();
        $('#editor_html_id').each(function () {
            description.push($(this).val());
        });
        var ispass = 1;
        var challenge_name = $('input[name="challenge_name"]').val();//召集名称

        if (ispass == 1) {
            if (getStrLength(challenge_name) > 72) {
                fun.error_tip('召集名称最多为72个字符，每个中文字占据2个字符');
                ispass = 0;
            }
        }

        var challenge_profile = $('textarea[name="challenge_profile"]').val();//召集的简要描述
        var challenge_shichang = 0;//开放时间
        $('.timer').find('span[class="cur"]').each(function () {
            challenge_shichang = $(this).attr('iid');
            if (challenge_shichang == -2) {
                challenge_shichang = $('input[name="zidingyi_shichang"]').val();//自定义开放时间
            }
        });
        var challenge_tag = $('input[name="challenge_tag"]').val();//标签
        var pic_1 = $('input[name="pic_1"]').val();//图片


        if (ispass == 1) {
            if (isNull.test(challenge_name) || challenge_name == '召集名称') {
                fun.error_tip('请填写召集名称');
                ispass = 0;
            }
        }

        if (ispass == 1) {
            if (isNull.test(challenge_shichang)) {
                fun.error_tip('请填写自定义开放时长');
                ispass = 0;
            } else {
                var tt = /^\\d+$/;
                if (tt.test(challenge_shichang)) {
                    fun.error_tip('自定义开放时长为正整数');
                    ispass = 0;
                }
            }
        }

        if (ispass == 1) {
            if (isNull.test(challenge_profile) || challenge_profile == '召集的简要描述') {
                fun.error_tip('请填写召集的简要描述');
                ispass = 0;
            }
        }
        if (ispass == 1) {
            if (isNull.test(pic_1)) {
                fun.error_tip('请上传图片');
                ispass = 0;
            }
        }

        var title = [];

        $('.challenge-description-title').each(function () {
            title.push($(this).val());
        });

        var attach = [];
        $('input[name="attach[]"]').each(function () {
            attach.push($(this).val());
        });

        if (ispass == 1) {
            var attach_truename = [];
            $('input[name="attach_truename[]"]').each(function () {
                if (isNull.test($(this).val())) {
                    fun.error_tip('请填写附件的名称');
                    ispass = 0;
                }
                attach_truename.push($(this).val());
            })
        }

        var attach_size = [];
        $('input[name="attach_size[]"]').each(function () {
            attach_size.push($(this).val());
        });
        var attach_houzui = [];
        $('input[name="attach_houzui[]"]').each(function () {
            attach_houzui.push($(this).val());
        });


//		ispass=0;
        if (ispass == 1) {
            $.post('/mzworld/?c=challenge&m=toaddchallenge', {challenge_name: challenge_name, challenge_profile: challenge_profile, challenge_shichang: challenge_shichang, challenge_tag: challenge_tag, pic_1: pic_1, title: title, description: description, attach: attach, attach_truename: attach_truename, attach_size: attach_size, attach_houzui: attach_houzui, user_id: avatar.id}, function (data) {
                fun.right_tip('发布召集成功!');

                var goto = true;
                if (goto) {
                    $(".right_tip .submit,.right_tip .tclose").click(function () {
                        window.location.href = '/gallery';
                        goto = false;
                    });
                }
                setTimeout(function () {
                    $(".right_tip,.layer_mask").hide();
                    window.location.href = '/gallery';
                }, 3000);
            })
        }

//		if(ispass==1){
//			if(isNull.test(challenge_tag)||challenge_tag=='最多不超过5个，空格隔开'){
//				fun.error_tip('请填写召集的标签');
//				ispass=0;
//			}
//		}

    });


    var isNull = /^[\s' ']*$/;
    function isEmail(email) {
        var isEmail = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(email);
        if (isEmail != true) {
            return false;
        } else {
            return true;
        }
    }
    //	JS获取字符串长度(区分中英文) 中文算2个字,英文一个.
    function getStrLength(str) {
        var cArr = str.match(/[^\x00-\xff]/ig);
        return str.length + (cArr == null ? 0 : cArr.length);
    }
    function toaddchallenge() {

    }
</script>


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
    $(function () {
        fun.challengePost();
    })
</script>
<script>
    $(function () {
        if ($("#avatar_m").size() > 0) {
            var timer = null;
            var direction = "left";
            var block_nums = $(".block").size();
            $(window).scroll(function () {
                clearTimeout(timer);
                timer = setTimeout(function () {
                    var move;
                    var new_position = $(window).scrollTop();
                    if (new_position - bar_position > 0) {
                        move = "down";
                    } else {
                        move = "up";
                    }
                    bar_position = new_position;
                    ///////////人物向下移动
                    var scroll_top = $(window).scrollTop();
                    var pepole_top = 160 + $("#avatar_m")[0].offsetTop + 118;
                    if (scroll_top > pepole_top && move == "down") {
                        $("#avatar_m").removeClass().addClass("avatar_m_down");
                        $("#avatar_m").stop().css({"top": scroll_top - 300 + "px"});
                        $("#avatar_m").animate({top: scroll_top + "px"}, 2000, function () {
                            $("#avatar_m").removeClass().addClass("avatar_right");
                        });
                    }
                    ///////////人物向上移动
                    var move_up = scroll_top + $(window).height();
                    var pepole_top2 = 160 + $("#avatar_m")[0].offsetTop;
                    if (move_up < pepole_top2 && move == "up") {
                        $("#avatar_m").removeClass().addClass("avatar_m_up");
                        if (scroll_top < 120) {
                            $("#avatar_m").stop().css({"top": move_up - 130 + "px"});
                            $("#avatar_m").animate({top: "270px"}, 2000, function () {
                                $("#avatar_m").removeClass().addClass("avatar_right");
                            });
                        } else {
                            $("#avatar_m").stop().css({"top": move_up - 130 + "px"});
                            $("#avatar_m").animate({top: move_up - 480 + "px"}, 2000, function () {
                                $("#avatar_m").removeClass().addClass("avatar_right");
                            });
                        }
                    }
                }, 200);
            });
        }
    })
</script>
<?php
require($this->__RAD__ . 'footer.php');
?>
<script src="<?= $this->__STATIC__ ?>js/json2.js"></script>
<script src="<?= $this->__STATIC__ ?>js/fileuploader.js"></script>
<script src="<?= $this->__STATIC__ ?>js/challengeopus.js"></script>
<script>
    $(function () {
        fun.workPost();
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        //上传图片
        var button_gksel1 = $('#attach-img'), interval;
        if (button_gksel1.length > 0) {
            new AjaxUpload(button_gksel1, {
                action: '/mzworld/?c=welcome&m=uplogo&maxwidth=840&maxheight=1200',
                name: 'logo',
                screenorder: '1',
                onSubmit: function (file, ext) {
                    if (ext && /^(jpg|png|gif)$/.test(ext)) {
                        button_gksel1.text('上传中');
                        this.disable();
                        interval = window.setInterval(function () {
                            var text = button_gksel1.text();
                            if (text.length < 13) {
                                button_gksel1.text(text + '.');
                            } else {
                                fun.error_tip('上传中');
                            }
                        }, 200);

                    } else {
                        fun.error_tip('只支持上传jpg , png , gif 格式的图片');
                        return false;
                    }
                },
                onComplete: function (file, response) {
                    window.clearInterval(interval);
                    this.enable();
                    if (response == 'false') {
                        fun.error_tip('上传失败');
                    } else {
                        var pic = eval("(" + response + ")");
                        $('#addnewpicture').html('<img src="' + '/' + pic.logoparent + '" />');
                        $('input[name="pic_1"]').val(pic.logoshiji);
                    }
                }
            });
        }

        //上传附件
        var button_gksel2 = $('#attach-file'), interval;
        if (button_gksel2.length > 0) {
            new AjaxUpload(button_gksel2, {
                action: '/mzworld/?c=welcome&m=upfile',
                name: 'newfile',
                screenorder: '2',
                onSubmit: function (file, ext) {
                    if (ext && /^(rar|zip)$/.test(ext)) {
                        button_gksel2.text('上传中');
                        this.disable();
                        interval = window.setInterval(function () {
                            var text = button_gksel2.text();
                            if (text.length < 13) {
                                button_gksel2.text(text + '.');
                            } else {
//							fun.error_tip('上传中');	
                            }
                        }, 200);

                    } else {
                        fun.error_tip('只支持上传rar, zip压缩格式文件');
                        return false;
                    }
                },
                onComplete: function (file, response) {
                    window.clearInterval(interval);
                    this.enable();
                    if (response == 'false') {
                        fun.error_tip('上传失败');
                    } else {
                        var pic = eval("(" + response + ")");
                        if (pic.size < 1024) {
                            var sizeshow = pic.size + 'B';
                        } else if (pic.size >= 1024 && pic.size < 1048576) {
                            var sizeshow = parseInt(accDiv(pic.size, 1024)) + 'KB';
                        } else if (pic.size >= 1048576 && pic.size < 1073741824) {
                            var sizeshow = parseInt(accDiv(accDiv(pic.size, 1024), 1024)) + 'M';
                        } else {
                            var sizeshow = parseInt(accDiv(accDiv(accDiv(pic.size, 1024), 1024), 1024)) + 'GB';
                        }
                        $('#addnewattach').append('<div class="section"><div class="cont"><div class="files clearboth"><div class="files-box clearboth"><span class="icon"></span><span class="info"><table><tr><td><input type="text" name="attach_truename[]" /><input type="hidden" name="attach_size[]" value="' + pic.size + '"/><input type="hidden" name="attach_houzui[]" value="' + pic.houzuiming + '"/></td><td><strong>.' + pic.houzuiming + '</strong></td></tr></table>' + sizeshow + '</span></div></div><a class="close" href="javascript:;"></a><span class="move_t"></span><span class="move_b"></span></div></div>');
                        $('#attach-file-value').append('<input name="attach[]" type="hidden" value="' + pic.logoshiji + '"/>');
                    }
                }
            });
        }
    })

    /**
     2  ** 除法函数，用来得到精确的除法结果
     3  ** 说明：javascript的除法结果会有误差，在两个浮点数相除的时候会比较明显。这个函数返回较为精确的除法结果。
     4  ** 调用：accDiv(arg1,arg2)
     5  ** 返回值：arg1除以arg2的精确结果
     6  **/
    function accDiv(arg1, arg2) {
        var t1 = 0, t2 = 0, r1, r2;
        try {
            t1 = arg1.toString().split(".")[1].length;
        }
        catch (e) {
        }
        try {
            t2 = arg2.toString().split(".")[1].length;
        }
        catch (e) {
        }
        with (Math) {
            r1 = Number(arg1.toString().replace(".", ""));
            r2 = Number(arg2.toString().replace(".", ""));
            return (r1 / r2) * pow(10, t2 - t1);
        }
    }
</script>
</body>
</html>
