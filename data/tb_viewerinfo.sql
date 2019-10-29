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

 Date: 17/06/2018 17:40:37
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tb_viewerinfo
-- ----------------------------
DROP TABLE IF EXISTS `tb_viewerinfo`;
CREATE TABLE `tb_viewerinfo`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `HTTP_X_REAL_IP` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `HTTP_X_FORWARDED_FOR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `REMOTE_ADDR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `useragent` varchar(2550) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `browser` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `viewtime` datetime(0) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 157 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
