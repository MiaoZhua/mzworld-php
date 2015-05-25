<div class="step_two">
    <div class="fbox_c clearboth">
        <div class="fbox_c_l clearboth">
            <div class="fbox_c_l_l">
                <div class="head_img">
                    <span>
                        <i class="body"><img src="<?= $this->__STATIC__ ?>images/01/body.png"></i>
                        <i class="cloth"><img src="<?= $this->__STATIC__ ?>images/01/cloth_front.png"></i>
                        <i class="face"><img src="<?= $this->__STATIC__ ?>images/01/face.png"></i>
                        <i class="hair"><img src="<?= $this->__STATIC__ ?>images/01/hair.png"></i>
                        <i class="mask"><img src="<?= $this->__STATIC__ ?>images/mask.png"></i>
                    </span>
                </div>
            </div>
            <div class="fbox_c_l_r">
                <input type="text" class="password" id="nickname" name="nickname" onBlur="if(this.value=='')this.value='起个名字';this.style.color='#999';" onClick="if(this.value=='起个名字')this.value='';this.style.color='#000';" value="起个名字">
                <input type="password" class="password" id="opassword" name="opassword" onBlur="if(this.value=='')this.value='设定密码';this.style.color='#999';" onClick="if(this.value=='设定密码')this.value='';this.style.color='#000';" value="设定密码">
                <input type="password" class="password" id="password" name="password" onBlur="if(this.value=='')this.value='确认密码';this.style.color='#999';" onClick="if(this.value=='确认密码')this.value='';this.style.color='#000';" value="确认密码">
                <input type="text" class="email" id="email" name="email" onBlur="if(this.value=='')this.value='设定邮箱';this.style.color='#999';" onClick="if(this.value=='设定邮箱')this.value='';this.style.color='#000';" value="设定邮箱">
                <div id="password-tips"></div>
            </div>
        </div>
        <div class="fbox_c_r more_info">
            <span>更多账户信息</span>
            <em>选填</em>
        </div>
    </div>
</div>