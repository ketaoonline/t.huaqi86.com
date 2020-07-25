<?php if (!defined('THINK_PATH')) exit(); /*a:11:{s:35:"template/admin/Goods/goodsList.html";i:1588036547;s:51:"/www/wwwroot/t.huaqi86.com/template/admin/base.html";i:1589944662;s:68:"/www/wwwroot/t.huaqi86.com/template/admin/controlCommonVariable.html";i:1557195638;s:55:"/www/wwwroot/t.huaqi86.com/template/admin/urlModel.html";i:1552613544;s:71:"/www/wwwroot/t.huaqi86.com/template/admin/Goods/goodsThreeCategory.html";i:1575977953;s:73:"/www/wwwroot/t.huaqi86.com/template/admin/Goods/batchProcessingModal.html";i:1555925609;s:75:"/www/wwwroot/t.huaqi86.com/template/admin/Goods/setMemberDiscountModal.html";i:1557054315;s:65:"/www/wwwroot/t.huaqi86.com/template/admin/Goods/goodsSkuEdit.html";i:1555663016;s:57:"/www/wwwroot/t.huaqi86.com/template/admin/pageCommon.html";i:1556191159;s:57:"/www/wwwroot/t.huaqi86.com/template/admin/openDialog.html";i:1575977953;s:64:"/www/wwwroot/t.huaqi86.com/template/admin/Goods/goodsAction.html";i:1562052023;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
	<meta name="renderer" content="webkit" />
	<meta http-equiv="X-UA-COMPATIBLE" content="IE=edge,chrome=1"/>
	<?php if($frist_menu['module_name']=='首页'): ?>
	<title><?php echo $title_name; ?> - 商家管理</title>
	<?php else: ?>
		<title><?php echo $title_name; ?> - <?php echo $frist_menu['module_name']; ?>管理</title>
	<?php endif; ?>
	<link rel="shortcut icon" type="image/x-icon" href="/public/static/images/favicon.ico" media="screen"/>
	<link rel="stylesheet" type="text/css" href="/public/static/blue/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="/public/static/blue/css/ns_blue_common.css" />
	<link rel="stylesheet" type="text/css" href="/public/static/blue/css/ns_blue_common_new.css" />
	<link rel="stylesheet" type="text/css" href="/public/static/font-awesome/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="/public/static/simple-switch/css/simple.switch.three.css" />
	<link rel="stylesheet" type="text/css" href="/template/admin/public/css/selectric.css" />
	<link rel="stylesheet" type="text/css" href="/template/admin/public/css/iconfont.css" />
	<link rel="stylesheet" type="text/css" href="/template/admin/public/css/new.css" />
	<link rel="stylesheet" type="text/css" href="/template/admin/public/css/honeySwitch.css" />
	<style>
	.Switch_FlatRadius.On span.switch-open{background-color: #4685fd;border-color: #4685fd;}
	.Switch_FlatRadius span.switch-close{background-color: #c8c8ca; border-color: #c8c8ca}
	/*#copyright_meta a{color:#333;}*/
	.fa-wechat-applet:before{content:'';display:inline-block;width:20px;height:20px;background:#FFF url(/public/static/images/wechat_applet.png) no-repeat;background-size: 100%;}
	</style>
	<script src="/public/static/js/jquery-1.8.1.min.js"></script>
	<script src="/public/static/bootstrap/js/bootstrap.js"></script>
	<script src="/public/static/bootstrap/js/bootstrapSwitch.js"></script>
	<script src="/public/static/simple-switch/js/simple.switch.js"></script>
	<script src="/public/static/js/jquery.unobtrusive-ajax.min.js"></script>
	<script src="/public/static/js/common.js"></script>
	<script src="/public/static/js/seller.js"></script>
	<script src="/template/admin/public/js/layer/layer.js"></script>
	<script src="/template/admin/public/js/jquery-ui.min.js"></script>
	<script src="/template/admin/public/js/ns_tool.js"></script>
	<script src="/template/admin/public/js/jquery.selectric.js"></script>
	<script src="/template/admin/public/js/honeySwitch.js"></script>
	<link rel="stylesheet" type="text/css" href="/public/static/blue/css/ns_table_style.css">
	<script>
	/**
	 * Niushop商城系统 - 团队十年电商经验汇集巨献!
	 * ========================================================= Copy right
	 * 2015-2025 山西牛酷信息科技有限公司, 保留所有权利。
	 * ---------------------------------------------- 官方网址:
	 * http://www.niushop.com.cn 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用。
	 * 任何企业和个人不允许对程序代码以任何形式任何目的再发布。
	 * =========================================================
	 */
	var PLATFORM_NAME = "<?php echo $title_name; ?>";
	var ADMINIMG = "/template/admin/public/images";//后台图片请求路径
	var ADMINMAIN = "http://t.huaqi86.com/index.php/admin";//后台请求路径
	var SHOPMAIN = "http://t.huaqi86.com/index.php";//PC端请求路径
	var APPMAIN = "http://t.huaqi86.com/index.php/wap";//手机端请求路径
	var UPLOAD = "";//上传文件根目录
	var PAGESIZE = "<?php echo $pagesize; ?>";//分页显示页数
	var ROOT = "";//根目录
	var ADDONS = "/addons";
	var STATIC = "/public/static";
</script>
	
<link rel="stylesheet" type="text/css" href="/template/admin/public/css/product.css">
<script type="text/javascript" src="/public/static/My97DatePicker/WdatePicker.js"></script>

<style type="text/css">
#productTbody tr:hover i.edit-sign{opacity: 1}
#productTbody td{padding:5px;font-size:12px;}
/* .tr-title td{border-top: 1px solid #E1E6F0;} */
.a-pro-view-img {float: left;}
.thumbnail-img {width: 60px;margin-right: 10px;height: 60px;}
.cell i {display: block;}
.remodal-bg.with-red-theme.remodal-is-opening,.remodal-bg.	with-red-theme.remodal-is-opened {filter: none;}
.remodal-overlay.with-red-theme {background-color: #f44336;}
.remodal.with-red-theme {background: #fff;}
input[type="radio"], input[type="checkbox"] {margin: -1px 5px 0 0;}
.edit-group{border-bottom: 1px solid #ebebeb;margin-bottom:10px;max-height: 280px;overflow-y: auto;}
.edit-group::-webkit-scrollbar{width: 3px;height: 2px;}
.edit-group::-webkit-scrollbar-track{background-color: #fff;}
.edit-group::-webkit-scrollbar-thumb{background-color: #ddd;}
.edit-group label{font-weight:normal;}
.edit-group-title{height:15px;line-height:15px;width:140px;margin-top:3px;margin-bottom:3px;color:#4685fd;}
.edit-group-button{border: 1px solid #bbb;height: 26px;line-height: 24px;padding: 0 5px;}
.group-button-bg{background: #3283fa;color: #fff;}
.div-pro-view-name {width: 100%;min-height: 60px;}
i.hot,i.recommend,i.new,i.goods_group{font-size:12px;margin-right:5px;font-style:normal;color:#fff;background-color:#FF6600;border-radius:2px;padding:1px 4px;position: relative;top:-5px;cursor: pointer;}
.icon-qrcode:before {content: "\f029";}
[class^="icon-"]:before, [class*=" icon-"]:before {text-decoration: inherit;display: inline-block;speak: none;}
[class^="icon-"], [class*=" icon-"] {font-family: FontAwesome;font-weight: normal;font-style: normal;text-decoration: inherit;-webkit-font-smoothing: antialiased;}
input[type=number] {-moz-appearance:textfield;}
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {-webkit-appearance: none;margin: 0;}
input, textarea, .uneditable-input {width: 147px;}
.table th, .table td {vertical-align: middle;}
.recommendBox{width: 360px;display: inline-block;float: right;}
.introduction_box{width: 360px;display: inline-block;float: right;}
.tab-content{overflow: visible;}
.editGoodsIntroduction{display: inline-block;border:1px dashed #fff;padding: 0;width: 341px;line-height: 25px;max-height: 60px;overflow: hidden;text-overflow: ellipsis;height: 25px;}
.editGoodsIntroduction:hover{border-color: #ddd;cursor: pointer;}
.editGoodsIntroduction + input{padding: 0 5px;width: 350px;line-height: 25px;height: 25px;background: #EEF7FF;display: none;margin:0 0 10px !important;}
.editGoodsIntroduction>a{margin-left:0 !important;}
.goods-fields-sort{cursor:pointer;}
.goods-fields-sort span{width: 11px;display: inline-block;margin-left: 0px;vertical-align: middle;position: absolute;font-size: 12px;}
.more-search{line-height: 20px;background: #fff;outline: none;font-size: 17px;}
.interval{width: 2px;display: inline-block;}
.btn-common-white,.btn-common{outline: none;line-height: 20px;display: inline-block;}
@media screen and (max-width:1260px) {
	a.btn-common{margin-bottom:5px !important;}
}
/* 商品规格项展示 */
.table-class tbody td a{margin-left: 0px;}
.single-goods-sku{
	height: 1px;
}
.single-goods-sku .single-item{
	float: left;
	border-left: 1px dashed #E1E6F0;
	min-width: 110px;
	padding: 10px;
	cursor: pointer;
}
.single-goods-sku .single-item:FIRST-CHILD {
	border-left:0px;
}
.single-goods-sku .single-item .hold-img{
	height: 60px;
    border: 1px solid #E1E6F0;
    padding: 5px;
}
.hold-img img{max-width: 100%;max-height: 100%;}
.single-goods-sku .single-item p{
	margin: 0px;
    width: 100px;
    display:block;
	white-space:nowrap;
	overflow:hidden;
	text-overflow:ellipsis;
}
.single-goods-sku .single-item p.spec-title{
    margin-top: 5px;
}
.single-item .row-term p{width: 100px; text-align: left; }
.single-item .row-term p .row-title{
	display: inline-block;
	text-align: left;
}
.single-item .hold-btn{
    text-align: left;
    padding-left: 5px;
}
.goods-sku-click{display: inline-block;float: left;margin: 37px 0px;}
.fx-radio-block{margin:0;}
.div-flag-style{
    display: inline-block;
    position: relative;
    cursor: pointer;
}

/* 二维码 */
.QRcode{
    position: absolute;
    width: 110px;
    top: 21px;
    left: 0px;
    z-index: 10;
    border: 1px solid rgb(230, 233, 240);
    background: rgb(255, 255, 255);
    padding: 5px;
    display: none;
}
.QRcode p{margin: 0px}

.goods-type{width: 850px;margin: 30px auto 0px;}
.goods-type .type-title{
	font-size: 23px;
    font-weight: 100;
    text-align: center;
    margin-bottom: 10px;
}
.goods-type .item-type{   
	width: 31%;
    border: 1px solid #e6e9f0;
    display: inline-block;
    margin: 20px 1% 0px;
    padding: 30px 0px 30px 20px;
    box-sizing: border-box;
	cursor: pointer;
	height: 120px;
}
.goods-type .item-type:hover{background: #f5f7fa;}
.goods-type .item-type div{display: inline-block;float: left;height: 50px;width: 50px;}
.goods-type .item-type div.item-content{margin-left: 10px; width: 170px;}
.goods-type .item-type div.item-content p{margin-bottom: 0px;}
.goods-type .item-type div.item-content p.name{margin-top: 2px;}
.goods-type .item-type div.item-content p.description{color: #999;font-size: 12px;margin-top: 7px;}
.goods-sku-click{width: 15px;text-align: center;font-size: 14px;}
.fx-value{margin-left: 5px;}
.fx-value.open{border: 1px solid #F06121;border-radius: 3px;padding: 1px 2px;color: #F06121;}
.fx-value.no-open{border: 1px solid #4CAF50;border-radius: 3px;padding: 1px 2px;color: #4CAF50;}
.mytable th .selectric {border-radius: 2px;top: -1px;}
.mytable {margin-top: 0px !important;}
.popover-content .search-input{padding-right: 20px;border: none !important;box-shadow: none !important; border-bottom:1px solid #eee !important;}
.popover-content .input-box{position:relative}
.popover-content .input-box i{position:absolute;top: 2px;right: 0px;width: 15px;cursor:pointer} 


</style>

	</head>
<body>
<input type="hidden" id="niushop_rewrite_model" value="<?php echo rewrite_model(); ?>">
<input type="hidden" id="niushop_url_model" value="<?php echo url_model(); ?>">
<input type="hidden" id="niushop_admin_model" value="<?php echo admin_model(); ?>">
<script>
function __URL(url){
	url = url.replace('http://t.huaqi86.com/index.php', '');
	url = url.replace('http://t.huaqi86.com/index.php/wap', 'wap');
	url = url.replace('http://t.huaqi86.com/index.php/admin', $("#niushop_admin_model"));
	if(url == ''|| url == null){
		return 'http://t.huaqi86.com/index.php';
	}else{
		var str=url.substring(0, 1);
		if(str=='/' || str=="\\"){
			url=url.substring(1, url.length);
		}
		if($("#niushop_rewrite_model").val()==1 || $("#niushop_rewrite_model").val()==true){
			return 'http://t.huaqi86.com/index.php/'+url;
		}
		var action_array = url.split('?');
		//检测是否是pathinfo模式
		url_model = $("#niushop_url_model").val();
		if(url_model==1 || url_model==true){
			var base_url = 'http://t.huaqi86.com/index.php/'+action_array[0];
			var tag = '?';
		}else{
			var base_url = 'http://t.huaqi86.com/index.php?s=/'+ action_array[0];
			var tag = '&';
		}
		if(action_array[1] != '' && action_array[1] != null){
			return base_url + tag + action_array[1];
		}else{
			return base_url;
		}
	}
}

//处理图片路径
function __IMG(img_path){
	var path = "";
	if(img_path != undefined && img_path != ""){
		if(img_path.indexOf("http://") == -1 && img_path.indexOf("https://") == -1){
			path = UPLOAD+"\/"+img_path;
		}else{
			path = img_path;
		}
	}
	return path;
}
</script>
<article class="ns-base-article">

	<header class="ns-base-header">
		<div class="ns-logo" onclick="location.href='<?php echo __URL('http://t.huaqi86.com/index.php/admin'); ?>';"></div>
		<div class="ns-search">
			<div class="nav-menu js-nav">
				<img src="/public/static/blue/img/nav_menu.png" title="导航管理" />
			</div>
			<div class="ns-navigation-management">
				<div class="ns-navigation-title">
					<h4>导航管理</h4>
					<span>x</span>
				</div>
				<div style="height:40px;"></div>
				<?php if(is_array($nav_list) || $nav_list instanceof \think\Collection || $nav_list instanceof \think\Paginator): if( count($nav_list)==0 ) : echo "" ;else: foreach($nav_list as $key=>$nav): ?>
				<dl>
					<dt><?php echo $nav['data']['module_name']; ?></dt>
					<?php if(is_array($nav['sub_menu']) || $nav['sub_menu'] instanceof \think\Collection || $nav['sub_menu'] instanceof \think\Paginator): if( count($nav['sub_menu'])==0 ) : echo "" ;else: foreach($nav['sub_menu'] as $key=>$nav_sub): ?>
					<dd>
						<?php if($nav_sub['module'] == 'admin'): ?>
						<a href="<?php echo __URL('http://t.huaqi86.com/index.php/admin/'.$nav_sub['url']); ?>"><?php echo $nav_sub['module_name']; ?></a>
						<?php else: ?>
						<a href="<?php echo __URL('http://t.huaqi86.com/index.php/'.$nav_sub['module'].'/admin/'.$nav_sub['url']); ?>"><?php echo $nav_sub['module_name']; ?></a>
						<?php endif; ?>
					</dd>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</dl>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
			 <div class="ns-search-block">
				<i class="fa fa-search" title="搜索"></i>
				<span></span>
				<div class="mask-layer-search">
					<input type="text" id="search_goods" placeholder="搜索" />
					<a href="javascript:search();"><img src="/public/static/blue/img/enter.png"/></a>
				</div>
			</div> 
		</div>
		<nav>
			<ul>
				<?php if(is_array($headlist) || $headlist instanceof \think\Collection || $headlist instanceof \think\Paginator): if( count($headlist)==0 ) : echo "" ;else: foreach($headlist as $key=>$per): if(strtoupper($per['module_id']) == $headid): if($per['module'] == 'admin'): ?>
					<li class="selected" onclick="location.href='<?php echo __URL('http://t.huaqi86.com/index.php/admin/'.$per['url']); ?>';">
					<?php else: ?>
					<li class="selected" onclick="location.href='<?php echo __URL('http://t.huaqi86.com/index.php/'.$per['module'].'/admin/'.$per['url']); ?>';">
					<?php endif; ?>
				
					<span><?php echo $per['module_name']; ?></span>
					<?php if($per['module_id'] == 10000): ?>
						<span class="is-upgrade"></span>
					<?php endif; ?>
				</li>
				
				<?php else: if($per['module'] == 'admin'): ?>
					<li  onclick="location.href='<?php echo __URL('http://t.huaqi86.com/index.php/admin/'.$per['url']); ?>';">
					<?php else: ?>
					<li  onclick="location.href='<?php echo __URL('http://t.huaqi86.com/index.php/'.$per['module'].'/admin/'.$per['url']); ?>';">
					<?php endif; ?>
				
					<span><?php echo $per['module_name']; ?></span>
					<?php if($per['module_id'] == 10000): ?>
						<span class="is-upgrade"></span>
					<?php endif; ?>
				</li>
				<?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</ul>
			
<!-- 			<div class="ns-base-header-search"> -->
<!-- 				<input type="text" id="search_goods" placeholder="请输入关键词"> -->
<!-- 				<a href="javascript:search();"><img src="/public/static/blue/img/icon-search.png"></a> -->
<!-- 			</div> -->
			
		</nav>
		<div class="ns-base-tool">
			<div class="ns-help">
				<div class="logo">
				<?php if($user_headimg != ''): ?>
				<img src="<?php echo __IMG($user_headimg); ?>"/>
				<?php else: ?>
				<img src="/public/static/blue/img/user_admin_blue.png" >
				<?php endif; ?>
				</div>
				<span><?php echo $user_name; ?></span>
				<i class="fa fa-angle-down"></i>
				<ul>
					<li onclick="window.open('<?php echo __URL('http://t.huaqi86.com/index.php'); ?>')">
						<img src="/public/static/blue/img/admin-icon-home.png"/>
						<a href="javascript:;" target= _blank data-toggle="modal" title="商城首页">首页</a>
					</li>
					<div class="line"></div>
					<li title="清理缓存" onclick="delcache()">
						<img src="/public/static/blue/img/admin-icon-cache.png"/>
						<a href="javascript:;">清理缓存</a>
					</li>
					<div class="line"></div>
					<li title="修改密码" onclick="editpassword()">
						<img src="/public/static/blue/img/admin-icon-pwd.png"/>
						<a href="javascript:;" title="修改密码">修改密码</a>
					</li>
					<div class="line"></div>
					<li title="加入收藏" onclick="addFavorite()">
						<img src="/public/static/blue/img/admin-icon-collect.png"/>
						<a href="javascript:;">加入收藏</a>
					</li>
					<li title="退出登录" class="admin-exit" onclick="window.location.href='<?php echo __URL('http://t.huaqi86.com/index.php/admin/login/logout'); ?>'">
						<a href="javascript:;">退出登录</a>
						<img src="/public/static/blue/img/admin-icon-close.png" />
					</li>
				</ul>
			</div>
		</div>
	</header>
	
	<aside class="ns-base-aside">
		<div class="ns-main-block">
			
			<h3 style="margin-top:55px;">
				<?php if(is_array($headlist) || $headlist instanceof \think\Collection || $headlist instanceof \think\Paginator): if( count($headlist)==0 ) : echo "" ;else: foreach($headlist as $key=>$per): if(strtoupper($per['module_id']) == $headid): ?>
					<span class="<?php echo $per['module_name']; ?>"><?php echo $per['module_name']; ?></span>
					<i class="fa fa-caret-down"></i>
				<?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</h3>
			
			<nav>
				<ul>
					<?php if(is_array($leftlist) || $leftlist instanceof \think\Collection || $leftlist instanceof \think\Paginator): if( count($leftlist)==0 ) : echo "" ;else: foreach($leftlist as $key=>$leftitem): if(strtoupper($leftitem['module_id']) == $second_menu_id): if($leftitem['module'] == 'admin'): ?>
						<li class="selected" onclick="location.href='<?php echo __URL('http://t.huaqi86.com/index.php/admin/'.$leftitem['url']); ?>';" title="<?php echo $leftitem['module_name']; ?>"><i class="iconfont <?php echo $leftitem['icon_class']; ?> left-menu-icon"></i><?php echo $leftitem['module_name']; ?></li>
						<?php else: ?>
						<li class="selected" onclick="location.href='<?php echo __URL('http://t.huaqi86.com/index.php/'.$leftitem['module'].'/admin/'.$leftitem['url']); ?>';" title="<?php echo $leftitem['module_name']; ?>"><i class="iconfont <?php echo $leftitem['icon_class']; ?> left-menu-icon"></i><?php echo $leftitem['module_name']; ?></li>
						<?php endif; else: if($leftitem['module'] == 'admin'): ?>
						<li onclick="location.href='<?php echo __URL('http://t.huaqi86.com/index.php/admin/'.$leftitem['url']); ?>';" title="<?php echo $leftitem['module_name']; ?>"><i class="iconfont <?php echo $leftitem['icon_class']; ?> left-menu-icon"></i><?php echo $leftitem['module_name']; ?></li>
						<?php else: ?>
						<li onclick="location.href='<?php echo __URL('http://t.huaqi86.com/index.php/'.$leftitem['module'].'/admin/'.$leftitem['url']); ?>';" title="<?php echo $leftitem['module_name']; ?>"><i class="iconfont <?php echo $leftitem['icon_class']; ?> left-menu-icon"></i><?php echo $leftitem['module_name']; ?></li>
						<?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
					<!-- 快捷菜单列表 -->
					<?php if($is_show_shortcut_menu == 1): if(is_array($shortcut_menu_list) || $shortcut_menu_list instanceof \think\Collection || $shortcut_menu_list instanceof \think\Paginator): $i = 0; $__LIST__ = $shortcut_menu_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;if($menu['module'] == 'admin'): ?>
						<li onclick="location.href='<?php echo __URL('http://t.huaqi86.com/index.php/admin/'.$menu['url']); ?>';" title="<?php echo $menu['module_name']; ?>"><i class="iconfont <?php echo $menu['icon_class']; ?> left-menu-icon"></i><?php echo $menu['module_name']; ?></li>
						<?php else: ?>
						<li onclick="location.href='<?php echo __URL('http://t.huaqi86.com/index.php/'.$menu['module'].'/admin/'.$menu['url']); ?>';" title="<?php echo $menu['module_name']; ?>"><i class="iconfont <?php echo $menu['icon_class']; ?> left-menu-icon"></i><?php echo $menu['module_name']; ?></li>
						<?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>
				</ul>
				<!-- 快捷菜单设置按钮 -->
				<?php if($is_show_shortcut_menu == 1): ?>
				<div class="shortcut-menu" onclick="show_shortcut_menu()">
					<span></span>
					常用功能
				</div>
				<?php endif; ?>
			</nav>
			
			<div style="height:90px;"></div>
			
			<div id="bottom_copyright">
				<footer>
					<?php if($copy_right_info['is_load']>0): if(!(empty($copy_right_info['bottom_info']['copyright_logo']) || (($copy_right_info['bottom_info']['copyright_logo'] instanceof \think\Collection || $copy_right_info['bottom_info']['copyright_logo'] instanceof \think\Paginator ) && $copy_right_info['bottom_info']['copyright_logo']->isEmpty()))): ?>
					<img id="copyright_logo" src="<?php echo __IMG($copy_right_info['bottom_info']['copyright_logo']); ?>"/>
					<?php else: ?>
					<img id="copyright_logo" src="/public/static/blue/img/logo.png"/>
					<?php endif; endif; ?>
 					<!-- <p>
					    <?php if($copy_right_info['is_load']>0): if(!(empty($copy_right_info['bottom_info']['copyright_desc']) || (($copy_right_info['bottom_info']['copyright_desc'] instanceof \think\Collection || $copy_right_info['bottom_info']['copyright_desc'] instanceof \think\Paginator ) && $copy_right_info['bottom_info']['copyright_desc']->isEmpty()))): ?>
					    <span id="copyright_desc"><?php echo $copy_right_info['bottom_info']['copyright_desc']; ?></span>
					    <?php else: ?>
 						<span id="copyright_desc">Copyright © 2015-2019 NiuShop开源商城&nbsp;版权所有</span>
					    <?php endif; ?>
 						<br/>
					    <?php if(!(empty($copy_right_info['bottom_info']['copyright_companyname']) || (($copy_right_info['bottom_info']['copyright_companyname'] instanceof \think\Collection || $copy_right_info['bottom_info']['copyright_companyname'] instanceof \think\Paginator ) && $copy_right_info['bottom_info']['copyright_companyname']->isEmpty()))): ?>
					    <a id="copyright_companyname" href="<?php if(!(empty($copy_right_info['bottom_info']['copyright_link']) || (($copy_right_info['bottom_info']['copyright_link'] instanceof \think\Collection || $copy_right_info['bottom_info']['copyright_link'] instanceof \think\Paginator ) && $copy_right_info['bottom_info']['copyright_link']->isEmpty()))): ?><?php echo $copy_right_info['bottom_info']['copyright_link']; else: ?>http://www.niushop.com.cn<?php endif; ?>" target="_blank"><?php echo $copy_right_info['bottom_info']['copyright_companyname']; ?></a>
					    <?php else: ?>
 						<a id="copyright_companyname" href="http://www.niushop.com.cn" target="_blank">山西牛酷信息科技有限公司&nbsp;提供技术支持</a>
					    <?php endif; ?>
 						<br/>
					    <?php endif; if(!(empty($copy_right_info['bottom_info']['copyright_meta']) || (($copy_right_info['bottom_info']['copyright_meta'] instanceof \think\Collection || $copy_right_info['bottom_info']['copyright_meta'] instanceof \think\Paginator ) && $copy_right_info['bottom_info']['copyright_meta']->isEmpty()))): ?>
 						<span id="copyright_meta">
						    <a href='http://www.beian.miit.gov.cn' target='_blank'><?php echo $copy_right_info['bottom_info']['copyright_meta']; ?></a>
					    </span>
					    <?php endif; ?>
 					</p> -->
				</footer>
			</div>
		</div>
	</aside>
	
	<section class="ns-base-section">
		
		
		
		<div style="position:relative;margin:0;background:#fff" class="breadcrumb-nav-box">
			<!-- 面包屑导航 -->
			<?php if(!isset($is_index)): ?>
			<div class="breadcrumb-nav">
				<a href="<?php echo __URL('http://t.huaqi86.com/index.php/admin'); ?>"><?php echo $title_name; ?></a>
				<?php if(!(empty($bread_crumb) || (($bread_crumb instanceof \think\Collection || $bread_crumb instanceof \think\Paginator ) && $bread_crumb->isEmpty()))): if(is_array($bread_crumb) || $bread_crumb instanceof \think\Collection || $bread_crumb instanceof \think\Paginator): if( count($bread_crumb)==0 ) : echo "" ;else: foreach($bread_crumb as $k=>$menu): if($k == count($bread_crumb) - 1): ?>
							<i class="fa fa-angle-right" style=""></i>
							<a href="javascript:;" style="">
						<?php else: ?>
							<i class="fa fa-angle-right"></i>
							<?php if($menu['module'] == 'admin'): ?>
								<a href="<?php echo __URL('http://t.huaqi86.com/index.php/admin/'.$menu['url']); ?>">
							<?php else: ?>
								<a href="<?php echo __URL('http://t.huaqi86.com/index.php/'.$menu['module'].'/admin/'.$menu['url']); ?>">
							<?php endif; endif; ?>
						<?php echo $menu['module_name']; ?></a>
					<?php endforeach; endif; else: echo "" ;endif; endif; ?>
			</div>
			<div class="empty-bg"></div>
			<?php endif; ?>

			<div class="right-side-operation hide">
				<ul>
					
					
<!-- 					<?php if($warm_prompt_is_show == 'show'): ?>style="display:none;"<?php endif; ?> style="display:block;" -->
					<li>
						<a class="js-open-warmp-prompt " href="javascript:;" data-menu-desc=''><i class="fa fa-question-circle"></i>&nbsp;提示</a>
						<div class="popover">
							<div class="arrow"></div>
							<div class="popover-content">
								<div>
									<?php if($secend_menu['desc']): ?>
									<h4>操作提示</h4>
									<p><?php echo $secend_menu['desc']; ?></p>
									<hr/>
									<?php endif; ?>
									<h4>功能提示</h4>
									<p class="function-prompts"></p>
								</div>
							</div>
						</div>
					</li>
					
				</ul>
			</div>
		</div>
		
		<!-- 操作提示 -->
		
<!-- 		<?php if($warm_prompt_is_show == 'hidden'): ?>style="display:none;"<?php endif; ?> -->
		<div class="ns-warm-prompt" style="display:none;">
			<div class="alert alert-info">
				<button type="button" class="close">&times;</button>
				<h4>
<!-- 					{1block name="alert_info"} -->
<!-- 					<i class="fa fa-info-circle"></i> -->
<!-- 					<span class="operating-hints">操作提示</span> -->
<!-- 						<?php if($secend_menu['desc']): ?> -->
<!-- 						<span><?php echo $secend_menu['desc']; ?></span> -->
<!-- 						<?php endif; ?> -->
<!-- 					{1/block} -->
				</h4>
			</div>
		</div>
		
		
		<div class="ns-main">
		<!-- 三级导航菜单 -->
			
				<?php if(count($child_menu_list) > 1): ?>
				<nav class="ns-third-menu">
					<ul>
					<?php if(is_array($child_menu_list) || $child_menu_list instanceof \think\Collection || $child_menu_list instanceof \think\Paginator): if( count($child_menu_list)==0 ) : echo "" ;else: foreach($child_menu_list as $k=>$child_menu): if($child_menu['active'] == '1'): if(!(empty($child_menu['module']) || (($child_menu['module'] instanceof \think\Collection || $child_menu['module'] instanceof \think\Paginator ) && $child_menu['module']->isEmpty()))): ?>
								<li class="selected" onclick="location.href='<?php echo __URL('http://t.huaqi86.com/index.php/'.$child_menu['module'].'/admin/'.$child_menu['url']); ?>';"><?php echo $child_menu['menu_name']; ?></li>
							<?php else: ?>
								<li class="selected" onclick="location.href='<?php echo __URL('http://t.huaqi86.com/index.php/admin/'.$child_menu['url']); ?>';"><?php echo $child_menu['menu_name']; ?></li>
							<?php endif; else: if(!(empty($child_menu['module']) || (($child_menu['module'] instanceof \think\Collection || $child_menu['module'] instanceof \think\Paginator ) && $child_menu['module']->isEmpty()))): ?>
								<li onclick="location.href='<?php echo __URL('http://t.huaqi86.com/index.php/'.$child_menu['module'].'/admin/'.$child_menu['url']); ?>';"><?php echo $child_menu['menu_name']; ?></li>
							<?php else: ?>
								<li onclick="location.href='<?php echo __URL('http://t.huaqi86.com/index.php/admin/'.$child_menu['url']); ?>';"><?php echo $child_menu['menu_name']; ?></li>
							<?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</nav>
				<?php endif; ?>
			
			
<div class="js-mask-category" style="display:none;background: rgba(0,0,0,0);position:fixed;width:100%;height:100%;top:0;left:0;right:0;bottom:0;z-index:90;"></div>
<table class="mytable">
	<tr>
		<th align="left">
			<a class="btn-common" href="javascript:addGoods();">发布商品</a>
			<a class="btn-common-white" href="javascript:batchDelete()">批量删除</a>
			<a class="btn-common-white upstore" href="javascript:goodsIdCount('online')">上架</a>
			<a class="btn-common-white downstore" href="javascript:goodsIdCount('offline')">下架</a>
			<a class="btn-common-white recommend" href="javascript:ShowRecommend()" data-html="true" id="setRecommend" title="推荐"
			data-container="body" data-placement="bottom"  data-trigger="manual"
			data-content="<div class='edit-group' id='recommendType'>
				<label class='checkbox-inline'><i class='checkbox-common'><input type='checkbox' value='1' /></i> 热卖 </label>
				<label class='checkbox-inline'><i class='checkbox-common'><input type='checkbox' value='2' /></i> 精品 </label>
				<label class='checkbox-inline'><i class='checkbox-common'><input type='checkbox' value='3' /></i> 新品 </label>
				</div>
				<button class='btn-common btn-small' onclick='setRecommend();'>保存</button>
				<button class='btn btn-small' onclick='hideSetRecommend()'>取消</button>
				"
			>推荐</a>
			<a data-html="true" class="btn-common-white fun-a category" href="javascript:goodsGroupIdCount();" id="editGroup" title="修改商品标签" data-container="body" data-placement="bottom"  data-trigger="manual"
				data-content="<div class='input-box'><input class='search-input' type='text' placeholder='请输入搜索内容'/><i class='seach-img' onclick='search_group()'><img src='/template/admin/public/images/index_search.png'/></i></div><div class='edit-group' id='goodsChecked' style='max-width:auto;'>				
				<?php foreach($goods_group as $vo): ?>
					<label class='checkbox-inline'>
						<i class='checkbox-common'><input type='checkbox' value='<?php echo $vo['group_id']; ?>'></i>
						<span><?php echo $vo['group_name']; ?></span>&nbsp;&nbsp;&nbsp;
					</label>
					<?php foreach($vo['sub_list']['data'] as $vs): ?>
						<label style='display:inline-block;'>
							<input type='checkbox' value='<?php echo $vs['group_id']; ?>'><?php echo $vs['group_name']; ?>
						</label>
					<?php endforeach; endforeach; ?>
				</div>
				<button class='btn-common btn-small' onclick='goodsGroupUpdate();'>保存</button>
				<button class='btn btn-small' onclick='hideEditGroup()'>取消</button>
				">
				商品标签</a>
			<!-- <a href="javascript:batchUpdateGoodsQrcode();" class="btn-common-white fun-a category" title="更新二维码">更新二维码</a>
			<a href="javascript:;" id="batchProcessing"  class="btn-common-white" title="批量设置商品信息">批量处理</a>
			<a href="javascript:;" id="setMemberDiscount"  class="btn-common-white" title="批量设置会员折扣">设置折扣</a>
			
			<?php if(addon_is_exit('Nsfx')): ?>
				<a class="btn-common" href="javascript:void(0)" onclick="distributionSetting()">分销设定</a>
			<?php endif; ?> -->
			<select id="batch-processing" class="select-common middle">
				<option value="">更多</option>
				<option value="qrcode">批量更新二维码</option>
				<option value="goodsinfo">批量设置商品信息</option>
				<option value="memberdiscount">批量设置会员折扣</option>
				<?php if(addon_is_exit('Nsfx')): ?><option value="goodsfx">批量设置商品分佣比率</option><?php endif; ?>
			</select>
			<input type='hidden' id='goods_type_ids'/>
		</th>
		<th style="position: relative;" class="default-condition">
			<span class="interval"></span>
			<span>商品名称：</span>
			<input id="goods_name" class="input-medium input-common middle" type="text" value="<?php echo $search_info; ?>" placeholder="要搜索的商品名称" >	
			<span class="interval"></span>
			<span class="interval"></span>
			<button onclick="searchData()" class="btn-common">搜索</button>
			<button onclick="openSeniorSearch('.default-condition')" value="搜索" class="btn-common" >高级搜索</button>
		</th>
	</tr>
</table>

<!-- 高级搜索 -->
<div class="nui-condition">
	<div class="c-item-column">
		<label>商品名称：</label>
		<input id="goods_name" class="input-medium input-common middle" type="text" value="<?php echo $search_info; ?>" placeholder="要搜索的商品名称" >
	</div>
	
	<div class="c-item-column">
		<label>商品编码：</label>
		<input id="goods_code" class="input-medium input-common middle" type="text" placeholder="要搜索的商品编码"/>
	</div>
	
	<div class="c-item-column">
		<label>供货商：</label>
		<select id="supplier_id" class="select-common middle">
			<option value="">全部</option>
			<?php if(!(empty($supplier_list) || (($supplier_list instanceof \think\Collection || $supplier_list instanceof \think\Paginator ) && $supplier_list->isEmpty()))): if(is_array($supplier_list) || $supplier_list instanceof \think\Collection || $supplier_list instanceof \think\Paginator): $i = 0; $__LIST__ = $supplier_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<option value="<?php echo $vo['supplier_id']; ?>"><?php echo $vo['supplier_name']; ?></option>
			<?php endforeach; endif; else: echo "" ;endif; endif; ?>
		</select>
	</div>
	<div class="c-item-column">
		<label>商品类型：</label>
		<select id="goods_type" class="select-common middle" >
			<option value="all">全部</option>
			<?php if(is_array($goods_type_list) || $goods_type_list instanceof \think\Collection || $goods_type_list instanceof \think\Paginator): $i = 0; $__LIST__ = $goods_type_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<option value="<?php echo $vo['id']; ?>"><?php echo $vo['title']; ?></option>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</select>
	</div>
	
	<div class="c-item-column">
		<label>商品标签：</label>
		<input type="text" placeholder="请选择商品标签" id="selectGoodsLabel"  onfocus="selectGoodsLabel();" is_show="false" data-html="true" class="input-common middle" title="<h6 class='edit-group-title'>选择商品标签</h6>" data-container="body" data-placement="bottom"  data-trigger="manual" data-content="<div class='edit-group' style='max-width:auto;'>
			<?php foreach($goods_group as $vo): ?>
					<p>
					<label class='checkbox-inline' style='display:inline-block;'>
					<input type='checkbox' value='<?php echo $vo['group_id']; ?>' onchange='clickGoodsLabel(this);'><span><?php echo $vo['group_name']; ?></span>&nbsp;&nbsp;&nbsp;
					</label>
				<?php endforeach; ?>
			</div></div>
			<button class='btn-common btn-small' onclick='confirm();'>确认</button>
			<button class='btn btn-small' onclick='hideGroup()'>取消</button>
			">
	</div>
	
	<div class="c-item-column">
		<label>商品分类：</label>
		<style>
.goods-category-container {display: inline-block;position: relative;}
.goodsCategory{width: 148px;height: 300px;border: 1px solid #CCCCCC;position: absolute;z-index: 100;background: #fff;right: 0;overflow-y: auto;top: 31px;}
.goodsCategory::-webkit-scrollbar{width: 3px;}
.goodsCategory::-webkit-scrollbar-track{-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);border-radius: 10px;background-color: #fff;}
.goodsCategory::-webkit-scrollbar-thumb{height: 20px;border-radius: 10px;-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);background-color: #ccc;}
.goodsCategory ul{height: 280px;margin-top: -2px;margin-left: 0;}
.goodsCategory ul li{text-align: left;padding:0 10px;line-height: 30px;}
.goodsCategory ul li i{float: right;line-height: 30px;}
.goodsCategory ul li:hover{cursor: pointer;}
.goodsCategory ul li:hover,.goodsCategory ul li.selected{background: #126AE4;color: #fff;}
.goodsCategory ul li span{width: 110px;display: inline-block;white-space: nowrap;text-overflow: ellipsis;overflow: hidden;vertical-align: middle;font-size:12px;}
.one{left: 0;}
.two{left: 150px;border-left:0;}
.three{left: 299px;width: 148px;border-left:0;}
.selectGoodsCategory{width: 148px;height: 45px;border:1px solid #CCCCCC;position: absolute;z-index: 100;left: 0;margin-top: 299px;border-collapse: collapse;background: #fff;}
.selectGoodsCategory a{height: 30px;width: 100px;text-align: center;color: #fff;line-height: 30px;margin:8px;background: #4685fd;text-decoration:none;}
</style>


<div class="goods-category-container">
	<input type="text" placeholder="请选择商品分类" show="false" class="input-common middle select-category">
	<div class="category-wrap hide">
		<div class="goodsCategory one">
			<ul>
				<?php if(is_array($oneGoodsCategory) || $oneGoodsCategory instanceof \think\Collection || $oneGoodsCategory instanceof \think\Paginator): $i = 0; $__LIST__ = $oneGoodsCategory;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				<li data-value="<?php echo $vo['category_id']; ?>" data-level="<?php echo $vo['level']; ?>" data-has-child="<?php echo $vo['is_parent']; ?>">
					<span><?php echo $vo['category_name']; ?></span>
					<?php if($vo['is_parent'] == 1): ?>
						<i class="fa fa-angle-right fa-lg"></i>
					<?php endif; ?>
				</li>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
		<div class="goodsCategory two hide" style="border-left:0;">
			<ul></ul>
		</div>
		<div class="goodsCategory three hide">
			<ul></ul>
		</div>
		<div class="selectGoodsCategory">
			<a href="javascript:;" style="float:right;" class="confirm-select">确认选择</a>
		</div>
	</div>
</div>

<script>
var rootEl;
$(function(){
	// 点击显示选择分类
	$(".goods-category-container .select-category").unbind("click");
	$('.goods-category-container .select-category').click(function(e) {
		rootEl = $(this).parents('.goods-category-container');
		var isShow = $(this).attr('show');
		if(isShow == 'true'){
			$(this).attr('show', 'false');
			rootEl.find('.category-wrap').addClass('hide');
		}else{
			$(this).attr('show', 'true');
			rootEl.find('.category-wrap').removeClass('hide');

			$(document).one("click", function(){
		        var isShow = rootEl.find('.select-category').attr('show');
			    if(isShow == 'true'){
					$(this).attr('show', 'false');
					rootEl.find('.category-wrap').addClass('hide');
				}
		    });
		    e.stopPropagation();
		}
	});

	// 点击选择分类
	$('body').on('click', '.goodsCategory ul li', function(e){
		var data = $(this).data();

		$(this).addClass('selected').siblings('li').removeClass('selected');
		$.ajax({
			type : 'post',
			url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/goods/getcategorybyparentajax'); ?>",
			data : { "parentId" : data.value },
			async : false,
			success : function(res){
				if(res.length > 0){
					var html = '';
					for (var i = 0; i < res.length; i++) {
						var item = res[i];
						html += `
							<li data-value="`+ item.category_id +`" data-level="`+ item.level +`" data-has-child="`+ item.is_parent +`">
								<span>`+ item.category_name +`</span>`;
						if(item.is_parent == 1){
							html += `<i class="fa fa-angle-right fa-lg"></i>`
						}	
						html += `</li>`;
					}
					if(data.level == 1){
						rootEl.find(".two ul").html(html);
						rootEl.find(".two").removeClass('hide');
						rootEl.find(".three ul li").remove();
						rootEl.find(".three").addClass('hide');
						rootEl.find('.selectGoodsCategory').css({'width' : 297});
					}else if(data.level == 2){
						rootEl.find(".three ul").html(html);
						rootEl.find(".three").removeClass('hide');
						rootEl.find('.selectGoodsCategory').css({'width' : 446});
					}
				}else{
					if(data.level == 1 && !rootEl.find(".two").hasClass('hide')){
						rootEl.find(".two ul li,.three ul li").remove();
						rootEl.find(".two,.three").addClass('hide');
						rootEl.find('.selectGoodsCategory').css({'width' : 148});
					}else if(data.level == 2 && !rootEl.find(".three").hasClass('hide')){
						rootEl.find(".three ul li").remove();
						rootEl.find(".three").addClass('hide');
						rootEl.find('.selectGoodsCategory').css({'width' : 297});
					}
					rootEl.find('.select-category').attr('show', 'false');
					rootEl.find('.category-wrap').addClass('hide');
				}
			}
		})

		var selected = {
			text : [],
			id : []
		}
		var categoryText = '';
		rootEl.find('.goodsCategory ul li.selected').each(function(index, el) {
			selected.id[index] = $(this).attr('data-value');
			selected.text[index] = $(this).find('span').text();
			if($(this).attr('data-has-child') == 1) categoryText += $(this).find('span').text() + ' > ';
			else categoryText += $(this).find('span').text();
		});
		rootEl.find('.select-category').val(categoryText).attr('data-value', selected.id.toString());
	    e.stopPropagation();
	})

	// 点击确认
	$('.goods-category-container .confirm-select').click(function(event) {
		rootEl = $(this).parents('.goods-category-container');
		var selected = {
			text : [],
			id : []
		}
		var categoryText = '';
		rootEl.find('.goodsCategory ul li.selected').each(function(index, el) {
			selected.id[index] = $(this).attr('data-value');
			selected.text[index] = $(this).find('span').text();
			if($(this).attr('data-has-child') == 1) categoryText += $(this).find('span').text() + ' > ';
			else categoryText += $(this).find('span').text();
		});
		rootEl.find('.select-category').val(categoryText).attr('data-value', selected.id.toString());
		rootEl.find('.select-category').attr('show', 'false');
		rootEl.find('.category-wrap').addClass('hide');
	});
})

</script>
	</div>
	<br />
	
	<div class="c-operation">
		<button onclick="searchData()"  value="搜索" class="btn-common" >搜索</button>
		<a href="javascript:clearCondition();">清空筛选条件</a>
	</div>
	<a href="javascript:retractSeniorSearch();" class="retract">收起↑</a>
</div>

<div id="myTabContent" class="tab-content">
	<div class="tab-pane active">
		<table class="table-class">
			<colgroup>
				<col style="width: 2%;">
				<col style="width: 30%;">
				<col style="width: 15%;">
				<col style="width: 8%;">
				<col style="width: 5%;">
				<col style="width: 10%;">
				<col style="width: 8%;">
				<col style="width: 8%;">

			</colgroup>
			<thead>
				<tr>
					<th>
						<i class="checkbox-common" input_all ="#productTbody">
							<input type="checkbox" id="check_all">
						</i>
					</th>
					<th align="left">商品名称</th>
					<?php if(addon_is_exit('Nsfx')): ?>
						<th align="center">三级分销</th>
					<?php endif; ?>
					<th class="goods-fields-sort" data-field="price" data-order="desc" style="text-align: center;">
						<span class="text">价格(元)</span>
						<span class="desc order">
							<i class="iconfont iconxia-xyzs-copy"></i>
							<i class="iconfont iconxia-xyzs"></i>
						</span>
					</th>
					<th class="goods-fields-sort" data-field="stock" data-order="desc" style="text-align: right;">
						<span class="text">总库存</span>
						<span class="desc order">
							<i class="iconfont iconxia-xyzs-copy"></i>
							<i class="iconfont iconxia-xyzs"></i>
						</span>
					</th>
					<th class="goods-fields-sort" data-field="sales" data-order="desc" style="text-align: center;">
						<span class="text">销量</span>
						<span class="desc order">
							<i class="iconfont iconxia-xyzs-copy"></i>
							<i class="iconfont iconxia-xyzs"></i>
						</span>
					</th>
					<th style="text-align: center;">商品类型</th>
					<th class="goods-fields-sort" data-field="sort" data-order="desc" style="text-align: center;">
						<span class="text">排序</span>
						<span class="desc order">
							<i class="iconfont iconxia-xyzs-copy"></i>
							<i class="iconfont iconxia-xyzs"></i>
						</span>
					</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody id="productTbody" style="border: 0;">
			</tbody>
		</table>
	</div>
	<input type="hidden" id="state" value="<?php echo $state; ?>"/>
	<input type="hidden" id="selectGoodsLabelId">
	<input type="hidden" id="stock_warning" value="<?php echo $stock_warning; ?>">
</div>
<input type="hidden" id="hidden_sort_rule" />

<!-- 批量处理弹出框 -->
<!-- 功能说明：批量处理弹出框 -->
<link rel="stylesheet" type="text/css" href="/template/admin/public/css/plugin/jquery.searchableSelect.css"/>
<style type="text/css">
	.modal{
		border-radius: 0;
		width: 700px;
	}
	#batch_processing .modal .modal-body{
		padding: 15px 10px!important;
		height:400px;
		overflow-y: visible;
	}
	#batch_processing .modal-header h3 {
	    font-size: 16px;
	}
	#batch_processing .tip_info{
		padding: 5px;
	    color: #3a87ad;
		background-color: #d9edf7;
    	border: 1px solid #bce8f1;
	}
	#batch_processing .tip_info p{
		margin:0;
		line-height: 1.5;
		font-size: 13px;
	}
	#batch_processing .setting-item{
		margin: 10px 0;
		width: 100%;
	}
	#batch_processing .setting-item dl{
		width: 100%;
	    margin: 0;
	}
	#batch_processing .setting-item dl dt,#batch_processing .setting-item dl dd{
	    line-height: 45px;
	    display: inline-block;
	    float: left;
	    margin: 0;
	    text-align: left;
	    font-weight: normal;
	    font-size: 13px;
	}
	#batch_processing .setting-item dl dt{
		width: 20%;
	}
	#batch_processing .setting-item dl dd{
	    width: 80%;
	}
	#batch_processing .setting-item dl dd label{
		display: inline-block;
		margin-right: 20px;
	}
	#batch_processing .setting-item dl dd .num{
		width: 60px;
		border-radius: 0;
		margin-bottom: 0;
	}
	#batch_processing .setting-item dl dd .info{
		color: #BBB;
	}
	#batch_processing .setting-item dl dd .select{
	    border-radius: 0;
	    width: 30%;
	    margin-right: 4%;
	    margin-bottom: 0;
	    outline: none;
	}
	#batch_processing .setting-item dl dd .select:last-child{
		margin-right: 0;
	}
	.searchable-select-holder{
		border-radius: 0;
		padding: 4px 20px 4px 6px;
	}
</style>
<div class="modal fade hide" id="batch_processing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>批量处理</h3>
			</div>
			<div class="modal-body">
				<div class="tip_info">
					<p>1、如果未设置任何选择，则商品保持原状不变。</p>
					<p>2、设置商品库存，将作用于所选商品的所有规格项。</p>
				</div>
				<div class="setting-item">
					<dl>
						<dt>商品分类</dt>
						<dd id="Js_goods_category">
							<select class="select-common middle" id="batch_catrgory_one">
								<option value="0">请选择一级分类</option>
								<?php if(is_array($oneGoodsCategory) || $oneGoodsCategory instanceof \think\Collection || $oneGoodsCategory instanceof \think\Paginator): $i = 0; $__LIST__ = $oneGoodsCategory;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
									<option value="<?php echo $vo['category_id']; ?>"><?php echo $vo['category_name']; ?></option>
								<?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
							<select class="select-common middle" id="batch_catrgory_two">
								<option value="0">请选择二级分类</option>
							</select>
							<select class="select-common middle" style="width: 150px;" id="batch_catrgory_three">
								<option value="0">请选择三级分类</option>
							</select>
						</dd>
					</dl>
					<dl>
						<dt>销售价:</dt>
						<dd id="price">
							<label>
								<i class="radio-common selected">
									<input type="radio" checked name="price" value="1">
								</i>
								<span>增加</span>
							</label>
							<label>
								<i class="radio-common">
									<input type="radio" name="price" value="0">
								</i>
								<span>减少</span>
							</label>
							<input type="number" name="" value="0" class="num input-common short" min='0' max="9999.99">
							<span class="info">销售价增加N元或减少N元</span>
						</dd>
					</dl>
					<dl>
						<dt>市场价:</dt>
						<dd id="market_price">
							<label>
								<i class="radio-common selected">
									<input type="radio" checked name="market_price" value="1">
								</i>
								<span>增加</span>
							</label>
							<label>
								<i class="radio-common">
									<input type="radio" name="market_price" value="0">
								</i>
								<span>减少</span>
							</label>
							<input type="number" name="" value="0" class="num input-common short" min='0' max="9999.99">
							<span class="info">市场价增加N元或减少N元</span>
						</dd>
					</dl>
					<dl>
						<dt>成本价:</dt>
						<dd id="cost_price">
							<label>
								<i class="radio-common selected">
									<input type="radio" checked name="cost_price" value="1">
								</i>
								<span>增加</span>
							</label>
							<label>
								<i class="radio-common">
									<input type="radio" name="cost_price" value="0">
								</i>
								<span>减少</span>
							</label>
							<input type="number" name="" value="0" class="num input-common short" min='0' max="9999.99"/>
							<span class="info">成本价增加N元或减少N元</span>
						</dd>
					</dl>
					<dl>
						<dt>库存:</dt>
						<dd id="stock">
							<label>
								<i class="radio-common selected">
									<input type="radio" checked name="stock" value="1">
								</i>
								<span>增加</span>
							</label>
							<label>
								<i class="radio-common">
									<input type="radio" name="stock" value="0">
								</i>
								<span>减少</span>
							</label>
							<input type="number" name="" value="0" class="num input-common short" min='0' max="99999">
							<span class="info">库存增加N件或减少N件</span>
						</dd>
					</dl>
					<dl>
						<dt>商品品牌:</dt>
						<dd id="stock" class="js-brand-block">
							<div>
							<select id="brand_id" style="display: none;" class="middle"></select>
							</div>
						</dd>
					</dl>
				</div>
			</div>
			
			<div class="modal-footer">
				<button class="btn-common btn-big" onclick="save();">保存</button>
				<button class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>
	
</div>
<script src="/template/admin/public/js/plugin/jquery.searchableSelect.js"></script>
<script type="text/javascript">
var curr_searchable_select = null;
$(function(){
	//可搜索的商品品牌下拉选项框
	curr_searchable_select = $('#brand_id').searchableSelect();
	getGoodsBrandList();

	$(".searchable-select-input").live("keyup",function(){
		if($(this).val().length>100){
			showTip("查询限制在100个字符以内","warning");
			return;
		}
		if($(this).attr("data-value") != $(this).val()){
			$(this).attr("data-value",$(this).val());
			getGoodsBrandList($(".searchable-select-holder").text(),$(this).val());
		}
	});
});

//查询商品品牌列表
function getGoodsBrandList(brand_name,search_name){
	var page_index = 1;
	var page_size = 20;
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/goods/getGoodsBrandList'); ?>",
		data : { "page_index" : page_index, "page_size" : page_size, "brand_name" : brand_name, "search_name" : search_name, "brand_id" : $("#hidden_goods_brand_id").val() },
		success : function(res){
			var html = '<option value="0">请选择商品品牌</option>';
			if(res.total_count>0){
				for(var i=0;i<res['data'].length;i++){
					html += '<option value="' + res['data'][i].brand_id + '">' + res['data'][i].brand_name + '</option>';
				}
			}
			$("#brand_id").html(html);
			//更新搜索结果
			$(".js-brand-block .searchable-select-items .searchable-select-item").remove();
			curr_searchable_select.buildItems();
		}
	});
}

$("#Js_goods_category select").change(function(){
	var parentId = $(this).val();
	var _this = $(this);
	$.ajax({
		type : 'post',
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/goods/getcategorybyparentajax'); ?>",
		data : {"parentId":parentId},
		success : function(data){
			if(data.length>0){
				var html = '';
				for (var i = 0; i < data.length; i++) {
					html += '<option value="'+ data[i]['category_id'] +'">' + data[i]['category_name'] + '</option>';
				}
				$(_this).parents(".selectric-wrapper").next(".selectric-wrapper").find("select").find("option[value !='0']").remove();
				$(_this).parents(".selectric-wrapper").next(".selectric-wrapper").find("select").find("option:first-child").after(html);
				$(_this).parents(".selectric-wrapper").next(".selectric-wrapper").find("select").selectric();
			}
		}
	})
});

var is_click = false;
function save(){
	var price = 0,
		market_price = 0,
		cost_price  = 0,
		stock = 0,
		catrgory_one = $("#batch_catrgory_one").val(),
		catrgory_two = $("#batch_catrgory_two").val(),
		catrgory_three = $("#batch_catrgory_three").val(),
		brand_id = $("#brand_id").val();
	//销售价
	if($("input[name='price']:checked").val() == 0){
		price -= parseFloat(parseFloat($("#price .num").val()).toFixed(2));
	}else{
		price += parseFloat(parseFloat($("#price .num").val()).toFixed(2));
	}
	//市场价
	if($("input[name='market_price']:checked").val() == 0){
		market_price -= parseFloat(parseFloat($("#market_price .num").val()).toFixed(2));
	}else{
		market_price += parseFloat(parseFloat($("#market_price .num").val()).toFixed(2));
	}
	//成本价
	if($("input[name='cost_price']:checked").val() == 0){
		cost_price -= parseFloat(parseFloat($("#cost_price .num").val()).toFixed(2));
	}else{
		cost_price += parseFloat(parseFloat($("#cost_price .num").val()).toFixed(2));
	}
	//库存
	if($("input[name='stock']:checked").val() == 0){
		stock -= parseInt($("#stock .num").val());
	}else{
		stock += parseInt($("#stock .num").val());
	}

	var goods_ids= [];
	$("#productTbody input[type='checkbox']:checked").each(function() {
		if (!isNaN($(this).val())) {
			goods_ids.push($(this).val());
		}
	});
	
	if(!is_click){
		is_click = true;
		$.ajax({
			type : "post",
			url : '<?php echo __URL("http://t.huaqi86.com/index.php/admin/goods/batchProcessingGoods"); ?>',
			async : false,
			data : {
				"price" : price,
				"market_price" : market_price,
				"cost_price" : cost_price,
				"stock" : stock,
				"catrgory_one" : catrgory_one,
				"catrgory_two" : catrgory_two,
				"catrgory_three" : catrgory_three,
				"brand_id" : brand_id,
				"goods_ids" : goods_ids.toString()
			},
			success : function(data){
				if(data["code"] > 0){
					$("#batch_processing").modal("hide");
					showMessage("success",data["message"],location.href);
				}else{
					is_click = false;
					showMessage("error",data["message"]);
				}
			}
		})
	}
	
}
</script>
<!-- 设置会员折扣 -->
<style type="text/css">
.modal#set_member_discount{
	border-radius: 0;
	width: 500px;
}
.modal#set_member_discount .modal-body{
	text-align: center;
}
.modal#set_member_discount .modal-body dl{
	margin-top: 0;
	margin-bottom: 10px;
	width: 100%;
	overflow: hidden;
}
.modal#set_member_discount .modal-body dl:last-child{
	margin-bottom: 0;
}
.modal#set_member_discount .modal-body dl dt,.modal#set_member_discount .modal-body dl dd{
	display: inline-block;
	line-height: 30px;
}
.modal#set_member_discount .modal-body dl dt{
	width: 35%;
	text-align: right;
	font-weight: normal;
	float: left;
}
.modal#set_member_discount .modal-body dl dd{
	text-align: left;
	margin-left: 0;
	width: 63%;
	float: right;
}
</style>
<div class="modal fade hide" id="set_member_discount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>会员折扣</h3>
			</div>
			<div class="modal-body" id="member_discount">
				<?php if(is_array($level_list) || $level_list instanceof \think\Collection || $level_list instanceof \think\Paginator): if( count($level_list)==0 ) : echo "" ;else: foreach($level_list as $key=>$vo): ?>
					<dl>
						<dt><?php echo $vo['level_name']; ?></dt>
						<dd>
							<input class="input-common harf" type="number" data-level-id="<?php echo $vo['level_id']; ?>" maxlength="3"><em class="unit">%</em>
						</dd>
					</dl>
				<?php endforeach; endif; else: echo "" ;endif; ?>
				<dl>
					<dt>价格保留方式</dt>
					<dd>
						<label class="radio inline normal decimal_reservation_number">
							<i class="radio-common">
								<input type="radio" name="decimal-reservation-number" value="0">
							</i>
							<span>抹去角和分</span>
						</label>
						<label class="radio inline normal decimal_reservation_number">
							<i class="radio-common">
								<input type="radio" name="decimal-reservation-number" value="1">
							</i>
							<span>抹去分</span>
						</label>
						<label class="radio inline normal decimal_reservation_number">
							<i class="radio-common">
								<input type="radio" name="decimal-reservation-number" value="2">
							</i>
							<span>保留角和分</span>
						</label>
					</dd>
				</dl>
			</div>
			<div class="modal-footer">
				<button class="btn-common btn-big" onclick="save_goods_discount();">保存</button>
				<button class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="curr_goods_id">
