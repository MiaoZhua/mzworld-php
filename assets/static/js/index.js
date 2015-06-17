$(document).ready(function() {
	fun.account();
	fun.down_people(".home_c");
	//判断浏览器版本
	var b_name = navigator.appName;
	if (b_name == "Microsoft Internet Explorer") {
		var b_version = navigator.appVersion;
		var version = b_version.split(";");
		var trim_version = version[1].replace(/[ ]/g, "");
		if (trim_version == "MSIE7.0" || trim_version == "MSIE6.0" || trim_version == "MSIE8.0" || trim_version == "MSIE9.0") {
			$(".version,.layer_mask").show();
		}
	}
	//滚动
	var s = skrollr.init({
			edgeStrategy: 'set',
			easing: {
					WTF: Math.random,
					inverted: function(p) {
							return 1-p;
					}
			}
	});
});