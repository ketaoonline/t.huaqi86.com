<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:37:"template/web/default/login/login.html";i:1577153700;s:57:"/www/wwwroot/t.huaqi86.com/template/web/default/base.html";i:1587364095;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta name="renderer" content="webkit" />
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge,chrome=1"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="renderer" content="webkit">
    <title><?php if($title_before != ''): ?><?php echo $title_before; ?>&nbsp;-&nbsp;<?php endif; ?><?php echo $title; if($seo_config['seo_title'] != ''): ?>&nbsp;-&nbsp;<?php echo $seo_config['seo_title']; endif; ?></title>
    
    <meta name="keywords" content="<?php echo $seo_config['seo_meta']; ?>" />
    <meta name="description" content="<?php echo $seo_config['seo_desc']; ?>"/>
    
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
    
<link type="text/css" rel="stylesheet" href="/template/web/default/public/css/login.css"/>

</head>
<body>

<div class="user-head-bg w1200">
    <div class="logo-box">
        <a class="self-adaption-block"href="<?php echo __URL('http://t.huaqi86.com/index.php'); ?>">
            <img class="self-adaption-img" src="<?php echo __IMG($web_info['logo']); ?>">
        </a>
        <span>欢迎登录</span>
    </div>
    <div class="reg">
        <span><?php echo lang('no_account'); ?>？</span>
        <a href="<?php echo __URL('http://t.huaqi86.com/index.php/login/register'); ?>" class="ns-text-color"><?php echo lang('register_immediately'); ?></a>
    </div>
</div>


<div class="ns-main w1200">
    
<?php 
    //轮播广告图
    $banner_list = api("System.Shop.advDetail",['ap_keyword'=> 'PC_LOGIN_SWIPER']);
    $banner_list = $banner_list['data'];
    
    //登录配置
    $login_info = api("System.Login.loginConfig");
    $login_info = $login_info['data'];
    
    //QQ配置
    $qq_info = $login_info['login_config']['qq_login_config'];
    
    //微信配置
    $wchat_info = $login_info['login_config']['wchat_login_config'];

    //验证配置
    $login_verify_code = $login_info['code_config']['value'];
 if(!(empty($banner_list) || (($banner_list instanceof \think\Collection || $banner_list instanceof \think\Paginator ) && $banner_list->isEmpty()))): ?>
<!-- 轮播 -->
<div class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <?php if(is_array($banner_list['advs']) || $banner_list['advs'] instanceof \think\Collection || $banner_list['advs'] instanceof \think\Paginator): if( count($banner_list['advs'])==0 ) : echo "" ;else: foreach($banner_list['advs'] as $k=>$vo): ?>
            <div class="item <?php if($k==0): ?>active<?php endif; ?>" style="background-color:<?php echo $vo['background']; ?>;">
                <?php if(is_url($vo['adv_url'])): ?>
                    <a href="<?php echo $vo['adv_url']; ?>" target="_blank">
                <?php else: ?>
                    <a href="<?php echo __URL('http://t.huaqi86.com/index.php'.$vo['adv_url']); ?>" target="_blank">
                <?php endif; ?>
                    <img src="<?php echo __IMG($vo['adv_image']); ?>">
                </a>
            </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