<script type="text/javascript">
var is_sub = false;
function save_goods_discount(){
	var member_discount_arr = [];
	$("#member_discount dl dd input[type='number']").each(function(){
		var discount = parseInt($(this).val());
		if(discount > 100){
			showMessage("error","商品折扣最大百分比为100,请重新设置");
			return;
		}
		if(discount != NaN && discount > 0 && discount <= 100){
			var member_discount = {};
				member_discount.level_id = $(this).attr("data-level-id");
				member_discount.discount = discount;
			member_discount_arr.push(member_discount);
		}
	});

	var goods_ids= [];
	$("#productTbody input[type='checkbox']:checked").each(function() {
		if (!isNaN($(this).val())) {
			goods_ids.push($(this).val());
		}
	});
	
	if(goods_ids.length == 0 && $("#curr_goods_id").val() > 0){
		goods_ids.push($("#curr_goods_id").val());
	}
	var decimal_reservation_number = $("input[name='decimal-reservation-number']:checked").val();
		decimal_reservation_number = decimal_reservation_number == undefined ? -1 : decimal_reservation_number;
		
	if(member_discount_arr.length > 0 && goods_ids.length > 0){
		if(is_sub) return;
		is_sub = true;
		$.ajax({
			type : "post",
			url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/goods/setMemberDiscount'); ?>",
			data : {
				member_discount_arr : JSON.stringify(member_discount_arr),
				goods_ids : goods_ids.toString(),
				decimal_reservation_number : decimal_reservation_number
			},
			success : function(data){
				$("#set_member_discount").modal("hide");
				if(data["code"] > 0){
					showMessage("success",data["message"],location.href);
				}else{
					is_click = false;
					showMessage("error",data["message"]);
				}
			}
		})
	}else{
		$("#set_member_discount").modal("hide");
	}
}

