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
    </div>
    <?php
    endif;
    ?>