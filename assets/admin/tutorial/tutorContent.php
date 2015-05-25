<script>
    $(function(){
        PageAction.currenPageActionClassName = '<?= $_GET['currenPageActionClassName'] ?>';
        PageAction.currenPageAction = '<?= ucfirst($_GET['action']) ?>';

        if (typeof PageAction[PageAction.currenPageActionClassName].doContentAction == 'undefined') {
            PageAction[PageAction.currenPageActionClassName].doContentAction = function() {
                var _test = Tools.checkNull('title', '请输入标题');
                if (_test) {
                    $.dialog.locking('系统已启动，请稍候。。。');

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
                                                + '&parentId=' + $('#stage_type').val()
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
    });
</script>

<input type="hidden" name="id" id="id" value="<?= $_GET['id'] ?>">
<table width="100%" cellpadding="0" cellspacing="0" class="data_input">
    <tr>
        <th width="15%">类别</th>
        <td width="35%"><?= \Tools\Html::select($this->pageControl, 'stage_type', $this->rs ? $this->rs->stage_type : $_GET['parentId'], $this->setting['aryStageType'], '0') ?></td>
        <th width="15%">发布时间</th>
        <td><?= \Tools\Html::setDate($this->pageControl, 'release_date', \Tools\Auxi::getTime($this->rs ? $this->rs->release_date :  time()), '90%') ?></td>
    </tr>
    <tr>
        <th>标题</th>
        <td><?= \Tools\Html::text($this->pageControl, 'title', $this->rs) ?></td>
        <th rowspan="2">封面图</th>
        <td rowspan="2"><?= \Admin\Helper::createUpFile('img', 'cover_src', $this->rs ? $this->rs->cover_src : null, $this->setting['aryPicExtName'], $this->setting['aryFileExtName'], $this->__CDN__, $this->__ASSETS__) ?></td>
    </tr>
    <tr>
        <th>信息描述</th>
        <td><?= \Tools\Html::textarea($this->pageControl, 'synopsis', $this->rs, null, 5, null, ' onpropertychange="if(value.length>200) value=value.substr(0,200)"') ?></td>
    </tr>
</table>
