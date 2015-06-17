<?php
require($this->__RAD__ . '_head.php');
?>
<link rel="stylesheet" href="<?= $this->__STATIC__ ?>css/zi.css">
</head>
<body>
<?php
require($this->__RAD__ . 'top.php');
?>
<div class="post_overflow work_line">
    <div class="banner"></div>
    <div class="work_post_title">召集：一起玩坏马里奥</div>
    <form id="frm-opus-pos" action="" method="post">
        <input type="hidden" id="opus-id" name="opus_id" value="<?= $this->rs ? $this->rs->opus_id : '' ?>">
        <div class="work_post_cont">
            <div class="post_tree_20"></div>
            <div class="post_tree_21"></div>
            <div class="post_tree_22"></div>
            <div class="post_tree_23"></div>
            <div class="post_tree_24"></div>
            <div class="post_tree_25"></div>
            <div class="post_tree_26"></div>
            <div class="post_tree_27"></div>
            <div class="post_tree_28"></div>
            <div class="box">
                <div class="box_t"></div>
                <div class="box_c">
                    <div class="box_cont clearboth">
                        <input class="upload_title" type="text" id="title" value="<?= $this->rs ? $this->rs->title : '' ?>" placeholder="作品标题（必填）">
                        <div class="upload_cont">
                        		<input type="file" id="sb-file" name="opus-file">
                            <div class="button">
                                <span>从本地上传</span>
                                <em>文件后缀名为“.sb2, .sb, .zip, .rar, .doc, .docx, .pdf, .xlsx, .mp4, .flv, .ppt, .pptx”</em>
                                <i>不支持中文文件名，建议上传20M以内的文件</i>
                            </div>
                            <div id="sb-cover-container" class="loaded"<?= $this->rs ? '' : ' style="display: none"' ?>>
                                <div class="loaded_title">
                                    <span id="close-cover" class="close"></span><span id="sb-name"><?= $this->rs ? pathinfo($this->rs->sb2_src, PATHINFO_FILENAME) . '.sb2' : '' ?></span>
                                </div>
                                <div class="loaded_img">
                                    <span class="img">
                                        <img id="sb-cover-preview" src="<?= $this->rs && $this->rs->thumb ? $this->__CDN__ . $this->rs->thumb : $this->__STATIC__ . 'images/content/work_img2.png' ?>">
                                    </span>
                                    <span class="changebtn"><input type="file" id="sb-thumb" name="opus-file">更改封面</span>
                                    <span class="tips">尺寸限定 800x600 px</span>
                                </div>
                            </div>
                            <div id="sb-src" style="display: none"></div>
                            <div id="sb-cover" style="display: none"></div>
                            <div id="opus-loading" class="animate-loading">
                            	<span class="bar"></span>
                            	<span class="text">Updating</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box_b"></div>
            </div>
        </div>
        <div class="work_post_box">
            <table cellpadding="0" cellspacing="0" border="0" class="work_post_table">
                <tr style="display:none;">
                    <td class="td_l">发布到</td>
                    <td>
                    	<?php if($_GET['from']=='yplan'){?>
	                    	<input name="selectinputto" id="selectinputto" type="hidden" value="3"/>
	                        <div class="select" to="1"><span>空间</span></div>
	                        <div class="select" to="2"><span>画廊</span></div>
	                        <div class="select select_cur" to="3"><span>社会工作坊</span></div>
                        <?php }else if($_GET['from']=='gallery'){?>
	                    	<input name="selectinputto" id="selectinputto" type="hidden" value="2"/>
	                        <div class="select" to="1"><span>空间</span></div>
	                        <div class="select select_cur" to="2"><span>画廊</span></div>
	                        <div class="select" to="3"><span>社会工作坊</span></div>
                        <?php }else{?>
	                    	<input name="selectinputto" id="selectinputto" type="hidden" value="1"/>
	                        <div class="select select_cur" to="1"><span>空间</span></div>
	                        <div class="select" to="2"><span>画廊</span></div>
	                        <div class="select" to="3"><span>社会工作坊</span></div>
                        <?php }?>
