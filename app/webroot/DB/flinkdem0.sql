-- phpMyAdmin SQL Dump
-- version 3.5.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 29, 2014 at 01:45 PM
-- Server version: 5.5.34-0ubuntu0.13.10.1
-- PHP Version: 5.5.3-1ubuntu2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `flinkiso`
--

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `appraisals`
--

CREATE TABLE IF NOT EXISTS `appraisals` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(36) DEFAULT NULL,
  `appraisal_date` date DEFAULT NULL,
  `appraiser_by` varchar(36) DEFAULT NULL,
  `reason` text,
  `self_appraisal_needed` tinyint(1) DEFAULT '0' COMMENT '0 = self appraisal not required, 1= self appraisal required',
  `self_appraisal_status` tinyint(1) DEFAULT '0' COMMENT '0=self appraisal pending, 1=self appraisal done',
  `rating` varchar(150) DEFAULT NULL,
  `employee_comments` text,
  `appraiser_comments` text,
  `promotion` tinyint(1) DEFAULT NULL,
  `warning` tinyint(1) DEFAULT NULL,
  `status_remained_unchanged` tinyint(1) DEFAULT NULL,
  `successful_probation_completion` tinyint(1) DEFAULT NULL,
  `salary_increment` tinyint(1) DEFAULT NULL,
  `termination` tinyint(1) DEFAULT NULL,
  `training_requirements` tinyint(1) DEFAULT NULL,
  `specific_requirement` text,
  `increament` text,
  `appraisal_token` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `appraisal_token_expires` datetime DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `appraisal_questions`
--

CREATE TABLE IF NOT EXISTS `appraisal_questions` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(256) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `appraisal_questions`
--

INSERT INTO `appraisal_questions` (`id`, `sr_no`, `question`, `publish`, `record_status`, `status_user_id`, `soft_delete`, `branchid`, `departmentid`, `created_by`, `created`, `modified_by`, `approved_by`, `prepared_by`, `modified`, `system_table_id`, `master_list_of_format_id`, `company_id`) VALUES
('531d79db-d5d4-4b14-969f-622fb6329416', 1, 'How well do you think you have performed in your duties over the past year?', 1, 0, NULL, 0, '530b43ec-428c-4a3d-997d-1a0bb6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530b43ec-0628-4772-8ce9-1a0bb6329416', NOW(), '530b43ec-0628-4772-8ce9-1a0bb6329416', NULL, NULL, NOW(), NULL, '', ''),
('531d79f0-b460-4c04-a6bf-68d1b6329416', 2, 'Please mention both the areas you have done well in and the areas that have not gone as well.', 1, 0, NULL, 0, '530b43ec-428c-4a3d-997d-1a0bb6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530b43ec-0628-4772-8ce9-1a0bb6329416', NOW(), '530b43ec-0628-4772-8ce9-1a0bb6329416', NULL, NULL, NOW(), NULL, '', ''),
('531d9947-12e4-4615-ab28-3749b6329416', 3, 'What form of support or encouragement would you like to have in your day-to-day work? ', 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '523a0abb-21e0-4b44-a219-6142c6c32687', '530d86cc-96d4-49f3-a126-1d42b6329416', NOW(), '530d86cc-96d4-49f3-a126-1d42b6329416', NULL, NULL, NOW(), NULL, '', ''),
('531d9954-e114-4a07-a6ca-3749b6329416', 4, 'What are your most important duties? ?', 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '523a0abb-21e0-4b44-a219-6142c6c32687', '530d86cc-96d4-49f3-a126-1d42b6329416', NOW(), '530d86cc-96d4-49f3-a126-1d42b6329416', NULL, NULL, NOW(), NULL, '', ''),
('531d995b-fed4-4b27-87cb-39e5b6329416', 5, 'What is your perception of your work situation?', 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '523a0abb-21e0-4b44-a219-6142c6c32687', '530d86cc-96d4-49f3-a126-1d42b6329416', NOW(), '530d86cc-96d4-49f3-a126-1d42b6329416', NULL, NULL, NOW(), NULL, '', ''),
('531d9962-587c-4ab5-b08f-3749b6329416', 6, 'How can you contribute to the development of cooperation?', 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '523a0abb-21e0-4b44-a219-6142c6c32687', '530d86cc-96d4-49f3-a126-1d42b6329416', NOW(), '530d86cc-96d4-49f3-a126-1d42b6329416', NULL, NULL, NOW(), NULL, '', ''),
('531d9968-8178-444d-bd87-39e5b6329416', 7, 'Are there any management issues you would like to raise?', 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '523a0abb-21e0-4b44-a219-6142c6c32687', '530d86cc-96d4-49f3-a126-1d42b6329416', NOW(), '530d86cc-96d4-49f3-a126-1d42b6329416', NULL, NULL, NOW(), NULL, '', ''),
('531d9973-e538-462f-bba5-39e5b6329416', 8, 'Do you feel that your skills are utilised in your current work? ', 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '523a0abb-21e0-4b44-a219-6142c6c32687', '530d86cc-96d4-49f3-a126-1d42b6329416', NOW(), '530d86cc-96d4-49f3-a126-1d42b6329416', NULL, NULL, NOW(), NULL, '', ''),
('531d9980-2948-4958-8fd4-39e5b6329416', 9, 'Has the past year been good/bad/satisfactory or otherwise for you, and why?', 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '523a0abb-21e0-4b44-a219-6142c6c32687', '530d86cc-96d4-49f3-a126-1d42b6329416', NOW(), '530d86cc-96d4-49f3-a126-1d42b6329416', NULL, NULL, NOW(), NULL, '', ''),
('531d9987-26f8-440f-a472-39e4b6329416', 10, 'What do you consider to be your most important achievements of the past year? ', 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '523a0abb-21e0-4b44-a219-6142c6c32687', '530d86cc-96d4-49f3-a126-1d42b6329416', NOW(), '530d86cc-96d4-49f3-a126-1d42b6329416', NULL, NULL, NOW(), NULL, '', ''),
('531d99e7-61a0-48ec-91ce-39e4b6329416', 11, 'What do you like and dislike about working for this organisation?', 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '523a0abb-21e0-4b44-a219-6142c6c32687', '530d86cc-96d4-49f3-a126-1d42b6329416', NOW(), '530d86cc-96d4-49f3-a126-1d42b6329416', NULL, NULL, NOW(), NULL, '0', ''),
('531d99e7-59e4-4342-b511-39e4b6329416', 12, 'What elements of your job do you find most difficult?', 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '523a0abb-21e0-4b44-a219-6142c6c32687', '530d86cc-96d4-49f3-a126-1d42b6329416', NOW(), '530d86cc-96d4-49f3-a126-1d42b6329416', NULL, NULL, NOW(), NULL, '0', ''),
('531d99e7-59e4-4343-b511-39e4b6329416', 13, 'What do you consider to be your most important aims and tasks in the next year? ', 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '523a0abb-21e0-4b44-a219-6142c6c32687', '530d86cc-96d4-49f3-a126-1d42b6329416', NOW(), '530d86cc-96d4-49f3-a126-1d42b6329416', NULL, NULL, NOW(), NULL, '0', ''),
('531d99e7-59e4-4344-b511-39e4b6329416', 14, 'What action could be taken to improve your performance in your current position?', 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '523a0abb-21e0-4b44-a219-6142c6c32687', '530d86cc-96d4-49f3-a126-1d42b6329416', NOW(), '530d86cc-96d4-49f3-a126-1d42b6329416', NULL, NULL, NOW(), NULL, '0', ''),
('531d99e7-59e4-4345-b511-39e4b6329416', 15, 'What sort of training/experiences would benefit you in the next year?', 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '523a0abb-21e0-4b44-a219-6142c6c32687', '530d86cc-96d4-49f3-a126-1d42b6329416', NOW(), '530d86cc-96d4-49f3-a126-1d42b6329416', NULL, NULL, NOW(), NULL, '0', '');

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `approvals`
--