$(".decimal_reservation_number").click(function(){
	$(this).siblings().find("i").removeClass("selected").find("input[type='checkbox']").prop('checked', false);
});

// 查看折扣
function showMemberDiscount(goods_id){
	$("#curr_goods_id").val(goods_id);
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/goods/showMemberDiscountAjax'); ?>",
		data : {
			goods_id : goods_id,
		},
		success : function(data){
			if(data['discount_list'].length > 0){
				for (var i = 0; i < data['discount_list'].length; i++) {
					var discount_info = data['discount_list'][i];
					$("input[data-level-id='"+discount_info['level_id']+"']").val(discount_info['discount']);
				}
			}
			if(data['decimal_reservation_number'] >= 0){
				$('input[name="decimal-reservation-number"]').prop("checked", false).parent().removeClass("selected");
				$('input[name="decimal-reservation-number"][value="'+data['decimal_reservation_number']+'"]').prop("checked", true).parent().addClass("selected");
			}
		}
	});
	$("#set_member_discount").modal("show");
}

$('#set_member_discount').on('hidden.bs.modal', function (e) {
	$("#curr_goods_id").val("");
	$("#member_discount").find('input[data-level-id]').val("");
	$("#member_discount").find('input[name="decimal-reservation-number"]').prop("checked", false).parent().removeClass("selected");
})
</script>

