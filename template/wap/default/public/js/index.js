$(function () {
	
	var mask_wap_floating = new MaskLayer(".wap-floating", function () {
		mask_wap_floating.show();
	});
	
	// 首页浮层
	var wap_floating = "";
	api("System.Shop.wapFloating", {}, function(res){
		wap_floating = res['data'];	
		wap_floating.show_type = wap_floating.show_type == undefined ? 'once' : wap_floating.show_type;
		wap_floating.show_num = wap_floating.show_num == undefined ? 1 : wap_floating.show_num;
	}, false)
	
	init();
	
	function init() {
		
		niushop.share();
		
		$('body').append('<div id="search_goods"></div><div id="detail"></div>');
		$('.custom-search-input').keyup(function () {
			var search = $(this).val();
		});
		
		var notice_count = $("#hidden_notice_count").val();
		if (notice_count) {
			
			var notice_index = 0;
			var notice_autoTimer = 0;//全局变量目的实现左右点击同步
			
			//当公告数量大于1个时进行滚动垂直滚动，等于1个时横向滚动
			if (notice_count > 1) {
				
				//自动轮播
				if ($(".dowebok-block ul li").length > 1) {
					$(".dowebok-block ul li:eq(0)").clone(true).appendTo($(".dowebok-block ul"));//克隆第一个放到最后(实现无缝滚动)
					var liHeight = $(".dowebok-block li").height();//一个li的高度
					//获取li的总高度再减去一个li的高度(再减二个Li是因为克隆了多出了一个Li的高度)
					var li_sum = $(".dowebok-block ul li").length;
					$(".dowebok-block ul").height(liHeight);//给ul赋值高度
					notice_autoTimer = setInterval(function () {
						
						notice_index++;
						
						if (notice_index > Number(li_sum) - 1) {
							notice_index = 0;
						}
						$(".dowebok-block ul").stop().animate({
							
							top: -notice_index * liHeight
							
						}, 500, function () {
							if (notice_index == Number(li_sum) - 1) {
								$(".dowebok-block ul").css({top: 0});
								notice_index = 0;
							}
							
						});
						
					}, 5000);
				}
				
			} else {
				$('.dowebok').liMarquee({
					hoverstop: false
				});
			}
		}
		
		var swiper = new Swiper('.swiper-container', {
		    autoplay: 2500,
		    autoplayDisableOnInteraction:false,
		    loop : true,
		    pagination : {
			    el : '.swiper-pagination'
		  	}
		})
		
		document.onkeydown = function (event) {
			e = event ? event : (window.event ? window.event : null);
			if (e.keyCode == 13) {
				var search = $('.custom-search-input').val();
				location.href = __URL(APPMAIN + "/goods/lists?keyword=" + search);
			}
		};
		
		function refreshFloating() {
			if ($.cookie("index_wap_floating_layer") == null) {
				$(".wap-floating").fadeIn();
				mask_wap_floating.show();
			} else {
				var wap_floating_cookie = JSON.parse($.cookie("index_wap_floating_layer"));
				if (wap_floating.nav_icon != wap_floating_cookie.imgPath) {
					$(".wap-floating").fadeIn();
					mask_wap_floating.show();
				} else {
					if (wap_floating.show_type == 'many' && wap_floating_cookie.closeNum < wap_floating.show_num) {
						$(".wap-floating").fadeIn();
						mask_wap_floating.show();
					}
				}
			}
		}
		
		$(".wap-floating .close-wrap").click(function () {
			mask_wap_floating.hide();
			$(".wap-floating").fadeOut();
			var closeNum = 1;
			if ($.cookie("index_wap_floating_layer") != null) {
				var wap_floating_cookie = JSON.parse($.cookie("index_wap_floating_layer"));
				if (wap_floating.nav_icon == wap_floating_cookie.imgPath) {
					closeNum = wap_floating_cookie.closeNum + 1;
				}
			}
			if (wap_floating.show_type == 'many') {
				$.cookie("index_wap_floating_layer", JSON.stringify({imgPath : wap_floating.nav_icon, closeNum : closeNum}), {expires: 1});
			} else {
				$.cookie("index_wap_floating_layer", JSON.stringify({imgPath : wap_floating.nav_icon, closeNum : closeNum}), {expires: 7});
			}
		});
		
		if (wap_floating.is_show == 1 && wap_floating.nav_icon != '') refreshFloating();

		updateEndTime();
	}
	
	$('.custom-search-button').click(function () {
		var searchCont = $('.custom-search-input').val();
		searchCont = searchCont.replace(/</g, "&lt;").replace(/>/g, "&gt;");
		if (searchCont != '') {
			if ($.cookie("searchRecordWap") != undefined) {
				var arr = eval($.cookie("searchRecordWap"));
			} else {
				var arr = new Array();
			}
			if (arr.length > 0) {
				if ($.inArray(searchCont, arr) < 0) {
					arr.push(searchCont);
				}
			} else {
				arr.push(searchCont);
			}
			$.cookie("searchRecordWap", JSON.stringify(arr));
			
			location.href = __URL(APPMAIN + '/goods/lists?keyword=' + searchCont);
		}
	});
	
	//点击关注弹出公众号二维码
	$(".foucs-on-block button").click(function () {
		$(".wechat-popup").show();
		$(".mask").show();
	});
	$(".foucs-on-block .mask").click(function () {
		$(".wechat-popup").hide();
		$(".mask").hide();
	});
	
});

