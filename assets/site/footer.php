<?php
require($this->__RAD__ . '_register.php');
require($this->__RAD__ . '_login.php');
?>
<div class="copyright clearboth">
    <dl class="item">
        <dt><img src="<?= $this->__STATIC__ ?>images/logo2.png" /></dt>
        <dd>&copy; 2015-2020  上海喵爪网络科技有限公司<a href="javascript:;">沪ICP备15011748号</a></dd>
    </dl>
    <dl class="item2">
        <dt>关于我们</dt>
        <dd>
            <span><a href="/about">关于我们</a></span>
            <span><a href="/privacy">隐私政策</a></span>
        </dd>
    </dl>
    <dl class="item3">
        <dt>关注我们</dt>
        <dd>
            <span class="weixin"><div class="code"><img src="<?= $this->__STATIC__ ?>images/code.jpg" /><em></em></div></span>
            <!--<img src="<?= $this->__STATIC__ ?>images/s_icon2.png" />-->
        </dd>
    </dl>
    <dl class="item4">
        <dt>合作伙伴</dt>
        <dd class="clearboth">
            <a href="http://www.arkdesign.cn" target="_blank" class="img_box"><span></span><img src="<?= $this->__STATIC__ ?>images/l.png" /></a>
            <a href="http://www.tes-amm.cn" target="_blank" class="img_box"><span></span><img src="<?= $this->__STATIC__ ?>images/l_3.png" /></a>
            <a class="img_box"><span></span></a>
            <a class="img_box"><span></span></a>
            <a class="img_box"><span></span></a>
            <a class="img_box"><span></span></a>
        </dd>
    </dl>
</div>
<div class="layer_mask"></div>
<!----------------------错误提示----------------------->
<div class="error_tip">
    <div class="tbox">
        <div class="tclose"></div>
        <input type="button" value="好的" class="submit">
        <div class="tbox_b">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td><span class="tip">操作错误！</span></td>
                </tr>
            </table>
            <i></i>
        </div>
    </div>
</div>
<!----------------------正确提示----------------------->
<div class="right_tip">
    <div class="tbox">
        <div class="tclose"></div>
        <input type="button" value="好的" class="submit">
        <div class="tbox_b">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td><span class="tip">操作成功！</span></td>
                </tr>
            </table>
            <i></i>
        </div>
    </div>
</div>
<!----------------------确认提示----------------------->
<div class="confirm">
    <div class="fbox_t clearboth">
        <a class="close" href="javascript:;"></a>
    </div>
    <div class="fbox_c clearboth">
        确认解散群组 “大同的三年二班”？
    </div>
    <div class="option clearboth">
        <span id="cancel-btn">取消</span><span id="sure-btn">确定</span>
    </div>
