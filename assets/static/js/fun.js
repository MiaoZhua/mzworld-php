var fun;
var bar_position;
setTimeout(function(){
    bar_position=$(window).scrollTop();
},100);
var taransform;
$(function(){
    fun={
        avatar : function(json) {
            var avatar = $.parseJSON(json);
            avatar.pics = avatar.cdn + 'pics/l/';
            var _merge = avatar.cdn + 'u/' + avatar.id + '/';
            avatar.front = _merge + avatar.front;
            avatar.rear = _merge + avatar.rear;

            return avatar;
        },
        flushAvatar : function(avatar) {
            $("#avatar_m .body img").attr("src",avatar.pics+avatar.body.front);
            $("#avatar_m .cloth img").attr("src",avatar.pics+avatar.clothes.front);
            $("#avatar_m .cloth_b img").attr("src",avatar.pics+avatar.clothes.rear);
            $("#avatar_m .face img").attr("src",avatar.pics+avatar.face.front);
            $("#avatar_m .hair img").attr("src",avatar.pics+avatar.hair.front);
            $("#avatar_m .hair_l img").attr("src",avatar.pics+avatar.hair.left);
            $("#avatar_m .hair_r img").attr("src",avatar.pics+avatar.hair.right);
            setTimeout(function(){
                $("#avatar_m .box").fadeIn(200);
                $("#avatar_m").removeClass("avatar_loading");
            },1000);
        },
        common:function(){
            if (window.location.hash != null && window.location.hash.indexOf('login') != -1) {
                var _top=$(window).scrollTop()+30;
                $(".layer_mask").show();
                $(".loginlayer").show().css("top",_top+"px");
            }

            $('body').bind('mousewheel', function(event, delta) {
                if(delta<0){
                    if($(".layer_mask").is(":hidden")){
                        $(".head").addClass("head_show");
                    }
                    move="down";
                }else{
                    if($(".layer_mask").is(":hidden")){
                        $(".head").removeClass("head_show");
                    }
                    move="up";
                }
            });
            //头部右菜单
            $(".button").hover(function(){
                $(this).addClass("button_show");
            },function(){
                $(this).removeClass("button_show");
            });

            //微课视频详细页
            $(".layer_close .btn").click(function(){
                $(".layer,.layer_mask").hide();
            });
            $(".tutorial_video .play").click(function(){
                var _top=$(window).scrollTop()+30;
                $(".layer_mask").show();
                $(".layer_weike_1").show().css("top",_top+"px");
            });

            /*下载文件链接*/
            $(".apple").hover(function(){
                $(this).find(".cont").show();
            },function(){
                $(this).find(".cont").hide();
            });
            /*作品详细页*/
            /*$(".work_video .download").click(function(){
             var _top=$(window).scrollTop()+30;
             $(".layer_mask").show();
             $(".layer_work_2").show().css("top",_top+"px");
             });
             $(".work_video .team .cont").click(function(){
             var _top=$(window).scrollTop()+30;
             $(".layer_mask").show();
             $(".layer_work_1").show().css("top",_top+"px");
             });*/

            /*关闭弹出层*/
            $(".fbox_t .close").click(function(){
                $(this).parent().parent().hide();
                $(".layer_mask").hide();
            });

            /*关闭弹出层*/
            $(".tbox .tclose").click(function(){
                $(this).parent().parent().hide();
                $(".layer_mask").hide();
            });

            /*账户信息----修改密码*/
            $(".account .password_btn").click(function(){
                $(this).hide();
                $(".password_cont").show();
            });
            $(".account .fbox_c_l_r .sure").click(function(){
                $(".password_btn").show();
                $(".password_cont").hide();
            });
            //avatar颜色随机
            $(".colors i").each(function(index, element) {
                var Random=RandomBy(0,3);
                $(".colors i").eq(index).addClass("color_"+Random);
            });
            function RandomBy(under, over){
                return parseInt(Math.random()*(over-under+1) + under);
            }

            //模拟下拉菜单
            $(".select_style").hover(function(){
                $(this).find("ul.cont").show();
            },function(){
                $(this).find("ul.cont").hide();
            });
            $(".select_style ul li").click(function(){
                var value=$(this).data("value");
                var text=$(this).text();
                $(this).parent().parent().find("span").text(text);
                $(this).parent().parent().prev().val(value);
                $(this).parent().hide();
            });

            //添加用户搜索框
            var $addinput=$(".adduser .search input");
            $addinput.keyup(function(){
                input_text();
            });
            input_text();
            function input_text(){
                if($addinput.val()!==""){
                    $addinput.next().addClass("btn_cur");
                }else{
                    $addinput.next().removeClass("btn_cur");
                }
            }
            //返回顶部
            $(window).bind("scroll",function(){
                var scroll_top=$(window).scrollTop();
                if(scroll_top>300){
                    $(".back_top").fadeIn(300);
                }else{
                    $(".back_top").fadeOut(300);
                }
            });
            $(".back_top").click(function(){
                $("html,body").animate({
                    scrollTop: 0
                }, 400,function(){
                    $(".head").removeClass("head_show");
                });
            });
            //
            fun.browser();
        },
        browser:function(){
            VENDORS=["Moz",'webkit','ms','O'];
            TARANSFORM_NAMES={"Moz":"-moz-transform","webkit":"-webkit-transform","ms":"-ms-transform","O":"-o-transform"}
            var mTestElement=document.createElement("div");
            for(var i=0,l=VENDORS.length;i<l;i++){
                css3Prefix=VENDORS[i];
                if((css3Prefix+"Transition")in mTestElement.style){break;}
                css3Prefix=false;
            }
            if(css3Prefix){
                taransform=TARANSFORM_NAMES[css3Prefix];
            }
        },
        login:function(){
            /*##############注册##############*/
            /*第一步按钮*/
            $(".steps_scroll .create_link").click(function(){
                $(".steps_scroll .steps").animate({"left":"-980px"},{duration: 900, easing: "easeInOutCubic"});
                var _bodyid=$(".step_one .color span.cur").data("index");
                var _body_index=$(".step_one .color span").index($(".step_one .color span.cur"));
                var _clothid=$(".step_one .role_body li.middle").data("index");
                var _faceid=$(".step_one .role_face li.middle").data("index");
                var _hairid=$(".step_one .role_head li.middle").data("index");
                var _body=$(".avatar .body span").eq(_body_index).html();
                var _cloth=$(".step_one .role_body li.middle").html();
                var _face=$(".step_one .role_face li.middle").html();
                var _hair=$(".step_one .role_head li.middle").html();
                $(".step_two .head_img .body").html(_body);
                $(".step_two .head_img .cloth").html(_cloth);
                $(".step_two .head_img .face").html(_face);
                $(".step_two .head_img .hair").html(_hair);
                var _avatar = {
                    body :_bodyid,
                    hair : _hairid,
                    face : _faceid,
                    clothes : _clothid
                };
                $("#avatar").val(JSON.stringify(_avatar));
                $(".steps_scroll .fbox_b").hide();
                btn_state(2);
            });
            /*第二步按钮*/
            $(".steps_scroll .more_info").click(function(){
                $(".steps_scroll .steps").animate({"left":"-1960px"},{duration: 900, easing: "easeInOutCubic"});
                btn_state(3);
            });
            $(".steps_scroll .to_first").click(function(){
                $(".steps_scroll .steps").animate({"left":"0"},{duration: 900, easing: "easeInOutCubic"});
                btn_state(1);
            });
            /*第三步按钮*/
            $(".steps_scroll .to_second").click(function(){
                $(".steps_scroll .steps").animate({"left":"-980px"},{duration: 900, easing: "easeInOutCubic"});
                btn_state(2);
            });
            $(".steps_scroll .base_info").click(function(){
                $(".steps_scroll .steps").animate({"left":"-980px"},{duration: 900, easing: "easeInOutCubic"});
                btn_state(2);
            });
            function btn_state(num){
                $(".steps_scroll .fbox_b").hide();
                num-=1;
                switch(num){
                    case 0:
                        $(".steps_scroll .fbox_b").eq(0).show();
                        $(".steps_scroll .fbox_t .title").css("background-position","0 0");
                        break;
                    case 1:
                        $(".steps_scroll .fbox_b").eq(1).show();
                        $(".steps_scroll .fbox_t .title").css("background-position","0 -37px");
                        break;
                    case 2:
                        $(".steps_scroll .fbox_b").eq(2).show();
                        break;
                }
            }
        },
        scroll_state:true,
        scroll:function(id,parts){
            $(".avatar .body span").eq(0).show();
            $(id).find("ul li").eq(2).addClass("middle img_move");
            var li_num=$(id).find("ul li").size();
            var li_width=$(id).find("ul li").outerWidth();
            var visible_num=5;
            var move_num=li_num-visible_num;
            var middle=null;
            //右边按钮
            $(id).find(".left_btn").click(function(){
                if(fun.scroll_state==true){
                    if(parts=="body"){
                        $(".avatar_mask").fadeOut(200);
                    }
                    clearTimeout(middle);
                    fun.scroll_state=false;
                    $(id).find("ul li").removeClass("middle img_move");
                    $(id).find("ul li").eq(1).addClass("middle");
                    $(id).find("ul").prepend($(id).find("ul li:last")).css("left","-"+li_width+"px");
                    $(id).find("ul").animate({"left":"0"},{duration: 600, easing: "easeInOutCubic",complete:function(){
                        middle=setTimeout(function(){
                            if(parts=="body"){
                                $(".avatar_mask").delay(300).fadeIn(200);
                            }
                            if(parts=="head"){
                                $(".role_head ul li.middle").addClass("img_move");
                            }else if(parts=="body"){
                                $(".role_body ul li.middle").addClass("img_move");
                            }
                        },300);
                        fun.scroll_state=true;
                    }});
                }
            });
            //右边按钮
            $(id).find(".right_btn").click(function(){
                if(fun.scroll_state==true){
                    if(parts=="body"){
                        $(".avatar_mask").fadeOut(200);
                    }
                    clearTimeout(middle);
                    fun.scroll_state=false;
                    $(id).find("ul li").removeClass("middle img_move");
                    $(id).find("ul li").eq(3).addClass("middle");
                    $(id).find("ul").animate({"left":"-"+li_width+"px"},{duration: 600, easing: "easeInOutCubic",complete:function(){
                        middle=setTimeout(function(){
                            if(parts=="body"){
                                $(".avatar_mask").delay(300).fadeIn(200);
                            }
                            if(parts=="head"){
                                $(".role_head ul li.middle").addClass("img_move");
                            }else if(parts=="body"){
                                $(".role_body ul li.middle").addClass("img_move");
                            }
                        },300);
                        $(id).find("ul").append($(id).find("ul li:first"));
                        $(id).find("ul").css("left","0");
                        fun.scroll_state=true;
                    }});
                }
            });
        },
        scroll_random:{
            init:function(){
                /*切换身体颜色*/
                $("#avatar-color span").eq(0).addClass("cur");
                $("#avatar-color span").click(function(){
                    var index=$("#avatar-color span").index($(this));
                    $("#avatar-color span").removeClass("cur");
                    $(this).addClass("cur");
                    $("#avatar-body span").fadeOut(300);
                    $("#avatar-body span").eq(index).fadeIn(300);
                });
                /*随机滚动*/
                var random_num=1;
                $(".step_one .random span").click(function(){
                    random_num++;
                    $(".random span em").css({"-moz-transform":"rotate("+360*random_num+"deg)","-webkit-transform":"rotate("+360*random_num+"deg)","transform":"rotate("+360*random_num+"deg)"});
                    if(fun.scroll_state==true){
                        fun.scroll_state=false;
                        var _random=parseInt(Math.random()*(7))+1;
                        var _random2=parseInt(Math.random()*(7))+1;
                        var _random3=parseInt(Math.random()*(7))+1;
                        var _current=2;
                        fun.scroll_random.obj_scroll(_random,".role_head",_current);
                        fun.scroll_random.obj_scroll(_random2,".role_face",_current);
                        fun.scroll_random.obj_scroll(_random3,".role_body",_current);
                    }
                });
            },
            middle:null,
            obj_scroll:function(_random,obj,_current){
                var li_width=$(".role_body ul li").outerWidth();
                if(obj==".role_body"){
                    $(".avatar_mask").fadeOut(200);
                }
                if(_random!==3){
                    $(obj).find("ul li").removeClass("middle img_move");
                }
                if(_random>_current){
                    clearTimeout(fun.scroll_random.middle);
                    $(obj).find("ul li").eq(_random-1).addClass("middle");
                    $(obj).find("ul").animate({"left":"-"+(_random-3)*li_width+"px"},{duration: 600, easing: "easeInOutCubic",complete:function(){
                        for(i=0;i<_random-3;i++){
                            $(obj).find("ul").append($(obj).find("ul li").eq(0));
                        }
                        $(obj).find("ul").css("left","0");
                        state(obj);
                        fun.scroll_state=true;
                    }})
                }
                if(_random==1){
                    clearTimeout(fun.scroll_random.middle);
                    $(obj).find("ul").prepend($(obj).find("ul li").last());
                    $(obj).find("ul").prepend($(obj).find("ul li").last()).css("left","-"+2*li_width+"px");
                    $(obj).find("ul li").eq(2).addClass("middle");
                    $(obj).find("ul").animate({"left":"0"},{duration: 600, easing: "easeInOutCubic",complete:function(){
                        state(obj);
                        fun.scroll_state=true;
                    }});
                }
                if(_random==2){
                    clearTimeout(fun.scroll_random.middle);
                    $(obj).find("ul").prepend($(obj).find("ul li").last()).css("left","-"+li_width+"px");
                    $(obj).find("ul li").eq(2).addClass("middle");
                    $(obj).find("ul").animate({"left":"0"},{duration: 600, easing: "easeInOutCubic",complete:function(){
                        state(obj);
                        fun.scroll_state=true;
                    }});
                }
                function state(obj){
                    fun.scroll_random.middle=setTimeout(function(){
                        if(obj==".role_head"){
                            $(obj).find("ul li.middle").addClass("img_move");
                        }else if(obj==".role_body"){
                            $(".avatar_mask").delay(300).fadeIn(200);
                            $(obj).find("ul li.middle").addClass("img_move");
                        }
                    },300);
                }
            }
        },
        gallery:function(){
            /*画廊*/
            if($("#avatar_m").size()>0){
                var timer=null;
                var direction="right";
                var block_nums=$(".block").size();
                var _array = new Array();
                for(var i=0;i<block_nums;i++){
                    _array[i]=new Array();
                    _array[i][0]=$(".block").eq(i).offset().top+1;
                    _array[i][1]=$(".block").eq(i).offset().top + $(".block").eq(i).outerHeight();
                }
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
                        var pepole_top=430+$("#avatar_m")[0].offsetTop+118;
                        if(scroll_top>pepole_top && move=="down"){
                            for(var i=0;i<block_nums;i++){
                                if(scroll_top>=_array[i][0]-240 && scroll_top<=_array[i][1]-240){
                                    direction=$(".block").eq(i).data("type");
                                }
                            }
                            $("#avatar_m").removeClass().addClass("avatar_m_down");
                            if(direction=="left"){
                                $("#avatar_m").stop().css({"top":scroll_top-620+"px","margin-left":"-580px"});
                                $("#avatar_m").animate({top:scroll_top-320+"px"},2000,function(){
                                    $("#avatar_m").removeClass().addClass("avatar_right");
                                });
                            }
                            if(direction=="right"){
                                $("#avatar_m").stop().css({"top":scroll_top-620+"px","margin-left":"490px"});
                                $("#avatar_m").animate({top:scroll_top-320+"px"},2000,function(){
                                    $("#avatar_m").removeClass().addClass("avatar_left");
                                });
                            }
                        }
                        ///////////人物向上移动
                        var move_up=scroll_top+$(window).height();
                        var pepole_top2=430+$("#avatar_m")[0].offsetTop;
                        if(move_up<pepole_top2 && move=="up"){
                            for(var i=0;i<block_nums;i++){
                                if(move_up>=_array[i][0] && move_up<=_array[i][1]){
                                    direction=$(".block").eq(i).data("type");
                                }
                            }
                            $("#avatar_m").removeClass().addClass("avatar_m_up");
                            if(scroll_top<300){
                                $("#avatar_m").stop().css({"top":move_up-430+"px","margin-left":"-50px"});
                                $("#avatar_m").animate({top:"280px"},2000,function(){
                                    $("#avatar_m").removeClass().addClass("avatar_right");
                                });
                            }else{
                                if(direction=="left"){
                                    $("#avatar_m").stop().css({"top":move_up-430+"px","margin-left":"-580px"});
                                    $("#avatar_m").animate({top:move_up-720+"px"},2000,function(){
                                        $("#avatar_m").removeClass().addClass("avatar_right");
                                    });
                                }
                                if(direction=="right"){
                                    $("#avatar_m").stop().css({"top":move_up-430+"px","margin-left":"490px"});
                                    $("#avatar_m").animate({top:move_up-720+"px"},2000,function(){
                                        $("#avatar_m").removeClass().addClass("avatar_left");
                                    });
                                }
                            }
                        }
                    },200);
                });
            }
            fun.down_people(".gallery_center");
        },
        tutorial:function(){
            /*微课*/
            $(window).scroll(function(){
                var scroll_top=$(window).scrollTop();
                //banner视差
                if(scroll_top<430){
                    $(".layer").css({"-webkit-transform":"translate3d(0,"+scroll_top*1+"px,0)","-moz-transform":"translate3d(0,"+scroll_top*1+"px,0)","transform":"translate3d(0,"+scroll_top*1+"px,0)"});
                    $(".layer2").css({"-webkit-transform":"translate3d(0,"+scroll_top*0.8+"px,0)","-moz-transform":"translate3d(0,"+scroll_top*0.8+"px,0)","transform":"translate3d(0,"+scroll_top*0.8+"px,0)"});
                    $(".layer3").css({"-webkit-transform":"translate3d(0,"+scroll_top*0.6+"px,0)","-moz-transform":"translate3d(0,"+scroll_top*0.6+"px,0)","transform":"translate3d(0,"+scroll_top*0.6+"px,0)"});
                }
            })
            if($("#avatar_m").size()>0){
                var timer=null;
                var direction="right";
                var block_nums=$(".block").size();
                var _array = new Array();
                for(var i=0;i<block_nums;i++){
                    _array[i]=new Array();
                    _array[i][0]=$(".block").eq(i).offset().top+1;
                    _array[i][1]=$(".block").eq(i).offset().top + $(".block").eq(i).outerHeight();
                }
                $(window).scroll(function(){
                    var scroll_top=$(window).scrollTop();
                    //banner视差
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
                        //人物向下移动
                        var pepole_top=430+$("#avatar_m")[0].offsetTop+118;
                        if(scroll_top>pepole_top && move=="down"){
                            for(var i=0;i<block_nums;i++){
                                if(scroll_top>=_array[i][0]-240 && scroll_top<=_array[i][1]-240){
                                    direction=$(".block").eq(i).data("type");
                                }
                            }
                            $("#avatar_m").removeClass().addClass("avatar_m_down");
                            if(direction=="left"){
                                $("#avatar_m").stop().css({"top":scroll_top-620+"px","margin-left":"-620px"});
                                $("#avatar_m").animate({top:scroll_top-320+"px"},2000,function(){
                                    $("#avatar_m").removeClass().addClass("avatar_right");
                                });
                            }
                            if(direction=="right"){
                                $("#avatar_m").stop().css({"top":scroll_top-620+"px","margin-left":"518px"});
                                $("#avatar_m").animate({top:scroll_top-320+"px"},2000,function(){
                                    $("#avatar_m").removeClass().addClass("avatar_left");
                                });
                            }
                        }
                        //人物向上移动
                        var move_up=scroll_top+$(window).height();
                        var pepole_top2=430+$("#avatar_m")[0].offsetTop;
                        if(move_up<pepole_top2 && move=="up"){
                            for(var i=0;i<block_nums;i++){
                                if(move_up>=_array[i][0] && move_up<=_array[i][1]){
                                    direction=$(".block").eq(i).data("type");
                                }
                            }
                            $("#avatar_m").removeClass().addClass("avatar_m_up");
                            if(scroll_top<300){
                                $("#avatar_m").stop().css({"top":move_up-430+"px","margin-left":"-50px"});
                                $("#avatar_m").animate({top:"280px"},2000,function(){
                                    $("#avatar_m").removeClass().addClass("avatar_right");
                                });
                            }else{
                                if(direction=="left"){
                                    $("#avatar_m").stop().css({"top":move_up-430+"px","margin-left":"-620px"});
                                    $("#avatar_m").animate({top:move_up-720+"px"},2000,function(){
                                        $("#avatar_m").removeClass().addClass("avatar_right");
                                    });
                                }
                                if(direction=="right"){
                                    $("#avatar_m").stop().css({"top":move_up-430+"px","margin-left":"518px"});
                                    $("#avatar_m").animate({top:move_up-720+"px"},2000,function(){
                                        $("#avatar_m").removeClass().addClass("avatar_left");
                                    });
                                }
                            }
                        }
                    },200)
                });
            }
            fun.down_people(".course_c");
        },
        _select:function(obj,_min,_max){
            //日历下拉菜单
            var option="";
            for(c=_min;c<_max;c++){
                option+="<li>"+c+"</li>";
            }
            $("."+obj+" ul").append(option);
            $("."+obj+" ul li").click(function(){
                if($(this).hasClass("cur")){
                    //
                }else{
                    var index=$(this).text();
                    $(this).parent().parent().find("span").text(index);
                    $("#"+obj).val(index);
                }
                $("."+obj+" ul li").removeClass("cur");
                $(this).addClass("cur");
                $(this).parent().hide();
            });
            //$("#"+obj).css("visibility","hidden");
            $("."+obj+"").hover(function(){
                $(this).find("ul").show();
                if(obj=="birthday-year"){
                    $(this).find("ul").scrollTop(1100);
                }
            },function(){
                $(this).find("ul").hide();
            });
        },
        thumb : function(thumb, width) {
            if (thumb.length > 0) {
                return avatar.cdn + (typeof width != 'undefined' ? thumb.replace(/(\.\w+)$/i, 'x' + width + '$1') : thumb);
            }
            return avatar.cdn + 'no_img.png';
        },
        avatar_read:function(cdn,option){
            //读取自己的avatar
            $.post('/api/avatar/read', function(data){
                if (data.body.length > 0) {
                    var _color = [], _body = [], _hair = [], _face = [], _clothes = [];
                    for (var i in data.body) {
                        _color.push('<span data-index="' + data.body[i][0] + '"><s><img src="'+cdn+'pics/l/' + data.body[i][2] + '"></s></span>');
                        _body.push('<span><img src="'+cdn+'pics/l/' + data.body[i][1] + '"></span>');
                    }
                    for (var i in data.hair) {
                        _hair.push('<li data-index="' + data.hair[i][0] + '"><img src="'+cdn+'pics/l/' + data.hair[i][1] + '"></li>');
                    }
                    for (var i in data.face) {
                        _face.push('<li data-index="' + data.face[i][0] + '"><img src="'+cdn+'pics/l/' + data.face[i][1] + '"></li>');
                    }
                    for (var i in data.clothes) {
                        _clothes.push('<li data-index="' + data.clothes[i][0] + '"><img src="'+cdn+'pics/l/' + data.clothes[i][1] + '"></li>');
                    }
                    $('#avatar-color').html(_color);
                    $('#avatar-body').html(_body);
                    $('#avatar-hair').html(_hair);
                    $('#avatar-face').html(_face);
                    $('#avatar-clothes').html(_clothes);
                    var scroll = new fun.scroll(".role_head .parts_scroll","head");
                    var scroll = new fun.scroll(".role_face .parts_scroll","face");
                    var scroll = new fun.scroll(".role_body .parts_scroll","body");
                    fun.scroll_random.init();
                } else {
                    //alert('avatar read error');
                    fun.error_tip('avatar读取失败！');
                }
            }, 'json');
            if(option=="modify_role"){
                $("#avatar_m .box").click(function(){//小人div点击时
                    var _top=$(window).scrollTop()+30;
                    $(".layer_mask").show();//灰色层
                    $(".info_scroll").show().css("top",_top+"px");
                    $(".info_scroll .loading").show(); //loading
                    $(".info_scroll .scroll").hide(); //loading
                    $.post('/api/account/opus/read', function(data){
                        var _out = [], _img = '';
                        switch (data.status) {
                            case 'SUCCESS':
                                if (data.rsp.opus.length > 0) {
                                    for (var i in data.rsp.opus) {
                                        _out.push('<li class="work"><strong class="title">' + data.rsp.opus[i].title + '</strong><span class="img"><a href="/gallery/' + data.rsp.opus[i].opus_id + '" target="_blank"><img src="' + fun.thumb(data.rsp.opus[i].thumb, 200) + '"></a></span></li>');
                                    }
                                    $('#insert-work').show().html(_out.join(''));
                                    if(data.rsp.cards.length > 0){
                                        _out_card=[],_out_card_div=[];//卡片，显示单个卡片大的div
                                        for (var i in data.rsp.cards) {
                                            _out_card.push('<li class="card card_id"><strong>卡片'+(parseInt(i)+1)+'</strong><span><img src="/uploads/pics/s/'+data.rsp.cards[i].card_front+'"/></span></li>');
                                            _out_card_div.push('<div class="p_room"><p class="mb35"><img src="/uploads/pics/l/'+data.rsp.cards[i].card_front+'" /><img src="/uploads/pics/l/'+data.rsp.cards[i].card_back+'" /></p><p class="f18">'+data.rsp.cards[i].title+"  "+data.rsp.cards[i].chapter_name+'<a class="arrow" href="tutorial/'+data.rsp.cards[i].tutorial_chapter_id+'" target="_blank">查看本节微课</a></p></div>');
                                        }
                                        $('#insert-card').show().html(_out_card.join(''));//加入到卡片中
                                        $("#insert-card .card_id").click(function(){
                                            var x=$(this).index();
                                            $(".profile_card").show();
                                            $scroll.animate({"left":"-980px"},{duration: 900, easing: "easeInOutCubic"});
											$(".fbox_c_r >.card").html(_out_card_div[x]);
                                        });										
                                    }
                                    $(".info_scroll .loading").fadeOut(300); //loading
                                    $(".info_scroll .scroll").fadeIn(300); //loading
                                    if($(".profile .scroll").hasClass("mCustomScrollbar")){
                                        $(".profile .scroll").mCustomScrollbar("update");
                                    }else{
                                        $(".profile .scroll").mCustomScrollbar({autoDraggerLength:false,mouseWheelPixels:400});
                                    }
                                    $(".profile .scroll li").each(function(index, element) {
                                        if(index%3==2){
                                            $(".profile .scroll li").eq(index).css("border-right","none");
                                        }
                                    });
                                }else{
                                    $('#insert-work').hide();
                                    $(".info_scroll .loading").fadeOut(300); //loading
                                    $(".info_scroll .scroll").fadeIn(300); //loading
                                }

                                break;
                            default:
                                break;
                        }
                    }, 'json');

                });

                $(".profile_notification .comment").mCustomScrollbar({autoDraggerLength:false,mouseWheelPixels:400});
                $(".info_scroll .step_three .fbox_c_l span").html("修改密码");
                //关注者
                var $scroll=$(".info_scroll .info_cont");
                $(".info_scroll .profile .email").click(function(){
                    $(".profile_notification").show();
                    $scroll.animate({"left":"-980px"},{duration: 900, easing: "easeInOutCubic"});
                });
                $(".profile_notification .fbox_c_l").click(function(){
                    $scroll.animate({"left":"0"},{duration: 900, easing: "easeInOutCubic",complete:function(){
                        $(".profile_notification").hide();
                    }});
                });

                //卡片
                $(".info_scroll .profile .card").click(function(){
                    $(".profile_card").show();
                    $scroll.animate({"left":"-980px"},{duration: 900, easing: "easeInOutCubic"});
                });
                $(".profile_card .fbox_c_l").click(function(){
                    $scroll.animate({"left":"0"},{duration: 900, easing: "easeInOutCubic",complete:function(){
                        $(".profile_card").hide();
                    }});
                });

                //修改avatar
                var _avatar={};
                $(".info_scroll .profile .fbox_c_l .img").click(function(){
                    $(".modify_role").show();
                    $scroll.animate({"left":"-980px"},{duration: 900, easing: "easeInOutCubic",complete:function(){
                        $(".info_scroll .fbox_b").eq(0).show();
                    }});
                    if(_avatar.body>0){
                        var _body=avatar.body,_hair=avatar.hair,_face=avatar.face,_clothes=avatar.clothes;
                    }else{
                        var _body=avatar.idIndex.body,_hair=avatar.idIndex.hair,_face=avatar.idIndex.face,_clothes=avatar.idIndex.clothes;
                    }
                    $("#avatar-color span").each(function(index, element) {
                        var nums=$(this).data("index");
                        if(nums==_body){
                            $("#avatar-color span").removeClass("cur");
                            $("#avatar-color span").eq(index).addClass("cur");
                            $("#avatar-body span").fadeOut(300);
                            $("#avatar-body span").eq(index).fadeIn(300);
                        }
                    });
                    $("#avatar-hair li").each(function(index, element) {
                        var nums=$(this).data("index");
                        if(nums==_hair){
                            fun.scroll_random.obj_scroll(index+1,".role_head",2);
                        }
                    });
                    $("#avatar-face li").each(function(index, element) {
                        var nums=$(this).data("index");
                        if(nums==_face){
                            fun.scroll_random.obj_scroll(index+1,".role_face",2);
                        }
                    });
                    $("#avatar-clothes li").each(function(index, element) {
                        var nums=$(this).data("index");
                        if(nums==_clothes){
                            fun.scroll_random.obj_scroll(index+1,".role_body",2);
                        }
                    });
                });
                $(".info_scroll .prev_one").click(function(){
                    info_scroll(0);
                });
                $(".info_scroll .prev_two").click(function(){
                    info_scroll(0);
                });
                $(".info_scroll .prev_three").click(function(){
                    info_scroll(1);
                });

                $("#btn-avatar").click(function(){
                    var _bodyid=$(".step_one .color span.cur").data("index");
                    var _clothid=$(".step_one .role_body li.middle").data("index");
                    var _faceid=$(".step_one .role_face li.middle").data("index");
                    var _hairid=$(".step_one .role_head li.middle").data("index");
                    _avatar = {
                        body :_bodyid,
                        hair : _hairid,
                        face : _faceid,
                        clothes : _clothid
                    };
                    $.post('/api/account/user/avatar', {avatar : JSON.stringify(_avatar)}, function(data){
                        switch (data.status) {
                            case 'SUCCESS' :
                                //alert('success');
                                var _body_index=$(".step_one .color span").index($(".step_one .color span.cur"));
                                var _body=$(".avatar .body span").eq(_body_index).find("img").attr("src");
                                var _cloth=$(".step_one .role_body li.middle img").attr("src");
                                var _face=$(".step_one .role_face li.middle img").attr("src");
                                var _hair=$(".step_one .role_head li.middle img").attr("src");
                                fun.profile_avatar(_body,_cloth,_face,_hair);
                                info_scroll(0);

                                avatar = fun.avatar(data.rsp);
                                fun.flushAvatar(avatar);
                                break;
                            default :
                                //alert(data.desc);
                                fun.error_tip(data.desc+'！');
                                break;
                        }
                    }, 'json');
                });

                //账户信息修改
                $(".info_scroll .step_three .fbox_c_l").click(function(){
                    info_scroll(1);
                });
                $(".info_scroll .step_two .fbox_c_r").click(function(){
                    info_scroll(2);
                });

                /*修改自己的信息*/
                $(".profile .account_btn").click(function(){
                    $(".step_two,.step_three").show();
                    info_scroll(2);
                    if ($('#btn-chg-profile').length > 0 && !!$('#btn-chg-profile').data('readflag') == false) {
                        $.post('/api/account/user/read', function(data){
                            switch (data.status) {
                                case 'SUCCESS' :
                                    $('#birthday-year').val(data.rsp.year);
                                    $('#birthday-month').val(data.rsp.month);
                                    $('#birthday-day').val(data.rsp.day);
                                    $('#parents_email').val(data.rsp.parents_email);
                                    $('#sex').val(data.rsp.sex);

                                    $('.birthday-year span').text(data.rsp.year);
                                    $('.birthday-month span').text(data.rsp.month);
                                    $('.birthday-day span').text(data.rsp.day);
                                    $('.parents_email span').text(data.rsp.parents_email);
                                    $('#school_id').val(data.rsp.school_id);
                                    $('#qq').val(data.rsp.qq);
                                    $('#mobile').val(data.rsp.mobile);
                                    $('#btn-chg-profile').data('readflag', 'true');
                                    if(data.rsp.sex==0){
                                        $(".select_sex span").text("女");
                                    }else if(data.rsp.sex==1){
                                        $(".select_sex span").text("男");
                                    }else if(data.rsp.sex==2){
                                        $(".select_sex span").text("保密");
                                    }
                                    break;
                                default :
                                    App.alert(data.desc);
                                    break;
                            }
                        }, 'json');
                    }
                });
                //切换滚动
                function info_scroll(p){
                    $scroll.animate({"left":-p*980+"px"},{duration: 900, easing: "easeInOutCubic",complete:function(){
                        if(p==0){
                            $(".info_cont .modify_role,.info_cont .step_two,.info_cont .step_three").hide();
                            $(".info_scroll .fbox_b").hide();
                        }else{
                            state(p);
                        }
                    }});
                }
                //按钮状态
                function state(num){
                    $(".info_scroll .fbox_b").hide();
                    $(".info_scroll .fbox_b").eq(num).show();
                }
                //卡片滑过变色
                /*$(".profile .fbox_c_r ul li").hover(function(){
                 $(this).css("background","#f2f2f2");
                 },function(){
                 $(this).css("background","#fff");
                 });*/
                $(".profile .fbox_c_l .name,.info_scroll .step_two .name").text(avatar.nickname);
                fun.profile_avatar(avatar.pics+avatar.body.front,avatar.pics+avatar.clothes.front,avatar.pics+avatar.face.front,avatar.pics+avatar.hair.front);
            }
        },
        profile_avatar:function(body,clothes,face,hair){
            //个人信息avatar换衣服
            $(".profile .fbox_c_l .body img").attr("src",body);
            $(".profile .fbox_c_l .cloth img").attr("src",clothes);
            $(".profile .fbox_c_l .face img").attr("src",face);
            $(".profile .fbox_c_l .hair img").attr("src",hair);

            $(".info_scroll .head_img .body img").attr("src",body);
            $(".info_scroll .head_img .cloth img").attr("src",clothes);
            $(".info_scroll .head_img .face img").attr("src",face);
            $(".info_scroll .head_img .hair img").attr("src",hair);
        },
        down_people:function(obj){
            /*人物掉落*/
            var down=300;
            var $people=$(obj).find(".pepole");
            $people.each(function(index, element) {
                var p_top=$(this)[0].offsetTop;
                $(this).css("top",p_top-down+"px");
            });
            var people_num=$people.size();
            var people_array=new Array();
            for(i=0;i<people_num;i++){
                people_array[i]=i;
            }
            var people_timer=setInterval(function(){
                var _max=people_array.length;
                if(_max!==0){
                    var p=parseInt(Math.random()*_max);
                    var p_top=$people.eq(people_array[p])[0].offsetTop;
                    $people.eq(people_array[p]).find(".img").fadeIn(400);
                    $people.eq(people_array[p]).animate({"top":p_top+down+"px"},{duration: 600, easing: "easeOutBounce"});
                    people_array.splice(p,1);
                }else{
                    clearInterval(people_timer);
                    random_tip();
                }
            },250);
            function random_tip(){
                var tips=[
                    "233",
                    "哈哈",
                    "前方高能",
                    "咦？有新人到！",
                    "哇！你怎么做到的？",
                    "你们老师好好哦？",
                    "我刚发布了一个召集大家快去看！",
                    "我刚发布了一个作品大家快去看！",
                    "沙发",
                    "Yooooooo~",
                    "你那些贴图哪里下载的？",
                    "大家好！",
                    "我的作业还没做完。",
                    "那节微课我没看懂！",
                    "好难啊~",
                    "这个游戏iphone上可以玩么？",
                    "有bug！",
                    "手工点赞！",
                    "多谢分享",
                    "太有才了",
                    "不谢！",
                    "加油！",
                    "小伙伴们都惊呆了！",
                    "你的新作品啥时候出来？",
                    "不会做，先看看别人的好了！",
                    "我是打酱油的~",
                    "请叫我scratch小能手！",
                    "感谢大家的支持！",
                    "这样真的好嘛？！",
                    "好可爱啊~",
                    "炫酷~",
                    "我是新来的，赶紧加好友！",
                    "我想不出怎么做了~",
                    "你花了多久做成的？",
                    "丑哭了！",
                    "大师！"
                ]
                setInterval(function(){
                    var p=parseInt(Math.random()*people_num);
                    var t=parseInt(Math.random()*tips.length);
                    $people.eq(p).css("z-index","6");
                    $people.eq(p).find(".box span").html(tips[t]);
                    $people.eq(p).find(".box").show().animate({"bottom":"78px","opacity":"1"},200).delay(2000).animate({"bottom":"58px","opacity":"0"},200,function(){
                        $(this).hide();
                        $people.eq(p).css("z-index","5");
                    });
                },2440);
            }
        },
        right_tip:function(tips){
            //正确提示
            $(".right_tip .tip").html(tips);
            $(".right_tip,.layer_mask").show();
            $(".right_tip .submit").click(function(){
                $(".right_tip,.layer_mask").hide();
            });
        },
        error_tip:function(tips){
            //错误提示
            $(".error_tip .tip").html(tips);
            $(".error_tip,.layer_mask").show();
            $(".error_tip .submit").click(function(){
                $(".error_tip,.layer_mask").hide();
            });
        },
        confirm_tip:function(tips, callback){
            //选择提示
            $(".confirm .fbox_c").html(tips);
            $(".confirm,.layer_mask").show();
            $("#sure-btn").click(function(){
                $(".confirm,.layer_mask").hide();
                callback();
            });
            $("#cancel-btn").click(function(){
                $(".confirm,.layer_mask").hide();
            });
        },
        group:function(){
            /*群组*/
            $(".group_b ul li").hover(function(){
                $(this).addClass("hover");
            },function(){
                $(this).removeClass("hover");
            });
            $("#group-data").delegate(".group_c_bar","click",function(){
                if($(this).parent().find(".group_c_box").is(":hidden")){
                    $(this).parent().addClass("group_show");
                }else{
                    $(this).parent().removeClass("group_show");
                }
            });

            $(".group_c_box ul li").click(function(){
                if($(this).hasClass("cur")){
                    $(this).removeClass("cur");
                }else{
                    $(this).addClass("cur");
                }
                var num=$(this).parent().find(".cur").size();
                $num=$(this).parent().parent().find(".option_r em.num");
                $num.text(num);
            });
            $(".option_r .btn2").each(function(index, element) {
                $(this).click(function(){
                    $(".group_c_box ul").eq(index).find("li.cur").remove();
                    $num=$(".option_r em.num").eq(index);
                    $num.text(0);
                })
            });
        },
        challenge:function(){
            /*召集详细*/
            var $li=$(".exit_challenge ul.work_list li");
            $li.click(function(){
                if($(this).hasClass("cur")){
                    $(this).removeClass("cur");
                }else{
                    $(this).addClass("cur");
                }
            });
            $(".challenge_b .work_post_link").click(function(){
                var top=$(window).scrollTop()+100;
                $(".select_challenge,.layer_mask").show();
                $(".select_challenge").css("top",top+"px");
            });
            $(".challenge_b .exit_link").click(function(){
                var top=$(window).scrollTop()+100;
                $(".exit_challenge,.layer_mask").show();
                $(".exit_challenge").css("top",top+"px");
            });
            $(".exit_challenge .submit").click(function(){
                $(".exit_challenge,.layer_mask").hide();
            });
            $(".select_challenge li").click(function(){
                $(".select_challenge,.layer_mask").hide();
            });
        },
        challengePost:function(){
            /*召集发布*/
            $(".work_post_table .dissolve").click(function(){
                $(".dissolve_challenge,.layer_mask").show();
            });
            $(".work_post_table .timer span").click(function(){
                $(".work_post_table .timer span").removeClass("cur");
                $(this).addClass("cur");
            });

            fun.tagAdd();
            /*模块上下移动*/
            fun.moveBlock();
        },
        moveBlock:function(){
            $(".sections").delegate(".close","click",function(){
                $(this).parent().parent().remove();
            });
            $(".sections").delegate(".section","mouseover",function(){
                $(this).find(".close,.move_t,.move_b").show();
            });
            $(".sections").delegate(".section","mouseout",function(){
                $(this).find(".close,.move_t,.move_b").hide();
            });
            $(".sections").delegate(".move_t","click",function(){
                var $this_p=$(this).parent().parent();
                $this_p.insertBefore($this_p.prev());
                $(".sections .section a.close,.sections .section .move_t,.sections .section .move_b").hide();
            });
            $(".sections").delegate(".move_b","click",function(){
                var $this_p=$(this).parent().parent();
                $this_p.insertAfter($this_p.next());
                $(".sections .section a.close,.sections .section .move_t,.sections .section .move_b").hide();
            });
        },
        tagAdd:function(){
            $(".tag_recommend a").click(function(){
                var _text = $.trim($(".tag_add").val()), _arySpace = _text.match(/\s+/g), _tag = $(this).text();
                var _regx = new RegExp('(^|[\\s]+)' + _tag, 'g')
                if (_tag.length > 0 && (_arySpace == null || _arySpace.length < 4) && !_regx.test(_text)) {
                    $(".tag_add").val(_text + ' ' + _tag);
                }
            });
            $(".tag_add").keyup(function(){
                tag_num();
            });
            $(".tag_add").blur(function(){
                repeat();
            });
            function repeat(){
                var _text = $.trim($(".tag_add").val());
                $(".tag_add").val(_text.replace(/\s+/g, ' '));
                tag_num();
            }
            function tag_num(){
                var _text = $.trim($(".tag_add").val()), _arySpace = _text.match(/\s+/g);
                if(_arySpace != null && _arySpace.length > 4) {
                    $(".tag_tips").text("标签不能超过5个！");
                    $(".tag_add").val(_text.replace(/\s+[^\s]+$/, ''));
                } else {
                    $(".tag_tips").text('');
                }
            }
        },
        account:function(){
            var timer=null;
            var direction="right";
            var block_nums=$(".block").size();
            var _array = new Array();
            for(var i=0;i<block_nums;i++){
                _array[i]=new Array();
                _array[i][0]=$(".block").eq(i).offset().top+1;
                _array[i][1]=$(".block").eq(i).offset().top + $(".block").eq(i).outerHeight();
            }
            $(window).scroll(function(){
                //banner视差
                clearTimeout(timer);
                timer=setTimeout(function(){
                    var scroll_top=$(window).scrollTop();
                    var move;
                    var new_position=$(window).scrollTop();
                    if(new_position-bar_position>0){
                        move="down";
                    }else{
                        move="up";
                    }
                    bar_position=new_position;
                    //人物向下移动
                    var pepole_top=430+$("#avatar_m")[0].offsetTop+118;
                    if(scroll_top>pepole_top && move=="down"){
                        for(var i=0;i<block_nums;i++){
                            if(scroll_top>=_array[i][0]-240 && scroll_top<=_array[i][1]-240){
                                direction=$(".block").eq(i).data("type");
                            }
                        }
                        $("#avatar_m").removeClass().addClass("avatar_m_down");
                        if(direction=="left"){
                            $("#avatar_m").stop().css({"top":scroll_top-620+"px","margin-left":"-580px"});
                            $("#avatar_m").animate({top:scroll_top-320+"px"},2000,function(){
                                $("#avatar_m").removeClass().addClass("avatar_right");
                            });
                        }
                        if(direction=="right"){
                            $("#avatar_m").stop().css({"top":scroll_top-620+"px","margin-left":"490px"});
                            $("#avatar_m").animate({top:scroll_top-320+"px"},2000,function(){
                                $("#avatar_m").removeClass().addClass("avatar_left");
                            });
                        }
                    }
                    //人物向上移动
                    var move_up=scroll_top+$(window).height();
                    var pepole_top2=430+$("#avatar_m")[0].offsetTop;
                    if(move_up<pepole_top2 && move=="up"){
                        for(var i=0;i<block_nums;i++){
                            if(move_up>=_array[i][0] && move_up<=_array[i][1]){
                                direction=$(".block").eq(i).data("type");
                            }
                        }
                        $("#avatar_m").removeClass().addClass("avatar_m_up");
                        if(scroll_top<300){
                            $("#avatar_m").stop().css({"top":move_up-430+"px","margin-left":"-50px"});
                            $("#avatar_m").animate({top:"280px"},2000,function(){
                                $("#avatar_m").removeClass().addClass("avatar_right");
                            });
                        }else{
                            if(direction=="left"){
                                $("#avatar_m").stop().css({"top":move_up-430+"px","margin-left":"-580px"});
                                $("#avatar_m").animate({top:move_up-720+"px"},2000,function(){
                                    $("#avatar_m").removeClass().addClass("avatar_right");
                                });
                            }
                            if(direction=="right"){
                                $("#avatar_m").stop().css({"top":move_up-430+"px","margin-left":"490px"});
                                $("#avatar_m").animate({top:move_up-720+"px"},2000,function(){
                                    $("#avatar_m").removeClass().addClass("avatar_left");
                                });
                            }
                        }
                    }
                },200);
            });

            //查看他人信息
            $(".section_c_cont ul li").click(function(){
                var _top=$(window).scrollTop()+30;
                $(".layer_mask").show();
                $(".profile_other").show().css("top",_top+"px");

                fun.userProfileOpus($(this).find('.img').data('userid'));

            });
        },
        workPost:function(){
            $(".people .img").html('<img src="'+avatar.front+'" />');
            /*作品发布*/
            var $select=$(".work_post_table .select"),$select_a=$(".work_post_table .select .cont a"),$add_user=$(".work_post_box .people .cont .add");
            $select.click(function(){
//                $select.removeClass("select_cur");
            	if($(this).hasClass('select_cur')){//判断元素是否包含class
            		$(this).removeClass("select_cur");
            	}else{
            		$(this).addClass("select_cur");
            	}
            	
            	
            	var selectconval='';
            	$('.select').each(function (){
            		if($(this).hasClass('select_cur')){//判断元素是否包含class
            			if(selectconval!=''){
            				selectconval=selectconval+','+$(this).attr('to');
            			}else{
            				selectconval=$(this).attr('to');
            			}
            		}
            	})
            	$('#selectinputto').val(selectconval);
            	
            });
            $select_a.click(function(){
                $(this).parent().hide();
            });
            $select.hover(function(){
                $(this).find(".cont").show();
            },function(){
                $(this).find(".cont").hide();
            });
            $select.find(".cont a").each(function(index, element) {
                $(this).click(function(){
                    var text=$(this).text();
                    $select.find("span.arrow").text(text);
                });
            });

            $add_user.click(function(){
                $(".layer_mask,.adduser").show();
            });
            //添加标签
            fun.tagAdd();

            //添加成员
            $("#add_member").delegate("li","click",function(){
                if($(this).hasClass("cur")){
                    $(this).removeClass("cur");
                    add_member();
                }else{
                    $(this).addClass("cur");
                    add_member();
                }
            });
            $("#add_type").delegate("li","click",function(){
                if($(this).hasClass("cur")){
                    $(this).removeClass("cur");
                }else{
                    $(this).addClass("cur");
                }
            });
            
            //完成添加成员
            $(".adduser .submit").click(function(){
                $(".adduser,.layer_mask").hide();
                var newpeopleaddstr='';
                $('#add_member').find('li[class="cur"]').each(function (){
                	newpeopleaddstr=newpeopleaddstr+'<li class="clearboth"><span class="face"><img src="'+$(this).find('img').attr('src')+'">'+$(this).find('span').text()+'</span></li>';
                })
                $('.people').find('.cont').find('ul').html(newpeopleaddstr);
                
                var zuopinmemberstr='';
                $("#add_member").find('li[class="cur"]').each(function (){
                	if(zuopinmemberstr!=""){
                		zuopinmemberstr=zuopinmemberstr+','+$(this).find('i').text();
                	}else{
                		zuopinmemberstr=$(this).find('i').text();
                	}
                })
                $('#zuopinmemberstr').val(zuopinmemberstr);
            });
            function add_member(){
                var size=$("#add_member li.cur").size();
                $(".adduser .selected span").text(size);
            }
            add_member();

            //多行文本自适应
            if($(".post_textarea textarea").size()>0){
                $(".post_textarea textarea").each(function(index, element) {
                    var _height=$(".post_textarea textarea").eq(index)[0].scrollHeight;
                    $(".post_textarea textarea").eq(index).css({"height":_height+"px","overflow-y":"hidden"});
                });
            }
            $(".section textarea").each(function(index, element) {
                $(this).autoTextarea({maxHeight:1500});
            });
            //fun.textareaAuto();
            //$("textarea").autoTextarea({maxHeight:1500});
            /*模块上下移动*/
            fun.moveBlock();
        },
        cookie:{
            addCookie:function(objName,objValue,objHours){//添加cookie
                var str = objName + "=" + escape(objValue);
                if(objHours > 0){//为0时不设定过期时间，浏览器关闭时cookie自动消失
                    var date = new Date();
                    var ms = objHours*3600*1000;
                    date.setTime(date.getTime() + ms);
                    str += "; expires=" + date.toGMTString();
                }
                document.cookie = str;
            },
            getCookie:function (objName){//获取指定名称的cookie的值
                var arrStr = document.cookie.split("; ");
                for(var i = 0;i < arrStr.length;i ++){
                    var temp = arrStr[i].split("=");
                    if(temp[0] == objName) return unescape(temp[1]);
                }
            },
            delCookie:function (name){//为了删除指定名称的cookie，可以将其过期时间设定为一个过去的时间
                var date = new Date();
                date.setTime(date.getTime() - 10000);
                document.cookie = name + "=a; expires=" + date.toGMTString();
            }
        },
        userProfileOpus : function(userId) {
            //查看他人信息
            $(".profile_other .loading").show(); //loading
            $(".profile_other .scroll").hide(); //loading
            $.post('/api/gallery/userOpus', {
                userId : userId
            }, function(data){
                switch (data.status) {
                    case 'SUCCESS' :
                        $('#opus-owner-nickname').html(data.rsp.profile.nickname);
                        $('#opus-owner-avatar > img').attr('src', avatar.cdn + 'u/' + userId + '/avatar_front.png');
                        $('#opus-owner-profile > li:eq(0) strong').html(data.rsp.profile.opus_count);
                        $('#opus-owner-profile > li:eq(1) strong').html(data.rsp.profile.challenge_count);
                        $('#opus-owner-profile > li:eq(2) strong').html(data.rsp.profile.praise_count);
                        $('#opus-owner-profile > li:eq(3) strong').html(data.rsp.profile.follow_count);

                        if ($('#btn-follow').length > 0) {
                            $('#btn-follow').data('status', data.rsp.follow);
                            $('#btn-follow').data('userId', userId);
                            switch (data.rsp.follow) {
                                case 'hide' :
                                    $('#btn-follow').hide();
                                    break;
                                case 'login' :
                                    $('#btn-follow').html('登录后关注').show();
                                    break;
                                case 'remove' :
                                    $('#btn-follow').html('取消关注').show();
                                    break;
                                case 'show' :
                                    $('#btn-follow').html('Follow !').show();
                                    break;
                            }
                        }

                        if (data.rsp.opus.length > 0) {
                            var _out = [], _opus = null;
                            for (var i in data.rsp.opus) {
                                _opus =  data.rsp.opus[i];
                                _out.push('<li class="work">' +
                                '<p class="title clearboth"><span class="title_l"><em class="text"><a href="/gallery/' + _opus.opus_id + '" target="_blank">' + _opus.title + '</a></em><em class="num">' + _opus.praise_count + '</em></span></p>' +
                                '<span class="img"><a href="/gallery/' + _opus.opus_id + '" target="_blank"><img src="' + fun.thumb(_opus.thumb, 200) + '"></a></span>' +
                                '</li>');
                            }
                            $('#insert-other-work').show().html(_out.join(''));
                            $(".profile_other .loading").fadeOut(300); //loading
                            $(".profile_other .scroll").fadeIn(300); //loading
                            if($(".profile_other .scroll").hasClass("mCustomScrollbar")){
                                $(".profile_other .scroll").mCustomScrollbar("update");
                            }else{
                                $(".profile_other .scroll").mCustomScrollbar({autoDraggerLength:false,mouseWheelPixels:400});
                            }
                        }else{
                            $('#insert-other-work').hide();
                            $(".profile_other .loading").fadeOut(300); //loading
                            $(".profile_other .scroll").fadeIn(300); //loading
                        }
                        break;
                    default :
                        break;
                }
            }, 'json');
        },
        followTpl : function(obj, type) {
            return '<li>' +
                '<span class="name">' + obj.nickname + '</span>' +
                (obj.is_friend == 1 ? '<em class="concern">互相关注</em>' : '<em>已关注</em>') +
                '<span class="img" data-userid="' + obj.user_id + '"><img src="'
                + avatar.cdn + 'u/' + obj.user_id + '/avatar_front.png"></span>' +
                (type == 0 ? '<span class="cancel">取消关注</span>' : '') +
                '</li>';
        },
        my_friends:function(){
            /*我的好友*/
            $(".friends").delegate("li","mouseover",function(){
                $(this).addClass("hover");
            });
            $(".friends").delegate("li","mouseout",function(){
                $(this).removeClass("hover");
            });

            $('#friend-switch > li').each(function(i){
                var _li = $(this);
                _li.click(function(){
                    $.post('/api/account/follow/read', {
                        type : i
                    }, function(data){
                        switch (data.status) {
                            case 'SUCCESS' :
                                _li.addClass('cur').show().find('span').html(data.rsp.count);
                                _li.siblings().removeClass('cur');
                                var _out = [];
                                if (data.rsp.count > 0) {
                                    for (var j in data.rsp.list) {
                                        _out.push(fun.followTpl(data.rsp.list[j], i));
                                    }
                                }
                                $('.myfriends_list').eq(i).show().find('ul').html(_out.join('')).parent().siblings('.myfriends_list').hide();
                                break;
                            default :
                                break;
                        }
                    }, 'json');
                });
            });
            $('#friend-switch > li').eq(0).triggerHandler('click');
            $('.myfriends_list > ul').delegate('> li > .img', 'click', function(){
                fun.userProfileOpus($(this).data('userid'));
                var _top=$(window).scrollTop()+30;
                $(".layer_mask").show();
                $(".profile_other").show().css("top",_top+"px");
            });
            $('.myfriends_list > ul').delegate('> li > .cancel', 'click', function(){
                var _name=$(this).parent().find(".name").text();
                var _li = $(this).parent(), _userId = $(this).prev().data('userid');
                fun.confirm_tip("确定取消关注 “"+_name+"” ？", function(){
                    $.post('/api/account/follow/remove', {
                        userId : _userId
                    }, function(data){
                        switch (data.status) {
                            case 'SUCCESS' :
                                var _index = _li.parent().parent().data('index');
                                _li.remove();
                                var _i = ($('#friend-switch > li').eq(_index).find('span').html() >> 0) - 1;
                                $('#friend-switch > li').eq(_index).find('span').html(_i);
                                break;
                            default:
                                fun.error_tip('remove follow error!');
                                break;
                        }
                    },'JSON');
                });

            });
        },
        _logout:function(nickname){
            if (nickname != undefined) {
                $('#login-info').html('欢迎您，<span> ' + nickname
                + '</span><a class="exit" id="logout" href="javascript:;">退出</a>');
            }
            if ($('.login-img').length > 0) {
                $('.login .box').hide();
            }
            if ($('#logout').length > 0) {
                $('#logout').unbind('click').click(function() {
                    $.post('/api/logout', function(data) {
                        switch (data.status) {
                            case 'SUCCESS' :
                                window.location.replace(window.location.href);
                                //window.location.href = '/';
                                $('.login .img').removeClass('login-img').next().show();
                                $('#login-info').html('');
                                break;
                            default :
                                //alert(data.desc);
                                fun.error_tip(data.desc+'！');
                                break;
                        }
                        return false;
                    }, 'json');
                });
            }
        },
        getUrlParam : function (name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[2]); return null;
        }
    };
    fun.common();
    fun.login();
    fun._logout();
})