<?php
if (intval($this->userId) <= 0):
    ?>
    <!----------------------创建人物角色----------------------->
    <div class="steps_scroll">
        <div class="fbox_t clearboth">
            <div class="title"></div>
            <a class="close" href="javascript:;"></a>
        </div>
        <div class="steps_overflow">
            <div class="steps clearboth">
                <!--第一步-->
                <?php require($this->__RAD__ . '_one.php'); ?>
                <form id="frm-register" method="post" action="">
                    <input type="hidden" id="avatar" name="avatar" value="" />
                    <!--第二步-->
                    <?php require($this->__RAD__ . '_two.php'); ?>
                    <!--第三步-->
                    <?php require($this->__RAD__ . '_three.php'); ?>
                </form>
            </div>
        </div>
        <!---每一步操作按钮--->
        <div class="fbox_b clearboth" style="display:block;">
            <div class="fbox_b_l"><!--<a class="disabled" href="javascript:;"><span class="arrow">上一步</span></a>--></div>
            <div class="fbox_b_r"><a class="create_link normal" href="javascript:;"><span class="arrow">创建</span></a></div>
        </div>
        <div class="fbox_b clearboth">
            <div class="fbox_b_l"><a class="normal to_first" href="javascript:;"><span class="arrow">上一步</span></a></div>
            <div class="fbox_b_r"><a class="normal complete_link btn-register" href="javascript:;"><span>完 成</span></a></div>
        </div>
        <div class="fbox_b clearboth">
            <div class="fbox_b_l"><a class="normal to_second" href="javascript:;"><span class="arrow">上一步</span></a></div>
            <div class="fbox_b_r"><a class="normal complete_link btn-register" href="javascript:;"><span>完 成</span></a></div>
        </div>
    </div>
    <script>
        $(function(){
            var _year = '<?= date('Y', time()) ?>' >> 0;
            fun._select("birthday-year",_year - 60,_year + 1);
            fun._select("birthday-month",1,13);
            fun._select("birthday-day",1,32);
            var avatar_cdn=<?= $this->__CDN__ ?>;
            fun.avatar_read(avatar_cdn,'create_role');
        })
    </script>
<?php
endif;
?>