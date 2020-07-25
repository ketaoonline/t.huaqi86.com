var vue = new Vue({
	el: '#app',
	data: {
		isNeedInvoice: false, // 是否需要发票
		taxMoney: '0.00', // 税费
		totalMoney: '0.00', // 总金额
		point: 0, // 使用积分数
		shippingMoney: '0.00', // 运费
		promotionMoney: '0.00', // 优惠金额
		goodsMoney: '0.00', // 商品金额
		payMoney: '0.00', // 实际支付金额
		pointMoney: '0.00', // 积分抵现金额
		payTypeName: $('[v-text="payTypeName"]').text(),
		shippingInfo: {
			shippingType: $('[v-text="shippingInfo.shippingType"]').text(),
			leftCont: $('[v-text="shippingInfo.leftCont"]').text(),
			rightCont: $('[v-text="shippingInfo.rightCont"]').text(),
		},
		couponCont: $('[v-html="couponCont"]').html(),
		couponMoney: '0.00',
		fullReduction: '0.00'
	}
});

$(function () {
	// 是否需要发票
	$('#is-need-invoice').click(function () {
		if ($(this).is(':checked')) {
			$(this).parents('.invoice-wrap').find('.invoice-form,.dividing-line').removeClass('hide');
		} else {
			$(this).parents('.invoice-wrap').find('.invoice-form,.dividing-line').addClass('hide');
		}
		vue.isNeedInvoice = $(this).is(':checked');
		order.calculate();
	});
	
	// 选择配送方式
	$('.delivery-wrap .shipping-type-list li').click(function () {
		$(this).attr('class', 'selected ns-text-color ns-border-color').siblings('li').attr('class', 'ns-border-color-gray');
		$('.delivery-wrap .panel').addClass('hide');
		var type = $(this).attr('data-value');
		switch (type) {
			case '1':
				$('.delivery-wrap .logistics').removeClass('hide');
				break;
			case '2':
				$('.delivery-wrap .pickup-point').removeClass('hide');
				break;
		}
		order.calculate();
	});
	
	// 物流公司选择 自提点选择 支付方式选择 发票内容选择
	$('.express-company-list li,.pickup-point-list li,.pay-type-list li,.invoice-cont-list li,.presell-pay-type li').click(function () {
		$(this).addClass('selected').siblings('li').removeClass('selected');
		$(this).parent('ul').find('i.iconfont').attr('class', 'iconfont iconcheckbox ns-text-color-gray');
		$(this).find('i.iconfont').attr('class', 'iconfont icon_success ns-text-color');
		order.calculate();
	});
	
	// 时间段选择
	$('.distribution-time-out .time-out-list span').click(function () {
		$(this).attr('class', 'selected ns-bg-color').siblings('span').attr('class', 'ns-bg-color-gray-fadeout-60');
	});
	
	// 时间选择
	$('.distribution-time-out .shipping-time-list li').click(function () {
		$(this).attr('class', 'selected ns-bg-color').siblings('li').attr('class', 'ns-bg-color-gray-fadeout-60');
		var text = '预计' + $(this).text() + ' ' + $('.distribution-time-out .time-out-list span.selected').text() + ' ' + '送达';
		$('.delivery-wrap .shipping-time time').text(text);
		picker.hide();
	});
	
	// 优惠选择
	$('.coupon-list li').click(function () {
		if ($(this).hasClass('selected')) {
			$(this).removeClass('selected');
			$(this).children('i.iconfont').attr('class', 'iconfont iconcheckbox ns-text-color-gray');
			var couponNum = $('.coupon-list li').length;
			vue.couponCont = `<span class="coupon-mark ns-text-color ns-border-color">有` + couponNum + `张券可用</span> <span>去使用</span>`;
		} else {
			$(this).addClass('selected').siblings('li').removeClass('selected');
			$(this).siblings('li').children('i.iconfont').attr('class', 'iconfont iconcheckbox ns-text-color-gray');
			$(this).children('i.iconfont').attr('class', 'iconfont iconchecked ns-text-color');
			var countMoney = $(this).find('.money').attr('data-value');
			vue.couponCont = `已使用1张，可抵扣￥<span>` + countMoney + `</span>`;
		}
		order.calculate();
	});
	
	// 使用积分
	$('.use-point').change(function () {
		var point = parseInt($(this).val()),
			max_use_point = $(this).attr('data-max-available');
		if (point < 0) point = 0;
		if (point > max_use_point) point = max_use_point;
		$(this).val(point);
		order.calculate();
	});

	// 支付方式
	$('.pay-type-list li').click(function () {
		vue.payTypeName = $(this).find('span').text();
		picker.hide();
	});
});

