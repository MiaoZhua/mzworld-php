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
                <div class="name"><?= $this->nickname ?></div>
                <input type="password" class="password" id="opassword" name="opassword" placeholder="原始密码">
                <input type="password" class="password" id="npassword" name="npassword" placeholder="新密码">
                <input type="password" class="email" id="password" name="password" placeholder="确认密码">
                <div id="password-tips"></div>
            </div>
        </div>
        <div class="fbox_c_r more_info">
            <span>修改账户信息</span>
        </div>
    </div>
</div>