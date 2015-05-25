<?php
$_currenPageActionClassName = str_replace(' ', '_', ucwords(str_replace('/', ' ', $this->__REQUEST_MAPPING__)));
$_winParameter = "?parentPageId=$this->pageId&currenPageActionClassName=$_currenPageActionClassName";
?>
<script>
    $(function(){
        PageAction.currenPageActionClassName = '<?= $_currenPageActionClassName ?>';
        if (typeof PageAction[PageAction.currenPageActionClassName] == 'undefined') {
            PageAction[PageAction.currenPageActionClassName] = function() {
                var _addEditPage = PageAction.pack + '<?= $this->__REQUEST_MAPPING__ ?>Content<?= $_winParameter ?>';
                return {
                    grid : '#<?= $_GET['divId'] ?> .data_grid_wrapper',
                    addEditPage : _addEditPage,
                    handlerUrl : PageAction.handlerRoot + 'handler/Admin.<?= str_replace('_', '.', $_currenPageActionClassName) . '.' ?>',
                    init : function() {
                        var _g = this.grid;
                        $(':input[type=submit]', _g).click(function(){
                            Navigation.getSearchData(_g);
                        });
                        this.read();
                    },
                    read : function() {
                        $(this.grid).dataGrid({
                            url      : this.handlerUrl + 'Read',
//                            params   : [ { name : 'tcq_id', value : '1' } ],
                            sortName : 'a.release_date',
                            sortOrder: 'ASC',
                            rp : 50,
                            buttons  : [
                                <?= \Tools\Auxi::getPowerButton('add', $this->security, $this->pageId, $this->adminPower, substr($this->adminMap[$this->security]['menu'][$this->pageId]['name'], 0, -6)) ?>
                                {name:'刷 新', bclass:'refresh', onpress:Navigation.getSearchData},
                                {separator:true},
                                {name:'全 选', bclass:'set_all'},
                                {name:'反 选', bclass:'set_inv', margin:true},
                                {separator:true}
                                <?= \Tools\Auxi::getPowerButton('delete', $this->security, $this->pageId, $this->adminPower, '删 除') ?>
                            ],
                            colModel : [
                                {display:'ID', name:'a.tutorial_chapter_id', width:30, align:'center', css:'num'},
                                {display:'所属章节', name:'a.tutorial_id', width:200, align:'left'},
                                {display:'问题', width:200, align:'left'},
                                {display:'答案', align:'center'},
                                {display:'发布时间', name:'a.release_date', width:120, align:'center', css:'num'}
                            ],
                            height:-12,
                            useSelect : true
                            <?= \Tools\Auxi::getPowerButton('edit', $this->security, $this->pageId, $this->adminPower) ?>
                        });
                    },
                    add : function(t) {
                        Tools.addEditPageLoad(_addEditPage + '&action=add', 700);
                    },
                    edit : function(t) {
                        Tools.addEditPageLoad(_addEditPage + '&action=edit&id=' + t, 700);
                    }
                }
            }();
            PageAction[PageAction.currenPageActionClassName].init();
        }
    });
</script>

<div class="data_grid_wrapper">
    <div class="control_wrapper">
        <div class="tl"></div>
        <div class="top_control">
            <div class="left"><?= $this->adminMap[$this->security]['title'] ?> » <?= $this->adminMap[$this->security]['menu'][$this->pageId]['name'] ?></div>
            <div class="control_btn"></div>
        </div>
        <div class="tr"></div>
    </div>
    <div class="grid_wrapper">
        <div class="m_search_field">
            <form name="search_from" onsubmit="return false;">
                <?= \Admin\Helper::getDefaultSearchInfo($this->__LANGUAGE_CONFIG__) ?>
            </form>
        </div>
    </div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="data_grid">
        <tbody>
        </tbody>
    </table>
</div>
