<script>
	$(function(){
		PageAction.currenPageActionClassName = '<?= $_GET['currenPageActionClassName'] ?>';
		PageAction.currenPageAction = '<?= ucfirst($_GET['action']) ?>';

		if (typeof PageAction[PageAction.currenPageActionClassName].doContentAction == 'undefined') {
			PageAction[PageAction.currenPageActionClassName].doContentAction = function() {
				var _test = Tools.checkNull('area_name', '请输入栏目名称') &&
					Tools.checkNull('sort', '栏目排序不能为空') &&
					Tools.checkDigit('sort', '排序只能填入数字');
				if (_test) {
					$.dialog.locking('系统已启动，请稍候。。。');

					var _this = this;
					$.post(this.handlerUrl + PageAction.currenPageAction,
					Tools.addEditPageLoader().DOM.form.serializeArray(),
					function(data) {
						switch (data.status) {
							case 'SUCCESS' :
								$(_this.grid).dataGridReload();

//								$.dialog.locking.confirm('success', '编辑成功，您还需要继续添加吗？', function(){
//
//									Tools.addEditPageLoader()
//									.resetConfig({
//										content : 'load:' + _this.addEditPage + '&action=add'
//											+ '&parentId=' + $('#area_id').val()
//											+ '&parentAreaTypeId=' + $('#area_type_id').val()
//									}, true);
//
//									return true;
//								}, function(){
//									Tools.addEditPageLoader().close();
//									return true;
//								});
								$.dialog.locking.remove();
								Tools.addEditPageLoader()
								.resetConfig({
									content : 'load:' + _this.addEditPage + '&action=add'
										+ '&parentId=' + $('#area_id').val()
										+ '&parentAreaTypeId=' + $('#area_type_id').val()
								}, true);

								return true;

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
		$('#area_name').focus();
		<?php
		}
		?>
	});
</script>

<input type="hidden" name="id" id="id" value="<?= $_GET['id'] ?>">
<table width="100%" cellpadding="0" cellspacing="0" class="data_input">
	<tr>
		<th width="15%">名称</th>
		<td width="35%"><?= \Tools\Html::text($this->pageControl, 'area_name', $this->rs) ?></td>
		<th width="15%">所属区域</th>
		<td><?= $this->sltIDTree ?></td>
	</tr>
	<tr>
		<th>一级首字母</th>
		<td><?= $this->rs && $this->rs->level == 1 ? \Tools\Html::text($this->pageControl, 'first_letter', $this->rs) : '' ?></td>
		<th>二级域名前缀</th>
		<td><?= \Tools\Html::text($this->pageControl, 'letter_index', $this->rs) ?></td>
	</tr>
	<tr>
		<th>行政级别</th>
		<td><?= $this->rs && $this->rs->level == 1 ? \Tools\Html::select($this->pageControl,
                'area_type_id', $this->rs ? $this->rs->area_type_id :
                (isset($_GET['parentAreaTypeId']) ? $_GET['parentAreaTypeId'] : null),
                $this->setting['aryAreaType'], '0') : '' ?></td>
		<th>排序</th>
		<td><?= \Tools\Html::text($this->pageControl, 'sort', $this->rs ? $this->rs : $this->getSort) ?></td>
	</tr>
</table>