<!--                        <div class="selectteststetste">-->
<!--                            <span class="arrow">群组</span>-->
<!--                            <div class="cont">-->
<!--                                <a href="javascript:;" style="color:#ccc; cursor:default">大同的三年二班</a>-->
<!--                                <a href="javascript:;">　迷宫宝藏　　</a>-->
<!--                                <a href="javascript:;">　三年二班　　</a>-->
<!--                                <a href="javascript:;">　默认分类　　</a>-->
<!--                                <a href="javascript:;" style="color:#ccc; cursor:default">马里奥联盟　　</a>-->
<!--                            </div>-->
<!--                        </div>-->
                    </td>
                </tr>
                <tr style="display:none;">
                    <td class="td_l"></td>
                    <td><div class="tips">至少发布到其中1项</div></td>
                </tr>
                <tr>
                    <td class="td_l">额外介绍</td>
                    <td>
                        <div class="sections" id="attach-area">
										
                        </div>
                        <ul class="buttons clearboth">
                            <li class="item"><input type="file" id="attach-img" name="opus-file"><a href="javascript:;">添加图片</a></li>
                            <li class="item2"><input type="file" id="attach-file" name="opus-file"><a href="javascript:;">添加附件</a></li>
                            <li class="item3"><a href="javascript:;" id="btn-attach-text">添加描述</a></li>
                        </ul>
                    </td>
                </tr>
                <!--<tr>
                    <td class="td_l">添加成员</td>
                    <td>
                    	<input id="zuopinmemberstr" name="zuopinmemberstr" type="hidden" value="1"/>
                        <div class="people">
                        <div class="img"></div>
	                        <div class="cont" style="width:800px;">
	                            <ul></ul>
	                            <a class="add" href="javascript:;">添加成员</a>
	                            <s></s>
	                        </div>
	                        
	                        <?php /*?><div class="cont">
	                            <ul>
	                                <li class="clearboth"><span class="face"><img src="<?= $this->__STATIC__ ?>images/content/work_post_face.png">Astronauter</span><span class="close"></span></li>
	                            </ul>
	                            <a class="add" href="javascript:;">添加成员</a>
	                            <s></s>
	                        </div><?php */?>
	                    </div>
                    </td>
                </tr>
                --><tr>
                    <td colspan="2" height="40">&nbsp;</td>
                </tr>
                <tr>
                    <td class="td_l">添加标签</td>
                    <td>
                        <input class="tag_add" type="text" id="sb-tag" name="sb-tag" value="<?= $this->rs ? $this->rs->tag : '' ?>" placeholder="最多不超过5个，空格隔开">
                        <div class="tag_tips"></div>
                    </td>
                </tr>
                <tr>
                    <td class="td_l"></td>
                    <td>
                        <div class="tag_recommend">推荐标签
                            <a href="javascript:;">游戏</a>
                            <a href="javascript:;">动画</a>
                            <a href="javascript:;">音乐</a>
                            <a href="javascript:;">美术</a>
                        </div>
                    </td>
                </tr>
                <tr style="display:none;">
                    <td class="td_l">分类</td>
                    <td>
                        <input class="challenge_id_add" type="text" id="sb-challenge_id" name="sb-challenge_id" value="<?php echo $_GET['challenge_id']?>" />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div id="edit-json" style="display:none"><?= $this->rs ? $this->rs->json : '' ?></div>
                        <input type="hidden" id="attach-id" name="attach-id" value="">
                        <?php
                        if ($this->rs):
                        ?>
                        <input class="dissolve" id="btn-delete" data-praise="<?= $this->rs->praise_count ?>" type="button" value="移除作品">
                        <?php
                        endif;
                        ?>
                        <input class="submit" id="btn-opus" type="button" value="发布作品">
                    </td>
                </tr>
                
                
                
            </table>
        </div>
    </form>
