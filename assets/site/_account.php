<!----------------------账户信息----------------------->
<div class="account">
    <div class="step_two">
        <div class="fbox_t clearboth">
            <div class="title"><img src="<?= $this->__STATIC__ ?>images/role/title3.png" /></div>
            <a class="close" href="javascript:;"></a>
        </div>
        <div class="fbox_c clearboth">
            <div class="fbox_c_l clearboth">
                <div class="fbox_c_l_l">
                    <div class="head_img">
                        <span><img src="<?= $this->__STATIC__ ?>images/login/img.png" /></span>
                    </div>
                </div>
                <div class="fbox_c_l_r">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td>
                                <div class="name">Cyan.L</div>
                                <p class="email_text">cyanblue@mail.com</p>
                                <input type="button" class="password_btn" value="修改密码" />
                                <div class="password_cont">
                                    <input type="text" class="password" value="现有密码" onBlur="if(this.value=='')this.value='现有密码';this.style.color='#999';" onClick="if(this.value=='现有密码')this.value='';this.style.color='#000';" />
                                    <input type="text" class="password" value="新密码" onBlur="if(this.value=='')this.value='新密码';this.style.color='#999';" onClick="if(this.value=='新密码')this.value='';this.style.color='#000';" />
                                    <input type="text" class="password" value="确认新密码" onBlur="if(this.value=='')this.value='确认新密码';this.style.color='#999';" onClick="if(this.value=='确认新密码')this.value='';this.style.color='#000';" />
                                    <div class="sure"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="fbox_c_r">
                <span>更多账户信息</span>
            </div>
        </div>
        <div class="fbox_b clearboth">
            <div class="fbox_b_r"><a class="normal" href="#">完 成</a></div>
        </div>
    </div>
    <div class="step_three">
        <div class="fbox_t clearboth">
            <div class="title"><img src="<?= $this->__STATIC__ ?>images/role/title3.png" /></div>
            <a class="close" href="javascript:;"></a>
        </div>
        <div class="fbox_c clearboth">
            <div class="fbox_c_l">
                <span>基本账户信息</span>
            </div>
            <div class="fbox_c_r">
                <p class="title blue">帮助我们更了解你！</p>
                <p class="gray mb60">请填写以下信息：</p>
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td>生日</td>
                        <td><select class="select_style" name=""><option>yyyy</option></select>&nbsp;&nbsp;<select class="select_style" name=""><option>mm</option></select>&nbsp;&nbsp;<select name="" class="select_style"><option>dd</option></select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td>父母邮箱</td>
                        <td><input class="formtext" name="" type="text" value="父母邮箱" onBlur="if(this.value=='')this.value='父母邮箱';this.style.color='#777';" onClick="if(this.value=='父母邮箱')this.value='';this.style.color='#000';" /></td>
                    </tr>
                    <tr>
                        <td>性别</td>
                        <td>
                            <input name="sex" type="hidden" value="">
                            <div class="select_style select_sex">
                                <span>男</span>
                                <ul class="cont">
                                    <li data-value="0">男</li>
                                    <li data-value="1">女</li>
                                    <li data-value="2">保密</li>
                                </ul>
                            </div>
                        </td>
                        <td>学校</td>
                        <td><input class="formtext" name="" type="text" value="你的学校" onBlur="if(this.value=='')this.value='你的学校';this.style.color='#777';" onClick="if(this.value=='你的学校')this.value='';this.style.color='#000';" /></td>
                    </tr>
                    <tr>
                        <td>QQ</td>
                        <td><input class="formtext" name="" type="text" value="你的QQ号码" onBlur="if(this.value=='')this.value='你的QQ号码';this.style.color='#777';" onClick="if(this.value=='你的QQ号码')this.value='';this.style.color='#000';" /></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>手机</td>
                        <td><input class="formtext" name="" type="text" value="你的手机号码" onBlur="if(this.value=='')this.value='你的手机号码';this.style.color='#777';" onClick="if(this.value=='你的手机号码')this.value='';this.style.color='#000';" /></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="fbox_b clearboth">
            <div class="fbox_b_r"><a class="normal" href="#">完 成</a></div>
        </div>
    </div>
</div>