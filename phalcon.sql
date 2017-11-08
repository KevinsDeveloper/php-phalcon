
/*Table structure for table `admin_auth_item` */

DROP TABLE IF EXISTS `admin_auth_item`;

CREATE TABLE `admin_auth_item` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `role_id` INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '角色ID',
  `menu_id` INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '菜单ID',
  `type` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0=菜单 1=动作',
  `url` VARCHAR(100) NOT NULL DEFAULT '' COMMENT 'URL',
  `updated_at` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COMMENT='管理员权限表';

/*Data for the table `admin_auth_item` */

INSERT  INTO `admin_auth_item`(`id`,`role_id`,`menu_id`,`type`,`url`,`updated_at`) VALUES (1,2,7,0,'/agents',0),(2,2,9,0,'/agents/index/index',0),(3,2,7,1,'/agents',0),(4,2,9,1,'/agents/index/index',0),(5,2,9,1,'/agents/index/edit',0),(6,2,9,1,'/agents/index/state',0),(7,2,9,1,'/agents/index/info',0),(8,2,9,1,'/agents/index/index',0),(9,2,9,1,'/agents/index/add',0);

/*Table structure for table `admin_auth_logs` */

DROP TABLE IF EXISTS `admin_auth_logs`;

CREATE TABLE `admin_auth_logs` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `role_id` INT(10) UNSIGNED NOT NULL COMMENT '角色ID',
  `user_id` INT(10) UNSIGNED NOT NULL COMMENT '管理员ID',
  `account` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '账号',
  `realname` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '姓名',
  `actionname` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '动作名称',
  `content` TEXT NOT NULL COMMENT '内容',
  `status` SMALLINT(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `account_user` (`account`,`user_id`)
) ENGINE=INNODB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COMMENT='管理员日志';

/*Data for the table `admin_auth_logs` */

