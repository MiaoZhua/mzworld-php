/*!!!!!!!!!!!!!!!!! edit below this line at your own risk !!!!!!!!!!!!!!!!!!!!!!!*/
(function($) {
  $.fn.removeNode = navigator.userAgent.indexOf('MSIE') != -1 ? function() {//内存回收
    var d;
    return this.each(function() {
      var n = this;
      if (n && n.tagName != 'BODY') {
        d = d || document.createElement('div');
        d.appendChild(n);
        d.innerHTML = '';
        d.outerHTML = '';
      }
      n = null;
    });
  } : function() {
    return this.each(function() {
      var n = this;
      if (n && n.parentNode && n.tagName != 'BODY') {
        n.parentNode.removeChild(n);
      }
      n = null;
    });
  };
  $.fn.disposable = function() {
    if ($.browser.msie) {
      $('*', this).add([this]).each(function() {
        $.event.remove(this);
        $.removeData(this);
      });
      $(this).html('');
      CollectGarbage();
    }
    return this.empty();
  };

  $.addFlex = function(t, p) {
    if (t.grid)
      return false; //return if already exist
    // apply default properties
    p = $.extend({
      url: false, //ajax url
      method: 'POST', // data sending method
      dataType: 'json', // type of data loaded
      striped: true,
      errorMsg: '数据连结出错',
      usePager: true, //
      sortName: '',
      sortOrder: '',
      page: 1, //current page
      total: 1, //total pages
      rp: 20, // results per page
      rpOptions: [10, 15, 20, 25, 40],
      pageStat: '显示第 {from} 到第 {to} 项，共 {total} 项',
      procMsg: '进程处理中，请稍候...',
      noMsg: '数据库没有检索到相应的数据',
      height: 0,
      dataEmptyHtml: '<p style="font-size:14px;font-weight:bold;text-align:center;">数据库没有检索到相应的数据</p>',
      useSelect: false,
      onRowDblclick: false,
      autoload: true,
      onSuccess: false,
      onSubmit: false, // using a custom populate function
      customAddData: false, //增加了自定义的表格生成函数，基于json false:使用默认读取器，否则使用自定义的读取函数
      otherCaseFunction: false, //每次选择一行数据的时候执行
      onItemDataBound: false//数据绑定后执行
    }, p);
    var g = {
      addData: function(data) { //parse data
        $('.refresh span', g.button).css('background'
                , 'url(' + PageAction.view + 'images/refresh.gif) no-repeat 0 50%');
        if (p.usePager)
          $('.page_loader span', g.pager).css('background'
                  , 'url(' + PageAction.view + 'images/page_loader.gif) no-repeat 50% 50%');
        //$('#wallpaper').animate({top:'40%'}, 'slow').animate({top:'-115px', opacity:0}, 'fast');
        $('#main_loading').fadeOut();
        this.loading = false;

        if (!data) {
          if (p.usePager)
            $('.load_status', g.pager).html(p.errorMsg);
          return false;
        }


        //if (p.usePager) {
        if (p.dataType == 'xml')
          p.total = +$('rows rsp totalResults', data).text();
        else
          p.total = data.rsp.totalResults;

        g.refreshDataGridHeight();

        if (p.total == 0) {
          g.tbody.empty().append('<tr><td class="data_empty_html" style="height:' + (p._realHeight - 1) + 'px;">' + p.dataEmptyHtml + '</td></tr>');//----------------------------------------------------------------------tobdy
          p.pages = 1;
          p.page = 1;
          if (p.usePager) {
            this.buildPager();
            $('.load_status', g.pager).html(p.noMsg);
          }
          if (p.onItemDataBound)
            p.onItemDataBound(t);//没有数据也会执行一次
          return false;
        }

        p.pages = Math.ceil(p.total / p.rp);

        //				if (p.dataType == 'xml')//-------------------------------------------------------------//去掉回调中的page
        //					p.page = +$('rows page',data).text();
        //				else
        //					p.page = data.page;

        if (p.usePager)
          this.buildPager();
//				var tbody = $('tbody',g.dataGrid);//----------------------------------------------------------------------tobdy
//				tbody.empty();
        g.tbody.empty();

        if (p.dataType == 'json') {
          if (!p.customAddData)
            g.defaultAddData(data);
          else
            p.customAddData(data, p, g);
        }
        //g.tbody = null;//----------------------------------------------------------------------tobdy
        data = null;

        //g.refreshDataGridHeight();

        g.hTable.width = $(g.dataGrid).width() + 'px';
//				if (_$ie6) $(t).width($(t).width() - 2);//
        //g.hTable.width = $(g.dataGrid).width() + 'px';//---------------------------------------------------
        //if (_$ie6) $(t).width($(t).width() - 2);//-------------
        //if ($(t).height() > p.height) $(g.dataGrid).parent().height(p.height);
        this.addCellProp();
        this.addRowProp();

        if (p.otherCaseFunction)
          p.otherCaseFunction();//------------------------------------------------------------
        if (p.onItemDataBound)
          p.onItemDataBound(t);
        if (p.onSuccess)
          p.onSuccess();
      },
      defaultAddData: function(data) {//增加了自定义的表格生成函数，基于json
        $.each(data.rsp.rows, function(i, row) {
          var tr = document.createElement('tr');
          if (i % 2 && p.striped)
            tr.className = 'erow';

          if (row.id)
            tr.id = 'row' + row.id;
          //add cell
          $('tr:first th', g.thead).each(function(j) {
            var td = document.createElement('td');
            td.align = this.align;
            if (i == 0)
              td.width = this.width;
            if (this.axis)
              td.className = this.axis;
            td.innerHTML = row.cell[j];
            $(tr).append(td);
            td = null;
          });
          //$(tbody).append(tr);
          g.tbody.append(tr);//----------------------------------------------------------------------tobdy
          tr = null;
        });
      },
      changeSort: function(th) { //change sortOrder
        if (this.loading)
          return true;

        if (p.sortName == $(th).attr('abbr')) {
          if (p.sortOrder == 'ASC')
            p.sortOrder = 'DESC';
          else
            p.sortOrder = 'ASC';
        }

        $('.sDESC', g.thead).removeClass('sDESC');
        $('.sASC', g.thead).removeClass('sASC');
        $(th).addClass('s' + p.sortOrder);
        p.sortName = $(th).attr('abbr');

//				if (p.onChangeSort)
//					p.onChangeSort(p.sortName,p.sortOrder);
//				else
        this.populate();
      },
      buildPager: function() { //rebuild pager based on new properties
        //alert($(t).attr('id'));
        $('.jump_page input', g.pager).val(p.page);
        $('.jump_page span', g.pager).html(p.pages);

        var r1 = (p.page - 1) * p.rp + 1;
        var r2 = r1 + p.rp - 1;

        if (p.total < r2)
          r2 = p.total;


        var stat = p.pageStat;

        stat = stat.replace(/{from}/, r1);
        stat = stat.replace(/{to}/, r2);
        stat = stat.replace(/{total}/, p.total);

        $('.load_status', g.pager).html(stat);
      },
      populate: function() { //get latest data
        if (this.loading)
          return true;

        this.loading = true;
        if (!p.url)
          return false;

        if (p.usePager)
          $('.load_status', g.pager).html(p.procMsg);
        else
          g.tbody.empty().append('<tr><td class="data_loading" style="height:' + (p._realHeight - 1) + 'px;"><img src="' + PageAction.view + 'images/loading.gif" style="padding:0 9px 6px 0;" />' + p.procMsg + '</td></tr>');//----------------------------------------------------------------------tobdy
        $('.refresh span', g.button).css('background', 'url(' + PageAction.view + 'images/loading.gif) no-repeat 0 50%');
        if (p.usePager)
          $('.page_loader span', g.pager).css('background', 'url(' + PageAction.view + 'images/page_loading.gif) no-repeat 50% 50%');

        if (!p.newp)
          p.newp = 1;

        if (p.page > p.pages)
          p.page = p.pages;
        //var param = {page:p.newp, rp: p.rp, sortName: p.sortName, sortOrder: p.sortOrder, query: p.query, qtype: p.qtype};
        var param = [
          {name: 'page', value: p.newp}
          , {name: 'rp', value: p.rp}
          , {name: 'sortName', value: p.sortName}
          , {name: 'sortOrder', value: p.sortOrder}
        ];

        if (p.params) {
          for (var pi = 0; pi < p.params.length; pi++)
            param[param.length] = p.params[pi];
        }

        $.ajax({
          type: p.method,
          url: p.url,
          data: param,
          dataType: p.dataType,
          success: function(data) {
            g.addData(data);
          },
          error: function(data, t) {
            try {
              if (p.onError)
                p.onError(data);
            } catch (e) {
            }
          }
        });
      },
      changePage: function(ctype) { //change page
        if (this.loading)
          return true;
        switch (ctype) {
          case 'first':
            p.newp = 1;
            break;
          case 'prev':
            if (p.page > 1)
              p.newp = parseInt(p.page, 10) - 1;
            break;
          case 'next':
            if (p.page < p.pages)
              p.newp = parseInt(p.page, 10) + 1;
            break;
          case 'last':
            p.newp = p.pages;
            break;
          case 'input':
            var nv = parseInt($('.jump_page input', this.pager).val(), 10);
            if (isNaN(nv))
              nv = 1;
            if (nv < 1)
              nv = 1;
            else if (nv > p.pages)
              nv = p.pages;
            $('.jump_page input', this.pager).val(nv);
            p.newp = nv;
            break;
        }

        if (p.newp == p.page)
          return false;
        p.page = p.newp;//-----------------------------------------------------//去掉回调中的page

//				if (p.onChangePage)
//					p.onChangePage(p.newp);
//				else
        this.populate();
      },
      addCellProp: function() {
        $('tbody tr td a.mybox, tbody tr td input.mybox', g.dataGrid).each(function() {
          $.dialog.imgLoader($(this));
        });
      },
      addRowProp: function() {
        $('tr', g.tbody).each(function() {//----------------------------------------------------------------------tobdy
          if (p.useSelect) {
            $(this).click(function() {
              $(this).toggleClass('tr_selected');
              if (p.otherCaseFunction && !$(this).children('td:first-child').hasClass('slt_tr_show')) {
                $(this).children('td:first-child').addClass('slt_tr_show').parent().siblings().children('td:first-child').removeClass('slt_tr_show');
                p.otherCaseFunction();
              }
            });
          }
          if (p.onRowDblclick) {
            $(this).dblclick(function() {
              p.onRowDblclick($(this).attr('id').substring(3));
            });
          }
          if (_$ie6)
            $(this).on({
              'mouseenter': function() {
                $(this).css('background-color', '#fffdd7');
              }
              , 'mouseleave': function() {
                $(this).css('background-color', '');
              }
            });
        });
      },
      refreshDataGridHeight: function() {
        if (p._gridOffsetTop == undefined) {
          p._gridOffsetTop = Math.floor($(g.dataGrid).parent().parent().offset().top)
                  + (p.usePager ? 36 : 8);
        }

        p._screenH = Math.floor(_$top.height() - p._gridOffsetTop);//grid主显示区域高度
        var _tmpH = 0;
        if (p.height > 0 && p.height < 1) {
          _tmpH = Math.floor(p._screenH * p.height);//高度用0-1显示百分比
        } else if (p.height > 1)
          _tmpH = p.height;//指定显示高度
        else if (p.height < 0)
          _tmpH = p._screenH + p.height;//全屏显示的时候减去外层margin padding值，故应该为负数
        else
          _tmpH = p._screenH;//为0的时候得值 默认值
        if (p._realHeight == undefined || p._realHeight != _tmpH) {
          p._realHeight = _tmpH;
          $(g.dataGrid).parent().parent().height(p._realHeight);
          //---------//直角版少一层包裹--------------------------------------------
          //$(g.dataGrid).parent().height(p._realHeight);
        }
      }
    }
    g.bDiv = document.createElement('div'); //create body container
    g.bDiv.className = 'grid_wrapper';
    g.button = $('.control_btn', t);
    g.dataGrid = $('.data_grid', t);
    g.tbody = $('tbody', g.dataGrid);//----------------------------------------------------------------------tobdy
    //g.thead = $('thead',g.dataGrid);
    $(g.dataGrid).wrap(g.bDiv);
    //create model if any
    g.thead = document.createElement('thead');//--------------------
    if (p.colModel) {
      tr = document.createElement('tr');

      for (i = 0; i < p.colModel.length; i++) {
        var cm = p.colModel[i];
        var th = document.createElement('th');
        th.innerHTML = cm.display;
        if (cm.name) {
          $(th).attr('abbr', cm.name);
          if (cm.name == p.sortName)
            $(th).addClass('s' + p.sortOrder);
          th.style.color = 'blue';
          th.style.cursor = 'pointer';
        }
        if (cm.align)
          th.align = cm.align;
        if (cm.width)
          $(th).attr('width', cm.width);
        if (cm.css)
          $(th).attr('axis', cm.css);
        $(tr).append(th);
        th = null;
        cm = null;
      }
      $(g.thead).append(tr);
      tr = null;
    } // end if p.colmodel
    g.hTable = document.createElement('table');
    g.hTable.width = '100%';
    g.hTable.cellPadding = 0;
    g.hTable.cellSpacing = 0;
    //g.hTable.border = 0;
    g.hTable.className = 'data_grid';
    $(g.hTable).append(g.thead);
    $(g.dataGrid).parent().before(g.hTable);
//		//------------------------------------------------------------ create table header warp div //删去为直角版
    g.hDiv = document.createElement('div');
    g.hDiv.className = 'grid_wrapper';
    $(g.hTable).wrap(g.hDiv);
    $(g.hTable).wrap('<div class="grid_wrapper_inner_border"></div>');
    $(g.dataGrid).wrap('<div class="grid_wrapper_inner_border"></div>');
//		//---------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------//设定布局高度
    g.refreshDataGridHeight();
//		if (p.height > 0) $(g.dataGrid).parent().parent().parent().height(p.height);//指定显示高度
//		else if (p.height < 0) $(g.dataGrid).parent().parent().parent().height(_screenH + p.height);//全屏显示的时候减去外层margin padding值，故应该为负数
//		else $(g.dataGrid).parent().parent().parent().height(_screenH);//为0的时候得值 默认值

    g.tbody.append('<tr><td class="data_loading" style="height:' + (p._realHeight - 1) + 'px;"><img src="' + PageAction.view + 'images/loading.gif" style="padding:0 9px 6px 0;" />' + p.procMsg + '</td></tr>');//----------------------------------------------------------------------tobdy
    //alert(MyBox.getPageSize()[1] - getPosition($(g.dataGrid)[0]) - 36 + p.height);
    //---------------------------------------------------------------------------------------------
    if (p.usePager) {
      g.pager = document.createElement('div');
      g.pager.className = 'pager';
      $(t).append(g.pager);
      $(g.pager).html('<div class="first page_btn" title="第一页"><span></span></div><div class="prev page_btn" title="上一页"><span></span></div><div class="separator"></div><div class="jump_page"> 跳转	<input type="text" name="page_num" size="3" value="1" /> 页 共 <span>1</span> 页 </div><div class="separator"></div><div class="next page_btn" title="下一页"><span></span></div><div class="last page_btn" title="最后一页"><span></span></div><div class="separator"></div><div class="page_loader page_btn" title="刷新本页数据"><span></span></div><div class="separator"></div><div class="load_status">显示第 1 到第 5 项，共 12 项</div>');
      //g.pager = $('.pager', t);
      $('.page_loader', g.pager).click(function() {
        g.populate()
      });
      $('.first', g.pager).click(function() {
        g.changePage('first')
      });
      $('.prev', g.pager).click(function() {
        g.changePage('prev')
      });
      $('.next', g.pager).click(function() {
        g.changePage('next')
      });
      $('.last', g.pager).click(function() {
        g.changePage('last')
      });
      $('.jump_page input', g.pager).keydown(function(e) {
        if (e.keyCode == 13)
          g.changePage('input')
      });
      if (_$ie6)
        $('.page_btn', g.pager).on({
          'mouseenter': function() {
            $(this).addClass('page_btn_hover');
          }
          , 'mouseleave': function() {
            $(this).removeClass('page_btn_hover');
          }
        });
      //-----------------------------------------------------------------------------------//删去为直角版
      $(g.pager).wrap('<div class="pager_wrapper"></div>');
      $(g.pager).before('<div class="fl"></div>');
      $(g.pager).after('<div class="fr"></div>');
      //-----------------------------------------------------------------------------------
    }
//			//-----------------------------------------------------------------------------------//删去为直角版
    else {
      $(t).append('<div class="pager_wrapper2"><div class="fl2"></div><div class="fc2"></div><div class="fr2"></div></div>');
    }
    //-----------------------------------------------------------------------------------
    if (p.buttons) {
      for (i = 0; i < p.buttons.length; i++) {
        var btn = p.buttons[i];
        if (!btn.separator) {
          var btnDiv = document.createElement('div');
          btnDiv.className = 'color_btn';

          if (_$ie6)
            $(btnDiv).on({
              'mouseenter': function() {
                $(this).addClass('color_btn_hover');
              }
              , 'mouseleave': function() {
                $(this).removeClass('color_btn_hover');
              }
            });

          if (btn.margin)
            btnDiv.style.marginLeft = '12px';
          btnDiv.innerHTML = "<span>" + btn.name + "</span>";
          if (btn.bclass)
            $(btnDiv).addClass(btn.bclass);

          btnDiv.onpress = btn.onpress;
          btnDiv.name = btn.name;
          if (btn.bclass == 'set_all') {
            $(btnDiv).click(function() {
              $('tr', g.tbody).removeClass('tr_selected');//----------------------------------------------------------------------tobdy
              $('tr', g.tbody).addClass('tr_selected');//----------------------------------------------------------------------tobdy
            });
          }
          if (btn.bclass == 'set_inv') {
            $(btnDiv).click(function() {
              $('tr', g.tbody).toggleClass('tr_selected');//----------------------------------------------------------------------tobdy
            });
          }
          if (btnDiv.onpress) {
            $(btnDiv).click((function(a) {
              return function() {
                this.onpress(t, a);
              }
            })(btn.dbAction ? btn.dbAction : null));
          }
          $(g.button).append(btnDiv);
          btnDiv = null;
        }
        else {
          $(g.button).append("<div class='separator'></div>");
        }
        btn = null;
      }
    }
    //setup thead
    $('tr:first th', g.thead).each(function() {
      if ($(this).attr('abbr')) {
        $(this).click(function() {
          g.changeSort(this);
        });
        if ($(this).attr('abbr') == p.sortName)
          this.className = 's' + p.sortOrder;
      }
    });
    t.p = p;
    t.grid = g;
    g.addCellProp();
    g.addRowProp();
    // load data
    if (p.url && p.autoload) {
      g.populate();
    }
    return t;
  }
  var docloaded = false;
  $(document).ready(function() {
    docloaded = true;
  });
  $.fn.dataGrid = function(p) {
    return this.each(function() {
      if (!docloaded) {
        var t = this;
        $(document).ready(function() {
          $.addFlex(t, p);
        });
      } else {
        $.addFlex(this, p);
      }
    });
  }; //end flexigrid

  $.fn.dataGridReload = function(p) { // function to reload grid
    return this.each(function() {
      if (this.grid && this.p.url)
        this.grid.populate();
    });
  }; //end flexReload

  $.fn.dataGridOptions = function(p) { //function to update general options
    return this.each(function() {
      if (this.grid)
        $.extend(this.p, p);
    });
  }; //end flexOptions

  $.fn.dataGridAddData = function(data) { // function to add data to grid
    return this.each(function() {
      if (this.grid)
        this.grid.addData(data);
    });
  };
})(jQuery);