<style type="text/css">
#goods_sku_edit{width: 1000px;left: 38.5%;}
#goods_sku_edit .input-common.middle{
	    width: 100px !important;
}
</style>
<div class="modal fade " id="goods_sku_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>修改价格库存</h3>
			</div>
			<div class="modal-body">
				<table class="table table-config-bordered">
					<thead>
						<tr >
							<th>规格名</th>
							<th>销售价<span style="color: #ff5050; font-size: 12px;">*</span></th>
							<th>市场价</th>
							<th>成本价</th>
							<th>当前库存</th>
							<th>增加/删减<span style="color: #ff5050; font-size: 12px;">*</span></th>
							<th>实际库存</th>
						</tr>
					</thead>
					<tbody id = "goods_sku_data">
						
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn-common btn-big" onclick="save_goods_sku();">保存</button>
				<button class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
/**
 * 商品规格对话框显示
 */
var sel_goods_id = 0;
function goodsSkuDialogShow(goods_id, goods_type){
	sel_goods_id = goods_id;
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/goods/getGoodsSkuList'); ?>",
		data : {goods_id},
		success : function(data){
			var h = '';
			for(var i = 0; i < data.length; i++){
				var sku_name = data[i]['sku_name'];
				if(data[i]['sku_name'] == ''){
					sku_name = '--';
				}
				h += `<tr sku_id = "${data[i]['sku_id']}">
						<td>${sku_name}</td>
						<td><input type="number" class="input-common middle" name="sku_price" value="${data[i]['price']}"/></td>
						<td><input type="number" class="input-common middle" name="market_price" value="${data[i]['market_price']}"/></td>
						<td><input type="number" class="input-common middle" name="cost_price" value="${data[i]['cost_price']}"/></td>
						<td name = "stock">${data[i]['stock']}</td>`;
				if(goods_type == 4){
                    h += `<td><input type="number" class="input-common middle" name="stock_num" placeholder="0" disabled="disabled"/></td>`;
				}else{
                    h += `<td><input type="number" class="input-common middle" name="stock_num" placeholder="0" onkeyup = "stockOperation(this)"/></td>`;
				}
				h += `<td><input type="number" class="input-common middle" name="actual_stock" value="${data[i]['stock']}" disabled="disabled"/></td>
					</tr>`;	
			}
			$('#goods_sku_data').html(h);
		}
		
	})
	$("#goods_sku_edit").modal("show");
}