</div>
<!----------------------个人信息----------------------->
<?php
if (intval($this->userId) > 0):
    ?>
    <div class="info_scroll">
        <div class="fbox_t clearboth">
            <a class="close" href="javascript:;"></a>
        </div>
        <div class="info_overflow">
            <div class="info_cont">
                <!--我的背包-->
                <div class="profile">
                    <div class="fbox_c clearboth">
                        <div class="fbox_c_l">
                            <div class="name">Astronaut X</div>
                            <div class="img">
                                <i class="body"><img src="<?= $this->__STATIC__ ?>images/01/body.png"></i>
                                <i class="cloth"><img src="<?= $this->__STATIC__ ?>images/01/cloth_front.png"></i>
                                <i class="face"><img src="<?= $this->__STATIC__ ?>images/01/face.png"></i>
                                <i class="hair"><img src="<?= $this->__STATIC__ ?>images/05/hair.png"></i>
                                <i class="mask"><img src="<?= $this->__STATIC__ ?>images/mask.png"></i>
                            </div>
                            <ul class="info clearboth">
                                <li><strong id="user-opus" data-readflag="false">0</strong>作品</li>
                                <li><strong id="user-challenge">0</strong>召集</li>
                                <li><strong id="user-praise">0</strong>赞!</li>
                                <li><strong id="user-focus">0</strong>关注者</li>
                            </ul>
                            <div class="text_c"><a class="account_btn" id="btn-chg-profile" data-readflag="false" href="javascript:;">账户</a><a class="exit_btn" href="javascript:;">登出</a></div>
                            <a href="/avatar?id=<?= $this->userId ?>&nickname=<?= $this->nickname ?>" class="download"></a>
                        </div>
                        <div class="fbox_c_r">
                            <div class="loading"></div>
                            <div class="scroll">
                                <?php /*?><ul>
                                    <li class="email">
                                    	<div class="email"></div>
                                        <strong>通知</strong>
                                        <span><em>32</em></span>
                                    </li>
                                </ul><?php */?>
                                <ul id="insert-work"></ul>
                                <ul id="insert-challenge"></ul>
                                <ul id="insert-card">

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!--我的背包/关注者-->
                <div class="profile_notification">
                    <div class="fbox_c clearboth">
                        <div class="fbox_c_l">
                            <span>我的背包</span>
                        </div>
                        <div class="fbox_c_r">
                            <div class="comment">
                                <dl class="clearboth">
                                    <dt><img src="<?= $this->__STATIC__ ?>images/profile/face.png" /></dt>
                                    <dd class="clearboth">
                                <span class="text">
                                      <em>13:59  Mon King 对 My Skateshoe 的评论：</em>
                                      <i>哈哈哈哈，庞麦郎好搞笑~~32个赞</i>
                                  </span>
                                        <span class="img"><img src="<?= $this->__STATIC__ ?>images/profile/img.jpg" /></span>
                                    </dd>
                                </dl>
                                <dl class="clearboth">
                                    <dt><img src="<?= $this->__STATIC__ ?>images/profile/face.png" /></dt>
                                    <dd class="clearboth">
                                      <span class="text">
                                            <em>2天前：</em>
                                            <i>wendy 邀请你加入马里奥联盟群组</i>
                                        </span>
                                        <a class="follow" href="/account/groupApply">立即参加</a>
                                        <!--<span class="img"><img src="<?= $this->__STATIC__ ?>images/profile/img.jpg" /></span>-->
                                    </dd>
                                </dl>
                                <dl class="clearboth">
                                    <dt><img src="<?= $this->__STATIC__ ?>images/profile/face.png" /></dt>
                                    <dd class="clearboth">
                                <span class="text">
                                      <em>1天前</em>
                                      <i>Forest Nurd 关注了你！</i>
                                  </span>
                                        <a class="follow" href="javascript:;">Follow</a>
                                    </dd>
                                </dl>
                                <dl class="clearboth">
                                    <dt><img src="<?= $this->__STATIC__ ?>images/profile/face.png" /></dt>
                                    <dd class="clearboth">
                                <span class="text">
                                      <em>13:59  Mon King 对 My Skateshoe 的评论：</em>
                                      <i>哈哈哈哈，庞麦郎好搞笑~~32个赞</i>
                                  </span>
                                        <span class="img"><img src="<?= $this->__STATIC__ ?>images/profile/img.jpg" /></span>
                                    </dd>
                                </dl>
                                <dl class="clearboth">
                                    <dt><img src="<?= $this->__STATIC__ ?>images/profile/face.png" /></dt>
                                    <dd class="clearboth">
                                <span class="text">
                                      <em>13:59  Mon King 对 My Skateshoe 的评论：</em>
                                      <i>哈哈哈哈，庞麦郎好搞笑~~32个赞</i>
                                  </span>
                                        <span class="img"><img src="<?= $this->__STATIC__ ?>images/profile/img.jpg" /></span>
                                    </dd>
                                </dl>
                                <dl class="clearboth">
                                    <dt><img src="<?= $this->__STATIC__ ?>images/profile/face.png" /></dt>
                                    <dd class="clearboth">
                                <span class="text">
                                      <em>13:59  Mon King 对 My Skateshoe 的评论：</em>
                                      <i>哈哈哈哈，庞麦郎好搞笑~~32个赞</i>
                                  </span>
                                        <span class="img"><img src="<?= $this->__STATIC__ ?>images/profile/img.jpg" /></span>
                                    </dd>
                                </dl>
                                <dl class="clearboth">
                                    <dt><img src="<?= $this->__STATIC__ ?>images/profile/face.png" /></dt>
                                    <dd class="clearboth">
                                <span class="text">
                                      <em>13:59  Mon King 对 My Skateshoe 的评论：</em>
                                      <i>哈哈哈哈，庞麦郎好搞笑~~32个赞</i>
                                  </span>
                                        <span class="img"><img src="<?= $this->__STATIC__ ?>images/profile/img.jpg" /></span>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <!--我的背包/卡片-->
                <div class="profile_card">
                    <div class="fbox_c clearboth">
                        <div class="fbox_c_l">
                            <span>我的背包</span>
                        </div>
                        <div class="fbox_c_r">
                            <div class="card">

                            </div>
                        </div>
                    </div>
                </div>
                <!--修改个人角色-->
                <div class="modify_role">
                    <?php require($this->__RAD__ . '_one.php'); ?>
                </div>
                <form id="frm-password" method="post" action="">
                    <?php require($this->__RAD__ . '_password.php'); ?>
                </form>
                <form id="frm-profile" method="post" action="">
                    <?php require($this->__RAD__ . '_three.php'); ?>
                </form>
                <!--end-->
                <script>
                    $(function(){
                        var _year = '<?= date('Y', time()) ?>' >> 0;
                        fun._select("birthday-year",_year - 60,_year + 1);
                        fun._select("birthday-month",1,13);
                        fun._select("birthday-day",1,32);
                        var avatar_cdn=<?= $this->__CDN__ ?>;
                        fun.avatar_read(avatar_cdn,'modify_role');
                    })
                </script>
            </div>
        </div>
        <div class="fbox_b clearboth">
            <div class="fbox_b_l"><a class="normal prev_one" href="javascript:;"><span class="arrow">我的背包</span></a></div>
            <div class="fbox_b_r"><a class="normal" id="btn-avatar" href="javascript:;"><span class="arrow">修 改</span></a></div>
        </div>
        <div class="fbox_b clearboth">
            <div class="fbox_b_l"><a class="normal prev_two" href="javascript:;"><span class="arrow">我的背包</span></a></div>
            <div class="fbox_b_r"><a class="normal" id="btn-password" href="javascript:;"><span class="arrow">完 成</span></a></div>
        </div>
        <div class="fbox_b clearboth">
            <div class="fbox_b_l"><a class="normal prev_three" href="javascript:;"><span class="arrow">修改密码</span></a></div>
            <div class="fbox_b_r"><a class="normal" id="btn-profile" href="javascript:;"><span class="arrow">完 成</span></a></div>
        </div>
    </div>
