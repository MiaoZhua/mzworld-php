<div class="head">
    <div class="logo"><a href="/"></a></div>
    <div class="menu">
        <ul class="clearboth">
            <?php
            if (!is_null($this->nickname)):
            ?>
            <li<?= \Tools\Auxi::comparePath($this->__PHP_SELF__, 'account', 'cur') ?>><a class="item" href="/account"><i></i>空间</a></li>
            <?php
            else:
            ?>
            <li<?= \Tools\Auxi::compareBool($this->__HOMEPAGE__, 'cur') ?>><a class="item" href="/"><i></i>空间</a></li>
            <?php
            endif;
            ?>
            <li<?= \Tools\Auxi::comparePath($this->__PHP_SELF__, 'gallery', 'cur') ?>><a class="item2" href="/gallery"><i></i>画廊</a></li>
            <li<?= \Tools\Auxi::comparePath($this->__PHP_SELF__, 'tutorial', 'cur') ?>><a class="item3" href="/tutorial"><i></i>微课</a></li>
            <li<?= \Tools\Auxi::comparePath($this->__PHP_SELF__, 'yplan', 'cur') ?>><a class="item4" href="/yplan"><i></i>社会工作坊</a></li>
        </ul>
    </div>
    <div class="login_info" id="login-info">
        <?= $this->userInfo ?>
    </div>
    <div class="button">
        <div class="img"></div>
        <ul class="cont">
            <li class="item"><a href="#">游戏</a></li>
            <li class="item2"><a href="#">动画</a></li>
            <li class="item3"><a href="#">音乐</a></li>
            <li class="item4"><a href="#">美术</a></li>
            <li class="search">
                <span>
                    <input class="keyword" name="" type="text">
                    <input class="submit" type="button" value=" ">
                </span>
            </li>
        </ul>
    </div>
</div>