<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:36:"template/web/default/help/index.html";i:1557819876;s:57:"/www/wwwroot/t.huaqi86.com/template/web/default/base.html";i:1587364095;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta name="renderer" content="webkit" />
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge,chrome=1"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="renderer" content="webkit">
    <title><?php if($title_before != ''): ?><?php echo $title_before; ?>&nbsp;-&nbsp;<?php endif; ?><?php echo $title; if($seo_config['seo_title'] != ''): ?>&nbsp;-&nbsp;<?php echo $seo_config['seo_title']; endif; ?></title>
    
<meta name="keywords" content="<?php echo $seo_config['seo_meta']; ?>,<?php echo $web_info['title']; ?>_帮助中心" />
<meta name="description" content="<?php echo $seo_config['seo_desc']; ?>,<?php echo $help_document_info['title']; ?>"/>

    <link rel="shortcut icon" type="image/x-icon" href="/public/static/images/favicon.ico" media="screen"/>
    <link type="text/css" rel="stylesheet" href="/public/static/font-awesome/css/font-awesome.css">
    <link type="text/css" rel="stylesheet" href="/template/web/default/public/plugin/zui/css/zui.css">
    <link type="text/css" rel="stylesheet" href="/template/web/default/public/plugin/zui/css/zui-theme.css">
    <link type="text/css" rel="stylesheet" href="/template/web/default/public/css/normalize.css">
    <link type="text/css" rel="stylesheet" href="/template/web/default/public/css/common.css">
    <link type="text/css" rel="stylesheet" href="/template/web/default/public/css/themes/<?php echo $theme_css; ?>">
    <script type="text/javascript" src="/public/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/template/web/default/public/plugin/zui/js/zui.js"></script>
    <script type="text/javascript" src="/template/web/default/public/plugin/zui/js/zui.lite.js"></script>
    <script src="/public/static/js/jquery.cookie.js"></script>
    <script src="/public/static/js/load_bottom.js" type="text/javascript"></script>
    <script src="/template/web/default/public/js/common.js"></script>
    <script src="/template/web/default/public/js/jquery.lazyload.js"></script>
    <script type="text/javascript">
        var SHOPMAIN = 'http://t.huaqi86.com/index.php';
        var APPMAIN = 'http://t.huaqi86.com/index.php/wap';
        var UPLOAD = '';
		var WEBIMG = "/template/web/default/public/img";
		var DEFAULT_GOODS_IMG = "<?php echo __IMG($default_goods_img); ?>";
		var uid = "<?php echo $uid; ?>";
		var STATIC = "/public/static";
		var PAGE_SIZE = "<?php echo $page_size; ?>";
    </script>
    
<link type="text/css" rel="stylesheet" href="/template/web/default/public/css/article.css" />

</head>
<body>

<?php 
$default_img = api("System.Config.defaultImages");
$default_img = $default_img['data'];
//商品分类
$goods_category_one = api("System.Goods.goodsCategoryTree");
$goods_category_one = $goods_category_one['data'];

//商品分类展示方式
$web_category_display = api("System.Config.webCategoryDisplay");
$web_category_display = $web_category_display['data'];
if(!empty($web_category_display)){
    $web_category_display = json_decode($web_category_display,true);
}

//logo右侧的广告图
$logo_right_nav = api('System.Shop.advDetail', ['ap_keyword' => 'PC_INDEX_RIGHT_LOGO', 'export_type' => 'template']);
$logo_right_nav = $logo_right_nav['data'];

//导航
$navigation_list = api("System.Shop.shopNavigationList", ["page_index"=>1, "page_size"=>10, "type"=>1]);
$navigation_list = $navigation_list['data'];

//热门关键词搜索
$hot_keys = api("System.Config.hotSearch");
$hot_keys = $hot_keys['data'];

//默认关键词搜索
$default_keywords = api("System.Shop.defaultKeyWords");
$default_keywords = $default_keywords['data'];

 ?>
