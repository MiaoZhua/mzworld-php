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
					$(':input[type=submit], :radio[name=opus_is_status]', _g).click(function(){
						Navigation.getSearchData(_g);
					});
					this.read();
				},
				read : function() {
					$(this.grid).dataGrid({
						url      : this.handlerUrl + 'Read',
                        params   : [ { name : 'opus_is_status', value : '5' } ],
						sortName : 'a.opus_id',
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
							{name:'反 选', bclass:'set_inv', margin:true},
							{separator:true}
                            <!--<?= \Tools\Auxi::getPowerButton('delete', $this->security, $this->pageId, $this->adminPower, '删 除') ?>-->
						],
						colModel : [
							{display:'ID', name:'a.opus_id', width:30, align:'center', css:'num'},
							{display:'分类', width:50, align:'center'},
							{display:'标题', width:200, align:'left'},
							{display:'缩略图', width:60, align:'center'},
							{display:'sb2文件', align:'center'},
							{display:'sb文件', align:'center'},
							{display:'浏览量', name:'a.view_count', width:50, align:'center'},
							{display:'下载量', name:'a.download_count', width:50, align:'center'},
							{display:'点赞数', name:'a.praise_count', width:50, align:'center'},
							{display:'收藏数', name:'a.favorites_count', width:50, align:'center'},
							{display:'评论数', name:'a.comment_count', width:50, align:'center'},
							{display:'landing推荐', width:80, align:'center'},
							{display:'画廊推荐', width:60, align:'center'},
							{display:'状态', width:60, align:'center'},
							{display:'发布人', width:60, align:'center'},
							{display:'添加时间', name:'a.add_date', width:120, align:'center', css:'num'}
						],
						height:-12,
						useSelect : true
						<?= \Tools\Auxi::getPowerButton('edit', $this->security, $this->pageId, $this->adminPower) ?>
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
//				add : function(t) {
//					Tools.addEditPageLoad(_addEditPage + '&action=add', 700);
//				},
//				edit : function(t) {
//					Tools.addEditPageLoad(_addEditPage + '&action=edit&id=' + t, 700);
//				}
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
                <?= \Tools\Html::radio(true, 'opus_is_status', '', $this->setting['aryStatus'], '5', 'horizontal', 'red b') ?>
            </form>
		</div>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="data_grid">
		<tbody>
		</tbody>
	</table>
</div>