CREATE TABLE IF NOT EXISTS `approvals` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `model_name` varchar(250) NOT NULL,
  `controller_name` varchar(250) NOT NULL,
  `record` varchar(36) NOT NULL,
  `from` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `comments` text,
  `auto_approval_id` varchar(36) DEFAULT NULL,
  `auto_approval_step_id` varchar(36) DEFAULT NULL,
  `approval_step` int(2) DEFAULT NULL,
  `status` varchar(120) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '1' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `created_by` varchar(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified_by` varchar(36) NOT NULL,
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL,
  `soft_delete` tinyint(1) NOT NULL DEFAULT '0',
  `branchid` varchar(36) DEFAULT NULL,
  `departmentid` varchar(36) DEFAULT NULL,
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `auto_approvals` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `details` text,
  `system_table` varchar(36) NOT NULL,
  `branch_id` varchar(36) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `auto_approval_steps`
--

CREATE TABLE IF NOT EXISTS `auto_approval_steps` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `auto_approval_id` varchar(36) NOT NULL,
  `name` varchar(120) NOT NULL,
  `step_number` int(2) NOT NULL,
  `allow_approval` tinyint(1) DEFAULT '0',
  `show_details` tinyint(1) DEFAULT '0',
  `user_id` varchar(36) NOT NULL,
  `branch_id` varchar(36) DEFAULT NULL,
  `details` text,
  `system_table` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- @#@ -- Table structure for table `benchmarks`
--

CREATE TABLE IF NOT EXISTS `benchmarks` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` varchar(36) NOT NULL,
  `department_id` varchar(36) NOT NULL,
  `benchmark` int(10) NOT NULL DEFAULT '0',
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `branches`
--

CREATE TABLE IF NOT EXISTS `branches` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `branch_benchmarks`
--

CREATE TABLE IF NOT EXISTS `branch_benchmarks` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` varchar(36) NOT NULL,
  `benchmark` int(10) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `calibrations`
--

CREATE TABLE IF NOT EXISTS `calibrations` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` varchar(36) NOT NULL,
  `calibration_date` date NOT NULL,
  `measurement_for` text,
  `least_count` varchar(20) DEFAULT '0',
  `required_accuracy` varchar(20) DEFAULT '0',
  `range` varchar(20) DEFAULT '0',
  `default_calibration` varchar(20) DEFAULT '0',
  `required_calibration` varchar(20) DEFAULT '0',
  `actual_calibration` varchar(20) DEFAULT '0',
  `errors` text,
  `comments` text,
  `next_calibration_date` date NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `capa_categories`
--

CREATE TABLE IF NOT EXISTS `capa_categories` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `capa_categories`
--

INSERT INTO `capa_categories` (`id`, `sr_no`, `name`, `publish`, `record_status`, `status_user_id`, `soft_delete`, `branchid`, `departmentid`, `created_by`, `created`, `modified_by`, `approved_by`, `prepared_by`, `modified`, `system_table_id`, `master_list_of_format_id`) VALUES
('5245a8fc-8f4c-4ab5-ab27-41f2c6c3268c', 1, 'Non Conformity from Audit', 1, 0, NULL, 0, '522e4490-ff60-4990-8ca2-8a04c6c3268c', '522ee01c-4c78-437c-bffb-0311c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), NULL, '0'),
('5245a90d-1f4c-4693-9853-41ebc6c3268c', 2, 'Suggestion for improvement', 1, 0, NULL, 0, '522e4490-ff60-4990-8ca2-8a04c6c3268c', '522ee01c-4c78-437c-bffb-0311c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec',NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL,NOW(), NULL, '0'),
('5245a935-7f58-482c-83c5-41f1c6c3268c', 3, 'Complaints', 1, 0, NULL, 0, '522e4490-ff60-4990-8ca2-8a04c6c3268c', '522ee01c-4c78-437c-bffb-0311c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), NULL, '0'),
('5245a94b-8730-4998-8106-41d6c6c3268c', 4, 'Notices External Parties', 1, 0, NULL, 0, '522e4490-ff60-4990-8ca2-8a04c6c3268c', '522ee01c-4c78-437c-bffb-0311c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), NULL, '0'),
('5245a95b-1340-4531-8d4a-4151c6c3268c', 5, 'Suppliers', 1, 0, NULL, 0, '522e4490-ff60-4990-8ca2-8a04c6c3268c', '522ee01c-4c78-437c-bffb-0311c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), NULL, '0'),
('528fcdd7-63ec-497e-b4f3-01e5c6c3268c', 7, 'Product', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '', NOW(), '', NULL, NULL, NOW(), NULL, '0'),
('53200cde-bb2c-4236-be8c-f90d51f38a45', 8, 'Material', 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530b42fa-b30c-461c-a81c-1a0bb6329416', NOW(), '530b42fa-b30c-461c-a81c-1a0bb6329416', NULL, NULL, NOW(), '5297b2e6-bf20-45c7-81eb-2d8f0a000005', ''),
('533e94b8-7b70-4fad-bcdd-1a3a51f38a45', 9, 'Device', 1, 0, NULL, 0, '530c2ddf-4668-4a02-96ba-383db6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '530c2de0-b334-4661-a55c-383db6329416', NOW(), '530c2de0-b334-4661-a55c-383db6329416', NULL, NULL, NOW(), '5297b2e6-bf20-45c7-81eb-2d8f0a000005', '');

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `capa_sources`
--

CREATE TABLE IF NOT EXISTS `capa_sources` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `capa_sources`
--

INSERT INTO `capa_sources` (`id`, `sr_no`, `name`, `publish`, `record_status`, `status_user_id`, `soft_delete`, `branchid`, `departmentid`, `created_by`, `created`, `modified_by`, `approved_by`, `prepared_by`, `modified`, `system_table_id`, `master_list_of_format_id`) VALUES
('5245a9b0-2f18-4072-92fe-41dbc6c3268c', 1, 'System failure', 1, 0, NULL, 0, '522e4490-ff60-4990-8ca2-8a04c6c3268c', '522ee01c-4c78-437c-bffb-0311c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), NULL, '0'),
('5245a9c4-e5a4-4c16-9dd9-4063c6c3268c', 2, 'Document control', 1, 0, NULL, 0, '522e4490-ff60-4990-8ca2-8a04c6c3268c', '522ee01c-4c78-437c-bffb-0311c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), NULL, '0'),
('5245a9da-db70-49ab-a8c9-41f2c6c3268c', 3, 'Wrong instructions', 1, 0, NULL, 0, '522e4490-ff60-4990-8ca2-8a04c6c3268c', '522ee01c-4c78-437c-bffb-0311c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530c2de0-b334-4661-a55c-383db6329416', NULL, NULL, NOW(), '5297b2e6-52b8-4647-93b7-2d8f0a000005', '0'),
('5245a9f8-255c-43da-b592-41ebc6c3268c', 4, 'Training', 1, 0, NULL, 0, '522e4490-ff60-4990-8ca2-8a04c6c3268c', '522ee01c-4c78-437c-bffb-0311c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), NULL, '0'),
('5245aa2a-9a48-4910-ae2a-41f1c6c3268c', 5, 'Contractor / Supplier fault', 1, 0, NULL, 0, '522e4490-ff60-4990-8ca2-8a04c6c3268c', '522ee01c-4c78-437c-bffb-0311c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), NULL, '0'),
('5245aa41-5d0c-4aee-9d2a-4063c6c3268c', 6, 'Operator fault', 0, 0, NULL, 0, '522e4490-ff60-4990-8ca2-8a04c6c3268c', '522ee01c-4c78-437c-bffb-0311c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530d86cc-96d4-49f3-a126-1d42b6329416', NULL, NULL, NOW(), '5297b2e6-52b8-4647-93b7-2d8f0a000005', '0'),
('533ea8a6-12e8-4bd6-a2fb-1a3a51f38a45', 7, 'Productions', 1, 0, NULL, 0, '530c2ddf-4668-4a02-96ba-383db6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '530c2de0-b334-4661-a55c-383db6329416', NOW(), '530c2de0-b334-4661-a55c-383db6329416', NULL, NULL, NOW(), '5297b2e6-52b8-4647-93b7-2d8f0a000005', '');

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `change_addition_deletion_requests`
--

CREATE TABLE IF NOT EXISTS `change_addition_deletion_requests` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` varchar(36) DEFAULT NULL,
  `department_id` varchar(36) DEFAULT NULL,
  `employee_id` varchar(36) DEFAULT NULL,
  `customer_id` varchar(36) DEFAULT NULL,
  `suggestion_form_id` varchar(36) DEFAULT NULL,
  `request_details` text,
  `others` varchar(250) DEFAULT NULL,
  `master_list_of_format` varchar(36) NOT NULL,
  `current_document_details` text,
  `current_work_instructions` text,
  `proposed_document_changes` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `proposed_work_instruction_changes` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `reason_for_change` text NOT NULL,
  `document_change_accepted` int(2) DEFAULT NULL,
  `flinkiso_functionality_change_required` tinyint(1) DEFAULT NULL,
  `flinkiso_functionality_change_details` text,
  `meeting_id` varchar(36) DEFAULT NULL COMMENT 'meeting where changes have been approved',
  `prepared_by` varchar(36) DEFAULT NULL,
  `approved_by` varchar(36) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `customer_id` varchar(150) NOT NULL,
  `phone` varchar(120) NOT NULL,
  `mobile` varchar(120) NOT NULL,
  `email` varchar(250) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(225) NOT NULL,
  `description` text NOT NULL,
  `logo` int(1) NOT NULL DEFAULT '0' COMMENT '0=Default, 1=Custom logo',
  `company_logo` varchar(225) CHARACTER SET utf8 DEFAULT NULL,
  `number_of_branches` int(1) NOT NULL,
  `allow_multiple_login` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0= Not allow, 1=Allow',
  `limit_login_attempt` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0= No limit, 1= limit upto 3 attempt',
  `flinkiso_start_date` date NOT NULL,
  `flinkiso_end_date` date NOT NULL,
  `welcome_message` text,
  `quality_policy` text,
  `vision_statement` text,
  `mission_statement` text,
  `schedule_id` varchar(36) DEFAULT NULL,
  `smtp_setup` tinyint(1) DEFAULT '0',
  `is_smtp` tinyint(1) DEFAULT '0',
  `liscence_key` varchar(36) DEFAULT NULL,
  `sample_data` tinyint(1) NOT NULL DEFAULT '0',
  `audit_plan` text,
  `activate_password_setting` int(1) NOT NULL DEFAULT '0',
  `two_way_authentication` TINYINT(1) NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(4) DEFAULT '0',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `company_benchmarks`
--

CREATE TABLE IF NOT EXISTS `company_benchmarks` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `benchmark` int(10) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `competency_mappings`
--

CREATE TABLE IF NOT EXISTS `competency_mappings` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(36) NOT NULL,
  `education_id` varchar(36) NOT NULL,
  `experience_required` varchar(100) NOT NULL,
  `skills_required` text,
  `actual_education` varchar(36) NOT NULL,
  `actual_experience` varchar(100) DEFAULT NULL,
  `skills_possesed` text,
  `remarks` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `corrective_preventive_actions`
--

CREATE TABLE IF NOT EXISTS `corrective_preventive_actions` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `number` varchar(20) DEFAULT NULL,
  `capa_source_id` varchar(200) DEFAULT NULL,
  `capa_category_id` varchar(36) NOT NULL,
  `capa_type` tinyint(4) NOT NULL COMMENT '0: Corrective Action 1:Preventive Action, 2:Both',
  `internal_audit_id` varchar(36) DEFAULT NULL,
  `suggestion_form_id` varchar(36) DEFAULT NULL,
  `customer_complaint_id` varchar(36) DEFAULT NULL,
  `supplier_registration_id` varchar(36) DEFAULT NULL,
  `product_id` varchar(36) DEFAULT NULL,
  `device_id` varchar(36) DEFAULT NULL,
  `material_id` varchar(36) DEFAULT NULL,
  `raised_by` varchar(250) NOT NULL,
  `assigned_to` varchar(36) NOT NULL,
  `target_date` date NOT NULL,
  `initial_remarks` text,
  `proposed_immidiate_action` text,
  `completed_by` varchar(36) DEFAULT NULL,
  `completed_on_date` date DEFAULT NULL,
  `completion_remarks` text,
  `root_cause_analysis_required` tinyint(1) DEFAULT '0',
  `root_cause` text,
  `determined_by` varchar(36) DEFAULT NULL,
  `determined_on_date` date DEFAULT NULL,
  `root_cause_remarks` text,
  `proposed_longterm_action` text,
  `action_assigned_to` varchar(36) DEFAULT NULL,
  `action_completed_on_date` date DEFAULT NULL,
  `action_completion_remarks` text,
  `effectiveness` text,
  `closed_by` varchar(36) DEFAULT NULL,
  `closed_on_date` date DEFAULT NULL,
  `closure_remarks` text,
  `document_changes_required` tinyint(1) DEFAULT NULL,
  `change_addition_deletion_request_id` varchar(36) DEFAULT NULL,
  `current_status` tinyint(1) DEFAULT '0' COMMENT '1: Close; 0; Open',
  `priority` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0= low, 1= medium, 2= high',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `publish` tinyint(1) DEFAULT '0',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `courier_registers`
--

CREATE TABLE IF NOT EXISTS `courier_registers` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(20) DEFAULT NULL,
  `dispatch_details` text,
  `bill_amount` int(11) DEFAULT NULL,
  `courier_no` varchar(20) DEFAULT NULL,
  `no_of_parcels` int(11) DEFAULT NULL,
  `user_id` varchar(36) DEFAULT NULL,
  `branch_id` varchar(36) DEFAULT NULL,
  `department_id` varchar(36) DEFAULT NULL,
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `company_id` varchar(36) DEFAULT NULL,
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(225) NOT NULL,
  `course_type_id` varchar(36) NOT NULL,
  `description` text NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `course_types`
--

CREATE TABLE IF NOT EXISTS `course_types` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(225) NOT NULL,
  `description` text NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `customer_code` char(20) NOT NULL,
  `customer_since_date` date NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `phone` varchar(120) NOT NULL,
  `mobile` varchar(120) NOT NULL,
  `email` varchar(250) NOT NULL,
  `customer_type` tinyint(1) NOT NULL COMMENT '0 for company, 1 for individual',
  `lead_type` int(1) NOT NULL,
  `residence_address` text,
  `maritial_status` varchar(55) DEFAULT NULL,
  `branch_id` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`company_id`),
  UNIQUE KEY `customer_code` (`customer_code`,`company_id`),
  UNIQUE KEY `email` (`email`,`company_id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `customer_contacts`
--

CREATE TABLE IF NOT EXISTS `customer_contacts` (
 `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `customer_id` varchar(150) NOT NULL,
  `phone` varchar(120) NOT NULL,
  `mobile` varchar(120) NOT NULL,
  `email` varchar(250) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `state_id` varchar(36) DEFAULT NULL,
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `customer_complaints`
--

CREATE TABLE IF NOT EXISTS `customer_complaints` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL COMMENT 'complaint or feed back',
  `customer_id` varchar(36) NOT NULL,
  `complaint_source` varchar(36) CHARACTER SET utf8 NOT NULL COMMENT '0: Product, 1:Service, 2:DelChallan, 3:Customer Care',
  `product_id` varchar(36) DEFAULT NULL,
  `delivery_challan_id` varchar(36) DEFAULT NULL,
  `complaint_number` varchar(100) NOT NULL,
  `complaint_date` date NOT NULL,
  `target_date` date NOT NULL,
  `details` text NOT NULL,
  `employee_id` varchar(36) NOT NULL,
  `action_taken` text,
  `action_taken_date` date DEFAULT NULL,
  `current_status` tinyint(1) DEFAULT '1',
  `settled_date` date DEFAULT NULL,
  `authorized_by` varchar(250) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `customer_contacts`
--

CREATE TABLE IF NOT EXISTS `customer_contacts` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `customer_id` varchar(150) NOT NULL,
  `phone` varchar(120) NOT NULL,
  `mobile` varchar(120) NOT NULL,
  `email` varchar(250) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
`company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `customer_feedbacks`
--

CREATE TABLE IF NOT EXISTS `customer_feedbacks` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(36) NOT NULL,
  `customer_feedback_question_id` varchar(36) NOT NULL,
  `answer` varchar(20) DEFAULT NULL,
  `comments` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `customer_feedback_questions`
--

CREATE TABLE IF NOT EXISTS `customer_feedback_questions` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `question_type` tinyint(1) NOT NULL,
  `option_one` varchar(20) DEFAULT NULL,
  `option_two` varchar(20) DEFAULT NULL,
  `option_three` varchar(20) DEFAULT NULL,
  `option_four` varchar(20) DEFAULT NULL,
  `option_five` varchar(20) DEFAULT NULL,
  `option_six` varchar(20) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `customer_meetings`
--

CREATE TABLE IF NOT EXISTS `customer_meetings` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(36) NOT NULL,
  `client_id` varchar(36) NOT NULL,
  `employee_id` varchar(36) DEFAULT NULL,
  `proposal_followup_id` varchar(36) DEFAULT NULL,
  `followup_id` varchar(36) DEFAULT NULL,
  `meeting_date` date NOT NULL,
  `action_point` varchar(255) NOT NULL,
  `details` text,
  `next_meeting_date` date DEFAULT NULL,
  `status` varchar(9) DEFAULT '0',
  `active_lock` tinyint(4) DEFAULT NULL COMMENT '0: Unlocked; 1: Locked',
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `custom_templates`
--

CREATE TABLE IF NOT EXISTS `custom_templates` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `description` text,
  `details` text NOT NULL,
  `header` text NOT NULL,
  `template_body` text NOT NULL,
  `footer` text NOT NULL,
  `schedule_id` varchar(36) DEFAULT NULL,
  `report_type` varchar(10) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`company_id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `daily_backup_details`
--

CREATE TABLE IF NOT EXISTS `daily_backup_details` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(156) NOT NULL,
  `employee_id` varchar(36) NOT NULL,
  `data_back_up_id` varchar(36) NOT NULL,
  `backup_date` date NOT NULL,
  `device_id` varchar(36) DEFAULT NULL COMMENT 'device on which backup is taken',
  `list_of_computer_id` varchar(36) DEFAULT NULL COMMENT 'device from which backup is taken',
  `task_performed` tinyint(2) DEFAULT '0' COMMENT '0=Unread, 1=Yes, 2=No',
  `comments` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `databackup_logbooks`
--

CREATE TABLE IF NOT EXISTS `databackup_logbooks` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `daily_backup_detail_id` varchar(36) DEFAULT NULL,
  `employee_id` varchar(36) NOT NULL COMMENT 'verified by',
  `backup_date` date NOT NULL,
  `task_performed` tinyint(2) DEFAULT '0',
  `comments` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `data_back_ups`
--

CREATE TABLE IF NOT EXISTS `data_back_ups` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `data_type_id` varchar(36) NOT NULL,
  `data_back_up_id` varchar(36) NOT NULL,
  `branch_id` varchar(36) NOT NULL,
  `schedule_id` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `data_entries`
--

CREATE TABLE IF NOT EXISTS `data_entries` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` varchar(36) NOT NULL,
  `department_id` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `record_date` date NOT NULL,
  `count` int(11) NOT NULL,
  `publish` tinyint(1) DEFAULT '1' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `data_types`
--

CREATE TABLE IF NOT EXISTS `data_types` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `details` text NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`company_id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `delivery_challans`
--

CREATE TABLE IF NOT EXISTS `delivery_challans` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `customer_id` varchar(36) DEFAULT NULL,
  `supplier_registration_id` varchar(36) NOT NULL,
  `details` text,
  `challan_number` varchar(80) NOT NULL,
  `challan_date` date NOT NULL,
  `challan_details` text NOT NULL,
  `purchase_order_id` varchar(36) NOT NULL,
  `prices` varchar(250) DEFAULT NULL,
  `ship_by` varchar(250) DEFAULT NULL,
  `shipping_details` varchar(250) DEFAULT NULL,
  `insurance` varchar(250) DEFAULT NULL,
  `shipping_date` date NOT NULL,
  `ship_to` varchar(250) DEFAULT NULL,
  `payment_details` varchar(250) NOT NULL,
  `invoice_to` varchar(250) NOT NULL,
  `acknowledgement_details` varchar(250) NOT NULL,
  `acknowledgement_date` date NOT NULL,
  `branch_id` varchar(36) DEFAULT NULL,
  `department_id` varchar(36) DEFAULT NULL,
  `other_reference_number` varchar(25) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `challan_number` (`challan_number`,`company_id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `delivery_challan_details`
--

CREATE TABLE IF NOT EXISTS `delivery_challan_details` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `delivery_challan_id` varchar(36) NOT NULL,
  `purchase_order_id` varchar(36) DEFAULT NULL,
  `purchase_order_details_id` varchar(36) DEFAULT NULL,
  `product_id` varchar(36) DEFAULT NULL,
  `device_id` varchar(36) DEFAULT NULL,
  `material_id` varchar(36) DEFAULT NULL,
  `material_qc_required` tinyint(1) DEFAULT '0' COMMENT '0=No, 1=Yes',
  `other` varchar(250) DEFAULT NULL,
  `item_number` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `quantity_dispatch` int(11) DEFAULT NULL,
  `quantity_received` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `rate` int(11) NOT NULL,
  `discount` int(2) DEFAULT NULL,
  `total` int(11) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `clauses` text,
  `details` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `name_2` (`name`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `sr_no`, `name`, `clauses`, `details`, `publish`, `record_status`, `status_user_id`, `soft_delete`, `branchid`, `departmentid`, `created_by`, `created`, `modified_by`, `approved_by`, `prepared_by`, `modified`, `system_table_id`, `master_list_of_format_id`) VALUES
('523a0abb-21e0-4b44-a219-6142c6c32681', 1, 'MR', '4.2.3, 5.0, 8.2.2, 8.4, 8.5.1, 8.5.2, 8.5.3', NULL, 1, 0, NULL, 0, '', '', '', NOW(), '', NULL, NULL, NOW(), NULL, '0'),
('523a0abb-21e0-4b44-a219-6142c6c32682', 2, 'Purchase', '7.4.1, 8.4', NULL, 1, 0, NULL, 0, '', '', '', NOW(), '', NULL, NULL, NOW(), NULL, '0'),
('523a0abb-21e0-4b44-a219-6142c6c32683', 3, 'Admin', '6.3', NULL, 1, 0, NULL, 0, '', '', '', NOW(), '', NULL, NULL, NOW(), NULL, '0'),
('523a0abb-21e0-4b44-a219-6142c6c32684', 4, 'HR', '6.2.2, 7.5.2', NULL, 1, 0, NULL, 0, '', '', '', NOW(), '', NULL, NULL, NOW(), NULL, '0'),
('523a0abb-21e0-4b44-a219-6142c6c32685', 5, 'Quality Control', '7.2.3, 7.3.6, 7.4.3, 7.5.2, 7.6, 8, 8.2.1, 8.3, 8.4', NULL, 1, 0, NULL, 0, '', '', '', NOW(), '', NULL, NULL, NOW(), NULL, '0'),
('523a0abb-21e0-4b44-a219-6142c6c32686', 6, 'Store', '', NULL, 0, 0, NULL, 0, '', '', '', NOW(), '', NULL, NULL, NOW(), NULL, '0'),
('523a0abb-21e0-4b44-a219-6142c6c32687', 7, 'EDP', '6.3, 7.5.3, 7.5.4', NULL, 1, 0, NULL, 0, '', '', '', NOW(), '', NULL, NULL, NOW(), NULL, '0'),
('523a0abb-21e0-4b44-a219-6142c6c32688', 8, 'BD', '7.2', NULL, 1, 0, NULL, 0, '', '', '', NOW(), '', NULL, NULL, NOW(), NULL, '0'),
('523a0abb-21e0-4b44-a219-6142c6c32689', 9, 'Production', '7.5.3', NULL, 1, 0, NULL, 0, '', '', '', NOW(), '', NULL, NULL, NOW(), NULL, '0');

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `department_benchmarks`
--

CREATE TABLE IF NOT EXISTS `department_benchmarks` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` varchar(36) NOT NULL,
  `department_id` varchar(36) NOT NULL,
  `benchmark` int(10) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `designations`
--

CREATE TABLE IF NOT EXISTS `designations` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=60 ;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `sr_no`, `name`, `publish`, `record_status`, `status_user_id`, `soft_delete`, `branchid`, `departmentid`, `created_by`, `created`, `modified_by`, `approved_by`, `prepared_by`, `modified`, `system_table_id`, `master_list_of_format_id`) VALUES
('5297a9cc-8418-4605-a61f-26b20a000005', 54, 'Developer', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), NULL, '0'),
('5297a9de-fb08-49e9-86ce-2b4a0a000005', 55, 'Office Admin Staff', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), NULL, '0'),
('5297a9eb-be04-4849-bada-2bb00a000005', 56, 'Sr. Sales Executive', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), NULL, '0'),
('52979a51-5948-41fb-9a6a-26500a000005', 28, 'Management Representative', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0', '0'),
('52979a51-25e0-4ed0-980f-26500a000005', 15, 'Managing Director', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0', '0'),
('52979a51-d410-4c17-a76d-26500a000005', 31, 'Software Architect', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '52f0c09f-370c-4071-b1d6-5ceeb6329416', NULL, NULL, NOW(), '0', '0'),
('52979a51-93bc-41b9-825e-26500a000005', 33, 'Sr. Design Engineer', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '52f0c09f-370c-4071-b1d6-5ceeb6329416', NULL, NULL, NOW(), '0', '0'),
('52979a51-c464-4df4-a5ca-26500a000005', 34, 'Engineer Software Testing', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '52f0c09f-370c-4071-b1d6-5ceeb6329416', NULL, NULL,  NOW(), '0', '0'),
('52979a51-9a24-4cb9-ba5f-26500a000005', 35, 'Sr. Engineer. Soft Testing', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '52f0c09f-370c-4071-b1d6-5ceeb6329416', NULL, NULL, NOW(), '0', '0'),
('52979a51-6660-493f-aff6-26500a000005', 36, 'Team Leader', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0', '0'),
('52979a51-4ab8-4edb-8b77-26500a000005', 37, 'Test Leader', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '52f0c09f-370c-4071-b1d6-5ceeb6329416', NULL, NULL, NOW(), '0', '0'),
('52979a51-bf58-4fff-bed5-26500a000005', 38, 'Assistant Project Manager', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '52f0c09f-370c-4071-b1d6-5ceeb6329416', NULL, NULL, NOW(), '0', '0'),
('52979a51-e380-4c21-800e-26500a000005', 39, 'Project Manager', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '52f0c09f-370c-4071-b1d6-5ceeb6329416', NULL, NULL, NOW(), '0', '0'),
('52979a51-85d4-4a7f-aaec-26500a000005', 40, 'Application Developer', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0', '0'),
('52979a51-8d78-493d-9a3e-26500a000005', 41, 'Sr. Application Developer', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '52f0c09f-370c-4071-b1d6-5ceeb6329416', NULL, NULL, NOW(), '0', '0'),
('52979a51-e148-4ae3-b2fc-26500a000005', 42, 'Application Engineer', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '52f0c09f-370c-4071-b1d6-5ceeb6329416', NULL, NULL, NOW(), '0', '0'),
('52979a51-6e3c-4cd8-bbfb-26500a000005', 43, 'Sr. Application Engineer', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '52f0c09f-370c-4071-b1d6-5ceeb6329416', NULL, NULL, NOW(), '0', '0'),
('52979a51-b7e4-4b47-bbd6-26500a000005', 44, 'Product Engineer', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '52f0c09f-370c-4071-b1d6-5ceeb6329416', NULL, NULL, NOW(), '0', '0'),
('52979a51-9e94-4227-8a77-26500a000005', 45, 'Sr. Product Engineer', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '52f0c075-3fac-4db3-a791-5ceeb6329416', NULL, NULL, NOW(), '0', '0'),
('52979a51-f458-445c-8465-26500a000005', 46, 'Product Head', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '52f0c09f-370c-4071-b1d6-5ceeb6329416', NULL, NULL, NOW(), '0', '0'),
('52979a51-72ec-4e5a-9a57-26500a000005', 47, 'Software Analyst / Analyst', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '52f0c09f-370c-4071-b1d6-5ceeb6329416', NULL, NULL, NOW(), '0', '0'),
('52979a51-f2e0-4274-806a-26500a000005', 48, 'Lead Analyst', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '52f0c075-3fac-4db3-a791-5ceeb6329416', NULL, NULL, NOW(), '0', '0'),
('52979a51-dcb0-4cc5-af80-26500a000005', 49, 'Sr. Analyst', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '52f0c075-3fac-4db3-a791-5ceeb6329416', NULL, NULL,NOW(), '0', '0'),
('52979a51-397c-45a5-a7a4-26500a000005', 50, 'Tech Lead', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL,NOW(), '0', '0'),
('52979a51-d270-41a1-83db-26500a000005', 51, 'Service Head', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0', '0'),
('52979a51-db94-46a9-acbf-26500a000005', 52, 'Directors and above', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0', '0'),
('52979a51-9ad0-4c90-be57-26500a000005', 53, 'Consultant / Sr. Consultant', 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0', '0'),
('52d24b0b-48e4-480b-b1f6-6cc5c6c3268c', 57, 'Human Resource Manager', 1, 0, NULL, 0, '52c1357d-d0d4-4a74-951b-0c21c6c3268c', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '52d244eb-e678-4f5c-b1c0-6c48c6c3268c', NOW(), '52f0c075-3fac-4db3-a791-5ceeb6329416', NULL, NULL, NOW(), '5297b2e7-c1a8-4d19-bbfe-2d8f0a000005', ''),
('5343bc58-a008-461c-a0e7-0fb551f38a45', 59, 'HR', 1, 0, NULL, 0, '530c2ddf-4668-4a02-96ba-383db6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '530c2de0-b334-4661-a55c-383db6329416', NOW(), '530c2de0-b334-4661-a55c-383db6329416', NULL, NULL, NOW(), '5297b2e7-c1a8-4d19-bbfe-2d8f0a000005', '');

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `devices`
--

CREATE TABLE IF NOT EXISTS `devices` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `number` varchar(80) NOT NULL,
  `serial` varchar(120) NOT NULL,
  `manual` varchar(120) NOT NULL,
  `sparelist` varchar(5) NOT NULL,
  `description` text NOT NULL,
  `make_type` varchar(120) NOT NULL,
  `supplier_registration_id` varchar(36) DEFAULT NULL,
  `purchase_date` date NOT NULL,
  `employee_id` varchar(36) NOT NULL COMMENT 'employee whos uses this instrument and responsible for maintainence',
  `branch_id` varchar(36) DEFAULT NULL,
  `department_id` varchar(36) DEFAULT NULL,
  `calibration_required` tinyint(1) NOT NULL DEFAULT '1',
  `calibration_frequency` varchar(36) DEFAULT NULL,
  `least_count` varchar(20) DEFAULT NULL,
  `required_accuracy` varchar(20) DEFAULT NULL,
  `range` varchar(20) DEFAULT NULL,
  `default_calibration` varchar(20) DEFAULT NULL,
  `required_calibration` varchar(20) DEFAULT NULL,
  `actual_calibration` varchar(20) DEFAULT NULL,
  `maintenance_required` tinyint(1) DEFAULT '0' COMMENT '0=no;1=yes',
  `maintenance_frequency` varchar(36) DEFAULT NULL,
  `maintenance_details` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`company_id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `device_maintenances`
--

CREATE TABLE IF NOT EXISTS `device_maintenances` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` varchar(36) NOT NULL,
  `employee_id` varchar(36) NOT NULL,
  `maintenance_performed_date` date NOT NULL,
  `findings` text,
  `status` varchar(156) DEFAULT NULL COMMENT '0=Not in use, 1=In use',
  `intimation_sent_to_employee_id` varchar(36) DEFAULT NULL,
  `intimation_sent_to_department_id` varchar(36) DEFAULT NULL,
  `next_maintanence_date` date DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `document_amendment_record_sheets`
--

CREATE TABLE IF NOT EXISTS `document_amendment_record_sheets` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `request_from` varchar(55) NOT NULL COMMENT 'from  branch department employee customer etc -checkbox',
  `branch_id` varchar(36) DEFAULT NULL,
  `department_id` varchar(36) DEFAULT NULL,
  `employee_id` varchar(36) DEFAULT NULL,
  `customer_id` varchar(36) DEFAULT NULL,
  `others` varchar(250) DEFAULT NULL,
  `change_addition_deletion_request_id` varchar(36) DEFAULT NULL,
  `master_list_of_format` varchar(36) NOT NULL COMMENT 'id of b/d/e/c etc',
  `document_number` varchar(12) DEFAULT NULL,
  `issue_number` varchar(2) DEFAULT NULL,
  `revision_number` int(2) DEFAULT NULL,
  `revision_date` date DEFAULT NULL,
  `document_details` text,
  `work_instructions` text,
  `prepared_by` varchar(36) DEFAULT NULL,
  `approved_by` varchar(36) DEFAULT NULL,
  `amendment_details` text NOT NULL,
  `reason_for_change` text NOT NULL,
  `suggestion_form_id` varchar(36) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `educations`
--

CREATE TABLE IF NOT EXISTS `educations` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(225) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `educations`
--

INSERT INTO `educations` (`id`, `sr_no`, `title`, `publish`, `record_status`, `status_user_id`, `soft_delete`, `branchid`, `departmentid`, `created_by`, `created`, `modified_by`, `approved_by`, `prepared_by`, `modified`, `system_table_id`, `master_list_of_format_id`) VALUES
('1b0fec70-7c3a-11e3-83eb-47ab8596632d', 1, 'Graduate', 1, 0, NULL, 0, '', '', '', NOW(), '', NULL, NULL, NOW(), '0', '0'),
('1b0fefb8-7c3a-11e3-83eb-47ab8596632d', 2, 'Masters', 1, 0, NULL, 0, '', '', '', NOW(), '', NULL, NULL, NOW(), '0', '0');

-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `email_triggers` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `details` text,
  `system_table` varchar(36) NOT NULL,
  `changed_field` varchar(250) DEFAULT NULL,
  `branch_id` varchar(36) NOT NULL,
  `if_added` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `if_edited` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `if_publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `if_approved` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `if_soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `recipents` text NOT NULL,
  `cc` text,
  `bcc` text,
  `subject` varchar(120) NOT NULL,
  `template` text NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
--
-- @#@ -- Table structure for table `email_triggers`
--

CREATE TABLE IF NOT EXISTS `email_triggers` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `details` text,
  `system_table` varchar(36) NOT NULL,
  `changed_field` varchar(250) DEFAULT NULL,
  `branch_id` varchar(36) DEFAULT NULL,
  `if_added` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `if_edited` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `if_publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `if_approved` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `if_soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `recipents` text NOT NULL,
  `cc` text,
  `bcc` text,
  `subject` varchar(120) NOT NULL,
  `template` text NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- @#@ -- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `employee_number` char(20) NOT NULL,
  `branch_id` varchar(36) NOT NULL,
  `designation_id` varchar(36) NOT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `pancard_number` char(15) DEFAULT 'NULL',
  `personal_telephone` varchar(120) DEFAULT NULL,
  `office_telephone` varchar(120) DEFAULT 'NULL',
  `mobile` varchar(120) DEFAULT 'NULL',
  `personal_email` varchar(250) DEFAULT 'NULL',
  `office_email` varchar(255) NOT NULL,
  `residence_address` text,
  `permenant_address` text,
  `maritial_status` varchar(55) DEFAULT NULL,
  `driving_license` char(40) DEFAULT 'NULL',
  `employment_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=Resigned, 1=Active',
  `is_approvar` TINYINT(1) NULL DEFAULT '0',
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) DEFAULT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime DEFAULT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `employee_appraisal_questions`
--

CREATE TABLE IF NOT EXISTS `employee_appraisal_questions` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `appraisal_id` varchar(36) DEFAULT NULL,
  `appraisal_question_id` varchar(36) DEFAULT NULL,
  `answer` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `employee_designations`
--

CREATE TABLE IF NOT EXISTS `employee_designations` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(36) NOT NULL,
  `designation_id` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `employee_induction_trainings`
--

CREATE TABLE IF NOT EXISTS `employee_induction_trainings` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(36) NOT NULL,
  `training_id` varchar(36) NOT NULL,
  `responsibility` text NOT NULL,
  `remarks` text NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `employee_kras`
--

CREATE TABLE IF NOT EXISTS `employee_kras` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `kra_id` varchar(36) DEFAULT NULL,
  `employee_id` varchar(36) DEFAULT NULL,
  `title` varchar(156) DEFAULT NULL,
  `description` text,
  `target` varchar(256) DEFAULT NULL,
  `target_achieved` int(10) DEFAULT NULL,
  `final_rating` int(10) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `employee_trainings`
--

CREATE TABLE IF NOT EXISTS `employee_trainings` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(36) NOT NULL,
  `training_id` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `evidences`
--

CREATE TABLE IF NOT EXISTS `evidences` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `file_upload_id` varchar(36) NOT NULL,
  `description` text,
  `model_name` varchar(36) NOT NULL,
  `record` varchar(36) NOT NULL,
  `record_type` varchar(36) NOT NULL,
  `user_session_id` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `file_uploads`
--

CREATE TABLE IF NOT EXISTS `file_uploads` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `system_table_id` varchar(36) DEFAULT NULL,
  `record` varchar(36) DEFAULT NULL,
  `file_details` varchar(250) NOT NULL,
  `file_type` varchar(5) NOT NULL,
  `file_dir` text NULL,
  `user_id` varchar(36) NOT NULL,
  `file_status` varchar(20) NOT NULL,
  `archived` tinyint(1) DEFAULT '0',
  `result` varchar(250) NOT NULL,
  `version` int(11) DEFAULT '0',
  `comment` text,
  `user_session_id` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `fire_extinguishers`
--

CREATE TABLE IF NOT EXISTS `fire_extinguishers` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `fire_extinguisher_type_id` varchar(36) NOT NULL,
  `company_name` varchar(120) NOT NULL,
  `description` text,
  `purchase_date` date NOT NULL,
  `expeiry_date` date NOT NULL,
  `warrenty_expiry_date` date NOT NULL,
  `model_type` varchar(120) NOT NULL,
  `other_remarks` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `fire_extinguisher_types`
--

CREATE TABLE IF NOT EXISTS `fire_extinguisher_types` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `description` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `fire_extinguisher_types`
--

INSERT INTO `fire_extinguisher_types` (`id`, `sr_no`, `name`, `description`, `publish`, `record_status`, `status_user_id`, `soft_delete`, `branchid`, `departmentid`, `created_by`, `created`, `modified_by`, `approved_by`, `prepared_by`, `modified`, `system_table_id`, `master_list_of_format_id`) VALUES
('529b7fb6-3d58-4097-9c2c-1f700a000005', 1, 'A B C Type Dry Powder', 'ABC or Multi-Purpose extinguishers comprise of a special fluidized and siliconized mono ammonium phosphate dry chemical. It chemically insulates Class A fires by melting at approximately 350Â°F and coats surface to which it is applied. It smothers and breaks the chain reaction of Class B fires and will not conduct electricity back to the operator.', 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '5297b2e7-48e8-44e9-84f9-2d8f0a000005', '0'),
('529b7fd8-e730-4509-8bd2-1ac20a000005', 2, 'CO2 Fire Extinguisher', 'Co2 is a liquefied gas, which is highly effective fighting B and C class of fires. These extinguishers are ideal for areas where contamination and/or clean-up are a concern, such as data processing centers, labs, telecommunication rooms, food storage and processing areas etc.', 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '5297b2e7-48e8-44e9-84f9-2d8f0a000005', '0'),
('529b7fef-c9b4-42f0-9b19-1acc0a000005', 3, 'Dry Powder Fire Extinguisher', 'Dry Chemical powder extinguishers utilize a specially siliconized Sodium Bicarbonate. It chemically insulates class B , C fires by forming a cloud and cutting off the oxygen supply, thus extinguishing the fire. It smothers and breaks the chain reaction of Class B fires and will not conduct electricity back to the operator.', 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '5297b2e7-48e8-44e9-84f9-2d8f0a000005', '0'),
('529b8004-9548-4229-82b3-1af00a000005', 4, 'Mechanical Foam (Afff) Fire Extinguisher', 'Foam has the ability to form an aqueous film which quickly over water-insoluble hydrocarbon fuel surfaces causing rapid fire extinguishment and vapour suppression for class b fires. Also it provides excellent penetrating and wetting qualities when used on class a fires. Hence, foam extinguishers are ideal for fires involving volatile liquids and freely burning materials such as lubricant, oil fires, paper, cloth, wood, etc.', 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '5297b2e7-48e8-44e9-84f9-2d8f0a000005', '0'),
('529b801e-f1a4-4367-8ae4-19e80a000005', 5, 'Modular Automatic Fire Extinguisher', 'Fire is a calamity that strikes without any warning and causes an unimaginable havoc. According to a survey conducted, 80% of the most damaging fires occur during night times, weekends or holidays when no one is around. Hence an automatic operation is the only solution for round-the-clock protection against any kind of fire.', 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '5297b2e7-48e8-44e9-84f9-2d8f0a000005', '0'),
('529b8048-b318-4273-a6e4-1fb40a000005', 6, 'Clean Agent Fire Extinguisher', ' CLEAN AGENT replaces Halon 1211 as the agent-of-choice for applications where the agent must be clean, electrically nonconductive, environment-friendly, extremely low in toxicity and exceptionally effective.', 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '5297b2e7-48e8-44e9-84f9-2d8f0a000005', '0'),
('53341d10-facc-4a99-ad3f-18c751f38a45', 7, 'Type 1', 'Fire Extinguisher Type', 1, 0, NULL, 0, '530c2ddf-4668-4a02-96ba-383db6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '530c2de0-b334-4661-a55c-383db6329416', NOW(), '530c2de0-b334-4661-a55c-383db6329416', NULL, NULL, NOW(), '5297b2e7-48e8-44e9-84f9-2d8f0a000005', '');

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `fire_safety_equipment_lists`
--

CREATE TABLE IF NOT EXISTS `fire_safety_equipment_lists` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `fire_extinguisher_id` varchar(36) NOT NULL,
  `fire_type_id` varchar(36) NOT NULL,
  `branch_id` varchar(36) NOT NULL,
  `department_id` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `fire_types`
--

CREATE TABLE IF NOT EXISTS `fire_types` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `helps`
--

CREATE TABLE IF NOT EXISTS `helps` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` varchar(36) NOT NULL,
  `title` varchar(120) NOT NULL,
  `table_name` varchar(80) NOT NULL,
  `action_name` varchar(80) NOT NULL,
  `help_text` mediumtext NOT NULL,
  `sequence` int(1) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) NOT NULL DEFAULT '0',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=331 ;

--
-- Dumping data for table `helps`
--

INSERT INTO `helps` (`id`, `sr_no`, `language_id`, `title`, `table_name`, `action_name`, `help_text`, `sequence`, `publish`, `record_status`, `status_user_id`, `soft_delete`, `branchid`, `departmentid`, `created_by`, `created`, `modified_by`, `approved_by`, `prepared_by`, `modified`, `system_table_id`, `master_list_of_format_id`) VALUES
('52527d0c-4724-475d-af79-29d3c6c3268c', 1, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Step - 1 : Adding Data', 'meetings', 'add_ajax, edit, approve', '<p>You can create a meeting from this panel. You need to first define the meeting details by entering the following values :</p>\r\n\r\n\r\n\r\n<ol>\r\n\r\n	<li>Title</li>\r\n\r\n	<li>Previous Meeting</li>\r\n\r\n	<li>Branch where the meeting will be held</li>\r\n\r\n	<li>Departments for which meeting would be held</li>\r\n\r\n	<li>Attendees of the meetings ( Automatic notifications &amp; emails will be sent to respective users )</li>\r\n\r\n	<li>Expected meeting start &amp; end time etc.</li>\r\n\r\n</ol>\r\n\r\n\r\n\r\n<p>You can add basic meeting details, like purpose of the meeting, clause etc.</p>\r\n\r\n\r\n\r\n<p>Once the meeting is created, you can later add &#39;Meeting Details&#39;.</p>', 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-30 16:17:54', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('525283db-b8f4-4782-8e33-2e40c6c3268c', 2, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Step - 2 : Adding Agendas', 'meetings', 'add_ajax, edit, approve', '<p>After you enter the meeting details, you can add &#39;Agenda&#39;. You can click on &#39;<strong>Add New Agenda</strong>&#39; and enter the respective data. You can re-click the button to add multiple agendas.</p>', 2, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-30 16:22:55', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('5278c068-c0e4-47ba-9d7c-808dc6c3268c', 3, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Introduction', 'InternalAuditPlans', 'add_ajax, edit , approve', '<p>This module is divided into two section.</p>\r\n\r\n\r\n\r\n<ol>\r\n\r\n	<li>Creating a plan / schedule</li>\r\n\r\n	<li>Adding actual audit details.</li>\r\n\r\n</ol>\r\n\r\n\r\n\r\n<p>Currently we are on 1st section i.e creating a Audit Plan / Schedule.</p>', 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-30 18:03:02', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('5278cf13-d4fc-4554-85a4-9b2ec6c3268c', 4, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Create Schedule', 'InternalAuditPlans', 'add_ajax, edit , approve', '<p>You can create a schedule by clicking on &quot;<strong>Add Schedule / Plan</strong>&quot; on &nbsp;the MR&nbsp;dashboard.To begin with, you will need to input the&nbsp;ollowing :</p>\r\n\r\n\r\n\r\n<ol>\r\n\r\n	<li>Title (Your title for schedule or plan)</li>\r\n\r\n	<li>Schedule from and to dates.</li>\r\n\r\n	<li>Notes if any</li>\r\n\r\n</ol>\r\n\r\n\r\n\r\n<p>Once you input these, click Submit, your plan will be created and the page will auto refresh.</p>\r\n\r\n\r\n\r\n<p>At this stage, you will see the list of branches in a tab&nbsp;view which currently&nbsp;will be emplty. You will need to add plan for each branch and department from &quot;Create Plan&quot; panel below.</p>\r\n\r\n\r\n\r\n<p>On refreshing the&nbsp;&nbsp;page, you will see a panel called &quot;<strong>Create plan</strong>&quot; below &quot;<strong>Schedule Details</strong>&quot; panel.</p>', 2, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-30 18:04:36', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('5278d49e-83d8-421b-a343-9a6dc6c3268c', 5, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Create Plan', 'InternalAuditPlans', 'add_ajax, edit , approve', '<p>Under &quot;<strong>Create Plan</strong>&quot; panel, you can choose the following :</p>\r\n\r\n\r\n\r\n<ol>\r\n\r\n	<li>Branch</li>\r\n\r\n	<li>Drepartment</li>\r\n\r\n	<li>Clauses (when you choose the department, the application&nbsp;will automatically generate clauses related to that department)</li>\r\n\r\n	<li>Employee (Auditee)</li>\r\n\r\n	<li>Internal Auditor (Auditor)</li>\r\n\r\n	<li>Start time and End time.</li>\r\n\r\n</ol>\r\n\r\n\r\n\r\n<p>Click <strong>Submit</strong>, and the page will reload with the data you have entered. You will now be able to see in &quot;<strong>Schedule Details</strong>&quot; the&nbsp;list of branches in tab&nbsp;view with the corresponding&nbsp;name and number.</p>\r\n\r\n\r\n\r\n<p><span style="line-height:1.6em">You can also edit these details if there are any changes.</span></p>\r\n\r\n', 4, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52792cf5-0730-4cee-a301-9d29c6c3268c', 6, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Schedule Details', 'InternalAudits', 'add_ajax, edit, approve', '<p>The &#39;<strong>Schedule Details</strong>&#39; panel will provide you the details about your pre-defined internal audit schedule. To edit schedule details, click&nbsp; &#39;Edit Details&#39; or if you wish to add acutal audit details, click on &#39;Add Details&#39;.</p>\r\n\r\n\r\n\r\n<p>&nbsp;</p>', 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-10-01 13:25:16', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52792dc6-908c-4866-bb7f-a0bfc6c3268c', 7, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Add Details', 'InternalAudits', 'add_ajax, edit , approve', '<p>Clicking on the &quot;Add Details&quot; button, will take you to the&nbsp;&nbsp;&quot;Add Details&quot; panel. It will also add default values from the audit&nbsp;schedule to relative fields in &quot;Add Details&quot; panel, like branch (invisible), department, auditee, auditor, scheduled start time and end time, clauses etc. You can continue to add other required data and click on submit.<br />\r\n\r\n&nbsp;</p>\r\n\r\n', 2, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52792e53-565c-4c9f-ab87-9d02c6c3268c', 8, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Non Conformity Found', 'InternalAudits', 'add_ajax, edit , approve', '<p>In case of&nbsp;any Non-Conformities raised, check the &quot;<strong><span style="color:#A52A2A">Non Conformity Found</span></strong>&quot; check box. If you click this check box, data from this entry will automatically generate a Corrective / Preventive Action and will be displayed as&nbsp;&quot;Open CAPA&quot;.</p>\r\n\r\n', 3, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52847f2f-409c-47eb-9fe7-0a390a000005', 9, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Missing Data', 'FileUploads', 'import_data', '<p>You get this message when the file you have imported has some data which has a dependency on other tables. e.g. If you are importing the employees. Remember when you add employee, you can select their branch, departments etc. from drop-downs? These values for branch &amp; departments etc are already stored in your system so that you can link your data with each other. Like you can link employee to a branch and department as so on.</p>\r\n\r\n\r\n\r\n<p>Right now the file you have imported, has certain data which is linked with other data in your system. Unless you do not have that data you can not successfully import your new data into the system.</p>\r\n\r\n\r\n\r\n<p>For your convenience, list of such data is displayed in the red alert box. You can either add this new data to their respective tables or if you find that there are any spelling mistakes in your current data, or some minor changes are required to your current data, please make those changes in your file and upload your file again and try again.</p>\r\n\r\n\r\n\r\n<p>Good Luck.</p>\r\n\r\n', 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '', '2014-09-22 08:26:53', '', NULL, NULL, '2014-09-22 08:26:53', '522e4411-1ea0-421c-b81a-84a2c6c3268c', '0'),
('5285d346-738c-44b1-83c9-1eed0a000005', 10, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'General Process', 'Dashboards', 'purchase', '<ol>\r\n\r\n	<li>Create (Register) New Supplier from &quot; New Supplier Registration Form&quot;</li>\r\n\r\n	<li>If you select the checkbox &quot;<strong>Supplier Selected</strong>&quot;&nbsp; as &quot;<span style="color:#008000"><strong>Yes</strong></span>&quot; it will automatically get added to &quot;<strong>List Of Acceptable Suppliers</strong>&quot;.</li>\r\n\r\n	<li>For each purchase order generated, as &quot;Outbound&quot;, you are requested to select the Supplier.</li>\r\n\r\n	<li>Based on the&nbsp;purchase order, while receiving the goods, Delivery Challans will be generated.</li>\r\n\r\n	<li>Based on Purchase Order &amp; Delivery Challans, the Supplier will be evaluated.</li>\r\n\r\n</ol>\r\n\r\n', 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('528cfa48-dd08-4edd-a313-22660a000005', 11, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Scope', 'Dashboards', 'mr', '<ol>\r\n\r\n	<li><strong>Meetings</strong>\r\n\r\n	<ol>\r\n\r\n		<li>Create&nbsp;new meetings</li>\r\n\r\n		<li>Add&nbsp;Meeting Agendas</li>\r\n\r\n		<li>Add&nbsp;chairperson &amp; invitees, scheduled start time &amp; end time</li>\r\n\r\n		<li>Display meeting in the timeline feature.</li>\r\n\r\n	</ol>\r\n\r\n	</li>\r\n\r\n	<li><strong>Meeting Details</strong>\r\n\r\n	<ol>\r\n\r\n		<li>Select earlier created meeting from drop down</li>\r\n\r\n		<li>Add actual date &amp; time</li>\r\n\r\n		<li>Set current status, responsibility &amp; target date for each topics</li>\r\n\r\n		<li>Save meeting for furture reference</li>\r\n\r\n		<li>You can also upload all&nbsp;documents related to meeting from meetings view.</li>\r\n\r\n	</ol>\r\n\r\n	</li>\r\n\r\n	<li><strong>Manage Internal Audits</strong>\r\n\r\n	<ol>\r\n\r\n		<li>First step is to create an audit schedule depending upon the audit plan you already have as per the QMS.</li>\r\n\r\n		<li>You can then add details to the plan for each branch\r\n\r\n		<ol>\r\n\r\n			<li>Add department, clauses, auditee, auditor, schedule start time &amp; end time.</li>\r\n\r\n		</ol>\r\n\r\n		</li>\r\n\r\n		<li>Once your draft is ready, you can add supporting files and publish it on timeline which can be viewed by all users. An email will also be triggered to all the meeting participants.</li>\r\n\r\n	</ol>\r\n\r\n	</li>\r\n\r\n	<li><strong>CAPA</strong>\r\n\r\n	<ol>\r\n\r\n		<li>While entering&nbsp;the audit details, if there are any non-confirmities found, it automatically generated a&nbsp;Corrective &amp; Preventive action.</li>\r\n\r\n	</ol>\r\n\r\n	</li>\r\n\r\n	<li><strong>Benchmarking</strong>\r\n\r\n	<ol>\r\n\r\n		<li>It is important to track the compliance to the application and therefore the ISO process&nbsp;in your organisation, to acheive that the application&nbsp;is equipepd with the benchmarking module, wherein you set a&nbsp;benchmark for every&nbsp;departments in each branch. Based on your input, the application&nbsp;will auto generate and display the&nbsp;readiness graphs on the main dashboard.</li>\r\n\r\n	</ol>\r\n\r\n	</li>\r\n\r\n	<li><strong>List of forms</strong>\r\n\r\n	<ol>\r\n\r\n		<li>All the forms which are available in the application and is&nbsp;listed here department-wise.</li>\r\n\r\n		<li>Each form is linked to a table in the&nbsp;database.</li>\r\n\r\n		<li>You can add your documents related to each format or edit the same.</li>\r\n\r\n		<li>If there are any formats which are missing, it will be created as part of customisation and will be added to the system.</li>\r\n\r\n	</ol>\r\n\r\n	</li>\r\n\r\n	<li><strong>Uploading Quality Documents</strong>\r\n\r\n	<ol>\r\n\r\n		<li>You can upload your quality document for all your users to reference.</li>\r\n\r\n		<li>Users will be able to download these documents for furture reference.</li>\r\n\r\n	</ol>\r\n\r\n	</li>\r\n\r\n	<li><strong>Files uploaded</strong>\r\n\r\n	<ol>\r\n\r\n		<li>You can see&nbsp;all the files&nbsp;uploaded by various&nbsp;users as evidences or as other reference materials</li>\r\n\r\n	</ol>\r\n\r\n	</li>\r\n\r\n</ol>\r\n\r\n', 2, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('528d0489-2dd0-473b-b9f8-22ae0a000005', 12, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Application Salient Features', 'Dashboards', 'mr', '<p>FlinkISO is designed to empower it&#39;s users to manage their ISO certification data completely paperless. The application&nbsp;is currently designed to help departments as viewed&nbsp;in the top menu.</p>\r\n\r\n\r\n\r\n<p>As the&nbsp;MR of an&nbsp;organization, it is important that the MR user understands this application&nbsp;completely. Here are a few&nbsp;brief points you should know about the application. Detailed help and information is also available on each section page.</p>\r\n\r\n\r\n\r\n<p>What you can do as a MR ?</p>\r\n\r\n\r\n\r\n<ol>\r\n\r\n	<li>You can create users, import existing employees, internal &amp; external auditors. create &amp; manage management review&nbsp;meetings / Internal audits from schedule to adding internal audit details and generating and tracking CAPA &amp; Non-Conformities, all of which then can be added onto the &quot;timeline&quot;&nbsp;&amp; &quot;notifications&quot; feature.</li>\r\n\r\n	<li>As the&nbsp;MR, you can provide access control to each&nbsp;user as prescribed by&nbsp;your organisation&#39;s rules.</li>\r\n\r\n	<li>It is recommended that you create atleast one user for each department in each branch and provide them with limited access to the subsystem where they can frequently login and upoad all ISO related data pertinent to their department / branch.</li>\r\n\r\n	<li>You can also set benchmarks of data entry for each user &amp; department. Based on these settings, each users / branch&#39;s compliance will be compared and reported..<br />\r\n\r\n	&nbsp;</li>\r\n\r\n</ol>\r\n\r\n', 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('528d08b0-65a0-484a-b062-223d0a000005', 13, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'How it works', 'Dashboards', 'mr', '<ul>\r\n\r\n	<li>Each user added, can view / add / edit records in the system as per the roles assigned&nbsp;to him or her.</li>\r\n\r\n	<li>For every record added onto the&nbsp;system, users can upload related documents as evidence for the record.</li>\r\n\r\n	<li>MR can also configure which table would require evidences or approvals before publishing it, from backend</li>\r\n\r\n	<li>Each record added will have the&nbsp;following:\r\n\r\n	<ul>\r\n\r\n		<li>Evidences</li>\r\n\r\n		<li>Approvals</li>\r\n\r\n		<li>Approvals History</li>\r\n\r\n		<li>Publish or Unpublish</li>\r\n\r\n	</ul>\r\n\r\n	</li>\r\n\r\n</ul>\r\n\r\n', 3, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-b398-4fb3-ae86-65a90a000005', 222, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'TrainingScheduleDepartments', 'add_ajax, edit , approve', '<ul>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-19a4-45c9-9252-65a90a000005', 223, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'TrainingScheduleEmployees', 'add_ajax, edit , approve', '<ul>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-b6a0-4a68-b675-65a90a000005', 221, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'TrainingScheduleBranches', 'add_ajax, edit , approve', '<ul>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-321c-4037-9c1b-65a90a000005', 220, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'TrainingNeedIdentifications', 'add_ajax, edit , approve', '<ul>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-d54c-4182-985e-65a90a000005', 219, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'TrainingEvaluations', 'add_ajax, edit , approve', '<ul>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-ec00-484e-925d-65a90a000005', 218, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Trainers', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Trainer Type </strong> is mandatory</li>\r\n\r\n	<li><strong>Name</strong> is mandatory</li>\r\n\r\n	<li><strong>Company</strong> is mandatory</li>\r\n\r\n	<li><strong>Designation</strong> is mandatory</li>\r\n\r\n	<li><strong>Qualification</strong> is mandatory</li>\r\n\r\n	<li><strong>Personal Email</strong> is mandatory</li>\r\n\r\n	<li><strong>Office Email</strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-0538-4f9f-9728-65a90a000005', 217, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'TrainerTypes', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Title</strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-e42c-4a90-bb43-65a90a000005', 216, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Timelines', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Title</strong> is mandatory</li>\r\n\r\n	<li><strong>Message</strong> is mandatory</li>\r\n\r\n	<li><strong>Start Date</strong> is mandatory (date format : &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n	<li><strong>End Date</strong> is mandatory (date format : &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n	<li><strong>Prepared By</strong> is mandatory</li>\r\n\r\n	<li><strong>Approved By</strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-3a70-483a-a3d3-65a90a000005', 215, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Tasks', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Name</strong> is mandatory</li>\r\n\r\n	<li><strong>User </strong> is mandatory</li>\r\n\r\n	<li><strong>Description</strong> is mandatory</li>\r\n\r\n	<li><strong>Schedule </strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-87d4-42a2-824b-65a90a000005', 214, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'TaskStatuses', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Task </strong> is mandatory</li>\r\n\r\n	<li><strong>Comments</strong> is mandatory</li>\r\n\r\n	<li><strong>Task Date</strong> is mandatory(date format : &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-a184-4fcb-a1eb-65a90a000005', 213, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'SystemTables', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Name</strong> is mandatory</li>\r\n\r\n	<li><strong>System Name</strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-6fc0-432d-b8de-65a90a000005', 212, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'SupplierRegistrations', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Title</strong> is mandatory</li>\r\n\r\n	<li><strong>Number</strong> is mandatory</li>\r\n\r\n	<li><strong>Type Of Company</strong> is mandatory</li>\r\n\r\n	<li><strong>Contact Person Office</strong> is mandatory</li>\r\n\r\n	<li><strong>Designation at Office</strong> is mandatory</li>\r\n\r\n	<li><strong>Office Address</strong> is mandatory</li>\r\n\r\n	<li><strong>Office Telephone</strong> is mandatory</li>\r\n\r\n</ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-26 19:41:43', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('54251b74-a1f8-4797-a910-117e118438bd', 311, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding Supplier Registration', 'supplierRegistrations', 'add_ajax, edit, approve', '<p>Adding suppliers&#39; information to FlinkISO is easy. Having supplier&#39; information handy is all you need to add a new supplier registration to FlinkISO.</p>\r\n\r\n\r\n\r\n<p>To add a supplier registration you must have at least one Supplier Category defined. Supplier Categories can be added from &#39;Purchase Dashboard&#39; by following &#39;Supplier Categories&#39; link. Once you have supplier categories ready, fill in supplier details in respective fields of this form.</p>\r\n\r\n\r\n\r\n<p>Enter the name of the supplier in &#39;Title&#39; field. If supplier has registration number or any other identity number, enter such number in &#39;Number&#39; field. Select supplier&#39;s company type from &#39;Type of Company&#39; drop-down list. Fill in supplier&#39;s Office Details. If supplier is holding his office and factory/workshop at same place, select <strong>&#39;Factory Details are the same as Office Details&#39;</strong> checkbox, this will copy all the &#39;Office Details&#39; to &#39;Factory / Workshop details&#39;. Enter CST, ST number, Income Tax number, SSI registration number (if any).</p>\r\n\r\n\r\n\r\n<p>You may have placed a trial order, if you are satisfied with the delivery of trial order then you can add this supplier to Acceptable Suppliers&#39; list by selecting &#39;Yes&#39; from &#39;<strong>Is supplier selected as Acceptable Supplier?</strong>&#39; drop-down list, else you can select an appropriate option from this list.</p>\r\n\r\n\r\n\r\n<p>Select a category this supplier fall into. After filling in all the available details, save this supplier information by clicking &#39;Submit&#39; button.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-26 13:23:24', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-10-01 15:33:57', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52ab0723-0b38-4734-87dc-65a90a000005', 211, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'SupplierEvaluationReevaluations', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Supplier Registration </strong> is mandatory</li>\r\n\r\n	<li><strong>Delivery Challan Id</strong> is mandatory</li>\r\n\r\n	<li><strong>Required Delivery Date</strong> is mandatory (date format : &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n	<li><strong>Actual Delivery Date</strong> is mandatory (date format : &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-cd60-472f-8b1a-65a90a000005', 209, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'SummeryOfSupplierEvaluations', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Supplier Registration </strong> is mandatory</li>\r\n\r\n	<li><strong>Supplier Category </strong> is mandatory</li>\r\n\r\n	<li><strong>Remarks</strong> is mandatory</li>\r\n\r\n	<li><strong>Evaluation Date</strong> is mandatory (date format : &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n	<li><strong>Employee </strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-1ca8-41e6-83fe-65a90a000005', 210, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'SupplierCategories', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Name</strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-4f78-4f6d-9acc-65a90a000005', 208, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'suggestionForms', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Employee </strong> is mandatory</li>\r\n\r\n	<li><strong>Activity</strong> is mandatory</li>\r\n\r\n	<li><strong>Title</strong> is mandatory</li>\r\n\r\n	<li><strong>Suggestion</strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-79b8-44f0-ba07-65a90a000005', 206, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Schedules', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Name</strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-1720-4e27-81b2-65a90a000005', 207, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'SoftwareTypes', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Title</strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-cb84-43c7-9fed-65a90a000005', 205, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Reports', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Title</strong> is mandatory</li>\r\n\r\n	<li><strong>Branch </strong> is mandatory</li>\r\n\r\n	<li><strong>Department </strong> is mandatory</li>\r\n\r\n	<li><strong>Details</strong> is mandatory</li>\r\n\r\n	<li><strong>Report Date</strong> is mandatory (date format : &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-af54-4d25-953c-65a90a000005', 204, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'PurchaseOrders', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Title</strong> is mandatory</li>\r\n\r\n	<li><strong>Type</strong> is mandatory</li>\r\n\r\n	<li><strong>Purchase Order Number</strong> is mandatory</li>\r\n\r\n	<li><strong>Order Date</strong> is mandatory (date format : &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-2880-481b-8a6c-65a90a000005', 203, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'PurchaseOrderDetails', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Item Number</strong> is mandatory</li>\r\n\r\n	<li><strong>Description</strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-d768-4e79-9092-65a90a000005', 201, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'OrderRegisters', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Date</strong> is mandatory (date format : &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n	<li><strong>Customer Details</strong> is mandatory</li>\r\n\r\n	<li><strong>Supplier Registration </strong> is mandatory</li>\r\n\r\n	<li><strong>Order Reference Number</strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-fc70-4991-950a-65a90a000005', 202, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Products', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Name</strong> is mandatory</li>\r\n\r\n	<li><strong>Description</strong> is mandatory</li>\r\n\r\n	<li><strong>Branch</strong> is mandatory</li>\r\n\r\n	<li><strong>Department</strong> is mandatory</li>\r\n\r\n</ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-26 18:50:13', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-efec-4f73-bc0d-65a90a000005', 200, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'OrderDetailsForms', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Purchase Order </strong> is mandatory</li>\r\n\r\n	<li><strong>Order Date</strong> is mandatory (date format : &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n	<li><strong>Delivery Date</strong> is mandatory (date format : &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n	<li><strong>Delivery Challan </strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-68ac-4550-b617-65a90a000005', 199, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Notifications', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Notification Type </strong> is mandatory</li>\r\n\r\n	<li><strong>Title</strong> is mandatory</li>\r\n\r\n	<li><strong>Message</strong> is mandatory</li>\r\n\r\n	<li><strong>Start Date</strong> is mandatory (date format : &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n	<li><strong>End Date</strong> is mandatory (date format : &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n	<li><strong>Prepared By</strong> is mandatory</li>\r\n\r\n	<li><strong>Approved By</strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-b570-4261-ae0d-65a90a000005', 197, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'NotificationTypes', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Name</strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-fce8-40d4-9167-65a90a000005', 198, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'NotificationUsers', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Notification </strong> is mandatory</li>\r\n\r\n	<li><strong>User Id</strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-92d4-40e3-b7ac-65a90a000005', 196, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Messages', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Subject</strong> is mandatory</li>\r\n\r\n	<li><strong>Message</strong> is mandatory</li>\r\n\r\n	<li><strong>User </strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-37d4-489a-890a-65a90a000005', 195, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'MessageUserThrashes', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Message </strong> is mandatory</li>\r\n\r\n	<li><strong>User </strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-6910-4450-9cf6-65a90a000005', 194, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'MessageUserSents', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Message </strong> is mandatory</li>\r\n\r\n	<li><strong>User </strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-17f8-4a93-b864-65a90a000005', 193, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'MessageUserInboxes', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Message </strong> is mandatory</li>\r\n\r\n	<li><strong>User </strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-1650-4efc-8827-65a90a000005', 192, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Meetings', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Title</strong> is mandatory</li>\r\n\r\n	<li><strong>Meeting Details</strong> is mandatory</li>\r\n\r\n	<li><strong>Branch</strong> is mandatory</li>\r\n\r\n	<li><strong>Chairperson</strong> is mandatory</li>\r\n\r\n	<li><strong>Department/s</strong> is mandatory</li>\r\n\r\n	<li><strong>Invitees</strong> is mandatory</li>\r\n\r\n	<li><strong>Meeting Start Time&nbsp;</strong> is mandatory</li>\r\n\r\n	<li><strong>Meeting End Time</strong> is mandatory</li>\r\n\r\n</ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-30 16:10:58', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-5d18-4149-b34e-65a90a000005', 191, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'MeetingTopics', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Meeting </strong> is mandatory</li>\r\n\r\n	<li><strong>Title</strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-d8b8-4bd7-a341-65a90a000005', 190, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'MeetingEmployees', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Meeting </strong> is mandatory</li>\r\n\r\n	<li><strong>Employee </strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-f8e8-4958-a0e2-65a90a000005', 189, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'MeetingDepartments', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Meeting </strong> is mandatory</li>\r\n\r\n	<li><strong>Department </strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-f294-4fdb-8e77-65a90a000005', 187, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Materials', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Name</strong> is mandatory</li>\r\n\r\n	<li><strong>Description</strong> is mandatory</li>\r\n\r\n	<li><strong>Shelflife By Manufacturer</strong> is mandatory</li>\r\n\r\n	<li><strong>Shelflife By Company</strong> is mandatory</li>\r\n\r\n	<li><strong>Remarks</strong> are mandatory</li>\r\n\r\n</ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-26 18:43:44', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-4b3c-40f4-85a7-65a90a000005', 188, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'MeetingBranches', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Meeting </strong> is mandatory</li>\r\n\r\n	<li><strong>Branch </strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-0410-4aab-88f4-65a90a000005', 186, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'MaterialListWithShelfLives', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Material </strong> is mandatory</li>\r\n\r\n	<li><strong>Shelflife By Manufacturer</strong> is mandatory</li>\r\n\r\n	<li><strong>Shelflife By Company</strong> is mandatory</li>\r\n\r\n	<li><strong>Remarks</strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-7b1c-4663-b3f7-65a90a000005', 185, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'MasterListOfWorkInstructions', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Title</strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-fed8-4552-ac60-65a90a000005', 184, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'MasterListOfFormats', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Title</strong> is mandatory</li>\r\n\r\n	<li><strong>Document Number</strong> is mandatory</li>\r\n\r\n	<li><strong>Issue Number</strong> is mandatory</li>\r\n\r\n	<li><strong>Revision Date</strong> is mandatory (date format : &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n	<li><strong>Prepared By</strong> is mandatory</li>\r\n\r\n	<li><strong>Approved By</strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-39e0-479e-9d2c-65a90a000005', 183, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'MasterListOfFormatDistributors', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Department </strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-c3ec-43a4-bf91-65a90a000005', 182, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'MasterListOfFormatDepartments', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Department </strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-d180-4f3f-841e-65a90a000005', 181, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'MasterListOfFormatBranches', 'add_ajax, edit , approve', '<ul><li><b>Branch </b>  is mandatory <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-1778-4e3b-aa8e-65a90a000005', 180, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'ListOfTrainedInternalAuditors', 'add_ajax, edit, approve', '<ul>\r\n\r\n	<li><strong>Employee </strong> is mandatory</li>\r\n\r\n	<li><strong>Training </strong>is mandatory</li>\r\n\r\n</ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-30 16:34:46', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-9420-47fb-9678-65a90a000005', 179, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'ListOfSoftwares', 'add_ajax, edit , approve', '<ul><li><b>Name</b>  is mandatory</li><li><b>Software Type </b>  is mandatory <br /></li><li><b>Employee </b>  is mandatory <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-872c-4e27-8222-65a90a000005', 177, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'ListOfComputers', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Employee </strong> is mandatory</li>\r\n\r\n	<li><strong>Supplier </strong>is mandatory</li>\r\n\r\n	<li><strong>Purchase Order </strong>is mandatory</li>\r\n\r\n	<li><strong>Make</strong> is mandatory</li>\r\n\r\n	<li><strong>Installation Date</strong> is mandatory (date format is &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n</ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-26 16:47:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-40dc-449f-9d73-65a90a000005', 178, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'ListOfMeasuringDevicesForCalibrations', 'add_ajax, edit , approve', '<ul></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-5b54-47ac-b3c4-65a90a000005', 176, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'ListOfComputerListOfSoftwares', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Computer Name </strong> is mandatory</li>\r\n\r\n	<li><strong>Software Name </strong> is mandatory</li>\r\n\r\n	<li><strong>Installation Date </strong>is mandatory</li>\r\n\r\n</ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-26 17:58:30', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-02dc-426c-8da8-65a90a000005', 174, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Languages', 'add_ajax, edit , approve', '<ul><li><b>Name</b>  is mandatory</li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-5ccc-4cf9-97da-65a90a000005', 175, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'ListOfAcceptableSuppliers', 'add_ajax, edit , approve', '<ul><li><b>Supplier Registration </b>  is mandatory <br /></li><li><b>Supplier Category </b>  is mandatory <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-072c-4ed3-988f-65a90a000005', 173, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'InternetUsageDetails', 'add_ajax, edit , approve', '<ul><li><b>Internet Provider Name</b>  is mandatory <br /></li><li><b>Plan Details</b>  is mandatory</li><li><b>From Date</b>  is mandatory (date format is ''YYYY-MM-DD'') <br /></li><li><b>To Date</b>  is mandatory (date format is ''YYYY-MM-DD'') <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-04bc-46d9-851a-65a90a000005', 172, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'InternalAudits', 'add_ajax, edit, approve', '<ul>\r\n\r\n	<li><strong>Internal Audit Plan Department </strong> is mandatory</li>\r\n\r\n	<li><strong>Department </strong> is mandatory</li>\r\n\r\n	<li><strong>Auditor </strong>is mandatory</li>\r\n\r\n	<li><strong>Auditee </strong>is mandatory</li>\r\n\r\n	<li><strong>Start Time </strong>is mandatory</li>\r\n\r\n	<li><strong>End Time </strong>is mandatory</li>\r\n\r\n	<li><strong>Clauses</strong> are mandatory</li>\r\n\r\n	<li><strong>Section</strong> is mandatory</li>\r\n\r\n	<li><strong>Question Asked</strong> is mandatory</li>\r\n\r\n	<li><strong>Finding</strong> is mandatory</li>\r\n\r\n	<li><strong>Notes</strong> are mandatory</li>\r\n\r\n</ul>\r\n\r\n\r\n\r\n<p>If &#39;<strong>Any Non Conformity Found?</strong>&#39; is selected, following fields are mandatory:</p>\r\n\r\n\r\n\r\n<ul>\r\n\r\n	<li><strong>CAPA Source</strong></li>\r\n\r\n	<li><strong>Assigned To</strong></li>\r\n\r\n	<li><strong>Target Date</strong> (date format is &#39;YYYY-MM-DD&#39;)<br />\r\n\r\n	&nbsp;</li>\r\n\r\n</ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-10-01 13:23:51', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-bd78-4831-b057-65a90a000005', 171, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'InternalAuditPlans', 'add_ajax, edit , approve', '<ul><li><b>Title</b>  is mandatory</li><li><b>List Of Trained Internal Auditor </b>  is mandatory <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-eaf8-4a89-ae7e-65a90a000005', 170, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'InternalAuditPlanDepartments', 'add_ajax, edit, approve', '<ul>\r\n\r\n	<li><strong>Branch</strong> is mandatory</li>\r\n\r\n	<li><strong>Department</strong> is mandatory</li>\r\n\r\n	<li><strong>StartTime</strong> is mandatory (date format is &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n	<li><strong>EndTime</strong> is mandatory (date format is &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n	<li><strong>Internal Audit Plan </strong> is mandatory</li>\r\n\r\n</ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-10-01 13:07:45', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0');
INSERT INTO `helps` (`id`, `sr_no`, `language_id`, `title`, `table_name`, `action_name`, `help_text`, `sequence`, `publish`, `record_status`, `status_user_id`, `soft_delete`, `branchid`, `departmentid`, `created_by`, `created`, `modified_by`, `approved_by`, `prepared_by`, `modified`, `system_table_id`, `master_list_of_format_id`) VALUES
('52ab0722-f744-41aa-b17a-65a90a000005', 169, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'InternalAuditPlanBranches', 'add_ajax, edit , approve', '<ul><li><b>Internal Audit Plan </b>  is mandatory <br /></li><li><b>Branch </b>  is mandatory <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-ef14-457d-b9ee-65a90a000005', 168, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'InternalAuditDetails', 'add_ajax, edit , approve', '<ul><li><b>Internal Audit </b>  is mandatory <br /></li><li><b>Question</b>  is mandatory</li><li><b>Findings</b>  is mandatory</li><li><b>Clause Number</b>  is mandatory</li><li><b>Current Status</b>  is mandatory</li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-90d8-473a-b58e-65a90a000005', 167, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Housekeepings', 'add_ajax, edit , approve', '<ul></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-0a3c-4e7c-b11c-65a90a000005', 166, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'HousekeepingResponsibilities', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Housekeeping Checklist </strong>is mandatory</li>\r\n\r\n	<li><strong>Employee</strong> is mandatory</li>\r\n\r\n	<li><strong>Schedule </strong> is mandatory</li>\r\n\r\n</ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-25 13:28:29', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-ad50-471a-b02f-65a90a000005', 165, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'HousekeepingChecklists', 'add_ajax, edit , approve', '<ul><li><b>Title</b>  is mandatory</li><li><b>Branch </b>  is mandatory <br /></li><li><b>Department </b>  is mandatory <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-e874-45ee-b1c7-65a90a000005', 164, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Histories', 'add_ajax, edit , approve', '<ul></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-7e20-4e1d-8a27-65a90a000005', 163, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Helps', 'add_ajax, edit , approve', '<ul><li><b>Language </b>  is mandatory <br /></li><li><b>Title</b>  is mandatory</li><li><b>Table Name</b>  is mandatory</li><li><b>Action Name</b>  is mandatory</li><li><b>Help Text</b>  is mandatory</li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-f3e8-44d3-99e1-65a90a000005', 162, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'FireTypes', 'add_ajax, edit , approve', '<ul><li><b>Name</b>  is mandatory</li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-bf30-4f92-b798-65a90a000005', 161, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'FireSafetyEquipmentLists', 'add_ajax, edit , approve', '<ul><li><b>Fire Extinguisher </b>  is mandatory <br /></li><li><b>Fire Type </b>  is mandatory <br /></li><li><b>Branch </b>  is mandatory <br /></li><li><b>Department </b>  is mandatory <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-2960-4499-945c-65a90a000005', 160, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'FireExtinguishers', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Name</strong> is mandatory</li>\r\n\r\n	<li><strong>Fire Extinguisher Type </strong> is mandatory</li>\r\n\r\n	<li><strong>Company Name</strong> is mandatory</li>\r\n\r\n	<li><strong>Purchase Date</strong> is mandatory (date format is &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n	<li><strong>Expiery Date</strong> is mandatory (date format is &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n	<li><strong>Warrenty Expiry Date</strong> is mandatory (date format is &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n	<li><strong>Model Type</strong> is mandatory</li>\r\n\r\n</ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-24 17:14:30', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-5270-4e3c-8086-65a90a000005', 159, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'FireExtinguisherTypes', 'add_ajax, edit , approve', '<ul><li><b>Name</b>  is mandatory</li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-e174-4233-a2f9-65a90a000005', 158, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'FileUploads', 'add_ajax, edit , approve', '<ul><li><b>File Details</b>  is mandatory</li><li><b>User </b>  is mandatory <br /></li><li><b>File Type</b>  is mandatory</li><li><b>File Status</b>  is mandatory</li><li><b>Result</b>  is mandatory</li><li><b>User Session </b>  is mandatory <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-1e0c-4ee6-bfb6-65a90a000005', 157, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Evidences', 'add_ajax, edit , approve', '<ul><li><b>File Upload </b>  is mandatory <br /></li><li><b>Model Name</b>  is mandatory <br /></li><li><b>Record</b>  is mandatory <br /></li><li><b>User Session </b>  is mandatory <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-0a6c-4651-99cd-65a90a000005', 156, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Employees', 'add_ajax, edit, approve', '<ul>\r\n\r\n	<li><strong>Name</strong> is mandatory</li>\r\n\r\n	<li><strong>Employee Number</strong> is mandatory</li>\r\n\r\n	<li><strong>Branch</strong> is mandatory</li>\r\n\r\n	<li><strong>Designation </strong> is mandatory</li>\r\n\r\n	<li><strong>Office Email </strong>is mandatory</li>\r\n\r\n	<li><strong>Employment Status</strong> is mandatory</li>\r\n\r\n</ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-10-01 11:36:51', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-e7bc-4275-b6c5-65a90a000005', 155, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'EmployeeTrainings', 'add_ajax, edit , approve', '<ul><li><b>Employee </b>  is mandatory <br /></li><li><b>Training </b>  is mandatory <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-b02c-485e-b820-65a90a000005', 154, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'EmployeeInductionTrainings', 'add_ajax, edit , approve', '<ul><li><b>Employee </b>  is mandatory <br /></li><li><b>Training </b>  is mandatory <br /></li><li><b>Responsibility</b>  is mandatory</li><li><b>Remarks</b>  is mandatory</li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-d518-430f-bbb3-65a90a000005', 152, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'DocumentAmendmentRecordSheets', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li>Selecting an <strong>Request From</strong> option is mandatory</li>\r\n\r\n	<li>Based on your &#39;Request From&#39; selection, a corresponding field appears which is mandatory e.g. If &#39;Request From&#39; is a &#39;Customer&#39;, then a &#39;Customer&#39; drop-down list appears. Similarly, selecting either of Branch/ Department/ Employee/ Suggestion will show a respective field.</li>\r\n\r\n	<li><strong>Branch</strong> is mandatory</li>\r\n\r\n	<li><strong>Master List Of Format</strong> is mandatory</li>\r\n\r\n	<li><strong>Amendment Details</strong> is mandatory</li>\r\n\r\n	<li><strong>Reason For Change</strong> is mandatory</li>\r\n\r\n</ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-30 16:01:35', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-24c4-4d8c-bf4b-65a90a000005', 153, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'EmployeeDesignations', 'add_ajax, edit , approve', '<ul><li><b>Employee </b>  is mandatory <br /></li><li><b>Designation </b>  is mandatory <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-6f9c-47c4-b0dc-65a90a000005', 151, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Devices', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Number</strong> is mandatory</li>\r\n\r\n	<li><strong>Serial</strong> is mandatory</li>\r\n\r\n	<li><strong>Description</strong> is mandatory</li>\r\n\r\n	<li><strong>Person Responsible for Maintenance</strong><strong> </strong> is mandatory<br />\r\n\r\n	<em>(if &#39;Maintenance Required&#39;/&nbsp;&#39;Calibration Required&#39; is set to &#39;Yes&#39;)</em></li>\r\n\r\n	<li><strong>Make Type</strong> is mandatory</li>\r\n\r\n	<li><strong>Purchase Date</strong> is mandatory (date format is &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n	<li><strong>Manual</strong> is mandatory</li>\r\n\r\n	<li><strong>Sparelist</strong> is mandatory</li>\r\n\r\n	<li><strong>Calibration Required</strong> is mandatory</li>\r\n\r\n</ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-30 12:11:44', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-f698-41fa-86a2-65a90a000005', 150, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Designations', 'add_ajax, edit , approve', '<ul><li><b>Name</b>  is mandatory</li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-b1e8-4ea9-a214-65a90a000005', 148, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'DepartmentBenchmarks', 'add_ajax, edit , approve', '<ul><li><b>Department </b>  is mandatory <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-946c-484d-819b-65a90a000005', 149, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Departments', 'add_ajax, edit , approve', '<ul><li><b>Name</b>  is mandatory</li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-813c-4c6a-8384-65a90a000005', 147, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'DeliveryChallans', 'add_ajax, edit , approve', '<ul><li><b>Type</b>  is mandatory</li><li><b>Purchase Order </b>  is mandatory <br /></li><li><b>Challan Number</b>  is mandatory</li><li><b>Challan Date</b>  is mandatory (date format is ''YYYY-MM-DD'') <br /></li><li><b>Challan Details</b>  is mandatory</li><li><b>Prices</b>  is mandatory</li><li><b>Ship By</b>  is mandatory</li><li><b>Shipping Details</b>  is mandatory</li><li><b>Insurance</b>  is mandatory</li><li><b>Shipping Date</b>  is mandatory (date format is ''YYYY-MM-DD'') <br /></li><li><b>Ship To</b>  is mandatory</li><li><b>Payment Details</b>  is mandatory</li><li><b>Invoice To</b>  is mandatory</li><li><b>Acknowledgement Details</b>  is mandatory</li><li><b>Acknowledgement Date</b>  is mandatory (date format is ''YYYY-MM-DD'') <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-39d4-463a-b97e-65a90a000005', 146, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'DatabackupLogbooks', 'add_ajax, edit , approve', '<ul><li><b>Employee </b>  is mandatory <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-1fac-4729-b464-65a90a000005', 145, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'DataTypes', 'add_ajax, edit , approve', '<ul><li><b>Name</b>  is mandatory</li><li><b>Details</b>  is mandatory</li><li><b>User </b>  is mandatory <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-cda8-4613-8134-65a90a000005', 144, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'DataBackUps', 'add_ajax, edit , approve', '<ul><li><b>Data Type </b>  is mandatory <br /></li><li><b>Branch </b>  is mandatory <br /></li><li><b>Schedule </b>  is mandatory <br /></li><li><b>User </b>  is mandatory <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-c4f8-48c5-8f7e-65a90a000005', 143, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'DailyBackupDetails', 'add_ajax, edit , approve', '<ul></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-9e98-4f13-bc6e-65a90a000005', 142, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Customers', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Customer Type</strong> is mandatory</li>\r\n\r\n	<li><strong>Name</strong> is mandatory</li>\r\n\r\n	<li><strong>Customer Since Date</strong> is mandatory<br />\r\n\r\n	(date format is &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n	<li><strong>Customer Code</strong> is mandatory</li>\r\n\r\n	<li><strong>Email</strong> is mandatory</li>\r\n\r\n	<li><strong>Phone</strong> is mandatory</li>\r\n\r\n	<li><strong>Mobile</strong> is mandatory</li>\r\n\r\n	<li><strong>Branch</strong> is mandatory</li>\r\n\r\n</ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '53c508ca-5870-4ded-8f3c-3e5d118438bd', '2014-09-30 13:14:08', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-8a28-44e9-91ce-65a90a000005', 139, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'CustomerComplaints', 'add_ajax, edit , approve', '<ul><li><b>Customer </b>  is mandatory <br /></li><li><b>Complaint Number</b>  is mandatory</li><li><b>Complaint Date</b>  is mandatory (date format is ''YYYY-MM-DD'') <br /></li><li><b>Target Date</b>  is mandatory (date format is ''YYYY-MM-DD'') <br /></li><li><b>Details</b>  is mandatory</li><li><b>Employee </b>  is mandatory <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-02b8-4b2e-9e67-65a90a000005', 140, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'CustomerFeedbackQuestions', 'add_ajax, edit , approve', '<ul><li><b>Title</b>  is mandatory</li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-d110-47d5-b37b-65a90a000005', 141, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'CustomerFeedbacks', 'add_ajax, edit , approve', '<ul><li><b>Customer </b>  is mandatory <br /></li><li><b>Customer Feedback Question </b>  is mandatory <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-05c8-473b-afcc-65a90a000005', 138, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'CustomTemplates', 'add_ajax, edit , approve', '<ul><li><b>Name</b>  is mandatory</li><li><b>Details</b>  is mandatory</li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-f8a8-49f2-8fa1-65a90a000005', 137, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Courses', 'add_ajax, edit , approve', '<ul><li><b>Title</b>  is mandatory</li><li><b>Course Type </b>  is mandatory <br /></li><li><b>Description</b>  is mandatory</li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-d840-4d01-a015-65a90a000005', 136, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'CourseTypes', 'add_ajax, edit , approve', '<ul><li><b>Title</b>  is mandatory</li><li><b>Description</b>  is mandatory</li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-1238-4c20-97f9-65a90a000005', 135, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'CourierRegisters', 'add_ajax, edit , approve', '<ul></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-45b0-4a51-a6cd-65a90a000005', 134, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'CorrectivePreventiveActions', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Action</strong> is mandatory</li>\r\n\r\n	<li><strong>Name</strong> is mandatory</li>\r\n\r\n	<li><strong>Capa Source </strong> is mandatory</li>\r\n\r\n	<li><strong>Capa Category </strong> is mandatory</li>\r\n\r\n	<li><strong>Assigned To </strong>is mandatory</li>\r\n\r\n	<li><strong>Target Date</strong> is mandatory (date format is &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n</ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-30 18:15:40', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-81e4-4062-8f2a-65a90a000005', 132, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'CompanyBenchmarks', 'add_ajax, edit , approve', '<ul></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-9880-4bb9-a6be-65a90a000005', 133, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'CompetencyMappings', 'add_ajax, edit , approve', '<ul><li><b>Employee </b>  is mandatory <br /></li><li><b>Education </b>  is mandatory <br /></li><li><b>Experience Required</b>  is mandatory</li><li><b>Actual Education</b>  is mandatory <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-5268-41dd-907a-65a90a000005', 131, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Companies', 'add_ajax, edit , approve', '<ul><li><b>Name</b>  is mandatory</li><li><b>Description</b>  is mandatory</li><li><b>Flinkiso Start Date</b>  is mandatory (date format is ''YYYY-MM-DD'') <br /></li><li><b>Flinkiso End Date</b>  is mandatory (date format is ''YYYY-MM-DD'') <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-3c94-48a1-a1c6-65a90a000005', 130, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'ChangeAdditionDeletionRequests', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Request From</strong> is mandatory</li>\r\n\r\n	<li>Based on <strong>&#39;Request From&#39;</strong> selection, a corresponding field appears which is mandatory.<br />\r\n\r\n	e.g. if you select &#39;Employee&#39; as an option, an &#39;Employee&#39; drop-down box appears. Selecting an employee is mandatory in this case.</li>\r\n\r\n	<li><strong>Master List Of Format</strong> is mandatory</li>\r\n\r\n	<li><strong>Current Document Details</strong> is mandatory</li>\r\n\r\n	<li><strong>Proposed Changes</strong> is mandatory</li>\r\n\r\n	<li><strong>Reason For Change</strong> is mandatory</li>\r\n\r\n</ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-10-01 12:26:25', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0722-21b8-44ea-b88d-65a90a000005', 128, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'CapaCategories', 'add_ajax, edit , approve', '<ul><li><b>Name</b>  is mandatory</li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-17cc-48a9-895a-65a90a000005', 129, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'CapaSources', 'add_ajax, edit , approve', '<ul><li><b>Name</b>  is mandatory</li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-43a0-4998-9277-65a90a000005', 126, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Branches', 'add_ajax, edit , approve', '<ul><li><b>Name</b>  is mandatory</li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-c678-49e6-b252-65a90a000005', 127, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Calibrations', 'add_ajax, edit , approve', '<ul><li><b>Device </b>  is mandatory <br /></li><li><b>Calibration Date</b>  is mandatory (date format is ''YYYY-MM-DD'') <br /></li><li><b>Standard Value</b>  is mandatory</li><li><b>Actual Value</b>  is mandatory</li><li><b>Next Calibration Date</b>  is mandatory (date format is ''YYYY-MM-DD'') <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-ac9c-4050-ba8e-65a90a000005', 125, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'BranchBenchmarks', 'add_ajax, edit , approve', '<ul><li><b>Branch </b>  is mandatory <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-3794-4241-a532-65a90a000005', 124, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Benchmarks', 'add_ajax, edit , approve', '<ul><li><b></b>  is mandatory <br /></li><li><b>Branch </b>  is mandatory <br /></li><li><b>Branch Id</b>  is mandatory</li><li><b>Department </b>  is mandatory <br /></li><li><b>Department Id</b>  is mandatory</li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52ab0722-fc9c-48d5-8394-65a90a000005', 123, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Approvals', 'add_ajax, edit , approve', '<ul><li><b>Model Name</b>  is mandatory</li><li><b>Controller Name</b>  is mandatory</li><li><b>Record</b>  is mandatory <br /></li><li><b>From</b>  is mandatory <br /></li><li><b>User </b>  is mandatory <br /></li></ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '0', '0'),
('52a71f92-7eb8-4d55-8d5a-38a0c6c3268c', 121, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding & Assigning Tasks ', 'Tasks', 'add_ajax, edit , approve', '<p>As per the standard requirement, your organization must have assigned various roles and responsibilities to various employees. In order to check the completion of these tasks as per the schedule, you can assign tasks to specific employees (who is also a FlinkISO user) and track the work progress. You add the tasks name (title or identifier), select the user, (make sure that the user is mapped with the correct employee), choose the related document from Master List Of Formats drop-down, select the schedule and Submit.</p>\r\n\r\n', 2, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52a72034-dda0-47bb-bac8-3a03c6c3268c', 122, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Follow Up', 'Tasks', 'add_ajax, edit , approve', '<p>Once the task is assigned to the respective user, that particular user, as per the schedule defined will be able to view those tasks on his/her dashboard . The User can then update status of those tasks based on the work completion. FlinkISO will automatically generate the tasks completion report for you under the Reports section.</p>', 3, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-10-01 14:36:57', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-eea0-4277-b2a2-65a90a000005', 224, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'TrainingSchedules', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Schedule Date From</strong> is&nbsp;mandatory (date format : &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n	<li><strong>Schedule Date To</strong> is mandatory (date format : &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-352c-4e05-ba7c-65a90a000005', 225, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'TrainingTypes', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Title</strong> is mandatory</li>\r\n\r\n	<li><strong>Training Description</strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-a348-4cff-ada3-65a90a000005', 226, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Trainings', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Description</strong> is mandatory</li>\r\n\r\n	<li><strong>Course </strong> is mandatory</li>\r\n\r\n	<li><strong>Trainer </strong> is mandatory</li>\r\n\r\n	<li><strong>Trainer Type </strong> is mandatory</li>\r\n\r\n	<li><strong>Training Type </strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-7cfc-4686-b2d4-65a90a000005', 227, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'UserSessions', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Ip Address</strong> is mandatory</li>\r\n\r\n	<li><strong>User </strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-f0d8-4202-83e2-65a90a000005', 228, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'UsernamePasswordDetails', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Computer Name </strong> is mandatory</li>\r\n\r\n	<li><strong>Employee </strong>is mandatory</li>\r\n\r\n	<li><strong>Username</strong> is mandatory</li>\r\n\r\n	<li><strong>Password</strong> is mandatory</li>\r\n\r\n	<li><strong>Date Of Change</strong> is mandatory (date format :&nbsp; &#39;YYYY-MM-DD&#39;)</li>\r\n\r\n</ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-26 18:20:47', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ab0723-bb5c-47ff-82ad-65a90a000005', 229, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'Users', 'add_ajax, edit , approve', '<ul>\r\n\r\n	<li><strong>Employee </strong> is mandatory</li>\r\n\r\n	<li><strong>Language </strong>is mandatory</li>\r\n\r\n	<li><strong>Username</strong> is mandatory</li>\r\n\r\n	<li><strong>Password</strong> is mandatory</li>\r\n\r\n	<li><strong>Department </strong> is mandatory</li>\r\n\r\n	<li><strong>Branch </strong> is mandatory</li>\r\n\r\n</ul>', 0, 1, 0, NULL, 0, '', '', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '53c508ca-5870-4ded-8f3c-3e5d118438bd', '2014-09-26 15:36:32', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52ad6826-0c64-4cf7-83aa-73fc0a000005', 230, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Step - 3 : Additional Agendas', 'Meetings', 'add_ajax, edit, approve', '<p style="text-align:start">Based on the data stored under&nbsp;</p>\r\n\r\n\r\n\r\n<ol>\r\n\r\n	<li>Document Change Amendment Requests</li>\r\n\r\n	<li>Customer Complaints</li>\r\n\r\n	<li>Non Conformities</li>\r\n\r\n	<li>Supplier Evaluations</li>\r\n\r\n</ol>\r\n\r\n\r\n\r\n<p style="text-align:start">FlinkISO will generate a report for that particular month and for records which are not resolved. You can select those records from the panel&nbsp;and&nbsp;those selected records will be added as &#39;Meeting Agendas&#39; during the MRM.</p>', 4, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-30 16:32:14', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '0'),
('52d9274d-1ca0-4f17-8dac-2feec6c3268c', 231, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding New User', 'users', 'add_ajax, edit , approve', '<p>Adding a new user is one of the first steps towards using FlinkISO. While adding a new user remember the following :</p>\r\n\r\n\r\n\r\n<ul>\r\n\r\n	<li>You should have added Employees before you add new users.</li>\r\n\r\n	<li>You can link users with employees.</li>\r\n\r\n	<li>You can link mutliple users to single employee.</li>\r\n\r\n	<li>e.g. If you have an employee called &quot;Xyz&quot;, you can create as many users e.g. &quot;abc&quot;, &quot;gfh&quot; etc and link those with &quot;Xyz&quot; as &quot;Employee&quot;.</li>\r\n\r\n	<li>You can also select the prefered language while adding a new user. This will be set as his/her default language.</li>\r\n\r\n	<li>Each user will belong to a single department in a specific branch.</li>\r\n\r\n	<li>You can also add Benchmark while adding a new user.</li>\r\n\r\n	<li>Benchmark is the tentative data/ records expected from the user on daily basis.</li>\r\n\r\n</ul>', 2, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', NULL, NULL, '2014-09-22 14:46:39', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52d927f5-09b4-465a-997f-30f7c6c3268c', 232, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'New MR User', 'users', 'add_ajax, edit , approve', '<p>MR User is a User with SuperUser privileges and will have complete access to FlinkISO.</p>\r\n\r\n\r\n\r\n<ul>\r\n\r\n	<li>MR user can create other users and also if need be multiple MR users.</li>\r\n\r\n	<li>MR user can grant / revoke permissions of other users</li>\r\n\r\n	<li>MR user can view/edit/delete records from all the users from all the branches &amp; departments.</li>\r\n\r\n	<li>MR user can set / change benchmarks.</li>\r\n\r\n	<li>MR user will have access to all the reports.</li>\r\n\r\n</ul>', 3, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', NULL, NULL, '2014-09-22 14:48:59', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52d92861-adfc-4df7-9e07-30f7c6c3268c', 233, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'User who can see other users'' records', 'users', 'add_ajax, edit , approve', '<p>If you would like to create a user who does not have MR access but can view records added by other users in his/her department, just checkmark &quot;<strong>User who can see other users&#39; records&quot;. </strong>This user will then be able to view/ edit/ delete records entered by other users in that department &amp; branch.</p>', 4, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', NULL, NULL, '2014-09-22 14:52:17', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52d928fc-6df4-4bbc-93cd-3054c6c3268c', 234, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'User who can approve data added by other users', 'users', 'add_ajax, edit , approve', '<p><strong>&quot;Any User who can approve data added by other users</strong>&quot; is termed as an Approver. FlinkISO as required by ISO standards follows the&nbsp; &#39;Approval System&#39;, wherein records/ data added by any user can go through a strict approval system and mitigates the risk of your QMS from storing unwanted records. Any user can add new records, however before publishing it, he/she will have to send the record to an Approval authority. Once the record is approved, it gets published.</p>', 5, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', NULL, NULL, '2014-09-22 14:57:23', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52d9291a-f75c-4853-ac64-3044c6c3268c', 235, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Copy permission from available user', 'users', 'add_ajax, edit , approve', '<p><span style="background-color:rgb(255, 255, 255); color:rgb(51, 51, 51); font-size:12px">Each user created has permissions to access the FlinkISO with specified limitations. You will need to exclusively provide access to each user based on his/her role. </span><br />\r\n\r\n<span style="background-color:rgb(255, 255, 255); color:rgb(51, 51, 51); font-size:12px">To provide access to a User with identical access rights as of an already created User, simply select that user from the drop-down and the new access rights of the selected User will be replicated for the new User.</span><br />\r\n\r\n<span style="background-color:rgb(255, 255, 255); color:rgb(51, 51, 51); font-size:12px">If needed you can at a later time either assign more access or limit the new user by manually changing the access. </span><br />\r\n\r\n<span style="background-color:rgb(255, 255, 255); color:rgb(51, 51, 51); font-size:12px">You can also manually add user access from Users/View page by clicking </span><strong>Manage Access Control</strong><span style="background-color:rgb(255, 255, 255); color:rgb(51, 51, 51); font-size:12px">.</span></p>', 6, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '53c508ca-5870-4ded-8f3c-3e5d118438bd', '2014-09-26 15:46:41', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52d929e1-cf04-4346-9d93-2e3dc6c3268c', 236, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding New Employee', 'employees', 'add_ajax, edit , approve', '<p>You should have at least one employee added to FlinkISO. You can have a single employee linked with multiple users. You can also bulk import employees via &#39;Import / Export&#39; utility. To learn more about &#39;Import / Export&#39; please visit HELP.</p>', 2, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '53c508ca-5870-4ded-8f3c-3e5d118438bd', '2014-09-30 11:30:21', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52d92d36-962c-4378-bbaa-3135c6c3268c', 237, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding new device', 'devices', 'add_ajax, edit , approve', '<p>There are 2 types of devices</p>\r\n\r\n\r\n\r\n<ol>\r\n\r\n	<li>Devices which requires calibration</li>\r\n\r\n	<li>Devices which does not require calibration</li>\r\n\r\n</ol>\r\n\r\n\r\n\r\n<p>If device calibration is required select &#39;Yes&#39; from &#39;Calibration Required&#39; drop-down list. Upon submission of this form, a new device will be automatically added to &#39;List of Devices For Calibration&#39; table.</p>\r\n\r\n\r\n\r\n<p>A FlinkISO User who is selected as &#39;<strong>Person Responsible for Maintenance&#39; </strong>will get alerts for scheduled calibrations.</p>', 1, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-30 11:45:57', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52d930b3-4e18-4c20-8714-2fdbc6c3268c', 238, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'HR Department', 'dashboards', 'hr', '<p>HR is one of the most important function of any organization and plays a critical role in your QMS process. With FlinkISO you can maintain most of your HR activities which are mandatory for ISO compliance viz :</p>\r\n\r\n\r\n\r\n<ul>\r\n\r\n	<li>Creating Employee Master</li>\r\n\r\n	<li>Adding / Updating Training</li>\r\n\r\n	<li>Adding / Updating TNI (Training Needs Identification)</li>\r\n\r\n	<li>Keeping track of Trainings Conducted</li>\r\n\r\n	<li>Training Evaluation</li>\r\n\r\n	<li>Competency Mapping</li>\r\n\r\n</ul>', 1, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-23 11:49:32', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52d932e1-a674-4874-a9e8-2e3dc6c3268c', 239, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Couses & Trainings', 'courses', 'add_ajax, edit , approve', '<p>You can add as many courses as you want based on your organizational HR requirement.</p>\r\n\r\n\r\n\r\n<p>You can create &quot;Course Types&quot; (course categories) and add courses under types. e.g :</p>\r\n\r\n\r\n\r\n<ul>\r\n\r\n	<li>HR Courses / MR Courses / Technical Courses / Induction Training Courses etc.</li>\r\n\r\n</ul>\r\n\r\n\r\n\r\n<p>You can also add a breif descrption about each course and also upload the course / training related documents / material under each course for employees to download &amp; refer.</p>\r\n\r\n', 1, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52d93a63-e188-482d-be15-31b7c6c3268c', 240, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'What is Trainer Type?', 'trainerTypes', 'add_ajax, edit , approve', '<p>While creating a new trainer, you can categorize each trainer as per types viz:</p>\r\n\r\n\r\n\r\n<ul>\r\n\r\n	<li>HR Trainer</li>\r\n\r\n	<li>Technical Trainer</li>\r\n\r\n	<li>External Trainer</li>\r\n\r\n	<li>Internal Trainer</li>\r\n\r\n</ul>', 1, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-23 15:23:41', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52d93ae8-ef0c-49e5-9bce-31b8c6c3268c', 241, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding New Trainer', 'trainers', 'add_ajax, edit , approve', '<p>You should have added Trainers for each course / training you created. Adding trainer is simple &amp; easy. You just need to create Trainer Type e.g</p>\r\n\r\n\r\n\r\n<ul>\r\n\r\n	<li>HR Trainer</li>\r\n\r\n	<li>Technical Trainer</li>\r\n\r\n	<li>External Trainer</li>\r\n\r\n	<li>Internal Trainer</li>\r\n\r\n</ul>\r\n\r\n\r\n\r\n<p>And then add the trainer&#39;s pertinent information like Name / Company etc and save the form. Newly added trainer will then be available in a drop down list while adding Trainings Conducted.</p>\r\n\r\n', 2, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52d93bcf-e174-4e59-b1f8-31c4c6c3268c', 242, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'TNI (Training Need Identification)', 'trainingNeedIdentifications', 'add_ajax, edit , approve', '<p>Training Needs Identification is a mandatory record as per the standard. You will have to access TNI for each emplyoyee and maintain the training records for each emoloyee.</p>\r\n\r\n\r\n\r\n<p>Under this section, you can select the employee and course/trainings which he/she might require for skill upgradation. A training schedule can be predefined if the training is required periodically.</p>\r\n\r\n', 1, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52d93d95-a194-4c46-9478-3234c6c3268c', 243, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'How to check if TNI is fullfilled?', 'trainingNeedIdentifications', 'add_ajax, edit , approve', '<p>After creating a TNI record, go to &quot;View / Upload Evidence&quot; link. On that page you will find a list of Trainings that a particular employee has undergone. In the list, if a training, which is required under &quot;TNI&quot;, is already conducted, then that records will be highlighted in green.</p>', 3, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '53c508ca-5870-4ded-8f3c-3e5d118438bd', '2014-09-23 16:52:03', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52d93ec9-b520-4916-87d9-2e3dc6c3268c', 244, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding New Training', 'trainings', 'add_ajax, edit , approve', '<p>As part of maintaining Training Needs Identification records, you will be required to maintain &#39;Training Records&#39; your employees would undergo. You can add such trainings along with it&#39;s documentation &amp; training material from this form.</p>\r\n\r\n\r\n\r\n<p>This form is to be filled out &#39;AFTER&#39; employees have finished their training and not before.</p>\r\n\r\n\r\n\r\n<p>To add a Training record, select a &#39;Course&#39; for the training employee has undergone e.g. &#39;Employee Induction&#39; from Course drop-down. Add a suitable training title e.g. &#39;Induction Training for employees on 1st Jan 2014&#39;. Add training description in &#39;Training Details&#39;, select persons from Attendees drop-down list. Add Start-End time and other training details and save the record.</p>\r\n\r\n\r\n\r\n<p>Once the record is saved, you can add related documents from &#39;View / Upload&#39; Evidence form.</p>', 1, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '53c508ca-5870-4ded-8f3c-3e5d118438bd', '2014-09-23 17:11:01', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52d93f6d-a9fc-4493-b670-3218c6c3268c', 245, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Admin Dashboard', 'dashboards', 'personal_admin', '<p><strong>Fire Extinguisher :</strong><br />\r\n\r\nOne of the mandatory records your organization will have to maintain as per the ISO standards. For your ease, we have already created &quot;Fire Extingusher Types&quot;. You will just need to further add the equipment details and save the record. You can also add images of the equipment after saving the record.</p>\r\n\r\n\r\n\r\n<p><strong>Check List For Housekeeping:</strong>&nbsp;&nbsp;</p>\r\n\r\n\r\n\r\n<p>Maintaining housekeeping checklist is one of the mandatory records. With help of FlinkISO you can create a housekeeping checklist and once the checklist is ready, you can assign checklist tasks to Users from &#39;<strong>Housekeeping Responsibilities</strong>&#39; and keep track of the compliance.</p>\r\n\r\n\r\n\r\n<p>If you assign &#39;Housekeeping Responsibility&#39; to a particular User, he/ she will have to login to the system and update the responsibilty status based on schedule. MR users&nbsp;on behalf of any other user, can also update the status.</p>', 1, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-25 12:29:38', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52d9438c-1e08-4df9-a3ae-325bc6c3268c', 246, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Responsibilities Assigned To You', 'dashboards', 'personal_admin', '<p>Housekeeping Checklists can be assigned to a particular FlinkISO Users through &#39;Housekeeping Responsibilties&#39;. These tasks are based on predefined schedule and assigned Users are expected to perform these tasks as per schedule.</p>\r\n\r\n\r\n\r\n<p>To track if the Users are performing their assigned tasks the MR / Administrator can click &#39;View All&#39; link at the right hand corner of the panel. Following &#39;View All&#39; link You can check status of all tasks. You can also check status of tasks that are assigned to a particular User, you can narrow your search by selecting From-To date selection.</p>\r\n\r\n\r\n\r\n<p>Each task performed will automatically be marked in Green &amp; tasks which are not performed turns Red.</p>', 2, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-25 13:27:41', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52d94c5e-08b8-4667-bf8a-3338c6c3268c', 247, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Quality Control Dashborad', 'dashboards', 'quality_control', '<p>On the Qaulity Control (QC) dashborad you can access the following :</p>\r\n\r\n\r\n\r\n<ul>\r\n\r\n	<li>Customer Complaints</li>\r\n\r\n	<li>Measuring Devices for Calibrations</li>\r\n\r\n	<li>Calibrations</li>\r\n\r\n	<li>Customer Feedbacks</li>\r\n\r\n	<li>Add QC for Material</li>\r\n\r\n	<li>Add Device Preventive Maintenance</li>\r\n\r\n</ul>', 1, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-10-01 15:25:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '');
INSERT INTO `helps` (`id`, `sr_no`, `language_id`, `title`, `table_name`, `action_name`, `help_text`, `sequence`, `publish`, `record_status`, `status_user_id`, `soft_delete`, `branchid`, `departmentid`, `created_by`, `created`, `modified_by`, `approved_by`, `prepared_by`, `modified`, `system_table_id`, `master_list_of_format_id`) VALUES
('52d94e52-c420-4eb6-a6e5-3219c6c3268c', 248, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Customer Complaints', 'dashboards', 'quality_control', '<p>Customer Complaints are critical for any organisation and needs immediate attention. Post performing the &#39;Root Cause Analysis&#39; of the customer complaint, a Corrective and Preventive Action plan needs to be deviced, this is an integral part of maintaining quality.</p>\r\n\r\n\r\n\r\n<p>To add customer complaints you should have added &#39;Customers&#39;&nbsp; &amp; &#39;Products&#39;.</p>\r\n\r\n\r\n\r\n<p>Once you have the customers&#39; list ready, you can add customer complaints.</p>\r\n\r\n\r\n\r\n<p>To add a new complaint, select customer form the drop-down, select Complaint Source, then select relevant (product or challan in case the source is delivery), add new complaint number and date.</p>\r\n\r\n\r\n\r\n<p>You can then assign the customer complaint to any user from &#39;Assigned To&#39; drop down and also select the target date for closure.</p>\r\n\r\n\r\n\r\n<p>Once you select &#39;Assigned to&#39;, &#39;Target Date&#39; and publish the complaint, the User to whom you have assigned the task will get the assigned complaint&#39;s details along with the target date on his/her dashboard on every login. The User is then expected to update the status before the target date.<br />\r\n\r\n&nbsp;</p>', 1, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-25 13:48:07', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52d94f7e-2eb0-4f3b-a359-336bc6c3268c', 249, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding Customer Complaint To MRM', 'dashboards', 'quality_control', '<p>While creating an MRM for a particular month, you will see the list of all customer complaints under &#39;Topics&#39;. You can then select any or all the customer complaints as a Topic under upcoming MRM. Once you select a particular customer complaint for MRM, an alert will be seen near Complaint Details (Added In Meeting).</p>', 3, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-25 13:50:27', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52d9502e-6820-46ba-9360-323ec6c3268c', 250, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding Customer Complaints to CAPA', 'dashboards', 'quality_control', '<p>You can add a Customer Complaint to Corrective Preventing Action table simply by clicking <strong>&#39;Add To CAPA?&#39; </strong>checkbox as Yes and then selecting the CAPA Source from the drop-down list. Once the CAPA is resolved, you can mark the Status as Closed along with the closure Date.</p>\r\n\r\n\r\n\r\n<p>All the Open/Close CAPA reports will be automatically generated by FlinkISO under the &#39;Reports&#39; section.</p>', 4, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-25 13:52:39', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52d95074-2ae4-4d09-bd85-3394c6c3268c', 251, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Measuring Devices for Calibrations', 'dashboards', 'quality_control', '<p>This lists is auto-populated during adding new devices.</p>\r\n\r\n\r\n\r\n<p>If you select &#39;Calibration Required&#39; checkbox, a new device will be automatically added to &#39;List of Devices For Calibration&#39; table.</p>\r\n\r\n\r\n\r\n<p>A FlinkISO user who is selected as the <strong>person responsible for maintenance </strong>will get alerts for the scheduled calibrations.</p>', 6, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-10-01 15:23:22', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52d9510d-76a4-4dbc-9d72-334ac6c3268c', 252, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Calibrations', 'dashboards', 'quality_control', '<p><span style="background-color:rgb(255, 255, 255); color:rgb(51, 51, 51); font-size:12px">List of all the calibrations performed on different devices</span> will be displayed here. Users can select the next calibration date and accordingly they will be prompted to add the details of the performed calibration based on &quot;Next Calibration Date&quot;</p>\r\n\r\n', 7, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52d954a1-159c-440d-b6ac-33a6c6c3268c', 253, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Customer Feedbacks', 'dashboards', 'quality_control', '<p>To add Customer Feedback, you will first need to add &#39;Customers&#39; and &#39;Feedback Questionnaire&#39;. You can directly import both via the &#39;Import Export&#39; utility.&nbsp; Once the Questionnaire is ready, you can add the feedback received from your customer.</p>', 7, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-25 13:55:49', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52e3b5d1-1fb4-4f3f-98df-6e7cc6c3268c', 254, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Assign complaint to an employee', 'customerComplaints', 'add_ajax, edit', '<p>Notes :</p>\n\n<ul>\n	<li>Only MR users can assign Customer Complaints to an employee.</li>\n	<li>To assign customer complaint to any user/ employee, you must have Employee/ User created under &#39;Quality Control&#39; department of that particular branch.</li>\n</ul>', 2, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-10-01 15:01:00', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('52e4aaea-63c0-4467-b458-761dc6c3268c', 255, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'How to evaluate Supplier', 'supplierEvaluationReevaluations', 'evaluate', '<p>To evaluate a supplier, you need to have purchase orders &amp; delivery challans related to&nbsp;that supplier. You also need to add Goods Accepted. Based on these system calculates the % accuracy of the supplier. Depending on the % you can add supplier in different categories.</p>\r\n\r\n\r\n\r\n<p><strong>Supplier Evaluation Report is automatically generated and saved in Report Center. It also automatically creates &amp; update the List Of Acceptabed Suppliers for you.</strong></p>\r\n\r\n', 1, 1, 0, NULL, 0, '529793bb-ebe8-4ebc-bc8f-25900a000005', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', '2014-09-22 08:26:53', '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5322b6ac-2268-46f1-9206-019151f38a45', 256, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Employee Master', 'dashboards', 'hr', '<p>Every organization has to maintain their employee records as per standards. You can add unlimited employees under various branches and departments. Adding employee is simple and straight forward. You can add employees either from the &#39;Add&#39; option or you can import your existing employee master sheet to FlinkISO by using Import/Export functionality.</p>\r\n\r\n\r\n\r\n<p>Once you add the employee, you can add Key Responsibility Areas, Training Need Identifications, Trainings attained, Employee Appraisal information etc. for each employee.</p>', 2, 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530b42fa-b30c-461c-a81c-1a0bb6329416', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-23 18:09:30', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5322b883-5338-4fc2-842b-019151f38a45', 257, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Courses', 'dashboards', 'hr', '<p>As per standards, each employee has to undergo various trainings/ courses to keep up with the changing business dynamics. You can add various courses/ trainings which your organization offers to your employees. These can be divided into several categories like Induction Trainings, HR Trainings, Product Related Trainings etc. Under these categories, you can add various trainings your employees have undergone so far.</p>', 3, 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530b42fa-b30c-461c-a81c-1a0bb6329416', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '53c508ca-5870-4ded-8f3c-3e5d118438bd', '2014-09-23 12:00:31', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5322b9cc-b7d4-4df5-b3d8-019151f38a45', 258, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'TNI', 'dashboards', 'hr', '<p>Once you create required trainings/ courses under unique categories, you can add &#39;Training Need Identifications&#39; (TNI) for each employee. After you create a TNI, employee will have to undergo related training within the speculated schedule. TNI is a mapping between Employee &amp; Training. Each TNI view page consists of Employee Details, TNI Vs actual Trainings Attended. Trainings which are required under TNI will be marked as Green.</p>', 4, 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530b42fa-b30c-461c-a81c-1a0bb6329416', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-23 18:11:55', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5333dd7e-f5f4-4414-ab49-164451f38a45', 259, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Customers', 'dashboards', 'bd', '<p>With customer&#39;s section you can add all your existing customers as well as new customers. You can also import your existing customers from Import-Export utility. Customers are divided into 2 categories :</p>\r\n\r\n\r\n\r\n<ol>\r\n\r\n	<li>Individuals</li>\r\n\r\n	<li>Companies</li>\r\n\r\n</ol>\r\n\r\n\r\n\r\n<p>Once you add your list of customers you can further explore Business Development module.<br />\r\n\r\n&nbsp;</p>', 1, 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530b42fa-b30c-461c-a81c-1a0bb6329416', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', NULL, NULL, '2014-09-22 15:49:46', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5368a25b-32b0-4a6f-8d94-7574b6329416', 260, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'How to create meetings', 'meetings', 'add_ajax, edit', '<p>As per clause 5.6 of ISO 9001 standards, Management Review Meetings (MRM)&nbsp; are conducted at planned intervals to gauge the efficacy of the QMS and look at areas of improvements.&nbsp; To schedule and create a MRM You will need to have active FlinkISO users. Once you enter the meeting title, previous meeting details (if any), branch where meeting would be held, chairperson, you will be prompted to select departments. Once you select the department the list of users pertinent to that department will be auto populated.&nbsp; Once you select the users from the drop-down list, you can proceed to add agenda.</p>\r\n\r\n\r\n\r\n<p>The following agenda will pop-up automatically (which can be changed as per your requirements)</p>\r\n\r\n\r\n\r\n<ul>\r\n\r\n	<li><strong>Follow-up actions from previous management reviews</strong></li>\r\n\r\n	<li><strong>Suitability &amp; effectiveness of QMS, Quality policy &amp; Quality objectives</strong></li>\r\n\r\n	<li><strong>Training &amp; motivational aspects &amp; Resource requirements.</strong></li>\r\n\r\n</ul>\r\n\r\n\r\n\r\n<p>The following records will be automatically displayed for you to choose from.</p>\r\n\r\n\r\n\r\n<ul>\r\n\r\n	<li><strong>Recent Document Change Amendment Requests</strong></li>\r\n\r\n	<li><strong>Recent Customer Complaints</strong></li>\r\n\r\n	<li><strong>Recent Non- Conformities</strong></li>\r\n\r\n	<li><strong>Recent Supplier Evaluations</strong></li>\r\n\r\n</ul>\r\n\r\n\r\n\r\n<p>You can select any of these records, which you would like to discuss in the meeting and then click submit. To display this on the &#39;Timeline&#39;, check &#39;Show on Timeline&#39; checkbox.</p>\r\n\r\n\r\n\r\n<p>If your SMTP is setup &amp; working, emails will be send to all the invitees. All the FlinkISO users will get meeting alerts post their respective logins.</p>\r\n\r\n\r\n\r\n<p>Future upgrades:</p>\r\n\r\n\r\n\r\n<ul>\r\n\r\n	<li>Ability to add Employees with email address</li>\r\n\r\n	<li>Ability to add any person with email address</li>\r\n\r\n</ul>', 0, 1, 0, NULL, 0, '53687891-b810-4f7e-adb9-4456b6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '53687891-7a44-4f79-addf-4456b6329416', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-30 16:15:16', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5368c2e4-7d9c-43d6-a7b7-19edb6329416', 261, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Creating Internal Audit Plan', 'internalAuditPlans', 'plan_add_ajax, edit, lists', '<p>You can dynamically create your Internal Audit Plan in FlinkISO.</p>\r\n\r\n\r\n\r\n<p>First step is to add the following :</p>\r\n\r\n\r\n\r\n<ul>\r\n\r\n	<li><strong>Title - Plan Title (e.g: First Internal Audit etc)</strong></li>\r\n\r\n	<li><strong>Schedule Date From - Schedule Date To</strong></li>\r\n\r\n	<li><strong>Notes (any other information you want to store)</strong></li>\r\n\r\n</ul>\r\n\r\n\r\n\r\n<p>Click Submit.</p>\r\n\r\n\r\n\r\n<p>Upon submit, the page will dynamically update with &quot;Create Plan&quot; panel where you will have to fill the following details :</p>\r\n\r\n\r\n\r\n<ul>\r\n\r\n	<li><strong>Branch - where audit would take place</strong></li>\r\n\r\n	<li><strong>Department - for which audit would take place</strong></li>\r\n\r\n	<li><strong>Clauses - clauses which audit would cover</strong></li>\r\n\r\n	<li><strong>Chose Auditee &amp; Auditor</strong></li>\r\n\r\n	<li><strong>Choose Start Time &amp; End Time</strong></li>\r\n\r\n	<li><strong>Note for Auditor or Auditee</strong></li>\r\n\r\n</ul>\r\n\r\n\r\n\r\n<p>Click submit.</p>\r\n\r\n\r\n\r\n<p>On submit, this information will be added to your plan dynamically.</p>\r\n\r\n\r\n\r\n<p>You can repeat the same step for each branch / department / clauses etc.</p>\r\n\r\n\r\n\r\n<p>All the information will be stored for you to review before publishing.</p>', 1, 1, 0, NULL, 0, '53687891-b810-4f7e-adb9-4456b6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '53687891-7a44-4f79-addf-4456b6329416', '2014-09-22 08:26:53', '53687891-7a44-4f79-addf-4456b6329416', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5368c6c3-8d74-4cbb-a83d-19eab6329416', 262, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Editing Plan', 'internalAuditPlans', 'plan_add_ajax, edit, lists', '<p>Once you create these plan, branch / department wise, you can edit the plan details form the same page. Locate the branch name from the tabs which is located at the top &quot;Schedule Details&quot; panel. Click on the branch you would like to see the plan for and it will display the plan details in the tab body with the following information.</p>\r\n\r\n<ul>\r\n	<li><strong>Department</strong></li>\r\n	<li><strong>Clauses</strong></li>\r\n	<li><strong>Auditee</strong></li>\r\n	<li><strong>Auditor</strong></li>\r\n	<li><strong>Time</strong></li>\r\n	<li><strong>Note</strong></li>\r\n	<li><strong>Action</strong><span style="display:none">&nbsp;</span><span style="display:none">&nbsp;</span><span style="display:none">&nbsp;</span><span style="display:none">&nbsp;</span><span style="display:none">&nbsp;</span><span style="display:none">&nbsp;</span><span style="display:none">&nbsp;</span></li>\r\n</ul>\r\n\r\n<p>Locate &quot;Edit&quot; button which is at the left hand side under Action. It will take you to a new page, from where you can edit &amp; save the details.</p>', 2, 1, 0, NULL, 0, '53687891-b810-4f7e-adb9-4456b6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '53687891-7a44-4f79-addf-4456b6329416', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-30 17:55:22', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5368ca3c-4540-4bdb-ac0d-19eab6329416', 263, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Publishing The Plan', 'internalAuditPlans', 'plan_add_ajax, edit, lists', '<p>Once you are ready with your plan details, you can publish the plan for everyone to see. To publish the plan, go back to MR dashboard and click &quot;Select Plan &amp; add Audit Details&quot;. It will take you to a list of Plans you have already created. Click Publish button, it will take you to the plan page for final review. You can still edit the plan before publishing it.</p>\r\n\r\n\r\n\r\n<ul>\r\n\r\n	<li>You can add any reference documents etc, to with the plan from this page.</li>\r\n\r\n	<li>You can display the published plan on time line</li>\r\n\r\n	<li>You can Notify user (FlinkISO user will see the plan alert in notification center)</li>\r\n\r\n	<li>You can also notify users via email. (Provided you have set up SMPT)</li>\r\n\r\n</ul>\r\n\r\n\r\n\r\n<p>&nbsp;</p>', 3, 1, 0, NULL, 0, '53687891-b810-4f7e-adb9-4456b6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '53687891-7a44-4f79-addf-4456b6329416', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-30 18:01:12', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('536956e9-84a4-4b74-ae99-1dfbb6329416', 264, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Step-I', 'correctivePreventiveActions', 'add_ajax, edit', '<p>Widely known as CAPA. They are divided into 3, Corrective Plan, Preventive Plan or Both (Corrective &amp; Preventive Plan).<br />\r\n\r\n<br />\r\n\r\nSelect the appropriate Action and give it a name &amp; number for your reference.<br />\r\n\r\nYou can select the source. FlinkISO has pre-defined CAPA sources:</p>\r\n\r\n\r\n\r\n<ul>\r\n\r\n	<li><strong>System Failure</strong></li>\r\n\r\n	<li><strong>Document Control</strong></li>\r\n\r\n	<li><strong>Wrong Instructions</strong></li>\r\n\r\n	<li><strong>Training</strong></li>\r\n\r\n	<li><strong>Contractor/Supplier fault</strong></li>\r\n\r\n	<li><strong>Operator Fault</strong></li>\r\n\r\n</ul>\r\n\r\n\r\n\r\n<p>After that you can add the CAPA to a specific category</p>\r\n\r\n\r\n\r\n<ul>\r\n\r\n	<li><strong>Non-Conformity from Audits</strong></li>\r\n\r\n	<li><strong>Suggestions for Improvement</strong></li>\r\n\r\n	<li><strong>Complaints</strong></li>\r\n\r\n	<li><strong>Notices from external parties</strong></li>\r\n\r\n	<li><strong>Suppliers</strong></li>\r\n\r\n	<li><strong>Product</strong></li>\r\n\r\n	<li><strong>Material</strong></li>\r\n\r\n</ul>\r\n\r\n\r\n\r\n<p>You can add more CAPA Sources &amp; Categories or change exiting to suite your terminology.</p>\r\n\r\n\r\n\r\n<p>Based on CAPA Category you can select &ldquo;Raised By&rdquo; field. (Audit, NCS, Suppler etc). You can then assign this to your employee (FlinkISO Users) along with target date, initial remarks, and proposed immediate action. If its a new CAPA, your current status will be Open. Incase you are adding historic data, and CAPA is already closed, you can set the status as closed.</p>', 0, 1, 0, NULL, 0, '53687891-b810-4f7e-adb9-4456b6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '53687891-7a44-4f79-addf-4456b6329416', '2014-09-22 08:26:53', '53687891-7a44-4f79-addf-4456b6329416', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('53695723-307c-4590-ab94-1dfbb6329416', 265, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'CAPA Reminders', 'correctivePreventiveActions', 'add_ajax, edit', '<p>Once you select a user as &ldquo;Assigned To&rdquo; with &ldquo;Target Date&rdquo;, That user will get the newly assigned CAPA on his/her dashboard for further action.</p>\r\n\r\n\r\n\r\n<p>&nbsp;</p>', 2, 1, 0, NULL, 0, '53687891-b810-4f7e-adb9-4456b6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '53687891-7a44-4f79-addf-4456b6329416', '2014-09-22 08:26:53', '53687891-7a44-4f79-addf-4456b6329416', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('53695741-ab08-44f4-abde-1dfbb6329416', 266, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Tracking CAPA', 'correctivePreventiveActions', 'add_ajax, edit', '<p>Approvals are one of the core features of FlinkISO and can be seamlessly used in tracking Open CAPAs. Once the CAPA is assigned to a user, that user can act on CAPA and add his/her inputs, upload relevant documents etc and send the record to any other user / employee for approval, and similarly new user can add his/her comments and forward it for further approval or close the CAPA if completed. All this history can be tracked and available under &ldquo;Approval History&rdquo; which is available on all the page at the right hand side panel.</p>', 3, 1, 0, NULL, 0, '53687891-b810-4f7e-adb9-4456b6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '53687891-7a44-4f79-addf-4456b6329416', '2014-09-22 08:26:53', '53687891-7a44-4f79-addf-4456b6329416', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5369575f-c368-4de0-b8ab-1dfbb6329416', 267, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Step-II', 'correctivePreventiveActions', 'add_ajax, edit', '<p>If the CAPA needs further actions and needs Root Cause Analysis, then step-2 is required. You can enter Root Cause Details and Assign it to any of the user for further completion process. You can always repeat the Approval System to track these changes.</p>', 4, 1, 0, NULL, 0, '53687891-b810-4f7e-adb9-4456b6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '53687891-7a44-4f79-addf-4456b6329416', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-30 18:43:01', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('53695784-f950-4795-b3e4-1ddfb6329416', 268, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Step-III', 'correctivePreventiveActions', 'add_ajax, edit', '<p>Once the Root Cause Analysis is over, add your Action Completed Date, Action Completion Remarks, Effectiveness &amp; Closure Remarks.</p>\r\n\r\n\r\n\r\n<p><strong>Document Change Required?</strong><br />\r\n\r\nDuring this process if it is required to have Document Change, you can add the current CAPA to Document Change by simply clicking on &ldquo;Document Change Required&rdquo; checkbox. This will add your current record to Non-Conformity table and will automatically be available in MRM as one of the topics for further actions.</p>', 5, 1, 0, NULL, 0, '53687891-b810-4f7e-adb9-4456b6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '53687891-7a44-4f79-addf-4456b6329416', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-30 18:44:55', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5369f58d-295c-452e-9c76-0fa6b6329416', 269, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Competency Mappings', 'competencyMappings', 'add_ajax, edit', '<p>Select employee from the drop-down. Select his/her actual Qualifications, Experience, Skills against required qualifications, experience &amp; skills. Add your remarks and save the form.</p>', 0, 1, 0, NULL, 0, '5364d17a-ae30-403e-8209-1f9eb6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '5364d17a-37c4-4e44-b159-1f9eb6329416', '2014-09-22 08:26:53', '5364d17a-37c4-4e44-b159-1f9eb6329416', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('536a2bd6-f7f0-446a-a625-06ebb6329416', 270, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Step-I: (Pre-Appraisal)', 'appraisals', 'add_ajax, edit', '<p>Before you add Appraisals, you need to add Appraisal Question Bank.</p>\r\n\r\n\r\n\r\n<p>These are general questions asked during appraisals to any employee. FlinkISO already has some of these sample questions, which you can edit/delete. You can even add more questions.</p>\r\n\r\n\r\n\r\n<p>Select the employee &amp; appraiser/ supervisor for the appraisal process from the drop-down list. Select the appraisal date, If self-appraisal is required, check the &#39;Self Appraisal Needed&#39; checkbox. If you click &#39;Self Appraisal Needed&#39; checkbox, list of questions will appear for the employee to fill up . You can select questions you find relevant for that particular employee and click submit. You can add more questions by clicking &#39;Add New Question&#39; button.</p>', 0, 1, 0, NULL, 0, '5364d17a-ae30-403e-8209-1f9eb6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '5364d17a-37c4-4e44-b159-1f9eb6329416', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-23 18:33:56', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('536a2c3a-21d4-4506-8034-077ab6329416', 271, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Email', 'appraisals', 'add_ajax, edit', '<p>After you submit (published) record, an email will be sent to the employee with the questions you have selected. Employee will have to answer the questions and save the form before &#39;Appraisal Date&#39;.&nbsp; Till that time &#39;Self Appraisal Status&#39; will be marked as &#39;Pending&#39;. Once the appraisal date has passed you can review and proceed with the appraisal by clicking on &#39;Review&#39; button.</p>', 1, 1, 0, NULL, 0, '5364d17a-ae30-403e-8209-1f9eb6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '5364d17a-37c4-4e44-b159-1f9eb6329416', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-23 18:31:56', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('536a2cee-ab74-40a6-82e0-428db6329416', 272, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Step-II : Final Result and Recommendation', 'appraisals', 'add_ajax, edit', '<p>Once the employee fills his/her appraisal form, : &#39;Self Appraisal Status&#39; will change to &#39;Done&#39;. After the appraisal date, Appraisal Review button will change to &#39;Review&#39;. Employees will have time to change their answers till &#39;Appraisal Date&#39;, after Appraisal date link will be inaccessible to them. You can then review the answers and add rating with comments and save the appraisal.</p>', 3, 1, 0, NULL, 0, '5364d17a-ae30-403e-8209-1f9eb6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '5364d17a-37c4-4e44-b159-1f9eb6329416', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '53c508ca-5870-4ded-8f3c-3e5d118438bd', '2014-09-23 18:38:10', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('537a0781-8870-4c02-bc36-183bb6329416', 273, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding Raw Materials', 'materials', 'add_ajax, edit', '<p>You can add material simply by entering name, description and save the form. if you wish to add this material to &#39;Material List with Shelf Life&#39;, add &#39;Shelflife By Manufacturer&#39;, &#39;Shelflife By Company&#39;, &#39;Remarks&#39; and these details will be added to &#39;Material List with Shelf Life&#39; table.</p>', 1, 1, 0, NULL, 0, '5364d17a-ae30-403e-8209-1f9eb6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '5364d17a-37c4-4e44-b159-1f9eb6329416', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-26 18:46:31', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('537a08d4-9d70-41ed-ba52-2129b6329416', 274, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Quality Check Required?', 'materials', 'add_ajax, edit', '<p>If this material needs a quality check, please check the &#39;Quality check required&#39; checkbox and save. Person form Quality Department will then can see this material on his/ her dashboard and add the Qulaity Check Proccess.</p>\r\n\r\n\r\n\r\n<p>Users from QC department can add any number of quality process steps to each material. Along with the steps they can also upload documents with specifications/ guidelines to refer to.</p>\r\n\r\n\r\n\r\n<p>Once these steps are added and published, material received will not get added to stock unless these check are passed.</p>', 2, 1, 0, NULL, 0, '5364d17a-ae30-403e-8209-1f9eb6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '5364d17a-37c4-4e44-b159-1f9eb6329416', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-26 18:49:06', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('537a0cc5-6184-4510-8d1e-53b0b6329416', 275, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding Quality Checks', 'materialQualityChecks', 'add_ajax, edit, approve', '<p>Users from QC department can add any number of quality process steps to each material. Along with the steps they can also upload documents with specifications / guidelines to refer to.</p>\r\n\r\n<p>Once these steps are added and published, material received will not get added to stock unless these checks are passed.</p>\r\n\r\n<p>To add Quality Checks to a material select material from drop-down list. Upon selection of material, Quality Check Steps that are already added to material will be shown on the page.</p>\r\n\r\n<p>You can add new steps by clicking ''<strong>Add Next Step</strong>''.<br />\r\nClick <span class="glyphicon glyphicon-remove" style="color:rgb(185, 74, 72)"></span> to remove a Quality Check Step.</p>\r\n\r\n<p><em><strong>Uncheck &#39;Active&#39; for Quality Check Steps that are no longer followed.</strong></em></p>\r\n\r\n<p><strong><em>Select &#39;Is Last Step&#39; for last step of Quality Check.</em></strong></p>\r\n\r\n<p>Click &#39;Submit&#39; to save these quality check steps.</p>', 1, 1, 0, NULL, 0, '5364d17a-ae30-403e-8209-1f9eb6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '5364d17a-37c4-4e44-b159-1f9eb6329416', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-25 17:03:42', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('537a105c-d494-4bc6-babb-79e7b6329416', 276, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding Calibrations', 'calibrations', 'add_ajax, edit', '<p>Select device you wish to calibrate.</p>\r\n\r\n\r\n\r\n<p>Add your calibration details like Least Count, Required Accuracy, Range etc. Fill out other details.</p>\r\n\r\n\r\n\r\n<p>You can also select &quot;Next Calibration Date&quot;. If you add next calibration date, reminder will be displayed on dashboard for next calibration.</p>', 1, 1, 0, NULL, 0, '5364d17a-ae30-403e-8209-1f9eb6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '5364d17a-37c4-4e44-b159-1f9eb6329416', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-10-01 15:06:48', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('537c46b7-be94-4883-af09-7607b6329416', 277, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding New Product', 'dashboards', 'production', '<p>Add name &amp; description. You can add required product material from the drop-down list. If material is not available, you can add it from Materials page. Adding material is important for keeping stocks.&nbsp; Select which branch &amp; department this product is available and click submit.<br />\r\n\r\nAfter submit, you can goto view and add any product related document as well as product images etc.<br />\r\n\r\nProduct Design Documents.<br />\r\n\r\nIn view, there are 6 sections available to upload product design related documents viz:</p>\r\n\r\n\r\n\r\n<ol>\r\n\r\n	<li>Upload file : For general uploads</li>\r\n\r\n	<li>Product Plan : You can add your product plan files here</li>\r\n\r\n	<li>Product Requirement : You can add your product requirement files here</li>\r\n\r\n	<li>Product Feasibility : You can add your product feasibility files here</li>\r\n\r\n	<li>Product Development Plan : You can add your product development plan here</li>\r\n\r\n	<li>Product Realization Plan : You can add your product realization plan here.</li>\r\n\r\n</ol>\r\n\r\n\r\n\r\n<p>You can add multiple files for each section.</p>', 3, 1, 0, NULL, 0, '5364d17a-ae30-403e-8209-1f9eb6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '5364d17a-37c4-4e44-b159-1f9eb6329416', '2014-09-22 08:26:53', '5364d17a-37c4-4e44-b159-1f9eb6329416', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('537c4756-1120-4af9-83a1-7643b6329416', 278, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding New Material', 'dashboards', 'production', '<p>You can simply add material name, description and save the form. Incase if you wish to add this material to &quot;Material List with Shelf Life&quot;, add &quot;Shelflife By Manufacturer&quot;, &quot;Shelflife By Company&quot;, &quot;Remarks&quot; and these details will be added to &quot;Material List with Shelf Life&quot; table.</p>', 1, 1, 0, NULL, 0, '5364d17a-ae30-403e-8209-1f9eb6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '5364d17a-37c4-4e44-b159-1f9eb6329416', '2014-09-22 08:26:53', '5364d17a-37c4-4e44-b159-1f9eb6329416', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('537c47c2-94c4-43cc-849d-7637b6329416', 279, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Quality Check Required?', 'dashboards', 'production', '<div>\r\n\r\n<div>\r\n\r\n<p>If this material needs a quality check, please check the &quot;Quality check required&quot; checkbox and save. Person form Quality Department will then see this material on his/her dashboard, to add the Qulaity Check Process.</p>\r\n\r\n\r\n\r\n<p>Users from QC department can add any number of quality process steps to each material. Along with the steps they can also upload any perticular document with specifications / guidelines to refer.</p>\r\n\r\n\r\n\r\n<p>Once these steps are add and published, material received will not get added to stock unless these check are passed.</p>\r\n\r\n\r\n\r\n<p>When you add any material from delivery challans along with the quantity &amp; if QC check is defined for that material, alert will flash on QC dashboard to perform QC check. When you click on the Act button, it will redirect you to the QC check form, for that material along with the number of steps defined in Tabs as steps. You can add the your comments on each step and at the end add the accepted material number in final step.</p>\r\n\r\n\r\n\r\n<p>&nbsp;</p>\r\n\r\n</div>\r\n\r\n</div>', 2, 1, 0, NULL, 0, '5364d17a-ae30-403e-8209-1f9eb6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '5364d17a-37c4-4e44-b159-1f9eb6329416', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-10-01 16:16:31', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('537c48f5-227c-4d21-b8cd-7637b6329416', 280, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Add Production Batch', 'dashboards', 'production', '<p>Once you are ready with both Products &amp; Materials you can start adding Production Batches. You need to first create a batch along with Product (remember, materials are connected to a product. So when you add a product to a batch, associated materials are automatically added to the batch). Added other required fields and save the batch.</p>\r\n\r\n\r\n\r\n<p>You can add each material to a batch from Add Stock To Batch form.</p>', 4, 1, 0, NULL, 0, '5364d17a-ae30-403e-8209-1f9eb6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '5364d17a-37c4-4e44-b159-1f9eb6329416', '2014-09-22 08:26:53', '5364d17a-37c4-4e44-b159-1f9eb6329416', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('537c49d8-2dd8-46a2-9d3d-7643b6329416', 281, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding Stock to Batch', 'dashboards', 'production', '<p>Once you have created a batch, go back to Production dashboard and click &quot;Add Stock To Batch&quot;, &quot;Add&quot; button. Select the batch &amp; sselecte the required material. Remember, only materials which are required for a product will be displayed. Once you select the material, system will prompt you with available stock for that material. Add the approprieate value in quantity consumed and save the form. At this point, quantity consumed will be removed from the quantity in hand.</p>', 5, 1, 0, NULL, 0, '5364d17a-ae30-403e-8209-1f9eb6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '5364d17a-37c4-4e44-b159-1f9eb6329416', '2014-09-22 08:26:53', '5364d17a-37c4-4e44-b159-1f9eb6329416', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('537c4bac-5328-4662-8214-7643b6329416', 282, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding New Product', 'products', 'add_ajax, edit', '<p>Add name and description. &#39;Add Required Materials&#39; for this product from drop-down list. If materials are not available, you can add from Materials page. Adding material is important for keeping stocks.&nbsp; Select which branch, department this product is available and click submit.<br />\r\n\r\nAfter submit, you can go to view and add any product related document as well as product images etc.<br />\r\n\r\nProduct Design Documents.<br />\r\n\r\nIn view, there are 6 sections available to upload product design related documents viz:</p>\r\n\r\n\r\n\r\n<ol>\r\n\r\n	<li>Upload file : For general uploads</li>\r\n\r\n	<li>Product Plan : You can add your product plan files here</li>\r\n\r\n	<li>Product Requirement : You can add your product requirement files here</li>\r\n\r\n	<li>Product Feasibility : You can add your product feasibility files here</li>\r\n\r\n	<li>Product Development Plan : You can add your product development plan here</li>\r\n\r\n	<li>Product Realization Plan : You can add your product realization plan here.</li>\r\n\r\n</ol>\r\n\r\n\r\n\r\n<p>You can add multiple files for each section.</p>', 1, 1, 0, NULL, 0, '5364d17a-ae30-403e-8209-1f9eb6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '5364d17a-37c4-4e44-b159-1f9eb6329416', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '53c508ca-5870-4ded-8f3c-3e5d118438bd', '2014-09-30 11:37:40', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('537c4c20-2ca0-419b-8460-1a7db6329416', 283, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding New Batch', 'productions', 'add_ajax, edit', '<p>Once you are ready with both Products &amp; Materials you can start adding Production Batches. You need to first create a batch along with Product (remember, materials are connected to a product. So when you add a product to a batch, associated materials are automatically added to the batch). Fill in the details in other required fields and save the batch.</p>\r\n\r\n\r\n\r\n<p>You can add any material to a batch from &#39;<strong>Add Stock To Batch</strong>&#39; form.</p>', 1, 1, 0, NULL, 0, '5364d17a-ae30-403e-8209-1f9eb6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '5364d17a-37c4-4e44-b159-1f9eb6329416', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-26 19:01:19', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('537c4c5d-09f4-4aee-ab72-1a7eb6329416', 284, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding Stock to Batch', 'stocks', 'add_ajax, edit, lists', '<p>After creating a batch, go back to Production dashboard and click &#39;<strong>Add</strong>&#39; button displayed under &#39;<strong>Add Stock To Batch</strong>&#39; section.</p>\r\n\r\n\r\n\r\n<p>Select the batch and required material.<strong> </strong>Remember: Only those materials will be displayed which are required for a product. Once you select the material, system will prompt you with available stock for that material. Add the appropriate value in quantity consumed and save the form. At this point, &#39;Quantity Consumed&#39; will be deducted from &#39;Quantity in hand&#39;.</p>', 1, 1, 0, NULL, 0, '5364d17a-ae30-403e-8209-1f9eb6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '5364d17a-37c4-4e44-b159-1f9eb6329416', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-26 19:26:10', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('537c4d8d-2ed4-4328-a382-7607b6329416', 285, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Materials From Challans', 'dashboards', 'purchase', '<p>If any Delivery Challan contains any Material which has defined QC steps, that material will not be added to stock immediately. Quantity received will be displayed on Quality Control dashboard and QC users are expected to add QC information for each of the defined step and then add final accepted quantity as final incoming stock.</p>', 2, 1, 0, NULL, 0, '5364d17a-ae30-403e-8209-1f9eb6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '5364d17a-37c4-4e44-b159-1f9eb6329416', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-10-01 15:55:10', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('537c4e4e-26c0-48c0-ae50-7637b6329416', 286, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Supplier Evaluations', 'dashboards', 'purchase', '<p>Supplier evaluation is a key process in QMS. FlinkISO supplire evaluation is based on the following matrix.</p>\r\n\r\n\r\n\r\n<ol>\r\n\r\n	<li>Number of orders placed</li>\r\n\r\n	<li>Number of good received</li>\r\n\r\n	<li>Number of goods accepted after QC check</li>\r\n\r\n	<li>Delays in delivery</li>\r\n\r\n</ol>\r\n\r\n\r\n\r\n<p>Based on these parameters, FlinkISO will provide you with a graph and the supplier score. You can then add the supplier in any of available category.</p>', 3, 1, 0, NULL, 0, '5364d17a-ae30-403e-8209-1f9eb6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '5364d17a-37c4-4e44-b159-1f9eb6329416', '2014-09-22 08:26:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-10-01 15:30:39', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('537c4fd4-a6e8-4bcf-a268-7637b6329416', 287, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Summery Of Supplier Evaluations', 'dashboards', 'purchase', '<p>For each evaluation made by your team, this list will be automatically gathered. You can also add this directly without going through the FlinkISO standard process.</p>', 3, 1, 0, NULL, 0, '5364d17a-ae30-403e-8209-1f9eb6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '5364d17a-37c4-4e44-b159-1f9eb6329416', '2014-09-22 08:26:53', '5364d17a-37c4-4e44-b159-1f9eb6329416', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('537db44c-df20-4e7d-b8b0-32cab6329416', 288, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Business Development Process', 'dashboards', 'bd', '<p>Create customers from &quot;Customers&quot; panel. You can also import your existing customers from Import-Export.</p>\r\n\r\n\r\n\r\n<p>Once your list of customers is ready, you can add details form &quot;Customer Meetings&quot; with your employees.</p>\r\n\r\n\r\n\r\n<p>You can add proposals as well as proposal follow-ups along with follow-up status.</p>\r\n\r\n\r\n\r\n<p>Based on meetings, proposals,follow-ups &amp; invoices raised based on the proposal, you can derive your conversion rate.</p>', 1, 1, 0, NULL, 0, '5364d17a-ae30-403e-8209-1f9eb6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '5364d17a-37c4-4e44-b159-1f9eb6329416', '2014-09-22 08:26:53', '5364d17a-37c4-4e44-b159-1f9eb6329416', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('537ee9cb-1dac-41ea-9cbf-1b5bb6329416', 289, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Document Change Request', 'dashboards', 'mr', '<p>FlinkISO can handle your Document Change Request like a cake. Click on Add in &quot;Document Change Request&quot; panel. It will take you to a new page. Add your initial details like Request From, select format, current document details, amendement details etc and save the form.</p>\r\n\r\n\r\n\r\n<p>These change request will then be available as a Meeting Topic for a upcomming MR meeting. While creating a meeting &amp; adding agenda, you can add this new request as a &quot;Meeting Topic&quot;. After the request is discussed in a meeting, you can then Edit the current &quot;Document Change Request&quot; record, from &quot;Document Change Request&quot; panel. Click on See All, chose the desired record for Edit, and you will see additional fields like</p>\r\n\r\n\r\n\r\n<ul>\r\n\r\n	<li>Document Changes Accepted</li>\r\n\r\n	<li>Approved In meeting</li>\r\n\r\n	<li>Current Document Details</li>\r\n\r\n	<li>New Document Details etc.</li>\r\n\r\n</ul>\r\n\r\n\r\n\r\n<p>Once you add these details and if document change is accepted, current document will be archived &amp; related document will be archived too. These changes will then available under &quot;Document Amendment Recordsheet&quot; as Archived History.</p>', 4, 1, 0, NULL, 0, '5364d17a-ae30-403e-8209-1f9eb6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '5364d17a-37c4-4e44-b159-1f9eb6329416', '2014-09-22 08:26:53', '5364d17a-37c4-4e44-b159-1f9eb6329416', NULL, NULL, '2014-09-22 08:26:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('54212758-e8c0-4707-986a-0476118438bd', 292, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding Course Type', 'CourseTypes', 'add_ajax, edit, approve', '<p>Your organisation may have numerous training courses. To group Courses related to a particular training they are categorised under a &#39;Course Type&#39; e.g. HR related courses can be categorised under &#39;HR Courses&#39;, likewise MR related courses can have &#39;MR Courses&#39; as course type.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-23 13:25:04', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-23 13:56:48', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('541ffc75-9a88-4927-b560-2359118438bd', 290, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding new Customer', 'customers', 'add_ajax, edit, approve', '<p>With customer&#39;s section you can add all your existing customers as well as new customers. You can also import your existing customers from Import-Export utility. Customers are divided into 2 categories :</p>\r\n\r\n\r\n\r\n<ol>\r\n\r\n	<li>Individuals</li>\r\n\r\n	<li>Companies</li>\r\n\r\n</ol>\r\n\r\n\r\n\r\n<p>Once you add your list of customers you can further explore FlinkISO modules such as Business Development, Purchase, Quality Control.</p>\r\n\r\n\r\n\r\n<p>There are many sections which requires already added Customers e.g. Customer Complaints, Customer Feedbacks, Customer Meetings/ Meeting Followups, Purchase Orders (Inbound).</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-22 16:09:49', '53c508ca-d868-4d71-b3a1-3e5d118438bd', NULL, NULL, '2014-09-22 16:39:50', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('54200d54-94fc-4852-ac1b-6293118438bd', 291, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding new Branch', 'branches', 'add_ajax, edit, approve', '<p>Branch Name must be unique as all the records stored in FlinkISO are broadly categorised by Branches and Departments of Branches.</p>', 1, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-22 17:21:48', '53c508ca-d868-4d71-b3a1-3e5d118438bd', NULL, NULL, '2014-09-22 17:22:57', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5421683a-8580-4d47-ab7a-0479118438bd', 293, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Add Training Evaluation', 'trainingEvaluations', 'add_ajax, edit, approve', '<p>Training Evaluation is a process which determines whether the goals, objectives were met and what impact the training had on actual performance of the employee. It can be performed after trainings are conducted.</p>\r\n\r\n\r\n\r\n<p>To add a Training Evaluation record, select training from &#39;Training&#39; drop-down list, Fill in the details e.g. purpose of training, is it fulfilled, was it informative, what are the improvements into corresponding fields of this form.</p>\r\n\r\n\r\n\r\n<p>&nbsp;</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-23 18:01:54', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-23 18:01:54', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('542267d0-640c-4fb7-8e4e-046f118438bd', 294, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding new Appraisal Question', 'appraisalQuestions', 'add_ajax, edit, approve', '<p>You can add Appraisal Questions using this form. These are the questions asked to employees during their &#39;Performance Appraisal&#39;.</p>\r\n\r\n\r\n\r\n<p>&#39;Import/Export&#39; utility allows you to import multiple appraisal questions at once. If you have a question bank ready, you can easily import it using this utility.</p>\r\n\r\n\r\n\r\n<p>All the questions added/imported will be available in &#39;Add Appraisal&#39; form.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-24 12:12:24', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-24 15:22:39', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('54226a24-4ee4-4b02-80ba-21e1118438bd', 295, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'appraisalQuestions', 'add_ajax, edit, approve', '<ul>\r\n\r\n	<li><strong>Question</strong> is mandatory</li>\r\n\r\n</ul>', 1, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-24 12:22:20', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-24 13:06:26', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '');
INSERT INTO `helps` (`id`, `sr_no`, `language_id`, `title`, `table_name`, `action_name`, `help_text`, `sequence`, `publish`, `record_status`, `status_user_id`, `soft_delete`, `branchid`, `departmentid`, `created_by`, `created`, `modified_by`, `approved_by`, `prepared_by`, `modified`, `system_table_id`, `master_list_of_format_id`) VALUES
('54228ce5-78b4-4b70-954f-3cc3118438bd', 296, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding new Customer Meeting', 'customerMeetings', 'add_ajax, edit, approve', '<p>Customer Meeting is a way to communicate with customers and understand customer&#39;s requirements.</p>\r\n\r\n\r\n\r\n<p>You can add customer meeting by using this &#39;<strong>Add Customer Meeting</strong>&#39; form.</p>\r\n\r\n\r\n\r\n<p>Select the customer from &#39;Customer&#39; drop-down list, select an employee who will attend this meeting. Set a date for meeting. Add &#39;Action Point&#39; of the meeting and meeting details in respective fields. Select current status of the meeting from &#39;Status&#39; drop-down list. Additionally you can set a &#39;Next Meeting Date&#39;. Once the form is filled up you can click &#39;Submit&#39; button to save the &#39;Meeting&#39; details you just entered.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-24 14:50:37', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-24 15:22:17', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('54228e73-ca0c-4129-b7db-046f118438bd', 297, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'customerMeetings', 'add_ajax, edit, approve', '<p>Following fields are mandatory:</p>\r\n\r\n\r\n\r\n<ul>\r\n\r\n	<li><strong>Customer</strong></li>\r\n\r\n	<li><strong>Employee</strong></li>\r\n\r\n	<li><strong>Meeting Date</strong></li>\r\n\r\n	<li><strong>Action Point</strong></li>\r\n\r\n	<li><strong>Status</strong></li>\r\n\r\n</ul>', 1, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-24 14:57:15', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-24 16:21:11', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5422a19b-3ef8-41cf-877a-635d118438bd', 298, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding new Proposal', 'proposals', 'add_ajax, edit, approve', '<p>You can add proposals presented/ being presented to your customers.</p>\r\n\r\n\r\n\r\n<p>To add a &#39;Proposal&#39; enter a title for proposal, select a customer to whom the proposal is meant for, from &#39;Employee&#39; drop-down list select an employee who presents this proposal, select a date for proposal. Add proposal heading and proposal details. Save this proposal by clicking on &#39;Submit&#39; button.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-24 16:18:59', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-24 16:24:37', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5422a20f-365c-447d-a724-21e1118438bd', 299, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'proposals', 'add_ajax, edit, approve', '<p>Following fields are mandatory :</p>\r\n\r\n\r\n\r\n<ul>\r\n\r\n	<li><strong>Title</strong></li>\r\n\r\n	<li><strong>Customer</strong></li>\r\n\r\n	<li><strong>Employee</strong></li>\r\n\r\n	<li><strong>Proposal Heading</strong></li>\r\n\r\n</ul>', NULL, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-24 16:20:55', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-24 16:20:55', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5422aafb-d2a4-4b1d-bb74-21e1118438bd', 300, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding new Proposal Follow-up', 'proposalFollowups', 'add_ajax, edit, approve', '<p>Following up a proposal, select &#39;Proposal&#39; from proposal drop-down list, select an employee, select &#39;Follow-up Date&#39;. If follow-up requires a meeting to be held, check &#39;Meeting Required&#39; checkbox, add follow-up heading and details, select &#39;Next Follow-up Date&#39; and current status of the follow-up. Save proposal followup by clicking on &#39;Submit&#39; button.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-24 16:58:59', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-24 17:03:34', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5422aba9-e440-4739-aadd-635d118438bd', 301, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'proposalFollowups', 'add_ajax, edit, approve', '<p>Following fields are mandatory:</p>\r\n\r\n\r\n\r\n<ul>\r\n\r\n	<li><strong>Proposal</strong></li>\r\n\r\n	<li><strong>Employee</strong></li>\r\n\r\n	<li><strong>Followup Date</strong></li>\r\n\r\n	<li><strong>Followup Heading</strong></li>\r\n\r\n	<li><strong>Status</strong></li>\r\n\r\n</ul>', NULL, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-24 17:01:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-24 17:01:53', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5422be91-1338-48a1-b1f7-21e1118438bd', 302, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Add new Fire Extinguisher', 'FireExtinguishers', 'add_ajax, edit, approve', '<p>As a safety measure and an ISO mandate you must have fire extinguishers installed in your organisation. Fire Extinguisher is a fire safety equipment. There are several types of fire extinguishers and they are already available in FlinkISO.</p>\r\n\r\n\r\n\r\n<p>Having equipment&#39;s details handy and you are just a step away from adding a new Fire Extinguisher e.g. Name, Type, Manufacturer, Purchase Date, equipment&#39;s Warranty Expiry Date. Fill in these details in respective fields and click &#39;Submit&#39; button.</p>\r\n\r\n\r\n\r\n<p>You can also upload any product related document by using &#39;Upload a file&#39; utility which is accessible from &#39;View / Upload evidence&#39; page.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-24 18:22:33', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-24 18:24:47', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5422c61a-3d1c-436b-b94e-21e5118438bd', 303, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Add new Fire Extinguisher Type', 'fireExtinguisherTypes', 'add_ajax, edit, approve', '<p>Different fuels create different fires and require different types of fire extinguishing agents, therefore, Fire Extinguishers are classified under several &#39;Extinguisher types&#39;. Commonly used extinguisher types are already available in FlinkISO.</p>\r\n\r\n\r\n\r\n<p>You can add a custom extinguisher type by specifying an Extinguisher Type Name, adding description. Once you are done filling up this information, a click on Submit button will create a new Fire Extinguisher Type.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-24 18:54:42', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-24 18:56:38', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5423c8fc-2bac-471b-8102-11ca118438bd', 304, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Add new Housekeeping Checklist', 'housekeepingChecklists', 'add_ajax, edit, approve', '<p>Adding a housekeeping task is easy. It can be done by using this &#39;Add new Housekeeping Checklist&#39; form.</p>\r\n\r\n\r\n\r\n<p>Enter a title for housekeeping task you want to create, add description. Select branch, department this task will be performed at. Submit this form to save Housekeeping Checklist.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-25 13:19:16', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-25 13:20:17', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5423ccde-050c-46ed-b49b-04a8118438bd', 305, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding new Housekeeping Responsibility', 'housekeepingResponsibilities', 'add_ajax, edit, approve', '<p>Housekeeping Checklist tasks are assigned to users through this &#39;Add Housekeeping Responsibility&#39; form.</p>\r\n\r\n\r\n\r\n<p>Select a task from &#39;Housekeeping Checklist&#39; drop-down list, select an employee who performs this task, select a schedule, add description and submit the form to create a new &#39;Housekeeping Responsibility&#39;.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-25 13:35:50', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-25 13:38:05', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5423e14e-8a4c-4e9d-9488-04a8118438bd', 306, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding new Customer Complaint', 'customerComplaints', 'add_ajax, edit, approve', '<p>Select customer who raised complaint, select the source of the complaint e.g. Product/ Service/ Delivery/ Customer Care. Enter complaint number, date of complaint. Fill in the complaint details.</p>\r\n\r\n<p><strong><span style="color:#d9534f">Note : Following details are not accessible to Non-MR users.</span><br />\r\nOnly MR users can</strong></p>\r\n\r\n<ul>\r\n	<li>\r\n	<p><strong>assign complaint to an &#39;Employee&#39;,</strong></p>\r\n	</li>\r\n	<li>\r\n	<p><strong>set a &#39;Target Date&#39;, </strong></p>\r\n	</li>\r\n	<li>\r\n	<p><strong>change &#39;Current Status&#39; of complaint,</strong></p>\r\n	</li>\r\n	<li>\r\n	<p><strong>add to CAPA</strong></p>\r\n	</li>\r\n	<li>\r\n	<p><strong>update the &#39;Action Details&#39; e.g. Action Taken, Action Taken Date, Settled Date, Authorized By.</strong></p>\r\n	</li>\r\n</ul>', 3, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-25 15:03:02', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-10-01 15:03:43', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5423e79c-1d04-4cee-9236-11d5118438bd', 307, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding Customer Feedback', 'customerFeedbacks', 'add_ajax, edit, approve', '<p>Customer Feedback Questions should be added before you add a customer feedback. All the published questions are shown in &#39;Add Customer Feedback&#39; form.</p>\r\n\r\n\r\n\r\n<p>Select customer from drop-down list. If question has multiple options underneath, select an appropriate answer. Customer might have an opinion, therefore, a Comment box is available for each question. Submit the form to save this Customer Feedback.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-25 15:29:56', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-25 15:31:01', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5423ee5d-4058-4900-94d6-04ab118438bd', 308, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding Customer Feedback Question', 'customerFeedbackQuestions', 'add_ajax, edit, approve', '<p>Customer Feedback Questions should be added before you add a customer feedback. All the published questions are shown in &#39;Add Customer Feedback&#39; form.</p>\r\n\r\n\r\n\r\n<p>Enter feedback question in &#39;Question&#39; field. If you select &#39;Optional&#39; question type and specify the options, while answering this question user will have a choice to select his answer from. If you don&#39;t want to specify options, select &#39;Comment&#39; under &#39;Question Type&#39; which adds a comment box under question where user can type in their comments.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-25 15:58:45', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-10-01 15:13:03', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('54240814-06a4-48a0-9c5a-0a99118438bd', 309, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'deviceMaintenances', 'add_ajax, edit, approve', '<p>Following fields are mandatory :</p>\r\n\r\n\r\n\r\n<ul>\r\n\r\n	<li><strong>Device</strong></li>\r\n\r\n	<li><strong>Employee</strong></li>\r\n\r\n	<li><strong>Maintenance Performed Date</strong></li>\r\n\r\n	<li><strong>Next Maintanence Date</strong></li>\r\n\r\n</ul>', 1, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-25 17:48:28', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-25 17:48:28', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('54240bc9-2878-4344-b752-183b118438bd', 310, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding Device Maintenance', 'deviceMaintenances', 'add_ajax, edit, approve', '<p>You can add a &#39;Device Maintenance&#39; record to FlinkISO after performing a device maintenance.</p>\r\n\r\n\r\n\r\n<p>Select a device from &#39;Device&#39; drop-down list, select employee who carried out the maintenance task, select &#39;Maintenance Performed Date&#39;, type in findings (if any), select device status, set a &#39;Next Maintenance Date&#39; and save the device maintenance form by clicking &#39;Submit&#39;.</p>\r\n\r\n\r\n\r\n<p>Device Maintenance notification will appear under &#39;Device Maintenance&#39; tab on &#39;User Dashboard&#39; of person who is responsible for maintenance, It will appear a week before &#39;Next Maintenance Date&#39;. Person responsible for maintenance can update the maintenance details by following the &#39;Act&#39; link.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-25 18:04:17', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-25 18:22:09', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('54252419-8e18-4894-a563-0474118438bd', 312, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding Supplier Category', 'SupplierCategories', 'add_ajax, edit, approve', '<p>There has to be at least one Supplier Category in order to be able to add Suppliers.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-26 14:00:17', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-26 14:00:17', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('54252ea2-5410-4eae-89e7-1162118438bd', 313, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding Delivery Challan', 'DeliveryChallans', 'add_ajax, edit, approve', '<p>Upon selecting Purchase Order, against which this Delivery Challan is issued, you can review details of Purchase Order you have selected. All the items listed in Purchase Order can be seen here. At the time of delivery, &#39;Delivery Challan values&#39; may differ from that of purchase order. You can type in the values, details of delivery challan you have received and then click &#39;Submit&#39; to save it.</p>\r\n\r\n\r\n\r\n<p><em><strong>Materials (listed in this delivery challan) that does not require quality checks, gets automatically added to stock. </strong></em></p>\r\n\r\n\r\n\r\n<p><em><strong>Materials which requires QC checks to be performed, will be added to stock after performing all the QC checks.</strong></em></p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-26 14:45:14', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-10-01 16:01:17', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('542538dd-19a8-4311-855a-0474118438bd', 314, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding Purchase Order', 'PurchaseOrders', 'add_ajax, edit, approve', '<p>FlinkISO has built-in functionality to keep track of purchase/ sales transactions.</p>\r\n\r\n\r\n\r\n<p>To add a Purchase Order (PO) enter a Title for purchase order, a unique PO number, date of the order.</p>\r\n\r\n\r\n\r\n<p>Select a type e.g. Inbound, Outbound, Other. &#39;<strong>Inbound Purchase Orders</strong>&#39; are purchase orders issued by your customers to you. &#39;<strong>Outbound Purchase Orders</strong>&#39; are purchase orders that you send to your suppliers. Based on your selection of PO &#39;Type&#39; select a Customer/Supplier.</p>\r\n\r\n\r\n\r\n<p>Enter the order details. Select item type, it can be a Product, a Device or a Material. Based on your item type selection you will have to select Product/ Device/ Material from drop-down list. Anything other than Product, Device, Material can be entered as &#39;Other&#39;.</p>\r\n\r\n\r\n\r\n<p>Purchase Orders may have multiple items. You can add these items by clicking &#39;<strong>Add New Order Details</strong>&#39; button.</p>\r\n\r\n\r\n\r\n<p>Once you have entered all necessary details click &#39;Submit&#39; to save this purchase order.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-26 15:28:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-26 15:31:51', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('54254679-b3f4-41f9-8907-0472118438bd', 315, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding new Software', 'ListOfSoftwares', 'add_ajax, edit, approve', '<p>Your organization may have many computer softwares applications. Managing details of all these software applications can be done easily using FlinkISO.</p>\r\n\r\n\r\n\r\n<p>Before you add Software you must have a &#39;<strong>Software </strong><strong>Type</strong>&#39;. You can add new software types by clicking &#39;<strong>New Software Type</strong>&#39; tab available on this page.</p>\r\n\r\n\r\n\r\n<p>Once you add a software type you can switch to &#39;New Software&#39; tab and add a new Software. Fill in other details e.g. Software Name, Software Type, License Key, Storage device Number. If software requires backup select &#39;<strong>Backup Required</strong>&#39; checkbox, select &#39;Backup Schedule&#39; from drop-down list. Select an employee, who uses/ manages this software. Click &#39;Submit&#39; to save this software.</p>\r\n\r\n\r\n\r\n<p>You can also upload documents that are related to this software package e.g. installation guide. Through &#39;<strong>View / Upload Evidence page</strong>&#39; of this software you can upload such documents.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-26 16:26:57', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-10-01 16:07:42', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5425564d-c1fc-4157-be64-1254118438bd', 316, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding new Computer', 'ListOfComputers', 'add_ajax, edit, approve', '<p>Computer has now become an integral part of any business organization. To keep track of these assets you can add relevant records to FlinkISO using this &#39;Add Computer&#39; form.</p>\r\n\r\n\r\n\r\n<p>Select an employee to whom this computer is allotted to, enter Serial Number, select Supplier and Purchase Order from respective drop-down lists, type in Make of Computer, price. Select the date of Installation.</p>\r\n\r\n\r\n\r\n<p>Information of the Softwares that are installed in this computer can also be added using this form. You can add as many softwares as you want by clicking &#39;Add New Software&#39;. Once you enter all required information click &#39;Submit&#39; to save this Computer.</p>\r\n\r\n\r\n\r\n<p>Documents related to this computer e.g Product Manual, Installation guide, can also be added using &#39;Upload a file&#39; utility on &#39;View / Upload Evidence&#39; page of this computer.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-26 17:34:29', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-26 17:53:17', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('5425604b-4058-46b5-a531-0491118438bd', 317, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding new Computer Software', 'ListOfComputerListOfSoftwares', 'add_ajax, edit, approve', '<p>There might be many Software Applications installed in a particular computer in your organization. You can add these applications to a Computer record which you have already added to FlinkISO. This way you can find out how many softwares are installed on a particular computer.</p>\r\n\r\n\r\n\r\n<p>Select a computer from drop-down list, select a software you want to add to computer you just selected, select software Installation Date, type in the details and click &#39;Submit&#39;.</p>\r\n\r\n\r\n\r\n<p>Adding softwares to a computer can also be done using &#39;Add Computer&#39; form.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-26 18:17:07', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-26 18:17:07', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('542564ed-4270-423d-a73c-1268118438bd', 318, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding Username Password Detail', 'UsernamePasswordDetails', 'add_ajax, edit, approve', '<p>Devices holding sensitive information requires password authentication. These passwords needs to be changed periodically. To keep track of this activity you can add &#39;Username Password Detail&#39; to FlinkISO.</p>\r\n\r\n\r\n\r\n<p>Select a computer, select an employee who uses/ manages it. Enter Username, Password and Date of change of password and submit the form to save these details.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-26 18:36:53', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-26 18:37:52', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('54256b63-5d78-4e7d-984a-1250118438bd', 319, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'productions', 'add_ajax, edit, approve', '<ul>\r\n\r\n	<li><strong>Product</strong> is mandatory</li>\r\n\r\n	<li><strong>Batch Number</strong> is mandatory</li>\r\n\r\n	<li><strong>Branch</strong> is mandatory</li>\r\n\r\n	<li><strong>Supervisor</strong> is mandatory</li>\r\n\r\n	<li><strong>Start Date</strong> is mandatory</li>\r\n\r\n	<li><strong>End Date</strong> is mandatory</li>\r\n\r\n</ul>', 0, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-26 19:04:27', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-26 19:05:06', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('54256f9e-1140-495c-abe1-0494118438bd', 320, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'stocks', 'add_ajax, edit, lists', '<p><strong>Add Stock to Batch </strong></p>\r\n\r\n\r\n\r\n<ul>\r\n\r\n	<li><strong>Batch</strong> is mandatory</li>\r\n\r\n	<li><strong>Production Date</strong> is mandatory</li>\r\n\r\n	<li><strong>Quantity Consumed</strong> is mandatory</li>\r\n\r\n</ul>\r\n\r\n\r\n\r\n<p><strong>Add Incoming Stock</strong></p>\r\n\r\n\r\n\r\n<ul>\r\n\r\n	<li><strong>Delivery Challan</strong> is mandatory</li>\r\n\r\n</ul>', 0, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-26 19:22:30', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-26 19:44:13', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('542a445d-dd4c-4b24-bd58-1618118438bd', 321, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding new Department', 'departments', 'add_ajax, edit, approve', '<p>Following a general organizational structure, FlinkISO has many built-in departments. You can also create as many departments as you may require.</p>\r\n\r\n\r\n\r\n<p>Built-in departments can not be edited, deleted. On departments&#39; list page these built-in departments can be easily identified as these departments have a lock symbol next to their name.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-30 11:19:17', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-30 11:19:45', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('542a4511-7738-4484-8fd1-1578118438bd', 322, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding new Designation', 'designations', 'add_ajax, edit, approve', '<p>FlinkISO has a list of designations which are suitable for most organizations. You can also create designations as per your requirements.</p>\r\n\r\n<p>Importing multiple designations at once can be easily done using &#39;Import/Export&#39; utility which is accessible from &#39;View / Upload Evidence&#39; page.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-30 11:22:17', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-30 11:26:41', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('542a7b03-d130-4fa9-ae40-479e118438bd', 323, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding Change Addition Deletion Request', 'ChangeAdditionDeletionRequests', 'add_ajax, edit, approve', '<p>&#39;Master List of Formats&#39; is a list of forms FlinkISO uses to store information.</p>\r\n\r\n\r\n\r\n<p>Change Addition Deletion Request is a request to propose changes in these forms. It helps you keep track of the changes.</p>\r\n\r\n\r\n\r\n<p>Select request source from &#39;<strong>Request From</strong>&#39; options. Based on your &#39;Request From&#39; selection, a corresponding field appears.</p>\r\n\r\n\r\n\r\n<p>e.g. if you select &#39;Employee&#39; as an option, an &#39;Employee&#39; drop-down box appears. Select an appropriate value.</p>\r\n\r\n\r\n\r\n<p>Fill in &#39;Current Document Details&#39;, &#39;Request Details&#39;, &#39;Proposed Changes&#39;, &#39;Reason For Change&#39; in respective fields. If this change request needs to be discussed in MR Meeting, select meeting from drop-down list. Submit the form to save this change addition deletion request.</p>\r\n\r\n\r\n\r\n<p>Once the request is discussed in a meeting, you can add further details by editing this request. If the proposed changes are accepted in meeting, click on &#39;<strong>Document Change Accepted</strong>&#39; checkbox. Select meeting from &#39;<strong>Approve in meeting</strong>&#39;, fill in other details.</p>\r\n\r\n\r\n\r\n<p>If FlinkISO functionality change is required, click on the checkbox and enter the details. Selecting &#39;<strong>FlinkISO functionality change required</strong>&#39; checkbox will send an email to FlinkISO Customization team upon submission of this form.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-30 15:12:27', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-30 15:29:36', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('542a92a3-b8e0-4849-8c68-1579118438bd', 324, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding Trained Internal Auditor', 'ListOfTrainedInternalAuditors', 'add_ajax, edit, approve', '<p>To add a &#39;Trained Internal Auditor&#39;, select &#39;Employee&#39; (who has undergone &#39;Auditor Training&#39;), select &#39;Training&#39; from adjacent drop-down list. Fill in other details (if any) and submit the form to save &#39;Trained Internal Auditor&#39;.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-30 16:53:15', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-30 16:54:04', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('542a9a29-0ff8-4195-898a-1537118438bd', 325, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding Meeting Details', 'meetings', 'after_meeting', '<p>Once the meeting is over, you can add meeting details. Select meeting from drop-down list. Upon selection, meeting details will be shown. You can make changes (if any) and save the meeting details by clicking the &#39;Submit&#39; button.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-30 17:25:21', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-10-01 12:57:08', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('542aaf9c-9bd8-434c-9c4e-204a118438bd', 326, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding new CAPA Source', 'capaSources', 'add_ajax, edit, approve', '<p>A list of CAPA Sources is already available in FlinkISO. You can also add new CAPA Source, simply by specifying the name of the source and then submit the form.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-30 18:56:52', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-30 19:00:31', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('542ab312-314c-4f0f-b0d0-0463118438bd', 327, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Adding new CAPA Category', 'capaCategories', 'add_ajax, edit, approve', '<p>FlinkISO has several built-in CAPA Categories. You can create new CAPA Categories as required.</p>\r\n\r\n\r\n\r\n<p>Specify the name for CAPA Category and click on &#39;Submit&#39; to save it.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-09-30 19:11:38', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-09-30 19:11:38', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('542bacb6-a7e8-48f1-93e4-0490118438bd', 328, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Mandatory Fields', 'meetings', 'after_meeting', '<ul>\r\n\r\n	<li><strong>Meeting</strong> is mandatory</li>\r\n\r\n</ul>', 1, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-10-01 12:56:46', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-10-01 12:56:46', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('542be1cd-5918-4ac4-8ee8-0491118438bd', 329, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Send Notifications', 'notifications', 'add_ajax, edit, approve', '<p>Creating notifications and sending it to multiple users is an easy task in FlinkISO.</p>\r\n\r\n\r\n\r\n<p>Type in the &#39;Title&#39; of notification, select &#39;Notification Type&#39; from drop-down list, type in the notification &#39;Message&#39;. Specify Start, End Date for notifications. Select user, be it a single user or many, upon submit, this notification will appear on their dashboard for the period you specified.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-10-01 16:43:17', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-10-01 16:44:10', '5297b2e7-6e50-40ce-8407-2d8f0a000005', ''),
('542be6f3-4f70-409f-8207-3659118438bd', 330, '366ac1f4-199b-11e3-9f46-c709d410d2ec', 'Add New Suggestion', 'suggestionForms', 'add_ajax, edit, approve', '<p>Suggestion can be sent to MR using this &#39;Add New Suggestion&#39; form.</p>\r\n\r\n\r\n\r\n<p>Select an employee(only MR Employees can be seen in the list) you want to send suggestion to, fill in other details e.g. &#39;Title&#39; for suggestion, Activity, Suggestion, Remark. To add this suggestion to CAPA, click on &#39;Yes&#39;. Submit the form to send suggestion to selected MR Employee.</p>', 2, 1, 0, NULL, 0, '53c508c9-250c-4867-9b82-3e5d118438bd', '523a0abb-21e0-4b44-a219-6142c6c32681', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '2014-10-01 17:05:15', '53c508ca-d868-4d71-b3a1-3e5d118438bd', '-1', '-1', '2014-10-01 17:05:15', '5297b2e7-6e50-40ce-8407-2d8f0a000005', '');


-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `histories`
--

CREATE TABLE IF NOT EXISTS `histories` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `model_name` varchar(225) DEFAULT NULL,
  `controller_name` varchar(250) DEFAULT NULL,
  `action` varchar(225) DEFAULT NULL,
  `record_id` varchar(36) DEFAULT NULL,
  `get_values` text,
  `pre_post_values` text,
  `post_values` text,
  `user_session_id` varchar(36) DEFAULT NULL,
  `branch_id` varchar(36) NOT NULL,
  `department_id` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `housekeepings`
--

CREATE TABLE IF NOT EXISTS `housekeepings` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `housekeeping_responsibility_id` varchar(36) NOT NULL,
  `employee_id` varchar(36) DEFAULT NULL,
  `activity_description` text,
  `remarks` text,
  `task_performed` tinyint(2) DEFAULT '0' COMMENT '0=Unread, 1=Yes, 2=No''',
  `comments` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `housekeeping_checklists`
--

CREATE TABLE IF NOT EXISTS `housekeeping_checklists` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `description` text,
  `branch_id` varchar(36) NOT NULL,
  `department_id` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `housekeeping_responsibilities`
--

CREATE TABLE IF NOT EXISTS `housekeeping_responsibilities` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `housekeeping_checklist_id` varchar(250) NOT NULL,
  `employee_id` varchar(36) DEFAULT NULL,
  `description` text,
  `schedule_id` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
--
-- @#@ -- Table structure for table `incidents`
--
CREATE TABLE IF NOT EXISTS `incidents` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(120) NOT NULL,
  `incident_classification_id` varchar(36) DEFAULT NULL,
  `reported_by` varchar(36) NOT NULL,
  `department_id` varchar(36) DEFAULT NULL,
  `incident_date` date DEFAULT NULL,
  `incident_reported_lag_time` time DEFAULT NULL,
  `branch_id` varchar(36) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `location_details` varchar(255) DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `activity_details` text,
  `damage_details` text,
  `first_aid_provided` tinyint(1) DEFAULT NULL,
  `first_aid_details` text,
  `first_aid_provided_by` varchar(36) DEFAULT NULL,
  `person_responsible_id` varchar(36) DEFAULT NULL,
  `corrective_preventive_action_id` varchar(36) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `incident_classifications`
--

CREATE TABLE IF NOT EXISTS `incident_classifications` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `incident_affected_personals`
--

CREATE TABLE IF NOT EXISTS `incident_affected_personals` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `incident_id` varchar(36) DEFAULT NULL,
  `person_type` tinyint(1) DEFAULT NULL COMMENT '0=employee 1=visitor 2=contractor',
  `employee_id` varchar(36) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `department_id` varchar(36) DEFAULT NULL,
  `designation_id` varchar(36) DEFAULT NULL,
  `age` int(2) DEFAULT NULL,
  `gender` varchar(12) DEFAULT NULL,
  `first_aid_provided` tinyint(1) DEFAULT NULL,
  `first_aid_details` text,
  `first_aid_provided_by` varchar(36) DEFAULT NULL,
  `follow_up_action_taken` varchar(36) DEFAULT NULL COMMENT '1.went home, 2 hospitalises 3. resumed duty 4 other',
  `other` text,
  `illhealth_reported` tinyint(1) DEFAULT NULL,
  `normal_work_affected` tinyint(1) DEFAULT NULL,
  `number_of_work_affected_dates` int(9) DEFAULT NULL,
  `incident_investigator_id` varchar(36) DEFAULT NULL,
  `date_of_interview` date DEFAULT NULL,
  `investigation_interview_findings` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `incident_investigations`
--

CREATE TABLE IF NOT EXISTS `incident_investigations` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `incident_id` varchar(36) NOT NULL,
  `incident_affected_personal_id` varchar(36) DEFAULT NULL,
  `incident_witness_id` varchar(36) DEFAULT NULL,
  `reference_number` varchar(20) DEFAULT NULL,
  `incident_investigator_id` varchar(36) DEFAULT NULL,
  `investigation_date_from` date DEFAULT NULL,
  `investigation_date_to` date DEFAULT NULL,
  `title` varchar(120) NOT NULL,
  `control_measures_currently_in_place` text NOT NULL,
  `summery_of_findings` text NOT NULL,
  `reason_for_incidence` text NOT NULL,
  `immediate_action_taken` text NOT NULL,
  `risk_assessment` text NOT NULL,
  `investigation_reviewd_by` text,
  `action_taken` text,
  `corrective_preventive_action_id` varchar(36) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `incident_investigators`
--

CREATE TABLE IF NOT EXISTS `incident_investigators` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(36) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `department_id` varchar(36) DEFAULT NULL,
  `designation_id` varchar(36) DEFAULT NULL,
  `age` int(2) DEFAULT NULL,
  `gender` varchar(12) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `incident_witnesses`
--

CREATE TABLE IF NOT EXISTS `incident_witnesses` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `incident_id` varchar(36) DEFAULT NULL,
  `person_type` tinyint(1) DEFAULT NULL COMMENT '0=employee 1=visitor 2=contractor',
  `employee_id` varchar(36) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `department_id` varchar(36) DEFAULT NULL,
  `designation_id` varchar(36) DEFAULT NULL,
  `age` int(2) DEFAULT NULL,
  `gender` varchar(12) DEFAULT NULL,
  `investigation_interview_taken_by` varchar(36) DEFAULT NULL,
  `date_of_interview` date DEFAULT NULL,
  `investigation_interview_findings` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
--
-- @#@ -- Table structure for table `internal_audits`
--

CREATE TABLE IF NOT EXISTS `internal_audits` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `internal_audit_plan_id` varchar(36) DEFAULT NULL,
  `internal_audit_plan_department_id` varchar(36) NOT NULL,
  `department_id` varchar(36) NOT NULL,
  `branch_id` varchar(36) NOT NULL,
  `section` varchar(50) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `list_of_trained_internal_auditor_id` varchar(36) NOT NULL,
  `employee_id` varchar(36) NOT NULL,
  `clauses` varchar(250) NOT NULL,
  `question_asked` text NOT NULL,
  `finding` text NOT NULL,
  `non_conformity_found` tinyint(1) NOT NULL,
  `corrective_preventive_action_id` varchar(36) DEFAULT NULL,
  `current_status` tinyint(1) NOT NULL COMMENT '0: Open; 1: Close',
  `employeeId` varchar(36) NOT NULL,
  `target_date` date NOT NULL,
  `notes` text NOT NULL,
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `publish` tinyint(1) DEFAULT '0',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `internal_audit_details`
--

CREATE TABLE IF NOT EXISTS `internal_audit_details` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `internal_audit_id` varchar(36) NOT NULL,
  `employee_id` varchar(36) NOT NULL,
  `nc_found` tinytext NOT NULL,
  `question` text NOT NULL,
  `findings` text NOT NULL,
  `clause_number` varchar(20) NOT NULL,
  `current_status` varchar(100) NOT NULL,
  `comments` text,
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `publish` tinyint(1) DEFAULT '0',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `internal_audit_plans`
--

CREATE TABLE IF NOT EXISTS `internal_audit_plans` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `schedule_date_from` datetime NOT NULL,
  `schedule_date_to` datetime NOT NULL,
  `clauses` text NULL,
  `audit_from` datetime NULL,
  `audit_to` datetime NULL,
  `list_of_trained_internal_auditor_id` varchar(36) NULL,
  `show_on_timeline` tinyint(1) NULL DEFAULT '0',
  `notify_users` tinyint(1) NULL DEFAULT '0',
  `notify_users_emails` tinyint(1) NULL DEFAULT '0',
  `note` text NULL,
  `publish` tinyint(1) DEFAULT '0',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `internal_audit_plan_branches`
--

CREATE TABLE IF NOT EXISTS `internal_audit_plan_branches` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `internal_audit_plan_id` varchar(36) NOT NULL,
  `branch_id` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `internal_audit_plan_departments`
--

CREATE TABLE IF NOT EXISTS `internal_audit_plan_departments` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `internal_audit_plan_id` varchar(36) NOT NULL,
  `department_id` varchar(36) NOT NULL,
  `branch_id` varchar(36) NOT NULL,
  `clauses` varchar(250) NOT NULL,
  `employee_id` varchar(36) NOT NULL,
  `list_of_trained_internal_auditor_id` varchar(36) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `note` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `internal_audit_questions`
--

CREATE TABLE IF NOT EXISTS `internal_audit_questions` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` varchar(36) NOT NULL,
  `clause` varchar(3) NOT NULL,
  `title` varchar(250) NOT NULL,
  `publish` tinyint(1) DEFAULT NULL,
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0',
  `created` datetime NOT NULL,
  `created_by` varchar(36) NOT NULL,
  `modified` datetime NOT NULL,
  `modified_by` varchar(36) NOT NULL,
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `system_table_id` varchar(36) DEFAULT NULL,
  `branchid` varchar(36) DEFAULT NULL,
  `departmentid` varchar(36) DEFAULT NULL,
  `master_list_of_format_id` varchar(36) NOT NULL,
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `internal_audit_questions`
--

INSERT INTO `internal_audit_questions` (`id`, `sr_no`, `department_id`, `clause`, `title`, `publish`, `record_status`, `status_user_id`, `soft_delete`, `created`, `created_by`, `modified`, `modified_by`, `approved_by`, `prepared_by`, `system_table_id`, `branchid`, `departmentid`, `master_list_of_format_id`, `company_id`) VALUES
('cc426170-cfa2-11e3-bd0d-74867a422274', 1, '523a0abb-21e0-4b44-a219-6142c6c32689', '', 'Are the customer requirements available?', 1, 0, NULL, 0, NOW(), '535e2638-9a18-4f30-bd0f-1acae386fb56', NOW(), '535e2638-9a18-4f30-bd0f-1acae386fb56', NULL, NULL, NULL, NULL, NULL, '', NULL),
('b91027a2-cfa3-11e3-bd0d-74867a422274', 2, '523a0abb-21e0-4b44-a219-6142c6c32689', '', 'Is a product development plan available and are the targets maintained?', 1, 0, NULL, 0, '2014-04-29 19:09:44', '535e2638-9a18-4f30-bd0f-1acae386fb56', '2014-04-29 19:09:44', '535e2638-9a18-4f30-bd0f-1acae386fb56', NULL, NULL, NULL, NULL, NULL, '', NULL),
('b9103e49-cfa3-11e3-bd0d-74867a422274', 3, '523a0abb-21e0-4b44-a219-6142c6c32689', '', 'Are the resources for the realisation of the product development planned?', 1, 0, NULL, 0, '2014-04-29 19:09:44', '535e2638-9a18-4f30-bd0f-1acae386fb56', '2014-04-29 19:09:44', '535e2638-9a18-4f30-bd0f-1acae386fb56', NULL, NULL, NULL, NULL, NULL, '', NULL);


--
-- @#@ -- Table structure for table `internet_usage_details`
--

CREATE TABLE IF NOT EXISTS `internet_usage_details` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `internet_provider_name` varchar(36) NOT NULL,
  `plan_details` text NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `download` int(11) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `short_code` varchar(5) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `sr_no`, `name`, `short_code`, `publish`, `record_status`, `status_user_id`, `soft_delete`, `branchid`, `departmentid`, `created_by`, `created`, `modified_by`, `approved_by`, `prepared_by`, `modified`, `system_table_id`, `master_list_of_format_id`) VALUES
('366ac1f4-199b-11e3-9f46-c709d410d2ec', 1, 'English', 'eng', 1, 0, NULL, 0, '', '', '', '0000-00-00 00:00:00', '', NULL, NULL, '0000-00-00 00:00:00', '5297b2e7-e44c-41b5-a4b2-2d8f0a000005', '0'),
('52dfabe2-1f50-41d8-af86-04b2c6c3268c', 2, 'Hindi', 'hin', 1, 0, NULL, 0, '', '', '', '0000-00-00 00:00:00', '', NULL, NULL, '0000-00-00 00:00:00', '5297b2e7-e44c-41b5-a4b2-2d8f0a000005', ''),
('52dfad0b-5014-4e29-98ef-136dc6c3268c', 3, 'Gujarati', 'gu', 1, 0, NULL, 0, '', '', '', '0000-00-00 00:00:00', '', NULL, NULL, '0000-00-00 00:00:00', '5297b2e7-e44c-41b5-a4b2-2d8f0a000005', ''),
('52dfad1b-6f7c-4150-9747-04afc6c3268c', 4, 'Marathi', 'mr', 1, 0, NULL, 0, '', '', '', '0000-00-00 00:00:00', '', NULL, NULL, '0000-00-00 00:00:00', '5297b2e7-e44c-41b5-a4b2-2d8f0a000005', ''),
('a7475b5d-f170-11e3-bbd3-74867a422274', 5, 'German', 'de_DE', 1, 0, NULL, 0, '', '', '', '0000-00-00 00:00:00', '', NULL, NULL, '0000-00-00 00:00:00', '5297b2e7-e44c-41b5-a4b2-2d8f0a000005', ''),
('a74774d4-f170-11e3-bbd3-74867a422274', 6, 'Spanish', 'es_ES', 1, 0, NULL, 0, '', '', '', '0000-00-00 00:00:00', '', NULL, NULL, '0000-00-00 00:00:00', '5297b2e7-e44c-41b5-a4b2-2d8f0a000005', ''),
('53e22a00-5c90-4299-b817-5263118438bd', 7, 'Portuguese', 'pt_PT', 1, 0, NULL, 0, '', '', '', '0000-00-00 00:00:00', '', NULL, NULL, '0000-00-00 00:00:00', '5297b2e7-e44c-41b5-a4b2-2d8f0a000005', ''),
('53e22a18-9d90-44cb-ab23-53ce118438bd', 8, 'Italian', 'it_IT', 1, 0, NULL, 0, '', '', '', '0000-00-00 00:00:00', '', NULL, NULL, '0000-00-00 00:00:00', '5297b2e7-e44c-41b5-a4b2-2d8f0a000005', ''),
('543272d2-18b0-46f7-ade3-1a65118438bd', 9, 'French', 'fr_FR', 1, 0, NULL, 0, '', '', '', '0000-00-00 00:00:00', '', NULL, NULL, '0000-00-00 00:00:00', '5297b2e7-e44c-41b5-a4b2-2d8f0a000005', ''),
('fe00b2d2-4d46-11e4-adf3-74867a434840', 10, 'Arabic', 'ar_AE', 1, 0, NULL, 0, '', '', '', '0000-00-00 00:00:00', '', NULL, NULL, '0000-00-00 00:00:00', '5297b2e7-e44c-41b5-a4b2-2d8f0a000005', ''),
('10672f16-9d54-11e4-9c6f-74867a434840', 11, 'Chinese (Simplified)', 'zh_CN', 1, 0, NULL, 0, '', '', '', '0000-00-00 00:00:00', '', NULL, NULL, '0000-00-00 00:00:00', '5297b2e7-e44c-41b5-a4b2-2d8f0a000005', ''),
('baab5fe1-9d87-11e4-9c6f-74867a434840', 12, 'Chinese (Traditional)', 'zh_TW', 1, 0, NULL, 0, '', '', '', '0000-00-00 00:00:00', '', NULL, NULL, '0000-00-00 00:00:00', '5297b2e7-e44c-41b5-a4b2-2d8f0a000005', '');

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `list_of_acceptable_suppliers`
--

CREATE TABLE IF NOT EXISTS `list_of_acceptable_suppliers` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_registration_id` varchar(36) NOT NULL,
  `supplier_category_id` varchar(36) NOT NULL,
  `remarks` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `list_of_computers`
--

CREATE TABLE IF NOT EXISTS `list_of_computers` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(36) NOT NULL COMMENT 'person owns the machine',
  `make` varchar(20) NOT NULL COMMENT 'laptop pc notebook etc',
  `serial_number` varchar(120) DEFAULT NULL,
  `supplier_registration_id` varchar(36) DEFAULT NULL,
  `purchase_order_id` varchar(36) DEFAULT NULL,
  `price` int(2) DEFAULT NULL,
  `installation_date` date NOT NULL,
  `other_details` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `serial_number` (`serial_number`,`company_id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `list_of_computer_list_of_softwares`
--

CREATE TABLE IF NOT EXISTS `list_of_computer_list_of_softwares` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `list_of_computer_id` varchar(36) NOT NULL,
  `list_of_software_id` varchar(36) NOT NULL,
  `installation_date` datetime NOT NULL,
  `other_details` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `list_of_measuring_devices_for_calibrations`
--

CREATE TABLE IF NOT EXISTS `list_of_measuring_devices_for_calibrations` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` varchar(36) DEFAULT NULL,
  `least_count` varchar(20) DEFAULT '0',
  `required_accuracy` varchar(20) DEFAULT '0',
  `range` varchar(20) DEFAULT '0',
  `default_calibration` varchar(20) DEFAULT '0',
  `required_calibration` varchar(20) DEFAULT '0',
  `actual_calibration` varchar(20) DEFAULT '0',
  `calibration_frequency` varchar(36) DEFAULT '0',
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `list_of_softwares`
--

CREATE TABLE IF NOT EXISTS `list_of_softwares` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'software name',
  `software_type_id` varchar(36) NOT NULL,
  `software_usage` text,
  `software_details` text,
  `license_key` varchar(120) DEFAULT NULL,
  `storage_device_number` varchar(40) NOT NULL,
  `employee_id` varchar(36) NOT NULL,
  `backup_required` tinyint(1) NOT NULL,
  `schedule_id` varchar(36) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `list_of_trained_internal_auditors`
--

CREATE TABLE IF NOT EXISTS `list_of_trained_internal_auditors` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(36) NOT NULL,
  `training_id` varchar(36) NOT NULL,
  `note` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `master_list_of_formats`
--

CREATE TABLE IF NOT EXISTS `master_list_of_formats` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(120) NOT NULL,
  `document_number` varchar(12) NOT NULL,
  `issue_number` varchar(2) NOT NULL,
  `revision_number` int(2) DEFAULT NULL,
  `revision_date` date NOT NULL,
  `document_details` text CHARACTER SET utf8 COLLATE utf8_bin,
  `work_instructions` text CHARACTER SET utf8 COLLATE utf8_bin,
  `prepared_by` varchar(36) NOT NULL,
  `approved_by` varchar(36) NOT NULL,
  `archived` tinyint(1) DEFAULT '0',
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `company_id` varchar(36) DEFAULT NULL,
  `system_table_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `master_list_of_formats`
--

INSERT INTO `master_list_of_formats` (`id`, `sr_no`, `title`, `document_number`, `issue_number`, `revision_number`, `revision_date`, `document_details`, `work_instructions`, `prepared_by`, `approved_by`, `archived`, `publish`, `record_status`, `status_user_id`, `soft_delete`, `branchid`, `departmentid`, `created_by`, `created`, `modified_by`, `modified`, `company_id`, `system_table_id`) VALUES
('523a0abb-21e0-4b44-a219-6142c6c3268c', 1, 'MASTER LIST OF FORMATS', 'MR001', '1', 1, NOW(), NULL, '', '', '', 1, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-3538-4360-97fc-2d8f0a000005'),
('523aad05-65ec-450f-a4c1-63b6c6c3268c', 4, 'DOCUMENTS CHANGE REQUEST', 'MR004', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e6-82b4-4d86-bb85-2d8f0a000005'),
('523aad3b-6a50-480a-95b7-63e3c6c3268c', 5, 'DOCUMENT AMENDMENT RECORD SHEET', 'MR005', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-136c-4479-a06c-2d8f0a000005'),
('523aad5d-a4e0-4363-bfd0-63bec6c3268c', 7, 'MASTER LIST OF WORK INSTRUCTIONS', 'MR007', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-874c-4858-bcdc-2d8f0a000005'),
('523aad7c-e838-4472-a2e4-63e4c6c3268c', 8, 'LIST OF RECORDS', 'MR008', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '-1'),
('523aad9d-fd28-4ad3-bacf-6200c6c3268c', 3, 'SUGGESTION FORMS', 'MR003', '1', 1, Now(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-265c-4008-812b-2d8f0a000005'),
('523aadba-be40-4687-901d-6efac6c3268c', 9, 'QUALITY OBJECTIVES MONITORING CHART', 'MR009', '1', 1, NOW(), NULL, '', '', '', 0, 0, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, NULL),
('523aadfb-d9e8-43ec-b5fb-607bc6c3268c', 10, 'AGENDA FOR M.R.M', 'MR010', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-1678-45a0-b8a3-2d8f0a000005'),
('523aae1b-0ee4-4da2-a56f-63e5c6c3268c', 11, 'MINUTES OF M.R.M', 'MR011', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-cd9c-41c5-990a-2d8f0a000005'),
('523aae38-ebe8-4818-bdd5-6409c6c3268c', 13, 'INTERNAL AUDIT PLAN', 'MR012', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-4314-466d-9358-2d8f0a000005'),
('523aae54-4bd8-45ef-9d98-63b6c6c3268c', 14, 'AUDIT FINDINGS', 'MR013', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-33bc-4843-810e-2d8f0a000005'),
('523aae88-010c-42b3-a6cc-63e6c6c3268c', 15, 'N.C. REPORT', 'QC001', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-8aa0-4c76-ad42-2d8f0a000005'),
('523ab320-2184-48e9-8df4-6409c6c3268c', 6, 'INTERNAL AUDIT SUMMARY', 'MR006', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-2188-4cb8-8673-2d8f0a000005'),
('523ab336-75c8-4920-a2ca-6efac6c3268c', 2, 'CORRECTIVE ACTION, PREVENTIVE ACTION', 'MR002', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6',NOW(), NULL, '5297b2e7-8aa0-4c76-ad42-2d8f0a000005'),
('523ab353-4f44-4b98-aa74-63e6c6c3268c', 25, 'TRAINING SCHEDULE', 'HR002', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-7be4-4cdb-8f1b-2d8f0a000005'),
('523ab3a7-2924-4cad-af28-63b6c6c3268c', 19, 'INDIVIDUAL EMPLOYEES TRAINING RECORDS', 'HR003', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-7be4-4cdb-8f1b-2d8f0a000005'),
('523ab3e5-c2bc-4b23-9a80-6f23c6c3268c', 24, 'TRAINING COURSE DETAILS', 'HR004', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-9ad0-46a0-a109-2d8f0a000005'),
('523ab400-9658-462a-b714-6f24c6c3268c', 26, 'TRAINING EVALUATION', 'HR005', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-cd0c-4159-be0a-2d8f0a000005'),
('523ab43b-1b94-40fd-be4b-63e5c6c3268c', 21, 'SKILL CHART/JOB DESCRIPTION', 'HR005', '1', 1, NOW(), NULL, '', '', '', 0, 0, 0, NULL, 0, '', '', '', NOW(), '', NOW(), NULL, '00'),
('523ab47b-92fc-49a5-b57f-63e6c6c3268c', 23, 'TRAINING NEED IDENTIFICATION', 'HR006', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-66e4-4b2d-af02-2d8f0a000005'),
('523ab49b-cb24-4922-bdaa-63b6c6c3268c', 18, 'INDUCTION TRAINING FOR NEW EMPLOYEES', 'HR007', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '', NOW(), NULL, '5297b2e7-0b74-4d2d-ba16-2d8f0a000005'),
('523ab49b-cb24-4922-bdaa-63b6c6c3268d', 20, 'LIST OF TRAINERS', 'HR007', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-0b74-4d2d-ba16-2d8f0a000005'),
('523ab4b6-cf7c-4de5-918b-6f22c6c3268c', 17, 'PROFILE OF EMPLOYEES', 'HR001', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-959c-4892-b073-2d8f0a000005'),
('523ab4d8-13bc-4cc0-b01a-6f23c6c3268c', 33, 'FIRE EXTINGUISHER', 'AD001', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-a8a8-4778-8a17-2d8f0a000005'),
('523ab500-aa34-4864-8a8a-6200c6c3268c', 34, 'CHECK LIST FOR HOUSEKEEPING', 'AD002', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6',NOW(), NULL, '5297b2e7-db08-4f64-b91c-2d8f0a000005'),
('523ab522-bfe0-4f02-94da-63e5c6c3268c', 35, 'HOUSE KEEPING ZONE', 'AD003', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-68e0-48a9-a808-2d8f0a000005'),
('523ab546-442c-4a62-a092-6409c6c3268c', 16, 'LIST OF STANDARD/SPECIFICATION', 'MR014', '1', 1, NOW(), NULL, '', '', '', 0, 0, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '-1'),
('523ab56a-e744-4efe-8697-6efac6c3268c', 46, 'LIST OF MEASURING DEVICES', 'QC002', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-db8c-4cf3-8845-2d8f0a000005'),
('523ab5ba-75a8-45ba-aa12-6f22c6c3268c', 29, 'LIST OF ACCEPTABLE SUPPLIERS', 'PU001', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-27dc-4297-8ba9-2d8f0a000005'),
('523ab606-3e24-45f4-b5c6-6200c6c3268c', 47, 'LIST OF CRITICAL ITEMS', '30', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '-1'),
('523ab626-8e2c-4af3-98f8-63e5c6c3268c', 27, 'SUBCONTRACTOR REGISTRATION FORM', 'PU001', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-e574-48b5-99f2-2d8f0a000005'),
('523ab649-a0f0-4155-af50-6efac6c3268c', 28, 'SUPPLIER EVALUATION/RE- EVALUATION', 'PU003', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-48e8-44c6-a7a7-2d8f0a000005'),
('523ab676-3e8c-430c-8439-607bc6c3268c', 30, 'SUMMARY OF SUPPLIER EVALUATION', 'PU004', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW() , '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-5548-4bef-9c34-2d8f0a000005'),
('523ae218-b274-4894-8946-76a0c6c3268c', 32, 'DELIVERY CHALLANS', 'PU006', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-42a4-4424-a5bd-2d8f0a000005'),
('523ae24f-a540-4109-a836-76a1c6c3268c', 37, 'LIST OF PRODUCTS', 'QC005', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-22b0-4efd-bc01-2d8f0a000005'),
('523ae24f-a540-4109-a836-76v1c6c3268c', 36, 'LIST OF MATERIALS', 'QC005', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-b924-480e-bef9-2d8f0a000005'),
('523ae24f-a540-4109-a846-76a1c6c3268c', 38, 'MATERIAL LIST WITH SEHLF LIFE', 'QC005', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-b924-480e-bef9-2d8f0a000005'),
('523ae2ab-4a50-4093-81de-761fc6c3268c', 31, 'PURCHASE ORDER', 'PU002', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-f858-4fd8-9037-2d8f0a000005'),
('523ae2da-1ac8-4038-8cd2-7638c6c3268c', 41, 'DATA BACKUP LOG BOOK', 'ED005', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-eb34-446e-9245-2d8f0a000005'),
('523ae2f8-867c-43dd-86c9-769fc6c3268c', 42, 'LIST OF COMPUTERS', 'ED003', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-88d4-4f8a-b07c-2d8f0a000005'),
('523ae314-8228-4107-9095-76a0c6c3268c', 43, 'LIST OF SOFTWARES', 'ED002', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-f794-48f0-8beb-2d8f0a000005'),
('523ae34c-bcc0-4c7d-b7aa-75cec6c3268c', 44, 'LIST OF USERNAMES', 'ED006', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-0a9c-46e3-96a6-2d8f0a000005'),
('524587fc-8d94-48bc-b275-4062c6c3268c', 12, 'INTERNAL AUDIT', 'MR0015', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-2188-4cb8-8673-2d8f0a000005'),
('526eaf56-8700-41ff-9f29-152bc6c3268c', 45, 'CALIBRATION HISTORY', 'QC006', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6',NOW(), NULL, '5297b2e6-2098-4689-9301-2d8f0a000005'),
('528fb1d6-3300-43ff-b9fc-2f1fb6329401', 22, 'COMPETANCY MAPPING', 'HR009', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-c8f0-4481-9236-2d8f0a000005'),
('528fb246-728c-4ded-a990-2f21b6329401', 48, 'CUSTOMER FEEDBACKS', 'QC004', '9', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-6c44-4b87-84af-2d8f0a000005'),
('528fbe28-2118-4dc9-951b-04b1c6c3268c', 40, 'STOCK STATUS', 'BD002', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '53070c36-6bcc-44bf-a4ac-0ceccf971fe6'),
('528fbe28-2118-4dcc-951a-04b1c6c3268c', 39, 'STOCK', 'BD002', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5306fb50-f870-4ecc-849f-1bd6cf971fe6'),
('528fbe28-2118-4dcc-951a-12b1c6c3268c', 49, 'CUSTOMER COMPLAINTS', 'QC003', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5297b2e7-43cc-49c8-8562-2d8f0a000005'),
('528fbe28-2118-4dcc-951a-22b1c6c3268c', 51, 'CUSTOMER MEETINGS', 'BD001', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5306fb20-3f54-434a-a17b-0ceccf971fe6'),
('528fbe28-2118-4dcc-951a-22b1c6c3274c', 50, 'CLIENT PROFILE', 'BD001', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5306fae4-6334-4a84-8d2b-1c51cf971fe6'),
('528fbe28-2118-4dcc-951a-32b1c6c3268c', 52, 'PROPOSALS', 'BD002', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5306fb6b-8c90-4ed6-abe2-1c0bcf971fe6'),
('528fbe28-2118-4dcc-951b-32b1c6c3268c', 53, 'PROPOSAL FOLLOWUPS', 'BD003', '1', 1, NOW(), NULL, '', '', '', 0, 1, 0, NULL, 0, '', '', '', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), NULL, '5306fb7e-3df4-4d61-9265-1c51cf971fe6');
-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `master_list_of_format_branches`
--

CREATE TABLE IF NOT EXISTS `master_list_of_format_branches` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `master_list_of_format_id` varchar(36) NOT NULL,
  `branch_id` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `company_id` varchar(36) DEFAULT NULL,
  `system_table_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `master_list_of_format_branches`
--

INSERT INTO `master_list_of_format_branches` (`id`, `sr_no`, `master_list_of_format_id`, `branch_id`, `publish`, `record_status`, `status_user_id`, `soft_delete`, `branchid`, `departmentid`, `created_by`, `created`, `modified_by`, `approved_by`, `prepared_by`, `modified`, `company_id`, `system_table_id`) VALUES
('530724ef-ce30-4f40-aeec-1930cf971fe6', 1, '523aadfb-d9e8-43ec-b5fb-607bc6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-1678-45a0-b8a3-2d8f0a000005'),
('530729d4-285c-42d1-b160-1e5ecf971fe6', 2, '523aae54-4bd8-45ef-9d98-63b6c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-33bc-4843-810e-2d8f0a000005'),
('530729f5-a358-4288-8279-1eb0cf971fe6', 3, '526eaf56-8700-41ff-9f29-152bc6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e6-2098-4689-9301-2d8f0a000005'),
('53072a07-2e80-40bf-b694-0ceccf971fe6', 4, '523ab500-aa34-4864-8a8a-6200c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-db08-4f64-b91c-2d8f0a000005'),
('53072a17-a14c-49a5-b812-1e35cf971fe6', 5, '528fbe28-2118-4dcc-951a-22b1c6c3274c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5306fae4-6334-4a84-8d2b-1c51cf971fe6'),
('53072a26-0f20-4c79-bf34-1eb0cf971fe6', 6, '528fb1d6-3300-43ff-b9fc-2f1fb6329401', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-c8f0-4481-9236-2d8f0a000005'),
('53072a34-9cb8-4b6d-88ea-0ceccf971fe6', 7, '523ab336-75c8-4920-a2ca-6efac6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-8aa0-4c76-ad42-2d8f0a000005'),
('53072a4e-2f44-4ab2-8401-1e39cf971fe6', 8, '528fbe28-2118-4dcc-951a-12b1c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-43cc-49c8-8562-2d8f0a000005'),
('53072a61-c0cc-41eb-b82d-192ccf971fe6', 9, '528fb246-728c-4ded-a990-2f21b6329401', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-6c44-4b87-84af-2d8f0a000005'),
('53072a6f-8484-44bd-9112-1c56cf971fe6', 10, '528fbe28-2118-4dcc-951a-22b1c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5306fb20-3f54-434a-a17b-0ceccf971fe6'),
('53072a7f-77ec-4b3a-a6c6-1930cf971fe6', 11, '523ae2da-1ac8-4038-8cd2-7638c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-eb34-446e-9245-2d8f0a000005'),
('53072b2c-b4d0-4f56-9732-1eb0cf971fe6', 12, '523ae218-b274-4894-8946-76a0c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-42a4-4424-a5bd-2d8f0a000005'),
('53072b59-f068-4db8-a3ce-1e5ecf971fe6', 13, '523aad3b-6a50-480a-95b7-63e3c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-136c-4479-a06c-2d8f0a000005'),
('53072d9f-e69c-43c1-901f-192ccf971fe6', 14, '523aad05-65ec-450f-a4c1-63b6c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e6-82b4-4d86-bb85-2d8f0a000005'),
('53072dea-39ac-4171-abc2-1e5ecf971fe6', 15, '523ab4d8-13bc-4cc0-b01a-6f23c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-a8a8-4778-8a17-2d8f0a000005'),
('53072df8-76d8-4013-9671-1e39cf971fe6', 16, '523ab522-bfe0-4f02-94da-63e5c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-68e0-48a9-a808-2d8f0a000005'),
('53072e25-0dcc-449c-8e95-1eb0cf971fe6', 17, '523ab3a7-2924-4cad-af28-63b6c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-7be4-4cdb-8f1b-2d8f0a000005'),
('53072e3b-3674-4f6f-b896-1e5ecf971fe6', 18, '524587fc-8d94-48bc-b275-4062c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-2188-4cb8-8673-2d8f0a000005'),
('53072e48-3694-4dd2-baa5-1e39cf971fe6', 19, '523aae38-ebe8-4818-bdd5-6409c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-4314-466d-9358-2d8f0a000005'),
('53072e58-ce48-44d8-bac6-1be7cf971fe6', 20, '523ab320-2184-48e9-8df4-6409c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-2188-4cb8-8673-2d8f0a000005'),
('53072e6e-dee0-4da0-b4eb-192ccf971fe6', 21, '523ab5ba-75a8-45ba-aa12-6f22c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-27dc-4297-8ba9-2d8f0a000005'),
('53072e98-9684-4e00-ad23-0ceccf971fe6', 22, '523ae2f8-867c-43dd-86c9-769fc6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-88d4-4f8a-b07c-2d8f0a000005'),
('53072ebd-98bc-4311-8f53-1930cf971fe6', 23, '523ab606-3e24-45f4-b5c6-6200c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '-1'),
('53072eda-16a0-4f74-bcfe-1eb0cf971fe6', 24, '523ab56a-e744-4efe-8697-6efac6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-db8c-4cf3-8845-2d8f0a000005'),
('53072ee9-604c-4b19-8768-1e35cf971fe6', 25, '523ae24f-a540-4109-a836-76a1c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-22b0-4efd-bc01-2d8f0a000005'),
('53072fc6-6bfc-4ceb-a563-192ccf971fe6', 27, '523aad7c-e838-4472-a2e4-63e4c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '-1'),
('53072fd9-27bc-4c84-bb86-1e5ecf971fe6', 28, '523ae314-8228-4107-9095-76a0c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-f794-48f0-8beb-2d8f0a000005'),
('53072ff9-280c-4e2d-b5eb-1be7cf971fe6', 29, '523ab546-442c-4a62-a092-6409c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '-1'),
('53073074-cd1c-480b-9f2d-1ea1cf971fe6', 30, '523ab49b-cb24-4922-bdaa-63b6c6c3268d', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-0b74-4d2d-ba16-2d8f0a000005'),
('53073085-0e48-4280-ad1b-0ceccf971fe6', 31, '523ae34c-bcc0-4c7d-b7aa-75cec6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-0a9c-46e3-96a6-2d8f0a000005'),
('53073098-26ec-4b2f-adb7-1e35cf971fe6', 32, '523a0abb-21e0-4b44-a219-6142c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-3538-4360-97fc-2d8f0a000005'),
('530730af-870c-4217-b7be-192ccf971fe6', 33, '523aad5d-a4e0-4363-bfd0-63bec6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-874c-4858-bcdc-2d8f0a000005'),
('530730c1-b3b8-4320-9e3f-1e39cf971fe6', 34, '523ae24f-a540-4109-a846-76a1c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-b924-480e-bef9-2d8f0a000005'),
('530730cf-da74-477e-98fe-1930cf971fe6', 35, '523aae1b-0ee4-4da2-a56f-63e5c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-cd9c-41c5-990a-2d8f0a000005'),
('530730fd-9a7c-4731-a203-1eb0cf971fe6', 36, '523aae88-010c-42b3-a6cc-63e6c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-8aa0-4c76-ad42-2d8f0a000005'),
('5307311e-1d78-481c-84cd-1e39cf971fe6', 37, '523ab4b6-cf7c-4de5-918b-6f22c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-959c-4892-b073-2d8f0a000005'),
('5307312e-eb10-41e4-bd02-1930cf971fe6', 38, '528fbe28-2118-4dcc-951b-32b1c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5306fb7e-3df4-4d61-9265-1c51cf971fe6'),
('5307313b-e844-4d77-80e8-1ea1cf971fe6', 39, '528fbe28-2118-4dcc-951a-32b1c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5306fb6b-8c90-4ed6-abe2-1c0bcf971fe6'),
('5307314a-9af4-4805-a97c-192ccf971fe6', 40, '523ae2ab-4a50-4093-81de-761fc6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-f858-4fd8-9037-2d8f0a000005'),
('5307317a-ec8c-4495-bfa0-1e5ecf971fe6', 41, '523aadba-be40-4687-901d-6efac6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '-1'),
('53073191-1b7c-4c4b-bc2c-1be7cf971fe6', 42, '528fbe28-2118-4dcc-951a-04b1c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5306fb50-f870-4ecc-849f-1bd6cf971fe6'),
('530731da-6b1c-46a6-9579-1f71cf971fe6', 43, '528fbe28-2118-4dc9-951b-04b1c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '53070c36-6bcc-44bf-a4ac-0ceccf971fe6'),
('530731e5-a8c0-46a3-8b5f-1f73cf971fe6', 44, '523ab626-8e2c-4af3-98f8-63e5c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-e574-48b5-99f2-2d8f0a000005'),
('53073200-b88c-4dd1-b795-1930cf971fe6', 45, '523aad9d-fd28-4ad3-bacf-6200c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-265c-4008-812b-2d8f0a000005'),
('5307320c-1e94-4f1a-ac5b-1e5ecf971fe6', 46, '523ab676-3e8c-430c-8439-607bc6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-5548-4bef-9c34-2d8f0a000005'),
('53073217-8934-48be-baa1-1c56cf971fe6', 47, '523ab649-a0f0-4155-af50-6efac6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-48e8-44c6-a7a7-2d8f0a000005'),
('53073224-42c0-4304-aab2-1f71cf971fe6', 48, '523ab3e5-c2bc-4b23-9a80-6f23c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-9ad0-46a0-a109-2d8f0a000005'),
('53073231-5854-4e3b-b8c5-1f73cf971fe6', 49, '523ab400-9658-462a-b714-6f24c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-cd0c-4159-be0a-2d8f0a000005'),
('5307323c-fe08-4eb2-b9da-1be7cf971fe6', 50, '523ab47b-92fc-49a5-b57f-63e6c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-66e4-4b2d-af02-2d8f0a000005'),
('53073250-81c0-4d4a-ab56-1e5ecf971fe6', 51, '523ab353-4f44-4b98-aa74-63e6c6c3268c', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-b60c-4641-aca5-2d8f0a000005'),
('5322de1e-f9ec-46c8-99d6-0e8451f38a45', 57, '53197557-683c-4832-b16d-453751f38a45', '530b42f9-2c60-479c-b7e9-1a0bb6329416', 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530b42fa-b30c-461c-a81c-1a0bb6329416', NOW(), '530b42fa-b30c-461c-a81c-1a0bb6329416', NULL, NULL, NOW(), '530b42f9-2ee4-4545-a815-1a0bb6329416', '53183ebc-fd3c-451e-84b7-21d5cf971fe6'),
('53202ce2-92b4-499e-b5a5-f96251f38a45', 56, '53202c95-03b8-46c9-9c42-f9ce51f38a45', '530b42f9-2c60-479c-b7e9-1a0bb6329416', 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530b42fa-b30c-461c-a81c-1a0bb6329416', NOW(), '530b42fa-b30c-461c-a81c-1a0bb6329416', NULL, NULL, NOW(), '530b42f9-2ee4-4545-a815-1a0bb6329416', '53202c58-1f2c-403e-99d3-f95f51f38a45'),
('5322e0ea-c358-4cde-9c59-0f5251f38a45', 58, '5322e0ea-4ae4-4c34-ba15-0f5251f38a45', '530b42f9-2c60-479c-b7e9-1a0bb6329416', 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530b42fa-b30c-461c-a81c-1a0bb6329416', NOW(), '530b42fa-b30c-461c-a81c-1a0bb6329416', NULL, NULL, NOW(), '530b42f9-2ee4-4545-a815-1a0bb6329416', '5297b2e7-761c-4e6a-b6dd-2d8f0a000005'),
('532c3d9f-3f68-4ac8-8fce-458a51f38a45', 61, '532c3d06-8c2c-4443-8311-458a51f38a45', '530b42f9-2c60-479c-b7e9-1a0bb6329416', 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '523a0abb-21e0-4b44-a219-6142c6c32685', '530d86cc-96d4-49f3-a126-1d42b6329416', NOW(), '530d86cc-96d4-49f3-a126-1d42b6329416', NULL, NULL, NOW(), '530b42f9-2ee4-4545-a815-1a0bb6329416', '532c3cd5-494c-4da6-8ad8-46ca51f38a45'),
('532c3de6-d42c-47ef-80ba-460951f38a45', 62, '532c3de6-6f5c-432f-aeae-460951f38a45', '530da1a8-6238-428b-a395-0329b6329416', 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '523a0abb-21e0-4b44-a219-6142c6c32685', '530d86cc-96d4-49f3-a126-1d42b6329416', NOW(), '530d86cc-96d4-49f3-a126-1d42b6329416', NULL, NULL, NOW(), '530b42f9-2ee4-4545-a815-1a0bb6329416', '532c3cd5-494c-4da6-8ad8-46ca51f38a45');

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `master_list_of_format_departments`
--

CREATE TABLE IF NOT EXISTS `master_list_of_format_departments` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `master_list_of_format_id` varchar(36) NOT NULL,
  `department_id` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `company_id` varchar(36) DEFAULT NULL,
  `system_table_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `master_list_of_format_departments`
--

INSERT INTO `master_list_of_format_departments` (`id`, `sr_no`, `master_list_of_format_id`, `department_id`, `publish`, `record_status`, `status_user_id`, `soft_delete`, `branchid`, `departmentid`, `created_by`, `created`, `modified_by`, `approved_by`, `prepared_by`, `modified`, `company_id`, `system_table_id`) VALUES
('530724ef-f76c-444e-8f8a-1930cf971fe6', 1, '523aadfb-d9e8-43ec-b5fb-607bc6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32681', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-1678-45a0-b8a3-2d8f0a000005'),
('530729d4-5860-4122-91ff-1e5ecf971fe6', 2, '523aae54-4bd8-45ef-9d98-63b6c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32681', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-33bc-4843-810e-2d8f0a000005'),
('530729f5-582c-4eca-8683-1eb0cf971fe6', 3, '526eaf56-8700-41ff-9f29-152bc6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32685', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e6-2098-4689-9301-2d8f0a000005'),
('53072a07-801c-48e8-9f8c-0ceccf971fe6', 4, '523ab500-aa34-4864-8a8a-6200c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32683', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-db08-4f64-b91c-2d8f0a000005'),
('53072a17-2de4-4630-8aed-1e35cf971fe6', 5, '528fbe28-2118-4dcc-951a-22b1c6c3274c', '523a0abb-21e0-4b44-a219-6142c6c32688', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5306fae4-6334-4a84-8d2b-1c51cf971fe6'),
('53072a26-5abc-4cb9-9ae2-1eb0cf971fe6', 6, '528fb1d6-3300-43ff-b9fc-2f1fb6329401', '523a0abb-21e0-4b44-a219-6142c6c32684', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-c8f0-4481-9236-2d8f0a000005'),
('53072a34-8db4-4836-b3ef-0ceccf971fe6', 7, '523ab336-75c8-4920-a2ca-6efac6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32681', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-8aa0-4c76-ad42-2d8f0a000005'),
('53072a4e-965c-484c-b954-1e39cf971fe6', 8, '528fbe28-2118-4dcc-951a-12b1c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32685', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-43cc-49c8-8562-2d8f0a000005'),
('53072a61-b5b0-43d1-85be-192ccf971fe6', 9, '528fb246-728c-4ded-a990-2f21b6329401', '523a0abb-21e0-4b44-a219-6142c6c32685', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-6c44-4b87-84af-2d8f0a000005'),
('53072a6f-6068-46e3-ad19-1c56cf971fe6', 10, '528fbe28-2118-4dcc-951a-22b1c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32688', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5306fb20-3f54-434a-a17b-0ceccf971fe6'),
('53072a7f-adcc-45a9-9173-1930cf971fe6', 11, '523ae2da-1ac8-4038-8cd2-7638c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32687', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-eb34-446e-9245-2d8f0a000005'),
('53072b2c-949c-446e-b6de-1eb0cf971fe6', 12, '523ae218-b274-4894-8946-76a0c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32682', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-42a4-4424-a5bd-2d8f0a000005'),
('53072b59-9348-410e-9a02-1e5ecf971fe6', 13, '523aad3b-6a50-480a-95b7-63e3c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32681', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-136c-4479-a06c-2d8f0a000005'),
('53072d9f-ee68-49e9-8aae-192ccf971fe6', 14, '523aad05-65ec-450f-a4c1-63b6c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32681', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e6-82b4-4d86-bb85-2d8f0a000005'),
('53072dea-fb00-4170-9a9e-1e5ecf971fe6', 15, '523ab4d8-13bc-4cc0-b01a-6f23c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32683', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-a8a8-4778-8a17-2d8f0a000005'),
('53072df8-acb8-4345-9793-1e39cf971fe6', 16, '523ab522-bfe0-4f02-94da-63e5c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32683', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-68e0-48a9-a808-2d8f0a000005'),
('53072e25-35dc-4aeb-92f7-1eb0cf971fe6', 17, '523ab3a7-2924-4cad-af28-63b6c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32684', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-7be4-4cdb-8f1b-2d8f0a000005'),
('53072e3b-b348-483c-975f-1e5ecf971fe6', 18, '524587fc-8d94-48bc-b275-4062c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32681', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-2188-4cb8-8673-2d8f0a000005'),
('53072e48-fe8c-44a8-9c9f-1e39cf971fe6', 19, '523aae38-ebe8-4818-bdd5-6409c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32681', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-4314-466d-9358-2d8f0a000005'),
('53072e58-d204-4de8-92c5-1be7cf971fe6', 20, '523ab320-2184-48e9-8df4-6409c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32681', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-2188-4cb8-8673-2d8f0a000005'),
('53072e6e-0b60-4ebe-83c3-192ccf971fe6', 21, '523ab5ba-75a8-45ba-aa12-6f22c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32682', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-27dc-4297-8ba9-2d8f0a000005'),
('53072e98-51fc-4058-a04f-0ceccf971fe6', 22, '523ae2f8-867c-43dd-86c9-769fc6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32687', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-88d4-4f8a-b07c-2d8f0a000005'),
('53072ebd-54d8-44e0-a3a2-1930cf971fe6', 23, '523ab606-3e24-45f4-b5c6-6200c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32689', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '-1'),
('53072eda-4234-4f45-a5ec-1eb0cf971fe6', 24, '523ab56a-e744-4efe-8697-6efac6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32689', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-db8c-4cf3-8845-2d8f0a000005'),
('53072ee9-0858-4eb9-bfdc-1e35cf971fe6', 25, '523ae24f-a540-4109-a836-76a1c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32689', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-22b0-4efd-bc01-2d8f0a000005'),
('53072fc6-c824-4fad-a9b2-192ccf971fe6', 27, '523aad7c-e838-4472-a2e4-63e4c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32681', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '-1'),
('53072fd9-4f28-4f7f-bfac-1e5ecf971fe6', 28, '523ae314-8228-4107-9095-76a0c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32687', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-f794-48f0-8beb-2d8f0a000005'),
('53072ff9-2074-47b0-8bf7-1be7cf971fe6', 29, '523ab546-442c-4a62-a092-6409c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32681', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '-1'),
('53073074-1c60-42b2-baeb-1ea1cf971fe6', 30, '523ab49b-cb24-4922-bdaa-63b6c6c3268d', '523a0abb-21e0-4b44-a219-6142c6c32684', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-0b74-4d2d-ba16-2d8f0a000005'),
('53073085-55bc-4c5d-afc6-0ceccf971fe6', 31, '523ae34c-bcc0-4c7d-b7aa-75cec6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32687', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-0a9c-46e3-96a6-2d8f0a000005'),
('53073098-8c10-44ae-89f9-1e35cf971fe6', 32, '523a0abb-21e0-4b44-a219-6142c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32681', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-3538-4360-97fc-2d8f0a000005'),
('530730af-aa2c-4d89-b4b4-192ccf971fe6', 33, '523aad5d-a4e0-4363-bfd0-63bec6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32681', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-874c-4858-bcdc-2d8f0a000005'),
('530730c1-89b8-4495-83d1-1e39cf971fe6', 34, '523ae24f-a540-4109-a846-76a1c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32689', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-b924-480e-bef9-2d8f0a000005'),
('530730cf-c148-4568-b45f-1930cf971fe6', 35, '523aae1b-0ee4-4da2-a56f-63e5c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32681', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-cd9c-41c5-990a-2d8f0a000005'),
('530730fd-471c-47cf-ad9e-1eb0cf971fe6', 36, '523aae88-010c-42b3-a6cc-63e6c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32681', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-8aa0-4c76-ad42-2d8f0a000005'),
('5307311e-d2b0-437d-860f-1e39cf971fe6', 37, '523ab4b6-cf7c-4de5-918b-6f22c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32684', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-959c-4892-b073-2d8f0a000005'),
('5307312e-56d8-4d37-8b67-1930cf971fe6', 38, '528fbe28-2118-4dcc-951b-32b1c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32688', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5306fb7e-3df4-4d61-9265-1c51cf971fe6'),
('5307313b-2720-43fb-a82e-1ea1cf971fe6', 39, '528fbe28-2118-4dcc-951a-32b1c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32688', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5306fb6b-8c90-4ed6-abe2-1c0bcf971fe6'),
('5307314a-1fbc-4d25-bd16-192ccf971fe6', 40, '523ae2ab-4a50-4093-81de-761fc6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32682', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-f858-4fd8-9037-2d8f0a000005'),
('5307317a-4d00-447b-84f6-1e5ecf971fe6', 41, '523aadba-be40-4687-901d-6efac6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32681', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, NULL),
('53073191-b8e0-44fd-b53b-1be7cf971fe6', 42, '528fbe28-2118-4dcc-951a-04b1c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32689', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5306fb50-f870-4ecc-849f-1bd6cf971fe6'),
('530731da-e5bc-45a7-ac32-1f71cf971fe6', 43, '528fbe28-2118-4dc9-951b-04b1c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32689', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '53070c36-6bcc-44bf-a4ac-0ceccf971fe6'),
('530731e5-4818-4392-b3c9-1f73cf971fe6', 44, '523ab626-8e2c-4af3-98f8-63e5c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32682', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-e574-48b5-99f2-2d8f0a000005'),
('53073200-3bc4-4e2c-a532-1930cf971fe6', 45, '523aad9d-fd28-4ad3-bacf-6200c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32681', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-265c-4008-812b-2d8f0a000005'),
('5307320c-ba68-4283-92d2-1e5ecf971fe6', 46, '523ab676-3e8c-430c-8439-607bc6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32682', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-5548-4bef-9c34-2d8f0a000005'),
('53073217-a3bc-4b06-b2c7-1c56cf971fe6', 47, '523ab649-a0f0-4155-af50-6efac6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32682', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-48e8-44c6-a7a7-2d8f0a000005'),
('53073224-96f4-4926-a976-1f71cf971fe6', 48, '523ab3e5-c2bc-4b23-9a80-6f23c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32684', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-9ad0-46a0-a109-2d8f0a000005'),
('53073231-84d4-427e-891d-1f73cf971fe6', 49, '523ab400-9658-462a-b714-6f24c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32684', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-cd0c-4159-be0a-2d8f0a000005'),
('5307323c-96bc-44f6-8797-1be7cf971fe6', 50, '523ab47b-92fc-49a5-b57f-63e6c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32684', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-66e4-4b2d-af02-2d8f0a000005'),
('53073250-d550-4640-9a74-1e5ecf971fe6', 51, '523ab353-4f44-4b98-aa74-63e6c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32684', 1, 0, NULL, 0, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530720d9-8f30-4f29-8824-1dc4cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), NULL, '5297b2e7-7be4-4cdb-8f1b-2d8f0a000005'),
('a20f01b2-9aed-11e3-bacb-131017420556', 52, '523ae24f-a540-4109-a836-76v1c6c3268c', '523a0abb-21e0-4b44-a219-6142c6c32689', 1, 0, NULL, 1, '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '530720d8-e34c-451f-bc2f-1dc4cf971fe6', '', NOW(), '', NULL, NULL, NOW(), NULL, '5297b2e7-b924-480e-bef9-2d8f0a000005');

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `master_list_of_format_distributors`
--

CREATE TABLE IF NOT EXISTS `master_list_of_format_distributors` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `master_list_of_format_id` varchar(36) NOT NULL,
  `department_id` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `company_id` varchar(36) DEFAULT NULL,
  `system_table_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `master_list_of_work_instructions`
--

CREATE TABLE IF NOT EXISTS `master_list_of_work_instructions` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(120) NOT NULL,
  `details` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `company_id` varchar(36) DEFAULT NULL,
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `materials`
--

CREATE TABLE IF NOT EXISTS `materials` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(225) NOT NULL,
  `description` text NOT NULL,
  `qc_required` tinyint(1) DEFAULT '0' COMMENT '0=No, 1=Yes',
  `material_qc_status` tinyint(2) DEFAULT '0' COMMENT '0= QC not added, 1= QC added',
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`company_id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `material_list_with_shelf_lives`
--

CREATE TABLE IF NOT EXISTS `material_list_with_shelf_lives` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `material_id` varchar(36) NOT NULL,
  `shelflife_by_manufacturer` varchar(100) NOT NULL,
  `shelflife_by_company` varchar(100) NOT NULL,
  `remarks` text NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `material_quality_check`
--

CREATE TABLE IF NOT EXISTS `material_quality_checks` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `material_id` varchar(36) NOT NULL,
  `name` varchar(120) NOT NULL,
  `details` text,
  `is_last_step` tinyint(1) DEFAULT '0' COMMENT '0=no 1=yes',
  `active_status` tinyint(4) NOT NULL COMMENT '1: Active; 0: Inactive',
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `material_quality_check_details`
--

CREATE TABLE IF NOT EXISTS `material_quality_check_details` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `material_quality_check_id` varchar(36) NOT NULL,
  `delivery_challan_id` varchar(36) DEFAULT NULL,
  `employee_id` varchar(36) NOT NULL COMMENT 'employee who performed the qc check',
  `check_performed_date` varchar(36) NOT NULL COMMENT 'date on which check was performed',
  `quantity_received` int(11) NOT NULL COMMENT 'quantity received by challan or previous check',
  `quantity_accepted` int(11) NOT NULL COMMENT 'quantity accepted',
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `material_types`
--

CREATE TABLE IF NOT EXISTS `material_types` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `material_types`
--

INSERT INTO `material_types` (`id`, `sr_no`, `name`, `publish`, `record_status`, `status_user_id`, `soft_delete`, `branchid`, `departmentid`, `created_by`, `created`, `modified_by`, `approved_by`, `prepared_by`, `modified`, `system_table_id`, `master_list_of_format_id`, `company_id`) VALUES
('5346416d-a930-4e7a-bf48-256051f38a45', 1, '', 0, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '523a0abb-21e0-4b44-a219-6142c6c32685', '530d86cc-96d4-49f3-a126-1d42b6329416', NOW(), '530d86cc-96d4-49f3-a126-1d42b6329416', NULL, NULL, NOW(), '5319747a-41ac-4db0-8c7c-453751f38a45', '0', '530b42f9-2ee4-4545-a815-1a0bb6329416'),
('534641b6-071c-4ddd-b27c-259251f38a45', 2, '', 0, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '523a0abb-21e0-4b44-a219-6142c6c32685', '530d86cc-96d4-49f3-a126-1d42b6329416', NOW(), '530d86cc-96d4-49f3-a126-1d42b6329416', NULL, NULL, NOW(), '5319747a-41ac-4db0-8c7c-453751f38a45', '0', '530b42f9-2ee4-4545-a815-1a0bb6329416');

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `meetings`
--

CREATE TABLE IF NOT EXISTS `meetings` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(36) NOT NULL,
  `previous_meeting_date` date DEFAULT NULL,
  `scheduled_meeting_from` datetime NOT NULL,
  `scheduled_meeting_to` datetime NOT NULL,
  `meeting_details` text NOT NULL,
  `header` text,
  `footer` text,
  `employee_by` varchar(36) NOT NULL,
  `actual_meeting_from` datetime DEFAULT NULL,
  `actual_meeting_to` datetime DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `show_on_timeline` tinyint(1) NOT NULL DEFAULT '0',
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `meeting_attendees`
--

CREATE TABLE IF NOT EXISTS `meeting_attendees` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `meeting_id` varchar(36) NOT NULL,
  `employee_id` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `meeting_branches`
--

CREATE TABLE IF NOT EXISTS `meeting_branches` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `meeting_id` varchar(36) NOT NULL,
  `branch_id` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `meeting_departments`
--

CREATE TABLE IF NOT EXISTS `meeting_departments` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `meeting_id` varchar(36) NOT NULL,
  `department_id` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `meeting_employees`
--

CREATE TABLE IF NOT EXISTS `meeting_employees` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `meeting_id` varchar(36) NOT NULL,
  `employee_id` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `meeting_topics`
--

CREATE TABLE IF NOT EXISTS `meeting_topics` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `meeting_id` varchar(36) NOT NULL,
  `change_addition_deletion_request_id` varchar(36) DEFAULT NULL,
  `corrective_preventive_action_id` varchar(36) DEFAULT NULL,
  `document_amendment_record_sheet_id` varchar(36) DEFAULT NULL,
  `customer_complaint_id` varchar(36) DEFAULT NULL,
  `customer_feedback_id` varchar(36) DEFAULT NULL,
  `supplier_evaluation_reevaluation_id` varchar(36) DEFAULT NULL,
  `summery_of_supplier_evaluation_id` varchar(36) DEFAULT NULL,
  `internal_audit_plan_id` varchar(36) DEFAULT NULL,
  `title` varchar(250) NOT NULL,
  `current_status` text,
  `action_plan` text,
  `employee_id` varchar(36) DEFAULT NULL,
  `target_date` date DEFAULT NULL,
  `notes` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `trackingid` varchar(36) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `sent_to` int(1) NULL,
  `flag` int(1) DEFAULT NULL,
  `created_by` varchar(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified_by` varchar(36) NOT NULL,
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL,
  `priority` varchar(10) DEFAULT NULL,
  `system_table_id` varchar(36) DEFAULT NULL,
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `message_user_inboxes`
--

CREATE TABLE IF NOT EXISTS `message_user_inboxes` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` varchar(36) NOT NULL,
  `trackingid` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `status` int(1) NOT NULL COMMENT '0-unread 1-read 2-thrash',
  `created_by` varchar(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified_by` varchar(36) NOT NULL,
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL,
  `system_table_id` varchar(36) DEFAULT NULL,
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `message_user_sents`
--

CREATE TABLE IF NOT EXISTS `message_user_sents` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` varchar(36) NOT NULL,
  `trackingid` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `status` int(1) NOT NULL,
  `created_by` varchar(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified_by` varchar(36) NOT NULL,
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL,
  `system_table_id` varchar(36) DEFAULT NULL,
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `message_user_thrashes`
--

CREATE TABLE IF NOT EXISTS `message_user_thrashes` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `status` int(1) NOT NULL,
  `created_by` varchar(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified_by` varchar(36) NOT NULL,
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL,
  `system_table_id` varchar(36) DEFAULT NULL,
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `non_conforming_products_materials`
--

CREATE TABLE IF NOT EXISTS `non_conforming_products_materials` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(120) DEFAULT NULL,
  `description` text,
  `material_id` varchar(36) DEFAULT NULL,
  `product_id` varchar(36) DEFAULT NULL,
  `capa_source_id` varchar(36) DEFAULT NULL,
  `corrective_preventive_action_id` varchar(36) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `notification_type_id` varchar(36) NOT NULL,
  `internal_audit_plan_id` varchar(36) DEFAULT NULL,
  `meeting_id` varchar(36) DEFAULT NULL,
  `title` varchar(120) NOT NULL,
  `message` varchar(250) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `prepared_by` varchar(36) NOT NULL,
  `approved_by` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT NULL,
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `notification_types`
--

CREATE TABLE IF NOT EXISTS `notification_types` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `notification_types`
--

INSERT INTO `notification_types` (`id`, `sr_no`, `name`, `publish`, `record_status`, `status_user_id`, `soft_delete`, `branchid`, `departmentid`, `created_by`, `created`, `modified_by`, `modified`, `system_table_id`, `master_list_of_format_id`, `company_id`) VALUES
('53392775-4504-4858-85ac-13fc51f38a45', 1, 'General Notification', 1, 0, NULL, 0, '530c2ddf-4668-4a02-96ba-383db6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '530c2de0-b334-4661-a55c-383db6329416', NOW(), '5378afee-61d0-49b5-b2c3-560e0a000002', NOW(), '5297b2e7-e80c-4d8d-89b7-2d8f0a000005', '', '537754ef-d108-4ff7-83e3-4c3b0a000002'),
('534535b9-8364-48b6-9abd-33af51f38a45', 2, 'Meetings', 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '523a0abb-21e0-4b44-a219-6142c6c32685', '530d86cc-96d4-49f3-a126-1d42b6329416', NOW(), '530d8bb7-e26c-4ad1-9a3a-48f7b6329416', NOW(), '5297b2e7-e80c-4d8d-89b7-2d8f0a000005', '', '537754ef-d108-4ff7-83e3-4c3b0a000002'),
('537b5670-2e5c-4bd1-80b7-62ac0a000002', 3, 'Internal Audits', 1, 0, NULL, 0, '537754ef-519c-4f6e-9984-4c3b0a000002', '523a0abb-21e0-4b44-a219-6142c6c32681', '5378afee-61d0-49b5-b2c3-560e0a000002', NOW(), '5378afee-61d0-49b5-b2c3-560e0a000002', NOW(), '5297b2e7-e80c-4d8d-89b7-2d8f0a000005', '', '537754ef-d108-4ff7-83e3-4c3b0a000002');

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `notification_users`
--

CREATE TABLE IF NOT EXISTS `notification_users` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `notification_id` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `employee_id` varchar(36) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=Unread, 1=Read',
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT NULL,
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `order_details_forms`
--

CREATE TABLE IF NOT EXISTS `order_details_forms` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_order_id` varchar(36) NOT NULL,
  `order_date` date NOT NULL,
  `delivery_date` date NOT NULL,
  `product_id` varchar(36) DEFAULT NULL,
  `device_id` varchar(36) DEFAULT NULL,
  `delivery_challan_id` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `order_registers`
--

CREATE TABLE IF NOT EXISTS `order_registers` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `customer_details` text NOT NULL,
  `supplier_registration_id` varchar(36) NOT NULL,
  `order_reference_number` varchar(25) NOT NULL,
  `details` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_reference_number` (`order_reference_number`,`company_id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `productions`
--

CREATE TABLE IF NOT EXISTS `productions` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(64) NOT NULL,
  `batch_number` varchar(64) NOT NULL,
  `details` text,
  `branch_id` varchar(36) DEFAULT NULL,
  `employee_id` varchar(36) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `remarks` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(225) NOT NULL,
  `description` text NOT NULL,
  `branch_id` varchar(36) DEFAULT NULL,
  `department_id` varchar(36) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `product_materials`
--

CREATE TABLE IF NOT EXISTS `product_materials` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(64) CHARACTER SET utf8 NOT NULL,
  `material_id` varchar(64) CHARACTER SET utf8 NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `proposals`
--

CREATE TABLE IF NOT EXISTS `proposals` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `customer_id` varchar(36) NOT NULL,
  `customer_contact_id` varchar(36) NOT NULL,
  `employee_id` varchar(36) DEFAULT NULL,
  `active_lock` tinyint(4) NOT NULL COMMENT '0: Unlocked; 1: Locked',
  `proposal_heading` varchar(255) NOT NULL,
  `proposal_details` text,
  `proposal_followup_rule_id` varchar(36) DEFAULT NULL,
  `proposal_assigned_to` varchar(36) DEFAULT NULL,
  `proposal_followup_date` date DEFAULT NULL,
  `email_body` text,
  `proposal_date` date DEFAULT NULL,
  `proposal_status` int(1) NOT NULL DEFAULT '0',
  `proposal_cc` varchar(250) DEFAULT NULL,
  `proposal_bcc` varchar(250) DEFAULT NULL,
  `proposal_sent_date` date DEFAULT NULL,
  `proposal_sent_type` int(1) NOT NULL,
  `attached_files` text,
  `proposal_accepted_date` date DEFAULT NULL,
  `notes` text,
  `resaon_for_hold_rejection` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- @#@ -- Table structure for table `proposal_followups`
--

CREATE TABLE IF NOT EXISTS `proposal_followups` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `proposal_id` varchar(36) NOT NULL,
  `customer_id` varchar(36) NOT NULL,
  `customer_meeting_id` varchar(36) DEFAULT NULL,
  `customer_contact_id` varchar(36) NOT NULL,
  `employee_id` varchar(36) DEFAULT NULL,
  `followup_date` date NOT NULL,
  `followup_day` int(2) DEFAULT NULL,
  `followup_type` varchar(20) DEFAULT NULL,
  `followup_heading` varchar(255) NOT NULL,
  `followup_details` text,
  `next_follow_up_date` date DEFAULT NULL,
  `followup_assigned_to` varchar(36) DEFAULT NULL,
  `status` varchar(9) DEFAULT '0',
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `proposal_followup_rules`
--

CREATE TABLE IF NOT EXISTS `proposal_followup_rules` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `rule` varchar(255) NOT NULL,
  `number_of_followups_required` int(2) NOT NULL,
  `followup_sequence` varchar(250) NOT NULL,
  `notes` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',  
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `purchase_orders`
--

CREATE TABLE IF NOT EXISTS `purchase_orders` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL COMMENT '0: Inbound, 1: Outbound, 2: Other',
  `purchase_order_number` varchar(120) NOT NULL,
  `customer_id` varchar(36) DEFAULT NULL,
  `supplier_registration_id` varchar(36) DEFAULT NULL,
  `other` varchar(250) DEFAULT NULL,
  `details` text,
  `order_date` date NOT NULL,
  `intimation` varchar(250) DEFAULT NULL,
  `expected_delivery_date` date NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `purchase_order_number` (`purchase_order_number`,`company_id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `purchase_order_details`
--

CREATE TABLE IF NOT EXISTS `purchase_order_details` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_order_id` varchar(36) DEFAULT NULL,
  `product_id` varchar(36) DEFAULT NULL,
  `device_id` varchar(36) DEFAULT NULL,
  `material_id` varchar(36) DEFAULT NULL,
  `other` varchar(250) DEFAULT NULL,
  `item_number` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `rate` int(11) NOT NULL,
  `discount` int(2) DEFAULT NULL,
  `total` int(11) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `branch_id` varchar(36) NOT NULL,
  `department_id` varchar(36) NOT NULL,
  `master_list_of_format_id` varchar(36) NOT NULL,
  `description` text,
  `details` text NOT NULL,
  `report_date` date NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `schedules`
--

CREATE TABLE IF NOT EXISTS `schedules` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `sr_no`, `name`, `publish`, `record_status`, `status_user_id`, `soft_delete`, `branchid`, `departmentid`, `created_by`, `created`, `modified_by`, `approved_by`, `prepared_by`, `modified`, `system_table_id`, `master_list_of_format_id`) VALUES
('52487014-1448-45ae-82c3-4f1fc6c3268c', 1, 'Daily', 1, 0, NULL, 0, '522e4490-ff60-4990-8ca2-8a04c6c3268c', '522ee01c-4c78-437c-bffb-0311c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '522e4411-7e44-4c41-9c1a-84a2c6c3268c', '0'),
('5248701d-1390-4782-9990-4f1fc6c3268c', 2, 'Weekly', 1, 0, NULL, 0, '522e4490-ff60-4990-8ca2-8a04c6c3268c', '522ee01c-4c78-437c-bffb-0311c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '522e4411-7e44-4c41-9c1a-84a2c6c3268c', '0'),
('52487027-260c-4196-8062-543bn6c3268c', 4, 'Monthly', 1, 0, NULL, 0, '522e4490-ff60-4990-8ca2-8a04c6c3268c', '522ee01c-4c78-437c-bffb-0311c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530c2de0-b334-4661-a55c-383db6329416', NULL, NULL, NOW(), '5297b2e7-d99c-464b-952b-2d8f0a000005', '0'),
('52487033-b1a8-436f-b0a9-53a7q6c3268c', 5, 'Quarterly', 1, 0, NULL, 0, '522e4490-ff60-4990-8ca2-8a04c6c3268c', '522ee01c-4c78-437c-bffb-0311c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '522e4411-7e44-4c41-9c1a-84a2c6c3268c', '0'),
('530df9f4-fff8-454e-aa24-71f5b6329416', 7, 'Yearly', 1, 0, NULL, 0, '530c2ddf-4668-4a02-96ba-383db6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530c2de0-b334-4661-a55c-383db6329416', NOW(), '530c2de0-b334-4661-a55c-383db6329416', NULL, NULL, NOW(), '5297b2e7-d99c-464b-952b-2d8f0a000005', '');

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `software_types`
--

CREATE TABLE IF NOT EXISTS `software_types` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT 'software type',
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `stocks`
--

CREATE TABLE IF NOT EXISTS `stocks` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0',
  `material_id` varchar(36) NOT NULL,
  `material_type_id` tinyint(1) DEFAULT '0',
  `supplier_registration_id` varchar(36) DEFAULT NULL,
  `purchase_order_id` varchar(36) DEFAULT NULL,
  `delivery_challan_id` varchar(36) DEFAULT NULL,
  `received_date` date DEFAULT NULL,
  `production_id` varchar(36) DEFAULT NULL,
  `production_date` date DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `quantity_consumed` int(11) DEFAULT NULL,
  `branch_id` varchar(36) DEFAULT NULL,
  `remarks` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `suggestion_forms`
--

CREATE TABLE IF NOT EXISTS `suggestion_forms` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(36) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=Unread, 1=Read',
  `title` varchar(250) NOT NULL,
  `activity` text NOT NULL,
  `suggestion` text NOT NULL,
  `remark` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `summery_of_supplier_evaluations`
--

CREATE TABLE IF NOT EXISTS `summery_of_supplier_evaluations` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_registration_id` varchar(36) NOT NULL,
  `supplier_category_id` varchar(36) NOT NULL,
  `remarks` text NOT NULL,
  `evaluation_date` date NOT NULL,
  `employee_id` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `supplier_categories`
--

CREATE TABLE IF NOT EXISTS `supplier_categories` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `supplier_categories`
--

INSERT INTO `supplier_categories` (`id`, `sr_no`, `name`, `publish`, `record_status`, `status_user_id`, `soft_delete`, `branchid`, `departmentid`, `created_by`, `created`, `modified_by`, `approved_by`, `prepared_by`, `modified`, `system_table_id`, `master_list_of_format_id`) VALUES
('530db756-3f24-4f4e-84d5-60bbb6329416', 1, 'Category A', 1, 0, NULL, 0, '530c2ddf-4668-4a02-96ba-383db6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530c2de0-b334-4661-a55c-383db6329416', NOW(), '530c2de0-b334-4661-a55c-383db6329416', NULL, NULL, NOW(), '5297b2e7-e944-43cd-baae-2d8f0a000005', ''),
('530db764-d57c-40c6-a40b-63fcb6329416', 2, 'Category B', 1, 0, NULL, 0, '530c2ddf-4668-4a02-96ba-383db6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530c2de0-b334-4661-a55c-383db6329416', NOW(), '530c2de0-b334-4661-a55c-383db6329416', NULL, NULL, NOW(), '5297b2e7-e944-43cd-baae-2d8f0a000005', ''),
('530db770-9f34-4229-88ed-63fcb6329416', 3, 'Category C', 1, 0, NULL, 0, '530c2ddf-4668-4a02-96ba-383db6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530c2de0-b334-4661-a55c-383db6329416', NOW(), '530c2de0-b334-4661-a55c-383db6329416', NULL, NULL, NOW(), '5297b2e7-e944-43cd-baae-2d8f0a000005', ''),
('533558c0-516c-4ea2-a413-143351f38a45', 4, 'Supplier category', 1, 0, NULL, 0, '530c2ddf-4668-4a02-96ba-383db6329416', '523a0abb-21e0-4b44-a219-6142c6c32681', '530c2de0-b334-4661-a55c-383db6329416', NOW(), '530c2de0-b334-4661-a55c-383db6329416', NULL, NULL, NOW(), '5297b2e7-e944-43cd-baae-2d8f0a000005', ''),
('5354c621-9534-43fc-a36d-119e51f38a45', 5, 'Food Supplier', 1, 0, NULL, 0, '530c2ddf-4668-4a02-96ba-383db6329416', '523a0abb-21e0-4b44-a219-6142c6c32685', '530da209-0164-46c9-8435-2554b6329416', NOW(), '530da209-0164-46c9-8435-2554b6329416', NULL, NULL, NOW(), '5297b2e7-e944-43cd-baae-2d8f0a000005', '');

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `supplier_evaluation_reevaluations`
--

CREATE TABLE IF NOT EXISTS `supplier_evaluation_reevaluations` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_registration_id` varchar(36) NOT NULL,
  `delivery_challan_id` varchar(36) DEFAULT NULL,
  `challan_date` date NOT NULL,
  `material_id` varchar(36) NOT NULL,
  `product_id` varchar(36) DEFAULT NULL,
  `device_id` varchar(36) DEFAULT NULL,
  `quantity_supplied` int(11) NOT NULL,
  `quantity_accepted` int(11) DEFAULT '0',
  `required_delivery_date` date NOT NULL,
  `actual_delivery_date` date NOT NULL,
  `remarks` text NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `supplier_registrations`
--

CREATE TABLE IF NOT EXISTS `supplier_registrations` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `number` varchar(40) NOT NULL,
  `type_of_company` varchar(130) NOT NULL,
  `contact_person_office` varchar(100) NOT NULL,
  `contact_person_work` varchar(100) DEFAULT NULL,
  `designition_in_office` varchar(100) NOT NULL,
  `designation_in_work` varchar(100) DEFAULT NULL,
  `office_address` text NOT NULL,
  `work_address` text,
  `office_telephone` varchar(45) NOT NULL,
  `work_telephone` varchar(45) DEFAULT NULL,
  `office_fax` varchar(45) DEFAULT NULL,
  `work_fax` varchar(45) DEFAULT NULL,
  `office_weekly_off` varchar(40) DEFAULT NULL,
  `work_weekly_off` varchar(40) DEFAULT NULL,
  `cst_registration_number` varchar(120) DEFAULT NULL,
  `st_registration_number` varchar(120) DEFAULT NULL,
  `incometax_number` varchar(120) DEFAULT NULL,
  `ssi_registration_number` varchar(120) DEFAULT NULL,
  `range_of_products` text,
  `services_offered` text,
  `existing_facilities` text,
  `prominent_customers` text,
  `quality_assurence` text,
  `name` varchar(100) DEFAULT NULL,
  `designation` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `facilites` varchar(5) DEFAULT NULL,
  `facility_comments` text,
  `supplier_representative` text,
  `supplier_selected` tinyint(2) DEFAULT NULL,
  `supplier_category_id` varchar(36) DEFAULT NULL,
  `details` text,
  `order_date` date DEFAULT NULL,
  `trial_order` varchar(4) DEFAULT NULL,
  `name2` varchar(255) DEFAULT NULL,
  `designation2` varchar(255) DEFAULT NULL,
  `date2` date DEFAULT NULL,
  `iso_certified` tinyint(1) DEFAULT '0' COMMENT '0=Not ISO certified, 1=ISO certified',
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`,`company_id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `system_tables`
--

CREATE TABLE IF NOT EXISTS `system_tables` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `system_name` varchar(250) NOT NULL,
  `iso_section` tinytext DEFAULT NULL,
  `evidence_required` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=no 1=yes',
  `approvals_required` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=no 1=yes',
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `system_name` (`system_name`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `name_2` (`name`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=131 ;

--
-- Dumping data for table `system_tables`
--

INSERT INTO `system_tables` (`id`, `sr_no`, `name`, `system_name`, `iso_section`, `evidence_required`, `approvals_required`, `publish`, `record_status`, `status_user_id`, `soft_delete`, `branchid`, `departmentid`, `created_by`, `created`, `modified_by`, `approved_by`, `prepared_by`, `modified`, `master_list_of_format_id`) VALUES
('5297b2e6-e41c-4b5a-a42c-2d8f0a000005', 1, 'Approvals', 'approvals', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e6-9ed8-431a-ba1c-2d8f0a000005', 2, 'Benchmarks', 'benchmarks', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e6-7d0c-491b-8069-2d8f0a000005', 3, 'Branch Benchmarks', 'branch_benchmarks', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e6-a72c-432a-a583-2d8f0a000005', 4, 'Branches', 'branches', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e6-2098-4689-9301-2d8f0a000005', 5, 'Calibrations', 'calibrations', '7.6', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '526eaf56-8700-41ff-9f29-152bc6c3268c'),
('5297b2e6-bf20-45c7-81eb-2d8f0a000005', 6, 'Capa Categories', 'capa_categories', '8.5.2, 8.5.3', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e6-52b8-4647-93b7-2d8f0a000005', 7, 'Capa Sources', 'capa_sources', '8.4', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e6-82b4-4d86-bb85-2d8f0a000005', 8, 'Change Addition Deletion Requests', 'change_addition_deletion_requests', '4.2.3', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523aad05-65ec-450f-a4c1-63b6c6c3268c'),
('5297b2e6-a644-4f0d-b600-2d8f0a000005', 9, 'Companies', 'companies', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e6-bc74-4a73-8ee7-2d8f0a000005', 10, 'Company Benchmarks', 'company_benchmarks', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-c8f0-4481-9236-2d8f0a000005', 11, 'Competency Mappings', 'competency_mappings', '7.5.2', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '528fb1d6-3300-43ff-b9fc-2f1fb6329401'),
('5297b2e7-8aa0-4c76-ad42-2d8f0a000005', 12, 'Corrective Preventive Actions', 'corrective_preventive_actions', '8.5.2, 8.5.3', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523aae88-010c-42b3-a6cc-63e6c6c3268c'),
('5297b2e7-e080-4188-ad11-2d8f0a000005', 13, 'Courier Registers', 'courier_registers', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-ce30-4d5f-a17b-2d8f0a000005', 14, 'Course Types', 'course_types', '6.2.2', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-9ad0-46a0-a109-2d8f0a000005', 15, 'Courses', 'courses', '6.2.2', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ab3e5-c2bc-4b23-9a80-6f23c6c3268c'),
('5297b2e7-eb9c-4f56-bc1c-2d8f0a000005', 16, 'Custom Templates', 'custom_templates', '4.2.3', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-43cc-49c8-8562-2d8f0a000005', 17, 'Customer Complaints', 'customer_complaints', '7.2.3, 8.3', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '528fbe28-2118-4dcc-951a-12b1c6c3268c'),
('5297b2e7-3500-416b-9aaa-2d8f0a000005', 18, 'Customer Feedback Questions', 'customer_feedback_questions', '8.2.1, 8.4', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-6c44-4b87-84af-2d8f0a000005', 19, 'Customer Feedbacks', 'customer_feedbacks', '7.2.3, 8.2.1, 8.3', 1, 0, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '528fb246-728c-4ded-a990-2f21b6329401'),
('5297b2e7-c288-45fd-bb91-2d8f0a000005', 20, 'Customers', 'customers', '7.2', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-1d18-4518-ba82-2d8f0a000005', 21, 'Daily Backup Details', 'daily_backup_details', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-5e44-48a1-b329-2d8f0a000005', 22, 'Dashboards', 'dashboards', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-2314-45d8-a798-2d8f0a000005', 23, 'Data Back Ups', 'data_back_ups', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-c3f4-4ec3-b6f3-2d8f0a000005', 24, 'Data Types', 'data_types', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-eb34-446e-9245-2d8f0a000005', 25, 'Databackup Logbooks', 'databackup_logbooks', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ae2da-1ac8-4038-8cd2-7638c6c3268c'),
('5297b2e7-42a4-4424-a5bd-2d8f0a000005', 26, 'Delivery Challans', 'delivery_challans', '7.4.1', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ae218-b274-4894-8946-76a0c6c3268c'),
('5297b2e7-6fe4-49f9-9b06-2d8f0a000005', 27, 'Department Benchmarks', 'department_benchmarks', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-f6fc-48b1-a8f9-2d8f0a000005', 28, 'Departments', 'departments', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-c1a8-4d19-bbfe-2d8f0a000005', 29, 'Designations', 'designations', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-0d60-4558-83e6-2d8f0a000005', 30, 'Devices', 'devices', '7.5.4', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-136c-4479-a06c-2d8f0a000005', 31, 'Document Amendment Record Sheets', 'document_amendment_record_sheets', '4.2.3', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523aad3b-6a50-480a-95b7-63e3c6c3268c'),
('5297b2e7-a1cc-4148-955d-2d8f0a000005', 32, 'Employee Designations', 'employee_designations', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-0b74-4d2d-ba16-2d8f0a000005', 33, 'Employee Induction Trainings', 'employee_induction_trainings', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ab49b-cb24-4922-bdaa-63b6c6c3268d'),
('5297b2e7-7be4-4cdb-8f1b-2d8f0a000005', 34, 'Employee Trainings', 'employee_trainings', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ab3a7-2924-4cad-af28-63b6c6c3268c'),
('5297b2e7-959c-4892-b073-2d8f0a000005', 35, 'Employees', 'employees', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ab4b6-cf7c-4de5-918b-6f22c6c3268c'),
('5297b2e7-c4d0-418d-adb5-2d8f0a000005', 36, 'Errors', 'errors', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-1e98-4de2-ae19-2d8f0a000005', 37, 'Evidences', 'evidences', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-fd94-4a43-b8d0-2d8f0a000005', 38, 'File Uploads', 'file_uploads', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-48e8-44e9-84f9-2d8f0a000005', 39, 'Fire Extinguisher Types', 'fire_extinguisher_types', '6.3', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-a8a8-4778-8a17-2d8f0a000005', 40, 'Fire Extinguishers', 'fire_extinguishers', '6.3', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ab4d8-13bc-4cc0-b01a-6f23c6c3268c'),
('5297b2e7-0844-40de-8caa-2d8f0a000005', 41, 'Fire Safety Equipment Lists', 'fire_safety_equipment_lists', '6.3', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-7b04-4776-b2c2-2d8f0a000005', 42, 'Fire Types', 'fire_types', '6.3', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-6e50-40ce-8407-2d8f0a000005', 43, 'Helps', 'helps', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-1250-4c17-abff-2d8f0a000005', 44, 'Histories', 'histories', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-db08-4f64-b91c-2d8f0a000005', 45, 'Housekeeping Checklists', 'housekeeping_checklists', '6.3', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ab500-aa34-4864-8a8a-6200c6c3268c'),
('5297b2e7-68e0-48a9-a808-2d8f0a000005', 46, 'Housekeeping Responsibilities', 'housekeeping_responsibilities', '6.3', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ab522-bfe0-4f02-94da-63e5c6c3268c'),
('5297b2e7-26a8-4210-827a-2d8f0a000005', 47, 'Housekeepings', 'housekeepings', '6.3', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-33bc-4843-810e-2d8f0a000005', 48, 'Internal Audit Details', 'internal_audit_details', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523aae54-4bd8-45ef-9d98-63b6c6c3268c'),
('5297b2e7-9248-46eb-aaff-2d8f0a000005', 49, 'Internal Audit Plan Branches', 'internal_audit_plan_branches', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-d6d4-4e82-a1f2-2d8f0a000005', 50, 'Internal Audit Plan Departments', 'internal_audit_plan_departments', '8.2.2', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-4314-466d-9358-2d8f0a000005', 51, 'Internal Audit Plans', 'internal_audit_plans', '8.2.2', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523aae38-ebe8-4818-bdd5-6409c6c3268c'),
('5297b2e7-2188-4cb8-8673-2d8f0a000005', 52, 'Internal Audits', 'internal_audits', '8.2.2', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ab320-2184-48e9-8df4-6409c6c3268c'),
('5297b2e7-6910-4085-8aec-2d8f0a000005', 53, 'Internet Usage Details', 'internet_usage_details', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-e44c-41b5-a4b2-2d8f0a000005', 54, 'Languages', 'languages', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-27dc-4297-8ba9-2d8f0a000005', 55, 'List Of Acceptable Suppliers', 'list_of_acceptable_suppliers', '7.4.1', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ab5ba-75a8-45ba-aa12-6f22c6c3268c'),
('5297b2e7-f60c-4aa1-9017-2d8f0a000005', 56, 'List Of Computer List Of Softwares', 'list_of_computer_list_of_softwares', '6.3, 7.5.4', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-88d4-4f8a-b07c-2d8f0a000005', 57, 'List Of Computers', 'list_of_computers', '6.3, 7.5.4', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ae2f8-867c-43dd-86c9-769fc6c3268c'),
('5297b2e7-db8c-4cf3-8845-2d8f0a000005', 58, 'List Of Measuring Devices For Calibrations', 'list_of_measuring_devices_for_calibrations', '7.6', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ab56a-e744-4efe-8697-6efac6c3268c'),
('5297b2e7-f794-48f0-8beb-2d8f0a000005', 59, 'List Of Softwares', 'list_of_softwares', '6.3, 7.5.4', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ae314-8228-4107-9095-76a0c6c3268c'),
('5297b2e7-8f0c-4ca7-b5da-2d8f0a000005', 60, 'List Of Trained Internal Auditors', 'list_of_trained_internal_auditors', '8.2.2', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-48a4-451e-beda-2d8f0a000005', 61, 'Master List Of Format Branches', 'master_list_of_format_branches', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-4b40-4fc7-b850-2d8f0a000005', 62, 'Master List Of Format Departments', 'master_list_of_format_departments', '4.2.3', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-ee54-42d8-a918-2d8f0a000005', 63, 'Master List Of Format Distributors', 'master_list_of_format_distributors', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-3538-4360-97fc-2d8f0a000005', 64, 'Master List Of Formats', 'master_list_of_formats', '4.2.3', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523a0abb-21e0-4b44-a219-6142c6c3268c'),
('5297b2e7-874c-4858-bcdc-2d8f0a000005', 65, 'Master List Of Work Instructions', 'master_list_of_work_instructions', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523aad5d-a4e0-4363-bfd0-63bec6c3268c'),
('5297b2e7-b924-480e-bef9-2d8f0a000005', 66, 'Material List With Shelf Lives', 'material_list_with_shelf_lives', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ae24f-a540-4109-a836-76v1c6c3268c'),
('5297b2e7-3a14-45c2-b2dc-2d8f0a000005', 67, 'Materials', 'materials', '7.5.3', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ae24f-a540-4109-a836-76v1c6c3268c'),
('5297b2e7-6668-4637-a93d-2d8f0a000005', 68, 'Meeting Branches', 'meeting_branches', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-b1fc-4d11-b6a0-2d8f0a000005', 69, 'Meeting Departments', 'meeting_departments', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-3bec-4638-90d3-2d8f0a000005', 70, 'Meeting Employees', 'meeting_employees', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-1678-45a0-b8a3-2d8f0a000005', 71, 'Meeting Topics', 'meeting_topics', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523aadfb-d9e8-43ec-b5fb-607bc6c3268c'),
('5297b2e7-cd9c-41c5-990a-2d8f0a000005', 72, 'Meetings', 'meetings', '5.0', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523aae1b-0ee4-4da2-a56f-63e5c6c3268c'),
('5297b2e7-3aa8-4310-b356-2d8f0a000005', 73, 'Message User Inboxes', 'message_user_inboxes', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-7bb0-479e-a778-2d8f0a000005', 74, 'Message User Sents', 'message_user_sents', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-3b9c-4e59-865f-2d8f0a000005', 75, 'Message User Thrashes', 'message_user_thrashes', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-5148-40e5-9f93-2d8f0a000005', 76, 'Messages', 'messages', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-1c98-4a96-8b18-2d8f0a000005', 77, 'Notificaion Types', 'notificaion_types', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-e80c-4d8d-89b7-2d8f0a000005', 78, 'Notification Types', 'notification_types', '5.0', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-4bd8-4895-847f-2d8f0a000005', 79, 'Notification Users', 'notification_users', '5.0', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-17b0-4f29-b8e6-2d8f0a000005', 80, 'Notifications', 'notifications', '5.0', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-a3f8-42e4-af2d-2d8f0a000005', 81, 'Order Details Forms', 'order_details_forms', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-8ce8-439e-beb3-2d8f0a000005', 82, 'Order Registers', 'order_registers', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-43b4-42dc-bd3b-2d8f0a000005', 83, 'Pages', 'pages', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-22b0-4efd-bc01-2d8f0a000005', 84, 'Products', 'products', '7.5.3', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ae24f-a540-4109-a836-76a1c6c3268c'),
('5297b2e7-69d4-4031-910a-2d8f0a000005', 85, 'Purchase Order Details', 'purchase_order_details', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-f858-4fd8-9037-2d8f0a000005', 86, 'Purchase Orders', 'purchase_orders', '7.4.1', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ae2ab-4a50-4093-81de-761fc6c3268c'),
('5297b2e7-9168-4e20-a832-2d8f0a000005', 87, 'Reports', 'reports', '8.4', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-d99c-464b-952b-2d8f0a000005', 88, 'Schedules', 'schedules', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-2e38-4cf8-9e61-2d8f0a000005', 89, 'Software Types', 'software_types', '7.5.3', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-265c-4008-812b-2d8f0a000005', 90, 'suggestion Forms', 'suggestion_forms', '5.0', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523aad9d-fd28-4ad3-bacf-6200c6c3268c'),
('5297b2e7-5548-4bef-9c34-2d8f0a000005', 91, 'Summery Of Supplier Evaluations', 'summery_of_supplier_evaluations', '7.4.1, 8.4', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ab676-3e8c-430c-8439-607bc6c3268c'),
('5297b2e7-e944-43cd-baae-2d8f0a000005', 92, 'Supplier Categories', 'supplier_categories', '7.4.1', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-48e8-44c6-a7a7-2d8f0a000005', 93, 'Supplier Evaluation Reevaluations', 'supplier_evaluation_reevaluations', '7.4.1', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ab649-a0f0-4155-af50-6efac6c3268c'),
('5297b2e7-e574-48b5-99f2-2d8f0a000005', 94, 'Supplier Registrations', 'supplier_registrations', '7.4.1', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ab626-8e2c-4af3-98f8-63e5c6c3268c'),
('5297b2e7-4d4c-44f9-9ad1-2d8f0a000005', 95, 'System Tables', 'system_tables', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-0578-40ee-9331-2d8f0a000005', 96, 'Task Statuses', 'task_statuses', '8.5.1', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-697c-465f-bf2c-2d8f0a000005', 97, 'Tasks', 'tasks', '8.5.1', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-a9d4-40d7-bef0-2d8f0a000005', 98, 'Timelines', 'timelines', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-3858-49c0-a14a-2d8f0a000005', 99, 'Trainer Types', 'trainer_types', '6.2.2', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-8e38-4e0f-8ea6-2d8f0a000005', 100, 'Trainers', 'trainers', '6.2.2', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '5297b3d3-7ebc-4dd2-a201-2cbe0a000005'),
('5297b2e7-cd0c-4159-be0a-2d8f0a000005', 101, 'Training Evaluations', 'training_evaluations', '6.2.2', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ab400-9658-462a-b714-6f24c6c3268c'),
('5297b2e7-66e4-4b2d-af02-2d8f0a000005', 102, 'Training Need Identifications', 'training_need_identifications', '6.2.2', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ab47b-92fc-49a5-b57f-63e6c6c3268c'),
('5297b2e7-0ae4-47e6-935f-2d8f0a000005', 103, 'Training Schedule Branches', 'training_schedule_branches', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-8574-4c41-8c0e-2d8f0a000005', 104, 'Training Schedule Departments', 'training_schedule_departments', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-e35c-40aa-aa59-2d8f0a000005', 105, 'Training Schedule Employees', 'training_schedule_employees', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-b60c-4641-aca5-2d8f0a000005', 106, 'Training Schedules', 'training_schedules', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ab353-4f44-4b98-aa74-63e6c6c3268c'),
('5297b2e7-52a0-406e-bdf0-2d8f0a000005', 107, 'Training Types', 'training_types', '6.2.2', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-761c-4e6a-b6dd-2d8f0a000005', 108, 'Trainings', 'trainings', '6.2.2', 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-0e64-4b2c-9684-2d8f0a000005', 109, 'User Sessions', 'user_sessions', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-87d0-46bb-8f65-2d8f0a000005', 110, 'Username Password Details', 'username_password_details', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '54e5d056-199b-11e3-9f46-c709d410d2ec', NULL, NULL, NOW(), '0'),
('5297b2e7-0a9c-46e3-96a6-2d8f0a000005', 111, 'Users', 'users', NULL, 1, 1, 1, 0, NULL, 0, '0941b9a8-2990-11e3-a528-d919ee611857', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '54e5d056-199b-11e3-9f46-c709d410d2ec', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '523ae34c-bcc0-4c7d-b7aa-75cec6c3268c'),
('5306fae4-6334-4a84-8d2b-1c51cf971fe6', 112, 'Clients', 'clients', NULL, 1, 1, 1, 0, NULL, 0, '5306fa07-5a3c-40ae-be31-1930cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '5306fa07-4710-4549-af15-1930cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '528fbe28-2118-4dcc-951a-22b1c6c3274c'),
('5306fb20-3f54-434a-a17b-0ceccf971fe6', 113, 'Customer Meetings', 'customer_meetings', '7.2', 1, 1, 1, 0, NULL, 0, '5306fa07-5a3c-40ae-be31-1930cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '5306fa07-4710-4549-af15-1930cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '528fbe28-2118-4dcc-951a-22b1c6c3268c'),
('5306fb50-f870-4ecc-849f-1bd6cf971fe6', 114, 'Stocks', 'stocks', NULL, 1, 1, 1, 0, NULL, 0, '5306fa07-5a3c-40ae-be31-1930cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '5306fa07-4710-4549-af15-1930cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '528fbe28-2118-4dcc-951a-04b1c6c3268c'),
('5306fb6b-8c90-4ed6-abe2-1c0bcf971fe6', 115, 'Proposals', 'proposals', NULL, 1, 1, 1, 0, NULL, 0, '5306fa07-5a3c-40ae-be31-1930cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '5306fa07-4710-4549-af15-1930cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '528fbe28-2118-4dcc-951a-32b1c6c3268c'),
('5306fb7e-3df4-4d61-9265-1c51cf971fe6', 116, 'Proposal Followups', 'proposal_followups', NULL, 1, 1, 1, 0, NULL, 0, '5306fa07-5a3c-40ae-be31-1930cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '5306fa07-4710-4549-af15-1930cf971fe6', NOW(), '530720d9-8f30-4f29-8824-1dc4cf971fe6', NULL, NULL, NOW(), '528fbe28-2118-4dcc-951b-32b1c6c3268c'),
('5306fbac-7a30-48bc-bbac-192ccf971fe6', 117, 'Production', 'productions', NULL, 1, 1, 1, 0, NULL, 0, '5306fa07-5a3c-40ae-be31-1930cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '5306fa07-4710-4549-af15-1930cf971fe6', NOW(), '5306fa07-4710-4549-af15-1930cf971fe6', NULL, NULL, NOW(), ''),
('5306fbc5-92e8-45c5-aca0-1be7cf971fe6', 118, 'Product Vs Materials', 'product_materials', NULL, 1, 1, 1, 0, NULL, 0, '5306fa07-5a3c-40ae-be31-1930cf971fe6', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '5306fa07-4710-4549-af15-1930cf971fe6', NOW(), '5306fa07-4710-4549-af15-1930cf971fe6', NULL, NULL, NOW(), ''),
('530ecd1f-5ae0-4dc7-beaf-2f6fb6329416', 120, 'ListOfComputers', 'ListOfComputers', NULL, 1, 1, 1, 0, NULL, 0, '530c2ddf-4668-4a02-96ba-383db6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530c2de0-b334-4661-a55c-383db6329416', NOW(), '530c2de0-b334-4661-a55c-383db6329416', NULL, NULL, NOW(), ''),
('53183ebc-fd3c-451e-84b7-21d5cf971fe6', 121, 'Appraisals', 'appraisals', NULL, 1, 1, 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '523a0abb-21e0-4b44-a219-6142c6c32687', '530d86cc-96d4-49f3-a126-1d42b6329416', NOW(), '530b42fa-b30c-461c-a81c-1a0bb6329416', NULL, NULL, NOW(), '53197557-683c-4832-b16d-453751f38a45'),
('5319719f-dcd4-46cc-8dc8-465251f38a45', 122, 'KRA', 'kras', NULL, 1, 1, 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530b42fa-b30c-461c-a81c-1a0bb6329416', NOW(), '530b42fa-b30c-461c-a81c-1a0bb6329416', NULL, NULL, NOW(), ''),
('531971d1-175c-42ea-85d3-463d51f38a45', 123, 'Employee KRAs', 'employee_kras', NULL, 1, 1, 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530b42fa-b30c-461c-a81c-1a0bb6329416', NOW(), '530b42fa-b30c-461c-a81c-1a0bb6329416', NULL, NULL, NOW(), ''),
('53197203-3ad8-458f-b280-465251f38a45', 124, 'Appraisal Questions', 'appraisal_questions', NULL, 1, 1, 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530b42fa-b30c-461c-a81c-1a0bb6329416', NOW(), '530b42fa-b30c-461c-a81c-1a0bb6329416', NULL, NULL, NOW(), ''),
('53197228-0344-45e5-9217-440e51f38a45', 125, 'Employee Appraisal Questions', 'employee_appraisal_questions', NULL, 1, 1, 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530b42fa-b30c-461c-a81c-1a0bb6329416', NOW(), '530b42fa-b30c-461c-a81c-1a0bb6329416', NULL, NULL, NOW(), ''),
('5319747a-41ac-4db0-8c7c-453751f38a45', 126, 'Material Type', 'material_types', '7.5.3', 1, 1, 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530b42fa-b30c-461c-a81c-1a0bb6329416', NOW(), '530b42fa-b30c-461c-a81c-1a0bb6329416', NULL, NULL, NOW(), ''),
('531974ac-3efc-4925-8841-452c51f38a45', 127, 'Meeting Attendees', 'meeting_attendees', NULL, 1, 1, 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530b42fa-b30c-461c-a81c-1a0bb6329416', NOW(), '530b42fa-b30c-461c-a81c-1a0bb6329416', NULL, NULL, NOW(), ''),
('531ed11a-e698-40e2-bd81-1412cf971fe6', 128, 'Material Quality Checks', 'material_quality_checks', '7.4.3, 8', 1, 1, 1, 0, NULL, 0, '530c2ddf-4668-4a02-96ba-383db6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530c2de0-b334-4661-a55c-383db6329416', NOW(), '530c2de0-b334-4661-a55c-383db6329416', NULL, NULL, NOW(), ''),
('53202c58-1f2c-403e-99d3-f95f51f38a45', 129, 'Non Conforming Products Materials', 'non_conforming_products_materials', NULL, 1, 1, 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530b42fa-b30c-461c-a81c-1a0bb6329416', NOW(), '530b42fa-b30c-461c-a81c-1a0bb6329416', NULL, NULL, NOW(), '53202c95-03b8-46c9-9c42-f9ce51f38a45'),
('5329a9cf-9ab0-4093-8971-309f51f38a45', 130, 'Sevice Maintenance', 'device_maintenances', '7.5.2', 1, 1, 1, 0, NULL, 0, '530b42f9-2c60-479c-b7e9-1a0bb6329416', '522e3da7-8e48-4be2-ab9d-8545c6c3268c', '530b42fa-b30c-461c-a81c-1a0bb6329416', NOW(), '530b42fa-b30c-461c-a81c-1a0bb6329416', NULL, NULL, NOW(), '');

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `master_list_of_format_id` varchar(36) DEFAULT NULL,
  `user_id` varchar(36) NOT NULL,
  `description` text NOT NULL,
  `task_type` varchar(120) NOT NULL,
  `schedule_id` varchar(36) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`company_id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `task_statuses`
--

CREATE TABLE IF NOT EXISTS `task_statuses` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` varchar(36) NOT NULL,
  `task_performed` tinyint(2) NOT NULL,
  `comments` text NOT NULL,
  `task_date` date NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `timelines`
--

CREATE TABLE IF NOT EXISTS `timelines` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(120) NOT NULL,
  `message` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `prepared_by` varchar(36) NOT NULL,
  `approved_by` varchar(36) NOT NULL,
  `internal_audit_plan_id` varchar(36) DEFAULT NULL,
  `meeting_id` varchar(36) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT NULL,
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `trainers`
--

CREATE TABLE IF NOT EXISTS `trainers` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `trainer_type_id` varchar(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `company` varchar(120) NOT NULL,
  `designation` varchar(120) NOT NULL,
  `qualification` varchar(255) NOT NULL,
  `personal_telephone` varchar(15) NOT NULL,
  `office_telephone` varchar(15) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `personal_email` varchar(64) NOT NULL,
  `office_email` varchar(255) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `trainer_types`
--

CREATE TABLE IF NOT EXISTS `trainer_types` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(120) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `trainings`
--

CREATE TABLE IF NOT EXISTS `trainings` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `course_id` varchar(36) NOT NULL,
  `trainer_id` varchar(36) NOT NULL,
  `trainer_type_id` varchar(36) NOT NULL,
  `course_type_id` varchar(36) NOT NULL,
  `start_date_time` datetime NOT NULL,
  `end_date_time` datetime NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `training_evaluations`
--

CREATE TABLE IF NOT EXISTS `training_evaluations` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `training_id` varchar(127) DEFAULT NULL,
  `purpose_of_training` text,
  `is_it_fulfilled` text,
  `informative` text,
  `improvement` text,
  `content` text,
  `elaboration` text,
  `comments` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `training_need_identifications`
--

CREATE TABLE IF NOT EXISTS `training_need_identifications` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(36) DEFAULT NULL,
  `course_id` varchar(36) DEFAULT NULL,
  `remarks` text,
  `schedule_id` varchar(36) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `training_schedules`
--

CREATE TABLE IF NOT EXISTS `training_schedules` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `training_id` varchar(36) DEFAULT NULL,
  `schedule_date_from` date NOT NULL,
  `schedule_date_to` date NOT NULL,
  `message` text,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `training_schedule_branches`
--

CREATE TABLE IF NOT EXISTS `training_schedule_branches` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `training_schedule_id` varchar(36) DEFAULT NULL,
  `branch_id` varchar(36) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `training_schedule_departments`
--

CREATE TABLE IF NOT EXISTS `training_schedule_departments` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `training_schedule_id` varchar(36) DEFAULT NULL,
  `department_id` varchar(36) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `training_schedule_employees`
--

CREATE TABLE IF NOT EXISTS `training_schedule_employees` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `training_schedule_id` varchar(36) DEFAULT NULL,
  `employee_id` varchar(36) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `training_types`
--

CREATE TABLE IF NOT EXISTS `training_types` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(120) NOT NULL,
  `training_description` text NOT NULL,
  `mandetory` tinyint(1) NOT NULL,
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `username_password_details`
--

CREATE TABLE IF NOT EXISTS `username_password_details` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `list_of_computer_id` varchar(36) NOT NULL,
  `username` varchar(120) NOT NULL,
  `password` varchar(120) NOT NULL,
  `date_of_change` date NOT NULL,
  `employee_id` varchar(36) DEFAULT NULL COMMENT 'person who changed the details',
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) DEFAULT NULL,
  `prepared_by` varchar(36) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) DEFAULT '0',
  `master_list_of_format_id` varchar(36) DEFAULT '0',
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` varchar(36) CHARACTER SET utf8 NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(36) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `username` varchar(240) CHARACTER SET utf8 NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 NOT NULL,
  `old_password` text CHARACTER SET utf8,
  `pwd_last_modified` datetime DEFAULT NULL,
  `is_mr` tinyint(1) DEFAULT '0',
  `is_view_all` tinyint(1) DEFAULT '0',
  `is_approvar` tinyint(1) DEFAULT '0',
  `status` int(1) DEFAULT '0',
  `department_id` varchar(36) CHARACTER SET utf8 NOT NULL,
  `branch_id` varchar(36) CHARACTER SET utf8 NOT NULL,
  `language_id` varchar(36) CHARACTER SET utf8 DEFAULT '1',
  `login_status` int(1) DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `allow_multiple_login` tinyint(1) DEFAULT '0' COMMENT '0= Not allow, 1=Allow',
  `limit_login_attempt` tinyint(1) DEFAULT '1' COMMENT '0= No limit, 1= limit upto 3 attempt',
  `last_activity` datetime DEFAULT NULL,
  `user_access` text CHARACTER SET utf8,
  `copy_acl_from` varchar(36) CHARACTER SET utf8 DEFAULT NULL,
  `benchmark` int(5) NOT NULL DEFAULT '0',
  `publish` tinyint(1) DEFAULT '0' COMMENT '0=Un 1=Pub',
  `record_status` tinyint(1) DEFAULT '0' COMMENT '0=Un-locked, 1=Locked',
  `status_user_id` varchar(36) COLLATE utf8_bin DEFAULT NULL,
  `soft_delete` tinyint(1) DEFAULT '0' COMMENT '1=deleted',
  `branchid` varchar(36) CHARACTER SET utf8 NOT NULL COMMENT 'system defined automatically add',
  `departmentid` varchar(36) CHARACTER SET utf8 NOT NULL COMMENT 'system defined automatically add',
  `password_token` varchar(225) CHARACTER SET utf8 DEFAULT NULL,
  `email_token_expires` datetime DEFAULT NULL,
  `agree` tinyint(1) DEFAULT NULL,
  `company_id` varchar(36) COLLATE utf8_bin DEFAULT NULL,
  `created_by` varchar(36) CHARACTER SET utf8 NOT NULL COMMENT 'system defined automatically add',
  `created` datetime NOT NULL COMMENT 'system defined automatically add',
  `modified_by` varchar(36) CHARACTER SET utf8 NOT NULL COMMENT 'system defined automatically add',
  `approved_by` varchar(36) COLLATE utf8_bin DEFAULT NULL,
  `prepared_by` varchar(36) COLLATE utf8_bin DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'system defined automatically add',
  `system_table_id` varchar(36) CHARACTER SET utf8 DEFAULT '0',
  `master_list_of_format_id` varchar(36) CHARACTER SET utf8 DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `username_2` (`username`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `user_sessions`
--

CREATE TABLE IF NOT EXISTS `user_sessions` (
  `id` varchar(36) NOT NULL,
  `sr_no` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(18) DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `employee_id` varchar(36) NOT NULL,
  `company_id` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_no` (`sr_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- @#@ -- Table structure for table `password_settings`
--

CREATE TABLE IF NOT EXISTS `password_settings` (
  `id` varchar(36) NOT NULL,
  `password_max_len` int(2) DEFAULT NULL,
  `password_min_len` int(2) DEFAULT NULL,
  `display_policy` tinyint(1) DEFAULT NULL,
  `concurrent_login` int(1) DEFAULT NULL,
  `password_change_remind` int(2) DEFAULT NULL,
  `password_uppercase_length` int(2) DEFAULT NULL,
  `password_uppercase_start` int(2) DEFAULT NULL,
  `password_special_character` int(1) DEFAULT NULL,
  `password_same_username` int(1) DEFAULT NULL,
  `password_repeat` int(1) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT NULL,
  `record_status` tinyint(1) DEFAULT NULL,
  `status_user_id` varchar(36) DEFAULT NULL,
  `soft_delete` tinyint(1) NOT NULL,
  `branchid` varchar(36) NOT NULL,
  `departmentid` varchar(36) NOT NULL,
  `company_id` varchar(36) NOT NULL,
  `created_by` varchar(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified_by` varchar(36) NOT NULL,
  `modified` datetime NOT NULL,
  `approved_by` varchar(36) NOT NULL,
  `prepared_by` varchar(36) NOT NULL,
  `system_table_id` varchar(36) NOT NULL,
  `master_list_of_format_id` varchar(36) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
