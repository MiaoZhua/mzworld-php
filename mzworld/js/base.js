	var isNull = /^[\s' ']*$/;
	function isEmail(email){
		var isEmail = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(email);
		if(isEmail!=true){
			return false;
		}else{
			return true;
		}
	}
var PIXELGIF="pngfix.gif";// 这个是个头1*1像素的透明gif图片，请自行建立并放在你网页的相同目录下

var arVersion = navigator.appVersion.split("MSIE");
var version = parseFloat(arVersion[1]);
var pngxp=/\.png$/i;
var AlphaPNGfix= "progid:DXImageTransform.Microsoft.AlphaImageLoader";
function fixPNGAll() {
        if(!document.all) return;
        if ((version >= 5.5 && version < 7) && (document.body.filters)) {
          for(var i=0; i<document.images.length; i++) {
                var img = document.images[i];
                if(img.src && pngxp.test(img.src)) {
                  var imgName = img.src;
                  var imgID = (img.id) ? "id='" + img.id + "' " : "";
                  var imgClass = (img.className) ? "class='" + img.className + "' " : "";
                  var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' ";
                  var imgStyle = "display:inline-block;" + img.style.cssText;
                  if (img.align == "left") imgStyle = "float:left;" + imgStyle;
                  if (img.align == "right") imgStyle = "float:right;" + imgStyle;
                  if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle;
                  var strNewHTML = "<span " + imgID + imgClass + imgTitle
                  + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
                  + "filter:" +AlphaPNGfix
                  + "(src='" + img.src + "', sizingMethod='scale');\"></span>";
                  if (img.useMap) {
                        strNewHTML += "<img style=\"position:relative; left:-" + img.width + "px;"
                        + "height:" + img.height + "px;width:" + img.width +"\" "
                        + "src=\"" + PIXELGIF + "\" usemap=\"" + img.useMap 
                        + "\" border=\"" + img.border + "\">";
                  }
                  img.outerHTML = strNewHTML;
                  i--;
                }
          }
          /* for type=image png button */
          var kmax = document.forms.length;
          for(var k=0; k<kmax; k++) {
                var fmob = document.forms[k];
                var elmarr = fmob.getElementsByTagName("input");
                var jmax = elmarr.length;
                for(var j=0; j<jmax; j++) {
                        var elmob = elmarr[j];
                        if(elmob && elmob.type=="image" && pngxp.test(elmob.src)) {
                                var origsrc = elmob.src;
                                elmob.src = PIXELGIF;
                                elmob.style.filter = AlphaPNGfix+"(src='" +origsrc +"')";
                        }
                }
          }
        }
}
// 修复 IE 下 PNG 图片不能透明显示的问题
	function fixPNG(myImage) {
	var arVersion = navigator.appVersion.split("MSIE");
	var version = parseFloat(arVersion[1]);
	if ((version >= 5.5) && (version < 7) && (document.body.filters))
	{
	     var imgID = (myImage.id) ? "id='" + myImage.id + "' " : "";
	     var imgClass = (myImage.className) ? "class='" + myImage.className + "' " : "";
	     var imgTitle = (myImage.title) ? "title='" + myImage.title   + "' " : "title='" + myImage.alt + "' ";
	     var imgStyle = "display:inline-block;" + myImage.style.cssText;
	     var strNewHTML = "<span " + imgID + imgClass + imgTitle
	
	   + " style=\"" + "width:" + myImage.width
	
	   + "px; height:" + myImage.height
	
	   + "px;" + imgStyle + ";"
	
	   + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
	
	   + "(src=\'" + myImage.src + "\', sizingMethod='scale');\"></span>";
	     myImage.outerHTML = strNewHTML;
	}} 
	        
	//输入框输入提示
	$(document).ready(function(){
	    $('input[type="text"],input[type="password"],select').focus(function(){
	    	var target_name=$(this).attr('name');
	    	$('input[type="text"],input[type="password"],select').each(function (){
				if(target_name==$(this).attr('name')){
					$("#"+$(this).attr('name')+"_tips").animate({opacity: "show"},1000)
				}else{
					$("#"+$(this).attr('name')+"_tips").animate({opacity: "hide"},1000)
				}
		    })
		});
	    $('input[type="text"],input[type="password"],select').blur(function(){
//			$("#"+$(this).attr('name')+"_tips").animate({opacity: "hide"},1000);
			$("#"+$(this).attr('name')+"_tips").hide();
		});
	})	
	
	//让IE也支持placeholder
	$(document).ready(function(){
		var doc=document;
		var inputs=doc.getElementsByTagName('input');
		var supportPlaceholder='placeholder'in doc.createElement('input');
		var placeholder=function(input){
			var text=input.getAttribute('placeholder'),defaultValue=input.defaultValue;
			if(defaultValue==''){
				input.value=text;
				$(this).css('color','gray');
			}
			input.onfocus=function(){
				if(input.value===text){
					this.value='';
					$(this).css('color','black');
				}
			};
			input.onblur=function(){
				if(input.value===''){
					this.value=text;
					$(this).css('color','gray');
				}
			}
		};
		if(!supportPlaceholder){
			for(var i=0,len=inputs.length;i<len;i++){
				var input=inputs[i],text=input.getAttribute('placeholder');
				if(input.type==='text'&&text){
					placeholder(input);
					$('input[type="text"][name="'+input.name+'"]').css('color','gray');
				}
			}
		}
	});
	
	
	//关闭按钮 X 
	function close_msg(){
		$('.notice_taball').hide();
		$('.notice_tab').hide();
		$('.message_tab').hide();
		$('.box_title').find("#title").html('');
		$('.box_content').html('<span class="loading_indicator">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>');
		$('.box_control').find("#content").html('');
	}
	
	function auto_box_location(width){
		$(".message_tab").css('width',width+'px');
		$(".message_tab").css('padding-bottom',(width*1/100)+'px');
		$(".message_tab").css('margin-left','-'+(width/2)+'px');
		$(".message_tab").css('margin-top','-'+($(".message_tab").height()/2)+'px');
		if(width>600){
			$('.box_content').css('width','94%');
			$('.box_content').css('padding','18px 2% 20px 2%');
		}else{
			$('.box_content').css('width','90%');
			$('.box_content').css('padding','18px 4% 20px 4%');
		}
	}
	
	//显示菜单
	function toshowmenu(){
		$('#area_menu').show();
		$('#area_menu').animate({'width': '100%'},500,function(){
			
		});
	}
