-- phpMyAdmin SQL Dump
-- version 3.3.7
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2011 年 12 月 12 日 10:02
-- 服务器版本: 5.0.22
-- PHP 版本: 5.2.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `test`
--

-- --------------------------------------------------------

--
-- 表的结构 `ebay_goodssort`
--

CREATE TABLE IF NOT EXISTS `ebay_goodssort` (
  `id` int(11) NOT NULL auto_increment,
  `goods_sn` varchar(255) default NULL,
  `qty` int(11) NOT NULL,
  `totalprice` float NOT NULL,
  `totalprofit` float default NULL,
  `ebay_user` varchar(255) default NULL,
  `goods_name` varchar(255) default NULL,
  `goods_cost` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=501 ;
