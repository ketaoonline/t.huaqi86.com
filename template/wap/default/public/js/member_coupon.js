$(function () {
	$('.cf-container ul li').click(function () {
		$('.cf-container ul li').removeClass('selected ns-text-color ns-border-color');
		$(this).addClass('selected ns-text-color ns-border-color');
	});
	getMemberCounponList(1);
});

function getMemberCounponList(type) {
	api("System.Member.coupon", {"type": type}, function (data) {
		var data = data['data'];
		var listhtml = '';
		console.log(data)
		if (data.length > 0) {
			for (var i = 0; i < data.length; i++) {
				var money = data[i]['money'] != null ? data[i]['money'] : "";
				var coupon_code = data[i]['coupon_code'] != null ? data[i]['coupon_code'] : "";
				var coupon_name = data[i]['coupon_name'] != null ? data[i]['coupon_name'] : "";
				var start_time = data[i]['start_time'] != null ? data[i]['start_time'] : "";
				var end_time = data[i]['end_time'] != null ? data[i]['end_time'] : "";
				var at_least = data[i]['at_least'];
				if (type != 1) {
					listhtml += '<div class="coupon-item ns-bg-color-gray-shade-20">';
				} else {
					listhtml += '<div class="coupon-item" >';
				}
				listhtml += '<div class="coupon-type">';
					listhtml += '<img src="'+WAPIMG+'/coupon.png" class="coupon-default-image" />';
				listhtml += '</div>';
				listhtml += '<section>';
				listhtml += '<div class="coupon-title"><i>￥</i><em>' + money + '</em><span>满' + at_least + '元可用</span></div>';		
				if(data[i]['range_type'] == 1){
					listhtml += '<div class="coupon-time">' + data[i]['coupon_name'] +'(&nbsp;全场商品可使用&nbsp;)</div>';
				}else{
					listhtml += '<div class="coupon-time">' + data[i]['coupon_name'] +'(&nbsp;仅限购买部分商品&nbsp;)</div>';
				}	
				listhtml += '<div class="line"></div>'
				listhtml += '<div class="coupon-desc ns-border-color-gray ns-text-color-gray">';
				listhtml += '' + start_time + ' 至 ' + end_time + '';
				listhtml += '</div>';
				listhtml += '</section>';
				if(data[i]['state'] == 1){
					if(data[i]['range_type'] == 0){
						listhtml += '<a href="'+ APPMAIN +'/goods/lists?coupon_type_id='+ data[i]['coupon_type_id'] +'">去使用</a>';
					}else{
						listhtml += '<a href="'+ APPMAIN +'/goods/lists">去使用</a>';
					}
				}				
				listhtml += '</div>';
				
			}
		} else {
			listhtml += '<div class="coupon-empty">';
			listhtml += '<p class="text-center">您还没有';
			switch (type) {
				case 1:
					listhtml += lang_coupon.unused;
					break;
				case 2:
					listhtml += lang_coupon.used;
					break;
				case 3:
					listhtml += lang_coupon.expire;
					break;
			}
			listhtml += '优惠券</p>';
			listhtml += '</div>';
		}
		$('.com-content .coupon-contianer').html(listhtml);
	})
}