//	
	//主页
	function tohomepage(){
		//开启语言
		$('#area_language').show();
		
		
		$('.menu_on').attr('class','menu_off');
		$('#menu_home').attr('class','menu_on');
		//关闭 About Us
		$('.area_aboutus').hide();
		//关闭Menu
		$('.area_products').hide();
		//关闭Press
		$('.area_press').hide();
		//关闭Contacts
		$('.area_contacts').hide();
		//开启相册
		$('.area_home').hide();
		$('.area_home').fadeIn(800);
	}
	
	//关于我们
	function toaboutus(){
		//关闭语言
		$('#area_language').hide();
		
		
		$('.menu_on').attr('class','menu_off');
		$('#menu_aboutus').attr('class','menu_on');
		//关闭首页
		$('.area_home').hide();
		//关闭products
		$('.area_products').hide();
		//关闭Press
		$('.area_press').hide();
		//关闭Contacts
		$('.area_contacts').hide();
		//开启关于我们
		$('.area_aboutus').hide();
		$('.area_aboutus').fadeIn(800);
	}
	//产品
	function toproducts(){
		//关闭语言
		$('#area_language').hide();
		
		$('.menu_on').attr('class','menu_off');
		$('#menu_products').attr('class','menu_on');
		//关闭首页
		$('.area_home').hide();
		//关闭About us
		$('.area_aboutus').hide();
		//关闭Press
		$('.area_press').hide();
		//关闭Contacts
		$('.area_contacts').hide();
		//开启关于我们
		$('#area_submenu').css('width','0px');
		$('#area_submenu').animate({'width': '200px'},500,function(){
			
		});
		$('.area_products').fadeIn(800,function (){
			
		});
	}
	//相册
	function topress(){
		//关闭语言
		$('#area_language').hide();
		
		$('.menu_on').attr('class','menu_off');
		$('#menu_press').attr('class','menu_on');
		//关闭首页
		$('.area_home').hide();
		//关闭About Us
		$('.area_aboutus').hide();
		//关闭Products
		$('.area_products').hide();
		//关闭Press
		$('.area_contacts').hide();
		//开启Contact us
		$('.area_press').hide();
		$('.area_press').fadeIn(800,function (){
			
		});
	}
	//Contacts
	function tocontacts(){
		//关闭语言
		$('#area_language').hide();
		
		$('.menu_on').attr('class','menu_off');
		$('#menu_contacts').attr('class','menu_on');
		//关闭首页
		$('.area_home').hide();
		//关闭About Us
		$('.area_aboutus').hide();
		//关闭Products
		$('.area_products').hide();
		//关闭Press
		$('.area_press').hide();
		//开启Contact us
		$('.area_contacts').hide();
		$('.area_contacts').fadeIn(800,function (){
			
		});
	}
	//获取Product Category
	function togetproductcategory(){
		$('.ajaxloading_tab').show();
		$('.submenu_on').each(function (){
			$(this).attr('class','submenu_off');
		})
		$.post(baseurl+'index.php/welcome/togetproductcategory',function (data){
			$('.ajaxloading_tab').hide();
			$('#productitem_section').html(data);
		});
	}
	
	//获取Product列表
	function togetproductlist(category_id){
		$('.ajaxloading_tab').show();
		$('.submenu_on,.submenu_off').each(function (){
			var thisid=$(this).attr('id');
			var this_split=thisid.split('_');
			if(category_id==this_split[1]){
				$(this).attr('class','submenu_on');
			}else{
				$(this).attr('class','submenu_off');
			}
		})
		$.post(baseurl+'index.php/welcome/togetproductlist/'+category_id,function (data){
			$('.ajaxloading_tab').hide();
			$('#productitem_section').html(data);
		});
	}
	
	//获取Product info
	function togetproductinfo(category_id,product_id){
		$('.ajaxloading_tab').show();
		$.post(baseurl+'index.php/welcome/togetproductinfo/'+category_id+'/'+product_id,function (data){
			$('.ajaxloading_tab').hide();
			$('#productitem_section').html(data);
		});
	}
	

	//加入购物车
	function addtocart(product_id){
		var size_id=1;
		var color_id=1;
		var zdyone_id=1;
		if(size_id==""||color_id==""||zdyone_id==""){
//			product_fill_area_on();
		}else{
//			product_fill_area_off();
			//判断购买的数量是否大于库存
//			var count_detail=parseInt($('#count_detail').val());
//			var num=parseInt($('#buy_num').val());
//			if(num>count_detail){
//				$('.product_bynum_error').show();
//			}else{
//				$('.product_bynum_error').hide();
			
				var num=1;
				var width=410;
				$('.notice_taball').show();
				$(".message_tab").show();
				auto_box_location(width);
				$('.box_title').find("#title").html('Notice');
				$.post(baseurl+"index.php/welcome/addtocart/"+product_id,{count:num,size_id:size_id,color_id:color_id,zdyone_id:zdyone_id},function (data){
					$(".box_content").html(data);
					$('.box_control').find("#content").html('<div style="float:left;width:100%;margin:20px 0px 20px 0px;"><div style="width:190px;margin:0 auto;"><table><tr><td><input onclick="gotoshoppingcart()" type="button" class="btn_2" value="Go to shoppingcart" /></td><td><input  onclick="close_msg()" type="button" class="btn_2" value="Close" /></td></tr></table></div></div>');
					auto_box_location(width);
//					get_cartnum();//计算购物车数量
				});
				
//			}
		}
	}
	
	//进入购物车页面
	function gotoshoppingcart(){
		location.href=baseurl+"index.php/shoppingcart";
	}
	
	
	function auto_box_location(width){
		$(".message_tab").css('width',width+'px');
		$(".message_tab").css('padding-bottom',(width*1/100)+'px');
		$(".message_tab").css('margin-left','-'+(width/2)+'px');
		$(".message_tab").css('margin-top','-'+($(".message_tab").height()/2)+'px');
		if(width>600){
			$('.box_content').css('width','94%');
			$('.box_content').css('padding','18px 2% 20px 2%');
		}else{
			$('.box_content').css('width','90%');
			$('.box_content').css('padding','18px 4% 20px 4%');
		}
	}