var is_sub = false;

function Order() {
	var data = {
		order_type: _params.order_type, // 订单类型
		goods_sku_list: _params.goods_sku_list, // 购买商品规格
		is_virtual: _params.is_virtual, // 是否是虚拟商品
		buyer_ip: _params.buyer_ip, // 购买人ip
		user_money: 0, // 用户余额
		platform_money: 0, // 平台余额
		shipping_info: {}, // 配送信息
		buyer_invoice: '', // 发票信息
		buyer_message: '', // 买家留言
		promotion_type: _params.promotion_type,
		coin: 0, // 购物币
		promotion_info: _params.promotion_info
	};
	
	this.getValue = function () {
		if (data.is_virtual == 0) {
			data.shipping_info = {}; // 每次获取前先清空原数据
			data.shipping_info.shipping_type = $('.shipping-type-list li.selected').attr('data-value');
			if (data.shipping_info.shipping_type == 1) {
				data.shipping_info.shipping_company_id = $('.express-company-list li.selected').attr('data-value') != undefined ? $('.express-company-list li.selected').attr('data-value') : 0;
				data.shipping_info.shipping_time = $('.shipping-time-list li.selected').attr('data-time');
				data.shipping_info.distribution_time_out = $('.time-out-list span').text();
			} else if (data.shipping_info.shipping_type == 2) {
				data.shipping_info.pick_up_id = $('.pickup-point-list li.selected').attr('data-value') != undefined ? $('.pickup-point-list li.selected').attr('data-value') : 0;
			}
		} else {
			data.user_telephone = $('.account-cont [name="mobile"]').val();
		}
		if ($('#is-need-invoice').is(':checked')) {
			var invoiceFormObj = $('.invoice-wrap .invoice-form');			
			if($('input[name="invoice_type"]:checked').val() == 1){
				data.buyer_invoice = invoiceFormObj.find('[name="invoice_title"]').val() + '$' + invoiceFormObj.find('li.selected').text() + '$' + invoiceFormObj.find('[name="taxpayer_identification_number"]').val();
			}else{
				data.buyer_invoice = invoiceFormObj.find('[name="invoice_title"]').val() + '$' + invoiceFormObj.find('li.selected').text() + '$' + invoiceFormObj.find('[name="taxpayer_identification_number"]').val() + '$' + invoiceFormObj.find('[name="opening_Bank"]').val() + '$' + invoiceFormObj.find('[name="bank_account"]').val() + '$' + invoiceFormObj.find('[name="business_address"]').val() + '$' + invoiceFormObj.find('[name="business_tel"]').val();
			}
			
		} else {
			data.buyer_invoice = '';
		}
		data.pay_type = $('.pay-type-list li.selected').attr('data-value');
		data.buyer_message = $('.user-message').val();
		data.coupon_id = $('.coupon-list li.selected').attr('data-value') != undefined ? $('.coupon-list li.selected').attr('data-value') : 0;
		data.point = isNaN(parseInt($('.use-point').val())) ? 0 : parseInt($('.use-point').val());
		data.address_id = $('.address-wrap .address').attr('data-value') != undefined ? $('.address-wrap .address').attr('data-value') : 0;
		// 预售订单
		if (data.order_type == 6) {
			data.presell_info = {
				is_full_payment: $('.presell-pay-type li.selected').attr('data-value')
			}
		}
	};
	
	// 订单计算
	this.calculate = function () {
		this.getValue();
		api('System.Order.orderCalculate', {'data': JSON.stringify(data)}, function (res) {
			if (res.code == 0) {
				vue.taxMoney = parseFloat(res.data.tax_money).toFixed(2);
				vue.totalMoney = parseFloat(res.data.total_money).toFixed(2);
				vue.shippingMoney = parseFloat(res.data.shipping_money).toFixed(2);				
				if(res.data.full_reduction == undefined){
					vue.fullReduction = 0.00;
				}else{
					vue.fullReduction = parseFloat(res.data.full_reduction).toFixed(2); 
				}	
				if(res.data.coupon_money){
					vue.promotionMoney = Number(parseFloat(res.data.promotion_money).toFixed(2)) + Number(parseFloat(res.data.coupon_money).toFixed(2));
				}else{
					vue.promotionMoney = parseFloat(res.data.promotion_money).toFixed(2);
				}
				
				//vue.promotionMoney = parseFloat(res.data.promotion_money).toFixed(2);
				vue.goodsMoney = parseFloat(res.data.goods_money).toFixed(2);
				vue.payMoney = parseFloat(res.data.pay_money).toFixed(2);
				vue.point = res.data.offset_money_array.point.num;
				vue.pointMoney = parseFloat(res.data.offset_money_array.point.offset_money).toFixed(2);
				data.pay_money = res.data.pay_money;
				vue.couponMoney = res.data.coupon_money;
				if (data.order_type == 6) {
					vue.payMoney = parseFloat(res.data.presell_order_pay_money).toFixed(2);
					data.pay_money = res.data.presell_order_pay_money;
				}
			} else {
				toast(res.message);
			}
		}, false)
	};
	
	// 订单提交
	this.submit = function () {
		this.getValue();
		if (this.verify()) {
			if (is_sub) return;
			is_sub = true;
			api('System.Order.orderCreate', {'data': JSON.stringify(data)}, function (res) {
				if (res.code == 0) {
					
					//清除订单数据(本地数据) (如果是购物车购买,要删除购物车中的数据)
					$.ajax({
						type: 'post',
						url: __URL(APPMAIN + "/order/deleteCreateData"),
						dataType: "JSON",
						data: {data: data},
						success: function (res) {
						}
					});
					//如果实际付款金额为0，跳转到个人中心的订单界面中
					if (data.pay_type == 4 || vue.payMoney == 0) {
						location.href = __URL(APPMAIN + '/order/lists');
					} else {
						window.location.href = __URL(APPMAIN + '/pay/pay?out_trade_no=' + res.data.out_trade_no);
					}
				} else {
					toast(res.message);
					is_sub = false;
				}
			}, false)
		}
	};
	
	// 验证
	this.verify = function () {
		// 非虚拟商品
		if (data.is_virtual == 0) {
			if (data.address_id == 0) {
				toast('请先选择收货地址');
				return false;
			}
			if (data.pay_type == undefined) {
				toast('商家未配置支付方式');
				return false;
			}
			// 如果用户选择商家配送的话 不考虑配送方式有没有开启
			if (data.pay_type != 4) {
				if (data.shipping_info.shipping_type == undefined) {
					toast('商家未启用配送方式');
					return false;
				}
			}
			if (data.shipping_info.shipping_type == 2 && data.shipping_info.pick_up_id == 0) {
				toast('请先选择自提点');
				return false;
			}
		} else {
			if (data.user_telephone.search(regex.mobile) == -1) {
				toast('请输入正确的手机号');
				return false;
			}
		}
		// 发票
		if ($('#is-need-invoice').is(':checked')) {
			if ($('.invoice-wrap [name="invoice_title"]').val().search(/[\S]+/)) {
				toast('请填写发票抬头');
				return false;
			}
			if ($('.invoice-wrap [name="taxpayer_identification_number"]').val().search(/[\S]+/)) {
				toast('请输入纳税人识别号');
				return false;
			}
			if($('input[name="invoice_type"]:checked').val() == 2){
				if ($('.invoice-wrap [name="opening_Bank"]').val().search(/[\S]+/)) {
					toast('请输入开户银行');
					return false;
				}
				if ($('.invoice-wrap [name="bank_account"]').val().search(/[\S]+/)) {
					toast('请输入银行账号');
					return false;
				}
				if ($('.invoice-wrap [name="business_address"]').val().search(/[\S]+/)) {
					toast('请输入企业地址');
					return false;
				}
				if ($('.invoice-wrap [name="business_tel"]').val().search(/[\S]+/)) {
					toast('请输入企业电话');
					return false;
				}
			}
		}
		
		var array = [];
		var custom_data = [];
		$(".custom-form [name]").each(function(index, el){
			array.push({value : $(el).val(), is_fill : $(el).attr("data-fill"), data_name : $(el).attr("data-name"), data_type : $(el).attr("data-type"), id : $(el).attr("id")})
			custom_data.push({data_name : $(el).attr("data-name"), value : $(el).val(), oc_id : $(el).attr("data-oc"), data_type : $(el).attr("data-type")})
		})
		for (i = 0; i < array.length; i ++){
			if(array[i]['is_fill'] == 1 && array[i]['value'] == ""){
				var custom_name  = $("#"+array[i]['id']).parents(".custom-box").find(".custom-title").html();
				toast(custom_name+'不能为空');
				return false;
			}
			if(array[i]['data_type'] == 2 && isNaN(array[i]['value'])){
				toast(array[i]['data_name'] + '只能是数字');
				return false;
			}
		}
		
		//单选框		
		if($("input[name='radio_text']").length>0){
			$(".ns-border-color-gray input[name='radio_text']").each(function(index, el){
				custom_data.push({
					data_name : $(el).attr("data-name"),
					value : $(el).next().next().next().find("input[name='radio_box_"+ $(el).attr("id") +"']:checked").attr("data-name"),
					oc_id : $(el).attr("data-oc"),
					data_type : $(el).attr("data-type")
				})
			})			
		}
		
		//复选框
		var no_type = "";
		if($("input[name='check_text']").length>0){
			$(".ns-border-color-gray input[name='check_text']").each(function(index, el){
				var check_text = [];
				$(el).next().next().next().find("input[type='checkbox']:checked").each(function(indexs, ele){
					check_text.push($(ele).attr("data-name"));
				})
				
				if($(el).attr("data-fill") == 1 && check_text == ""){
					toast($(el).attr("data-name") + '必须选择');
					no_type = "-9";
					return false;
				}
				if(check_text != ""){
					var check_str = check_text.join(',');
				}else{
					var check_str = "";
				}
				
				custom_data.push({data_name : $(el).attr("data-name"), value : check_str, oc_id : $(el).attr("data-oc"), data_type : $(el).attr("data-type")})
			}) 
		}

		if(no_type == "-9"){
			return false;
		}
		data.custom_data = custom_data;

		return true;
	}
}

