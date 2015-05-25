<script>
    $(function(){
        PageAction.editor.create(['info'], { width : '100%', height : '320px' });

        PageAction.currenPageActionClassName = '<?= $_GET['currenPageActionClassName'] ?>';
        PageAction.currenPageAction = '<?= ucfirst($_GET['action']) ?>';

        if (typeof PageAction[PageAction.currenPageActionClassName].doContentAction == 'undefined') {
            PageAction[PageAction.currenPageActionClassName].doContentAction = function() {
                var _test = Tools.checkNull('chapter_name', '请输入标题');
                if (_test) {
                    $.dialog.locking('系统已启动，请稍候。。。');

                    PageAction.editor.sync();

                    var _this = this;
                    $.post(this.handlerUrl + PageAction.currenPageAction,
                        Tools.addEditPageLoader().DOM.form.serializeArray(),
                        function(data) {
                            switch (data.status) {
                                case 'SUCCESS' :
                                    $(_this.grid).dataGridReload();

                                    $.dialog.locking.confirm('success', '编辑成功，您还需要继续添加吗？', function(){

                                        Tools.addEditPageLoader()
                                            .resetConfig({
                                                content : 'load:' + _this.addEditPage + '&action=add'
                                                + '&parentId=' + $('#tutorial_id').val()
                                            }, true);

                                        return true;
                                    }, function(){
                                        Tools.addEditPageLoader().close();
                                        return true;
                                    });

                                    break;
                                case 'NO_CHANGES' :
                                    $.dialog.locking.alert('ndash', data.desc);
                                    break;
                                case 'DB_ERROR' :
                                case 'INTERCEPTOR' :
                                    $.dialog.locking.alert('error', data.desc);
                                    break;
                                default :
                                    $.dialog.locking.alert('error', '系统繁忙，请稍候再试');
                                    break;
                            }
                        }, 'json');
                }
            };
        }

        Tools.addEditPageLoader()
            .title('<?= $this->adminMap[$this->security]['title'] ?> » <?= $this->adminMap[$this->security]['menu'][$_GET['parentPageId']]['name'] ?> » <?= \Admin\Helper::getActionName($_GET['action']) ?>');

        <?php
        if ($this->pageControl) {
        ?>
        Tools.addEditPageLoader().button({
            id : 'ok',
            name : Tools.addEditPageLoader().config.okVal,
            callback : function(){

                PageAction[PageAction.currenPageActionClassName]
                    .doContentAction
                    .call(PageAction[PageAction.currenPageActionClassName]);

                return false;
            },
            unshift : true,
            type : 'submit',
            focus: true
        });
        <?php
        }
        ?>
        Tools.switchDiv('.switch > ul > li', 'slt_switch', '.switch_list');
    });
</script>

<input type="hidden" name="id" id="id" value="<?= $_GET['id'] ?>">
<div class="switch">
    <ul>
        <li class="slt_switch">基本信息</li>
        <li>详细说明</li>
    </ul>
    <div class="switch_list">
        <table width="100%" cellpadding="0" cellspacing="0" class="data_input">
            <tr>
                <th width="15%">所属单元</th>
                <td width="35%"><?= \Tools\Html::select($this->pageControl, 'tutorial_id', $this->rs ? $this->rs->tutorial_id : $_GET['parentId'], $this->aryTutorial, '0') ?></td>
                <th width="15%">发布时间</th>
                <td><?= \Tools\Html::setDate($this->pageControl, 'release_date', \Tools\Auxi::getTime($this->rs ? $this->rs->release_date : time()), '90%') ?></td>
            </tr>
            <tr>
                <th>章节名称</th>
                <td colspan="3"><?= \Tools\Html::text($this->pageControl, 'chapter_name', $this->rs) ?></td>
            </tr>
            <tr>
                <th>封面图</th>
                <td><?= \Admin\Helper::createUpFile('img', 'picture', $this->rs ? $this->rs->picture : null, $this->setting['aryPicExtName'], $this->setting['aryFileExtName'], $this->__CDN__, $this->__ASSETS__) ?></td>
                <th>视频文件</th>
                <td><?= \Admin\Helper::createUpFile('file', 'video_src', $this->rs ? $this->rs->video_src : null, $this->setting['aryPicExtName'], $this->setting['aryFileExtName'], $this->__CDN__, $this->__ASSETS__) ?></td>
            </tr>
            <tr>
                <th>附件</th>
                <td colspan="3"><?= \Admin\Helper::createUpFile('file', 'attach_src', $this->rs ? $this->rs->attach_src : null, $this->setting['aryPicExtName'], $this->setting['aryFileExtName'], $this->__CDN__, $this->__ASSETS__, 'fileNameNormal') ?></td>
            </tr>
            <tr>
                <th>卡片正面</th>
                <td><?= \Admin\Helper::createUpFile('img', 'card_front', $this->rs ? $this->rs->card_front : null, $this->setting['aryPicExtName'], $this->setting['aryFileExtName'], $this->__CDN__, $this->__ASSETS__) ?></td>
                <th>卡片背面</th>
                <td><?= \Admin\Helper::createUpFile('img', 'card_back', $this->rs ? $this->rs->card_back : null, $this->setting['aryPicExtName'], $this->setting['aryFileExtName'], $this->__CDN__, $this->__ASSETS__) ?></td>
            </tr>
            <tr>
                <th>相关作品</th>
                <td colspan="3"><?= \Tools\Html::text($this->pageControl, 'opus_example', $this->rs) ?></td>
            </tr>
        </table>
    </div>
    <div class="switch_list hide">
        <table width="100%" cellpadding="0" cellspacing="0" class="data_input">
            <tr>
                <th width="15%">详细说明</th>
                <td height="320"><?= \Tools\Html::editor($this->pageControl, 'info', $this->rs) ?></td>
            </tr>
        </table>
    </div>
</div>