-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2015 at 05:01 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `projects_cmscanvas_b`
--

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE IF NOT EXISTS `calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `url` varchar(255) COLLATE utf8_bin NOT NULL,
  `location` varchar(250) COLLATE utf8_bin NOT NULL,
  `featured` varchar(255) COLLATE utf8_bin NOT NULL,
  `event_author` int(11) NOT NULL,
  `allDay` varchar(255) COLLATE utf8_bin NOT NULL,
  `repeat` tinyint(1) NOT NULL DEFAULT '0',
  `series_id` int(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `series_id` (`series_id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=14 ;

--
-- Dumping data for table `calendar`
--

INSERT INTO `calendar` (`id`, `title`, `description`, `start`, `end`, `created`, `modified`, `url`, `location`, `featured`, `event_author`, `allDay`, `repeat`, `series_id`) VALUES
(10, 'Hard Rock Cafe Seat Down', '<p>Aliquam et arcu non dolor varius finibus. Nunc quis dolor vel justo fermentum imperdiet. Sed ut odio sed neque efficitur aliquam. Morbi convallis eros ut turpis bibendum, non efficitur purus euismod. Suspendisse potenti. Pellentesque quis augue porttitor, hendrerit ligula et, accumsan ex. Cras sed nulla ex. Ut lobortis condimentum nibh id scelerisque. Integer ultricies tincidunt lectus, quis luctus turpis tristique at. Suspendisse mollis, nulla sit amet dictum cursus, nisi nunc porttitor eros, quis elementum tellus nunc vitae nulla.</p>', '2015-09-10 22:30:00', '2015-09-18 13:15:12', '2015-08-01 10:11:18', '2015-09-09 22:50:04', '', '', '/assets/cms/uploads/images/bible-study-series.jpg', 10, '', 0, 0),
(11, 'Baseball Trivia Night Rerun', '<p>Aliquam et arcu non dolor varius finibus. Nunc quis dolor vel justo fermentum imperdiet. Sed ut odio sed neque efficitur aliquam. Morbi convallis eros ut turpis bibendum, non efficitur purus euismod. Suspendisse potenti.</p>\r\n\r\n<p>Pellentesque quis augue porttitor, hendrerit ligula et, accumsan ex. Cras sed nulla ex. Ut lobortis condimentum nibh id scelerisque. Integer ultricies tincidunt lectus, quis luctus turpis tristique at.</p>\r\n\r\n<p>Suspendisse mollis, nulla sit amet dictum cursus, nisi nunc porttitor eros, quis elementum tellus nunc vitae nulla.</p>', '2015-09-17 00:00:00', '2015-09-25 00:00:00', '2015-08-01 10:32:34', '2015-09-09 20:11:34', '', '', '', 10, '', 0, 0),
(12, 'Bible study night with the Man', '<p>Aliquam et arcu non dolor varius finibus. Nunc quis dolor vel justo fermentum imperdiet. Sed ut odio sed neque efficitur aliquam. Morbi convallis eros ut turpis bibendum, non efficitur purus euismod. Suspendisse potenti. Pellentesque quis augue porttitor, hendrerit ligula et, accumsan ex. Cras sed nulla ex. Ut lobortis condimentum nibh id scelerisque.</p>\r\n\r\n<p>Integer ultricies tincidunt lectus, quis luctus turpis tristique at. Suspendisse mollis, nulla sit amet dictum cursus, nisi nunc porttitor eros, quis elementum tellus nunc vitae nulla.</p>', '2015-09-22 17:00:00', '2015-09-24 20:00:00', '2015-08-01 10:45:18', '2015-09-09 22:58:54', '', '', '/assets/cms/uploads/images/survivors.jpg', 10, '', 0, 0),
(13, 'In House Golfing Tournament', '<p>Description to be added later.</p>', '2015-08-27 00:00:00', '2015-08-28 00:00:00', '2015-08-15 23:02:43', '2015-09-09 20:07:02', '', '', '', 10, '', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_group_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `url_title` varchar(255) NOT NULL,
  `description` text,
  `tag_id` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `target` varchar(50) DEFAULT NULL,
  `subcategories_visibility` enum('show','current_trail','hide') DEFAULT 'show',
  `hide` tinyint(1) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `category_group_id` (`category_group_id`,`parent_id`),
  KEY `url_title` (`url_title`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_group_id`, `parent_id`, `title`, `url_title`, `description`, `tag_id`, `class`, `target`, `subcategories_visibility`, `hide`, `sort`) VALUES
(1, 1, 0, 'News', 'news', NULL, NULL, NULL, NULL, 'show', 0, 1),
(2, 1, 0, 'Bible Study', 'bible-study', NULL, NULL, NULL, NULL, 'show', 0, 2),
(3, 1, 0, 'Men''s Group', 'mens-group', NULL, NULL, NULL, NULL, 'show', 0, 3),
(4, 1, 0, 'Women''s Group', 'womens-group', NULL, NULL, NULL, NULL, 'show', 0, 4),
(5, 2, 0, 'Staff', 'staff', NULL, NULL, NULL, NULL, 'show', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `categories_entries`
--

CREATE TABLE IF NOT EXISTS `categories_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `entry_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`,`entry_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `categories_entries`
--

INSERT INTO `categories_entries` (`id`, `category_id`, `entry_id`) VALUES
(1, 1, 5),
(2, 3, 5),
(3, 1, 17);

-- --------------------------------------------------------

--
-- Table structure for table `category_groups`
--

CREATE TABLE IF NOT EXISTS `category_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `category_groups`
--

INSERT INTO `category_groups` (`id`, `title`) VALUES
(1, 'Blog'),
(2, 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `content_fields`
--

CREATE TABLE IF NOT EXISTS `content_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_type_id` int(11) NOT NULL,
  `content_field_type_id` int(11) NOT NULL,
  `label` varchar(50) NOT NULL,
  `short_tag` varchar(50) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `options` text,
  `settings` text,
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `content_field_type_id` (`content_field_type_id`),
  KEY `content_type_id` (`content_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `content_fields`
--

INSERT INTO `content_fields` (`id`, `content_type_id`, `content_field_type_id`, `label`, `short_tag`, `required`, `options`, `settings`, `sort`) VALUES
(2, 0, 1, 'Right Column', 'right_column', 0, NULL, NULL, 2),
(15, 8, 1, 'Content', 'content', 1, NULL, 'a:2:{s:6:"height";s:0:"";s:14:"inline_editing";s:1:"1";}', 15),
(13, 2, 1, 'Hero Text', 'hero_text', 0, NULL, 'a:2:{s:6:"height";s:0:"";s:14:"inline_editing";s:1:"1";}', 13),
(12, 7, 1, 'content', 'content', 0, NULL, 'a:2:{s:6:"height";s:0:"";s:14:"inline_editing";s:1:"1";}', 2),
(11, 4, 1, 'Hero Text', 'hero_text', 0, NULL, 'a:2:{s:6:"height";s:0:"";s:14:"inline_editing";s:1:"1";}', 1),
(10, 4, 1, 'Full Width Content', 'full_width_content', 0, NULL, 'a:2:{s:6:"height";s:0:"";s:14:"inline_editing";s:1:"1";}', 2),
(14, 2, 1, 'Right Column', 'right_column', 0, NULL, 'a:2:{s:6:"height";s:0:"";s:14:"inline_editing";s:1:"1";}', 14),
(9, 6, 1, 'Content', 'content', 1, NULL, 'a:2:{s:6:"height";s:0:"";s:14:"inline_editing";s:1:"1";}', 9),
(16, 9, 1, 'Hero Text', 'hero_text', 1, NULL, 'a:2:{s:6:"height";s:0:"";s:14:"inline_editing";s:1:"1";}', 16),
(17, 9, 1, 'Full Width Content', 'full_width_content', 1, NULL, 'a:2:{s:6:"height";s:0:"";s:14:"inline_editing";s:1:"1";}', 17),
(24, 7, 8, 'Featured Image', 'featured_image', 0, NULL, 'a:7:{s:6:"output";s:5:"image";s:2:"id";s:0:"";s:5:"class";s:0:"";s:9:"max_width";s:3:"930";s:10:"max_height";s:3:"300";s:4:"crop";s:1:"1";s:14:"inline_editing";s:1:"1";}', 1),
(19, 10, 1, 'Bio', 'bio', 1, NULL, 'a:2:{s:6:"height";s:0:"";s:14:"inline_editing";s:1:"1";}', 19),
(20, 10, 8, 'Headshot', 'headshot', 0, NULL, 'a:7:{s:6:"output";s:5:"image";s:2:"id";s:0:"";s:5:"class";s:0:"";s:9:"max_width";s:3:"205";s:10:"max_height";s:3:"205";s:4:"crop";s:1:"1";s:14:"inline_editing";s:1:"1";}', 20),
(21, 10, 3, 'Position', 'position', 0, NULL, 'a:1:{s:14:"inline_editing";s:1:"1";}', 21),
(22, 10, 3, 'Phone', 'phone', 0, NULL, 'a:1:{s:14:"inline_editing";s:1:"1";}', 22),
(23, 10, 3, 'Email', 'email', 0, NULL, 'a:1:{s:14:"inline_editing";s:1:"1";}', 23),
(26, 10, 15, 'Sort Order', 'sort_order', 0, NULL, 'a:1:{s:14:"inline_editing";s:1:"0";}', 26);

-- --------------------------------------------------------

--
-- Table structure for table `content_field_types`
--

CREATE TABLE IF NOT EXISTS `content_field_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `model_name` varchar(50) NOT NULL,
  `datatype` varchar(50) NOT NULL DEFAULT 'text',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `content_field_types`
--

INSERT INTO `content_field_types` (`id`, `title`, `model_name`, `datatype`) VALUES
(1, 'CKEditor', 'ckeditor', 'text'),
(2, 'TinyMCE', 'tinymce', 'text'),
(3, 'Text', 'text', 'text'),
(4, 'Dropdown', 'dropdown', 'text'),
(5, 'Radio', 'radio', 'text'),
(6, 'Textarea', 'textarea', 'text'),
(7, 'HTML', 'html', 'text'),
(8, 'Image', 'image', 'text'),
(9, 'File', 'file', 'text'),
(10, 'Date', 'date', 'date'),
(11, 'Date Time', 'datetime', 'datetime'),
(12, 'Page URL', 'page_url', 'text'),
(13, 'Gallery', 'gallery_id', 'int'),
(14, 'Checkbox', 'checkbox', 'text'),
(15, 'Integer', 'text', 'int');

-- --------------------------------------------------------

--
-- Table structure for table `content_types`
--

CREATE TABLE IF NOT EXISTS `content_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `short_name` varchar(50) NOT NULL,
  `layout` text,
  `page_head` text,
  `theme_layout` varchar(50) DEFAULT NULL,
  `dynamic_route` varchar(255) DEFAULT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `access` tinyint(1) NOT NULL DEFAULT '0',
  `restrict_to` text,
  `restrict_admin_access` tinyint(1) NOT NULL DEFAULT '0',
  `enable_versioning` tinyint(1) NOT NULL DEFAULT '0',
  `max_revisions` int(11) NOT NULL DEFAULT '0',
  `entries_allowed` int(11) DEFAULT NULL,
  `category_group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `short_name` (`short_name`),
  KEY `dynamic_route` (`dynamic_route`),
  KEY `category_group_id` (`category_group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `content_types`
--

INSERT INTO `content_types` (`id`, `title`, `short_name`, `layout`, `page_head`, `theme_layout`, `dynamic_route`, `required`, `access`, `restrict_to`, `restrict_admin_access`, `enable_versioning`, `max_revisions`, `entries_allowed`, `category_group_id`) VALUES
(2, 'Contact Page', 'contact_page', '{{ right_column }}', NULL, 'contact_page', NULL, 0, 0, NULL, 0, 1, 5, NULL, NULL),
(3, 'Blog Landing Page', 'blog_landing-page', '\r\n\r\n{{# content:snippets snippet="blog_articles" #}}', NULL, 'blog_landing_page', NULL, 0, 0, NULL, 0, 1, 5, NULL, NULL),
(10, 'Staff', 'staff', '{{ bio }}', NULL, 'leader_details_page', NULL, 0, 0, NULL, 0, 0, 5, NULL, NULL),
(4, 'Simple Landing Page', 'simple_landing_page', '{{ full_width_content }}', NULL, 'simple_landing_page', NULL, 0, 0, NULL, 0, 1, 10, 10, NULL),
(6, 'Complex Landing Page', 'complex_landing_page', '{{ content }}', NULL, 'complex_landing_page', NULL, 0, 0, NULL, 0, 0, 5, NULL, NULL),
(11, 'Leadership', 'leadership', '{{ content }}', NULL, 'leadership_page', NULL, 0, 0, NULL, 0, 0, 5, NULL, NULL),
(7, 'Blog Articles', 'blog_articles', '{{ content }}', NULL, 'blog_article', NULL, 0, 0, NULL, 0, 0, 5, NULL, 1),
(8, 'Normal Page', 'normal_page', '{{ content }}', NULL, 'normal_pages', NULL, 0, 0, NULL, 0, 1, 10, NULL, NULL),
(9, 'Error Pages', 'error_pages', '{{ full_width_content }}', NULL, '404-page', NULL, 0, 0, NULL, 0, 0, 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `content_types_admin_groups`
--

CREATE TABLE IF NOT EXISTS `content_types_admin_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_type_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `content_type_id` (`content_type_id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `entries`
--

CREATE TABLE IF NOT EXISTS `entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `url_title` varchar(100) DEFAULT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `content_type_id` int(11) NOT NULL,
  `status` enum('published','draft') NOT NULL DEFAULT 'published',
  `meta_title` varchar(65) DEFAULT NULL,
  `meta_description` text,
  `meta_keywords` text,
  `created_date` datetime DEFAULT NULL,
  `published_date` datetime NOT NULL,
  `modified_date` datetime DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `content_type_id` (`content_type_id`),
  KEY `slug` (`slug`),
  KEY `url_title` (`url_title`),
  KEY `author_id` (`author_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `entries`
--

INSERT INTO `entries` (`id`, `slug`, `title`, `url_title`, `required`, `content_type_id`, `status`, `meta_title`, `meta_description`, `meta_keywords`, `created_date`, `published_date`, `modified_date`, `author_id`) VALUES
(1, 'home', 'Home', NULL, 0, 6, 'published', 'Welcome', NULL, NULL, '2012-03-06 21:07:07', '0000-00-00 00:00:00', '2015-09-08 04:39:23', 1),
(3, 'contact', 'Contact', NULL, 0, 2, 'published', NULL, NULL, NULL, '2012-03-07 21:45:48', '1970-01-01 01:00:00', '2015-09-08 21:50:18', NULL),
(4, 'about', 'About', NULL, 0, 4, 'published', NULL, NULL, NULL, '2012-03-11 16:06:40', '0000-00-00 00:00:00', '2015-09-08 03:08:03', NULL),
(5, 'news/welcome-to-cms-canvas', 'Welcome To CMS Canvas', NULL, 0, 7, 'published', NULL, NULL, NULL, '2015-09-05 05:03:10', '0000-00-00 00:00:00', '2015-09-07 08:04:10', 1),
(7, 'news', 'News', NULL, 0, 3, 'published', NULL, NULL, NULL, '2015-09-07 07:07:01', '0000-00-00 00:00:00', '2015-09-07 07:07:50', 1),
(8, 'giving', 'Giving', NULL, 0, 4, 'published', NULL, NULL, NULL, '2015-09-07 07:52:12', '1970-01-01 01:00:00', '2015-09-09 07:08:20', 1),
(9, 'our-story', 'Our Story', NULL, 0, 8, 'published', NULL, NULL, NULL, '2015-09-07 22:09:04', '0000-00-00 00:00:00', '2015-09-07 22:10:13', 1),
(10, 'our-beliefs', 'Our Beliefs', NULL, 0, 8, 'published', NULL, NULL, NULL, '2015-09-07 22:13:24', '0000-00-00 00:00:00', '2015-09-07 22:13:49', 1),
(11, 'our-mission', 'Our Mission', NULL, 0, 8, 'published', NULL, NULL, NULL, '2015-09-07 22:15:10', '1970-01-01 01:00:00', '2015-09-08 06:55:49', 1),
(12, 'membership', 'Membership', NULL, 0, 8, 'published', NULL, NULL, NULL, '2015-09-07 22:16:22', '1970-01-01 01:00:00', '2015-09-09 07:01:19', 1),
(13, 'new-here', 'New Here?', NULL, 0, 8, 'published', NULL, NULL, NULL, '2015-09-07 22:16:53', '0000-00-00 00:00:00', '2015-09-07 22:17:34', 1),
(14, '404', 'Page Not Found', NULL, 0, 4, 'published', NULL, NULL, NULL, '2015-09-07 23:10:53', '0000-00-00 00:00:00', '2015-09-07 23:23:00', 1),
(15, 'leadership', 'Leadership', NULL, 0, 11, 'published', NULL, NULL, NULL, '2015-09-07 23:43:44', '1970-01-01 01:00:00', '2015-09-08 19:09:17', 1),
(16, 'leadership/rev-aa-dicks', 'Rev. A.A. Dicks', NULL, 0, 10, 'published', NULL, NULL, NULL, '2015-09-07 23:56:40', '1970-01-01 01:00:00', '2015-09-08 21:35:41', 1),
(17, 'news/lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', NULL, 0, 7, 'published', NULL, NULL, NULL, '2015-09-07 23:38:35', '1970-01-01 01:00:00', '2015-09-08 06:33:46', 1),
(18, 'leadership/walt-atkins', 'Walt Atkins', NULL, 0, 10, 'published', NULL, NULL, NULL, '2015-09-08 20:56:41', '2015-09-08 20:56:41', '2015-09-08 21:02:26', 1),
(19, 'leadership/betty-simmons', 'Betty Simmons', NULL, 0, 10, 'published', NULL, NULL, NULL, '2015-09-08 21:18:26', '2015-09-08 21:18:26', '2015-09-08 21:21:47', 1),
(20, 'leadership/bobby-madden', 'Bobby Madden', NULL, 0, 10, 'published', NULL, NULL, NULL, '2015-09-08 21:24:59', '2015-09-08 21:24:59', '2015-09-08 21:26:12', 1),
(21, 'leadership/dorothy-vance', 'Dorothy Vance', NULL, 0, 10, 'published', NULL, NULL, NULL, '2015-09-08 21:27:14', '2015-09-08 21:27:14', '2015-09-08 21:28:02', 1),
(22, 'leadership/dwan-sullivan', 'Dwan Sullivan', NULL, 0, 10, 'published', NULL, NULL, NULL, '2015-09-08 21:28:36', '2015-09-08 21:28:36', '2015-09-08 21:29:55', 1),
(23, 'leadership/jonathan-jackson', 'Jonathan Jackson', NULL, 0, 10, 'published', NULL, NULL, NULL, '2015-09-08 21:30:00', '2015-09-08 21:30:00', '2015-09-08 21:31:07', 1),
(24, 'leadership/robert-smith', 'Robert Smith', NULL, 0, 10, 'published', NULL, NULL, NULL, '2015-09-08 21:31:11', '2015-09-08 21:31:11', '2015-09-08 21:32:08', 1),
(25, 'leadership/lynette-hope', 'Lynette Hope', NULL, 0, 10, 'published', NULL, NULL, NULL, '2015-09-08 21:32:50', '2015-09-08 21:32:50', '2015-09-08 21:34:03', 1),
(26, 'calendar', 'Events Calendar', NULL, 0, 4, 'published', NULL, NULL, NULL, '2015-09-09 15:27:50', '2015-09-09 15:27:50', '2015-09-09 21:46:25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `entries_data`
--

CREATE TABLE IF NOT EXISTS `entries_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_id` int(11) NOT NULL,
  `field_id_2` text,
  `field_id_9` text,
  `field_id_10` text,
  `field_id_11` text,
  `field_id_12` text,
  `field_id_13` text,
  `field_id_14` text,
  `field_id_15` text,
  `field_id_16` text,
  `field_id_17` text,
  `field_id_19` text,
  `field_id_20` text,
  `field_id_21` text,
  `field_id_22` text,
  `field_id_23` text,
  `field_id_24` text,
  `field_id_26` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `entries_data`
--

INSERT INTO `entries_data` (`id`, `entry_id`, `field_id_2`, `field_id_9`, `field_id_10`, `field_id_11`, `field_id_12`, `field_id_13`, `field_id_14`, `field_id_15`, `field_id_16`, `field_id_17`, `field_id_19`, `field_id_20`, `field_id_21`, `field_id_22`, `field_id_23`, `field_id_24`, `field_id_26`) VALUES
(1, 1, NULL, '<p>[featured_heading]</p>\r\n\r\n<h2>The Three Parts To <a data-mce-href="#" href="/our-mission/">Our Mission</a> At A Glance:</h2>\r\n\r\n<p>[/featured_heading]</p>\r\n\r\n<p>[cols_3 first=&quot;&quot;]</p>\r\n\r\n<h2>Win Souls</h2>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae purus a diam faucibus pellentesque vitae commodo erat. Pellentesque eget est id leo aliquet auctor. Vestibulum pulvinar mauris at dictum pharetra. Ut vel vulputate risus, at commodo erat.</p>\r\n\r\n<p><a data-mce-href="#" href="http://local.pagestudio.app/pages/edit/1#">Read More</a></p>\r\n\r\n<p>[/cols_3]</p>\r\n\r\n<p>[cols_3]</p>\r\n\r\n<h2>Make Disciples</h2>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae purus a diam faucibus pellentesque vitae commodo erat. Pellentesque eget est id leo aliquet auctor. Vestibulum pulvinar mauris at dictum pharetra. Ut vel vulputate risus, at commodo erat.</p>\r\n\r\n<p><a data-mce-href="#" href="http://local.pagestudio.app/pages/edit/1#">Read More</a></p>\r\n\r\n<p>[/cols_3]</p>\r\n\r\n<p>[cols_3 last=&quot;yes&quot;]</p>\r\n\r\n<h2>Change Lives</h2>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae purus a diam faucibus pellentesque vitae commodo erat. Pellentesque eget est id leo aliquet auctor. Vestibulum pulvinar mauris at dictum pharetra. Ut vel vulputate risus, at commodo erat.</p>\r\n\r\n<p><a data-mce-href="#" href="http://local.pagestudio.app/pages/edit/1#">Read More</a></p>\r\n\r\n<p>[/cols_3]</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 3, NULL, NULL, NULL, NULL, NULL, '<h2>CONTACT US</h2>\r\n\r\n<p>Thank you for stopping by! We are happy to hear from you. Please contact us using one of the methods below and we will get back to you as soon as we can.</p>', '<p>[map-it title=&quot;We are here&quot; address=&quot;206 Moore Street Street, Simpsonville, SC 29680&quot; link=&quot;https://maps.google.com/maps?oe=utf-8&amp;client=firefox-a&amp;channel=rcs&amp;q=206+Moore+Street,+Simpsonville,+SC+29680&amp;ie=UTF-8&amp;hq=&amp;hnear=0x8858271b124cb44d:0xd11767dcd807df11,206+Moore+St,+Simpsonville,+SC+29681&amp;gl=us&amp;daddr=206+Moore+St,+Simpsonville,+SC+29681&amp;ei=WTz9Ur8BhYLJAcLsgOgG&amp;ved=0CCsQwwUwAA&quot; height=&quot;240&quot; width=&quot;360&quot; border=&quot;framed&quot;]</p>\r\n\r\n<p><strong>Cedar Grove Baptist Church Simpsonville</strong></p>\r\n\r\n<p>206 Moore Street Street<br />\r\nSimpsonville, SC 29680</p>\r\n\r\n<p>Phone: 864.963.6935</p>\r\n\r\n<p>Fax: 864.963.2391</p>\r\n\r\n<p>Email: <a data-mce-href="#" href="http://local.pagestudio.app/pages/edit/9#">info@cedargrovesc.org</a></p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 4, NULL, NULL, '<p>[featured_heading]</p>\r\n\r\n<h2><a data-mce-href="#" href="/new-here/">New Here?</a> Find out what to expect when you visit our church.</h2>\r\n\r\n<p>[/featured_heading]</p>\r\n\r\n<p>[cols_3 first=&quot;&quot;]</p>\r\n\r\n<h2>Who We Are</h2>\r\n\r\n<p><a data-mce-href="/projects/pagestudio_1.1.0/leadership/" href="/leadership/"><strong>Leadership</strong></a><br />\r\nLearn about our staff &ndash; our life stories and hopes for The Village.<br />\r\n<br />\r\n<a data-mce-href="/projects/pagestudio_1.1.0/our-story" href="/our-story"><strong>Our Story</strong></a><br />\r\nRead the story of how God has graciously worked in and through a broken people.<br />\r\n<br />\r\n<a data-mce-href="/projects/pagestudio_1.1.0/our-beliefs" href="/our-beliefs"><strong>What We Believe</strong></a><br />\r\nLearn about the mission of our church and our four family traits.</p>\r\n\r\n<p>[/cols_3]</p>\r\n\r\n<p>[cols_3]</p>\r\n\r\n<p><a data-mce-href="/projects/pagestudio_1.1.0/giving/" href="/giving/"><strong>Giving</strong></a><br />\r\nFind out why we give and how to give.<br />\r\n<br />\r\n<a data-mce-href="/projects/pagestudio_1.1.0/membership/" href="/membership/"><strong>Membership</strong></a><br />\r\nTake the steps to becoming a Covenant Member of The Village.<br />\r\n<br />\r\n<a data-mce-href="/projects/pagestudio_1.1.0/our-mission/" href="/our-mission/"><strong>Our Mission</strong></a><br />\r\nLearn about baptism and sign up for Baptism Class.<br />\r\n<br />\r\n<a data-mce-href="/projects/pagestudio_1.1.0/contact/" href="/contact/"><strong>Contact Us</strong></a><br />\r\nWrite, call, visit or contact us online and read frequently asked questions.</p>\r\n\r\n<p>[/cols_3]</p>\r\n\r\n<p>[cols_3 last=&quot;yes&quot;]</p>\r\n\r\n<h2>Get Involved</h2>\r\n\r\n<p><a href="http://www.sundaystreams.com/go/dagrove1870" target="_blank"><strong>Watch Live</strong></a><br />\r\nTake the steps to becoming a Covenant Member of The Village.<br />\r\n<br />\r\n<strong>Resources</strong><br />\r\nLearn about baptism and sign up for Baptism Class.<br />\r\n<br />\r\n<a data-mce-href="/projects/pagestudio_1.1.0/calendar/" href="/calendar/"><strong>Upcoming Events</strong></a><br />\r\nWrite, call, visit or contact us online and read frequently asked questions<br />\r\n<a class="read" data-mce-href="/history-of-cedar-grove-baptist-simpsonville" href="/calendar/">view more &rarr;</a></p>\r\n\r\n<p>[/cols_3]</p>', '<h2>ABOUT US</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 17, NULL, NULL, NULL, NULL, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae purus a diam faucibus pellentesque vitae commodo erat. Pellentesque eget est id leo aliquet auctor. Vestibulum pulvinar mauris at dictum pharetra. Ut vel vulputate risus, at commodo erat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae purus a diam faucibus pellentesque vitae commodo erat. Pellentesque eget est id leo aliquet auctor. Vestibulum pulvinar mauris at dictum pharetra. Ut vel vulputate risus, at commodo erat.</p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae purus a diam faucibus pellentesque vitae commodo erat. Pellentesque eget est id leo aliquet auctor. Vestibulum pulvinar mauris at dictum pharetra. Ut vel vulputate risus, at commodo erat.</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a:2:{s:3:"src";s:49:"/assets/cms/uploads/images/bible-study-series.jpg";s:3:"alt";s:0:"";}', NULL),
(8, 8, NULL, NULL, '<p>[cols_3 first=&quot;&quot;]</p>\r\n\r\n<p>[featured_heading]</p>\r\n\r\n<h2>Give Online</h2>\r\n\r\n<p><strong>PayPal</strong><br />\r\nSed sit amet pulvinar orci, at placerat justo. Praesent id quam est. Duis ullamcorper nulla massa, eget mollis nulla condimentum in. Ut id orci tellus.</p>\r\n\r\n<p>Pellentesque nec dignissim erat. Vivamus in tristique neque. Praesent in justo ligula.</p>\r\n\r\n<p>[button text=&quot;Give Now&quot; link=&quot;#&quot; target=&quot;_blank&quot;]</p>\r\n\r\n<p>[/featured_heading]</p>\r\n\r\n<p>[/cols_3]</p>\r\n\r\n<p>[cols_3]</p>\r\n\r\n<h2>More Ways To Give</h2>\r\n\r\n<p><strong>Direct Mail</strong><br />\r\nPlease do not send cash via US mail. For checks, please make them out to:<br />\r\n<br />\r\n<strong>Cedar Grove Baptist Church Simpsonville</strong><br />\r\nAttention: Finance Department<br />\r\n206 Moore Street Street, Simpsonville, SC 29680<br />\r\n<br />\r\n<strong>Have A Question?</strong><br />\r\nContact us online, via phone 864.999.5544, or email us at info@cedargrovesc.org.</p>\r\n\r\n<p>[/cols_3]</p>\r\n\r\n<p>[cols_3 last=&quot;yes&quot;]</p>\r\n\r\n<h2>Thank You</h2>\r\n\r\n<p>Your prayers, tithes, and offerings help fulfill the mission of making disciples and planting churches! Christ calls his followers to work and be on mission until He returns &ndash; and you are doing just that. Thank you!</p>\r\n\r\n<p>Christ Himself said that it is more blessed to give than to receive (<a data-mce-href="http://www.esvbible.org/Acts%2020%3A35/" href="http://www.esvbible.org/Acts%2020%3A35/" target="_blank">Acts 20:35</a>). So whatever your gift, may Jesus&rsquo; words be true in your life, and may you be blessed by giving toward the work of Jesus. You are loved and appreciated. In Jesus&rsquo; name, thank you!</p>\r\n\r\n<p>[/cols_3]</p>', '<h2>Giving Financially</h2>\r\n\r\n<p>We have a tremendous opportunity to proclaim the gospel by giving generously. Giving invigorates our devotion to Christ and frees us from the tyranny of consumerism. It provides an outlet for compassion and allows us to proclaim His sufficiency and provision. As people of faith, we give faithfully.</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 5, NULL, NULL, NULL, NULL, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pellentesque volutpat ipsum, vel volutpat risus accumsan eu. Phasellus eu odio lectus, congue ultrices quam. Donec et luctus orci. Proin eu eros quis lectus posuere iaculis et eget nisi. Nunc ullamcorper dolor in sem pulvinar ac volutpat velit pretium. Nullam et cursus nisi. In laoreet, leo id facilisis placerat, tortor odio luctus ante, at pharetra leo diam nec lectus. Maecenas adipiscing eleifend erat, et molestie magna facilisis vitae.</p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pellentesque volutpat ipsum, vel volutpat risus accumsan eu. Phasellus eu odio lectus, congue ultrices quam. Donec et luctus orci.</p>\r\n\r\n<p>Proin eu eros quis lectus posuere iaculis et eget nisi. Nunc ullamcorper dolor in sem pulvinar ac volutpat velit pretium. Nullam et cursus nisi. In laoreet, leo id facilisis placerat, tortor odio luctus ante, at pharetra leo diam nec lectus. Maecenas adipiscing eleifend erat, et molestie magna facilisis vitae.</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<h2>Historical Account</h2>\r\n\r\n<p>The following historical chronicle of the Cedar Grove Baptist Church, Simpsonville, South Carolina, is an attempt to recount the efforts of those who counted it a privilege to sacrifice so that the Word of the Lord might be heard, taught, and lived. Thus, it is with a deep sense of indebtedness and thanksgiving that a special salute is extended to those both -living and dead who have made outstanding and sacrificial contributions to the growth of our spiritual heritage. Thus, the following historical record is offered for the reader&rsquo;s examination, appreciation, and inspiration.</p>\r\n\r\n<p>During the Post Civil War period, Blacks in Simpsonville prayed for their own place of worship. Their prayers were answered when Tom Moore, a local white citizen , donated several parcels of land to be used for a place of worship. Clothed in armors of faith and determination, this group of Christian warriors, under the leadership of the Reverend Tom Jones, completed the construction of a brush arbor in July of 1870. Because of the density of cedar trees surrounding the building, the church was named Cedar Grove.</p>\r\n\r\n<p>These pioneers were not only imbued with the Holy Spirit, but they also possessed vision, perseverance, and wisdom. Consequently, they recognized the inadequacy of the church&rsquo;s physical facilities and made plans to build a new church in 1876. Constructed of pine and poplar logs, the church was completed during the summer of 1877, just in time for the members to hold their first August revival.</p>\r\n\r\n<p>In 1937, a membership exceeding two hundred necessitated the need for still a larger church. Therefore, a frame structure was completed in 1938. The existing building was renovated and bricked in 1962. An educational wing was added in 1972. As a result of additional membership growth, groundbreaking services were held December 8, 1985, for the construction of the present edifice which contains a sanctuary that seats more than three hundred and fifty, offices, educational classrooms, a library, and a baptistery. On Sunday, October 5, 1986, members marched from the old sanctuary to the new sanctuary where the first worship service was held. The new edifice was dedicated Sunday, November 16, 1986. The $332, 000 loan for such was liquidated in 1992.</p>\r\n\r\n<p>Since we have a biblical mandate to minister from a holistic perspective, the need for additional space was acknowledged. Consequently, groundbreaking services for a 2.2 million dollar Family Life Center were held on Sunday, June 11, 2000. This much-needed facility contains three offices, four classrooms, a conference room, a gymnasium with a stage, a walking track, a family room, an exercise room, a family room, a weight room, and a commercial kitchen.</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<h2>Our beliefs can be summarized as follows:</h2>\r\n\r\n<p><strong>The Bible:&nbsp;</strong>We believe the Bible to be the verbally inspired Word of God, inerrant in the original manuscripts and the sufficient and final authority for all matters of faith, practice, and life. (II Timothy 3:16)</p>\r\n\r\n<p><strong>God:</strong> We believe God is triune, being three in person and one in essence. The Father, Son, and Spirit are equally God but are three in person. This God is the center of our worship. (Matthew 28:19-20)</p>\r\n\r\n<p><strong>The Father:</strong> We believe in the sovereign rule of the Father who assumes headship of all that He created and continues to care and sustain in providence all that exists. (Isaiah 40)<br />\r\n<br />\r\n<strong>Jesus:</strong> We believe that the eternal Son took on human flesh, being born of a virgin, and that Jesus Christ is truly God and truly man, the only mediator between God and man. (Matthew 1:23-25, I Timothy 2:5, Philippians 2:5-7)<br />\r\n<br />\r\n<strong>Sin:</strong> We believe that all have sinned and are under the condemnation of death. (Romans 3:23 and 6:23)<br />\r\n<br />\r\n<strong>Atonement:</strong> We believe that Jesus, according to the will of God the Father, offered Himself as a substitutionary sacrifice and that all who believe in Him have eternal life. On the cross, Jesus defeated evil, sin and death. He shed His blood so that those who repent and believe will have life in Him as their Lord and Savior. (John 3:1, Romans 10:9-10)<br />\r\n<br />\r\n<strong>Salvation:</strong> We believe that salvation is by grace through faith, and that true faith in the gospel will be made evident by a life of godliness, which is only possible by walking with the Holy Spirit, and by participation with the community of the saints. (Acts 2:42, Ephesians 2:10, Philippians 2:12, Hebrews 10:25)<br />\r\n<br />\r\n<strong>Resurrection:</strong> We believe in the bodily resurrection of Jesus as the first fruits of our resurrection and His ascension into heaven to the right hand of the Father. We look forward in hope to His second coming in glory. (I Corinthians 15:3-8, II Peter 3)<br />\r\n<br />\r\n<strong>Ordinances: </strong>We believe that baptism is a faithful response to God&rsquo;s grace, signifying one&rsquo;s identification with Christ and His church and the church&rsquo;s privilege is to commune with the triune God and His people in celebrating the Lord&rsquo;s Supper. (Acts 2:3)<br />\r\n<br />\r\n<strong>The Church:</strong> We believe that the church is the pillar and foundation of the truth, sharing in God&rsquo;s redemptive mission through proclamation of the gospel by word and deed, resulting in transformed lives committed to God&rsquo;s glory. The church is the community where the people of God share their lives in fellowship with God and each other. (I Timothy 3:15, Matthew 28:19-20)<br />\r\n<br />\r\n<strong>Eternity:</strong> We believe in a coming Great Day where all people -- the living and the dead -- will stand before God in order to hear His verdict concerning their eternal destiny, either heaven or hell. (Revelation 20:11-15, I Corinthians 3:12-15)</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<h2>Creating a welcoming environment</h2>\r\n\r\n<p>Some text can go here that focuses on the key points below...</p>\r\n\r\n<h3><em>The vision of the Church</em></h3>\r\n\r\n<p>Make your vision intensely personal and relational. It should be one in which we dwell in the heart of Christ as He dwells in us (Jn. 15:1-15; other key vision passages are Ps. 45, Ps. 110, Rev. 1, Heb. 1, John 1 and Col. 1:15-23). A church which defines its vision in terms of this &ldquo;beatific vision&rdquo; of Christ will have a much greater impact for the Kingdom of God than a church whose vision is defined in terms of buildings, staff, and programs alone.</p>\r\n\r\n<h3>The mission of the Church</h3>\r\n\r\n<p>There are key passages found in the Bible such as Matthew 28:18-20 and Acts 1:8 that can be used in order to determine a church&#39;s mission. Here is a sample &quot;Our mission is to be witnesses who make disciples, who in turn become loyal and loving subjects of Christ.</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<h2>Membership Class</h2>\r\n\r\n<p>We want you to make an informed decision about joining our church. Our class covers what it means to be a Covenant Member and our beliefs and bylaws.</p>\r\n\r\n<h3>Baptism at Cedar Grove Baptist Simpsonville</h3>\r\n\r\n<p>For many, baptism is the first public step of obedience to Christ. If you have not been baptized following salvation, we ask you to take this step before becoming a Covenant Member. To help prepare you, we offer a <a data-mce-href="#" href="http://local.pagestudio.app/pages/edit/17#">Baptism Class</a>. The class covers the biblical significance of baptism, frequently asked questions and gives you an opportunity to share your testimony.</p>\r\n\r\n<h3>Required Reading</h3>\r\n\r\n<p>We require prospective members to read <a data-mce-href="#" href="http://local.pagestudio.app/pages/edit/17#"><em>Church Membership</em></a> by [Author&#39;s name] before signing the Membership Covenant. This book is handed out at Membership Class.</p>\r\n\r\n<h3>Signing the Covenant</h3>\r\n\r\n<p>Need to add some text here...</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<h2>What To Expect</h2>\r\n\r\n<p>Knowing what to expect before going somewhere for the first time makes a big difference. Take some time to get to know us. We have highlighted several key areas of information that should help you to see into our services. We&rsquo;re glad you&rsquo;re here and we hope you stay!</p>\r\n\r\n<h2>Time &amp; Locations</h2>\r\n\r\n<h2>Values and Beliefs</h2>\r\n\r\n<h2>Baptism</h2>\r\n\r\n<h2>Department Directory</h2>\r\n\r\n<h2>Job Opportunities</h2>\r\n\r\n<p>We hope this information was helpful to you. If you find that it wasn&#39;t enough or would like to get in touch with us, simply follow this <a data-mce-href="#" href="http://local.pagestudio.app/pages/edit/5#">link</a> to our contact page. Again, we are glad that you are here!</p>\r\n\r\n<p>Yours truly,</p>\r\n\r\n<p>The CGB Staff</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 14, NULL, NULL, '<p>[featured_heading]</p>\r\n\r\n<h2><a data-mce-href="#" href="http://local.pagestudio.app/pages/edit/2#">New Here?</a> Find out what to expect when you visit our church.</h2>\r\n\r\n<p>[/featured_heading]</p>\r\n\r\n<p>[cols_3 first=&quot;&quot;]</p>\r\n\r\n<h2>Who We Are</h2>\r\n\r\n<p><a data-mce-href="/projects/pagestudio_1.1.0/leadership/" href="http://local.pagestudio.app/projects/pagestudio_1.1.0/leadership/"><strong>Leadership</strong></a><br />\r\nLearn about our staff &ndash; our life stories and hopes for The Village.<br />\r\n<br />\r\n<a data-mce-href="/projects/pagestudio_1.1.0/our-story" href="http://local.pagestudio.app/projects/pagestudio_1.1.0/our-story"><strong>Our Story</strong></a><br />\r\nRead the story of how God has graciously worked in and through a broken people.<br />\r\n<br />\r\n<a data-mce-href="/projects/pagestudio_1.1.0/our-beliefs" href="http://local.pagestudio.app/projects/pagestudio_1.1.0/our-beliefs"><strong>What We Believe</strong></a><br />\r\nLearn about the mission of our church and our four family traits.</p>\r\n\r\n<p>[/cols_3]</p>\r\n\r\n<p>[cols_3]</p>\r\n\r\n<p><a data-mce-href="/projects/pagestudio_1.1.0/giving/" href="http://local.pagestudio.app/projects/pagestudio_1.1.0/giving/"><strong>Giving</strong></a><br />\r\nFind out why we give and how to give.<br />\r\n<br />\r\n<a data-mce-href="/projects/pagestudio_1.1.0/membership/" href="http://local.pagestudio.app/projects/pagestudio_1.1.0/membership/"><strong>Membership</strong></a><br />\r\nTake the steps to becoming a Covenant Member of The Village.<br />\r\n<br />\r\n<a data-mce-href="/projects/pagestudio_1.1.0/our-mission/" href="http://local.pagestudio.app/projects/pagestudio_1.1.0/our-mission/"><strong>Our Mission</strong></a><br />\r\nLearn about baptism and sign up for Baptism Class.<br />\r\n<br />\r\n<a data-mce-href="/projects/pagestudio_1.1.0/contact/" href="http://local.pagestudio.app/projects/pagestudio_1.1.0/contact/"><strong>Contact Us</strong></a><br />\r\nWrite, call, visit or contact us online and read frequently asked questions.</p>\r\n\r\n<p>[/cols_3]</p>\r\n\r\n<p>[cols_3 last=&quot;yes&quot;]</p>\r\n\r\n<h2>Get Involved</h2>\r\n\r\n<p><strong>Watch Live</strong><br />\r\nTake the steps to becoming a Covenant Member of The Village.<br />\r\n<br />\r\n<strong>Resources</strong><br />\r\nLearn about baptism and sign up for Baptism Class.<br />\r\n<br />\r\n<a data-mce-href="/projects/pagestudio_1.1.0/calendar/" href="http://local.pagestudio.app/projects/pagestudio_1.1.0/calendar/"><strong>Upcoming Events</strong></a><br />\r\nWrite, call, visit or contact us online and read frequently asked questions<br />\r\n<a class="read" data-mce-href="/history-of-cedar-grove-baptist-simpsonville" href="http://local.pagestudio.app/history-of-cedar-grove-baptist-simpsonville">view more &rarr;</a></p>\r\n\r\n<p>[/cols_3]</p>', '<h2>Error 404</h2>\r\n\r\n<p>Hmmm... It looks like you followed an old link or this page has been moved and is no longer where you thought. Please try one of the links below.</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<h2>Life Story</h2>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pellentesque volutpat ipsum, vel volutpat risus accumsan eu. Phasellus eu odio lectus, congue ultrices quam. Donec et luctus orci. Proin eu eros quis lectus posuere iaculis et eget nisi. Nunc ullamcorper dolor in sem pulvinar ac volutpat velit pretium. Nullam et cursus nisi. In laoreet, leo id facilisis placerat, tortor odio luctus ante, at pharetra leo diam nec lectus. Maecenas adipiscing eleifend erat, et molestie magna facilisis vitae.</p>\r\n\r\n<h2>Hope for Cedar Grove Baptist SC</h2>\r\n\r\n<p>Quisque lobortis scelerisque nunc, eu pulvinar risus accumsan nec. Nulla pharetra scelerisque turpis cursus convallis. Duis a magna luctus, accumsan nisl a, bibendum quam.</p>', 'a:2:{s:3:"src";s:78:"/assets/cms/uploads/images/Staff%20Headshots/rev-aa-dicks-headshot_205x205.jpg";s:3:"alt";s:21:"Rev. Anthony A. Dicks";}', 'Senior Pastor', '864.555-9595', 'rev.anthony.dicks@cedargrovesc.org', NULL, 1),
(18, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<h2>Life Story</h2>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pellentesque volutpat ipsum, vel volutpat risus accumsan eu. Phasellus eu odio lectus, congue ultrices quam. Donec et luctus orci. Proin eu eros quis lectus posuere iaculis et eget nisi. Nunc ullamcorper dolor in sem pulvinar ac volutpat velit pretium. Nullam et cursus nisi. In laoreet, leo id facilisis placerat, tortor odio luctus ante, at pharetra leo diam nec lectus. Maecenas adipiscing eleifend erat, et molestie magna facilisis vitae.</p>\r\n\r\n<h2>Hope for Cedar Grove Baptist SC</h2>\r\n\r\n<p>Quisque lobortis scelerisque nunc, eu pulvinar risus accumsan nec. Nulla pharetra scelerisque turpis cursus convallis. Duis a magna luctus, accumsan nisl a, bibendum quam.</p>', 'a:2:{s:3:"src";s:77:"/assets/cms/uploads/images/Staff%20Headshots/walt-atkins-headshot_205x205.jpg";s:3:"alt";s:11:"Walt Atkins";}', 'Super Loving Human', '864-555-9595', 'walt.atkins@cedargrovesc.org', NULL, NULL),
(19, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<h2>Life Story</h2>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pellentesque volutpat ipsum, vel volutpat risus accumsan eu. Phasellus eu odio lectus, congue ultrices quam. Donec et luctus orci. Proin eu eros quis lectus posuere iaculis et eget nisi. Nunc ullamcorper dolor in sem pulvinar ac volutpat velit pretium. Nullam et cursus nisi. In laoreet, leo id facilisis placerat, tortor odio luctus ante, at pharetra leo diam nec lectus. Maecenas adipiscing eleifend erat, et molestie magna facilisis vitae.</p>\r\n\r\n<h2>Hope for Cedar Grove Baptist SC</h2>\r\n\r\n<p>Quisque lobortis scelerisque nunc, eu pulvinar risus accumsan nec. Nulla pharetra scelerisque turpis cursus convallis. Duis a magna luctus, accumsan nisl a, bibendum quam.</p>', 'a:2:{s:3:"src";s:79:"/assets/cms/uploads/images/Staff%20Headshots/betty-simmons-headshot_205x205.jpg";s:3:"alt";s:13:"Betty Simmons";}', 'Super Loving Human', '864-555-9595', 'betty.simmons@cedargrovesc.org', NULL, NULL),
(20, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<h2>Life Story</h2>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pellentesque volutpat ipsum, vel volutpat risus accumsan eu. Phasellus eu odio lectus, congue ultrices quam. Donec et luctus orci. Proin eu eros quis lectus posuere iaculis et eget nisi. Nunc ullamcorper dolor in sem pulvinar ac volutpat velit pretium. Nullam et cursus nisi. In laoreet, leo id facilisis placerat, tortor odio luctus ante, at pharetra leo diam nec lectus. Maecenas adipiscing eleifend erat, et molestie magna facilisis vitae.</p>\r\n\r\n<h2>Hope for Cedar Grove Baptist SC</h2>\r\n\r\n<p>Quisque lobortis scelerisque nunc, eu pulvinar risus accumsan nec. Nulla pharetra scelerisque turpis cursus convallis. Duis a magna luctus, accumsan nisl a, bibendum quam.</p>', 'a:2:{s:3:"src";s:78:"/assets/cms/uploads/images/Staff%20Headshots/bobby-madden-headshot_205x205.jpg";s:3:"alt";s:12:"Bobby Madden";}', 'Super Loving Human', '864-555-9595', 'bobby.madden@cedargrovesc.org', NULL, NULL),
(21, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<h2>Life Story</h2>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pellentesque volutpat ipsum, vel volutpat risus accumsan eu. Phasellus eu odio lectus, congue ultrices quam. Donec et luctus orci. Proin eu eros quis lectus posuere iaculis et eget nisi. Nunc ullamcorper dolor in sem pulvinar ac volutpat velit pretium. Nullam et cursus nisi. In laoreet, leo id facilisis placerat, tortor odio luctus ante, at pharetra leo diam nec lectus. Maecenas adipiscing eleifend erat, et molestie magna facilisis vitae.</p>\r\n\r\n<h2>Hope for Cedar Grove Baptist SC</h2>\r\n\r\n<p>Quisque lobortis scelerisque nunc, eu pulvinar risus accumsan nec. Nulla pharetra scelerisque turpis cursus convallis. Duis a magna luctus, accumsan nisl a, bibendum quam.</p>', 'a:2:{s:3:"src";s:79:"/assets/cms/uploads/images/Staff%20Headshots/dorothy-vance-headshot_205x205.jpg";s:3:"alt";s:13:"Dorothy Vance";}', 'Super Loving Human', '864-555-9595', 'dorothy-vance@cedargrovesc.org', NULL, NULL),
(22, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<h2>Life Story</h2>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pellentesque volutpat ipsum, vel volutpat risus accumsan eu. Phasellus eu odio lectus, congue ultrices quam. Donec et luctus orci. Proin eu eros quis lectus posuere iaculis et eget nisi. Nunc ullamcorper dolor in sem pulvinar ac volutpat velit pretium. Nullam et cursus nisi. In laoreet, leo id facilisis placerat, tortor odio luctus ante, at pharetra leo diam nec lectus. Maecenas adipiscing eleifend erat, et molestie magna facilisis vitae.</p>\r\n\r\n<h2>Hope for Cedar Grove Baptist SC</h2>\r\n\r\n<p>Quisque lobortis scelerisque nunc, eu pulvinar risus accumsan nec. Nulla pharetra scelerisque turpis cursus convallis. Duis a magna luctus, accumsan nisl a, bibendum quam.</p>', 'a:2:{s:3:"src";s:79:"/assets/cms/uploads/images/Staff%20Headshots/dwan-sullivan-headshot_205x205.jpg";s:3:"alt";s:13:"Dwan Sullivan";}', 'Super Loving Human', '864-555-9595', 'dwan-sullivan@cedargrovesc.org', NULL, NULL),
(23, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<h2>Life Story</h2>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pellentesque volutpat ipsum, vel volutpat risus accumsan eu. Phasellus eu odio lectus, congue ultrices quam. Donec et luctus orci. Proin eu eros quis lectus posuere iaculis et eget nisi. Nunc ullamcorper dolor in sem pulvinar ac volutpat velit pretium. Nullam et cursus nisi. In laoreet, leo id facilisis placerat, tortor odio luctus ante, at pharetra leo diam nec lectus. Maecenas adipiscing eleifend erat, et molestie magna facilisis vitae.</p>\r\n\r\n<h2>Hope for Cedar Grove Baptist SC</h2>\r\n\r\n<p>Quisque lobortis scelerisque nunc, eu pulvinar risus accumsan nec. Nulla pharetra scelerisque turpis cursus convallis. Duis a magna luctus, accumsan nisl a, bibendum quam.</p>', 'a:2:{s:3:"src";s:82:"/assets/cms/uploads/images/Staff%20Headshots/jonathan-jackson-headshot_205x205.jpg";s:3:"alt";s:16:"Jonathan Jackson";}', 'Super Loving Human', '864-555-9595', 'jonathan-jackson@cedargrovesc.org', NULL, NULL),
(24, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<h2>Life Story</h2>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pellentesque volutpat ipsum, vel volutpat risus accumsan eu. Phasellus eu odio lectus, congue ultrices quam. Donec et luctus orci. Proin eu eros quis lectus posuere iaculis et eget nisi. Nunc ullamcorper dolor in sem pulvinar ac volutpat velit pretium. Nullam et cursus nisi. In laoreet, leo id facilisis placerat, tortor odio luctus ante, at pharetra leo diam nec lectus. Maecenas adipiscing eleifend erat, et molestie magna facilisis vitae.</p>\r\n\r\n<h2>Hope for Cedar Grove Baptist SC</h2>\r\n\r\n<p>Quisque lobortis scelerisque nunc, eu pulvinar risus accumsan nec. Nulla pharetra scelerisque turpis cursus convallis. Duis a magna luctus, accumsan nisl a, bibendum quam.</p>', 'a:2:{s:3:"src";s:78:"/assets/cms/uploads/images/Staff%20Headshots/robert-smith-headshot_205x205.jpg";s:3:"alt";s:12:"Robert Smith";}', 'Super Loving Human', '864-555-9595', 'robert.smith@cedargrovesc.org', NULL, NULL),
(25, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<h2>Life Story</h2>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pellentesque volutpat ipsum, vel volutpat risus accumsan eu. Phasellus eu odio lectus, congue ultrices quam. Donec et luctus orci. Proin eu eros quis lectus posuere iaculis et eget nisi. Nunc ullamcorper dolor in sem pulvinar ac volutpat velit pretium. Nullam et cursus nisi. In laoreet, leo id facilisis placerat, tortor odio luctus ante, at pharetra leo diam nec lectus. Maecenas adipiscing eleifend erat, et molestie magna facilisis vitae.</p>\r\n\r\n<h2>Hope for Cedar Grove Baptist SC</h2>\r\n\r\n<p>Quisque lobortis scelerisque nunc, eu pulvinar risus accumsan nec. Nulla pharetra scelerisque turpis cursus convallis. Duis a magna luctus, accumsan nisl a, bibendum quam.</p>', 'a:2:{s:3:"src";s:78:"/assets/cms/uploads/images/Staff%20Headshots/lynette-hope-headshot_205x205.jpg";s:3:"alt";s:12:"Lynette Hope";}', 'Super Loving Human', '864-555-9595', 'lenette.hope@cedargrovesc.org', NULL, NULL),
(26, 26, NULL, NULL, NULL, '<h2>Event Calendar</h2>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE IF NOT EXISTS `galleries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `title`) VALUES
(1, 'Home Slider');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE IF NOT EXISTS `gallery_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) NOT NULL,
  `gallery_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `alt` varchar(250) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `hide` tinyint(1) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `gallery_id` (`gallery_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `filename`, `gallery_id`, `title`, `alt`, `description`, `hide`, `sort`) VALUES
(1, '/assets/cms/uploads/images/bible-study-series.jpg', 1, 'Bible Study Series', NULL, '<p>This is some random text that can be added to the slider.</p>', 0, 3),
(2, '/assets/cms/uploads/images/survivors.jpg', 1, 'Blogs Bg', NULL, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae purus a diam faucibus pellentesque vitae commodo erat.</p>', 0, 2),
(3, '/assets/cms/uploads/images/sermon-series.jpg', 1, 'Sermon Series', NULL, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` varchar(15) NOT NULL,
  `permissions` text,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `modifiable_permissions` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `type`, `permissions`, `required`, `modifiable_permissions`) VALUES
(1, 'Super Admin', 'super_admin', NULL, 1, 0),
(2, 'Administrator', 'administrator', 'a:1:{s:6:"access";a:12:{i:0;s:23:"sitemin/content/entries";i:1;s:19:"sitemin/navigations";i:2;s:17:"sitemin/galleries";i:3;s:13:"sitemin/users";i:4;s:20:"sitemin/users/groups";i:5;s:21:"sitemin/content/types";i:6;s:24:"sitemin/content/snippets";i:7;s:18:"sitemin/categories";i:8;s:29:"sitemin/settings/theme-editor";i:9;s:33:"sitemin/settings/general-settings";i:10;s:28:"sitemin/settings/clear-cache";i:11;s:28:"sitemin/settings/server-info";}}', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `navigations`
--

CREATE TABLE IF NOT EXISTS `navigations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `navigations`
--

INSERT INTO `navigations` (`id`, `title`, `required`) VALUES
(1, 'Main Navigation', 0),
(2, 'Side Navigation', 0);

-- --------------------------------------------------------

--
-- Table structure for table `navigation_items`
--

CREATE TABLE IF NOT EXISTS `navigation_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(25) NOT NULL,
  `entry_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `tag_id` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `target` varchar(50) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `navigation_id` int(11) NOT NULL,
  `subnav_visibility` enum('show','current_trail','hide') DEFAULT 'show',
  `hide` tinyint(1) NOT NULL DEFAULT '0',
  `disable_current` tinyint(1) NOT NULL DEFAULT '0',
  `disable_current_trail` tinyint(1) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `navigation_items`
--

INSERT INTO `navigation_items` (`id`, `type`, `entry_id`, `title`, `url`, `tag_id`, `class`, `target`, `parent_id`, `navigation_id`, `subnav_visibility`, `hide`, `disable_current`, `disable_current_trail`, `sort`) VALUES
(1, 'page', 1, NULL, NULL, NULL, NULL, NULL, 0, 1, 'show', 0, 0, 0, 0),
(2, 'page', 4, NULL, NULL, NULL, NULL, NULL, 0, 1, 'show', 0, 0, 0, 1),
(3, 'page', 3, NULL, NULL, NULL, NULL, NULL, 0, 1, 'show', 0, 0, 0, 12),
(4, 'url', NULL, 'News', '/news/', NULL, NULL, NULL, 0, 1, 'show', 0, 0, 0, 10),
(5, 'page', 8, NULL, NULL, NULL, NULL, NULL, 0, 1, 'show', 0, 0, 0, 7),
(6, 'page', 9, NULL, NULL, NULL, NULL, NULL, 2, 1, 'show', 0, 0, 0, 6),
(7, 'page', 10, NULL, NULL, NULL, NULL, NULL, 2, 1, 'show', 0, 0, 0, 4),
(8, 'page', 11, NULL, NULL, NULL, NULL, NULL, 2, 1, 'show', 0, 0, 0, 5),
(9, 'page', 12, NULL, NULL, NULL, NULL, NULL, 2, 1, 'show', 0, 0, 0, 3),
(10, 'page', 13, 'Guests', NULL, NULL, NULL, NULL, 0, 1, 'show', 0, 0, 0, 8),
(11, 'url', NULL, 'Directions', 'https://maps.google.com/maps?oe=utf-8&client=firefox-a&channel=rcs&q=206+Moore+Street,+Simpsonville,+SC+29680&ie=UTF-8&hq=&hnear=0x8858271b124cb44d:0xd11767dcd807df11,206+Moore+St,+Simpsonville,+SC+29681&gl=us&daddr=206+Moore+St,+Simpsonville,+SC+29681&ei', NULL, 'hide-on-desktop', '_blank', 0, 1, 'show', 0, 0, 0, 13),
(31, 'page', 10, NULL, NULL, NULL, NULL, NULL, 0, 2, 'show', 0, 0, 0, 3),
(30, 'page', 9, NULL, NULL, NULL, NULL, NULL, 0, 2, 'show', 0, 0, 0, 5),
(36, 'url', NULL, 'Watch Online', 'http://www.sundaystreams.com/go/dagrove1870', NULL, NULL, '_blank', 0, 1, 'show', 0, 0, 0, 11),
(28, 'page', 3, NULL, NULL, NULL, NULL, NULL, 0, 2, 'show', 0, 0, 0, 7),
(27, 'page', 4, NULL, NULL, NULL, NULL, NULL, 0, 2, 'show', 0, 0, 0, 0),
(39, 'page', 26, 'Calendar', NULL, NULL, NULL, NULL, 0, 1, 'show', 0, 0, 0, 9),
(38, 'page', 15, NULL, NULL, NULL, NULL, NULL, 0, 2, 'show', 0, 0, 0, 1),
(37, 'page', 15, NULL, NULL, NULL, NULL, NULL, 2, 1, 'show', 0, 0, 0, 2),
(32, 'page', 11, NULL, NULL, NULL, NULL, NULL, 0, 2, 'show', 0, 0, 0, 4),
(33, 'page', 12, NULL, NULL, NULL, NULL, NULL, 0, 2, 'show', 0, 0, 0, 2),
(34, 'page', 13, 'Visiting Us', NULL, NULL, NULL, NULL, 0, 2, 'show', 0, 0, 0, 6);

-- --------------------------------------------------------

--
-- Table structure for table `revisions`
--

CREATE TABLE IF NOT EXISTS `revisions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `revision_resource_type_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `content_type_id` int(11) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `author_name` varchar(150) NOT NULL,
  `revision_date` datetime NOT NULL,
  `revision_data` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `revision_resource_type_id` (`revision_resource_type_id`),
  KEY `content_type_id` (`content_type_id`),
  KEY `resource_id` (`resource_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=124 ;

--
-- Dumping data for table `revisions`
--

INSERT INTO `revisions` (`id`, `revision_resource_type_id`, `resource_id`, `content_type_id`, `author_id`, `author_name`, `revision_date`, `revision_data`) VALUES
(1, 1, 1, 1, 1, 'Albert Einstein', '2012-03-11 16:26:38', 'a:10:{s:5:"title";s:4:"Home";s:10:"field_id_2";s:992:"<p>\n  Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna <a href="#">aliquam</a> erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>\n<p>\n Sed ut perspiciatis unde <a href="#">omnis</a> iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>\n<h1>\n  H1 Tag</h1>\n<h2>\n H2 Tag</h2>\n<h3>\n H3 Tag</h3>\n<h4>\n H4 Tag</h4>\n<p>\n  <strong>Strong</strong></p>\n<ul>\n <li>\n    List Item 1\n   <ul>\n      <li>\n        Indented Item 1</li>\n      <li>\n        Indented Item 2</li>\n    </ul>\n </li>\n <li>\n    List Item 2</li>\n  <li>\n    List Item 3</li>\n  <li>\n    List Item 4</li>\n</ul>";s:10:"field_id_1";s:684:"<h2>\n  Lorem Ipsum</h2>\n<p>\n Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>\n<p>\n Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>";s:4:"slug";s:4:"home";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:15:"content_type_id";s:1:"1";s:12:"created_date";s:22:"03/06/2012 09:07:07 pm";}'),
(2, 1, 4, 1, 1, 'Albert Einstein', '2012-03-11 16:27:01', 'a:10:{s:5:"title";s:5:"About";s:10:"field_id_2";s:2647:"<p>\n  Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>\n<p>\n Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>\n<p>\n Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>\n<p>\n Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>\n<p>\n Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>\n<p>\n Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>\n<p>\n Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>\n<p>\n Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>";s:10:"field_id_1";s:684:"<h2>\n Lorem Ipsum</h2>\n<p>\n Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>\n<p>\n Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>";s:4:"slug";s:5:"about";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:15:"content_type_id";s:1:"1";s:12:"created_date";s:22:"03/11/2012 04:06:40 pm";}'),
(3, 1, 3, 2, 1, 'Albert Einstein', '2012-03-11 16:27:31', 'a:8:{s:5:"title";s:7:"Contact";s:4:"slug";s:7:"contact";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:15:"content_type_id";s:1:"2";s:12:"created_date";s:22:"03/07/2012 09:45:48 pm";}'),
(97, 2, 9, NULL, 1, 'Cosmo Mathieu', '2015-09-07 23:15:16', 'a:12:{s:6:"layout";s:13:"{{ content }}";s:9:"page_head";s:0:"";s:5:"title";s:11:"Error Pages";s:10:"short_name";s:11:"error_pages";s:12:"theme_layout";s:8:"404-page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(57, 2, 3, NULL, 1, 'Cosmo Mathieu', '2015-09-07 07:22:59', 'a:12:{s:6:"layout";s:1202:"<article class="post-entry wrapped">\r\n    <header class="bposttitle">\r\n        <h2 class="entry-title">\r\n            <a href="">News item one</a>\r\n        </h2>\r\n    </header>\r\n    <div class="bpostentry-meta">\r\n        <p><small> On\r\n        February 21st, 2014 by Cosmo Mathieu in\r\n        <a href="#" rel="tag">Sports</a>, \r\n        <a href="#" rel="tag">Web Design</a>\r\n        <a class="comments-link" href="#">1 comment</a>\r\n        </small></p>\r\n    </div><!--/.post-meta -->\r\n\r\n    <div class="post-body">\r\n        <img src="https://placehold.it/300x250" alt="cedar-grove-baptist-church-of-simpsonville" class="post-entrty-thumb" width="320">\r\n        <p>New year, new beginnings. We are happy to introduce our new website. There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don''t look even slightly believable. If you are going...									</p>\r\n        <div style="float:right;padding-right:10px;margin-top:10px;">\r\n            <a class="button" href="">Read More</a>\r\n        </div>\r\n    </div><!--/.post-body -->\r\n</article>\r\n\r\n{{# content:snippets snippet="blog_articles" #}}";s:9:"page_head";s:0:"";s:5:"title";s:17:"Blog Landing Page";s:10:"short_name";s:17:"blog_landing-page";s:12:"theme_layout";s:17:"blog_landing_page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"1";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:1:"1";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(48, 1, 7, 3, 1, 'Cosmo Mathieu', '2015-09-07 07:07:34', 'a:9:{s:5:"title";s:4:"News";s:4:"slug";s:0:"";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"09/07/2015 07:07:01 am";s:9:"author_id";s:1:"1";s:19:"content_type_change";s:0:"";}'),
(72, 2, 3, NULL, 1, 'Cosmo Mathieu', '2015-09-07 08:04:29', 'a:12:{s:6:"layout";s:1202:"<article class="post-entry wrapped">\r\n    <header class="bposttitle">\r\n        <h2 class="entry-title">\r\n            <a href="">News item one</a>\r\n        </h2>\r\n    </header>\r\n    <div class="bpostentry-meta">\r\n        <p><small> On\r\n        February 21st, 2014 by Cosmo Mathieu in\r\n        <a href="#" rel="tag">Sports</a>, \r\n        <a href="#" rel="tag">Web Design</a>\r\n        <a class="comments-link" href="#">1 comment</a>\r\n        </small></p>\r\n    </div><!--/.post-meta -->\r\n\r\n    <div class="post-body">\r\n        <img src="https://placehold.it/300x250" alt="cedar-grove-baptist-church-of-simpsonville" class="post-entrty-thumb" width="320">\r\n        <p>New year, new beginnings. We are happy to introduce our new website. There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don''t look even slightly believable. If you are going...									</p>\r\n        <div style="float:right;padding-right:10px;margin-top:10px;">\r\n            <a class="button" href="">Read More</a>\r\n        </div>\r\n    </div><!--/.post-body -->\r\n</article>\r\n\r\n{{# content:snippets snippet="blog_articles" #}}";s:9:"page_head";s:0:"";s:5:"title";s:17:"Blog Landing Page";s:10:"short_name";s:17:"blog_landing-page";s:12:"theme_layout";s:17:"blog_landing_page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"1";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(21, 1, 5, 3, 1, 'Cosmo Mathieu', '2015-09-05 05:23:40', 'a:11:{s:5:"title";s:21:"Welcome To CMS Canvas";s:10:"field_id_3";s:924:"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras dapibus mi quis est finibus sagittis. Duis commodo, leo at semper vulputate, arcu quam aliquam enim, sit amet ultricies nisl velit vel enim. Duis scelerisque pulvinar euismod. Mauris faucibus dolor ut odio sagittis iaculis. Curabitur sollicitudin bibendum quam, eget volutpat elit finibus ac. Curabitur rutrum sem purus, id aliquet diam gravida non. In sem turpis, venenatis vitae fringilla et, ultricies at libero. Mauris eget metus leo.</p>\r\n\r\n<p>Maecenas facilisis vulputate arcu non gravida. Praesent sed dolor ut mi consectetur iaculis nec a sem. Cras cursus sed est id rutrum. Vivamus laoreet libero nibh, ac aliquet nibh commodo sit amet. Sed et suscipit libero. Vivamus a erat nibh. Vestibulum ullamcorper ipsum in elementum bibendum. Nullam sagittis felis interdum vehicula cursus. Sed dui lacus, varius commodo neque id, finibus porttitor nulla.</p>";s:10:"categories";a:2:{i:0;s:1:"1";i:1;s:1:"3";}s:4:"slug";s:26:"blog/welcome-to-cms-canvas";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"09/05/2015 05:03:10 am";s:9:"author_id";s:1:"1";s:19:"content_type_change";s:0:"";}'),
(105, 2, 3, NULL, 1, 'Cosmo Mathieu', '2015-09-08 04:50:20', 'a:12:{s:6:"layout";s:52:"\r\n\r\n{{# content:snippets snippet="blog_articles" #}}";s:9:"page_head";s:0:"";s:5:"title";s:17:"Blog Landing Page";s:10:"short_name";s:17:"blog_landing-page";s:12:"theme_layout";s:17:"blog_landing_page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"1";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(55, 2, 3, NULL, 1, 'Cosmo Mathieu', '2015-09-07 07:17:28', 'a:12:{s:6:"layout";s:921:"{{ title }}\r\n\r\n<article class="post-entry wrapped">\r\n    <header class="bposttitle">\r\n        <h2 class="entry-title">{{ title }}</h2>\r\n    </header>\r\n    <div class="bpostentry-meta">\r\n        <p><small> On\r\n        <time> by </time> in\r\n        <a href="#" rel="tag">Sports</a>, \r\n        <a href="#" rel="tag">Web Design</a>\r\n        <a class="comments-link" href="#">1 comment</a>\r\n        </small></p>\r\n    </div><!--/.post-meta -->\r\n\r\n    <div class="post-body">\r\n        <img src="" class="border post-image" />\r\n    </div><!--/.post-body -->\r\n\r\n    <footer class="">\r\n        <p>\r\n            <a href="" data-disqus-identifier="256">Read comments</a> | \r\n            <a href="" data-disqus-identifier="256">Leave a comment</a>\r\n        </p>\r\n	</footer>\r\n</article><!--/.post-entry -->\r\n							\r\n<p><a href="{{ site_url }}/news/">? View Other Articles</a></p>	\r\n\r\n{{# content:snippets snippet="blog_articles" #}}";s:9:"page_head";s:0:"";s:5:"title";s:17:"Blog Landing Page";s:10:"short_name";s:17:"blog_landing-page";s:12:"theme_layout";s:17:"blog_landing_page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"1";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:1:"1";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(22, 1, 5, 3, 1, 'Cosmo Mathieu', '2015-09-05 05:24:14', 'a:11:{s:5:"title";s:21:"Welcome To CMS Canvas";s:10:"field_id_3";s:924:"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras dapibus mi quis est finibus sagittis. Duis commodo, leo at semper vulputate, arcu quam aliquam enim, sit amet ultricies nisl velit vel enim. Duis scelerisque pulvinar euismod. Mauris faucibus dolor ut odio sagittis iaculis. Curabitur sollicitudin bibendum quam, eget volutpat elit finibus ac. Curabitur rutrum sem purus, id aliquet diam gravida non. In sem turpis, venenatis vitae fringilla et, ultricies at libero. Mauris eget metus leo.</p>\r\n\r\n<p>Maecenas facilisis vulputate arcu non gravida. Praesent sed dolor ut mi consectetur iaculis nec a sem. Cras cursus sed est id rutrum. Vivamus laoreet libero nibh, ac aliquet nibh commodo sit amet. Sed et suscipit libero. Vivamus a erat nibh. Vestibulum ullamcorper ipsum in elementum bibendum. Nullam sagittis felis interdum vehicula cursus. Sed dui lacus, varius commodo neque id, finibus porttitor nulla.</p>";s:10:"categories";a:2:{i:0;s:1:"1";i:1;s:1:"3";}s:4:"slug";s:0:"";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"09/05/2015 05:03:10 am";s:9:"author_id";s:1:"1";s:19:"content_type_change";s:0:"";}'),
(23, 1, 5, 3, 1, 'Cosmo Mathieu', '2015-09-05 05:24:30', 'a:12:{s:5:"title";s:21:"Welcome To CMS Canvas";s:10:"field_id_3";s:924:"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras dapibus mi quis est finibus sagittis. Duis commodo, leo at semper vulputate, arcu quam aliquam enim, sit amet ultricies nisl velit vel enim. Duis scelerisque pulvinar euismod. Mauris faucibus dolor ut odio sagittis iaculis. Curabitur sollicitudin bibendum quam, eget volutpat elit finibus ac. Curabitur rutrum sem purus, id aliquet diam gravida non. In sem turpis, venenatis vitae fringilla et, ultricies at libero. Mauris eget metus leo.</p>\r\n\r\n<p>Maecenas facilisis vulputate arcu non gravida. Praesent sed dolor ut mi consectetur iaculis nec a sem. Cras cursus sed est id rutrum. Vivamus laoreet libero nibh, ac aliquet nibh commodo sit amet. Sed et suscipit libero. Vivamus a erat nibh. Vestibulum ullamcorper ipsum in elementum bibendum. Nullam sagittis felis interdum vehicula cursus. Sed dui lacus, varius commodo neque id, finibus porttitor nulla.</p>";s:10:"categories";a:2:{i:0;s:1:"1";i:1;s:1:"3";}s:4:"slug";s:26:"blog/welcome-to-cms-canvas";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"09/05/2015 05:03:10 am";s:9:"author_id";s:1:"1";s:19:"content_type_change";s:0:"";s:9:"save_exit";s:1:"1";}'),
(25, 1, 5, 3, 1, 'Cosmo Mathieu', '2015-09-05 05:46:29', 'a:12:{s:5:"title";s:21:"Welcome To CMS Canvas";s:10:"field_id_3";s:924:"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras dapibus mi quis est finibus sagittis. Duis commodo, leo at semper vulputate, arcu quam aliquam enim, sit amet ultricies nisl velit vel enim. Duis scelerisque pulvinar euismod. Mauris faucibus dolor ut odio sagittis iaculis. Curabitur sollicitudin bibendum quam, eget volutpat elit finibus ac. Curabitur rutrum sem purus, id aliquet diam gravida non. In sem turpis, venenatis vitae fringilla et, ultricies at libero. Mauris eget metus leo.</p>\r\n\r\n<p>Maecenas facilisis vulputate arcu non gravida. Praesent sed dolor ut mi consectetur iaculis nec a sem. Cras cursus sed est id rutrum. Vivamus laoreet libero nibh, ac aliquet nibh commodo sit amet. Sed et suscipit libero. Vivamus a erat nibh. Vestibulum ullamcorper ipsum in elementum bibendum. Nullam sagittis felis interdum vehicula cursus. Sed dui lacus, varius commodo neque id, finibus porttitor nulla.</p>";s:10:"field_id_4";a:2:{s:3:"src";s:39:"/assets/cms/uploads/images/IMG_2300.PNG";s:3:"alt";s:0:"";}s:10:"categories";a:2:{i:0;s:1:"1";i:1;s:1:"3";}s:4:"slug";s:26:"blog/welcome-to-cms-canvas";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"09/05/2015 05:03:10 am";s:9:"author_id";s:1:"1";s:19:"content_type_change";s:0:"";}'),
(68, 1, 5, 3, 1, 'Cosmo Mathieu', '2015-09-07 07:50:41', 'a:10:{s:5:"title";s:21:"Welcome To CMS Canvas";s:10:"categories";a:2:{i:0;s:1:"1";i:1;s:1:"3";}s:4:"slug";s:26:"news/welcome-to-cms-canvas";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"09/05/2015 05:03:10 am";s:9:"author_id";s:1:"1";s:19:"content_type_change";s:0:"";}'),
(75, 2, 7, NULL, 1, 'Cosmo Mathieu', '2015-09-07 08:12:29', 'a:12:{s:6:"layout";s:1337:"<!-- Header\r\n	============================================== -->\r\n    <section class="alternate no-border-top " style="margin-top:-55px;padding-top: 60px;">\r\n		<div class="container">\r\n            <div class="sixteen columns">\r\n				<div class="jumbotron">\r\n                    <h2>{{ title }}</h2>\r\n                </div>			\r\n            </div>\r\n        </div><!-- container end -->\r\n	</section>\r\n    \r\n	<section class="no-border-top normal">\r\n		\r\n<article class="post-entry wrapped">\r\n    <header class="bposttitle">\r\n        <h2 class="entry-title">\r\n            <a href="">News item one</a>\r\n        </h2>\r\n    </header>\r\n    <div class="bpostentry-meta">\r\n        <p><small> On\r\n        February 21st, 2014 by Cosmo Mathieu in\r\n        <a href="#" rel="tag">Sports</a>, \r\n        <a href="#" rel="tag">Web Design</a>\r\n        <a class="comments-link" href="#">1 comment</a>\r\n        </small></p>\r\n    </div><!--/.post-meta -->\r\n\r\n    <div class="post-body">\r\n        <img src="https://placehold.it/300x250" alt="cedar-grove-baptist-church-of-simpsonville" class="post-entrty-thumb" width="320">\r\n        {{ content }}\r\n        <div style="float:right;padding-right:10px;margin-top:10px;">\r\n            <a class="button" href="">Read More</a>\r\n        </div>\r\n    </div><!--/.post-body -->\r\n</article>\r\n\r\n</section><!--/ .About Us -->";s:9:"page_head";s:0:"";s:5:"title";s:13:"Blog Articles";s:10:"short_name";s:13:"blog_articles";s:12:"theme_layout";s:7:"default";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:1:"1";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(76, 2, 7, NULL, 1, 'Cosmo Mathieu', '2015-09-07 08:13:54', 'a:12:{s:6:"layout";s:1726:"<!-- Header\r\n============================================== -->\r\n<section class="alternate no-border-top " style="margin-top:-55px;padding-top: 60px;">\r\n    <div class="container">\r\n        <div class="sixteen columns">\r\n            <div class="jumbotron">\r\n                <h2>{{ title }}</h2>\r\n            </div>			\r\n        </div>\r\n    </div><!-- container end -->\r\n</section>\r\n\r\n<section class="no-border-top normal">\r\n    <div class="container">\r\n        <div class="sixteen columns">\r\n        \r\n            <article class="post-entry wrapped">\r\n                <header class="bposttitle">\r\n                    <h2 class="entry-title">\r\n                        <a href="">News item one</a>\r\n                    </h2>\r\n                </header>\r\n                <div class="bpostentry-meta">\r\n                    <p><small> On\r\n                    February 21st, 2014 by Cosmo Mathieu in\r\n                    <a href="#" rel="tag">Sports</a>, \r\n                    <a href="#" rel="tag">Web Design</a>\r\n                    <a class="comments-link" href="#">1 comment</a>\r\n                    </small></p>\r\n                </div><!--/.post-meta -->\r\n\r\n                <div class="post-body">\r\n                    <img src="https://placehold.it/300x250" alt="cedar-grove-baptist-church-of-simpsonville" class="post-entrty-thumb" width="320">\r\n                    {{ content }}\r\n                    <div style="float:right;padding-right:10px;margin-top:10px;">\r\n                        <a class="button" href="">Read More</a>\r\n                    </div>\r\n                </div><!--/.post-body -->\r\n            </article>\r\n\r\n        </div><!-- container end -->\r\n    </div><!-- container end -->\r\n</section><!--/ .About Us -->";s:9:"page_head";s:0:"";s:5:"title";s:13:"Blog Articles";s:10:"short_name";s:13:"blog_articles";s:12:"theme_layout";s:7:"default";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:1:"1";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(30, 1, 1, 1, 1, 'Cosmo Mathieu', '2015-09-05 22:22:27', 'a:11:{s:5:"title";s:4:"Home";s:10:"field_id_1";s:983:"<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna <a href="#">aliquam</a> erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>\r\n\r\n<p>Sed ut perspiciatis unde <a href="#">omnis</a> iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>\r\n\r\n<h1>H1 Tag</h1>\r\n\r\n<h2>H2 Tag</h2>\r\n\r\n<h3>H3 Tag</h3>\r\n\r\n<h4>H4 Tag</h4>\r\n\r\n<p><strong>Strong</strong></p>\r\n\r\n<ul>\r\n	<li>List Item 1\r\n	<ul>\r\n		<li>Indented Item 1</li>\r\n		<li>Indented Item 2</li>\r\n	</ul>\r\n	</li>\r\n	<li>List Item 2</li>\r\n	<li>List Item 3</li>\r\n	<li>List Item 4</li>\r\n</ul>";s:10:"field_id_2";s:684:"<h2>Lorem Ipsum</h2>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>\r\n\r\n<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>";s:4:"slug";s:4:"home";s:10:"meta_title";s:7:"Welcome";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"03/06/2012 09:07:07 pm";s:9:"author_id";s:0:"";s:19:"content_type_change";s:0:"";}'),
(26, 3, 1, NULL, 1, 'Cosmo Mathieu', '2015-09-05 07:11:05', 'a:5:{s:5:"title";s:13:"News Snippets";s:10:"short_name";s:13:"news_snippets";s:7:"snippet";s:33:"<?php \r\necho ''News Snippets'';\r\n?>";s:6:"layout";s:0:"";s:9:"page_head";s:0:"";}'),
(27, 3, 1, NULL, 1, 'Cosmo Mathieu', '2015-09-05 07:11:09', 'a:6:{s:5:"title";s:13:"News Snippets";s:10:"short_name";s:13:"news_snippets";s:7:"snippet";s:33:"<?php \r\necho ''News Snippets'';\r\n?>";s:9:"save_exit";s:1:"1";s:6:"layout";s:0:"";s:9:"page_head";s:0:"";}'),
(102, 2, 10, NULL, 1, 'Cosmo Mathieu', '2015-09-08 00:11:08', 'a:12:{s:6:"layout";s:9:"{{ bio }}";s:9:"page_head";s:0:"";s:5:"title";s:5:"Staff";s:10:"short_name";s:5:"staff";s:12:"theme_layout";s:19:"leader_details_page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(100, 2, 10, NULL, 1, 'Cosmo Mathieu', '2015-09-07 23:51:26', 'a:12:{s:5:"title";s:5:"Staff";s:10:"short_name";s:5:"staff";s:12:"theme_layout";s:19:"leader_details_page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";s:6:"layout";s:0:"";s:9:"page_head";s:0:"";}'),
(101, 2, 10, NULL, 1, 'Cosmo Mathieu', '2015-09-08 00:11:00', 'a:12:{s:6:"layout";s:13:"{{ content }}";s:9:"page_head";s:0:"";s:5:"title";s:5:"Staff";s:10:"short_name";s:5:"staff";s:12:"theme_layout";s:19:"leader_details_page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(66, 2, 4, NULL, 1, 'Cosmo Mathieu', '2015-09-07 07:48:44', 'a:12:{s:6:"layout";s:24:"{{ full_width_content }}";s:9:"page_head";s:0:"";s:5:"title";s:19:"Simple Landing Page";s:10:"short_name";s:19:"simple_landing_page";s:12:"theme_layout";s:19:"simple_landing_page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:2:"10";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(33, 1, 1, 1, 1, 'Cosmo Mathieu', '2015-09-05 23:13:23', 'a:11:{s:5:"title";s:4:"Home";s:10:"field_id_1";s:983:"<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna <a href="#">aliquam</a> erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>\r\n\r\n<p>Sed ut perspiciatis unde <a href="#">omnis</a> iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>\r\n\r\n<h1>H1 Tag</h1>\r\n\r\n<h2>H2 Tag</h2>\r\n\r\n<h3>H3 Tag</h3>\r\n\r\n<h4>H4 Tag</h4>\r\n\r\n<p><strong>Strong</strong></p>\r\n\r\n<ul>\r\n	<li>List Item 1\r\n	<ul>\r\n		<li>Indented Item 1</li>\r\n		<li>Indented Item 2</li>\r\n	</ul>\r\n	</li>\r\n	<li>List Item 2</li>\r\n	<li>List Item 3</li>\r\n	<li>List Item 4</li>\r\n</ul>";s:10:"field_id_2";s:684:"<h2>Lorem Ipsum</h2>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>\r\n\r\n<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>";s:4:"slug";s:4:"home";s:10:"meta_title";s:7:"Welcome";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"03/06/2012 09:07:07 pm";s:9:"author_id";s:0:"";s:19:"content_type_change";s:1:"4";}'),
(112, 2, 4, NULL, 1, 'Cosmo Mathieu', '2015-09-09 06:59:04', 'a:12:{s:6:"layout";s:24:"{{ full_width_content }}";s:9:"page_head";s:0:"";s:5:"title";s:19:"Simple Landing Page";s:10:"short_name";s:19:"simple_landing_page";s:12:"theme_layout";s:19:"simple_landing_page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"1";s:13:"max_revisions";s:2:"10";s:15:"entries_allowed";s:2:"10";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(36, 1, 4, 1, 1, 'Cosmo Mathieu', '2015-09-07 03:19:00', 'a:11:{s:5:"title";s:5:"About";s:10:"field_id_1";s:3159:"<p>[page_excerpt size=&quot;large&quot;]</p>\r\n\r\n<h2>ABOUT US</h2>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p>\r\n\r\n<p>[/page_excerpt]</p>\r\n\r\n<p>[featured_heading]</p>\r\n\r\n<h2><a data-mce-href="#" href="http://local.pagestudio.app/pages/edit/2#">New Here?</a> Find out what to expect when you visit our church.</h2>\r\n\r\n<p>[/featured_heading]</p>\r\n\r\n<p>[cols_3 first=&quot;&quot;]</p>\r\n\r\n<h2>Who We Are</h2>\r\n\r\n<p><a data-mce-href="/projects/pagestudio_1.1.0/leadership/" href="http://local.pagestudio.app/projects/pagestudio_1.1.0/leadership/"><strong>Leadership</strong></a><br />\r\nLearn about our staff &ndash; our life stories and hopes for The Village.<br />\r\n<br />\r\n<a data-mce-href="/projects/pagestudio_1.1.0/our-story" href="http://local.pagestudio.app/projects/pagestudio_1.1.0/our-story"><strong>Our Story</strong></a><br />\r\nRead the story of how God has graciously worked in and through a broken people.<br />\r\n<br />\r\n<a data-mce-href="/projects/pagestudio_1.1.0/our-beliefs" href="http://local.pagestudio.app/projects/pagestudio_1.1.0/our-beliefs"><strong>What We Believe</strong></a><br />\r\nLearn about the mission of our church and our four family traits.</p>\r\n\r\n<p>[/cols_3]</p>\r\n\r\n<p>[cols_3]</p>\r\n\r\n<p><a data-mce-href="/projects/pagestudio_1.1.0/giving/" href="http://local.pagestudio.app/projects/pagestudio_1.1.0/giving/"><strong>Giving</strong></a><br />\r\nFind out why we give and how to give.<br />\r\n<br />\r\n<a data-mce-href="/projects/pagestudio_1.1.0/membership/" href="http://local.pagestudio.app/projects/pagestudio_1.1.0/membership/"><strong>Membership</strong></a><br />\r\nTake the steps to becoming a Covenant Member of The Village.<br />\r\n<br />\r\n<a data-mce-href="/projects/pagestudio_1.1.0/our-mission/" href="http://local.pagestudio.app/projects/pagestudio_1.1.0/our-mission/"><strong>Our Mission</strong></a><br />\r\nLearn about baptism and sign up for Baptism Class.<br />\r\n<br />\r\n<a data-mce-href="/projects/pagestudio_1.1.0/contact/" href="http://local.pagestudio.app/projects/pagestudio_1.1.0/contact/"><strong>Contact Us</strong></a><br />\r\nWrite, call, visit or contact us online and read frequently asked questions.</p>\r\n\r\n<p>[/cols_3]</p>\r\n\r\n<p>[cols_3 last=&quot;yes&quot;]</p>\r\n\r\n<h2>Get Involved</h2>\r\n\r\n<p><strong>Watch Live</strong><br />\r\nTake the steps to becoming a Covenant Member of The Village.<br />\r\n<br />\r\n<strong>Resources</strong><br />\r\nLearn about baptism and sign up for Baptism Class.<br />\r\n<br />\r\n<a data-mce-href="/projects/pagestudio_1.1.0/calendar/" href="http://local.pagestudio.app/projects/pagestudio_1.1.0/calendar/"><strong>Upcoming Events</strong></a><br />\r\nWrite, call, visit or contact us online and read frequently asked questions<br />\r\n<a class="read" data-mce-href="/history-of-cedar-grove-baptist-simpsonville" href="http://local.pagestudio.app/history-of-cedar-grove-baptist-simpsonville">view more &rarr;</a></p>\r\n\r\n<p>[/cols_3]</p>\r\n\r\n<p>&nbsp;More changes</p>";s:10:"field_id_2";s:684:"<h2>Lorem Ipsum</h2>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>\r\n\r\n<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>";s:4:"slug";s:5:"about";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"03/11/2012 04:06:40 pm";s:9:"author_id";s:0:"";s:19:"content_type_change";s:0:"";}'),
(38, 1, 3, 2, 1, 'Cosmo Mathieu', '2015-09-07 03:27:34', 'a:10:{s:5:"title";s:7:"Contact";s:10:"field_id_8";s:1097:"<p>[page_excerpt size=&quot;large&quot;]</p>\r\n\r\n<h2>CONTACT US</h2>\r\n\r\n<p>Thank you for stopping by! We are happy to hear from you. Please contact us using one of the methods below and we will get back to you as soon as we can.</p>\r\n\r\n<p>[/page_excerpt]</p>\r\n\r\n<p>[map-it title=&quot;We are here&quot; address=&quot;206 Moore Street Street, Simpsonville, SC 29680&quot; link=&quot;https://maps.google.com/maps?oe=utf-8&amp;client=firefox-a&amp;channel=rcs&amp;q=206+Moore+Street,+Simpsonville,+SC+29680&amp;ie=UTF-8&amp;hq=&amp;hnear=0x8858271b124cb44d:0xd11767dcd807df11,206+Moore+St,+Simpsonville,+SC+29681&amp;gl=us&amp;daddr=206+Moore+St,+Simpsonville,+SC+29681&amp;ei=WTz9Ur8BhYLJAcLsgOgG&amp;ved=0CCsQwwUwAA&quot; height=&quot;240&quot; width=&quot;360&quot; border=&quot;framed&quot;]</p>\r\n\r\n<p><strong>Cedar Grove Baptist Church Simpsonville</strong></p>\r\n\r\n<p>206 Moore Street Street<br />\r\nSimpsonville, SC 29680</p>\r\n\r\n<p>Phone: 864.963.6935</p>\r\n\r\n<p>Fax: 864.963.2391</p>\r\n\r\n<p>Email: <a data-mce-href="#" href="http://local.pagestudio.app/pages/edit/9#">info@cedargrovesc.org</a></p>";s:4:"slug";s:7:"contact";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"03/07/2012 09:45:48 pm";s:9:"author_id";s:0:"";s:19:"content_type_change";s:0:"";}'),
(44, 2, 6, NULL, 1, 'Cosmo Mathieu', '2015-09-07 06:47:26', 'a:12:{s:6:"layout";s:13:"{{ content }}";s:9:"page_head";s:0:"";s:5:"title";s:20:"Complex Landing Page";s:10:"short_name";s:20:"complex_landing_page";s:12:"theme_layout";s:21:"complex_landing_pages";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(67, 2, 6, NULL, 1, 'Cosmo Mathieu', '2015-09-07 07:49:37', 'a:12:{s:6:"layout";s:13:"{{ content }}";s:9:"page_head";s:0:"";s:5:"title";s:20:"Complex Landing Page";s:10:"short_name";s:20:"complex_landing_page";s:12:"theme_layout";s:20:"complex_landing_page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(41, 2, 6, NULL, 1, 'Cosmo Mathieu', '2015-09-07 06:44:21', 'a:12:{s:6:"layout";s:13:"{{ content }}";s:9:"page_head";s:0:"";s:5:"title";s:20:"Complex Landing Page";s:10:"short_name";s:20:"complex_landing_page";s:12:"theme_layout";s:5:"_base";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(42, 2, 6, NULL, 1, 'Cosmo Mathieu', '2015-09-07 06:45:22', 'a:12:{s:6:"layout";s:13:"{{ content }}";s:9:"page_head";s:0:"";s:5:"title";s:20:"Complex Landing Page";s:10:"short_name";s:20:"complex_landing_page";s:12:"theme_layout";s:21:"complex_landing_pages";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(43, 2, 6, NULL, 1, 'Cosmo Mathieu', '2015-09-07 06:46:59', 'a:12:{s:6:"layout";s:258:"{{ content }}\r\n\r\n<h2>Fresh From The Blog</h2>\r\n                {{ content:entries content_type="blog_pages" }}\r\n                    <ul>\r\n                        <li><h5>{{ title }}</h5></li>\r\n                    </ul>\r\n                {{ /content:entries }}";s:9:"page_head";s:0:"";s:5:"title";s:20:"Complex Landing Page";s:10:"short_name";s:20:"complex_landing_page";s:12:"theme_layout";s:21:"complex_landing_pages";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(56, 2, 3, NULL, 1, 'Cosmo Mathieu', '2015-09-07 07:20:06', 'a:12:{s:6:"layout";s:1217:"{{ title }}\r\n\r\n<article class="post-entry wrapped">\r\n    <header class="bposttitle">\r\n        <h2 class="entry-title">\r\n            <a href="">News item one</a>\r\n        </h2>\r\n    </header>\r\n    <div class="bpostentry-meta">\r\n        <p><small> On\r\n        February 21st, 2014 by Cosmo Mathieu in\r\n        <a href="#" rel="tag">Sports</a>, \r\n        <a href="#" rel="tag">Web Design</a>\r\n        <a class="comments-link" href="#">1 comment</a>\r\n        </small></p>\r\n    </div><!--/.post-meta -->\r\n\r\n    <div class="post-body">\r\n        <img src="https://placehold.it/300x250" alt="cedar-grove-baptist-church-of-simpsonville" class="post-entrty-thumb" width="320">\r\n        <p>New year, new beginnings. We are happy to introduce our new website. There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don''t look even slightly believable. If you are going...									</p>\r\n        <div style="float:right;padding-right:10px;margin-top:10px;">\r\n            <a class="button" href="">Read More</a>\r\n        </div>\r\n    </div><!--/.post-body -->\r\n</article>\r\n\r\n{{# content:snippets snippet="blog_articles" #}}";s:9:"page_head";s:0:"";s:5:"title";s:17:"Blog Landing Page";s:10:"short_name";s:17:"blog_landing-page";s:12:"theme_layout";s:17:"blog_landing_page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"1";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:1:"1";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(49, 1, 7, 3, 1, 'Cosmo Mathieu', '2015-09-07 07:07:48', 'a:9:{s:5:"title";s:4:"News";s:4:"slug";s:4:"news";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"09/07/2015 07:07:01 am";s:9:"author_id";s:1:"1";s:19:"content_type_change";s:0:"";}'),
(50, 1, 7, 3, 1, 'Cosmo Mathieu', '2015-09-07 07:07:50', 'a:10:{s:5:"title";s:4:"News";s:4:"slug";s:4:"news";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"09/07/2015 07:07:01 am";s:9:"author_id";s:1:"1";s:19:"content_type_change";s:0:"";s:9:"save_exit";s:1:"1";}'),
(51, 3, 2, NULL, 1, 'Cosmo Mathieu', '2015-09-07 07:10:33', 'a:6:{s:5:"title";s:13:"Blog Articles";s:10:"short_name";s:13:"blog_articles";s:7:"snippet";s:0:"";s:9:"save_exit";s:1:"1";s:6:"layout";s:0:"";s:9:"page_head";s:0:"";}'),
(52, 3, 2, NULL, 1, 'Cosmo Mathieu', '2015-09-07 07:13:33', 'a:5:{s:5:"title";s:13:"Blog Articles";s:10:"short_name";s:13:"blog_articles";s:7:"snippet";s:857:"<article class="post-entry wrapped">\r\n    <header class="bposttitle">\r\n        <h2 class="entry-title">{{ title }}</h2>\r\n    </header>\r\n    <div class="bpostentry-meta">\r\n        <p><small> On\r\n        <time> by </time> in\r\n        <a href="#" rel="tag">Sports</a>, \r\n        <a href="#" rel="tag">Web Design</a>\r\n        <a class="comments-link" href="#">1 comment</a>\r\n        </small></p>\r\n    </div><!--/.post-meta -->\r\n\r\n    <div class="post-body">\r\n        <img src="" class="border post-image" />\r\n    </div><!--/.post-body -->\r\n\r\n    <footer class="">\r\n        <p>\r\n            <a href="" data-disqus-identifier="256">Read comments</a> | \r\n            <a href="" data-disqus-identifier="256">Leave a comment</a>\r\n        </p>\r\n	</footer>\r\n</article><!--/.post-entry -->\r\n							\r\n<p><a href="{{ site_url }}/news/">&larr; View Other Articles</a></p>	";s:6:"layout";s:0:"";s:9:"page_head";s:0:"";}'),
(63, 2, 4, NULL, 1, 'Cosmo Mathieu', '2015-09-07 07:44:09', 'a:12:{s:6:"layout";s:369:"<!-- Header\r\n============================================== -->\r\n<section class="alternate no-border-top breadcrumb" style="margin-top:-55px;padding-top: 60px;">\r\n    <div class="container">\r\n        <div class="sixteen columns">\r\n            {{ hero_text }}\r\n        </div>\r\n    </div><!-- container end -->\r\n</section><!--/ .end Header -->\r\n\r\n{{ full_width_content }}";s:9:"page_head";s:0:"";s:5:"title";s:19:"Simple Landing Page";s:10:"short_name";s:19:"simple_landing_page";s:12:"theme_layout";s:19:"simple_landing_page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:2:"10";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(64, 2, 4, NULL, 1, 'Cosmo Mathieu', '2015-09-07 07:44:55', 'a:12:{s:6:"layout";s:24:"{{ full_width_content }}";s:9:"page_head";s:0:"";s:5:"title";s:19:"Simple Landing Page";s:10:"short_name";s:19:"simple_landing_page";s:12:"theme_layout";s:19:"simple_landing_page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:2:"10";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(65, 2, 4, NULL, 1, 'Cosmo Mathieu', '2015-09-07 07:47:12', 'a:12:{s:6:"layout";s:0:"";s:9:"page_head";s:0:"";s:5:"title";s:19:"Simple Landing Page";s:10:"short_name";s:19:"simple_landing_page";s:12:"theme_layout";s:19:"simple_landing_page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:2:"10";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(77, 2, 7, NULL, 1, 'Cosmo Mathieu', '2015-09-07 08:14:29', 'a:12:{s:6:"layout";s:1550:"<!-- Header\r\n============================================== -->\r\n<section class="alternate no-border-top " style="margin-top:-55px;padding-top: 60px;">\r\n    <div class="container">\r\n        <div class="sixteen columns">\r\n            <div class="jumbotron">\r\n                <h2>{{ title }}</h2>\r\n            </div>			\r\n        </div>\r\n    </div><!-- container end -->\r\n</section>\r\n\r\n<section class="no-border-top normal">\r\n    <div class="container">\r\n        <div class="sixteen columns">\r\n        \r\n            <article class="post-entry wrapped">\r\n                <header class="bposttitle">\r\n                    <h2 class="entry-title">\r\n                        <a href="">News item one</a>\r\n                    </h2>\r\n                </header>\r\n                <div class="bpostentry-meta">\r\n                    <p><small> On\r\n                    February 21st, 2014 by Cosmo Mathieu in\r\n                    <a href="#" rel="tag">Sports</a>, \r\n                    <a href="#" rel="tag">Web Design</a>\r\n                    <a class="comments-link" href="#">1 comment</a>\r\n                    </small></p>\r\n                </div><!--/.post-meta -->\r\n\r\n                <div class="post-body">\r\n                    <img src="https://placehold.it/300x250" alt="cedar-grove-baptist-church-of-simpsonville" class="post-entrty-thumb" width="320">\r\n                    {{ content }}\r\n                </div><!--/.post-body -->\r\n            </article>\r\n\r\n        </div><!-- container end -->\r\n    </div><!-- container end -->\r\n</section><!--/ .About Us -->";s:9:"page_head";s:0:"";s:5:"title";s:13:"Blog Articles";s:10:"short_name";s:13:"blog_articles";s:12:"theme_layout";s:7:"default";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:1:"1";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(103, 2, 7, NULL, 1, 'Cosmo Mathieu', '2015-09-08 04:43:30', 'a:13:{s:6:"layout";s:1550:"<!-- Header\r\n============================================== -->\r\n<section class="alternate no-border-top " style="margin-top:-55px;padding-top: 60px;">\r\n    <div class="container">\r\n        <div class="sixteen columns">\r\n            <div class="jumbotron">\r\n                <h2>{{ title }}</h2>\r\n            </div>			\r\n        </div>\r\n    </div><!-- container end -->\r\n</section>\r\n\r\n<section class="no-border-top normal">\r\n    <div class="container">\r\n        <div class="sixteen columns">\r\n        \r\n            <article class="post-entry wrapped">\r\n                <header class="bposttitle">\r\n                    <h2 class="entry-title">\r\n                        <a href="">News item one</a>\r\n                    </h2>\r\n                </header>\r\n                <div class="bpostentry-meta">\r\n                    <p><small> On\r\n                    February 21st, 2014 by Cosmo Mathieu in\r\n                    <a href="#" rel="tag">Sports</a>, \r\n                    <a href="#" rel="tag">Web Design</a>\r\n                    <a class="comments-link" href="#">1 comment</a>\r\n                    </small></p>\r\n                </div><!--/.post-meta -->\r\n\r\n                <div class="post-body">\r\n                    <img src="https://placehold.it/300x250" alt="cedar-grove-baptist-church-of-simpsonville" class="post-entrty-thumb" width="320">\r\n                    {{ content }}\r\n                </div><!--/.post-body -->\r\n            </article>\r\n\r\n        </div><!-- container end -->\r\n    </div><!-- container end -->\r\n</section><!--/ .About Us -->";s:9:"page_head";s:0:"";s:5:"title";s:13:"Blog Articles";s:10:"short_name";s:13:"blog_articles";s:12:"theme_layout";s:12:"blog_article";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:1:"1";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";s:9:"save_exit";s:1:"1";}'),
(104, 2, 7, NULL, 1, 'Cosmo Mathieu', '2015-09-08 04:44:25', 'a:12:{s:6:"layout";s:13:"{{ content }}";s:9:"page_head";s:0:"";s:5:"title";s:13:"Blog Articles";s:10:"short_name";s:13:"blog_articles";s:12:"theme_layout";s:12:"blog_article";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:1:"1";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(106, 2, 11, NULL, 1, 'Cosmo Mathieu', '2015-09-08 19:08:47', 'a:12:{s:5:"title";s:10:"Leadership";s:10:"short_name";s:10:"leadership";s:12:"theme_layout";s:15:"leadership_page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";s:6:"layout";s:0:"";s:9:"page_head";s:0:"";}'),
(107, 2, 11, NULL, 1, 'Cosmo Mathieu', '2015-09-08 19:08:56', 'a:12:{s:6:"layout";s:13:"{{ content }}";s:9:"page_head";s:0:"";s:5:"title";s:10:"Leadership";s:10:"short_name";s:10:"leadership";s:12:"theme_layout";s:15:"leadership_page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}');
INSERT INTO `revisions` (`id`, `revision_resource_type_id`, `resource_id`, `content_type_id`, `author_id`, `author_name`, `revision_date`, `revision_data`) VALUES
(79, 1, 3, 2, 1, 'Cosmo Mathieu', '2015-09-07 08:19:56', 'a:11:{s:5:"title";s:7:"Contact";s:11:"field_id_13";s:183:"<h2>CONTACT US</h2>\r\n\r\n<p>Thank you for stopping by! We are happy to hear from you. Please contact us using one of the methods below and we will get back to you as soon as we can.</p>";s:11:"field_id_14";s:836:"<p>[map-it title=&quot;We are here&quot; address=&quot;206 Moore Street Street, Simpsonville, SC 29680&quot; link=&quot;https://maps.google.com/maps?oe=utf-8&amp;client=firefox-a&amp;channel=rcs&amp;q=206+Moore+Street,+Simpsonville,+SC+29680&amp;ie=UTF-8&amp;hq=&amp;hnear=0x8858271b124cb44d:0xd11767dcd807df11,206+Moore+St,+Simpsonville,+SC+29681&amp;gl=us&amp;daddr=206+Moore+St,+Simpsonville,+SC+29681&amp;ei=WTz9Ur8BhYLJAcLsgOgG&amp;ved=0CCsQwwUwAA&quot; height=&quot;240&quot; width=&quot;360&quot; border=&quot;framed&quot;]</p>\r\n\r\n<p><strong>Cedar Grove Baptist Church Simpsonville</strong></p>\r\n\r\n<p>206 Moore Street Street<br />\r\nSimpsonville, SC 29680</p>\r\n\r\n<p>Phone: 864.963.6935</p>\r\n\r\n<p>Fax: 864.963.2391</p>\r\n\r\n<p>Email: <a data-mce-href="#" href="http://local.pagestudio.app/pages/edit/9#">info@cedargrovesc.org</a></p>";s:4:"slug";s:7:"contact";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"03/07/2012 09:45:48 pm";s:9:"author_id";s:0:"";s:19:"content_type_change";s:0:"";}'),
(111, 2, 2, NULL, 1, 'Cosmo Mathieu', '2015-09-09 06:53:33', 'a:12:{s:6:"layout";s:18:"{{ right_column }}";s:9:"page_head";s:0:"";s:5:"title";s:12:"Contact Page";s:10:"short_name";s:12:"contact_page";s:12:"theme_layout";s:12:"contact_page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"1";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(115, 1, 12, 8, 1, 'Cosmo Mathieu', '2015-09-09 07:01:01', 'a:11:{s:5:"title";s:10:"Membership";s:11:"field_id_15";s:1029:"<h2>Membership Class</h2>\r\n\r\n<p>We want you to make an informed decision about joining our church. Our class covers what it means to be a Covenant Member and our beliefs and bylaws.</p>\r\n\r\n<h3>Baptism at Cedar Grove Baptist Simpsonville</h3>\r\n\r\n<p>For many, baptism is the first public step of obedience to Christ. If you have not been baptized following salvation, we ask you to take this step before becoming a Covenant Member. To help prepare you, we offer a <a data-mce-href="#" href="http://local.pagestudio.app/pages/edit/17#">Baptism Class</a>. The class covers the biblical significance of baptism, frequently asked questions and gives you an opportunity to share your testimony.</p>\r\n\r\n<h3>Required Reading</h3>\r\n\r\n<p>We require prospective members to read <a data-mce-href="#" href="http://local.pagestudio.app/pages/edit/17#"><em>Church Membership</em></a> by [Author&#39;s name] before signing the Membership Covenant. This book is handed out at Membership Class.</p>\r\n\r\n<h3>Signing the Covenant</h3>\r\n\r\n<p>&nbsp;</p>";s:4:"slug";s:10:"membership";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"09/07/2015 10:16:22 pm";s:14:"published_date";s:22:"01/01/1970 01:00:00 am";s:9:"author_id";s:1:"1";s:19:"content_type_change";s:0:"";}'),
(113, 2, 8, NULL, 1, 'Cosmo Mathieu', '2015-09-09 06:59:50', 'a:12:{s:6:"layout";s:13:"{{ content }}";s:9:"page_head";s:0:"";s:5:"title";s:11:"Normal Page";s:10:"short_name";s:11:"normal_page";s:12:"theme_layout";s:12:"normal_pages";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"1";s:13:"max_revisions";s:2:"10";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(114, 1, 12, 8, 1, 'Cosmo Mathieu', '2015-09-09 07:00:20', 'a:11:{s:5:"title";s:10:"Membership";s:11:"field_id_15";s:1052:"<h2>Membership Class</h2>\r\n\r\n<p>We want you to make an informed decision about joining our church. Our class covers what it means to be a Covenant Member and our beliefs and bylaws.</p>\r\n\r\n<h3>Baptism at Cedar Grove Baptist Simpsonville</h3>\r\n\r\n<p>For many, baptism is the first public step of obedience to Christ. If you have not been baptized following salvation, we ask you to take this step before becoming a Covenant Member. To help prepare you, we offer a <a data-mce-href="#" href="http://local.pagestudio.app/pages/edit/17#">Baptism Class</a>. The class covers the biblical significance of baptism, frequently asked questions and gives you an opportunity to share your testimony.</p>\r\n\r\n<h3>Required Reading</h3>\r\n\r\n<p>We require prospective members to read <a data-mce-href="#" href="http://local.pagestudio.app/pages/edit/17#"><em>Church Membership</em></a> by [Author&#39;s name] before signing the Membership Covenant. This book is handed out at Membership Class.</p>\r\n\r\n<h3>Signing the Covenant</h3>\r\n\r\n<p>Need to add some text here...</p>";s:4:"slug";s:10:"membership";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"09/07/2015 10:16:22 pm";s:14:"published_date";s:22:"01/01/1970 01:00:00 am";s:9:"author_id";s:1:"1";s:19:"content_type_change";s:0:"";}'),
(92, 2, 2, NULL, 1, 'Cosmo Mathieu', '2015-09-07 08:56:42', 'a:12:{s:6:"layout";s:732:"<section class="normal no-border-top">\r\n    <div class="container">		\r\n        \r\n        <!-- form -->\r\n        <div class="nine columns">					\r\n        \r\n            <a id="talk"></a>\r\n            <div class="form-result"></div>\r\n            \r\n            <p>Fields marked with an * (asterisk) are required.</p>\r\n			\r\n			{{ contact:form id="" class="" }}\r\n            \r\n        </div><!-- two-thirds .end -->\r\n\r\n        <!-- map -->\r\n        <div class="seven columns">\r\n            \r\n            <div class="row">\r\n                <address>\r\n        			{{ right_column }}\r\n                </address>\r\n            </div><!--/ .row -->\r\n\r\n        </div><!--/ one-third -->				\r\n        \r\n    </div><!-- container end -->\r\n</section>";s:9:"page_head";s:0:"";s:5:"title";s:12:"Contact Page";s:10:"short_name";s:12:"contact_page";s:12:"theme_layout";s:12:"contact_page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"1";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(93, 2, 2, NULL, 1, 'Cosmo Mathieu', '2015-09-07 09:00:34', 'a:12:{s:6:"layout";s:766:"<section class="normal no-border-top">\r\n    <div class="container">		\r\n        \r\n        <!-- form -->\r\n        <div class="nine columns">					\r\n        \r\n            <a id="talk"></a>\r\n            <div class="form-result"></div>\r\n            \r\n            <p>Fields marked with an * (asterisk) are required.</p>\r\n			\r\n			{{ contact:form id="contactForm" class="two-thirds column alpha" }}\r\n            \r\n        </div><!-- two-thirds .end -->\r\n\r\n        <!-- map -->\r\n        <div class="seven columns">\r\n            \r\n            <div class="row">\r\n                <address>\r\n        			{{ right_column }}\r\n                </address>\r\n            </div><!--/ .row -->\r\n\r\n        </div><!--/ one-third -->				\r\n        \r\n    </div><!-- container end -->\r\n</section>";s:9:"page_head";s:0:"";s:5:"title";s:12:"Contact Page";s:10:"short_name";s:12:"contact_page";s:12:"theme_layout";s:12:"contact_page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"1";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(109, 2, 2, NULL, 1, 'Cosmo Mathieu', '2015-09-09 06:52:42', 'a:12:{s:6:"layout";s:18:"{{ right_column }}";s:9:"page_head";s:0:"";s:5:"title";s:12:"Contact Page";s:10:"short_name";s:12:"contact_page";s:12:"theme_layout";s:12:"contact_page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"1";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(110, 2, 2, NULL, 1, 'Cosmo Mathieu', '2015-09-09 06:53:17', 'a:12:{s:6:"layout";s:0:"";s:9:"page_head";s:0:"";s:5:"title";s:12:"Contact Page";s:10:"short_name";s:12:"contact_page";s:12:"theme_layout";s:12:"contact_page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"1";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(94, 2, 8, NULL, 1, 'Cosmo Mathieu', '2015-09-07 22:07:37', 'a:12:{s:5:"title";s:11:"Normal Page";s:10:"short_name";s:11:"normal_page";s:12:"theme_layout";s:12:"normal_pages";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";s:6:"layout";s:0:"";s:9:"page_head";s:0:"";}'),
(95, 2, 8, NULL, 1, 'Cosmo Mathieu', '2015-09-07 22:08:23', 'a:12:{s:6:"layout";s:13:"{{ content }}";s:9:"page_head";s:0:"";s:5:"title";s:11:"Normal Page";s:10:"short_name";s:11:"normal_page";s:12:"theme_layout";s:12:"normal_pages";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(96, 2, 9, NULL, 1, 'Cosmo Mathieu', '2015-09-07 23:09:30', 'a:12:{s:5:"title";s:11:"Error Pages";s:10:"short_name";s:11:"error_pages";s:12:"theme_layout";s:8:"404-page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";s:6:"layout";s:0:"";s:9:"page_head";s:0:"";}'),
(98, 2, 9, NULL, 1, 'Cosmo Mathieu', '2015-09-07 23:16:38', 'a:12:{s:6:"layout";s:13:"{{ content }}";s:9:"page_head";s:0:"";s:5:"title";s:11:"Error Pages";s:10:"short_name";s:11:"error_pages";s:12:"theme_layout";s:8:"404-page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(99, 2, 9, NULL, 1, 'Cosmo Mathieu', '2015-09-07 23:17:21', 'a:12:{s:6:"layout";s:24:"{{ full_width_content }}";s:9:"page_head";s:0:"";s:5:"title";s:11:"Error Pages";s:10:"short_name";s:11:"error_pages";s:12:"theme_layout";s:8:"404-page";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"0";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";}'),
(108, 1, 3, 2, 1, 'Cosmo Mathieu', '2015-09-08 21:50:18', 'a:12:{s:5:"title";s:7:"Contact";s:11:"field_id_13";s:183:"<h2>CONTACT US</h2>\r\n\r\n<p>Thank you for stopping by! We are happy to hear from you. Please contact us using one of the methods below and we will get back to you as soon as we can.</p>";s:11:"field_id_14";s:836:"<p>[map-it title=&quot;We are here&quot; address=&quot;206 Moore Street Street, Simpsonville, SC 29680&quot; link=&quot;https://maps.google.com/maps?oe=utf-8&amp;client=firefox-a&amp;channel=rcs&amp;q=206+Moore+Street,+Simpsonville,+SC+29680&amp;ie=UTF-8&amp;hq=&amp;hnear=0x8858271b124cb44d:0xd11767dcd807df11,206+Moore+St,+Simpsonville,+SC+29681&amp;gl=us&amp;daddr=206+Moore+St,+Simpsonville,+SC+29681&amp;ei=WTz9Ur8BhYLJAcLsgOgG&amp;ved=0CCsQwwUwAA&quot; height=&quot;240&quot; width=&quot;360&quot; border=&quot;framed&quot;]</p>\r\n\r\n<p><strong>Cedar Grove Baptist Church Simpsonville</strong></p>\r\n\r\n<p>206 Moore Street Street<br />\r\nSimpsonville, SC 29680</p>\r\n\r\n<p>Phone: 864.963.6935</p>\r\n\r\n<p>Fax: 864.963.2391</p>\r\n\r\n<p>Email: <a data-mce-href="#" href="http://local.pagestudio.app/pages/edit/9#">info@cedargrovesc.org</a></p>";s:4:"slug";s:7:"contact";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"03/07/2012 09:45:48 pm";s:14:"published_date";s:22:"01/01/1970 01:00:00 am";s:9:"author_id";s:0:"";s:19:"content_type_change";s:0:"";}'),
(116, 1, 12, 8, 1, 'Cosmo Mathieu', '2015-09-09 07:01:19', 'a:11:{s:5:"title";s:10:"Membership";s:11:"field_id_15";s:1052:"<h2>Membership Class</h2>\r\n\r\n<p>We want you to make an informed decision about joining our church. Our class covers what it means to be a Covenant Member and our beliefs and bylaws.</p>\r\n\r\n<h3>Baptism at Cedar Grove Baptist Simpsonville</h3>\r\n\r\n<p>For many, baptism is the first public step of obedience to Christ. If you have not been baptized following salvation, we ask you to take this step before becoming a Covenant Member. To help prepare you, we offer a <a data-mce-href="#" href="http://local.pagestudio.app/pages/edit/17#">Baptism Class</a>. The class covers the biblical significance of baptism, frequently asked questions and gives you an opportunity to share your testimony.</p>\r\n\r\n<h3>Required Reading</h3>\r\n\r\n<p>We require prospective members to read <a data-mce-href="#" href="http://local.pagestudio.app/pages/edit/17#"><em>Church Membership</em></a> by [Author&#39;s name] before signing the Membership Covenant. This book is handed out at Membership Class.</p>\r\n\r\n<h3>Signing the Covenant</h3>\r\n\r\n<p>Need to add some text here...</p>";s:4:"slug";s:10:"membership";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"09/07/2015 10:16:22 pm";s:14:"published_date";s:22:"01/01/1970 01:00:00 am";s:9:"author_id";s:1:"1";s:19:"content_type_change";s:0:"";}'),
(117, 1, 8, 4, 1, 'Cosmo Mathieu', '2015-09-09 07:08:20', 'a:12:{s:5:"title";s:6:"Giving";s:11:"field_id_11";s:337:"<h2>Giving Financially</h2>\r\n\r\n<p>We have a tremendous opportunity to proclaim the gospel by giving generously. Giving invigorates our devotion to Christ and frees us from the tyranny of consumerism. It provides an outlet for compassion and allows us to proclaim His sufficiency and provision. As people of faith, we give faithfully.</p>";s:11:"field_id_10";s:1730:"<p>[cols_3 first=&quot;&quot;]</p>\r\n\r\n<p>[featured_heading]</p>\r\n\r\n<h2>Give Online</h2>\r\n\r\n<p><strong>PayPal</strong><br />\r\nSed sit amet pulvinar orci, at placerat justo. Praesent id quam est. Duis ullamcorper nulla massa, eget mollis nulla condimentum in. Ut id orci tellus.</p>\r\n\r\n<p>Pellentesque nec dignissim erat. Vivamus in tristique neque. Praesent in justo ligula.</p>\r\n\r\n<p>[button text=&quot;Give Now&quot; link=&quot;#&quot; target=&quot;_blank&quot;]</p>\r\n\r\n<p>[/featured_heading]</p>\r\n\r\n<p>[/cols_3]</p>\r\n\r\n<p>[cols_3]</p>\r\n\r\n<h2>More Ways To Give</h2>\r\n\r\n<p><strong>Direct Mail</strong><br />\r\nPlease do not send cash via US mail. For checks, please make them out to:<br />\r\n<br />\r\n<strong>Cedar Grove Baptist Church Simpsonville</strong><br />\r\nAttention: Finance Department<br />\r\n206 Moore Street Street, Simpsonville, SC 29680<br />\r\n<br />\r\n<strong>Have A Question?</strong><br />\r\nContact us online, via phone 864.999.5544, or email us at info@cedargrovesc.org.</p>\r\n\r\n<p>[/cols_3]</p>\r\n\r\n<p>[cols_3 last=&quot;yes&quot;]</p>\r\n\r\n<h2>Thank You</h2>\r\n\r\n<p>Your prayers, tithes, and offerings help fulfill the mission of making disciples and planting churches! Christ calls his followers to work and be on mission until He returns &ndash; and you are doing just that. Thank you!</p>\r\n\r\n<p>Christ Himself said that it is more blessed to give than to receive (<a data-mce-href="http://www.esvbible.org/Acts%2020%3A35/" href="http://www.esvbible.org/Acts%2020%3A35/" target="_blank">Acts 20:35</a>). So whatever your gift, may Jesus&rsquo; words be true in your life, and may you be blessed by giving toward the work of Jesus. You are loved and appreciated. In Jesus&rsquo; name, thank you!</p>\r\n\r\n<p>[/cols_3]</p>";s:4:"slug";s:6:"giving";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"09/07/2015 07:52:12 am";s:14:"published_date";s:22:"01/01/1970 01:00:00 am";s:9:"author_id";s:1:"1";s:19:"content_type_change";s:0:"";}'),
(118, 1, 26, 4, 1, 'Cosmo Mathieu', '2015-09-09 15:28:29', 'a:12:{s:5:"title";s:15:"Events Calendar";s:11:"field_id_11";s:0:"";s:11:"field_id_10";s:32:"<p>The calendar goes here...</p>";s:4:"slug";s:0:"";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"09/09/2015 03:27:50 pm";s:14:"published_date";s:22:"09/09/2015 03:27:50 pm";s:9:"author_id";s:1:"1";s:19:"content_type_change";s:0:"";}'),
(119, 1, 26, 4, 1, 'Cosmo Mathieu', '2015-09-09 15:28:38', 'a:12:{s:5:"title";s:15:"Events Calendar";s:11:"field_id_11";s:0:"";s:11:"field_id_10";s:32:"<p>The calendar goes here...</p>";s:4:"slug";s:8:"calendar";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"09/09/2015 03:27:50 pm";s:14:"published_date";s:22:"09/09/2015 03:27:50 pm";s:9:"author_id";s:1:"1";s:19:"content_type_change";s:0:"";}'),
(120, 1, 26, 4, 1, 'Cosmo Mathieu', '2015-09-09 15:30:30', 'a:12:{s:5:"title";s:15:"Events Calendar";s:11:"field_id_11";s:337:"<h2>Giving Financially</h2>\r\n\r\n<p>We have a tremendous opportunity to proclaim the gospel by giving generously. Giving invigorates our devotion to Christ and frees us from the tyranny of consumerism. It provides an outlet for compassion and allows us to proclaim His sufficiency and provision. As people of faith, we give faithfully.</p>";s:11:"field_id_10";s:32:"<p>The calendar goes here...</p>";s:4:"slug";s:8:"calendar";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"09/09/2015 03:27:50 pm";s:14:"published_date";s:22:"09/09/2015 03:27:50 pm";s:9:"author_id";s:1:"1";s:19:"content_type_change";s:0:"";}'),
(121, 1, 26, 4, 1, 'Cosmo Mathieu', '2015-09-09 15:30:41', 'a:12:{s:5:"title";s:15:"Events Calendar";s:11:"field_id_11";s:27:"<h2>Giving Financially</h2>";s:11:"field_id_10";s:32:"<p>The calendar goes here...</p>";s:4:"slug";s:8:"calendar";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"09/09/2015 03:27:50 pm";s:14:"published_date";s:22:"09/09/2015 03:27:50 pm";s:9:"author_id";s:1:"1";s:19:"content_type_change";s:0:"";}'),
(122, 1, 26, 4, 1, 'Cosmo Mathieu', '2015-09-09 15:30:48', 'a:12:{s:5:"title";s:15:"Events Calendar";s:11:"field_id_11";s:23:"<h2>Event Calendar</h2>";s:11:"field_id_10";s:32:"<p>The calendar goes here...</p>";s:4:"slug";s:8:"calendar";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"09/09/2015 03:27:50 pm";s:14:"published_date";s:22:"09/09/2015 03:27:50 pm";s:9:"author_id";s:1:"1";s:19:"content_type_change";s:0:"";}'),
(123, 1, 26, 4, 1, 'Cosmo Mathieu', '2015-09-09 21:46:25', 'a:12:{s:5:"title";s:15:"Events Calendar";s:11:"field_id_11";s:23:"<h2>Event Calendar</h2>";s:11:"field_id_10";s:0:"";s:4:"slug";s:8:"calendar";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:0:"";s:6:"status";s:9:"published";s:12:"created_date";s:22:"09/09/2015 03:27:50 pm";s:14:"published_date";s:22:"09/09/2015 03:27:50 pm";s:9:"author_id";s:1:"1";s:19:"content_type_change";s:0:"";}');

-- --------------------------------------------------------

--
-- Table structure for table `revision_resource_types`
--

CREATE TABLE IF NOT EXISTS `revision_resource_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `key_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `key_name` (`key_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `revision_resource_types`
--

INSERT INTO `revision_resource_types` (`id`, `name`, `key_name`) VALUES
(1, 'Entry', 'ENTRY'),
(2, 'Content Type', 'CONTENT_TYPE'),
(3, 'Snippet', 'SNIPPET');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) NOT NULL,
  `value` text NOT NULL,
  `module` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `slug`, `value`, `module`) VALUES
(1, 'site_name', 'Cedar Grove Baptist SC', NULL),
(2, 'ga_account_id', '', NULL),
(3, 'suspend', '0', NULL),
(4, 'enable_admin_toolbar', '1', NULL),
(10, 'custom_404', '14', 'content'),
(6, 'site_homepage', '1', 'content'),
(7, 'enable_registration', '0', 'users'),
(8, 'default_group', '2', 'users'),
(9, 'email_activation', '0', 'users'),
(11, 'ga_email', '', NULL),
(12, 'ga_password', '', NULL),
(13, 'ga_profile_id', '', NULL),
(14, 'theme', 'cedargrove', NULL),
(15, 'layout', '404-page', NULL),
(16, 'enable_profiler', '0', NULL),
(17, 'notification_email', 'cosmo@cosmointeractive.co', NULL),
(18, 'editor_stylesheet', 'assets/css/content.css', NULL),
(19, 'enable_inline_editing', '0', NULL),
(20, 'site_description', 'The Cedar Grove Baptist Church is a fellowship of baptized believers in Jesus Christ. Empowered by the Holy Spirit, we seek to carry out the will and work of God through education, evangelism, fellowship, ministry, stewardship and worship.', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `snippets`
--

CREATE TABLE IF NOT EXISTS `snippets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `short_name` varchar(50) NOT NULL,
  `snippet` text,
  PRIMARY KEY (`id`),
  KEY `short_name` (`short_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `snippets`
--

INSERT INTO `snippets` (`id`, `title`, `short_name`, `snippet`) VALUES
(1, 'News Snippets', 'news_snippets', '<?php \r\necho ''News Snippets'';\r\n?>'),
(2, 'Blog Articles', 'blog_articles', '<article class="post-entry wrapped">\r\n    <header class="bposttitle">\r\n        <h2 class="entry-title">{{ title }}</h2>\r\n    </header>\r\n    <div class="bpostentry-meta">\r\n        <p><small> On\r\n        <time> by </time> in\r\n        <a href="#" rel="tag">Sports</a>, \r\n        <a href="#" rel="tag">Web Design</a>\r\n        <a class="comments-link" href="#">1 comment</a>\r\n        </small></p>\r\n    </div><!--/.post-meta -->\r\n\r\n    <div class="post-body">\r\n        <img src="" class="border post-image" />\r\n    </div><!--/.post-body -->\r\n\r\n    <footer class="">\r\n        <p>\r\n            <a href="" data-disqus-identifier="256">Read comments</a> | \r\n            <a href="" data-disqus-identifier="256">Leave a comment</a>\r\n        </p>\r\n	</footer>\r\n</article><!--/.post-entry -->\r\n							\r\n<p><a href="{{ site_url }}/news/">&larr; View Other Articles</a></p>	');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(50) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `zip` varchar(15) DEFAULT NULL,
  `group_id` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `activation_code` varchar(32) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `password`, `first_name`, `last_name`, `email`, `phone`, `address`, `address2`, `city`, `state`, `zip`, `group_id`, `enabled`, `activated`, `activation_code`, `last_login`, `created_date`) VALUES
(1, 'a0e464d59e7d3b138291f805397b3a4e', 'Cosmo', 'Mathieu', 'cosmo@cosmointeractive.co', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, '2015-09-10 02:41:42', '2015-09-05 04:55:46');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
