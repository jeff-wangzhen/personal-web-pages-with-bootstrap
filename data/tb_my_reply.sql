/*
 Navicat Premium Data Transfer

 Source Server         : 大宇
 Source Server Type    : MySQL
 Source Server Version : 50611
 Source Host           : ftp1.dxdc.net:3306
 Source Schema         : a0912161003

 Target Server Type    : MySQL
 Target Server Version : 50611
 File Encoding         : 65001

 Date: 18/06/2018 14:05:10
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tb_my_reply
-- ----------------------------
DROP TABLE IF EXISTS `tb_my_reply`;
CREATE TABLE `tb_my_reply`  (
  `id` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `replyid` int(11) DEFAULT NULL,
  `author` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `truename` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `messages` varchar(2550) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `createtime` datetime(0) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_my_reply
-- ----------------------------
INSERT INTO `tb_my_reply` VALUES (00000000001, 2, '王振', NULL, '这里有回复功能。', '2018-01-07 23:12:57');
INSERT INTO `tb_my_reply` VALUES (00000000002, 2, '王振', NULL, '不过比留言简洁多了，不能设置匿名，不能显示头像，不能删除。', '2018-01-07 23:13:21');
INSERT INTO `tb_my_reply` VALUES (00000000003, 2, '王振', NULL, '回复王振：幸好还有回复的回复。', '2018-01-07 23:13:39');
INSERT INTO `tb_my_reply` VALUES (00000000004, 2, '王振', NULL, '这条消息只能展开才能看到。', '2018-01-07 23:13:53');
INSERT INTO `tb_my_reply` VALUES (00000000005, 2, '王振', NULL, '回复王振：但是展开不能收回。', '2018-01-07 23:25:38');
INSERT INTO `tb_my_reply` VALUES (00000000006, 2, '游客', NULL, '回复王振：niubi', '2018-01-13 03:19:18');
INSERT INTO `tb_my_reply` VALUES (00000000007, 4, 'qaz123', NULL, '123', '2018-01-22 12:18:57');
INSERT INTO `tb_my_reply` VALUES (00000000008, 18, '游客', NULL, '速度补救……', '2018-01-22 13:17:36');
INSERT INTO `tb_my_reply` VALUES (00000000009, 21, '游客', NULL, '只匹配了安卓的，其他的……', '2018-01-22 13:49:32');
INSERT INTO `tb_my_reply` VALUES (00000000010, 33, '游客', NULL, '/<s?[/]?s?script.?>/i', '2018-01-22 19:44:31');
INSERT INTO `tb_my_reply` VALUES (00000000011, 38, '游客', NULL, '<div>', '2018-01-23 14:42:32');
INSERT INTO `tb_my_reply` VALUES (00000000012, 45, '游客', NULL, '的非官方的', '2018-03-14 21:40:17');
INSERT INTO `tb_my_reply` VALUES (00000000013, 1, '王振', NULL, '今天新加了点赞功能。', '2018-05-30 17:18:08');
INSERT INTO `tb_my_reply` VALUES (00000000014, 1, '王振', NULL, '右键菜单功能前后弄了五六天，一开始还是从http://www.codeweblog.com/js%e5%ae%9e%e7%8e%b0%e5%ae%8c%e5%85%a8%e8%87%aa%e5%ae%9a%e4%b9%89%e5%8f%af%e5%b8%a6%e5%a4%9a%e7%ba%a7%e7%9b%ae%e5%bd%95%e7%9a%84%e7%bd%91%e9%a1%b5%e9%bc%a0%e6%a0%87%e5%8f%b3%e9%94%ae%e8%8f%9c%e5%8d%95/复制的，但是感觉显示隐藏逻辑不对，改了许久。', '2018-06-08 17:24:09');
INSERT INTO `tb_my_reply` VALUES (00000000015, 1, '王振', NULL, '其中包括：鼠标移出子菜单时子菜单马上隐藏，不妥；要修改为正常菜单：移出不消失，悬停在其他菜单项上时兄弟菜单子菜单要隐藏，点击页面全隐藏，点击有子菜单的项目菜单不能消失，等等，伤透了脑筋。', '2018-06-09 14:06:23');
INSERT INTO `tb_my_reply` VALUES (00000000016, 2, '王振', NULL, '回复王振：增加了收回功能，其实很简单，反正是slideToggle()函数。', '2018-06-09 17:55:04');
INSERT INTO `tb_my_reply` VALUES (00000000017, 32, '游客', NULL, '多谢告知……', '2018-01-22 18:48:37');
INSERT INTO `tb_my_reply` VALUES (00000000018, 1, '王振', NULL, '前些日子给弹幕增加了点赞功能，不限次。但是似乎在手机上点不出那个div来。', '2018-06-09 22:01:44');
INSERT INTO `tb_my_reply` VALUES (00000000019, 1, '王振', NULL, '今天改变了鼠标指针样式。', '2018-06-10 16:31:22');
INSERT INTO `tb_my_reply` VALUES (00000000020, 2, '王振', NULL, '回复王振：今天改成了slideDown，slideUp，并且从js创建div改成隐藏div，js控制显示隐藏和value值。', '2018-06-11 17:20:39');
INSERT INTO `tb_my_reply` VALUES (00000000021, 8, '王振', NULL, '改成响应式网站，又何止耗时两周！', '2018-06-11 17:24:59');
INSERT INTO `tb_my_reply` VALUES (00000000023, 1, '王振', NULL, '今天调整css样式，使自己的样式与bootstrap重合最少。', '2018-06-17 13:33:33');
INSERT INTO `tb_my_reply` VALUES (00000000024, 1, '王振', NULL, '今天增加了搜索框，并且优化了php代码逻辑，时至今日，身心俱疲，才已尽矣。尚有不足，唯待日后增长见识了。', '2018-06-18 14:03:22');

SET FOREIGN_KEY_CHECKS = 1;
