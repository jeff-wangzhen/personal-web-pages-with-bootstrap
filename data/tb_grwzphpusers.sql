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

 Date: 17/06/2018 17:37:52
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tb_grwzphpusers
-- ----------------------------
DROP TABLE IF EXISTS `tb_grwzphpusers`;
CREATE TABLE `tb_grwzphpusers`  (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET gb2312 COLLATE gb2312_chinese_ci DEFAULT NULL,
  `userpwd` varchar(50) CHARACTER SET gb2312 COLLATE gb2312_chinese_ci DEFAULT NULL,
  `portrait` varchar(255) CHARACTER SET gb2312 COLLATE gb2312_chinese_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 248 CHARACTER SET = gb2312 COLLATE = gb2312_chinese_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_grwzphpusers
-- ----------------------------
INSERT INTO `tb_grwzphpusers` VALUES (1, '\r\nwangzhen', '332', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (221, 'fdgfdgfg', 'ffffff', '1515401018943.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (222, 'rtrtrtretr', 'tttttt', '1515401063015.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (2, '王振', 'wz', 'myself.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (223, 'qaz123', 'qaz123', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (224, 'cx', 'sd', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (225, 'df', 'fd', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (226, 'df', 'fd', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (227, 'dsf', '43', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (228, 'dsf', '43', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (229, 'sdfd', 'f', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (230, 'sdfd', 'f', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (231, '1', '2', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (232, '1', '2', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (233, 'sdfdsfsdfsdf', 'dfdfdfd', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (234, 'ererererer', 'dddddd', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (235, '23', '3', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (236, 'redfgdfgdf', 'ffffff', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (237, 'redfgdfgdf', 'ffffff', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (238, 'redfgdfgdf', 'ffffff', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (239, 'redfgdfgdf', 'ffffff', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (240, 'redfgdfgdf', 'ffffff', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (241, 'redfgdfgdf', 'ffffff', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (242, 'ffdgfdgfd', 'ffffff', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (243, 'ghgjhgjhgjhg', 'hhhhhh', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (244, 'fdgdfggfdgf', 'ffffff', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (245, 'dsfdsfsd', 'dddddd', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (246, 'qweeqwewq', 'q11111', 'client1.jpg');
INSERT INTO `tb_grwzphpusers` VALUES (247, 'werwerere', 'wwwwww', 'client1.jpg');

SET FOREIGN_KEY_CHECKS = 1;
