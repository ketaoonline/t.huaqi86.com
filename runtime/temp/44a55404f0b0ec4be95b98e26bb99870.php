<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:37:"template/admin/Order/orderAction.html";i:1588730747;}*/ ?>
<style>
.modal-body{max-height:400px;overflow-y: auto}
.editprice-input{width:100px;}
.pick_title{float: left;line-height: 32px; width: 140px;text-align:right;}
.pick_title .required{color:red;margin-right:10px;}
textarea{width: 350px;}
#pickup_name,#pickup_mobile{width: 350px;}
.address_choice select{width:118px}
.modal-backdrop{background-color: #000000;}
.form-group:after{content:"";display:block;clear:both;}
.refunds-block .selectric-scroll{height:auto !important;}
#Delivery .goods-box{max-height: 280px;overflow-y: auto;}
#Delivery .modal-body{max-height: 430px !important;}
.selectric-items{0px !important; height:0px !important;padding:0px;border:0px}
.c-item-column .selectric-scroll{position: fixed;width: 140px;height: auto !important;background: #fff;border: 1px solid #ccc;padding: 4px;border-top:0px}
.form-group .selectric-scroll{position: fixed;width: 240px;height: auto !important;background: #fff;border: 1px solid #ccc;padding: 4px;border-top:0px}
</style>

<!-- 调整价格  开始 -->
<div id="edit-price" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width: 650px;overflow: overlay;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin-right: 10px;">×</button>
		<h3 id="H1">修改价格</h3>
	</div>
	<div class="modal-body">
		<table class="table table-striped table-main table-order-header">
			<colgroup>
				<col style="width: 40%;">
				<col style="width: 20%;">	
				<col style="width: 25%;">
				<col style="width: 15%;">
			</colgroup>
			<tbody>
				<tr>
					<td>商品信息</td>
					<td>商品清单</td>
					<td>
						<div class="editprice-tiptxt">涨价或减价<i class="icon-tip"></i>
							<p class="text-tip">-表示减价<i class="icon-down-pic"></i></p>
						</div>
					</td>
					<td id="edit-express-money">邮费</td>
				</tr>
			</tbody>
		</table>
		<table class="table table-bordered table-order-list">
			<colgroup>
				<col style="width: 40%;">
				<col style="width: 20%;">
				<col style="width: 25%;">
				<col style="width: 15%;">
			</colgroup>
			<tbody id="OrderCommodity"></tbody>
		</table>
		<ul class="edit-price-amountpay">
			<li>
				<span class="amountpay-label">商品总价：</span>
				<span class="amountpay-price" id="goodsmoney"></span>元&nbsp;&nbsp;&nbsp;
				<span class="amountpay-label">商品优惠：</span>
				<span class="amountpay-price" id="discountmoney"></span>元&nbsp;&nbsp;&nbsp;
				<span class="amountpay-label">运费：</span>
				<span class="amountpay-price" id="modifiedFreight"></span>元
			</li>
			<li>
				<div>
					实收款： <span class="amountpay-price reality-price" id="changeTotal"></span>元
					<input type="hidden" id="hiedchangeTotal" />
				</div>
			</li>
		</ul>
	</div>
	<div class="modal-footer">
		<button class="btn-common btn-big" onclick="updPrice()" id="butSubmit">保存</button>
		<button class="btn-common-cancle btn-big" data-dismiss="modal" aria-hidden="true">关闭</button>
	</div>
</div>


<!-- 调整价格  结束 -->
<!-- 发货 开始 -->
<div class="modal hide fade" id="Delivery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="left:32%">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3>商品发货</h3>
			</div>
			<div class="modal-body">
				<!-- 主要内容 -->
				<div style="padding: 0 0 10px 0;">待发货(<span id="no_shipping_num"></span>)，已选<span id="checkedbox">0</span></div>
				<div class="goods-box">
					<table class="table-class" style="margin-bottom:10px;">
						<thead>
							<tr>
								<th>
									<i class="checkbox-common"><input type="checkbox" id="inlineCheckbox1"></i>
								</th>
								<th></th>
								<th>商品</th>
								<th>数量</th>
								<th>物流 | 单号</th>
								<th>状态</th>
							</tr>
						</thead>
						<colgroup>
							<col style="width: 5%;">
							<col style="width: 10%;">
							<col style="width: 40%;">
							<col style="width: 10%;">
							<col style="width: 20%;">
							<col style="width: 15%;">
						<colgroup>
						<tbody></tbody>
					</table>
				</div>				
				<div>
					<div style="margin-bottom:5px;">发货方式：</div>
					<label class="checkbox-inline" style="float:left;margin-right:30px;">
						<i class="radio-common">
							<input type="radio" name="shipping_type" id="shipping_type0" value="0">
						</i>
						<span>无需物流</span>
					</label>
					<label class="checkbox-inline" style="float:left;">
						<i class="radio-common selected">
							<input type="radio" name=shipping_type id="shipping_type1" value="1" checked="checked">
						</i>
						<span>需要物流</span>
					</label>
				</div>
				<div style="clear:both;"></div>
				<div class="form-group" id="express_input" style="margin:5px 0 10px 0;">
					<select class="form-control" id="divlogistics_express_company" ></select>
					<input type="text" id="divlogistics_express_no" class="input-common" placeholder="请填写快递单号" style="vertical-align:2px;">
				</div>
				<div id="receiver_info" style="clear:both;"></div>
			</div>
			
			<div class="modal-footer">
				<input type="hidden" id="o2o_delivery_order_id"/>
				<button class="btn-common btn-big" onclick="orderDeliverySubmit()">保存</button>
				<button class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>
</div>
<!-- 发货 结束 -->
<!-- 本地配送模态框 -->
<div class="modal hide fade" id="o2o_Delivery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="left:32%">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3>商品发货</h3>
			</div>
			<div class="modal-body">
				<!-- 主要内容 -->
				<div>待发货(<span id="o2o_shipping_num"></span>)</div>
				<table class="table table-hover" style="margin-bottom:10px;">
					<thead>
						<tr>
							<td>商品</td>
							<td>数量</td>
						</tr>
					</thead>
					<colgroup>
						<col style="width: 60%;">
						<col style="width: 40%;">
					<colgroup>
					<tbody></tbody>
				</table>
				<div>
					<div style="margin-bottom:5px;">配送人员：</div>
				</div>
				<div style="clear:both;"></div>
				<div class="form-group" id="express_input">
					<select class="form-control input-lg" id="o2o_delivery_user" ></select>
					<input type="text" id="o2o_delivery_no" class="input-common" placeholder="请填写配送单号" style="vertical-align:2px;">
				</div>
				<div id="receiver_info"></div>
				<div>
					<div style="margin-bottom:5px;">备注：</div>
					<textarea class="remark textarea-common" style=" width: 440px;height: 80px;" maxlength="500"></textarea>
				</div>
			</div>
			
			<div class="modal-footer">
				<input type="hidden" id="delivery_order_id"/>
				<input type="hidden" id="delivery_buyer_id"/>
				<button class="btn-common btn-big" onclick="o2oDeliverySubmit()">提交更改</button>
				<button class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>
</div>


<!-- 自提模态 -->
<div class="modal hide fade" id="pickup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="margin-left:-365px; width: 700px;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3>商品提货</h3>
			</div>
			<div class="modal-body">
				<!-- 主要内容 -->
				<table class="table table-hover" style="margin-bottom:10px;">
					<thead></thead>
					<colgroup><colgroup>
					<tbody></tbody>
				</table>
				
				<div class="form-group">
					<div class="pick_title"><span class="required">*</span>提货人：</div>
					<div class="col-lg-4"><input type="text" id="pickup_name" class="form-control input-common" placeholder="请填写提货人姓名"></div>
				</div>
				<div class="form-group">
					<div class="pick_title"><span class="required">*</span>提货人手机号：</div>
					<div class="col-lg-4"><input type="text" id="pickup_mobile" class="form-control input-common" placeholder="请填写提货人手机号"></div>
				</div>
				<div class="form-group">
					<div class="pick_title">备注：</div>
					<div class="col-lg-2"><textarea id="pickup_desc" class="textarea-common"></textarea></div>
				</div>
			
			</div>
			
			<div class="modal-footer">
				<input type="hidden" id="pickup_order_id" />
				<button class="btn-common btn-big" onclick="orderPickupSubmit(pickup_order_id)">确认提货</button>
				<button class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>
</div>
<!-- 修改收货地址模态 -->
<div class="modal hide fade" id="update_address" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="margin-left:-365px; width: 700px;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3>修改收货地址</h3>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="pick_title"><span class="required">*</span>收货人：</div>
					<div class="col-lg-4"><input type="text" id="receiver_name" class="form-control input-common" style="width:350px;margin-bottom:10px !important;"></div>
				</div>
				<div class="form-group">
					<div class="pick_title"><span class="required">*</span>收货人手机号：</div>
					<div class="col-lg-4"><input type="text" id="receiver_mobile" class="form-control input-common" style="width:350px;margin-bottom:10px !important;"></div>
				</div>
				<div class="form-group">
					<div class="pick_title">收货人固定电话：</div>
					<div class="col-lg-4"><input type="text" id="fixed_telephone" class="form-control input-common" style="width:350px;margin-bottom:10px !important;"></div>
				</div>
				<div class="form-group">
					<div class="pick_title">收货人邮编：</div>
					<div class="col-lg-4"><input type="text" id="receiver_zip" class="form-control input-common" style="width:350px;margin-bottom:10px !important;" maxlength="6" onkeyup="this.value=this.value.replace(/\D/g,'')"></div>
				</div>
				<div class="form-group" style="width:100%;margin-bottom: 10px;">
					<div class="pick_title"><span class="required">*</span>收货地址：</div>
					<div class="address_choice">
						<select name="province" id="seleAreaNext" onchange="GetProvince();" class="select-common harf">
							<option value="">请选择省</option>
						</select>
						<select name="city" id="seleAreaThird" onchange="getSelCity();" class="select-common harf">
							<option value="">请选择市</option>
						</select>
						<select name="district" id="seleAreaFouth" class="select-common harf">
							<option value="-1">请选择区/县</option>
						</select>
						<input type="hidden" id="provinceid" >
						<input type="hidden" id="cityid" >
						<input type="hidden" id="districtid" >
					</div>
				</div>
				<div class="form-group">
					<div class="pick_title"><span class="required">*</span>详细地址：</div>
					<div class="col-lg-4"><input type="text" id="address_detail" class="form-control input-common" style="width:350px"></div>
				</div>
			</div>
			
			<div class="modal-footer">
				<input type="hidden" id="update_address_id" />
				<button type="button" class="btn-common btn-big" onclick="updateAddressSubmit(update_address_id)">修改</button>
				<button type="button" class="btn-common-white btn-big" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>
</div>

<!-- 模态框（Modal） -->
<div class="modal fade hide" id="Memobox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;left:45%;top:30%;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>备注信息</h3>
			</div>
			<div class="set-style">
				<dl>
					<dt><span class="required">*</span>备注:</dt>
					<dd>
						<p>
							<textarea rows="3" cols="20" id="memo" class="textarea-common"></textarea>
						</p>
						<p class="error">请输入备注</p>
					</dd>
				</dl>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn-common btn-big" onclick="addMemoAjax()">保存</button>
				<button class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>
</div>

<!-- 修改运单号 -->
<div class="modal hide fade" id="update_express" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width: 700px; left: 45%; top: 30%; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3>修改运单号</h3>
			</div>
	 			<div class="modal-body">
					<div style="margin-bottom:5px;">发货方式：</div>
					<label class="checkbox-inline" style="float:left;margin-right:30px;"><input type="radio" name="shipping_type_update" id="shipping_type2" value="0"> 无需物流</label>
					<label class="checkbox-inline" style="float:left;"><input type="radio" name=shipping_type_update id="shipping_type3" value="1" checked="checked"> 需要物流</label>
				
					<div style="clear:both;"></div>
					<div class="form-group" id="update_express_input">
						<select class="form-control input-lg" id="update_divlogistics_express_company" style="margin-bottom:5px;margin-right:15px;float:left;"></select>
						<div class="col-lg-2"><input type="text" id="update_divlogistics_express_no" class="form-control" placeholder="请填写快递单号" style="height:19px;"></div>
					</div>
					<div id="receiver_infos"></div>
				</div>
			</div>
			
			<div class="modal-footer">
				<input type="hidden" id="order_goods_express_id"/>
				<button class="btn-common btn-big" onclick="updateExpressAjax()">提交更改</button>
				<button class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>
</div>
<script>
$(function() {

	var selCity = $("#seleAreaNext")[0];
	for (var i = selCity.length - 1; i >= 0; i--) {
		selCity.options[i] = null;
	}
	var opt = new Option("请选择省", "-1");
	selCity.options.add(opt);
	// 添加省
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/order/getprovince'); ?>",
		dataType : "json",
		success : function(data) {
			if (data != null && data.length > 0) {
				for (var i = 0; i < data.length; i++) {
					var opt = new Option(data[i].province_name,data[i].province_id);
					selCity.options.add(opt);
				}
				
				if(typeof($("#provinceid").val())!='undefined'){
					$("#seleAreaNext").val($("#provinceid").val());
					GetProvince();
					$("#provinceid").val('-1');
				}
				$("#seleAreaNext").selectric({maxHeight:500});
			} 
		}
	});

	$("#shipping_type1").focus(function(){
		$("#express_input").show();
	});

	$("#shipping_type0").focus(function(){
		$("#express_input").hide();
	});
	
	$("#shipping_type3").focus(function(){
		$("#update_express_input").show();
	});

	$("#shipping_type2").focus(function(){
		$("#update_express_input").hide();
	});
});
/*****订单相关操作函数开始*****/
function operation(operation_type, order_id,buyer_id){
	if(operation_type == 'pay'){
		orderOffLinePay(order_id);//线下支付
	}else if(operation_type == 'complete'){
		orderComplete(order_id);//交易完成
	}else if(operation_type == 'delivery'){
		orderDelivery(order_id,buyer_id);//发货
	}else if(operation_type == 'close'){
		orderClose(order_id);//交易关闭
	}else if(operation_type == 'adjust_price'){
		modifyPrice(order_id);//修改价格
	}else if(operation_type == 'pickup'){
		pickuporder(order_id);//提货
	}else if(operation_type == 'seller_memo'){
		orderSellerMemo(order_id);//备注
	}else if(operation_type == 'logistics'){
		location.href = __URL(ADMINMAIN+'/order/orderdetail?order_id='+order_id);//查看物流
	}else if(operation_type == 'update_express'){
		updateExpress(order_id);//修改运单号
	}else if(operation_type == 'update_address'){
		update_address(order_id);//修改收货地址
	}else if(operation_type == 'getdelivery'){
		getdelivery(order_id);//确认收货
	}else if(operation_type == 'delete_order'){
		delete_order(order_id);//删除订单
	}else if(operation_type == 'o2o_delivery'){
		o2o_delivery(order_id);//o2o发货
	}else if(operation_type == 'order_presell'){
		presellOrderOffLinePay(order_id);//预售线下支付
	}else if(operation_type == 'stocking_complete'){
		presellStockingComplete(order_id);
	}else if(operation_type == 'received_payment'){
		received_payment(order_id); // 货到付款订单已收到货款
	}
}

function orderDelivery(order_id,buyer_id){
	$("#divlogistics_express_company option").remove();
	$("#Delivery .modal-body table tbody tr").remove();
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/order/orderdeliverydata'); ?>",
		data : {'order_id':order_id},
		success : function(data) {
			$("#delivery_order_id").val(order_id);
			$("#delivery_buyer_id").val(buyer_id);
			var receiver_info = '收货信息：'+data['order_info']['address']+'&nbsp;'+data['order_info']['receiver_address']+'&nbsp;'+data['order_info']['receiver_name']+'&nbsp;'+data['order_info']['receiver_mobile'];//收货信息
			$("#receiver_info").html(receiver_info);
			var co_html = '';
			co_html += '<option value="0">请选择物流公司</option>';
			for(var i=0;i<data['express_company_list'].length;i++){
				if(data['express_company_list'][i]['is_enabled'] == '1'){
					if(data['order_info']["shipping_company_id"] == data["express_company_list"][i]["co_id"]){
						co_html += '<option value="'+data["express_company_list"][i]["co_id"]+'" selected>'+data["express_company_list"][i]["company_name"]+'</option>';
					}else{
						co_html += '<option value="'+data["express_company_list"][i]["co_id"]+'">'+data["express_company_list"][i]["company_name"]+'</option>';
					}
				}
			} 
			$("#divlogistics_express_company").append(co_html).addClass("select-common").selectric({maxHeight:500});
			
			$("#divlogistics_express_company").val(data['order_info']["shipping_company_id"]);
			
			var go_html = '';
			var no_shipping_num = 0;
			for(var i=0;i<data['order_goods_list'].length;i++){
				if(data['order_goods_list'][i]['shipping_status'] == 0){
					no_shipping_num++;
				}
				go_html += '<tr align="center">';
				if(data['order_goods_list'][i]['shipping_status'] > 0){
					go_html += '<td><i class="checkbox-common"><input type="checkbox" value="'+data['order_goods_list'][i]['shipping_status']+'" disabled="true"></i></label></td>';
				}else{
					go_html += '<td><i class="checkbox-common"><input type="checkbox" id="'+data['order_goods_list'][i]['order_goods_id']+'" value="'+data['order_goods_list'][i]['shipping_status']+'" onclick="deliveryCheck(this)"></i></td>';
				}
				go_html += '<td><a href="'+__URL('http://t.huaqi86.com/index.php/goods/detail?goods_id='+data['order_goods_list'][i]['goods_id'])+'" target="_blank"><img src="'+__IMG(data['order_goods_list'][i]['picture_info']['pic_cover_micro'])+'" style="width:40px;" title="'+data['order_goods_list'][i]['goods_name']+'"></a></td>';
				go_html += '<td style="text-align:left;"><a href="'+__URL('http://t.huaqi86.com/index.php/goods/detail?goods_id='+data['order_goods_list'][i]['goods_id'])+'" target="_blank">'+data['order_goods_list'][i]['goods_name'];
				go_html += '&nbsp;' + data['order_goods_list'][i]['sku_name'];
				go_html += '</a></td>';
				go_html += '<td>'+data['order_goods_list'][i]['num']+'</td>';
				//if(data['order_goods_list'][i]['shipping_status'] == 0 || data['order_goods_list'][i]['express_info']['express_company'] == undefined){
				if(data['order_goods_list'][i]['shipping_status'] == 0 || data['order_goods_list'][i]['express_info'] == undefined){
					go_html += '<td></td>';
				}else{
					go_html += '<td>'+data['order_goods_list'][i]['express_info']['express_company']+' | '+data['order_goods_list'][i]['express_info']['express_no']+'</td>';
				}
				go_html += '<td>'+data['order_goods_list'][i]['shipping_status_name']+'</td>';
				go_html += '</tr>';
			}
			$("#no_shipping_num").html(no_shipping_num);
			$("#Delivery .modal-body table tbody").append(go_html);

			if ($("#Delivery .modal-body").innerHeight() > parseInt($("#Delivery .modal-body").css('max-height'))) {
				$("#Delivery .modal-body").css('overflow-y', 'auto');
			} else {
				$("#Delivery .modal-body").css('overflow-y', 'inherit');
			}
		}
	});
	$("#Delivery").modal('show');
}

