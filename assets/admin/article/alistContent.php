<script>
	$(function(){
		PageAction.editor.create(['content'], { width : '100%', height : '320px' });

		PageAction.currenPageActionClassName = '<?= $_GET['currenPageActionClassName'] ?>';
		PageAction.currenPageAction = '<?= ucfirst($_GET['action']) ?>';

		if (typeof PageAction[PageAction.currenPageActionClassName].doContentAction == 'undefined') {
			PageAction[PageAction.currenPageActionClassName].doContentAction = function() {
				var _test = Tools.checkNull('article_title', '请输入信息标题') &&
					Tools.compare('type_id', 0, '请选择所属类别') &&
					Tools.checkDigit('view_count', '点击率只能输入数字');
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

		$('.tags > ol > li > span').click(function(){
			var _articleTags = $('#article_tags').val();
			var _tag = $(this).text();

			if (_articleTags.indexOf(_tag) == -1) {
				if ($.trim(_articleTags).length > 0) {
					_articleTags += ',';
				}
				_articleTags += _tag;
			}
			$('#article_tags').val(_articleTags);
		});
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
				<th>信息标题</th>
				<td><?= \Tools\Html::text($this->pageControl, 'article_title', $this->rs) ?></td>
				<th>所属类别</th>
				<td><?= $this->sltIDTree ?></td>
			</tr>
			<tr>
				<th>信息描述</th>
				<td><?= \Tools\Html::textarea($this->pageControl, 'synopsis', $this->rs, null, 5, null, ' onpropertychange="if(value.length>200) value=value.substr(0,200)"') ?></td>
				<th>信息相关图<br />
					(缩略图)</th>
				<td><?= \Admin\Helper::createUpFile('img', 'article_img', $this->rs ? $this->rs->article_img : null,
                        $this->setting['aryPicExtName'], $this->setting['aryFileExtName'], $this->__CDN__, $this->__ASSETS__) ?></td>
			</tr>
			<tr>
				<th>点击率</th>
				<td><?= \Tools\Html::text($this->pageControl, 'view_count', $this->rs ? $this->rs : 0) ?></td>
				<th rowspan="3">Seo Description</th>
				<td rowspan="3"><?= \Tools\Html::textarea($this->pageControl, 'seo_description', $this->rs, null, 4) ?></td>
			</tr>
			<tr>
				<th>Seo Title</th>
				<td><?= \Tools\Html::text($this->pageControl, 'seo_title', $this->rs) ?></td>
			</tr>
			<tr>
				<th>Seo Keywords</th>
				<td><?= \Tools\Html::textarea($this->pageControl, 'seo_keywords', $this->rs) ?></td>
			</tr>
		</table>
	</div>
	<div class="switch_list hide">
		<table width="100%" cellpadding="0" cellspacing="0" class="data_input">
			<tr>
				<th width="15%">文章内容</th>
				<td height="320"><?= \Tools\Html::editor($this->pageControl, 'content', $this->rs) ?></td>
			</tr>
		</table>
	</div>
</div>
