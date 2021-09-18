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

 Date: 28/03/2021 00:40:46
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_menu
-- ----------------------------
INSERT INTO `t_menu` VALUES (1, 'Permission', '/permission', 'Layout', 0, 1, '/permission/page', 0, 'admin,editor', 'Permission', 'lock', 0, 0, 1, '', '2021-03-23 13:16:07', '2021-03-23 13:16:12');
INSERT INTO `t_menu` VALUES (2, 'PagePermission', 'page', 'permission/page', 0, NULL, '', 1, 'admin', 'Page Permission', '', 0, 0, 1, '', '2021-03-23 13:31:12', '2021-03-23 13:31:14');
INSERT INTO `t_menu` VALUES (3, 'DirectivePermission', 'directive', 'permission/directive', 0, NULL, '', 1, '', 'Directive Permission', '', 0, 0, 1, '', '2021-03-23 13:33:27', '2021-03-23 13:33:29');
INSERT INTO `t_menu` VALUES (4, 'RolePermission', 'role', 'permission/role', 0, NULL, '', 1, '', 'Role Permission', '', 0, 0, 1, '', '2021-03-23 13:34:41', '2021-03-23 13:34:45');
INSERT INTO `t_menu` VALUES (5, '', '/icon', 'Layout', 0, 1, '', 0, '', '图标管理', '', 0, 0, 0, '', '2021-03-23 14:28:10', '2021-03-26 04:26:19');
INSERT INTO `t_menu` VALUES (6, 'Icons', 'index', 'icons/index', 0, NULL, '', 5, '', 'Icons', 'icon', 1, 0, 1, '', '2021-03-23 14:30:17', '2021-03-23 14:30:19');
INSERT INTO `t_menu` VALUES (7, '', '/menu', 'Layout', 0, 1, '', 0, '', '菜单管理', 'tree', 0, 0, 0, '', '2021-03-23 14:39:23', '2021-03-25 08:18:14');
INSERT INTO `t_menu` VALUES (8, 'menu', 'index', 'menu/index', 0, NULL, '', 7, 'admin', '动态菜单管理', 'tree', 0, 0, 1, '', '2021-03-23 14:45:01', '2021-03-23 14:45:03');

-- ----------------------------
-- Table structure for t_role
-- ----------------------------
DROP TABLE IF EXISTS `t_role`;
CREATE TABLE `t_role`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '角色名称',
  `tag` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '角色tag',
  `desc` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '角色描述',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_role
-- ----------------------------
INSERT INTO `t_role` VALUES (1, '管理员', 'admin', '管理员', 1615723880, 1615723880);
INSERT INTO `t_role` VALUES (2, '编辑员', 'editor', '编辑员', 1615723880, 1615723880);

-- ----------------------------
-- Table structure for t_user
-- ----------------------------
DROP TABLE IF EXISTS `t_user`;
CREATE TABLE `t_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `username` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名称',
  `email` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '邮箱',
  `phone` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '手机',
  `password` char(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `avatar` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户头像',
  `introduction` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '介绍',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_user
-- ----------------------------
INSERT INTO `t_user` VALUES (1, 'coco', '1192475069@qq.com', '18579250335', '0d6016c82daa29f5a01fefa918f16c0e', 'https://www.easyicon.net/api/resizeApi.php?id=1190167&size=64', '长得帅，又有才华', 1615707981, 1615707981);

-- ----------------------------
-- Table structure for t_user_role
-- ----------------------------
DROP TABLE IF EXISTS `t_user_role`;
CREATE TABLE `t_user_role`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(11) NOT NULL COMMENT '用户主键',
  `role_id` int(11) NOT NULL COMMENT '角色主键',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_user_role
-- ----------------------------
INSERT INTO `t_user_role` VALUES (1, 1, 1, 1615723880, 1615723880);
INSERT INTO `t_user_role` VALUES (2, 1, 2, 1615723880, 1615723880);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'admin', '1192475069@qq.com', '$2y$10$CWuanmE9w7GA1RYlBSQ1B.XAbBgNRy.1zNclhTF9NdZRrBPMtKGDm', 'egzZDINq7Vndk9JEp0behW6pHRMNL0yDGVnZwOPmp3kYiD5GaHGVeKgdEEHr', '2021-03-14 04:48:14', '2021-03-14 04:48:14');

SET FOREIGN_KEY_CHECKS = 1;
