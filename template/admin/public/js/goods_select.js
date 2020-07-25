$(function(){
	//公共下拉框
	$('.select-common').selectric();

	//公共单选框点击切换样式
	$(".radio-common").live("click",function(){
		var radio = $(this).children("input");
		var name = radio.attr("name");
		if(radio.is(":checked")){
			$(".radio-common>input[type='radio'][name='" + name + "']").parent().removeClass("selected");
			$(this).addClass("selected");
		}else{
			$(this).removeClass("selected");
		}
	});

	// 切换商品来源
	$(".set-style [name='from_type']").click(function(event) {
		var type = $(this).val();
		$('.set-style [data-type]').addClass('hide');
		$('.set-style [data-type="'+ type +'"]').removeClass('hide');
	});

	// 搜索商品
	$(".search-goods").click(function(event) {
		LoadingInfo(1);
	});

	// 单选
	$('body').on('change', '.table-class tbody [type="checkbox"]', function(){
		var val = $(this).attr("data");
		var sku = $(this).val();
		var type = $(this).attr("data-type");
		if(limit.is_many_select == 1){	
			if($(this).is(':checked')){
				if(type == "goods_id"){
					sku = $(this).parents("tr").next().find("table tbody tr:eq(1) .checkbox-common [type='checkbox']").val();
				}
				if($.inArray(parseInt(val), goodsIdArray) == -1){
					goodsIdArray.push(val);					
				}
				$(this).parents('.checkbox-common').addClass('selected');
				if(type == "sku_id"){
					var name = $(this).attr("name");					
					var sku_arr = [];
					$("input[name='"+ name +"']").each(function(index,el){
						sku_arr.push($(el).val());
					});
					for(var i = 0; i < sku_arr.length; i ++){	
						if($.inArray(parseInt(sku_arr[i]), skuIdArray) != -1){							
							skuIdArray.splice($.inArray(parseInt(sku_arr[i]), skuIdArray), 1);
						}
						if($.inArray(sku_arr[i], skuIdArray) != -1){
							skuIdArray.splice($.inArray(sku_arr[i], skuIdArray), 1);
						}
					}	
					$("input[name='"+ name +"']").prop('checked', false);
					$("input[name='"+ name +"']").parents().removeClass('selected');
					$(this).parents('.checkbox-common').addClass('selected');
					$(this).prop('checked', true);
					$(this).parents(".sku-list").prev().find(".checkbox-common").addClass('selected');
					$(this).parents(".sku-list").prev().find(".checkbox-common").find('[type="checkbox"]').prop('checked', true);
				}
				if(type == "goods_id" && limit.is_limit_open_sku == 0){
					$(this).parents("tr").next().find("input").prop('checked', false);
					$(this).parents("tr").next().find("label").removeClass('selected');
					$(this).parents("tr").next().find("table tbody tr:eq(1) .checkbox-common").addClass('selected');
					$(this).parents("tr").next().find("table tbody tr:eq(1) .checkbox-common [type='checkbox']").prop('checked', true);
				}
								
				if($.inArray(sku, skuIdArray) == -1){
					skuIdArray.push(sku);
				}

			}else{	
				if(type == "goods_id"){
					sku = $(this).parents("tr").next().find("table tbody tr .checkbox-common [type='checkbox']:checked").val();
				}

				if($.inArray(val, goodsIdArray) != -1){
					goodsIdArray.splice($.inArray(val, goodsIdArray), 1);
				}	
				
				if($.inArray(parseInt(val), goodsIdArray) != -1){
					goodsIdArray.splice($.inArray(parseInt(val), goodsIdArray), 1);
				}
				
				if($.inArray(sku, skuIdArray) != -1){
					skuIdArray.splice($.inArray(sku, skuIdArray), 1);
				}
				if($.inArray(parseInt(sku), skuIdArray) != -1){
					skuIdArray.splice($.inArray(parseInt(sku), skuIdArray), 1);
				}

				$(this).parents('.checkbox-common').removeClass('selected');
				if(type == "sku_id"){
					$(this).parents('.checkbox-common').removeClass('selected');
					$(this).prop('checked', false);
					$(this).parents(".sku-list").prev().find(".checkbox-common").removeClass('selected');
					$(this).parents(".sku-list").prev().find(".checkbox-common").find('[type="checkbox"]').prop('checked', false);
				}
				if(type == "goods_id" && limit.is_limit_open_sku == 0){
					$(this).parents("tr").next().find("input").prop('checked', false);
					$(this).parents("tr").next().find("label").removeClass('selected');
					$(this).parents("tr").next().find("table tbody tr:eq(1) .checkbox-common").removeClass('selected');
					$(this).parents("tr").next().find("table tbody tr:eq(1) .checkbox-common [type='checkbox']").prop('checked', false);
				}
			}
		}else{
			if(type == "goods_id"){
				sku = $(this).parents("tr").next().find("table tbody tr:eq(1) .checkbox-common [type='checkbox']").val();
			}
			if($(this).is(':checked')){	
				goodsIdArray[0] = val;
				skuIdArray[0] = sku;				
				$(this).parents('.checkbox-common').addClass('selected');
				$(this).parents('tr').siblings('tr').find('.checkbox-common').removeClass('selected');
				$(this).parents('tr').siblings('tr').find('.checkbox-common input').prop('checked', false);
				if(type == "sku_id"){
					$(this).parents(".sku-list").prev().find(".checkbox-common").addClass('selected');
					$(this).parents(".sku-list").prev().find(".checkbox-common").find('[type="checkbox"]').prop('checked', true);
				}
				if(type == "goods_id" && limit.is_limit_open_sku == 0){
					$(this).parents("tr").next().find("table tbody tr:eq(1) .checkbox-common").addClass('selected');
					$(this).parents("tr").next().find("table tbody tr:eq(1) .checkbox-common [type='checkbox']").prop('checked', true);
				}
			}else{
				goodsIdArray = [];
				skuIdArray = [];
				$(this).parents('.checkbox-common').removeClass('selected');
				if(type == "sku_id"){
					$(this).parents(".sku-list").prev().find(".checkbox-common").removeClass('selected');
					$(this).parents(".sku-list").prev().find(".checkbox-common").find('[type="checkbox"]').prop('checked', false);
				}
				if(type == "goods_id" && limit.is_limit_open_sku == 0){
					$(this).parents("tr").next().find("table tbody tr:eq(1) .checkbox-common").removeClass('selected');
					$(this).parents("tr").next().find("table tbody tr:eq(1) .checkbox-common [type='checkbox']").prop('checked', false);
				}
			}
		}
	})

	// 全选
	$('.table-class thead [type="checkbox"]').change(function(){
		if(limit.is_many_select == 0) return;
		if($(this).is(':checked')){
			$(this).parents('.checkbox-common').addClass('selected');
			$('.table-class tbody [type="checkbox"]').each(function(index, el) {
				var val = parseInt($(el).val());
				if($.inArray(val, goodsIdArray) == -1){
					goodsIdArray.push(val);
				}
				$(el).parents('.checkbox-common').addClass('selected');
			});
		}else{
			$(this).parents('.checkbox-common').removeClass('selected');
			$('.table-class tbody [type="checkbox"]').each(function(index, el) {
				var val = parseInt($(el).val());
				if($.inArray(val, goodsIdArray) != -1){
					goodsIdArray.splice($.inArray(val, goodsIdArray), 1);
				}
				$(el).parents('.checkbox-common').removeClass('selected');
			});
		}
	})
})




