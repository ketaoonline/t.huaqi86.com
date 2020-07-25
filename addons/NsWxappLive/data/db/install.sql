
SET NAMES 'utf8';

CREATE TABLE
IF NOT EXISTS `ns_wxapp_live_user` (
	`id` INT (10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
	`uid` INT (10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '对应ns_member的uid',
	`wechat_id` VARCHAR (50) NOT NULL DEFAULT '' COMMENT '微信号',
	`true_name` VARCHAR (50) NOT NULL DEFAULT '' COMMENT '用户的真实姓名',
	`identity_card` VARCHAR (32) NOT NULL DEFAULT '' COMMENT '用户的身份证号',
	`identity_card_back` VARCHAR (255) NOT NULL DEFAULT '' COMMENT '身份证反面',
	`identity_card_front` VARCHAR (255) NOT NULL DEFAULT '' COMMENT '身份证正面',
	`mobile` VARCHAR (11) NOT NULL COMMENT '手机号',
	`status` TINYINT (1) NOT NULL DEFAULT 0 COMMENT '状态：1-申请中，2-申请通过，3-申请拒绝，4-封禁',
	`refuse_reason` VARCHAR (255) NOT NULL DEFAULT '' COMMENT '拒绝或者封禁原因',
	`create_time` INT (11) DEFAULT 0 COMMENT '创建日期',
	`modify_time` INT (11) DEFAULT 0 COMMENT '修改日期',
	PRIMARY KEY (`id`)
) ENGINE = INNODB AUTO_INCREMENT = 1 CHARSET = utf8 COMMENT = '主播表';

CREATE TABLE
IF NOT EXISTS `ns_wxapp_live_apply` (
	`id` INT (10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
	`uid` INT (10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '对应ns_member的uid',
	`live_uid` INT (10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '对应ns_wxapp_live_user的id',
	`room_name` VARCHAR (50) NOT NULL DEFAULT '' COMMENT '直播间名称',
	`room_desc` VARCHAR (255) NOT NULL DEFAULT '' COMMENT '直播间介绍',
	`category_id` INT (10) UNSIGNED NOT NULL COMMENT '商品一级分类id',
	`start_time` INT (11) DEFAULT 0 COMMENT '开播时间',
	`cover_img` VARCHAR (255) NOT NULL DEFAULT '' COMMENT '封面图片',
	`share_img` VARCHAR (255) NOT NULL DEFAULT '' COMMENT '分享卡片图片',
	`goods_ids` VARCHAR (255) DEFAULT '' COMMENT '直播商品id',
	`status` TINYINT (1) NOT NULL DEFAULT 1 COMMENT '状态：1申请中，2-申请通过，3-申请拒绝',
	`refuse_reason` VARCHAR (255) NOT NULL DEFAULT '' COMMENT ' 拒绝原因',
	`create_time` INT (11) DEFAULT 0 COMMENT '创建日期',
	`modify_time` INT (11) DEFAULT 0 COMMENT '修改日期',
	PRIMARY KEY (`id`)
) ENGINE = INNODB AUTO_INCREMENT = 1 CHARSET = utf8 COMMENT = '直播申请表';

CREATE TABLE
IF NOT EXISTS `ns_wxapp_live_room` (
	`id` INT (10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
	`room_id` INT (10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '房间 id',
	`name` VARCHAR (50) NOT NULL DEFAULT '' COMMENT '直播间名称',
	`anchor_name` VARCHAR (50) NOT NULL DEFAULT '' COMMENT '主播名',
    `anchor_img` varchar(255) NOT NULL DEFAULT '' COMMENT '博主头像',
	`start_time` INT (11) NOT NULL DEFAULT 0 COMMENT '开播时间',
	`end_time` INT (11) NOT NULL DEFAULT 0 COMMENT '直播计划结束时间',
	`cover_img` VARCHAR (255) NOT NULL DEFAULT '' COMMENT '封面图片 url',
	`share_img` VARCHAR (255) NOT NULL DEFAULT '' COMMENT '分享图片 url',
	`goods` TEXT COMMENT '商品列表',
	`live_status` TINYINT (3) NOT NULL DEFAULT 0 COMMENT '直播状态 101: 直播中, 102: 未开始, 103: 已结束, 104: 禁播, 105: 暂停中, 106: 异常, 107: 已过期',
	`has_play_backs` TINYINT (3) NOT NULL DEFAULT 0 COMMENT '是否有直播回放0-无 1-有',
	`play_back_expire` int(11) NOT NULL DEFAULT 0 COMMENT '回放过期时间',
	`is_top` TINYINT (1) UNSIGNED ZEROFILL NOT NULL DEFAULT '0' COMMENT '是否顶置',
	`is_recommend` TINYINT (1) UNSIGNED ZEROFILL NOT NULL DEFAULT '0' COMMENT '是否推荐',
	`is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示0-影藏 1显示',
	PRIMARY KEY (`id`)
) ENGINE = INNODB AUTO_INCREMENT = 1 CHARSET = utf8 COMMENT = '直播间列表';
CREATE TABLE
IF NOT EXISTS `ns_wxapp_live_room_play_back` (
	`id` INT (10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
	`room_id` INT (10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '房间 id',
	`expire_time` INT (11) NOT NULL DEFAULT 0 COMMENT '回放视频 url 过期时间',
	`create_time` INT (11) NOT NULL DEFAULT 0 COMMENT '回放视频创建时间',
	`media_url` VARCHAR (255) NOT NULL DEFAULT '' COMMENT '回放视频',
	PRIMARY KEY (`id`)
) ENGINE = INNODB AUTO_INCREMENT = 1 CHARSET = utf8 COMMENT = '直播间回放';