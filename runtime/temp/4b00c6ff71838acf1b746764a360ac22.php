<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:37:"template/wap/default/index/index.html";i:1589107520;s:57:"/www/wwwroot/t.huaqi86.com/template/wap/default/base.html";i:1591172818;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta name="renderer" content="webkit"/>
	<meta http-equiv="X-UA-COMPATIBLE" content="IE=edge,chrome=1"/>
	<meta content="text/html; charset=UTF-8">
	<meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no,width=device-width,viewport-fit=cover">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
	<title><?php if($title_before != ''): ?><?php echo $title_before; ?>&nbsp;-&nbsp;<?php endif; ?><?php echo $platform_shop_name; if($seo_config['seo_title'] != ''): ?>-<?php echo $seo_config['seo_title']; endif; ?></title>
	
	<meta name="keywords" content="<?php echo $seo_config['seo_meta']; ?>"/>
	<meta name="description" content="<?php echo $seo_config['seo_desc']; ?>"/>
	
	<link rel="shortcut icon" type="image/x-icon" href="/public/static/images/favicon.ico" media="screen"/>
	<link type="text/css" rel="stylesheet" href="/public/static/font-awesome/css/font-awesome.css">
	<link rel="stylesheet" href="/template/wap/default/public/css/normalize.css"/>
	<link rel="stylesheet" href="/template/wap/default/public/plugin/mzui/css/mzui.css"/>
	<link rel="stylesheet" href="/template/wap/default/public/plugin/mescroll/css/mescroll.css"/>
	<link rel="stylesheet" href="/template/wap/default/public/css/common.css"/>
	<link type="text/css" rel="stylesheet" href="/template/wap/default/public/css/themes/<?php echo $theme_css; ?>">
	<script src="/template/wap/default/public/plugin/mzui/lib/jquery/jquery-3.2.1.min.js"></script>
	<script src="/template/wap/default/public/plugin/mzui/js/mzui.js"></script>
	<script src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"> </script>
	<script src="/public/static/js/jquery.cookie.js"></script>
	<script src="/template/wap/default/public/plugin/mescroll/js/mescroll.js"></script>
	<script src="/template/wap/default/public/js/common.js"></script>
	<script src="/template/wap/default/public/js/jquery.lazyload.js"></script>
	<script>
		var APPMAIN = 'http://t.huaqi86.com/index.php/wap';
		var SHOPMAIN = "http://t.huaqi86.com/index.php";
		var STATIC = "/public/static";
		var WAPIMG = "/template/wap/default/public/img";
		var WAPPLUGIN = "/template/wap/default/public/plugin";
		var UPLOAD = "";
		var DEFAULT_HEAD_IMG = "<?php echo __IMG($default_headimg); ?>";
		var DEFAULT_GOODS_IMG = "<?php echo __IMG($default_goods_img); ?>";
		var uid = "<?php echo $uid; ?>";
		$(function() {
			img_lazyload();
		});
		function img_lazyload(){
			$("img.lazy").lazyload({
		    	threshold : 0,
		    	effect: "fadeIn",
		    	skip_invisible : false,
		        failurelimit : 10
		    })
		}
	</script>
	
<link rel="stylesheet" href="/template/wap/default/public/css/liMarquee.css">
<link rel="stylesheet" href="/template/wap/default/public/css/index.css"/>
<link rel="stylesheet" href="/template/wap/default/public/plugin/swiper/css/swiper.min.css"/>
<script src="/template/wap/default/public/plugin/swiper/js/swiper.min.js"></script>

</head>
<body>


<?php 
$page_layout = api("System.Config.wapPageLayout");
$page_layout = $page_layout['data'];
if(empty($page_layout)){
	$page_layout = array( 
            [ "tag" => "banner", "isVisible" => true ], [ "tag" => "search", "isVisible" => true ], [ "tag" => "nav", "isVisible" => true ],[ "tag" => "notice", "isVisible" => true ], [ "tag" => "coupons", "isVisible" => true ], [ "tag" => "games", "isVisible" => true ], [ "tag" => "discount", "isVisible" => true ], [ "tag" => "spell-bargain", "isVisible" => true ], [ "tag" => "spell-group", "isVisible" => true ], [ "tag" => "goods", "isVisible" => true ], [ "tag" => "cube", "isVisible" => true ], [ "tag" => "bottom", "isVisible" => true ]);
}

//WAP端首页浮层
$wap_floating = api('System.Shop.wapFloating');
$wap_floating = $wap_floating['data'];
 if(!(empty($wap_floating) || (($wap_floating instanceof \think\Collection || $wap_floating instanceof \think\Paginator ) && $wap_floating->isEmpty()))): if($wap_floating['is_show'] == 1): ?>
<div class="wap-floating">
	<a class="close-wrap" href="javascript:;"><img src="/template/wap/default/public/img/index/floating_layer_close.png"></a>
    <?php if(is_url($wap_floating['nav_url'])): ?>
	<a class="img-wrap" href="<?php echo $wap_floating['nav_url']; ?>">
    <?php else: ?>
    <a class="img-wrap" href="<?php echo __URL('http://t.huaqi86.com/index.php/wap' . $wap_floating['nav_url']); ?>">

    <?php endif; ?>
        <img src="<?php echo __IMG($wap_floating['nav_icon']); ?>" alt="浮层图片" />
    </a>
</div>
<?php endif; endif; ?>

