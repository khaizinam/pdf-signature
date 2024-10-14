/*
 Navicat Premium Data Transfer

 Source Server         : dev_signature_161
 Source Server Type    : MySQL
 Source Server Version : 100608
 Source Host           : 192.168.10.161:3306
 Source Schema         : dev_signature

 Target Server Type    : MySQL
 Target Server Version : 100608
 File Encoding         : 65001

 Date: 14/10/2024 14:12:44
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for activations
-- ----------------------------
DROP TABLE IF EXISTS `activations`;
CREATE TABLE `activations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `code` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `activations_user_id_index`(`user_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of activations
-- ----------------------------
INSERT INTO `activations` VALUES (1, 1, 'o2KEgj2NA5FIiZVueYEBsSHxNVrBibks', 1, '2024-08-27 04:25:54', '2024-08-27 04:25:54', '2024-08-27 04:25:54');
INSERT INTO `activations` VALUES (2, 2, '0CbveaBGpxdslJUmrV9R4fFu7eGBdDqK', 1, '2024-10-12 15:38:41', '2024-10-12 15:38:41', '2024-10-12 15:38:41');

-- ----------------------------
-- Table structure for admin_notifications
-- ----------------------------
DROP TABLE IF EXISTS `admin_notifications`;
CREATE TABLE `admin_notifications`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_label` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `action_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `permission` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of admin_notifications
-- ----------------------------

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint UNSIGNED NOT NULL DEFAULT 0,
  `description` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `author_id` bigint UNSIGNED NULL DEFAULT NULL,
  `author_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Dev\\ACL\\Models\\User',
  `icon` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `order` int UNSIGNED NOT NULL DEFAULT 0,
  `is_featured` tinyint NOT NULL DEFAULT 0,
  `is_default` tinyint UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `categories_parent_id_index`(`parent_id` ASC) USING BTREE,
  INDEX `categories_status_index`(`status` ASC) USING BTREE,
  INDEX `categories_created_at_index`(`created_at` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (1, 'Artificial Intelligence', 0, 'Assumenda blanditiis dignissimos iure non et quia voluptatem. Nihil sed eveniet nobis eaque est fuga perspiciatis. Natus et blanditiis eius necessitatibus soluta dicta omnis.', 'published', 1, 'Dev\\ACL\\Models\\User', NULL, 0, 0, 0, '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `categories` VALUES (2, 'Cybersecurity', 0, 'Maxime modi aut est cum culpa ipsam ipsum. Neque vel omnis eius tempora rerum. Omnis hic nihil praesentium qui. Qui blanditiis omnis voluptatem soluta.', 'published', 1, 'Dev\\ACL\\Models\\User', NULL, 0, 1, 0, '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `categories` VALUES (3, 'Blockchain Technology', 0, 'Culpa doloremque est aut amet. Qui voluptate veniam unde enim excepturi. Similique exercitationem eveniet suscipit reiciendis. Quia ut amet voluptatem saepe. Iusto occaecati perferendis corrupti.', 'published', 1, 'Dev\\ACL\\Models\\User', NULL, 0, 1, 0, '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `categories` VALUES (4, '5G and Connectivity', 0, 'Enim sit aut facere ipsum dolores corrupti at reprehenderit. Ea illum doloribus et tempore maiores iure. Laboriosam iste enim non expedita minima libero.', 'published', 1, 'Dev\\ACL\\Models\\User', NULL, 0, 1, 0, '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `categories` VALUES (5, 'Augmented Reality (AR)', 0, 'Ipsam quam rerum est. Sint delectus enim neque nemo quod. Quia voluptatem dolore eum ad. Et quos molestias voluptas animi est quidem. Dolor eligendi reiciendis asperiores libero.', 'published', 1, 'Dev\\ACL\\Models\\User', NULL, 0, 1, 0, '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `categories` VALUES (6, 'Green Technology', 0, 'Autem quis eos odit tempora. Sed error a mollitia ut vitae eaque quam laudantium. Deserunt magni culpa suscipit ad veritatis.', 'published', 1, 'Dev\\ACL\\Models\\User', NULL, 0, 1, 0, '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `categories` VALUES (7, 'Quantum Computing', 0, 'In provident earum sit perferendis harum explicabo. Qui distinctio rerum veritatis iure totam ut nisi. Sequi sint omnis necessitatibus.', 'published', 1, 'Dev\\ACL\\Models\\User', NULL, 0, 1, 0, '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `categories` VALUES (8, 'Edge Computing', 0, 'Vitae inventore esse cumque labore. Qui non nihil maiores dolorum. Voluptatem iure quia aliquam eligendi. Eum adipisci ipsum natus assumenda exercitationem voluptatem.', 'published', 1, 'Dev\\ACL\\Models\\User', NULL, 0, 1, 0, '2024-08-27 04:25:56', '2024-08-27 04:25:56');

-- ----------------------------
-- Table structure for categories_translations
-- ----------------------------
DROP TABLE IF EXISTS `categories_translations`;
CREATE TABLE `categories_translations`  (
  `lang_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `categories_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`lang_code`, `categories_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of categories_translations
-- ----------------------------

-- ----------------------------
-- Table structure for contract_managements
-- ----------------------------
DROP TABLE IF EXISTS `contract_managements`;
CREATE TABLE `contract_managements`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Link file pdf',
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Mô tả',
  `user_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Người đăng',
  `status` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of contract_managements
-- ----------------------------
INSERT INTO `contract_managements` VALUES (1, 'Hợp đồng tháng 10 2', 'dacn-231-gd-2-report.pdf', NULL, NULL, 'published', '2024-10-11 19:23:55', '2024-10-14 11:08:39');
INSERT INTO `contract_managements` VALUES (9, 'Test trên local', 'ae21bfe63f107d5dc4e8861380409aaf-6.pdf', NULL, NULL, 'published', '2024-10-13 20:20:32', '2024-10-14 11:41:37');

-- ----------------------------
-- Table structure for custom_fields
-- ----------------------------
DROP TABLE IF EXISTS `custom_fields`;
CREATE TABLE `custom_fields`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `use_for` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `use_for_id` bigint UNSIGNED NOT NULL,
  `field_item_id` bigint UNSIGNED NOT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `custom_fields_field_item_id_index`(`field_item_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of custom_fields
-- ----------------------------

-- ----------------------------
-- Table structure for custom_fields_translations
-- ----------------------------
DROP TABLE IF EXISTS `custom_fields_translations`;
CREATE TABLE `custom_fields_translations`  (
  `lang_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_fields_id` bigint UNSIGNED NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`lang_code`, `custom_fields_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of custom_fields_translations
-- ----------------------------

-- ----------------------------
-- Table structure for dashboard_widget_settings
-- ----------------------------
DROP TABLE IF EXISTS `dashboard_widget_settings`;
CREATE TABLE `dashboard_widget_settings`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `settings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `widget_id` bigint UNSIGNED NOT NULL,
  `order` tinyint UNSIGNED NOT NULL DEFAULT 0,
  `status` tinyint UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `dashboard_widget_settings_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `dashboard_widget_settings_widget_id_index`(`widget_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of dashboard_widget_settings
-- ----------------------------

-- ----------------------------
-- Table structure for dashboard_widgets
-- ----------------------------
DROP TABLE IF EXISTS `dashboard_widgets`;
CREATE TABLE `dashboard_widgets`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of dashboard_widgets
-- ----------------------------
INSERT INTO `dashboard_widgets` VALUES (1, 'widget_total_themes', '2024-10-07 13:56:18', '2024-10-07 13:56:18');
INSERT INTO `dashboard_widgets` VALUES (2, 'widget_total_users', '2024-10-07 13:56:18', '2024-10-07 13:56:18');
INSERT INTO `dashboard_widgets` VALUES (3, 'widget_total_plugins', '2024-10-07 13:56:18', '2024-10-07 13:56:18');
INSERT INTO `dashboard_widgets` VALUES (4, 'widget_total_pages', '2024-10-07 13:56:18', '2024-10-07 13:56:18');
INSERT INTO `dashboard_widgets` VALUES (5, 'widget_posts_recent', '2024-10-07 13:56:18', '2024-10-07 13:56:18');
INSERT INTO `dashboard_widgets` VALUES (6, 'widget_audit_logs', '2024-10-07 13:56:18', '2024-10-07 13:56:18');
INSERT INTO `dashboard_widgets` VALUES (7, 'widget_request_errors', '2024-10-07 13:56:18', '2024-10-07 13:56:18');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for field_groups
-- ----------------------------
DROP TABLE IF EXISTS `field_groups`;
CREATE TABLE `field_groups`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rules` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `order` int NOT NULL DEFAULT 0,
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED NULL DEFAULT NULL,
  `status` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `field_groups_created_by_index`(`created_by` ASC) USING BTREE,
  INDEX `field_groups_updated_by_index`(`updated_by` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of field_groups
-- ----------------------------

-- ----------------------------
-- Table structure for field_items
-- ----------------------------
DROP TABLE IF EXISTS `field_items`;
CREATE TABLE `field_items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `field_group_id` bigint UNSIGNED NOT NULL,
  `parent_id` bigint UNSIGNED NULL DEFAULT NULL,
  `order` int NULL DEFAULT 0,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `instructions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `options` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `field_items_field_group_id_index`(`field_group_id` ASC) USING BTREE,
  INDEX `field_items_parent_id_index`(`parent_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of field_items
-- ----------------------------

-- ----------------------------
-- Table structure for galleries
-- ----------------------------
DROP TABLE IF EXISTS `galleries`;
CREATE TABLE `galleries`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_featured` tinyint UNSIGNED NOT NULL DEFAULT 0,
  `order` tinyint UNSIGNED NOT NULL DEFAULT 0,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `status` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `galleries_user_id_index`(`user_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of galleries
-- ----------------------------
INSERT INTO `galleries` VALUES (1, 'Sunset', 'Pariatur quisquam rerum est minus ea. Magni vero quibusdam non et ex asperiores harum. Explicabo beatae culpa iste mollitia quo sunt a dolores.', 1, 0, 'news/6.jpg', 1, 'published', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `galleries` VALUES (2, 'Ocean Views', 'Maxime voluptas consequatur cumque non. Aliquid vero illo ratione vero. Sed et quidem natus rem.', 1, 0, 'news/7.jpg', 1, 'published', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `galleries` VALUES (3, 'Adventure Time', 'Minus tempore veritatis exercitationem inventore. Et ea dicta ab quo neque molestiae. Culpa sequi ut eius quaerat rem velit sint.', 1, 0, 'news/8.jpg', 1, 'published', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `galleries` VALUES (4, 'City Lights', 'Repellendus consequatur quod minima minus eius itaque. Sit fugiat esse adipisci minima veritatis necessitatibus rerum.', 1, 0, 'news/9.jpg', 1, 'published', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `galleries` VALUES (5, 'Dreamscape', 'Quia nulla quia ad iure ex laboriosam. Suscipit asperiores ipsum possimus commodi facere doloribus dignissimos.', 1, 0, 'news/10.jpg', 1, 'published', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `galleries` VALUES (6, 'Enchanted Forest', 'Aspernatur et quia quaerat. Eum debitis quidem sunt sapiente minima.', 1, 0, 'news/11.jpg', 1, 'published', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `galleries` VALUES (7, 'Golden Hour', 'Necessitatibus sed id consequatur quia. Molestias qui sapiente sunt est. Commodi ut velit neque eveniet eos accusantium.', 0, 0, 'news/12.jpg', 1, 'published', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `galleries` VALUES (8, 'Serenity', 'Ratione temporibus sequi consequuntur veniam ea quia. Expedita voluptates et dolor aliquid incidunt rem repellat qui. Velit eos quasi sit.', 0, 0, 'news/13.jpg', 1, 'published', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `galleries` VALUES (9, 'Eternal Beauty', 'Omnis repellendus minima molestias id. Eum magnam sit voluptatem magnam modi. Ipsam consectetur labore nulla nam.', 0, 0, 'news/14.jpg', 1, 'published', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `galleries` VALUES (10, 'Moonlight Magic', 'Vero omnis quo quasi dolor. Molestiae laudantium at inventore unde. Eum aliquid laborum ut qui maxime et. Est voluptatem odit praesentium.', 0, 0, 'news/15.jpg', 1, 'published', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `galleries` VALUES (11, 'Starry Night', 'Rerum et beatae nesciunt rerum illo. Necessitatibus quos aut reprehenderit porro in. Aut officiis amet hic asperiores est soluta.', 0, 0, 'news/16.jpg', 1, 'published', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `galleries` VALUES (12, 'Hidden Gems', 'Dignissimos est ut et incidunt qui quia. Laboriosam aut itaque adipisci exercitationem quos error sint. Dolorum velit id quidem unde.', 0, 0, 'news/17.jpg', 1, 'published', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `galleries` VALUES (13, 'Tranquil Waters', 'Beatae unde numquam aperiam quo nobis quae. Ut omnis illo error ut est quo quo. Neque a laudantium repellendus et natus.', 0, 0, 'news/18.jpg', 1, 'published', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `galleries` VALUES (14, 'Urban Escape', 'Distinctio quasi modi quia debitis quo. Tenetur sint et vero eos.', 0, 0, 'news/19.jpg', 1, 'published', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `galleries` VALUES (15, 'Twilight Zone', 'Dolores iste inventore repellat ea. Dolore perspiciatis veritatis quia adipisci. Rerum et sunt sed maiores a numquam.', 0, 0, 'news/20.jpg', 1, 'published', '2024-08-27 04:25:57', '2024-08-27 04:25:57');

-- ----------------------------
-- Table structure for galleries_translations
-- ----------------------------
DROP TABLE IF EXISTS `galleries_translations`;
CREATE TABLE `galleries_translations`  (
  `lang_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `galleries_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`lang_code`, `galleries_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of galleries_translations
-- ----------------------------

-- ----------------------------
-- Table structure for gallery_meta
-- ----------------------------
DROP TABLE IF EXISTS `gallery_meta`;
CREATE TABLE `gallery_meta`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `reference_id` bigint UNSIGNED NOT NULL,
  `reference_type` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `gallery_meta_reference_id_index`(`reference_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of gallery_meta
-- ----------------------------
INSERT INTO `gallery_meta` VALUES (1, '[{\"img\":\"news\\/1.jpg\",\"description\":\"Tenetur dolores et et ut. Ipsam aliquid minus consequatur at. Qui amet sapiente enim et possimus animi tenetur qui. Totam molestiae ex in.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Quod sequi deleniti qui rem voluptatem natus. Rerum et sunt totam nihil excepturi.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Voluptatem tempora in qui fugiat. Et voluptatum voluptatem quis id iste. Dolor perspiciatis sit et sit facere molestiae omnis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Dolorem et error sed. Veniam modi qui neque sed commodi eveniet recusandae. Voluptates error qui est nisi dolorem minus ratione.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Est qui nam soluta. Pariatur unde alias quae nulla libero. Quas debitis in eius aliquid qui dolorem culpa.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Iure minima ratione perspiciatis dolorum. In voluptatem in ea. Id et et quibusdam eos. Eius eum neque cupiditate rerum quia ad et.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Quis sit aut nesciunt quidem ut cupiditate. Autem qui molestias illo voluptas. Officiis iure ipsa eveniet alias nesciunt ipsum expedita.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Excepturi repudiandae quaerat similique nihil. Perspiciatis vel itaque qui nam sed occaecati quo. Eius sunt nostrum ut veniam quam.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Ea eveniet et enim numquam. Similique neque dolores officia possimus. Ullam voluptatem id et eveniet voluptas.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Voluptas iure et impedit eaque quasi. Sed harum quam omnis unde.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"A corporis voluptate quibusdam quis. Omnis quia minus commodi. Consequatur quos repudiandae deleniti est.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Distinctio voluptates velit quas quo quia cum commodi. Sit est blanditiis aspernatur dolore a. Harum vitae harum laboriosam dolores et et nulla.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Facere sit vitae ea dolorem tempore et. Autem sed voluptas voluptas id voluptas et. Inventore autem id nobis nobis ex architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Quia repellat culpa rerum nulla at eveniet. Cum vitae voluptatum temporibus voluptatem inventore. Quisquam maiores voluptatum ut voluptas recusandae.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Aut quisquam occaecati qui inventore commodi quia eum. Ullam eligendi sed sed aut voluptatem. Velit libero nemo iusto officiis aut.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Et neque et perferendis laudantium. Autem tempore eum et adipisci similique sunt iste. Qui quidem itaque nam ut.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Ducimus voluptate velit vitae ducimus dolorem vel tempore. Repellendus delectus magni labore est enim. Voluptatem quo molestias assumenda nisi.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Sint error debitis totam sint aut neque. Quis est debitis quidem autem voluptatem eveniet commodi ex. Facere a porro rerum neque tempore in natus.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Rerum aliquid aliquam nostrum. Dignissimos nobis atque enim qui exercitationem et distinctio. At ut est repellat molestias voluptatum.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Repellat provident saepe ipsa possimus. Facilis consequatur voluptatem impedit inventore rerum non. Veritatis sunt consectetur velit blanditiis.\"}]', 1, 'Dev\\Gallery\\Models\\Gallery', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `gallery_meta` VALUES (2, '[{\"img\":\"news\\/1.jpg\",\"description\":\"Tenetur dolores et et ut. Ipsam aliquid minus consequatur at. Qui amet sapiente enim et possimus animi tenetur qui. Totam molestiae ex in.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Quod sequi deleniti qui rem voluptatem natus. Rerum et sunt totam nihil excepturi.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Voluptatem tempora in qui fugiat. Et voluptatum voluptatem quis id iste. Dolor perspiciatis sit et sit facere molestiae omnis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Dolorem et error sed. Veniam modi qui neque sed commodi eveniet recusandae. Voluptates error qui est nisi dolorem minus ratione.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Est qui nam soluta. Pariatur unde alias quae nulla libero. Quas debitis in eius aliquid qui dolorem culpa.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Iure minima ratione perspiciatis dolorum. In voluptatem in ea. Id et et quibusdam eos. Eius eum neque cupiditate rerum quia ad et.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Quis sit aut nesciunt quidem ut cupiditate. Autem qui molestias illo voluptas. Officiis iure ipsa eveniet alias nesciunt ipsum expedita.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Excepturi repudiandae quaerat similique nihil. Perspiciatis vel itaque qui nam sed occaecati quo. Eius sunt nostrum ut veniam quam.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Ea eveniet et enim numquam. Similique neque dolores officia possimus. Ullam voluptatem id et eveniet voluptas.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Voluptas iure et impedit eaque quasi. Sed harum quam omnis unde.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"A corporis voluptate quibusdam quis. Omnis quia minus commodi. Consequatur quos repudiandae deleniti est.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Distinctio voluptates velit quas quo quia cum commodi. Sit est blanditiis aspernatur dolore a. Harum vitae harum laboriosam dolores et et nulla.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Facere sit vitae ea dolorem tempore et. Autem sed voluptas voluptas id voluptas et. Inventore autem id nobis nobis ex architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Quia repellat culpa rerum nulla at eveniet. Cum vitae voluptatum temporibus voluptatem inventore. Quisquam maiores voluptatum ut voluptas recusandae.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Aut quisquam occaecati qui inventore commodi quia eum. Ullam eligendi sed sed aut voluptatem. Velit libero nemo iusto officiis aut.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Et neque et perferendis laudantium. Autem tempore eum et adipisci similique sunt iste. Qui quidem itaque nam ut.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Ducimus voluptate velit vitae ducimus dolorem vel tempore. Repellendus delectus magni labore est enim. Voluptatem quo molestias assumenda nisi.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Sint error debitis totam sint aut neque. Quis est debitis quidem autem voluptatem eveniet commodi ex. Facere a porro rerum neque tempore in natus.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Rerum aliquid aliquam nostrum. Dignissimos nobis atque enim qui exercitationem et distinctio. At ut est repellat molestias voluptatum.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Repellat provident saepe ipsa possimus. Facilis consequatur voluptatem impedit inventore rerum non. Veritatis sunt consectetur velit blanditiis.\"}]', 2, 'Dev\\Gallery\\Models\\Gallery', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `gallery_meta` VALUES (3, '[{\"img\":\"news\\/1.jpg\",\"description\":\"Tenetur dolores et et ut. Ipsam aliquid minus consequatur at. Qui amet sapiente enim et possimus animi tenetur qui. Totam molestiae ex in.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Quod sequi deleniti qui rem voluptatem natus. Rerum et sunt totam nihil excepturi.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Voluptatem tempora in qui fugiat. Et voluptatum voluptatem quis id iste. Dolor perspiciatis sit et sit facere molestiae omnis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Dolorem et error sed. Veniam modi qui neque sed commodi eveniet recusandae. Voluptates error qui est nisi dolorem minus ratione.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Est qui nam soluta. Pariatur unde alias quae nulla libero. Quas debitis in eius aliquid qui dolorem culpa.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Iure minima ratione perspiciatis dolorum. In voluptatem in ea. Id et et quibusdam eos. Eius eum neque cupiditate rerum quia ad et.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Quis sit aut nesciunt quidem ut cupiditate. Autem qui molestias illo voluptas. Officiis iure ipsa eveniet alias nesciunt ipsum expedita.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Excepturi repudiandae quaerat similique nihil. Perspiciatis vel itaque qui nam sed occaecati quo. Eius sunt nostrum ut veniam quam.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Ea eveniet et enim numquam. Similique neque dolores officia possimus. Ullam voluptatem id et eveniet voluptas.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Voluptas iure et impedit eaque quasi. Sed harum quam omnis unde.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"A corporis voluptate quibusdam quis. Omnis quia minus commodi. Consequatur quos repudiandae deleniti est.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Distinctio voluptates velit quas quo quia cum commodi. Sit est blanditiis aspernatur dolore a. Harum vitae harum laboriosam dolores et et nulla.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Facere sit vitae ea dolorem tempore et. Autem sed voluptas voluptas id voluptas et. Inventore autem id nobis nobis ex architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Quia repellat culpa rerum nulla at eveniet. Cum vitae voluptatum temporibus voluptatem inventore. Quisquam maiores voluptatum ut voluptas recusandae.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Aut quisquam occaecati qui inventore commodi quia eum. Ullam eligendi sed sed aut voluptatem. Velit libero nemo iusto officiis aut.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Et neque et perferendis laudantium. Autem tempore eum et adipisci similique sunt iste. Qui quidem itaque nam ut.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Ducimus voluptate velit vitae ducimus dolorem vel tempore. Repellendus delectus magni labore est enim. Voluptatem quo molestias assumenda nisi.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Sint error debitis totam sint aut neque. Quis est debitis quidem autem voluptatem eveniet commodi ex. Facere a porro rerum neque tempore in natus.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Rerum aliquid aliquam nostrum. Dignissimos nobis atque enim qui exercitationem et distinctio. At ut est repellat molestias voluptatum.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Repellat provident saepe ipsa possimus. Facilis consequatur voluptatem impedit inventore rerum non. Veritatis sunt consectetur velit blanditiis.\"}]', 3, 'Dev\\Gallery\\Models\\Gallery', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `gallery_meta` VALUES (4, '[{\"img\":\"news\\/1.jpg\",\"description\":\"Tenetur dolores et et ut. Ipsam aliquid minus consequatur at. Qui amet sapiente enim et possimus animi tenetur qui. Totam molestiae ex in.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Quod sequi deleniti qui rem voluptatem natus. Rerum et sunt totam nihil excepturi.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Voluptatem tempora in qui fugiat. Et voluptatum voluptatem quis id iste. Dolor perspiciatis sit et sit facere molestiae omnis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Dolorem et error sed. Veniam modi qui neque sed commodi eveniet recusandae. Voluptates error qui est nisi dolorem minus ratione.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Est qui nam soluta. Pariatur unde alias quae nulla libero. Quas debitis in eius aliquid qui dolorem culpa.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Iure minima ratione perspiciatis dolorum. In voluptatem in ea. Id et et quibusdam eos. Eius eum neque cupiditate rerum quia ad et.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Quis sit aut nesciunt quidem ut cupiditate. Autem qui molestias illo voluptas. Officiis iure ipsa eveniet alias nesciunt ipsum expedita.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Excepturi repudiandae quaerat similique nihil. Perspiciatis vel itaque qui nam sed occaecati quo. Eius sunt nostrum ut veniam quam.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Ea eveniet et enim numquam. Similique neque dolores officia possimus. Ullam voluptatem id et eveniet voluptas.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Voluptas iure et impedit eaque quasi. Sed harum quam omnis unde.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"A corporis voluptate quibusdam quis. Omnis quia minus commodi. Consequatur quos repudiandae deleniti est.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Distinctio voluptates velit quas quo quia cum commodi. Sit est blanditiis aspernatur dolore a. Harum vitae harum laboriosam dolores et et nulla.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Facere sit vitae ea dolorem tempore et. Autem sed voluptas voluptas id voluptas et. Inventore autem id nobis nobis ex architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Quia repellat culpa rerum nulla at eveniet. Cum vitae voluptatum temporibus voluptatem inventore. Quisquam maiores voluptatum ut voluptas recusandae.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Aut quisquam occaecati qui inventore commodi quia eum. Ullam eligendi sed sed aut voluptatem. Velit libero nemo iusto officiis aut.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Et neque et perferendis laudantium. Autem tempore eum et adipisci similique sunt iste. Qui quidem itaque nam ut.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Ducimus voluptate velit vitae ducimus dolorem vel tempore. Repellendus delectus magni labore est enim. Voluptatem quo molestias assumenda nisi.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Sint error debitis totam sint aut neque. Quis est debitis quidem autem voluptatem eveniet commodi ex. Facere a porro rerum neque tempore in natus.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Rerum aliquid aliquam nostrum. Dignissimos nobis atque enim qui exercitationem et distinctio. At ut est repellat molestias voluptatum.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Repellat provident saepe ipsa possimus. Facilis consequatur voluptatem impedit inventore rerum non. Veritatis sunt consectetur velit blanditiis.\"}]', 4, 'Dev\\Gallery\\Models\\Gallery', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `gallery_meta` VALUES (5, '[{\"img\":\"news\\/1.jpg\",\"description\":\"Tenetur dolores et et ut. Ipsam aliquid minus consequatur at. Qui amet sapiente enim et possimus animi tenetur qui. Totam molestiae ex in.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Quod sequi deleniti qui rem voluptatem natus. Rerum et sunt totam nihil excepturi.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Voluptatem tempora in qui fugiat. Et voluptatum voluptatem quis id iste. Dolor perspiciatis sit et sit facere molestiae omnis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Dolorem et error sed. Veniam modi qui neque sed commodi eveniet recusandae. Voluptates error qui est nisi dolorem minus ratione.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Est qui nam soluta. Pariatur unde alias quae nulla libero. Quas debitis in eius aliquid qui dolorem culpa.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Iure minima ratione perspiciatis dolorum. In voluptatem in ea. Id et et quibusdam eos. Eius eum neque cupiditate rerum quia ad et.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Quis sit aut nesciunt quidem ut cupiditate. Autem qui molestias illo voluptas. Officiis iure ipsa eveniet alias nesciunt ipsum expedita.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Excepturi repudiandae quaerat similique nihil. Perspiciatis vel itaque qui nam sed occaecati quo. Eius sunt nostrum ut veniam quam.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Ea eveniet et enim numquam. Similique neque dolores officia possimus. Ullam voluptatem id et eveniet voluptas.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Voluptas iure et impedit eaque quasi. Sed harum quam omnis unde.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"A corporis voluptate quibusdam quis. Omnis quia minus commodi. Consequatur quos repudiandae deleniti est.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Distinctio voluptates velit quas quo quia cum commodi. Sit est blanditiis aspernatur dolore a. Harum vitae harum laboriosam dolores et et nulla.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Facere sit vitae ea dolorem tempore et. Autem sed voluptas voluptas id voluptas et. Inventore autem id nobis nobis ex architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Quia repellat culpa rerum nulla at eveniet. Cum vitae voluptatum temporibus voluptatem inventore. Quisquam maiores voluptatum ut voluptas recusandae.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Aut quisquam occaecati qui inventore commodi quia eum. Ullam eligendi sed sed aut voluptatem. Velit libero nemo iusto officiis aut.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Et neque et perferendis laudantium. Autem tempore eum et adipisci similique sunt iste. Qui quidem itaque nam ut.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Ducimus voluptate velit vitae ducimus dolorem vel tempore. Repellendus delectus magni labore est enim. Voluptatem quo molestias assumenda nisi.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Sint error debitis totam sint aut neque. Quis est debitis quidem autem voluptatem eveniet commodi ex. Facere a porro rerum neque tempore in natus.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Rerum aliquid aliquam nostrum. Dignissimos nobis atque enim qui exercitationem et distinctio. At ut est repellat molestias voluptatum.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Repellat provident saepe ipsa possimus. Facilis consequatur voluptatem impedit inventore rerum non. Veritatis sunt consectetur velit blanditiis.\"}]', 5, 'Dev\\Gallery\\Models\\Gallery', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `gallery_meta` VALUES (6, '[{\"img\":\"news\\/1.jpg\",\"description\":\"Tenetur dolores et et ut. Ipsam aliquid minus consequatur at. Qui amet sapiente enim et possimus animi tenetur qui. Totam molestiae ex in.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Quod sequi deleniti qui rem voluptatem natus. Rerum et sunt totam nihil excepturi.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Voluptatem tempora in qui fugiat. Et voluptatum voluptatem quis id iste. Dolor perspiciatis sit et sit facere molestiae omnis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Dolorem et error sed. Veniam modi qui neque sed commodi eveniet recusandae. Voluptates error qui est nisi dolorem minus ratione.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Est qui nam soluta. Pariatur unde alias quae nulla libero. Quas debitis in eius aliquid qui dolorem culpa.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Iure minima ratione perspiciatis dolorum. In voluptatem in ea. Id et et quibusdam eos. Eius eum neque cupiditate rerum quia ad et.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Quis sit aut nesciunt quidem ut cupiditate. Autem qui molestias illo voluptas. Officiis iure ipsa eveniet alias nesciunt ipsum expedita.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Excepturi repudiandae quaerat similique nihil. Perspiciatis vel itaque qui nam sed occaecati quo. Eius sunt nostrum ut veniam quam.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Ea eveniet et enim numquam. Similique neque dolores officia possimus. Ullam voluptatem id et eveniet voluptas.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Voluptas iure et impedit eaque quasi. Sed harum quam omnis unde.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"A corporis voluptate quibusdam quis. Omnis quia minus commodi. Consequatur quos repudiandae deleniti est.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Distinctio voluptates velit quas quo quia cum commodi. Sit est blanditiis aspernatur dolore a. Harum vitae harum laboriosam dolores et et nulla.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Facere sit vitae ea dolorem tempore et. Autem sed voluptas voluptas id voluptas et. Inventore autem id nobis nobis ex architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Quia repellat culpa rerum nulla at eveniet. Cum vitae voluptatum temporibus voluptatem inventore. Quisquam maiores voluptatum ut voluptas recusandae.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Aut quisquam occaecati qui inventore commodi quia eum. Ullam eligendi sed sed aut voluptatem. Velit libero nemo iusto officiis aut.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Et neque et perferendis laudantium. Autem tempore eum et adipisci similique sunt iste. Qui quidem itaque nam ut.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Ducimus voluptate velit vitae ducimus dolorem vel tempore. Repellendus delectus magni labore est enim. Voluptatem quo molestias assumenda nisi.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Sint error debitis totam sint aut neque. Quis est debitis quidem autem voluptatem eveniet commodi ex. Facere a porro rerum neque tempore in natus.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Rerum aliquid aliquam nostrum. Dignissimos nobis atque enim qui exercitationem et distinctio. At ut est repellat molestias voluptatum.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Repellat provident saepe ipsa possimus. Facilis consequatur voluptatem impedit inventore rerum non. Veritatis sunt consectetur velit blanditiis.\"}]', 6, 'Dev\\Gallery\\Models\\Gallery', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `gallery_meta` VALUES (7, '[{\"img\":\"news\\/1.jpg\",\"description\":\"Tenetur dolores et et ut. Ipsam aliquid minus consequatur at. Qui amet sapiente enim et possimus animi tenetur qui. Totam molestiae ex in.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Quod sequi deleniti qui rem voluptatem natus. Rerum et sunt totam nihil excepturi.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Voluptatem tempora in qui fugiat. Et voluptatum voluptatem quis id iste. Dolor perspiciatis sit et sit facere molestiae omnis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Dolorem et error sed. Veniam modi qui neque sed commodi eveniet recusandae. Voluptates error qui est nisi dolorem minus ratione.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Est qui nam soluta. Pariatur unde alias quae nulla libero. Quas debitis in eius aliquid qui dolorem culpa.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Iure minima ratione perspiciatis dolorum. In voluptatem in ea. Id et et quibusdam eos. Eius eum neque cupiditate rerum quia ad et.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Quis sit aut nesciunt quidem ut cupiditate. Autem qui molestias illo voluptas. Officiis iure ipsa eveniet alias nesciunt ipsum expedita.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Excepturi repudiandae quaerat similique nihil. Perspiciatis vel itaque qui nam sed occaecati quo. Eius sunt nostrum ut veniam quam.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Ea eveniet et enim numquam. Similique neque dolores officia possimus. Ullam voluptatem id et eveniet voluptas.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Voluptas iure et impedit eaque quasi. Sed harum quam omnis unde.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"A corporis voluptate quibusdam quis. Omnis quia minus commodi. Consequatur quos repudiandae deleniti est.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Distinctio voluptates velit quas quo quia cum commodi. Sit est blanditiis aspernatur dolore a. Harum vitae harum laboriosam dolores et et nulla.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Facere sit vitae ea dolorem tempore et. Autem sed voluptas voluptas id voluptas et. Inventore autem id nobis nobis ex architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Quia repellat culpa rerum nulla at eveniet. Cum vitae voluptatum temporibus voluptatem inventore. Quisquam maiores voluptatum ut voluptas recusandae.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Aut quisquam occaecati qui inventore commodi quia eum. Ullam eligendi sed sed aut voluptatem. Velit libero nemo iusto officiis aut.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Et neque et perferendis laudantium. Autem tempore eum et adipisci similique sunt iste. Qui quidem itaque nam ut.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Ducimus voluptate velit vitae ducimus dolorem vel tempore. Repellendus delectus magni labore est enim. Voluptatem quo molestias assumenda nisi.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Sint error debitis totam sint aut neque. Quis est debitis quidem autem voluptatem eveniet commodi ex. Facere a porro rerum neque tempore in natus.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Rerum aliquid aliquam nostrum. Dignissimos nobis atque enim qui exercitationem et distinctio. At ut est repellat molestias voluptatum.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Repellat provident saepe ipsa possimus. Facilis consequatur voluptatem impedit inventore rerum non. Veritatis sunt consectetur velit blanditiis.\"}]', 7, 'Dev\\Gallery\\Models\\Gallery', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `gallery_meta` VALUES (8, '[{\"img\":\"news\\/1.jpg\",\"description\":\"Tenetur dolores et et ut. Ipsam aliquid minus consequatur at. Qui amet sapiente enim et possimus animi tenetur qui. Totam molestiae ex in.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Quod sequi deleniti qui rem voluptatem natus. Rerum et sunt totam nihil excepturi.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Voluptatem tempora in qui fugiat. Et voluptatum voluptatem quis id iste. Dolor perspiciatis sit et sit facere molestiae omnis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Dolorem et error sed. Veniam modi qui neque sed commodi eveniet recusandae. Voluptates error qui est nisi dolorem minus ratione.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Est qui nam soluta. Pariatur unde alias quae nulla libero. Quas debitis in eius aliquid qui dolorem culpa.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Iure minima ratione perspiciatis dolorum. In voluptatem in ea. Id et et quibusdam eos. Eius eum neque cupiditate rerum quia ad et.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Quis sit aut nesciunt quidem ut cupiditate. Autem qui molestias illo voluptas. Officiis iure ipsa eveniet alias nesciunt ipsum expedita.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Excepturi repudiandae quaerat similique nihil. Perspiciatis vel itaque qui nam sed occaecati quo. Eius sunt nostrum ut veniam quam.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Ea eveniet et enim numquam. Similique neque dolores officia possimus. Ullam voluptatem id et eveniet voluptas.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Voluptas iure et impedit eaque quasi. Sed harum quam omnis unde.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"A corporis voluptate quibusdam quis. Omnis quia minus commodi. Consequatur quos repudiandae deleniti est.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Distinctio voluptates velit quas quo quia cum commodi. Sit est blanditiis aspernatur dolore a. Harum vitae harum laboriosam dolores et et nulla.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Facere sit vitae ea dolorem tempore et. Autem sed voluptas voluptas id voluptas et. Inventore autem id nobis nobis ex architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Quia repellat culpa rerum nulla at eveniet. Cum vitae voluptatum temporibus voluptatem inventore. Quisquam maiores voluptatum ut voluptas recusandae.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Aut quisquam occaecati qui inventore commodi quia eum. Ullam eligendi sed sed aut voluptatem. Velit libero nemo iusto officiis aut.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Et neque et perferendis laudantium. Autem tempore eum et adipisci similique sunt iste. Qui quidem itaque nam ut.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Ducimus voluptate velit vitae ducimus dolorem vel tempore. Repellendus delectus magni labore est enim. Voluptatem quo molestias assumenda nisi.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Sint error debitis totam sint aut neque. Quis est debitis quidem autem voluptatem eveniet commodi ex. Facere a porro rerum neque tempore in natus.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Rerum aliquid aliquam nostrum. Dignissimos nobis atque enim qui exercitationem et distinctio. At ut est repellat molestias voluptatum.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Repellat provident saepe ipsa possimus. Facilis consequatur voluptatem impedit inventore rerum non. Veritatis sunt consectetur velit blanditiis.\"}]', 8, 'Dev\\Gallery\\Models\\Gallery', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `gallery_meta` VALUES (9, '[{\"img\":\"news\\/1.jpg\",\"description\":\"Tenetur dolores et et ut. Ipsam aliquid minus consequatur at. Qui amet sapiente enim et possimus animi tenetur qui. Totam molestiae ex in.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Quod sequi deleniti qui rem voluptatem natus. Rerum et sunt totam nihil excepturi.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Voluptatem tempora in qui fugiat. Et voluptatum voluptatem quis id iste. Dolor perspiciatis sit et sit facere molestiae omnis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Dolorem et error sed. Veniam modi qui neque sed commodi eveniet recusandae. Voluptates error qui est nisi dolorem minus ratione.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Est qui nam soluta. Pariatur unde alias quae nulla libero. Quas debitis in eius aliquid qui dolorem culpa.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Iure minima ratione perspiciatis dolorum. In voluptatem in ea. Id et et quibusdam eos. Eius eum neque cupiditate rerum quia ad et.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Quis sit aut nesciunt quidem ut cupiditate. Autem qui molestias illo voluptas. Officiis iure ipsa eveniet alias nesciunt ipsum expedita.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Excepturi repudiandae quaerat similique nihil. Perspiciatis vel itaque qui nam sed occaecati quo. Eius sunt nostrum ut veniam quam.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Ea eveniet et enim numquam. Similique neque dolores officia possimus. Ullam voluptatem id et eveniet voluptas.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Voluptas iure et impedit eaque quasi. Sed harum quam omnis unde.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"A corporis voluptate quibusdam quis. Omnis quia minus commodi. Consequatur quos repudiandae deleniti est.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Distinctio voluptates velit quas quo quia cum commodi. Sit est blanditiis aspernatur dolore a. Harum vitae harum laboriosam dolores et et nulla.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Facere sit vitae ea dolorem tempore et. Autem sed voluptas voluptas id voluptas et. Inventore autem id nobis nobis ex architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Quia repellat culpa rerum nulla at eveniet. Cum vitae voluptatum temporibus voluptatem inventore. Quisquam maiores voluptatum ut voluptas recusandae.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Aut quisquam occaecati qui inventore commodi quia eum. Ullam eligendi sed sed aut voluptatem. Velit libero nemo iusto officiis aut.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Et neque et perferendis laudantium. Autem tempore eum et adipisci similique sunt iste. Qui quidem itaque nam ut.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Ducimus voluptate velit vitae ducimus dolorem vel tempore. Repellendus delectus magni labore est enim. Voluptatem quo molestias assumenda nisi.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Sint error debitis totam sint aut neque. Quis est debitis quidem autem voluptatem eveniet commodi ex. Facere a porro rerum neque tempore in natus.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Rerum aliquid aliquam nostrum. Dignissimos nobis atque enim qui exercitationem et distinctio. At ut est repellat molestias voluptatum.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Repellat provident saepe ipsa possimus. Facilis consequatur voluptatem impedit inventore rerum non. Veritatis sunt consectetur velit blanditiis.\"}]', 9, 'Dev\\Gallery\\Models\\Gallery', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `gallery_meta` VALUES (10, '[{\"img\":\"news\\/1.jpg\",\"description\":\"Tenetur dolores et et ut. Ipsam aliquid minus consequatur at. Qui amet sapiente enim et possimus animi tenetur qui. Totam molestiae ex in.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Quod sequi deleniti qui rem voluptatem natus. Rerum et sunt totam nihil excepturi.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Voluptatem tempora in qui fugiat. Et voluptatum voluptatem quis id iste. Dolor perspiciatis sit et sit facere molestiae omnis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Dolorem et error sed. Veniam modi qui neque sed commodi eveniet recusandae. Voluptates error qui est nisi dolorem minus ratione.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Est qui nam soluta. Pariatur unde alias quae nulla libero. Quas debitis in eius aliquid qui dolorem culpa.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Iure minima ratione perspiciatis dolorum. In voluptatem in ea. Id et et quibusdam eos. Eius eum neque cupiditate rerum quia ad et.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Quis sit aut nesciunt quidem ut cupiditate. Autem qui molestias illo voluptas. Officiis iure ipsa eveniet alias nesciunt ipsum expedita.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Excepturi repudiandae quaerat similique nihil. Perspiciatis vel itaque qui nam sed occaecati quo. Eius sunt nostrum ut veniam quam.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Ea eveniet et enim numquam. Similique neque dolores officia possimus. Ullam voluptatem id et eveniet voluptas.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Voluptas iure et impedit eaque quasi. Sed harum quam omnis unde.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"A corporis voluptate quibusdam quis. Omnis quia minus commodi. Consequatur quos repudiandae deleniti est.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Distinctio voluptates velit quas quo quia cum commodi. Sit est blanditiis aspernatur dolore a. Harum vitae harum laboriosam dolores et et nulla.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Facere sit vitae ea dolorem tempore et. Autem sed voluptas voluptas id voluptas et. Inventore autem id nobis nobis ex architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Quia repellat culpa rerum nulla at eveniet. Cum vitae voluptatum temporibus voluptatem inventore. Quisquam maiores voluptatum ut voluptas recusandae.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Aut quisquam occaecati qui inventore commodi quia eum. Ullam eligendi sed sed aut voluptatem. Velit libero nemo iusto officiis aut.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Et neque et perferendis laudantium. Autem tempore eum et adipisci similique sunt iste. Qui quidem itaque nam ut.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Ducimus voluptate velit vitae ducimus dolorem vel tempore. Repellendus delectus magni labore est enim. Voluptatem quo molestias assumenda nisi.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Sint error debitis totam sint aut neque. Quis est debitis quidem autem voluptatem eveniet commodi ex. Facere a porro rerum neque tempore in natus.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Rerum aliquid aliquam nostrum. Dignissimos nobis atque enim qui exercitationem et distinctio. At ut est repellat molestias voluptatum.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Repellat provident saepe ipsa possimus. Facilis consequatur voluptatem impedit inventore rerum non. Veritatis sunt consectetur velit blanditiis.\"}]', 10, 'Dev\\Gallery\\Models\\Gallery', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `gallery_meta` VALUES (11, '[{\"img\":\"news\\/1.jpg\",\"description\":\"Tenetur dolores et et ut. Ipsam aliquid minus consequatur at. Qui amet sapiente enim et possimus animi tenetur qui. Totam molestiae ex in.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Quod sequi deleniti qui rem voluptatem natus. Rerum et sunt totam nihil excepturi.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Voluptatem tempora in qui fugiat. Et voluptatum voluptatem quis id iste. Dolor perspiciatis sit et sit facere molestiae omnis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Dolorem et error sed. Veniam modi qui neque sed commodi eveniet recusandae. Voluptates error qui est nisi dolorem minus ratione.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Est qui nam soluta. Pariatur unde alias quae nulla libero. Quas debitis in eius aliquid qui dolorem culpa.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Iure minima ratione perspiciatis dolorum. In voluptatem in ea. Id et et quibusdam eos. Eius eum neque cupiditate rerum quia ad et.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Quis sit aut nesciunt quidem ut cupiditate. Autem qui molestias illo voluptas. Officiis iure ipsa eveniet alias nesciunt ipsum expedita.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Excepturi repudiandae quaerat similique nihil. Perspiciatis vel itaque qui nam sed occaecati quo. Eius sunt nostrum ut veniam quam.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Ea eveniet et enim numquam. Similique neque dolores officia possimus. Ullam voluptatem id et eveniet voluptas.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Voluptas iure et impedit eaque quasi. Sed harum quam omnis unde.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"A corporis voluptate quibusdam quis. Omnis quia minus commodi. Consequatur quos repudiandae deleniti est.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Distinctio voluptates velit quas quo quia cum commodi. Sit est blanditiis aspernatur dolore a. Harum vitae harum laboriosam dolores et et nulla.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Facere sit vitae ea dolorem tempore et. Autem sed voluptas voluptas id voluptas et. Inventore autem id nobis nobis ex architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Quia repellat culpa rerum nulla at eveniet. Cum vitae voluptatum temporibus voluptatem inventore. Quisquam maiores voluptatum ut voluptas recusandae.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Aut quisquam occaecati qui inventore commodi quia eum. Ullam eligendi sed sed aut voluptatem. Velit libero nemo iusto officiis aut.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Et neque et perferendis laudantium. Autem tempore eum et adipisci similique sunt iste. Qui quidem itaque nam ut.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Ducimus voluptate velit vitae ducimus dolorem vel tempore. Repellendus delectus magni labore est enim. Voluptatem quo molestias assumenda nisi.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Sint error debitis totam sint aut neque. Quis est debitis quidem autem voluptatem eveniet commodi ex. Facere a porro rerum neque tempore in natus.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Rerum aliquid aliquam nostrum. Dignissimos nobis atque enim qui exercitationem et distinctio. At ut est repellat molestias voluptatum.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Repellat provident saepe ipsa possimus. Facilis consequatur voluptatem impedit inventore rerum non. Veritatis sunt consectetur velit blanditiis.\"}]', 11, 'Dev\\Gallery\\Models\\Gallery', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `gallery_meta` VALUES (12, '[{\"img\":\"news\\/1.jpg\",\"description\":\"Tenetur dolores et et ut. Ipsam aliquid minus consequatur at. Qui amet sapiente enim et possimus animi tenetur qui. Totam molestiae ex in.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Quod sequi deleniti qui rem voluptatem natus. Rerum et sunt totam nihil excepturi.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Voluptatem tempora in qui fugiat. Et voluptatum voluptatem quis id iste. Dolor perspiciatis sit et sit facere molestiae omnis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Dolorem et error sed. Veniam modi qui neque sed commodi eveniet recusandae. Voluptates error qui est nisi dolorem minus ratione.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Est qui nam soluta. Pariatur unde alias quae nulla libero. Quas debitis in eius aliquid qui dolorem culpa.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Iure minima ratione perspiciatis dolorum. In voluptatem in ea. Id et et quibusdam eos. Eius eum neque cupiditate rerum quia ad et.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Quis sit aut nesciunt quidem ut cupiditate. Autem qui molestias illo voluptas. Officiis iure ipsa eveniet alias nesciunt ipsum expedita.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Excepturi repudiandae quaerat similique nihil. Perspiciatis vel itaque qui nam sed occaecati quo. Eius sunt nostrum ut veniam quam.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Ea eveniet et enim numquam. Similique neque dolores officia possimus. Ullam voluptatem id et eveniet voluptas.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Voluptas iure et impedit eaque quasi. Sed harum quam omnis unde.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"A corporis voluptate quibusdam quis. Omnis quia minus commodi. Consequatur quos repudiandae deleniti est.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Distinctio voluptates velit quas quo quia cum commodi. Sit est blanditiis aspernatur dolore a. Harum vitae harum laboriosam dolores et et nulla.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Facere sit vitae ea dolorem tempore et. Autem sed voluptas voluptas id voluptas et. Inventore autem id nobis nobis ex architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Quia repellat culpa rerum nulla at eveniet. Cum vitae voluptatum temporibus voluptatem inventore. Quisquam maiores voluptatum ut voluptas recusandae.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Aut quisquam occaecati qui inventore commodi quia eum. Ullam eligendi sed sed aut voluptatem. Velit libero nemo iusto officiis aut.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Et neque et perferendis laudantium. Autem tempore eum et adipisci similique sunt iste. Qui quidem itaque nam ut.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Ducimus voluptate velit vitae ducimus dolorem vel tempore. Repellendus delectus magni labore est enim. Voluptatem quo molestias assumenda nisi.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Sint error debitis totam sint aut neque. Quis est debitis quidem autem voluptatem eveniet commodi ex. Facere a porro rerum neque tempore in natus.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Rerum aliquid aliquam nostrum. Dignissimos nobis atque enim qui exercitationem et distinctio. At ut est repellat molestias voluptatum.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Repellat provident saepe ipsa possimus. Facilis consequatur voluptatem impedit inventore rerum non. Veritatis sunt consectetur velit blanditiis.\"}]', 12, 'Dev\\Gallery\\Models\\Gallery', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `gallery_meta` VALUES (13, '[{\"img\":\"news\\/1.jpg\",\"description\":\"Tenetur dolores et et ut. Ipsam aliquid minus consequatur at. Qui amet sapiente enim et possimus animi tenetur qui. Totam molestiae ex in.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Quod sequi deleniti qui rem voluptatem natus. Rerum et sunt totam nihil excepturi.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Voluptatem tempora in qui fugiat. Et voluptatum voluptatem quis id iste. Dolor perspiciatis sit et sit facere molestiae omnis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Dolorem et error sed. Veniam modi qui neque sed commodi eveniet recusandae. Voluptates error qui est nisi dolorem minus ratione.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Est qui nam soluta. Pariatur unde alias quae nulla libero. Quas debitis in eius aliquid qui dolorem culpa.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Iure minima ratione perspiciatis dolorum. In voluptatem in ea. Id et et quibusdam eos. Eius eum neque cupiditate rerum quia ad et.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Quis sit aut nesciunt quidem ut cupiditate. Autem qui molestias illo voluptas. Officiis iure ipsa eveniet alias nesciunt ipsum expedita.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Excepturi repudiandae quaerat similique nihil. Perspiciatis vel itaque qui nam sed occaecati quo. Eius sunt nostrum ut veniam quam.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Ea eveniet et enim numquam. Similique neque dolores officia possimus. Ullam voluptatem id et eveniet voluptas.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Voluptas iure et impedit eaque quasi. Sed harum quam omnis unde.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"A corporis voluptate quibusdam quis. Omnis quia minus commodi. Consequatur quos repudiandae deleniti est.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Distinctio voluptates velit quas quo quia cum commodi. Sit est blanditiis aspernatur dolore a. Harum vitae harum laboriosam dolores et et nulla.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Facere sit vitae ea dolorem tempore et. Autem sed voluptas voluptas id voluptas et. Inventore autem id nobis nobis ex architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Quia repellat culpa rerum nulla at eveniet. Cum vitae voluptatum temporibus voluptatem inventore. Quisquam maiores voluptatum ut voluptas recusandae.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Aut quisquam occaecati qui inventore commodi quia eum. Ullam eligendi sed sed aut voluptatem. Velit libero nemo iusto officiis aut.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Et neque et perferendis laudantium. Autem tempore eum et adipisci similique sunt iste. Qui quidem itaque nam ut.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Ducimus voluptate velit vitae ducimus dolorem vel tempore. Repellendus delectus magni labore est enim. Voluptatem quo molestias assumenda nisi.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Sint error debitis totam sint aut neque. Quis est debitis quidem autem voluptatem eveniet commodi ex. Facere a porro rerum neque tempore in natus.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Rerum aliquid aliquam nostrum. Dignissimos nobis atque enim qui exercitationem et distinctio. At ut est repellat molestias voluptatum.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Repellat provident saepe ipsa possimus. Facilis consequatur voluptatem impedit inventore rerum non. Veritatis sunt consectetur velit blanditiis.\"}]', 13, 'Dev\\Gallery\\Models\\Gallery', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `gallery_meta` VALUES (14, '[{\"img\":\"news\\/1.jpg\",\"description\":\"Tenetur dolores et et ut. Ipsam aliquid minus consequatur at. Qui amet sapiente enim et possimus animi tenetur qui. Totam molestiae ex in.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Quod sequi deleniti qui rem voluptatem natus. Rerum et sunt totam nihil excepturi.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Voluptatem tempora in qui fugiat. Et voluptatum voluptatem quis id iste. Dolor perspiciatis sit et sit facere molestiae omnis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Dolorem et error sed. Veniam modi qui neque sed commodi eveniet recusandae. Voluptates error qui est nisi dolorem minus ratione.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Est qui nam soluta. Pariatur unde alias quae nulla libero. Quas debitis in eius aliquid qui dolorem culpa.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Iure minima ratione perspiciatis dolorum. In voluptatem in ea. Id et et quibusdam eos. Eius eum neque cupiditate rerum quia ad et.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Quis sit aut nesciunt quidem ut cupiditate. Autem qui molestias illo voluptas. Officiis iure ipsa eveniet alias nesciunt ipsum expedita.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Excepturi repudiandae quaerat similique nihil. Perspiciatis vel itaque qui nam sed occaecati quo. Eius sunt nostrum ut veniam quam.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Ea eveniet et enim numquam. Similique neque dolores officia possimus. Ullam voluptatem id et eveniet voluptas.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Voluptas iure et impedit eaque quasi. Sed harum quam omnis unde.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"A corporis voluptate quibusdam quis. Omnis quia minus commodi. Consequatur quos repudiandae deleniti est.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Distinctio voluptates velit quas quo quia cum commodi. Sit est blanditiis aspernatur dolore a. Harum vitae harum laboriosam dolores et et nulla.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Facere sit vitae ea dolorem tempore et. Autem sed voluptas voluptas id voluptas et. Inventore autem id nobis nobis ex architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Quia repellat culpa rerum nulla at eveniet. Cum vitae voluptatum temporibus voluptatem inventore. Quisquam maiores voluptatum ut voluptas recusandae.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Aut quisquam occaecati qui inventore commodi quia eum. Ullam eligendi sed sed aut voluptatem. Velit libero nemo iusto officiis aut.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Et neque et perferendis laudantium. Autem tempore eum et adipisci similique sunt iste. Qui quidem itaque nam ut.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Ducimus voluptate velit vitae ducimus dolorem vel tempore. Repellendus delectus magni labore est enim. Voluptatem quo molestias assumenda nisi.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Sint error debitis totam sint aut neque. Quis est debitis quidem autem voluptatem eveniet commodi ex. Facere a porro rerum neque tempore in natus.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Rerum aliquid aliquam nostrum. Dignissimos nobis atque enim qui exercitationem et distinctio. At ut est repellat molestias voluptatum.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Repellat provident saepe ipsa possimus. Facilis consequatur voluptatem impedit inventore rerum non. Veritatis sunt consectetur velit blanditiis.\"}]', 14, 'Dev\\Gallery\\Models\\Gallery', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `gallery_meta` VALUES (15, '[{\"img\":\"news\\/1.jpg\",\"description\":\"Tenetur dolores et et ut. Ipsam aliquid minus consequatur at. Qui amet sapiente enim et possimus animi tenetur qui. Totam molestiae ex in.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Quod sequi deleniti qui rem voluptatem natus. Rerum et sunt totam nihil excepturi.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Voluptatem tempora in qui fugiat. Et voluptatum voluptatem quis id iste. Dolor perspiciatis sit et sit facere molestiae omnis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Dolorem et error sed. Veniam modi qui neque sed commodi eveniet recusandae. Voluptates error qui est nisi dolorem minus ratione.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Est qui nam soluta. Pariatur unde alias quae nulla libero. Quas debitis in eius aliquid qui dolorem culpa.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Iure minima ratione perspiciatis dolorum. In voluptatem in ea. Id et et quibusdam eos. Eius eum neque cupiditate rerum quia ad et.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Quis sit aut nesciunt quidem ut cupiditate. Autem qui molestias illo voluptas. Officiis iure ipsa eveniet alias nesciunt ipsum expedita.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Excepturi repudiandae quaerat similique nihil. Perspiciatis vel itaque qui nam sed occaecati quo. Eius sunt nostrum ut veniam quam.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Ea eveniet et enim numquam. Similique neque dolores officia possimus. Ullam voluptatem id et eveniet voluptas.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Voluptas iure et impedit eaque quasi. Sed harum quam omnis unde.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"A corporis voluptate quibusdam quis. Omnis quia minus commodi. Consequatur quos repudiandae deleniti est.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Distinctio voluptates velit quas quo quia cum commodi. Sit est blanditiis aspernatur dolore a. Harum vitae harum laboriosam dolores et et nulla.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Facere sit vitae ea dolorem tempore et. Autem sed voluptas voluptas id voluptas et. Inventore autem id nobis nobis ex architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Quia repellat culpa rerum nulla at eveniet. Cum vitae voluptatum temporibus voluptatem inventore. Quisquam maiores voluptatum ut voluptas recusandae.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Aut quisquam occaecati qui inventore commodi quia eum. Ullam eligendi sed sed aut voluptatem. Velit libero nemo iusto officiis aut.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Et neque et perferendis laudantium. Autem tempore eum et adipisci similique sunt iste. Qui quidem itaque nam ut.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Ducimus voluptate velit vitae ducimus dolorem vel tempore. Repellendus delectus magni labore est enim. Voluptatem quo molestias assumenda nisi.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Sint error debitis totam sint aut neque. Quis est debitis quidem autem voluptatem eveniet commodi ex. Facere a porro rerum neque tempore in natus.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Rerum aliquid aliquam nostrum. Dignissimos nobis atque enim qui exercitationem et distinctio. At ut est repellat molestias voluptatum.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Repellat provident saepe ipsa possimus. Facilis consequatur voluptatem impedit inventore rerum non. Veritatis sunt consectetur velit blanditiis.\"}]', 15, 'Dev\\Gallery\\Models\\Gallery', '2024-08-27 04:25:57', '2024-08-27 04:25:57');

-- ----------------------------
-- Table structure for gallery_meta_translations
-- ----------------------------
DROP TABLE IF EXISTS `gallery_meta_translations`;
CREATE TABLE `gallery_meta_translations`  (
  `lang_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gallery_meta_id` bigint UNSIGNED NOT NULL,
  `images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`lang_code`, `gallery_meta_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of gallery_meta_translations
-- ----------------------------

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED NULL DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_index`(`queue` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for language_meta
-- ----------------------------
DROP TABLE IF EXISTS `language_meta`;
CREATE TABLE `language_meta`  (
  `lang_meta_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `lang_meta_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `lang_meta_origin` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` bigint UNSIGNED NOT NULL,
  `reference_type` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`lang_meta_id`) USING BTREE,
  INDEX `language_meta_reference_id_index`(`reference_id` ASC) USING BTREE,
  INDEX `meta_code_index`(`lang_meta_code` ASC) USING BTREE,
  INDEX `meta_origin_index`(`lang_meta_origin` ASC) USING BTREE,
  INDEX `meta_reference_type_index`(`reference_type` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of language_meta
-- ----------------------------
INSERT INTO `language_meta` VALUES (1, 'en_US', '60d1bea579781478bdf601148b329897', 1, 'Dev\\Menu\\Models\\MenuLocation');
INSERT INTO `language_meta` VALUES (4, 'en_US', 'b7574fc27245fa8d4eba6589a259a116', 3, 'Dev\\Menu\\Models\\Menu');
INSERT INTO `language_meta` VALUES (5, 'en_US', '6ae46aed01d9a7fc5988a784818c3eb7', 10, 'Dev\\Menu\\Models\\MenuNode');
INSERT INTO `language_meta` VALUES (6, 'en_US', 'a40919d8be8f84ee3af643da3f59e6b2', 11, 'Dev\\Menu\\Models\\MenuNode');
INSERT INTO `language_meta` VALUES (7, 'en_US', '1ce8d89e807ea9e5b1582dabe904ebb6', 12, 'Dev\\Menu\\Models\\MenuNode');
INSERT INTO `language_meta` VALUES (8, 'en_US', '725c24ac5a36eacab574535f50c6c55f', 13, 'Dev\\Menu\\Models\\MenuNode');

-- ----------------------------
-- Table structure for languages
-- ----------------------------
DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages`  (
  `lang_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `lang_name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_locale` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_flag` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `lang_is_default` tinyint UNSIGNED NOT NULL DEFAULT 0,
  `lang_order` int NOT NULL DEFAULT 0,
  `lang_is_rtl` tinyint UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`lang_id`) USING BTREE,
  INDEX `lang_locale_index`(`lang_locale` ASC) USING BTREE,
  INDEX `lang_code_index`(`lang_code` ASC) USING BTREE,
  INDEX `lang_is_default_index`(`lang_is_default` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of languages
-- ----------------------------
INSERT INTO `languages` VALUES (1, 'English', 'en', 'en_US', 'us', 0, 0, 0);
INSERT INTO `languages` VALUES (2, 'Tiếng Việt', 'vi', 'vi', 'vn', 1, 0, 0);

-- ----------------------------
-- Table structure for media_files
-- ----------------------------
DROP TABLE IF EXISTS `media_files`;
CREATE TABLE `media_files`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `folder_id` bigint UNSIGNED NOT NULL DEFAULT 0,
  `mime_type` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` int NOT NULL,
  `url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `visibility` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `media_files_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `media_files_index`(`folder_id` ASC, `user_id` ASC, `created_at` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 55 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of media_files
-- ----------------------------
INSERT INTO `media_files` VALUES (1, 0, '1', '1', 1, 'image/jpeg', 9803, 'news/1.jpg', '[]', '2024-08-27 04:25:55', '2024-08-27 04:25:55', NULL, 'public');
INSERT INTO `media_files` VALUES (2, 0, '10', '10', 1, 'image/jpeg', 9803, 'news/10.jpg', '[]', '2024-08-27 04:25:55', '2024-08-27 04:25:55', NULL, 'public');
INSERT INTO `media_files` VALUES (3, 0, '11', '11', 1, 'image/jpeg', 9803, 'news/11.jpg', '[]', '2024-08-27 04:25:55', '2024-08-27 04:25:55', NULL, 'public');
INSERT INTO `media_files` VALUES (4, 0, '12', '12', 1, 'image/jpeg', 9803, 'news/12.jpg', '[]', '2024-08-27 04:25:55', '2024-08-27 04:25:55', NULL, 'public');
INSERT INTO `media_files` VALUES (5, 0, '13', '13', 1, 'image/jpeg', 9803, 'news/13.jpg', '[]', '2024-08-27 04:25:55', '2024-08-27 04:25:55', NULL, 'public');
INSERT INTO `media_files` VALUES (6, 0, '14', '14', 1, 'image/jpeg', 9803, 'news/14.jpg', '[]', '2024-08-27 04:25:55', '2024-08-27 04:25:55', NULL, 'public');
INSERT INTO `media_files` VALUES (7, 0, '15', '15', 1, 'image/jpeg', 9803, 'news/15.jpg', '[]', '2024-08-27 04:25:55', '2024-08-27 04:25:55', NULL, 'public');
INSERT INTO `media_files` VALUES (8, 0, '16', '16', 1, 'image/jpeg', 9803, 'news/16.jpg', '[]', '2024-08-27 04:25:55', '2024-08-27 04:25:55', NULL, 'public');
INSERT INTO `media_files` VALUES (9, 0, '17', '17', 1, 'image/jpeg', 9803, 'news/17.jpg', '[]', '2024-08-27 04:25:55', '2024-08-27 04:25:55', NULL, 'public');
INSERT INTO `media_files` VALUES (10, 0, '18', '18', 1, 'image/jpeg', 9803, 'news/18.jpg', '[]', '2024-08-27 04:25:55', '2024-08-27 04:25:55', NULL, 'public');
INSERT INTO `media_files` VALUES (11, 0, '19', '19', 1, 'image/jpeg', 9803, 'news/19.jpg', '[]', '2024-08-27 04:25:55', '2024-08-27 04:25:55', NULL, 'public');
INSERT INTO `media_files` VALUES (12, 0, '2', '2', 1, 'image/jpeg', 9803, 'news/2.jpg', '[]', '2024-08-27 04:25:55', '2024-08-27 04:25:55', NULL, 'public');
INSERT INTO `media_files` VALUES (13, 0, '20', '20', 1, 'image/jpeg', 9803, 'news/20.jpg', '[]', '2024-08-27 04:25:55', '2024-08-27 04:25:55', NULL, 'public');
INSERT INTO `media_files` VALUES (14, 0, '3', '3', 1, 'image/jpeg', 9803, 'news/3.jpg', '[]', '2024-08-27 04:25:56', '2024-08-27 04:25:56', NULL, 'public');
INSERT INTO `media_files` VALUES (15, 0, '4', '4', 1, 'image/jpeg', 9803, 'news/4.jpg', '[]', '2024-08-27 04:25:56', '2024-08-27 04:25:56', NULL, 'public');
INSERT INTO `media_files` VALUES (16, 0, '5', '5', 1, 'image/jpeg', 9803, 'news/5.jpg', '[]', '2024-08-27 04:25:56', '2024-08-27 04:25:56', NULL, 'public');
INSERT INTO `media_files` VALUES (17, 0, '6', '6', 1, 'image/jpeg', 9803, 'news/6.jpg', '[]', '2024-08-27 04:25:56', '2024-08-27 04:25:56', NULL, 'public');
INSERT INTO `media_files` VALUES (18, 0, '7', '7', 1, 'image/jpeg', 9803, 'news/7.jpg', '[]', '2024-08-27 04:25:56', '2024-08-27 04:25:56', NULL, 'public');
INSERT INTO `media_files` VALUES (19, 0, '8', '8', 1, 'image/jpeg', 9803, 'news/8.jpg', '[]', '2024-08-27 04:25:56', '2024-08-27 04:25:56', NULL, 'public');
INSERT INTO `media_files` VALUES (20, 0, '9', '9', 1, 'image/jpeg', 9803, 'news/9.jpg', '[]', '2024-08-27 04:25:56', '2024-08-27 04:25:56', NULL, 'public');
INSERT INTO `media_files` VALUES (21, 0, '1', '1', 2, 'image/jpeg', 9803, 'members/1.jpg', '[]', '2024-08-27 04:25:57', '2024-08-27 04:25:57', NULL, 'public');
INSERT INTO `media_files` VALUES (22, 0, '10', '10', 2, 'image/jpeg', 9803, 'members/10.jpg', '[]', '2024-08-27 04:25:57', '2024-08-27 04:25:57', NULL, 'public');
INSERT INTO `media_files` VALUES (23, 0, '11', '11', 2, 'image/png', 9803, 'members/11.png', '[]', '2024-08-27 04:25:57', '2024-08-27 04:25:57', NULL, 'public');
INSERT INTO `media_files` VALUES (24, 0, '2', '2', 2, 'image/jpeg', 9803, 'members/2.jpg', '[]', '2024-08-27 04:25:57', '2024-08-27 04:25:57', NULL, 'public');
INSERT INTO `media_files` VALUES (25, 0, '3', '3', 2, 'image/jpeg', 9803, 'members/3.jpg', '[]', '2024-08-27 04:25:57', '2024-08-27 04:25:57', NULL, 'public');
INSERT INTO `media_files` VALUES (26, 0, '4', '4', 2, 'image/jpeg', 9803, 'members/4.jpg', '[]', '2024-08-27 04:25:57', '2024-08-27 04:25:57', NULL, 'public');
INSERT INTO `media_files` VALUES (27, 0, '5', '5', 2, 'image/jpeg', 9803, 'members/5.jpg', '[]', '2024-08-27 04:25:57', '2024-08-27 04:25:57', NULL, 'public');
INSERT INTO `media_files` VALUES (28, 0, '6', '6', 2, 'image/jpeg', 9803, 'members/6.jpg', '[]', '2024-08-27 04:25:58', '2024-08-27 04:25:58', NULL, 'public');
INSERT INTO `media_files` VALUES (29, 0, '7', '7', 2, 'image/jpeg', 9803, 'members/7.jpg', '[]', '2024-08-27 04:25:58', '2024-08-27 04:25:58', NULL, 'public');
INSERT INTO `media_files` VALUES (30, 0, '8', '8', 2, 'image/jpeg', 9803, 'members/8.jpg', '[]', '2024-08-27 04:25:58', '2024-08-27 04:25:58', NULL, 'public');
INSERT INTO `media_files` VALUES (31, 0, '9', '9', 2, 'image/jpeg', 9803, 'members/9.jpg', '[]', '2024-08-27 04:25:58', '2024-08-27 04:25:58', NULL, 'public');
INSERT INTO `media_files` VALUES (32, 0, 'favicon', 'favicon', 3, 'image/png', 1122, 'general/favicon.png', '[]', '2024-08-27 04:26:01', '2024-08-27 04:26:01', NULL, 'public');
INSERT INTO `media_files` VALUES (33, 0, 'logo', 'logo', 3, 'image/png', 55709, 'general/logo.png', '[]', '2024-08-27 04:26:01', '2024-08-27 04:26:01', NULL, 'public');
INSERT INTO `media_files` VALUES (34, 0, 'preloader', 'preloader', 3, 'image/gif', 189758, 'general/preloader.gif', '[]', '2024-08-27 04:26:02', '2024-08-27 04:26:02', NULL, 'public');
INSERT INTO `media_files` VALUES (35, 1, 'Screenshot from 2024-10-11 18-00-07', 'Screenshot from 2024-10-11 18-00-07', 0, 'image/png', 46075, 'screenshot-from-2024-10-11-18-00-07.png', '[]', '2024-10-11 17:16:31', '2024-10-11 17:16:31', NULL, 'public');
INSERT INTO `media_files` VALUES (36, 1, 'ae21bfe63f107d5dc4e8861380409aaf', 'ae21bfe63f107d5dc4e8861380409aaf', 0, 'application/pdf', 86077, 'ae21bfe63f107d5dc4e8861380409aaf.pdf', '[]', '2024-10-11 17:53:08', '2024-10-11 17:53:08', NULL, 'public');
INSERT INTO `media_files` VALUES (37, 1, 'NGUYEN HUU KHAI CV', 'NGUYEN HUU KHAI CV', 0, 'application/pdf', 59190, 'nguyen-huu-khai-cv.pdf', '[]', '2024-10-12 05:51:41', '2024-10-12 05:51:41', NULL, 'public');
INSERT INTO `media_files` VALUES (38, 1, 'ae21bfe63f107d5dc4e8861380409aaf-1', 'ae21bfe63f107d5dc4e8861380409aaf-1', 0, 'application/pdf', 86077, 'ae21bfe63f107d5dc4e8861380409aaf-1.pdf', '[]', '2024-10-12 05:55:09', '2024-10-12 05:55:09', NULL, 'public');
INSERT INTO `media_files` VALUES (39, 1, 'ae21bfe63f107d5dc4e8861380409aaf-2', 'ae21bfe63f107d5dc4e8861380409aaf-2', 0, 'application/pdf', 86077, 'ae21bfe63f107d5dc4e8861380409aaf-2.pdf', '[]', '2024-10-12 05:57:28', '2024-10-12 05:57:28', NULL, 'public');
INSERT INTO `media_files` VALUES (40, 1, 'ae21bfe63f107d5dc4e8861380409aaf-3', 'ae21bfe63f107d5dc4e8861380409aaf-3', 0, 'application/pdf', 86077, 'ae21bfe63f107d5dc4e8861380409aaf-3.pdf', '[]', '2024-10-12 06:08:19', '2024-10-12 06:08:19', NULL, 'public');
INSERT INTO `media_files` VALUES (41, 2, 'ae21bfe63f107d5dc4e8861380409aaf-4', 'ae21bfe63f107d5dc4e8861380409aaf-4', 0, 'application/pdf', 86077, 'ae21bfe63f107d5dc4e8861380409aaf-4.pdf', '[]', '2024-10-12 15:39:59', '2024-10-12 15:39:59', NULL, 'public');
INSERT INTO `media_files` VALUES (42, 1, '_CO3335_CO3345__INTERNSHIP_REPORT__Copy_', '_CO3335_CO3345__INTERNSHIP_REPORT__Copy_', 0, 'application/pdf', 1043785, 'co3335-co3345-internship-report-copy.pdf', '[]', '2024-10-13 00:35:11', '2024-10-13 00:35:11', NULL, 'public');
INSERT INTO `media_files` VALUES (43, 1, '_CO3335_CO3345__INTERNSHIP_REPORT__Copy_-1', '_CO3335_CO3345__INTERNSHIP_REPORT__Copy_-1', 0, 'application/pdf', 1043785, 'co3335-co3345-internship-report-copy-1.pdf', '[]', '2024-10-13 01:33:08', '2024-10-13 01:33:08', NULL, 'public');
INSERT INTO `media_files` VALUES (44, 2, 'DAY-LA-FILE-MAU-PDF', 'DAY-LA-FILE-MAU-PDF', 0, 'application/pdf', 24395, 'day-la-file-mau-pdf.pdf', '[]', '2024-10-13 14:41:38', '2024-10-13 14:41:38', NULL, 'public');
INSERT INTO `media_files` VALUES (45, 2, '10 MAU HOP DONG MCAC', '10 MAU HOP DONG MCAC', 0, 'application/pdf', 1653732, '10-mau-hop-dong-mcac.pdf', '[]', '2024-10-13 14:54:37', '2024-10-13 14:54:37', NULL, 'public');
INSERT INTO `media_files` VALUES (46, 1, '10-MAU-HOP-DONG-MCAC', '10-MAU-HOP-DONG-MCAC', 0, 'application/pdf', 1653732, '10-mau-hop-dong-mcac.pdf', '[]', '2024-10-13 15:02:31', '2024-10-13 15:02:31', NULL, 'public');
INSERT INTO `media_files` VALUES (47, 2, '10-MAU-HOP-DONG-MCAC-1', '10-MAU-HOP-DONG-MCAC-1', 0, 'application/pdf', 1653732, '10-mau-hop-dong-mcac-1.pdf', '[]', '2024-10-13 15:03:56', '2024-10-13 15:03:56', NULL, 'public');
INSERT INTO `media_files` VALUES (48, 1, 'ae21bfe63f107d5dc4e8861380409aaf-5', 'ae21bfe63f107d5dc4e8861380409aaf-5', 0, 'application/pdf', 86077, 'ae21bfe63f107d5dc4e8861380409aaf-5.pdf', '[]', '2024-10-13 19:38:15', '2024-10-13 19:38:15', NULL, 'public');
INSERT INTO `media_files` VALUES (49, 2, 'CNPM', 'CNPM', 0, 'application/pdf', 4342116, 'cnpm.pdf', '[]', '2024-10-14 10:21:20', '2024-10-14 10:21:20', NULL, 'public');
INSERT INTO `media_files` VALUES (50, 2, '1', '1', 0, 'image/png', 208806, '1.png', '[]', '2024-10-14 10:23:23', '2024-10-14 10:23:23', NULL, 'public');
INSERT INTO `media_files` VALUES (51, 2, 'DACN_231_GD_2_report', 'DACN_231_GD_2_report', 0, 'application/pdf', 16055358, 'dacn-231-gd-2-report.pdf', '[]', '2024-10-14 10:24:27', '2024-10-14 10:24:27', NULL, 'public');
INSERT INTO `media_files` VALUES (52, 2, 'testpdf', 'testpdf', 0, 'application/pdf', 9022, 'testpdf.pdf', '[]', '2024-10-14 10:34:15', '2024-10-14 10:34:15', NULL, 'public');
INSERT INTO `media_files` VALUES (53, 1, '_CO3335_CO3345__INTERNSHIP_REPORT__Copy_-2', '_CO3335_CO3345__INTERNSHIP_REPORT__Copy_-2', 0, 'application/pdf', 1043785, 'co3335-co3345-internship-report-copy-2.pdf', '[]', '2024-10-14 10:40:36', '2024-10-14 10:40:36', NULL, 'public');
INSERT INTO `media_files` VALUES (54, 1, 'ae21bfe63f107d5dc4e8861380409aaf-6', 'ae21bfe63f107d5dc4e8861380409aaf-6', 0, 'application/pdf', 86077, 'ae21bfe63f107d5dc4e8861380409aaf-6.pdf', '[]', '2024-10-14 11:41:19', '2024-10-14 11:41:19', NULL, 'public');

-- ----------------------------
-- Table structure for media_folders
-- ----------------------------
DROP TABLE IF EXISTS `media_folders`;
CREATE TABLE `media_folders`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `color` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `parent_id` bigint UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `media_folders_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `media_folders_index`(`parent_id` ASC, `user_id` ASC, `created_at` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of media_folders
-- ----------------------------
INSERT INTO `media_folders` VALUES (1, 0, 'news', NULL, 'news', 0, '2024-08-27 04:25:54', '2024-08-27 04:25:54', NULL);
INSERT INTO `media_folders` VALUES (2, 0, 'members', NULL, 'members', 0, '2024-08-27 04:25:57', '2024-08-27 04:25:57', NULL);
INSERT INTO `media_folders` VALUES (3, 0, 'general', NULL, 'general', 0, '2024-08-27 04:26:01', '2024-08-27 04:26:01', NULL);

-- ----------------------------
-- Table structure for media_settings
-- ----------------------------
DROP TABLE IF EXISTS `media_settings`;
CREATE TABLE `media_settings`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `media_id` bigint UNSIGNED NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of media_settings
-- ----------------------------

-- ----------------------------
-- Table structure for member_activity_logs
-- ----------------------------
DROP TABLE IF EXISTS `member_activity_logs`;
CREATE TABLE `member_activity_logs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `action` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `reference_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `reference_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `member_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `member_activity_logs_member_id_index`(`member_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of member_activity_logs
-- ----------------------------

-- ----------------------------
-- Table structure for member_password_resets
-- ----------------------------
DROP TABLE IF EXISTS `member_password_resets`;
CREATE TABLE `member_password_resets`  (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  INDEX `member_password_resets_email_index`(`email` ASC) USING BTREE,
  INDEX `member_password_resets_token_index`(`token` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of member_password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for members
-- ----------------------------
DROP TABLE IF EXISTS `members`;
CREATE TABLE `members`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `gender` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar_id` bigint UNSIGNED NULL DEFAULT NULL,
  `dob` date NULL DEFAULT NULL,
  `phone` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `confirmed_at` datetime NULL DEFAULT NULL,
  `email_verify_token` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `members_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of members
-- ----------------------------
INSERT INTO `members` VALUES (1, 'Payton', 'Welch', NULL, NULL, 'member@gmail.com', '$2y$12$CFcAgYK8gS9jp84o6elYZ.Y2zRSSApYMx1axpSI6YOYJi0WSW2ZbK', 21, NULL, NULL, '2024-08-27 04:25:58', NULL, NULL, '2024-08-27 04:25:58', '2024-08-27 04:25:58', 'published');
INSERT INTO `members` VALUES (2, 'Helga', 'Marks', NULL, NULL, 'dillon.terry@hotmail.com', '$2y$12$A04VwMhE0rtoMOUw1r9.L.KJE1KaPDO8YPzMZ.yhQJrW0409RyI1y', 22, NULL, NULL, '2024-08-27 04:25:58', NULL, NULL, '2024-08-27 04:25:58', '2024-08-27 04:25:58', 'published');
INSERT INTO `members` VALUES (3, 'Maximo', 'Weimann', NULL, NULL, 'monty.kirlin@kertzmann.info', '$2y$12$7luANWq1g/KqO93XXmx9Wu7XBYAlTZMTrCFyWJrEdfuvvbZhGtWbi', 23, NULL, NULL, '2024-08-27 04:25:58', NULL, NULL, '2024-08-27 04:25:58', '2024-08-27 04:25:58', 'published');
INSERT INTO `members` VALUES (4, 'Darien', 'Kilback', NULL, NULL, 'greenholt.lisette@aufderhar.com', '$2y$12$tl6PpD04TZcNJlOcKKJFVuZ.2fZBWXQJTCzk0kExnrvN0ts7k8QJK', 24, NULL, NULL, '2024-08-27 04:25:58', NULL, NULL, '2024-08-27 04:25:58', '2024-08-27 04:25:58', 'published');
INSERT INTO `members` VALUES (5, 'Sheldon', 'Lakin', NULL, NULL, 'roob.beryl@gmail.com', '$2y$12$B1p0dpF9fEyiWFDf8kF9Nu3tgEORyIF2VxuIOW/6cKQ.rDhJFDvfu', 25, NULL, NULL, '2024-08-27 04:25:58', NULL, NULL, '2024-08-27 04:25:58', '2024-08-27 04:25:58', 'published');
INSERT INTO `members` VALUES (6, 'Bud', 'Wuckert', NULL, NULL, 'joshua.daniel@yahoo.com', '$2y$12$/23H1No5fSrxHfhxIrnfsekLaVvoJpU7p9Cd1NJrqv.VkiPBPROBG', 26, NULL, NULL, '2024-08-27 04:25:58', NULL, NULL, '2024-08-27 04:25:58', '2024-08-27 04:25:58', 'published');
INSERT INTO `members` VALUES (7, 'Casandra', 'Schultz', NULL, NULL, 'gschultz@zemlak.com', '$2y$12$q9wR6k8zoE9QY1Z.QAQJ2.isblIUADd8POTIxQSHaXJOBwhwUOQG.', 27, NULL, NULL, '2024-08-27 04:25:58', NULL, NULL, '2024-08-27 04:25:58', '2024-08-27 04:25:58', 'published');
INSERT INTO `members` VALUES (8, 'Joshua', 'Bernhard', NULL, NULL, 'runte.anita@jacobi.com', '$2y$12$eLakCwbJc0MJ.ilRs8EzSuUAI2adggNK/cQEk/uJMq2OjSN9O.nsi', 28, NULL, NULL, '2024-08-27 04:25:58', NULL, NULL, '2024-08-27 04:25:58', '2024-08-27 04:25:58', 'published');
INSERT INTO `members` VALUES (9, 'Sophie', 'Stracke', NULL, NULL, 'zackery13@kuhic.info', '$2y$12$UXFthSIUewQZ02rtzrxTaOlLhe1S5CkcFv9s2rPNL.dcsbCC0dcl.', 29, NULL, NULL, '2024-08-27 04:25:58', NULL, NULL, '2024-08-27 04:25:58', '2024-08-27 04:25:58', 'published');
INSERT INTO `members` VALUES (10, 'Marcia', 'Bartell', NULL, NULL, 'ruecker.karley@hotmail.com', '$2y$12$zdm7lA7Y9DEfdTvIxb1YLOrB36k55pw0KBzRHLOhn5H2J0y8Vgut6', 30, NULL, NULL, '2024-08-27 04:25:58', NULL, NULL, '2024-08-27 04:25:58', '2024-08-27 04:25:58', 'published');
INSERT INTO `members` VALUES (11, 'John', 'Smith', NULL, NULL, 'john.smith@cms.fsofts.com', '$2y$12$6JIwWyxmLyozAzX7sJ72NunhjD4.0PsXXVgym00VIDEiRLU24ba/W', 31, NULL, NULL, '2024-08-27 04:25:58', NULL, NULL, '2024-08-27 04:25:58', '2024-08-27 04:25:58', 'published');

-- ----------------------------
-- Table structure for menu_locations
-- ----------------------------
DROP TABLE IF EXISTS `menu_locations`;
CREATE TABLE `menu_locations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_id` bigint UNSIGNED NOT NULL,
  `location` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `menu_locations_menu_id_created_at_index`(`menu_id` ASC, `created_at` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of menu_locations
-- ----------------------------
INSERT INTO `menu_locations` VALUES (3, 3, 'menu-header', '2024-10-07 15:14:31', '2024-10-07 15:14:31');

-- ----------------------------
-- Table structure for menu_nodes
-- ----------------------------
DROP TABLE IF EXISTS `menu_nodes`;
CREATE TABLE `menu_nodes`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_id` bigint UNSIGNED NOT NULL,
  `parent_id` bigint UNSIGNED NOT NULL DEFAULT 0,
  `reference_id` bigint UNSIGNED NULL DEFAULT NULL,
  `reference_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `icon_font` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `position` tinyint UNSIGNED NOT NULL DEFAULT 0,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `css_class` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `target` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `has_child` tinyint UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `menu_nodes_menu_id_index`(`menu_id` ASC) USING BTREE,
  INDEX `menu_nodes_parent_id_index`(`parent_id` ASC) USING BTREE,
  INDEX `reference_id`(`reference_id` ASC) USING BTREE,
  INDEX `reference_type`(`reference_type` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of menu_nodes
-- ----------------------------
INSERT INTO `menu_nodes` VALUES (10, 3, 0, 0, NULL, '/', '', 0, 'Project', '', '_self', 0, '2024-10-07 14:59:55', '2024-10-07 15:14:31');
INSERT INTO `menu_nodes` VALUES (11, 3, 0, 0, NULL, '/documents', '', 1, 'Documents', '', '_self', 0, '2024-10-07 15:04:21', '2024-10-07 15:14:31');
INSERT INTO `menu_nodes` VALUES (12, 3, 0, 0, NULL, '/services', '', 2, 'Services', '', '_self', 0, '2024-10-07 15:04:45', '2024-10-07 15:14:31');
INSERT INTO `menu_nodes` VALUES (13, 3, 0, 0, NULL, '/contact', '', 3, 'Contact', '', '_self', 0, '2024-10-07 15:04:57', '2024-10-07 15:14:31');

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `menus_slug_unique`(`slug` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES (3, 'Menu Header', 'header-menu', 'published', '2024-10-07 14:55:44', '2024-10-07 15:14:31');

-- ----------------------------
-- Table structure for meta_boxes
-- ----------------------------
DROP TABLE IF EXISTS `meta_boxes`;
CREATE TABLE `meta_boxes`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `meta_key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `reference_id` bigint UNSIGNED NOT NULL,
  `reference_type` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `meta_boxes_reference_id_index`(`reference_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of meta_boxes
-- ----------------------------
INSERT INTO `meta_boxes` VALUES (1, 'seo_meta', '[{\"index\":\"index\"}]', 2, 'Dev\\Page\\Models\\Page', '2024-10-11 15:42:19', '2024-10-11 15:42:19');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 79 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2013_04_09_032329_create_base_tables', 1);
INSERT INTO `migrations` VALUES (2, '2013_04_09_062329_create_revisions_table', 1);
INSERT INTO `migrations` VALUES (3, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (4, '2014_10_12_100000_create_password_reset_tokens_table', 1);
INSERT INTO `migrations` VALUES (5, '2016_06_10_230148_create_acl_tables', 1);
INSERT INTO `migrations` VALUES (6, '2016_06_14_230857_create_menus_table', 1);
INSERT INTO `migrations` VALUES (7, '2016_06_28_221418_create_pages_table', 1);
INSERT INTO `migrations` VALUES (8, '2016_10_05_074239_create_setting_table', 1);
INSERT INTO `migrations` VALUES (9, '2016_11_28_032840_create_dashboard_widget_tables', 1);
INSERT INTO `migrations` VALUES (10, '2016_12_16_084601_create_widgets_table', 1);
INSERT INTO `migrations` VALUES (11, '2017_05_09_070343_create_media_tables', 1);
INSERT INTO `migrations` VALUES (12, '2017_11_03_070450_create_slug_table', 1);
INSERT INTO `migrations` VALUES (13, '2019_01_05_053554_create_jobs_table', 1);
INSERT INTO `migrations` VALUES (14, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (15, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (16, '2022_04_20_100851_add_index_to_media_table', 1);
INSERT INTO `migrations` VALUES (17, '2022_04_20_101046_add_index_to_menu_table', 1);
INSERT INTO `migrations` VALUES (18, '2022_07_10_034813_move_lang_folder_to_root', 1);
INSERT INTO `migrations` VALUES (19, '2022_08_04_051940_add_missing_column_expires_at', 1);
INSERT INTO `migrations` VALUES (20, '2022_09_01_000001_create_admin_notifications_tables', 1);
INSERT INTO `migrations` VALUES (21, '2022_10_14_024629_drop_column_is_featured', 1);
INSERT INTO `migrations` VALUES (22, '2022_11_18_063357_add_missing_timestamp_in_table_settings', 1);
INSERT INTO `migrations` VALUES (23, '2022_12_02_093615_update_slug_index_columns', 1);
INSERT INTO `migrations` VALUES (24, '2023_01_30_024431_add_alt_to_media_table', 1);
INSERT INTO `migrations` VALUES (25, '2023_02_16_042611_drop_table_password_resets', 1);
INSERT INTO `migrations` VALUES (26, '2023_04_23_005903_add_column_permissions_to_admin_notifications', 1);
INSERT INTO `migrations` VALUES (27, '2023_05_10_075124_drop_column_id_in_role_users_table', 1);
INSERT INTO `migrations` VALUES (28, '2023_08_21_090810_make_page_content_nullable', 1);
INSERT INTO `migrations` VALUES (29, '2023_09_14_021936_update_index_for_slugs_table', 1);
INSERT INTO `migrations` VALUES (30, '2023_12_07_095130_add_color_column_to_media_folders_table', 1);
INSERT INTO `migrations` VALUES (31, '2023_12_17_162208_make_sure_column_color_in_media_folders_nullable', 1);
INSERT INTO `migrations` VALUES (32, '2024_04_04_110758_update_value_column_in_user_meta_table', 1);
INSERT INTO `migrations` VALUES (33, '2024_05_12_091229_add_column_visibility_to_table_media_files', 1);
INSERT INTO `migrations` VALUES (34, '2024_07_07_091316_fix_column_url_in_menu_nodes_table', 1);
INSERT INTO `migrations` VALUES (35, '2024_07_12_100000_change_random_hash_for_media', 1);
INSERT INTO `migrations` VALUES (41, '2015_06_18_033822_create_blog_table', 5);
INSERT INTO `migrations` VALUES (42, '2021_02_16_092633_remove_default_value_for_author_type', 5);
INSERT INTO `migrations` VALUES (43, '2021_12_03_030600_create_blog_translations', 5);
INSERT INTO `migrations` VALUES (44, '2022_04_19_113923_add_index_to_table_posts', 5);
INSERT INTO `migrations` VALUES (45, '2023_08_29_074620_make_column_author_id_nullable', 5);
INSERT INTO `migrations` VALUES (46, '2024_07_30_091615_fix_order_column_in_categories_table', 5);
INSERT INTO `migrations` VALUES (52, '2017_03_27_150646_re_create_custom_field_tables', 7);
INSERT INTO `migrations` VALUES (53, '2022_04_30_030807_table_custom_fields_translation_table', 7);
INSERT INTO `migrations` VALUES (54, '2016_10_13_150201_create_galleries_table', 8);
INSERT INTO `migrations` VALUES (55, '2021_12_03_082953_create_gallery_translations', 8);
INSERT INTO `migrations` VALUES (56, '2022_04_30_034048_create_gallery_meta_translations_table', 8);
INSERT INTO `migrations` VALUES (57, '2023_08_29_075308_make_column_user_id_nullable', 8);
INSERT INTO `migrations` VALUES (58, '2016_10_03_032336_create_languages_table', 9);
INSERT INTO `migrations` VALUES (59, '2023_09_14_022423_add_index_for_language_table', 9);
INSERT INTO `migrations` VALUES (60, '2021_10_25_021023_fix-priority-load-for-language-advanced', 10);
INSERT INTO `migrations` VALUES (61, '2021_12_03_075608_create_page_translations', 10);
INSERT INTO `migrations` VALUES (62, '2023_07_06_011444_create_slug_translations_table', 10);
INSERT INTO `migrations` VALUES (63, '2017_10_04_140938_create_member_table', 11);
INSERT INTO `migrations` VALUES (64, '2023_10_16_075332_add_status_column', 11);
INSERT INTO `migrations` VALUES (65, '2024_03_25_000001_update_captcha_settings', 11);
INSERT INTO `migrations` VALUES (66, '2016_05_28_112028_create_system_request_logs_table', 12);
INSERT INTO `migrations` VALUES (67, '2016_10_07_193005_create_translations_table', 13);
INSERT INTO `migrations` VALUES (68, '2023_12_12_105220_drop_translations_table', 13);
INSERT INTO `migrations` VALUES (78, '2024_10_11_160046_contract_management_create_contract_management_table', 17);

-- ----------------------------
-- Table structure for pages
-- ----------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `template` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pages_user_id_index`(`user_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pages
-- ----------------------------
INSERT INTO `pages` VALUES (1, 'Homepage', '<div>[featured-posts][/featured-posts]</div><div>[recent-posts title=\"What\'s new?\"][/recent-posts]</div><div>[featured-categories-posts title=\"Best for you\" category_id=\"\" enable_lazy_loading=\"yes\"][/featured-categories-posts]</div><div>[all-galleries limit=\"8\" title=\"Galleries\" enable_lazy_loading=\"yes\"][/all-galleries]</div>', 1, NULL, 'no-sidebar', NULL, 'published', '2024-08-27 04:25:54', '2024-08-27 04:25:54');
INSERT INTO `pages` VALUES (2, 'Hợp đồng', '<p>---</p>', 1, NULL, 'contract', '', 'published', '2024-08-27 04:25:54', '2024-10-11 15:49:18');
INSERT INTO `pages` VALUES (3, 'Contact', '<p>Address: North Link Building, 10 Admiralty Street, 757695 Singapore</p><p>Hotline: 18006268</p><p>Email: contact@cms.fsofts.com</p><p>[google-map]North Link Building, 10 Admiralty Street, 757695 Singapore[/google-map]</p><p>For the fastest reply, please use the contact form below.</p><p>[contact-form][/contact-form]</p>', 1, NULL, NULL, NULL, 'published', '2024-08-27 04:25:54', '2024-08-27 04:25:54');
INSERT INTO `pages` VALUES (4, 'Cookie Policy', '<h3>EU Cookie Consent</h3><p>To use this website we are using Cookies and collecting some Data. To be compliant with the EU GDPR we give you to choose if you allow us to use certain Cookies and to collect some Data.</p><h4>Essential Data</h4><p>The Essential Data is needed to run the Site you are visiting technically. You can not deactivate them.</p><p>- Session Cookie: PHP uses a Cookie to identify user sessions. Without this Cookie the Website is not working.</p><p>- XSRF-Token Cookie: Laravel automatically generates a CSRF \"token\" for each active user session managed by the application. This token is used to verify that the authenticated user is the one actually making the requests to the application.</p>', 1, NULL, NULL, NULL, 'published', '2024-08-27 04:25:54', '2024-08-27 04:25:54');
INSERT INTO `pages` VALUES (5, 'Galleries', '<div>[gallery title=\"Galleries\" enable_lazy_loading=\"yes\"][/gallery]</div>', 1, NULL, NULL, NULL, 'published', '2024-08-27 04:25:54', '2024-08-27 04:25:54');

-- ----------------------------
-- Table structure for pages_translations
-- ----------------------------
DROP TABLE IF EXISTS `pages_translations`;
CREATE TABLE `pages_translations`  (
  `lang_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pages_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`lang_code`, `pages_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pages_translations
-- ----------------------------

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for post_categories
-- ----------------------------
DROP TABLE IF EXISTS `post_categories`;
CREATE TABLE `post_categories`  (
  `category_id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL,
  INDEX `post_categories_category_id_index`(`category_id` ASC) USING BTREE,
  INDEX `post_categories_post_id_index`(`post_id` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of post_categories
-- ----------------------------
INSERT INTO `post_categories` VALUES (3, 1);
INSERT INTO `post_categories` VALUES (2, 1);
INSERT INTO `post_categories` VALUES (1, 2);
INSERT INTO `post_categories` VALUES (2, 2);
INSERT INTO `post_categories` VALUES (3, 3);
INSERT INTO `post_categories` VALUES (5, 3);
INSERT INTO `post_categories` VALUES (1, 4);
INSERT INTO `post_categories` VALUES (3, 4);
INSERT INTO `post_categories` VALUES (3, 5);
INSERT INTO `post_categories` VALUES (7, 5);
INSERT INTO `post_categories` VALUES (3, 6);
INSERT INTO `post_categories` VALUES (7, 6);
INSERT INTO `post_categories` VALUES (2, 7);
INSERT INTO `post_categories` VALUES (1, 7);
INSERT INTO `post_categories` VALUES (7, 8);
INSERT INTO `post_categories` VALUES (6, 8);
INSERT INTO `post_categories` VALUES (5, 9);
INSERT INTO `post_categories` VALUES (8, 9);
INSERT INTO `post_categories` VALUES (6, 10);
INSERT INTO `post_categories` VALUES (3, 10);
INSERT INTO `post_categories` VALUES (7, 11);
INSERT INTO `post_categories` VALUES (1, 11);
INSERT INTO `post_categories` VALUES (7, 12);
INSERT INTO `post_categories` VALUES (2, 12);
INSERT INTO `post_categories` VALUES (1, 13);
INSERT INTO `post_categories` VALUES (5, 13);
INSERT INTO `post_categories` VALUES (6, 14);
INSERT INTO `post_categories` VALUES (4, 14);
INSERT INTO `post_categories` VALUES (1, 15);
INSERT INTO `post_categories` VALUES (7, 15);
INSERT INTO `post_categories` VALUES (2, 16);
INSERT INTO `post_categories` VALUES (8, 16);
INSERT INTO `post_categories` VALUES (8, 17);
INSERT INTO `post_categories` VALUES (5, 17);
INSERT INTO `post_categories` VALUES (6, 18);
INSERT INTO `post_categories` VALUES (4, 18);
INSERT INTO `post_categories` VALUES (3, 19);
INSERT INTO `post_categories` VALUES (5, 19);
INSERT INTO `post_categories` VALUES (4, 20);
INSERT INTO `post_categories` VALUES (5, 20);

-- ----------------------------
-- Table structure for post_tags
-- ----------------------------
DROP TABLE IF EXISTS `post_tags`;
CREATE TABLE `post_tags`  (
  `tag_id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL,
  INDEX `post_tags_tag_id_index`(`tag_id` ASC) USING BTREE,
  INDEX `post_tags_post_id_index`(`post_id` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of post_tags
-- ----------------------------
INSERT INTO `post_tags` VALUES (3, 1);
INSERT INTO `post_tags` VALUES (7, 1);
INSERT INTO `post_tags` VALUES (6, 2);
INSERT INTO `post_tags` VALUES (2, 2);
INSERT INTO `post_tags` VALUES (3, 3);
INSERT INTO `post_tags` VALUES (1, 3);
INSERT INTO `post_tags` VALUES (6, 3);
INSERT INTO `post_tags` VALUES (3, 4);
INSERT INTO `post_tags` VALUES (7, 4);
INSERT INTO `post_tags` VALUES (6, 5);
INSERT INTO `post_tags` VALUES (4, 5);
INSERT INTO `post_tags` VALUES (2, 5);
INSERT INTO `post_tags` VALUES (6, 6);
INSERT INTO `post_tags` VALUES (5, 6);
INSERT INTO `post_tags` VALUES (1, 6);
INSERT INTO `post_tags` VALUES (1, 7);
INSERT INTO `post_tags` VALUES (7, 7);
INSERT INTO `post_tags` VALUES (3, 8);
INSERT INTO `post_tags` VALUES (8, 8);
INSERT INTO `post_tags` VALUES (1, 8);
INSERT INTO `post_tags` VALUES (8, 9);
INSERT INTO `post_tags` VALUES (4, 9);
INSERT INTO `post_tags` VALUES (7, 9);
INSERT INTO `post_tags` VALUES (1, 10);
INSERT INTO `post_tags` VALUES (4, 10);
INSERT INTO `post_tags` VALUES (7, 10);
INSERT INTO `post_tags` VALUES (7, 11);
INSERT INTO `post_tags` VALUES (4, 11);
INSERT INTO `post_tags` VALUES (3, 12);
INSERT INTO `post_tags` VALUES (7, 12);
INSERT INTO `post_tags` VALUES (5, 12);
INSERT INTO `post_tags` VALUES (8, 13);
INSERT INTO `post_tags` VALUES (1, 13);
INSERT INTO `post_tags` VALUES (7, 14);
INSERT INTO `post_tags` VALUES (4, 14);
INSERT INTO `post_tags` VALUES (6, 15);
INSERT INTO `post_tags` VALUES (8, 16);
INSERT INTO `post_tags` VALUES (7, 16);
INSERT INTO `post_tags` VALUES (4, 16);
INSERT INTO `post_tags` VALUES (6, 17);
INSERT INTO `post_tags` VALUES (5, 17);
INSERT INTO `post_tags` VALUES (6, 18);
INSERT INTO `post_tags` VALUES (3, 18);
INSERT INTO `post_tags` VALUES (3, 19);
INSERT INTO `post_tags` VALUES (2, 19);
INSERT INTO `post_tags` VALUES (4, 19);
INSERT INTO `post_tags` VALUES (2, 20);
INSERT INTO `post_tags` VALUES (5, 20);
INSERT INTO `post_tags` VALUES (8, 20);

-- ----------------------------
-- Table structure for posts
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `status` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `author_id` bigint UNSIGNED NULL DEFAULT NULL,
  `author_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Dev\\ACL\\Models\\User',
  `is_featured` tinyint UNSIGNED NOT NULL DEFAULT 0,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `views` int UNSIGNED NOT NULL DEFAULT 0,
  `format_type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `posts_status_index`(`status` ASC) USING BTREE,
  INDEX `posts_author_id_index`(`author_id` ASC) USING BTREE,
  INDEX `posts_author_type_index`(`author_type` ASC) USING BTREE,
  INDEX `posts_created_at_index`(`created_at` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of posts
-- ----------------------------
INSERT INTO `posts` VALUES (1, 'Breakthrough in Quantum Computing: Computing Power Reaches Milestone', 'Researchers achieve a significant milestone in quantum computing, unlocking unprecedented computing power that has the potential to revolutionize various industries.', '<p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><p>So she was exactly three inches high). \'But I\'m NOT a serpent, I tell you, you coward!\' and at once crowded round her once more, while the Mouse to tell them something more. \'You promised to tell me the truth: did you call it sad?\' And she began nursing her child again, singing a sort of chance of her head down to her ear. \'You\'re thinking about something, my dear, and that is enough,\' Said his father; \'don\'t give yourself airs! Do you think, at your age, it is all the players, except the Lizard, who seemed to be executed for having missed their turns, and she was terribly frightened all the right house, because the chimneys were shaped like the look of things at all, as the door opened inwards, and Alice\'s first thought was that she was now the right distance--but then I wonder if I shall remember it in a few minutes, and she did not sneeze, were the verses the White Rabbit, \'but it doesn\'t mind.\' The table was a little faster?\" said a timid voice at her own children. \'How should I.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/1-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>CHAPTER V. Advice from a Caterpillar The Caterpillar and Alice was rather glad there WAS no one to listen to her, one on each side, and opened their eyes and mouths so VERY tired of sitting by her sister was reading, but it is.\' \'Then you keep moving round, I suppose?\' \'Yes,\' said Alice loudly. \'The idea of having the sentence first!\' \'Hold your tongue, Ma!\' said the White Rabbit read out, at the end of half an hour or so there were a Duck and a scroll of parchment in the middle, wondering how.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/9-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>The twelve jurors were all locked; and when she next peeped out the proper way of expressing yourself.\' The baby grunted again, so that they couldn\'t get them out again. That\'s all.\' \'Thank you,\' said the Hatter, and he went on, \'you see, a dog growls when it\'s angry, and wags its tail about in all directions, tumbling up against each other; however, they got thrown out to be sure! However, everything is to-day! And yesterday things went on at last, more calmly, though still sobbing a little shriek, and went on planning to herself that perhaps it was a real Turtle.\' These words were followed by a very good height indeed!\' said the Hatter, \'when the Queen said to the end of the sort,\' said the Hatter, and here the conversation dropped, and the Queen left off, quite out of sight; and an Eaglet, and several other curious creatures. Alice led the way, and the Dormouse shall!\' they both bowed low, and their curls got entangled together. Alice laughed so much already, that it was certainly.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/11-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Alice could hardly hear the words:-- \'I speak severely to my right size again; and the baby was howling so much at first, but, after watching it a little scream, half of fright and half believed herself in a loud, indignant voice, but she had nibbled some more bread-and-butter--\' \'But what did the archbishop find?\' The Mouse did not sneeze, were the cook, and a large cat which was full of tears, until there was not a moment that it would be a lesson to you how the Dodo replied very solemnly. Alice was only a mouse that had fallen into a sort of circle, (\'the exact shape doesn\'t matter,\' it said,) and then Alice dodged behind a great crash, as if she were looking up into the sea, some children digging in the middle, nursing a baby; the cook took the place where it had VERY long claws and a fall, and a long and a fan! Quick, now!\' And Alice was a child,\' said the cook. \'Treacle,\' said the Mouse. \'Of course,\' the Dodo suddenly called out as loud as she was exactly three inches high).</p>', 'published', 1, 'Dev\\ACL\\Models\\User', 1, 'news/1.jpg', 733, NULL, '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `posts` VALUES (2, '5G Rollout Accelerates: Next-Gen Connectivity Transforms Communication', 'The global rollout of 5G technology gains momentum, promising faster and more reliable connectivity, paving the way for innovations in communication and IoT.', '<p>Mad Tea-Party There was a different person then.\' \'Explain all that,\' said the Caterpillar. \'Is that all?\' said Alice, \'we learned French and music.\' \'And washing?\' said the Gryphon. \'It all came different!\' Alice replied thoughtfully. \'They have their tails in their mouths--and they\'re all over crumbs.\' \'You\'re wrong about the twentieth time that day. \'A likely story indeed!\' said the Caterpillar sternly. \'Explain yourself!\' \'I can\'t help it,\' said the Mouse, turning to Alice a little timidly: \'but it\'s no use denying it. I suppose you\'ll be asleep again before it\'s done.\' \'Once upon a low trembling voice, \'--and I hadn\'t cried so much!\' said Alice, a little three-legged table, all made of solid glass; there was no more of it at all. \'But perhaps he can\'t help it,\' she thought, \'till its ears have come, or at any rate I\'ll never go THERE again!\' said Alice to herself, \'I wish you were me?\' \'Well, perhaps not,\' said the Queen, in a sort of chance of this, so that they could not make.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/1-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>In another moment that it seemed quite natural); but when the White Rabbit read out, at the Hatter, with an M?\' said Alice. \'Did you say it.\' \'That\'s nothing to what I like\"!\' \'You might just as I get it home?\' when it grunted again, and Alice looked down at once, she found a little door about fifteen inches high: she tried hard to whistle to it; but she remembered trying to put everything upon Bill! I wouldn\'t say anything about it, and fortunately was just saying to her daughter \'Ah, my.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/7-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>The question is, what?\' The great question is, Who in the pool of tears which she concluded that it was impossible to say but \'It belongs to the whiting,\' said the Lory. Alice replied very solemnly. Alice was not even get her head through the wood. \'If it had a vague sort of mixed flavour of cherry-tart, custard, pine-apple, roast turkey, toffee, and hot buttered toast,) she very seldom followed it), and sometimes she scolded herself so severely as to size,\' Alice hastily replied; \'at least--at least I know I do!\' said Alice thoughtfully: \'but then--I shouldn\'t be hungry for it, she found herself lying on the floor, as it happens; and if I chose,\' the Duchess by this time, and was just going to dive in among the trees, a little bird as soon as she remembered trying to put it right; \'not that it seemed quite natural); but when the Rabbit began. Alice thought she might find another key on it, for she was playing against herself, for this time she had never forgotten that, if you like!\'.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/11-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Because he knows it teases.\' CHORUS. (In which the cook till his eyes were looking up into the wood for fear of their hearing her; and when she got into a tree. By the use of a tree a few minutes that she was shrinking rapidly; so she began again. \'I should have liked teaching it tricks very much, if--if I\'d only been the right words,\' said poor Alice, \'it would have appeared to them she heard a little girl she\'ll think me at all.\' \'In that case,\' said the Lory. Alice replied very gravely. \'What else have you executed, whether you\'re nervous or not.\' \'I\'m a poor man,\' the Hatter and the second verse of the Lobster Quadrille, that she ran out of a tree. By the use of repeating all that stuff,\' the Mock Turtle is.\' \'It\'s the first to speak. \'What size do you call it sad?\' And she opened the door between us. For instance, suppose it doesn\'t understand English,\' thought Alice; \'but a grin without a porpoise.\' \'Wouldn\'t it really?\' said Alice doubtfully: \'it.</p>', 'published', 1, 'Dev\\ACL\\Models\\User', 1, 'news/2.jpg', 284, NULL, '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `posts` VALUES (3, 'Tech Giants Collaborate on Open-Source AI Framework', 'Leading technology companies join forces to develop an open-source artificial intelligence framework, fostering collaboration and accelerating advancements in AI research.', '<p>I!\' said the Queen was close behind us, and he\'s treading on my tail. See how eagerly the lobsters and the March Hare said in a rather offended tone, \'Hm! No accounting for tastes! Sing her \"Turtle Soup,\" will you, won\'t you, won\'t you, won\'t you, will you, won\'t you, will you, old fellow?\' The Mock Turtle said: \'I\'m too stiff. And the Gryphon as if she was peering about anxiously among the branches, and every now and then I\'ll tell you how it was over at last, and managed to swallow a morsel of the reeds--the rattling teacups would change to dull reality--the grass would be a very curious thing, and she went back to finish his story. CHAPTER IV. The Rabbit started violently, dropped the white kid gloves while she was walking by the Hatter, with an M--\' \'Why with an M?\' said Alice. \'Why, there they are!\' said the Duchess; \'and that\'s the jury-box,\' thought Alice, \'and why it is right?\' \'In my youth,\' said his father, \'I took to the tarts on the trumpet, and then added them up, and.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/4-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Alice. \'Nothing WHATEVER?\' persisted the King. \'Then it doesn\'t matter which way she put them into a large kitchen, which was full of soup. \'There\'s certainly too much pepper in that poky little house, on the floor, as it was neither more nor less than no time to go, for the first verse,\' said the Gryphon: \'I went to school in the distance would take the hint; but the Mouse replied rather impatiently: \'any shrimp could have told you that.\' \'If I\'d been the right thing to nurse--and she\'s such.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/9-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Mystery,\' the Mock Turtle Soup is made from,\' said the Mock Turtle Soup is made from,\' said the King said to the Gryphon. \'The reason is,\' said the Footman. \'That\'s the most interesting, and perhaps after all it might happen any minute, \'and then,\' thought Alice, as she listened, or seemed to be sure, this generally happens when one eats cake, but Alice had not gone much farther before she had expected: before she gave a look askance-- Said he thanked the whiting kindly, but he would deny it too: but the three gardeners at it, busily painting them red. Alice thought to herself. At this moment the door of which was sitting on the same thing as \"I eat what I say--that\'s the same solemn tone, \'For the Duchess. \'I make you a song?\' \'Oh, a song, please, if the Mock Turtle, and said nothing. \'When we were little,\' the Mock Turtle said with some curiosity. \'What a pity it wouldn\'t stay!\' sighed the Hatter. \'It isn\'t a bird,\' Alice remarked. \'Right, as usual,\' said the Caterpillar. Here was.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/13-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>I got up in her hands, and was delighted to find it out, we should all have our heads cut off, you know. Which shall sing?\' \'Oh, YOU sing,\' said the sage, as he spoke. \'A cat may look at all fairly,\' Alice began, in rather a handsome pig, I think.\' And she tried the effect of lying down on one knee as he wore his crown over the wig, (look at the righthand bit again, and she went on again:-- \'I didn\'t write it, and talking over its head. \'Very uncomfortable for the baby, and not to be executed for having cheated herself in a helpless sort of present!\' thought Alice. The poor little Lizard, Bill, was in the sky. Alice went on for some minutes. Alice thought she might as well she might, what a delightful thing a bit!\' said the Queen, and in another moment it was the first minute or two, she made it out to the fifth bend, I think?\' \'I had NOT!\' cried the Mock Turtle at last, more calmly, though still sobbing a little glass table. \'Now, I\'ll manage better this time,\' she said to herself.</p>', 'published', 1, 'Dev\\ACL\\Models\\User', 1, 'news/3.jpg', 687, NULL, '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `posts` VALUES (4, 'SpaceX Launches Mission to Establish First Human Colony on Mars', 'Elon Musk\'s SpaceX embarks on a historic mission to establish the first human colony on Mars, marking a significant step toward interplanetary exploration.', '<p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><p>King eagerly, and he says it\'s so useful, it\'s worth a hundred pounds! He says it kills all the creatures wouldn\'t be in before the end of the conversation. Alice replied, rather shyly, \'I--I hardly know, sir, just at first, but, after watching it a violent shake at the March Hare. Alice sighed wearily. \'I think I should have liked teaching it tricks very much, if--if I\'d only been the whiting,\' said the Mock Turtle, and to stand on their slates, when the White Rabbit, \'and that\'s why. Pig!\' She said this she looked up, and there was hardly room for her. \'Yes!\' shouted Alice. \'Come on, then,\' said the Hatter with a knife, it usually bleeds; and she tried to get in?\' asked Alice again, for this time she saw maps and pictures hung upon pegs. She took down a very good height indeed!\' said the Mock Turtle went on, \'--likely to win, that it\'s hardly worth while finishing the game.\' The Queen had never forgotten that, if you could manage it?) \'And what an ignorant little girl or a watch to.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/3-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>I will just explain to you to get in at all?\' said the King say in a hurry: a large plate came skimming out, straight at the Hatter, it woke up again with a lobster as a partner!\' cried the Mock Turtle. \'And how do you want to go! Let me see: four times six is thirteen, and four times seven is--oh dear! I shall never get to the shore. CHAPTER III. A Caucus-Race and a piece of rudeness was more than Alice could only see her. She is such a curious appearance in the same height as herself; and.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/6-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>She soon got it out to sea!\" But the insolence of his great wig.\' The judge, by the whole party at once to eat or drink anything; so I\'ll just see what was coming. It was so large a house, that she did not venture to go on. \'And so these three little sisters,\' the Dormouse turned out, and, by the time she saw in my size; and as for the first to speak. \'What size do you mean by that?\' said the Gryphon: and Alice called out in a day did you manage on the table. \'Have some wine,\' the March Hare. \'Then it doesn\'t matter much,\' thought Alice, as she leant against a buttercup to rest her chin in salt water. Her first idea was that she did not like to be lost: away went Alice after it, \'Mouse dear! Do come back again, and the Queen ordering off her head!\' Those whom she sentenced were taken into custody by the officers of the words \'DRINK ME,\' but nevertheless she uncorked it and put it to make personal remarks,\' Alice said to herself, \'I don\'t believe you do lessons?\' said Alice, in a tone.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/13-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Queen shrieked out. \'Behead that Dormouse! Turn that Dormouse out of court! Suppress him! Pinch him! Off with his head!\' or \'Off with her head!\' the Queen shrieked out. \'Behead that Dormouse! Turn that Dormouse out of the cattle in the court!\' and the sound of many footsteps, and Alice could think of nothing else to say anything. \'Why,\' said the King, the Queen, and Alice, were in custody and under sentence of execution.\' \'What for?\' said the Mock Turtle in a hurry. \'No, I\'ll look first,\' she said, \'for her hair goes in such a long time together.\' \'Which is just the case with MINE,\' said the Hatter. \'I told you that.\' \'If I\'d been the whiting,\' said Alice, \'we learned French and music.\' \'And washing?\' said the Cat, \'if you don\'t even know what you would seem to see its meaning. \'And just as if he thought it would,\' said the Hatter: \'but you could draw treacle out of the March Hare moved into the Dormouse\'s place, and Alice looked all round the rosetree; for, you see, because some of.</p>', 'published', 1, 'Dev\\ACL\\Models\\User', 1, 'news/4.jpg', 293, NULL, '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `posts` VALUES (5, 'Cybersecurity Advances: New Protocols Bolster Digital Defense', 'In response to evolving cyber threats, advancements in cybersecurity protocols enhance digital defense measures, protecting individuals and organizations from online attacks.', '<p>Mock Turtle yet?\' \'No,\' said the King said to Alice, that she was a large one, but it is.\' \'Then you keep moving round, I suppose?\' \'Yes,\' said Alice, always ready to agree to everything that was sitting between them, fast asleep, and the great concert given by the English, who wanted leaders, and had been would have called him Tortoise because he taught us,\' said the Cat; and this Alice would not stoop? Soup of the table. \'Nothing can be clearer than THAT. Then again--\"BEFORE SHE HAD THIS FIT--\" you never even introduced to a mouse, That he met in the pool of tears which she had accidentally upset the week before. \'Oh, I beg your pardon,\' said Alice very humbly: \'you had got to the table for it, while the rest of the ground--and I should like to show you! A little bright-eyed terrier, you know, with oh, such long curly brown hair! And it\'ll fetch things when you come and join the dance. \'\"What matters it how far we go?\" his scaly friend replied. \"There is another shore, you know.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/5-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Alice. \'You did,\' said the White Rabbit. She was a paper label, with the Queen, the royal children, and everybody laughed, \'Let the jury had a wink of sleep these three weeks!\' \'I\'m very sorry you\'ve been annoyed,\' said Alice, feeling very curious thing, and longed to change the subject of conversation. \'Are you--are you fond--of--of dogs?\' The Mouse looked at it again: but he now hastily began again, using the ink, that was trickling down his brush, and had to run back into the air off all.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/10-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Hatter instead!\' CHAPTER VII. A Mad Tea-Party There was nothing else to do, and perhaps after all it might tell her something worth hearing. For some minutes it puffed away without speaking, but at last it unfolded its arms, took the opportunity of taking it away. She did not like to be a footman because he taught us,\' said the Hatter, and here the Mock Turtle: \'crumbs would all come wrong, and she went on, spreading out the verses to himself: \'\"WE KNOW IT TO BE TRUE--\" that\'s the jury, in a VERY good opportunity for showing off her knowledge, as there seemed to be a grin, and she felt that she was talking. Alice could hear him sighing as if she were looking over his shoulder as he said in a large crowd collected round it: there was no use in saying anything more till the Pigeon the opportunity of taking it away. She did not quite sure whether it would make with the lobsters, out to sea. So they couldn\'t get them out with his whiskers!\' For some minutes it seemed quite natural to.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/13-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Alice: \'--where\'s the Duchess?\' \'Hush! Hush!\' said the Gryphon, with a bound into the earth. Let me think: was I the same size for ten minutes together!\' \'Can\'t remember WHAT things?\' said the King. The White Rabbit cried out, \'Silence in the same solemn tone, only changing the order of the trees had a VERY good opportunity for making her escape; so she went hunting about, and called out, \'First witness!\' The first question of course you know why it\'s called a whiting?\' \'I never said I could show you our cat Dinah: I think it would make with the strange creatures of her voice. Nobody moved. \'Who cares for fish, Game, or any other dish? Who would not give all else for two reasons. First, because I\'m on the top of his Normans--\" How are you getting on?\' said the King; and as the rest of it had entirely disappeared; so the King said to herself; \'I should like to be true): If she should chance to be no sort of circle, (\'the exact shape doesn\'t matter,\' it said,) and then all the right.</p>', 'published', 1, 'Dev\\ACL\\Models\\User', 1, 'news/5.jpg', 606, NULL, '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `posts` VALUES (6, 'Artificial Intelligence in Healthcare: Transformative Solutions for Patient Care', 'AI technologies continue to revolutionize healthcare, offering transformative solutions for patient care, diagnosis, and personalized treatment plans.', '<p>Mock Turtle. \'Very much indeed,\' said Alice. \'Come on, then,\' said Alice, very much of a globe of goldfish she had quite forgotten the Duchess said after a minute or two, it was very glad to find that she wasn\'t a bit afraid of them!\' \'And who are THESE?\' said the Gryphon. Alice did not get hold of anything, but she could not join the dance. So they had been (Before she had sat down and saying to her great delight it fitted! Alice opened the door opened inwards, and Alice\'s elbow was pressed so closely against her foot, that there was a different person then.\' \'Explain all that,\' he said do. Alice looked all round the court with a pair of boots every Christmas.\' And she kept tossing the baby was howling so much at this, she came up to the Knave. The Knave of Hearts, and I had not attended to this last remark. \'Of course you don\'t!\' the Hatter asked triumphantly. Alice did not sneeze, were the verses on his spectacles. \'Where shall I begin, please your Majesty!\' the Duchess replied.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/1-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Hatter, and here the conversation dropped, and the jury wrote it down \'important,\' and some \'unimportant.\' Alice could see her after the birds! Why, she\'ll eat a bat?\' when suddenly, thump! thump! down she came upon a time she went on, half to itself, \'Oh dear! Oh dear! I\'d nearly forgotten that I\'ve got back to the three gardeners at it, and burning with curiosity, she ran out of sight, he said to the three gardeners who were lying round the neck of the same as the White Rabbit, with a kind.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/9-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>I\'m mad. You\'re mad.\' \'How do you mean by that?\' said the King, the Queen, who had been found and handed back to them, and the other players, and shouting \'Off with her head down to nine inches high. CHAPTER VI. Pig and Pepper For a minute or two, it was addressed to the other: he came trotting along in a twinkling! Half-past one, time for dinner!\' (\'I only wish people knew that: then they both sat silent for a long way back, and barking hoarsely all the things between whiles.\' \'Then you may nurse it a bit, if you hold it too long; and that you couldn\'t cut off a head could be beheaded, and that makes them bitter--and--and barley-sugar and such things that make children sweet-tempered. I only wish people knew that: then they wouldn\'t be so proud as all that.\' \'With extras?\' asked the Gryphon, and the little golden key in the face. \'I\'ll put a white one in by mistake; and if it thought that she looked up, and there she saw maps and pictures hung upon pegs. She took down a very little!.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/13-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>It did so indeed, and much sooner than she had expected: before she came upon a time there were TWO little shrieks, and more sounds of broken glass, from which she concluded that it is!\' As she said to herself; \'the March Hare was said to the little door about fifteen inches high: she tried to look down and make out what it was: at first she thought it over here,\' said the Dodo, \'the best way you go,\' said the Queen. An invitation for the pool as it spoke (it was Bill, the Lizard) could not even get her head was so ordered about by mice and rabbits. I almost wish I hadn\'t to bring tears into her face. \'Wake up, Alice dear!\' said her sister; \'Why, what a long argument with the bread-and-butter getting so thin--and the twinkling of the house, and found that, as nearly as she fell very slowly, for she had made out the answer to it?\' said the King. \'When did you do lessons?\' said Alice, \'we learned French and music.\' \'And washing?\' said the Queen. An invitation from the shock of being.</p>', 'published', 1, 'Dev\\ACL\\Models\\User', 1, 'news/6.jpg', 1057, NULL, '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `posts` VALUES (7, 'Robotic Innovations: Autonomous Systems Reshape Industries', 'Autonomous robotic systems redefine industries as they are increasingly adopted for tasks ranging from manufacturing and logistics to healthcare and agriculture.', '<p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><p>Alice turned and came flying down upon their faces, so that they were gardeners, or soldiers, or courtiers, or three pairs of tiny white kid gloves, and she tried the roots of trees, and I\'ve tried to get through the air! Do you think, at your age, it is to give the prizes?\' quite a commotion in the distance, screaming with passion. She had not got into it), and handed them round as prizes. There was certainly English. \'I don\'t know the way to fly up into a doze; but, on being pinched by the hand, it hurried off, without waiting for the next witness was the King; \'and don\'t look at the bottom of a good deal frightened by this time, and was suppressed. \'Come, that finished the goose, with the Duchess, \'as pigs have to beat them off, and that he had come to the Classics master, though. He was an old conger-eel, that used to say \'Drink me,\' but the Gryphon added \'Come, let\'s hear some of YOUR business, Two!\' said Seven. \'Yes, it IS his business!\' said Five, \'and I\'ll tell you my.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/2-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Caterpillar. This was not much like keeping so close to her: first, because the Duchess and the procession moved on, three of the window, she suddenly spread out her hand, watching the setting sun, and thinking of little Alice was more and more sounds of broken glass. \'What a pity it wouldn\'t stay!\' sighed the Lory, who at last the Mock Turtle recovered his voice, and, with tears again as quickly as she leant against a buttercup to rest herself, and shouted out, \'You\'d better not talk!\' said.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/10-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Said he thanked the whiting kindly, but he now hastily began again, using the ink, that was lying on their slates, when the White Rabbit: it was quite impossible to say it over) \'--yes, that\'s about the right thing to eat or drink anything; so I\'ll just see what would be only rustling in the distance would take the place of the court. \'What do you mean \"purpose\"?\' said Alice. \'And ever since that,\' the Hatter said, turning to Alice for protection. \'You shan\'t be able! I shall only look up and picking the daisies, when suddenly a White Rabbit read out, at the Duchess said to herself as she did not notice this question, but hurriedly went on, \'\"--found it advisable to go on. \'And so these three little sisters--they were learning to draw,\' the Dormouse sulkily remarked, \'If you do. I\'ll set Dinah at you!\' There was a dead silence. \'It\'s a pun!\' the King in a very respectful tone, but frowning and making quite a large ring, with the Lory, with a large caterpillar, that was trickling down.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/11-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Queen said--\' \'Get to your places!\' shouted the Queen merely remarking that a red-hot poker will burn you if you wouldn\'t mind,\' said Alice: \'three inches is such a curious croquet-ground in her own courage. \'It\'s no business of MINE.\' The Queen smiled and passed on. \'Who ARE you doing out here? Run home this moment, and fetch me a pair of the tea--\' \'The twinkling of the Queen\'s absence, and were resting in the chimney as she could, \'If you didn\'t sign it,\' said the Caterpillar. \'Well, I should say \"With what porpoise?\"\' \'Don\'t you mean \"purpose\"?\' said Alice. \'I wonder what was going to dive in among the leaves, which she had not gone (We know it was looking up into the way down one side and then they wouldn\'t be so stingy about it, even if I must, I must,\' the King replied. Here the other side, the puppy began a series of short charges at the Mouse\'s tail; \'but why do you know what they\'re about!\' \'Read them,\' said the Duchess: \'and the moral of that dark hall, and close to her.</p>', 'published', 1, 'Dev\\ACL\\Models\\User', 0, 'news/7.jpg', 659, NULL, '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `posts` VALUES (8, 'Virtual Reality Breakthrough: Immersive Experiences Redefine Entertainment', 'Advancements in virtual reality technology lead to immersive experiences that redefine entertainment, gaming, and interactive storytelling.', '<p>Alice (she was so much about a whiting to a day-school, too,\' said Alice; \'I daresay it\'s a very curious to see it pop down a good way off, panting, with its head, it WOULD twist itself round and look up and walking away. \'You insult me by talking such nonsense!\' \'I didn\'t write it, and found that, as nearly as she spoke, but no result seemed to listen, the whole party at once in a large caterpillar, that was trickling down his face, as long as there was a general chorus of \'There goes Bill!\' then the other, looking uneasily at the other, and making quite a commotion in the same age as herself, to see it trot away quietly into the way YOU manage?\' Alice asked. The Hatter was the cat.) \'I hope they\'ll remember her saucer of milk at tea-time. Dinah my dear! I shall only look up in great disgust, and walked a little nervous about this; \'for it might be hungry, in which the wretched Hatter trembled so, that Alice quite hungry to look at me like a candle. I wonder if I\'ve been changed for.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/5-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Mock Turtle in a large rabbit-hole under the circumstances. There was a dispute going on between the executioner, the King, going up to her feet, for it flashed across her mind that she had to run back into the air, mixed up with the Duchess, \'as pigs have to whisper a hint to Time, and round Alice, every now and then said, \'It was the White Rabbit as he said to herself, as she could. The next thing is, to get out of a bottle. They all sat down at them, and he called the Queen, stamping on the.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/6-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Besides, SHE\'S she, and I\'m sure she\'s the best way to hear the very tones of the Shark, But, when the race was over. Alice was only too glad to get in?\' \'There might be hungry, in which case it would not allow without knowing how old it was, even before she found to be otherwise.\"\' \'I think I may as well be at school at once.\' However, she soon found out a history of the house, and have next to her. \'I wish I could let you out, you know.\' \'Not at first, but, after watching it a little shaking among the distant sobs of the house till she got into a conversation. \'You don\'t know the way wherever she wanted much to know, but the Rabbit was still in sight, hurrying down it. There could be beheaded, and that is enough,\' Said his father; \'don\'t give yourself airs! Do you think you could keep it to speak first, \'why your cat grins like that?\' \'It\'s a mineral, I THINK,\' said Alice. \'Come, let\'s try Geography. London is the capital of Paris, and Paris is the use of a procession,\' thought.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/13-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>KNOW IT TO BE TRUE--\" that\'s the jury-box,\' thought Alice, \'as all the time she heard was a good deal to ME,\' said the Hatter. Alice felt a very little! Besides, SHE\'S she, and I\'m I, and--oh dear, how puzzling it all seemed quite natural); but when the Rabbit hastily interrupted. \'There\'s a great hurry; \'and their names were Elsie, Lacie, and Tillie; and they lived at the number of changes she had felt quite strange at first; but she had brought herself down to look for her, and she went hunting about, and crept a little way out of its little eyes, but it puzzled her very much of it now in sight, hurrying down it. There could be beheaded, and that makes them so shiny?\' Alice looked at the March Hare, \'that \"I breathe when I got up this morning, but I shall see it trot away quietly into the garden door. Poor Alice! It was the first to break the silence. \'What day of the sea.\' \'I couldn\'t afford to learn it.\' said the Hatter. He came in sight of the sort!\' said Alice. \'Why?\' \'IT DOES.</p>', 'published', 1, 'Dev\\ACL\\Models\\User', 0, 'news/8.jpg', 2182, NULL, '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `posts` VALUES (9, 'Innovative Wearables Track Health Metrics and Enhance Well-Being', 'Smart wearables with advanced health-tracking features gain popularity, empowering individuals to monitor and improve their well-being through personalized data insights.', '<p>I wonder if I\'ve been changed for any of them. \'I\'m sure those are not attending!\' said the Cat, \'or you wouldn\'t squeeze so.\' said the White Rabbit blew three blasts on the same words as before, \'It\'s all her life. Indeed, she had never before seen a good deal to ME,\' said Alice in a Little Bill It was so much at first, the two creatures, who had spoken first. \'That\'s none of YOUR adventures.\' \'I could tell you what year it is?\' \'Of course not,\' Alice cautiously replied, not feeling at all the players, except the King, the Queen, \'Really, my dear, I think?\' he said to herself, \'after such a dear little puppy it was!\' said Alice, \'I\'ve often seen them so shiny?\' Alice looked all round her at the picture.) \'Up, lazy thing!\' said Alice, \'how am I then? Tell me that first, and then, \'we went to him,\' said Alice in a great deal of thought, and rightly too, that very few things indeed were really impossible. There seemed to Alice as she left her, leaning her head in the sea. The master.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/1-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>I suppose Dinah\'ll be sending me on messages next!\' And she squeezed herself up on to her lips. \'I know SOMETHING interesting is sure to kill it in a day did you do lessons?\' said Alice, timidly; \'some of the ground--and I should like to show you! A little bright-eyed terrier, you know, as we needn\'t try to find my way into that lovely garden. First, however, she waited patiently. \'Once,\' said the Hatter, \'I cut some more tea,\' the March Hare, \'that \"I breathe when I grow at a reasonable.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/7-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Rabbit say to itself \'Then I\'ll go round and round Alice, every now and then; such as, \'Sure, I don\'t remember where.\' \'Well, it must be a queer thing, to be patted on the bank, and of having the sentence first!\' \'Hold your tongue!\' said the Mock Turtle Soup is made from,\' said the cook. The King laid his hand upon her arm, and timidly said \'Consider, my dear: she is such a wretched height to be.\' \'It is a raven like a serpent. She had quite forgotten the Duchess sang the second time round, she found to be beheaded!\' said Alice, rather alarmed at the thought that it would not allow without knowing how old it was, and, as the game was going a journey, I should like to have finished,\' said the King; \'and don\'t look at it!\' This speech caused a remarkable sensation among the branches, and every now and then; such as, \'Sure, I don\'t remember where.\' \'Well, it must make me grow smaller, I suppose.\' So she stood looking at the Footman\'s head: it just missed her. Alice caught the flamingo.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/12-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>White Rabbit read out, at the thought that SOMEBODY ought to be trampled under its feet, \'I move that the mouse to the end: then stop.\' These were the verses the White Rabbit, who said in a confused way, \'Prizes! Prizes!\' Alice had been running half an hour or so, and were quite silent, and looked at Alice, as she could, for the pool rippling to the heads of the edge of her going, though she knew that it felt quite unhappy at the Lizard in head downwards, and the words all coming different, and then they both sat silent for a minute or two sobs choked his voice. \'Same as if he would not allow without knowing how old it was, even before she got to do,\' said Alice angrily. \'It wasn\'t very civil of you to get to,\' said the March Hare,) \'--it was at in all directions, tumbling up against each other; however, they got thrown out to sea!\" But the insolence of his head. But at any rate, there\'s no harm in trying.\' So she was coming to, but it all is! I\'ll try and repeat \"\'TIS THE VOICE OF.</p>', 'published', 1, 'Dev\\ACL\\Models\\User', 0, 'news/9.jpg', 2402, NULL, '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `posts` VALUES (10, 'Tech for Good: Startups Develop Solutions for Social and Environmental Issues', 'Tech startups focus on developing innovative solutions to address social and environmental challenges, demonstrating the positive impact of technology on global issues.', '<p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><p>Allow me to sell you a present of everything I\'ve said as yet.\' \'A cheap sort of chance of her head on her toes when they liked, so that it felt quite strange at first; but she heard it say to itself in a low voice, \'Your Majesty must cross-examine the next verse,\' the Gryphon interrupted in a thick wood. \'The first thing she heard her voice close to her great delight it fitted! Alice opened the door with his head!\' or \'Off with his head!\' or \'Off with his tea spoon at the bottom of a good deal to come down the chimney?--Nay, I shan\'t! YOU do it!--That I won\'t, then!--Bill\'s to go near the door and found quite a long sleep you\'ve had!\' \'Oh, I\'ve had such a thing as \"I sleep when I got up very sulkily and crossed over to herself, and once she remembered that she was coming back to the other: the Duchess to play croquet.\' The Frog-Footman repeated, in the pictures of him), while the Dodo solemnly presented the thimble, looking as solemn as she could guess, she was now about two feet.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/4-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>King said, with a great hurry to get rather sleepy, and went stamping about, and called out \'The Queen! The Queen!\' and the shrill voice of the window, and some of them were animals, and some of the country is, you ARE a simpleton.\' Alice did not venture to say than his first remark, \'It was the same side of the trees behind him. \'--or next day, maybe,\' the Footman continued in the wood,\' continued the Gryphon. \'It\'s all his fancy, that: he hasn\'t got no business of MINE.\' The Queen had.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/8-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Alice heard the Queen\'s voice in the lap of her sister, who was sitting next to no toys to play croquet.\' The Frog-Footman repeated, in the lock, and to wonder what I say,\' the Mock Turtle persisted. \'How COULD he turn them out of THIS!\' (Sounds of more energetic remedies--\' \'Speak English!\' said the White Rabbit blew three blasts on the top of her ever getting out of court! Suppress him! Pinch him! Off with his tea spoon at the Hatter, \'I cut some more tea,\' the Hatter began, in a tone of delight, and rushed at the righthand bit again, and went stamping about, and called out, \'Sit down, all of you, and listen to me! When I used to say.\' \'So he did, so he did,\' said the Hatter: \'I\'m on the shingle--will you come to the Mock Turtle persisted. \'How COULD he turn them out of the jurymen. \'No, they\'re not,\' said Alice very meekly: \'I\'m growing.\' \'You\'ve no right to grow to my boy, I beat him when he sneezes: He only does it matter to me whether you\'re nervous or not.\' \'I\'m a poor man.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/11-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Alice, in a low, timid voice, \'If you can\'t swim, can you?\' he added, turning to Alice, and she put them into a doze; but, on being pinched by the hand, it hurried off, without waiting for turns, quarrelling all the other was sitting on a summer day: The Knave shook his head off outside,\' the Queen was in the world am I? Ah, THAT\'S the great hall, with the game,\' the Queen said--\' \'Get to your tea; it\'s getting late.\' So Alice began to feel a little timidly, for she had never seen such a fall as this, I shall have to go through next walking about at the Hatter, \'or you\'ll be asleep again before it\'s done.\' \'Once upon a Gryphon, lying fast asleep in the lock, and to hear it say, as it can\'t possibly make me giddy.\' And then, turning to the heads of the Lobster Quadrille, that she was dozing off, and Alice looked round, eager to see if she was to twist it up into the air off all its feet at once, with a trumpet in one hand, and a fan! Quick, now!\' And Alice was silent. The King and.</p>', 'published', 1, 'Dev\\ACL\\Models\\User', 0, 'news/10.jpg', 2499, NULL, '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `posts` VALUES (11, 'AI-Powered Personal Assistants Evolve: Enhancing Productivity and Convenience', 'AI-powered personal assistants undergo significant advancements, becoming more intuitive and capable of enhancing productivity and convenience in users\' daily lives.', '<p>I\'m not the right size, that it was the White Rabbit blew three blasts on the table. \'Nothing can be clearer than THAT. Then again--\"BEFORE SHE HAD THIS FIT--\" you never had to kneel down on one of the day; and this Alice would not open any of them. \'I\'m sure I\'m not myself, you see.\' \'I don\'t think--\' \'Then you may nurse it a very decided tone: \'tell her something about the right size to do anything but sit with its legs hanging down, but generally, just as I\'d taken the highest tree in front of the Lobster Quadrille?\' the Gryphon as if his heart would break. She pitied him deeply. \'What is his sorrow?\' she asked the Mock Turtle, and said anxiously to herself, \'because of his shrill little voice, the name \'Alice!\' CHAPTER XII. Alice\'s Evidence \'Here!\' cried Alice, with a growl, And concluded the banquet--] \'What IS a long argument with the end of every line: \'Speak roughly to your little boy, And beat him when he finds out who was a very good advice, (though she very good-naturedly.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/2-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Alice said nothing; she had not gone (We know it to speak again. In a little shriek, and went on planning to herself how this same little sister of hers would, in the act of crawling away: besides all this, there was no longer to be true): If she should push the matter worse. You MUST have meant some mischief, or else you\'d have signed your name like an honest man.\' There was no use in waiting by the time he had to double themselves up and walking away. \'You insult me by talking such.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/6-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Alice; \'I must be a book written about me, that there was nothing else to say a word, but slowly followed her back to the three gardeners who were all in bed!\' On various pretexts they all crowded together at one and then sat upon it.) \'I\'m glad I\'ve seen that done,\' thought Alice. \'I\'m glad I\'ve seen that done,\' thought Alice. \'I wonder what CAN have happened to me! I\'LL soon make you grow shorter.\' \'One side will make you a song?\' \'Oh, a song, please, if the Mock Turtle, and to stand on their slates, and then all the jurymen on to himself in an impatient tone: \'explanations take such a dear quiet thing,\' Alice went on, without attending to her; \'but those serpents! There\'s no pleasing them!\' Alice was very deep, or she fell very slowly, for she was terribly frightened all the while, till at last turned sulky, and would only say, \'I am older than I am so VERY wide, but she got back to the company generally, \'You are old, Father William,\' the young Crab, a little pattering of feet in.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/11-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Lory, as soon as she could. The next witness would be so easily offended, you know!\' The Mouse looked at it again: but he could go. Alice took up the chimney, and said nothing. \'Perhaps it doesn\'t mind.\' The table was a most extraordinary noise going on shrinking rapidly: she soon made out that one of them attempted to explain it as a lark, And will talk in contemptuous tones of the court. All this time she had peeped into the wood for fear of killing somebody, so managed to swallow a morsel of the conversation. Alice felt a little recovered from the time he had come to the heads of the door of the same size: to be a very good height indeed!\' said the Rabbit hastily interrupted. \'There\'s a great many more than that, if you drink much from a Caterpillar The Caterpillar and Alice rather unwillingly took the least notice of her going, though she felt that there was generally a frog or a watch to take MORE than nothing.\' \'Nobody asked YOUR opinion,\' said Alice. \'Why, there they lay.</p>', 'published', 1, 'Dev\\ACL\\Models\\User', 0, 'news/11.jpg', 1291, NULL, '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `posts` VALUES (12, 'Blockchain Innovation: Decentralized Finance (DeFi) Reshapes Finance Industry', 'Blockchain technology drives the rise of decentralized finance (DeFi), reshaping traditional financial systems and offering new possibilities for secure and transparent transactions.', '<p>Turtle--we used to know. Let me think: was I the same solemn tone, only changing the order of the window, I only wish people knew that: then they wouldn\'t be so stingy about it, even if my head would go anywhere without a cat! It\'s the most confusing thing I ask! It\'s always six o\'clock now.\' A bright idea came into Alice\'s shoulder as he spoke. \'A cat may look at the sides of the words \'DRINK ME,\' but nevertheless she uncorked it and put back into the sky all the things get used up.\' \'But what am I to do anything but sit with its legs hanging down, but generally, just as she stood still where she was always ready to make herself useful, and looking anxiously about as she could get to the general conclusion, that wherever you go to on the top of her ever getting out of its voice. \'Back to land again, and did not appear, and after a few minutes she heard a little recovered from the Gryphon, half to Alice. \'Nothing,\' said Alice. \'Call it what you like,\' said the Gryphon. \'Do you mean.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/4-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>The March Hare had just begun to dream that she was exactly three inches high). \'But I\'m NOT a serpent, I tell you!\' But she went on. \'Or would you like the three gardeners instantly threw themselves flat upon their faces. There was not here before,\' said Alice,) and round Alice, every now and then; such as, that a moment\'s pause. The only things in the direction it pointed to, without trying to touch her. \'Poor little thing!\' said the Dodo, pointing to Alice an excellent opportunity for.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/9-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>I\'ve said as yet.\' \'A cheap sort of meaning in them, after all. \"--SAID I COULD NOT SWIM--\" you can\'t think! And oh, I wish you wouldn\'t squeeze so.\' said the Caterpillar. \'Well, I shan\'t grow any more--As it is, I suppose?\' \'Yes,\' said Alice, \'how am I to get through the doorway; \'and even if my head would go round and round the hall, but they were filled with tears running down his cheeks, he went on, looking anxiously about her. \'Oh, do let me hear the words:-- \'I speak severely to my right size to do anything but sit with its mouth and yawned once or twice she had wept when she looked up, and reduced the answer to shillings and pence. \'Take off your hat,\' the King say in a very difficult question. However, at last she stretched her arms round it as she could not stand, and she went on, very much to-night, I should think you\'ll feel it a bit, if you cut your finger VERY deeply with a deep sigh, \'I was a table, with a round face, and was in managing her flamingo: she succeeded in.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/11-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>COULD grin.\' \'They all can,\' said the Cat. \'I said pig,\' replied Alice; \'and I do it again and again.\' \'You are old, Father William,\' the young lady tells us a story.\' \'I\'m afraid I\'ve offended it again!\' For the Mouse heard this, it turned a back-somersault in at the thought that it might injure the brain; But, now that I\'m doubtful about the temper of your flamingo. Shall I try the thing Mock Turtle to the conclusion that it would be like, \'--for they haven\'t got much evidence YET,\' she said to itself \'The Duchess! The Duchess! Oh my fur and whiskers! She\'ll get me executed, as sure as ferrets are ferrets! Where CAN I have dropped them, I wonder?\' Alice guessed who it was, and, as there was room for her. \'I wish you were or might have been changed in the window, and on both sides of it, and fortunately was just saying to her feet in the middle, wondering how she would get up and down in a trembling voice, \'--and I hadn\'t drunk quite so much!\' Alas! it was a large pool all round her.</p>', 'published', 1, 'Dev\\ACL\\Models\\User', 0, 'news/12.jpg', 391, NULL, '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `posts` VALUES (13, 'Quantum Internet: Secure Communication Enters a New Era', 'The development of a quantum internet marks a new era in secure communication, leveraging quantum entanglement for virtually unhackable data transmission.', '<p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><p>March Hare said to a mouse: she had felt quite unhappy at the Lizard as she did not quite know what to do with you. Mind now!\' The poor little feet, I wonder if I might venture to ask his neighbour to tell him. \'A nice muddle their slates\'ll be in Bill\'s place for a minute or two she stood still where she was, and waited. When the pie was all ridges and furrows; the balls were live hedgehogs, the mallets live flamingoes, and the beak-- Pray how did you manage to do this, so she went nearer to make out exactly what they said. The executioner\'s argument was, that you have to go after that savage Queen: so she went on again:-- \'I didn\'t write it, and found herself safe in a low, hurried tone. He looked anxiously round, to make out what it might happen any minute, \'and then,\' thought she, \'what would become of you? I gave her answer. \'They\'re done with a pair of the edge with each hand. \'And now which is which?\' she said to herself. At this moment the door as you might do something.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/1-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Alice noticed, had powdered hair that curled all over with diamonds, and walked two and two, as the jury wrote it down \'important,\' and some \'unimportant.\' Alice could hear him sighing as if she could not think of nothing better to say it over) \'--yes, that\'s about the twentieth time that day. \'That PROVES his guilt,\' said the Hatter, \'when the Queen to play with, and oh! ever so many lessons to learn! Oh, I shouldn\'t want YOURS: I don\'t want YOU with us!\"\' \'They were obliged to say it any.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/10-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Long Tale They were just beginning to end,\' said the March Hare. \'Exactly so,\' said the one who got any advantage from the change: and Alice was beginning to see that she let the jury--\' \'If any one of the room again, no wonder she felt sure it would be like, but it just now.\' \'It\'s the thing at all. \'But perhaps it was very likely true.) Down, down, down. Would the fall NEVER come to an end! \'I wonder how many miles I\'ve fallen by this time, and was just beginning to grow here,\' said the Pigeon had finished. \'As if I might venture to say anything. \'Why,\' said the Duchess; \'and most of \'em do.\' \'I don\'t see,\' said the Gryphon, the squeaking of the court was in the after-time, be herself a grown woman; and how she was surprised to find quite a chorus of voices asked. \'Why, SHE, of course,\' said the Hatter. He had been anxiously looking across the garden, and I shall have to whisper a hint to Time, and round goes the clock in a fight with another dig of her own children. \'How should I.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/13-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Her chin was pressed hard against it, that attempt proved a failure. Alice heard the Rabbit just under the table: she opened the door began sneezing all at once. \'Give your evidence,\' said the Gryphon: and it set to work throwing everything within her reach at the Footman\'s head: it just missed her. Alice caught the flamingo and brought it back, the fight was over, and she trembled till she got back to the beginning of the gloves, and she thought it would be so stingy about it, and then Alice put down her anger as well say,\' added the Gryphon; and then hurried on, Alice started to her lips. \'I know what to do, so Alice went on for some time without interrupting it. \'They must go by the officers of the water, and seemed to be Involved in this way! Stop this moment, and fetch me a good thing!\' she said to herself that perhaps it was getting so far off). \'Oh, my poor little feet, I wonder what was going to begin again, it was sneezing and howling alternately without a cat! It\'s the most.</p>', 'published', 1, 'Dev\\ACL\\Models\\User', 0, 'news/13.jpg', 589, NULL, '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `posts` VALUES (14, 'Drone Technology Advances: Applications Expand Across Industries', 'Drone technology continues to advance, expanding its applications across industries such as agriculture, construction, surveillance, and delivery services.', '<p>France-- Then turn not pale, beloved snail, but come and join the dance? Will you, won\'t you, will you, won\'t you, will you, won\'t you, will you, won\'t you, will you, won\'t you, will you, won\'t you join the dance. So they got thrown out to sea!\" But the snail replied \"Too far, too far!\" and gave a sudden burst of tears, until there was hardly room for this, and Alice guessed in a natural way. \'I thought it would be wasting our breath.\" \"I\'ll be judge, I\'ll be jury,\" Said cunning old Fury: \"I\'ll try the first to break the silence. \'What day of the other side of the room again, no wonder she felt that she had got so close to her that she still held the pieces of mushroom in her brother\'s Latin Grammar, \'A mouse--of a mouse--to a mouse--a mouse--O mouse!\') The Mouse gave a sudden leap out of his teacup instead of onions.\' Seven flung down his brush, and had come back in their mouths. So they had a pencil that squeaked. This of course, Alice could hardly hear the name \'W. RABBIT\'.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/1-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>She felt that she had been to the garden with one eye; but to open her mouth; but she did not venture to ask any more HERE.\' \'But then,\' thought Alice, as she spoke; \'either you or your head must be getting home; the night-air doesn\'t suit my throat!\' and a Dodo, a Lory and an old Crab took the thimble, looking as solemn as she could not tell whether they were mine before. If I or she should meet the real Mary Ann, and be turned out of its little eyes, but it said in a piteous tone. And she.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/7-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>English!\' said the King, rubbing his hands; \'so now let the Dormouse turned out, and, by the hedge!\' then silence, and then said \'The fourth.\' \'Two days wrong!\' sighed the Hatter. This piece of evidence we\'ve heard yet,\' said the Cat, \'if you don\'t even know what it might not escape again, and made believe to worry it; then Alice, thinking it was YOUR table,\' said Alice; \'all I know who I WAS when I sleep\" is the driest thing I know. Silence all round, if you drink much from a Caterpillar The Caterpillar and Alice called out to be executed for having missed their turns, and she thought to herself, \'the way all the while, till at last the Mock Turtle. So she began: \'O Mouse, do you know I\'m mad?\' said Alice. \'That\'s very curious.\' \'It\'s all her knowledge of history, Alice had not got into the garden. Then she went on so long since she had caught the baby violently up and said, without even waiting to put the Lizard in head downwards, and the three were all talking together: she made.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/11-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Majesty?\' he asked. \'Begin at the door--I do wish I hadn\'t to bring tears into her face, with such sudden violence that Alice had no reason to be true): If she should push the matter with it. There was a large pool all round the rosetree; for, you see, so many tea-things are put out here?\' she asked. \'Yes, that\'s it,\' said Alice. \'That\'s the judge,\' she said to the other bit. Her chin was pressed hard against it, that attempt proved a failure. Alice heard the Rabbit was still in sight, and no more to come, so she bore it as far down the chimney?--Nay, I shan\'t! YOU do it!--That I won\'t, then!--Bill\'s to go among mad people,\' Alice remarked. \'Right, as usual,\' said the Caterpillar took the hookah into its face was quite tired of this. I vote the young Crab, a little scream, half of fright and half believed herself in a soothing tone: \'don\'t be angry about it. And yet you incessantly stand on their slates, and then the Mock Turtle in the last words out loud, and the other queer noises.</p>', 'published', 1, 'Dev\\ACL\\Models\\User', 0, 'news/14.jpg', 1250, NULL, '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `posts` VALUES (15, 'Biotechnology Breakthrough: CRISPR-Cas9 Enables Precision Gene Editing', 'The CRISPR-Cas9 gene-editing technology reaches new heights, enabling precise and targeted modifications in the genetic code with profound implications for medicine and biotechnology.', '<p>Alice had been of late much accustomed to usurpation and conquest. Edwin and Morcar, the earls of Mercia and Northumbria--\"\' \'Ugh!\' said the Duchess: \'flamingoes and mustard both bite. And the executioner myself,\' said the Cat. \'I don\'t much care where--\' said Alice. \'That\'s very curious.\' \'It\'s all his fancy, that: they never executes nobody, you know. Come on!\' So they sat down, and nobody spoke for some minutes. The Caterpillar and Alice was very provoking to find that the way down one side and up the chimney, has he?\' said Alice in a great interest in questions of eating and drinking. \'They lived on treacle,\' said the Pigeon; \'but I know who I WAS when I breathe\"!\' \'It IS a long way back, and barking hoarsely all the right size, that it was a large kitchen, which was full of tears, but said nothing. \'This here young lady,\' said the Duchess: \'what a clear way you have just been picked up.\' \'What\'s in it?\' said the Caterpillar sternly. \'Explain yourself!\' \'I can\'t remember half of.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/3-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>I can listen all day about it!\' Last came a rumbling of little animals and birds waiting outside. The poor little thing sat down and saying to herself \'Suppose it should be raving mad after all! I almost think I should like to try the whole cause, and condemn you to set about it; if I\'m Mabel, I\'ll stay down here! It\'ll be no chance of this, so that her shoulders were nowhere to be no doubt that it made no mark; but he now hastily began again, using the ink, that was trickling down his face.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/6-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Pray how did you manage on the song, \'I\'d have said to the three gardeners instantly threw themselves flat upon their faces. There was exactly the right distance--but then I wonder who will put on your head-- Do you think you can find it.\' And she began looking at the number of changes she had hurt the poor little thing grunted in reply (it had left off writing on his slate with one finger, as he spoke. \'UNimportant, of course, Alice could see her after the candle is like after the others. \'Are their heads off?\' shouted the Queen. \'Sentence first--verdict afterwards.\' \'Stuff and nonsense!\' said Alice very humbly: \'you had got its neck nicely straightened out, and was just possible it had entirely disappeared; so the King and the other queer noises, would change (she knew) to the confused clamour of the house of the Lobster Quadrille?\' the Gryphon replied rather impatiently: \'any shrimp could have been changed in the air. \'--as far out to the Gryphon. \'I\'ve forgotten the words.\' So.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/14-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>And so it was certainly English. \'I don\'t see,\' said the King, going up to the other: the only difficulty was, that anything that looked like the name: however, it only grinned a little bottle on it, (\'which certainly was not an encouraging opening for a conversation. Alice replied, so eagerly that the meeting adjourn, for the pool rippling to the Hatter. \'He won\'t stand beating. Now, if you please! \"William the Conqueror, whose cause was favoured by the carrier,\' she thought; \'and how funny it\'ll seem to dry me at all.\' \'In that case,\' said the Mock Turtle replied; \'and then the Rabbit\'s voice along--\'Catch him, you by the whole thing very absurd, but they began running when they hit her; and the other side of WHAT? The other guests had taken his watch out of this elegant thimble\'; and, when it grunted again, so violently, that she was beginning to feel very uneasy: to be no doubt that it ought to speak, and no room to open her mouth; but she gained courage as she listened, or.</p>', 'published', 1, 'Dev\\ACL\\Models\\User', 0, 'news/15.jpg', 868, NULL, '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `posts` VALUES (16, 'Augmented Reality in Education: Interactive Learning Experiences for Students', 'Augmented reality transforms education, providing students with interactive and immersive learning experiences that enhance engagement and comprehension.', '<p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><p>I eat one of the trial.\' \'Stupid things!\' Alice thought to herself. Imagine her surprise, when the White Rabbit read:-- \'They told me he was going off into a graceful zigzag, and was just in time to see the Hatter began, in rather a complaining tone, \'and they drew all manner of things--everything that begins with an M--\' \'Why with an air of great dismay, and began bowing to the other, and making quite a crowd of little Alice and all sorts of little Alice and all of you, and must know better\'; and this was the same thing a bit!\' said the Duchess, the Duchess! Oh! won\'t she be savage if I\'ve been changed for Mabel! I\'ll try and repeat \"\'TIS THE VOICE OF THE SLUGGARD,\"\' said the Mock Turtle: \'crumbs would all come wrong, and she jumped up in spite of all her fancy, that: they never executes nobody, you know. Please, Ma\'am, is this New Zealand or Australia?\' (and she tried to open her mouth; but she stopped hastily, for the hot day made her next remark. \'Then the words did not notice.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/2-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>I the same year for such dainties would not join the dance? Will you, won\'t you, will you join the dance?\"\' \'Thank you, it\'s a very truthful child; \'but little girls in my size; and as Alice could not join the dance? Will you, won\'t you join the dance? \"You can really have no idea how to speak first, \'why your cat grins like that?\' \'It\'s a Cheshire cat,\' said the Dormouse; \'VERY ill.\' Alice tried to look for her, and the words have got into it), and handed back to the Gryphon. \'How the.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/9-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Duchess; \'and most of \'em do.\' \'I don\'t think it\'s at all fairly,\' Alice began, in rather a hard word, I will just explain to you to learn?\' \'Well, there was no time to avoid shrinking away altogether. \'That WAS a narrow escape!\' said Alice, a good deal worse off than before, as the rest were quite dry again, the Dodo had paused as if she were looking up into a large arm-chair at one and then she had never heard it say to itself, \'Oh dear! Oh dear! I\'d nearly forgotten that I\'ve got to the Hatter. \'Does YOUR watch tell you more than that, if you want to stay in here any longer!\' She waited for some time without hearing anything more: at last turned sulky, and would only say, \'I am older than I am to see it written up somewhere.\' Down, down, down. There was nothing on it except a little timidly, \'why you are painting those roses?\' Five and Seven said nothing, but looked at them with one finger pressed upon its nose. The Dormouse slowly opened his eyes. \'I wasn\'t asleep,\' he said in a.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/12-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Fainting in Coils.\' \'What was THAT like?\' said Alice. \'Of course they were\', said the King very decidedly, and there they lay sprawling about, reminding her very much of a muchness\"--did you ever eat a bat?\' when suddenly, thump! thump! down she came upon a Gryphon, lying fast asleep in the last few minutes, and she put them into a small passage, not much surprised at this, she came upon a time she had not gone (We know it to be Number One,\' said Alice. \'Well, then,\' the Cat said, waving its right paw round, \'lives a March Hare. Alice was not even get her head was so large in the court!\' and the Queen\'s shrill cries to the jury, of course--\"I GAVE HER ONE, THEY GAVE HIM TWO--\" why, that must be on the bank, with her face in her pocket) till she was quite impossible to say \"HOW DOTH THE LITTLE BUSY BEE,\" but it was over at last: \'and I do hope it\'ll make me smaller, I suppose.\' So she began thinking over other children she knew, who might do very well as she passed; it was over at.</p>', 'published', 1, 'Dev\\ACL\\Models\\User', 0, 'news/16.jpg', 856, NULL, '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `posts` VALUES (17, 'AI in Autonomous Vehicles: Advancements in Self-Driving Car Technology', 'AI algorithms and sensors in autonomous vehicles continue to advance, bringing us closer to widespread adoption of self-driving cars with improved safety features.', '<p>Queen furiously, throwing an inkstand at the end of his teacup instead of onions.\' Seven flung down his cheeks, he went on again:-- \'I didn\'t know that cats COULD grin.\' \'They all can,\' said the Gryphon went on. \'Or would you like the look of the evening, beautiful Soup! Beau--ootiful Soo--oop! Beau--ootiful Soo--oop! Beau--ootiful Soo--oop! Soo--oop of the window, and some were birds,) \'I suppose they are the jurors.\' She said this she looked down into a large canvas bag, which tied up at this corner--No, tie \'em together first--they don\'t reach half high enough yet--Oh! they\'ll do well enough; and what does it matter to me whether you\'re a little door into that lovely garden. First, however, she went on, without attending to her, still it was looking about for some way of escape, and wondering what to say whether the blows hurt it or not. So she stood looking at everything about her, to pass away the time. Alice had got its neck nicely straightened out, and was delighted to find.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/1-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>However, I\'ve got to the fifth bend, I think?\' \'I had NOT!\' cried the Gryphon, and all must have imitated somebody else\'s hand,\' said the Footman, and began by producing from under his arm a great crowd assembled about them--all sorts of things, and she, oh! she knows such a tiny little thing!\' It did so indeed, and much sooner than she had found the fan and gloves, and, as there seemed to be seen--everything seemed to listen, the whole court was a different person then.\' \'Explain all that,\'.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/6-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Mouse, who was trembling down to them, they set to work, and very soon came to the game. CHAPTER IX. The Mock Turtle\'s Story \'You can\'t think how glad I am very tired of sitting by her sister on the whole place around her became alive with the bread-knife.\' The March Hare had just upset the milk-jug into his cup of tea, and looked at Alice. \'It must have a prize herself, you know,\' said Alice, in a hoarse growl, \'the world would go round and get in at once.\' However, she did not appear, and after a few minutes to see if he were trying to fix on one, the cook was leaning over the jury-box with the next thing was to get in?\' asked Alice again, in a melancholy tone. \'Nobody seems to grin, How neatly spread his claws, And welcome little fishes in With gently smiling jaws!\' \'I\'m sure those are not attending!\' said the sage, as he spoke, and then Alice put down yet, before the officer could get away without being invited,\' said the youth, \'as I mentioned before, And have grown most.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/12-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>ALL RETURNED FROM HIM TO YOU,\"\' said Alice. \'You did,\' said the King, and the pool was getting very sleepy; \'and they drew all manner of things--everything that begins with a little door about fifteen inches high: she tried to beat them off, and that if you wouldn\'t have come here.\' Alice didn\'t think that there was Mystery,\' the Mock Turtle replied, counting off the mushroom, and her eyes immediately met those of a muchness\"--did you ever saw. How she longed to change them--\' when she looked up, but it was over at last, and they went on in a soothing tone: \'don\'t be angry about it. And yet I don\'t take this young lady tells us a story.\' \'I\'m afraid I can\'t put it in with a round face, and large eyes like a tunnel for some while in silence. Alice noticed with some curiosity. \'What a number of cucumber-frames there must be!\' thought Alice. One of the what?\' said the Cat: \'we\'re all mad here. I\'m mad. You\'re mad.\' \'How do you know about it, and found that, as nearly as she came in with.</p>', 'published', 1, 'Dev\\ACL\\Models\\User', 0, 'news/17.jpg', 1486, NULL, '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `posts` VALUES (18, 'Green Tech Innovations: Sustainable Solutions for a Greener Future', 'Green technology innovations focus on sustainable solutions, ranging from renewable energy sources to eco-friendly manufacturing practices, contributing to a greener future.', '<p>I\'m sure _I_ shan\'t be able! I shall fall right THROUGH the earth! How funny it\'ll seem to dry me at all.\' \'In that case,\' said the Rabbit whispered in a voice of the house till she too began dreaming after a minute or two to think that proved it at all,\' said the Cat. \'Do you play croquet with the name of nearly everything there. \'That\'s the first figure,\' said the Gryphon: and it was too small, but at any rate he might answer questions.--How am I to get in?\' \'There might be hungry, in which the cook was leaning over the list, feeling very curious thing, and she had this fit) An obstacle that came between Him, and ourselves, and it. Don\'t let me help to undo it!\' \'I shall sit here,\' he said, \'on and off, for days and days.\' \'But what am I to do?\' said Alice. The poor little Lizard, Bill, was in the world! Oh, my dear paws! Oh my dear paws! Oh my dear paws! Oh my fur and whiskers! She\'ll get me executed, as sure as ferrets are ferrets! Where CAN I have dropped them, I wonder?\' And.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/4-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Alice as he came, \'Oh! the Duchess, \'as pigs have to fly; and the Dormouse denied nothing, being fast asleep. \'After that,\' continued the Pigeon, but in a trembling voice to a mouse, That he met in the sea. But they HAVE their tails in their paws. \'And how many hours a day is very confusing.\' \'It isn\'t,\' said the Hatter. \'He won\'t stand beating. Now, if you want to get her head made her next remark. \'Then the words came very queer indeed:-- \'\'Tis the voice of the hall: in fact she was holding.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/9-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>This speech caused a remarkable sensation among the trees behind him. \'--or next day, maybe,\' the Footman went on again: \'Twenty-four hours, I THINK; or is it twelve? I--\' \'Oh, don\'t bother ME,\' said Alice a good deal frightened at the end of the earth. At last the Mock Turtle to sing \"Twinkle, twinkle, little bat! How I wonder what CAN have happened to you? Tell us all about it!\' Last came a little wider. \'Come, it\'s pleased so far,\' said the Dormouse. \'Don\'t talk nonsense,\' said Alice to herself. At this the whole pack rose up into a cucumber-frame, or something of the March Hare went \'Sh! sh!\' and the pool of tears which she had never before seen a cat without a porpoise.\' \'Wouldn\'t it really?\' said Alice indignantly. \'Ah! then yours wasn\'t a really good school,\' said the Cat, and vanished again. Alice waited till she got to see if she was quite tired and out of the wood to listen. The Fish-Footman began by producing from under his arm a great letter, nearly as large as the whole.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/13-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Even the Duchess to play croquet.\' Then they both cried. \'Wake up, Alice dear!\' said her sister; \'Why, what a long way back, and barking hoarsely all the time they had settled down in an angry tone, \'Why, Mary Ann, what ARE you talking to?\' said one of the door between us. For instance, suppose it were nine o\'clock in the sea, \'and in that case I can say.\' This was quite tired of this. I vote the young Crab, a little while, however, she waited patiently. \'Once,\' said the Dormouse. \'Write that down,\' the King said to herself how this same little sister of hers would, in the after-time, be herself a grown woman; and how she would have done that?\' she thought. \'I must be collected at once and put it to annoy, Because he knows it teases.\' CHORUS. (In which the cook till his eyes very wide on hearing this; but all he SAID was, \'Why is a long tail, certainly,\' said Alice, \'and if it began ordering people about like mad things all this time. \'I want a clean cup,\' interrupted the Hatter.</p>', 'published', 1, 'Dev\\ACL\\Models\\User', 0, 'news/18.jpg', 2110, NULL, '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `posts` VALUES (19, 'Space Tourism Soars: Commercial Companies Make Strides in Space Travel', 'Commercial space travel gains momentum as private companies make significant strides in offering space tourism experiences, opening up new frontiers for adventurous individuals.', '<p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><p>Just as she went hunting about, and shouting \'Off with her head!\' about once in a hurried nervous manner, smiling at everything about her, to pass away the time. Alice had begun to repeat it, but her voice close to the garden with one finger for the accident of the tea--\' \'The twinkling of the suppressed guinea-pigs, filled the air, and came back again. \'Keep your temper,\' said the Lory. Alice replied eagerly, for she could do, lying down with one eye; but to her full size by this very sudden change, but she could guess, she was near enough to drive one crazy!\' The Footman seemed to be trampled under its feet, ran round the court with a shiver. \'I beg your pardon!\' cried Alice in a deep voice, \'What are you getting on now, my dear?\' it continued, turning to Alice, and she dropped it hastily, just in time to avoid shrinking away altogether. \'That WAS a curious dream!\' said Alice, a little of it?\' said the Caterpillar. \'Not QUITE right, I\'m afraid,\' said Alice, a little startled by.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/5-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>COULD grin.\' \'They all can,\' said the Queen. \'Their heads are gone, if it likes.\' \'I\'d rather finish my tea,\' said the Dormouse; \'--well in.\' This answer so confused poor Alice, that she was a different person then.\' \'Explain all that,\' he said to herself. \'Shy, they seem to see it quite plainly through the door, she walked off, leaving Alice alone with the bread-knife.\' The March Hare said--\' \'I didn\'t!\' the March Hare and his friends shared their never-ending meal, and the cool fountains.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/9-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Dodo solemnly presented the thimble, looking as solemn as she could. \'The Dormouse is asleep again,\' said the Hatter. \'Stolen!\' the King said to the garden door. Poor Alice! It was all finished, the Owl, as a partner!\' cried the Mock Turtle with a table in the direction in which you usually see Shakespeare, in the pictures of him), while the Mouse replied rather crossly: \'of course you don\'t!\' the Hatter hurriedly left the court, arm-in-arm with the other side. The further off from England the nearer is to give the prizes?\' quite a long and a scroll of parchment in the pool was getting so thin--and the twinkling of the bottle was NOT marked \'poison,\' so Alice went on to himself in an undertone to the company generally, \'You are all pardoned.\' \'Come, THAT\'S a good deal frightened at the place of the well, and noticed that they were nowhere to be true): If she should meet the real Mary Ann, what ARE you talking to?\' said one of the goldfish kept running in her French lesson-book. The.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/12-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Gryphon at the thought that it ought to tell you--all I know who I am! But I\'d better take him his fan and the Dormouse turned out, and, by the officers of the bottle was NOT marked \'poison,\' it is I hate cats and dogs.\' It was the King; and as the soldiers remaining behind to execute the unfortunate gardeners, who ran to Alice an excellent plan, no doubt, and very soon finished it off. * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * CHAPTER II. The Pool of Tears \'Curiouser and curiouser!\' cried Alice in a low voice, \'Your Majesty must cross-examine THIS witness.\' \'Well, if I fell off the fire, and at once in her own mind (as well as she swam lazily about in the same as the large birds complained that they had at the Mouse\'s tail; \'but why do you know I\'m mad?\' said Alice. \'You must be,\' said the Duchess; \'and that\'s the jury, in a long, low hall, which was the first day,\' said the sage, as he shook both his shoes on. \'--and just take his head.</p>', 'published', 1, 'Dev\\ACL\\Models\\User', 0, 'news/19.jpg', 2198, NULL, '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `posts` VALUES (20, 'Humanoid Robots in Everyday Life: AI Companions and Assistants', 'Humanoid robots equipped with advanced artificial intelligence become more integrated into everyday life, serving as companions and assistants in various settings.', '<p>It quite makes my forehead ache!\' Alice watched the Queen was silent. The Dormouse again took a minute or two she stood still where she was, and waited. When the pie was all ridges and furrows; the balls were live hedgehogs, the mallets live flamingoes, and the Dormouse followed him: the March Hare. \'Exactly so,\' said Alice. \'Nothing WHATEVER?\' persisted the King. \'Shan\'t,\' said the Gryphon, and all that,\' said the Gryphon: \'I went to him,\' the Mock Turtle, who looked at the Lizard in head downwards, and the little thing was snorting like a wild beast, screamed \'Off with her friend. When she got into the wood. \'It\'s the thing Mock Turtle sighed deeply, and drew the back of one flapper across his eyes. \'I wasn\'t asleep,\' he said in a loud, indignant voice, but she was getting quite crowded with the Queen, tossing her head impatiently; and, turning to the three were all talking at once, she found this a good deal worse off than before, as the Caterpillar sternly. \'Explain yourself!\' \'I.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/3-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Caterpillar. Alice said with a sigh: \'he taught Laughing and Grief, they used to queer things happening. While she was beginning to write out a new pair of gloves and a great letter, nearly as large as himself, and this Alice thought over all the party were placed along the passage into the garden. Then she went back for a minute, while Alice thought to herself. \'I dare say you\'re wondering why I don\'t know,\' he went on growing, and growing, and growing, and very nearly in the direction it.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/9-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>I didn\'t know it to the beginning of the party sat silent and looked at the house, quite forgetting in the book,\' said the Mock Turtle, who looked at Alice. \'It goes on, you know,\' said Alice, and her eyes immediately met those of a procession,\' thought she, \'if people had all to lie down on one side, to look for her, and she had looked under it, and burning with curiosity, she ran off at once: one old Magpie began wrapping itself up and said, without opening its eyes, for it flashed across her mind that she was now only ten inches high, and she could not be denied, so she took courage, and went by without noticing her. Then followed the Knave was standing before them, in chains, with a lobster as a drawing of a tree a few minutes she heard a little feeble, squeaking voice, (\'That\'s Bill,\' thought Alice,) \'Well, I hardly know--No more, thank ye; I\'m better now--but I\'m a hatter.\' Here the other side of WHAT?\' thought Alice; \'only, as it\'s asleep, I suppose I ought to be a.</p><p class=\"text-center\"><img src=\"https://cms.fsofts.com/storage/news/14-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>White Rabbit blew three blasts on the hearth and grinning from ear to ear. \'Please would you like the look of the Lizard\'s slate-pencil, and the little passage: and THEN--she found herself in a whisper.) \'That would be QUITE as much as serpents do, you know.\' It was, no doubt: only Alice did not like the largest telescope that ever was! Good-bye, feet!\' (for when she noticed that they would call after her: the last few minutes that she had nothing yet,\' Alice replied in a shrill, loud voice, and see after some executions I have none, Why, I do it again and again.\' \'You are not attending!\' said the Queen to play croquet.\' The Frog-Footman repeated, in the night? Let me see--how IS it to be rude, so she waited. The Gryphon lifted up both its paws in surprise. \'What! Never heard of \"Uglification,\"\' Alice ventured to remark. \'Tut, tut, child!\' said the Gryphon. \'Well, I can\'t be Mabel, for I know I have done just as well as pigs, and was going to shrink any further: she felt that it was.</p>', 'published', 1, 'Dev\\ACL\\Models\\User', 0, 'news/20.jpg', 662, NULL, '2024-08-27 04:25:57', '2024-08-27 04:25:57');

-- ----------------------------
-- Table structure for posts_translations
-- ----------------------------
DROP TABLE IF EXISTS `posts_translations`;
CREATE TABLE `posts_translations`  (
  `lang_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `posts_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`lang_code`, `posts_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of posts_translations
-- ----------------------------

-- ----------------------------
-- Table structure for projects
-- ----------------------------
DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of projects
-- ----------------------------

-- ----------------------------
-- Table structure for projects_translations
-- ----------------------------
DROP TABLE IF EXISTS `projects_translations`;
CREATE TABLE `projects_translations`  (
  `lang_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `projects_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`lang_code`, `projects_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of projects_translations
-- ----------------------------

-- ----------------------------
-- Table structure for request_logs
-- ----------------------------
DROP TABLE IF EXISTS `request_logs`;
CREATE TABLE `request_logs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `status_code` int NULL DEFAULT NULL,
  `url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `count` int UNSIGNED NOT NULL DEFAULT 0,
  `user_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `referrer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 199 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of request_logs
-- ----------------------------
INSERT INTO `request_logs` VALUES (1, 404, 'https://my.khaizinam.code/asset/images/projects/new-carnival.jpg', 9, NULL, NULL, '2024-10-07 13:56:38', '2024-10-07 15:28:04');
INSERT INTO `request_logs` VALUES (2, 404, 'https://my.khaizinam.code/asset/images/projects/lagoona.jpg', 9, NULL, NULL, '2024-10-07 13:56:38', '2024-10-07 15:28:04');
INSERT INTO `request_logs` VALUES (3, 404, 'https://my.khaizinam.code/asset/images/projects/mitsuheavy.jpg', 8, NULL, NULL, '2024-10-07 13:57:01', '2024-10-07 15:28:04');
INSERT INTO `request_logs` VALUES (4, 404, 'https://my.khaizinam.code/asset/images/projects/id-vnea.jpg', 8, NULL, NULL, '2024-10-07 13:57:01', '2024-10-07 15:28:05');
INSERT INTO `request_logs` VALUES (5, 404, 'https://my.khaizinam.code/asset/images/projects/usedcar.jpg', 8, NULL, NULL, '2024-10-07 13:57:01', '2024-10-07 15:28:04');
INSERT INTO `request_logs` VALUES (6, 404, 'https://my.khaizinam.code/asset/images/projects/thaco-tai.jpg', 8, NULL, NULL, '2024-10-07 13:57:01', '2024-10-07 15:28:05');
INSERT INTO `request_logs` VALUES (7, 404, 'http://127.0.0.1:8000/asset/images/projects/new-carnival.jpg', 2, NULL, NULL, '2024-10-11 15:26:07', '2024-10-11 15:34:34');
INSERT INTO `request_logs` VALUES (8, 404, 'http://127.0.0.1:8000/asset/images/projects/lagoona.jpg', 2, NULL, NULL, '2024-10-11 15:26:08', '2024-10-11 15:34:35');
INSERT INTO `request_logs` VALUES (9, 404, 'http://127.0.0.1:8000/asset/images/projects/mitsuheavy.jpg', 2, NULL, NULL, '2024-10-11 15:26:08', '2024-10-11 15:34:41');
INSERT INTO `request_logs` VALUES (10, 404, 'http://127.0.0.1:8000/asset/images/projects/usedcar.jpg', 2, NULL, NULL, '2024-10-11 15:26:09', '2024-10-11 15:34:43');
INSERT INTO `request_logs` VALUES (11, 404, 'http://127.0.0.1:8000/asset/images/projects/id-vnea.jpg', 2, NULL, NULL, '2024-10-11 15:26:09', '2024-10-11 15:34:44');
INSERT INTO `request_logs` VALUES (12, 404, 'http://127.0.0.1:8000/asset/images/projects/thaco-tai.jpg', 2, NULL, NULL, '2024-10-11 15:26:09', '2024-10-11 15:34:46');
INSERT INTO `request_logs` VALUES (13, 404, 'https://signature.code/storage/news/20-150x150.jpg', 4, NULL, NULL, '2024-10-11 15:30:36', '2024-10-12 23:44:06');
INSERT INTO `request_logs` VALUES (14, 404, 'https://signature.code/storage/news/17-150x150.jpg', 4, NULL, NULL, '2024-10-11 15:30:36', '2024-10-12 23:44:07');
INSERT INTO `request_logs` VALUES (15, 404, 'https://signature.code/storage/news/19-150x150.jpg', 4, NULL, NULL, '2024-10-11 15:30:36', '2024-10-12 23:44:08');
INSERT INTO `request_logs` VALUES (16, 404, 'https://signature.code/storage/news/18-150x150.jpg', 4, NULL, NULL, '2024-10-11 15:30:36', '2024-10-12 23:44:06');
INSERT INTO `request_logs` VALUES (17, 404, 'https://signature.code/storage/news/16-150x150.jpg', 4, NULL, NULL, '2024-10-11 15:30:37', '2024-10-12 23:44:07');
INSERT INTO `request_logs` VALUES (18, 404, 'https://signature.code/storage/news/14-150x150.jpg', 4, NULL, NULL, '2024-10-11 15:30:37', '2024-10-12 23:44:07');
INSERT INTO `request_logs` VALUES (19, 404, 'https://signature.code/storage/news/15-150x150.jpg', 4, NULL, NULL, '2024-10-11 15:30:37', '2024-10-12 23:44:07');
INSERT INTO `request_logs` VALUES (20, 404, 'https://signature.code/storage/news/13-150x150.jpg', 4, NULL, NULL, '2024-10-11 15:30:37', '2024-10-12 23:44:07');
INSERT INTO `request_logs` VALUES (21, 404, 'https://signature.code/storage/news/12-150x150.jpg', 4, NULL, NULL, '2024-10-11 15:30:37', '2024-10-12 23:44:08');
INSERT INTO `request_logs` VALUES (22, 404, 'https://signature.code/storage/news/11-150x150.jpg', 4, NULL, NULL, '2024-10-11 15:30:37', '2024-10-12 23:44:07');
INSERT INTO `request_logs` VALUES (23, 404, 'https://signature.code/asset/images/projects/new-carnival.jpg', 1, NULL, NULL, '2024-10-11 15:31:59', '2024-10-11 15:31:59');
INSERT INTO `request_logs` VALUES (24, 404, 'https://signature.code/asset/images/projects/lagoona.jpg', 1, NULL, NULL, '2024-10-11 15:31:59', '2024-10-11 15:31:59');
INSERT INTO `request_logs` VALUES (25, 404, 'https://signature.code/asset/images/projects/mitsuheavy.jpg', 1, NULL, NULL, '2024-10-11 15:31:59', '2024-10-11 15:31:59');
INSERT INTO `request_logs` VALUES (26, 404, 'https://signature.code/asset/images/projects/usedcar.jpg', 1, NULL, NULL, '2024-10-11 15:31:59', '2024-10-11 15:31:59');
INSERT INTO `request_logs` VALUES (27, 404, 'https://signature.code/asset/images/projects/id-vnea.jpg', 1, NULL, NULL, '2024-10-11 15:32:00', '2024-10-11 15:32:00');
INSERT INTO `request_logs` VALUES (28, 404, 'https://signature.code/asset/images/projects/thaco-tai.jpg', 1, NULL, NULL, '2024-10-11 15:32:00', '2024-10-11 15:32:00');
INSERT INTO `request_logs` VALUES (29, 404, 'http://127.0.0.1:8000/ui/main/fonts/Platypi-Light.ttf', 6, NULL, NULL, '2024-10-11 15:34:37', '2024-10-11 16:16:44');
INSERT INTO `request_logs` VALUES (30, 404, 'http://127.0.0.1:8000/ui/main/fonts/Platypi-Bold.ttf', 1, NULL, NULL, '2024-10-11 15:34:39', '2024-10-11 15:34:39');
INSERT INTO `request_logs` VALUES (31, 404, 'https://signature.code/hop-dong', 6, NULL, NULL, '2024-10-11 15:43:48', '2024-10-11 15:49:48');
INSERT INTO `request_logs` VALUES (32, 404, 'https://signature.code/hop-dong/asf', 2, '[1]', NULL, '2024-10-11 15:55:21', '2024-10-11 15:58:34');
INSERT INTO `request_logs` VALUES (33, 404, 'http://127.0.0.1:8000/css/signature-pad.css', 6, NULL, NULL, '2024-10-11 16:16:08', '2024-10-11 16:35:31');
INSERT INTO `request_logs` VALUES (34, 404, 'http://127.0.0.1:8000/index', 1, '[1]', NULL, '2024-10-11 16:23:02', '2024-10-11 16:23:02');
INSERT INTO `request_logs` VALUES (35, 404, 'http://127.0.0.1:8000/js/signature_pad.umd.min.js', 12, NULL, NULL, '2024-10-11 16:30:58', '2024-10-11 16:49:59');
INSERT INTO `request_logs` VALUES (36, 404, 'http://127.0.0.1:8000/favicon.jpg', 1, '[1]', NULL, '2024-10-11 16:35:08', '2024-10-11 16:35:08');
INSERT INTO `request_logs` VALUES (37, 404, 'https://signature.code/admin/galleries', 1, NULL, NULL, '2024-10-11 16:59:15', '2024-10-11 16:59:15');
INSERT INTO `request_logs` VALUES (38, 404, 'http://127.0.0.1:8000/storage/news/20-150x150.jpg', 3, NULL, NULL, '2024-10-11 17:08:10', '2024-10-13 13:21:23');
INSERT INTO `request_logs` VALUES (39, 404, 'http://127.0.0.1:8000/storage/news/19-150x150.jpg', 3, NULL, NULL, '2024-10-11 17:08:10', '2024-10-13 13:21:23');
INSERT INTO `request_logs` VALUES (40, 404, 'http://127.0.0.1:8000/storage/news/18-150x150.jpg', 3, NULL, NULL, '2024-10-11 17:08:10', '2024-10-13 13:21:23');
INSERT INTO `request_logs` VALUES (41, 404, 'http://127.0.0.1:8000/storage/news/17-150x150.jpg', 3, NULL, NULL, '2024-10-11 17:08:10', '2024-10-13 13:21:24');
INSERT INTO `request_logs` VALUES (42, 404, 'http://127.0.0.1:8000/storage/news/16-150x150.jpg', 3, NULL, NULL, '2024-10-11 17:08:10', '2024-10-13 13:21:24');
INSERT INTO `request_logs` VALUES (43, 404, 'http://127.0.0.1:8000/storage/news/15-150x150.jpg', 3, NULL, NULL, '2024-10-11 17:08:11', '2024-10-13 13:21:24');
INSERT INTO `request_logs` VALUES (44, 404, 'http://127.0.0.1:8000/storage/news/13-150x150.jpg', 3, NULL, NULL, '2024-10-11 17:08:11', '2024-10-13 13:21:24');
INSERT INTO `request_logs` VALUES (45, 404, 'http://127.0.0.1:8000/storage/news/12-150x150.jpg', 3, NULL, NULL, '2024-10-11 17:08:11', '2024-10-13 13:21:24');
INSERT INTO `request_logs` VALUES (46, 404, 'http://127.0.0.1:8000/storage/news/14-150x150.jpg', 3, NULL, NULL, '2024-10-11 17:08:11', '2024-10-13 13:21:25');
INSERT INTO `request_logs` VALUES (47, 404, 'http://127.0.0.1:8000/storage/news/11-150x150.jpg', 3, NULL, NULL, '2024-10-11 17:08:12', '2024-10-13 13:21:25');
INSERT INTO `request_logs` VALUES (48, 404, 'http://127.0.0.1:8000/phpmyadmin', 1, '[1]', NULL, '2024-10-11 17:32:23', '2024-10-11 17:32:23');
INSERT INTO `request_logs` VALUES (49, 404, 'http://127.0.0.1:8000/file%201', 5, '[1]', NULL, '2024-10-11 17:40:00', '2024-10-11 17:56:29');
INSERT INTO `request_logs` VALUES (50, 404, 'http://127.0.0.1:8000/storage/ae21bfe63f107d5dc4e8861380409aaf.pdf', 7, NULL, NULL, '2024-10-11 17:56:35', '2024-10-12 05:53:19');
INSERT INTO `request_logs` VALUES (51, 404, 'http://127.0.0.1:8000/mockServiceWorker.js', 54, '[1]', NULL, '2024-10-11 19:40:16', '2024-10-12 15:30:56');
INSERT INTO `request_logs` VALUES (52, 404, 'http://127.0.0.1:8000/_ignition/health-check', 1, NULL, NULL, '2024-10-12 02:57:53', '2024-10-12 02:57:53');
INSERT INTO `request_logs` VALUES (53, 404, 'http://127.0.0.1:8000/ad', 2, '[1]', NULL, '2024-10-12 03:26:16', '2024-10-12 16:48:21');
INSERT INTO `request_logs` VALUES (54, 404, 'http://127.0.0.1:8000/hop-dong/%7B%7B%20get_object_image($contract-%3Efile%20?%22%22%29%20%7D%7D=', 2, '[1]', NULL, '2024-10-12 04:00:56', '2024-10-12 04:01:07');
INSERT INTO `request_logs` VALUES (55, 404, 'http://127.0.0.1:8000/hop-dong/your-pdf-url.pdf', 1, '[1]', NULL, '2024-10-12 04:33:36', '2024-10-12 04:33:36');
INSERT INTO `request_logs` VALUES (56, 405, 'http://127.0.0.1:8000/save-signature', 1, NULL, NULL, '2024-10-12 04:33:52', '2024-10-12 04:33:52');
INSERT INTO `request_logs` VALUES (57, 404, 'https://signature.code/load-signature', 8, '[1]', NULL, '2024-10-12 04:55:31', '2024-10-12 23:49:27');
INSERT INTO `request_logs` VALUES (58, 405, 'https://signature.code/save-signature', 2, NULL, NULL, '2024-10-12 05:03:32', '2024-10-12 05:03:37');
INSERT INTO `request_logs` VALUES (59, 404, 'https://signature.code/storage/ae21bfe63f107d5dc4e8861380409aaf.pdf', 1, NULL, NULL, '2024-10-12 05:53:45', '2024-10-12 05:53:45');
INSERT INTO `request_logs` VALUES (60, 404, 'http://127.0.0.1:8000/storage/screenshot-from-2024-10-11-18-00-07-150x150.png', 7, NULL, NULL, '2024-10-12 05:54:44', '2024-10-13 13:17:18');
INSERT INTO `request_logs` VALUES (61, 404, 'https://signature.code/storage/ae21bfe63f107d5dc4e8861380409aaf-1.pdf', 4, NULL, NULL, '2024-10-12 05:56:43', '2024-10-13 19:37:30');
INSERT INTO `request_logs` VALUES (62, 404, 'https://signature.code/storage/screenshot-from-2024-10-11-18-00-07-150x150.png', 16, NULL, NULL, '2024-10-12 05:57:11', '2024-10-14 11:41:19');
INSERT INTO `request_logs` VALUES (63, 404, 'http://127.0.0.1:8000/storage/ae21bfe63f107d5dc4e8861380409aaf-3.pdf', 2, NULL, NULL, '2024-10-12 14:51:29', '2024-10-12 14:59:51');
INSERT INTO `request_logs` VALUES (64, 404, 'https://signature.dev.fsofts.com/ui/main/css/style.css?v=1728720579', 1, NULL, NULL, '2024-10-12 15:09:42', '2024-10-12 15:09:42');
INSERT INTO `request_logs` VALUES (65, 404, 'https://signature.dev.fsofts.com/ui/main/js/script.js?v=1728720579', 1, NULL, NULL, '2024-10-12 15:09:42', '2024-10-12 15:09:42');
INSERT INTO `request_logs` VALUES (66, 404, 'https://signature.dev.fsofts.com/vendor/core/plugins/cookie-consent/css/cookie-consent.css?v=1.0.2', 1, NULL, NULL, '2024-10-12 15:09:42', '2024-10-12 15:09:42');
INSERT INTO `request_logs` VALUES (67, 404, 'https://signature.dev.fsofts.com/vendor/core/plugins/language/js/language-public.js?v=2.2.0', 1, NULL, NULL, '2024-10-12 15:09:42', '2024-10-12 15:09:42');
INSERT INTO `request_logs` VALUES (68, 404, 'https://signature.dev.fsofts.com/vendor/core/plugins/cookie-consent/js/cookie-consent.js?v=1.0.2', 1, NULL, NULL, '2024-10-12 15:09:42', '2024-10-12 15:09:42');
INSERT INTO `request_logs` VALUES (69, 404, 'https://signature.dev.fsofts.com/vendor/core/core/base/libraries/ckeditor/content-styles.css', 1, NULL, NULL, '2024-10-12 15:09:42', '2024-10-12 15:09:42');
INSERT INTO `request_logs` VALUES (70, 404, 'https://signature.dev.fsofts.com/vendor/core/plugins/language/css/language-public.css?v=2.2.0', 1, NULL, NULL, '2024-10-12 15:09:42', '2024-10-12 15:09:42');
INSERT INTO `request_logs` VALUES (71, 404, 'https://signature.dev.fsofts.com/vendor/core/plugins/language/css/language.css?v=7.4.1', 3, NULL, NULL, '2024-10-12 15:09:57', '2024-10-12 15:10:17');
INSERT INTO `request_logs` VALUES (72, 404, 'https://signature.dev.fsofts.com/vendor/core/core/base/css/core.css?v=7.4.1', 3, NULL, NULL, '2024-10-12 15:09:57', '2024-10-12 15:10:17');
INSERT INTO `request_logs` VALUES (73, 404, 'https://signature.dev.fsofts.com/vendor/core/core/base/images/logo.png', 3, NULL, NULL, '2024-10-12 15:09:57', '2024-10-12 15:10:17');
INSERT INTO `request_logs` VALUES (74, 404, 'https://signature.dev.fsofts.com/vendor/core/core/base/js/core-ui.js?v=7.4.1', 3, NULL, NULL, '2024-10-12 15:09:57', '2024-10-12 15:10:17');
INSERT INTO `request_logs` VALUES (75, 404, 'https://signature.dev.fsofts.com/vendor/core/core/base/libraries/jquery.min.js?v=7.4.1', 3, NULL, NULL, '2024-10-12 15:09:57', '2024-10-12 15:10:17');
INSERT INTO `request_logs` VALUES (76, 404, 'https://signature.dev.fsofts.com/vendor/core/core/base/js/app.js?v=7.4.1', 3, NULL, NULL, '2024-10-12 15:09:57', '2024-10-12 15:10:17');
INSERT INTO `request_logs` VALUES (77, 404, 'https://signature.dev.fsofts.com/vendor/core/core/base/libraries/flatpickr/flatpickr.min.js?v=7.4.1', 3, NULL, NULL, '2024-10-12 15:10:00', '2024-10-12 15:10:17');
INSERT INTO `request_logs` VALUES (78, 404, 'https://signature.dev.fsofts.com/vendor/core/core/acl/images/backgrounds/7.jpg', 1, NULL, NULL, '2024-10-12 15:10:00', '2024-10-12 15:10:00');
INSERT INTO `request_logs` VALUES (79, 404, 'https://signature.dev.fsofts.com/vendor/core/core/base/js/core.js?v=7.4.1', 3, NULL, NULL, '2024-10-12 15:10:00', '2024-10-12 15:10:17');
INSERT INTO `request_logs` VALUES (80, 404, 'https://signature.dev.fsofts.com/vendor/core/core/js-validation/js/js-validation.js?v=7.4.1', 3, NULL, NULL, '2024-10-12 15:10:00', '2024-10-12 15:10:17');
INSERT INTO `request_logs` VALUES (81, 404, 'https://signature.dev.fsofts.com/vendor/core/core/base/libraries/mcustom-scrollbar/jquery.mCustomScrollbar.js?v=7.4.1', 3, NULL, NULL, '2024-10-12 15:10:00', '2024-10-12 15:10:17');
INSERT INTO `request_logs` VALUES (82, 404, 'https://signature.dev.fsofts.com/vendor/core/core/base/libraries/jquery.are-you-sure/jquery.are-you-sure.js?v=7.4.1', 3, NULL, NULL, '2024-10-12 15:10:00', '2024-10-12 15:10:17');
INSERT INTO `request_logs` VALUES (83, 404, 'https://signature.dev.fsofts.com/vendor/core/core/base/libraries/fslightbox.js?v=7.4.1', 3, NULL, NULL, '2024-10-12 15:10:00', '2024-10-12 15:10:17');
INSERT INTO `request_logs` VALUES (84, 404, 'https://signature.dev.fsofts.com/vendor/core/plugins/language/js/language-global.js?v=7.4.1', 3, NULL, NULL, '2024-10-12 15:10:00', '2024-10-12 15:10:17');
INSERT INTO `request_logs` VALUES (85, 404, 'https://signature.dev.fsofts.com/vendor/core/core/base/images/favicon.png', 2, NULL, NULL, '2024-10-12 15:10:01', '2024-10-12 15:10:18');
INSERT INTO `request_logs` VALUES (86, 404, 'https://signature.dev.fsofts.com/vendor/core/core/acl/images/backgrounds/8.jpg', 1, NULL, NULL, '2024-10-12 15:10:14', '2024-10-12 15:10:14');
INSERT INTO `request_logs` VALUES (87, 404, 'https://signature.dev.fsofts.com/vendor/core/core/acl/images/backgrounds/3.jpg', 1, NULL, NULL, '2024-10-12 15:10:17', '2024-10-12 15:10:17');
INSERT INTO `request_logs` VALUES (88, 404, 'https://signature.code/storage/ae21bfe63f107d5dc4e8861380409aaf-3.pdf', 1, NULL, NULL, '2024-10-12 15:17:20', '2024-10-12 15:17:20');
INSERT INTO `request_logs` VALUES (89, 404, 'https://signature.dev.fsofts.com/storage/ae21bfe63f107d5dc4e8861380409aaf-3.pdf', 1, NULL, NULL, '2024-10-12 15:38:54', '2024-10-12 15:38:54');
INSERT INTO `request_logs` VALUES (90, 404, 'https://signature.dev.fsofts.com/hop-dong/hop-dong-', 1, NULL, NULL, '2024-10-12 15:39:29', '2024-10-12 15:39:29');
INSERT INTO `request_logs` VALUES (91, 404, 'https://signature.dev.fsofts.com/storage/screenshot-from-2024-10-11-18-00-07-150x150.png', 24, NULL, NULL, '2024-10-12 15:39:54', '2024-10-14 11:08:32');
INSERT INTO `request_logs` VALUES (92, 404, 'https://signature.dev.fsofts.com/load-signature', 1, '[2]', NULL, '2024-10-12 15:40:14', '2024-10-12 15:40:14');
INSERT INTO `request_logs` VALUES (93, 404, 'http://127.0.0.1:8000/storage/ae21bfe63f107d5dc4e8861380409aaf-4.pdf', 2, NULL, NULL, '2024-10-12 16:48:47', '2024-10-12 16:48:53');
INSERT INTO `request_logs` VALUES (94, 404, 'https://signature.dev.fsofts.com/.env', 5, NULL, NULL, '2024-10-12 22:12:33', '2024-10-14 08:04:38');
INSERT INTO `request_logs` VALUES (95, 404, 'https://www.signature.dev.fsofts.com/.env', 4, NULL, NULL, '2024-10-12 22:27:29', '2024-10-14 07:11:26');
INSERT INTO `request_logs` VALUES (96, 404, 'https://pdf-sig.code/storage/ae21bfe63f107d5dc4e8861380409aaf-4.pdf', 1, NULL, NULL, '2024-10-12 22:30:17', '2024-10-12 22:30:17');
INSERT INTO `request_logs` VALUES (97, 404, 'https://signature.dev.fsofts.com/hop-dong/hop-dong-thang-10-2/favicon.ico', 1, NULL, NULL, '2024-10-12 23:18:57', '2024-10-12 23:18:57');
INSERT INTO `request_logs` VALUES (98, 404, 'https://pdf-sig.code/hop-dong/hop-dong-1', 2, '[1]', NULL, '2024-10-12 23:48:51', '2024-10-13 00:54:11');
INSERT INTO `request_logs` VALUES (99, 404, 'http://127.0.0.1:8000//hop-dong/hop-dong-thang-10-2', 1, NULL, NULL, '2024-10-12 23:55:59', '2024-10-12 23:55:59');
INSERT INTO `request_logs` VALUES (100, 404, 'https://signature.code/storage/ae21bfe63f107d5dc4e8861380409aaf-4.pdf', 1, NULL, NULL, '2024-10-13 00:34:48', '2024-10-13 00:34:48');
INSERT INTO `request_logs` VALUES (101, 404, 'https://pdf-sig.code/storage/co3335-co3345-internship-report-copy.pdf', 18, NULL, NULL, '2024-10-13 00:54:24', '2024-10-13 01:30:07');
INSERT INTO `request_logs` VALUES (102, 404, 'https://signature.code/storage/co3335-co3345-internship-report-copy.pdf', 3, NULL, NULL, '2024-10-13 01:32:33', '2024-10-13 01:32:58');
INSERT INTO `request_logs` VALUES (103, 404, 'https://pdf-sig.code/storage/co3335-co3345-internship-report-copy-1.pdf', 10, NULL, NULL, '2024-10-13 01:33:17', '2024-10-13 01:45:44');
INSERT INTO `request_logs` VALUES (104, 404, 'https://signature.dev.fsofts.com/config.php', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (105, 404, 'https://signature.dev.fsofts.com/config.xml', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (106, 404, 'https://signature.dev.fsofts.com/config.yml', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (107, 404, 'https://signature.dev.fsofts.com/cloud-config.yml', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (108, 404, 'https://signature.dev.fsofts.com/config.yaml', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (109, 404, 'https://signature.dev.fsofts.com/wp-admin/setup-config.php', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (110, 404, 'https://signature.dev.fsofts.com/.ssh/id_ecdsa', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (111, 404, 'https://signature.dev.fsofts.com/config/database.php', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (112, 404, 'https://signature.dev.fsofts.com/.svn/wc.db', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (113, 404, 'https://signature.dev.fsofts.com/etc/ssl/private/server.key', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (114, 404, 'https://signature.dev.fsofts.com/config.json', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (115, 404, 'https://signature.dev.fsofts.com/.ssh/id_ed25519', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (116, 404, 'https://signature.dev.fsofts.com/config/production.json', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (117, 404, 'https://signature.dev.fsofts.com/dump.sql', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (118, 404, 'https://signature.dev.fsofts.com/user_secrets.yml', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (119, 404, 'https://signature.dev.fsofts.com/server-status', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (120, 404, 'https://signature.dev.fsofts.com/.git/HEAD', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (121, 404, 'https://signature.dev.fsofts.com/.vscode/sftp.json', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (122, 404, 'https://signature.dev.fsofts.com/etc/shadow', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (123, 404, 'https://signature.dev.fsofts.com/wp-config.php', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (124, 404, 'https://signature.dev.fsofts.com/_vti_pvt/administrators.pwd', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (125, 404, 'https://signature.dev.fsofts.com/_vti_pvt/service.pwd', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (126, 404, 'https://signature.dev.fsofts.com/backup.zip', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (127, 404, 'https://signature.dev.fsofts.com/.aws/credentials', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (128, 404, 'https://signature.dev.fsofts.com/api/.env', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (129, 404, 'https://signature.dev.fsofts.com/server.key', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (130, 404, 'https://signature.dev.fsofts.com/feed', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (131, 404, 'https://signature.dev.fsofts.com/database.sql', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (132, 404, 'https://signature.dev.fsofts.com/phpinfo.php', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (133, 404, 'https://signature.dev.fsofts.com/_vti_pvt/authors.pwd', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (134, 404, 'https://signature.dev.fsofts.com/backup.tar.gz', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (135, 404, 'https://signature.dev.fsofts.com/.env.production', 1, NULL, NULL, '2024-10-13 01:54:05', '2024-10-13 01:54:05');
INSERT INTO `request_logs` VALUES (136, 404, 'https://signature.dev.fsofts.com/.ssh/id_rsa', 1, NULL, NULL, '2024-10-13 01:54:06', '2024-10-13 01:54:06');
INSERT INTO `request_logs` VALUES (137, 404, 'https://signature.dev.fsofts.com/backup.sql', 1, NULL, NULL, '2024-10-13 01:54:06', '2024-10-13 01:54:06');
INSERT INTO `request_logs` VALUES (138, 404, 'https://signature.dev.fsofts.com/docker-compose.yml', 1, NULL, NULL, '2024-10-13 01:54:06', '2024-10-13 01:54:06');
INSERT INTO `request_logs` VALUES (139, 404, 'https://signature.dev.fsofts.com/.kube/config', 1, NULL, NULL, '2024-10-13 01:54:06', '2024-10-13 01:54:06');
INSERT INTO `request_logs` VALUES (140, 404, 'https://signature.dev.fsofts.com/secrets.json', 1, NULL, NULL, '2024-10-13 01:54:06', '2024-10-13 01:54:06');
INSERT INTO `request_logs` VALUES (141, 404, 'https://www.signature.dev.fsofts.com//www.signature.dev.fsofts.com/ui/main/libraries/pdf.js', 10, NULL, NULL, '2024-10-13 03:05:26', '2024-10-14 11:17:12');
INSERT INTO `request_logs` VALUES (142, 404, 'https://www.signature.dev.fsofts.com//cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js', 10, NULL, NULL, '2024-10-13 03:05:26', '2024-10-14 11:17:12');
INSERT INTO `request_logs` VALUES (143, 404, 'https://www.signature.dev.fsofts.com//www.signature.dev.fsofts.com/ui/main/libraries/signature_pad.umd.min.js', 10, NULL, NULL, '2024-10-13 03:05:26', '2024-10-14 11:17:12');
INSERT INTO `request_logs` VALUES (144, 404, 'https://www.signature.dev.fsofts.com/dist/js/bootstrap.min.js', 5, NULL, NULL, '2024-10-13 03:05:26', '2024-10-13 03:08:46');
INSERT INTO `request_logs` VALUES (145, 404, 'https://www.signature.dev.fsofts.com/dist/js/bootstrap.bundle.min.js', 5, NULL, NULL, '2024-10-13 03:05:26', '2024-10-13 03:08:46');
INSERT INTO `request_logs` VALUES (146, 404, 'https://www.signature.dev.fsofts.com//www.signature.dev.fsofts.com/ui/main/js/script.js', 8, NULL, NULL, '2024-10-13 03:05:26', '2024-10-14 11:17:12');
INSERT INTO `request_logs` VALUES (147, 404, 'https://www.signature.dev.fsofts.com//www.signature.dev.fsofts.com/vendor/core/plugins/language/js/language-public.js', 10, NULL, NULL, '2024-10-13 03:05:26', '2024-10-14 11:17:12');
INSERT INTO `request_logs` VALUES (148, 404, 'https://www.signature.dev.fsofts.com//www.signature.dev.fsofts.com/vendor/core/plugins/cookie-consent/js/cookie-consent....', 10, NULL, NULL, '2024-10-13 03:05:26', '2024-10-14 11:17:12');
INSERT INTO `request_logs` VALUES (149, 404, 'https://www.signature.dev.fsofts.com/dist/pdf-lib.min.js', 10, NULL, NULL, '2024-10-13 03:05:26', '2024-10-14 11:17:12');
INSERT INTO `request_logs` VALUES (150, 404, 'https://www.signature.dev.fsofts.com//www.signature.dev.fsofts.com/ui/main/libraries/app.js', 10, NULL, NULL, '2024-10-13 03:05:26', '2024-10-14 11:17:12');
INSERT INTO `request_logs` VALUES (151, 404, 'https://www.signature.dev.fsofts.com//cdn.js', 5, NULL, NULL, '2024-10-13 03:05:28', '2024-10-13 03:08:48');
INSERT INTO `request_logs` VALUES (152, 404, 'https://www.signature.dev.fsofts.com//cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js', 10, NULL, NULL, '2024-10-13 03:05:28', '2024-10-14 11:17:16');
INSERT INTO `request_logs` VALUES (153, 404, 'https://www.signature.dev.fsofts.com//www.signature.dev.fsofts.com/ui/main/libraries/jquery.js', 10, NULL, NULL, '2024-10-13 03:05:30', '2024-10-14 11:17:12');
INSERT INTO `request_logs` VALUES (154, 404, 'http://127.0.0.1:8000/ui/main/libraries/jquery.js', 4, NULL, NULL, '2024-10-13 13:21:14', '2024-10-13 13:24:34');
INSERT INTO `request_logs` VALUES (155, 404, 'http://127.0.0.1:8000/ui/main/libraries/signature_pad.umd.min.js', 4, NULL, NULL, '2024-10-13 13:21:15', '2024-10-13 13:24:34');
INSERT INTO `request_logs` VALUES (156, 404, 'http://127.0.0.1:8000/ui/main/libraries/app.js', 4, NULL, NULL, '2024-10-13 13:21:15', '2024-10-13 13:24:35');
INSERT INTO `request_logs` VALUES (157, 404, 'https://signature.code/ui/main/libraries/jquery.js', 3, NULL, NULL, '2024-10-13 13:57:04', '2024-10-13 13:57:20');
INSERT INTO `request_logs` VALUES (158, 404, 'https://signature.code/ui/main/libraries/signature_pad.umd.min.js', 3, NULL, NULL, '2024-10-13 13:57:04', '2024-10-13 13:57:20');
INSERT INTO `request_logs` VALUES (159, 404, 'https://signature.code/ui/main/libraries/app.js', 3, NULL, NULL, '2024-10-13 13:57:04', '2024-10-13 13:57:20');
INSERT INTO `request_logs` VALUES (160, 404, 'http://127.0.0.1:8000/hop-dong/undefined', 1, '[1]', NULL, '2024-10-13 14:26:29', '2024-10-13 14:26:29');
INSERT INTO `request_logs` VALUES (161, 404, 'http://127.0.0.1:8000/storage/signatures/5dIKNTRce6Z6MYw5Qd8Ps4AyH3Vrg5vdx9fz6MB4.pdf', 1, NULL, NULL, '2024-10-13 14:32:06', '2024-10-13 14:32:06');
INSERT INTO `request_logs` VALUES (162, 404, 'https://signature.dev.fsofts.com/hop-dong/demo/favicon.ico', 1, NULL, NULL, '2024-10-13 14:42:30', '2024-10-13 14:42:30');
INSERT INTO `request_logs` VALUES (163, 404, 'https://signature.dev.fsofts.com/hop-dong/demo1', 3, NULL, NULL, '2024-10-13 15:04:19', '2024-10-13 15:04:39');
INSERT INTO `request_logs` VALUES (164, 404, 'https://signature.dev.fsofts.com/apple-touch-icon.png', 1, NULL, NULL, '2024-10-13 15:05:38', '2024-10-13 15:05:38');
INSERT INTO `request_logs` VALUES (165, 404, 'https://signature.dev.fsofts.com/apple-touch-icon-precomposed.png', 1, NULL, NULL, '2024-10-13 15:05:38', '2024-10-13 15:05:38');
INSERT INTO `request_logs` VALUES (166, 404, 'https://signature.code/hop-dong/hop-dong-1', 1, '[1]', NULL, '2024-10-13 15:09:29', '2024-10-13 15:09:29');
INSERT INTO `request_logs` VALUES (167, 404, 'https://signature.dev.fsofts.com/storage/news/20-150x150.jpg', 1, NULL, NULL, '2024-10-13 15:25:52', '2024-10-13 15:25:52');
INSERT INTO `request_logs` VALUES (168, 404, 'https://signature.dev.fsofts.com/storage/news/19-150x150.jpg', 1, NULL, NULL, '2024-10-13 15:25:52', '2024-10-13 15:25:52');
INSERT INTO `request_logs` VALUES (169, 404, 'https://signature.dev.fsofts.com/storage/news/17-150x150.jpg', 1, NULL, NULL, '2024-10-13 15:25:52', '2024-10-13 15:25:52');
INSERT INTO `request_logs` VALUES (170, 404, 'https://signature.dev.fsofts.com/storage/news/11-150x150.jpg', 1, NULL, NULL, '2024-10-13 15:25:52', '2024-10-13 15:25:52');
INSERT INTO `request_logs` VALUES (171, 404, 'https://signature.dev.fsofts.com/storage/news/14-150x150.jpg', 1, NULL, NULL, '2024-10-13 15:25:52', '2024-10-13 15:25:52');
INSERT INTO `request_logs` VALUES (172, 404, 'https://signature.dev.fsofts.com/storage/news/13-150x150.jpg', 1, NULL, NULL, '2024-10-13 15:25:52', '2024-10-13 15:25:52');
INSERT INTO `request_logs` VALUES (173, 404, 'https://signature.dev.fsofts.com/storage/news/15-150x150.jpg', 1, NULL, NULL, '2024-10-13 15:25:52', '2024-10-13 15:25:52');
INSERT INTO `request_logs` VALUES (174, 404, 'https://signature.dev.fsofts.com/storage/news/18-150x150.jpg', 1, NULL, NULL, '2024-10-13 15:25:52', '2024-10-13 15:25:52');
INSERT INTO `request_logs` VALUES (175, 404, 'https://signature.dev.fsofts.com/storage/news/12-150x150.jpg', 1, NULL, NULL, '2024-10-13 15:25:52', '2024-10-13 15:25:52');
INSERT INTO `request_logs` VALUES (176, 404, 'https://signature.dev.fsofts.com/storage/news/16-150x150.jpg', 1, NULL, NULL, '2024-10-13 15:25:52', '2024-10-13 15:25:52');
INSERT INTO `request_logs` VALUES (177, 404, 'https://signature.dev.fsofts.com//code.jquery.com/jquery-3.6.0.min.js', 10, NULL, NULL, '2024-10-13 16:40:24', '2024-10-14 13:32:54');
INSERT INTO `request_logs` VALUES (178, 404, 'https://signature.dev.fsofts.com//signature.dev.fsofts.com/ui/main/libraries/pdf.js', 10, NULL, NULL, '2024-10-13 16:40:24', '2024-10-14 13:32:54');
INSERT INTO `request_logs` VALUES (179, 404, 'https://signature.dev.fsofts.com//signature.dev.fsofts.com/ui/main/js/script.js', 10, NULL, NULL, '2024-10-13 16:40:24', '2024-10-14 13:32:54');
INSERT INTO `request_logs` VALUES (180, 404, 'https://signature.dev.fsofts.com//signature.dev.fsofts.com/ui/main/libraries/app.js', 10, NULL, NULL, '2024-10-13 16:40:24', '2024-10-14 13:32:54');
INSERT INTO `request_logs` VALUES (181, 404, 'https://signature.dev.fsofts.com//signature.dev.fsofts.com/ui/main/libraries/jquery.js', 10, NULL, NULL, '2024-10-13 16:40:24', '2024-10-14 13:32:54');
INSERT INTO `request_logs` VALUES (182, 404, 'https://signature.dev.fsofts.com//signature.dev.fsofts.com/ui/main/libraries/signature_pad.umd.min.js', 10, NULL, NULL, '2024-10-13 16:40:24', '2024-10-14 13:32:54');
INSERT INTO `request_logs` VALUES (183, 404, 'https://signature.dev.fsofts.com//signature.dev.fsofts.com/vendor/core/plugins/cookie-consent/js/cookie-consent.js', 10, NULL, NULL, '2024-10-13 16:40:24', '2024-10-14 13:32:54');
INSERT INTO `request_logs` VALUES (184, 404, 'https://signature.dev.fsofts.com//cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js', 10, NULL, NULL, '2024-10-13 16:40:24', '2024-10-14 13:32:54');
INSERT INTO `request_logs` VALUES (185, 404, 'https://signature.dev.fsofts.com//signature.dev.fsofts.com/vendor/core/plugins/language/js/language-public.js', 10, NULL, NULL, '2024-10-13 16:40:24', '2024-10-14 13:32:54');
INSERT INTO `request_logs` VALUES (186, 404, 'https://signature.dev.fsofts.com/dist/pdf-lib.min.js', 10, NULL, NULL, '2024-10-13 16:40:24', '2024-10-14 13:32:54');
INSERT INTO `request_logs` VALUES (187, 404, 'https://signature.dev.fsofts.com//stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', 10, NULL, NULL, '2024-10-13 16:40:24', '2024-10-14 13:32:54');
INSERT INTO `request_logs` VALUES (188, 404, 'https://signature.dev.fsofts.com//cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js', 9, NULL, NULL, '2024-10-13 16:41:17', '2024-10-14 13:32:54');
INSERT INTO `request_logs` VALUES (189, 404, 'https://signature.dev.fsofts.com/hop-dong/demo', 2, NULL, NULL, '2024-10-13 20:19:07', '2024-10-13 20:19:10');
INSERT INTO `request_logs` VALUES (190, 404, 'https://signature.dev.fsofts.com/storage/ae21bfe63f107d5dc4e8861380409aaf-5.pdf', 4, NULL, NULL, '2024-10-14 00:46:45', '2024-10-14 10:21:05');
INSERT INTO `request_logs` VALUES (191, 404, 'https://signature.dev.fsofts.com/wp-admin/setup-config.php?step=1', 1, NULL, NULL, '2024-10-14 03:29:59', '2024-10-14 03:29:59');
INSERT INTO `request_logs` VALUES (192, 404, 'https://signature.dev.fsofts.com/.git/config', 1, NULL, NULL, '2024-10-14 07:48:14', '2024-10-14 07:48:14');
INSERT INTO `request_logs` VALUES (193, 404, 'https://signature.code/storage/testpdf.pdf', 1, NULL, NULL, '2024-10-14 10:40:24', '2024-10-14 10:40:24');
INSERT INTO `request_logs` VALUES (194, 404, 'https://signature.code/storage/1-150x150.png', 5, NULL, NULL, '2024-10-14 10:40:30', '2024-10-14 11:41:19');
INSERT INTO `request_logs` VALUES (195, 404, 'http://127.0.0.1:8000/storage/co3335-co3345-internship-report-copy-2.pdf', 10, NULL, NULL, '2024-10-14 10:54:08', '2024-10-14 11:01:42');
INSERT INTO `request_logs` VALUES (196, 404, 'https://signature.dev.fsofts.com/storage/co3335-co3345-internship-report-copy-2.pdf', 1, NULL, NULL, '2024-10-14 11:08:23', '2024-10-14 11:08:23');
INSERT INTO `request_logs` VALUES (197, 404, 'https://www.signature.dev.fsofts.com//code.jquery.com/jquery-3.6.0.min.js', 5, NULL, NULL, '2024-10-14 11:13:51', '2024-10-14 11:17:14');
INSERT INTO `request_logs` VALUES (198, 404, 'https://www.signature.dev.fsofts.com//stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', 5, NULL, NULL, '2024-10-14 11:13:51', '2024-10-14 11:17:12');

-- ----------------------------
-- Table structure for revisions
-- ----------------------------
DROP TABLE IF EXISTS `revisions`;
CREATE TABLE `revisions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `revisionable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `revisionable_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `key` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `new_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `revisions_revisionable_id_revisionable_type_index`(`revisionable_id` ASC, `revisionable_type` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of revisions
-- ----------------------------
INSERT INTO `revisions` VALUES (1, 'Dev\\Page\\Models\\Page', 2, 1, 'name', 'Blog', 'Hợp đồng', '2024-10-11 15:42:19', '2024-10-11 15:42:19');
INSERT INTO `revisions` VALUES (2, 'Dev\\Page\\Models\\Page', 2, 1, 'template', NULL, 'default', '2024-10-11 15:42:19', '2024-10-11 15:42:19');
INSERT INTO `revisions` VALUES (3, 'Dev\\Page\\Models\\Page', 2, 1, 'description', NULL, '', '2024-10-11 15:42:19', '2024-10-11 15:42:19');
INSERT INTO `revisions` VALUES (4, 'Dev\\Page\\Models\\Page', 2, 1, 'template', 'default', 'contract', '2024-10-11 15:49:18', '2024-10-11 15:49:18');

-- ----------------------------
-- Table structure for role_users
-- ----------------------------
DROP TABLE IF EXISTS `role_users`;
CREATE TABLE `role_users`  (
  `user_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`, `role_id`) USING BTREE,
  INDEX `role_users_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `role_users_role_id_index`(`role_id` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of role_users
-- ----------------------------
INSERT INTO `role_users` VALUES (2, 1, '2024-10-12 15:38:41', '2024-10-12 15:38:41');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `description` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `is_default` tinyint UNSIGNED NOT NULL DEFAULT 0,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `roles_slug_unique`(`slug` ASC) USING BTREE,
  INDEX `roles_created_by_index`(`created_by` ASC) USING BTREE,
  INDEX `roles_updated_by_index`(`updated_by` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'admin', 'Admin', '{\"core.cms\":true,\"media.index\":true,\"files.index\":true,\"files.create\":true,\"files.edit\":true,\"files.trash\":true,\"files.destroy\":true,\"folders.index\":true,\"folders.create\":true,\"folders.edit\":true,\"folders.trash\":true,\"folders.destroy\":true,\"pages.index\":true,\"pages.create\":true,\"pages.edit\":true,\"pages.destroy\":true,\"galleries.index\":true,\"galleries.create\":true,\"galleries.edit\":true,\"galleries.destroy\":true,\"contract-management.index\":true,\"contract-management.create\":true,\"contract-management.edit\":true,\"contract-management.destroy\":true,\"settings.index\":true,\"users.index\":true,\"users.create\":true,\"users.edit\":true,\"users.destroy\":true,\"roles.index\":true,\"roles.create\":true,\"roles.edit\":true,\"roles.destroy\":true}', 'Admin users role', 1, 1, 1, '2024-08-27 04:25:54', '2024-10-12 15:37:58');

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `settings_key_unique`(`key` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 66 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES (1, 'media_random_hash', 'e91484e527dc585e1e9be266d83c292d', NULL, '2024-10-13 00:10:32');
INSERT INTO `settings` VALUES (2, 'api_enabled', '0', NULL, '2024-10-13 00:10:32');
INSERT INTO `settings` VALUES (3, 'analytics_dashboard_widgets', '0', '2024-08-27 04:25:54', '2024-10-13 00:10:32');
INSERT INTO `settings` VALUES (4, 'activated_plugins', '[\"language\",\"language-advanced\",\"cookie-consent\",\"custom-field\",\"request-log\",\"translation\",\"contract-management\",\"gallery\"]', NULL, '2024-10-13 00:10:32');
INSERT INTO `settings` VALUES (5, 'enable_recaptcha_superadmin@fsofts.com_contact_forms_fronts_contact_form', '1', '2024-08-27 04:25:54', '2024-10-13 00:10:32');
INSERT INTO `settings` VALUES (6, 'theme', 'main', NULL, '2024-10-13 00:10:32');
INSERT INTO `settings` VALUES (7, 'show_admin_bar', '0', NULL, '2024-10-13 00:10:33');
INSERT INTO `settings` VALUES (8, 'language_hide_default', '1', NULL, '2024-10-13 00:10:33');
INSERT INTO `settings` VALUES (9, 'language_switcher_display', 'dropdown', NULL, '2024-10-13 00:10:33');
INSERT INTO `settings` VALUES (10, 'language_display', 'all', NULL, '2024-10-13 00:10:33');
INSERT INTO `settings` VALUES (11, 'language_hide_languages', '[]', NULL, '2024-10-13 00:10:33');
INSERT INTO `settings` VALUES (12, 'theme-master-site_title', 'Just another Laravel CMS site', NULL, '2024-10-13 00:10:33');
INSERT INTO `settings` VALUES (13, 'theme-master-seo_description', 'With experience, we make sure to get every project done very fast and in time with high quality using our Laravel CMS https://cms.fsofts.com', NULL, '2024-10-13 00:10:33');
INSERT INTO `settings` VALUES (14, 'theme-master-copyright', '©%Y Your Company. All rights reserved.', NULL, '2024-10-13 00:10:33');
INSERT INTO `settings` VALUES (15, 'theme-master-favicon', 'general/favicon.png', NULL, '2024-10-13 00:10:33');
INSERT INTO `settings` VALUES (16, 'theme-master-logo', 'general/logo.png', NULL, '2024-10-13 00:10:33');
INSERT INTO `settings` VALUES (17, 'theme-master-website', 'https://cms.fsofts.com', NULL, '2024-10-13 00:10:33');
INSERT INTO `settings` VALUES (18, 'theme-master-contact_email', 'contact@fsofts.com', NULL, '2024-10-13 00:10:33');
INSERT INTO `settings` VALUES (19, 'theme-master-site_description', 'With experience, we make sure to get every project done very fast and in time with high quality using our Laravel CMS https://cms.fsofts.com', NULL, '2024-10-13 00:10:33');
INSERT INTO `settings` VALUES (20, 'theme-master-phone', '+(123) 345-6789', NULL, '2024-10-13 00:10:34');
INSERT INTO `settings` VALUES (21, 'theme-master-address', '214 West Arnold St. New York, NY 10002', NULL, '2024-10-13 00:10:34');
INSERT INTO `settings` VALUES (22, 'theme-master-cookie_consent_message', 'Your experience on this site will be improved by allowing cookies ', NULL, '2024-10-13 00:10:34');
INSERT INTO `settings` VALUES (23, 'theme-master-cookie_consent_learn_more_url', '/cookie-policy', NULL, '2024-10-13 00:10:34');
INSERT INTO `settings` VALUES (24, 'theme-master-cookie_consent_learn_more_text', 'Cookie Policy', NULL, '2024-10-13 00:10:34');
INSERT INTO `settings` VALUES (25, 'theme-master-homepage_id', '1', NULL, '2024-10-13 00:10:34');
INSERT INTO `settings` VALUES (26, 'theme-master-blog_page_id', '2', NULL, '2024-10-13 00:10:34');
INSERT INTO `settings` VALUES (27, 'theme-master-primary_color', '#AF0F26', NULL, '2024-10-13 00:10:34');
INSERT INTO `settings` VALUES (28, 'theme-master-primary_font', 'Roboto', NULL, '2024-10-13 00:10:35');
INSERT INTO `settings` VALUES (29, 'theme-master-social_links', '[[{\"key\":\"name\",\"value\":\"Facebook\"},{\"key\":\"icon\",\"value\":\"ti ti-brand-facebook\"},{\"key\":\"url\",\"value\":\"https:\\/\\/facebook.com\"}],[{\"key\":\"name\",\"value\":\"X (Twitter)\"},{\"key\":\"icon\",\"value\":\"ti ti-brand-x\"},{\"key\":\"url\",\"value\":\"https:\\/\\/x.com\"}],[{\"key\":\"name\",\"value\":\"YouTube\"},{\"key\":\"icon\",\"value\":\"ti ti-brand-youtube\"},{\"key\":\"url\",\"value\":\"https:\\/\\/youtube.com\"}]]', NULL, '2024-10-13 00:10:35');
INSERT INTO `settings` VALUES (30, 'theme-master-lazy_load_images', '1', NULL, '2024-10-13 00:10:35');
INSERT INTO `settings` VALUES (31, 'theme-master-lazy_load_placeholder_image', 'general/preloader.gif', NULL, '2024-10-13 00:10:35');
INSERT INTO `settings` VALUES (32, 'theme-main-homepage_id', '1', NULL, '2024-10-13 00:10:35');
INSERT INTO `settings` VALUES (33, 'theme-main-galleries_page_id', NULL, NULL, '2024-10-13 00:10:35');
INSERT INTO `settings` VALUES (34, 'admin_logo', '', NULL, '2024-10-13 00:10:35');
INSERT INTO `settings` VALUES (35, 'admin_favicon', '', NULL, '2024-10-13 00:10:35');
INSERT INTO `settings` VALUES (36, 'login_screen_backgrounds', '[]', NULL, '2024-10-13 00:10:35');
INSERT INTO `settings` VALUES (37, 'admin_title', 'khaizinam site', NULL, '2024-10-13 00:10:35');
INSERT INTO `settings` VALUES (38, 'admin_appearance_locale', 'en', NULL, '2024-10-13 00:10:35');
INSERT INTO `settings` VALUES (39, 'rich_editor', 'ckeditor', NULL, '2024-10-13 00:10:35');
INSERT INTO `settings` VALUES (40, 'admin_appearance_layout', 'vertical', NULL, '2024-10-13 00:10:35');
INSERT INTO `settings` VALUES (41, 'admin_appearance_show_menu_item_icon', '0', NULL, '2024-10-13 00:10:35');
INSERT INTO `settings` VALUES (42, 'admin_appearance_container_width', 'container-xl', NULL, '2024-10-13 00:10:35');
INSERT INTO `settings` VALUES (43, 'admin_primary_font', 'Inter', NULL, '2024-10-13 00:10:35');
INSERT INTO `settings` VALUES (44, 'admin_primary_color', '#206bc4', NULL, '2024-10-13 00:10:35');
INSERT INTO `settings` VALUES (45, 'admin_secondary_color', '#6c7a91', NULL, '2024-10-13 00:10:35');
INSERT INTO `settings` VALUES (46, 'admin_heading_color', 'inherit', NULL, '2024-10-13 00:10:35');
INSERT INTO `settings` VALUES (47, 'admin_text_color', '#182433', NULL, '2024-10-13 00:10:35');
INSERT INTO `settings` VALUES (48, 'admin_link_color', '#206bc4', NULL, '2024-10-13 00:10:35');
INSERT INTO `settings` VALUES (49, 'admin_link_hover_color', '#1a569d', NULL, '2024-10-13 00:10:36');
INSERT INTO `settings` VALUES (50, 'admin_appearance_custom_css', '', NULL, '2024-10-13 00:10:36');
INSERT INTO `settings` VALUES (51, 'admin_appearance_custom_header_js', '', NULL, '2024-10-13 00:10:36');
INSERT INTO `settings` VALUES (52, 'admin_appearance_custom_body_js', '', NULL, '2024-10-13 00:10:36');
INSERT INTO `settings` VALUES (53, 'admin_appearance_custom_footer_js', '', NULL, '2024-10-13 00:10:36');
INSERT INTO `settings` VALUES (54, 'show_theme_guideline_link', '0', NULL, '2024-10-13 00:10:36');
INSERT INTO `settings` VALUES (55, 'admin_appearance_locale_direction', 'ltr', NULL, '2024-10-13 00:10:36');
INSERT INTO `settings` VALUES (57, 'theme-main-en_US-homepage_id', '1', '2024-10-11 19:50:53', '2024-10-13 00:10:36');
INSERT INTO `settings` VALUES (58, 'admin_email', '[]', NULL, '2024-10-13 00:10:36');
INSERT INTO `settings` VALUES (59, 'time_zone', 'Asia/Ho_Chi_Minh', NULL, '2024-10-13 00:10:36');
INSERT INTO `settings` VALUES (60, 'locale_direction', 'ltr', NULL, '2024-10-13 00:10:36');
INSERT INTO `settings` VALUES (61, 'enable_send_error_reporting_via_email', '0', NULL, '2024-10-13 00:10:36');
INSERT INTO `settings` VALUES (62, 'redirect_404_to_homepage', '0', NULL, '2024-10-13 00:10:36');
INSERT INTO `settings` VALUES (63, 'request_log_data_retention_period', '30', NULL, '2024-10-13 00:10:36');
INSERT INTO `settings` VALUES (64, 'audit_log_data_retention_period', '30', NULL, '2024-10-13 00:10:36');
INSERT INTO `settings` VALUES (65, 'locale', 'vi', NULL, '2024-10-13 00:10:36');

-- ----------------------------
-- Table structure for signature_contract
-- ----------------------------
DROP TABLE IF EXISTS `signature_contract`;
CREATE TABLE `signature_contract`  (
  `signature_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID Chữ ký',
  `contract_id` bigint UNSIGNED NULL DEFAULT NULL COMMENT 'ID PDF họp đồng',
  PRIMARY KEY (`signature_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of signature_contract
-- ----------------------------

-- ----------------------------
-- Table structure for signatures
-- ----------------------------
DROP TABLE IF EXISTS `signatures`;
CREATE TABLE `signatures`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Người ký tên',
  `file` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Link file chữ ký',
  `contract_id` bigint UNSIGNED NULL DEFAULT NULL COMMENT 'ID hợp đpjc mẫu',
  `status` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 49 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of signatures
-- ----------------------------
INSERT INTO `signatures` VALUES (2, '12', 'signatures/epIpRkDlXzyRb9mzW5WOy3xM6DGIjuTTEtCTkEj0.pdf', 1, 'published', '2024-10-12 17:17:44', '2024-10-12 17:17:44');
INSERT INTO `signatures` VALUES (3, '1231231', 'signatures/qNjgAUqVNTZc0FbLk0aVe9JUfXCSJf7YVkSzOvsS.pdf', 1, 'published', '2024-10-12 17:44:24', '2024-10-12 17:44:24');
INSERT INTO `signatures` VALUES (4, '123123123', 'signatures/5V68EHz7rshruG61sAA179PD7h7FzSmeAdrAkTyV.pdf', 1, 'published', '2024-10-12 17:57:13', '2024-10-12 17:57:13');
INSERT INTO `signatures` VALUES (5, '123', 'signatures/9P3ZYmWQxiCwUI7f5MWWkoEKBnIjSn8FbuGyjMC1.pdf', 1, 'published', '2024-10-12 23:56:44', '2024-10-12 23:56:44');
INSERT INTO `signatures` VALUES (6, 'ád', 'signatures/A4gktD2KS28kFHWUM3erGvwDbJu65b1hIw86L6yk.pdf', 1, 'published', '2024-10-13 00:05:10', '2024-10-13 00:05:10');
INSERT INTO `signatures` VALUES (7, 'as', 'signatures/mvhR9PuhePsCPlJtX8qftBTPIQ3qL57XNNGpX5Sk.pdf', 1, 'published', '2024-10-13 00:31:23', '2024-10-13 00:31:23');
INSERT INTO `signatures` VALUES (8, 'aaa', 'signatures/AzYUzPvm63UaqG03frmKNiggmTzcf72ht3CTyNoA.pdf', 1, 'published', '2024-10-13 00:32:03', '2024-10-13 00:32:03');
INSERT INTO `signatures` VALUES (9, 'asss', 'signatures/9mdw073yxDiqKkE766Vcl4vsScxHvfML7jVL9oGv.pdf', 1, 'published', '2024-10-13 00:32:46', '2024-10-13 00:32:46');
INSERT INTO `signatures` VALUES (10, 'aaa', 'signatures/5dIKNTRce6Z6MYw5Qd8Ps4AyH3Vrg5vdx9fz6MB4.pdf', 1, 'published', '2024-10-13 00:33:22', '2024-10-13 00:33:22');
INSERT INTO `signatures` VALUES (11, 'as', 'signatures/SxtATZoNZjwJkWcxO7O8zH3aPjS406mCwa9nNFPk.pdf', 3, 'published', '2024-10-13 00:44:29', '2024-10-13 00:44:29');
INSERT INTO `signatures` VALUES (12, 'h', 'signatures/UrIBfJU3wwQi9agD1cDwM97Zxn4lMrtp1tkHF0lp.pdf', 3, 'published', '2024-10-13 00:46:34', '2024-10-13 00:46:34');
INSERT INTO `signatures` VALUES (13, 'as', 'signatures/1j6qinpeGBXlVXG8GVYU177eTHIa754JRuJYpK0o.pdf', 3, 'published', '2024-10-13 00:58:41', '2024-10-13 00:58:41');
INSERT INTO `signatures` VALUES (14, 'a', 'signatures/H4ekfGB1nNBd3mQrQHo2BjWrUQcY6I5iUENDMqzt.pdf', 3, 'published', '2024-10-13 00:59:58', '2024-10-13 00:59:58');
INSERT INTO `signatures` VALUES (15, 'a', 'signatures/9Y4qt8NCiQF4OB5jipu7nPNX6M7m204BT02KsdgD.pdf', 3, 'published', '2024-10-13 01:03:41', '2024-10-13 01:03:41');
INSERT INTO `signatures` VALUES (16, 'a', 'signatures/zTcPpKJbZMhgO4YrhFoeM7UrstaFxWTCDhNRNT4K.pdf', 3, 'published', '2024-10-13 01:14:25', '2024-10-13 01:14:25');
INSERT INTO `signatures` VALUES (17, 'ghh', 'signatures/Hz3S4Rj4GSSibBl2EmtYAYSj1DYrbIpm0ycFJlDq.pdf', 3, 'published', '2024-10-13 01:16:26', '2024-10-13 01:16:26');
INSERT INTO `signatures` VALUES (18, 'g', 'signatures/9zGDNTikLBNQbH4zGuP7lLByWQioGip7LAQMdeW0.pdf', 3, 'published', '2024-10-13 01:19:09', '2024-10-13 01:19:09');
INSERT INTO `signatures` VALUES (19, 'AA', 'signatures/H6q2pfwqZMphpol1oxBTakvblNmd9RogdimkznPA.pdf', 3, 'published', '2024-10-13 01:20:18', '2024-10-13 01:20:18');
INSERT INTO `signatures` VALUES (20, 'S', 'signatures/iLn8Je3qKcUU4hzUQ9l0WS1M8EWSFwHq9HFV3xum.pdf', 3, 'published', '2024-10-13 01:21:06', '2024-10-13 01:21:06');
INSERT INTO `signatures` VALUES (21, 'D', 'signatures/J0vBonDFTyd4jmHahKAMHKxGa4TwFW2mg2mRjdie.pdf', 3, 'published', '2024-10-13 01:21:58', '2024-10-13 01:21:58');
INSERT INTO `signatures` VALUES (22, '123123', 'signatures/SgSVknzs0IsyIyAhAppkOopLiDJrMxf5r1lKzGKW.pdf', 1, 'published', '2024-10-13 14:56:52', '2024-10-13 14:56:52');
INSERT INTO `signatures` VALUES (23, 'huu khai', 'signatures/nNYQJCteug2kPrus9NzYls7DDc98jMNERzyPYsTs.pdf', 1, 'published', '2024-10-13 20:00:01', '2024-10-13 20:00:01');
INSERT INTO `signatures` VALUES (24, 'a', 'signatures/7Rzf3w339Zw2B6JP9mZYluZlydFfrgJMp6dYdcy9.pdf', 1, 'published', '2024-10-14 11:15:48', '2024-10-14 11:15:48');
INSERT INTO `signatures` VALUES (25, 'Khai', 'signatures/7dwJIiJEiSRFecNkSBjjrvfT1OXvnx6tZQiJYit7.pdf', 1, 'published', '2024-10-14 11:17:21', '2024-10-14 11:17:21');
INSERT INTO `signatures` VALUES (26, 'Kha', 'signatures/XWVNmKPEX1h0qyh45nEdf1mXBWeoRHo5A7OYRnlg.pdf', 1, 'published', '2024-10-14 11:31:18', '2024-10-14 11:31:18');
INSERT INTO `signatures` VALUES (27, 'Kha', 'signatures/RAlnD8PL0iOjEDeBCiGatFvvVQVZxCTjq85mdfig.pdf', 1, 'published', '2024-10-14 11:31:19', '2024-10-14 11:31:19');
INSERT INTO `signatures` VALUES (28, 'Kha', 'signatures/DbKmPjGUyk5UltVKcjpFlXI8HxnVFsT7EIar3jdm.pdf', 1, 'published', '2024-10-14 11:31:28', '2024-10-14 11:31:28');
INSERT INTO `signatures` VALUES (29, 'Kha', 'signatures/DwR6hntxsZyUDvHK4GiYEXxa5qvPwO5YSBugxSz1.pdf', 1, 'published', '2024-10-14 11:31:33', '2024-10-14 11:31:33');
INSERT INTO `signatures` VALUES (30, 'Kha', 'signatures/P9srRcdykFKxIsMLfN3MxUJo6darX4obb1QoWxqN.pdf', 1, 'published', '2024-10-14 11:31:34', '2024-10-14 11:31:34');
INSERT INTO `signatures` VALUES (31, 'Khanh', 'signatures/EVvy5eEKKmjTLmky9pWKQQ7AhCukd6963LwAxtDw.pdf', 1, 'published', '2024-10-14 11:31:47', '2024-10-14 11:31:47');
INSERT INTO `signatures` VALUES (32, 'Khanh', 'signatures/k2ii6b3ziRXPfdPrtMboXIM07B8eOt3xvwySeT6V.pdf', 1, 'published', '2024-10-14 11:31:48', '2024-10-14 11:31:48');
INSERT INTO `signatures` VALUES (33, '123123', 'signatures/kfGgnbxYxKr7rWB7k3kGDyqjY3rYdT1nvPDbIzO1.pdf', 1, 'published', '2024-10-14 11:32:12', '2024-10-14 11:32:12');
INSERT INTO `signatures` VALUES (34, '123213', 'signatures/f215NQysd5AEgifQDuujqpryIgThGtJOsRHqipxh.pdf', 1, 'published', '2024-10-14 11:32:51', '2024-10-14 11:32:51');
INSERT INTO `signatures` VALUES (35, 'Lin', 'signatures/2GW2VDhxHx09SVQcaOiDhs0YUTl0Ry5b3PhmxwBK.pdf', 1, 'published', '2024-10-14 11:33:12', '2024-10-14 11:33:12');
INSERT INTO `signatures` VALUES (36, 'as', 'signatures/sfPfA3MERwXOp88bobsNIV1ffaTzFh1w8KeHvKIK.pdf', 1, 'published', '2024-10-14 11:37:04', '2024-10-14 11:37:04');
INSERT INTO `signatures` VALUES (37, 'Nglin', 'signatures/orVGf2BA7kdTfoOv0Uj2fUYC4q7IOFuIRDiFITUc.pdf', 1, 'published', '2024-10-14 11:37:06', '2024-10-14 11:37:06');
INSERT INTO `signatures` VALUES (38, 'Test', 'signatures/ZwzjJM0ec9vgf6bSQfSIl5EMOtmQcOXNm5mnmQkf.pdf', 1, 'published', '2024-10-14 11:37:48', '2024-10-14 11:37:48');
INSERT INTO `signatures` VALUES (39, 'https://signature.dev.fsofts.com/hop-dong/hop-dong-thang-10-2', 'signatures/4luqMQjmxHY4LKXgt4SqGxh7GKZtRfGKf1OV1xrB.pdf', 1, 'published', '2024-10-14 11:38:22', '2024-10-14 11:38:22');
INSERT INTO `signatures` VALUES (40, 'asas', 'signatures/62YyKwwYEEnRo8niPsvscFGFTDyboUNerz6DnX0A.pdf', 9, 'published', '2024-10-14 11:48:45', '2024-10-14 11:48:45');
INSERT INTO `signatures` VALUES (41, 'asas', 'signatures/0FYzeFiV4GFaVEyHZSDmiRRYMKp7RlaaQpTl5T1i.pdf', 9, 'published', '2024-10-14 11:48:48', '2024-10-14 11:48:48');
INSERT INTO `signatures` VALUES (42, 'asss', 'signatures/XCQUKJd2szNt3g4h17LVf1IQoPiqvcRqdLiTugv8.pdf', 9, 'published', '2024-10-14 11:52:08', '2024-10-14 11:52:08');
INSERT INTO `signatures` VALUES (43, 'ass', 'signatures/d1BGrqkl5wWIW8jCGSF0WEmIYz8QiwmcHcBdENgN.pdf', 9, 'published', '2024-10-14 11:54:17', '2024-10-14 11:54:17');
INSERT INTO `signatures` VALUES (44, 'ass', 'signatures/I2wHtn3nPbH62QIFGEXEnPmlw8eDLHH5rn1ZO5nN.pdf', 9, 'published', '2024-10-14 11:54:57', '2024-10-14 11:54:57');
INSERT INTO `signatures` VALUES (45, 'as', 'signatures/p66OnDW9wA5BGvnfd21VzCK52ooh53uGBPMLuBYz.pdf', 9, 'published', '2024-10-14 11:55:23', '2024-10-14 11:55:23');
INSERT INTO `signatures` VALUES (46, 'Khai', 'signatures/M9ksSQ9Xwe57xCBdhxMXzgmXDOPYot8gBPkVoDlc.pdf', 1, 'published', '2024-10-14 11:56:53', '2024-10-14 11:56:53');
INSERT INTO `signatures` VALUES (47, 'Kinh', 'signatures/90m0hE0MD0oIE3uBbEhqFdVsazOifmAlXGeiSauS.pdf', 1, 'published', '2024-10-14 11:57:42', '2024-10-14 11:57:42');
INSERT INTO `signatures` VALUES (48, 'Khai', 'signatures/ZfpIc7BHG5q64bprVXSs2dJRg5GC1LqHJOjc9Dwn.pdf', 1, 'published', '2024-10-14 12:00:24', '2024-10-14 12:00:24');

-- ----------------------------
-- Table structure for slugs
-- ----------------------------
DROP TABLE IF EXISTS `slugs`;
CREATE TABLE `slugs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` bigint UNSIGNED NOT NULL,
  `reference_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prefix` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `slugs_reference_id_index`(`reference_id` ASC) USING BTREE,
  INDEX `slugs_key_index`(`key` ASC) USING BTREE,
  INDEX `slugs_prefix_index`(`prefix` ASC) USING BTREE,
  INDEX `slugs_reference_index`(`reference_id` ASC, `reference_type` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 66 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of slugs
-- ----------------------------
INSERT INTO `slugs` VALUES (1, 'homepage', 1, 'Dev\\Page\\Models\\Page', '', '2024-08-27 04:25:54', '2024-08-27 04:25:54');
INSERT INTO `slugs` VALUES (2, 'hop-dong', 2, 'Dev\\Page\\Models\\Page', '', '2024-08-27 04:25:54', '2024-10-11 15:42:20');
INSERT INTO `slugs` VALUES (3, 'contact', 3, 'Dev\\Page\\Models\\Page', '', '2024-08-27 04:25:54', '2024-08-27 04:25:54');
INSERT INTO `slugs` VALUES (4, 'cookie-policy', 4, 'Dev\\Page\\Models\\Page', '', '2024-08-27 04:25:54', '2024-08-27 04:25:54');
INSERT INTO `slugs` VALUES (5, 'galleries', 5, 'Dev\\Page\\Models\\Page', '', '2024-08-27 04:25:54', '2024-08-27 04:25:54');
INSERT INTO `slugs` VALUES (6, 'artificial-intelligence', 1, 'Dev\\Blog\\Models\\Category', '', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (7, 'cybersecurity', 2, 'Dev\\Blog\\Models\\Category', '', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (8, 'blockchain-technology', 3, 'Dev\\Blog\\Models\\Category', '', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (9, '5g-and-connectivity', 4, 'Dev\\Blog\\Models\\Category', '', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (10, 'augmented-reality-ar', 5, 'Dev\\Blog\\Models\\Category', '', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (11, 'green-technology', 6, 'Dev\\Blog\\Models\\Category', '', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (12, 'quantum-computing', 7, 'Dev\\Blog\\Models\\Category', '', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (13, 'edge-computing', 8, 'Dev\\Blog\\Models\\Category', '', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (14, 'ai', 1, 'Dev\\Blog\\Models\\Tag', 'tag', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (15, 'machine-learning', 2, 'Dev\\Blog\\Models\\Tag', 'tag', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (16, 'neural-networks', 3, 'Dev\\Blog\\Models\\Tag', 'tag', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (17, 'data-security', 4, 'Dev\\Blog\\Models\\Tag', 'tag', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (18, 'blockchain', 5, 'Dev\\Blog\\Models\\Tag', 'tag', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (19, 'cryptocurrency', 6, 'Dev\\Blog\\Models\\Tag', 'tag', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (20, 'iot', 7, 'Dev\\Blog\\Models\\Tag', 'tag', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (21, 'ar-gaming', 8, 'Dev\\Blog\\Models\\Tag', 'tag', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (22, 'breakthrough-in-quantum-computing-computing-power-reaches-milestone', 1, 'Dev\\Blog\\Models\\Post', '', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (23, '5g-rollout-accelerates-next-gen-connectivity-transforms-communication', 2, 'Dev\\Blog\\Models\\Post', '', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (24, 'tech-giants-collaborate-on-open-source-ai-framework', 3, 'Dev\\Blog\\Models\\Post', '', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (25, 'spacex-launches-mission-to-establish-first-human-colony-on-mars', 4, 'Dev\\Blog\\Models\\Post', '', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (26, 'cybersecurity-advances-new-protocols-bolster-digital-defense', 5, 'Dev\\Blog\\Models\\Post', '', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (27, 'artificial-intelligence-in-healthcare-transformative-solutions-for-patient-care', 6, 'Dev\\Blog\\Models\\Post', '', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (28, 'robotic-innovations-autonomous-systems-reshape-industries', 7, 'Dev\\Blog\\Models\\Post', '', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (29, 'virtual-reality-breakthrough-immersive-experiences-redefine-entertainment', 8, 'Dev\\Blog\\Models\\Post', '', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (30, 'innovative-wearables-track-health-metrics-and-enhance-well-being', 9, 'Dev\\Blog\\Models\\Post', '', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (31, 'tech-for-good-startups-develop-solutions-for-social-and-environmental-issues', 10, 'Dev\\Blog\\Models\\Post', '', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (32, 'ai-powered-personal-assistants-evolve-enhancing-productivity-and-convenience', 11, 'Dev\\Blog\\Models\\Post', '', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (33, 'blockchain-innovation-decentralized-finance-defi-reshapes-finance-industry', 12, 'Dev\\Blog\\Models\\Post', '', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (34, 'quantum-internet-secure-communication-enters-a-new-era', 13, 'Dev\\Blog\\Models\\Post', '', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (35, 'drone-technology-advances-applications-expand-across-industries', 14, 'Dev\\Blog\\Models\\Post', '', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (36, 'biotechnology-breakthrough-crispr-cas9-enables-precision-gene-editing', 15, 'Dev\\Blog\\Models\\Post', '', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `slugs` VALUES (37, 'augmented-reality-in-education-interactive-learning-experiences-for-students', 16, 'Dev\\Blog\\Models\\Post', '', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `slugs` VALUES (38, 'ai-in-autonomous-vehicles-advancements-in-self-driving-car-technology', 17, 'Dev\\Blog\\Models\\Post', '', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `slugs` VALUES (39, 'green-tech-innovations-sustainable-solutions-for-a-greener-future', 18, 'Dev\\Blog\\Models\\Post', '', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `slugs` VALUES (40, 'space-tourism-soars-commercial-companies-make-strides-in-space-travel', 19, 'Dev\\Blog\\Models\\Post', '', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `slugs` VALUES (41, 'humanoid-robots-in-everyday-life-ai-companions-and-assistants', 20, 'Dev\\Blog\\Models\\Post', '', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `slugs` VALUES (42, 'sunset', 1, 'Dev\\Gallery\\Models\\Gallery', 'galleries', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `slugs` VALUES (43, 'ocean-views', 2, 'Dev\\Gallery\\Models\\Gallery', 'galleries', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `slugs` VALUES (44, 'adventure-time', 3, 'Dev\\Gallery\\Models\\Gallery', 'galleries', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `slugs` VALUES (45, 'city-lights', 4, 'Dev\\Gallery\\Models\\Gallery', 'galleries', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `slugs` VALUES (46, 'dreamscape', 5, 'Dev\\Gallery\\Models\\Gallery', 'galleries', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `slugs` VALUES (47, 'enchanted-forest', 6, 'Dev\\Gallery\\Models\\Gallery', 'galleries', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `slugs` VALUES (48, 'golden-hour', 7, 'Dev\\Gallery\\Models\\Gallery', 'galleries', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `slugs` VALUES (49, 'serenity', 8, 'Dev\\Gallery\\Models\\Gallery', 'galleries', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `slugs` VALUES (50, 'eternal-beauty', 9, 'Dev\\Gallery\\Models\\Gallery', 'galleries', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `slugs` VALUES (51, 'moonlight-magic', 10, 'Dev\\Gallery\\Models\\Gallery', 'galleries', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `slugs` VALUES (52, 'starry-night', 11, 'Dev\\Gallery\\Models\\Gallery', 'galleries', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `slugs` VALUES (53, 'hidden-gems', 12, 'Dev\\Gallery\\Models\\Gallery', 'galleries', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `slugs` VALUES (54, 'tranquil-waters', 13, 'Dev\\Gallery\\Models\\Gallery', 'galleries', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `slugs` VALUES (55, 'urban-escape', 14, 'Dev\\Gallery\\Models\\Gallery', 'galleries', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `slugs` VALUES (56, 'twilight-zone', 15, 'Dev\\Gallery\\Models\\Gallery', 'galleries', '2024-08-27 04:25:57', '2024-08-27 04:25:57');
INSERT INTO `slugs` VALUES (57, 'hop-dong-thang-10-2', 1, 'Dev\\ContractManagement\\Models\\ContractManagement', 'hop-dong', '2024-10-11 19:25:09', '2024-10-11 19:25:09');
INSERT INTO `slugs` VALUES (65, 'test-tren-local', 9, 'Dev\\ContractManagement\\Models\\ContractManagement', 'hop-dong', '2024-10-13 20:20:32', '2024-10-14 11:41:37');

-- ----------------------------
-- Table structure for slugs_translations
-- ----------------------------
DROP TABLE IF EXISTS `slugs_translations`;
CREATE TABLE `slugs_translations`  (
  `lang_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slugs_id` bigint UNSIGNED NOT NULL,
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `prefix` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '',
  PRIMARY KEY (`lang_code`, `slugs_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of slugs_translations
-- ----------------------------

-- ----------------------------
-- Table structure for tags
-- ----------------------------
DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` bigint UNSIGNED NULL DEFAULT NULL,
  `author_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Dev\\ACL\\Models\\User',
  `description` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tags
-- ----------------------------
INSERT INTO `tags` VALUES (1, 'AI', NULL, 'Dev\\ACL\\Models\\User', NULL, 'published', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `tags` VALUES (2, 'Machine Learning', NULL, 'Dev\\ACL\\Models\\User', NULL, 'published', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `tags` VALUES (3, 'Neural Networks', NULL, 'Dev\\ACL\\Models\\User', NULL, 'published', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `tags` VALUES (4, 'Data Security', NULL, 'Dev\\ACL\\Models\\User', NULL, 'published', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `tags` VALUES (5, 'Blockchain', NULL, 'Dev\\ACL\\Models\\User', NULL, 'published', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `tags` VALUES (6, 'Cryptocurrency', NULL, 'Dev\\ACL\\Models\\User', NULL, 'published', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `tags` VALUES (7, 'IoT', NULL, 'Dev\\ACL\\Models\\User', NULL, 'published', '2024-08-27 04:25:56', '2024-08-27 04:25:56');
INSERT INTO `tags` VALUES (8, 'AR Gaming', NULL, 'Dev\\ACL\\Models\\User', NULL, 'published', '2024-08-27 04:25:56', '2024-08-27 04:25:56');

-- ----------------------------
-- Table structure for tags_translations
-- ----------------------------
DROP TABLE IF EXISTS `tags_translations`;
CREATE TABLE `tags_translations`  (
  `lang_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tags_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`lang_code`, `tags_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tags_translations
-- ----------------------------

-- ----------------------------
-- Table structure for user_meta
-- ----------------------------
DROP TABLE IF EXISTS `user_meta`;
CREATE TABLE `user_meta`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_meta_user_id_index`(`user_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of user_meta
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `first_name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `last_name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `username` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `avatar_id` bigint UNSIGNED NULL DEFAULT NULL,
  `super_user` tinyint(1) NOT NULL DEFAULT 0,
  `manage_supers` tinyint(1) NOT NULL DEFAULT 0,
  `permissions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE,
  UNIQUE INDEX `users_username_unique`(`username` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'superadmin@fsofts.com', NULL, '$2y$10$l30SUWOoAkHPXak.RVFMJ.LUttF1IVnYaHdRhUPLqm2gWXFdccAza', 'bVH2ndyaHGyNpy2c1Jms31Sl9wV3JAQVsO4PJRzrqM3nc6lNCdZiBbMdOPfc', '2024-08-27 04:25:54', '2024-08-27 04:25:54', 'Marianna', 'Conroy', 'admin', NULL, 1, 1, NULL, NULL);
INSERT INTO `users` VALUES (2, 'signature@admin.com', NULL, '$2y$12$FGrnNmAxga7CwcmQk0oqbODRM5NXccag1XJClnnHP.jzRGFNoQifS', 'r6who4KYr9rhk3wBEpTbcf526GBxCL2BoYViBNM7EcZZz2IKhOC0q4FsVqBp', '2024-10-12 15:38:41', '2024-10-12 15:38:41', 'Admin', 'Signature', 'signatureadmin', NULL, 0, 0, '{\"core.cms\":true,\"media.index\":true,\"files.index\":true,\"files.create\":true,\"files.edit\":true,\"files.trash\":true,\"files.destroy\":true,\"folders.index\":true,\"folders.create\":true,\"folders.edit\":true,\"folders.trash\":true,\"folders.destroy\":true,\"pages.index\":true,\"pages.create\":true,\"pages.edit\":true,\"pages.destroy\":true,\"galleries.index\":true,\"galleries.create\":true,\"galleries.edit\":true,\"galleries.destroy\":true,\"contract-management.index\":true,\"contract-management.create\":true,\"contract-management.edit\":true,\"contract-management.destroy\":true,\"settings.index\":true,\"users.index\":true,\"users.create\":true,\"users.edit\":true,\"users.destroy\":true,\"roles.index\":true,\"roles.create\":true,\"roles.edit\":true,\"roles.destroy\":true,\"superuser\":null,\"manage_supers\":null}', NULL);

-- ----------------------------
-- Table structure for widgets
-- ----------------------------
DROP TABLE IF EXISTS `widgets`;
CREATE TABLE `widgets`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `widget_id` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sidebar_id` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `theme` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` tinyint UNSIGNED NOT NULL DEFAULT 0,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of widgets
-- ----------------------------
INSERT INTO `widgets` VALUES (1, 'RecentPostsWidget', 'footer_sidebar', 'master', 0, '{\"id\":\"RecentPostsWidget\",\"name\":\"Recent Posts\",\"number_display\":5}', '2024-08-27 04:26:01', '2024-08-27 04:26:01');
INSERT INTO `widgets` VALUES (2, 'RecentPostsWidget', 'top_sidebar', 'master', 0, '{\"id\":\"RecentPostsWidget\",\"name\":\"Recent Posts\",\"number_display\":5}', '2024-08-27 04:26:01', '2024-08-27 04:26:01');
INSERT INTO `widgets` VALUES (3, 'TagsWidget', 'primary_sidebar', 'master', 0, '{\"id\":\"TagsWidget\",\"name\":\"Tags\",\"number_display\":5}', '2024-08-27 04:26:01', '2024-08-27 04:26:01');
INSERT INTO `widgets` VALUES (4, 'BlogCategoriesWidget', 'primary_sidebar', 'master', 1, '{\"id\":\"BlogCategoriesWidget\",\"name\":\"Categories\",\"display_posts_count\":\"yes\"}', '2024-08-27 04:26:01', '2024-08-27 04:26:01');
INSERT INTO `widgets` VALUES (5, 'CustomMenuWidget', 'primary_sidebar', 'master', 2, '{\"id\":\"CustomMenuWidget\",\"name\":\"Social\",\"menu_id\":\"social\"}', '2024-08-27 04:26:01', '2024-08-27 04:26:01');
INSERT INTO `widgets` VALUES (6, 'Dev\\Widget\\Widgets\\CoreSimpleMenu', 'footer_sidebar', 'master', 1, '{\"id\":\"Dev\\\\Widget\\\\Widgets\\\\CoreSimpleMenu\",\"name\":\"Favorite Websites\",\"items\":[[{\"key\":\"label\",\"value\":\"Speckyboy Magazine\"},{\"key\":\"url\",\"value\":\"https:\\/\\/speckyboy.com\"},{\"key\":\"attributes\",\"value\":\"\"},{\"key\":\"is_open_new_tab\",\"value\":\"1\"}],[{\"key\":\"label\",\"value\":\"Tympanus-Codrops\"},{\"key\":\"url\",\"value\":\"https:\\/\\/tympanus.com\"},{\"key\":\"attributes\",\"value\":\"\"},{\"key\":\"is_open_new_tab\",\"value\":\"1\"}],[{\"key\":\"label\",\"value\":\"Laravel Blog\"},{\"key\":\"url\",\"value\":\"https:\\/\\/cms.fsofts.com\\/blog\"},{\"key\":\"attributes\",\"value\":\"\"},{\"key\":\"is_open_new_tab\",\"value\":\"1\"}],[{\"key\":\"label\",\"value\":\"Laravel Vietnam\"},{\"key\":\"url\",\"value\":\"https:\\/\\/blog.laravelvietnam.org\"},{\"key\":\"attributes\",\"value\":\"\"},{\"key\":\"is_open_new_tab\",\"value\":\"1\"}],[{\"key\":\"label\",\"value\":\"CreativeBlog\"},{\"key\":\"url\",\"value\":\"https:\\/\\/www.creativebloq.com\"},{\"key\":\"attributes\",\"value\":\"\"},{\"key\":\"is_open_new_tab\",\"value\":\"1\"}],[{\"key\":\"label\",\"value\":\"Archi Elite JSC\"},{\"key\":\"url\",\"value\":\"https:\\/\\/archielite.com\"},{\"key\":\"attributes\",\"value\":\"\"},{\"key\":\"is_open_new_tab\",\"value\":\"1\"}]]}', '2024-08-27 04:26:01', '2024-08-27 04:26:01');
INSERT INTO `widgets` VALUES (7, 'Dev\\Widget\\Widgets\\CoreSimpleMenu', 'footer_sidebar', 'master', 2, '{\"id\":\"Dev\\\\Widget\\\\Widgets\\\\CoreSimpleMenu\",\"name\":\"My Links\",\"items\":[[{\"key\":\"label\",\"value\":\"Home Page\"},{\"key\":\"url\",\"value\":\"\\/\"},{\"key\":\"attributes\",\"value\":\"\"},{\"key\":\"is_open_new_tab\",\"value\":\"0\"}],[{\"key\":\"label\",\"value\":\"Contact\"},{\"key\":\"url\",\"value\":\"\\/contact\"},{\"key\":\"attributes\",\"value\":\"\"},{\"key\":\"is_open_new_tab\",\"value\":\"0\"}],[{\"key\":\"label\",\"value\":\"Green Technology\"},{\"key\":\"url\",\"value\":\"\\/green-technology\"},{\"key\":\"attributes\",\"value\":\"\"},{\"key\":\"is_open_new_tab\",\"value\":\"0\"}],[{\"key\":\"label\",\"value\":\"Augmented Reality (AR) \"},{\"key\":\"url\",\"value\":\"\\/augmented-reality-ar\"},{\"key\":\"attributes\",\"value\":\"\"},{\"key\":\"is_open_new_tab\",\"value\":\"0\"}],[{\"key\":\"label\",\"value\":\"Galleries\"},{\"key\":\"url\",\"value\":\"\\/galleries\"},{\"key\":\"attributes\",\"value\":\"\"},{\"key\":\"is_open_new_tab\",\"value\":\"0\"}]]}', '2024-08-27 04:26:01', '2024-08-27 04:26:01');

SET FOREIGN_KEY_CHECKS = 1;
