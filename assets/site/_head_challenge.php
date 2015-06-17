<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $this->pageSeoTitle ?></title>
    <?= $this->pageSeoDescription ?>
    <?= $this->pageSeoKeywords ?>
    <link href="<?= $this->__STATIC__ ?>css/default.css" rel="stylesheet">
	<link rel="shortcut icon" href="<?= $this->__STATIC__ ?>images/icon.ico" />
    <script src="<?= $this->__STATIC__ ?>js/jquery-1.11.1.min.js"></script>
    <!--[if lt IE 8 ]><script src="<?= $this->__STATIC__ ?>js/json2.js"></script><![endif]-->
    <script src="<?= $this->__STATIC__ ?>js/funchallenge.js"></script>
    <script src="<?= $this->__STATIC__ ?>js/scrollbar.js"></script>
    <script src="<?= $this->__STATIC__ ?>js/swfobject.js"></script>
    <script src="<?= $this->__STATIC__ ?>js/scroll.js"></script>
    <script>
        <?php
        if (intval($this->userId) > 0):
        ?>
        var avatar = $.parseJSON('<?= $this->avatar ?>');
        avatar.id = '<?= $this->userId ?>';
        avatar.nickname = '<?= $this->nickname ?>';
        avatar.pics = avatar.cdn + 'pics/l/';
        var _merge = avatar.cdn + 'u/' + avatar.id + '/';
        avatar.front = _merge + avatar.front;
        avatar.rear = _merge + avatar.rear;
        $(function(){
            fun.flushAvatar(avatar);
        });
        <?php
        else:
        ?>
        var avatar = { cdn : '<?= $this->__CDN__ ?>' };
        <?php
        endif;
        ?>
    </script>