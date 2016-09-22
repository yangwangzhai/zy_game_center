/*
SQLyog v10.2 
MySQL - 5.5.40 : Database - zy_gamecenter
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`zy_gamecenter` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `zy_gamecenter`;

/*Table structure for table `zy_active_blacklist` */

DROP TABLE IF EXISTS `zy_active_blacklist`;

CREATE TABLE `zy_active_blacklist` (
  `ActiveBlackID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ActiveBlackID',
  `Openid` varchar(30) DEFAULT NULL COMMENT '微信用户的Openid',
  `Nickname` varchar(50) DEFAULT NULL COMMENT '微信用户昵称',
  `Remark` varchar(255) DEFAULT NULL COMMENT '备注(列黑原因)',
  `AddTime` int(11) DEFAULT NULL COMMENT '列入时间',
  `AddUid` int(11) DEFAULT NULL COMMENT '列入人id',
  `ReleaseTime` int(11) DEFAULT NULL COMMENT '解禁时间',
  `ReleaseUid` int(11) DEFAULT NULL COMMENT '解禁人id',
  `ChannelID` int(11) DEFAULT NULL COMMENT '来源渠道ID',
  `ActiveID` int(11) DEFAULT NULL COMMENT '来源活动ID',
  `GameID` int(11) DEFAULT NULL COMMENT '来源游戏ID',
  PRIMARY KEY (`ActiveBlackID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='活动_黑名单';

/*Data for the table `zy_active_blacklist` */

insert  into `zy_active_blacklist`(`ActiveBlackID`,`Openid`,`Nickname`,`Remark`,`AddTime`,`AddUid`,`ReleaseTime`,`ReleaseUid`,`ChannelID`,`ActiveID`,`GameID`) values (3,'123456fff','测试2','积分异常',1467621010,3,1467683370,4,1,2,1),(2,'123456','测试','游戏作弊',1467621010,1,NULL,NULL,1,2,1);

/*Table structure for table `zy_active_game` */

DROP TABLE IF EXISTS `zy_active_game`;

CREATE TABLE `zy_active_game` (
  `GameID` int(11) NOT NULL AUTO_INCREMENT COMMENT '游戏ID',
  `UseStatus` tinyint(1) NOT NULL DEFAULT '0' COMMENT '启用状态(0启用,1停用）',
  `ChannelID` int(11) DEFAULT NULL COMMENT '游戏所属渠道ID',
  `ActiveID` int(11) DEFAULT NULL COMMENT '游戏所属活动ID',
  `RoomID` int(11) DEFAULT NULL COMMENT '游戏库ID',
  `VistNum` int(11) DEFAULT NULL COMMENT '游戏访问次数',
  `VistTime` int(11) DEFAULT NULL COMMENT '游戏最近访问时间',
  PRIMARY KEY (`GameID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='活动_游戏';

/*Data for the table `zy_active_game` */

insert  into `zy_active_game`(`GameID`,`UseStatus`,`ChannelID`,`ActiveID`,`RoomID`,`VistNum`,`VistTime`) values (1,0,1,2,1,NULL,NULL);

/*Table structure for table `zy_active_main` */

DROP TABLE IF EXISTS `zy_active_main`;

CREATE TABLE `zy_active_main` (
  `ActiveID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '活动ID',
  `ActiveName` varchar(50) DEFAULT NULL COMMENT '活动名称',
  `Remark` varchar(255) DEFAULT NULL COMMENT '活动备注',
  `ChannelID` int(11) unsigned DEFAULT NULL COMMENT '渠道ID',
  `RoomID` int(11) unsigned DEFAULT NULL COMMENT '游戏库ID',
  `GameID` int(11) unsigned DEFAULT NULL COMMENT '活动所选择的游戏',
  `UID` int(11) unsigned DEFAULT NULL COMMENT '最近更新用户',
  `Uptime` int(11) unsigned DEFAULT NULL COMMENT '最近更新时间',
  `Status` tinyint(1) DEFAULT '0' COMMENT '活动状态(0未开始,1进行中,2已结束)',
  `PartNum` int(11) unsigned DEFAULT '0' COMMENT '目前参与人数',
  PRIMARY KEY (`ActiveID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='活动主表';

/*Data for the table `zy_active_main` */

insert  into `zy_active_main`(`ActiveID`,`ActiveName`,`Remark`,`ChannelID`,`RoomID`,`GameID`,`UID`,`Uptime`,`Status`,`PartNum`) values (2,'7.4我的大转盘','快乐游戏！！',2,2,NULL,3,1468550312,2,0);

/*Table structure for table `zy_channel_api` */

DROP TABLE IF EXISTS `zy_channel_api`;

CREATE TABLE `zy_channel_api` (
  `ChannelApiID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ChannelApiID',
  `ChannelID` int(11) unsigned DEFAULT NULL COMMENT 'Api所属渠道ID',
  `ApiName` varchar(50) DEFAULT NULL COMMENT '接口名称',
  `ApiSign` varchar(50) DEFAULT NULL COMMENT '接口标记',
  `ApiUrl` varchar(255) DEFAULT NULL COMMENT '接口地址',
  `Remark` text COMMENT '接口说明',
  `UID` int(11) unsigned DEFAULT NULL COMMENT '最近更新用户',
  `Uptime` int(11) unsigned DEFAULT NULL COMMENT '最近更新时间',
  `Status` tinyint(1) DEFAULT '1' COMMENT '接口状态(1启用,0停用)',
  PRIMARY KEY (`ChannelApiID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='渠道_接口';

/*Data for the table `zy_channel_api` */

insert  into `zy_channel_api`(`ChannelApiID`,`ChannelID`,`ApiName`,`ApiSign`,`ApiUrl`,`Remark`,`UID`,`Uptime`,`Status`) values (1,1,'获取用户信息接口','GetUserInfo','http://ip/xx.do','接口测试',1,1467602322,1);

/*Table structure for table `zy_channel_main` */

DROP TABLE IF EXISTS `zy_channel_main`;

CREATE TABLE `zy_channel_main` (
  `ChannelID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '渠道ID',
  `ChannelName` varchar(50) DEFAULT NULL COMMENT '渠道名称',
  `AddTime` int(11) unsigned DEFAULT NULL COMMENT '渠道添加时间',
  `ActiveNum` int(5) unsigned DEFAULT '0' COMMENT '渠道对应活动数',
  `ActiveTime` int(11) unsigned DEFAULT NULL COMMENT '活动最近活跃时间',
  `ApiNum` int(5) unsigned DEFAULT '0' COMMENT '渠道接口数',
  `ApiUpdateTime` int(11) unsigned DEFAULT NULL COMMENT '接口最近更新时间',
  `Remark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`ChannelID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='渠道主表';

/*Data for the table `zy_channel_main` */

insert  into `zy_channel_main`(`ChannelID`,`ChannelName`,`AddTime`,`ActiveNum`,`ActiveTime`,`ApiNum`,`ApiUpdateTime`,`Remark`) values (1,'真龙服务号',1467596216,0,NULL,0,NULL,'南宁号'),(2,'海韵之友',1467596512,0,NULL,0,NULL,'');

/*Table structure for table `zy_game_api` */

DROP TABLE IF EXISTS `zy_game_api`;

CREATE TABLE `zy_game_api` (
  `ApiId` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '接口ID',
  `ApiName` varchar(150) DEFAULT NULL COMMENT '接口名称',
  `ApiSign` varchar(150) DEFAULT NULL COMMENT '接口调用标记',
  `ApiUrl` varchar(255) DEFAULT NULL COMMENT '接口地址',
  `RoomID` int(11) unsigned DEFAULT NULL COMMENT '游戏库ID',
  `UseNum` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '调用次数',
  `UseTime` int(11) unsigned DEFAULT NULL COMMENT '最近调用时间',
  `VrIP` varchar(15) DEFAULT NULL COMMENT '鉴权IP',
  `Vrkey` varchar(32) DEFAULT NULL COMMENT '通讯密钥',
  `ApiRemark` text COMMENT '接口说明',
  `Status` tinyint(1) DEFAULT '0' COMMENT '0:停用1:启用',
  `UpdateTime` int(11) unsigned DEFAULT '0' COMMENT '更新时间',
  `UID` int(11) unsigned DEFAULT NULL COMMENT 'UID',
  PRIMARY KEY (`ApiId`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='游戏_接口';

/*Data for the table `zy_game_api` */

insert  into `zy_game_api`(`ApiId`,`ApiName`,`ApiSign`,`ApiUrl`,`RoomID`,`UseNum`,`UseTime`,`VrIP`,`Vrkey`,`ApiRemark`,`Status`,`UpdateTime`,`UID`) values (1,'获取成绩排行','getrank','http://ip/xx.do',1,0,NULL,'192.168.1.178','oisjaisdasdas','游戏接口测试游戏接口测试游戏接口测试游戏接口测试游戏接口测试游戏接口测试游戏接口测试游戏接口测试游戏接口测试游戏接口测试游戏接口测试',1,1467686253,1),(2,'获取每局输赢数据','getwindata','http://ip/xx.do',2,0,NULL,'192.168.1.1','asdjaisjdiajsdad','获取每局输赢数据',1,1467788386,1);

/*Table structure for table `zy_game_reg_basetable` */

DROP TABLE IF EXISTS `zy_game_reg_basetable`;

CREATE TABLE `zy_game_reg_basetable` (
  `RepID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '表ID',
  `RoomID` int(11) unsigned DEFAULT NULL COMMENT '游戏库ID',
  `BaseName` varchar(50) DEFAULT NULL COMMENT '表名称',
  `BaseTable` varchar(50) DEFAULT NULL COMMENT '该款游戏复用所需母数据表',
  `UID` int(11) unsigned DEFAULT NULL COMMENT '最近更新系统用户',
  `UpdateTime` int(11) unsigned DEFAULT NULL COMMENT '最近更新时间',
  `Remark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`RepID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='游戏复用资源注册表';

/*Data for the table `zy_game_reg_basetable` */

insert  into `zy_game_reg_basetable`(`RepID`,`RoomID`,`BaseName`,`BaseTable`,`UID`,`UpdateTime`,`Remark`) values (1,1,'游戏UI资源表','zy_gamelist_resources',4,1467706028,'游戏资源表'),(2,1,'游戏规则表','zy_gamelist_rule',4,1467706021,'游戏规则表'),(3,2,'游戏UI资源表','zy_gamelist_resources',1,1467788006,'游戏UI资源表'),(4,2,'游戏规则','zy_gamelist_rule',3,1468544587,'');

/*Table structure for table `zy_game_reg_nav` */

DROP TABLE IF EXISTS `zy_game_reg_nav`;

CREATE TABLE `zy_game_reg_nav` (
  `NavID` int(11) NOT NULL AUTO_INCREMENT COMMENT '导航ID',
  `RoomID` int(11) DEFAULT NULL COMMENT '游戏库ID',
  `NavSign` varchar(50) DEFAULT NULL COMMENT '导航标记',
  `NavName` varchar(50) DEFAULT NULL COMMENT '导航名称',
  `NavUrl` varchar(255) DEFAULT NULL COMMENT '导航地址',
  `UID` int(11) DEFAULT NULL COMMENT '最近更新系统用户',
  `UpdateTime` int(11) DEFAULT NULL COMMENT '最近更新时间',
  PRIMARY KEY (`NavID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='游戏功能导航注册表';

/*Data for the table `zy_game_reg_nav` */

insert  into `zy_game_reg_nav`(`NavID`,`RoomID`,`NavSign`,`NavName`,`NavUrl`,`UID`,`UpdateTime`) values (1,2,'A_users','玩家管理','?Gameroom=a&c=users',3,1468546768);

/*Table structure for table `zy_game_room` */

DROP TABLE IF EXISTS `zy_game_room`;

CREATE TABLE `zy_game_room` (
  `RoomID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '游戏库ID',
  `GameName` varchar(50) DEFAULT NULL COMMENT '游戏名称',
  `GameType` tinyint(1) DEFAULT '0' COMMENT '游戏类型',
  `GameResume` text COMMENT '游戏介绍',
  `ScreenImages` text COMMENT '游戏截图',
  `UID` int(11) unsigned DEFAULT NULL COMMENT '最近更新用户',
  `UpdateTime` int(11) unsigned DEFAULT NULL COMMENT '最近更新时间',
  `Version` varchar(20) DEFAULT NULL COMMENT '最新游戏版本',
  `ActiveUseNum` int(11) unsigned DEFAULT '0' COMMENT '活动使用总数',
  `VistNum` int(11) unsigned DEFAULT '0' COMMENT '游戏被访问总数',
  `Status` tinyint(1) DEFAULT '0' COMMENT '状态(0测试,1开放,2停用,3维护中)',
  `Remark` varchar(255) DEFAULT NULL COMMENT '游戏备注',
  PRIMARY KEY (`RoomID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='游戏库';

/*Data for the table `zy_game_room` */

insert  into `zy_game_room`(`RoomID`,`GameName`,`GameType`,`GameResume`,`ScreenImages`,`UID`,`UpdateTime`,`Version`,`ActiveUseNum`,`VistNum`,`Status`,`Remark`) values (1,'游戏测试',0,'游戏测试游戏测试游戏测试游戏测试游戏测试游戏测试游戏测试游戏测试游戏测试游戏测试游戏测试游戏测试','uploads/file/20160704/20160704170818_71042.png|uploads/file/20160714/20160714171615_98283.jpg',1,1468490578,'V1.0',0,0,0,'游戏测试游戏测试游戏测试游戏测试游戏测试游戏测试游戏测试游戏测试游戏测试游戏测试'),(2,'牛奶大作战',2,'游戏2游戏2游戏2游戏2游戏2游戏2游戏2游戏2游戏2','uploads/file/20160714/20160714172108_95811.jpg',1,1468488073,'V1.2',0,0,0,'游戏2游戏2游戏2游戏2游戏2游戏2');

/*Table structure for table `zy_gamelist_more` */

DROP TABLE IF EXISTS `zy_gamelist_more`;

CREATE TABLE `zy_gamelist_more` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ChannelID` int(11) DEFAULT NULL COMMENT '所属渠道ID',
  `ActiveID` int(11) DEFAULT NULL COMMENT '所属活动ID',
  `GameID` int(11) DEFAULT NULL COMMENT '所属游戏ID',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='游戏A_更多相关表';

/*Data for the table `zy_gamelist_more` */

/*Table structure for table `zy_gamelist_record` */

DROP TABLE IF EXISTS `zy_gamelist_record`;

CREATE TABLE `zy_gamelist_record` (
  `RecordID` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录ID',
  `GameID` int(11) DEFAULT NULL COMMENT '游戏ID',
  `ChannelID` int(11) DEFAULT NULL COMMENT '游戏所属渠道ID',
  `ActiveID` int(11) DEFAULT NULL COMMENT '游戏所属活动ID',
  `Openid` varchar(30) DEFAULT NULL COMMENT '微信用户openid',
  `Nickname` varchar(50) DEFAULT NULL COMMENT '微信昵称',
  `Num` int(10) DEFAULT NULL COMMENT '游戏成绩',
  `AddTime` int(11) DEFAULT NULL COMMENT '记录时间',
  PRIMARY KEY (`RecordID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='游戏A_游戏记录';

/*Data for the table `zy_gamelist_record` */

/*Table structure for table `zy_gamelist_resources` */

DROP TABLE IF EXISTS `zy_gamelist_resources`;

CREATE TABLE `zy_gamelist_resources` (
  `ReID` int(11) NOT NULL AUTO_INCREMENT COMMENT '资源ID',
  `RoomID` int(11) unsigned DEFAULT NULL COMMENT '游戏库ID',
  `ReName` varchar(50) DEFAULT NULL COMMENT '资源名称',
  `ReSrc` varchar(255) DEFAULT NULL COMMENT '资源路径',
  `ReType` tinyint(1) NOT NULL DEFAULT '0' COMMENT '资源类型',
  `ReSize` varchar(10) DEFAULT NULL COMMENT '资源大小',
  `IsBase` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否母数据(0否,1是)',
  `ChannelID` int(11) DEFAULT NULL COMMENT '所属渠道ID',
  `ActiveID` int(11) DEFAULT NULL COMMENT '所属活动ID',
  `GameID` int(11) DEFAULT NULL COMMENT '所属游戏ID',
  `UID` int(11) DEFAULT NULL COMMENT '最近变更用户',
  `UpdateTime` int(11) DEFAULT NULL COMMENT '最近更新时间',
  PRIMARY KEY (`ReID`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COMMENT='游戏A_UI资源';

/*Data for the table `zy_gamelist_resources` */

insert  into `zy_gamelist_resources`(`ReID`,`RoomID`,`ReName`,`ReSrc`,`ReType`,`ReSize`,`IsBase`,`ChannelID`,`ActiveID`,`GameID`,`UID`,`UpdateTime`) values (1,1,'游戏背景图片','uploads/file/20160706/20160706112045_18838.jpg',0,'49.28 KB',1,NULL,NULL,NULL,1,1467776878),(2,2,'倒计时背景1','static/gameroom/milk/images/1.png',0,'8.59 KB',1,NULL,NULL,NULL,3,1468482670),(3,2,'倒计时背景2','static/gameroom/milk/images/2.png',0,'8.45 KB',1,NULL,NULL,NULL,3,1468483139),(4,2,'倒计时背景3','static/gameroom/milk/images/3.png',0,'7.06 KB',1,NULL,NULL,NULL,3,1468483167),(5,2,'倒计时背景4','static/gameroom/milk/images/4.png',0,'7.15 KB',1,NULL,NULL,NULL,3,1468483175),(6,2,'倒计时背景5','static/gameroom/milk/images/5.png',0,'7.72 KB',1,NULL,NULL,NULL,3,1468483182),(7,2,'活动介绍头部背景','static/gameroom/milk/images/about_title.png',0,'24.34 KB',1,NULL,NULL,NULL,3,1468483247),(8,2,'游戏页面背景','static/gameroom/milk/images/bg.jpg',0,'47.9 KB',1,NULL,NULL,NULL,3,1468483281),(9,2,'我的游戏页面背景','static/gameroom/milk/images/box_bg.png',0,'25.16 KB',1,NULL,NULL,NULL,3,1468483308),(10,2,'查看记录按钮背景','static/gameroom/milk/images/ckjl.png',0,'7.97 KB',1,NULL,NULL,NULL,3,1468483334),(11,2,'游戏时间倒计时背景','static/gameroom/milk/images/clock.png',0,'6.68 KB',1,NULL,NULL,NULL,3,1468483368),(12,2,'关闭按钮图标','static/gameroom/milk/images/close.png',0,'1.12 KB',1,NULL,NULL,NULL,3,1468483410),(13,2,'点击领奖按钮图标','static/gameroom/milk/images/djlj.png',0,'33.83 KB',1,NULL,NULL,NULL,3,1468483613),(14,2,'皇氏乳业公众号二维码','static/gameroom/milk/images/ewm.jpg',0,'29.06 KB',1,NULL,NULL,NULL,3,1468543843),(15,2,'游戏排行按钮图标','static/gameroom/milk/images/game_top.png',0,'8.47 KB',1,NULL,NULL,NULL,3,1468543867),(16,2,'手势图标','static/gameroom/milk/images/hand.png',0,'4.05 KB',1,NULL,NULL,NULL,3,1468543888),(17,2,'活动介绍按钮图标','static/gameroom/milk/images/hdsm.png',0,'8.4 KB',1,NULL,NULL,NULL,3,1468543907),(18,2,'我的成绩头部背景','static/gameroom/milk/images/list_title.png',0,'24.53 KB',1,NULL,NULL,NULL,3,1468543929),(19,2,'点击领奖按钮图标','static/gameroom/milk/images/ljjs.png',0,'10.2 KB',1,NULL,NULL,NULL,3,1468543948),(20,2,'皇氏乳业logo','static/gameroom/milk/images/logo.jpg',0,'15.89 KB',1,NULL,NULL,NULL,3,1468543968),(21,2,'领奖分店地址','static/gameroom/milk/images/milk_address.jpg',0,'65.4 KB',1,NULL,NULL,NULL,3,1468543987),(22,2,'牛奶盒装背景','static/gameroom/milk/images/nai.png',0,'16.18 KB',1,NULL,NULL,NULL,3,1468544011),(23,2,'喝奶数量背景','static/gameroom/milk/images/number.png',0,'6.39 KB',1,NULL,NULL,NULL,3,1468544028),(24,2,'再玩一次按钮','static/gameroom/milk/images/play_again.png',0,'1.95 KB',1,NULL,NULL,NULL,3,1468544048),(25,2,'喝奶动作1','static/gameroom/milk/images/ren1.png',0,'26.05 KB',1,NULL,NULL,NULL,3,1468544064),(26,2,'喝奶动作2','static/gameroom/milk/images/ren2.png',0,'25.64 KB',1,NULL,NULL,NULL,3,1468544082),(27,2,'开始游戏按钮图标','static/gameroom/milk/images/start.png',0,'20.01 KB',1,NULL,NULL,NULL,3,1468544102),(28,2,'开始游戏按钮图标','static/gameroom/milk/images/start_hover.png',0,'21.02 KB',1,NULL,NULL,NULL,3,1468544123),(29,2,'喝奶台背景','static/gameroom/milk/images/tai.jpg',0,'16.98 KB',1,NULL,NULL,NULL,3,1468544141),(30,2,'时间到背景','static/gameroom/milk/images/timeUp.png',0,'11.83 KB',1,NULL,NULL,NULL,3,1468544159),(31,2,'游戏主页头部背景','static/gameroom/milk/images/title.png',0,'81.61 KB',1,NULL,NULL,NULL,3,1468544177),(32,2,'排行榜按钮图标','static/gameroom/milk/images/top_btn.png',0,'1.92 KB',1,NULL,NULL,NULL,3,1468544212),(33,2,'游戏总排行头部背景','static/gameroom/milk/images/top_title.png',0,'38.69 KB',1,NULL,NULL,NULL,3,1468544233),(34,2,'toplist_bg.png','static/gameroom/milk/images/toplist_bg.png',0,'99 B',1,NULL,NULL,NULL,3,1468544252),(35,2,'向上箭头背景','static/gameroom/milk/images/up.png',0,'1.58 KB',1,NULL,NULL,NULL,3,1468544273),(36,2,'游戏规则按钮图标','static/gameroom/milk/images/yxgz.png',0,'7.75 KB',1,NULL,NULL,NULL,3,1468544292),(37,2,'游戏规则头部背景','static/gameroom/milk/images/yxgz_title.png',0,'24.12 KB',1,NULL,NULL,NULL,3,1468544309),(38,2,'中奖名单按钮','static/gameroom/milk/images/zjbtn.png',0,'20.04 KB',1,NULL,NULL,NULL,3,1468544326),(39,2,'中奖按钮图标','static/gameroom/milk/images/zjmd.png',0,'10.45 KB',1,NULL,NULL,NULL,3,1468544342),(40,2,'中奖列表头部背景','static/gameroom/milk/images/zjmd_title.png',0,'20.45 KB',1,NULL,NULL,NULL,3,1468544360);

/*Table structure for table `zy_gamelist_rule` */

DROP TABLE IF EXISTS `zy_gamelist_rule`;

CREATE TABLE `zy_gamelist_rule` (
  `RuleID` int(11) NOT NULL AUTO_INCREMENT COMMENT '规则ID',
  `RoomID` int(11) unsigned DEFAULT NULL COMMENT '游戏库ID',
  `RuleName` varchar(50) DEFAULT NULL COMMENT '规则名称',
  `RuleSign` varchar(50) DEFAULT NULL COMMENT '规则标记',
  `RuleSet` varchar(255) DEFAULT NULL COMMENT '游戏规则',
  `ChannelID` int(11) DEFAULT NULL COMMENT '规则所属渠道游戏ID',
  `ActiveID` int(11) DEFAULT NULL COMMENT '规则所属活动ID',
  `GameID` int(11) DEFAULT NULL COMMENT '游戏ID',
  `UID` int(11) DEFAULT NULL COMMENT '规则最近更新用户',
  `UpdateTime` int(11) DEFAULT NULL COMMENT '规则最近变更时间',
  `IsBase` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否母数据（0否,1是）',
  PRIMARY KEY (`RuleID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='游戏A_规则配置';

/*Data for the table `zy_gamelist_rule` */

insert  into `zy_gamelist_rule`(`RuleID`,`RoomID`,`RuleName`,`RuleSign`,`RuleSet`,`ChannelID`,`ActiveID`,`GameID`,`UID`,`UpdateTime`,`IsBase`) values (1,1,'允许最大分数值','Allow_max_num','350',NULL,NULL,NULL,1,1467711904,1);

/*Table structure for table `zy_gamelist_user` */

DROP TABLE IF EXISTS `zy_gamelist_user`;

CREATE TABLE `zy_gamelist_user` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT '玩家ID',
  `Openid` varchar(30) DEFAULT NULL COMMENT '微信用户penid',
  `Nickname` varchar(50) DEFAULT NULL COMMENT '微信昵称',
  `GameID` int(11) DEFAULT NULL COMMENT '游戏ID',
  `ChannelID` int(11) DEFAULT NULL COMMENT '玩家所属渠道ID',
  `ActiveID` int(11) DEFAULT NULL COMMENT '玩家所属活动ID',
  `Num` int(11) DEFAULT NULL COMMENT '游戏成绩',
  `UpdateTime` int(11) DEFAULT NULL COMMENT '最近活跃时间',
  `AddTime` int(11) DEFAULT NULL COMMENT '游戏参与时间',
  PRIMARY KEY (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='游戏A_(游戏/活动)玩家';

/*Data for the table `zy_gamelist_user` */

/*Table structure for table `zy_sys_group` */

DROP TABLE IF EXISTS `zy_sys_group`;

CREATE TABLE `zy_sys_group` (
  `GroupID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色ID',
  `GroupName` varchar(50) DEFAULT NULL COMMENT '角色名称',
  `UID` int(11) unsigned DEFAULT NULL COMMENT '最近更新用户',
  `UpdateTime` int(11) unsigned DEFAULT NULL COMMENT '最近更新时间',
  `Pids` varchar(255) DEFAULT NULL COMMENT '权限id(权限1,权限2,...)',
  PRIMARY KEY (`GroupID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='系统管理_角色';

/*Data for the table `zy_sys_group` */

insert  into `zy_sys_group`(`GroupID`,`GroupName`,`UID`,`UpdateTime`,`Pids`) values (1,'超级管理员',1,1467257082,'1,2,3,4,5,6,7,8,9,10'),(2,'开发人员',1,1467708877,'1,20,28,29,30,31,32,33,34,2,21,22,23,24,25,26,27,3,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19');

/*Table structure for table `zy_sys_manager` */

DROP TABLE IF EXISTS `zy_sys_manager`;

CREATE TABLE `zy_sys_manager` (
  `UID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理用户UID',
  `Username` varchar(50) DEFAULT NULL COMMENT '用户名',
  `TrueName` varchar(50) DEFAULT NULL COMMENT '姓名',
  `Password` varchar(32) DEFAULT NULL COMMENT '密码',
  `GroupID` int(11) unsigned DEFAULT NULL COMMENT '所属角色',
  `UserType` tinyint(1) unsigned DEFAULT '0' COMMENT '0系统，1渠道',
  `Tel` varchar(15) DEFAULT NULL COMMENT '联系电话',
  `Email` varchar(150) DEFAULT NULL COMMENT 'Email',
  `LoginTime` int(11) DEFAULT NULL COMMENT '最近登录时间',
  `Remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `CanChannel` varchar(255) DEFAULT NULL COMMENT '可管理的渠道(渠道ID1,...)',
  `Status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未锁定1:锁定',
  PRIMARY KEY (`UID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='系统管理_系统用户';

/*Data for the table `zy_sys_manager` */

insert  into `zy_sys_manager`(`UID`,`Username`,`TrueName`,`Password`,`GroupID`,`UserType`,`Tel`,`Email`,`LoginTime`,`Remark`,`CanChannel`,`Status`) values (1,'lkl','sss','2a0e6a8a3599c10631652f11d15f91d4',2,1,'12345678901','123@123.com',1468803015,'',NULL,0),(3,'wyb','','a5f8f94f064f1165cf5cdbc3ae7d4d3d',1,0,'','',1468802437,'','1,2',0),(4,'test','','2fed7d879e648c7663ae765cd775f299',2,0,'','',1467680916,'',NULL,0),(5,'admin','','6a5877ef60bf2ad0f6bc0193bf4c654c',1,0,'','',1468545817,'',NULL,0);

/*Table structure for table `zy_sys_privicy` */

DROP TABLE IF EXISTS `zy_sys_privicy`;

CREATE TABLE `zy_sys_privicy` (
  `Pid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限ID',
  `GroupID` int(11) unsigned DEFAULT NULL COMMENT '角色ID',
  `Pname` varchar(50) DEFAULT NULL COMMENT '权限名称',
  `Psign` varchar(50) DEFAULT NULL COMMENT '权限标记',
  `Status` tinyint(1) DEFAULT '0' COMMENT '开放状态',
  `UpdateTime` int(11) unsigned DEFAULT NULL COMMENT '最新更新时间',
  `ParentID` int(11) NOT NULL DEFAULT '0' COMMENT '父id',
  PRIMARY KEY (`Pid`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COMMENT='系统管理_权限分配';

/*Data for the table `zy_sys_privicy` */

insert  into `zy_sys_privicy`(`Pid`,`GroupID`,`Pname`,`Psign`,`Status`,`UpdateTime`,`ParentID`) values (7,NULL,'查看用户','Manager_view',0,1467279644,6),(8,NULL,'删除用户','Manager_del',0,1467278698,6),(9,NULL,'修改用户','Manager_update',0,1467278705,6),(10,NULL,'添加用户','Manager_add',0,1467278710,6),(1,1,'渠道管理','qdgl',0,1467273527,0),(2,1,'活动管理','hdgl',0,1467273527,0),(3,1,'游戏仓库','yxck',0,1467273527,0),(4,1,'安全控制','aqkz',0,1467273527,0),(5,NULL,'数据统计','sjtj',0,1467273527,0),(6,NULL,'系统管理','xtgl',0,1467273527,0),(11,NULL,'查看角色','Group_view',0,1467342730,6),(12,NULL,'删除角色','Group_del',0,1467342795,6),(13,NULL,'修改角色','Group_update',0,1467342830,6),(14,NULL,'添加角色','Group_add',0,1467342858,6),(15,NULL,'查看权限','Privicy_view',0,1467342943,6),(16,NULL,'删除权限','Privicy_del',0,1467342976,6),(17,NULL,'修改权限','Privicy_update',0,1467343005,6),(18,NULL,'添加权限','Privicy_add',0,1467343034,6),(19,NULL,'分配权限','Privicy_fenpei',0,1467343087,6),(20,NULL,'渠道列表','Channel_view',0,1467793779,1),(21,NULL,'活动列表','Active_list',0,1467596190,2),(22,NULL,'黑名单','Black_list',0,1467596207,2),(23,NULL,'添加活动','Active_add',0,1467600372,2),(24,NULL,'修改活动','Active_edit',0,1467600419,2),(25,NULL,'删除活动','Active_del',0,1467600406,2),(26,NULL,'删除黑名单','Black_del',0,1467682557,2),(27,NULL,'解禁黑名单','Black_release',0,1467682600,2),(28,NULL,'查看渠道接口','ChannelAPI_view',0,1467362888,1),(29,NULL,'添加渠道','Channel_add',0,1467363652,1),(30,NULL,'修改渠道','Channel_update',0,1467363683,1),(31,NULL,'删除渠道','Channel_del',0,1467363705,1),(32,NULL,'添加渠道接口','ChannelAPI_add',0,1467598032,1),(33,NULL,'修改渠道接口','ChannelAPI_update',0,1467598075,1),(34,NULL,'删除渠道接口','ChannelAPI_del',0,1467598102,1),(35,NULL,'查看游戏列表','GameRoom_view',0,1467619423,3),(36,NULL,'修改游戏列表','GameRoom_update',0,1467619466,3),(37,NULL,'删除游戏列表','GameRoom_del',0,1467619511,3),(38,NULL,'添加游戏列表','GameRoom_add',0,1467619542,3),(39,NULL,'查看功能导航','GameRegNav_view',0,1467680981,3),(40,NULL,'修改功能导航','GameRegNav_update',0,1467681010,3),(41,NULL,'删除功能导航','GameRegNav_del',0,1467681045,3),(42,NULL,'添加功能导航','GameRegNav_add',0,1467681074,3),(43,NULL,'查看游戏接口','GameAPI_view',0,1467682655,3),(44,NULL,'修改游戏接口','GameAPI_update',0,1467682682,3),(45,NULL,'删除游戏接口','GameAPI_del',0,1467682711,3),(46,NULL,'添加游戏接口','GameAPI_add',0,1467682728,3),(47,NULL,'查看复用资源','GameRegTable_view',0,1467703679,3),(48,NULL,'修改复用资源','GameRegTable_update',0,1467703718,3),(49,NULL,'删除复用资源','GameRegTable_del',0,1467703753,3),(50,NULL,'添加复用资源','GameRegTable_add',0,1467703791,3),(51,NULL,'母数据管理','BaseTable_view',0,1467708755,3),(52,NULL,'修改母数据','BaseTable_update',0,1467708804,3),(53,NULL,'删除母数据','BaseTable_del',0,1467708838,3),(54,NULL,'添加母数据','BaseTable_add',0,1467708860,3);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
