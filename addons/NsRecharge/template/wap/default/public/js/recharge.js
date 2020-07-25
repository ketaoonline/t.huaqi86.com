$(function(){
	$('.select-amount ul li').click(function(event) {
		$(this).addClass('ns-text-color ns-border-color ns-bg-color-fadeout-80').siblings('li').removeClass('ns-text-color ns-border-color ns-bg-color-fadeout-80');
		$('.recharge-form input').val('');
	});

	$('.recharge-form input').change(function(event) {
		var recharge_money = $(this).val();
		if (recharge_money > 0) {
			$('.select-amount ul li').removeClass('ns-text-color ns-border-color ns-bg-color-fadeout-80');
		}
	});
})

var is_submit = false;
function recharge(){
	var pay_no = $('#pay_no').val(),
		recharge_money = 0,
		inputEl = $('.recharge-form input');

	if (inputEl != undefined && inputEl.val() > 0) {
		if (inputEl.val() < inputEl.attr('data-min-recharge') && inputEl.attr('data-min-recharge') != 0) {
			toast('最低需充值'+ inputEl.attr('data-min-recharge') + '元');
			return;
		}	
		recharge_money = inputEl.val();
	} else if ($('.select-amount ul li.ns-text-color') != undefined) {
		recharge_money = $('.select-amount ul li.ns-text-color').attr('data-value');
	}

	if (!recharge_money) {
		toast('请输入有效金额');
	}

	if(is_submit) return;
	is_submit = true;
	api('System.Member.createRechargeOrder', {"recharge_money": recharge_money, "out_trade_no": pay_no}, function(res) {
      	if(res.data>0){
      		window.location.href = __URL(APPMAIN+"/pay/getpayvalue?out_trade_no="+pay_no);
       	}else{
			is_submit = false;
       		toast(lang_member_recharge.member_recharge_failed);
       	}
	})
}