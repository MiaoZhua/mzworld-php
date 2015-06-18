$(function(){

  var Gallery = {
    holder : -1,
    cache : {
      0 : {},
      1 : {},
      2 : {}
    },
    topId : 0,
    page : 1,
    pages : 0,
    thumb : function(obj, width) {
      if (obj.thumb.length > 0) {
        return _cdn + (typeof width != 'undefined' ? obj.thumb.replace(/(\.\w+)$/i, 'x' + width + '$1') : obj.thumb);
      }
      return _cdn + 'no_img.png';
    },
    tpl : {
      top : function(obj) {
        Gallery.topId = obj.opus_id;
        return '<div class="cont">' +
          '<div class="title clearboth">' +
          '<div class="title_r"><img src="' + (_cdn + 'u/' + obj.user_id + '/avatar_front.png') + '"></div>' +
          '<div class="title_l">' +
          '<h3>' + obj.title + '</h3>' +
          '<em>' + obj.praise_count + '</em>' +
          '</div>' +
          '</div>' +
          '<div class="img">' +
          '<span><a href="/gallery/' + obj.opus_id + '" target="_blank"><img src="' + Gallery.thumb(obj) + '"></a></span>' +
          '<div class="nums colors"><i></i><i></i></div>' +
          '</div>' +
          '</div>';
      },
      list : function(obj) {
        return '<li>' +
          '<span class="title clearboth"><em class="text">' + obj.title + '</em><em class="num">'
          + obj.praise_count + '</em></span>' +
          '<span class="img"><a href="/gallery/' + obj.opus_id + '" target="_blank"><img src="'
          + Gallery.thumb(obj, 200) + '"></a></span>' +
          '<span class="nums colors"><i></i><i></i></span>' +
          '</li>';
      }
    },
    display : function(callback) {
      var _obj = Gallery.cache[Gallery.holder][Gallery.page];
      var _out = [];
      for (var i in _obj) {
        if (Gallery.page == 1 && i == 0) {
          $('#gallery-top').html(this.tpl.top(_obj[i]));
        } else {
          _out.push(this.tpl.list(_obj[i]));
        }
      }
      _out = '<ul class="work_list clearboth">' + _out.join('') + '</ul>';
      if (callback) {
        callback(_out);
      } else {
        $('#gallery-data').html(_out);
      }
    },
    read : function(callback) {
      if (_opusCount > 0) {
        if (Gallery.cache[Gallery.holder].hasOwnProperty(Gallery.page)) {
          Gallery.display(callback);
        } else {
          $.post('/api/gallery/read', {
            page : Gallery.page, order : Gallery.holder, topId : Gallery.topId
          }, function(data){
            switch (data.status) {
              case 'SUCCESS':
                Gallery.cache[Gallery.holder][Gallery.page] = data.rsp;
                Gallery.display(callback);
                break;
              default:
                Gallery.page--;
                alert(data.desc);
                break;
            }
          }, 'json');
        }
      }
    }
  };

  Gallery.pages = Math.ceil((_opusCount - 9) / 8) + 1;
  var move_num=Gallery.pages;
  var move_width=848;
  var move_count=move_num-1;
  var state=true;
  var current=0;
  $box=$('#gallery-data');
  $l_btn=$(".gallery_b_b .left_btn");
  $r_btn=$(".gallery_b_b .right_btn");
  $l_btn.addClass("left_stop");

  $('#order-type > li').each(function(i){
    $(this).click(function(){
      $(this).removeClass('cur').addClass('cur').siblings().removeClass('cur');
      if (Gallery.holder != i) {
        Gallery.holder = i;
        Gallery.page = 1;
        Gallery.read();
        state=true;

        $l_btn.removeClass('left_stop').addClass("left_stop");
        $r_btn.removeClass('right_stop').addClass("right_stop");
        if (Gallery.pages > 1) {
          $r_btn.removeClass('right_stop');
        }
      }
    });
  });
  $('#order-type > li:eq(0)').triggerHandler('click');

  $l_btn.click(function(){
    if(state==true && current>0){
      Gallery.page--;
      if (Gallery.page <= 0) {
        Gallery.page = 1;
      }

      current--;
      state=false;

      Gallery.read(function(ul){
        $box.prepend(ul).css("left",-move_width+"px");
        $box.animate({"left":"0"},{duration: 600, easing: "easeInOutCubic",complete:function(){
          $box.find("ul:last").remove();
          state=true;
        }});
      });

      if(current==0){
        $l_btn.addClass("left_stop");
      }
      $r_btn.removeClass("right_stop");
    }
  });

  $r_btn.click(function(){
    if(state==true && current<move_count) {
      Gallery.page++;
      if (Gallery.page > Gallery.pages) {
        Gallery.page = Gallery.pages;
        $r_btn.addClass("right_stop");
        return false;
      }

      current++;
      state=false;

      Gallery.read(function(ul){
        $box.append(ul);
        $box.animate({"left":-move_width+"px"},{duration: 600, easing: "easeInOutCubic",complete:function(){
          $box.find("ul:first").remove();
          $box.css("left","0");
          if (Gallery.page == Gallery.pages) {
            $r_btn.addClass("right_stop");
          }
          state=true;
        }});
      });

      if(current==move_count){
        $r_btn.addClass("right_stop");
      }
      $l_btn.removeClass("left_stop");
    }
  });


});