function Page() {
	
	this.show = function (name) {
		this.name = name;
		if ($('[data-page="' + name + '"]') != undefined) {
			$('[data-page="main"]').hide(0, function () {
				$('[data-page="' + name + '"]').show();
			});
		}
	};
	
	this.hide = function () {
		$('[data-page="' + this.name + '"]').hide(0, function () {
			$('[data-page="main"]').show();
		});
		
		if (pageCancelAfter[this.name] != undefined) {
			pageCancelAfter[this.name]();
		}
	};
	
	this.confirm = function () {
		if (pageConfirmAfter[this.name] != undefined) {
			if (pageConfirmAfter[this.name]()) {
				$('[data-page="' + this.name + '"]').hide(0, function () {
					$('[data-page="main"]').show();
				});
			}
		} else {
			$('[data-page="' + this.name + '"]').hide(0, function () {
				$('[data-page="main"]').show();
			});
		}
	}
}

// 副页面点击确认之后回调函数
var pageConfirmAfter = {
	invoice: function () {
		if ($('.invoice-wrap [name="invoice_title"]').val().search(/[\S]+/)) {
			toast('请填写发票抬头');
			return false;
		}
		if ($('.invoice-wrap [name="taxpayer_identification_number"]').val().search(/[\S]+/)) {
			toast('请输入纳税人识别号');
			return false;
		}		
		if($('input[name="invoice_type"]:checked').val() == 2){
			if ($('.invoice-wrap [name="opening_Bank"]').val().search(/[\S]+/)) {
				toast('请输入开户银行');
				return false;
			}
			if ($('.invoice-wrap [name="bank_account"]').val().search(/[\S]+/)) {
				toast('请输入银行账号');
				return false;
			}
			if ($('.invoice-wrap [name="business_address"]').val().search(/[\S]+/)) {
				toast('请输入企业地址');
				return false;
			}
			if ($('.invoice-wrap [name="business_tel"]').val().search(/[\S]+/)) {
				toast('请输入企业电话');
				return false;
			}
		}
		return true;
	},
	delivery: function () {
		var type = $('.shipping-type-list li.selected').attr('data-value');
		switch (type) {
			case '1':
				vue.shippingInfo.shippingType = $('.shipping-type-list li.selected').text();
				vue.shippingInfo.leftCont = '送货时间';
				vue.shippingInfo.rightCont = $('.delivery-wrap .shipping-time time').text();
				break;
			case '2':
				vue.shippingInfo.shippingType = $('.shipping-type-list li.selected').text();
				vue.shippingInfo.leftCont = '自提点';
				vue.shippingInfo.rightCont = $('.pickup-point-list li.selected .name').text();
				break;
			case '3':
				vue.shippingInfo.shippingType = $('.shipping-type-list li.selected').text();
				vue.shippingInfo.leftCont = '配送时间';
				vue.shippingInfo.rightCont = $('.delivery-wrap .distribution-time').text();
				break;
		}
		return true;
	}
};

