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
    <div class="banner" style=" height:200px; margin-bottom:-97px;"></div>
    <div class="create_title"></div>
    <div class="group_a clearboth" style="min-height:400px;">
        <div class="group_a_l">
            <span><img src="<?= $this->__STATIC__ ?>images/group/img2.png" /></span>
        </div>
        <div class="group_a_r success_r">
            <div class="title">
              <span>群组 三年二班 创建成功</span>
            </div>
            <div class="mb40"><a class="view_space" href="/account/group">查看群组空间</a></div>
            <p class="send">发送邀请链接</p>
            <textarea class="textarea" name="" cols="" rows="">ScratchWorld群组 三年二班 管理员邀请你加入，点击本链接申请加入群组：http://www.scratchworld.com/group/1730723/apply</textarea>
            <input class="copybtn" type="button" value="复制文本" />
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
		$(".add_flag li.item").click(function(){
				var _url=$(this).find("img").attr("src");
				$(".group_a_l img").attr("src",_url);
		});
	})
</script>
</body>
</html>