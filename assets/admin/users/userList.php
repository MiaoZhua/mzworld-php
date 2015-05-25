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
                        $(':input[type=submit], :radio[name=user_is_status]', _g).click(function(){
                            Navigation.getSearchData(_g);
                        });
                        this.read();
                    },
                    read : function() {
                        $(this.grid).dataGrid({
                            url      : this.handlerUrl + 'Read',
                            params   : [ { name : 'user_is_status', value : '5' } ],
                            sortName : 'a.user_id',
                            sortOrder: 'ASC',
                            rp : 50,
                            buttons  : [
                                { name:'冻结', dbAction: { action : this.handlerUrl + 'SetFieldValue', field : 'is_status', fieldValue : 2 }, onpress:this.setFieldValue },
                                {separator:true},
                                { name:'正常', dbAction: { action : this.handlerUrl + 'SetFieldValue', field : 'is_status', fieldValue : 5 }, onpress:this.setFieldValue },
                                {separator:true},
                                {name:'刷 新', bclass:'refresh', onpress:Navigation.getSearchData},
                                {separator:true},
                                {name:'全 选', bclass:'set_all'},
                                {name:'反 选', bclass:'set_inv', margin:true}
                            ],
                            colModel : [
                                {display:'ID', name:'a.user_id', width:30, align:'center', css:'num'},
                                {display:'昵称', width:100, align:'center'},
//                                {display:'角色', name:'a.role', width:50, align:'center'},
                                {display:'等级', name:'a.level', width:50, align:'center'},
                                {display:'姓名', align:'center'},
                                {display:'email', width:150, align:'center'},
                                {display:'年龄', width:50, align:'center'},
                                {display:'性别', width:50, align:'center'},
                                {display:'学校', width:100, align:'center'},
                                {display:'身份', width:60, align:'center'},
                                {display:'总收藏数', name:'a.favorite_count', width:70, align:'center'},
                                {display:'总点赞数', name:'a.praise_count', width:70, align:'center'},
                                {display:'状态', name:'a.is_status', width:50, align:'center'},
                                {display:'注册时间', name:'a.add_date', width:120, align:'center', css:'num'}
                            ],
                            height:-12,
                            useSelect : true
                        });
                    },
                    setFieldValue : function(t, action) {
                        Tools.doLockingUpdate(t, action, [
                            '您确定更改这',
                            '个会员状态吗？',
                            'directRemoveLocking',
                            '数据库出错'
                        ]);
                    }
//                    add : function(t) {
//                        Tools.addEditPageLoad(_addEditPage + '&action=add', 700);
//                    },
//                    edit : function(t) {
//                        Tools.addEditPageLoad(_addEditPage + '&action=edit&id=' + t, 700);
//                    }
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
                <?= \Tools\Html::radio(true, 'user_is_status', '', $this->setting['aryStatus'], '5', 'horizontal', 'red b') ?>
            </form>
        </div>
    </div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="data_grid">
        <tbody>
        </tbody>
    </table>
</div>