var flag = false;
function orderDeliverySubmit(){
	var order_id = $("#delivery_order_id").val();
	var buyer_id = $("#delivery_buyer_id").val();
	var order_goods_id_array = '';
	$("#Delivery .modal-body table tbody input[type = 'checkbox'][value = 0][checked]").each(function(i){
		if(0==i){
			order_goods_id_array = $(this).attr('id');
		}else{
			order_goods_id_array += (","+$(this).attr('id'));
		}
	});
	if(order_goods_id_array == ''){
		showTip("至少选择一个商品",'warning');
		return false;
	}
	var express_name = $("#divlogistics_express_company").find("option:selected").text();
	var shipping_type = $('#Delivery input[name="shipping_type"]:checked').val();
	var express_company_id = $("#divlogistics_express_company").val();
	var express_no = $("#divlogistics_express_no").val();
	if(shipping_type == 1){
		if(express_company_id == "0"){
			showTip("请选择物流公司",'warning');
			return false;
		}
		if(express_no == ""){
			showTip("请填写快递单号",'warning');
			$("#divlogistics_express_no").focus();
			return false;
		}
	}
	if(flag){
		return;
	}
	flag = true;
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/order/orderdelivery'); ?>",
		data : {'order_id':order_id,"order_goods_id_array":order_goods_id_array,"express_name":express_name,"shipping_type":shipping_type,"express_company_id":express_company_id,"express_no":express_no, "buyer_id" : buyer_id},
		success : function(data) {
			
			$("#Delivery").modal('hide');
			if (data['code'] > 0) {
				showMessage('success', data["message"],window.location.reload());
			} else {
				showMessage('error', data["message"]);
				flag = false;
			}
		}
	});
}

