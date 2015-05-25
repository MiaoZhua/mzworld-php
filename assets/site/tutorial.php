<?php
require($this->__RAD__ . '_head.php');
?>
<link rel="stylesheet" href="<?= $this->__STATIC__ ?>css/index.css">
</head>
<body>
<?php
require($this->__RAD__ . 'top.php');
?>
<!--微课-->
<div class="course">
    <div class="course_t">
        <div class="layer"></div>
        <div class="layer2"></div>
        <div class="layer3"></div>
    </div>
    <div class="course_c">
        <?php
        if ($this->topRs):
        ?>
        <div class="tv">
            <div class="img"><img src="<?= $this->__CDN__ . 'pics/s/' . $this->topRs->cover_src ?>"></div>
            <div class="tip">
                <span><?= $this->topTip ?></span>
                <a href="#tutorial<?= $this->topRs->tutorial_id ?>"><?= $this->topRs->title ?></a>
            </div>
        </div>
        <?php
        endif;
        ?>
        <div class="pepole p_1">
            <div class="img"></div>
            <div class="box">
                <span>My Works Here!</span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_2">
            <div class="img"></div>
            <div class="box">
                <span>My Works Here!</span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_3">
            <div class="img"></div>
            <div class="box">
                <span>My Works Here!</span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_4">
            <div class="img"></div>
            <div class="box">
                <span>My Works Here!</span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_5">
            <div class="img"></div>
            <div class="box">
                <span>My Works Here!</span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_7">
            <div class="img"></div>
            <div class="box">
                <span>My Works Here!</span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_8">
            <div class="img"></div>
            <div class="box">
                <span>My Works Here!</span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_9">
            <div class="img"></div>
            <div class="box">
                <span>My Works Here!</span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_10">
            <div class="img"></div>
            <div class="box">
                <span>My Works Here!</span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_11">
            <div class="img"></div>
            <div class="box">
                <span>My Works Here!</span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_12">
            <div class="img"></div>
            <div class="box">
                <span>My Works Here!</span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_13">
            <div class="img"></div>
            <div class="box">
                <span>My Works Here!My Works Here!</span>
                <s></s>
            </div>
        </div>
        <div class="pepole p_14">
            <div class="img"></div>
            <div class="box">
                <span>My Works Here!</span>
                <s></s>
            </div>
        </div>
        <div class="icon1"></div>
        <div class="icon2"></div>
        <div class="icon3"></div>
        <div class="icon4"></div>
        <div class="icon5"></div>
        <div class="icon6"></div>
        <div class="left_arrow"><a href="gallery">画廊</a></div>
		<?php
        require($this->__RAD__ . '_avatar.php');
        ?>
        <!--向下滚动查看-->
        <div class="view_more">
            <span class="tip">向下滚动查看</span>
            <span class="arrow"></span>
        </div>
        <div class="line"></div>
    </div>
    <div class="tutorial">
        <?php
        if (count($this->tutorialRs) > 0):
            $_i = 0;
            foreach ($this->tutorialRs as $_t):
                $_c = count($_t->studyHistory);
                if ($_i % 2 == 0):
        ?>
        <a name="tutorial<?= $_t->tutorial_id ?>"></a>
        <div class="tutorial_a block" data-type="left">
            <div class="tutorial_line tutorial_1"></div>
            <div class="tutorial_line tutorial_2"></div>
            <div class="tutorial_line tutorial_3"></div>
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
                        <div class="tutorial_text">
                            <div class="tutorial_title clearboth">
                                <em><?= str_pad($_i + 1, 2, '0', STR_PAD_LEFT) ?></em>
                                <span><?= $_t->title ?></span>
                                <s></s>
                            </div>
                            <h3>已完成课时 <?= $_c ?>/<?= $_t->chapter_count ?> </h3>
                            <div class="tutorial_bar"><span style="width:<?= $_t->chapter_count > 0 ? $_c * 275 / $_t->chapter_count : 0 ?>px"></span></div>
                            <div class="desc"><?= $_t->synopsis ?></div>
                            <!--<a class="tutorial_button" href="/account/weike">继续课程</a>-->
                        </div>
                    </td>
                    <td>
                        <div class="tutorial_img">
                            <div class="img"><span><img src="<?= $this->__CDN__ ?>pics/l/<?= $_t->cover_src ?>"></span></div>
                            <div class="hots">
                                <i></i>
                                <i></i>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <div class="list clearboth">
                <ul class="tutorial_list clearboth">
                    <?php
                    if (count($_t->chapterList) > 0):
                        $_j = 1;
                        foreach ($_t->chapterList as $_cl):
                            ?>
                            <li class="complete">
                                <span class="title">Lesson <?= $_j ?></span>
                                <span class="img">
                                    <a href="/tutorial/<?= $_cl->tutorial_chapter_id ?>" target="_blank">
                                        <img src="<?= $this->__CDN__ ?>pics/s/<?= $_cl->picture ?>">
                                    </a>
                                    <?php
                                    if ($_c > 0 && in_array($_cl->tutorial_chapter_id, $_t->studyHistory)):
                                    ?>
                                    <a href="/tutorial/<?= $_cl->tutorial_chapter_id ?>" target="_blank"><i class="mask"></i></a>
                                    <?php
                                    endif;
                                    ?>
                                </span>
                                <i class="next">下一课</i>
                            </li>
                            <?php
                            $_j++;
                        endforeach;
                    endif;
                    ?>
                </ul>
            </div>
        </div>
        <?php
                    else:
        ?>
        <a name="tutorial<?= $_t->tutorial_id ?>"></a>
        <div class="tutorial_b block" data-type="right">
            <div class="tutorial_line tutorial_4"></div>
            <div class="tutorial_line tutorial_5"></div>
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
                        <div class="tutorial_img">
                            <div class="img"><span><img src="<?= $this->__CDN__ ?>/pics/l/<?= $_t->cover_src ?>"></span></div>
                            <div class="hots">
                                <i></i>
                                <i></i>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="tutorial_text">
                            <div class="tutorial_title clearboth">
                                <em><?= str_pad($_i + 1, 2, '0', STR_PAD_LEFT) ?></em>
                                <span><?= $_t->title ?></span>
                                <s></s>
                            </div>
                            <h3>已完成课时 <?= $_c ?>/<?= $_t->chapter_count ?> </h3>
                            <div class="tutorial_bar"><span style="width:<?= $_t->chapter_count > 0 ? $_c * 275 / $_t->chapter_count : 0 ?>px"></span></div>
                            <div class="desc"><?= $_t->synopsis ?></div>
                            <!--<a class="tutorial_button" href="/account/weike">继续课程</a>-->
                        </div>
                    </td>
                </tr>
            </table>
            <div class="list clearboth">
                <ul class="tutorial_list clearboth">
                    <?php
                    if (count($_t->chapterList) > 0):
                        $_j = 1;
                        foreach ($_t->chapterList as $_cl):
                    ?>
                    <li class="complete">
                        <span class="title">Lesson <?= $_j ?></span>
                        <span class="img">
                            <a href="/tutorial/<?= $_cl->tutorial_chapter_id ?>" target="_blank">
                                <img src="<?= $this->__ROOT__ . $this->__UPLOAD__ ?>/pics/s/<?= $_cl->picture ?>">
                            </a>
                            <?php
                            if ($_c > 0 && in_array($_cl->tutorial_chapter_id, $_t->studyHistory)):
                                ?>
                                <a href="/tutorial/<?= $_cl->tutorial_chapter_id ?>" target="_blank"><i class="mask"></i></a>
                            <?php
                            endif;
                            ?>
                                </span>
                        <i class="next">下一课</i>
                    </li>
                    <?php
                            $_j++;
                        endforeach;
                    endif;
                    ?>
                </ul>
            </div>
        </div>
        <?php
                    endif;
                $_i++;
            endforeach;
        endif;
        ?>
    </div>
</div>
<?php
require($this->__RAD__ . 'footer.php');
?>
<script>
	$(function(){
		fun.tutorial();	
	})
</script>
</body>
</html>