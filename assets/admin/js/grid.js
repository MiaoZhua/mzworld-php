/*!!!!!!!!!!!!!!!! edit below this line at your own risk !!!!!!!!!!!!!!!!!!!!!!!*/
(function(a){a.fn.removeNode=navigator.userAgent.indexOf("MSIE")!=-1?function(){var c;return this.each(function(){var d=this;if(d&&d.tagName!="BODY"){c=c||document.createElement("div");c.appendChild(d);c.innerHTML="";c.outerHTML=""}d=null})}:function(){return this.each(function(){var c=this;if(c&&c.parentNode&&c.tagName!="BODY"){c.parentNode.removeChild(c)}c=null})};a.fn.disposable=function(){if(a.browser.msie){a("*",this).add([this]).each(function(){a.event.remove(this);a.removeData(this)});a(this).html("");CollectGarbage()}return this.empty()};a.addFlex=function(f,k){if(f.grid){return false}k=a.extend({url:false,method:"POST",dataType:"json",striped:true,errorMsg:"\u6570\u636e\u8fde\u7ed3\u51fa\u9519",usePager:true,sortName:"",sortOrder:"",page:1,total:1,rp:20,rpOptions:[10,15,20,25,40],pageStat:"\u663e\u793a\u7b2c {from} \u5230\u7b2c {to} \u9879\uff0c\u5171 {total} \u9879",procMsg:"\u8fdb\u7a0b\u5904\u7406\u4e2d\uff0c\u8bf7\u7a0d\u5019...",noMsg:"\u6570\u636e\u5e93\u6ca1\u6709\u68c0\u7d22\u5230\u76f8\u5e94\u7684\u6570\u636e",height:0,dataEmptyHtml:'<p style="font-size:14px;font-weight:bold;text-align:center;">\u6570\u636e\u5e93\u6ca1\u6709\u68c0\u7d22\u5230\u76f8\u5e94\u7684\u6570\u636e</p>',useSelect:false,onRowDblclick:false,autoload:true,onSuccess:false,onSubmit:false,customAddData:false,otherCaseFunction:false,onItemDataBound:false},k);var j={addData:function(g){a(".refresh span",j.button).css("background","url("+PageAction.view+"images/refresh.gif) no-repeat 0 50%");if(k.usePager){a(".page_loader span",j.pager).css("background","url("+PageAction.view+"images/page_loader.gif) no-repeat 50% 50%")}a("#main_loading").fadeOut();this.loading=false;if(!g){if(k.usePager){a(".load_status",j.pager).html(k.errorMsg)}return false}if(k.dataType=="xml"){k.total=+a("rows rsp totalResults",g).text()}else{k.total=g.rsp.totalResults}j.refreshDataGridHeight();if(k.total==0){j.tbody.empty().append('<tr><td class="data_empty_html" style="height:'+(k._realHeight-1)+'px;">'+k.dataEmptyHtml+"</td></tr>");k.pages=1;k.page=1;if(k.usePager){this.buildPager();a(".load_status",j.pager).html(k.noMsg)}if(k.onItemDataBound){k.onItemDataBound(f)}return false}k.pages=Math.ceil(k.total/k.rp);if(k.usePager){this.buildPager()}j.tbody.empty();if(k.dataType=="json"){if(!k.customAddData){j.defaultAddData(g)}else{k.customAddData(g,k,j)}}g=null;j.hTable.width=a(j.dataGrid).width()+"px";this.addCellProp();this.addRowProp();if(k.otherCaseFunction){k.otherCaseFunction()}if(k.onItemDataBound){k.onItemDataBound(f)}if(k.onSuccess){k.onSuccess()}},defaultAddData:function(g){a.each(g.rsp.rows,function(l,n){var m=document.createElement("tr");if(l%2&&k.striped){m.className="erow"}if(n.id){m.id="row"+n.id}a("tr:first th",j.thead).each(function(o){var p=document.createElement("td");p.align=this.align;if(l==0){p.width=this.width}if(this.axis){p.className=this.axis}p.innerHTML=n.cell[o];a(m).append(p);p=null});j.tbody.append(m);m=null})},changeSort:function(g){if(this.loading){return true}if(k.sortName==a(g).attr("abbr")){if(k.sortOrder=="ASC"){k.sortOrder="DESC"}else{k.sortOrder="ASC"}}a(".sDESC",j.thead).removeClass("sDESC");a(".sASC",j.thead).removeClass("sASC");a(g).addClass("s"+k.sortOrder);k.sortName=a(g).attr("abbr");this.populate()},buildPager:function(){a(".jump_page input",j.pager).val(k.page);a(".jump_page span",j.pager).html(k.pages);var l=(k.page-1)*k.rp+1;var g=l+k.rp-1;if(k.total<g){g=k.total}var m=k.pageStat;m=m.replace(/{from}/,l);m=m.replace(/{to}/,g);m=m.replace(/{total}/,k.total);a(".load_status",j.pager).html(m)},populate:function(){if(this.loading){return true}this.loading=true;if(!k.url){return false}if(k.usePager){a(".load_status",j.pager).html(k.procMsg)}else{j.tbody.empty().append('<tr><td class="data_loading" style="height:'+(k._realHeight-1)+'px;"><img src="'+PageAction.view+'images/loading.gif" style="padding:0 9px 6px 0;" />'+k.procMsg+"</td></tr>")}a(".refresh span",j.button).css("background","url("+PageAction.view+"images/loading.gif) no-repeat 0 50%");if(k.usePager){a(".page_loader span",j.pager).css("background","url("+PageAction.view+"images/page_loading.gif) no-repeat 50% 50%")}if(!k.newp){k.newp=1}if(k.page>k.pages){k.page=k.pages}var l=[{name:"page",value:k.newp},{name:"rp",value:k.rp},{name:"sortName",value:k.sortName},{name:"sortOrder",value:k.sortOrder}];if(k.params){for(var g=0;g<k.params.length;g++){l[l.length]=k.params[g]}}a.ajax({type:k.method,url:k.url,data:l,dataType:k.dataType,success:function(m){j.addData(m)},error:function(n,m){try{if(k.onError){k.onError(n)}}catch(o){}}})},changePage:function(l){if(this.loading){return true}switch(l){case"first":k.newp=1;break;case"prev":if(k.page>1){k.newp=parseInt(k.page,10)-1}break;case"next":if(k.page<k.pages){k.newp=parseInt(k.page,10)+1}break;case"last":k.newp=k.pages;break;case"input":var g=parseInt(a(".jump_page input",this.pager).val(),10);if(isNaN(g)){g=1}if(g<1){g=1}else{if(g>k.pages){g=k.pages}}a(".jump_page input",this.pager).val(g);k.newp=g;break}if(k.newp==k.page){return false}k.page=k.newp;this.populate()},addCellProp:function(){a("tbody tr td a.mybox, tbody tr td input.mybox",j.dataGrid).each(function(){a.dialog.imgLoader(a(this))})},addRowProp:function(){a("tr",j.tbody).each(function(){if(k.useSelect){a(this).click(function(){a(this).toggleClass("tr_selected");if(k.otherCaseFunction&&!a(this).children("td:first-child").hasClass("slt_tr_show")){a(this).children("td:first-child").addClass("slt_tr_show").parent().siblings().children("td:first-child").removeClass("slt_tr_show");k.otherCaseFunction()}})}if(k.onRowDblclick){a(this).dblclick(function(){k.onRowDblclick(a(this).attr("id").substring(3))})}if(_$ie6){a(this).on({mouseenter:function(){a(this).css("background-color","#fffdd7")},mouseleave:function(){a(this).css("background-color","")}})}})},refreshDataGridHeight:function(){if(k._gridOffsetTop==undefined){k._gridOffsetTop=Math.floor(a(j.dataGrid).parent().parent().offset().top)+(k.usePager?36:8)}k._screenH=Math.floor(_$top.height()-k._gridOffsetTop);var g=0;if(k.height>0&&k.height<1){g=Math.floor(k._screenH*k.height)}else{if(k.height>1){g=k.height}else{if(k.height<0){g=k._screenH+k.height}else{g=k._screenH}}}if(k._realHeight==undefined||k._realHeight!=g){k._realHeight=g;a(j.dataGrid).parent().parent().height(k._realHeight)}}};j.bDiv=document.createElement("div");j.bDiv.className="grid_wrapper";j.button=a(".control_btn",f);j.dataGrid=a(".data_grid",f);j.tbody=a("tbody",j.dataGrid);a(j.dataGrid).wrap(j.bDiv);j.thead=document.createElement("thead");if(k.colModel){tr=document.createElement("tr");for(i=0;i<k.colModel.length;i++){var c=k.colModel[i];var h=document.createElement("th");h.innerHTML=c.display;if(c.name){a(h).attr("abbr",c.name);if(c.name==k.sortName){a(h).addClass("s"+k.sortOrder)}h.style.color="blue";h.style.cursor="pointer"}if(c.align){h.align=c.align}if(c.width){a(h).attr("width",c.width)}if(c.css){a(h).attr("axis",c.css)}a(tr).append(h);h=null;c=null}a(j.thead).append(tr);tr=null}j.hTable=document.createElement("table");j.hTable.width="100%";j.hTable.cellPadding=0;j.hTable.cellSpacing=0;j.hTable.className="data_grid";a(j.hTable).append(j.thead);a(j.dataGrid).parent().before(j.hTable);j.hDiv=document.createElement("div");j.hDiv.className="grid_wrapper";a(j.hTable).wrap(j.hDiv);a(j.hTable).wrap('<div class="grid_wrapper_inner_border"></div>');a(j.dataGrid).wrap('<div class="grid_wrapper_inner_border"></div>');j.refreshDataGridHeight();j.tbody.append('<tr><td class="data_loading" style="height:'+(k._realHeight-1)+'px;"><img src="'+PageAction.view+'images/loading.gif" style="padding:0 9px 6px 0;" />'+k.procMsg+"</td></tr>");if(k.usePager){j.pager=document.createElement("div");j.pager.className="pager";a(f).append(j.pager);a(j.pager).html('<div class="first page_btn" title="\u7b2c\u4e00\u9875"><span></span></div><div class="prev page_btn" title="\u4e0a\u4e00\u9875"><span></span></div><div class="separator"></div><div class="jump_page"> \u8df3\u8f6c	<input type="text" name="page_num" size="3" value="1" /> \u9875 \u5171 <span>1</span> \u9875 </div><div class="separator"></div><div class="next page_btn" title="\u4e0b\u4e00\u9875"><span></span></div><div class="last page_btn" title="\u6700\u540e\u4e00\u9875"><span></span></div><div class="separator"></div><div class="page_loader page_btn" title="\u5237\u65b0\u672c\u9875\u6570\u636e"><span></span></div><div class="separator"></div><div class="load_status">\u663e\u793a\u7b2c 1 \u5230\u7b2c 5 \u9879\uff0c\u5171 12 \u9879</div>');a(".page_loader",j.pager).click(function(){j.populate()});a(".first",j.pager).click(function(){j.changePage("first")});a(".prev",j.pager).click(function(){j.changePage("prev")});a(".next",j.pager).click(function(){j.changePage("next")});a(".last",j.pager).click(function(){j.changePage("last")});a(".jump_page input",j.pager).keydown(function(g){if(g.keyCode==13){j.changePage("input")}});if(_$ie6){a(".page_btn",j.pager).on({mouseenter:function(){a(this).addClass("page_btn_hover")},mouseleave:function(){a(this).removeClass("page_btn_hover")}})}a(j.pager).wrap('<div class="pager_wrapper"></div>');a(j.pager).before('<div class="fl"></div>');a(j.pager).after('<div class="fr"></div>')}else{a(f).append('<div class="pager_wrapper2"><div class="fl2"></div><div class="fc2"></div><div class="fr2"></div></div>')}if(k.buttons){for(i=0;i<k.buttons.length;i++){var e=k.buttons[i];if(!e.separator){var d=document.createElement("div");d.className="color_btn";if(_$ie6){a(d).on({mouseenter:function(){a(this).addClass("color_btn_hover")},mouseleave:function(){a(this).removeClass("color_btn_hover")}})}if(e.margin){d.style.marginLeft="12px"}d.innerHTML="<span>"+e.name+"</span>";if(e.bclass){a(d).addClass(e.bclass)}d.onpress=e.onpress;d.name=e.name;if(e.bclass=="set_all"){a(d).click(function(){a("tr",j.tbody).removeClass("tr_selected");a("tr",j.tbody).addClass("tr_selected")})}if(e.bclass=="set_inv"){a(d).click(function(){a("tr",j.tbody).toggleClass("tr_selected")})}if(d.onpress){a(d).click((function(g){return function(){this.onpress(f,g)}})(e.dbAction?e.dbAction:null))}a(j.button).append(d);d=null}else{a(j.button).append("<div class='separator'></div>")}e=null}}a("tr:first th",j.thead).each(function(){if(a(this).attr("abbr")){a(this).click(function(){j.changeSort(this)});if(a(this).attr("abbr")==k.sortName){this.className="s"+k.sortOrder}}});f.p=k;f.grid=j;j.addCellProp();j.addRowProp();if(k.url&&k.autoload){j.populate()}return f};var b=false;a(document).ready(function(){b=true});a.fn.dataGrid=function(c){return this.each(function(){if(!b){var d=this;a(document).ready(function(){a.addFlex(d,c)})}else{a.addFlex(this,c)}})};a.fn.dataGridReload=function(c){return this.each(function(){if(this.grid&&this.p.url){this.grid.populate()}})};a.fn.dataGridOptions=function(c){return this.each(function(){if(this.grid){a.extend(this.p,c)}})};a.fn.dataGridAddData=function(c){return this.each(function(){if(this.grid){this.grid.addData(c)}})}})(jQuery);