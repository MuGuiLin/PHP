/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : mu_piao

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-06-08 18:26:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `mu_leave_message`
-- ----------------------------
DROP TABLE IF EXISTS `mu_leave_message`;
CREATE TABLE `mu_leave_message` (
  `id` tinyint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '留言id',
  `title` varchar(125) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '留言标题',
  `type` tinyint(1) NOT NULL COMMENT '留言类型 1留言 2意见 3举报',
  `text` text CHARACTER SET utf8 NOT NULL COMMENT '留言内容',
  `time` datetime NOT NULL COMMENT '留言日期和时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of mu_leave_message
-- ----------------------------
INSERT INTO `mu_leave_message` VALUES ('1', '留言标题', '0', '这是我的留言内容！', '2016-06-08 18:23:56');
INSERT INTO `mu_leave_message` VALUES ('2', 'PHP留言板', '0', '高性能Linux服务器构建实战：运维监控、性能调优与集群应用(完整)', '2016-06-08 18:24:45');

-- ----------------------------
-- Table structure for `mu_users`
-- ----------------------------
DROP TABLE IF EXISTS `mu_users`;
CREATE TABLE `mu_users` (
  `user_id` int(24) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户唯一ID号',
  `user_name` varchar(32) NOT NULL COMMENT '用户名称',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '用户密码',
  `sex` tinyint(1) NOT NULL COMMENT '性别 1先生 2女士 3保密',
  `hobby` varchar(120) NOT NULL COMMENT '爱好',
  `email` varchar(64) NOT NULL DEFAULT '' COMMENT '用户邮箱',
  `age` tinyint(3) NOT NULL COMMENT '年龄',
  `home_phone` varchar(24) NOT NULL DEFAULT '' COMMENT '个人电话',
  `mboile_phone` varchar(24) NOT NULL DEFAULT '' COMMENT '家庭电话',
  `office_phone` varchar(24) NOT NULL DEFAULT '' COMMENT '办公电话',
  `family_address` varchar(256) NOT NULL DEFAULT '' COMMENT '家庭地址',
  `nowliving_address` varchar(256) NOT NULL DEFAULT '' COMMENT '现住地址',
  `qq` varchar(18) NOT NULL COMMENT 'QQ号码',
  `wx` varchar(128) NOT NULL DEFAULT '' COMMENT '微信账号',
  `msn` varchar(128) NOT NULL DEFAULT '' COMMENT 'MSN账号',
  `registration_date` datetime NOT NULL COMMENT '注册日期和时间',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mu_users
-- ----------------------------
INSERT INTO `mu_users` VALUES ('1', '小穆', 'e10adc3949ba59abbe56e057f20f883e', '1', '1,3,4,5', 'muguli2008@qq.com', '0', '18198353918', '', '', '', '中华人民共和国', '', '', '', '2016-06-08 18:19:31');
