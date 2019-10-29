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

 Date: 17/06/2018 17:39:24
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tb_messages
-- ----------------------------
DROP TABLE IF EXISTS `tb_messages`;
CREATE TABLE `tb_messages`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `messages` varchar(10000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `createtime` datetime(0) DEFAULT NULL,
  `agent` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `truename` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `likenum` int(1) UNSIGNED ZEROFILL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `name`(`author`) USING BTREE,
  CONSTRAINT `name` FOREIGN KEY (`author`) REFERENCES `tb_my_users` (`username`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 66 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tb_messages
-- ----------------------------
INSERT INTO `tb_messages` VALUES (1, '王振', '　　这是我模仿百度贴吧做的留言板。', '2018-01-07 23:01:03', 'QQ', 'gfuyhgfhghgf', 25);
INSERT INTO `tb_messages` VALUES (2, '王振', '　　留言框右上角有输入字数提示，这是模仿微博的。留言栏右下角浏览器获取功能是网上一个php函数写的，原本探测不出opera，查看用户代理标识后发现它使用chrome内核，用户代理字符串中没有opera字样，却有OPR字样，所以添加了这个判断。QQ浏览器标识也是我加的，但是360安全浏览器没办法，完全没有360字样。', '2018-01-07 23:05:16', 'QQ', 'gfuyhgfhghgf', 8);
INSERT INTO `tb_messages` VALUES (3, 'wangzhen', '　　如果你注册了账号，可以上传不大于9kb的jpg/png/gif头像。如果没有上传，会给一个默认头像，就像左边的一样。', '2018-01-07 23:19:55', 'Safari', '', 9);
INSERT INTO `tb_messages` VALUES (4, '王振', '　　登录之后可以选择匿名发表留言，最后会显示“游客”发表。也可以删除已发布的留言，但不能删除回复。', '2018-01-08 13:05:10', 'Opera', '', 7);
INSERT INTO `tb_messages` VALUES (5, '王振', '　　注册功能验证十分繁琐，失焦检测用户名是否合法、是否已经存在，失焦检测密码是否合法，并且检测确认密码是否已经输入了内容，如果有也调用确认密码检测函数。确认密码检测函数需要边输入边检查，是否长度已经到达密码长度，到则提示一致或不一致。提交表单时也需要验证，防止提交空表单，且要限制重复提交。登录界面则只判断用户名或密码是否为空，是则不提交。然后一次性检测是否与数据库中匹配，不匹配则返回登录界面。', '2018-01-08 13:18:19', 'Opera', '', 1);
INSERT INTO `tb_messages` VALUES (6, '王振', '　　点击回复会临时创建div和表单，本来按道理应该页面一次性加载并隐藏，点击时再显现。但是考虑到服务器压力，故此将此任务交给客户端。jq临时创建，若点击“收起回复”则隐藏，再次点击再出现。这也是考虑到效率问题。这是把标志放在数组中实现的。', '2018-01-08 13:29:32', 'Firefox', '', 2);
INSERT INTO `tb_messages` VALUES (7, '王振', '　　发表留言之后会自动跳转到最后一页。回复成功之后会返回当前页。跳转到指定页功能需要获取总页数和当前页，所以需要php和js代码混写，所以把js代码写在了本页面源代码中，而不是放在专门的js文件里。这里并没有像上面那样寻找父节点，是考虑到代码的简洁性。所以只能放在主页面。说实话，我也不知道到底怎样才好。', '2018-01-08 13:39:06', 'Firefox', '', 4);
INSERT INTO `tb_messages` VALUES (8, '王振', '　　虽然功能不多，但是毕竟是我的一番心血，耗时两周，绕了许多弯子。这都是学业不精的教训。', '2018-01-08 16:22:49', 'Firefox', '', 5);
INSERT INTO `tb_messages` VALUES (9, '王振', '　　有许多明显的缺点无法补救，限于作者的才力，那是无可如何的了。', '2018-01-08 16:36:33', 'Chrome', '', 7);
INSERT INTO `tb_messages` VALUES (10, '王振', '　　如果你有什么意见或者建议，希望写信告诉我kill370354@qq.com。我把每一位访客都当成是朋友,朋友们的指教和关怀，自然永远是欢迎的。', '2018-01-08 16:41:19', 'Chrome', '', 4);
INSERT INTO `tb_messages` VALUES (12, '游客', 'test', '2018-01-13 15:11:40', 'Chrome', '', 0);
INSERT INTO `tb_messages` VALUES (13, '游客', 'first\r\nsecond', '2018-01-13 15:12:19', 'Chrome', '', 0);
INSERT INTO `tb_messages` VALUES (15, 'qaz123', 'yuyuyuyuyu', '2018-01-22 12:18:05', 'Chrome', 'qaz123', 0);
INSERT INTO `tb_messages` VALUES (16, '游客', '2', '2018-01-22 12:20:52', 'Chrome', '', 0);
INSERT INTO `tb_messages` VALUES (17, '游客', '我试试手机浏览器行不行', '2018-01-22 13:10:58', 'Chrome', '', 0);
INSERT INTO `tb_messages` VALUES (18, '游客', '再试一次。', '2018-01-22 13:13:45', '0', '', 0);
INSERT INTO `tb_messages` VALUES (19, '游客', '现在总可以了吧', '2018-01-22 13:35:39', 'Chrome', '', 0);
INSERT INTO `tb_messages` VALUES (20, '游客', '清缓存了', '2018-01-22 13:37:03', 'Chrome', '', 0);
INSERT INTO `tb_messages` VALUES (21, '游客', '罢了', '2018-01-22 13:38:45', '安卓版UC', '', 0);
INSERT INTO `tb_messages` VALUES (24, 'qaz123', '<script>String.fromCharCode(97, 108, 101, 114, 116, 40, 34, 88, 83, 83, 34, 41, 59)</script> ', '2018-01-22 14:47:45', 'Firefox', 'qaz123', 0);
INSERT INTO `tb_messages` VALUES (25, '游客', '<script>String.fromCharCode(97, 108, 101, 114, 116, 40, 34, 88, 83, 83, 34, 41, 59)</script> ', '2018-01-22 14:48:21', 'Firefox', 'qaz123', 0);
INSERT INTO `tb_messages` VALUES (27, 'qaz123', '</script><script>alert(test)</script> ', '2018-01-22 14:50:22', 'Firefox', 'qaz123', 0);
INSERT INTO `tb_messages` VALUES (30, 'qaz123', '<script>alert(document.cookie)</script>', '2018-01-22 14:54:22', 'Firefox', 'qaz123', 0);
INSERT INTO `tb_messages` VALUES (31, 'qaz123', '<script>alert(/存在xss跨站脚本攻击，请及时整改/)</script>', '2018-01-22 14:54:57', 'Firefox', 'qaz123', 0);
INSERT INTO `tb_messages` VALUES (32, '游客', '我跳转一个页数，就说我xss攻击了，贵站迟早药丸', '2018-01-22 18:06:40', '安卓版QQ', 'qaz123', 0);
INSERT INTO `tb_messages` VALUES (33, '游客', '< script >alert(\"js\");< / script >', '2018-01-22 19:43:09', 'QQ', '', 0);
INSERT INTO `tb_messages` VALUES (34, '游客', '现在玩不到电脑了，我明天再来处理php的……请勿乱发……', '2018-01-22 19:58:33', '安卓版UC', '', 0);
INSERT INTO `tb_messages` VALUES (35, '游客', '游客', '2018-01-22 21:09:36', 'Safari', '', 0);
INSERT INTO `tb_messages` VALUES (36, '游客', '<?php echo\"d\";?> echo \"a\";', '2018-01-23 14:25:18', 'QQ', '', 0);
INSERT INTO `tb_messages` VALUES (37, '游客', '原以为pre标签能够显示标签，原来只是显示空白用的。多谢诸位留言一测！现用html字符编码替换好了。', '2018-01-23 14:28:47', 'QQ', '', 0);
INSERT INTO `tb_messages` VALUES (38, '游客', '\"', '2018-01-23 14:39:25', 'QQ', '', 0);
INSERT INTO `tb_messages` VALUES (39, '游客', 'UC浏览器可以设置无UA标识，浏览器判断似乎没什么用。。', '2018-01-23 16:54:50', '', '', 0);
INSERT INTO `tb_messages` VALUES (40, '游客', '忍不住又多加了几个关于操作系统和其他浏览器的判断，应该够多了。', '2018-02-05 19:14:15', '安卓版阿里应用', '', 0);
INSERT INTO `tb_messages` VALUES (41, '游客', 'sadsadasdsadassdadsa', '2018-02-20 15:48:57', 'WP系统IE10', '', 0);
INSERT INTO `tb_messages` VALUES (42, '游客', '#include <iostream>\r\nusing namespace std;\r\nint main()\r\n{\r\n	void fnSort(int * ,int * ,int *);\r\n	void fnInput(int * ,int * ,int *);\r\n    void fnOutput(int &a,int &b,int &c);\r\n	int a,b,c;\r\n	fnInput(&a,&b,&c);\r\n	fnSort(&a,&b,&c);\r\n	fnOutput( a, b,c);\r\n	return 0;\r\n}\r\nvoid fnSort(int *a,int *b,int *c)//排序算法，不能用数组，幸好只有三个数\r\n{\r\n	\r\n	int d;\r\n	if(*a>*c) {d=*a;*a=*c;*c=d;}//比较第一个数和第三个数\r\n	if(*a>*b) {d=*b;*b=*a;*a=d;}//比较第一个数和第二个数\r\n	else if(*b>*c) {d=*b;*b=*c;*c=d;}//比较第二个数和第三个数 \r\n//	if(*a>*b) {d=*b;*b=*a;*a=d;}//比较第一个数和第二个数\r\n}\r\nvoid fnInput(int *a,int *b,int *c)\r\n{\r\n\r\n	cout<<\"请输入三个数：\n\";\r\n	cin>>*a>>*b>>*c;\r\n}\r\nvoid fnOutput(int &a,int &b,int &c)\r\n{\r\n\r\n	cout<<\"排序完成后如下：\n\";\r\n	cout<<a<<\"  \"<<b<<\"  \"<<c<<endl;\r\n}', '2018-03-09 10:00:18', 'Win7系统Chrome', '', 0);
INSERT INTO `tb_messages` VALUES (43, '游客', '没人', '2018-03-10 15:38:38', 'Win10系统QQ', '', 0);
INSERT INTO `tb_messages` VALUES (44, '游客', '会更好\r\n好', '2018-03-10 15:46:23', 'Win7系统QQ', '', 0);
INSERT INTO `tb_messages` VALUES (45, '游客', '\'', '2018-03-14 21:39:14', 'Win10系统QQ', '', 0);
INSERT INTO `tb_messages` VALUES (46, '游客', 'dfghfd ', '2018-04-28 14:30:21', 'Win10系统QQ', '', 0);
INSERT INTO `tb_messages` VALUES (47, '游客', '\"', '2018-04-28 14:30:28', 'Win10系统QQ', '', 0);
INSERT INTO `tb_messages` VALUES (48, '游客', '\'', '2018-05-13 15:42:46', 'Win7系统QQ', '', 0);
INSERT INTO `tb_messages` VALUES (49, '游客', '\'fgf \'fg ', '2018-05-13 15:42:46', '小米Win7系统QQ', '', 0);
INSERT INTO `tb_messages` VALUES (50, '游客', '\'\'fgf \'fg ', '2018-05-13 15:42:46', '小米Win7系统QQ', '', 0);
INSERT INTO `tb_messages` VALUES (51, '游客', 'Array', '2018-05-13 16:09:33', '小米Win7系统QQ', '', 0);
INSERT INTO `tb_messages` VALUES (52, '游客', 'Array', '2018-05-13 16:12:29', '小米Win7系统QQ', '', 0);
INSERT INTO `tb_messages` VALUES (53, '游客', 'Array', '2018-05-13 16:13:05', '小米Win7系统QQ', '', 0);
INSERT INTO `tb_messages` VALUES (54, '游客', '\'', '2018-05-13 16:24:05', '小米Win7系统QQ', '', 0);
INSERT INTO `tb_messages` VALUES (55, '游客', '\'\'\'', '2018-05-13 16:42:11', '小米Win7系统QQ', '', 0);
INSERT INTO `tb_messages` VALUES (56, '游客', '\"\"\"', '2018-05-13 16:43:21', '小米Win7系统QQ', '', 0);
INSERT INTO `tb_messages` VALUES (57, '游客', '\"', '2018-05-13 16:24:05', '小米Win7系统QQ', '', 0);
INSERT INTO `tb_messages` VALUES (58, '游客', '\'\r\n', '2018-05-13 17:00:08', 'Win7系统QQ', '', 0);
INSERT INTO `tb_messages` VALUES (59, '游客', '\'\'\'\'\'', '2018-05-13 17:05:03', 'Win7系统QQ', '', 0);
INSERT INTO `tb_messages` VALUES (60, '游客', '\'', '2018-05-19 23:05:33', 'Win7系统QQ', NULL, 0);
INSERT INTO `tb_messages` VALUES (61, '游客', '怎么做的', '2018-05-27 18:30:39', 'Win7系统Chrome', '', 0);
INSERT INTO `tb_messages` VALUES (62, 'qaz123', '格瓦拉看', '2018-05-31 10:25:39', '小米安卓系统Chrome', 'qaz123', 0);
INSERT INTO `tb_messages` VALUES (63, 'qaz123', 'i酷我不', '2018-05-31 10:26:42', '小米安卓系统Chrome', 'qaz123', 0);
INSERT INTO `tb_messages` VALUES (64, 'qaz123', 'i酷我不', '2018-05-31 10:26:42', '小米安卓系统Chrome', 'qaz123', 1);
INSERT INTO `tb_messages` VALUES (65, '游客', '的非官方的\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '2018-06-17 13:24:14', 'Win10系统QQ', '', 1);

SET FOREIGN_KEY_CHECKS = 1;