<header class="ns-header">
    <div class="top-bar ns-border-color-gray">
        <div class="w1200 clearfix">
            <div class="pull-left">
                <?php if($member_detail): ?>
                <a href="<?php echo __URL('http://t.huaqi86.com/index.php/member/index'); ?>" class="ns-text-color"><?php echo $member_detail['user_info']['nick_name']; ?></a>
                <a href="javascript:logout();">退出</a>
                <?php else: ?>
                <a href="<?php echo __URL('http://t.huaqi86.com/index.php/login/index'); ?>" class="ns-text-color">登录</a>
                <a href="<?php echo __URL('http://t.huaqi86.com/index.php/login/register'); ?>">注册</a>
                <?php endif; ?>
            </div>
            <ul class="pull-right">
                <li><a target="_blank" href="<?php echo __URL('http://t.huaqi86.com/index.php/member/index'); ?>"><?php echo lang('member_center'); ?></a></li>
                <li><a target="_blank" href="<?php echo __URL('http://t.huaqi86.com/index.php/member/order'); ?>">我的订单</a></li>
                <li><a target="_blank" href="<?php echo __URL('http://t.huaqi86.com/index.php/member/footprint'); ?>">我的浏览</a></li>
                <li><a target="_blank" href="<?php echo __URL('http://t.huaqi86.com/index.php/member/collection'); ?>"><?php echo lang('member_baby_collection'); ?></a></li>
                <li><a target="_blank" href="<?php echo __URL('http://t.huaqi86.com/index.php/help/index'); ?>"><?php echo lang('shop_help_center'); ?></a></li>
                <li><a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap'); ?>" class="menu-hd wap-nav"><?php echo lang('mobile_terminal'); ?></a></li>
                <li class="focus">
                    <a href="javascript:;" target="_blank"><?php echo lang('attention_mall'); ?></a>
                    <div class="ns-border-color-gray">
                        <span></span>
                        <a target="_top"><img src="<?php echo __IMG($web_info['web_qrcode']); ?>" alt="<?php echo lang('official_wechat'); ?>"></a>
                        <p><?php echo lang('concerned_official_wechat'); ?></p>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="w1200 middle">
        <a class="ns-logo" href="<?php echo __URL('http://t.huaqi86.com/index.php'); ?>">
            <img class="self-adaption-img" src="<?php echo __IMG($web_info['logo']); ?>"/>
        </a>

        <div class="ns-logo-right">
            <?php if(!(empty($logo_right_nav) || (($logo_right_nav instanceof \think\Collection || $logo_right_nav instanceof \think\Paginator ) && $logo_right_nav->isEmpty()))): ?>
            <?php echo $logo_right_nav; endif; ?>
        </div>

        <div class="ns-search">
            <div class="clearfix">
                <input class="ns-border-color ns-text-color-black" type="text" id="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $default_keywords; ?>" data-search-words="<?php echo $default_keywords; ?>">
                <button class="btn btn-primary" type="button"><?php echo lang('search'); ?></button>
            </div>
            <?php if(!(empty($hot_keys) || (($hot_keys instanceof \think\Collection || $hot_keys instanceof \think\Paginator ) && $hot_keys->isEmpty()))): ?>
            <div class="keyword">
                <?php if(is_array($hot_keys) || $hot_keys instanceof \think\Collection || $hot_keys instanceof \think\Paginator): $i = 0; $__LIST__ = $hot_keys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$hot_key): $mod = ($i % 2 );++$i;?>
                <a href="<?php echo __URL('http://t.huaqi86.com/index.php/goods/lists','keyword='.$hot_key); ?>" title="<?php echo $hot_key; ?>"><?php echo $hot_key; ?></a>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <?php endif; ?>
        </div>

        <div class="ns-cart ns-border-color-gray">
            <div class="cart common-text-color">
                <i class="icon icon-shopping-cart"></i>
                <span>我的购物车</span>
                <em class="shopping-amount common-bg-color">0</em>
            </div>
            <div class="list ns-border-color-gray"></div>
        </div>
    </div>

    <nav class="w1200 clearfix">
        <div class="category">
            <div class="all ns-bg-color">
                <a href="<?php echo __URL('http://t.huaqi86.com/index.php/goods/category'); ?>" title="查看全部商品分类"><i class="icon icon-list-ul"></i>全部商品分类</a>
            </div>
            <ul>
                <?php foreach($goods_category_one as $k=>$vo): if($k < 11): ?>
                <li>
                    <div class="item-left">
                        <a href="<?php echo __URL('http://t.huaqi86.com/index.php/goods/lists','category_id='.$vo['category_id']); ?>" title="<?php echo $vo['category_name']; ?>">
                            <?php if($web_category_display['is_img'] == 1): if(!(empty($vo['category_pic']) || (($vo['category_pic'] instanceof \think\Collection || $vo['category_pic'] instanceof \think\Paginator ) && $vo['category_pic']->isEmpty()))): ?>
                            <img src="<?php echo __IMG($vo['category_pic']); ?>"/>
                            <?php else: ?>
                            <!--<img src="<?php echo __IMG($default_goods_img); ?>"/>-->
                            <?php endif; endif; if($web_category_display['is_use'] == 0): ?>
                            <span><?php echo $vo['category_name']; ?></span>
                            <?php else: ?>
                            <span><?php echo $vo['short_name']; ?></span>
                            <?php endif; if($web_category_display && $web_category_display['template']>1): if($vo['count'] >0): ?>
                            <i class="fa fa-angle-right"></i>
                            <?php endif; endif; ?>
                        </a>
                    </div>
                    <?php if($web_category_display && $web_category_display['template']>1): if(!(empty($vo['child_list']) || (($vo['child_list'] instanceof \think\Collection || $vo['child_list'] instanceof \think\Paginator ) && $vo['child_list']->isEmpty()))): ?>
                        <ul class="second-child ns-border-color-gray clearfix <?php if($web_category_display && $web_category_display['template']>2): ?>have-third-child<?php endif; ?>">
                        <?php foreach($vo['child_list'] as $vo2): ?>
                            <li class="<?php if($web_category_display && (($web_category_display['template']==2 && $web_category_display['is_img'] == 0) || ($web_category_display['template']==3))): ?>empty-img<?php endif; ?>">
                                <a href="<?php echo __URL('http://t.huaqi86.com/index.php/goods/lists','category_id='.$vo2['category_id']); ?>" target="_blank" title="<?php echo $vo2['category_name']; ?>" <?php if($web_category_display['is_img'] == 1): ?>style="float:none;"<?php endif; ?>>
                                    <?php if($web_category_display['template']==2 && $web_category_display['is_img'] == 1): if(!(empty($vo2['category_pic']) || (($vo2['category_pic'] instanceof \think\Collection || $vo2['category_pic'] instanceof \think\Paginator ) && $vo2['category_pic']->isEmpty()))): ?>
                                    <img src="<?php echo __IMG($vo2['category_pic']); ?>"/>
                                    <?php else: ?>
                                    <img src="<?php echo __IMG($default_goods_img); ?>"/>
                                    <?php endif; endif; if($web_category_display['is_use'] == 0): ?>
                                    <span><?php echo $vo2['category_name']; ?></span>
                                    <?php else: ?>
                                    <span><?php echo $vo2['short_name']; ?></span>
                                    <?php endif; if($web_category_display['template']>2): ?>
                                    <i class="fa fa-angle-right"></i>
                                    <?php endif; ?>
                                </a>
                                <?php if($web_category_display['template']>2): if(!(empty($vo2['child_list']) || (($vo2['child_list'] instanceof \think\Collection || $vo2['child_list'] instanceof \think\Paginator ) && $vo2['child_list']->isEmpty()))): ?>
                                <ul class="third-child <?php if($web_category_display['is_img'] == 0): ?>empty-img ns-border-color-gray<?php endif; ?>">
                                    <?php foreach($vo2['child_list'] as $vo3): ?>
                                    <li>
                                        <a href="<?php echo __URL('http://t.huaqi86.com/index.php/goods/lists','category_id='.$vo3['category_id']); ?>" target="_blank" title="<?php echo $vo3['category_name']; ?>">
                                            <?php if($web_category_display['is_img'] == 1): if(!(empty($vo3['category_pic']) || (($vo3['category_pic'] instanceof \think\Collection || $vo3['category_pic'] instanceof \think\Paginator ) && $vo3['category_pic']->isEmpty()))): ?>
                                                <img src="<?php echo __IMG($vo3['category_pic']); ?>"/>
                                                <?php else: ?>
                                                <img src="<?php echo __IMG($default_goods_img); ?>"/>
                                                <?php endif; endif; if($web_category_display['is_use'] == 0): ?>
		                                    <span><?php echo $vo3['category_name']; ?></span>
		                                    <?php else: ?>
		                                    <span><?php echo $vo3['short_name']; ?></span>
		                                    <?php endif; ?>

                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php endif; endif; ?>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    <?php endif; endif; ?>
                </li>
                <?php endif; endforeach; ?>
            </ul>
        </div>
        <?php if(!(empty($navigation_list['data']) || (($navigation_list['data'] instanceof \think\Collection || $navigation_list['data'] instanceof \think\Paginator ) && $navigation_list['data']->isEmpty()))): ?>
        <ul class="menu">
            <?php if(is_array($navigation_list['data']) || $navigation_list['data'] instanceof \think\Collection || $navigation_list['data'] instanceof \think\Paginator): if( count($navigation_list['data'])==0 ) : echo "" ;else: foreach($navigation_list['data'] as $k=>$nav): ?>
            <li>
                <?php if($nav['nav_type'] == 0): ?>
                <a class="ns-border-color-hover ns-text-color-hover" <?php if($nav['is_blank'] == 1): ?>target="_blank"<?php endif; ?> href="<?php echo __URL('http://t.huaqi86.com/index.php'.$nav['nav_url']); ?>" title="<?php echo $nav['nav_title']; ?>"><?php echo $nav['nav_title']; ?></a>
                <?php else: ?>
                <a class="ns-border-color-hover ns-text-color-hover" <?php if($nav['is_blank'] == 1): ?>target="_blank"<?php endif; ?> href="<?php echo $nav['nav_url']; ?>" title="<?php echo $nav['nav_title']; ?>"><?php echo $nav['nav_title']; ?></a>
                <?php endif; ?>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <?php endif; ?>
    </nav>

