$(function(){
	// 切换赠送类型
	$('body').on('change', '[name="give_type"]', function(){
		var type = $(this).val();
		$(this).parents('.item').find('.give_type [data-type="'+ type +'"]').removeClass('hide').siblings('[data-type]').addClass('hide');
		if (type == 'coupon') {
			var couponEl = $(this).parents('.item').find('.give_type [data-type="coupon"] select');
			getCoupon(couponEl, couponEl.val());
		}
	})

	// 添加层级
	$('.add-level').click(function(event) {
		if ($('.level-list .level-container').length < 5) {
			$('.level-list').append($('#level-container').html());
		}else {
			showTip('最多添加5个层级', 'warning');
		}
	});

	// 移除层级
	$('body').on('click', '.level-container .box-title .del', function(){
		var levelContainer = $(this).parents('.level-container');
		levelContainer.slideUp('normal', function(){
			levelContainer.remove();
		});
	})

	// 添加内容
	$('body').on('click', '.level-container .add-give-content', function(){
		var giveContentEl = $(this).parents('.level-container').find('.give-content-list');
		if (giveContentEl.find('.item').length < 5) {
			giveContentEl.append($('#item').html());
		}else {
			showTip('最多添加5项赠送内容', 'warning');
		}
	})

	// 移除内容
	$('body').on('click', '.level-container .item .fa-trash', function(){
		$(this).parents('.item').remove();
	})
	

	// 刷新优惠券
	$('body').on('click', '.level-container .right-box .refresh', function(){
		var couponEl = $(this).parents('[data-type="coupon"]').find('select');
		getCoupon(couponEl, couponEl.val());
	})

	$("#start_time").click(function () {
        WdatePicker({
            dateFmt: 'yyyy-MM-dd HH:mm:ss',
            minDate : '%y-%M-%d',
        })
    })
    $("#end_time").click(function () {
        WdatePicker({
            dateFmt: 'yyyy-MM-dd HH:mm:ss',
            minDate: '#F{$dp.$D(\'start_time\')}',
        })
    })

    $('[data-value]').each(function(index, el) {
    	getCoupon($(this), $(this).attr('data-value'));
    });
})

// 获取优惠券
function getCoupon(selectEl, couponId){
	$.ajax({
		type : "post",
		url : __URL(ADMINMAIN + '/promotion/sendcoupontypelist'),
		success : function(data) {
			var html = '';
			if(data['data'].length > 0){
				html += '<option value="0">请选择优惠券</option>';
				for(var i = 0;i < data['data'].length; i++){
					if (couponId != undefined && data['data'][i]['coupon_type_id'] == couponId) {
						html += '<option value="'+data['data'][i]['coupon_type_id']+'" selected>'+data['data'][i]['coupon_name']+'</option>';
					} else {
						html += '<option value="'+data['data'][i]['coupon_type_id']+'">'+data['data'][i]['coupon_name']+'</option>';
					}
				}
			}else{
				html += '<option value="0">您还未创建优惠券</option>';
			}
			selectEl.html(html);
			selectEl.selectric();
		}
	});
}

// 获取表单数据
function getValue(){
	var field = {
		activity_name : $('[name="activity_name"]').val(),
		start_time : $('[name="start_time"]').val(), 
		end_time : $('[name="end_time"]').val(), 
		activity_type : $('[name="activity_type"]:checked').val(),
		scene : [],
		data : []
	};
	if ($('#hide_id').val() != undefined) {
		field.id = $('#hide_id').val();
	}
	if ($('[name="scene"]:checked').length) {
		$('[name="scene"]:checked').each(function(index, el) {
			field.scene.push($(el).val())
		});
	}
	$('.level-list .level-container').each(function(index, el) {
		var data = {
			condition : $(this).find('.condition').val(),
			giveCont : []
		};
		$(this).find('.give-content-list .item').each(function(index, el) {
			data.giveCont.push({
				type : $(this).find('[data-type]:not(.hide)').attr('data-type'),
				value : $(this).find('[data-type]:not(.hide) [name="value"]').val()
			})
		});
		field.data.push(data);
	});
	field.data.sort(function(x, y){
  		return x.condition - y.condition;
	})
	return field;
}

// 表单验证
function verify(){
	var result = true,
		field = getValue();

	if (field.activity_name.length == 0) {
		result = false;
		$('[name="activity_name"]').parents('dd').find('.error').text('请输入活动名称').show();
	} else{
		$('[name="activity_name"]').parents('dd').find('.error').hide();
	}

	if (field.start_time == '' || field.end_time == '') {
		result = false;
		$('[name="start_time"]').parents('dd').find('.error').text('请选择适用场景').show();
	} else {
		$('[name="start_time"]').parents('dd').find('.error').hide();
	}

	if (field.scene.length == 0) {
		result = false;
		$('[name="scene"]').parents('dd').find('.error').text('请选择适用场景').show();
	} else{
		$('[name="scene"]').parents('dd').find('.error').hide();
	}

	$('.level-list .level-container').each(function(index, el) {
		if ($(this).find('.condition').val() == '') {
			result = false;
			$(this).find('.left-box .error').text('必须填写').show();
		} else {
			$(this).find('.left-box .error').hide();
		}
		
		$(this).find('.give-content-list .item').each(function(index, el) {
			if ($(this).find('[data-type]:not(.hide) [name="value"]').val() == '') {
				result = false;
				$(this).find('.error').text('必须填写').show();
			} else {
				$(this).find('.error').hide();
			}
		});
	});

	if (result) $('.error').hide();
	return result; 
}

var is_sub = false;
function save(){
	if (verify()) {
		var url = $('#hide_id').val() != undefined ? __URL(URL + "NsRecharge/" + ADMINMODULE + "/config/editRecharge") : __URL(URL + "NsRecharge/" + ADMINMODULE + "/config/addRecharge");
		if (is_sub) return;
		is_sub = true;
		$.ajax({
			url: url,
			type: 'post',
			data: {
				value : JSON.stringify(getValue())
			},
			success : function(res){
				if (res.code) {
					showTip(res.message,"success");
					setTimeout(function(){
						location.href = __URL(URL + "NsRecharge/" + ADMINMODULE + "/config/index");
					},1500);
				} else {
					is_sub = false;
					showTip(res.message,"error");
				}
			}
		})
	}
}