<?php
endif;
?>
<!----------------------查看他人信息----------------------->
<div class="profile_other" id="opus-owner-wrap">
    <div class="fbox_t clearboth">
        <a class="close" href="javascript:;"></a>
    </div>
    <div class="fbox_c clearboth">
        <div class="fbox_c_l">
            <div class="name" id="opus-owner-nickname">Astronaut X</div>
            <div class="img" id="opus-owner-avatar">
                <img src="">
            </div>
            <ul class="info clearboth" id="opus-owner-profile">
                <li><strong>0</strong>作品</li>
                <li><strong>0</strong>召集</li>
                <li><strong>0</strong>赞!</li>
                <li><strong>0</strong>关注者</li>
            </ul>
            <div class="text_c"><a class="follow" id="btn-follow" href="javascript:;">Follow !</a></div>
        </div>
        <div class="fbox_c_r">
            <div class="loading"></div>
            <div class="scroll">
                <ul id="insert-other-work"></ul>
                <ul id="insert-other-challenge"></ul>
            </div>
        </div>
    </div>
</div>
<!--返回顶部-->
<div class="back_top"></div>
<script src="<?= $this->__STATIC__ ?>js/common.js"></script>
<!--<script>-->
<!--//    $(function(){-->
<!--//        $("#insert-card .card_id").click(function(){-->
<!--//            var x=$(this).index();-->
<!--//            $(".p_room:eq("+x+")").addClass("show").siblings().removeClass("show");-->
<!--//        })-->
<!--//    })-->
<!--</script>-->