</header>


<div class="ns-main w1200">
    
<div class="help">
	<ol class="breadcrumb">
		<li><a href="<?php echo __URL('http://t.huaqi86.com/index.php'); ?>"><?php echo lang('home_page'); ?></a></li>
		<li class="active"><?php echo lang('shop_help_center'); ?></li>
	</ol>
	<div class="category">
		<h3 class="ns-bg-color"><?php echo lang('shop_help_center'); ?></h3>
		<ul>
			<?php if(is_array($platform_help_class) || $platform_help_class instanceof \think\Collection || $platform_help_class instanceof \think\Paginator): if( count($platform_help_class)==0 ) : echo "" ;else: foreach($platform_help_class as $key=>$class_vo): ?>
			<li>
				<div class="ns-bg-color-gray">
					<a href="javascript:;" title="<?php echo $class_vo['class_name']; ?>"><?php echo $class_vo['class_name']; ?></a>
					<span><i class="<?php if($class_vo['class_id'] == $class_id): ?>icon-sort-up<?php else: ?>icon-sort-down<?php endif; ?>"></i></span>
				</div>
				<ul <?php if($class_vo['class_id'] != $class_id): ?>class="dis-no"<?php endif; ?>>
					<?php if(is_array($platform_help_document) || $platform_help_document instanceof \think\Collection || $platform_help_document instanceof \think\Paginator): if( count($platform_help_document)==0 ) : echo "" ;else: foreach($platform_help_document as $key=>$document_vo): if($document_vo['class_id'] == $class_vo['class_id']): ?>
					<li>
						<a href="<?php echo __URL('http://t.huaqi86.com/index.php/help/index','id='.$document_vo['id'].'&class_id='.$document_vo['class_id']); ?>" target="_self" title="<?php echo $document_vo['title']; ?>" <?php if($document_vo['id'] == $id): ?>class="ns-text-color"<?php endif; ?>><?php echo $document_vo['title']; ?></a>
					</li>
					<?php endif; endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
	<div class="detail">
		<h3 class="ns-border-color-gray"><?php echo $help_document_info['title']; ?></h3>
		<div class="content"><?php echo $help_document_info['content']; ?></div>
	</div>
