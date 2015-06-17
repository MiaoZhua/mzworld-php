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
            },
            match : function(value, ext) {
                var regx = new RegExp('\\.' + ext + '$', 'i');
                return regx.test(value);
            }
        }
    };
    App.opus.init();

}(window, jQuery);
