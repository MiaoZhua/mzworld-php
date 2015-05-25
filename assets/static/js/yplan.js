$(function(){
	var yplan={
			down_people:{
					tips:[
							"我也要找小伙伴一起来参赛！",
							"求关注",
							"废弃电池该如何回收？",
							"啥是电子废弃物？",
							"垃圾分类怎样更合理？",
							"我也要加入智能城市！",
							"我有个好主意！",
							"自来水可以直接喝就好了",
							"棒棒哒！",
							"那些风车一直在转唉！",
							"快把雾霾吹走！",
							"环保是每个人的事！",
							"拒绝垃圾食品！",
							"学校是我家，节能靠大家",
							"我真的也能为学校建设出谋划策嘛？",
							"小伙伴们快来头脑风暴"
					],
					people_num:null,
					$people:$(".plan_c .pepole"),
					init:function(){
							/*人物掉落*/
							var down=300;
							yplan.down_people.$people.each(function(index, element) {
								var p_top=$(this)[0].offsetTop;
								$(this).css("top",p_top-down+"px");
							});
							yplan.down_people.people_num=yplan.down_people.$people.size();
							var people_array=new Array();
							for(i=0;i<yplan.down_people.people_num;i++){
								people_array[i]=i;
							}
							var people_timer=setInterval(function(){
								var _max=people_array.length;
								if(_max!==0){
									var p=parseInt(Math.random()*_max);
									var p_top=yplan.down_people.$people.eq(people_array[p])[0].offsetTop;
									yplan.down_people.$people.eq(people_array[p]).find(".img").fadeIn(400);
									yplan.down_people.$people.eq(people_array[p]).animate({"top":p_top+down+"px"},{duration: 600, easing: "easeOutBounce"});
									people_array.splice(p,1);
								}else{
									clearInterval(people_timer);
									yplan.down_people.random_tip();
								}
							},250);
					},
					random_tip:function(){
						
							setInterval(function(){
								var p=parseInt(Math.random()*yplan.down_people.people_num);
								var t=parseInt(Math.random()*yplan.down_people.tips.length);
								yplan.down_people.$people.eq(p).css("z-index","6");
								yplan.down_people.$people.eq(p).find(".box span").html(yplan.down_people.tips[t]);
								yplan.down_people.$people.eq(p).find(".box").show().animate({"bottom":"78px","opacity":"1"},200).delay(2000).animate({"bottom":"58px","opacity":"0"},200,function(){
									$(this).hide();
									yplan.down_people.$people.eq(p).css("z-index","5");
								});
							},2440);
					}
			}
	}
	yplan.down_people.init();
})