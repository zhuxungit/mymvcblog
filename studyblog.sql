/*
Navicat MySQL Data Transfer

Source Server         : vtest
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : studyblog

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2017-05-05 19:44:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `article`
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `cid` int(10) unsigned NOT NULL COMMENT '分类ID（关联分类表）',
  `title` varchar(80) NOT NULL COMMENT '标题',
  `image` varchar(45) DEFAULT '' COMMENT '图片名称',
  `author` varchar(30) DEFAULT '匿名者' COMMENT '作者',
  `keywords` varchar(100) DEFAULT '' COMMENT '关键词',
  `description` varchar(200) DEFAULT '' COMMENT '描述',
  `content` text COMMENT '文章内容',
  `click` int(11) DEFAULT '100' COMMENT '点击量',
  `comment` int(11) DEFAULT '0' COMMENT '评论量',
  `zan` int(11) DEFAULT '88' COMMENT '赞',
  `isTuijian` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否推荐：1-是，0-否',
  `display` tinyint(3) unsigned DEFAULT '1' COMMENT '是否显示：1-是,0-否',
  `created_time` int(10) unsigned DEFAULT '0' COMMENT '创建于',
  `updated_time` int(10) unsigned DEFAULT '0' COMMENT '更新于',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('1', '1', 'php9', '', '匿名者', '', '', null, '100', '0', '88', '0', '1', '1493190120', '1493190120');
INSERT INTO `article` VALUES ('2', '1', 'php9_1', '', '匿名者', '', '', null, '100', '0', '88', '0', '1', '1493190120', '1493190120');
INSERT INTO `article` VALUES ('3', '1', 'php9_2', '', '匿名者', '', '', null, '100', '0', '88', '0', '1', '1493190120', '1493190120');
INSERT INTO `article` VALUES ('4', '5', 'php9_3', '', '匿名者', 'afdsf', 'asdf', 'asdf', '100', '0', '88', '0', '0', '1493190120', '1493190120');
INSERT INTO `article` VALUES ('9', '2', 'update', '', 'asdf', 'asdfa', 'asdf', 'asdf', '100', '0', '88', '0', '0', '0', '0');
INSERT INTO `article` VALUES ('8', '5', 'up', '', 'sadfas', 'asdfa', 'asdf', 'sadfsdaf', '100', '0', '88', '0', '0', '0', '0');
INSERT INTO `article` VALUES ('10', '9', 'iamge', '2017-04-28/5902b2580d0e35.56549148.jpg', 'asdf', 'asdf', 'asdf', 'asdf', '100', '0', '88', '0', '0', '0', '0');
INSERT INTO `article` VALUES ('11', '4', 'asdf', '', 'asdf', 'asdf', 'asdf', 'asdf', '100', '0', '88', '0', '0', '0', '0');
INSERT INTO `article` VALUES ('12', '4', '手动阀', '', 'sdf', 'dfsdf', 'sdfsd', '<p><span style=\"font-size:24px;\"><strong>sdfs</strong></span>  </p><div></div><p></p>', '100', '0', '88', '1', '0', '0', '0');
INSERT INTO `article` VALUES ('13', '4', 'sdgsd', '', '匿名者', 'sdfg', 'sdfg', 'sdf', '100', '0', '88', '0', '1', '0', '0');
INSERT INTO `article` VALUES ('14', '5', 'dsfg', '', '匿名者', 'dsfg', 'sdf', 'sdf', '100', '0', '88', '0', '1', '0', '0');
INSERT INTO `article` VALUES ('15', '2', 'sdfg', '', '匿名者', 'dsfg', 'sdfg', 'sdfg', '100', '0', '88', '0', '1', '0', '0');
INSERT INTO `article` VALUES ('16', '9', 'sadf', '', '匿名者', 'asdf', 'asdf', '<p>asdfasd</p><p><br /></p><p>&lt;script&gt;111&lt;/script&gt;</p>', '100', '0', '88', '0', '1', '0', '0');
INSERT INTO `article` VALUES ('19', '4', 'asdasaSD123', '', 'ASDF', 'ASDFAS', 'ASDF', '<p><strong>ASDFASDF</strong></p>', '100', '0', '88', '0', '0', '0', '0');
INSERT INTO `article` VALUES ('18', '2', 'adsf', '', '匿名者', 'asdf', 'asdf', '<p>asdf</p><p><br /></p><p>&lt;script&gt;alert(1)&lt;/script&gt;</p>', '100', '0', '88', '0', '1', '0', '0');
INSERT INTO `article` VALUES ('20', '5', 'ASDFAS', '', 'ASDFA', 'ASDFAS', 'ASDFAS', '<p><strong>ASDFAS &nbsp; &nbsp;&lt;script&gt;&lt;/script&gt;</strong></p><p><br/></p><p>&nbsp;</p><div></div><p></p>', '100', '0', '88', '0', '0', '0', '0');
INSERT INTO `article` VALUES ('21', '4', 'testpurify', '', 'sadf', 'asdf', 'asdf', '<p><strong>asdfa    </strong></p><div></div><p></p><p><br /></p><p><br /></p><p><br /></p><p><br /></p>', '100', '0', '88', '0', '0', '0', '0');
INSERT INTO `article` VALUES ('22', '13', 'purifu', '', 'asdf', 'asdf', 'adsf', '<p>adsfas&lt;script&gt;alert(1)&lt;/script&gt;</p>', '100', '0', '88', '1', '1', '0', '0');

-- ----------------------------
-- Table structure for `category`
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类主键id',
  `pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `name` varchar(45) NOT NULL COMMENT '分类名',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `created_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建于',
  `updated_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新于',
  `display` tinyint(3) unsigned DEFAULT '1' COMMENT '是否显示1显示0不显示',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='分类表';

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('1', '0', '编程', '0', '0', '0', '1');
INSERT INTO `category` VALUES ('2', '1', 'PHP新', '0', '0', '0', '1');
INSERT INTO `category` VALUES ('17', '2', '111', '37', '0', '0', '1');
INSERT INTO `category` VALUES ('4', '1', 'WEB前段', '0', '0', '0', '1');
INSERT INTO `category` VALUES ('5', '0', '文章', '0', '0', '0', '1');
INSERT INTO `category` VALUES ('14', '8', '琼瑶', '234', '0', '0', '1');
INSERT INTO `category` VALUES ('7', '5', '历史', '0', '0', '0', '1');
INSERT INTO `category` VALUES ('8', '5', '言情', '0', '0', '0', '0');
INSERT INTO `category` VALUES ('9', '13', 'test2', '567', '0', '0', '1');
INSERT INTO `category` VALUES ('10', '15', 'test3', '456', '0', '0', '1');
INSERT INTO `category` VALUES ('13', '4', 'php_1新', '345', '0', '0', '1');
INSERT INTO `category` VALUES ('15', '7', '战国', '456', '0', '0', '1');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(45) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `avatar` varchar(45) DEFAULT NULL COMMENT '头像',
  `login_count` int(10) unsigned DEFAULT '0' COMMENT '登录次数',
  `last_login_time` int(11) DEFAULT NULL COMMENT '上次登录时间',
  `last_login_ip` int(11) DEFAULT NULL COMMENT '上次登录IP',
  `is_admin` tinyint(4) DEFAULT '0' COMMENT '1代表是管理员0代表普通用户',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', '123', '302', '1493982916', '2130706433', '1');
INSERT INTO `user` VALUES ('13', 'test2', '21232f297a57a5a743894a0e4a801fc3', null, '1', '1493476030', '2130706433', '0');


drop table if exists comment;
create table comment(
id int unsigned primary key auto_increment  comment'评论ID',
aid int unsigned not null comment'文章ID',
pid int unsigned not null comment'父类id',
uid int unsigned not null comment'用户ID',
comment varchar(255) not null comment'评论内容',
created_time int unsigned default 0 not null comment'创建于',
updated_time int unsigned default 0 not null comment'更新于',
display tinyint unsigned default 1  not null comment'是否显示1显示0不显示'
)engine=myisam charset=utf8;
