<?php
require($this->__RAD__ . '_head.php');
?>
<link rel="stylesheet" href="<?= $this->__STATIC__ ?>css/zi.css">
</head>
<body>
<?php
require($this->__RAD__ . 'top.php');
?>
<div class="group_bg">
    <div class="banner"></div>
    <div class="group_a clearboth" style="min-height:500px;">
        <div class="group_a_l">
            <span><img src="<?= $this->__STATIC__ ?>/images/content/honor_2.png" /></span>
        </div>
        <div class="group_apply">
        		<div class="title">马里奥联盟</div>
            <p class="num">10个成员 33个作品</p>
            <a id="apply_btn" href="/account/groupUser">申请加入</a>
            <p class="time">2天前已提交申请</p>
            <div class="role"><img src="<?= $this->__STATIC__ ?>images/group.png"></div>
        </div>
    </div>
</div>
<?php
require($this->__RAD__ . 'footer.php');
?>
<script src="<?= $this->__STATIC__ ?>js/jquery.zclip.min.js"></script>
<script>
    $(function(){
        fun.group();
        $(".copybtn").zclip({
            path: "<?= $this->__STATIC__ ?>js/ZeroClipboard.swf",
            copy: function(){
                return $(this).parent().find(".textarea").val();
            },
            afterCopy:function(){/* 复制成功后的操作 */
                var $copysuc = $("<div class='copy-tips'><div class='copy-tips-wrap'>复制成功 !</div></div>");
                $("body").find(".copy-tips").remove().end().append($copysuc);
                $(".copy-tips").fadeOut(3000);
            }
        });
    })
</script>
<script>
	$(function(){
			$(".option_r .btn1").click(function(){
					$(".move_to,.layer_mask").show();
			});
			$(".move_to .button").click(function(){
					$(".move_to,.layer_mask").hide();
			});
			$(".move_to .type li").each(function(index, element) {
        $(this).click(function(){
						$(".move_to .type li").removeClass("cur");
						$(this).addClass("cur");
				});
      });
			$("#dissolve-link").click(function(){
				fun.confirm_tip();
			});
	})
</script>
</body>
</html>