function deliveryCheck(event){
	var obj = $("#Delivery .modal-body table tbody input[type = 'checkbox'][value = 0][checked]");
	$("#checkedbox").html(obj.length);
}


function orderOffLinePay(order_id){
	$( "#dialog" ).dialog({
		buttons: {
			"确定": function() {
				$.ajax({
					type : "post",
					url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/order/orderofflinepay'); ?>",
					data : {'order_id':order_id},
					success : function(data) {
						if (data["code"] > 0) {
							showMessage('success', data["message"],window.location.reload());
						}else{
							showMessage('error', data["message"]);
						}
					}
				});
				$(this).dialog('close');
			},
			"取消,#f5f5f5,#666": function() {
				$(this).dialog('close');
			},
		},
		contentText:"确定线下支付吗？",
	});
}

//预售订单线下支付
function presellOrderOffLinePay(presell_order_id){
	$( "#dialog" ).dialog({
		buttons: {
			"确定": function() {
					$.ajax({
						type : "post",
						url : "<?php echo __URL('NsPresell/admin/orderpresell/presellOrderOffLinePay'); ?>",
						data : {'presell_order_id':presell_order_id},
						success : function(data) {
							if (data["code"] > 0) {
								showMessage('success', data["message"],window.location.reload());
							}else{
								showMessage('error', data["message"]);
							}
						}
					});
					$(this).dialog('close');
			},
			"取消,#f5f5f5,#666": function() {
				$(this).dialog('close');
			},
		},
		contentText:"确定线下支付吗？",
	});
}

