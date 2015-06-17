<?php
require($this->__RAD__ . '_head.php');
?>
<link rel="stylesheet" href="<?= $this->__STATIC__ ?>css/zi.css">
</head>
<body>
<?php
require($this->__RAD__ . 'top.php');
?>
<div class="myfriends">
    <div class="banner">
        <span>我的好友</span>
    </div>
    <div class="myfriends_type">
        <ul id="friend-switch" class="clearboth">
            <li class="cur" data-index="0">我关注的 <span></span></li>
            <li data-index="1">关注我的 <span></span></li>
        </ul>
    </div>
    <div class="myfriends_list" data-index="0">
        <ul class="friends clearboth">
        </ul>
    </div>
    <div class="myfriends_list" data-index="1">
        <ul class="friends clearboth">
        </ul>
    </div>
</div>
<?php
require($this->__RAD__ . 'footer.php');
?>
<script>
    $(function(){
        fun.my_friends();
    })
</script>
</body>
</html>