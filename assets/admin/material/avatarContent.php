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
                                                + '&parentId=' + $('#parts').val()
                                                + '&level=' + $('#level').val()
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

        $('#parts').change(function(){
            var _i = $(this).val() >> 0;
            switch (_i) {
                case 2:
                    $('#dl_front > dl').show();
                    $('#dl_left > dl, #dl_right > dl, #dl_rear > dl').hide();
                break;
                case 1:
                    $('#dl_front > dl, #dl_left > dl, #dl_right > dl').show();
                    $('#dl_rear > dl').hide();
                    break;
                case 0:
                case 3:
                    $('#dl_front > dl, #dl_rear > dl').show();
                    $('#dl_left > dl, #dl_right > dl').hide();
                break;
            }
        }).triggerHandler('change');
    });
</script>

<input type="hidden" name="id" id="id" value="<?= $_GET['id'] ?>">
<table width="100%" cellpadding="0" cellspacing="0" class="data_input">
    <tr>
        <th width="15%">类别</th>
        <td width="35%"><?= \Tools\Html::select($this->pageControl, 'parts', $this->rs ? $this->rs->parts : $_GET['parentId'], $this->setting['aryParts'], 'hair') ?></td>
        <th width="15%">level</th>
        <td><?= \Tools\Html::select($this->pageControl, 'level', $this->rs ? $this->rs->level : $_GET['level'], $this->setting['aryLevel'], '0') ?></td>
    </tr>
    <tr>
        <th>标题</th>
        <td colspan="3"><?= \Tools\Html::text($this->pageControl, 'title', $this->rs) ?></td>
    </tr>
    <tr>
        <th style="height:105px"><?= $this->setting['aryMaterial'][0] ?></th>
        <td id="dl_front"><?= \Admin\Helper::createUpFile('img', 'src_front', $this->rs ? $this->rs->src_front : null, $this->setting['aryPicExtName'], $this->setting['aryFileExtName'], $this->__CDN__, $this->__ASSETS__) ?></td>
        <th><?= $this->setting['aryMaterial'][1] ?></th>
        <td id="dl_rear"><?= \Admin\Helper::createUpFile('img', 'src_rear', $this->rs ? $this->rs->src_rear : null, $this->setting['aryPicExtName'], $this->setting['aryFileExtName'], $this->__CDN__, $this->__ASSETS__) ?></td>

    </tr>
    <tr>
        <th><?= $this->setting['aryMaterial'][2] ?></th>
        <td id="dl_left"><?= \Admin\Helper::createUpFile('img', 'src_left', $this->rs ? $this->rs->src_left : null, $this->setting['aryPicExtName'], $this->setting['aryFileExtName'], $this->__CDN__, $this->__ASSETS__) ?></td>
        <th style="height:105px"><?= $this->setting['aryMaterial'][3] ?></th>
        <td id="dl_right"><?= \Admin\Helper::createUpFile('img', 'src_right', $this->rs ? $this->rs->src_right : null, $this->setting['aryPicExtName'], $this->setting['aryFileExtName'], $this->__CDN__, $this->__ASSETS__) ?></td>
    </tr>
</table>
