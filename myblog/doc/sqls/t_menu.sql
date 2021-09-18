/*
 Navicat MySQL Data Transfer

 Source Server         : 本地mysql
 Source Server Type    : MySQL
 Source Server Version : 80016
 Source Host           : localhost:3306
 Source Schema         : myblog

 Target Server Type    : MySQL
 Target Server Version : 80016
 File Encoding         : 65001

 Date: 23/03/2021 19:49:30
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for t_menu
-- ----------------------------
DROP TABLE IF EXISTS `t_menu`;
CREATE TABLE `t_menu`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '路由名称',
  `path` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '路径',
  `component` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '组件名称',
  `hidden` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否隐藏',
  `alwaysShow` tinyint(1) NULL DEFAULT NULL COMMENT '设置一级菜单，是否总是显示',
  `redirect` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '面包屑是否重定向',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT '父路由',
  `roles` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '允许访问的角色',
  `title` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '左侧导航栏和面包屑显示名称',
  `icon` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '图标',
  `noCache` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否不要缓存',
  `affix` tinyint(1) NOT NULL DEFAULT 0 COMMENT '标签页是否总是显示',
  `breadcrumb` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否显示面包屑',
  `activeMenu` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '左侧菜单高亮',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  `update_time` datetime(0) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_menu
-- ----------------------------
INSERT INTO `t_menu` VALUES (1, 'Permission', '/permission', 'Layout', 0, 1, '/permission/page', 0, 'admin,editor', 'Permission', 'lock', 0, 0, 1, '', '2021-03-23 13:16:07', '2021-03-23 13:16:12');
INSERT INTO `t_menu` VALUES (2, 'PagePermission', 'page', 'permission/page', 0, NULL, '', 1, 'admin', 'Page Permission', '', 0, 0, 1, '', '2021-03-23 13:31:12', '2021-03-23 13:31:14');
INSERT INTO `t_menu` VALUES (3, 'DirectivePermission', 'directive', 'permission/directive', 0, NULL, '', 1, '', 'Directive Permission', '', 0, 0, 1, '', '2021-03-23 13:33:27', '2021-03-23 13:33:29');
INSERT INTO `t_menu` VALUES (4, 'RolePermission', 'role', 'permission/role', 0, NULL, '', 1, '', 'Role Permission', '', 0, 0, 1, '', '2021-03-23 13:34:41', '2021-03-23 13:34:45');
INSERT INTO `t_menu` VALUES (5, '', '/icon', 'Layout', 0, NULL, '', 0, '', '图标管理', '', 0, 0, 1, '', '2021-03-23 14:28:10', '2021-03-23 14:28:15');
INSERT INTO `t_menu` VALUES (6, 'Icons', 'index', 'icons/index', 0, NULL, '', 5, '', 'Icons', 'icon', 1, 0, 1, '', '2021-03-23 14:30:17', '2021-03-23 14:30:19');
INSERT INTO `t_menu` VALUES (7, '', '/menu', 'Layout', 0, NULL, '', 0, '', '菜单管理', '', 0, 0, 1, '', '2021-03-23 14:39:23', '2021-03-23 14:39:28');
INSERT INTO `t_menu` VALUES (8, 'menu', 'index', 'menu/index', 0, NULL, '', 7, 'admin', '动态菜单管理', 'tree', 0, 0, 1, '', '2021-03-23 14:45:01', '2021-03-23 14:45:03');

SET FOREIGN_KEY_CHECKS = 1;
