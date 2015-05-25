<script>
	$(function(){
		PageAction.editor.create(['content'], { width : '100%', height : '380px' });

		PageAction.currenPageActionClassName = '<?= $_GET['currenPageActionClassName'] ?>';
		PageAction.currenPageAction = '<?= ucfirst($_GET['action']) ?>';

		if (typeof PageAction[PageAction.currenPageActionClassName].doContentAction == 'undefined') {
			PageAction[PageAction.currenPageActionClassName].doContentAction = function() {
				var _test = Tools.checkNull('type_name', '请输入栏目名称') &&
					Tools.checkNull('sort', '栏目排序不能为空') &&
					Tools.checkDigit('sort', '排序只能填入数字');
				if (parseInt($('#type_id').val()) == 0)
					_test = _test && Tools.checkNull('list_dir', '请输入文件保存目录');
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
											+ '&parentId=' + $('#type_id').val()
											+ '&parentChannelType=' + $('#channel_type').val()
											+ '&parentIsPart=' + $(':radio[name=is_part]:checked').val()
											+ '&parentNavType=' + $(':radio[name=nav_type]:checked').val()
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
		<li>高级功能</li>
	</ul>
	<div class="switch_list">
		<table width="100%" cellpadding="0" cellspacing="0" class="data_input">
			<tr>
				<th width="15%">语言</th>
				<td width="35%"><?= \Tools\Html::radio($this->pageControl, 'ilanguage', $this->rs, $this->__LANGUAGE_CONFIG__, $this->__LANGUAGE_ID__) ?></td>
				<th width="15%">修改时间</th>
				<td><?= \Tools\Html::setDate($this->pageControl, 'release_date', \Tools\Auxi::getTime(time()), '90%') ?></td>
			</tr>
			<tr>
				<th>栏目名称</th>
				<td><?= \Tools\Html::text($this->pageControl, 'type_name', $this->rs) ?></td>
				<th>所属栏目</th>
				<td><?= $this->sltIDTree ?></td>
			</tr>
			<tr>
				<th>文件保存目录</th>
				<td colspan="3">${rootPath}<?= \Tools\Html::text($this->pageControl, 'list_dir', $this->rs, '80%') ?></td>
			</tr>
			<tr>
				<th>内容模型</th>
				<td><?= \Tools\Html::select($this->pageControl, 'channel_type', $this->rs ? $this->rs->channel_type : intval($_GET['parentChannelType']), $this->setting['aryChannelTypeMapping'][$this->__LANGUAGE_CONFIG__[$this->__LANGUAGE_ID__]], '0') ?></td>
				<th rowspan="2">类别相关图<br />
					(缩略图)</th>
				<td rowspan="2"><?= \Admin\Helper::createUpFile('img', 'type_img', $this->rs ? $this->rs->type_img : null, $this->setting['aryPicExtName'], $this->setting['aryFileExtName'], $this->__CDN__, $this->__ASSETS__) ?></td>
			</tr>
			<tr>
				<th>栏目属性</th>
				<td><?= \Tools\Html::radio($this->pageControl, 'is_part', $this->rs ? $this->rs->is_part : intval($_GET['parentIsPart']), $this->setting['aryPart'], '0', 'vertical') ?></td>
			</tr>
			<tr>
				<th>target方式</th>
				<td><?= \Tools\Html::radio($this->pageControl, 'target', $this->rs, $this->setting['aryFooterLinkTarget'], '1', 'horizontal') ?></td>
				<th>栏目排序</th>
				<td><?= \Tools\Html::text($this->pageControl, 'sort', $this->rs ? $this->rs : $this->getSort) ?></td>
			</tr>
			<tr>
				<th>主导航副导航</th>
				<td><?= \Tools\Html::radio($this->pageControl, 'nav_type', $this->rs ? $this->rs->nav_type : intval($_GET['parentNavType']), $this->setting['aryNavType'], '0', 'horizontal') ?></td>
				<th>是否显示</th>
				<td><?= \Tools\Html::radio($this->pageControl, 'is_display', $this->rs, $this->setting['aryDisplay'], '1', 'horizontal') ?></td>
			</tr>
			<tr>
				<th>Seo Title</th>
				<td colspan="3"><?= \Tools\Html::text($this->pageControl, 'seo_title', $this->rs) ?></td>
			</tr>
			<tr>
				<th>Seo Keywords</th>
				<td colspan="3"><?= \Tools\Html::textarea($this->pageControl, 'seo_keywords', $this->rs) ?></td>
			</tr>
			<tr>
				<th>Seo Description</th>
				<td colspan="3"><?= \Tools\Html::textarea($this->pageControl, 'seo_description', $this->rs) ?></td>
			</tr>
		</table>
	</div>
	<div class="switch_list hide">
		<table width="100%" cellpadding="0" cellspacing="0" class="data_input">
			<tr>
				<th width="15%">栏目内容</th>
				<td height="380"><?= \Tools\Html::editor($this->pageControl, 'content', $this->rs) ?></td>
			</tr>
		</table>
	</div>
</div>
