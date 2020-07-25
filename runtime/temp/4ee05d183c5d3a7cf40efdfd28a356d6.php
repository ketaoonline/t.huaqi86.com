<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:57:"addons/Nsfx/template/admin/Distribution/promoterList.html";i:1586257642;s:51:"/www/wwwroot/t.huaqi86.com/template/admin/base.html";i:1589944662;s:68:"/www/wwwroot/t.huaqi86.com/template/admin/controlCommonVariable.html";i:1557195638;s:55:"/www/wwwroot/t.huaqi86.com/template/admin/urlModel.html";i:1552613544;s:57:"/www/wwwroot/t.huaqi86.com/template/admin/pageCommon.html";i:1556191159;s:57:"/www/wwwroot/t.huaqi86.com/template/admin/openDialog.html";i:1575977953;}*/ ?>
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
	
<script type="text/javascript" src="/public/static/My97DatePicker/WdatePicker.js"></script>
<style  type="text/css">
	p{margin: 0}
.ns-main{margin-top: 0;}
.modal-div{width:90%;margin:auto}
.modal-dl{overflow:hidden}
.modal-dl dt{line-height:33px;float:left;font-weight:400}
.modal-dl dd{float:left}
.modal-dl dd span{display:block;color:#de533c}
.btn.off{background-color:#e26f6f;color:#FFF}
.btn.sure{color:#FFF;background-color:#62c462}
.status-error{display:inline-block;padding-left:5px;padding-right:5px;padding-bottom:3px;padding-top:3px;color:#FFF;background-color:#de533c}
.status-success{display:inline-block;color:#51A351;padding-left:5px;padding-right:5px;padding-bottom:3px;padding-top:3px;}
.update_up{
	float:left;
}
.msg_member {
    position: absolute;
    background: #fff;
    border: 1px solid rgba(221, 221, 221, 0.43);
    padding: 10px 10px 10px 18px;
    left: 100%;
    top: -50px;
    width: 200px;
    display: none;
    z-index: 10;
    box-shadow: 3px 3px 21px rgba(136, 136, 136, 0.38);
	border-radius: 5px;
}
.member-basics {
    position: relative;
    text-align: left;
	min-width: 166px;
}
.member-basics:hover .msg_member{
	display: block;
}

.member-basics > span{
	width: 150px;
	overflow: hidden;
	text-overflow: ellipsis;
	white-space: nowrap;
	display: inline-block;
	margin-top: 5px;
	margin-bottom: -6px;
}

.msg_member .transform-left {
    width: 20px;
    height: 20px;
    transform: rotate(7deg);
    -ms-transform: rotate(7deg);
    -moz-transform: rotate(7deg);
    -webkit-transform: rotate(43deg);
    -o-transform: rotate(7deg);
    position: absolute;
    left: -10px;
    top: 44%;
    z-index: 11;
    background: #fff;
    border-left: 1px solid rgba(221, 221, 221, 0.43);
    border-bottom: 1px solid rgba(221, 221, 221, 0.43);
}
.source_fx {
	overflow: hidden;
	text-overflow: ellipsis;
	display: -webkit-box;
	-webkit-box-orient: vertical;
	-webkit-line-clamp: 2;
	cursor: pointer;
	padding: 0 25px;
}
p{margin: 0}
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
					
<!-- <li><a class="nscs-table-handle_green" href="javascript:;" onclick="addBrand()"><i class="fa fa-plus-circle"></i>&nbsp;添加品牌</a></li> -->

					
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
			
			
<table class="mytable">
	<tr>
		<th style="text-align: left;width: 20%;">
			<button onclick="update_up()" value="修改" class="btn-common update_up" >修改上级</button>
		</th>
		<th class="default-condition">
			<input id="userName" class="input-common middle" type="text" value="" placeholder="请输入用户昵称">
			<button onclick="searchData()" value="搜索" class="btn-common" >搜索</button>
			<button onclick="openSeniorSearch('.default-condition')" value="搜索" class="btn-common" >高级搜索</button>
			<button onclick="promoterExcel()" value="搜索" class="btn-common" >导出数据</button>
		</th>
	</tr>
</table>

<div class="nui-condition">
	<div class="c-item-column">
		<label>用户昵称：</label>
		<input id="userName" class="input-common middle" type="text" value="" placeholder="请输入用户昵称">
	</div>
	<div class="c-item-column">
		<label>手机号：</label>
		<input id="userTel" class="input-common middle" type="text" value="" placeholder="请输入手机号">
	</div>
	<div class="c-item-column">
		<label>上级编号：</label>
		<input id="up_bianhao" class="input-common middle" type="text" value="" placeholder="请输入上级编号">
	</div>
	
	<div class="c-item-column">
		<label>申请时间：</label>
		<input type="text" id="startDate" class="input-common middle" placeholder="请选择开始日期" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" />
		&nbsp;-&nbsp;
		<input type="text" id="endDate" placeholder="请选择结束日期" class="input-common middle" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" />
	</div>
	<br/>

	<div class="c-operation">
		<button onclick="searchData()"  value="搜索" class="btn-common" >搜索</button>
		<button onclick="promoterExcel()"  value="导出" class="btn-common-white" >导出</button>
		<a href="javascript:clearCondition();">清空筛选条件</a>
	</div>
	<a href="javascript:retractSeniorSearch();" class="retract">收起↑</a>
</div>

<div class="mod-table">
	<div class="mod-table-head">
		<div class="con style0list">
				<table class="table-class">
				<colgroup>
					<col style="width: 2%;">
						<col style="width: 12%;">
					<col style="width: 8%;">
					<col style="width: 10%;">
					<col style="width: 8%;">
					<col style="width: 8%;">
					<col style="width: 8%;">
					<col style="width: 10%;">
					<col style="width: 5%;">
<!-- 					<col style="width: 6%;"> -->
					<col style="width: 12%;">
					<col style="width: 11%;">
				</colgroup>
				<thead>
					<tr>
						<th><i class="checkbox-common"><input type="checkbox"  id="check"/></i></th>
						<th align="left">姓名</th>
						<th>编号</th>
						<th>等级</th>
						<th>店铺名称</th>
						
						<th>团队</th>
						<th>销售总额</th>
						<th>上级分销商</th>
						<th>店铺状态</th>
<!-- 					<th>审核状态</th> -->
						
						<th>申请时间</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
</div>

<!-- 修改用户上级（Modal）开始 -->
<div class="modal fade hide" id="editParent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">分销商上级修改</h3>
            </div>
            <div class="modal-body">
            	<div class="modal-div">
            		<input type="hidden"  id="promoter_id"  value=''/>
            		<dl class="modal-dl">
            			<dt>上级分销商编号:</dt>
            			<dd>
            				<input  type="text" id="parent_promoter" value=""/>
            				<span id="ever_parent_promoter"></span>
            			</dd>
            		</dl>
            	</div>
            </div>
            <div class="modal-footer">
            	<input type="hidden" id="up_id"/>
            	<input type="hidden" id="no_arr" value=""/>
                <button type="button" class="btn-common btn-big" onclick="modifyPromoterParent();">修改</button>
                <button type="button" class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade hide" id="editLevel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">分销商等级修改</h3>
            </div>
            <div class="modal-body">
            	<div class="modal-div">
            		<input type="hidden"  id="level_promoter_id"  value=''/>
            		<dl class="modal-dl">
            			<dt>分销商等级:</dt>
            			<dd>
            				<select id="level_id">
            					<?php if(is_array($level_list) || $level_list instanceof \think\Collection || $level_list instanceof \think\Paginator): if( count($level_list)==0 ) : echo "" ;else: foreach($level_list as $key=>$level_info): ?>
								    <option value="<?php echo $level_info['level_id']; ?>"><?php echo $level_info['level_name']; ?></option>
								<?php endforeach; endif; else: echo "" ;endif; ?>
            				</select>
            			</dd>
            		</dl>
            	</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-common btn-big" onclick="modifyPromoterLevel();">修改</button>
                <button type="button" class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<!-- 修改用户上级（Modal）结束 -->

<!--修改店铺名称  -->
<div class="modal fade hide" id="editShopName" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">店铺名称修改</h3>
            </div>
            <div class="modal-body">
            	<div class="modal-div">
            		<input type="hidden"  id="shop_promoter_id"  value=''/>
            		<dl class="modal-dl">
            			<dt>店铺名称：</dt>
            			<dd>
            				<input  type="text" id="shop_name" value=""/>
            			</dd>
            		</dl>
            	</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-common btn-big" onclick="modifyShopName();">修改</button>
                <button type="button" class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>

<!--我的团队显示 -->
<div class="modal fade hide" id="myTeam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:60%;left:35%">

	<div class="modal-dialog" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title">我的团队 <input type="button" onclick="dataExcel()" value="导出数据" class="btn-common" style="float: right;margin-right:50px!important"/></h3>
			</div>
			<div class="modal-body" style="min-height: 360px;">
				<div class="modal-infp-style" style="height: 600px; overflow: auto;">
					<table class="modal-tab table-class">
						<thead>
							<tr align="center">
								<th>昵称</th>
								<th>编号</th>
								<th>等级</th>
								<th>店铺名称</th>
								<th>角色</th>
								<th>申请时间</th>
							</tr>
						</thead>
						<colgroup>
							<col style="width: 8%;">
							<col style="width: 12%;">
							<col style="width: 10%;">
							<col style="width: 8%;">
							<col style="width: 7%;">
							<col style="width: 16%;">
						</colgroup>
						<tbody id="my_team_list"></tbody>
					</table>
				</div>
			</div>

			<input type="hidden" value="" id="hidden_promoter_id"/>
			<div class="modal-footer">
				<button type="button" class="btn-common-cancle btn-big" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>

</div>

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
//全选
function CheckAll(event){
	var checked = event.checked;
	$(".table-class tbody input[type = 'checkbox']").prop("checked",checked);
	if(checked) $(".table-class tbody input[type = 'checkbox']").parent().addClass("selected");
	else $(".table-class tbody input[type = 'checkbox']").parent().removeClass("selected");
}
	//查询
	function searchData(){
		$(".more-search-container").slideUp();
		LoadingInfo(1);
	}
	//加载数据
	function LoadingInfo(pageIndex) {
		var user_name = $("#userName").val();
		var start_date = $("#startDate").val();
		var end_date = $("#endDate").val();
		var user_phone = $("#userTel").val();
		var up_bianhao = $("#up_bianhao").val();
		$.ajax({
			type : "post",
			url : "<?php echo __URL('http://t.huaqi86.com/index.php/nsfx/admin/Distribution/promoterList'); ?>",
			data : {
				"pageIndex" : pageIndex,
				"is_audit":<?php echo $is_audit; ?>,
				"user_name":user_name,
				"start_date" : start_date,
				"end_date" : end_date,
				"user_phone":user_phone,
				"up_bianhao" : up_bianhao
			},
			success : function(data) {
				console.log(data);
				$("#page_count").val(data["page_count"]);
				$("#pageNumber a").remove();
				var html = '';
				if (data["data"].length > 0) {
					for (var i = 0; i < data["data"].length; i++) {
						var lock_operrate = "";
						var lock_do = 0;
						if(data["data"][i]["is_lock"] == 1){
							lock_operrate = "解冻";
							lock_do = 0;
						}else{
							lock_operrate = "冻结";
							lock_do = 1;
						}
						var parent_realname ="";
						if(data["data"][i]["parent_realname"] != null){
							parent_realname = data["data"][i]["parent_realname"];
						}
						var user_tel = '';
						if(data["data"][i]["user_tel"] !=''){
							user_tel = "<p>"+data["data"][i]["user_tel"]+"</p>";
						}
						html += '<tr align="center">';
						html += '<td><i class="checkbox-common"><input type="checkbox"  value="'+data['data'][i]['promoter_id']+'" name="sub" promoter_no="'+ data['data'][i]['promoter_no'] +'"></i></td>';
						html += '<td class="member-basics">';
						if(data["data"][i]["user_headimg"] ==""){
							html += '<img src="/public/static/images/default_user_portrait.gif" class="head-portrait" />&nbsp;&nbsp;'+ '<span>' +data["data"][i]["nick_name"]+'</span>';
						}else{
							html += '<img src="'+__IMG(data["data"][i]["user_headimg"])+'" class="head-portrait" />&nbsp;&nbsp;'+ '<span>' +data["data"][i]["nick_name"]+'</span>';
						}
						html += '<div class="msg_member">';
						html += '<p><span>会员ID：</span>'+data["data"][i]["uid"]+'</p>';
						html += '<p><span>会员账号：</span>'+(data["data"][i]["user_name"] == '' ? '--' : data["data"][i]["user_name"])+'</p>';
						html += '<p><span>会员昵称：</span>'+(data["data"][i]["nick_name"] == '' ? '匿名用户' : data["data"][i]["nick_name"])+'</p>';

						html += '<p><span>手机号码：</span>'+(data["data"][i]["user_tel"] == '' ? '--' : data["data"][i]["user_tel"])+'</p>';
						html += '<p><span>会员邮箱：</span>'+(data["data"][i]["user_email"] == '' ? '--' : data["data"][i]["user_email"])+'</p>';
						html += '<span class="transform-left"></span></div>';

						html += '</td>';
						html += '<td>' + data["data"][i]["promoter_no"] + user_tel+'</td>';
						html += '<td>' + data["data"][i]["level_name"] + '</td>';
						html += '<td>' + data["data"][i]["promoter_shop_name"] + '</td>';
						
						
						
						html += '<td>分销商数:'+data["data"][i]["promoter_num"]+'<br/>粉丝数:'+data["data"][i]["fans_num"]+'</td>';
						html += '<td>' + data["data"][i]["order_total"] + '</td>';
						if(data["data"][i]["parent_realname"]==''){
							html += '<td><p class="source_fx" title="无"> 无 </p></td>';
						}else{
							html += '<td><p class="source_fx" title="'+parent_realname+'">' + parent_realname + '</p></td>';
						}

// 						if(data["data"][i]["is_audit"] == 1){
// 							html += '<td><span class="status-success">已审核</span></td>';
// 						}else if(data["data"][i]["is_audit"] == -1){
// 							html += '<td><span class="status-error">已拒绝</span></td>';
// 						}
						if(data["data"][i]["is_lock"] == 0){
							html += '<td><span class="statusclassno">正常</span></td>';
						}else if(data["data"][i]["is_lock"] == 1){
							html += '<td><span class="statusclass">已冻结</span></td>';
						}
						
						
						html += '<td>' +timeStampTurnTime(data["data"][i]["regidter_time"])+ '</td>';

						html += '<td>';
						//html += '<a href="http://t.huaqi86.com/index.php/admin/Distribution/modifyPromoterParent?promoter_id='+data["data"][i]["promoter_id"]+'&parent_promoter='+data["data"][i]["parent_promoter"]+'" >修改上级</a>';
						if(data["data"][i]["is_audit"] == 1){
							html += '<a href="'+__URL('http://t.huaqi86.com/index.php/nsfx/admin/Distribution/promoterAccount?promoter_id='+data["data"][i]["promoter_id"]+'&uid='+data["data"][i]["uid"])+'" target="_blank">账户详情</a>';
							html += '<a href="javascript:void(0);"  onclick="showEditParent('+data["data"][i]["promoter_id"]+',&#39;'+data["data"][i]["parent_promoter_no"]+'&#39;);" >修改上级</a><br/>';
							html += '<a href="javascript:void(0);" onclick="modifyPromoterLock('+data["data"][i]["promoter_id"]+','+lock_do+');">'+lock_operrate+'店铺</a>';
							html += '<a href="javascript:void(0);"  onclick="showEditLevel('+data["data"][i]["promoter_id"]+',&#39;'+data["data"][i]["promoter_level"]+'&#39;);" >修改等级</a><br/>';
							html += '<a href="javascript:void(0);"  onclick="showTeamList('+data["data"][i]["promoter_id"]+');" >我的团队</a>';
							html += '<a href="javascript:void(0);"  onclick="showEditShopName('+data["data"][i]["promoter_id"]+',&#39;'+data["data"][i]["promoter_shop_name"]+'&#39;);" >修改店铺</a>';
						}

						html += '</td> ';
						html += '</tr>';
					}
				} else {
					html += '<tr align="center"><td colspan="11">暂无符合条件的数据记录</td></tr>';
				}

				$(".style0list tbody").html(html);
				var totalpage = $("#page_count").val();
				if (totalpage == 1) {
					changeClass("all");
				}
				initPageData(data["page_count"],data['data'].length,data['total_count']);
				var $html = pagenumShow(jumpNumber,totalpage,<?php echo $pageshow; ?>);
				
				$("#pageNumber").append($html);
			}
		});
	}

	function modifyPromoterLock(promoter_id, is_lock){
		$.ajax({
			type : "post",
			url : "<?php echo __URL('http://t.huaqi86.com/index.php/nsfx/admin/Distribution/modifyPromoterLock'); ?>",
			data : {
				"promoter_id" : promoter_id,
				"is_lock":is_lock
			},
			success : function(data) {
				if (data["code"] > 0) {
					showMessage('success', data["message"],"<?php echo __URL('http://t.huaqi86.com/index.php/nsfx/admin/Distribution/PromoterList'); ?>");
				}else{
					showMessage('error', data["message"]);
				}
			}
		});
	}
	//修改上级弹出框
	function showEditParent(promoter_id,parent_promoter_no){
		$("#promoter_id").val(promoter_id);
		if(parent_promoter_no == "" ){
			parent_promoter_no = "此分销商无上级";
		}else{
			parent_promoter_no = "原上级分销商编号为:"+parent_promoter_no;
		}
		$("#ever_parent_promoter").html(parent_promoter_no);
		$("#editParent").modal('show');
	}

	//修改上级
	function modifyPromoterParent(){
		var promoter_id = $("#promoter_id").val();
		var parent_promoter = $("#parent_promoter").val();
		var up_id = $("#up_id").val();
		var up_promoter = $("#no_arr").val();
		if(parent_promoter == ''){
			showMessage('error', "上级分销商编号不可为空！");
			return false;
		}

		//批量修改上级分销商判断
		if(up_id != ""){
			var up_array = up_promoter.split(',');
			for(var i=0; i<up_array.length; i++){
				if(parent_promoter == up_array[i]){
					showMessage('error', "自己不能当自己的上级");
					return false;
				}
			}
			var query_res = false;
			$.ajax({
				type : "post",
				async: false,
				url : "<?php echo __URL('http://t.huaqi86.com/index.php/nsfx/admin/Distribution/selectUpTuiGuang'); ?>",
				data : {
					'parent_promoter':parent_promoter,
					'up_id' : up_id
				},
				success : function (data){
					if(data == 1){
						query_res = true;
					}
				}
			});
			if(query_res){
				showMessage('error', "作为下级的分销商不能转上级");
				return false;
			}
		}
		$.ajax({
			type:"post",
			url:"<?php echo __URL('http://t.huaqi86.com/index.php/nsfx/admin/Distribution/modifyPromoterParent'); ?>",
			data:{
				'promoter_id':promoter_id,
				'parent_promoter':parent_promoter,
				'up_id' : up_id
			},
			success:function (data) {
				if (data["code"] > 0) {
					showMessage('success', data["message"],"<?php echo __URL('http://t.huaqi86.com/index.php/nsfx/admin/Distribution/promoterList'); ?>");
					$("#editParent").modal('hide');
				}else{
					showMessage('error', '不可添加自己为上级或者上级编号不存在！');
				}
			}
		});
	}

	//修改等级框
	function showEditLevel(promoter_id,promoter_level){
		$("#level_promoter_id").val(promoter_id);
		$("#level_id").val(promoter_level);
		$("#editLevel").modal('show');
	}

	//修改上级
	function modifyPromoterLevel(){
		var promoter_id = $("#level_promoter_id").val();
		var level_id = $("#level_id").val();
		$.ajax({
			type:"post",
			url:"<?php echo __URL('http://t.huaqi86.com/index.php/nsfx/admin/Distribution/modifyPromoterLevel'); ?>",
			data:{
				'promoter_id':promoter_id,
				'level_id':level_id
			},
			success:function (data) {
				if (data["code"] > 0) {
					showMessage('success', data["message"],"<?php echo __URL('http://t.huaqi86.com/index.php/nsfx/admin/Distribution/promoterList'); ?>");
					$("#editLevel").modal('hide');
				}else{
					showMessage('error', '您已是此等级无需修改！');
				}
			}
		});
	}

	//修改店铺名称显示
	function showEditShopName(promoter_id,shop_name){
		$("#shop_promoter_id").val(promoter_id);
		$("#shop_name").val(shop_name);
		$("#editShopName").modal('show');
	}

	//修改店铺名称
	function modifyShopName(){
		var promoter_id = $("#shop_promoter_id").val();
		var promoter_shop_name = $("#shop_name").val();
		$.ajax({
			type:"post",
			url:"<?php echo __URL('http://t.huaqi86.com/index.php/nsfx/admin/Distribution/modifyPromoterShopName'); ?>",
			data:{
				'promoter_id':promoter_id,
				'promoter_shop_name':promoter_shop_name
			},
			success:function (data) {
				if (data["code"] > 0) {
					showMessage('success', data["message"],"<?php echo __URL('http://t.huaqi86.com/index.php/nsfx/admin/Distribution/promoterList'); ?>");
					$("#editShopName").modal('hide');
				}else{
					showMessage('error', data["message"]);
				}
			}
		});
	}

	//我的团队显示
	function showTeamList(promoter_id){
		$.ajax({
			type:"post",
			url:"<?php echo __URL('http://t.huaqi86.com/index.php/nsfx/admin/Distribution/teamList'); ?>",
			data:{
				'promoter_id':promoter_id
			},
			success:function (data) {
 				//alert(JSON.stringify(data[0]));
				var html = '';
				if (data.length > 0) {
					for (var i = 0; i < data.length; i++) {
						html += '<tr>';
						if(data[i]["promoter_info"]["promoter_no"] == undefined){
							html += '<td style="text-align:center;">--</td>';
						}else{
							html += '<td style="text-align:center;">' + data[i]["promoter_info"]["promoter_no"] + '</td>';
						}
						html += '<td style="text-align:center;">' + data[i]["user_info"]["nick_name"] + '</td>';

						if(data[i]["promoter_info"]["level_name"] == null){
							html += '<td style="text-align:center;">--</td>';
						}else{
							html += '<td style="text-align:center;">' + data[i]["promoter_info"]["level_name"] + '</td>';
						}

						if(data[i]["promoter_info"]["promoter_shop_name"] == undefined){
							html += '<td style="text-align:center;">--</td>';
						}else{
							html += '<td style="text-align:center;">' + data[i]["promoter_info"]["promoter_shop_name"] + '</td>';
						}

						html += '<td style="text-align:center;">' + data[i]["role_name"] + '</td>';
						html += '<td style="text-align:center;">' + timeStampTurnTime(data[i]["user_info"]["reg_time"]) + '</td>';
						html += '</tr>';
					}
				} else {
					   html += '<tr align="center"><td colspan="11">暂无符合条件的数据记录</td></tr>';
				}
				$("#my_team_list").html(html);
			}
		});

		$("#hidden_promoter_id").val(promoter_id);
		$("#myTeam").modal('show');
	}

	/**
	 * 团队数据导出
	 */
	function dataExcel(){
		var promoter_id = $("#hidden_promoter_id").val();
		window.location.href=__URL("http://t.huaqi86.com/index.php/nsfx/admin/Distribution/memberDataExcel?promoter_id="+promoter_id);
	}

	/**
	 * 订单数据导出
	 */
	function promoterExcel(){
		var user_name = $("#userName").val();
		var start_date = $("#startDate").val();
		var end_date = $("#endDate").val();
		var user_phone = $("#userTel").val();
		window.location.href=__URL("http://t.huaqi86.com/index.php/nsfx/admin/distribution/promoterDataExcel?is_audit=<?php echo $is_audit; ?>&start_date="+start_date+"&end_date="+end_date+"&user_name="+user_name+"&user_phone="+user_phone);
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

function update_up(){
	var obj = $(".table-class tbody input[type='checkbox']:checked");
	var id_arr = new Array();
    var no_arr = new Array();
	for(var i=0; i<obj.length; i++){
		id_arr.push(obj.eq(i).val());
		no_arr.push(obj.eq(i).attr('promoter_no'));
	}

	if(id_arr == ""){
		showMessage("error","请选择分销商");
		return false;
	}else{
		$("#editParent").modal('show');
		$("#up_id").val(id_arr);
		$("#no_arr").val(no_arr.toString());
	}
}
</script>

</body>
</html>