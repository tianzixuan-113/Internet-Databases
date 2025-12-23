-- phpMyAdmin SQL Dump
-- version 3.3.7
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2025 年 12 月 20 日 23:11
-- 服务器版本: 1.0.432
-- PHP 版本: 5.2.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

USE war_resistance_db;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `war_resistance_db`
--

-- --------------------------------------------------------

--
-- 表的结构 `data_statistics`
--

CREATE TABLE IF NOT EXISTS `data_statistics` (
  `stat_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '统计ID（自增主键）',
  `stat_type` varchar(50) NOT NULL COMMENT '统计类型（如"战役年份统计/英雄籍贯统计"）',
  `stat_year` int(4) NOT NULL COMMENT '统计年份（如1937/1938）',
  `stat_count` int(11) NOT NULL COMMENT '统计数量（如该年战役数/该籍贯英雄数）',
  PRIMARY KEY (`stat_id`),
  KEY `idx_stat_type_year` (`stat_type`,`stat_year`) COMMENT '统计类型+年份联合索引'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='数据统计表（用于前端动态图形展示）' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `data_statistics`
--

INSERT INTO `data_statistics` (`stat_id`, `stat_type`, `stat_year`, `stat_count`) VALUES
(1, '战役年份统计', 1937, 5),
(2, '战役年份统计', 1938, 3),
(3, '战役年份统计', 1939, 2),
(4, '战役年份统计', 1940, 1),
(5, '英雄籍贯统计', 1937, 12),
(6, '英雄籍贯统计', 1938, 8),
(7, '英雄籍贯统计', 1939, 6),
(8, '英雄籍贯统计', 1940, 4);

-- --------------------------------------------------------

--
-- 表的结构 `hero_info`
--

CREATE TABLE IF NOT EXISTS `hero_info` (
  `hero_id` int(11) NOT NULL COMMENT '英雄唯一 ID',
  `hero_name` varchar(100) NOT NULL COMMENT '英雄姓名',
  `native_place` varchar(100) DEFAULT NULL COMMENT '籍贯',
  `deed` text DEFAULT NULL COMMENT '英雄事迹',
  `army` varchar(100) DEFAULT NULL COMMENT '所属部队',
  `campaign_id` int(11) NOT NULL COMMENT '关联战役 ID',
  UNIQUE KEY `hero_id` (`hero_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `hero_info`
--

INSERT INTO `hero_info` (`hero_id`, `hero_name`, `native_place`, `deed`, `army`, `campaign_id`) VALUES
(1, '杨靖宇', '河南省确山县', '东北抗日联军主要创建者和领导人之一，长期在东北坚持抗日斗争，直至壮烈牺牲', '东北抗日联军', 1),
(2, '赵一曼', '四川省宜宾县', '在东北抗日战争中被俘，面对日军酷刑宁死不屈，英勇就义', '东北抗日联军', 1),
(3, '张自忠', '山东省临清县', '在枣宜会战中率部与日军激战，壮烈殉国，是抗日战争中牺牲的最高级别将领之一', '国民革命军第33集团军', 3),
(4, '左权', '湖南省醴陵县', '八路军高级将领，在反"扫荡"作战中指挥部队突围时牺牲', '八路军', 4),
(5, '戴安澜', '安徽省无为县', '中国远征军第200师师长，在缅甸作战中英勇牺牲', '中国远征军', 5),
(6, '佟麟阁', '河北省高阳县', '七七事变爆发后率部抵抗日军进攻，壮烈殉国', '国民革命军第29军', 6),
(7, '赵登禹', '山东省菏泽县', '七七事变中率部与日军作战，英勇牺牲', '国民革命军第29军', 6),
(8, '吉鸿昌', '河南省扶沟县', '察哈尔抗日同盟军主要领导人之一，积极组织抗日活动', '察哈尔抗日同盟军', 7);

-- --------------------------------------------------------

--
-- 表的结构 `historical_doc`
--

CREATE TABLE IF NOT EXISTS `historical_doc` (
  `doc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文献ID（自增主键）',
  `doc_name` varchar(200) NOT NULL COMMENT '文献名称',
  `doc_type` varchar(50) DEFAULT NULL COMMENT '文献类型（如"回忆录/电报/战报"）',
  `doc_summary` text DEFAULT NULL COMMENT '文献内容摘要',
  `related_campaign_id` int(11) DEFAULT NULL COMMENT '关联战役ID',
  PRIMARY KEY (`doc_id`),
  KEY `idx_related_campaign_id` (`related_campaign_id`) COMMENT '关联战役ID索引'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='史料文献表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `historical_doc`
--

INSERT INTO `historical_doc` (`doc_id`, `doc_name`, `doc_type`, `doc_summary`, `related_campaign_id`) VALUES
(1, '平型关大捷战报', '战报', '八路军第115师在平型关取得首战大捷的详细战报，记录了战斗经过和战果', 1),
(2, '台儿庄战役总结报告', '总结报告', '第五战区司令长官李宗仁关于台儿庄战役的总结报告，详述了战役部署和胜利意义', 2),
(3, '论持久战', '战略理论', '毛泽东关于抗日战争的战略理论著作，科学分析了抗日战争的规律和进程', NULL),
(4, '八路军抗战八年总结', '总结报告', '八路军总部对抗战八年的全面总结，包括战绩和经验', NULL),
(5, '新四军抗战历程', '历史文献', '新四军在华中地区抗战的详细记录', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `image_resource`
--

CREATE TABLE IF NOT EXISTS `image_resource` (
  `img_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图片唯一 ID',
  `img_url` varchar(500) NOT NULL COMMENT '图片网络 URL',
  `img_desc` varchar(200) DEFAULT NULL COMMENT '图片描述',
  `related_id` int(11) NOT NULL COMMENT '关联 ID',
  PRIMARY KEY (`img_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `image_resource`
--

INSERT INTO `image_resource` (`img_id`, `img_url`, `img_desc`, `related_id`) VALUES
(1, 'https://example.com/images/pingxingguan.jpg', '平型关大捷战场遗址', 1),
(2, 'https://example.com/images/taierzhuang.jpg', '台儿庄战役战场复原图', 2),
(3, 'https://example.com/images/yangjingyu.jpg', '抗日英雄杨靖宇肖像', 1),
(4, 'https://example.com/images/zhaoyiman.jpg', '抗日英雄赵一曼肖像', 2),
(5, 'https://example.com/images/zhangzizhong.jpg', '抗日将领张自忠肖像', 3),
(6, 'https://example.com/images/zuoguang.jpg', '抗日将领左权肖像', 4),
(7, 'https://example.com/images/daianlan.jpg', '抗日将领戴安澜肖像', 5),
(8, 'https://example.com/images/junxunjuntuan.jpg', '八路军军徽与臂章', 1),
(9, 'https://example.com/images/wuqijuhui.jpg', '抗日游击队缴获的日军武器', 3),
(10, 'https://example.com/images/yumin.jpg', '民众支援抗战的场景', 2);

-- --------------------------------------------------------

--
-- 表的结构 `member_info`
--

CREATE TABLE IF NOT EXISTS `member_info` (
  `member_id` int(11) NOT NULL COMMENT '成员id',
  `member_name` varchar(20) NOT NULL COMMENT '成员姓名',
  `student_id` varchar(20) NOT NULL COMMENT '学号',
  `duty` varchar(50) NOT NULL COMMENT '分工',
  `introduction` text DEFAULT NULL COMMENT '个人介绍',
  `team_id` int(11) NOT NULL COMMENT '关联团队ID',
  UNIQUE KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `member_info`
--

INSERT INTO `member_info` (`member_id`, `member_name`, `student_id`, `duty`, `introduction`, `team_id`) VALUES
(1, '田子煊', '2311583', '前端', NULL, 258001),
(2, '郭思达', '2310688', '后端', NULL, 258003),
(3, '张度', '2312873', '建立数据库', NULL, 258002);

-- --------------------------------------------------------

--
-- 表的结构 `message_board`
--

CREATE TABLE IF NOT EXISTS `message_board` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '留言唯一 ID',
  `nickname` varchar(50) NOT NULL COMMENT '留言昵称',
  `content` text NOT NULL COMMENT '留言内容',
  `msg_time` datetime DEFAULT NULL COMMENT '留言时间',
  PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `message_board`
--

INSERT INTO `message_board` (`msg_id`, `nickname`, `content`, `msg_time`) VALUES
(1, '铭记历史', '致敬抗日英雄，珍惜和平生活', '2025-12-20 10:30:00'),
(2, '爱国青年', '感谢你们做的抗战主题网站，让我了解了很多历史', '2025-12-20 11:45:23'),
(3, '历史爱好者', '这些珍贵的史料值得我们永远铭记', '2025-12-20 14:20:11'),
(4, '和平守护者', '勿忘国耻，振兴中华', '2025-12-20 16:15:37'),
(5, '学生', '通过这个网站学到了很多课堂之外的知识', '2025-12-21 09:05:42'),
(6, '老一辈', '我们这代人对这段历史有深刻记忆，希望年轻人永远记住', '2025-12-21 12:30:18'),
(7, '教师', '很好的教育平台，会推荐给我的学生们', '2025-12-21 15:40:55'),
(8, '研究者', '史料详实，感谢你们的整理工作', '2025-12-22 08:22:10');

-- --------------------------------------------------------

--
-- 表的结构 `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `perm_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '权限ID（自增主键）',
  `member_id` int(11) NOT NULL COMMENT '关联成员ID（外键）',
  `perm_level` varchar(20) NOT NULL COMMENT '权限等级（如"管理员/普通成员/只读成员"）',
  `perm_desc` varchar(100) DEFAULT NULL COMMENT '权限描述（如"可编辑所有资讯/仅可查看数据"）',
  PRIMARY KEY (`perm_id`),
  KEY `idx_member_id` (`member_id`) COMMENT '成员ID索引'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='后台用户权限表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `permission`
--

INSERT INTO `permission` (`perm_id`, `member_id`, `perm_level`, `perm_desc`) VALUES
(1, 1, '编辑', '可编辑前端相关资讯'),
(2, 2, '管理员', '可管理所有内容'),
(3, 3, '编辑', '可编辑数据库相关资料');

-- --------------------------------------------------------

--
-- 表的结构 `publish_info`
--

CREATE TABLE IF NOT EXISTS `publish_info` (
  `publish_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '资讯ID（自增主键）',
  `title` varchar(200) NOT NULL COMMENT '资讯标题',
  `content` text NOT NULL COMMENT '资讯内容',
  `publish_time` datetime DEFAULT current_timestamp() COMMENT '发布时间（自动填充当前时间）',
  `publisher_id` int(11) NOT NULL COMMENT '发布者ID（关联成员ID）',
  PRIMARY KEY (`publish_id`),
  KEY `idx_publisher_id` (`publisher_id`) COMMENT '发布者ID索引'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='抗战主题资讯发布表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `publish_info`
--

INSERT INTO `publish_info` (`publish_id`, `title`, `content`, `publish_time`, `publisher_id`) VALUES
(1, '纪念抗战胜利80周年', '今年是抗日战争胜利80周年，我们要铭记历史，缅怀先烈，珍爱和平，开创未来。', '2025-10-25 10:00:00', 2),
(2, '新增珍贵史料', '我们最近收集了一批关于抗日战争的珍贵史料，包括战地日记、电报、照片等，丰富了网站内容。', '2025-11-05 14:30:00', 3),
(3, '英雄人物事迹更新', '更新了多位抗日英雄的生平事迹，增加了他们鲜为人知的感人故事。', '2025-11-15 09:15:00', 1),
(4, '文物展示区上线', '新增了文物展示区，展示了抗战时期的武器、生活用品、文献等珍贵文物。', '2025-11-22 16:45:00', 2),
(5, '互动留言功能开放', '现在您可以在这个平台上留下对英雄的敬意和对和平的祝愿。', '2025-12-01 11:20:00', 1);

-- --------------------------------------------------------

--
-- 表的结构 `relic_info`
--

CREATE TABLE IF NOT EXISTS `relic_info` (
  `relic_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文物唯一ID',
  `relic_name` varchar(100) NOT NULL COMMENT '文物名称',
  `relic_type` varchar(50) DEFAULT NULL COMMENT '文物类型',
  `age` varchar(50) DEFAULT NULL COMMENT '文物年代',
  `collection_place` varchar(200) DEFAULT NULL COMMENT '馆藏地',
  `description` text DEFAULT NULL COMMENT '文物描述',
  PRIMARY KEY (`relic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `relic_info`
--

INSERT INTO `relic_info` (`relic_id`, `relic_name`, `relic_type`, `age`, `collection_place`, `description`) VALUES
(1, '八路军军装', '服装', '1937-1945', '中国人民革命军事博物馆', '八路军战士穿过的军装，见证了艰苦卓绝的抗战岁月'),
(2, '抗日游击队使用的大刀', '武器', '1937-1945', '中国人民抗日战争纪念馆', '抗日游击队使用的大刀，刀刃锋利，是"大刀向鬼子头上砍去"的象征'),
(3, '缴获的日军指挥刀', '武器', '1937-1945', '中国人民革命军事博物馆', '在某次战斗中缴获的日军指挥刀，见证了中国军队的英勇作战'),
(4, '抗战时期的收音机', '通信设备', '1937-1945', '中国人民抗日战争纪念馆', '抗战时期用于收听战况和宣传的收音机'),
(5, '抗日根据地发行的货币', '货币', '1937-1945', '中国国家博物馆', '抗日根据地为稳定经济发行的货币，具有重要的历史价值'),
(6, '战地日记', '文献', '1937-1945', '中国人民抗日战争纪念馆', '某位抗日战士的战地日记，记录了战斗生活和思想感受'),
(7, '抗战时期的传单', '文献', '1937-1945', '中国国家博物馆', '宣传抗日、动员民众的传单，反映了当时的政治宣传'),
(8, '民兵使用的老式步枪', '武器', '1937-1945', '中国人民革命军事博物馆', '抗日民兵使用的老式步枪，体现了全民抗战的特点');

-- --------------------------------------------------------

--
-- 表的结构 `team_info`
--

CREATE TABLE IF NOT EXISTS `team_info` (
  `team_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '团队ID',
  `team_name` varchar(50) NOT NULL COMMENT '团队名称',
  `project_topic` varchar(100) NOT NULL COMMENT '项目主题',
  `division_work` text DEFAULT NULL COMMENT '团队分工描述',
  `create_time` datetime DEFAULT NULL COMMENT '项目创建时间',
  PRIMARY KEY (`team_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=802024 ;

--
-- 转存表中的数据 `team_info`
--

INSERT INTO `team_info` (`team_id`, `team_name`, `project_topic`, `division_work`, `create_time`) VALUES
(202580, '抗战纪念先锋队', '抗战胜利 80 周年', '田子煊 前端/郭思达 后端/张度 数据库', '2025-10-21 06:19:23');

-- --------------------------------------------------------

--
-- 表的结构 `war_campaign`
--

CREATE TABLE IF NOT EXISTS `war_campaign` (
  `campaign_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '战役ID',
  `campaign_name` varchar(100) NOT NULL COMMENT '战役名称',
  `start_time` date DEFAULT NULL COMMENT '战役开始时间',
  `end_time` date DEFAULT NULL COMMENT '战役结束时间',
  `location` varchar(100) DEFAULT NULL COMMENT '战役地点',
  `warring_parties` varchar(200) DEFAULT NULL COMMENT '参战方',
  `result` varchar(200) DEFAULT NULL COMMENT '战役结果',
  `description` text DEFAULT NULL COMMENT '战役详情描述',
  PRIMARY KEY (`campaign_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `war_campaign`
--

INSERT INTO `war_campaign` (`campaign_id`, `campaign_name`, `start_time`, `end_time`, `location`, `warring_parties`, `result`, `description`) VALUES
(1, '平型关大捷', '1937-09-25', '1937-09-25', '山西省大同市灵丘县', '八路军第 115 师 vs 日军板垣师团', '打破 "日军不可战胜" 的神话', '平型关大捷是全民族抗战爆发后中国军队取得的第一次重大胜利.'),
(2, '台儿庄战役', '1938-03-16', '1938-04-15', '山东省枣庄市台儿庄区', '中国军队 vs 日军矶谷师团', '中国军队取得正面战场首次大规模胜利', '台儿庄战役是抗日战争时期中国军队在正面战场取得的重大胜利。'),
(3, '武汉会战', '1938-06-11', '1938-10-27', '湖北省武汉市', '中国第五、第九战区部队 vs 日本第二、第十一军', '中国军队战略撤退，但消耗了日军大量有生力量', '武汉会战是抗日战争期间规模最大的一次会战，标志着抗日战争进入战略相持阶段。'),
(4, '长沙会战', '1939-09-14', '1942-01-06', '湖南省长沙市', '中国第九战区部队 vs 日本第十一军', '中国军队取得三次会战胜利，沉重打击了日军', '长沙会战是中国军队在抗日战争相持阶段取得的较大胜利之一。'),
(5, '百团大战', '1940-08-20', '1941-01-24', '华北地区', '八路军 vs 日军华北方面军', '八路军取得大规模破袭战胜利', '百团大战是全民族抗战以来八路军在华北发动的规模最大、持续时间最长的一次带战略性进攻的战役。'),
(6, '淞沪会战', '1937-08-13', '1937-11-26', '上海市', '中国第三战区部队 vs 日本上海派遣军', '中国军队撤退，但粉碎了日军三个月灭亡中国的计划', '淞沪会战是中日双方在抗日战争中的第一场大型会战，也是整个中日战争中进行的规模最大、战斗最惨烈的一场战役。'),
(7, '徐州会战', '1938-01-26', '1938-05-19', '江苏省徐州市', '中国第五战区部队 vs 日本华北方面军', '中国军队在台儿庄取得胜利，但最终失守徐州', '徐州会战是中日双方在华东地区进行的一次大规模战役，其中台儿庄战役是会战的重要组成部分。');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 10,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='用户表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin_auth_key', '$2y$13$uQFJmN2.HFf6o1z8L4sZNeH5aMm5Qp0K7zY1yZ8L4sZNeH5aMm5Qp', 'admin@example.com', 10, 1609334400, 1609334400),
(2, 'guosida', 'guosida_auth_key', '$2y$13$uQFJmN2.HFf6o1z8L4sZNeH5aMm5Qp0K7zY1yZ8L4sZNeH5aMm5Qp', 'guosida@example.com', 10, 1609334400, 1609334400),
(3, 'zhangdu', 'zhangdu_auth_key', '$2y$13$uQFJmN2.HFf6o1z8L4sZNeH5aMm5Qp0K7zY1yZ8L4sZNeH5aMm5Qp', 'zhangdu@example.com', 10, 1609334400, 1609334400);