/**
 * 库存计算操作
 */
function stockOperation(even){
	obj = $(even);
	var stock = obj.parent().prev().text();
	var o_v = obj.val();
	stock = Number(stock) + Number(o_v);
	obj.parents('tr').find('[name="actual_stock"]').val(stock);

}

/**
 * 保存sku信息
 */
function save_goods_sku(){
	
	var arr = new Array();
	$('#goods_sku_edit tr').each(function(){
		obj = new Object();
		obj.sku_id = $(this).attr('sku_id');
		obj.price = $(this).find('[name = "sku_price"]').val();
		obj.market_price = $(this).find('[name = "market_price"]').val();
		obj.cost_price = $(this).find('[name = "cost_price"]').val();
		obj.stock = $(this).find('[name = "actual_stock"]').val();
		arr.push(obj);
	})
	
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/goods/editGoodsSku'); ?>",
		data : {"sku_data":JSON.stringify(arr), "goods_id":sel_goods_id},
		success : function(data){
			if(data['code'] > 0){
				
				LoadingInfo(getCurrentIndex(sel_goods_id,'#productTbody','tr[class="tr-title"]'));
				$("#goods_sku_edit").modal("hide");
				showTip(data['message'],"success");
			}else{
				showTip(data['message'],"error");
			}
		}
	})
}

function goodsSkuDetailsList(clisk_obj, goods_id, goods_img){
	
	current_obj = $(clisk_obj);
	obj = $(clisk_obj).parents('tr').next('.single-goods-sku');
	current_obj.html('-');
	
	if(obj.html() != ''){
		obj.html('');
		current_obj.text('+');
		return;
	}
	
	openGoodsSKu = function(sku_id, goods_id){
		window.open(`${__URL('http://t.huaqi86.com/index.php/goods/detail?sku_id=')}${sku_id}&goods_id=${goods_id}`);
	}
	
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/goods/goodsSkuDetailsList'); ?>",
		data : {"goods_id":goods_id},
		success : function(data){
		
			var h = '<td align="center" colspan="10">';
			for(var i = 0; i<data.length; i++){
				
				sku_img = data[i]['pic_cover'] == '' ? goods_img : data[i]['pic_cover']; 
				sku_id = data[i]['sku_id'];
				h += `<div class="single-item" >
							<div class="hold-img" onclick = "openGoodsSKu(${sku_id}, ${goods_id})">
								<img src="${__IMG(sku_img)}" alt="" />
							</div>
							<p class="spec-title"><a href="javascript:openGoodsSKu(${sku_id}, ${goods_id});" target="_blank" title ="${data[i]['sku_name']}">${data[i]['sku_name']}</a></p>
							<div class = "row-term">
								<p><span class="row-title">价格：</span><span class="price-value">￥${data[i]['price']}</span></p>
								<p><span class="row-title">库存：</span><span class="stock-value">${data[i]['stock']}</span></p>
							</div>
						</div>`;
			}
			h += '</td>';
			obj.html(h);
		}
	})
}
</script>

			<script type="text/javascript" src="/public/static/js/jquery.cookie.js"></script>
<script src="/public/static/js/page.js"></script>
<div class="page" id="turn-ul" style="display: none;">
	<div class="pagination">
		<ul>
			<li class="according-number">每页显示<input type="text" class="input-medium" id="showNumber" value="<?php echo $pagesize; ?>" data-default="<?php echo $pagesize; ?>" autocomplete="off"/>条</li>
			<li><a id="beginPage" class="page-disable" style="border: 1px solid #dddddd;">首页</a></li>
			<li><a id="prevPage" class="page-disable">上一页</a></li>
			<li id="pageNumber"></li>
			<li id="JslastPage"></li>
			<li><a id="nextPage">下一页</a></li>
			<li><a id="lastPage">末页</a></li>
			<li class="total-data">共0条</li>
			<!-- <li class="page-count">共0页</li> -->
			<li class="according-number">
				跳<input type="text" class="input-medium"  id="skipPage" data-curr-page="1"/>页
			</li>
		</ul>
	</div>
</div>
<input type="hidden" id="page_count" />
<input type="hidden" id="page_size" />
<script>
/**
 * 保存当前的页面
 * 创建时间：2017年8月30日 19:29:20
 */
function savePage(index){
	var json = { page_index : index, show_number : $("#showNumber").val(), url :  window.location.href };
	$.cookie('page_cookie',JSON.stringify(json),{ path: '/' });
 	//console.log(json);
}

$(function() {
	try{
		$("#turn-ul").show();//显示分页
		var history_url = "";
		var json = { page_index : 1, show_number : <?php echo $pagesize; ?>, url :  window.location.href };
		var history_json = "";//用于临时保存分页数据
		if($.cookie('page_cookie') != undefined && $.cookie('page_cookie') != "" && $.cookie('page_cookie') != '""'){
			
			var cookie = eval("(" + $.cookie('page_cookie') + ")");
			if(cookie !=undefined && cookie != ""){
				json.page_index = cookie.page_index;
				if(cookie.show_number != undefined && cookie.show_number != "") json.show_number = cookie.show_number;
				else json.show_number = <?php echo $pagesize; ?>;
				history_url = cookie.url;
				history_json = cookie;
			}
			
		}else{
			savePage(json.page_index);
		}
		if(history_url != undefined && history_url != "" && history_url != json.url && json.page_index != 1){
			
			//如果页面发生了跳转，还原操作
			json.page_index = 1;
			json.show_number = <?php echo $pagesize; ?>;
			json.url = history_url;
 			//console.log("如果页面发生了跳转，还原操作");
			$.cookie('page_cookie',JSON.stringify(json),{ path: '/' });
		}

 		//console.log($.cookie('page_cookie'));
		$("#showNumber").val(json.show_number);
		if(json.page_index != 1) jumpNumber = json.page_index;
		LoadingInfo(json.page_index);//通过此方法调用分页类
		
	}catch(e){
		
		$("#turn-ul").hide();
		//当前页面没有分页，进行还原操作
		$.cookie('page_cookie',JSON.stringify(history_json),{ path: '/' });
//		console.error(e);
 		//console.log("当前页面没有分页，进行还原操作");
 		//console.log($.cookie('page_cookie'));
	}
	
	//首页
	$("#beginPage").click(function() {
		if(jumpNumber!=1){
			jumpNumber = 1;
			LoadingInfo(1);
			savePage(1);
			changeClass("begin");
		}
		return false;
	});

	//上一页
	$("#prevPage").click(function() {
		var obj = $(".currentPage");
		var index = parseInt(obj.text()) - 1;
		if (index > 0) {
			obj.removeClass("currentPage");
			obj.prev().addClass("currentPage");
			jumpNumber = index;
			LoadingInfo(index);
			savePage(index);
			//判断是否是第一页
			if (index == 1) {
				changeClass("prev");
			} else {
				changeClass();
			}
		}
		return false;
	});

	//下一页
	$("#nextPage").click(function() {
		var obj = $(".currentPage");
		//当前页加一（下一页）
		var index = parseInt(obj.text()) + 1;
		if (index <= $("#page_count").val()) {
			jumpNumber = index;
			LoadingInfo(index);
			savePage(index);
			obj.removeClass("currentPage");
			obj.next().addClass("currentPage");
			//判断是否是最后一页
			if (index == $("#page_count").val()) {
				changeClass("next");
			} else {
				changeClass();
			}
		}
		return false;
	});

	//末页
	$("#lastPage").click(function() {
		jumpNumber = $("#page_count").val();
		if(jumpNumber>1){
			LoadingInfo(jumpNumber);
			savePage(jumpNumber);
			$("#pageNumber a:eq("+ (parseInt($("#page_count").val()) - 1) + ")").text($("#page_count").val());
			changeClass("next");
		}
		return false;
	});

	//每页显示页数
	$("#showNumber").blur(function(){
		if(isNaN($(this).val())){
			$("#showNumber").val(20);
			jumpNumber = 1;
			LoadingInfo(jumpNumber);
			savePage(jumpNumber);
			return;
		}
		if($(this).val().indexOf(".") != -1){
			var index = $(this).val().indexOf(".");
			$("#showNumber").val($(this).val().substr(0,index));
			jumpNumber = 1;
			LoadingInfo(jumpNumber);
			savePage(jumpNumber);
			return;
		}
		if(parseInt($(this).val())<=0){
			jumpNumber = 1;
			LoadingInfo(jumpNumber);
			savePage(jumpNumber);
			return;
		}
		//页数没有变化的话，就不要再执行查询
		if(parseInt($(this).val()) != $(this).attr("data-default")){
// 			jumpNumber = 1;//设置每页显示的页数，并且设置到第一页
			$(this).attr("data-default",$(this).val());
			LoadingInfo(jumpNumber);
			savePage(jumpNumber);
		}
		if($(this).val() == "<?php echo $pagesize; ?>"){
			jumpNumber = 1;
			LoadingInfo(jumpNumber);
			savePage(jumpNumber);
			
		}
		return false;
	}).keyup(function(event){
		if(event.keyCode == 13){
			if(isNaN($(this).val())){
				$("#showNumber").val(20);
				jumpNumber = 1;
				LoadingInfo(jumpNumber);
				savePage(jumpNumber);
			}
			//页数没有变化的话，就不要再执行查询
			if(parseInt($(this).val()) != $(this).attr("data-default")){
// 				jumpNumber = 1;//设置每页显示的页数，并且设置到第一页
				$(this).attr("data-default",$(this).val());
				//总数据数量
				var total_count = parseInt($(".total-data").attr("data-total-count"));
				//计算用户输入的页数是否超过当前页数
				var curr_count = Math.ceil(total_count/parseInt($(this).val()));
				if( curr_count !=0 && curr_count < jumpNumber){
					jumpNumber = curr_count;//输入的页数超过了，没有那么多
				}
				LoadingInfo(jumpNumber);
				savePage(jumpNumber);
			}
		}
		return false;
	});

	// 跳转到某页
	$("#skipPage").blur(function(){
		if(isNaN($(this).val()) || $(this).val().length == 0){
			$("#showNumber").val(20);
			jumpNumber = 1;
			LoadingInfo(jumpNumber);
			savePage(jumpNumber);
			return;
		}
		if(parseInt($(this).val())<=0){
			jumpNumber = 1;
			LoadingInfo(jumpNumber);
			savePage(jumpNumber);
			return;
		}
		if(parseInt($(this).val()) > $("#page_count").val()){
			jumpNumber = $("#page_count").val();
			LoadingInfo(jumpNumber);
			savePage(jumpNumber);
			$(this).val(jumpNumber);
			return;
		}
		if(parseInt($(this).val()) == parseInt($(this).attr("data-curr-page"))){
			return;
		}
		jumpNumber = $(this).val();
		LoadingInfo(jumpNumber);
		savePage(jumpNumber);
	}).keyup(function(event){
		if(event.keyCode == 13){
			if(isNaN($(this).val())){
				$("#showNumber").val(20);
				jumpNumber = 1;
				LoadingInfo(jumpNumber);
				savePage(jumpNumber);
			}
			if(parseInt($(this).val())<=0){
				jumpNumber = 1;
				LoadingInfo(jumpNumber);
				savePage(jumpNumber);
				return;
			}
			if(parseInt($(this).val()) > $("#page_count").val()){
				jumpNumber = $("#page_count").val();
				LoadingInfo(jumpNumber);
				savePage(jumpNumber);
				$(this).val(jumpNumber);
				return;
			}
			if(parseInt($(this).val()) == parseInt($(this).attr("data-curr-page"))){
				return;
			}
			jumpNumber = $(this).val();
			LoadingInfo(jumpNumber);
			savePage(jumpNumber);
		}
		return false;
	});
});

//跳转页面
function JumpForPage(obj) {
	jumpNumber = $(obj).text();
	LoadingInfo($(obj).text());
	savePage($(obj).text());
	$(".currentPage").removeClass("currentPage");
	$(obj).addClass("currentPage");
	if (jumpNumber == 1) {
		changeClass("prev");
	} else if (jumpNumber < parseInt($("#page_count").val())) {
		changeClass();
	} else if (jumpNumber == parseInt($("#page_count").val())) {
		changeClass("next");
	}
}
</script>
		</div>
		
	</section>
	
</article>

<!-- 公共的操作提示弹出框 common-success：成功，common-warning：警告，common-error：错误，-->
<div class="common-tip-message js-common-tip">
	<div class="tip-container">
		<span class="inner"></span>
	</div>
</div>

