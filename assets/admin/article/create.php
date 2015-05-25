<?php
$_currenPageActionClassName = str_replace(' ', '_', ucwords(str_replace('/', ' ', $this->__REQUEST_MAPPING__)));
?>
<script>
$(function(){
	if (typeof PageAction.createSite == 'undefined') {
		PageAction.createSite = function() {
			var _grid = '#<?= $_GET['divId'] ?> .data_grid_wrapper';
			var _url = PageAction.handlerRoot + 'handler/Admin.<?= str_replace('_', '.', $_currenPageActionClassName) . '.' ?>' + 'Action';
			return {
				init : function() {
					$('#main_loading').fadeOut();
					Navigation.flushContentHeight($('.data_content_wrapper', _grid));

					var _this = this;
					$('.create_homepage', _grid).unbind('click').click(function(){_this.doAction(0)});
					$('.create_column', _grid).unbind('click').click(function(){_this.doAction(1)});
					$('.create_article', _grid).unbind('click').click(function(){_this.doAction(2)});
					$('.create_site', _grid).unbind('click').click(function(){_this.doAction(3)});
				},
				doAction : function(createType) {
					$.dialog.locking.confirm('prompt', '确定生成吗？', function(){
						$.dialog.locking('系统已启动，请稍候。。。');
						var _objCreateShow = $('.create_show', _grid);
						var _txtCreateNum = $('#txtCreateNum');
						if (!_txtCreateNum.val().isDigit() || _txtCreateNum.val() <= 1) {
							_txtCreateNum.val(20);
						}

						_objCreateShow.html('');

						var _obj = {
							createInfo : createType + '-' + (createType < 3 ? createType : 0) + '-0-0-' + _txtCreateNum.val(),
							resetAnchorText : $('#resetAnchorText').prop('checked') ? 1 : 0,
							deleteHtmlFolder : $('#deleteHtmlFolder').prop('checked') ? 1 : 0,
							createSitemap : $('#createSitemap').prop('checked') ? 1 : 0
						};
						PageAction.createSite._handler(_obj, _objCreateShow);
						return false;
					});
				},
				_progressTitle : ['首页', '栏目', '文章'],
				_handler : function(option, objCreateShow) {
					var _createInfo = option.createInfo.split('-');
					if (_createInfo[2] == 0) {
						objCreateShow.append(PageAction.createSite._progressTitle[_createInfo[1]]
							+ '生成开始。<br />');
						$.dialog.locking(PageAction.createSite._progressTitle[_createInfo[1]] + '生成开始');
					}
					$.ajax({
						type : 'post',
						url : _url,
						timeout : 30000,
						cache : false,
						async : false,
						data : option,
						dataType : 'json',
						success : function(data, textStatus) {
							if (data == '404') {
								$.dialog.locking.alert('error', '404');
								return;
							}
							switch (data.status) {
								case 'SUCCESS' :
									PageAction.createSite.errTotal = 0;//出错次数重置
									_createInfo = data.desc.split('-');
									if (_createInfo[2] == 0 && _createInfo[0] == 3) {
										objCreateShow.append(PageAction.createSite._progressTitle[_createInfo[1] - 1] + '生成完毕。<br />');
										$.dialog.locking(PageAction.createSite._progressTitle[_createInfo[1] - 1] + '生成完毕');
									}
									switch (parseInt(_createInfo[1], 10)) {
										case 2 :
										case 1 :
											if (_createInfo[3] > 0) {
												var _percentage = 100;
												if (_createInfo[1] < 3) {
													_percentage = Math.floor(_createInfo[2] * _createInfo[4] * 100 / _createInfo[3]);
													if (_percentage >= 100)
														_percentage = 100;
	
													objCreateShow.append(PageAction.createSite._progressTitle[_createInfo[1]] + '生成进度 ' + _percentage + '%。<br />');
												}
												else {
													objCreateShow.append(PageAction.createSite._progressTitle[_createInfo[1]] + '生成完毕。<br />');
												}
												$.dialog.locking(PageAction.createSite._progressTitle[_createInfo[1]] + '每次' + _createInfo[4] + '条，已生成 ' + _percentage + '%');
											}
											break;
									}
	
									if (_createInfo[1] == 3) {
										$('#resetAnchorText, #deleteHtmlFolder').prop('checked', false);
										objCreateShow.append('任务执行完毕。');
										//$.dialog.locking.alert('success', '任务执行完毕');
										$.dialog.locking.remove();
									}
									else {
										window.setTimeout(function(){
											option.createInfo = _createInfo.join('-');
											option.deleteHtmlFolder = 0;//回调后不再删除
											PageAction.createSite._handler(option, objCreateShow);
										}, 50);
									}
									break;
								case 'DB_ERROR' :
								case 'INTERCEPTOR' :
									$.dialog.locking.alert('error', data.desc);
									break;
								default :
									$.dialog.locking.alert('error', '系统繁忙，请稍候再试');
									break;
							}
						},
						error : function() {
							PageAction.createSite.errTotal++;
							if (PageAction.createSite.errTotal < 3) {
								window.setTimeout(function(){
									PageAction.createSite._handler(option, objCreateShow);
								}, 50);
							}
							else {
								$.dialog.locking.alert('error', '回调已出错' + PageAction.createSite.errTotal + '次。中止线程。');
								PageAction.createSite.errTotal = 0;
							}
						},
						complete: function (XHR, TS) { XHR = null }
					});
				}
			}
		}();
		PageAction.createSite.init();
	}
});
</script>

<div class="data_grid_wrapper">
	<div class="control_wrapper">
		<div class="tl"></div>
		<div class="top_control">
			<div class="left"><?= $this->adminMap[$this->security]['title'] ?> » <?= $this->adminMap[$this->security]['menu'][$this->pageId]['name'] ?></div>
			<div class="control_btn">
				<div class="create_homepage color_btn" title="生成首页"><span>生成首页</span></div>
				<div class="separator"></div>
				<div class="create_column color_btn" title="生成全部文章栏目"><span>生成全部文章栏目</span></div>
				<div class="separator"></div>
				<div class="create_article color_btn" title="生成全部文章"><span>生成全部文章</span></div>
				<div class="separator"></div>
				<div class="create_site color_btn" title="整站文章生成"><span>整站文章生成</span></div>
				<div class="separator"></div>
				<div class="load_state"></div>
			</div>
		</div>
		<div class="tr"></div>
	</div>
	<div class="grid_wrapper">
		<form action="" name="list_post_form" method="post" onsubmit="return false;">
			<div class="data_content_wrapper">
				<ul class="create_list">
					<li><input type="text" name="txtCreateNum" id="txtCreateNum" class="ipt" size="3" maxlength="3" value="30">每次生成条数（为避免文章过多执行超时，每次生成100以内为佳）</li>
					<li><input type="checkbox" name="resetAnchorText" id="resetAnchorText" value="1"><label for="resetAnchorText">重建锚文本</label></li>
					<li><input type="checkbox" name="deleteHtmlFolder" id="deleteHtmlFolder" value="1"><label for="deleteHtmlFolder">清空html目录</label></li>
				<li><input type="checkbox" name="createSitemap" id="createSitemap" value="1" checked="checked"><label for="createSitemap">生成sitemap</label></li>
				</ul>
				<div class="create_show"></div>
			</div>
		</form>
	</div>
</div>
