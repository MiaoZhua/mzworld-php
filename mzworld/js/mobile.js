	var isNull = /^[\s' ']*$/;
	function isEmail(email){
		var isEmail = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(email);
		if(isEmail!=true){
			return false;
		}else{
			return true;
		}
	}
	function click_scroll() {
		var scroll_offset = $(".gksel_screenwidth").offset(); //得到pos这个div层的offset，包含两个值，top和left
		$("body,html").animate({
			scrollTop:scroll_offset.top //让body的scrollTop等于pos的top，就实现了滚动
		},500);
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
	//Home
	function togethomelist(section){
		$('.gksel_loading_tab').show();//加载中
		$('.mb_menuon').attr('class','mb_menuoff');
		$('#menu_home_area').attr('class','mb_menuon');
		$.post(baseurl+"index.php/mobile/welcome/gethomecontent",function (data){
			$('.gksel_loading_tab').hide();//取消加载中
			$('#gksel_'+section+'_content').html(data);
			if(section==2){
				$('#contmenu_1').show();
				$('#contmenu_2').hide();
			}
			$('.gksel_widthall').animate({marginLeft:"-"+((section-1)*body_width)+"px"},function(){
				click_scroll();//滚动到页面的最上面
			});
		})
	}
	
	function togetcategorylist(section,category_id){
		$('.gksel_loading_tab').show();//加载中
		$('.mb_menuon').attr('class','mb_menuoff');
//		$('#menu_product_'+parent+'_area').attr('class','mb_menuon');
		$('#menu_category_'+category_id+'_area').attr('class','mb_menuon');
		$.post(baseurl+"index.php/mobile/welcome/getcategorylist/"+category_id,function (data){
			$('.gksel_loading_tab').hide();//取消加载中
			$('#gksel_'+section+'_content').html(data);
			if(section==2){
				$('#contmenu_1').show();
				$('#contmenu_2').hide();
			}
			$('.gksel_widthall').animate({marginLeft:"-"+((section-1)*body_width)+"px"},function(){
				click_scroll();//滚动到页面的最上面
			});
		})
	}
	
	//产品详细
	function togetproductinfo(section,product_id){
		$('.gksel_loading_tab').show();//加载中
		$.post(baseurl+"index.php/mobile/welcome/getproductinfo/"+section+"/"+product_id,function (data){
			$('.gksel_loading_tab').hide();//取消加载中
			$('#gksel_'+section+'_content').html(data);
			if(section==2){
				$('#contmenu_1').show();
				$('#contmenu_2').hide();
			}
			$('.gksel_widthall').animate({marginLeft:"-"+((section-1)*body_width)+"px"},function(){
				click_scroll();//滚动到页面的最上面
			});
		})
	}
	//Contact Us
	function togetcontactus(section){
		$('.gksel_loading_tab').show();//加载中
		$('.mb_menuon').attr('class','mb_menuoff');
		$('#menu_contactus_area').attr('class','mb_menuon');
		$.post(baseurl+"index.php/mobile/welcome/getcontactuscontent",function (data){
			$('.gksel_loading_tab').hide();//取消加载中
			$('#gksel_'+section+'_content').html(data);
			if(section==2){
				$('#contmenu_1').show();
				$('#contmenu_2').hide();
			}
			$('.gksel_widthall').animate({marginLeft:"-"+((section-1)*body_width)+"px"},function(){
				click_scroll();//滚动到页面的最上面
			});
		})
	}
	
	//cms
	function togetcmspage(section,parent){
		$('.gksel_loading_tab').show();//加载中
		$('.mb_menuon').attr('class','mb_menuoff');
		$('#menu_cms_'+parent+'_area').attr('class','mb_menuon');
		$.post(baseurl+"index.php/mobile/welcome/getcmspage/"+parent,function (data){
			$('.gksel_loading_tab').hide();//取消加载中
			$('#gksel_'+section+'_content').html(data);
			if(section==2){
				$('#contmenu_1').show();
				$('#contmenu_2').hide();
			}
			$('.gksel_widthall').animate({marginLeft:"-"+((section-1)*body_width)+"px"},function(){
				click_scroll();//滚动到页面的最上面
			});
		})
	}
	
	
	function gotosecond(){
		$('.gksel_widthall').animate({marginLeft:"-"+(1*body_width)+"px"},function(){
			click_scroll();//滚动到页面的最上面
		});
	}
	
	function gotothird(){
		$('.gksel_widthall').animate({marginLeft:"-"+(2*body_width)+"px"},function(){
			click_scroll();//滚动到页面的最上面
		});
	}
	
	function gotofour(){
		$('.gksel_widthall').animate({marginLeft:"-"+(3*body_width)+"px"},function(){
			click_scroll();//滚动到页面的最上面
		});
	}
	
	function gotofive(){
		$('.gksel_widthall').animate({marginLeft:"-"+(4*body_width)+"px"},function(){
			click_scroll();//滚动到页面的最上面
		});
	}
	
	function gotosix(){
		$('.gksel_widthall').animate({marginLeft:"-"+(5*body_width)+"px"},function(){
			click_scroll();//滚动到页面的最上面
		});
	}
	
	
	
	//关闭按钮 X 
	function close_msg(){
		$('.notice_taball').hide();
		$('.message_tab').hide();
		$('.box_title').find("#title").html('');
		$('.box_content').html('<span class="loading_indicator">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>');
		$('.box_control').find("#content").html('');
	}
	
	//关闭按钮 X 
	function close_msg_err(){
		$('.notice_taball').hide();
		$('.error_tab').hide();
		$('.err_box_title').find("#title").html('');
		$('.err_box_content').html('<span class="loading_indicator">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>');
		$('.err_box_control').find("#content").html('');
	}
	
	//关闭按钮 X 
	function close_msg_suc(){
		$('.notice_taball').hide();
		$('.success_tab').hide();
		$('.suc_box_title').find("#title").html('');
		$('.suc_box_content').html('<span class="loading_indicator">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>');
		$('.suc_box_control').find("#content").html('');
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
	
	function toshowsuccess(text){
		var width=300;
		$('.notice_taball').show();
		$(".success_tab").show();
		auto_box_location_suc(width);
		$('.suc_box_title').find("#title").html(L['notice']);
		$.post(baseurl+"index.php/mobile/welcome/success_msgnotice",{text:text},function (data){
			$(".suc_box_content").html(data);
			$('.suc_box_control').find("#content").html('<div style="width:90px;margin:0 auto;"><input onclick="close_msg_suc()" type="button" class="btn_2" value="'+L['close']+'" /></div>');
			auto_box_location_suc(width);
			setTimeout('close_msg_suc()',1000);
		});
	}
	
	function auto_box_location_suc(width){
		$(".success_tab").css('width',width+'px');
		$(".success_tab").css('padding-bottom',(width*1/100)+'px');
		$(".success_tab").css('margin-left','-'+(width/2)+'px');
		$(".success_tab").css('margin-top','-'+($(".message_tab").height()/2)+'px');
		if(width>600){
			$('.suc_box_content').css('width','94%');
			$('.suc_box_content').css('padding','18px 2% 20px 2%');
		}else{
			$('.suc_box_content').css('width','90%');
			$('.suc_box_content').css('padding','18px 4% 20px 4%');
		}
	}
	
	function toshowerror(text){
		var width=300;
		$('.notice_taball').show();
		$(".error_tab").show();
		auto_box_location_err(width);
		$('.err_box_title').find("#title").html(L['notice']);
		$.post(baseurl+"index.php/mobile/welcome/error_msgnotice",{text:text},function (data){
			$(".err_box_content").html(data);
			$('.err_box_control').find("#content").html('<div style="width:90px;margin:0 auto;"><input onclick="close_msg_err()" type="button" class="btn_2" value="'+L['close']+'" /></div>');
			auto_box_location_err(width);
			setTimeout('close_msg_err()',1000);
		});
	}
	
	function auto_box_location_err(width){
		$(".error_tab").css('width',width+'px');
		$(".error_tab").css('padding-bottom',(width*1/100)+'px');
		$(".error_tab").css('margin-left','-'+(width/2)+'px');
		$(".error_tab").css('margin-top','-'+($(".message_tab").height()/2)+'px');
		if(width>600){
			$('.err_box_content').css('width','94%');
			$('.err_box_content').css('padding','18px 2% 20px 2%');
		}else{
			$('.err_box_content').css('width','90%');
			$('.err_box_content').css('padding','18px 4% 20px 4%');
		}
	}
	
	//省市县三级联动
	function togetcity(pid){
		if(pid!=0){
			$.post(baseurl+'index.php/account/getcity/'+pid,function(data){
				$('.city').html(data);
				$('.area').html('<option value=0>'+L['select_area']+'</option>');
			});
		}
	}
	//省市县三级联动
	function togetarea(cid){
		if(cid!=0){
			$.post(baseurl+'index.php/account/getarea/'+cid,function(data){
				$('.area').html(data);
			});
		}
	}
	function tosubmit(){
		var consulting_type=$('select[name="consulting_type"]').val();
		var email=$('input[name="email"]').val();
		var message=$('textarea[name="message"]').val();
		var code=$('input[name="code"]').val();
		ispass=1;
		if(isNull.test(email)){
			ispass=0;
			//不能为空
			toshowerror(L['noempty_email']);
		}else{
			if(isEmail(email)==false){
				ispass=0;
				//邮箱格式错误
				toshowerror(L['formaterror_email']);
			}
		}
		if(ispass==1){
			if(isNull.test(message)){
				ispass=0;
				//不能为空
				toshowerror(L['noempty_message']);
			}
		}
		if(ispass==1){
			if(isNull.test(code)){
				ispass=0;
				//不能为空
				toshowerror(L['noempty_code']);
			}
		}
		if(ispass==1){
			$('.gksel_loading_tab').show();//加载中
			$.post(baseurl+'index.php/mobile/welcome/submit',{code:code,consulting_type:consulting_type,email:email,message:message},function (data){
				$('.gksel_loading_tab').hide();//取消加载中
				if(data==0){
					toshowerror(L['code_error']);
					$('input[name="code"]').val('');
				}else{
					click_scroll();//滚动到页面的最上面
					$('#box_content').html(L['submit_success']);
				}
			});
		}
	}
	function tosubmit_careers(){
		var name=$('input[name="name"]').val();
		var birth=$('input[name="birth"]').val();
		var nationality=$('input[name="nationality"]').val();
		var address=$('textarea[name="address"]').val();
		var email=$('input[name="email"]').val();
		var phone=$('input[name="phone"]').val();
		var code=$('input[name="code"]').val();
		ispass=1;
		if(ispass==1){
			if(isNull.test(name)){
				ispass=0;
				//不能为空
				toshowerror(L['noempty_name']);
			}
		}
		if(ispass==1){
			if(isNull.test(birth)){
				ispass=0;
				//不能为空
				toshowerror(L['noempty_birth']);
			}
		}
		if(ispass==1){
			if(isNull.test(nationality)){
				ispass=0;
				//不能为空
				toshowerror(L['noempty_nationality']);
			}
		}
		if(ispass==1){
			if(isNull.test(address)){
				ispass=0;
				//不能为空
				toshowerror(L['noempty_address']);
			}
		}
		if(isNull.test(email)){
			ispass=0;
			//不能为空
			toshowerror(L['noempty_email']);
		}else{
			if(isEmail(email)==false){
				ispass=0;
				//邮箱格式错误
				toshowerror(L['formaterror_email']);
			}
		}
		if(ispass==1){
			if(isNull.test(phone)){
				ispass=0;
				//不能为空
				toshowerror(L['noempty_phone']);
			}
		}
		if(ispass==1){
			if(isNull.test(code)){
				ispass=0;
				//不能为空
				toshowerror(L['noempty_code']);
			}
		}
		if(ispass==1){
			$('.gksel_loading_tab').show();//加载中
			$.post(baseurl+'index.php/mobile/welcome/submitcareers',{code:code,name:name,birth:birth,nationality:nationality,email:email,phone:phone,address:address},function (data){
				$('.gksel_loading_tab').hide();//取消加载中
				if(data==0){
					toshowerror(L['code_error']);
					$('input[name="code"]').val('');
				}else{
					click_scroll();//滚动到页面的最上面
					$('#box_content').html(L['submit_success']);
				}
				
				
			});
		}
	}
	
	//删除信息
	function del(isdel,section,ref_url,cart_id){
		if(isdel==1){
			ref_url=decodeURI(ref_url);
			$.post(ref_url,function (data){
				close_msg();
				$('#shoppingcart_list_'+cart_id).fadeOut(100,function (){
					$('#shoppingcart_list_'+cart_id).remove();
					get_cartnum();
					gotoshoppingcart(section);//到购物车页面
					
				})
			});
		}else{
			close_msg();
		}
	}
	