<!--修改密码弹出框 -->
<div id="edit-password" class="modal hide fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="width:562px;top:50%;margin-top:-180.5px;">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3>修改密码</h3>
	</div>
	<div class="modal-body">
		<form class="form-horizontal">
			<div class="control-group">
				<label class="control-label" for="pwd0" style="width: 160px;"><span class="color-red">*</span>原密码</label>
				<div class="controls" style="margin-left: 180px;">
					<input type="password" id="pwd0" placeholder="请输入原密码" class="input-common" />
					<span class="help-block"></span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="pwd1" style="width: 160px;"><span class="color-red">*</span>新密码</label>
				<div class="controls" style="margin-left: 180px;">
					<input type="password" id="pwd1" placeholder="请输入新密码" class="input-common" />
					<span class="help-block"></span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="pwd2" style="width: 160px;"><span class="color-red">*</span>再次输入密码</label>
				<div class="controls" style="margin-left: 180px;">
					<input type="password" id="pwd2" placeholder="请输入确认密码" class="input-common" />
					<span class="help-block"></span>
				</div>
			</div>
			<div style="text-align: center; height: 20px;" id="show"></div>
		</form>
	</div>
	<div class="modal-footer">
		<button class="btn-common btn-big" onclick="submitPassword()" style="display:inline-block;">保存</button>
		<button class="btn-common-cancle btn-big" data-dismiss="modal" aria-hidden="true">关闭</button>
	</div>
</div>

<link rel="stylesheet" type="text/css" href="/template/admin/public/css/jquery-ui-private.css">
<script>
var platform_shopname= '<?php echo $web_popup_title; ?>';
</script>
<script type="text/javascript" src="/template/admin/public/js/jquery-ui-private.js" charset="utf-8"></script>
<script type="text/javascript" src="/template/admin/public/js/jquery.timers.js"></script>
<div id="dialog"></div>
<script type="text/javascript">
function showMessage(type, message,url,time){
	if(url == undefined){
		url = '';
	}
	if(time == undefined){
		time = 2;
	}
	//成功之后的跳转
	if(type == 'success'){
		$( "#dialog").dialog({
			buttons: {
				"确定,#4685fd,#fff": function() {
					$(this).dialog('close');
				}
			},
			contentText:message,
			time:time,
			timeHref: url,
			msgType : type
		});
	}
	//失败之后的跳转
	if(type == 'error'){
		$( "#dialog").dialog({
			buttons: {
				"确定,#4685fd,#fff": function() {
					$(this).dialog('close');
				}
			},
			time:time,
			contentText:message,
			timeHref: url,
			msgType : type
		});
	}
}

function showConfirm(content){
	$( "#dialog").dialog({
		buttons: {
			"确定": function() {
				$(this).dialog('close');
				return 1;
			},
			"取消,#f5f5f5,#666": function() {
				$(this).dialog('close');
				return 0;
			}
		},
		contentText:content,
	});
}
</script>
<script src="/template/admin/public/js/ns_common_base.js"></script>
<script src="/public/static/blue/js/ns_common_blue.js"></script>
<script>
$(function(){
	
	$(".ns-third-menu ul .btn-more").toggle(
		function(){
			$(".ns-third-menu ul").animate({height:"84px"},300);
		},
		function(){
			$(".ns-third-menu ul").animate({height:"42px"},300);
		}
	);
	
	//公共下拉框
	$('.select-common').selectric();
	
	//解决label两次调用事件
/*  	$(".checkbox-common").on("click",function(event){

 		if($(event.target).is("i")){
 			event.stopPropagation();//阻止其继续冒泡
 		}
 	}); */
	
	//公共复选框点击切换样式
	$(".checkbox-common").live("click",function(event){ 
		//如果样式是选中设置input为不选中		
		if($(this).hasClass('selected')){
			$(this).children("input").prop("checked", false);
		}   
		
		var checkbox = $(this).children("input");
		
		/* if(checkbox.is(":checked") === false){
			if ($(event.target).is("input") === false){
				event.stopPropagation();
	      		return;
			 }
		} */
		
		if(checkbox.is(":checked")){			 
			$(this).addClass("selected");
		}else{			

			$(this).removeClass("selected");
		}
		
		//如果为全选按钮
		if($(this).parents('thead').length > 0){
			
			obj = $(this).parents('table').find('tbody');
			if(checkbox.is(":checked")){
				obj.find("input[type = 'checkbox']").prop("checked", true);
				obj.find("input[type = 'checkbox']").parent().addClass("selected");
			}else{
				obj.find("input[type = 'checkbox']").prop("checked", false);
				obj.find("input[type = 'checkbox']").parent().removeClass("selected");
			}
		}
	});
	
	//鼠标浮上查看预览上传的图片
	$(".upload-btn-common>img,#preview_adv").live("mouseover",function(){
		var curr = $(this);
		var src = curr.attr("data-src");
		if(src){
			//alert(src);
			var contents = '<img src="'+src+'" style="width: 100px;height: auto;display:block;margin:0 auto;">';
			//鼠标每次浮上图片时，要销毁之前的事件绑定
			curr.popover("destroy");
			
			//重新配置弹出框内容
			curr.popover({ content : contents });

			//显示
			curr.popover("show");
		}
	});
	
	//鼠标离开隐藏预览上传的图片
	$(".upload-btn-common>img,#preview_adv").live("mouseout",function(){
		var curr = $(this);
		//隐藏
		if($(".popover.top").is(":visible") && curr.attr("data-src")) curr.popover("hide");
	});

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

	//顶部导航管理显示隐藏
	$(".ns-navigation-title>span").click(function(){
		$(".ns-navigation-management").slideUp(400);
	});
	
	$(".js-nav").toggle(function(){
		$(".ns-navigation-management").slideDown(400);
	},function(){
		$(".ns-navigation-management").slideUp(400);
	});
	
	//搜索展开
	$(".ns-search-block").hover(function(){
		if($(this).children(".mask-layer-search").is(":hidden")) $(this).children(".mask-layer-search").fadeIn(300);
	},function(){
		if($(this).children(".mask-layer-search").is(":visible")) $(this).children(".mask-layer-search").fadeOut(300);
	});
	
	$(".ns-base-tool .ns-help").hover(function(){
		if($(this).children("ul").is(":hidden")) $(this).children("ul").fadeIn(250);
	},function(){
		if($(this).children("ul").is(":visible")) $(this).children("ul").fadeOut(250);
	});
	
	// 给所有input禁用自动完成属性
	$('.input-common:not([autocomplete])').attr('autocomplete', 'off');
});

function addFavorite() {
	var url = window.location;
	var title = document.title;
	var ua = navigator.userAgent.toLowerCase();
	if (ua.indexOf("360se") > -1) {
		alert("由于360浏览器功能限制，请按 Ctrl+D 手动收藏！");
	}else if (ua.indexOf("msie 8") > -1) {
		window.external.AddToFavoritesBar(url, title); //IE8
	}
	else if (document.all) {
		try{
			window.external.addFavorite(url, title);
		}catch(e){
			alert('您的浏览器不支持,请按 Ctrl+D 手动收藏!');
		}
	}else if (window.sidebar) {
		window.sidebar.addPanel(title, url, "");
	}else {
		alert('您的浏览器不支持,请按 Ctrl+D 手动收藏!');
	}
}

$('.ns-base-tool .ns-help ul li').hover(function(){
	var old_img = $(this).find('img').attr('src');
	var img = old_img.replace('.png', "_check.png");
	$(this).find('img').attr('src', img);
},function() {
	var old_img = $(this).find('img').attr('src');
	var img = old_img.replace('_check.png', ".png");
	$(this).find('img').attr('src', img);
	
});

var primary_selector_v = '.default-condition';
var primary_selector_h = '';
//高级搜索
function openSeniorSearch(primary_selector){
	primary_selector_h = $(primary_selector).html();
	$(primary_selector).html('');
	$('.nui-condition').show();
	primary_selector_v = primary_selector;
}
//清除高级筛选条件
function clearCondition(){
	$('.nui-condition').find('input').val('');
	$('.nui-condition').find('select').val('');
	$('.select-common').selectric();
}

//收起高级筛选
function retractSeniorSearch(){
	$(primary_selector_v).html(primary_selector_h);
	$('.nui-condition').hide();
}
</script>

<script type="text/javascript">
$(function(){
	$(".js-update-goods-name,.js-update-introduction").live("blur",function(){
		var up_type = $(this).attr("data-up-type");
		var goods_id = $(this).attr("data-goods-id");
		var editContent = $(this).val();
		if(editContent == ""){
			if(up_type == "goods_name"){
				showTip("商品名不可为空","warning");
				$(this).focus();
				return false;
			}
		}
		var $self = $(this);
		$.ajax({
			type : "post",
			url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/goods/ajaxEditGoodsNameOrIntroduction'); ?>",
			data : {
				"goods_id" : goods_id,
				"up_type" : up_type,
				"up_content" : editContent
			},
			success : function(data){
				if(data['code'] > 0){
					$self.prev(".editGoodsIntroduction").children("a").text(editContent);
				}
				$self.hide();
				$self.prev(".editGoodsIntroduction").show();
			}
		});
	}).live("keyup",function(event){
		if(event.keyCode == 13) $(this).blur();
	});
	

	// 排序规则
	$(".goods-fields-sort").click(function(){
		var field = $(this).attr("data-field"),
			order = $(this).attr("data-order");

		$(".goods-fields-sort").removeClass('selected');	
		$(this).addClass('selected');

		if (order == 'asc') {
			$(this).attr('data-order', 'desc');
			$(this).find('.order').removeClass('desc').addClass('asc');	
			field += ",a";		
		} else {
			$(this).attr('data-order', 'asc');
			$(this).find('.order').removeClass('asc').addClass('desc');	
			field += ",d";
		}
		$("#hidden_sort_rule").val(field);
		LoadingInfo(1);
	})
});

function searchData(){
	$(".more-search-container").slideUp();
	LoadingInfo(1);
}

//隐藏商品分组
function hideEditGroup(){
	$("#editGroup").popover("hide");
}

function hideSetRecommend(){
	$("#setRecommend").popover("hide");
}

function LoadingInfo(page_index) {
	var start_date = $("#startDate").val();
	var end_date = $("#endDate").val();
	var state = $("#state").val();
	var goods_name =$("#goods_name").val();
	var goods_code = $("#goods_code").val();
	var category_ids = $(".nui-condition .select-category").attr('data-value');
	var	category_id_arr = category_ids != undefined && category_ids != '' ? category_ids.split(',') : [];
	var category_id_1 = category_id_arr[0] != undefined ? category_id_arr[0] : 0;
	var category_id_2 = category_id_arr[1] != undefined ? category_id_arr[1] : 0;
	var category_id_3 = category_id_arr[2] != undefined ? category_id_arr[2] : 0;
	var selectGoodsLabelId = $("#selectGoodsLabelId").val();
	var supplier_id = $("#supplier_id").val();
	var stock_warning = $("#stock_warning").val();
	var goods_type = $("#goods_type").val() == null ? 'all' : $("#goods_type").val();
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/goods/goodslist'); ?>",
		data : {
			"page_index" : page_index,
			"page_size" : $("#showNumber").val(),
			"start_date":start_date,
			"end_date":end_date,
			"state":state,
			"goods_name":goods_name,
			"code":goods_code,
			"category_id_1" : category_id_1,
			"category_id_2" : category_id_2,
			"category_id_3" : category_id_3,
			"selectGoodsLabelId" : selectGoodsLabelId,
			"supplier_id" : supplier_id,
			"stock_warning" : stock_warning,
			'sort_rule' : $("#hidden_sort_rule").val(),
			'goods_type' : goods_type
		},
		success : function(data) {
			if (data["data"].length > 0) {
				$("#productTbody").empty();
				for (var i = 0; i < data["data"].length; i++) {
					var item = data["data"][i];
					var goodsLabel = '',
						operationHtml = `
							<a href="`+ __URL("http://t.huaqi86.com/index.php/admin/goods/editGoods?goods_id="+ item.goods_id) +`">编辑</a>
							<span class="sep"></span>
							<a href="javascript:copyGoodsDetail(`+ item.goods_id +`);">复制</a>
							<span class="sep"></span>
							<a href="javascript:deleteGoods(`+ item.goods_id +`);">删除</a>
							<span class="sep"></span>
						`,
						fxHtml = '',
						stockHtml = item.stock;

					// 商品操作html
					if (item.state) operationHtml += `<a href="javascript:modifyGoodsOnline(`+ item.goods_id +`, 'offline');">下架</a>`;
					else operationHtml += `<a href="javascript:modifyGoodsOnline(`+ item.goods_id +`, 'online');">上架</a>`;
					if (item.is_virtual) operationHtml+= `<br><a href="`+ __URL("http://t.huaqi86.com/index.php/admin/goods/virtualGoodsManage?goods_id="+ item.goods_id) +`" title="虚拟商品管理" target="_blank">虚拟商品</a>`

					// 库存html
					if (item.goods_type != 4) stockHtml += '<i class="iconfont iconbianji" onclick="goodsSkuDialogShow('+ item.goods_id +',\''+ item.goods_type +'\')"></i>'

					// 商品标签 推荐 html
					if (item.goods_group_array != undefined && item.goods_group_array.length > 0) {
						item.goods_group_array.forEach(function(labelItem, index){
							if (labelItem.group_name != '') goodsLabel += '<span class="goods-label" onclick="cancelLabelRecommend('+ item.goods_id +',\'label\',\''+ labelItem.group_id +'\')" title="点击取消该标签">'+ labelItem.group_name +'</span>'
						})
					}

					if (item.is_hot) goodsLabel += '<span class="goods-recommend" onclick="cancelLabelRecommend('+ item.goods_id +', \'recommend\',\'hot\')" title="点击取消该推荐">热</span>';
					if (item.is_recommend) goodsLabel += '<span class="goods-recommend" onclick="cancelLabelRecommend('+ item.goods_id +', \'recommend\',\'recommend\')" title="点击取消该推荐">精</span>';
					if (item.is_new) goodsLabel += '<span class="goods-recommend" onclick="cancelLabelRecommend('+ item.goods_id +', \'recommend\',\'new\')" title="点击取消该推荐">新</span>';
					if (item.shipping_fee == 0.00 && item.is_virtual == 0) goodsLabel += '<span class="free-shipping">包邮</span>';

					// 商品分销html
					<?php if(addon_is_exit('Nsfx')): ?>
						fxHtml += '<td>';
							fxHtml += '<div class="fx-info">';
								if (item.distribution.is_open) {
									fxHtml += '<p>是否开启分销 <span class="status-mark">已开启</span></p>';
								} else {
									fxHtml += '<p>是否开启分销 <span class="status-mark not-opened">未开启</span></p>';
								}
								fxHtml += '<p>分销佣金比率：'+ item.distribution.distribution_commission_rate +'%</p>';
								fxHtml += '<p>股东分红比率：'+ item.distribution.partner_commission_rate +'%</p>';
								fxHtml += '<p>区域分销比率：'+ item.distribution.regionagent_commission_rate +'%</p>';
							fxHtml += '</div>';
						fxHtml += '</td>';
					<?php endif; ?>
	
					var html = `
					<tr>
						<td class="td-`+ item.goods_id +`">
							<i class="checkbox-common">
								<input value="`+ item.goods_id +`" name="sub" data-state="`+ item.state +`" type="checkbox">
							</i>
						</td>
						<td>
							<div class="goods-info">
								<div class="sku-click">
									<a href="javascript:;" onclick="goodsSkuDetailsList(this, `+ item.goods_id +`,'`+ item.pic_cover_small +`')" class="goods-sku-click">+</a>
								</div>
								<div class="goods-img">
									<a target="_blank" href="`+ __URL('http://t.huaqi86.com/index.php/goods/detail?goods_id='+ item.goods_id) +`">
										<img src="`+ __IMG(item.pic_cover_small) +`" alt="">
									</a>
								</div>
								<div class="info-wrap">
									<div class="info">
										<span class="c_text">创建时间：</span><span class="c_time">`+ timeStampTurnTime(item.create_time) +`</span>
										<span class="div-flag-style">
											<i class="iconfont iconerweima goods-qrcode"></i>
											<div class="QRcode">
												<p><img src="`+ __IMG(item.QRcode) +`" style="width:110px;"></p>
											</div>
										</span>
									</div>
									<a target="_blank" href="`+ __URL('http://t.huaqi86.com/index.php/goods/detail?goods_id='+ item.goods_id) +`">
										<p class="goods-name">`+ item.goods_name +`</p>
									</a>
									<div class="line-height-none clearfix">
										<p class="goods-introduction">`+ item.introduction +`</p>

									</div>
									<div class="line-height-none">
										`+ goodsLabel +`
									</div>
								</div>
							</div>
						</td>
						`+ fxHtml +`
						<td class="align-center">
							<span class="goods-price">
								`+ item.promotion_price +`
								<i class="iconfont iconbianji" onclick="goodsSkuDialogShow(`+ item.goods_id +`,'`+ item.goods_type +`')"></i>
							</span>
						</td>
						<td class="align-right">
							<span class="goods-stock">
								`+ stockHtml +`
							</span>
						</td>
						<td class="align-center">
							<span class="goods-sales">`+ item.real_sales +`</span>
						</td>
						<td class="align-center">
							<span class="goods-type">`+ item.type_config.title +`</span>
						</td>
						<td class="align-center">
							<span class="goods-sort">
								<input class="input-common input-common-sort" goods_id="`+ item.goods_id +`"  value="`+ item.sort +`" onchange="changeSort(this)"' + 'type="number" title="排序号数值越大，商城商品列表显示越靠前">
							</span>
						</td>
						<td class="align-center goods-operation">
							<div>
								`+ operationHtml +`
							</div>
						</td>
					</tr>
					<tr class="single-goods-sku active"></tr>
					`;
					$("#productTbody").append(html);
				}
			} else {
				var html = '<tr align="center"><td colspan="9" style="text-align: center;font-weight: normal;color: #999;">暂无符合条件的数据记录</td></tr>';
				$("#productTbody").html(html);
			}
			initPageData(data["page_count"],data['data'].length,data['total_count']);
			$("#pageNumber").html(pagenumShow(jumpNumber,$("#page_count").val(),<?php echo $pageshow; ?>));
			code();
		}
	});
}