function orderComplete(order_id){
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/order/ordercomplete'); ?>",
		data : {'order_id':order_id},
		success : function(data) {
			if (data["code"] > 0) {
				showMessage('success', data["message"],window.location.reload());
			}else{
				showMessage('error', data["message"]);
			}
		}
	});
}

function orderClose(order_id){
	$( "#dialog" ).dialog({
		buttons: {
			"确定": function() {
			$.ajax({
				type : "post",
				url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/order/orderclose'); ?>",
				data : {"order_id" : order_id},
				success : function(data) {
					if(data["code"] > 0 ){
						LoadingInfo(1);
						showMessage('success', data["message"],window.location.reload());
					}
				}
			});
			$(this).dialog('close');
			},
			"取消,#f5f5f5,#666": function() {
				$(this).dialog('close');
			},
		},
		contentText:"确定关闭订单吗？",
	});
}

//修改价格
function modifyPrice(order_id,orderFreight){
	if(orderFreight == null){
		orderFreight = 0;
	}
	orderInfo ={
		express_fee: 0,
		total: 0,
		goodsArray: []
	};
	$("#butSubmit").val(order_id);
	var str = "";
	var Total = 0.00;
	var Count = 0;
	$.ajax({
		type: "post",
		url: "<?php echo __URL('http://t.huaqi86.com/index.php/admin/order/getordergoods'); ?>",
		data: { "order_id": order_id },
		dataType: "json",
		async: false,
		success: function (jsonData) {
			var Subtotal = 0.0;
			var order_info = jsonData[1];
			if(order_info.is_virtual == 1){
				$("#edit-express-money").hide(); 
			}else{
				$("#edit-express-money").show(); 
			}
			jsonData = jsonData[0];
			for (var i = 0 ; i < jsonData.length; i++) {
				Price = (jsonData[i].price * 1);
				Count = (jsonData[i].num * 1);
				Subtotal = parseFloat(Price) * parseInt(Count);//单商品总价
				Total += parseFloat(Subtotal * 1);
				str += "<tr>";
				str += "<td>";
				str += "<div class='product-img'><img src='"+__IMG(jsonData[i]['picture_info']['pic_cover_micro']) + "'></div>";
				str += "<div class='product-infor'>";
				//原总金额
				var item_now_money = parseFloat(jsonData[i].price*jsonData[i].num)+parseFloat(jsonData[i].adjust_money);
				str += "<input type='hidden' id='total"+jsonData[i].order_goods_id+"' value='"+item_now_money*(item_now_money/parseFloat(jsonData[i].goods_money))+"'>";
				str += "<a class='name' href="+__URL('http://t.huaqi86.com/index.php/wap?id='+jsonData[i].goods_id)+" target='_blank'>" + jsonData[i].goods_name + "</a>";
				str += "<p class='specification'><span>规格:" + jsonData[i].sku_name + "</span></p>";
				str += "<div class='div-flag-style'>";
				str += "</div>";
				str += "</div>";
				str += "<input type='hidden' id='hidorderNumber' value='" + jsonData[i].order_id + "'>";
				str += "<input type='hidden' id='freighthidden' value='" + orderFreight + "'>";
				str += "<input type='hidden' id='goodsmoneyhidden' value=''>";
				str += "<input type='hidden' id='favourable' value='0'>";
				str += "</td>";
				str += "<td>";
				str += "<div class='cell'><span name='Commoditymark' count='" + jsonData[i].num + "' id='" + jsonData[i].goods_id + "' dir='" + jsonData[i].price + "' value='" + jsonData[i].price + "'>￥" + jsonData[i].price + "</span></div>";
				str += "<div class='cell' id='Count" + jsonData[i].goods_id + "' value='" + jsonData[i].num + "'>" + jsonData[i].num + "件</div>";
				str += "</td>";
				str += "<td>";
				str += "<div class='editprice-discount'><input  type='hidden' id='productPrice" + jsonData[i].order_goods_id + "' value='" + jsonData[i].price + "'><input type='hidden' id='count" + jsonData[i].goods_id + "' value='" + jsonData[i].num + "'>";
				str += "<div class='editprice-minus'><input name='caculatePrice'  onchange=\"caculatePrice()\" id='" + jsonData[i].order_goods_id + "' value='"+jsonData[i].adjust_money+"'  class='editprice-input price input-common harf' type='number'  placeholder='0'  /></div>";
				str += "</td>"; 
				
					if (i == 0) {
						if(order_info.is_virtual == 0){
							str += "<td rowspan='"+jsonData.length+"'>";
							str += "<input onchange=\"caculatePrice()\" id='Freightnumber' type='number' placeholder='0'  class='editprice-input input-common harf' value='"+order_info.shipping_money+"' ";
							if(orderFreight != 0 || orderFreight != ''){
								str += orderFreight;
							}
							str += "' min='0'/>";
							str += "<p class='muted'>直接输入邮费金额</p>";
						}
						str += "</td>";
					}
				
				$("#OrderCommodity").html(str);
				$("#goodsmoney").html(order_info.goods_money);
				$("#goodsmoneyhidden").val(Total);
				var discount_money =order_info.point_money*1.00+order_info.coupon_money*1.00+order_info.user_money*1.00+order_info.promotion_money*1.00;
				$("#discountmoney").html(discount_money);
				$("#changeTotal").html(order_info.pay_money); 
				$("#hiedchangeTotal").html(Total);
			}
			$("#modifiedFreight").html(order_info.shipping_money);
			var freight = $("#Freightnumber").val() == 0 ? 0 : $("#Freightnumber").val(); 
			$('#edit-price').modal('show');
		}
	});
}

