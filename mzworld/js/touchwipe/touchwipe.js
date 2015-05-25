
(function(a){
	a.fn.touchwipe=function(c){
		var b={
				min_move_x:20,min_move_y:20,wipeLeft:function(){
			
		},wipeRight:function(){
			
		},wipeUp:function(){
			
		},wipeDown:function(){
			
		},wipe:function(){
			
		},wipehold:function(){
			
		},preventDefaultEvents:true};if(c){
			a.extend(b,c)}this.each(function(){
				var h;var g;var j=false;var i=false;var e;function m(){
					this.removeEventListener("touchmove",d);h=null;j=false;clearTimeout(e)}function d(q){
						if(b.preventDefaultEvents){
							q.preventDefault()}if(j){
								var n=q.touches[0].pageX;var r=q.touches[0].pageY;var p=h-n;var o=g-r;if(Math.abs(p)>=b.min_move_x){
									m();if(p>0){
										b.wipeLeft()}else{
											b.wipeRight()}}else{
												if(Math.abs(o)>=b.min_move_y){
													m();if(o>0){
														b.wipeUp()}else{
															b.wipeDown()}}}}}function k(){
																clearTimeout(e);if(!i&&j){
																	b.wipe()}i=false}function l(){
																		i=true;b.wipehold()}function f(n){
																			if(n.touches.length==1){
																				h=n.touches[0].pageX;g=n.touches[0].pageY;j=true;this.addEventListener("touchmove",d,false);e=setTimeout(l,750)}}if("ontouchstart" in document.documentElement){
																					this.addEventListener("touchstart",f,false);}});return this};a.extend()})(jQuery);

$(function(){
	var winHeight=$(window).height();
	$("#content").css({'height': winHeight});
	$(".wipeone").css({'height': winHeight});
	
	var offsetTop = 0;
	$("#wipecontbox").touchwipe({
	  min_move_x: 30, 
	  min_move_y: 30, 
	  wipeUp: function() {
		  if(offsetTop > -winHeight*3){
			  offsetTop -= winHeight;
//			  $(".wipecont").css("top",offsetTop + "px");
			  $(".wipecont").animate({
				  top:offsetTop + "px"
			  });
		  };
		  if(offsetTop == 0){
			  alert(11);
			  animateT1();
		  }; 
		  if(offsetTop == -winHeight*1){
			  animateT2();
		  }; 
		  if(offsetTop == -winHeight*2){
			  animateT3();
		  }; 
		},
	  wipeDown: function() {
		  if(offsetTop < 0){
			  offsetTop += winHeight;
//			  $(".wipecont").css("top",offsetTop + "px");
			  $(".wipecont").animate({
				  top:offsetTop + "px"
			  });
		  };
		  if(offsetTop == 0){
			  animateT1();
		  }; 
		  if(offsetTop == -winHeight*1){
			  animateT2();
		  }; 
		  if(offsetTop == -winHeight*2){
			  animateT3();
		  }; 
	   }
    });
});



	