var pageCancelAfter = {};
pageCancelAfter.delivery = pageConfirmAfter.delivery;

function Picker() {
	this.show = function (name) {
		var contEl = $('[data-picker="picker-' + name + '"]');
		if (contEl != undefined) {
			$('.shade,[data-picker="picker-' + name + '"]').removeClass('hide');
		}
	};
	
	this.hide = function () {
		$('.picker .cont').html('');
		$('.shade,.picker').addClass('hide');
	}
}

function custom(){
	this.show = function (id){
		$('#order_custom').removeClass('hide').addClass("custom-y");
	}
	this.hide = function () {
		$('#order_custom').addClass('hide').removeClass("custom-y");
	}
}

function switchtype(type){
	if(type == 1){		
		$(".special-ticket").css("display","none");
	}else{
		$(".special-ticket").css("display","block");
	}
}

var page = new Page();
var picker = new Picker();
var order = new Order();
var custom = new custom();
order.calculate();

$(".radio-box .iconfont").each(function(){
	
	$(this).on("click",function(event){			
		$("."+ $(this).attr("data-co") +"").removeClass("iconcheck");
		$("."+ $(this).attr("data-co") +"").children("input").prop("checked", false);
		$(this).addClass("iconcheck");
		$(this).children("input").prop("checked", true);
	})	
})

