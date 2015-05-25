<!----------------------登录部分--------------------------->
<div class="loginlayer">
    <div class="fbox_t clearboth">
        <a class="close" href="javascript:;"></a>
    </div>
    <div class="fbox_c">
        <!--登录过用户列表-->
        <div class="cookie">
            <ul class="clearboth" id="cookie_data">
                <li><span><i><img src="<?= $this->__STATIC__ ?>images/login/normal.png" /></i></span>Other...</li>
            </ul>
            <div class="btn_cont"><a class="reg_link blue" href="javascript:;">注册新帐号</a></div>
        </div>
        <!--登录界面-->
        <form id="frm-login" action="" method="post">
            <div class="login_cont">
                <div class="head_img">
                    <span><img src="<?= $this->__STATIC__ ?>images/login/normal.png" /></span>
                </div>
                <input type="text" id="login-nickname" name="nickname" class="name" onBlur="if(this.value=='')this.value='Username';this.style.color='#999';" onClick="if(this.value=='Username')this.value='';this.style.color='#000';" value="Username" />
                <input type="password" id="login-password" name="password" class="password" maxlength="10" value="" />
                <div id="login-tips"></div>
                <p class="forget"><a class="blue" href="javascript:;">&nbsp;&nbsp;忘记密码？</a></p>
                <div class="btn_cont">
                    <input type="button" id="btn-login" class="button" value="登录" />
                    <a class="reg_link blue" href="javascript:;">注册新帐号</a>
                </div>
            </div>
        </form>
    </div>
</div>
<!--找回密码-->
<div class="find_password">
    <div class="fbox_t clearboth">
        <a class="close" href="javascript:;"></a>
    </div>
    <div class="fbox_c">
        <div class="fbox_c_t clearboth">
        	<div class="fbox_c_t_l"><img src="<?= $this->__STATIC__ ?>images/password/title.png" /></div>
			<div class="fbox_c_t_r">联系我们<br><a href="mailto:info@mzworld.cn">info@mzworld.cn</a></div>
        </div>
        <div class="scroll_cont">
        	<div class="scroll clearboth">
                <div class="select_role">
                    <p class="f14 mb20">这下面的角色，哪个是你？</p>
                    <ul class="role clearboth" id="select_role">
                        <li>
                            <div class="img" style="background:none;"><img style="margin-top:14px;" src="<?= $this->__STATIC__ ?>images/password/last.png" /></div>
                            <s></s>
                        </li>
                    </ul>
                </div>
                <div class="fill_input">
                    <p class="tips">请输入你的用户名和邮箱<br />以便我们将重设密码的链接发送给你</p>
                    <input name="" id="forgot-nickname" type="text" class="name" placeholder="用户名" value="" />
                    <input name="" id="forgot-email" type="text" class="email" placeholder="邮箱" value="" />
                    <div id="forgot-tip" class="form_tips"></div>
                </div>
                <div class="email_tip">密码重置邮件已经发往<br /><em id="r_email"></em><br />重置的方法可以在邮件中找到</div>
            </div>
        </div>
    </div>
    <div class="fbox_b clearboth" style="display:block;">
        <div class="fbox_b_r"><a class="normal to_two" href="javascript:;"><span>下一步</span></a></div>
    </div>
    <div class="fbox_b clearboth">
        <div class="fbox_b_l"><a class="normal to_one" href="javascript:;"><span>上一步</span></a></div>
        <div class="fbox_b_r"><a id="sendmail" class="normal" href="javascript:;"><span>下一步</span></a></div>
    </div>
    <div class="fbox_b clearboth">
        <div class="fbox_b_l"><a class="normal to_two" href="javascript:;"><span>上一步</span></a></div>
        <div class="fbox_b_r"><a class="ok" href="javascript:;"></a></div>
    </div>
</div>