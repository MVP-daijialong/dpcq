/*
 Navicat Premium Data Transfer

 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : dpcq

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 27/06/2024 14:19:57
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for dp_attack_target
-- ----------------------------
DROP TABLE IF EXISTS `dp_attack_target`;
CREATE TABLE `dp_attack_target`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `target_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `target_des` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `map_id` int(10) NULL DEFAULT NULL,
  `target_type` tinyint(4) NULL DEFAULT NULL COMMENT '1 普通怪物 2 BOSS 3 玩家 4 NPC',
  `cycle` tinyint(4) UNSIGNED NULL DEFAULT 1 COMMENT '是否循环刷新 1否 2是',
  `num` int(10) UNSIGNED NULL DEFAULT 1 COMMENT '数量',
  `retreat_amount` int(10) UNSIGNED NULL DEFAULT 100 COMMENT '撤退金额',
  `target_pic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '图片',
  `created_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_attack_target
-- ----------------------------
INSERT INTO `dp_attack_target` VALUES (1, '野狼', '一头极其凶狠的狼，露出那狰狞的獠牙', 2, 1, 1, 2, 10, '/images/lang.jpeg', NULL);
INSERT INTO `dp_attack_target` VALUES (2, '路人甲', '平平无奇的路人甲', 1, 4, 1, 1, 0, NULL, NULL);

-- ----------------------------
-- Table structure for dp_attribute
-- ----------------------------
DROP TABLE IF EXISTS `dp_attribute`;
CREATE TABLE `dp_attribute`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `t_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `t_level` int(10) UNSIGNED NULL DEFAULT NULL,
  `t_hp` bigint(20) NOT NULL COMMENT '生命值',
  `t_min_gjl` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '最小攻击力',
  `t_max_gjl` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '最大攻击力',
  `t_fyl` int(10) NULL DEFAULT NULL COMMENT '防御力',
  `t_sd` int(10) NULL DEFAULT NULL COMMENT '速度',
  `t_bj` decimal(10, 2) NULL DEFAULT NULL COMMENT '暴击率',
  `t_bjxs` decimal(10, 2) NULL DEFAULT NULL COMMENT '暴击伤害系数',
  `t_xx` decimal(10, 2) UNSIGNED NULL DEFAULT NULL COMMENT '吸血率',
  `t_mb` decimal(10, 2) UNSIGNED NULL DEFAULT NULL COMMENT '麻痹几率',
  `created_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of dp_attribute
-- ----------------------------
INSERT INTO `dp_attribute` VALUES (1, 1, 1, 200, 30, 50, 20, 5, 0.00, 0.00, 0.00, 0.00, NULL);

-- ----------------------------
-- Table structure for dp_chats
-- ----------------------------
DROP TABLE IF EXISTS `dp_chats`;
CREATE TABLE `dp_chats`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `server_id` int(10) NULL DEFAULT NULL,
  `role_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `role_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `chat_channel` tinyint(4) NULL DEFAULT NULL COMMENT '1世界聊天 2当前场景 3私聊 4帮会',
  `content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_chats
-- ----------------------------
INSERT INTO `dp_chats` VALUES (1, 1, 1, '萧炎', 1, 'asdf ', '2024-06-27 11:39:40', '2024-06-27 11:39:40');
INSERT INTO `dp_chats` VALUES (2, 1, 2, '雷峰鳄灵海剑', 1, '1324564', '2024-06-27 11:40:03', '2024-06-27 11:40:03');
INSERT INTO `dp_chats` VALUES (3, 1, 1, '萧炎', 1, '123', '2024-06-27 11:41:18', '2024-06-27 11:41:18');
INSERT INTO `dp_chats` VALUES (4, 1, 2, '雷峰鳄灵海剑', 1, '6666', '2024-06-27 11:41:26', '2024-06-27 11:41:26');
INSERT INTO `dp_chats` VALUES (5, 1, 1, '萧炎', 1, '888', '2024-06-27 11:47:46', '2024-06-27 11:47:46');
INSERT INTO `dp_chats` VALUES (6, 1, 2, '雷峰鳄灵海剑', 1, '777', '2024-06-27 11:47:56', '2024-06-27 11:47:56');
INSERT INTO `dp_chats` VALUES (7, 1, 1, '萧炎', 1, '1111', '2024-06-27 11:51:41', '2024-06-27 11:51:41');
INSERT INTO `dp_chats` VALUES (8, 1, 2, '雷峰鳄灵海剑', 1, '2222', '2024-06-27 11:52:28', '2024-06-27 11:52:28');
INSERT INTO `dp_chats` VALUES (9, 1, 1, '萧炎', 1, '0000', '2024-06-27 11:53:31', '2024-06-27 11:53:31');
INSERT INTO `dp_chats` VALUES (10, 1, 1, '萧炎', 1, '00001', '2024-06-27 11:53:59', '2024-06-27 11:53:59');
INSERT INTO `dp_chats` VALUES (11, 1, 1, '萧炎', 1, '88888', '2024-06-27 12:08:44', '2024-06-27 12:08:44');
INSERT INTO `dp_chats` VALUES (12, 1, 1, '萧炎', 1, '多少', '2024-06-27 12:12:39', '2024-06-27 12:12:39');
INSERT INTO `dp_chats` VALUES (13, 1, 1, '萧炎', 1, '54', '2024-06-27 12:17:05', '2024-06-27 12:17:05');
INSERT INTO `dp_chats` VALUES (14, 1, 1, '萧炎', 1, '5555', '2024-06-27 12:17:44', '2024-06-27 12:17:44');
INSERT INTO `dp_chats` VALUES (15, 1, 1, '萧炎', 1, '799799', '2024-06-27 12:18:08', '2024-06-27 12:18:08');
INSERT INTO `dp_chats` VALUES (16, 1, 1, '萧炎', 1, '777', '2024-06-27 12:18:38', '2024-06-27 12:18:38');
INSERT INTO `dp_chats` VALUES (17, 1, 1, '萧炎', 1, '3142134', '2024-06-27 12:20:05', '2024-06-27 12:20:05');
INSERT INTO `dp_chats` VALUES (18, 1, 1, '萧炎', 1, '999', '2024-06-27 12:21:23', '2024-06-27 12:21:23');

-- ----------------------------
-- Table structure for dp_drop
-- ----------------------------
DROP TABLE IF EXISTS `dp_drop`;
CREATE TABLE `dp_drop`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `t_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `item_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '物品ID',
  `drop_num` int(11) NULL DEFAULT NULL COMMENT '掉落数量',
  `drop_probability` decimal(10, 2) UNSIGNED NOT NULL COMMENT '掉落概率',
  `drop_type` tinyint(4) UNSIGNED NULL DEFAULT 1 COMMENT '掉落类型 1道具 2装备',
  `created_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_drop
-- ----------------------------
INSERT INTO `dp_drop` VALUES (1, 1, '1', 10, 100.00, 1, NULL);
INSERT INTO `dp_drop` VALUES (2, 1, '10001', 1, 30.00, 2, NULL);
INSERT INTO `dp_drop` VALUES (3, 1, '10', 1, 50.00, 1, NULL);
INSERT INTO `dp_drop` VALUES (4, 1, '2', 15000, 100.00, 1, NULL);
INSERT INTO `dp_drop` VALUES (5, 1, '101', 1, 10.00, 1, NULL);

-- ----------------------------
-- Table structure for dp_duihua
-- ----------------------------
DROP TABLE IF EXISTS `dp_duihua`;
CREATE TABLE `dp_duihua`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `t_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `pid` int(10) UNSIGNED NULL DEFAULT NULL,
  `duihua_type` tinyint(4) UNSIGNED NULL DEFAULT 1 COMMENT '1普通对话 2任务对话',
  `click` tinyint(2) UNSIGNED NULL DEFAULT 1 COMMENT '1可以点击 2不可以',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_duihua
-- ----------------------------
INSERT INTO `dp_duihua` VALUES (1, 2, '你是谁？', 0, 1, 1, NULL, NULL);
INSERT INTO `dp_duihua` VALUES (2, 2, '这里是哪里？', 0, 1, 1, NULL, NULL);
INSERT INTO `dp_duihua` VALUES (3, 2, '我是路人甲，你个臭傻逼', 1, 1, 2, NULL, NULL);
INSERT INTO `dp_duihua` VALUES (4, 2, '这里是斗气大陆的一个偏僻小城', 2, 1, 2, NULL, NULL);
INSERT INTO `dp_duihua` VALUES (5, 2, '这里有多少个国家？', 2, 1, 1, NULL, NULL);
INSERT INTO `dp_duihua` VALUES (6, 2, '斗气大陆有23个国家', 5, 1, 2, NULL, NULL);

-- ----------------------------
-- Table structure for dp_equip_attribute
-- ----------------------------
DROP TABLE IF EXISTS `dp_equip_attribute`;
CREATE TABLE `dp_equip_attribute`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `e_hp` int(10) UNSIGNED NULL DEFAULT NULL,
  `e_min_gjl` int(10) UNSIGNED NULL DEFAULT NULL,
  `e_max_gjl` int(10) UNSIGNED NULL DEFAULT NULL,
  `e_fyl` int(10) UNSIGNED NULL DEFAULT NULL,
  `e_sd` int(10) UNSIGNED NULL DEFAULT NULL,
  `e_bj` decimal(10, 2) UNSIGNED NULL DEFAULT NULL COMMENT '暴击率',
  `e_bjxs` decimal(10, 2) UNSIGNED NULL DEFAULT NULL COMMENT '暴击系数',
  `e_level` int(10) NULL DEFAULT NULL COMMENT '装备等级',
  `e_quality` int(5) UNSIGNED NULL DEFAULT NULL COMMENT '1白 2赤 3橙 4黄 5绿 6青 7蓝 8紫',
  `e_position` tinyint(4) NULL DEFAULT NULL COMMENT '1头 2身 3手 4腰 5脚 6饰品',
  `drop_rate` decimal(10, 2) UNSIGNED NULL DEFAULT 20.00 COMMENT '掉落率',
  `e_xx` decimal(10, 2) UNSIGNED NULL DEFAULT NULL COMMENT '吸血率',
  `e_mb` decimal(10, 2) UNSIGNED NULL DEFAULT NULL COMMENT '麻痹几率',
  `suit_id` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '套装ID',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of dp_equip_attribute
-- ----------------------------
INSERT INTO `dp_equip_attribute` VALUES (1, 10001, 0, 10, 20, 0, 2, 0.00, 0.00, 1, 1, 3, 20.00, 0.00, 0.00, NULL, NULL, NULL);
INSERT INTO `dp_equip_attribute` VALUES (2, 80001, 3600, 0, 0, 1000, 0, 0.00, 0.00, 160, 8, 1, 1.00, 0.00, 0.00, 1, NULL, NULL);
INSERT INTO `dp_equip_attribute` VALUES (3, 80002, 2400, 0, 0, 600, 0, 0.00, 0.00, 155, 8, 2, 1.00, 0.00, 0.00, 1, NULL, NULL);
INSERT INTO `dp_equip_attribute` VALUES (4, 80003, 2800, 0, 0, 800, 0, 0.00, 0.00, 165, 8, 4, 1.00, 0.00, 0.00, 1, NULL, NULL);
INSERT INTO `dp_equip_attribute` VALUES (5, 80004, 4200, 0, 0, 500, 100, 0.00, 0.00, 175, 8, 5, 1.00, 0.00, 0.00, 1, NULL, NULL);
INSERT INTO `dp_equip_attribute` VALUES (6, 80005, 0, 800, 1600, 0, 0, 3.00, 1.00, 170, 8, 3, 1.00, 2.00, 1.00, NULL, NULL, NULL);
INSERT INTO `dp_equip_attribute` VALUES (7, 80006, 2000, 200, 480, 0, 50, 1.00, 1.00, 180, 8, 6, 1.00, 1.00, 1.00, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for dp_equip_suit
-- ----------------------------
DROP TABLE IF EXISTS `dp_equip_suit`;
CREATE TABLE `dp_equip_suit`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `suit_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `suit_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `s_hp` int(10) UNSIGNED NULL DEFAULT NULL,
  `s_min_gjl` int(10) UNSIGNED NULL DEFAULT NULL,
  `s_max_gjl` int(10) UNSIGNED NULL DEFAULT NULL,
  `s_fyl` int(10) UNSIGNED NULL DEFAULT NULL,
  `s_sd` int(10) NULL DEFAULT NULL,
  `s_bj` decimal(10, 2) UNSIGNED NULL DEFAULT NULL,
  `s_bjxs` decimal(10, 2) UNSIGNED NULL DEFAULT NULL,
  `s_xx` decimal(10, 2) NULL DEFAULT NULL,
  `s_mb` decimal(10, 2) NULL DEFAULT NULL,
  `s_desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_equip_suit
-- ----------------------------
INSERT INTO `dp_equip_suit` VALUES (1, 1, '四象圣套', 15000, 1800, 3600, 2000, 200, 5.00, 5.00, 5.00, 5.00, '三魔时代，四象陨落，但四象之力与它们的魂魄还游荡在天地之间。纵横的勇士经过千难万险，终于在四象圣殿发现了合成四象圣套的方法，于是各路勇士纷纷前往。此套有神秘的隐藏属性哦。', NULL, NULL);

-- ----------------------------
-- Table structure for dp_items
-- ----------------------------
DROP TABLE IF EXISTS `dp_items`;
CREATE TABLE `dp_items`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `item_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `gold_coin` int(10) UNSIGNED NULL DEFAULT NULL,
  `color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `pic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 42 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_items
-- ----------------------------
INSERT INTO `dp_items` VALUES (1, 1001, '圣耀鼎', '光影空间出产，乃世界光明本源分化而出的极一小部分形成，与黑魔鼎相对。', NULL, NULL, NULL, '2024-06-19 11:36:31', NULL);
INSERT INTO `dp_items` VALUES (2, 1002, '黑魔鼎', '黑色的药鼎，体型颇为壮硕，浑身上下隐隐缭绕着一股沉稳的气息，药鼎表面，还绘制着栩栩如生的火焰图腾，药鼎缓缓的旋转间，这些火焰图腾，竟然也是犹如实物一般，隐然间，淡淡的火焰能量，正在药鼎周围凝聚着。', NULL, NULL, NULL, '2024-06-19 11:36:57', NULL);
INSERT INTO `dp_items` VALUES (3, 1003, '万兽鼎', '药鼎体积颇大，在其周身布满着各种各样的奇异纹路，鼎身之上，雕刻着栩栩如生的猛兽图像，狰狞大嘴巨张时，若是附耳倾听的话，似乎能够隐隐的听见那从药鼎之中传出来的一此异样吼声，这种种异状，都是显示着这尊赤红药鼎的不凡。', NULL, NULL, NULL, '2024-06-19 11:37:42', NULL);
INSERT INTO `dp_items` VALUES (4, 1004, '山熔鼎', '一尊足有丈许庞大的药鼎，药鼎通体火红，在药鼎圆壁上，有着火山喷发般的图纹，一眼看上去，一股狂暴气息顿时迎面而来。', NULL, NULL, NULL, '2024-06-19 11:38:14', NULL);
INSERT INTO `dp_items` VALUES (5, 2001, '帝炎', '天生万物，各有其灵异，火也是如此。曾有一异火诞生于天地之间，千年成形，万年聚灵，万载潜修，冥冥中使得其略有几分变异。众所周知，一般异火成形极少会主动的离开诞生之地，而此火却是不同，在其拥有灵智之后，却是沿着地底岩浆而走，在那地底之下游荡千年，以吞火为生，而它所吞之火，皆是在异火榜上有所名次，其上二十二种都曾为其所食。此异火在功成之后，自命“帝炎”，而后再度修炼千载，方才破世而出。当年被人尊称为“陀舍古帝”。', NULL, NULL, NULL, '2024-06-19 11:39:18', NULL);
INSERT INTO `dp_items` VALUES (6, 2002, '虚无吞炎', '此火生于虚无之中，无相可寻，无形可抓，是一种相当奇异的存在。虚无吞炎号称吞天噬地之物，拥有着吞噬万物之能，天地之间唯有寥寥可数的东西方才能够抗衡那种吞噬之能。\r\n拥有分裂子火的能力，且虚无吞炎的子火也分有层次，在诸多寻常的子火之上，还生有两种奇特子火，称天地子火，从某种层次上来说算是幼生形态的虚无吞炎。', NULL, NULL, NULL, '2024-06-19 11:39:44', NULL);
INSERT INTO `dp_items` VALUES (7, 2003, '净莲妖火', '有净化万物的特效，任何东西只要被其沾上丁点，就将会被净化成一片虚无。其火焰甚至可以以人的情绪为引，进入体内，将肉体灵魂斗气都净化为虚无，威力极其恐怖。净莲妖火千百年来一直被净莲妖圣制造的妖火空间禁锢，妖火空间出现时：双月同现，九星一体，天地潮汐，妖火降世。当年妖火反噬净莲妖圣，得到了净莲妖圣的传承——梦魇天雾——能够让一个城市上百万的人在幻境中生活近百年，效果恐怖，后来被萧炎使用破魇之符所克。火焰呈莲型，乳白色，可化身为俊美的白袍男子，灵智极高，能将敌人打败后变成傀儡一般的火奴供其驱使，但对高级斗圣的控制力较低。', NULL, NULL, NULL, '2024-06-19 11:40:14', NULL);
INSERT INTO `dp_items` VALUES (8, 2004, '金帝焚天炎', '此火虽然比不上净莲妖火那般神秘，但在远古时也是拥有着赫赫威名，而且此种异火乃是古族传承之火，鲜有人能够将之降服。金帝焚天炎是号称连斗气都会被燃烧的可怕异火，传说中金帝焚天炎的第一任主人施展此火时可是直接将一位斗圣强者所创造的空间给焚烧成了一片虚无。', NULL, NULL, NULL, '2024-06-19 11:41:09', NULL);
INSERT INTO `dp_items` VALUES (9, 2005, '生灵之焱', '这等异火极为奇异，因为大多异火固然形态不同，可毕竟都是弥漫着毁灭之力，但这生灵之焱却并不展现强大的破坏力，它闻名于世的是它所充斥的那种生命之力。据说此等异火扩散而开，只要将药材的种子投入其中，那种子便是会迅速的发芽成长，也就是说只要有了这等异火，那基本不用考虑什么搜寻药材，只要你拥有着足够的种子，便是能够源源不断的得到想要的药材，端得是神奇无比。而且这生灵之焱也号称长寿之火，得到它的人寿命就算是比起那些以寿命著名的魔兽都是不遑多让，只不过唯一缺憾就是此火并不擅长战斗，对战斗力的增幅并非很强。', NULL, NULL, NULL, '2024-06-19 11:41:43', NULL);
INSERT INTO `dp_items` VALUES (10, 2006, '八荒破灭焱', '可化作一对足有百丈庞大的火焰双翼，霸道绝伦。', NULL, NULL, NULL, '2024-06-19 11:42:21', NULL);
INSERT INTO `dp_items` VALUES (11, 2007, '九幽金祖火', '可与火山石焰融合出新型异火，并能跟金帝焚天炎相抗衡而不落下风。', NULL, NULL, NULL, '2024-06-19 11:45:23', NULL);
INSERT INTO `dp_items` VALUES (12, 2008, '红莲业火', '深红、颇为妖艳的火焰，而在那火苗蹿升间，会形成一道道红莲之状。', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (13, 2009, '三千焱炎火', '又被称为“三千星空焱炎火”，呈紫黑色，成形于星空，能吸收星辰之力不断地变得强大。天降银火，千里之地如处沙漠，昼夜不分，星辰不现，耀日不出。由于身处星空那寻常人难以企及的地方，故而三千焱炎火一般的存在时间将会比其他异火更加长远一些，而也正因为此，方才给予了它足够的进化时间，所以说大多被发现的三千焱炎火，皆是属于那种灵智颇高的超级天地灵物，即便寻找到，可想要将之抓捕，也是极难之事。这种异火拥有着一种格外特殊的能力，那便是传闻中的“三千星空体质”。一些曾经与拥有过三千焱炎火的人战斗过的强者将之称为“不死体”，具有极强的恢复能力。只要不是被轰成肉泥，那么任何伤势都能恢复，不过只是时间问题罢了。', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (14, 2010, '九幽风炎', '诞生于极阴之地的无尽深渊之中，在那里阴风整年不休，此异火就成型于风罡最为猛烈之地。此火有着一种奇异的风声自其中传出，而这种风声传入人耳中会令人感觉到一丝异样的烦躁，这种异声能够引起人情绪上出现波动。', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (15, 2011, '骨灵冷火', '极寒与极热相结合的奇特火焰，只有在每百年日月交替之时，方才能够在极寒与极阴之地遇见。', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (16, 2012, '九龙雷罡火', '银色火焰，火焰升腾间隐隐间能够见到九条银色火龙在火焰之内穿梭而行。异火之内有着龙威凝聚，因此有着震慑灵魂之神效。银色火焰袅袅燃烧，九条细小的火龙在其中四下穿梭，犹如具备着灵智一般，而且隐隐间有着些许龙威从中弥漫而出，令得人灵魂力量感到有些压抑。此异火被焚炎谷传承了数百年，历代强者在火之本源里烙下了难以抹除的血魂印记，除非是修炼了焚炎谷的镇谷功法“青冥幽炎决”，不然的话即便是得到了九龙雷罡火，也绝对不可能持之纳为己用。', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (17, 2013, '龟灵地火', '形状如巨龟，浑身布满尖锐火刺，狰狞巨嘴中生满如同刀锋般的獠牙的褐色奇异火焰。', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (18, 2014, '陨落心炎', '火由心生，淬气炼骨。号称“修炼作弊器”，可以加快修炼。一旦成功炼化陨落心炎，那么体内便是会源源不断的产生一种心火，而这心火又会完全不用操控的每日每夜每时每刻的煅烧着体内斗气，在这等近乎不停歇的淬炼间，就犹如时时刻刻身体都处在修炼状态之中般，而且这修炼状态效果还比平日修炼更好，这种修炼速度自然会远远高于寻常修炼，所以称之为作弊器。此火还可召唤心火，将人从内而外焚烧殆尽。', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (19, 2015, '海心焰', '深蓝色火焰，看上去极为玄异，火焰升腾间，如同清澈海水般缓缓的扩散而开，淡淡的涟漪恍若水波。', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (20, 2016, '火云水炎', '炎族所有。', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (21, 2017, '火山石焰', '可与九幽金祖火融合出新型异火，并能跟金帝焚天炎相抗衡而不落下风。', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (22, 2018, '风怒龙炎', '生于古老沙漠中的火焰龙卷风的风眼之中。不同于其他异火，没有固定的地点，而是在每年的最热的几天内，随机出现在沙漠中的任何一处，极其罕见。施展出时会形成龙卷风形态，风与火相结合，火焰高达数百米，像一条巨大的火龙咆哮着旋转前进，具有极强的破坏能力，所到之处化成一片火海。', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (23, 2019, '青莲地心火', '顾名思义，即存在于地心熔岩之中的火焰。生于大地深处，历经大地之火的无数次锤炼、融合、压缩、雕制……十年成灵，百年成形，千年成莲，大成之时，其色偏青，莲心生一簇青火，其名为青莲火，也称青莲地心火。此火威力莫测，在临近火山地带之处甚至能够引发火山喷发，形成大自然的毁灭力量。与此火共生之宝有青莲座，修炼时可平心静气，避免走火入魔，还能使人对天地间火属性能量十分敏感，收集此莲座时需用玉器如玉尺玉刀等从火山地底之石上切割而下。另外青莲座上还产有至宝——地火莲子，其用途广泛，可辅助火属性斗气之人修炼，而地火莲子只有在青莲地心火与青莲座共处一地时百年才会凝聚出一颗。', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (24, 2020, '幽冥毒火', '存在于上古幽冥毒泽之中的火焰。经过毒泽中遮天毒瘴千万年的熏染，火焰燃食了无尽的毒瘴之气，百年成灵，千年成形，大成之时，其色偏绿，犹如鬼火一般在毒泽瘴气中穿行。由于火焰本身是毒瘴喂养成灵，含有剧毒，只要沾染片刻星火，便会身中剧毒，更别说是吞噬融合！也正是因为如此，很少有人去寻找这种异火，也就没有多少人知晓它的存在。\r\n化形为蝴蝶，火焰中充斥着毒性的异火，其形呈现淡紫色，吸收天地间奇毒而成，威力无穷，沾上一点就让人生不如死。', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (25, 2021, '阴阳双炎', '诞生于宇宙虚空之中，一黑一白两种颜色的火焰缠绕在一起，就犹如阴阳双鱼一般游动。阴阳便是自然法则，是孕育世间万物的本源。而诞生于本源之中的阴阳双炎便是本源所幻化出的其中一种火焰形态，充满生命和死亡的双重力量，阳火救人，生生不息，阴火杀人，尸骨无存', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (26, 2022, '万兽灵火', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (27, 2023, '玄黄炎', '火焰呈深黄色。', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (28, 1, '金币', '斗气大陆通用货币', NULL, '#FFB800', NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (29, 10001, '枯朽的木剑', '一把枯萎树枝做成的剑，看上去一碰就断', 100, '#c2c2c2', NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (30, 80001, '青龙★征天', '天地玄黄，众生虚妄，生死幻灭，轮回无常。一个卑微渺小的生灵，该如何问道？震四海，捍八方，屠苍天，灭法则，破轮回，霸气外泄，柔情内敛。天地的破灭，残存的六道，混沌的起源，长生的尽头，一切尽在其中。', 1000000, '#A00DAB', NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (31, 80002, '雪虎★霸野', '天地玄黄，众生虚妄，生死幻灭，轮回无常。一个卑微渺小的生灵，该如何问道？震四海，捍八方，屠苍天，灭法则，破轮回，霸气外泄，柔情内敛。天地的破灭，残存的六道，混沌的起源，长生的尽头，一切尽在其中。', 1000000, '#A00DAB', NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (32, 80003, '朱雀★焚魂', '天地玄黄，众生虚妄，生死幻灭，轮回无常。一个卑微渺小的生灵，该如何问道？震四海，捍八方，屠苍天，灭法则，破轮回，霸气外泄，柔情内敛。天地的破灭，残存的六道，混沌的起源，长生的尽头，一切尽在其中。', 1000000, '#A00DAB', NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (33, 80004, '玄武★撼山', '天地玄黄，众生虚妄，生死幻灭，轮回无常。一个卑微渺小的生灵，该如何问道？震四海，捍八方，屠苍天，灭法则，破轮回，霸气外泄，柔情内敛。天地的破灭，残存的六道，混沌的起源，长生的尽头，一切尽在其中。', 1000000, '#A00DAB', NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (34, 10, '狼肉', '一块狼肉', 50, 'red', NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (35, 2, '经验', NULL, NULL, '#FFB800', NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (36, 80005, '月华相思剑', '月华光耀，亲人远疏，万里孤穹，泪为相思。是为：月华相思剑。', 1000000, '#A00DAB', NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (37, 80006, '玄冰灵戒', NULL, NULL, '#A00DAB', NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (38, 101, '小还丹', '能够恢复少量生命的灵丹妙药', 20, '#5FB878', NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (39, 110, '体力宝(小)', '存储着100000点血，能够持续回血的神药', 100000, '#5FB878', NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (40, 111, '体力宝(中)', '存储着500000点血，能够持续回血的神药', 500000, '#5FB878', NULL, NULL, NULL);
INSERT INTO `dp_items` VALUES (41, 109, '大力神丸', '存储着5000点血，能够持续回血的神药', 5000, '#5FB878', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for dp_levels
-- ----------------------------
DROP TABLE IF EXISTS `dp_levels`;
CREATE TABLE `dp_levels`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` int(10) NULL DEFAULT NULL,
  `level` int(10) UNSIGNED NULL DEFAULT NULL,
  `level_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `exp` int(10) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `update_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 169 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_levels
-- ----------------------------
INSERT INTO `dp_levels` VALUES (1, 1, 1, '一段', 0, NULL, NULL);
INSERT INTO `dp_levels` VALUES (2, 1, 2, '二段', 60, NULL, NULL);
INSERT INTO `dp_levels` VALUES (3, 1, 3, '三段', 140, NULL, NULL);
INSERT INTO `dp_levels` VALUES (4, 1, 4, '四段', 240, NULL, NULL);
INSERT INTO `dp_levels` VALUES (5, 1, 5, '五段', 360, NULL, NULL);
INSERT INTO `dp_levels` VALUES (6, 1, 6, '六段', 500, NULL, NULL);
INSERT INTO `dp_levels` VALUES (7, 1, 7, '七段', 660, NULL, NULL);
INSERT INTO `dp_levels` VALUES (8, 1, 8, '八段', 840, NULL, NULL);
INSERT INTO `dp_levels` VALUES (9, 1, 9, '九段', 1040, NULL, NULL);
INSERT INTO `dp_levels` VALUES (10, 2, 10, '一星', 1260, NULL, NULL);
INSERT INTO `dp_levels` VALUES (11, 2, 11, '二星', 1500, NULL, NULL);
INSERT INTO `dp_levels` VALUES (12, 2, 12, '三星', 1760, NULL, NULL);
INSERT INTO `dp_levels` VALUES (13, 2, 13, '四星', 2040, NULL, NULL);
INSERT INTO `dp_levels` VALUES (14, 2, 14, '五星', 2340, NULL, NULL);
INSERT INTO `dp_levels` VALUES (15, 2, 15, '六星', 2660, NULL, NULL);
INSERT INTO `dp_levels` VALUES (16, 2, 16, '七星', 3000, NULL, NULL);
INSERT INTO `dp_levels` VALUES (17, 2, 17, '八星', 3360, NULL, NULL);
INSERT INTO `dp_levels` VALUES (18, 2, 18, '九星', 3740, NULL, NULL);
INSERT INTO `dp_levels` VALUES (19, 3, 19, '一星', 4140, NULL, NULL);
INSERT INTO `dp_levels` VALUES (20, 3, 20, '二星', 4560, NULL, NULL);
INSERT INTO `dp_levels` VALUES (21, 3, 21, '三星', 5000, NULL, NULL);
INSERT INTO `dp_levels` VALUES (22, 3, 22, '四星', 5460, NULL, NULL);
INSERT INTO `dp_levels` VALUES (23, 3, 23, '五星', 5940, NULL, NULL);
INSERT INTO `dp_levels` VALUES (24, 3, 24, '六星', 6440, NULL, NULL);
INSERT INTO `dp_levels` VALUES (25, 3, 25, '七星', 6960, NULL, NULL);
INSERT INTO `dp_levels` VALUES (26, 3, 26, '八星', 7500, NULL, NULL);
INSERT INTO `dp_levels` VALUES (27, 3, 27, '九星', 8060, NULL, NULL);
INSERT INTO `dp_levels` VALUES (28, 4, 28, '一星', 8640, NULL, NULL);
INSERT INTO `dp_levels` VALUES (29, 4, 29, '二星', 9240, NULL, NULL);
INSERT INTO `dp_levels` VALUES (30, 4, 30, '三星', 9860, NULL, NULL);
INSERT INTO `dp_levels` VALUES (31, 4, 31, '四星', 10500, NULL, NULL);
INSERT INTO `dp_levels` VALUES (32, 4, 32, '五星', 11160, NULL, NULL);
INSERT INTO `dp_levels` VALUES (33, 4, 33, '六星', 11840, NULL, NULL);
INSERT INTO `dp_levels` VALUES (34, 4, 34, '七星', 12540, NULL, NULL);
INSERT INTO `dp_levels` VALUES (35, 4, 35, '八星', 13260, NULL, NULL);
INSERT INTO `dp_levels` VALUES (36, 4, 36, '九星', 14000, NULL, NULL);
INSERT INTO `dp_levels` VALUES (37, 5, 37, '一星', 14760, NULL, NULL);
INSERT INTO `dp_levels` VALUES (38, 5, 38, '二星', 15540, NULL, NULL);
INSERT INTO `dp_levels` VALUES (39, 5, 39, '三星', 16340, NULL, NULL);
INSERT INTO `dp_levels` VALUES (40, 5, 40, '四星', 17160, NULL, NULL);
INSERT INTO `dp_levels` VALUES (41, 5, 41, '五星', 18000, NULL, NULL);
INSERT INTO `dp_levels` VALUES (42, 5, 42, '六星', 18860, NULL, NULL);
INSERT INTO `dp_levels` VALUES (43, 5, 43, '七星', 19740, NULL, NULL);
INSERT INTO `dp_levels` VALUES (44, 5, 44, '八星', 20640, NULL, NULL);
INSERT INTO `dp_levels` VALUES (45, 5, 45, '九星', 21560, NULL, NULL);
INSERT INTO `dp_levels` VALUES (46, 6, 46, '一星', 22500, NULL, NULL);
INSERT INTO `dp_levels` VALUES (47, 6, 47, '二星', 23460, NULL, NULL);
INSERT INTO `dp_levels` VALUES (48, 6, 48, '三星', 24440, NULL, NULL);
INSERT INTO `dp_levels` VALUES (49, 6, 49, '四星', 25440, NULL, NULL);
INSERT INTO `dp_levels` VALUES (50, 6, 50, '五星', 26460, NULL, NULL);
INSERT INTO `dp_levels` VALUES (51, 6, 51, '六星', 27500, NULL, NULL);
INSERT INTO `dp_levels` VALUES (52, 6, 52, '七星', 28560, NULL, NULL);
INSERT INTO `dp_levels` VALUES (53, 6, 53, '八星', 29640, NULL, NULL);
INSERT INTO `dp_levels` VALUES (54, 6, 54, '九星', 30740, NULL, NULL);
INSERT INTO `dp_levels` VALUES (55, 7, 55, '一星', 31860, NULL, NULL);
INSERT INTO `dp_levels` VALUES (56, 7, 56, '二星', 33000, NULL, NULL);
INSERT INTO `dp_levels` VALUES (57, 7, 57, '三星', 34160, NULL, NULL);
INSERT INTO `dp_levels` VALUES (58, 7, 58, '四星', 35340, NULL, NULL);
INSERT INTO `dp_levels` VALUES (59, 7, 59, '五星', 36540, NULL, NULL);
INSERT INTO `dp_levels` VALUES (60, 7, 60, '六星', 37760, NULL, NULL);
INSERT INTO `dp_levels` VALUES (61, 7, 61, '七星', 39000, NULL, NULL);
INSERT INTO `dp_levels` VALUES (62, 7, 62, '八星', 40260, NULL, NULL);
INSERT INTO `dp_levels` VALUES (63, 7, 63, '九星', 41540, NULL, NULL);
INSERT INTO `dp_levels` VALUES (64, 8, 64, '一星', 42840, NULL, NULL);
INSERT INTO `dp_levels` VALUES (65, 8, 65, '初段', 44160, NULL, NULL);
INSERT INTO `dp_levels` VALUES (66, 8, 66, '中段', 45500, NULL, NULL);
INSERT INTO `dp_levels` VALUES (67, 8, 67, '高段', 46860, NULL, NULL);
INSERT INTO `dp_levels` VALUES (68, 8, 68, '巅峰', 48240, NULL, NULL);
INSERT INTO `dp_levels` VALUES (69, 8, 69, '二星', 49640, NULL, NULL);
INSERT INTO `dp_levels` VALUES (70, 8, 70, '初段', 51060, NULL, NULL);
INSERT INTO `dp_levels` VALUES (71, 8, 71, '中段', 52500, NULL, NULL);
INSERT INTO `dp_levels` VALUES (72, 8, 72, '高段', 53960, NULL, NULL);
INSERT INTO `dp_levels` VALUES (73, 8, 73, '巅峰', 55440, NULL, NULL);
INSERT INTO `dp_levels` VALUES (74, 8, 74, '三星', 56940, NULL, NULL);
INSERT INTO `dp_levels` VALUES (75, 8, 75, '初段', 58460, NULL, NULL);
INSERT INTO `dp_levels` VALUES (76, 8, 76, '中段', 60000, NULL, NULL);
INSERT INTO `dp_levels` VALUES (77, 8, 77, '高段', 61560, NULL, NULL);
INSERT INTO `dp_levels` VALUES (78, 8, 78, '巅峰', 63140, NULL, NULL);
INSERT INTO `dp_levels` VALUES (79, 8, 79, '四星', 64740, NULL, NULL);
INSERT INTO `dp_levels` VALUES (80, 8, 80, '初段', 66360, NULL, NULL);
INSERT INTO `dp_levels` VALUES (81, 8, 81, '中段', 68000, NULL, NULL);
INSERT INTO `dp_levels` VALUES (82, 8, 82, '高段', 69660, NULL, NULL);
INSERT INTO `dp_levels` VALUES (83, 8, 83, '巅峰', 71340, NULL, NULL);
INSERT INTO `dp_levels` VALUES (84, 8, 84, '五星', 73040, NULL, NULL);
INSERT INTO `dp_levels` VALUES (85, 8, 85, '初段', 74760, NULL, NULL);
INSERT INTO `dp_levels` VALUES (86, 8, 86, '中段', 76500, NULL, NULL);
INSERT INTO `dp_levels` VALUES (87, 8, 87, '高段', 78260, NULL, NULL);
INSERT INTO `dp_levels` VALUES (88, 8, 88, '巅峰', 80040, NULL, NULL);
INSERT INTO `dp_levels` VALUES (89, 8, 89, '六星', 81840, NULL, NULL);
INSERT INTO `dp_levels` VALUES (90, 8, 90, '初段', 83660, NULL, NULL);
INSERT INTO `dp_levels` VALUES (91, 8, 91, '中段', 85500, NULL, NULL);
INSERT INTO `dp_levels` VALUES (92, 8, 92, '高段', 87360, NULL, NULL);
INSERT INTO `dp_levels` VALUES (93, 8, 93, '巅峰', 89240, NULL, NULL);
INSERT INTO `dp_levels` VALUES (94, 8, 94, '七星', 91140, NULL, NULL);
INSERT INTO `dp_levels` VALUES (95, 8, 95, '初段', 93060, NULL, NULL);
INSERT INTO `dp_levels` VALUES (96, 8, 96, '中段', 95000, NULL, NULL);
INSERT INTO `dp_levels` VALUES (97, 8, 97, '高段', 96960, NULL, NULL);
INSERT INTO `dp_levels` VALUES (98, 8, 98, '巅峰', 98940, NULL, NULL);
INSERT INTO `dp_levels` VALUES (99, 8, 99, '八星', 100940, NULL, NULL);
INSERT INTO `dp_levels` VALUES (100, 8, 100, '初段', 102960, NULL, NULL);
INSERT INTO `dp_levels` VALUES (101, 8, 101, '中段', 105000, NULL, NULL);
INSERT INTO `dp_levels` VALUES (102, 8, 102, '高段', 107060, NULL, NULL);
INSERT INTO `dp_levels` VALUES (103, 8, 103, '巅峰', 109140, NULL, NULL);
INSERT INTO `dp_levels` VALUES (104, 8, 104, '九星', 111240, NULL, NULL);
INSERT INTO `dp_levels` VALUES (105, 8, 105, '初段', 113360, NULL, NULL);
INSERT INTO `dp_levels` VALUES (106, 8, 106, '中段', 115500, NULL, NULL);
INSERT INTO `dp_levels` VALUES (107, 8, 107, '高段', 117660, NULL, NULL);
INSERT INTO `dp_levels` VALUES (108, 8, 108, '巅峰', 119840, NULL, NULL);
INSERT INTO `dp_levels` VALUES (109, 9, 109, '一星', 122040, NULL, NULL);
INSERT INTO `dp_levels` VALUES (110, 9, 110, '二星', 124260, NULL, NULL);
INSERT INTO `dp_levels` VALUES (111, 9, 111, '三星', 126500, NULL, NULL);
INSERT INTO `dp_levels` VALUES (112, 9, 112, '四星', 128760, NULL, NULL);
INSERT INTO `dp_levels` VALUES (113, 9, 113, '五星', 131040, NULL, NULL);
INSERT INTO `dp_levels` VALUES (114, 9, 114, '六星', 133340, NULL, NULL);
INSERT INTO `dp_levels` VALUES (115, 9, 115, '七星', 135660, NULL, NULL);
INSERT INTO `dp_levels` VALUES (116, 9, 116, '八星', 138000, NULL, NULL);
INSERT INTO `dp_levels` VALUES (117, 9, 117, '九星', 140360, NULL, NULL);
INSERT INTO `dp_levels` VALUES (118, 10, 118, '一转', 142740, NULL, NULL);
INSERT INTO `dp_levels` VALUES (119, 10, 119, '二转', 145140, NULL, NULL);
INSERT INTO `dp_levels` VALUES (120, 10, 120, '三转', 147560, NULL, NULL);
INSERT INTO `dp_levels` VALUES (121, 10, 121, '四转', 150000, NULL, NULL);
INSERT INTO `dp_levels` VALUES (122, 10, 122, '五转', 152460, NULL, NULL);
INSERT INTO `dp_levels` VALUES (123, 10, 123, '六转', 154940, NULL, NULL);
INSERT INTO `dp_levels` VALUES (124, 10, 124, '七转', 157440, NULL, NULL);
INSERT INTO `dp_levels` VALUES (125, 10, 125, '八转', 159960, NULL, NULL);
INSERT INTO `dp_levels` VALUES (126, 10, 126, '九转', 162500, NULL, NULL);
INSERT INTO `dp_levels` VALUES (127, 11, 127, '初级', 165060, NULL, NULL);
INSERT INTO `dp_levels` VALUES (128, 11, 128, '中级', 167640, NULL, NULL);
INSERT INTO `dp_levels` VALUES (129, 11, 129, '高级', 170240, NULL, NULL);
INSERT INTO `dp_levels` VALUES (130, 12, 130, '一星', 172860, NULL, NULL);
INSERT INTO `dp_levels` VALUES (131, 12, 131, '一星初期', 175500, NULL, NULL);
INSERT INTO `dp_levels` VALUES (132, 12, 132, '一星中期', 178160, NULL, NULL);
INSERT INTO `dp_levels` VALUES (133, 12, 133, '一星后期', 180840, NULL, NULL);
INSERT INTO `dp_levels` VALUES (134, 12, 134, '二星', 183540, NULL, NULL);
INSERT INTO `dp_levels` VALUES (135, 12, 135, '二星初期', 186260, NULL, NULL);
INSERT INTO `dp_levels` VALUES (136, 12, 136, '二星中期', 189000, NULL, NULL);
INSERT INTO `dp_levels` VALUES (137, 12, 137, '二星后期', 191760, NULL, NULL);
INSERT INTO `dp_levels` VALUES (138, 12, 138, '三星', 194540, NULL, NULL);
INSERT INTO `dp_levels` VALUES (139, 12, 139, '三星初期', 197340, NULL, NULL);
INSERT INTO `dp_levels` VALUES (140, 12, 140, '三星中期', 200160, NULL, NULL);
INSERT INTO `dp_levels` VALUES (141, 12, 141, '三星后期', 203000, NULL, NULL);
INSERT INTO `dp_levels` VALUES (142, 12, 142, '四星', 205860, NULL, NULL);
INSERT INTO `dp_levels` VALUES (143, 12, 143, '四星初期', 208740, NULL, NULL);
INSERT INTO `dp_levels` VALUES (144, 12, 144, '四星中期', 211640, NULL, NULL);
INSERT INTO `dp_levels` VALUES (145, 12, 145, '四星后期', 214560, NULL, NULL);
INSERT INTO `dp_levels` VALUES (146, 12, 146, '五星', 217500, NULL, NULL);
INSERT INTO `dp_levels` VALUES (147, 12, 147, '五星初期', 220460, NULL, NULL);
INSERT INTO `dp_levels` VALUES (148, 12, 148, '五星中期', 223440, NULL, NULL);
INSERT INTO `dp_levels` VALUES (149, 12, 149, '五星后期', 226440, NULL, NULL);
INSERT INTO `dp_levels` VALUES (150, 12, 150, '六星', 229460, NULL, NULL);
INSERT INTO `dp_levels` VALUES (151, 12, 151, '六星初期', 232500, NULL, NULL);
INSERT INTO `dp_levels` VALUES (152, 12, 152, '六星中期', 235560, NULL, NULL);
INSERT INTO `dp_levels` VALUES (153, 12, 153, '六星后期', 238640, NULL, NULL);
INSERT INTO `dp_levels` VALUES (154, 12, 154, '七星', 241740, NULL, NULL);
INSERT INTO `dp_levels` VALUES (155, 12, 155, '七星初期', 244860, NULL, NULL);
INSERT INTO `dp_levels` VALUES (156, 12, 156, '七星中期', 248000, NULL, NULL);
INSERT INTO `dp_levels` VALUES (157, 12, 157, '七星后期', 251160, NULL, NULL);
INSERT INTO `dp_levels` VALUES (158, 12, 158, '八星', 254340, NULL, NULL);
INSERT INTO `dp_levels` VALUES (159, 12, 159, '八星初期', 257540, NULL, NULL);
INSERT INTO `dp_levels` VALUES (160, 12, 160, '八星中期', 260760, NULL, NULL);
INSERT INTO `dp_levels` VALUES (161, 12, 161, '八星后期', 264000, NULL, NULL);
INSERT INTO `dp_levels` VALUES (162, 12, 162, '九星', 267260, NULL, NULL);
INSERT INTO `dp_levels` VALUES (163, 12, 163, '九星初期', 270540, NULL, NULL);
INSERT INTO `dp_levels` VALUES (164, 12, 164, '九星中期', 273840, NULL, NULL);
INSERT INTO `dp_levels` VALUES (165, 12, 165, '九星后期', 277160, NULL, NULL);
INSERT INTO `dp_levels` VALUES (166, 13, 166, '小圆满', 280500, NULL, NULL);
INSERT INTO `dp_levels` VALUES (167, 13, 167, '大圆满', 283860, NULL, NULL);
INSERT INTO `dp_levels` VALUES (168, 13, 168, '永恒', 287240, NULL, NULL);

-- ----------------------------
-- Table structure for dp_map
-- ----------------------------
DROP TABLE IF EXISTS `dp_map`;
CREATE TABLE `dp_map`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `map_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `map_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `pid` int(10) UNSIGNED NULL DEFAULT 0,
  `map_desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_map
-- ----------------------------
INSERT INTO `dp_map` VALUES (1, 1, '乌坦城', 0, '乌坦城，加玛帝国的一座大型城市之一，位于魔兽山脉附近。', NULL);
INSERT INTO `dp_map` VALUES (2, 2, '魔兽山脉', 1, '魔兽山脉是加玛帝国境界得一片山脉,这里是魔兽的乐园并且有着实力高强的魔兽在山脉里栖息,因为乌坦城背靠魔兽山脉,所以乌坦城也因此而繁荣,无数的佣兵团在乌坦城中建立,但同岁也有无数的佣兵团在消失,他们的躯体或许永远的留在了魔兽山脉之中。', NULL);
INSERT INTO `dp_map` VALUES (3, 3, '萧家家族内', 1, '一片欢声笑语。。。', NULL);
INSERT INTO `dp_map` VALUES (4, 4, '市集', 1, '人来人往，十分热闹', NULL);
INSERT INTO `dp_map` VALUES (5, 5, '魔石碑', 1, '一块神秘而带有古老气息的石碑', NULL);
INSERT INTO `dp_map` VALUES (6, 6, '山麓', 2, '荒无人烟', NULL);
INSERT INTO `dp_map` VALUES (7, 7, '山洞', 2, '阴森恐怖，看不见光', NULL);

-- ----------------------------
-- Table structure for dp_plevels
-- ----------------------------
DROP TABLE IF EXISTS `dp_plevels`;
CREATE TABLE `dp_plevels`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `level_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `level_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_plevels
-- ----------------------------
INSERT INTO `dp_plevels` VALUES (1, 1, '斗之气', '滋润筋骨，强壮身体，吸收斗之气进行强化');
INSERT INTO `dp_plevels` VALUES (2, 2, '斗者', '聚气成气旋，斗之气压缩成斗气。\r\n可内视，开始吸收斗气修炼，有了修炼功法的资格，修炼功法会将无属性的乳白斗气转化成功法的属性斗气。');
INSERT INTO `dp_plevels` VALUES (3, 3, '斗师', '气旋内的斗气由气态化液态。\r\n可召唤斗气纱衣为自身提供增幅。');
INSERT INTO `dp_plevels` VALUES (4, 4, '大斗师', '斗气旋内的斗气由液态化固态，形成不太规则的菱形晶体称为斗晶。\r\n斗气可离体外放，可将斗气覆盖在武器之上能增加攻击力，斗气纱衣蜕变成斗气铠甲。真正踏入了斗气修炼的殿堂。');
INSERT INTO `dp_plevels` VALUES (5, 5, '斗灵', '斗晶蜕变，形似海胆，做到斗气凝物，短距离飞行。\r\n斗晶圆润但具备九条长刺，一星收进一刺，其凝结出的武器与铠甲，远非寻常武器铠甲能够相比喻，拥有强大的攻击和防御。');
INSERT INTO `dp_plevels` VALUES (6, 6, '斗王', '斗气与天地间同属性能量共鸣，调动天地能量化为己用。\r\n仅凝聚斗气化翼为准斗王，斗气化翼后在空中停滞并且飞行一段时间为真王。\r\n斗晶真正圆润并壮大，可以身躯直接吸纳能量，能引动天地之力布置能量结界。\r\n踏入此境界便拥有了闯荡斗气大陆的资本，魔兽到这一阶段已具备灵智。');
INSERT INTO `dp_plevels` VALUES (7, 7, '斗皇', '掌控天地之力，可大量调动外界同属性能量，不借外力短时间停留虚空\r\n体内雄浑的斗气可施展出能量匹练进行攻击。\r\n魔兽到这一阶段已具备化形之力。');
INSERT INTO `dp_plevels` VALUES (8, 8, '斗宗', '踏空而行，在天空之上几乎能够如履平地。\r\n随意调动外界天地能量；初步操控空间之力，做到扭曲空间、空间封锁等，高阶懂得一些粗浅的空间之力；自身体内犹如脱胎换骨，经脉甚至骨骼之外有着一层淡淡的斗气晶层，光凭体内粘稠状斗气的运转便能引起天地空间的变化，举手投足有空间震荡之力，高阶斗宗凭借自身斗气影响一方天地能量变化。\r\n大陆强者真正的分水岭，拥有开宗立派的资格，从斗宗开始每一星之间都有着极大的差距，因此对于分级要显得更细微一些。\r\n魔兽到这一阶段灵智已跟人类无异。');
INSERT INTO `dp_plevels` VALUES (9, 9, '斗尊', '掌控空间之力，体内斗气浩瀚如大海，能将斗气固体化形成斗气晶体。\r\n能撕裂空间、空间穿梭、空间绞杀，布置空间锁、空间囚牢，建立空间虫洞、不惧空间风暴等，举手投足间便是足以扭曲空间的浩瀚之力；可无时无刻吸收天地能量化为体内斗气；只要灵魂还未散于无形就还有复生的机会。\r\n踏入此境界的强者，已是进入了斗气大陆金字塔顶层。');
INSERT INTO `dp_plevels` VALUES (10, 10, '斗尊巅峰', '九转成圣，为九次斗气凝练与压缩。\r\n处于斗尊巅峰，体内斗气饱满且无可增加时，需将斗气全部进行凝练与压缩，令体内再度出现可容纳新生斗气的空区，待斗气再度饱满时继续凝练，每一转所需要的斗气相当于一位斗尊一至九星的需要，八转以上拥有圣境特有的能量波动。');
INSERT INTO `dp_plevels` VALUES (11, 11, '半圣', '斗气九转压缩成功质变。\r\n初入圣境，虽是伪圣也可自称圣者，远胜于斗尊，能制作空间玉简。');
INSERT INTO `dp_plevels` VALUES (12, 12, '斗圣', '掌控一方天地，能毫无节制的调动天地能量进行进攻和防御。\r\n举手投足间，山崩地裂，空间破碎。可从虚无空间中开辟一方可供人居住的空间界，随手做到空间崩塌。六星斗圣的标志则是空间挪位，能够随手构建混沌空间战斗；九星斗圣能以自身斗气引发天地能量潮汐，巅峰血脉开始变异。');
INSERT INTO `dp_plevels` VALUES (13, 13, '斗帝', '吸收天地源气，斗气质变。\r\n一念之间，天地变换，山河破碎，战斗余波可直接震死一位斗圣巅峰；凌驾于天地之上，可禁止斗圣调动天地能量；拥有改变自身的血脉的能力，令自己的后人得益，能以一人之力振兴整个种族，血脉浓郁者在达到半圣前没有瓶颈；纳天地入体，形成巨大的斗帝之身（类似大千世界至尊法相），威能可破苍穹。\r\n踏入此境界的强者，已是斗气大陆上至高的存在。');

-- ----------------------------
-- Table structure for dp_recover_items
-- ----------------------------
DROP TABLE IF EXISTS `dp_recover_items`;
CREATE TABLE `dp_recover_items`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `recover_type` tinyint(4) UNSIGNED NULL DEFAULT 1 COMMENT '恢复类型 1血量 2解除异常 3持续回血',
  `hp` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '恢复hp量',
  `all_hp` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '总血量',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of dp_recover_items
-- ----------------------------
INSERT INTO `dp_recover_items` VALUES (1, 101, 1, 100, 100, NULL, NULL);
INSERT INTO `dp_recover_items` VALUES (2, 110, 3, 500, 100000, NULL, NULL);
INSERT INTO `dp_recover_items` VALUES (3, 111, 3, 1500, 500000, NULL, NULL);
INSERT INTO `dp_recover_items` VALUES (4, 109, 3, 10, 5000, NULL, NULL);

-- ----------------------------
-- Table structure for dp_roles
-- ----------------------------
DROP TABLE IF EXISTS `dp_roles`;
CREATE TABLE `dp_roles`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int(10) NULL DEFAULT NULL,
  `role_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `account` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `server_id` int(10) NULL DEFAULT NULL,
  `gold_coin` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '金币',
  `guyu` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '古玉',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_roles
-- ----------------------------
INSERT INTO `dp_roles` VALUES (1, 1, '萧炎', 'test', 1, 2090, 10000, NULL, NULL);
INSERT INTO `dp_roles` VALUES (8, 2, '雷峰鳄灵海剑', 'test01', 1, 0, 0, '2024-06-22 16:02:46', '2024-06-22 16:02:46');
INSERT INTO `dp_roles` VALUES (10, 3, '峡龙龙狗鸡电', 'test03', 1, 0, 0, '2024-06-26 10:24:03', '2024-06-26 10:24:03');

-- ----------------------------
-- Table structure for dp_roles_attribute
-- ----------------------------
DROP TABLE IF EXISTS `dp_roles_attribute`;
CREATE TABLE `dp_roles_attribute`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `r_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `r_level` int(10) UNSIGNED NULL DEFAULT NULL,
  `r_now_hp` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT '当前生命值',
  `r_hp` bigint(20) NOT NULL COMMENT '生命值',
  `r_min_gjl` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '最小攻击力',
  `r_max_gjl` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '最小攻击力',
  `r_fyl` int(10) NULL DEFAULT NULL COMMENT '防御力',
  `r_sd` int(10) NULL DEFAULT NULL COMMENT '速度',
  `r_bj` decimal(10, 2) NULL DEFAULT NULL COMMENT '暴击率',
  `r_bjxs` decimal(10, 2) NULL DEFAULT NULL COMMENT '暴击伤害系数',
  `r_mb` decimal(10, 2) UNSIGNED NULL DEFAULT NULL COMMENT '麻痹率',
  `r_xx` decimal(10, 2) UNSIGNED NULL DEFAULT NULL COMMENT '吸血率',
  `r_exp` bigint(20) UNSIGNED NULL DEFAULT 0,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of dp_roles_attribute
-- ----------------------------
INSERT INTO `dp_roles_attribute` VALUES (1, 1, 149, 31003, 32325, 2864, 5776, 4930, 351, 9.00, 7.00, 7.00, 8.00, 226450, NULL, '2024-06-27 10:37:36');
INSERT INTO `dp_roles_attribute` VALUES (4, 2, 1, 500, 500, 20, 30, 12, 1, 0.00, 0.00, 0.00, 0.00, 0, '2024-06-22 16:02:46', '2024-06-22 16:02:46');
INSERT INTO `dp_roles_attribute` VALUES (5, 3, 1, 500, 500, 20, 30, 12, 1, 0.00, 0.00, 0.00, 0.00, 0, '2024-06-26 10:22:46', '2024-06-26 10:22:46');
INSERT INTO `dp_roles_attribute` VALUES (6, 3, 1, 500, 500, 20, 30, 12, 1, 0.00, 0.00, 0.00, 0.00, 0, '2024-06-26 10:24:03', '2024-06-26 10:24:03');

-- ----------------------------
-- Table structure for dp_roles_equip
-- ----------------------------
DROP TABLE IF EXISTS `dp_roles_equip`;
CREATE TABLE `dp_roles_equip`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `item_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `e_position` tinyint(4) NULL DEFAULT NULL COMMENT '装备部位',
  `suit_id` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '套装ID',
  `e_bag_id` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '对应装备背包的id',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `r_e_unique`(`role_id`, `e_position`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of dp_roles_equip
-- ----------------------------
INSERT INTO `dp_roles_equip` VALUES (1, 1, 80001, 1, 1, 11, NULL, '2024-06-27 12:22:29');
INSERT INTO `dp_roles_equip` VALUES (2, 1, 80002, 2, 1, 12, NULL, '2024-06-27 12:22:28');
INSERT INTO `dp_roles_equip` VALUES (3, 1, 80003, 4, 1, 13, NULL, '2024-06-27 12:22:27');
INSERT INTO `dp_roles_equip` VALUES (4, 1, 80004, 5, 1, 14, NULL, '2024-06-27 12:22:26');
INSERT INTO `dp_roles_equip` VALUES (13, 1, 80005, 3, NULL, 15, NULL, '2024-06-27 12:22:25');
INSERT INTO `dp_roles_equip` VALUES (6, 1, 80006, 6, NULL, 16, NULL, '2024-06-27 12:22:23');
INSERT INTO `dp_roles_equip` VALUES (7, 3, NULL, 1, NULL, NULL, '2024-06-26 10:24:03', NULL);
INSERT INTO `dp_roles_equip` VALUES (8, 3, NULL, 2, NULL, NULL, '2024-06-26 10:24:03', NULL);
INSERT INTO `dp_roles_equip` VALUES (9, 3, NULL, 3, NULL, NULL, '2024-06-26 10:24:03', NULL);
INSERT INTO `dp_roles_equip` VALUES (10, 3, NULL, 4, NULL, NULL, '2024-06-26 10:24:03', NULL);
INSERT INTO `dp_roles_equip` VALUES (11, 3, NULL, 5, NULL, NULL, '2024-06-26 10:24:03', NULL);
INSERT INTO `dp_roles_equip` VALUES (12, 3, NULL, 6, NULL, NULL, '2024-06-26 10:24:03', NULL);

-- ----------------------------
-- Table structure for dp_roles_equip_bag
-- ----------------------------
DROP TABLE IF EXISTS `dp_roles_equip_bag`;
CREATE TABLE `dp_roles_equip_bag`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `item_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `status` tinyint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT '0隐藏 1展示',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 48 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of dp_roles_equip_bag
-- ----------------------------
INSERT INTO `dp_roles_equip_bag` VALUES (1, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (2, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (21, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (20, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (5, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (17, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (18, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (19, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (22, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (23, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (11, 1, 80001, 0, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (12, 1, 80002, 0, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (13, 1, 80003, 0, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (14, 1, 80004, 0, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (15, 1, 80005, 0, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (16, 1, 80006, 0, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (24, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (25, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (26, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (27, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (28, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (29, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (30, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (31, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (32, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (33, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (34, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (35, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (36, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (37, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (38, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (39, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (40, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (41, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (42, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (43, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (44, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (45, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (46, 1, 10001, 1, NULL, NULL);
INSERT INTO `dp_roles_equip_bag` VALUES (47, 1, 10001, 1, NULL, NULL);

-- ----------------------------
-- Table structure for dp_roles_item_bag
-- ----------------------------
DROP TABLE IF EXISTS `dp_roles_item_bag`;
CREATE TABLE `dp_roles_item_bag`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `item_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `num` int(10) UNSIGNED NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of dp_roles_item_bag
-- ----------------------------
INSERT INTO `dp_roles_item_bag` VALUES (6, 1, 10, 52, NULL, NULL);
INSERT INTO `dp_roles_item_bag` VALUES (5, 1, 101, 9, NULL, NULL);
INSERT INTO `dp_roles_item_bag` VALUES (7, 1, 110, 4, NULL, NULL);
INSERT INTO `dp_roles_item_bag` VALUES (8, 1, 111, 1, NULL, NULL);
INSERT INTO `dp_roles_item_bag` VALUES (9, 1, 109, 2, NULL, NULL);

-- ----------------------------
-- Table structure for dp_tlb
-- ----------------------------
DROP TABLE IF EXISTS `dp_tlb`;
CREATE TABLE `dp_tlb`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `item_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `hp` int(255) NULL DEFAULT NULL,
  `status` tinyint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT '0禁用 1启用',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `r_index`(`role_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of dp_tlb
-- ----------------------------
INSERT INTO `dp_tlb` VALUES (2, 1, 109, 2480, 1, NULL, NULL);

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '0000_00_00_000000_create_websockets_statistics_entries_table', 1);
INSERT INTO `migrations` VALUES (2, '2019_08_19_000000_create_failed_jobs_table', 2);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (2, 'test', '$2y$10$ryto8..VT39AegaKTfaZBe3/th9x97RDYSMI22Cd5lapJpGt0D.LS', '2024-06-22 14:21:55', '2024-06-22 14:21:55');
INSERT INTO `users` VALUES (9, 'test03', '$2y$10$csjztu4ppeYbR8ZJ8UU7wO1j0ccGNLGU9D7mAsFlqqOXh6g/92lIa', '2024-06-26 10:24:00', '2024-06-26 10:24:00');
INSERT INTO `users` VALUES (7, 'test01', '$2y$10$177Nd8XZUkw8w.5vA/bZIudAlb1Jffwcq7/p/pGQPJHjcYG.Zvocy', '2024-06-22 16:01:25', '2024-06-22 16:01:25');

SET FOREIGN_KEY_CHECKS = 1;