</div>
<?php endif; ?>
<div class="w1200">
    
    <div class="login-form">
        <div class="form-head"> 
            <?php if($login_info['login_config']['mobile_config']['is_use'] == 1): ?>
                <div class="tit ns-text-color" data-type="mobile"><?php echo lang('mobile_quick_login'); ?></div>
                <div class="tit" data-type="account"><?php echo lang('account_login'); ?></div>
            <?php else: ?>
                <div class="tit ns-text-color" data-type="account"><?php echo lang('account_login'); ?></div>
            <?php endif; ?>
        </div>
        <div class="type-box active">
            <div class="account login-type <?php if($login_info['login_config']['mobile_config']['is_use'] == 1): ?>hide<?php endif; ?>">
                <div class="input-control has-icon-left">
                    <input id="user_name" type="text" class="form-control ns-border-color-gray-shade-10" placeholder="<?php echo lang('cell_phone_number'); ?>/<?php echo lang('member_name'); ?>/<?php echo lang('mailbox'); ?>">
                    <label for="user_name" class="input-control-icon-left"><i class="icon icon-user"></i></label>
                </div>
                <div class="input-control has-icon-left">
                    <input autocomplete="off" id="password" type="password" class="form-control ns-border-color-gray-shade-10" placeholder="<?php echo lang('please_input_password'); ?>">
                    <label for="password" class="input-control-icon-left"><i class="icon icon-key"></i></label>
                </div>
                <?php if($login_verify_code['pc'] == 1): ?>
                <div class="input-control has-icon-left <?php if($login_verify_code['error_num'] > 0 && $login_verify_code['error_num'] > $login_verify_code['curr_err_num']): ?>hide<?php endif; ?>">
                    <input id="vertification" type="text" class="form-control ns-border-color-gray-shade-10 verification-code" placeholder="<?php echo lang('please_enter_verification_code'); ?>">
                    <img class="input-control-label-right text-success verifyimg" src="<?php echo __URL('http://t.huaqi86.com/index.php/captcha'); ?>" alt="captcha" onclick="this.src='<?php echo __URL('http://t.huaqi86.com/index.php/captcha?tag=1'); ?>'+'&send='+Math.random()" />
                </div>
                <?php endif; ?>
            </div>
            
            <?php if($login_info['login_config']['mobile_config']['is_use'] == 1): ?>
            <div class="mobile login-type">
                <div class="input-control">
                    <input name="mobile" type="text" class="form-control ns-border-color-gray-shade-10" placeholder="<?php echo lang('cell_phone_number'); ?>">
                </div>
                <?php if($login_verify_code['pc'] == 1): ?>
                <div class="input-control has-icon-left">
                    <input name="captcha" type="text" class="form-control ns-border-color-gray-shade-10 verification-code" placeholder="<?php echo lang('please_enter_verification_code'); ?>">
                    <img class="input-control-label-right text-success verifyimg" src="<?php echo __URL('http://t.huaqi86.com/index.php/captcha'); ?>" alt="captcha" onclick="this.src='<?php echo __URL('http://t.huaqi86.com/index.php/captcha?tag=1'); ?>'+'&send='+Math.random()" />
                </div>
                <?php endif; ?>
                <div class="input-control send-code">
                    <input name="dynamic_code" type="text" class="form-control ns-border-color-gray-shade-10" placeholder="短信校验码">
                    <button class="btn check-code-btn ns-text-color-gray" type="button" id="sendOutCode">获取短信校验码</button>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="forget-password">
                <a href="<?php echo __URL('http://t.huaqi86.com/index.php/login/find'); ?>"><?php echo lang('forgot_password'); ?>?</a>
            </div>
            <button class="btn btn-primary" type="button" id="btn_login"><?php echo lang('login'); ?></button>
            <?php if($qq_info['is_use'] != 0 || $wchat_info['is_use'] != 0): ?>
             <div class="coagent ns-border-color-gray ns-bg-color-gray-fadeout-60">
                <ul>
                    <li class="extra-r"><?php echo lang('use_cooperative_account'); ?><b></b></li>
                    <?php if($wchat_info['is_use'] == 1): ?>
                    <li>
                        <a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap/login/oauthlogin','type=WCHAT'); ?>" title="<?php echo lang('wechat_authorized_login'); ?>">
                            <span>微信</span>
                            <b class="weixin-icon"></b>
                        </a>
                    </li>
                    <?php endif; if($qq_info['is_use'] == 1): ?>
                    <li>
                        <a href="<?php echo __URL('http://t.huaqi86.com/index.php/wap/login/oauthlogin','type=QQLOGIN'); ?>" title="<?php echo lang('qq_account_login'); ?>">
                            <span>QQ</span>
                            <b></b>
                        </a>
                        <b></b>
                        <span class="line">|</span>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<input type="hidden" value="<?php echo $login_verify_code['error_num']; ?>" id="hide_error_num">
<input type="hidden" value="<?php echo $login_verify_code['pc']; ?>" id="hidden_verify_pc">

    
    
	
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

<?php if($default_client): ?>
<div class="go-mobile" onclick="locationWap()" id="go_mobile">
    <img src="/template/web/default/public/img/go_mobile.png"/>
</div>
<?php endif; ?>

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

<script>
var login_pre_url = "<?php echo $login_pre_url; ?>";
var lang_login = {
	enter_your_account_number : '<?php echo lang("enter_your_account_number"); ?>',
	please_input_pd : '<?php echo lang("please_input_password"); ?>',
	please_enter_verification_code : '<?php echo lang("please_enter_verification_code"); ?>',
    send_successfully : "<?php echo lang('send_successfully'); ?>",
    dynamic_error_code : "<?php echo lang('dynamic_error_code'); ?>",
    get_dynamic_code : "<?php echo lang('get_dynamic_code'); ?>",
    post_resend : "<?php echo lang('post_resend'); ?>",
    phone_number_cannot_empty : "<?php echo lang('phone_number_cannot_empty'); ?>",
    dynamic_code_cannot_be_empty : "<?php echo lang('dynamic_code_cannot_be_empty'); ?>",
    member_enter_correct_phone_format : "<?php echo lang('member_enter_correct_phone_format'); ?>",
    verification_code_cannot_be_null : "<?php echo lang('verification_code_cannot_be_null'); ?>"
};
</script>
<script type="text/javascript" src="/template/web/default/public/js/login.js"></script>

</body>
</html>