<div class="pay-layout">
<?php if(is_array($page_layout) || $page_layout instanceof \think\Collection || $page_layout instanceof \think\Paginator): if( count($page_layout)==0 ) : echo "" ;else: foreach($page_layout as $k=>$vo): if($vo['tag']=='banner'): if($vo['isVisible']): ?>
        <!--轮播图-->
            <?php 
            $plat_adv_list = api("System.Shop.advDetail",['ap_keyword' => 'WAP_INDEX_SWIPER', 'export_type' => 'data']);
             if(!(empty($plat_adv_list['data']) || (($plat_adv_list['data'] instanceof \think\Collection || $plat_adv_list['data'] instanceof \think\Paginator ) && $plat_adv_list['data']->isEmpty()))): ?>
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                    <?php if(is_array($plat_adv_list['data']['advs']) || $plat_adv_list['data']['advs'] instanceof \think\Collection || $plat_adv_list['data']['advs'] instanceof \think\Paginator): if( count($plat_adv_list['data']['advs'])==0 ) : echo "" ;else: foreach($plat_adv_list['data']['advs'] as $key=>$vo): ?>
                        <div class="swiper-slide">
                            <?php if(is_url($vo['adv_url'])): ?>
                            <a href="<?php echo $vo['adv_url']; ?>" style="height:<?php echo $plat_adv_list['data']['ap_height']; ?>px;line-height:<?php echo $plat_adv_list['data']['ap_height']; ?>px;">
                            <?php else: ?>
                            <a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap' . $vo['adv_url']); ?>" style="height:<?php echo $plat_adv_list['data']['ap_height']; ?>px;line-height:<?php echo $plat_adv_list['data']['ap_height']; ?>px;">
                            <?php endif; ?>
                                <img src="<?php echo __IMG($vo['adv_image']); ?>" alt="<?php echo lang('carousel_figure'); ?>">
                            </a>
                        </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
           	<?php endif; endif; elseif($vo['tag']=='search'): if($vo['isVisible']): ?>
        <!-- 搜索栏 -->
        <div class="control-search">
            <div class="control-search-input ns-bg-color-gray-fadeout-60">
                <button type="button" class="search-button custom-search-button ns-border-color-gray"><?php echo lang('search'); ?></button>
                <input type="text" class="search-input custom-search-input ns-text-color-gray" placeholder="<?php echo lang('search_goods'); ?>">
            </div>
        </div>
        <?php endif; elseif($vo['tag']=='nav'): if($vo['isVisible']): ?>
        <!--导航栏-->
            <?php 
            $navigation_list = api("System.Shop.shopNavigationList",['page_index'=>1,'page_size'=>0,'type'=>2,'is_show'=>1,'order' => 'sort desc']);
            $navigation_list = $navigation_list['data']['data'];
             if(!(empty($navigation_list) || (($navigation_list instanceof \think\Collection || $navigation_list instanceof \think\Paginator ) && $navigation_list->isEmpty()))): ?>
            <nav class="navi">
                <?php if(is_array($navigation_list) || $navigation_list instanceof \think\Collection || $navigation_list instanceof \think\Paginator): if( count($navigation_list)==0 ) : echo "" ;else: foreach($navigation_list as $key=>$vo): if($vo['nav_type'] == 0): ?>
                    <a class="nav-item" href="<?php echo __URL('http://t.huaqi86.com/index.php/wap'.$vo['nav_url']); ?>">
                    <?php else: ?>
                    <a class="nav-item" href="<?php echo $vo['nav_url']; ?>">
                    <?php endif; ?>
                        <div>
                            <img src="<?php echo __IMG($vo['nav_icon']); ?>">
	                        <span class="ns-text-color-black"><?php echo $vo['nav_title']; ?></span>
                        </div>
                    </a>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </nav>
            <?php endif; endif; elseif($vo['tag']=='notice'): ?>
    
        <!-- 公告 -->
        <?php if($vo['isVisible']): 
            $notice = api("System.Shop.shopNoticeList");
            $notice = $notice['data']['data'];
             if(!(empty($notice) || (($notice instanceof \think\Collection || $notice instanceof \think\Paginator ) && $notice->isEmpty()))): ?>
            <input type="hidden" id="hidden_notice_count" value="<?php echo count($notice); ?>">
            <div class="hot ns-border-color-gray-fadeout-50">
                <div class="notice-img">
                    <img src="/template/wap/default/public/img/index/hot.png">
                </div>
                <div class="dowebok dowebok-block">
                    <ul>
                        <?php if(is_array($notice) || $notice instanceof \think\Collection || $notice instanceof \think\Paginator): if( count($notice)==0 ) : echo "" ;else: foreach($notice as $key=>$vo): ?>
	                    <li>
                            <a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap/notice/detail?id='.$vo['id']); ?>"><?php echo $vo['notice_title']; ?></a>
	                    </li>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
            </div>
            <?php endif; endif; elseif($vo['tag']=='coupons'): if($vo['isVisible']): ?>
            <!--优惠券-->
            <?php 
            $coupon_list = api("System.Member.canReceiveCouponQuery",['uid'=>$uid]);
            $coupon_list = $coupon_list['data'];
             if(!(empty($coupon_list) || (($coupon_list instanceof \think\Collection || $coupon_list instanceof \think\Paginator ) && $coupon_list->isEmpty()))): ?>
            <div class="coupon-container">
                <div  class="coupon-all">
                    <?php if(is_array($coupon_list) || $coupon_list instanceof \think\Collection || $coupon_list instanceof \think\Paginator): $i = 0; $__LIST__ = $coupon_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['max_fetch'] <= $vo['received_num'] && $vo['max_fetch'] != 0): ?>
	                    <div class="receive-coupons type_color" data-max-fetch="<?php echo $vo['max_fetch']; ?>" data-received-num="<?php if(!empty($uid)): ?><?php echo $vo['received_num']; else: ?>0<?php endif; ?>">
	                        <div class="coupon-left">
	                        	<span class="money-number">￥<?php echo $vo['money']; ?></span>
	                        	<p class="explanation">满<?php echo $vo['at_least']; ?>可用</p>
	                        </div>
	                        <div class="get ns-text-color coupon-right type_top">已领取</div>
	                    </div>
                    <?php else: ?>
                    <div class="receive-coupons" data-max-fetch="<?php echo $vo['max_fetch']; ?>" data-received-num="<?php if(!empty($uid)): ?><?php echo $vo['received_num']; else: ?>0<?php endif; ?>" onclick="couponReceive(this,<?php echo $vo['coupon_type_id']; ?>)">
                        <div class="coupon-left">
                        	<span class="money-number">￥<?php echo $vo['money']; ?></span>
                        	<p class="explanation">满<?php echo $vo['at_least']; ?>可用</p>
                        </div>
                        <div class="get ns-text-color coupon-right">领取</div>
                    </div>
                    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <?php endif; endif; elseif($vo['tag']=='games'): if($vo['isVisible']): ?>
        <!--游戏活动-->
            <?php 
                $game_list = api("System.Promotion.promotionGamesList",['condition'=>['status' => 1,"is_index_show" => 1 ],'order'=>'game_id desc']);
                $game_list = $game_list['data'];
             if(!(empty($game_list['data']) || (($game_list['data'] instanceof \think\Collection || $game_list['data'] instanceof \think\Paginator ) && $game_list['data']->isEmpty()))): ?>
            <div class="promotion-game-content">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <?php if(is_array($game_list['data']) || $game_list['data'] instanceof \think\Collection || $game_list['data'] instanceof \think\Paginator): if( count($game_list['data'])==0 ) : echo "" ;else: foreach($game_list['data'] as $key=>$vo): ?>
                        <div class="swiper-slide">
                            <a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap/game/index?gid='.$vo['game_id']); ?>">
                                <img src="<?php echo __IMG($vo['activity_images']); ?>" >
                            </a>
                        </div>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <?php endif; endif; elseif($vo['tag']=='discount'): if($vo['isVisible']): ?>
        <!--限时折扣-->
            <?php 
            $discount_data = api("System.Goods.newestDiscount");
            $discount = $discount_data['data'];
             if(!empty($discount)): ?>
                <div class="group-list-box">
	                <div class="group-list-box-in">
	                    <div class="controltype" onclick="location.href='<?php echo __URL("http://t.huaqi86.com/index.php/wap/goods/discount"); ?>'">
	                        <div class="title ns-text-color-black discount-title">
	                        	<!-- <img src="/template/wap/default/public/img/index/discoun_title.png" /> -->
	                        	<span class="module-title spike">限时秒杀</span>
	                        </div>
	                        <div class="discount-title-right">
	                        	<time class="remaining-time" starttime="<?php echo date('Y-m-d H:i:s',$discount['start_time']); ?>" endtime="<?php echo date('Y-m-d H:i:s',$discount['end_time']); ?>">
                                      <span class="day ns-bg-color-black">0</span>
                                      <span class="hours">00</span>
                                      <em>:</em>
                                      <span class="min ns-bg-color-black">00</span>
                                      <em>:</em>
                                      <span class="seconds ns-bg-color-black">00</span>
                                  </time>
	                        </div>
	                    </div>
	                    <div class="discount-list">
	                        <ul>
	                            <?php if(is_array($discount['goods_list']) || $discount['goods_list'] instanceof \think\Collection || $discount['goods_list'] instanceof \think\Paginator): $k = 0; $__LIST__ = $discount['goods_list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;if($k < 3): ?>
    	                            <li>
    	                            	 <div class="goods-pic">
    	                                    <a class="nav-item" href="<?php echo __URL('http://t.huaqi86.com/index.php/wap/goods/detail?goods_id='.$vo['goods_id']); ?>">
    	                                        <img class="lazy" src="<?php echo __IMG($default_goods_img); ?>" data-original="<?php echo __IMG($vo['picture_info']['pic_cover_small']); ?>">
    	                                    </a>
    	                                </div>
    	                                <div class="goods-info">
    	                                    <a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap/goods/detail?goods_id='.$vo['goods_id']); ?>">
    	                                        <div class="goods-name"><?php echo $vo['goods_name']; ?></div>
    	                                        <span class="goods-price ns-text-color"><i>￥</i><?php echo $vo['promotion_price']; ?></span>
    	                                    </a>
    	                                </div>
    	                            </li>
                                    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
	                        </ul>
	                    </div>
	                </div>
                </div>
            <?php endif; endif; elseif($vo['tag']=='spell-bargain'): if($vo['isVisible']): if(addon_is_exit('NsBargain') == 1): 
    			 $bargain_list = api("NsBargain.Bargain.bargainList",['page_size'=>5]);
    			 $bargain_list = $bargain_list['data'];
    		 if(!(empty($bargain_list['data']) || (($bargain_list['data'] instanceof \think\Collection || $bargain_list['data'] instanceof \think\Paginator ) && $bargain_list['data']->isEmpty()))): ?>
	        <!-- 砍价 -->
		    <div class="spelling-block">
			     <header>
			         <div class="ns-text-color-black assemble-title bargain-title"><span class="module-title bargain">疯狂砍价</span></div>
			         <a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap//goods/bargain'); ?>">更多&nbsp;&gt;</a>
			     </header>
			     <ul>
			         <?php if(is_array($bargain_list['data']) || $bargain_list['data'] instanceof \think\Collection || $bargain_list['data'] instanceof \think\Paginator): if( count($bargain_list['data'])==0 ) : echo "" ;else: foreach($bargain_list['data'] as $k=>$vo): ?>
			         <li onclick="location.href='<?php echo __URL('http://t.huaqi86.com/index.php/wap/goods/detail?goods_id='.$vo['goods_id'].'&bargain_id='.$vo['bargain_id']); ?>'">
			             <div>
			                 <img src="<?php echo __IMG($default_goods_img); ?>" data-original="<?php echo __IMG($vo['pic_cover_mid']); ?>" class="lazy_load pic lazy">
			             </div>
			             <footer class="ns-border-color-gray">
			                 <p class="ns-text-color-black"><?php echo $vo['goods_name']; ?></p>
			                 <div class="assemble-tag">
			                 	<div class="people-num ns-text-color">砍价</div>
			                 	<?php if($vo['shipping_fee'] == '0'): ?><div class="people-num ns-text-color">包邮</div><?php endif; ?>
			                 </div>
			                 <div class="assemble-foot">
			               	  	<div class="tuangou-money ns-text-color bargain-price">￥<?php echo $vo['promotion_price']; ?></div>
			                    <div class="assemble-foot-right">
			                     	<div class="mui-btn mui-btn-danger primary go-bargain">发起砍价</div>
			                     </div>
			                 </div>
			             </footer>
			         </li>
			         <?php endforeach; endif; else: echo "" ;endif; ?>
			     </ul>
			 </div>
			 <?php endif; endif; endif; elseif($vo['tag']=='spell-group'): if($vo['isVisible']): ?>
        <!--拼团推荐-->
			<?php if(addon_is_exit('NsPintuan') == 1): 

            $pintuan_list = api("NsPintuan.Pintuan.goodsList",['page_size'=>5,'condition'=> json_encode(['npg.is_open' => 1, 'npg.is_show' => 1]),'order'=>'npg.create_time desc']);
            $pintuan_list = $pintuan_list['data'];
             if(!(empty($pintuan_list['data']) || (($pintuan_list['data'] instanceof \think\Collection || $pintuan_list['data'] instanceof \think\Paginator ) && $pintuan_list['data']->isEmpty()))): ?>
            <div class="spelling-block">
                <header>
                    <div class="ns-text-color-black assemble-title"><span class="module-title assemble">拼团抢购</span></div>
                    <a class="assemble-title-right" href="<?php echo __URL('http://t.huaqi86.com/index.php/wap/goods/pintuan'); ?>">更多&nbsp;&gt;</a>
                </header>
                <ul>
                    <?php if(is_array($pintuan_list['data']) || $pintuan_list['data'] instanceof \think\Collection || $pintuan_list['data'] instanceof \think\Paginator): if( count($pintuan_list['data'])==0 ) : echo "" ;else: foreach($pintuan_list['data'] as $k=>$vo): ?>
                    <li onclick="location.href='<?php echo __URL('http://t.huaqi86.com/index.php/wap/goods/detail?goods_id='.$vo['goods_id']); ?>'">
                        <div>
                            <img src="<?php echo __IMG($default_goods_img); ?>" data-original="<?php echo __IMG($vo['pic_cover_mid']); ?>" class="pic lazy">
                        </div>
                        <footer class="ns-border-color-gray">
                            <p class="ns-text-color-black"><?php echo $vo['goods_name']; ?></p>
                            <div class="assemble-tag">
                            	<div class="already-num ns-text-color ns-bg-color-fadeout-80">已抢<?php echo $vo['sales']; ?>件</div>
                            	<div class="people-num ns-text-color ns-border-color-fadeout-80"><?php echo $vo['tuangou_num']; ?>人团</div>
                            	<div class="people-num ns-text-color ns-border-color-fadeout-80">包邮</div>
                            </div>
                            <div class="assemble-foot">
	                            <div class="assemble-foot-left">
	                            	 <div class="tuangou-money ns-text-color">￥<?php echo $vo['tuangou_money']; ?></div>
	                                <div class="original-money ns-text-color-gray">单买价<?php echo $vo['promotion_price']; ?></div>
	                            </div>
                               <div class="assemble-foot-right">
                                	<div class="mui-btn-danger primary">GO</div>
                                	<div class="goin ns-border-color ns-text-color">去拼团</div>
                                </div>
                            </div>
                        </footer>
                    </li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
            <?php endif; endif; endif; elseif($vo['tag']=='adv'): if($vo['isVisible']): ?>
        <!--广告位-->
        <?php endif; elseif($vo['tag']=='goods'): if($vo['isVisible']): ?>
        <!--推荐商品（新品 精品 热卖、楼层等推荐商品）-->
            <!--推荐商品（新品 精品 热卖、楼层等推荐商品）-->
			<?php 
				$new_goods_list = api("System.Goods.newGoodsList", ["page_size" => 4]);
				$new_goods_list = $new_goods_list['data'];
			 if(!(empty($new_goods_list) || (($new_goods_list instanceof \think\Collection || $new_goods_list instanceof \think\Paginator ) && $new_goods_list->isEmpty()))): ?>
			<!-- 新品 -->
			<div class="floor">
				<div class="category-name ">
					<div class="floor-list-title">
						<div class="floor-title-left">
							<div class="floor-title-left-second ns-border-color-gray"></div>
						</div>
						<span class="floor-left-nav ns-text-color-black">新品</span>
						<div class="floor-title-right">
							<div class="floor-title-left-second ns-border-color-gray"></div>
						</div>
					</div>
				</div>
				<section class="members-goods-pic ns-border-color-gray">
					<ul>
						<?php if(is_array($new_goods_list) || $new_goods_list instanceof \think\Collection || $new_goods_list instanceof \think\Paginator): if( count($new_goods_list)==0 ) : echo "" ;else: foreach($new_goods_list as $k=>$list): ?>
						<li class="gooditem">
							<div class="imgs">
								<a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>">
									<img class="lazy" src="<?php echo __IMG($default_goods_img); ?>" data-original="<?php echo __IMG($list['pic_cover_mid']); ?>" >
								</a>
							</div>
							<div class="info">
								<p class="goods-title">
									<a class="ns-text-color-black" href="<?php echo __URL('http://t.huaqi86.com/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>"><?php echo $list['goods_name']; ?></a>
								</p>
								<div class="goods-info">
									<span class="goods-price ns-text-color">
										<?php if(in_array(($list['point_exchange_type']), explode(',',"0,2"))): ?>
										<em>￥<?php echo $list['promotion_price']; ?></em>
										<?php else: if($list['point_exchange_type'] == 1 && $list['promotion_price'] > 0): ?>
												<em>￥<?php echo $list['promotion_price']; ?>+<?php echo $list['point_exchange']; ?>积分</em>
											<?php else: ?>
												<em><?php echo $list['point_exchange']; ?>积分</em>
											<?php endif; endif; ?>
									</span>
									<div class="add_cart" onclick="window.location.href='<?php echo __URL('http://t.huaqi86.com/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>'">
										<img src="/template/wap/default/public/img/index/add_cart.png" />
									</div>
								</div>
							</div>
						</li>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</section>
			</div>
			<?php endif; 
				$recommend_goods_list = api("System.Goods.recommendGoodsList", ["page_size" => 4]);
				$recommend_goods_list = $recommend_goods_list['data'];
			 if(!(empty($recommend_goods_list) || (($recommend_goods_list instanceof \think\Collection || $recommend_goods_list instanceof \think\Paginator ) && $recommend_goods_list->isEmpty()))): ?>
			<!-- 精品 -->
			<div class="floor">
				<div class="category-name">
					<div class="floor-list-title">
						<div class="floor-title-left">
							<div class="floor-title-left-second ns-border-color-gray"></div>
						</div>
						<span class="floor-left-nav ns-text-color-black">精品</span>
						<div class="floor-title-right">
							<div class="floor-title-left-second ns-border-color-gray"></div>
						</div>
					</div>
				</div>
				<section class="members-goods-pic ns-border-color-gray">
					<ul>
						<?php if(is_array($recommend_goods_list) || $recommend_goods_list instanceof \think\Collection || $recommend_goods_list instanceof \think\Paginator): if( count($recommend_goods_list)==0 ) : echo "" ;else: foreach($recommend_goods_list as $k=>$list): ?>
						<li class="gooditem">
							<div class="imgs">
								<a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>">
									<img class="lazy" src="<?php echo __IMG($default_goods_img); ?>" data-original="<?php echo __IMG($list['pic_cover_mid']); ?>" >
								</a>
							</div>
							<div class="info">
								<p class="goods-title">
									<a class="ns-text-color-black" href="<?php echo __URL('http://t.huaqi86.com/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>"><?php echo $list['goods_name']; ?></a>
								</p>
								<div class="goods-info">
									<span class="goods-price ns-text-color">
										<?php if(in_array(($list['point_exchange_type']), explode(',',"0,2"))): ?>
										<em>￥<?php echo $list['promotion_price']; ?></em>
										<?php else: if($list['point_exchange_type'] == 1 && $list['promotion_price'] > 0): ?>
												<em>￥<?php echo $list['promotion_price']; ?>+<?php echo $list['point_exchange']; ?>积分</em>
											<?php else: ?>
												<em><?php echo $list['point_exchange']; ?>积分</em>
											<?php endif; endif; ?>
									</span>
									<div class="add_cart" onclick="window.location.href='<?php echo __URL('http://t.huaqi86.com/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>'">
										<img src="/template/wap/default/public/img/index/add_cart.png"  />
									</div>
								</div>
							</div>
						</li>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</section>
			</div>
			<?php endif; 
				$hot_goods_list = api("System.Goods.hotGoodsList", ["page_size" => 4]);
				$hot_goods_list = $hot_goods_list['data'];
			 if(!(empty($hot_goods_list) || (($hot_goods_list instanceof \think\Collection || $hot_goods_list instanceof \think\Paginator ) && $hot_goods_list->isEmpty()))): ?>
			<!-- 热卖 -->
			<div class="floor">
				<div class="category-name">
					<div class="floor-list-title">
						<div class="floor-title-left">
							<div class="floor-title-left-second ns-border-color-gray"></div>
						</div>
						<span class="floor-left-nav ns-text-color-black">热卖</span>
						<div class="floor-title-right">
							<div class="floor-title-left-second ns-border-color-gray"></div>
						</div>
					</div>
					<a class="assemble-title-right" href="<?php echo __URL('http://t.huaqi86.com/index.php/wap/goods/lists'); ?>">更多&nbsp;&gt;</a>
				</div>
				<section class="members-goods-pic ns-border-color-gray">
					<ul>
						<?php if(is_array($hot_goods_list) || $hot_goods_list instanceof \think\Collection || $hot_goods_list instanceof \think\Paginator): if( count($hot_goods_list)==0 ) : echo "" ;else: foreach($hot_goods_list as $k=>$list): ?>
						<li class="gooditem">
							<div class="imgs">
								<a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>">
									<img class="lazy" src="<?php echo __IMG($default_goods_img); ?>" data-original="<?php echo __IMG($list['pic_cover_mid']); ?>" >
								</a>
							</div>
							<div class="info">
								<p class="goods-title">
									<a class="ns-text-color-black" href="<?php echo __URL('http://t.huaqi86.com/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>"><?php echo $list['goods_name']; ?></a>
								</p>
								<div class="goods-info">
									<span class="goods-price ns-text-color">
										<?php if(in_array(($list['point_exchange_type']), explode(',',"0,2"))): ?>
										<em>￥<?php echo $list['promotion_price']; ?></em>
										<?php else: if($list['point_exchange_type'] == 1 && $list['promotion_price'] > 0): ?>
												<em>￥<?php echo $list['promotion_price']; ?>+<?php echo $list['point_exchange']; ?>积分</em>
											<?php else: ?>
												<em><?php echo $list['point_exchange']; ?>积分</em>
											<?php endif; endif; ?>
									</span>
									<div class="add_cart" onclick="window.location.href='<?php echo __URL('http://t.huaqi86.com/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>'">
										<img src="/template/wap/default/public/img/index/add_cart.png" />
									</div>
								</div>
							</div>
						</li>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</section>
			</div>
			<?php endif; 
            $block_list = api("System.Goods.goodsCategoryBlockWap");
            $block_list = $block_list['data'];
             ?>
            <!-- 楼层版块 -->
            <?php if(is_array($block_list['data']) || $block_list['data'] instanceof \think\Collection || $block_list['data'] instanceof \think\Paginator): if( count($block_list['data'])==0 ) : echo "" ;else: foreach($block_list['data'] as $key=>$class): if(!(empty($class['goods_list']) || (($class['goods_list'] instanceof \think\Collection || $class['goods_list'] instanceof \think\Paginator ) && $class['goods_list']->isEmpty()))): ?>
            <div class="floor">
            	<?php if($class['img']): ?>
             	<div><img src="<?php echo __IMG($class['img']); ?>" /></div>
             	<?php endif; if($class['recommend_name']): ?>
                <div class="category-name">
                    <div class="floor-list-title">
	                        <div class="floor-title-left">
	                            <div class="floor-title-left-second ns-border-color-gray"></div>
	                        </div>
	                        <span class="floor-left-nav ns-text-color-black"><a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap/goods/lists'); ?>"><?php echo $class['recommend_name']; ?></a></span>
	                        <div class="floor-title-right">
	                            <div class="floor-title-left-second ns-border-color-gray"></div>
	                        </div>                       
                    </div>                
                </div>
                <?php endif; ?>
                <section class="members-goods-pic ns-border-color-gray">
                    <ul>
                        <?php if(is_array($class['goods_list']) || $class['goods_list'] instanceof \think\Collection || $class['goods_list'] instanceof \think\Paginator): if( count($class['goods_list'])==0 ) : echo "" ;else: foreach($class['goods_list'] as $k=>$list): ?>
                        <li class="gooditem">
                            <div class="imgs">
                                <a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>">
                                    <img class="lazy" src="<?php echo __IMG($default_goods_img); ?>" data-original="<?php echo __IMG($list['pic_cover_small']); ?>" >
                                </a>
                            </div>
                            <div class="info">
                                <p class="goods-title">
                                    <a class="ns-text-color-black" href="<?php echo __URL('http://t.huaqi86.com/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>"><?php echo $list['goods_name']; ?></a>
                                </p>
                                <div class="goods-info">
	                                <span class="goods-price ns-text-color">
	                                    <?php if(in_array(($list['point_exchange_type']), explode(',',"0,2"))): ?>
	                                    <em>￥<?php echo $list['promotion_price']; ?></em>
	                                    <?php else: if($list['point_exchange_type'] == 1 && $list['promotion_price'] > 0): ?>
	                                            <em>￥<?php echo $list['promotion_price']; ?>+<?php echo $list['point_exchange']; ?>积分</em>
	                                        <?php else: ?>
	                                            <em><?php echo $list['point_exchange']; ?>积分</em>
	                                        <?php endif; endif; ?>
	                                </span>
                                	<div class="add_cart" onclick="window.location.href='<?php echo __URL('http://t.huaqi86.com/index.php/wap/goods/detail?goods_id='.$list['goods_id']); ?>'">
										<img src="/template/wap/default/public/img/index/add_cart.png" />
									</div>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </section>
            </div>
            <?php endif; endforeach; endif; else: echo "" ;endif; endif; elseif($vo['tag']=='cube'): if($vo['isVisible']): 
                $magiccube = api("System.Config.wapHomeMagicCube");
                $magiccube = $magiccube['data'];
             if(!(empty($magiccube) || (($magiccube instanceof \think\Collection || $magiccube instanceof \think\Paginator ) && $magiccube->isEmpty()))): ?>
            <!-- 首页魔方 -->
            <div class="magiccube-warp">
                <div class="box">
                    <?php if(count($magiccube) == 1): ?>
                        <!-- 一行一个 -->
                        <div class="layout-one">
                            <div class="item" style="width: 100%;height: 100%;">
                                <?php if(is_url($magiccube[0]['url'])): ?>
                                    <a href="<?php echo $magiccube[0]['url']; ?>"  target="_blank">
                                <?php else: ?>
                                    <a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap'.$magiccube[0]['url']); ?>"  target="_blank">
                                <?php endif; ?>
                                    <img src="<?php echo __IMG($magiccube[0]['imgPath']); ?>">
                                </a>
                            </div>
                        </div>
                    <?php elseif(count($magiccube) == 2): ?>
                        <!-- 一行两个 -->
                        <div class="layout-two">
                            <?php $__FOR_START_1842004667__=0;$__FOR_END_1842004667__=2;for($i=$__FOR_START_1842004667__;$i < $__FOR_END_1842004667__;$i+=1){ ?>
                            <div class="item">
                                <?php if(is_url($magiccube[$i]['url'])): ?>
                                    <a href="<?php echo $magiccube[$i]['url']; ?>"  target="_blank">
                                <?php else: ?>
                                    <a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap'.$magiccube[$i]['url']); ?>"  target="_blank">
                                <?php endif; ?>
                                    <img src="<?php echo __IMG($magiccube[$i]['imgPath']); ?>">
                                </a>
                            </div>
                            <?php } ?>
                        </div>
                    <?php elseif(count($magiccube) == 3): ?>
                        <!-- 一左两右 -->
                        <div class="layout-three">
                            <div class="left">
                                <div class="item">
                                    <?php if(is_url($magiccube[0]['url'])): ?>
                                        <a href="<?php echo $magiccube[0]['url']; ?>"  target="_blank">
                                    <?php else: ?>
                                        <a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap'.$magiccube[0]['url']); ?>"  target="_blank">
                                    <?php endif; ?>
                                        <img src="<?php echo __IMG($magiccube[0]['imgPath']); ?>">
                                    </a>
                                </div>
                            </div>
                            <div class="right">
                                <?php $__FOR_START_1873165881__=1;$__FOR_END_1873165881__=3;for($i=$__FOR_START_1873165881__;$i < $__FOR_END_1873165881__;$i+=1){ ?>
                                <div class="item">
                                    <?php if(is_url($magiccube[$i]['url'])): ?>
                                        <a href="<?php echo $magiccube[$i]['url']; ?>"  target="_blank">
                                    <?php else: ?>
                                        <a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap'.$magiccube[$i]['url']); ?>"  target="_blank">
                                    <?php endif; ?>
                                        <img src="<?php echo __IMG($magiccube[$i]['imgPath']); ?>">
                                    </a>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php elseif(count($magiccube) == 4): ?>
                        <!-- 一左三右 -->
                        <div class="layout-four">
                            <div class="left">
                                <div class="item">
                                    <?php if(is_url($magiccube[0]['url'])): ?>
                                        <a href="<?php echo $magiccube[0]['url']; ?>"  target="_blank">
                                    <?php else: ?>
                                        <a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap'.$magiccube[0]['url']); ?>"  target="_blank">
                                    <?php endif; ?>
                                        <img src="<?php echo __IMG($magiccube[0]['imgPath']); ?>">
                                    </a>
                                </div>
                            </div>
                            <div class="right">
                                <div class="top">
                                    <div class="item">
                                        <?php if(is_url($magiccube[1]['url'])): ?>
                                            <a href="<?php echo $magiccube[1]['url']; ?>"  target="_blank">
                                        <?php else: ?>
                                            <a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap'.$magiccube[1]['url']); ?>"  target="_blank">
                                        <?php endif; ?>
                                            <img src="<?php echo __IMG($magiccube[1]['imgPath']); ?>">
                                        </a>
                                    </div>
                                </div>
                                <div class="buttom">
                                    <?php $__FOR_START_660143434__=2;$__FOR_END_660143434__=4;for($i=$__FOR_START_660143434__;$i < $__FOR_END_660143434__;$i+=1){ ?>
                                    <div class="item">
                                        <?php if(is_url($magiccube[$i]['url'])): ?>
                                            <a href="<?php echo $magiccube[$i]['url']; ?>"  target="_blank">
                                        <?php else: ?>
                                            <a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap'.$magiccube[$i]['url']); ?>"  target="_blank">
                                        <?php endif; ?>
                                            <img src="<?php echo __IMG($magiccube[$i]['imgPath']); ?>">
                                        </a>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; endif; endif; endforeach; endif; else: echo "" ;endif; ?>
</div>

<div class="foot-nav">
	<?php if(empty($uid) || (($uid instanceof \think\Collection || $uid instanceof \think\Paginator ) && $uid->isEmpty())): ?>
	<a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap/login/index'); ?>" class="ns-border-color-gray-shade-10 ns-text-color-gray"><?php echo lang("login"); ?></a>
	<a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap/login/register'); ?>" class="ns-border-color-gray-shade-10 ns-text-color-gray"><?php echo lang("register"); ?></a>
	<?php endif; ?>
	<a href="javascript:;" onclick="locationShop();" class="ns-border-color-gray-shade-10 ns-text-color-gray"><?php echo lang("pc_version"); ?></a>
	<a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap/member/index'); ?>" class="ns-border-color-gray-shade-10 ns-text-color-gray"><?php echo lang("member_member_center"); ?></a>
	<a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap/help/index'); ?>" class="ns-text-color-gray"><?php echo lang('shop_help_center'); ?></a>
</div>

<div class="ns-copyright">
<?php 
    $copyright = api('System.Config.copyRight');
    $copyright = $copyright['data'];
 if($copyright['is_load'] > 0): if(!(empty($copyright['bottom_info']['copyright_logo']) || (($copyright['bottom_info']['copyright_logo'] instanceof \think\Collection || $copyright['bottom_info']['copyright_logo'] instanceof \think\Paginator ) && $copyright['bottom_info']['copyright_logo']->isEmpty()))): ?>
        <img src="<?php echo __IMG($copyright['bottom_info']['copyright_logo']); ?>">
    <?php else: ?>
        <img src="/template/wap/default/public/img/logo_copy.png">
    <?php endif; if(!(empty($copyright['bottom_info']['copyright_companyname']) || (($copyright['bottom_info']['copyright_companyname'] instanceof \think\Collection || $copyright['bottom_info']['copyright_companyname'] instanceof \think\Paginator ) && $copyright['bottom_info']['copyright_companyname']->isEmpty()))): ?>
        <a href="<?php echo $copyright['bottom_info']['copyright_link']; ?>" target="_blank" class="ns-text-color-gray"><?php echo $copyright['bottom_info']['copyright_companyname']; ?></a>
    <?php else: ?>
        <a href="http://www.niushop.com.cn" target="_blank" class="ns-text-color-gray">山西牛酷信息科技有限公司&nbsp;提供技术支持</a>
    <?php endif; else: ?>
    <img src="/template/wap/default/public/img/logo_copy.png">
    <a href="http://www.niushop.com.cn" target="_blank" class="ns-text-color-gray">山西牛酷信息科技有限公司&nbsp;提供技术支持</a>
<?php endif; ?>
</div>




	<!--所需数据-->
	
	<!--头部、面包屑-->
	
	<!--//受模板限时，当前模块引入整体头部，改变-->
	
	<!--商品活动-->
	
	<!--商品标题、名称、描述-->
	
	<!--价格-->
	
	<!--单品活动-->

	<!--销量评价-->

	<!--商家服务-->

	<!--商品属性-->

	<!--面板右侧，看了又看，推荐商品等-->

	<!--商品详情、商品属性、评价、咨询-->
	
	<!--中部左侧，推荐商品-->
	
	<!--操作，立即购买/加入购物车-->
	
	<!--当前选中商品信息-->

	<!--商品规格-->

	<!--商品活动弹框形式-->
	
	<!--商品分享-->




<?php 
	$data = api('System.Config.bottomNav');
	$nav_list = $data['data'];
	$nav_width = 100/count($nav_list['template_data']);
	$method = strtolower($controller.'/'.$action);
	$url_index_str = __URL('http://t.huaqi86.com/index.php/wap/index');

	//获取购物车数量
	$cart_count = api("System.Goods.cartCount");
	$cart_count = $cart_count['data'];
 if(strpos($nav_list['showPage'], $method) !== false): ?>
<div class="bottom-menu">
<?php else: ?>
<div class="bottom-menu" style="display: none">
<?php endif; ?>
	<ul>

		<?php foreach($nav_list['template_data'] as $k => $v): ?>
		<li style="width:<?php echo $nav_width; ?>%">
			<a href="<?php echo $v['href']; ?>" class="ns-text-color-black">
				<?php if((strpos($v['href'], 'goods/cart') !== false) && $cart_count > 0): ?>
					<span class="bottom-cart-num ns-bg-color"><?php echo $cart_count<100?$cart_count : '99+'; ?></span>
				<?php endif; if((strpos($v['href'], $method) !== false) || ($v['href'] == $url_index_str && $method == 'index/index')): ?>
				<div id="bottom_home">
					<img src="<?php echo __IMG($v['img_src_hover']); ?>" data-hover-src="<?php echo __IMG($v['img_src']); ?>">
				</div>
				<!--color:<?php echo $v['color_hover']; ?>-->
				<span data-hover-color="<?php echo $v['color']; ?>" <?php if($v['color_hover']): ?>style="color:<?php echo $v['color_hover']; ?>"<?php else: ?>class="ns-text-color"<?php endif; ?> ><?php echo $v['menu_name']; ?></span>
				<?php else: ?>
				<div id="bottom_home">
					<img src="<?php echo __IMG($v['img_src']); ?>" data-hover-src="<?php echo __IMG($v['img_src_hover']); ?>">
				</div>
				<!--style="color:<?php echo $v['color']; ?>"-->
				<span data-hover-color="<?php echo $v['color_hover']; ?>"><?php echo $v['menu_name']; ?></span>
				<?php endif; ?>
			</a>
		</li>
		<?php endforeach; ?>
	</ul>
</div>
<div></div>

<input type="hidden" id="niushop_rewrite_model" value="<?php echo rewrite_model(); ?>">
<input type="hidden" id="niushop_url_model" value="<?php echo url_model(); ?>">
<input type="hidden" value="<?php echo $uid; ?>" id="uid"/>
<input type="hidden" id="hidden_shop_name" value="<?php echo $web_info['title']; ?>">
<input type="hidden" id="appId" value="<?php echo $signPackage['appId']; ?>">
<input type="hidden" id="jsTimesTamp" value="<?php echo $signPackage['jsTimesTamp']; ?>">
<input type="hidden" id="jsNonceStr"  value="<?php echo $signPackage['jsNonceStr']; ?>">
<input type="hidden" id="jsSignature" value="<?php echo $signPackage['jsSignature']; ?>">

<script src="/template/wap/default/public/js/jquery.liMarquee.js"></script>
<script>
var lang_index = {
	activity_over : "<?php echo lang('activity_over'); ?>",
	days : "<?php echo lang('days'); ?>"
};
</script>
<script src="/template/wap/default/public/js/index.js"></script>

<?php echo $web_info['third_count']; ?>
</body>
</html>