//重新计算
function caculatePrice(){
	//设置邮费
	if($("#caculatePrice").val() < 0 || $("#Freightnumber").val() == ''){
		showTip("邮费错误！","warning");
		return false;
	}
	var Freightnumber = $("#Freightnumber").val();//邮费input
	$("#modifiedFreight").html(Freightnumber);
	//调整金额
	var price = 0.00;
	$("input[name = 'caculatePrice']").each(function(i){
		if(0 == i){
			price = parseFloat($(this).val());
		}else{
			price = parseFloat($(this).val()) + parseFloat(price);
		}
	});
	var goods_money  = $("#goodsmoneyhidden").val();
	new_goods_money = (parseFloat(price)+parseFloat(goods_money)).toFixed(2);
	if(new_goods_money <0){
		$(".price").val(-goods_money);
		caculatePrice();
	}
	$("#goodsmoney").html(new_goods_money);
	// 获取邮费
	var modifiedFreight = $("#modifiedFreight").html() ? $("#modifiedFreight").html() : 0;
	// 获取优惠金额
	var discountmoney = $("#discountmoney").html();
	//计算实收款
	new_hiedchangeTotal = (parseFloat(new_goods_money)+parseFloat(modifiedFreight)-parseFloat(discountmoney)).toFixed(2);
	$("#changeTotal").html(new_hiedchangeTotal);
}
	
