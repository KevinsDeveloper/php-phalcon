# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 120.25.84.17 (MySQL 5.6.21-log)
# Database: puningcom
# Generation Time: 2017-09-09 14:16:54 +0000
# ************************************************************
# 
# 

# Dump of table db_auth_item
# ------------------------------------------------------------
# 
DROP TABLE IF EXISTS `db_auth_item`;

CREATE TABLE `db_auth_item` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `role_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '角色ID',
  `menu_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '菜单ID',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0=菜单 1=动作',
  `url` varchar(100) NOT NULL DEFAULT '' COMMENT 'URL',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='管理员权限表';


# Dump of table db_auth_menu
# ------------------------------------------------------------
# 
DROP TABLE IF EXISTS `db_auth_menu`;

CREATE TABLE `db_auth_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `title` varchar(60) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `url` varchar(60) NOT NULL DEFAULT '' COMMENT '菜单URL',
  `module` varchar(40) NOT NULL DEFAULT '' COMMENT '模块',
  `controller` varchar(40) NOT NULL DEFAULT 'index' COMMENT '控制器',
  `action` varchar(40) NOT NULL DEFAULT 'index' COMMENT '动作',
  `params` varchar(60) NOT NULL DEFAULT '' COMMENT '参数',
  `icon` varchar(40) NOT NULL DEFAULT 'fa' COMMENT '图标',
  `rank` smallint(4) unsigned DEFAULT '0' COMMENT '等级',
  `orderby` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1=显示 0=不显示',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='管理员菜单表';


# Dump of table db_auth_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `db_auth_role`;

CREATE TABLE `db_auth_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `role_name` varchar(50) NOT NULL DEFAULT '' COMMENT '角色名称',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1=可用 0=不可用',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='管理员角色表';

LOCK TABLES `db_auth_role` WRITE;
/*!40000 ALTER TABLE `db_auth_role` DISABLE KEYS */;

INSERT INTO `db_auth_role` (`id`, `pid`, `role_name`, `status`, `created_at`) VALUES (1,0,'超级管理员',1,1494212147);

/*!40000 ALTER TABLE `db_auth_role` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table db_auth_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `db_auth_user`;

CREATE TABLE `db_auth_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `role_id` int(10) unsigned NOT NULL COMMENT '角色ID',
  `account` varchar(100) NOT NULL DEFAULT '' COMMENT '账号',
  `realname` varchar(100) NOT NULL DEFAULT '' COMMENT '姓名',
  `phone` varchar(20) NOT NULL DEFAULT '' COMMENT '联系电话',
  `position` varchar(40) NOT NULL DEFAULT '' COMMENT '职位',
  `password` varchar(64) NOT NULL COMMENT '密码',
  `password_token` varchar(100) NOT NULL COMMENT 'token',
  `status` smallint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `login_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='管理员表';

LOCK TABLES `db_auth_user` WRITE;
/*!40000 ALTER TABLE `db_auth_user` DISABLE KEYS */;

INSERT INTO `db_auth_user` (`id`, `role_id`, `account`, `realname`, `phone`, `position`, `password`, `password_token`, `status`, `login_at`, `created_at`, `updated_at`)
VALUES
	(1,1,'admin','超级管理员','13800138001','超级管理员','$2y$13$H1XfieYhzLKeAVDyzmWPT.q2ngw8KtgVebT2yp7J0A5YObQifTaxC','9OxUBRkRkW9ABX81H54pR9jDPYwVHZOf',1,1504704435,1494212147,1504750403);

/*!40000 ALTER TABLE `db_auth_user` ENABLE KEYS */;
UNLOCK TABLES;






