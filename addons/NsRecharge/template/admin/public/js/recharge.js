$(function(){
	$('.add-recharge-amount').click(function(event) {
		var amount = $(this).prev('[name="value"]').val();
		if ($('.amount-container .amount-btn').length == 6) {
			showTip('最多添加六个自定义金额','warning');
			return;
		}
		if (amount > 0) {
			var html = '<span class="amount-btn" data-value="'+ amount +'"><span>'+ amount +'元</span><i class="del">x</i></span>';
			$('.amount-container').append(html);
			$(this).prev('[name="value"]').val('');
		}
	});

	$('body').on('click', '.amount-btn .del', function(){
		$(this).parent('.amount-btn').remove();
	})
})

function getValue(){
	var field = {
		rechargeMode : [],
		fixedAmount : [],
		customAmount : isNaN($('.min-recharge [name="value"]').val()) ? 0 : $('.min-recharge [name="value"]').val()
	};
	if ($('[name="rechargemode"]:checked').length) {
		$('[name="rechargemode"]:checked').each(function(index, el) {
			field.rechargeMode.push($(el).val())
		});
	}
	if ($('.amount-container .amount-btn').length) {
		$('.amount-container .amount-btn').each(function(index, el) {
			field.fixedAmount.push($(this).attr('data-value'));
		});
		field.fixedAmount.sort(function(x, y){
			return x - y;
		})
	}
	return field;
}

function verify(){
	var field = getValue();
	if (field.rechargeMode.length == 0) {
		showTip('至少选择一项充值金额类型','warning');
		return false;
	}
	if ($.inArray('fixed_amount', field.rechargeMode) != -1 && field.fixedAmount == 0) {
		showTip('请添加充值金额','warning');
		return false;
	}
	return true;
}

var is_sub = false;
function save(){
	if (verify()) {
		if (is_sub) return;
		is_sub = true;
		$.ajax({
			url: __URL(URL + "NsRecharge/" + ADMINMODULE + "/config/recharge"),
			type: 'post',
			data: {
				value : JSON.stringify(getValue())
			},
			success : function(res){
				if (res.code) {
					showTip(res.message,"success");
					setTimeout(function(){
						location.reload();
					},1500);
				} else {
					is_sub = false;
					showTip(res.message,"error");
				}
			}
		})
	}
}