function clickBox(event){
	if($(event).is(':checked')){
		$(event).parent(".checked-box").addClass("selected");
		$(event).children("input").prop("checked", true);
	}else{
		$(event).parent(".checked-box").removeClass("selected");
		$(event).children("input").prop("checked", false);
	}
}

function checkMore(event, string){
	var html = "";
	var type = $(event).attr("data-type");
	var array = string.split(",");
	var div_length = $("."+ type +" .option-text");
	if(div_length.length > 4){
		for(var i = 0; i < array.length; i ++){
			if(i < 4){
				html += '<div class="option-text">';
				html += '<label class="checked-box">';
					html += '<input type="checkbox" data-name=" '+ array[i] +'" onChange="clickBox(this)"/>';
					html += '<i> '+ array[i] +' </i>';
				html += '</label>';
			html += '</div>';
			}	
		}		
		$(event).removeClass("iconunfold");
		$(event).addClass("iconfold");
		$("."+ type +"").html(html);
	}else{
		if(array.length >4){
			for(var i = 0; i < array.length; i ++){
				html += '<div class="option-text">';
					html += '<label class="checked-box">';
						html += '<input type="checkbox" data-name=" '+ array[i] +'" onChange="clickBox(this)"/>';
						html += '<i> '+ array[i] +' </i>';
					html += '</label>';
				html += '</div>';
			}
			$(event).removeClass("iconfold");
			$(event).addClass("iconunfold");
			$("."+ type +"").html(html);
		}
	}
}	
