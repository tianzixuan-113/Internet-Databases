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
  `stat_type` varchar(50) NOT NULL COMMENT '统计类型（如“战役年份统计/英雄籍贯统计”）',
  `stat_year` int(4) NOT NULL COMMENT '统计年份（如1937/1938）',
  `stat_count` int(11) NOT NULL COMMENT '统计数量（如该年战役数/该籍贯英雄数）',
  PRIMARY KEY (`stat_id`),
  KEY `idx_stat_type_year` (`stat_type`,`stat_year`) COMMENT '统计类型+年份联合索引'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='数据统计表（用于前端动态图形展示）' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `data_statistics`
--


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


-- --------------------------------------------------------

--
-- 表的结构 `historical_doc`
--

CREATE TABLE IF NOT EXISTS `historical_doc` (
  `doc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文献ID（自增主键）',
  `doc_name` varchar(200) NOT NULL COMMENT '文献名称',
  `doc_type` varchar(50) DEFAULT NULL COMMENT '文献类型（如“回忆录/电报/战报”）',
  `doc_summary` text DEFAULT NULL COMMENT '文献内容摘要',
  `related_campaign_id` int(11) DEFAULT NULL COMMENT '关联战役ID',
  PRIMARY KEY (`doc_id`),
  KEY `idx_related_campaign_id` (`related_campaign_id`) COMMENT '关联战役ID索引'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='史料文献表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `historical_doc`
--


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


-- --------------------------------------------------------

--
-- 表的结构 `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `perm_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '权限ID（自增主键）',
  `member_id` int(11) NOT NULL COMMENT '关联成员ID（外键）',
  `perm_level` varchar(20) NOT NULL COMMENT '权限等级（如“管理员/普通成员/只读成员”）',
  `perm_desc` varchar(100) DEFAULT NULL COMMENT '权限描述（如“可编辑所有资讯/仅可查看数据”）',
  PRIMARY KEY (`perm_id`),
  KEY `idx_member_id` (`member_id`) COMMENT '成员ID索引'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='后台用户权限表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `permission`
--


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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `war_campaign`
--

INSERT INTO `war_campaign` (`campaign_id`, `campaign_name`, `start_time`, `end_time`, `location`, `warring_parties`, `result`, `description`) VALUES
(1, '平型关大捷', '1937-09-25', '1937-09-25', '山西省大同市灵丘县', '八路军第 115 师 vs 日军板垣师团', '打破 “日军不可战胜” 的神话', '平型关大捷是全民族抗战爆发后中国军队取得的第一次重大胜利.'),
(2, '台儿庄战役', '1938-03-16', '1938-04-15', '山东省枣庄市台儿庄区', '中国军队 vs 日军矶谷师团', '中国军队取得正面战场首次大规模胜利', NULL);
