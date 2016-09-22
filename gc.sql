/*
SQLyog Ultimate v8.32 
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
  `PartNum` int(11) unsigned DEFAULT NULL COMMENT '目前参与人数',
  PRIMARY KEY (`ActiveID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='活动主表';

/*Data for the table `zy_active_main` */

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='渠道_接口';

/*Data for the table `zy_channel_api` */

/*Table structure for table `zy_channel_main` */

DROP TABLE IF EXISTS `zy_channel_main`;

CREATE TABLE `zy_channel_main` (
  `ChannelID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '渠道ID',
  `ChannelName` varchar(50) DEFAULT NULL COMMENT '渠道名称',
  `AddTime` int(11) unsigned DEFAULT NULL COMMENT '渠道添加时间',
  `ActiveNum` int(5) unsigned DEFAULT NULL COMMENT '渠道对应活动数',
  `ActiveTime` int(11) unsigned DEFAULT NULL COMMENT '活动最近活跃时间',
  `ApiNum` int(5) unsigned DEFAULT NULL COMMENT '渠道接口数',
  `ApiUpdateTime` int(11) unsigned DEFAULT NULL COMMENT '接口最近更新时间',
  `Remark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`ChannelID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='渠道主表';

/*Data for the table `zy_channel_main` */

/*Table structure for table `zy_game_api` */

DROP TABLE IF EXISTS `zy_game_api`;

CREATE TABLE `zy_game_api` (
  `ApiId` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '接口ID',
  `ApiName` varchar(150) DEFAULT NULL COMMENT '接口名称',
  `ApiSign` varchar(150) DEFAULT NULL COMMENT '接口调用标记',
  `RoomID` int(11) unsigned DEFAULT NULL COMMENT '游戏库ID',
  `UseNum` int(11) unsigned DEFAULT NULL COMMENT '调用次数',
  `UseTime` int(11) unsigned DEFAULT NULL COMMENT '最近调用时间',
  `VrIP` varchar(15) DEFAULT NULL COMMENT '鉴权IP',
  `Vrkey` varchar(32) DEFAULT NULL COMMENT '通讯密钥',
  PRIMARY KEY (`ApiId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='游戏_接口';

/*Data for the table `zy_game_api` */

/*Table structure for table `zy_game_reg_basetable` */

DROP TABLE IF EXISTS `zy_game_reg_basetable`;

CREATE TABLE `zy_game_reg_basetable` (
  `RepID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '表ID',
  `RoomID` int(11) unsigned DEFAULT NULL COMMENT '游戏库ID',
  `BaseName` varchar(50) DEFAULT NULL COMMENT '表名称',
  `BaseTable` varchar(255) DEFAULT NULL COMMENT '该款游戏复用所需母数据表',
  `UID` int(11) unsigned DEFAULT NULL COMMENT '最近更新系统用户',
  `UpdateTime` int(11) unsigned DEFAULT NULL COMMENT '最近更新时间',
  `Remark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`RepID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='游戏复用资源注册表';

/*Data for the table `zy_game_reg_basetable` */

/*Table structure for table `zy_game_room` */

DROP TABLE IF EXISTS `zy_game_room`;

CREATE TABLE `zy_game_room` (
  `RoomID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '游戏库ID',
  `GameName` varchar(50) DEFAULT NULL COMMENT '游戏名称',
  `GameType` tinyint(1) DEFAULT '0' COMMENT '游戏类型',
  `GameResume` text COMMENT '游戏介绍',
  `ScreenImages` varchar(255) DEFAULT NULL COMMENT '游戏截图',
  `UID` int(11) unsigned DEFAULT NULL COMMENT '最近更新用户',
  `UpdateTime` int(11) unsigned DEFAULT NULL COMMENT '最近更新时间',
  `Version` varchar(20) DEFAULT NULL COMMENT '最新游戏版本',
  `ActiveUseNum` int(11) unsigned DEFAULT NULL COMMENT '活动使用总数',
  `VistNum` int(11) unsigned DEFAULT NULL COMMENT '游戏被访问总数',
  `Status` tinyint(1) DEFAULT '0' COMMENT '状态(0测试,1开放,2停用,3维护中)',
  `Remark` varchar(255) DEFAULT NULL COMMENT '游戏备注',
  PRIMARY KEY (`RoomID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='游戏库';

/*Data for the table `zy_game_room` */

/*Table structure for table `zy_sys_group` */

DROP TABLE IF EXISTS `zy_sys_group`;

CREATE TABLE `zy_sys_group` (
  `GroupID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色ID',
  `GroupName` varchar(50) DEFAULT NULL COMMENT '角色名称',
  `UID` int(11) unsigned DEFAULT NULL COMMENT '最近更新用户',
  `UpdateTime` int(11) unsigned DEFAULT NULL COMMENT '最近更新时间',
  PRIMARY KEY (`GroupID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统管理_角色';

/*Data for the table `zy_sys_group` */

/*Table structure for table `zy_sys_manager` */

DROP TABLE IF EXISTS `zy_sys_manager`;

CREATE TABLE `zy_sys_manager` (
  `UID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理用户UID',
  `Username` varchar(50) DEFAULT NULL COMMENT '用户名',
  `TrueName` varchar(50) DEFAULT NULL COMMENT '姓名',
  `GroupID` int(11) unsigned DEFAULT NULL COMMENT '所属角色',
  `Tel` varchar(15) DEFAULT NULL COMMENT '联系电话',
  `Email` varchar(150) DEFAULT NULL COMMENT 'Email',
  `LoginTime` int(11) DEFAULT NULL COMMENT '最近登录时间',
  `Remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `CanChannel` varchar(255) DEFAULT NULL COMMENT '可管理的渠道(渠道ID1,...)',
  PRIMARY KEY (`UID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统管理_系统用户';

/*Data for the table `zy_sys_manager` */

/*Table structure for table `zy_sys_privicy` */

DROP TABLE IF EXISTS `zy_sys_privicy`;

CREATE TABLE `zy_sys_privicy` (
  `Pid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限ID',
  `Pname` varchar(50) DEFAULT NULL COMMENT '权限名称',
  `Psign` varchar(50) DEFAULT NULL COMMENT '权限标记',
  `Status` tinyint(1) DEFAULT '0' COMMENT '开放状态',
  PRIMARY KEY (`Pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统管理_权限分配';

/*Data for the table `zy_sys_privicy` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