//跳转到电脑端
function locationShop() {
	$.ajax({
		type: 'post',
		url: __URL(APPMAIN + "/index/setClientCookie"),
		data: {client: "web"},
		success: function (res) {
			if (res.code > 0) {
				location.href = __URL(SHOPMAIN);
			}
		}
	});
}

var is_have = true;

function couponReceive(event, coupon_type_id) {
	var info = new Array();
	info['maxFetch'] = $(event).attr("data-max-fetch");
	info['receivedNum'] = $(event).attr("data-received-num");
	
	is_have = false;
	if (is_have) {
		return;
	}
	api("System.Member.getCoupon", {'coupon_type_id': coupon_type_id, "scenario_type": 2}, function (res) {
		if (res.code >= 0) {
			toast('领取成功');
			is_have = true;
			var received_num = parseInt(info['receivedNum']) + 1; // 该用户已领取数
			$(event).attr("data-received-num", received_num);
			
			if (info['maxFetch'] > 0 && received_num >= info['maxFetch']) {
				$(event).find(".get").text("已领取");
				$(event).addClass("received");
			}
		} else if (res.code == -9999) {
			toast(res.message, __URL(APPMAIN + "/login/index"));
		} else {
			toast(res.message);
			is_have = true;
		}
	});
}

//倒计时函数
function updateEndTime() {
	var date = new Date();
	var time = date.getTime(); //当前时间距1970年1月1日之间的毫秒数
	
	$(".remaining-time").each(function (i) {
		var endDate = this.getAttribute("endTime"); //结束时间字符串
		
		//转换为时间日期类型
		var endDate1 = eval('new Date(' + endDate.replace(/\d+(?=-[^-]+$)/, function (a) {
			return parseInt(a, 10) - 1;
		}).match(/\d+/g) + ')');
		
		var endTime = endDate1.getTime(); //结束时间毫秒数
		
		var lag = (endTime - time) / 1000; //当前时间和结束时间之间的秒数
		if (lag > 0) {
			var second = Math.floor(lag % 60);
			var minite = Math.floor((lag / 60) % 60);
			var hour = Math.floor((lag / 3600) % 24);
			var day = Math.floor((lag / 3600) / 24);
			second = second < 10 ? '0' + second : second;
			minite = minite < 10 ? '0' + minite : minite;
			hour = hour < 10 ? '0' + hour : hour;
			day = day < 10 ? '0' + day : day;
			$(this).find(".day").html(day + lang_index.days);
			$(this).find(".hours").html(hour);
			$(this).find(".min").html(minite);
			$(this).find(".seconds").html(second);
		} else {
			$(this).html(lang_index.activity_over + "！");
		}
	});
	setTimeout("updateEndTime()", 1000);
}