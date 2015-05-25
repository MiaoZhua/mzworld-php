<script>
	$(function(){
		PageAction.currenPageActionClassName = '<?= $_GET['currenPageActionClassName'] ?>';
		PageAction.currenPageAction = '<?= ucfirst($_GET['action']) ?>';

		if (typeof PageAction[PageAction.currenPageActionClassName].doContentAction == 'undefined') {
			PageAction[PageAction.currenPageActionClassName].doContentAction = function() {
				var _test = Tools.checkNull('ad_title', '请输入广告标题') &&
					Tools.checkNull('ad_url', '请输入广告链接');
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
		<th width="15%">类别</th>
		<td width="35%"><?= \Tools\Html::select($this->pageControl, 'type_id', $this->rs ? $this->rs->type_id : $_GET['parentId'], $this->setting['aryAd'], '0') ?></td>
		<th width="15%">属性</th>
		<td><?= \Tools\Html::checkbox($this->pageControl, 'is_display', $this->rs ? $this->rs->is_display : 1, '是否上架') ?></td>
	</tr>
	<tr>
		<th>广告标题</th>
		<td><?= \Tools\Html::text($this->pageControl, 'ad_title', $this->rs) ?></td>
		<th rowspan="4">广告图</th>
		<td rowspan="4"><?= \Admin\Helper::createUpFile('img', 'ad_img', $this->rs ? $this->rs->ad_img : null, $this->setting['aryPicExtName'], $this->setting['aryFileExtName'], $this->__CDN__, $this->__ASSETS__) ?></td>
	</tr>
	<tr>
		<th>链接</th>
		<td><?= \Tools\Html::text($this->pageControl, 'ad_url', $this->rs) ?></td>
	</tr>
	<tr>
		<th>开始时间</th>
		<td><?= \Tools\Html::setDate($this->pageControl, 'start_date', \Tools\Auxi::getTime($this->rs ? $this->rs->start_date : time()), '90%') ?></td>
	</tr>
	<tr>
		<th>结束时间</th>
		<td><?= \Tools\Html::setDate($this->pageControl, 'end_date', \Tools\Auxi::getTime($this->rs ? $this->rs->end_date : time()), '90%') ?></td>
	</tr>
	<tr>
		<th>排序</th>
		<td><?= \Tools\Html::text($this->pageControl, 'ad_sort', $this->rs ? $this->rs : $this->getSort) ?></td>
		<th>target</th>
		<td><?= \Tools\Html::radio($this->pageControl, 'target', $this->rs, $this->setting['aryFooterLinkTarget'], '1', 'horizontal') ?></td>
	</tr>
</table>