</div>
<input type="hidden" value="<?php echo $id; ?>" id="hidden_id" />

    
    
	
        <!--所需数据-->
    
        <!--头部、面包屑-->
    
        <!--//受模板限时，当前模块引入整体头部，改变-->
    
        <!--商品分享收藏-->
    
        <!--商品标题、名称、描述-->
    
        <!--商品活动-->
    
        <!--价格-->
        
        <!--销量评价-->
        
        <!--单品活动-->
    
        <!--物流配送-->
    
        <!--商品规格-->
    
        <!--操作，立即购买/加入购物车-->
    
        <!--商家服务-->
    
        <!--面板右侧，看了又看，推荐商品等-->
    
        <!--中部左侧，推荐商品-->
    
        <!--中部：组合套餐-->
    
        <!--商品详情、商品属性、评价、咨询-->
    
    
    
    <!--猜你喜欢/浏览历史-->
    
    
</div>

<footer class="ns-footer">
    <div class="w1200">
        <?php 

        //商城服务
        $merchant_service_list = api("System.Config.merchantService");
        $merchant_service_list = $merchant_service_list['data'];

        //帮助中心
        $platform_help_class = api("System.Shop.helpClassList");
        $platform_help_class = $platform_help_class['data'];

        //帮助中心
        $platform_help_document = api("System.Shop.helpInfo");
        $platform_help_document = $platform_help_document['data'];

        //友情链接
        $link_list = api("System.Shop.shopLinkList");
        $link_list = $link_list['data']['data'];

        //客服链接配置
        $custom_service = api("System.Config.customService");
        $custom_service = $custom_service['data'];
         if(!(empty($merchant_service_list) || (($merchant_service_list instanceof \think\Collection || $merchant_service_list instanceof \think\Paginator ) && $merchant_service_list->isEmpty()))): ?>
        <div class="service ns-border-color-gray">
            <ul class="w1200 clearfix">
                <?php if(is_array($merchant_service_list) || $merchant_service_list instanceof \think\Collection || $merchant_service_list instanceof \think\Paginator): if( count($merchant_service_list)==0 ) : echo "" ;else: foreach($merchant_service_list as $k=>$vo): ?>
                <li class="ns-border-color-gray" style="width: <?php echo 100/count($merchant_service_list)-1?>%">
                    <?php if($vo['pic'] == ''): ?>
                    <!--<i class="ico ico-service ns-bg-color-gray"></i>-->
                    <?php else: ?>
                    <i class="ico ico-service" style="background: url('<?php echo __IMG($vo['pic']); ?>') no-repeat center center;background-size:100%;"></i>
                    <?php endif; ?>
                    <p><?php echo $vo['title']; ?></p>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
        <?php endif; ?>
        <div class="help w1200 clearfix">
            <div class="pull-left list">
                <?php if(!(empty($platform_help_class['data']) || (($platform_help_class['data'] instanceof \think\Collection || $platform_help_class['data'] instanceof \think\Paginator ) && $platform_help_class['data']->isEmpty()))): ?>
                <div class="wrap">
                    <?php if(is_array($platform_help_class['data']) || $platform_help_class['data'] instanceof \think\Collection || $platform_help_class['data'] instanceof \think\Paginator): if( count($platform_help_class['data'])==0 ) : echo "" ;else: foreach($platform_help_class['data'] as $key=>$class_vo): ?>
                    <dl>
                        <dt><?php echo $class_vo['class_name']; ?></dt>
                        <?php if(is_array($platform_help_document['data']) || $platform_help_document['data'] instanceof \think\Collection || $platform_help_document['data'] instanceof \think\Paginator): if( count($platform_help_document['data'])==0 ) : echo "" ;else: foreach($platform_help_document['data'] as $key=>$document_vo): if($class_vo['class_id'] == $document_vo['class_id']): ?>
                        <dd><a href="<?php echo __URL('http://t.huaqi86.com/index.php/help/index','id='.$document_vo['id']); ?>" title="<?php echo $document_vo['title']; ?>" target="_blank"><?php echo $document_vo['title']; ?></a></dd>
                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </dl>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <?php endif; if(!(empty($link_list) || (($link_list instanceof \think\Collection || $link_list instanceof \think\Paginator ) && $link_list->isEmpty()))): ?>
                <div class="friendship-links clearfix">
                    <span><?php echo lang('friendship_link'); ?> : </span>
                    <div class="links-wrap">
                        <?php if(is_array($link_list) || $link_list instanceof \think\Collection || $link_list instanceof \think\Paginator): if( count($link_list)==0 ) : echo "" ;else: foreach($link_list as $key=>$vo): ?>
                        <a href="<?php echo $vo['link_url']; ?>" title="<?php echo $vo['link_title']; ?>" <?php if($vo['is_blank'] == 1): ?>target="_blank_"<?php endif; ?>><?php echo $vo['link_title']; ?></a>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="contact-us">
                <h3><?php echo lang('hotline'); ?></h3>
                <span class="phone common-text-color" title="<?php echo $web_info['web_phone']; ?>"><?php echo $web_info['web_phone']; ?></span>
               
                <?php if($custom_service['value']['service_addr']): ?>
                <a href="<?php echo $custom_service['value']['service_addr']; ?>" class="consultation_cu" target="_blank" title="<?php echo lang('contact_customer_service'); ?>"><?php echo lang('consulting_customer_service'); ?></a>
            	<?php endif; ?>
            </div>
        </div>
        
        <div class="ns-copyright" id="copyright-main">
            <p id="copyright_desc"></p>
            <p>
                <a id="copyright_companyname" href="javascript:;" target="_blank"></a>
                <span id="copyright_meta"></span>
            </p>
            <p id="web_gov_record_wap">
                <a href="javascript:;" target="_blank">
                    <img src="/public/static/images/gov_record.png" alt="公安备案">
                    <span></span>
                </a>
            </p>
            <?php echo $web_info['third_count']; ?>
        </div>
    </div>