INSERT  INTO `admin_auth_logs`(`id`,`role_id`,`user_id`,`account`,`realname`,`actionname`,`content`,`status`,`created_at`) VALUES (1,1,1,'admin','超级管理员','管理员-编辑','_url：/settings/admin/edit/，id：2，role_id：3，account：test01，password：，realname：测试，phone：13800138001，position：测试，status：1',1,1508566738),(7,1,1,'admin','超级管理员','代理设置\r-保存设置\r','_url:/agents/settings/save，setting:{\"red_packe\":\"0.2\",\"dis_ratio_z\":\"0.15\",\"dis_ratio_j\":\"0.05\",\"city_ratio_z\":\"0.2\",\"dis_tx_fr\":\"0.2\",\"city_tx_fr\":\"0\"}',1,1508567145),(8,1,1,'admin','超级管理员','代理列表\r-启用/禁用\r','_url:/agents/index/state，id:5，state:0',1,1508567152),(9,1,1,'admin','超级管理员','角色管理-删除','_url:/settings/role/delete，id:55',1,1508569498),(10,1,1,'admin','超级管理员','角色管理-删除','_url:/settings/role/delete，id:56',1,1508569502),(11,1,1,'admin','超级管理员','角色管理-删除','_url:/settings/role/delete，id:54',1,1508569504),(12,1,1,'admin','超级管理员','角色管理-删除','_url:/settings/role/delete，id:53',1,1508569507),(13,1,1,'admin','超级管理员','角色管理-编辑','_url:/settings/role/edit，id:10，pid:0，role_name:技术部，status:1',1,1508569511),(14,1,1,'admin','超级管理员','角色管理-编辑','_url:/settings/role/edit，id:10，pid:0，role_name:技术部，status:1',1,1508569512),(15,1,1,'admin','超级管理员','角色管理-编辑','_url:/settings/role/edit，id:10，pid:0，role_name:技术部，status:1',1,1508569512),(16,1,1,'admin','超级管理员','角色管理-编辑','_url:/settings/role/edit，id:10，pid:0，role_name:技术部，status:1',1,1508569512),(17,1,1,'admin','超级管理员','角色管理-编辑','_url:/settings/role/edit，id:10，pid:0，role_name:技术部，status:1',1,1508569512),(18,1,1,'admin','超级管理员','代理列表\r-添加\r','_url:/agents/index/add，thumb:{\"id_pic\":[\"\\/images\\/20171023\\/34e91214115.jpg\"],\"ht_pic\":[\"\\/images\\/20171023\\/07c6538d6c1.jpg\"],\"jf_pic\":[\"\\/images\\/20171023\\/58572888aa3.jpg\"]}，file:',1,1508721165),(19,1,1,'admin','超级管理员','代理列表\r-添加\r','_url:/agents/index/add，thumb:{\"id_pic\":[\"\\/images\\/20171023\\/34e91214115.jpg\"],\"ht_pic\":[\"\\/images\\/20171023\\/07c6538d6c1.jpg\"],\"jf_pic\":[\"\\/images\\/20171023\\/58572888aa3.jpg\"]}，file:',1,1508721170),(20,1,1,'admin','超级管理员','登录-成功','_url:/login/do，redirect:/，account:admin，captcha:20',1,1508722309),(21,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:2',1,1508722342),(22,1,1,'admin','超级管理员','登录--成功','_url:/login/out',1,1508722452),(23,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:73',1,1508722458),(24,1,1,'admin','超级管理员','角色管理--权限','_url:/settings/role/power，id:2',1,1508734804),(25,1,1,'admin','超级管理员','代理列表\r-添加\r','_url:/agents/index/add，thumb:{\"id_pic\":[\"\\/images\\/20171023\\/544c6d48424.jpg\"],\"ht_pic\":[\"\\/images\\/20171023\\/bf6094a02e5.jpg\"],\"jf_pic\":[\"\\/images\\/20171023\\/2c70fad75cc.jpg\"]}，file:',1,1508738539),(26,1,1,'admin','超级管理员','代理列表\r-添加\r','_url:/agents/index/add，thumb:{\"id_pic\":[\"\\/images\\/20171023\\/544c6d48424.jpg\"],\"ht_pic\":[\"\\/images\\/20171023\\/bf6094a02e5.jpg\"],\"jf_pic\":[\"\\/images\\/20171023\\/2c70fad75cc.jpg\"]}，file:',1,1508738553),(27,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:102',1,1508806257),(28,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:96',1,1508834165),(29,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:%2Fagents%2Fsettings%2Findex，account:admin，captcha:95',1,1508837899),(30,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:%2Fagents%2Findex%2Findex，account:admin，captcha:7',1,1508837920),(31,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:%2Fagents%2Findex%2Findex，account:admin，captcha:19',1,1508838066),(32,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:%2Fagents%2Findex%2Findex，account:admin，captcha:41',1,1508838172),(33,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:%2Fagents%2Findex%2Findex，account:admin，captcha:66',1,1508838210),(34,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:%2Fagents%2Fsettings%2Findex，account:admin，captcha:27',1,1508838364),(35,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:%2Fagents%2Findex%2Findex，account:admin，captcha:43',1,1508838386),(36,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:%2Fagents%2Findex%2Findex，account:admin，captcha:70',1,1508838435),(37,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:%2Fagents%2Findex%2Findex，account:admin，captcha:70',1,1508838492),(38,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:%2Fagents%2Findex%2Findex，account:admin，captcha:37',1,1508838533),(39,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:%2Fagents%2Findex%2Findex，account:admin，captcha:51',1,1508838561),(40,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:%2Fagents%2Findex%2Findex，account:admin，captcha:31',1,1508838647),(41,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:43',1,1508919442),(42,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:53',1,1508919446),(43,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:26',1,1508919451),(44,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:51',1,1508920004),(45,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:45',1,1508920047),(46,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:2',1,1508920074),(47,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:41',1,1508920467),(48,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:37',1,1508920541),(49,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:62',1,1508920800),(50,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:84',1,1508921154),(51,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:24',1,1508921414),(52,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:40',1,1508921466),(53,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:50',1,1508921491),(54,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:50',1,1508921545),(55,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:78',1,1508921759),(56,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:31',1,1508921791),(57,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:72',1,1508921869),(58,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:86',1,1508921919),(59,1,1,'admin','超级管理员','退出--成功','_url:/login/out',1,1508921995),(60,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:35',1,1508921999),(61,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:48',1,1508922006),(62,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:9',1,1508922252),(63,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:17',1,1508922327),(64,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:87',1,1508922502),(65,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:27',1,1508922541),(66,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:77',1,1508922547),(67,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:35',1,1508922564),(68,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:24',1,1508922738),(69,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:101',1,1508922749),(70,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:83',1,1508922825),(71,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:92',1,1508923041),(72,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:73',1,1508923063),(73,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:50',1,1508923093),(74,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:92',1,1508923114),(75,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:36',1,1508923187),(76,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:41',1,1508923439),(77,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:66',1,1508923486),(78,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:102',1,1508925003),(79,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:60',1,1508925132),(80,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:15',1,1508925156),(81,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:24',1,1508925784),(82,1,1,'admin','超级管理员','登录--成功','_url:/login/do，redirect:/，account:admin，captcha:60',1,1508986099);

/*Table structure for table `admin_auth_menu` */

DROP TABLE IF EXISTS `admin_auth_menu`;

CREATE TABLE `admin_auth_menu` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父级ID',
  `title` VARCHAR(60) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `url` VARCHAR(60) NOT NULL DEFAULT '' COMMENT '菜单URL',
  `module` VARCHAR(40) NOT NULL DEFAULT '' COMMENT '模块',
  `controller` VARCHAR(40) NOT NULL DEFAULT 'index' COMMENT '控制器',
  `action` VARCHAR(40) NOT NULL DEFAULT 'index' COMMENT '动作',
  `params` VARCHAR(60) NOT NULL DEFAULT '' COMMENT '参数',
  `icon` VARCHAR(40) NOT NULL DEFAULT 'fa' COMMENT '图标',
  `rank` SMALLINT(4) UNSIGNED DEFAULT '0' COMMENT '等级',
  `orderby` SMALLINT(4) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `status` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1=显示 0=不显示',
  `created_at` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COMMENT='管理员菜单表';

