//animate
window.onload = function(){
	pagaInit();
	animateT1();
	
	$(".imgtxt2").hide();
	$(".itxt").click(function(){
		$(this).parent().parent().find(".imgtxt").hide();
		$(this).parent().parent().find(".imgtxt2").show();
	});
	$(".itxt2").click(function(){
		$(this).parent().parent().find(".imgtxt2").hide();
		$(this).parent().parent().find(".imgtxt").show();
	});	
	
		
	$("#audiobtn").click(function(){
		$(this).hide();
		$("#audiobtn2").show();
		$("#sourcesrc").attr("src","");
	});
	$("#audiobtn2").click(function(){
		$(this).hide();
		$("#audiobtn").show();
		$("#sourcesrc").attr("src","audio/01.mp3");
	});
	
};

function pagaInit(){
	$('#loading').hide();
	$("body").removeClass("black");
	$('#content').show();
}


function animateT1(){
	$(".tablist").hide();
	$(".arrows").show();
}
function animateT2(){
	$(".tablist").show();
//	$(".arrows").hide();
	
	$(".tablist li").removeClass("on");
	$(".tablist li").eq(0).addClass("on");
}

function animateT3(){
	$(".tablist li").removeClass("on");
	$(".tablist li").eq(1).addClass("on");
}

function animateT4(){
	$(".tablist li").removeClass("on");
	$(".tablist li").eq(2).addClass("on");
}

function animateT5(){
	$(".tablist li").removeClass("on");
	$(".tablist li").eq(3).addClass("on");
}

function animateT6(){
	$(".tablist li").removeClass("on");
	$(".tablist li").eq(4).addClass("on");
}

function animateT7(){
	$(".tablist li").removeClass("on");
	$(".tablist li").eq(5).addClass("on");
}

function animateT8(){
	$(".tablist li").removeClass("on");
	$(".tablist li").eq(6).addClass("on");
}

function animateT9(){
	$(".tablist li").removeClass("on");
	$(".tablist li").eq(7).addClass("on");
}

function animateT10(){
	$(".tablist li").removeClass("on");
	$(".tablist li").eq(8).addClass("on");
}

function animateT11(){
	$(".tablist li").removeClass("on");
	$(".tablist li").eq(9).addClass("on");
}

function animateT12(){
	$(".tablist li").removeClass("on");
	$(".tablist li").eq(10).addClass("on");
}

function animateT13(){
	$(".tablist li").removeClass("on");
	$(".tablist li").eq(11).addClass("on");
}

function animateT14(){
	$(".tablist li").removeClass("on");
	$(".tablist li").eq(12).addClass("on");
}

function animateT15(){
	$(".tablist li").removeClass("on");
	$(".tablist li").eq(13).addClass("on");
}

function animateT16(){
	$(".tablist li").removeClass("on");
	$(".tablist li").eq(14).addClass("on");
}

function animateT17(){
	$(".tablist li").removeClass("on");
	$(".tablist li").eq(15).addClass("on");
}

function animateT18(){
	$(".tablist").hide();
	$(".arrows").hide();	
	
//	$(".t11_01").animate({top:800,opacity:'hide'},0);
//	setTimeout(function(){$(".t11_01").animate({top:0,opacity:'show'},200)},200);
	
}
