-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 06 月 02 日 21:08
-- 服务器版本: 5.5.24
-- PHP 版本: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `jdyxy_subject`
--
CREATE DATABASE `jdyxy_subject` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `jdyxy_subject`;

-- --------------------------------------------------------

--
-- 表的结构 `class_names`
--

CREATE TABLE IF NOT EXISTS `class_names` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '班级名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='班级名称' AUTO_INCREMENT=16 ;

--
-- 转存表中的数据 `class_names`
--

INSERT INTO `class_names` (`id`, `name`) VALUES
(1, '临床医八年制'),
(2, '临床八年法文班'),
(3, '口腔班'),
(4, '临床五年制一大班'),
(5, '临床五年制二大班'),
(6, '临床五年制三大班'),
(7, '临床五年制四大班'),
(8, '临床五年制五大班'),
(9, '临床五年制六大班'),
(10, '营养班'),
(11, '预防班'),
(12, '检验班'),
(13, '护理班'),
(14, '临床八年制英文班'),
(15, '临床医学（儿科方向）班');

-- --------------------------------------------------------

--
-- 表的结构 `college_names`
--

CREATE TABLE IF NOT EXISTS `college_names` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `code` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '院系代码',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '院系名称',
  `sname` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '简称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='院系代码' AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `college_names`
--

INSERT INTO `college_names` (`id`, `code`, `name`, `sname`) VALUES
(1, '700000', '学工部（处）', '学工部'),
(2, '700100', '闵行综合办', '闵行综合办'),
(3, '700200', '基础医学院', '基院'),
(4, '700301', '瑞金临床医学院', '瑞金'),
(5, '700302', '仁济临床医学院', '仁济'),
(6, '700303', '六院临床医学院', '六院'),
(7, '700304', '新华临床医学院', '新华'),
(8, '700305', '口腔|九院临床医学院', '口腔|九院'),
(9, '700306', '一院临床医学院', '市一'),
(10, '700307', '三院临床医学院', '三院'),
(11, '700308', '胸科医院', '胸科'),
(12, '700309', '儿童医院', '儿童'),
(13, '700310', '儿童医学中心', '儿中心'),
(14, '700311', '精神卫生中心', '精中'),
(15, '700312', '护理学院', '护理'),
(16, '700313', '公共卫生学院', '公卫'),
(17, '700314', '国际和平妇幼保健院', '国妇婴'),
(18, '700315', '药学系', '药学');

-- --------------------------------------------------------

--
-- 表的结构 `expert_users`
--

CREATE TABLE IF NOT EXISTS `expert_users` (
  `userid` int(11) NOT NULL COMMENT '易班用户id',
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '易班用户名',
  `realname` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '真实姓名',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='专家用户';

-- --------------------------------------------------------

--
-- 表的结构 `project_sets`
--

CREATE TABLE IF NOT EXISTS `project_sets` (
  `pid` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `pname` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '项目集名称',
  `pyear` varchar(5) COLLATE utf8_unicode_ci NOT NULL COMMENT '隶属年度',
  `ptype` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '项目分类',
  `pprofile` text COLLATE utf8_unicode_ci NOT NULL COMMENT '项目集描述',
  `psummary` text COLLATE utf8_unicode_ci COMMENT '项目集总结',
  `ptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `puid` int(11) NOT NULL COMMENT '易班用户id',
  `pusername` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '易班用户名',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='项目集' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `project_sets`
--

INSERT INTO `project_sets` (`pid`, `pname`, `pyear`, `ptype`, `pprofile`, `psummary`, `ptime`, `puid`, `pusername`) VALUES
(1, '测试项目集一', '2012', '项目类型一', '项目集一描述', NULL, '2012-06-02 13:05:19', 33, 'Sai翔'),
(2, '测试项目集二', '2012', '项目类型二', '项目集一描述', NULL, '2012-06-02 13:05:19', 33, 'Sai翔');

-- --------------------------------------------------------

--
-- 表的结构 `project_time_points`
--

CREATE TABLE IF NOT EXISTS `project_time_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `pid` int(11) NOT NULL COMMENT '对应项目集id',
  `point_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '节点内容',
  `point_time` date NOT NULL COMMENT '节点时间',
  `link_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '对应链接名称',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='项目集各节点时间' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `pid` int(11) NOT NULL COMMENT '所属项目集id',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '项目名称',
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '项目类型',
  `source` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '项目来源',
  `level` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '项目级别',
  `over_expect` date DEFAULT NULL COMMENT '结题预期',
  `report_way` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '申报方式',
  `college` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '项目所属院系',
  `realname` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '负责人姓名',
  `teacher_name` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '指导教师姓名',
  `fund_budget` int(11) DEFAULT NULL COMMENT '经费预算',
  `submit_flag` int(11) DEFAULT NULL COMMENT '提交标志',
  `add_fund` int(11) DEFAULT NULL COMMENT '附加项目经费',
  `reward_fund` int(11) DEFAULT NULL COMMENT '项目奖励经费',
  `reward_reason` text COLLATE utf8_unicode_ci COMMENT '项目奖励原因',
  `last_fund` int(11) DEFAULT NULL COMMENT '上期已拨发核定经费',
  `last_add_fund` int(11) DEFAULT NULL COMMENT '上期已拨发附加经费',
  `comment_college` text COLLATE utf8_unicode_ci COMMENT '（院系）立项评议',
  `comment_school` text COLLATE utf8_unicode_ci COMMENT '（学校）立项审核',
  `comment_school_fund` int(11) DEFAULT NULL COMMENT '（学校）立项审核核定项目经费',
  `comment_school_score` int(11) DEFAULT NULL COMMENT '（学校）立项审核评分',
  `follow_check` int(11) DEFAULT NULL COMMENT '跟踪检查（中期检查）',
  `submit_report_flag` int(11) DEFAULT NULL COMMENT '提交结题报告提交标志',
  `over_comment_college` text COLLATE utf8_unicode_ci COMMENT '（院系）结题评议',
  `over_comment_school` text COLLATE utf8_unicode_ci COMMENT '（学校）结题审核',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `userid` int(11) NOT NULL COMMENT '易班用户id',
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '易班用户名',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='项目列表' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