/**
* 保存修改的价格
* $order_id, $goods_money, $shipping_fee
*/
function updPrice(){
	var order_id = $("#hidorderNumber").val();
	var order_goods_id_adjust_array = '';
	var shipping_fee = $("#Freightnumber").val();
	$("input[name = 'caculatePrice']").each(function(i){
		if(0 == i){
			order_goods_id_adjust_array = $(this).attr('id')+','+$(this).val();
		}else{
			order_goods_id_adjust_array += ';'+$(this).attr('id')+','+$(this).val();
		}
	});
	if(parseFloat($("#changeTotal").text()).toFixed(2) == 0.00){
		showTip("实收款最小0.01元","warning");
		return;
	}
	$.ajax({
		type: "post",
		url: "<?php echo __URL('http://t.huaqi86.com/index.php/admin/order/orderadjustmoney'); ?>",
		data: { "order_id": order_id, "order_goods_id_adjust_array":order_goods_id_adjust_array, "shipping_fee":shipping_fee},
		dataType: "json",
		async: false,
		success: function (data) {
		if (data["code"] > 0) {
				showMessage('success', data["message"],window.location.reload());
				$("#edit-price").modal("hide");
			}else{
				showMessage('error', data["message"]);
			}
		}
	});
}

//自提订单 进行提货
function pickuporder(order_id){
	$("#pickup .modal-body table tbody tr").remove();
	$("#pickup_order_id").val(order_id);
	$("#pickup").modal('show');
}

//查看订单备注
function orderSellerMemo(order_id){
	$.ajax({
		type : 'post',
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/order/getordersellermemo'); ?>",
		data : { "order_id" : order_id },
		success : function(res){
			$("#order_id").val(order_id);
			$("#memo").val(res);
			$("#Memobox").modal("show");
		}
	});
}

// 提货进行提交数据
function orderPickupSubmit(){
	var pickup_order_id = $("#pickup_order_id").val();
	var pickup_name = $("#pickup_name").val();
	var pickup_mobile = $("#pickup_mobile").val();
	var pickup_desc = $("#pickup_desc").val();
	if(pickup_name == ''){
		showTip("请填写提货人姓名","warning");
		$("#pickup_name").focus();
		return false;
	}
	if(pickup_mobile == ''){
		showTip("请填写提货人手机号","warning");
		$("#pickup_mobile").focus();
		return false;
	}
	if(pickup_mobile.search(/^1(3|4|5|7|8)\d{9}$/) == -1){
		showTip("请填写正确格式的手机号!","warning");
		$("#pickup_mobile").select();
		return false;
	}
	$.ajax({
		type: "post",
		url: "<?php echo __URL('http://t.huaqi86.com/index.php/admin/order/pickuporder'); ?>",
		data: { "order_id": pickup_order_id, "buyer_name":pickup_name, "buyer_phone":pickup_mobile, "remark":pickup_desc},
		dataType: "json",
		async: false,
		success: function (data) {
		if (data["code"] > 0) {
				showMessage('success', '提货成功',window.location.reload());
			}else{
				showMessage('error', '提货失败');
			}
		}
	});
}

//查询修改的收货地址的信息
function update_address(order_id){
	$.ajax({
		type : 'post',
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/order/getOrderUpdateAddress'); ?>",
		data : { "order_id" : order_id },
		success : function(data){
			$("#receiver_name").val(data['receiver_name']);
			$("#receiver_mobile").val(data['receiver_mobile']);
			$("#fixed_telephone").val(data['fixed_telephone']);
			$("#receiver_zip").val(data['receiver_zip']);
			var provinceid = data['receiver_province'] > 0 ? data['receiver_province'] : -1;
			var cityid = data['receiver_city'] > 0 ? data['receiver_city'] : -1;
			var districtid = data['receiver_district'] > 0 ? data['receiver_district'] : -1;
			$("#seleAreaNext").val(provinceid);
			$("#provinceid").val(provinceid);
			$("#cityid").val(cityid);
			$("#districtid").val(districtid);
			$("#seleAreaNext option[value='"+provinceid+"']").attr("selected", true);
			$("#seleAreaNext").selectric({maxHeight:500});
			GetProvince();
			getSelCity();
			var address_arr = data['receiver_address'].split('&nbsp;');
			if(address_arr[3] != undefined){
				$("#address_detail").val(address_arr[3]);
			}else{
				$("#address_detail").val("");
			}
			$("#update_address").modal('show');
			$("#update_address .modal-body table tbody tr").remove();
			$("#update_address_id").val(order_id);
		}
	});
}

//提交修改的收货地址
function updateAddressSubmit(){
	var receiver_name = $("#receiver_name").val();
	var receiver_mobile = $("#receiver_mobile").val();
	var receiver_zip = $("#receiver_zip").val();
	var seleAreaNext = $("#seleAreaNext").val();
	var seleAreaThird = $("#seleAreaThird").val();
	var seleAreaFouth = $("#seleAreaFouth").val();
	var address_detail = $("#address_detail").val();
	var order_id = $("#update_address_id").val();
	var fixed_telephone = $("#fixed_telephone").val();
	if(receiver_name == ''){
		showTip("请填写收货人姓名",'warning');
		$("#receiver_name").focus();
		return false;
	}

	if(!(/^1(3|4|5|7|8)\d{9}$/.test(receiver_mobile))){
		showTip("请填写正确格式的手机号",'warning');
		$("#receiver_mobile").focus();
		return false;
	}

	if(fixed_telephone.length > 0){
		var pattern=/(^[0-9]{3,4}\-[0-9]{3,8}$)|(^[0-9]{3,8}$)|(^\([0-9]{3,4}\)[0-9]{3,8}$)|(^0{0,1}13[0-9]{9}$)/; 
		if(!pattern.test(fixed_telephone)) { 
			showTip("请输入正确的固定电话",'warning');
			$("#fixed_telephone").focus();
			return false; 
		} 
	}

	if(seleAreaNext == '-1'){
		showTip("请选择省",'warning');
		return false;
	}

	if(seleAreaThird == '-1'){
		showTip("请选择市",'warning');
		return false;
	}
	
	if($("#seleAreaFouth option").length>1){
		if(seleAreaFouth == '-1'){
			showTip("请选择区/县",'warning');
			return false;
		}
	}
	if(address_detail == ''){
		showTip("请填写详细收货地址",'warning');
		return false;
	}
	
	$.ajax({
		type : 'post',
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/order/updateOrderAddress'); ?>",
		data : {
			"order_id" : order_id,
			"receiver_name" : receiver_name,
			"receiver_mobile" : receiver_mobile,
			"receiver_zip" : receiver_zip,
			"seleAreaNext" : seleAreaNext,
			"seleAreaThird" : seleAreaThird,
			"seleAreaFouth" : seleAreaFouth,
			"address_detail" : address_detail,
			"fixed_telephone" : fixed_telephone
		},
		success : function(data){
			if (data > 0) {
				showMessage('success', '修改收货地址成功',window.location.reload());
			}else{
				showMessage('error', '修改收货地址失败');
			}
		}
	});
}

