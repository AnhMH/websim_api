/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : maishop

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-10-29 15:44:48
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Admin ID',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Vip Type',
  `account` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `description` text CHARACTER SET utf8,
  `disable` tinyint(1) DEFAULT '0',
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', '0', 'admin', 'HdH7tYt5E38XXbD-7NS3l3Y2S0s2Ri1Id1FBWndGdkpHbERnVUZORU14SzFaZUxEbFVXS2lZVk1sSXM', 'ADMIN', 'admin@gmail.com', 'Q9 - Ho Chi Minh', '0968677633', 'http://img.maishop.localhost/2017/10/28/217c38e02e569909667302e516b9c183.png', 'hoanganhonline.com', 'aaaa', null, '0', '1509165041', '1509168253');

-- ----------------------------
-- Table structure for authenticates
-- ----------------------------
DROP TABLE IF EXISTS `authenticates`;
CREATE TABLE `authenticates` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '`user_id/admin_id base on type',
  `token` varchar(255) NOT NULL DEFAULT '' COMMENT 'トークン',
  `expire_date` int(11) NOT NULL DEFAULT '0' COMMENT 'トークンの期限',
  `regist_type` varchar(20) NOT NULL COMMENT 'user/admin',
  `created` int(11) DEFAULT NULL COMMENT '作成日',
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of authenticates
-- ----------------------------
INSERT INTO `authenticates` VALUES ('17', '1', 'a7e0dd7582a9b414335c36b8d2c99389dcecabe5354528caa09f3afe639ea5e2d1c5e495159833375994705572881a663fed965478c94c8b864585bcaed47c27', '1511852867', 'admin', '1509162333');

-- ----------------------------
-- Table structure for customers
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL,
  `name` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `note` text CHARACTER SET utf8,
  `order_count` int(11) DEFAULT '0',
  `disable` tinyint(1) DEFAULT '0',
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO `customers` VALUES ('1', '1', 'Hoang Anh', 'q9 - hcm', '0968677633', 'mhanhqb1@gmail.com', 'Thang nay la admin', '0', '0', '1509245814', '1509264644');
INSERT INTO `customers` VALUES ('2', '1', 'Mai Khung', 'q9-hcm', '01286347795', 'maikhung@gmail.com', 'abc', '0', '0', '1509258953', '1509264644');
INSERT INTO `customers` VALUES ('3', '1', 'sad', 'sa', '121346', 'anh@gmail.com', 'sad', '0', '0', '1509262475', '1509264644');
INSERT INTO `customers` VALUES ('4', '1', 'sad', 'sa', '121346', 'anh@gmail.com', 'sad', '0', '0', '1509262551', '1509264644');
INSERT INTO `customers` VALUES ('5', '1', 'áda', 'ads', '2132', 'anhmh@gmail.com', 'dsfsdf', '0', '0', '1509262572', '1509264643');
INSERT INTO `customers` VALUES ('6', '1', 'sadasd', 'ads', '3442', 'anh@gmail.com', 'sadasfdsafdasf', '0', '0', '1509262609', '1509264643');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `sub_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sub_address` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sub_tel` varchar(20) DEFAULT NULL,
  `ext_cost` varchar(255) DEFAULT NULL,
  `ship_cost` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `note` text,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `disable` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of orders
-- ----------------------------

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL,
  `cate_id` int(11) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `description` text CHARACTER SET utf8,
  `detail` text CHARACTER SET utf8,
  `avatar` varchar(255) DEFAULT NULL,
  `gallery` varchar(1000) DEFAULT NULL,
  `agent_price` varchar(255) DEFAULT NULL COMMENT 'Gia dai ly',
  `price` varchar(255) DEFAULT NULL,
  `discount` tinyint(2) DEFAULT NULL COMMENT '% giam gia',
  `rate` tinyint(4) DEFAULT NULL,
  `disable` tinyint(1) DEFAULT '0',
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES ('1', null, null, 'a', null, null, null, null, null, null, '127', null, '0', null, null);

-- ----------------------------
-- Table structure for suppliers
-- ----------------------------
DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL,
  `name` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `note` text CHARACTER SET utf8,
  `order_count` int(11) DEFAULT '0',
  `disable` tinyint(1) DEFAULT '0',
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of suppliers
-- ----------------------------
DROP TRIGGER IF EXISTS `before_insert_admins`;
DELIMITER ;;
CREATE TRIGGER `before_insert_admins` BEFORE INSERT ON `admins` FOR EACH ROW SET
  new.created = UNIX_TIMESTAMP(),
  new.updated = UNIX_TIMESTAMP()
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `before_update_admins`;
DELIMITER ;;
CREATE TRIGGER `before_update_admins` BEFORE UPDATE ON `admins` FOR EACH ROW SET
   new.updated = UNIX_TIMESTAMP()
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `before_insert_authenticates`;
DELIMITER ;;
CREATE TRIGGER `before_insert_authenticates` BEFORE INSERT ON `authenticates` FOR EACH ROW SET
  new.created = UNIX_TIMESTAMP()
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `before_insert_customers`;
DELIMITER ;;
CREATE TRIGGER `before_insert_customers` BEFORE INSERT ON `customers` FOR EACH ROW SET
  new.created = UNIX_TIMESTAMP(),
  new.updated = UNIX_TIMESTAMP()
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `before_update_customers`;
DELIMITER ;;
CREATE TRIGGER `before_update_customers` BEFORE UPDATE ON `customers` FOR EACH ROW SET
   new.updated = UNIX_TIMESTAMP()
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `before_insert_orders`;
DELIMITER ;;
CREATE TRIGGER `before_insert_orders` BEFORE INSERT ON `orders` FOR EACH ROW SET
  new.created = UNIX_TIMESTAMP(),
  new.updated = UNIX_TIMESTAMP()
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `before_update_orders`;
DELIMITER ;;
CREATE TRIGGER `before_update_orders` BEFORE UPDATE ON `orders` FOR EACH ROW SET
   new.updated = UNIX_TIMESTAMP()
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `before_insert_products`;
DELIMITER ;;
CREATE TRIGGER `before_insert_products` BEFORE INSERT ON `products` FOR EACH ROW SET
  new.created = UNIX_TIMESTAMP(),
  new.updated = UNIX_TIMESTAMP()
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `before_update_products`;
DELIMITER ;;
CREATE TRIGGER `before_update_products` BEFORE UPDATE ON `products` FOR EACH ROW SET
   new.updated = UNIX_TIMESTAMP()
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `before_insert_suppliers`;
DELIMITER ;;
CREATE TRIGGER `before_insert_suppliers` BEFORE INSERT ON `suppliers` FOR EACH ROW SET
  new.created = UNIX_TIMESTAMP(),
  new.updated = UNIX_TIMESTAMP()
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `before_update_suppliers`;
DELIMITER ;;
CREATE TRIGGER `before_update_suppliers` BEFORE UPDATE ON `suppliers` FOR EACH ROW SET
   new.updated = UNIX_TIMESTAMP()
;;
DELIMITER ;