//二维码
function code(){
	$(".div-flag-style").mouseover(function(){
		$(this).children('.QRcode').show();
	});
	$(".div-flag-style").mouseout(function(){
		$(this).children('.QRcode').hide();
	});
} 

//把值传过去即可
function updateGoodsDetail(goods_id) {
	window.location = __URL("http://t.huaqi86.com/index.php/admin/goods/addgoods?step=2&goodsId="+ goods_id);
}

//商品上架id合计
function goodsIdCount(line){
	var goods_ids= "";
	$("#productTbody input[type='checkbox']:checked").each(function() {
		if (!isNaN($(this).val())) {
			var state = $(this).data("state");
			goods_ids = $(this).val() + "," + goods_ids;
		}
	});
	goods_ids = goods_ids.substring(0, goods_ids.length - 1);
	if(goods_ids == ""){
		showTip("请选择需要操作的记录","warning");
		return false;
	}
	modifyGoodsOnline(goods_ids,line);
}

//商品上下架
function modifyGoodsOnline(goods_ids,line){
	if(line == "online"){
		var url = "<?php echo __URL('http://t.huaqi86.com/index.php/admin/Goods/modifygoodsonline'); ?>";
		var lingStr = "上架";
	}else{
		var url = "<?php echo __URL('http://t.huaqi86.com/index.php/admin/Goods/modifygoodsoffline'); ?>";
		var lingStr = "下架";
	}
	$.ajax({
		type : "post",
		url : url,
		data : { "goods_ids" : goods_ids },
		success : function(data) {
			if(data["code"] > 0 ){
				LoadingInfo(getCurrentIndex(goods_ids,'#productTbody','tr[class="tr-title"]'));
				showTip("商品"+lingStr+"成功","success");
			}
		}
	})
}

function batchDelete() {
	var goods_ids= new Array();
	$("#productTbody input[type='checkbox']:checked").each(function() {
		if (!isNaN($(this).val())) {
			goods_ids.push($(this).val());
		}
	});
	if(goods_ids.length ==0){
		showTip("请选择需要操作的记录","warning");
		return false;
	}
	deleteGoods(goods_ids);
}

function deleteGoods(goods_ids){
	$( "#dialog" ).dialog({
		buttons: {
			"确定": function() {
				$.ajax({
					type : "post",
					url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/goods/deletegoods'); ?>",
					data : { "goods_ids" : goods_ids.toString() },
					dataType : "json",
					success : function(data) {
						if(data["code"] > 0 ){
							LoadingInfo(getCurrentIndex(goods_ids,'#productTbody','tr[class="tr-title"]'));
							showTip(data['message'],"success");
							$("#chek_all").prop("checked", false);
						}
					}
				});
				$(this).dialog('close');
			},
			"取消,#f5f5f5,#666": function() {
				$(this).dialog('close');
			},
		},
		contentText:"确定要删除吗？",
	});
}

//商品修改分组id合计
function goodsGroupIdCount(){
	var goods_ids= "";
	$("#productTbody input[type='checkbox']:checked").each(function() {
		if (!isNaN($(this).val())) {
			goods_ids = $(this).val() + "," + goods_ids;
		}
	});
	goods_ids = goods_ids.substring(0, goods_ids.length - 1);
	if(goods_ids == ""){
		showTip("请选择需要操作的记录","warning");
		return false;
	}
	$("#goods_type_ids").val(goods_ids);
	$("#editGroup").popover("show");
	$(".popover").css("max-width",'1000px');
}

//商品修改分组
function goodsGroupUpdate(){
	var goods_type = "";
	var goods_ids = $("#goods_type_ids").val();
	$("#goodsChecked input[type='checkbox']:checked").each(function(){
		if (!isNaN($(this).val())) {
			goods_type = $(this).val() + "," + goods_type;
		}
	});
	goods_type = goods_type.substring(0, goods_type.length - 1);
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/goods/modifygoodsgroup'); ?>",
		data : { "goods_id" : goods_ids, "goods_type" : goods_type },
		success : function(data) {
			if(data["code"] > 0 ){
				$("#editGroup").popover("hide");
				LoadingInfo(getCurrentIndex(goods_ids,'#productTbody','tr[class="tr-title"]'));
				showTip(data['message'],"success");
			}
		}
	})
}

//显示 推荐选项
function ShowRecommend(){
	var goods_ids= "";
	$("#productTbody input[type='checkbox']:checked").each(function() {
		if (!isNaN($(this).val())) {
			goods_ids = $(this).val() + "," + goods_ids;
		}
	});
	goods_ids = goods_ids.substring(0, goods_ids.length - 1);
	if(goods_ids == ""){
		showTip("请选择需要操作的记录","warning");
		return false;
	}
	$("#goods_type_ids").val(goods_ids);
	$("#setRecommend").popover("show");
}

$("#recommendType label,#recommendType label input").live("click",function(){
// 	if($(this).children("input").is(":checked")){
// 		$(this).children("input").prop("checked",false);
// 	}else{
// 		$("#recommendType label input").prop("checked",false);
// 		$(this).children("input").prop("checked",true);
// 	}
});

//修改为  推荐 商品
function setRecommend(){
	var recommend_type = '';
	var goods_ids = $("#goods_type_ids").val();
	$("#recommendType input[type='checkbox']").each(function(){
		if ($(this).attr("checked") == 'checked') {
			var recommend_type_new = 1;
		}else{
			var recommend_type_new = 0;
		}
		recommend_type = recommend_type_new + "," + recommend_type;
	});
	if(recommend_type == ""){
		showTip("请选择需要操作的记录","warning");
		return false;
	}
	recommend_type = recommend_type.substring(0, recommend_type.length - 1);
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/goods/modifygoodsrecommend'); ?>",
		data : {
			"goods_id" : goods_ids,
			"recommend_type" : recommend_type
		},
		success : function(data) {
			if(data["code"] > 0 ){
				$("#setRecommend").popover("hide");
				LoadingInfo(getCurrentIndex(goods_ids,'#productTbody','tr[class="tr-title"]'));
				showTip(data['message'],"success");
			} 
		}
	})
}

function copyGoodsDetail(goods_id){
	$( "#dialog" ).dialog({
		buttons: {
			"确定": function() {
				$.ajax({
					type : "post",
					url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/goods/copygoods'); ?>",
					data : {"goods_id":goods_id},
					dataType : "json",
					success : function(data) {
						if(data["code"] > 0 ){
							LoadingInfo(getCurrentIndex(goods_id,'#productTbody','tr[class="tr-title"]'));
							showTip(data["message"],"success");
							$("#chek_all").prop("checked", false);
						}else{
							showTip(data["message"],"error");
						}
					}
				});
				$(this).dialog('close');
			},
			"取消,#f5f5f5,#666": function() {
				$(this).dialog('close');
			},
		},
		contentText:"确定要复制一条新的商品信息吗？",
	});
}

function changeSort(event){
	var sort = parseInt($(event).val());
	$(event).val(sort);
	var goods_id = $(event).attr("goods_id");
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/goods/modifygoodssort'); ?>",
		data : { "sort" : sort, "goods_id" : goods_id },
		success : function(data){
			if(data.code>0){
				LoadingInfo(getCurrentIndex(goods_id,'#productTbody','tr[class="tr-title"]'));
				showTip(data.message,"success");
			}else{
				showTip(data.message,"error");
			}
		}
	})
}

//更新二维码
function batchUpdateGoodsQrcode(){
	var goods_ids= new Array();
	$("#productTbody input[type='checkbox']:checked").each(function() {
		if (!isNaN($(this).val())) {
			goods_ids.push($(this).val());
		}
	});
	if(goods_ids.length == 0){
		showTip("请至少选择一件商品","warning");
		return false;
	}
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/goods/updateGoodsQrcode'); ?>",
		data : { "goods_id" : goods_ids.toString() },
		success : function(data){
			if (data["code"] > 0) {
				LoadingInfo(getCurrentIndex(goods_ids,'#productTbody','tr[class="tr-title"]'));
				showTip('二维码更新成功',"success");
			}else{
				showTip(data['message'],"error");
			}
		}
	})
}

function selectGoodsLabel(){
	$("#selectGoodsLabel").popover("show");
	$("#selectGoodsLabelId").val('');
	$("#selectGoodsLabel").val('');
}

function hideGroup(){
	$("#selectGoodsLabel").popover("hide");
	$("#selectGoodsLabel").val('');
}

function clickGoodsLabel(event){
	var goods_label_id = $(event).val();
	var goods_label_name = $(event).next("span").text();
	var selectGoodsLabelVal = $("#selectGoodsLabel").val();
	var selectGoodsLabelId = $("#selectGoodsLabelId").val();
	if($(event).is(":checked")){
		$("#selectGoodsLabelId").val(selectGoodsLabelId+goods_label_id+',');
		$("#selectGoodsLabel").val(selectGoodsLabelVal+goods_label_name+';');
	}else{
		selectGoodsLabelVal = selectGoodsLabelVal.replace(goods_label_name+';','');
		selectGoodsLabelId = selectGoodsLabelId.replace(goods_label_id+',','');
		$("#selectGoodsLabelId").val(selectGoodsLabelId);
		$("#selectGoodsLabel").val(selectGoodsLabelVal);
	}
}

function confirm(){
	$("#selectGoodsLabel").popover("hide");
}

function editGoodsInfo(event){
	$(event).hide();
	$(event).next("input").show().focus();
}

// 点击显示更多搜索
$(".more-search").on("click", function(e){
	$(".more-search-container").slideToggle();
	$(document).one("click", function(){
        $(".more-search-container").slideUp();
    });
    e.stopPropagation();
});

$(".more-search-container").on("click", function(e){
    e.stopPropagation();
});

// 批量处理弹出框
$("#batchProcessing").click(function(){
	batchProcessing();
});

function batchProcessing(){
	var goods_ids= [];
	$("#productTbody input[type='checkbox']:checked").each(function() {
		if (!isNaN($(this).val())) {
			goods_ids.push($(this).val());
		}
	});
	if(goods_ids.length == 0){
		showTip("请至少选择一件商品","warning");
		return false;
	}
	$("#batch_processing").modal("show");
}


// 批量处理弹出框
$("#setMemberDiscount").click(function(){
	setMemberDiscount();
});
function setMemberDiscount(){
	var goods_ids= [];
	$("#productTbody input[type='checkbox']:checked").each(function() {
		if (!isNaN($(this).val())) {
			goods_ids.push($(this).val());
		}
	});
	if(goods_ids.length == 0){
		showTip("请至少选择一件商品","warning");
		return false;
	}
	$("#set_member_discount").modal("show");
}
function addGoods(){
	var type_count = <?php echo count($goods_type_list); ?>;
	var area_height = 300;
	if(type_count == 5 || type_count == 6){
		area_height = 400;
	}else if(type_count == 7 || type_count == 8){
		area_height = 550;
	}
	
	<?php if(count($goods_type_list) == 0): ?>
		showTip("请先安装至少一种商品插件","warning");
	<?php elseif(count($goods_type_list) == 1): ?>
		type_info("<?php echo $goods_type_list[0]['name']; ?>");
	<?php else: ?>
		layer.open({
		  type: 1,
		  title: '',
		  area: ['900px', area_height+'px'],
		  content: `<div class="goods-type">
			<h3 class="type-title">选择上货方式</h3>
			<?php if(is_array($goods_type_list) || $goods_type_list instanceof \think\Collection || $goods_type_list instanceof \think\Paginator): $i = 0; $__LIST__ = $goods_type_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<div class="item-type" onclick="type_info('<?php echo $vo['name']; ?>')">
				<div class="item-img"><img src="/<?php echo $vo['ico']; ?>" alt="" /></div>
				<div class="item-content">
					<p class = "name"><?php echo $vo['title']; ?></p>
					<p class = "description">（<?php echo $vo['description']; ?>）</p>
				</div>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</div>`
		  ,yes: function(index, layero){
			  layer.close(index);
		  }
		});
	<?php endif; ?>
}

type_info = function(type_name){
	location.href = __URL("http://t.huaqi86.com/index.php/admin/goods/addGoods?type="+ type_name);
}

function cancelLabelRecommend(goodsId, type, value){
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/goods/cancelLabelRecommend'); ?>",
		data : {
			"goods_id" : goodsId,
			"type" : type,
			"value" : value
		},
		success : function(data) {
			if(data["code"] > 0 ){
				LoadingInfo(getCurrentIndex(goodsId,'#productTbody','tr[class="tr-title"]'));
				showTip(data['message'],"success");
			} 
		}
	})
}

// 更多
$('#batch-processing').change(function(event) {
	switch($(this).val()){
		case 'qrcode':
			batchUpdateGoodsQrcode();
		break;
		case 'goodsinfo':
			batchProcessing();
		break;	
		case 'memberdiscount':
			setMemberDiscount();
		break;
		case 'goodsfx':
			distributionSetting();
		break;
	}
});

$(window).scroll(function(event) {
	var scrollTop = $(this).scrollTop();
	if ($('#goodsChecked').parents('.popover').offset() != undefined) {
		if (scrollTop > ($('#goodsChecked').parents('.popover').offset().top - 50)) {
			$("#editGroup").popover("hide");
		}
	}
	if ($('#recommendType').parents('.popover').offset() != undefined) {
		if (scrollTop > ($('#recommendType').parents('.popover').offset().top - 50)) {
			$("#setRecommend").popover("hide");
		}
	}
});