//选择省份弹出市区
function GetProvince() {
	var id = $("#seleAreaNext").find("option:selected").val();
	var selCity = $("#seleAreaThird")[0];
	for (var i = selCity.length - 1; i >= 0; i--) {
		selCity.options[i] = null;
	}
	var opt = new Option("请选择市", "-1");
	selCity.options.add(opt);
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/order/getcity'); ?>",
		dataType : "json",
		data : {
			"province_id" : id
		},
		success : function(data) {
			if (data != null && data.length > 0) {
				for (var i = 0; i < data.length; i++) {
					var opt = new Option(data[i].city_name,data[i].city_id);
					selCity.options.add(opt);
				}
				if(typeof($("#cityid").val())!='undefined'){
					$("#seleAreaThird").val($("#cityid").val());
					getSelCity();
					$("#cityid").val('-1');
				}
				$("#seleAreaThird").selectric({maxHeight:500});
			}
		}
	});
}

// 选择市区弹出区域
function getSelCity() {
	var id = $("#seleAreaThird").find("option:selected").val();
	var selArea = $("#seleAreaFouth")[0];
	for (var i = selArea.length - 1; i >= 0; i--) {
		selArea.options[i] = null;
	}
	var opt = new Option("请选择区/县", "-1");
	selArea.options.add(opt);
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/order/getdistrict'); ?>",
		dataType : "json",
		data : {
			"city_id" : id
		},
		success : function(data) {
			if (data != null && data.length > 0) {
				for (var i = 0; i < data.length; i++) {
					var opt = new Option(data[i].district_name,data[i].district_id);
					selArea.options.add(opt);
				}
				if(typeof($("#districtid").val())!='undefined'){
					$("#seleAreaFouth").val($("#districtid").val());
					$("#districtid").val('-1');
				}
				$("#seleAreaFouth").selectric({maxHeight:500});
			}
		}
	});
}

//修改备注
function addMemoAjax(){
	var order_id = $("#order_id").val();
	var memo = $("#memo").val();
	if(memo == ''){
		$(".error").css("display","block");
		return false;
	}
	$.ajax({
		url: "<?php echo __URL('http://t.huaqi86.com/index.php/admin/order/addmemo'); ?>",
		data: { "order_id": order_id,"memo":memo },
		type : "post",
		success: function(data) {
			if (data.code > 0) {
				showMessage('success','保存成功');
				location.reload();
			}else{
				showMessage('error','保存失败');
			}
		}
	});
}

function getdelivery(order_id){	
	$( "#dialog" ).dialog({
		buttons: {
			"确定": function() {
				$.ajax({
					url: "<?php echo __URL('http://t.huaqi86.com/index.php/admin/order/orderTakeDelivery'); ?>",
					data: { "order_id": order_id },
					type : "post",
					success: function(data) {
						if (data.code > 0) {
							showMessage('success','确认收货成功');
							location.reload();
						}else{
							showMessage('error','确认收货失败');
						}
					}
				});
			$(this).dialog('close');
			},
			"取消,#f5f5f5,#666": function() {
				$(this).dialog('close');
			},
		},
		contentText:"您确定要收货吗？",
	});
}

 //删除订单
function delete_order(order_id){
	$( "#dialog" ).dialog({
		buttons: {
			"确定": function() {
			$.ajax({
				type : "post",
				url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/order/deleteOrder'); ?>",
				data : {"order_id" : order_id.toString()},
				success : function(data) {
					if(data["code"] > 0 ){
						if(typeof LoadingInfo !="undefined"){
							LoadingInfo(1);
							showMessage('success', data["message"], location.reload());
						}else{
							showMessage('success', data["message"], "<?php echo __URL('http://t.huaqi86.com/index.php/admin/order/orderlist'); ?>");
						}
					}
				}
			});
			$(this).dialog('close');
			},
			"取消,#f5f5f5,#666": function() {
				$(this).dialog('close');
			},
		},
		contentText:"确定要删除订单吗？",
	});
}
 
//显示运单
function updateExpress(order_id){
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/order/orderdeliverydata'); ?>",
		data : {'order_id':order_id},
		success : function(data) {
			$("#order_goods_express_id").val(data['order_info']['goods_packet_list'][0]['express_id']);
			var receiver_info = '收货信息：'+data['order_info']['address']+'&nbsp;'+data['order_info']['receiver_address']+'&nbsp;'+data['order_info']['receiver_name']+'&nbsp;'+data['order_info']['receiver_mobile'];//收货信息
			$("#receiver_infos").html(receiver_info);
			var express_company_id = data['order_info']['goods_packet_list'][0]['express_company_id'];
			var express_code = data['order_info']['goods_packet_list'][0]['express_code'];
			var co_html = '';
			co_html += '<option value="0">请选择物流公司</option>';
			for(var i=0;i<data['express_company_list'].length;i++){
				
				if(data['express_company_list'][i]['is_enabled'] == '1'){
					var co_id = data["express_company_list"][i]["co_id"];
					if(express_company_id == co_id){
						co_html += '<option value="'+data["express_company_list"][i]["co_id"]+'" selected >'+data["express_company_list"][i]["company_name"]+'</option>';
					}
					else
					{
						co_html += '<option value="'+data["express_company_list"][i]["co_id"]+'">'+data["express_company_list"][i]["company_name"]+'</option>';
					}
				}
			} 
			$("#update_divlogistics_express_company").html(co_html);
			$("#update_divlogistics_express_no").val(express_code);
			$("#update_express").modal("show");
			
		}
	});	
	
}
 
