<?php
require($this->__RAD__ . '_head.php');
?>
</head>
<body style="background:#EFDFD0;">
<?php
require($this->__RAD__ . 'top.php');
?>
<div class="box-404">
    <div class="box-404-t"></div>
    <div class="box-404-cont">

    </div>
</div>
<div class="reset">
    <div class="fbox_c">
        <form id="frm-login" method="post" action="">
            <div class="login_cont" style="display: block;">
                <div class="head_img"><span><img src="/assets/static/images/login/normal.png"></span></div>
                <input id="opassword" class="name" type="password" placeholder="新密码" name="opassword" style="color: rgb(153, 153, 153);">
                <input id="password" class="password" type="password" value="" placeholder="确认密码" maxlength="20" name="password" style="color: rgb(153, 153, 153);">

                <div class="btn_cont"><input id="btn-forgot-password" class="button" type="button" value="提 交"></div>
            </div>
        </form>
    </div>
</div>
<?php
require($this->__RAD__ . 'footer.php');
?>
<script>
    $(function(){
        var _uuid = '<?= $_GET['uuid'] ?>';
        if (_uuid.length > 0) {

            $('#btn-forgot-password').unbind('click').click(function(){
                if ($.trim($('#opassword').val()).length == 0) {
                    alert('please input you new password');
                    $('#opassword').focus();
                } else if ($.trim($('#opassword').val()) != $.trim($('#password').val())) {
                    alert('password match error');
                    $('#password').focus();
                } else {
                    $.post('/api/forgotPassword', {
                        uuid : _uuid,
                        password : $.trim($('#password').val())
                    }, function(data) {
                        switch (data.status) {
                            case 'SUCCESS':
                                alert('success, jump to login wait for a moment time');
                                break;
                            case 'NONE':
                                alert('权限验证错误');
                                break;
                            default:
                                alert('已超时，请重新获取邮件');
                                break;
                        }
                    }, 'json');
                }
            });
        }
    })
</script>
</body>
</html>