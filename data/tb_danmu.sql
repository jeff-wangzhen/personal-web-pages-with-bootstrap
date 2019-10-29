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

 Date: 29/06/2018 23:09:23
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tb_danmu
-- ----------------------------
DROP TABLE IF EXISTS `tb_danmu`;
CREATE TABLE `tb_danmu`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `message` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `datetime` datetime(0) DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `likenum` int(1) DEFAULT 0,
  `dislikenum` int(1) DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
