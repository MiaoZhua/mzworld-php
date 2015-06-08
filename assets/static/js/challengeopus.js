!function (window, $, undefined) {
    'use strict';
    var tmp_attach_count=0;
    window.App = {
        alert : function(msg) {
            return alert(msg);
        },
        confirm : function(msg) {
            return confirm(msg);
        },
        opus : {
            tpl : {
                auto: function(aryObj) {
                    var _out = [], _tmp, _attachId = [];
                    for (var i in aryObj) {
                        try {
                            _tmp = JSON.parse(aryObj[i]);
                        } catch (e) {
                            _tmp = aryObj[i];
                        }
                        if (_tmp.hasOwnProperty('opus_attach_id')) {
                            _attachId.push(_tmp.opus_attach_id);
                        }
                        switch (_tmp.type) {
                            case 'img' :
                                _out.push(this.img(_tmp));
                                break;
                            case 'file' :
                                _out.push(this.file(_tmp));
                                break;
                            default :
                                var _obj = {
                                    text : _tmp
                                };
                                _out.push(this.text(_obj));
                                break;
                        }
                    }
                    $('#attach-id').val(_attachId.join(','));
                    return _out.join('');
                },
                img : function(obj) {
                    if (obj == undefined) {
                        obj  = {
                            name : '',
                            src : ''
                        }
                    }

                    return '<div class="section"><div class="cont">' +
                        '<div class="thumbnail">' +
                        '<img src="' + obj.src + '">' +
                        '<s class="mask"></s><span><em>' + obj.name + '</em></span></div>' +
                        '<a class="close" href="javascript:;"></a>' +
                        '<span class="move_t"></span>' +
                        '<span class="move_b"></span>' +
                        '<div style="display:none" class="attach">' + JSON.stringify(obj) + '</div>' +
                        '</div></div>';
                },
                file : function(obj) {
                    if (obj == undefined) {
                        obj  = {
                            name : '',
                            size : 0
                        }
                    }
                    var attach_user_name='<input id="attach_user_name" name="attach_user_name" type="text" value="附件'+tmp_attach_count+'"/>' + obj.name;
                    if(obj.opus_attach_id!=undefined){
                        attach_user_name='<strong>' + obj.name + '</strong>';
                    }
                    if(obj.attach_user_name != undefined){
                        attach_user_name=obj.attach_user_name;
                    }

                    return '<div class="section"><div class="cont">' +
                        '<div class="files clearboth">' +
                        '<div class="files-box clearboth">' +
                        '<span class="icon"></span>' +
                        '<span class="info">' +
                        '<strong>'+attach_user_name+
                        '</strong> ' +''+ (Math.round(obj.size / 1024)) + ' KB   '+
                        '</span>' +
                        '</div></div>' +
                        '<a class="close" href="javascript:;"></a>' +
                        '<span class="move_t"></span>' +
                        '<span class="move_b"></span>' +
                        '<div style="display:none" class="attach">' + JSON.stringify(obj) + '</div>' +
                        '</div></div>';
                },
                text : function (obj) {
                    if (obj == undefined) {
                        obj  = {
                            text : ''
                        }
                    }
                    return '<div class="section"><div class="cont">' +
                        '<div class="post_textarea">' +
                        '<div class="title" style="border-bottom: 1px solid #ccc;padding-bottom: 12px;margin-bottom: 12px;"><input class="challenge-description-title" style="background: none;border: none;width: 100%;font: bold 34px \'gothamroundedbook\',\'幼圆\',\'Hiragino Sans GB W3\';" placeholder="在此输入描述标题" /></div><textarea class="textarea opus-text" rows="1" placeholder="在此输入描述文本">' + obj.text + '</textarea>' +
                        '</div>' +
                        '<a class="close" href="javascript:;"></a>' +
                        '<span class="move_t"></span>' +
                        '<span class="move_b"></span>' +
                        '</div></div>';
                }
            },
            out : {
                auto : function(obj) {
                    if (obj.type == 'img') {
                        return this.img(obj);
                    }
                    return this.file(obj);
                },
                img : function(obj) {
                    return '<div class="thumbnail" style="margin-bottom:30px;"><div class="cont"><img src="'
                        + obj.cdn + obj.path + '/' + obj.name + '"></div></div>';
                },
                file : function(obj) {
                    return '<div class="files clearboth" style="margin-bottom:30px;">' +
                        '<a class="files-box clearboth" href="' + obj.cdn + obj.path + '/' + obj.name + '" target="_blank">' +
                        '<span class="icon"></span>' +
                        '<span class="info">' +
                        '<strong>'+obj.name+'</strong> ' + (Math.round(obj.size / 1024)) + ' KB </span>' +
                        '</a>' +
                        '</div>';
                },
                text : function(text) {
                    return '<div class="desc">' + text + '</div>';
                }
            },
            init : function() {
                $('#btn-attach-text').click(function(){
                    $('#attach-area').append(App.opus.tpl.text());
                    $(".section textarea").each(function(index, element) {
                        $(this).autoTextarea({maxHeight:1500});
                    });
                });
                $('#attach-img, #attach-file, #sb-file').change(function(){
                    App.opus.ajaxUp($(this).attr('id'), 'fileNormal');
                });
                $('#sb-thumb').change(function(){
                    App.opus.ajaxUp($(this).attr('id'), 'uuid');
                });
                $('#close-cover').click(function(){
                    $('#sb-src, #sb-cover').val('');
                    $('#sb-cover-container').hide();
                });
                App.opus.remove();
                App.opus.post();
                if ($('#edit-json').html().length > 0) {
                    $('#attach-area').html(App.opus.tpl.auto(JSON.parse($('#edit-json').html())));
                }
            },
            remove : function() {
                $('#btn-delete').unbind('click').click(function () {
                    var _img='<img src="'+$("#sb-cover-container .img img").attr("src")+'" >';
                    var _title=$(".upload_title").val();
                    var _praise=$(this).data("praise");
                    $(".delete_opus,.layer_mask").show();
                    $(".delete_opus em.text").text(_title);
                    $(".delete_opus em.num").text(_praise);
                    $(".delete_opus span.img").html(_img);
                });
                $(".delete_opus .dissolve_btn").click(function(){
                    $(".delete_opus,.layer_mask").hide();
                    $.post('/api/account/opus/remove', {
                        opusId : $('#opus-id').val()
                    }, function(data){
                        switch (data.status) {
                            case 'SUCCESS' :
                                //App.alert('success');
                                fun.right_tip('删除成功！');
                                window.location.href = '/account';
                                break;
                            default :
                                //App.alert('删除出错');
                                fun.error_tip('删除出错！');
                                break;
                        }
                    }, 'json');
                    return false;
                });
                $(".delete_opus .cancel_btn").click(function(){
                    $(".delete_opus,.layer_mask").hide();
                });
            },
            post : function() {
                $('#btn-opus').unbind('click').click(function () {
                	var selecttoarr=$('.select_cur');
                	
                	
                	
                	var ispasspost=1;//通过
                	
                    if ($('#title').val().length == 0) {
                        //App.alert('作品标题不能位空');
                        fun.error_tip('作品标题不能为空！');
                        $('#title').focus();
                        ispasspost=0;//不通过
                    }else if ($('#opus-id').val().length == 0 && $('#sb-src').html().length == 0) {
                        //App.alert('');
//                    	if($.trim($('#sb-challenge_id').val())>0){//从召集里面发布作品
                    		fun.error_tip('请上传sb2, sb, zip, rar, doc, docx, pdf, xlsx, mp4, flv, ppt, pptx文件!');
//                    	}else{
//                    		fun.error_tip('请上传sb2, sb文件!');
//                    	}
                    	ispasspost=0;//不通过
                        $('#title').focus();
                    }else if (selecttoarr.length == 0) {
//                    	if($.trim($('#sb-challenge_id').val())>0){//从召集里面发布作品
                    		fun.error_tip('请选择发布到哪儿');
                    		$('#selectinputto').focus();
                    		ispasspost=0;//不通过
//                    	}
                    }else if ($('#zuopinmemberstr').val() == "") {
                    	if($.trim($('#sb-challenge_id').val())>0){//从召集里面发布作品
	                        fun.error_tip('请添加成员');
	                        $('#zuopinmemberstr').focus();
	                        ispasspost=0;//不通过
                    	}
                    }
                    //else if ($('#sb-cover').html().length == 0) {
                    //  App.alert('请上传封面图片');
                    //  $('#title').focus();
                    //}
                    else {
                        
                    }
                    
                    if(ispasspost==1){//通过
                    	var _flag = true;
                        if ($('#attach-area > .section .textarea').length > 0) {
                            $('#attach-area > .section .textarea').each(function(){
                                if ($.trim($(this).val()).length == 0) {
                                    //App.alert('请将描述补充完整');
                                    fun.error_tip('请将描述补充完整!');
                                    $(this).focus();
                                    _flag = false;
                                    return false;
                                }
                            });
                        }
                        
                        if (_flag) {
                            var _data = App.opus.postData();
                            
//                            alert(_data.type_id);

                            $.post('/api/account/opus/save', _data, function(data){
//                            	  alert(data);
                                switch (data.status) {
                                    case 'SUCCESS' :
                                        fun.right_tip('发布作品成功!');
                                        var goto=true;
                                        if(goto){
                                            $(".right_tip .submit,.right_tip .tclose").click(function(){
                                            	if($.trim($('#sb-challenge_id').val())>0){//从召集里面发布作品
                                            		if($.trim($('#selectinputto').val())==3){
                                            			window.location.href = '/challenge/'+$('#sb-challenge_id').val()+'?from=yplan';
                                            		}else if($.trim($('#selectinputto').val())==2){
                                            			window.location.href = '/challenge/'+$('#sb-challenge_id').val()+'?from=gallery';
                                            		}else{
                                            			window.location.href = '/challenge/'+$('#sb-challenge_id').val()+'?from=account';
                                            		}
                                            	}else{
                                            		window.location.href = '/account';
                                            	}
                                                goto=false;
                                            });
                                        }
                                        setTimeout(function(){
                                        	$(".right_tip,.layer_mask").hide();
                                        	if($.trim($('#sb-challenge_id').val())>0){//从召集里面发布作品
                                        		if($.trim($('#selectinputto').val())==3){
                                        			window.location.href = '/challenge/'+$('#sb-challenge_id').val()+'?from=yplan';
                                        		}else if($.trim($('#selectinputto').val())==2){
                                        			window.location.href = '/challenge/'+$('#sb-challenge_id').val()+'?from=gallery';
                                        		}else{
                                        			window.location.href = '/challenge/'+$('#sb-challenge_id').val()+'?from=account';
                                        		}
                                        	}else{
                                        		window.location.href = '/account';
                                        	}
                                        },3000);
                                        break;
                                    default :
                                        fun.error_tip(data.desc+'!');
                                        break;
                                }
                            }, 'json');
                        }
                    }
                });
            },
            postData : function () {
                var _data = {};
                _data.title = $.trim($('#title').val());
                _data.thumbJson = $('#sb-cover').html();
                _data.sb2SrcJson = $('#sb-src').html();
                _data.attach = [];
                _data.detail = '';
                _data.opus_id = $.trim($('#opus-id').val());
                _data.attachId = $.trim($('#attach-id').val());
                if ($('#attach-area > .section').length > 0) {
                    $('#attach-area > .section').each(function(){
                        if ($(this).find('.attach').length > 0) {
                            var _json = JSON.parse($(this).find('.attach').html());
                            //_data.detail += App.opus.out.auto(_json);
                            $(this).find('.attach').html(JSON.stringify($.extend(_json,{"attach_user_name":$(this).find("#attach_user_name").val()})));
                            _data.detail += App.opus.out.auto(JSON.parse($(this).find('.attach').html()));
                            _data.attach.push($(this).find('.attach').html());
                        } else {
                            _data.detail += App.opus.out.text($(this).find('.textarea').val());
                            _data.attach.push($(this).find('.textarea').val());
                        }
                    });
                }
                _data.tag = $.trim($('#sb-tag').val());
                _data.type_id = $.trim($('#sb-challenge_id').val());
                _data.issue_to = $.trim($('#selectinputto').val());
                _data.relativeuid = $.trim($('#zuopinmemberstr').val());
                
                return _data;
            },
            match : function(value, ext) {
                var regx = new RegExp('\\.' + ext + '$', 'i');
                return regx.test(value);
            },
            ajaxUp : function (fileId, mode) {
                var _fileValue = $('#' + fileId).val();
                switch (fileId) {
                    case 'sb-file':
//                    	if($.trim($('#sb-challenge_id').val())>0){//从召集里面发布作品
                    		if (this.match(_fileValue, 'sb2')) {
                            	
                            }else if (this.match(_fileValue, 'sb')) {
                            	
                            }else if (this.match(_fileValue, 'zip')) {
                            	
                            }else if (this.match(_fileValue, 'rar')) {
                            	
                            }else if (this.match(_fileValue, 'doc')) {
                            	
                            }else if (this.match(_fileValue, 'docx')) {
                            	
                            }else if (this.match(_fileValue, 'pdf')) {
                            	
                            }else if (this.match(_fileValue, 'xlsx')) {
                            	
                            }else if (this.match(_fileValue, 'mp4')) {
                            	
                            }else if (this.match(_fileValue, 'flv')) {
                            	
                            }else if (this.match(_fileValue, 'ppt')) {
                            	
                            }else if (this.match(_fileValue, 'pptx')) {
                            	
                            }else{
                            	 fun.error_tip('上传的作品文件必须为sb2, sb, zip, rar, doc, docx, pdf, xlsx, mp4, flv, ppt, pptx格式，<br>请重新上传正确格式的文件！');
                                 return;
                            }
//                    	}else{
//                    		if (this.match(_fileValue, 'sb2')) {
//                            	
//                            }else if (this.match(_fileValue, 'sb')) {
//                        	
//                          }else{
//                            	 fun.error_tip('上传的作品文件必须为sb2, sb格式，<br>请重新上传正确格式的文件！');
//                                 return;
//                            }
//                    	}
                        
                        break;
                    case 'attach-img':
                    case 'sb-thumb':
                        if (!this.match(_fileValue, '((jpg)|(jpeg)|(png))')) {
                            fun.error_tip('图片只能为jpg或png格式！');
                            return;
                        }
                        break;
                    case 'attach-file':
                        if (!this.match(_fileValue, '((zip)|(rar))')) {
                            fun.error_tip('附件格式只能为zip或rar格式！');
                            return;
                        }
                        break;
                }
                $('#opus-loading').show().addClass("animate-loading");
                $.ajaxFileUpload({
                    url: 'http://localhost/mzworld/?c=welcome&m=upfile',
                    type: 'post',
                    data: { mode : mode },
                    //secureuri: false,
                    fileElementId: fileId,
                    dataType: 'json',
                    success: function (data, status) {
                    	alert(12);
                        $('#opus-loading').removeClass("animate-loading").fadeOut(300);
                        switch (data.status) {
                            case 'SUCCESS' :
                                var _out = '';
                                if (data.rsp.type == 'img') {
                                    data.rsp.src = '/data/tmp/' + data.rsp.name;
                                    _out = App.opus.tpl.img(data.rsp);
                                } else {
                                    if(fileId=='attach-file'){
                                        tmp_attach_count++;
                                    }
                                    _out = App.opus.tpl.file(data.rsp);
                                }
                                switch (fileId) {
                                    case 'sb-file':
                                        $('#sb-cover-container').show();
                                        $('#sb-name').html(data.rsp.name);
                                        $('#sb-src').html(JSON.stringify(data.rsp));
                                        $('#sb-file').unbind('change').change(function(){
                                            App.opus.ajaxUp($(this).attr('id'), 'fileNormal');
                                        });
                                        break;
                                    case 'sb-thumb':
                                        $('#sb-cover').html(JSON.stringify(data.rsp));
                                        $('#sb-cover-preview').attr('src', '/data/tmp/' + data.rsp.name);
                                        $('#sb-thumb').unbind('change').change(function(){
                                            App.opus.ajaxUp($(this).attr('id'), 'uuid');
                                        });
                                        break;
                                    case 'attach-img':
                                    case 'attach-file':
                                        $('#attach-img, #attach-file').unbind('change').change(function(){
                                            App.opus.ajaxUp($(this).attr('id'), 'fileNormal');
                                        });
                                        $('#attach-area').append(_out);
                                        break;
                                }
                                break;
                            case 'ERROR':
                                //App.alert(data.desc);
                                fun.error_tip(data.desc + '!');
								 switch (fileId) {
                                    case 'sb-file':
                                        $('#sb-file').unbind('change').change(function(){
                                            App.opus.ajaxUp($(this).attr('id'), 'fileNormal');
                                        });
                                        break;
                                    case 'sb-thumb':
                                        $('#sb-thumb').unbind('change').change(function(){
                                            App.opus.ajaxUp($(this).attr('id'), 'uuid');
                                        });
                                        break;
                                    case 'attach-img':
                                    case 'attach-file':
                                        $('#attach-img, #attach-file').unbind('change').change(function(){
                                            App.opus.ajaxUp($(this).attr('id'), 'fileNormal');
                                        });
                                        $('#attach-area').append(_out);
                                        break;
                                }								
                                break;
                        }
                        $('#' + fileId).val('');
                    },
                    error: function (data, status, e) {
                    	
                        $('#opus-loading').removeClass("animate-loading").fadeOut(300);
                    }
                });
                return false;
            }
        }
    };
    App.opus.init();

}(window, jQuery);