/*Data for the table `admin_auth_menu` */

INSERT  INTO `admin_auth_menu`(`id`,`pid`,`title`,`url`,`module`,`controller`,`action`,`params`,`icon`,`rank`,`orderby`,`status`,`created_at`,`updated_at`) VALUES (1,0,'系统设置','/settings','settings','#','#','','glyphicon glyphicon-cog',0,1,1,0,0),(2,1,'基本设置','/settings/config/index','settings','config','index','','fa',1,1,1,1472881588,0),(3,1,'菜单管理','/settings/menu/index','settings','menu','index','','fa',1,2,1,1472881588,0),(5,1,'管理员列表','/settings/admin/index','settings','admin','index','','fa',1,4,1,1478613146,0),(6,1,'角色管理','/settings/role/index','settings','role','index','','fa',1,3,1,1478672080,0),(7,0,'代理管理','/agents','agents','#','#','','fa fa-group',0,2,1,0,0),(8,7,'代理设置','/agents/settings/index','agents','settings','index','','fa',1,1,1,0,0),(9,7,'代理列表','/agents/index/index','agents','index','index','','fa',1,2,1,0,0),(10,1,'管理员日志','/settings/logs/index','settings','logs','index','','fa',1,6,1,0,0);

/*Table structure for table `admin_auth_role` */

DROP TABLE IF EXISTS `admin_auth_role`;

CREATE TABLE `admin_auth_role` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父级ID',
  `role_name` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '角色名称',
  `status` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1=可用 0=不可用',
  `created_at` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `tree_lt` INT(11) NOT NULL DEFAULT '0' COMMENT '左值',
  `tree_rt` INT(11) NOT NULL DEFAULT '1' COMMENT '右值',
  `tree_rank` INT(11) NOT NULL DEFAULT '0' COMMENT '树ID',
  `rank` SMALLINT(2) NOT NULL DEFAULT '0' COMMENT '树等级',
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COMMENT='管理员角色表';

/*Data for the table `admin_auth_role` */

INSERT  INTO `admin_auth_role`(`id`,`pid`,`role_name`,`status`,`created_at`,`updated_at`,`tree_lt`,`tree_rt`,`tree_rank`,`rank`) VALUES (1,0,'超级管理员',1,1506217435,0,0,1,1,0),(2,0,'市场部',1,1506217449,1508566775,0,1,2,0),(3,0,'财务部',1,1506217460,0,0,1,3,0),(4,0,'运营部',1,1507519105,0,0,3,4,0),(5,4,'产品',1,1507519126,1507796053,1,2,4,1),(10,0,'技术部',1,1508142079,1508569512,0,1,10,0);

/*Table structure for table `admin_auth_user` */

DROP TABLE IF EXISTS `admin_auth_user`;

CREATE TABLE `admin_auth_user` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `role_id` INT(10) UNSIGNED NOT NULL COMMENT '角色ID',
  `account` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '账号',
  `realname` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '姓名',
  `phone` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '联系电话',
  `position` VARCHAR(40) NOT NULL DEFAULT '' COMMENT '职位',
  `password` VARCHAR(64) NOT NULL COMMENT '密码',
  `password_token` VARCHAR(100) NOT NULL COMMENT 'token',
  `status` SMALLINT(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态',
  `login_at` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `created_at` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `tree_lt` INT(11) NOT NULL DEFAULT '0' COMMENT '左值',
  `tree_rt` INT(11) NOT NULL DEFAULT '1' COMMENT '右值',
  `tree_rank` INT(11) NOT NULL DEFAULT '0' COMMENT '树ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`)
) ENGINE=INNODB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='管理员表';

/*Data for the table `admin_auth_user` */

INSERT  INTO `admin_auth_user`(`id`,`role_id`,`account`,`realname`,`phone`,`position`,`password`,`password_token`,`status`,`login_at`,`created_at`,`updated_at`,`tree_lt`,`tree_rt`,`tree_rank`) VALUES (1,1,'admin','超级管理员','13800138001','超级管理员','DhnhbVSW8cVL6kae/JnsrfU7CW60qa+wUQlvmOYTNrd6KKpLgOFasQ==','9OxUBRkRkW9ABX81H54pR9jDPYwVHZOf',1,1508986099,1494212147,1508986099,0,1,0),(2,3,'test01','测试','13800138001','测试','puroS4HpSfhaq1FLmXiR2cjYQdp8PTDuxW6lFRqQwB3gpToCQ78=','A5BF93F7E9454E49D9E934FB3C74A6E3',1,1508738011,1508482480,1508738011,0,1,0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
