/*
Navicat MySQL Data Transfer

Source Server         : 本地数据库
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : mini_shop

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2019-01-31 18:10:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for fox_ad
-- ----------------------------
DROP TABLE IF EXISTS `fox_ad`;
CREATE TABLE `fox_ad` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '幻灯片0 广告1',
  `title` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '标题',
  `img` varchar(200) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '图片',
  `gid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '链接的商品ID',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of fox_ad
-- ----------------------------
INSERT INTO `fox_ad` VALUES ('2', '0', '手机', '20180211/062843d860ddd577f192e26b6b62e4c7.jpg', '1', '2');
INSERT INTO `fox_ad` VALUES ('3', '0', '日用百货', '20180206/a46d85a0ba172c6b45f2c6f1e2b6b026.jpg', '3', '1');
INSERT INTO `fox_ad` VALUES ('4', '1', '电脑', '20180206/18234254764e7d0cf2d85c9592a44b4d.jpg', '2', '3');
INSERT INTO `fox_ad` VALUES ('5', '1', 'test4', '20180206/7ca80ccb0240ad13ebdaad74aeaed234.jpg', '4', '4');
INSERT INTO `fox_ad` VALUES ('6', '1', 'test5', '20180206/41364f87ff8e4d90336b3f325f4edc91.jpg', '5', '5');
INSERT INTO `fox_ad` VALUES ('7', '1', 'test6', '20180206/66792278061b54626a0305ed10cd8092.jpg', '6', '6');
INSERT INTO `fox_ad` VALUES ('11', '0', '手机', '20180211/e592cfa8b91486927188319d88ed7344.jpg', '7', '3');

-- ----------------------------
-- Table structure for fox_address
-- ----------------------------
DROP TABLE IF EXISTS `fox_address`;
CREATE TABLE `fox_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `consignee` varchar(60) NOT NULL DEFAULT '' COMMENT '收货人',
  `address` varchar(200) NOT NULL DEFAULT '' COMMENT '地址',
  `mobile` varchar(12) NOT NULL DEFAULT '' COMMENT '手机',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '默认收货地址',
  PRIMARY KEY (`id`),
  KEY `user_id` (`uid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fox_address
-- ----------------------------
INSERT INTO `fox_address` VALUES ('1', '1', '糯米巴巴网', '上海市XXX', '18827206927', '1');
INSERT INTO `fox_address` VALUES ('3', '1', '小雪', '上海市杨浦区', '13361996998', '0');

-- ----------------------------
-- Table structure for fox_admin
-- ----------------------------
DROP TABLE IF EXISTS `fox_admin`;
CREATE TABLE `fox_admin` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of fox_admin
-- ----------------------------
INSERT INTO `fox_admin` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e');

-- ----------------------------
-- Table structure for fox_cart
-- ----------------------------
DROP TABLE IF EXISTS `fox_cart`;
CREATE TABLE `fox_cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `gid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `name` varchar(200) NOT NULL DEFAULT '' COMMENT '商品名称',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '价格',
  `num` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '购买数量',
  `selected` tinyint(1) unsigned DEFAULT '1' COMMENT '购物车选中状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fox_cart
-- ----------------------------
INSERT INTO `fox_cart` VALUES ('23', '1', '30', '小米(MI)Air 13.3英寸全金属轻薄笔记本(i5-7200U 8G 256G PCle SSD MX150 2G独显 FHD 指纹识别 ', '0.01', '1', '1');
INSERT INTO `fox_cart` VALUES ('22', '1', '16', '华为手环B3 (蓝牙耳机与智能手环结合+金属机身+触控屏幕+真皮腕带) 商务版 摩卡棕', '1199.00', '1', '0');

-- ----------------------------
-- Table structure for fox_category
-- ----------------------------
DROP TABLE IF EXISTS `fox_category`;
CREATE TABLE `fox_category` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品分类id',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '分类名称',
  `pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `img` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '图片',
  `is_show_index` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '首页显示',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`pid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fox_category
-- ----------------------------
INSERT INTO `fox_category` VALUES ('1', '手机数码', '0', '', '1', '1');
INSERT INTO `fox_category` VALUES ('2', '家用电器', '0', '', '1', '2');
INSERT INTO `fox_category` VALUES ('3', '电脑办公', '0', '', '1', '3');
INSERT INTO `fox_category` VALUES ('4', '家具厨具', '0', '', '0', '4');
INSERT INTO `fox_category` VALUES ('5', '服装服饰', '0', '', '0', '5');
INSERT INTO `fox_category` VALUES ('6', '美妆个护 ', '0', '', '0', '6');
INSERT INTO `fox_category` VALUES ('7', '箱包珠宝', '0', '', '0', '7');
INSERT INTO `fox_category` VALUES ('8', '手机', '1', '20180215/f5e3cd84add0985b68b9334b0bca528e.jpg', '0', '1');
INSERT INTO `fox_category` VALUES ('9', '手机配件', '1', '20180215/a3d4e138a58a73e47dbdf9075b50156b.jpg', '0', '2');
INSERT INTO `fox_category` VALUES ('10', '摄影摄像', '1', '20180215/f3d88f1d515c12fb5ab3b7e4dcc8294a.jpg', '0', '3');
INSERT INTO `fox_category` VALUES ('11', '数码配件', '1', '20180215/1f8d285cc658affd7132743eeb68c28b.jpg', '0', '4');
INSERT INTO `fox_category` VALUES ('12', '影音娱乐', '1', '20180215/78c3d0479be2c2e158a059bcfaf274c1.jpg', '0', '5');
INSERT INTO `fox_category` VALUES ('13', '电子教育', '1', '20180215/463d1cf7d2d8d232bca4bd121a67d88c.jpg', '0', '6');
INSERT INTO `fox_category` VALUES ('14', '智能设备', '1', '20180215/941aad6a9a6676cf5b474e18b4731415.jpg', '0', '7');
INSERT INTO `fox_category` VALUES ('17', '电视', '2', '20180215/f8a3bc388b5e3d482bf89e15bed4d2b4.jpg', '0', '1');
INSERT INTO `fox_category` VALUES ('18', '空调', '2', '20180215/4db552348f4d046d5b1850836b26c976.jpg', '0', '2');
INSERT INTO `fox_category` VALUES ('19', '洗衣机', '2', '20180215/204474d43223dc5278aba1119e12089e.jpg', '0', '3');
INSERT INTO `fox_category` VALUES ('20', '冰箱', '2', '20180215/910b8a962c69b20f89aa7f02356e10d6.jpg', '0', '4');
INSERT INTO `fox_category` VALUES ('21', '电脑', '3', '20180215/2a82d46194946963fcd6e939aa879c51.jpg', '0', '1');
INSERT INTO `fox_category` VALUES ('22', '外设', '3', '20180215/d0d387ea162ecc520ff1c699d4673542.jpg', '0', '2');
INSERT INTO `fox_category` VALUES ('23', '办公设备', '3', '20180215/2c0092d2d387a7cccf34a732c9e74650.jpg', '0', '3');
INSERT INTO `fox_category` VALUES ('24', '家具', '4', '20180215/7b9f0be0b4c69715306d4b6521ee9515.jpg', '0', '1');
INSERT INTO `fox_category` VALUES ('25', '厨具', '4', '20180215/84cb93808a5a1dc0cf2a2e45f879c2fd.jpg', '0', '2');
INSERT INTO `fox_category` VALUES ('26', '女装', '5', '20180215/5fbb715520574252e310b4cbc019ea9e.jpg', '0', '1');
INSERT INTO `fox_category` VALUES ('27', '护肤', '6', '20180215/340404e32739c1c81006b43e51f3a844.jpg', '0', '1');
INSERT INTO `fox_category` VALUES ('28', '珠宝首饰', '7', '20180215/f8f1da2dc74391f7a88c6aad2785b222.jpg', '0', '1');

-- ----------------------------
-- Table structure for fox_goods
-- ----------------------------
DROP TABLE IF EXISTS `fox_goods`;
CREATE TABLE `fox_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `cid_one` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '一级分类id',
  `cid_two` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '二级分类',
  `name` varchar(120) NOT NULL DEFAULT '' COMMENT '商品名称',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `store` smallint(5) unsigned NOT NULL DEFAULT '10' COMMENT '库存数量',
  `collect` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏数',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '价格',
  `content` text CHARACTER SET utf16 COMMENT '商品描述',
  `img` varchar(200) NOT NULL DEFAULT '' COMMENT '商品图片',
  `sales` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '销量',
  `sort` smallint(4) unsigned NOT NULL DEFAULT '50' COMMENT '商品排序',
  PRIMARY KEY (`id`),
  KEY `cat_id` (`cid_one`),
  KEY `goods_number` (`store`),
  KEY `sort_order` (`sort`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fox_goods
-- ----------------------------
INSERT INTO `fox_goods` VALUES ('1', '1', '8', 'Apple iPhone X (A1865) 256GB 深空灰色 移动联通电信4G手机', '3', '100', '0', '0.01', '<p style=\"text-align: center;\"><img src=\"/uploads/20180216/59fbccda158ac65e45a546bd7c1665c2.jpg\" title=\"59fbccda158ac65e45a546bd7c1665c2.jpg\"/></p><p style=\"text-align: center;\"><img src=\"/uploads/20180216/89acca9d8ee93ed93daa955f8f7ed943.jpg\" title=\"89acca9d8ee93ed93daa955f8f7ed943.jpg\"/></p><p style=\"text-align: center;\"><img src=\"/uploads/20180216/56cb4257b44d5b219edcf87ec4a26e42.jpg\" title=\"56cb4257b44d5b219edcf87ec4a26e42.jpg\"/></p><p style=\"text-align: center;\"><img src=\"/uploads/20180216/10ba22e9996c3763257eff988da10d44.jpg\" title=\"10ba22e9996c3763257eff988da10d44.jpg\"/></p><p style=\"text-align: center;\"><img src=\"/uploads/20180216/97772520bf3f834b72b685281491541e.jpg\" title=\"97772520bf3f834b72b685281491541e.jpg\"/></p><p style=\"text-align: center;\"><br/></p>', '20180216/166d6e04fa8ee1e9f0241efc26198011.jpg', '0', '1');
INSERT INTO `fox_goods` VALUES ('2', '1', '8', 'Apple iPhone 8 Plus (A1864) 64GB 金色 移动联通电信4G手机', '1', '102', '0', '6688.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180217/b8055c99adafc4ecaa84e36737225875.jpg\" title=\"b8055c99adafc4ecaa84e36737225875.jpg\" alt=\"b8055c99adafc4ecaa84e36737225875.jpg\"/></p>', '20180217/c61841f9bf2be8a7c50c91967b360fc2.jpg', '0', '2');
INSERT INTO `fox_goods` VALUES ('3', '1', '8', '华为 HUAWEI Mate 10 Pro 全网通 6GB+128GB 银钻灰 移动联通电信4G手机 双卡双待', '0', '103', '0', '5399.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180217/58ecf891ee6ae1e4b2db1fe67772771e.jpg\" title=\"58ecf891ee6ae1e4b2db1fe67772771e.jpg\" alt=\"58ecf891ee6ae1e4b2db1fe67772771e.jpg\"/></p>', '20180217/5664870c160d6c2097075aca6b8f9bcc.jpg', '0', '3');
INSERT INTO `fox_goods` VALUES ('4', '1', '8', '华为 HUAWEI P10 Plus 全网通4G智能手机 钻雕金 6G+128G', '0', '104', '0', '4488.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180217/29b10b9ceb62ee8f6d99faf9629a1682.jpg\" title=\"29b10b9ceb62ee8f6d99faf9629a1682.jpg\" alt=\"29b10b9ceb62ee8f6d99faf9629a1682.jpg\"/></p>', '20180217/15af57289c262eef3599171634f78b52.jpg', '0', '4');
INSERT INTO `fox_goods` VALUES ('5', '1', '8', '小米MIX2 全网通 6GB 128GB 黑色 移动联通电信4G手机 双卡双待', '0', '105', '0', '3599.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180217/ff3abb85ccfa5b300f4d114fe2de105f.jpg\" title=\"ff3abb85ccfa5b300f4d114fe2de105f.jpg\" alt=\"ff3abb85ccfa5b300f4d114fe2de105f.jpg\"/></p>', '20180217/17ba99b5a7d32a2b95181eb4ebe11490.jpg', '0', '5');
INSERT INTO `fox_goods` VALUES ('6', '1', '8', '小米 Note2 全网通4G 移动联通电信全网通4G智能手机 亮黑色 6+128GB 全球版', '1', '106', '0', '2349.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180217/ce0485426a5af1f3bf74b91cab5134ee.jpg\" title=\"ce0485426a5af1f3bf74b91cab5134ee.jpg\" alt=\"ce0485426a5af1f3bf74b91cab5134ee.jpg\"/></p>', '20180217/669bbd371cf2bb17c711c18391bc249b.jpg', '0', '6');
INSERT INTO `fox_goods` VALUES ('7', '1', '8', '魅族 PRO6S 4GB+64GB 全网通公开版 玫瑰金 移动联通电信4G手机 双卡双待', '1', '107', '0', '1499.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180217/5cb256563e6caa6e405fcd3d37bdf093.jpg\" title=\"5cb256563e6caa6e405fcd3d37bdf093.jpg\" alt=\"5cb256563e6caa6e405fcd3d37bdf093.jpg\"/></p>', '20180217/643a94466226ff1e9ae50fadd398cd86.jpg', '0', '7');
INSERT INTO `fox_goods` VALUES ('8', '1', '8', '三星 Galaxy Note8（SM-N9500）6GB+128GB 谜夜黑 移动联通电信4G手机 双卡双待', '0', '108', '0', '7388.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180217/542c47bfbc0690a8019075d0fe3c442c.jpg\" title=\"542c47bfbc0690a8019075d0fe3c442c.jpg\" alt=\"542c47bfbc0690a8019075d0fe3c442c.jpg\"/></p>', '20180217/da50f2928784fe1d1b9fcab3a2868a95.jpg', '0', '8');
INSERT INTO `fox_goods` VALUES ('9', '1', '8', 'vivo X20 全面屏双摄拍照手机 6GB+64GB 移动联通电信全网通4G手机 双卡双待', '0', '109', '0', '3698.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180217/e4a71876efd89d2bc785849b1ed7d863.jpg\" title=\"e4a71876efd89d2bc785849b1ed7d863.jpg\" alt=\"e4a71876efd89d2bc785849b1ed7d863.jpg\"/></p>', '20180217/a0e0f1bfbd4d598057849a9e35a006e4.jpg', '0', '9');
INSERT INTO `fox_goods` VALUES ('10', '1', '8', '一加手机5T 8GB+128GB 星辰黑 全面屏双摄游戏手机 全网通4G 双卡双待', '1', '110', '0', '3499.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180217/a14862a6560089e79802b4c5c99cbe0b.jpg\" title=\"a14862a6560089e79802b4c5c99cbe0b.jpg\" alt=\"a14862a6560089e79802b4c5c99cbe0b.jpg\"/></p>', '20180217/13aa8c8912575fccf66f2792d18e5f57.jpg', '0', '10');
INSERT INTO `fox_goods` VALUES ('11', '1', '9', '毕亚兹(BIAZE) 苹果6/6S手机壳 iPhone6/6S保护套 全包防摔透明软壳 清爽系列', '0', '110', '0', '8.80', '<p style=\"text-align: center;\"><img src=\"/uploads/20180217/8b120732d06659b18f32e811435ccaa6.jpg\" title=\"8b120732d06659b18f32e811435ccaa6.jpg\" alt=\"8b120732d06659b18f32e811435ccaa6.jpg\"/></p>', '20180217/783c94e65e2b8e7364e13c6afdebc73c.jpg', '0', '11');
INSERT INTO `fox_goods` VALUES ('12', '1', '10', '索尼（SONY） DSC-RX100M5（RX100V）黑卡数码相机 等效24-70mm F1.8-2.8蔡司镜头', '0', '112', '0', '6149.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180217/eb58e8811ec4cbc54831e1c7a62d4275.jpg\" title=\"eb58e8811ec4cbc54831e1c7a62d4275.jpg\" alt=\"eb58e8811ec4cbc54831e1c7a62d4275.jpg\"/></p>', '20180217/cf26ced45a4e314fd6b43d24b67e681d.jpg', '0', '12');
INSERT INTO `fox_goods` VALUES ('13', '1', '11', '三星（SAMSUNG）存储卡128GB 读速100MB/s 写速90MB/s 4K Class10 高速TF卡（Micro SD卡）红色plus升级版', '2', '116', '0', '245.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180217/94f02a5ef69fee5496c245481c256c93.jpg\" title=\"94f02a5ef69fee5496c245481c256c93.jpg\" alt=\"94f02a5ef69fee5496c245481c256c93.jpg\"/></p>', '20180217/da9172edb219502bfbcced2b60460a46.jpg', '0', '16');
INSERT INTO `fox_goods` VALUES ('14', '1', '12', 'JBL CM102 高保真蓝牙音响 HIFI音质 有源监听音箱 低音炮 多媒体电脑电视音响', '3', '112', '0', '999.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180217/f7431fc5f0c642abbfc386381267c67a.jpg\" title=\"f7431fc5f0c642abbfc386381267c67a.jpg\" alt=\"f7431fc5f0c642abbfc386381267c67a.jpg\"/></p>', '20180217/61a55e95cd6d66b7dd13f0012c67e830.jpg', '0', '1');
INSERT INTO `fox_goods` VALUES ('15', '1', '13', '步步高家教机S3 香槟金64G 9.7英寸Retina视网膜屏安全护眼 学生平板电脑学习机 英语点读机点读笔早教机', '4', '123', '0', '3498.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180217/04d099d2e425372143ab7e8c518466bd.jpg\" title=\"04d099d2e425372143ab7e8c518466bd.jpg\" alt=\"04d099d2e425372143ab7e8c518466bd.jpg\"/></p>', '20180217/20a182d48ccf9efeb09924ec4bdf8191.jpg', '0', '1');
INSERT INTO `fox_goods` VALUES ('16', '1', '14', '华为手环B3 (蓝牙耳机与智能手环结合+金属机身+触控屏幕+真皮腕带) 商务版 摩卡棕', '43', '169', '0', '1199.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180217/6c1677741f4380e73c56e3d416c85d41.jpg\" title=\"6c1677741f4380e73c56e3d416c85d41.jpg\" alt=\"6c1677741f4380e73c56e3d416c85d41.jpg\"/></p>', '20180217/ebe473c60aa2371995298b4fd08740f8.jpg', '0', '1');
INSERT INTO `fox_goods` VALUES ('17', '2', '17', '飞利浦（PHILIPS）65PUF6051/T3 65英寸 二级能效 丰富影视应用 64位4K超高清WIFI智能液晶电视机', '2', '128', '0', '4799.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180217/90b6e87345f8936fbbfc198bfb4149a6.jpg\" title=\"90b6e87345f8936fbbfc198bfb4149a6.jpg\" alt=\"90b6e87345f8936fbbfc198bfb4149a6.jpg\"/></p>', '20180217/47ea646c035727ea6938678aa8fb06cc.jpg', '0', '1');
INSERT INTO `fox_goods` VALUES ('18', '2', '18', '格力（GREE）正1.5匹 变频 品圆 冷暖 壁挂式空调 KFR-35GW/(35592)FNhDa-A3', '3', '211', '0', '3399.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180217/9cacbeda14eda3db62264c260c2942a4.jpg\" title=\"9cacbeda14eda3db62264c260c2942a4.jpg\" alt=\"9cacbeda14eda3db62264c260c2942a4.jpg\"/></p>', '20180217/a6c348f4866c66fa0c742e24a3b7da38.jpg', '0', '1');
INSERT INTO `fox_goods` VALUES ('19', '2', '19', '西门子 (SIEMENS) XQG80-WM12N1600W 8公斤 变频 滚筒洗衣机 缓震降噪 筒清洁 加漂洗', '4', '100', '0', '3899.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180217/b6f30a064a24f0f828454b39dedf07dc.jpg\" title=\"b6f30a064a24f0f828454b39dedf07dc.jpg\" alt=\"b6f30a064a24f0f828454b39dedf07dc.jpg\"/></p>', '20180217/1077add1ba6f68fab4d7284f4c834633.jpg', '0', '1');
INSERT INTO `fox_goods` VALUES ('20', '2', '20', '西门子（SIEMENS）610升 变频风冷无霜 对开门冰箱 LED显示速冷速冻（白色）', '10', '100', '0', '5999.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180217/15bd1f454de9b715b86abe253a828d80.jpg\" title=\"15bd1f454de9b715b86abe253a828d80.jpg\" alt=\"15bd1f454de9b715b86abe253a828d80.jpg\"/></p>', '20180217/3bc0ebabc6b01ed5083377dc0b4f1e7a.jpg', '0', '1');
INSERT INTO `fox_goods` VALUES ('21', '3', '21', '戴尔DELL灵越游匣Master15-R4645B 15.6英寸游戏笔记本电脑(i5-7300HQ 8G 128GSSD+1T GTX1050Ti 4G独显)黑', '1', '123', '0', '6399.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180217/e7c018def278df344279948e6f808103.jpg\" title=\"e7c018def278df344279948e6f808103.jpg\" alt=\"e7c018def278df344279948e6f808103.jpg\"/></p>', '20180217/5f1f549e3483239f35825f1d3a96399e.jpg', '0', '1');
INSERT INTO `fox_goods` VALUES ('22', '3', '22', '酷冷至尊(CoolerMaster) MK750 RGB 幻彩 机械键盘（红轴）樱桃轴（CNC上盖/全键无冲/绝地求生吃鸡键盘）', '0', '121', '0', '1099.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180218/e5353e3ca4b07c48e856f25f7ab9b52a.jpg\" title=\"e5353e3ca4b07c48e856f25f7ab9b52a.jpg\" alt=\"e5353e3ca4b07c48e856f25f7ab9b52a.jpg\"/></p>', '20180218/a5055dd9efce78d3646ec9c4871d7b4f.jpg', '0', '1');
INSERT INTO `fox_goods` VALUES ('23', '3', '23', '爱普生（EPSON）L360墨仓式打印机 家用彩色喷墨一体机（打印 复印 扫描）', '9', '120', '0', '999.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180218/3f0983ada7b3f238b2668f297beb32a2.jpg\" title=\"3f0983ada7b3f238b2668f297beb32a2.jpg\" alt=\"3f0983ada7b3f238b2668f297beb32a2.jpg\"/></p>', '20180218/e4e4426956df9f4e1c910508a4a7ee0c.jpg', '0', '1');
INSERT INTO `fox_goods` VALUES ('24', '4', '24', '梵爱（VASO LOVE）秒杀直降901 沙发 布艺沙发皮布可拆洗储物沙发客厅家具 ', '0', '121', '0', '3600.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180218/03f687f4b04602e6fcff553563afeb67.jpg\" title=\"03f687f4b04602e6fcff553563afeb67.jpg\" alt=\"03f687f4b04602e6fcff553563afeb67.jpg\"/></p>', '20180218/230bde6df02385fcd1efac3396525271.jpg', '0', '1');
INSERT INTO `fox_goods` VALUES ('25', '4', '25', '双立人 ZWILLING 鸿运当头 30cm中式炒锅14件套 40120-035-922', '0', '211', '0', '2288.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180218/a45f66064d90ca364bce87bb0b3ce300.jpg\" title=\"a45f66064d90ca364bce87bb0b3ce300.jpg\" alt=\"a45f66064d90ca364bce87bb0b3ce300.jpg\"/></p>', '20180218/e1555f01cdfef4589057073713b40b07.jpg', '0', '1');
INSERT INTO `fox_goods` VALUES ('26', '5', '26', 'intercrew打底衫女套头2018春新款长袖半高领修身保暖女装气质百搭打底弹力针织衫女 ICS1DR53A 黑色', '0', '233', '0', '109.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180218/18d9dd04302858101b3964bc4af1ecd7.jpg\" title=\"18d9dd04302858101b3964bc4af1ecd7.jpg\" alt=\"18d9dd04302858101b3964bc4af1ecd7.jpg\"/></p>', '20180218/74810328c83ff36916cd2d93d71185d8.jpg', '0', '1');
INSERT INTO `fox_goods` VALUES ('27', '6', '27', '欧莱雅（LOREAL）男士劲能极润护肤霜 50ml（补水保湿 护肤面霜）', '0', '210', '0', '119.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180218/1a48d5711ed7845b31e9c8f2d377b53f.jpg\" title=\"1a48d5711ed7845b31e9c8f2d377b53f.jpg\" alt=\"1a48d5711ed7845b31e9c8f2d377b53f.jpg\"/></p>', '20180218/f1c370f07db0c2da32a5d061db359487.jpg', '0', '1');
INSERT INTO `fox_goods` VALUES ('28', '7', '28', '六福珠宝 网络专款京东JOY联名款足金狗黄金吊坠硬金不含项链', '0', '123', '0', '1690.00', '<p style=\"text-align: center;\"><img src=\"/uploads/20180218/a3025197b3c1155aafcdf3cfd4d4acb2.jpg\" title=\"a3025197b3c1155aafcdf3cfd4d4acb2.jpg\" alt=\"a3025197b3c1155aafcdf3cfd4d4acb2.jpg\"/></p>', '20180218/3e9c6e937b9e5c3c98e7681d4c9449c6.jpg', '0', '1');
INSERT INTO `fox_goods` VALUES ('30', '3', '21', '小米(MI)Air 13.3英寸全金属轻薄笔记本(i5-7200U 8G 256G PCle SSD MX150 2G独显 FHD 指纹识别 ', '37', '133', '0', '0.01', '<p style=\"text-align: center;\"><img src=\"/uploads/20180218/9f12abe26ec2ed432b29e487b1f315ce.jpg\" title=\"9f12abe26ec2ed432b29e487b1f315ce.jpg\" alt=\"9f12abe26ec2ed432b29e487b1f315ce.jpg\"/></p>', '20180218/964ed0315d3a6063ee8b223c3367f02c.jpg', '0', '2');

-- ----------------------------
-- Table structure for fox_goods_collect
-- ----------------------------
DROP TABLE IF EXISTS `fox_goods_collect`;
CREATE TABLE `fox_goods_collect` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `gid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  PRIMARY KEY (`id`),
  KEY `user_id` (`uid`) USING BTREE,
  KEY `goods_id` (`gid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fox_goods_collect
-- ----------------------------
INSERT INTO `fox_goods_collect` VALUES ('3', '1', '16');
INSERT INTO `fox_goods_collect` VALUES ('5', '1', '30');

-- ----------------------------
-- Table structure for fox_goods_images
-- ----------------------------
DROP TABLE IF EXISTS `fox_goods_images`;
CREATE TABLE `fox_goods_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品图片id',
  `gid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `img` varchar(200) NOT NULL DEFAULT '' COMMENT '图片地址',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`gid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fox_goods_images
-- ----------------------------
INSERT INTO `fox_goods_images` VALUES ('1', '1', '20180217/a906ce80ba7113748dcaebeb24d86b99.jpg');
INSERT INTO `fox_goods_images` VALUES ('2', '1', '20180217/fa1eb05bf3a9d27ee323dbe1f598b82c.jpg');
INSERT INTO `fox_goods_images` VALUES ('3', '1', '20180217/f78993b92f58849cb9748f494ae71ce3.jpg');
INSERT INTO `fox_goods_images` VALUES ('4', '1', '20180217/ef089475c6da9fab11fe5d9c680f584d.jpg');
INSERT INTO `fox_goods_images` VALUES ('5', '1', '20180217/065f2c319d14bf245110cc2384151491.jpg');
INSERT INTO `fox_goods_images` VALUES ('6', '2', '20180217/60840318790e4c6ac4af94399e12813f.jpg');
INSERT INTO `fox_goods_images` VALUES ('7', '2', '20180217/f6c4ee6fcfe7d38fe30afb0aea059260.jpg');
INSERT INTO `fox_goods_images` VALUES ('8', '2', '20180217/14b52e6a84a22ad1bf6609c258807bfc.jpg');
INSERT INTO `fox_goods_images` VALUES ('9', '2', '20180217/f346deb3343a456f9eae30949a1e497f.jpg');
INSERT INTO `fox_goods_images` VALUES ('10', '3', '20180217/540234d2c61de110e41259d4c8c8465b.jpg');
INSERT INTO `fox_goods_images` VALUES ('11', '3', '20180217/9a423a0cad615c050f4962720a4e9a31.jpg');
INSERT INTO `fox_goods_images` VALUES ('12', '4', '20180217/df6b60744f155d362d580e5439c364cb.jpg');
INSERT INTO `fox_goods_images` VALUES ('13', '4', '20180217/91e54e90970eb53a6bf697abf1cdb5e7.jpg');
INSERT INTO `fox_goods_images` VALUES ('17', '5', '20180217/89a1c96ce454fa07ff3241fcb9beb399.jpg');
INSERT INTO `fox_goods_images` VALUES ('16', '5', '20180217/a7a40d84aba7b41e388c4b89a3aad2cb.jpg');
INSERT INTO `fox_goods_images` VALUES ('18', '5', '20180217/266fb41b31379510606a5eccc2e5871d.jpg');
INSERT INTO `fox_goods_images` VALUES ('19', '6', '20180217/88ff6e130c0b52b1170b69e9aefb758c.jpg');
INSERT INTO `fox_goods_images` VALUES ('20', '6', '20180217/8566ec9a9bfe76bc8dc1214955c97685.jpg');
INSERT INTO `fox_goods_images` VALUES ('21', '7', '20180217/73d23701a71819a4abbc00e07bbb7029.jpg');
INSERT INTO `fox_goods_images` VALUES ('22', '7', '20180217/fdfa635b5d1540d4555ad4a52e0437a1.jpg');
INSERT INTO `fox_goods_images` VALUES ('23', '8', '20180217/c9e27cebe8a04b6f717adb95682cebba.jpg');
INSERT INTO `fox_goods_images` VALUES ('24', '8', '20180217/8804bb3f4f1eb2f72b36d8de2c4a2d82.jpg');
INSERT INTO `fox_goods_images` VALUES ('25', '9', '20180217/4d468573c34bfe4e0961c6a4b80a2568.jpg');
INSERT INTO `fox_goods_images` VALUES ('26', '9', '20180217/5251c023dd3f7ecb24245d43a660adcc.jpg');
INSERT INTO `fox_goods_images` VALUES ('27', '10', '20180217/2ec5bae2013570a3962d9fda11828847.jpg');
INSERT INTO `fox_goods_images` VALUES ('28', '10', '20180217/d236282d232a0b0fb3d78a5be8c1b423.jpg');
INSERT INTO `fox_goods_images` VALUES ('29', '11', '20180217/9343f88d56e60375904215e2f01114a5.jpg');
INSERT INTO `fox_goods_images` VALUES ('30', '11', '20180217/4b80aa28c23f6d14d420f6309b4c7510.jpg');
INSERT INTO `fox_goods_images` VALUES ('31', '12', '20180217/0237420278173aa1ee98364db8f372cc.jpg');
INSERT INTO `fox_goods_images` VALUES ('32', '12', '20180217/05160cd8db0e68c5a031dc153b27b115.jpg');
INSERT INTO `fox_goods_images` VALUES ('33', '13', '20180217/de843658fa9974091989949b9ba2ce90.jpg');
INSERT INTO `fox_goods_images` VALUES ('34', '13', '20180217/5c9681a62e561c8416d07964032d7e69.jpg');
INSERT INTO `fox_goods_images` VALUES ('35', '14', '20180217/e626a24a8971d7d156943dcb92cee3da.jpg');
INSERT INTO `fox_goods_images` VALUES ('36', '14', '20180217/c1493d07ce070f0c62cfbcdb64facaa4.jpg');
INSERT INTO `fox_goods_images` VALUES ('37', '15', '20180217/b20fe76b42a1577ce82c7d5ba762b0ba.jpg');
INSERT INTO `fox_goods_images` VALUES ('38', '15', '20180217/b3a956ff77dca5d3b468dd8d9787c4d8.jpg');
INSERT INTO `fox_goods_images` VALUES ('39', '16', '20180217/4a031b248576a9554959fd0fcc01129e.jpg');
INSERT INTO `fox_goods_images` VALUES ('40', '16', '20180217/e9fa8d00c2c4a0f18e8d5d5467ad8254.jpg');
INSERT INTO `fox_goods_images` VALUES ('41', '17', '20180217/095b9bd21e8ed074988e6f9016e57bd7.jpg');
INSERT INTO `fox_goods_images` VALUES ('42', '17', '20180217/db87c33757a4d0888cb11e643a7dcb83.jpg');
INSERT INTO `fox_goods_images` VALUES ('43', '18', '20180217/585f9dc73e9c243b4825c969f768c400.jpg');
INSERT INTO `fox_goods_images` VALUES ('44', '18', '20180217/3ea4bf49482d5ad2784b5d7ef2bf6186.jpg');
INSERT INTO `fox_goods_images` VALUES ('45', '19', '20180217/7e64f881c088442e65abf2ec7b03c4c2.jpg');
INSERT INTO `fox_goods_images` VALUES ('46', '19', '20180217/f9ad368ceb740032bb05d881283f8172.jpg');
INSERT INTO `fox_goods_images` VALUES ('47', '21', '20180217/b7b304d4533b7d90570e425802a54efd.jpg');
INSERT INTO `fox_goods_images` VALUES ('48', '21', '20180217/a523a635fa9c1587d652f57974f3acc2.jpg');
INSERT INTO `fox_goods_images` VALUES ('49', '22', '20180218/6b67348b8114a2f4350461d8fd86222b.jpg');
INSERT INTO `fox_goods_images` VALUES ('50', '22', '20180218/1f796c7ab4a55e37774195e47b77a147.jpg');
INSERT INTO `fox_goods_images` VALUES ('51', '23', '20180218/8db53e0ceb03676751635d1a741b7549.jpg');
INSERT INTO `fox_goods_images` VALUES ('52', '23', '20180218/0de238910b014a83b7447801244207cf.jpg');
INSERT INTO `fox_goods_images` VALUES ('53', '24', '20180218/d6958ef6c4a32576953d976f8cfdd9c8.jpg');
INSERT INTO `fox_goods_images` VALUES ('54', '25', '20180218/b23141a164d5ed13ce63dfa616796ab5.jpg');
INSERT INTO `fox_goods_images` VALUES ('55', '25', '20180218/55cac7d1b01c509d43dae42cbdc59d1d.jpg');
INSERT INTO `fox_goods_images` VALUES ('56', '26', '20180218/97371cf86a8bb325c237c54d82d523f4.jpg');
INSERT INTO `fox_goods_images` VALUES ('57', '26', '20180218/e44db9bded9bb1dd13698003be7c761c.jpg');
INSERT INTO `fox_goods_images` VALUES ('58', '27', '20180218/468d8a332b838f0630be760507c5240f.jpg');
INSERT INTO `fox_goods_images` VALUES ('59', '27', '20180218/ca794889bc9c68f1846980d84c3677ea.jpg');
INSERT INTO `fox_goods_images` VALUES ('60', '28', '20180218/9b82d66bb93eb3d99fa3bd642211659d.jpg');
INSERT INTO `fox_goods_images` VALUES ('61', '28', '20180218/48a696a5335182ab648be7a8fc90f88a.jpg');
INSERT INTO `fox_goods_images` VALUES ('62', '30', '20180218/930b010d32a8b22e9ab41c1e0d45ce9a.jpg');
INSERT INTO `fox_goods_images` VALUES ('63', '30', '20180218/29a16ca312b47787be6a22331bad61e0.jpg');
INSERT INTO `fox_goods_images` VALUES ('64', '20', '20180220/19988e81d2c98f5703d1968dd3ae453b.jpg');
INSERT INTO `fox_goods_images` VALUES ('65', '20', '20180220/224155427e24b311f89e0e7e364e4fc5.jpg');

-- ----------------------------
-- Table structure for fox_order
-- ----------------------------
DROP TABLE IF EXISTS `fox_order`;
CREATE TABLE `fox_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `order_sn` varchar(20) NOT NULL DEFAULT '' COMMENT '订单号，小程序中显示用',
  `order_sn_submit` varchar(20) NOT NULL DEFAULT '' COMMENT '订单号，微信支付时提交用，可变',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `order_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态 待付款0 已完成1 待发货2 待收货3 已取消4',
  `consignee` varchar(60) NOT NULL DEFAULT '' COMMENT '收货人',
  `address` varchar(200) NOT NULL DEFAULT '' COMMENT '地址',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单总价',
  `submit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '下单时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_sn` (`order_sn`) USING BTREE,
  KEY `user_id` (`uid`) USING BTREE,
  KEY `order_status` (`order_status`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fox_order
-- ----------------------------
INSERT INTO `fox_order` VALUES ('1', '201802282306596079', '201802282306595449', '1', '0', '糯米巴巴网', '上海市XXX', '18827206927', '0.01', '2018-02-28 23:06:59');
INSERT INTO `fox_order` VALUES ('2', '201803011009004336', '201803011009003677', '1', '1', '糯米巴巴网', '上海市XXX', '18827206927', '0.01', '2018-03-01 10:09:00');
INSERT INTO `fox_order` VALUES ('3', '201803011017093931', '201803011017096974', '1', '2', '糯米巴巴网', '上海市XXX', '18827206927', '0.01', '2018-03-01 10:17:09');
INSERT INTO `fox_order` VALUES ('4', '201803011038211642', '201803011038212936', '1', '3', '糯米巴巴网', '上海市XXX', '18827206927', '0.01', '2018-03-01 10:38:21');
INSERT INTO `fox_order` VALUES ('5', '201803011039367958', '201803011039364973', '1', '4', '糯米巴巴网', '上海市XXX', '18827206927', '0.01', '2018-03-01 10:39:36');
INSERT INTO `fox_order` VALUES ('6', '201803011041393069', '201803011041394920', '1', '0', '糯米巴巴网', '上海市XXX', '18827206927', '0.01', '2018-03-01 10:41:39');
INSERT INTO `fox_order` VALUES ('7', '201803011043254627', '201803011043254714', '1', '0', '糯米巴巴网', '上海市XXX', '18827206927', '0.01', '2018-03-01 10:43:25');
INSERT INTO `fox_order` VALUES ('8', '201803011045061392', '201803011045063053', '1', '0', '糯米巴巴网', '上海市XXX', '18827206927', '0.01', '2018-03-01 10:45:06');
INSERT INTO `fox_order` VALUES ('9', '201803011048024437', '201803011048029671', '1', '1', '糯米巴巴网', '上海市XXX', '18827206927', '0.01', '2018-03-01 10:48:02');
INSERT INTO `fox_order` VALUES ('10', '201803011159294275', '201803011159292647', '1', '2', '糯米巴巴网', '上海市XXX', '18827206927', '0.01', '2018-03-01 11:59:29');
INSERT INTO `fox_order` VALUES ('11', '201803011225118268', '201803011225111689', '1', '1', '糯米巴巴网', '上海市XXX', '18827206927', '0.01', '2018-03-01 12:25:11');
INSERT INTO `fox_order` VALUES ('12', '201803011229346701', '201803011229344402', '1', '4', '糯米巴巴网', '上海市XXX', '18827206927', '0.01', '2018-03-01 12:29:34');
INSERT INTO `fox_order` VALUES ('13', '201803011306437426', '201803011306438421', '1', '1', '糯米巴巴网', '上海市XXX', '18827206927', '0.01', '2018-03-01 13:06:43');
INSERT INTO `fox_order` VALUES ('14', '201803011316562925', '201803011316562586', '1', '3', '糯米巴巴网', '上海市XXX', '18827206927', '0.01', '2018-03-01 13:16:56');
INSERT INTO `fox_order` VALUES ('15', '201803011328207948', '201803021056266204', '1', '3', '糯米巴巴网', '上海市XXX', '18827206927', '0.01', '2018-03-01 13:28:20');
INSERT INTO `fox_order` VALUES ('16', '201803011331588013', '201803011331582799', '1', '4', '糯米巴巴网', '上海市XXX', '18827206927', '0.01', '2018-03-01 13:31:58');
INSERT INTO `fox_order` VALUES ('17', '201803021305171680', '201803021305174797', '1', '1', '糯米巴巴网', '上海市XXX', '18827206927', '27895.00', '2018-03-02 13:05:17');

-- ----------------------------
-- Table structure for fox_order_goods
-- ----------------------------
DROP TABLE IF EXISTS `fox_order_goods`;
CREATE TABLE `fox_order_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `gid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `num` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '购买数量',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  PRIMARY KEY (`id`),
  KEY `order_id` (`oid`) USING BTREE,
  KEY `goods_id` (`gid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fox_order_goods
-- ----------------------------
INSERT INTO `fox_order_goods` VALUES ('1', '1', '30', '1', '0.01');
INSERT INTO `fox_order_goods` VALUES ('2', '2', '30', '1', '0.01');
INSERT INTO `fox_order_goods` VALUES ('3', '3', '30', '1', '0.01');
INSERT INTO `fox_order_goods` VALUES ('4', '4', '30', '1', '0.01');
INSERT INTO `fox_order_goods` VALUES ('5', '5', '30', '1', '0.01');
INSERT INTO `fox_order_goods` VALUES ('6', '6', '30', '1', '0.01');
INSERT INTO `fox_order_goods` VALUES ('7', '7', '30', '1', '0.01');
INSERT INTO `fox_order_goods` VALUES ('8', '8', '30', '1', '0.01');
INSERT INTO `fox_order_goods` VALUES ('9', '9', '30', '1', '0.01');
INSERT INTO `fox_order_goods` VALUES ('10', '10', '30', '1', '0.01');
INSERT INTO `fox_order_goods` VALUES ('11', '11', '30', '1', '0.01');
INSERT INTO `fox_order_goods` VALUES ('12', '12', '30', '1', '0.01');
INSERT INTO `fox_order_goods` VALUES ('13', '13', '30', '1', '0.01');
INSERT INTO `fox_order_goods` VALUES ('14', '14', '30', '1', '0.01');
INSERT INTO `fox_order_goods` VALUES ('15', '15', '30', '1', '0.01');
INSERT INTO `fox_order_goods` VALUES ('16', '16', '30', '1', '0.01');
INSERT INTO `fox_order_goods` VALUES ('17', '17', '20', '4', '5999.00');
INSERT INTO `fox_order_goods` VALUES ('18', '17', '19', '1', '3899.00');

-- ----------------------------
-- Table structure for fox_user
-- ----------------------------
DROP TABLE IF EXISTS `fox_user`;
CREATE TABLE `fox_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `head` varchar(200) NOT NULL DEFAULT '' COMMENT '头像 从小程序获取',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '用户金额',
  `total_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '消费累计',
  `reg_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册时间',
  `openid` varchar(200) NOT NULL DEFAULT '' COMMENT '微信验证后返回openid',
  `token` varchar(32) NOT NULL DEFAULT '',
  `token_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fox_user
-- ----------------------------
INSERT INTO `fox_user` VALUES ('1', '小江', 'https://wx.qlogo.cn/mmopen/vi_32/CmN3Ax889RSbKWnXibGSqcQk6upxj3QAic58l1uBx0PbxDZqZtdCgr0aichgJPM3et1Y8kzaia0X6LeYBKDPUZ2iayQ/0', '0.00', '0.00', '2018-02-22 14:14:06', 'oEE2t4n0eerWnb2mNShyK2ttXLc0', 'QXWaG4nQlgoxuaOe3vmSJoHyiLFGk5NU', '1520247085');
