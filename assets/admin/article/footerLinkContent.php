<script>
	$(function(){
		PageAction.currenPageActionClassName = '<?= $_GET['currenPageActionClassName'] ?>';
		PageAction.currenPageAction = '<?= ucfirst($_GET['action']) ?>';

		if (typeof PageAction[PageAction.currenPageActionClassName].doContentAction == 'undefined') {
			PageAction[PageAction.currenPageActionClassName].doContentAction = function() {
				var _test = Tools.checkNull('keywords', '请输入关键字') &&
					Tools.checkNull('link_url', '请输入链接');
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
											+ '&parentId=' + $('#type_id').val()
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
		<th width="15%">所属类别</th>
		<td width="35%"><?= $this->sltIDTree ?></td>
		<th width="15%">关键字</th>
		<td><?= \Tools\Html::text($this->pageControl, 'keywords', $this->rs) ?></td>
	</tr>
	<tr>
		<th>链接</th>
		<td><?= \Tools\Html::text($this->pageControl, 'link_url', $this->rs) ?></td>
		<th>状态</th>
		<td><?= \Tools\Html::radio($this->pageControl, 'is_status', $this->rs, $this->setting['aryAnchorStatus'], '1', 'horizontal') ?></td>
	</tr>
	<tr>
		<th>target方式</th>
		<td><?= \Tools\Html::radio($this->pageControl, 'target', $this->rs, $this->setting['aryFooterLinkTarget'], '0', 'horizontal') ?></td>
		<th>链接类型</th>
		<td><?= \Tools\Html::radio($this->pageControl, 'link_type', $this->rs, $this->setting['aryFooterLinkType'], '0', 'horizontal') ?></td>
	</tr>
</table>