</footer>

<?php if($default_client): ?>
<div class="go-mobile" onclick="locationWap()" id="go_mobile">
    <img src="/template/web/default/public/img/go_mobile.png"/>
</div>
<?php endif; ?>

<aside class="right-sidebar">
    <div class="toolbar">
        <div class='menu'>
            <a href="<?php echo __URL('http://t.huaqi86.com/index.php/member/index'); ?>">
                <div class="item-icon-box">
                    <i class="icon icon-user"></i>
                </div>
                <div class="text ns-bg-color">会员中心</div>
            </a>
            <a href="<?php echo __URL('http://t.huaqi86.com/index.php/goods/cart'); ?>" class="js-sidebar-cart-trigger">
                <div class="item-icon-box">
                    <i class="icon icon-shopping-cart"></i>
                    <span class="sidebar-num ns-bg-color">0</span>
                </div>
                <div class="text ns-bg-color">购物车</div>
            </a>
            <a href="<?php echo __URL('http://t.huaqi86.com/index.php/member/collection'); ?>">
                <div class="item-icon-box">
                    <i class="icon icon-heart-empty"></i>
                </div>
                <div class="text ns-bg-color">我的收藏</div>
            </a>
            <a href="<?php echo __URL('http://t.huaqi86.com/index.php/member/footprint'); ?>">
                <div class="item-icon-box">
                    <i class="icon icon-time "></i>
                </div>
                <div class="text ns-bg-color">我的足迹</div>
            </a>
            <a href="javascript:;">
                <div class="item-icon-box">
                    <i class="icon icon-qrcode"></i>
                </div>
                <div class="text ns-bg-color qrcode ns-border-color-gray">
                    <img src="<?php echo __IMG($web_info['web_qrcode']); ?>">
                </div>
            </a>
        </div>
        <div class="menu back-top">
            <a href="javascript:;">
                <div class="item-icon-box">
                    <i class="icon icon-angle-up"></i>
                </div>
                <div class="text ns-bg-color">顶部</div>
            </a>
        </div>
    </div>