//修改运单
var flags = false;
function updateExpressAjax(){

		var order_goods_express_id = $("#order_goods_express_id").val();
		var express_name = $("#update_divlogistics_express_company").find("option:selected").text();
		var shipping_type = $('#update_express input[name="shipping_type_update"]:checked ').val();
		var express_company_id = $("#update_divlogistics_express_company").val();
		var express_no = $("#update_divlogistics_express_no").val();
		if(shipping_type == 1){
			if(express_company_id == "0"){
				showTip("请选择物流公司",'warning');
				return false;
			}
			if(express_no == ""){
				showTip("请填写快递单号",'warning');
				$("#update_divlogistics_express_no").focus();
				return false;
			}
		}
		if(flags){
			return;
		}
		flags = true;
		$.ajax({
			type : "post",
			url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/order/updateOrderExpress'); ?>",
			data : {'order_goods_express_id':order_goods_express_id,"express_name":express_name,"shipping_type":shipping_type,"express_company_id":express_company_id,"express_no":express_no},
			success : function(data) {
				$("#Delivery").modal('hide');
				if (data['code'] > 0) {
					showMessage('success', data["message"],window.location.reload());
				} else {
					showMessage('error', data["message"]);
					flags = false;
				}
			}
		});
	}

/**
 * 弹出本地配送模态框
 */
function o2o_delivery(order_id){
	$("#o2o_Delivery").modal('show');
	$("#o2o_delivery_order_id").val(order_id);
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/order/o2odeliverydata'); ?>",
		data : {'order_id':order_id},
		success : function(data) {
			$("#delivery_order_id").val(order_id);
			var receiver_info = '收货信息：'+data['order_info']['address']+'&nbsp;'+data['order_info']['receiver_address']+'&nbsp;'+data['order_info']['receiver_name']+'&nbsp;'+data['order_info']['receiver_mobile'];//收货信息
			$("#receiver_info").html(receiver_info);
			var co_html = '';
			co_html += '<option value="0">请选择配送人员</option>';
			for(var i=0;i<data['o2o_delivery_user_list'].length;i++){
				co_html += '<option value="'+data["o2o_delivery_user_list"][i]["id"]+'">'+data["o2o_delivery_user_list"][i]["name"]+ "&nbsp;&nbsp;" +data["o2o_delivery_user_list"][i]["mobile"] + '</option>';
			} 
			$("#o2o_delivery_user").html(co_html).addClass('select-common').selectric({maxHeight:500});
			
			var go_html = '';
			var no_shipping_num = 0;
			for(var i=0;i<data['order_goods_list'].length;i++){
				if(data['order_goods_list'][i]['shipping_status'] == 0){
					no_shipping_num++;
				}
				go_html += '<tr>';
					go_html += '<td><a>'+data['order_goods_list'][i]['goods_name']+'</a></td>';
					go_html += '<td>'+data['order_goods_list'][i]['num']+'</td>';
				go_html += '</tr>';
			}
			$("#o2o_shipping_num").html(no_shipping_num);
			$("#o2o_Delivery .modal-body table tbody").html(go_html);
		}
	});
}

/**
 * 本地配送提交
 */
var o2o_flag = false;
function o2oDeliverySubmit(){
	var order_id = $("#o2o_delivery_order_id").val();
	var o2o_delivery_user_id = $("#o2o_delivery_user").val();
	var o2o_delivery_no = $("#o2o_delivery_no").val();
	var remark = $("#o2o_Delivery .remark").val();

	if(o2o_delivery_user_id == "0"){
		showTip("请选择配送人员",'warning');
		$("#o2o_delivery_user").focus();
		return false;
	}
	 if(o2o_delivery_no == ""){
		showTip("请填写配送单号",'warning');
		$("#o2o_delivery_no").focus();
		return false;
	} 
	
	if(o2o_flag){
		return;
	}
	o2o_flag = true;
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/order/o2odelivery'); ?>",
		data : {
			'order_id': order_id,
			'o2o_delivery_user_id': o2o_delivery_user_id,
			'o2o_delivery_no': o2o_delivery_no,
			'remark': remark
		},
		success : function(data) {
			$("#o2o_Delivery").modal('hide');
			if (data['code'] > 0) {
				showMessage('success', data["message"],window.location.reload());
			} else {
				showMessage('error', data["message"]);
				o2o_flag = false;
			}
		}
	});
}

//备货完成
function presellStockingComplete(order_id){
	$( "#dialog" ).dialog({
		buttons: {
			"确定": function() {
			$.ajax({
				type : "post",
				url : "<?php echo __URL('NsPresell/admin/Orderpresell/orderStockingComplete'); ?>",
				data : {"order_id" : order_id},
				success : function(data) {
					if(data["code"] > 0 ){
						
						if(order_id > 0){
							showMessage('success', data["message"],window.location.reload());
						}else{
							LoadingInfo(1);
						}
						
					}
				}
			});
			$(this).dialog('close');
			},
			"取消,#f5f5f5,#666": function() {
				$(this).dialog('close');
			},
		},
		contentText:"确定设为备货完成吗？",
	});
}

// 收到货款
function received_payment(order_id){
	$( "#dialog" ).dialog({
		buttons: {
			"确定": function() {
			$.ajax({
				type : "post",
				url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/order/receivedPayment'); ?>",
				data : {"order_id" : order_id},
				success : function(data) {
					if(data["code"] > 0 ){
						LoadingInfo(1);
						showMessage('success', data["message"],window.location.reload());
					}
				}
			});
			$(this).dialog('close');
			},
			"取消,#f5f5f5,#666": function() {
				$(this).dialog('close');
			},
		},
		contentText:"您确定已经收到货款了吗？",
	});
}
</script>