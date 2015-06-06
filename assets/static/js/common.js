$(function(){
  //登录
  $(".login").click(function(){
    var _top=$(window).scrollTop()+30;
    $(".layer_mask").show();
    $(".loginlayer").show().css("top",_top+"px");
  });

  $("#cookie_data").delegate("li","click",function(){
    if($(this).hasClass("item")){
      var _name=$(this).find("em").text();
      var _body=$(this).find("span").html();
      $(".login_cont .head_img").html(_body);
      $("#login-nickname").val(_name);
    }else{
      $("#login-nickname").val("Username");
    }
    $(".loginlayer .cookie").hide();
    $(".loginlayer .login_cont").show();
  });

  //创建帐号
  $(".loginlayer .reg_link").click(function(){
    var _top=$(window).scrollTop()+30;
    $(".loginlayer").hide();
    $(".steps_scroll").show().css("top",_top+"px");
  });

  //注册账号
  if ($('#frm-register').length > 0) {
    $('.btn-register').eq(0).unbind('click').click(function() {
      register('base');
    });
    $('.btn-register').eq(1).unbind('click').click(function() {
      register('more');
    });
    function register(type){
      var _nickname = $('#nickname'), _nicknameV = $.trim(_nickname.val()),
        _opassword = $('#opassword'), _opasswordV = $.trim(_opassword.val()),
        _password = $('#password'), _passwordV = $.trim(_password.val()),
        _email = $('#email'), _emailV = $.trim(_email.val()),_t=$("#password-tips");
      _nickname.keyup(function(){
        if($.trim($(this).val())!==""){
          $(this).removeClass("error_input");
          _t.text('');
        }
      });
      _password.keyup(function(){
        if($.trim($(this).val())!==""){
          $(this).removeClass("error_input");
          _t.text('');
        }
      });
      _opassword.keyup(function(){
        if($.trim($(this).val())!==""){
          $(this).removeClass("error_input");
          _t.text('');
        }
      });
      _email.keyup(function(){
        if($.trim($(this).val())!==""){
          $(this).removeClass("error_input");
          _t.text('');
        }
      });
      if (_nicknameV.length == 0) {
        _t.text('请输入昵称');
        _nickname.focus().addClass("error_input");
        if(type=="more"){
          step_scroll();
        }
        return false;
      } else if (_opasswordV.length == 0) {
        _t.text('请输入密码');
        _opassword.focus().addClass("error_input");
        if(type=="more"){
          step_scroll();
        }
        return false;
      } else if (_opasswordV != _passwordV) {
        _t.text('前后密码不一致');
        _password.focus().addClass("error_input");
        if(type=="more"){
          step_scroll();
        }
        return false;
      } else if (_emailV.length == 0) {
        _t.text('请输入邮箱');
        _email.focus().addClass("error_input");
        if(type=="more"){
          step_scroll();
        }
        return false;
      }else{
        var myreg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
        if(!myreg.test(_email.val())){
          _t.text('邮箱格式不正确');
          _email.focus().addClass("error_input");
          return false;
        }
        $.post('/api/register', $('#frm-register').serializeArray(), function(data) {
          switch (data.status) {
            case 'SUCCESS' :
              $(".steps_scroll").hide();
              $('.login .img').addClass('login-img').next().show();
              fun.right_tip('注册成功，欢迎加入喵爪社区！');
              var goto=true;
              if(goto){
                $(".right_tip .submit,.right_tip .tclose").click(function(){
                  //window.location.href = '/account';
                  window.location.replace(window.location.href);
                  goto=false;
                });
              }
              setTimeout(function(){
                $(".right_tip,.layer_mask").hide();
                window.location.href = '/account';
              },3000);
              //_logout(_nicknameV);
              break;
            default :
              $("#password-tips").text(data.desc);
              break;
          }
          return false;
        }, 'json');
      }
    }
    function step_scroll(){
      $(".step_three .base_info").click();
    }
  }
  if ($('#frm-login').length > 0) {
    $('#btn-login').unbind('click').click(function() {
      var _m = $('#login-nickname'), _nickname = $.trim(_m.val()), _userPwdHolder = '';
      var _p = $('#login-password');
      var _t = $('#login-tips');
      var _password = $.trim(_p.val());
      _m.keyup(function(){
        if($.trim($(this).val())!==""){
          $(this).removeClass("error_input");
          _t.text('');
        }
      });
      _p.keyup(function(){
        if($.trim($(this).val())!==""){
          $(this).removeClass("error_input");
          _t.text('');
        }
      });
      if (_userPwdHolder.length > 0 && _userPwdHolder == _password) {
        return false;
      }
      _userPwdHolder = _password;
      if (_nickname.length < 2) {
        _m.focus().addClass("error_input");
        _t.text('用户名不能为空');
        return false;
      } else if (_password.length < 5 || _password.length > 12) {
        _p.focus().addClass("error_input");
        _t.text('请输入5至12位密码');
        return false;
      } else {
        $.post('/api/login', {
          nickname: _nickname,
          pwd: _password
        }, function(data) {
          switch (data.status) {
            case 'SUCCESS' :
              if (window.location.href.indexOf('url=') != -1) {
                window.location.replace(decodeURIComponent(fun.getUrlParam('url')));
              } else {
                window.location.replace(window.location.href);
              }
              //window.location.href = '/account';
              $('.loginlayer,.layer_mask').hide();
              fun._logout(_nickname);
              break;
            case 'IS_LOCK' :
              _t.text('账号已被锁定，请在后' + data.desc + '重新尝试');
              break;
            case 'PASSWORD_ERROR' :
              _t.text('密码错误' + (data.rsp < 3 ? '，还可尝试 ' + data.rsp + ' 次' : ''));
              break;
            case 'NOT_EXISTS' :
              _t.text('此用户不存在');
              break;
            default :
              _t.text(data.desc);
              break;
          }
          return false;
        }, 'json');
      }
    });
  }


  /*忘记密码*/
  $(".forget .blue").click(function(){
    $(".loginlayer").hide();
    $(".find_password").show();
  });
  //找回密码
  $("#select_role").delegate("li","click",function(){
    $(".find_password ul.role li").removeClass("cur");
    $(this).addClass("cur");
  });
  var $scroll=$(".find_password .scroll");
  $(".find_password .to_two").click(function(){
    $scroll.animate({"left":"-650px"},{duration: 600, easing: "easeInOutCubic"});
    password_state(2);
  });
  $(".find_password .to_one").click(function(){
    $scroll.animate({"left":"0px"},{duration: 600, easing: "easeInOutCubic"});
    password_state(1);
  });
  function password_state(num){
    var _name=$("#select_role li.cur").data("name");
    if(_name!==""){
      $("#forgot-nickname").val(_name);
    }else{
      $("#forgot-nickname").val("");
    }
    $(".find_password .fbox_b").hide();
    num-=1;
    switch(num){
      case 0:
        $(".find_password .fbox_b").eq(0).show();
        break;
      case 1:
        $(".find_password .fbox_b").eq(1).show();
        break;
    }
  }
  if ($('#sendmail').length > 0) {
    $('#sendmail').unbind('click').click(function(){
      if ($('#forgot-nickname').val().length == 0 || $('#forgot-email').val().length == 0) {
        $('#forgot-tip').html('请将用户名及邮箱填写完整');
      } else {
        $.post('/api/sentMail', {
          nickname : $.trim($('#forgot-nickname').val()),
          email : $.trim($('#forgot-email').val())
        }, function(data){

          switch (data.status) {
            case 'SUCCESS' :
              var $scroll=$(".find_password .scroll");
              $("#r_email").text($("#forgot-email").val());
              $scroll.animate({"left":"-1300px"},{duration: 600, easing: "easeInOutCubic"});
              $(".find_password .fbox_b").hide();
              $(".find_password .fbox_b").eq(2).show();
              break;
            case 'NONE':
              $('#forgot-tip').html('请将用户名及邮箱填写完整');
              break;
            default:
              break;
          }
        },'JSON');
      }
    });
  }

  //follow
  if ($('#btn-follow').length > 0) {
    $('#btn-follow').unbind('click').click(function(){
      switch ($(this).data('status')) {
        case 'hide' :
          break;
        case 'login' :
          break;
        case 'remove' :
          $.post('/api/account/follow/remove', {
            userId : $(this).data('userId')
          }, function(data){
            switch (data.status) {
              case 'SUCCESS' :
                $('#btn-follow').data('status', 'show');
                $('#btn-follow').html('Follow !').show();
                if ($('#opus-owner-profile').length > 0) {
                  var _i = ($('#opus-owner-profile > li:eq(3) > strong').html() >> 0) - 1;
                  $('#opus-owner-profile > li:eq(3) > strong').html(_i);
                }
                break;
              default:
                fun.error_tip('remove follow error!');
                break;
            }
          },'JSON');
          break;
        case 'show' :
          $.post('/api/account/follow', {
            userId : $(this).data('userId')
          }, function(data){
            switch (data.status) {
              case 'SUCCESS' :
                $('#btn-follow').data('status', 'remove');
                $('#btn-follow').html('取消关注').show();
                if ($('#opus-owner-profile').length > 0) {
                  var _i = ($('#opus-owner-profile > li:eq(3) > strong').html() >> 0) + 1;
                  $('#opus-owner-profile > li:eq(3) > strong').html(_i);
                }
                break;
              default:
                fun.error_tip('follow error!');
                break;
            }
          },'JSON');
          break;
      }
    });
  }

  //修改个人信息
  $('#btn-password').unbind('click').click(function(){
    var _opassword = $('#opassword'), _opasswordV = $.trim(_opassword.val()),
      _npassword = $('#npassword'), _npasswordV = $.trim(_npassword.val()),
      _password = $('#password'), _passwordV = $.trim(_password.val()),_t=$("#password-tips");
    if (_opasswordV.length == 0) {
      _t.text('请输入密码');
      _opassword.focus();
    } else if (_npasswordV.length == 0) {
      _t.text('请输入新密码');
      _npassword.focus();
    } else if (_npasswordV != _passwordV) {
      _t.text('前后密码不一致');
      _password.focus();
    } else {
      $.post('/api/account/user/password', $('#frm-password').serializeArray(), function(data) {
        switch (data.status) {
          case 'SUCCESS' :
            _t.text('前后密码不一致');
            break;
          default :
            _t.text(data.desc);
            break;
        }
        return false;
      }, 'json');
    }
  });
  $('#btn-profile').unbind('click').click(function(){
    var _email = $('#parents_email'),_emailV = $.trim($('#parents_email').val()), _qq = $("#qq"), _qqV = $.trim($("#qq").val()), _mobile = $("#mobile"), _mobileV = $.trim($("#mobile").val()),_t=$("#baseinfo-tip");
    var myreg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
    var qq_reg= /^[0-9]{5,10}$/;
    var mobile_reg = /^(((13[0-9]{1})|159|153)+\d{8})$/;
    _email.keyup(function(){
      $(this).removeClass("error_input");
      _t.text('');
    });
    _qq.keyup(function(){
      $(this).removeClass("error_input");
      _t.text('');
    });
    _mobile.keyup(function(){
      $(this).removeClass("error_input");
      _t.text('');
    });
    if(_emailV!==""){
      if(!myreg.test(_emailV)){
        _t.text('邮箱格式不正确');
        _email.focus().addClass("error_input");
        return false;
      }
    }
    if(_qqV!==""){
      if(!qq_reg.test(_qqV)){
        _t.text('QQ号码格式不正确');
        _qq.focus().addClass("error_input");
        return false;
      }
    }
    if(_mobileV!==""){
      if(!mobile_reg.test(_mobileV)){
        _t.text('手机号码格式不正确');
        _mobile.focus().addClass("error_input");
        return false;
      }
    }
    $.post('/api/account/user/profile', $('#frm-profile').serializeArray(), function(data){
      switch (data.status) {
        case 'SUCCESS' :
          $(".info_scroll .info_cont").css("left","0");
          $(".info_scroll .step_two,.info_scroll .step_three,.info_scroll,.info_scroll .fbox_b").hide();
          fun.right_tip("保存成功！");
          break;
        default :
          fun.error_tip(data.desc+"！");
          break;
      }
    }, 'json');
  });
  if ($('#user-opus').length > 0 && !!$('#user-opus').data('readflag') == false) {
    $.post('/api/account/user/statistics', function(data){
      switch (data.status) {
        case 'SUCCESS' :
          $('#user-opus, #a-opus').html(data.rsp.opus_count);
          $('#user-praise, #a-praise').html(data.rsp.praise_count);
          $('#user-challenge').html(data.rsp.challenge_count);
          $('#user-focus').html(data.rsp.follow_count);
          $('#a-friend').html(data.rsp.friend_count);
          $('#a-day').html(data.rsp.day);
          $('#user-opus').data('readflag', 'true');
          break;
        default :
          fun.error_tip(data.desc);
          break;
      }
    }, 'json');
  }
  //退出登录
  $(".profile .exit_btn").click(function(){
    $.post('/api/logout', function(data) {
      switch (data.status) {
        case 'SUCCESS' :
          //window.location.href = '/';
          window.location.replace(window.location.href);
          break;
        default :
          //alert(data.desc);
          fun.error_tip(data.desc + '！');
          break;
      }
      return false;
    }, 'json');
  });

  //登录默认小人cookie创建
  if(String(typeof(avatar))!=="undefined"){
    var userAvatarId=avatar.userAvatarId;
    if(typeof(userAvatarId)!=="undefined"){
      var userId=new Array();
      var all_cookie=fun.cookie.getCookie("avatar_c");
      if(typeof(all_cookie)!=="undefined"){
        var obj=all_cookie.split("--");
        //if(obj.length<7){
        for(i=0;i<obj.length;i++){
          if(obj[i]!==""){
            var OldId=JSON.parse(obj[i]).userAvatarId;
            userId[i]=OldId;
          }
        }
        if(userId.indexOf(userAvatarId)==-1){
          var new_cookie=all_cookie+JSON.stringify(avatar);
          fun.cookie.addCookie("avatar_c",new_cookie+"--",30);
        };
        //}
      }else{
        fun.cookie.addCookie("avatar_c",JSON.stringify(avatar)+"--",30);
      }
    }else{
      if($(".cookie").size()>0){
        var html="";
        var find_html="";
        var all_cookie=fun.cookie.getCookie("avatar_c");
        if(typeof(all_cookie)!=="undefined"){
          var obj=all_cookie.split("--");
          obj.pop();
          for(i=0;i<obj.length;i++){
            if(obj[i]!==""){
              var _avatar=JSON.parse(obj[i]);
              var _body=_avatar.pics+_avatar.body.front;
              var _cloth=_avatar.pics+_avatar.clothes.front;
              var _face=_avatar.pics+_avatar.face.front;
              var _hair=_avatar.pics+_avatar.hair.front;
              var _name=_avatar.nickname;
              var _front=_avatar.front;
              html+='<li class="item"><span><i class="body"><img src="'+_body+'"></i><i class="cloth"><img src="'+_cloth+'"></i><i class="face"><img src="'+_face+'"></i><i class="hair"><img src="'+_hair+'"></i><i class="mask"></i></span><em>'+_name+'</em></li>';
              find_html+='<li data-name="'+_name+'"><div class="img"><img src="'+_front+'"></div><s></s></li>';
            }
          }
          $("#cookie_data").prepend(html);
          $("#select_role").prepend(find_html);
        }
      }
    }
  }

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-63780522-1', 'auto');
  ga('send', 'pageview');
  //end
});
