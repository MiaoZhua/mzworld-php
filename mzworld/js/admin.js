	var isNull = /^[\s' ']*$/;
	function isEmail(email){
		var isEmail = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(email);
		if(isEmail!=true){
			return false;
		}else{
			return true;
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
	function auto_box_location(width){
		$(".message_tab").css('width',width+'px');
		$(".message_tab").css('padding-bottom',(width*1/100)+'px');
		$(".message_tab").css('margin-left','-'+(width/2)+'px');
		if(width>600){
			$('.box_content').css('width','94%');
			$('.box_content').css('padding','18px 2% 20px 2%');
		}else{
			$('.box_content').css('width','90%');
			$('.box_content').css('padding','18px 4% 20px 4%');
		}
	}
	
	//删除文章
	function todel_article(article_id){
		var width=350;
		$('.notice_taball').show();
		$(".message_tab").show();
		auto_box_location(width);
		$('.box_title').find("#title").html('Notice');
		var ref_url=encodeURI(baseurl+"index.php/admins/home/del_article/"+article_id);
//		var new_msg_title=L['del_msg_title'].replace(/{title}/, $('input[name="title_'+id+'"]').val());
		$.post(baseurl+"index.php/welcome/del_msgnotice_new",{text:'您确定要删除此文字吗？'},function (data){
			$(".box_content").html(data);
			$('.box_control').find("#content").html('<div style="width:170px;margin:0 auto;"><input onclick="del(1,\''+ref_url+'\')" type="button" class="btn_1" value="确定" /><input onclick="close_msg(0)" type="button" class="btn_1" value="取消"  style="margin-left:30px;"/></div>');
			auto_box_location(width);
		});
	}
	
	//删除博客
	function todel_blog(blog_id){
		var width=350;
		$('.notice_taball').show();
		$(".message_tab").show();
		auto_box_location(width);
		$('.box_title').find("#title").html('Notice');
		var ref_url=encodeURI(baseurl+"index.php/admins/blog/del_msg_box/"+blog_id);
//		var new_msg_title=L['del_msg_title'].replace(/{title}/, $('input[name="title_'+id+'"]').val());
		$.post(baseurl+"index.php/welcome/del_msgnotice_new",{text:'您确定要删除此条消息吗？'},function (data){
			$(".box_content").html(data);
			$('.box_control').find("#content").html('<div style="width:170px;margin:0 auto;"><input onclick="del(1,\''+ref_url+'\')" type="button" class="btn_1" value="确定" /><input onclick="close_msg(0)" type="button" class="btn_1" value="取消"  style="margin-left:30px;"/></div>');
			auto_box_location(width);
		});
	}
	
	//删除信息
	function del(isdel,ref_url){
		if(isdel==1){
			ref_url=decodeURI(ref_url);
			$.post(ref_url,function (data){
				location.href=currenturl;
			});
		}else{
			$(".notice_taball").hide();
			$("#notice_tab").hide();
			$(".message_tab").hide();
		}
	}
	
	//关闭按钮 X 
	function close_msg(){
		$('.notice_taball').hide();
		$('.notice_tab').hide();
		$('.message_tab').hide();
		$('.box_title').find("#title").html('');
		$('.box_content').html('<span class="loading_indicator">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>');
		$('.box_control').find("#content").html('');
	}
	
	var image_width=0;
	var image_height=0;
	$(document).ready(function(){
		
		//上传图片1
		var img_choose1 = $('#img_choose1'), interval;
		if(img_choose1.length>0){
			new AjaxUpload(img_choose1,{
				action: baseurl+'index.php/welcome/uplogo_project', 
				name: 'logo',onSubmit : function(file, ext){
					if (ext && /^(jpg|png|jpeg|gif)$/.test(ext)){
						img_choose1.text(L['uploading']);
						this.disable();
						interval = window.setInterval(function(){
							var text = img_choose1.text();
							if (text.length < 13){
								img_choose1.text(text + '.');					
							}else{
								img_choose1.text(L['uploading']);				
							}
						},200);
					}else{
						$('#img_project_error').html(L['uploadfile_type1']);
						return false;
					}
				},onComplete: function(file, response){
					img_choose1.text(L['select_picture']);						
					window.clearInterval(interval);
					this.enable();
					if(response=='false'){
						$('#img_project_error').html(L['upload_false']);
					}else{
						project_pic_on(1);
						var pic = eval("("+response+")");
						if(pic.size<1048576){
							$('#img1_project_show').html('<img src="'+baseurl+pic.logo+'" /><br />');
							$('#img1_project_small').html('<img src="'+baseurl+pic.logo+'" /><br />');
							$('#img1_project').attr('value',pic.logo);
							$('#img1_project_smile').attr('value',pic.pic_logo_url_smile);
							$('#img_project_error').html('');
						}else{
							$('#img_project_error').html('图片太大无法上传');
						}
						
					}
				}
			});
		}
		//上传图片2
		var button_project2 = $('#img2_project_choose'), interval;
		if(button_project2.length>0){
			new AjaxUpload(button_project2,{
				action: baseurl+'index.php/welcome/uplogo_project', 
				name: 'logo',onSubmit : function(file, ext){
					if (ext && /^(jpg|png|jpeg|gif)$/.test(ext)){
						button_project2.text(L['uploading']);
						this.disable();
						interval = window.setInterval(function(){
							var text = button_project2.text();
							if (text.length < 13){
								button_project2.text(text + '.');					
							}else{
								button_project2.text(L['uploading']);				
							}
						},200);
					}else{
						$('#img_project_error').html(L['uploadfile_type1']);
						return false;
					}
				},onComplete: function(file, response){
					button_project2.text(L['select_picture']);						
					window.clearInterval(interval);
					this.enable();
					if(response=='false'){
						$('#img_project_error').html(L['upload_false']);
					}else{
						project_pic_on(2);
						var pic = eval("("+response+")");
						if(pic.size<1048576){
							$('#img2_project_show').html('<img src="'+baseurl+pic.logo+'" /><br />');
							$('#img2_project_small').html('<img src="'+baseurl+pic.logo+'" /><br />');
							$('#img2_project').attr('value',pic.logo);
							$('#img2_project_smile').attr('value',pic.pic_logo_url_smile);
							$('#img_project_error').html('');
						}else{
							$('#img_project_error').html('图片太大无法上传');
						}
					}
				}
			});
		}
	
	});
	
	
	function toggle_calendar(id){
		$('#'+id+'_error').html('<span class="loading_indicator">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>');
		var isopten=$('#'+id).attr('isopten');
		if(isopten==0){
			var default_val=$('#'+id).val();
			$.post(baseurl+'index.php/admins/home/toevent_calendar_pick',{id:id,default_val:default_val},function (data){
				$('#'+id+'_area').html(data);
				$('#'+id+'_error').html('');
				$('#'+id).attr('isopten',1);
			});
		}else{
			$('#'+id+'_area').html('');
			$('#'+id+'_error').html('');
			$('#'+id).attr('isopten',0);
		}
	}
	
	function togetrilidatatoinput(id,year,month,day){
		if(day<10){
			var day_show='0'+day;
		}else{
			var day_show=day;
		}
		$('#'+id).val(year+'-'+month+'-'+day_show);
		
//		var timee = year+'-'+month+'-'+day_show;
//		var timeetest= new Date(Date.parse(timee.replace(/-/g,   "/"))); //转换成Data();
//		var ww= timeetest.getDay();
//		if(ww==0){
//			$('input[name="week"]').val('星期日');
//		}else if(ww==1){
//			$('input[name="week"]').val('星期一');
//		}else if(ww==2){
//			$('input[name="week"]').val('星期二');
//		}else if(ww==3){
//			$('input[name="week"]').val('星期三');
//		}else if(ww==4){
//			$('input[name="week"]').val('星期四');
//		}else if(ww==5){
//			$('input[name="week"]').val('星期五');
//		}else if(ww==6){
//			$('input[name="week"]').val('星期六');
//		}
//		$('input[name="week_id"]').val(ww);
		
		toggle_calendar(id);
	}
//	
	function togetshiwucalendar_month(id,year,month){
		$.post(baseurl+'index.php/admins/home/toevent_calendar_pick/'+year+'/'+month,{id:id},function (data){
			$('#'+id+'_area').html(data);
		});
	}

	//删除订阅
	function todel_email(id){
		$("#notice_tab").show();
		$(".notice_taball").show();
		var ref_url=encodeURI(baseurl+"index.php/admins/email/del_email/"+id);
		$.post(baseurl+"index.php/welcome/del_msgnotice",{text:L['del_msg_costume'],title:L['notice'],ref_url:ref_url},function (data){
			$("#notice_tab").html(data);
		});
	}