</aside>

<input type="hidden" id="hidden_default_headimg" value="<?php echo __IMG($default_headimg); ?>">
<input type="hidden" id="niushop_rewrite_model" value="<?php echo rewrite_model(); ?>">
<input type="hidden" id="niushop_url_model" value="<?php echo url_model(); ?>">
<input type="hidden" id="hidden_default_client" value="<?php echo $default_client; ?>">
<input type="hidden" id="hidden_shop_name" value="<?php echo $web_info['title']; ?>">
<input type="hidden" id="default_goods_img" value="<?php echo $default_goods_img; ?>">
<script>
$(function() {
	img_lazyload();
});

//图片懒加载
function img_lazyload(){
	$("img.lazy").lazyload({
    	threshold : 0,
    	effect: "fadeIn",
    	skip_invisible : false,
        failurelimit : 10
    })
}
var default_goods_img = $("#default_goods_img").val();
var lang_base = {
	i_am : '<?php echo lang("i_am"); ?>',
	safe_exit : '<?php echo lang("safe_exit"); ?>',
	default_avatar : '<?php echo lang("default_avatar"); ?>',
	login : '<?php echo lang("login"); ?>',
	welcome_login : '<?php echo lang("welcome_login"); ?>',
	register : '<?php echo lang("register"); ?>',
	quit_successfully : '<?php echo lang("quit_successfully"); ?>',
	recent_search : '<?php echo lang("recent_search"); ?>',
	empty : '<?php echo lang("empty"); ?>',
	please_input_keywords : '<?php echo lang("please_input_keywords"); ?>',
	username_cannot_be_empty : '<?php echo lang("username_cannot_be_empty"); ?>',
	password_must_not_be_empty : '<?php echo lang("password_must_not_be_empty"); ?>',
	verification_code_must_not_be_null : '<?php echo lang("verification_code_must_not_be_null"); ?>',
	login_successful : '<?php echo lang("login_successful"); ?>',
};
</script>

<script type="text/javascript" src="/template/web/default/public/js/help.js"></script>

</body>
</html>