</div>
<!-------------添加成员----------->
<div class="adduser">
    <div class="tbox">
        <div class="tclose"></div>
        <input type="button" value=" " class="submit">
        <div class="tbox_t">
            <span class="title">添加成员</span>
            <div class="search"><input name="" type="text"><span class="btn"></span></div>
        </div>
        <div class="tbox_b clearboth">
<!--            <div class="tbox_b_l">-->
<!--                <ul class="list" id="add_type">-->
<!--                		<li class="cur"><i></i><span>我关注的</span><em>9</em></li>-->
<!--                    <li><i></i><span>三年二班</span><em>43</em></li>-->
<!--                    <li><i></i><span>迷宫宝藏</span><em>12</em></li>-->
<!--                </ul>-->
<!--            </div>-->
            <div class="tbox_b_r">
                <div class="scroll">
                    <ul class="list clearboth" id="add_member">
                        <li class="cur">
                            <img src="<?= $this->__STATIC__ ?>images/content/work_face_3.png" />
                            <span>Lackar</span>
                            <i style="display:none;">1</i>
                        </li>
                        <li>
                            <img src="<?= $this->__STATIC__ ?>images/content/work_face_2.png" />
                            <span>Lackar</span>
                            <i style="display:none;">2</i>
                        </li>
                        <li>
                            <img src="<?= $this->__STATIC__ ?>images/content/work_face.png" />
                            <span>Lackar</span>
                            <i style="display:none;">3</i>
                        </li>
                        <li>
                            <img src="<?= $this->__STATIC__ ?>images/content/work_face_3.png" />
                            <span>Lackar</span>
                            <i style="display:none;">4</i>
                        </li>
                        <li>
                            <img src="<?= $this->__STATIC__ ?>images/content/work_face_2.png" />
                            <span>Lackar</span>
                            <i style="display:none;">5</i>
                        </li>
                        <li>
                            <img src="<?= $this->__STATIC__ ?>images/content/work_face.png" />
                            <span>Lackar</span>
                            <i style="display:none;">6</i>
                        </li>
                        <li>
                            <img src="<?= $this->__STATIC__ ?>images/content/work_face_3.png" />
                            <span>Lackar</span>
                            <i style="display:none;">7</i>
                        </li>
                        <li>
                            <img src="<?= $this->__STATIC__ ?>images/content/work_face.png" />
                            <span>Lackar</span>
                            <i style="display:none;">8</i>
                        </li>
                        <li>
                            <img src="<?= $this->__STATIC__ ?>images/content/work_face_2.png" />
                            <span>Lackar</span>
                            <i style="display:none;">9</i>
                        </li>

                    </ul>
                </div>
                <div class="selected">已选择<span>0</span>个用户</div>
            </div>
        </div>
    </div>
</div>
<!------删除作品提示----->
<div class="delete_opus">
    <div class="tbox">
        <div class="tclose"></div>
        <div class="tbox_b clearboth">
            <div class="tbox_b_l">
                <ul class="work_list clearboth">
                    <li>
                        <span class="title clearboth">
                            <em class="text">Pixel Mount</em>
                            <em class="num">45</em>
                        </span>
                        <span class="img"><a href="/gallery/1"><img src="/assets/static/images/content/challenge_4.jpg"></a></span>
                    </li>
                </ul>
            </div>
            <div class="tbox_b_r">
                <span class="tips">确定删除作品吗？</span>
                <span class="cancel_btn">取消</span><span class="dissolve_btn">删除</span>
            </div>
        </div>
    </div>
</div>
<?php
require($this->__RAD__ . 'footer.php');
?>
<script src="<?= $this->__STATIC__ ?>js/json2.js"></script>
<script src="<?= $this->__STATIC__ ?>js/ajaxfileupload.js"></script>
<script src="<?= $this->__STATIC__ ?>js/opus.js"></script>
<script src="<?= $this->__STATIC__ ?>js/autoresize.min.js"></script>
<script>
    $(function(){
       fun.workPost();
    });
</script>
</body>
</html>