function search_group(){
	var search_group_name = $(".search-input").val();
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/admin/goods/goodsGroupList'); ?>",
		data : {
			"group_name" : search_group_name
		},
		success : function(data) {
			if(data.data.length > 0){
				var html = "";
				var data = data.data;
				for(var i = 0	; i<data.length; i++){
					html += "<label class='checkbox-inline'>";
						html += "<i class='checkbox-common'><input type='checkbox' value='"+ data[i]['group_id'] +"'></i>";
						html += "<span>"+  data[i]['group_name'] +"</span>&nbsp;&nbsp;&nbsp;";
					html += "</label>";
				}
				$("#goodsChecked").html(html);
			} 
		}
	})
}

</script>

<?php if(addon_is_exit('Nsfx')): ?>
<style>
.set-style dl dt{width:200px !important;}
.set-style dl dd{width:auto !important;}
#queryGoodsCommissionRate .set-style dl dd{line-height: 34px;}
#distributionSetting .modal-body{overflow-y: initial}
.progress-modal {width: 360px;height: 140px;background: #fff;position: fixed;z-index: 100;top: 50%;left: 50%;transform: translate(-50%,-50%);box-shadow: 0 5px 15px rgba(0,0,0,0.2);padding: 20px;box-sizing: border-box;}
.progress-modal h4 {text-align: center;font-size: 14px;}
.progress-modal .progress-bar {width: 100%;margin: 5px auto;height: 10px;border:1px solid #ddd;border-radius: 10px;overflow:hidden;margin-top: 20px;}
.progress-modal .progress-bar div {width: 0;height: 100%;background: #00A0DE;}
.progress-modal .progress-desc {text-align: center;margin-top: 10px;}
</style>

<!-- 分销设定 -->
<div class="modal fade hide" id="distributionSetting" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title">分销设定</h4>
      		</div>
      		<div class="modal-body">
        		<div class="set-style">
            		<dl>
						<dt>是否开启：</dt>
						<dd>
							<p>
								<input type="checkbox"  class="checkbox" name="is_open" />
							</p>	
						</dd>
					</dl>
            		<dl>
						<dt>分销佣金比率：</dt>
						<dd>
							<p>
								<input name="distribution_commission_rate" type="number"  class="input-common harf" value="0" /><em class="unit">%</em>
							</p>	
						</dd>
					</dl>
					<dl>
						<dt>区域分销佣金比率：</dt>
						<dd>
							<p>
								<input name="regionagent_commission_rate" type="number" class="input-common harf" value="0" /><em class="unit">%</em>
							</p>	
						</dd>
					</dl>
					<dl>
						<dt>股东分红佣金比率：</dt>
						<dd>
							<p>
								<input name="partner_commission_rate" type="number" value="0" class="input-common harf" /><em class="unit">%</em>
							</p>	
						</dd>
					</dl>
					<dl class="hide">
						<dt>分销团队分红佣金比率：</dt>
						<dd>
							<p>
								<input name="distribution_team_commission_rate" type="number" value="0" class="input-common harf" /><em class="unit">%</em>
							</p>	
						</dd>
					</dl>
					<dl class="hide">
						<dt>股东团队分红佣金比率：</dt>
						<dd>
							<p>
								<input name="partner_team_commission_rate" type="number" value="0" class="input-common harf" /><em class="unit">%</em>
							</p>	
						</dd>
					</dl>
					<dl class="hide">
						<dt>渠道代理分红佣金比率：</dt>
						<dd>
							<p>
								<input name="channelagent_commission_rate" type="number" value="0" class="input-common harf" /><em class="unit">%</em>
							</p>	
						</dd>
					</dl>
					<dl>
						<dt>选择商品：</dt>
						<dd>
							<p>
								<label class="radio inline normal">
									<i class="radio-common selected">
										<input type="radio" name="type" checked="checked" value="1" />
									</i>
									<span>全部</span>
								</label>
								<label class="radio inline normal">
									<i class="radio-common">
										<input type="radio" name="type" value="0" />
									</i>
									<span>部分</span>
								</label>
							</p>
						</dd>
					</dl>
					<div class="goods-select hide">
						<dl>
							<dt>商品来源：</dt>
							<dd>
								<label class="radio inline normal">
									<i class="radio-common selected">
										<input type="radio" name="from_type" checked="checked" value="label" />
									</i>
									<span>标签</span>
								</label>
								<label class="radio inline normal">
									<i class="radio-common">
										<input type="radio" name="from_type" value="category" />
									</i>
									<span>分类</span>
								</label>
								<label class="radio inline normal">
									<i class="radio-common">
										<input type="radio" name="from_type" value="brand" />
									</i>
									<span>品牌</span>
								</label>
								<label class="radio inline normal">
									<i class="radio-common">
										<input type="radio" name="from_type" value="recommend" />
									</i>
									<span>推荐</span>
								</label>
								<label class="radio inline normal">
									<i class="radio-common">
										<input type="radio" name="from_type" value="goods_type" />
									</i>
									<span>类型</span>
								</label>
								<label class="radio inline normal hide">
									<i class="radio-common">
										<input type="radio" name="from_type" value="goods_ids" />
									</i>
									<span>已选商品</span>
								</label>
							</dd>
						</dl>
						<dl data-type="label">
							<dt></dt>
							<dd>
								<select name="label" class="select-common">
									<?php foreach($goods_group as $vo): ?>
										<option value="<?php echo $vo['group_id']; ?>"><?php echo $vo['group_name']; ?></option>
									<?php endforeach; ?>
								</select>
							</dd>
						</dl>
						<dl data-type="category" class="hide">
							<dt></dt>
							<dd>
								<div class="goods-category-container">
									<input type="text" placeholder="请选择商品分类" show="false" class="input-common select-category" name="category" data-value="">
									<div class="category-wrap hide">
										<div class="goodsCategory one">
											<ul>
												<?php if(is_array($oneGoodsCategory) || $oneGoodsCategory instanceof \think\Collection || $oneGoodsCategory instanceof \think\Paginator): $i = 0; $__LIST__ = $oneGoodsCategory;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
												<li data-value="<?php echo $vo['category_id']; ?>" data-level="<?php echo $vo['level']; ?>" data-has-child="<?php echo $vo['is_parent']; ?>">
													<span><?php echo $vo['category_name']; ?></span>
													<?php if($vo['is_parent'] == 1): ?>
														<i class="fa fa-angle-right fa-lg"></i>
													<?php endif; ?>
												</li>
												<?php endforeach; endif; else: echo "" ;endif; ?>
											</ul>
										</div>
										<div class="goodsCategory two hide" style="border-left:0;">
											<ul></ul>
										</div>
										<div class="goodsCategory three hide">
											<ul></ul>
										</div>
										<div class="selectGoodsCategory">
											<a href="javascript:;" style="float:right;" class="confirm-select">确认选择</a>
										</div>
									</div>
								</div>
							</dd>
						</dl>
						<dl data-type="goods_type" class="hide">
							<dt></dt>
							<dd>
								<select name="goods_type" class="select-common">
									<?php if(is_array($goods_type_list) || $goods_type_list instanceof \think\Collection || $goods_type_list instanceof \think\Paginator): $i = 0; $__LIST__ = $goods_type_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
										<option value="<?php echo $vo['id']; ?>"><?php echo $vo['title']; ?></option>
									<?php endforeach; endif; else: echo "" ;endif; ?>
								</select>
							</dd>
						</dl>
						<dl data-type="recommend" class="hide">
							<dt></dt>
							<dd>
								<select name="recommend" class="select-common">
									<option value="1">热卖</option>
									<option value="2">精品</option>
									<option value="3">新品</option>
								</select>
							</dd>
						</dl>
						<dl data-type="brand" class="hide">
							<dt></dt>
							<dd>
								<select name="brand" class="select-common">
									<?php foreach($brand_list as $k => $v): ?>
										<option value="<?php echo $v['brand_id']; ?>" ><?php echo $v['brand_name']; ?></option>
									<?php endforeach; ?>
								</select>
							</dd>
						</dl>
					</div>

            	</div>
      		</div>
      		<div class="modal-footer">
        		<button class="btn-common btn-big" onclick="saveDistributionSetting('distributionSetting');">保存</button>
				<button class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
      		</div>
    	</div>
  	</div>
</div>

<!-- 商品分销 -->
<div class="modal fade hide" id="goodsDistribution" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title">商品分销</h4>
      		</div>
      		<div class="modal-body">
				<div class="set-style">
            		<dl>
						<dt>是否开启：</dt>
						<dd>
							<p class="is-open">
								<input type="checkbox"  class="checkbox" name="is_open" />
							</p>	
						</dd>
					</dl>
            		<dl>
						<dt>分销佣金比率：</dt>
						<dd>
							<p>
								<input name="distribution_commission_rate" type="number"  class="input-common harf" value="0" /><em class="unit">%</em>
							</p>	
						</dd>
					</dl>
					<dl>
						<dt>区域分销佣金比率：</dt>
						<dd>
							<p>
								<input name="regionagent_commission_rate" type="number" class="input-common harf" value="0" /><em class="unit">%</em>
							</p>	
						</dd>
					</dl>
					<dl>
						<dt>股东分红佣金比率：</dt>
						<dd>
							<p>
								<input name="partner_commission_rate" type="number" value="0" class="input-common harf" /><em class="unit">%</em>
							</p>	
						</dd>
					</dl>
					<dl class="hide">
						<dt>分销团队分红佣金比率：</dt>
						<dd>
							<p>
								<input name="distribution_team_commission_rate" type="number" value="0" class="input-common harf" /><em class="unit">%</em>
							</p>	
						</dd>
					</dl>
					<dl class="hide">
						<dt>股东团队分红佣金比率：</dt>
						<dd>
							<p>
								<input name="partner_team_commission_rate" type="number" value="0" class="input-common harf" /><em class="unit">%</em>
							</p>	
						</dd>
					</dl>
					<dl class="hide">
						<dt>渠道代理分红佣金比率：</dt>
						<dd>
							<p>
								<input name="channelagent_commission_rate" type="number" value="0" class="input-common harf" /><em class="unit">%</em>
							</p>	
						</dd>
					</dl>
				</div>
  			</div>
  			<div class="modal-footer">
        		<button class="btn-common btn-big" onclick="saveDistributionSetting('goodsDistribution');">保存</button>
				<button class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
      		</div>
    	</div>
  	</div>
</div>

<div class="progress-modal hide">
	<h4>本次共设置<span class="num">0</span>件商品</h4>
	<div class="progress-bar"><div></div></div>
	<p class="progress-desc">正在进行中...</p>
</div>

<script>
var currDistributionGoodsId = '';	
/**
 * 分销设定
*/
function distributionSetting(){
	$('#distributionSetting').modal('show');
}

// 保存设定
var distribution_is_sub = false;
function saveDistributionSetting(id, page){
	var field = getDistributionField(id);
		field.page = page != null ? page : 1;

	if(distribution_is_sub) return;
	if(distributionVertify(field)){
		distribution_is_sub = true;
		$.ajax({
			type:"post",
			url:"<?php echo __URL('http://t.huaqi86.com/index.php/nsfx/admin/Distribution/goodsDistributionSetting'); ?>",
			data:{ value : JSON.stringify(field)},
			success:function (data) {
				$("#"+id).modal("hide");
				distribution_is_sub = false;
				if (data != undefined && data.page_count >= 1) {
					if(data.page < data.page_count) {
						if(data.page == 1){
							$('.progress-modal .num').text(data.total_count);
							$('.progress-modal').removeClass('hide');
						}
						var percentage = parseFloat((data.page / data.page_count)).toFixed(2) * 100;
						$('.progress-modal .progress-bar div').css('width', percentage+'%');
						$('.progress-modal .progress-desc').text('已完成'+ data.page + '/' + data.page_count);
						var page = data.page + 1;
						saveDistributionSetting(id, page);
					}else{
						$('.progress-modal').addClass('hide');
						showTip('设置成功', 'success');
						LoadingInfo(1);
					}
				}

				// if (data["code"] > 0) {
				// 	showMessage('success', data["message"]);
				// 	LoadingInfo(1);
				// }else{
				// 	showMessage('error', data["message"]);
				// 	LoadingInfo(1);
				// }	
			}
		});
	}
}

// 获取数据
function getDistributionField(id){
	var field = {};
	$('#'+id+' [name]').each(function(index, el) {
		var name = $(el).attr('name');
		switch (name){
			case 'is_open':
				field[name] = $(el).is(':checked') ? 1 : 0;
			break;
			case 'type':
				field[name] = $('#'+id+' [name="type"]:checked').val();
			break;
			case 'from_type':
				field[name] = $('#'+id+' [name="from_type"]:checked').val();
			break;
			case 'category':
				field[name] = $('#'+id+' [name="category"]').attr('data-value');
			break;
			default:
				field[name] = $(el).val();
			break;
		}
	});
	if(field.from_type == 'goods_ids'){
		var goods_ids= new Array();
		$("#productTbody input[type='checkbox']:checked").each(function() {
			if (!isNaN($(this).val())) {
				goods_ids.push($(this).val());
			}
		});
		field.goods_ids = goods_ids.toString();
	}
	if(id == 'goodsDistribution'){
		field.type = 0;
		field.from_type = 'goods_ids';
		field.goods_ids = currDistributionGoodsId;
	}
	return field;
}

// 数据验证
function distributionVertify(data){
	var all = parseFloat(data.distribution_commission_rate) + parseFloat(data.partner_commission_rate) + parseFloat(data.distribution_team_commission_rate) + parseFloat(data.partner_team_commission_rate) + parseFloat(data.regionagent_commission_rate) + parseFloat(data.channelagent_commission_rate);
	if(all > 100){
		showTip('总的分佣比率不能大于100%', 'error');
		return false;
	}
	if(data.from_type == 'category' && data.category == ''){
		showTip('请选择商品分类', 'error');
		return false;
	}
	if(data.from_type == 'goods_ids' && data.goods_ids == ''){
		showTip('请选择要设置的商品', 'error');
		return false;
	}
	return true;
}

$(function(){
	$('#distributionSetting [name="type"]').click(function(){
		if($(this).val() == 1){
			$("#distributionSetting .goods-select").addClass('hide');
		}else if($(this).val() == 0){
			$("#distributionSetting .goods-select").removeClass('hide');
		}
	})

	$("#distributionSetting [name='from_type']").click(function(event) {
		var type = $(this).val();
		$('#distributionSetting [data-type]').addClass('hide');
		$('#distributionSetting [data-type="'+ type +'"]').removeClass('hide');
	});
})


function setGoodsDistribution(goods_id, type){
	currDistributionGoodsId = goods_id;
	$.ajax({
		type : "post",
		url : "<?php echo __URL('http://t.huaqi86.com/index.php/nsfx/admin/Distribution/getGoodsCommissionRateDetail'); ?>",
		data : {
			"goods_id" : goods_id
		},
		success : function(data) {
			$('#goodsDistribution').modal('show');
			$("#goodsDistribution [name='distribution_commission_rate']").val(data.distribution_commission_rate);
			$("#goodsDistribution [name='partner_commission_rate']").val(data.partner_commission_rate);
			$("#goodsDistribution [name='regionagent_commission_rate']").val(data.regionagent_commission_rate);
			$("#goodsDistribution [name='distribution_team_commission_rate']").val(data.distribution_team_commission_rate);
			$("#goodsDistribution [name='partner_team_commission_rate']").val(data.partner_team_commission_rate);
			$("#goodsDistribution [name='channelagent_commission_rate']").val(data.channelagent_commission_rate);
			if(data.is_open == 1){
				$("#goodsDistribution .is-open").html('<input type="checkbox" class="checkbox" name="is_open" checked/>');
			}else{
				$("#goodsDistribution .is-open").html('<input type="checkbox" class="checkbox" name="is_open" />');
			}
			$("#goodsDistribution [name='is_open']").simpleSwitch({
				"theme": "FlatRadius"
			});
			$('#goodsDistribution').modal('show');
		}
	})	
}
//**************************************New*********************************************
</script>
<?php endif; ?>

</body>
</html>