function LoadingInfo(page){
	var field = getConditionValue();
	$.ajax({
		url: __URL(ADMINMAIN + '/promotion/goodsSelectList'),
		type: 'POST',
		data: {
			'page_index' : page,
			'page_size' : $('#showNumber').val(),
			'value' : JSON.stringify(field),
			'is_limit_sku' : limit.is_limit_sku,
			'is_limit_skock' : limit.is_limit_skock,
			'is_limit_state' : limit.is_limit_state,
			'is_limit_goods_type' : limit.is_limit_goods_type,
			'is_limit_open_sku' : limit.is_limit_open_sku
		},
		success : function(data){
			if(data.data.length > 0){
				$(".table-class tbody").empty();
				for (var i = 0; i < data["data"].length; i++) {
					
					var item = data["data"][i];
						item.state_name = item.state == 1 ? '已上架' : '已下架';
						item.checked = $.inArray(item.goods_id, goodsIdArray) != -1 ? 'checked' : '';
					var html = "";	
						html += '<tr>';
							html += '<td class="align-center">';
								html += '<label class="checkbox-common '+ (item.checked != '' ? 'selected' : '') +'">';
									html += '<input type="checkbox" value="'+ item.goods_id +'" '+ item.checked +' data="'+ item.goods_id +'" data-type="goods_id"/>';
								html += '</label>';
							html += '</td>';
							if(limit.is_limit_open_sku == 0){
							html += '<td class="align-center"><span onclick="skulist(this)">+</span></td>';
							}else{
							html += '<td class="align-center"></td>';
							}
							html += '<td>';
								html += '<div class="goods-info">';
									html += '<img src="'+ __IMG(item.picture_info.pic_cover_micro) +'" alt="">';
									html += '<p class="goods-name"><a href="'+__URL(SHOPMAIN + '/goods/detail?goods_id=' + item.goods_id )+'">'+ item.goods_name +'</a></p>';
									html += '<p class="goods-price">￥'+ item.price +'</p>';
								html += '</div>';
							html += '</td>';
							html += '<td class="align-center">'+ item.stock +'</td>';
							html += '<td class="align-center">'+ item.type_config.title +'</td>';		
							html += '<td class="align-center">'+ item.state_name +'</td>';	
						html += '</tr>';	
						if(limit.is_limit_open_sku == 0){
						html += '<tr style="display:none" class="sku-list">';
							html += '<td colspan="6"><table style="width:100%"><colgroup>';	
												html += '<col style="width: 5%;">';
												html += '<col style="width: 5%;">';
												html += '<col style="width: 45%;">';
												html += '<col style="width: 15%;">';
												html += '<col style="width: 15%;">';
												html += '<col style="width: 15%;">';
									html += '</colgroup>';
									html += '<tbody>';
										html += '<tr class="title-tr">';
											html += '<th align="left"></th>';	
											html += '<th align="center">';
											html += '</th>';
											html += '<th align="left">规格名称</th>';
											html += '<th>商品库存</th>';
											html += '<th>商品类型</th>';
											html += '<th>状态</th>';
										html += '</tr>';
										for(var k = 0; k < item["sku_list"]["data"].length; k++){
											var sku_ch = item["sku_list"]["data"][k];
											
											sku_ch.checked = $.inArray(item["sku_list"]["data"][k]['sku_id'], skuIdArray) != -1 ? 'checked' : '';
											html += '<tr>';
												html += '<td></td>';
												html += '<td class="align-center">';
													html += '<label class="checkbox-common skuinput '+ (sku_ch.checked != '' ? 'selected' : '') +'">';
														html += '<input type="checkbox" name="sku'+ item["sku_list"]["data"][k]["goods_id"] +'" '+ sku_ch.checked +' value="'+ item["sku_list"]["data"][k]["sku_id"] +'" data="'+ item["sku_list"]["data"][k]["goods_id"] +'" data-type="sku_id"/>';
													html += '</label>';
												html += '</td>';
												html += '<td>';
													html += '<div class="goods-info">';
														html += '<img src="'+ __IMG(item["sku_list"]["data"][k]["picture_info"]["pic_cover_micro"]) +'" alt="">';
														html += '<p class="goods-name">'+ item["sku_list"]["data"][k]['sku_name'] +'</p>';
														html += '<p class="goods-price">￥'+ item["sku_list"]["data"][k]['price'] +'</p>';
													html += '</div>';
												html += '</td>';
												html += '<td class="align-center">'+ item["sku_list"]["data"][k]['stock'] +'</td>';
												html += '<td class="align-center">'+ item.type_config.title +'</td>';		
												html += '<td class="align-center">'+ item.state_name +'</td>';	
											html += '</tr>';	
										}								
									html += '</tbody></table>'
							html += '</td>';
						html += '</tr>';
						}
					$(".table-class>tbody").append(html);
				}
			}else{
				$('.table-class tbody').html('<tr class="align-center"><td colspan="6">暂无符合条件的数据记录</td></tr>');
			}
			initPageData(data["page_count"],data['data'].length,data['total_count']);
			$("#pageNumber").html(pagenumShow(jumpNumber,$("#page_count").val(), pageshow));
		}
	});	
}

function skulist(even){		
	if($(even).parent().parent().next().css("display") == "none"){
		$(even).parent().parent().next().show();
	}else{
		$(even).parent().parent().next().hide();
	}
}

function getConditionValue(){
	var field = {
		from_type : $('.set-style [name="from_type"]:checked').val()
	};

	if(field.from_type == 'category'){
		field[field.from_type] = $('.set-style [data-type="'+ field.from_type +'"] .select-category').attr('data-value');
	}else{
		field[field.from_type] = $('.set-style [data-type="'+ field.from_type +'"] [name="'+ field.from_type +'"]').val();
	}
	return field;
}

// 选取之后回调
function returnData(callback){
	try	{
		if(typeof callback == 'function'){
			callback(goodsIdArray);
		}
	} catch (e){
		console.error(e.message);
	}
}
//选取之后回调
function returnSkuData(callback){
	try	{
		if(typeof callback == 'function'){
			callback(skuIdArray);
		}
	} catch (e){
		console.error(e.message);
	}
}