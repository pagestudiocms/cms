--
-- Database: `pagestudiocms_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

DROP TABLE IF EXISTS `calendar`;
CREATE TABLE IF NOT EXISTS `calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_bin NOT NULL,
  `location` varchar(250) COLLATE utf8_bin NOT NULL,
  `featured_image` varchar(255) COLLATE utf8_bin NOT NULL,
  `event_author` int(11) NOT NULL,
  `allDay` varchar(255) COLLATE utf8_bin NOT NULL,
  `recurrence` varchar(35) COLLATE utf8_bin DEFAULT NULL,
  `series_id` int(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `series_id` (`series_id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories_entries`
--

DROP TABLE IF EXISTS `categories_entries`;
CREATE TABLE IF NOT EXISTS `categories_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `entry_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`,`entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `category_groups`
--

DROP TABLE IF EXISTS `category_groups`;
CREATE TABLE IF NOT EXISTS `category_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `content_fields`
--

DROP TABLE IF EXISTS `content_fields`;
CREATE TABLE IF NOT EXISTS `content_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_type_id` int(11) NOT NULL,
  `content_field_type_id` int(11) NOT NULL,
  `label` varchar(50) NOT NULL,
  `short_tag` varchar(50) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `is_searchable` varchar(4) DEFAULT NULL,
  `options` text,
  `settings` text,
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `content_field_type_id` (`content_field_type_id`),
  KEY `content_type_id` (`content_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `content_fields`
--

INSERT INTO `content_fields` (`id`, `content_type_id`, `content_field_type_id`, `label`, `short_tag`, `required`, `is_searchable`, `options`, `settings`, `sort`) VALUES
(1, 1, 8, 'Hero Image', 'hero_image', 1, 'n', NULL, 'a:7:{s:6:"output";s:5:"image";s:2:"id";s:0:"";s:5:"class";s:0:"";s:9:"max_width";s:0:"";s:10:"max_height";s:0:"";s:4:"crop";s:1:"0";s:14:"inline_editing";s:1:"0";}', 1),
(2, 1, 3, 'Heading', 'heading', 1, 'n', NULL, 'a:1:{s:14:"inline_editing";s:1:"1";}', 2),
(3, 1, 3, 'Sub Heading', 'sub_heading', 1, 'n', NULL, 'a:1:{s:14:"inline_editing";s:1:"1";}', 3),
(4, 1, 3, 'Body Heading', 'body_heading', 0, 'n', NULL, 'a:1:{s:14:"inline_editing";s:1:"1";}', 4),
(5, 1, 1, 'Body Content', 'body_content', 0, 'n', NULL, 'a:2:{s:6:"height";s:0:"";s:14:"inline_editing";s:1:"1";}', 5);

-- --------------------------------------------------------

--
-- Table structure for table `content_field_types`
--

DROP TABLE IF EXISTS `content_field_types`;
CREATE TABLE IF NOT EXISTS `content_field_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `model_name` varchar(50) NOT NULL,
  `datatype` varchar(50) NOT NULL DEFAULT 'text',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

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
(15, 'Integer', 'text', 'int'),
(16, 'Grid', 'grid', 'text');

-- --------------------------------------------------------

--
-- Table structure for table `content_types`
--

DROP TABLE IF EXISTS `content_types`;
CREATE TABLE IF NOT EXISTS `content_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `short_name` varchar(50) NOT NULL,
  `layout` text,
  `page_head` text,
  `theme_layout` varchar(50) DEFAULT NULL,
  `dynamic_route` varchar(255) DEFAULT NULL,
	`static_route` varchar(255) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `content_types`
--

INSERT INTO `content_types` (`id`, `title`, `short_name`, `layout`, `page_head`, `theme_layout`, `dynamic_route`, `required`, `access`, `restrict_to`, `restrict_admin_access`, `enable_versioning`, `max_revisions`, `entries_allowed`, `category_group_id`) VALUES
(1, 'Page', 'page', NULL, NULL, 'pages', NULL, 0, 0, NULL, 0, 1, 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `content_types_admin_groups`
--

DROP TABLE IF EXISTS `content_types_admin_groups`;
CREATE TABLE IF NOT EXISTS `content_types_admin_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_type_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `content_type_id` (`content_type_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `entries`
--

DROP TABLE IF EXISTS `entries`;
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
	`entry_layout` varchar(65) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `published_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `content_type_id` (`content_type_id`),
  KEY `slug` (`slug`),
  KEY `url_title` (`url_title`),
  KEY `author_id` (`author_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `entries`
--

INSERT INTO `entries` (`id`, `slug`, `title`, `url_title`, `required`, `content_type_id`, `status`, `meta_title`, `meta_description`, `meta_keywords`, `entry_layout`, `created_date`, `published_date`, `modified_date`, `author_id`) VALUES
(1, 'home', 'Welcome to Perfect Studio', NULL, 0, 1, 'published', NULL, 'A wonderfully crafted responsive theme for PageStudioCMS', NULL, NULL, '2016-03-15 14:15:43', '2016-03-15 14:15:43', '2016-03-15 14:50:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `entries_data`
--

DROP TABLE IF EXISTS `entries_data`;
CREATE TABLE IF NOT EXISTS `entries_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_id` int(11) NOT NULL,
  `field_id_1` text,
  `field_id_2` text,
  `field_id_3` text,
  `field_id_4` text,
  `field_id_5` text,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `entries_data`
--

INSERT INTO `entries_data` (`id`, `entry_id`, `field_id_1`, `field_id_2`, `field_id_3`, `field_id_4`, `field_id_5`) VALUES
(1, 1, 'a:2:{s:3:"src";s:38:"/assets/cms/uploads/images/hero-bg.jpg";s:3:"alt";s:0:"";}', 'PERFECT STUDIO', 'A wonderfully crafted responsive theme for PageStudioCMS', 'About The Theme', '<p>This theme is based of the Bocour bootstrap template by... Lorem ipsum dolor sit amet, vis tale malis tacimates et, graece doctus omnesque ne est, deserunt pertinacia ne nam. Pro eu simul affert referrentur, natum mutat erroribus te his</p>\r\n\r\n<p>Ne mundi fabulas corrumpit vim, nulla vivendum conceptam eu nam. Ius ex principes complectitur, ex quo duis suscipit. Ius fastidii reprimique no. Sadipscing appellantur pri ad. Oratio moderatius definitiones cum ex, mea ne brute vivendum percipitur.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

DROP TABLE IF EXISTS `galleries`;
CREATE TABLE IF NOT EXISTS `galleries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `title`) VALUES
(1, 'Featured');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

DROP TABLE IF EXISTS `gallery_images`;
CREATE TABLE IF NOT EXISTS `gallery_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) NOT NULL,
  `gallery_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `alt` varchar(250) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `credits` varchar(250) DEFAULT NULL,
  `link` varchar(250) DEFAULT NULL,
  `link_text` varchar(250) DEFAULT NULL,
  `hide` tinyint(1) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `gallery_id` (`gallery_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `filename`, `gallery_id`, `title`, `alt`, `description`, `credits`, `link`, `link_text`, `hide`, `sort`) VALUES
(1, '/assets/cms/uploads/images/galleries/1.jpg', 1, '1', NULL, NULL, NULL, NULL, NULL, 0, 1),
(2, '/assets/cms/uploads/images/galleries/2.jpg', 1, '2', NULL, NULL, NULL, NULL, NULL, 0, 2),
(3, '/assets/cms/uploads/images/galleries/3.jpg', 1, '3', NULL, NULL, NULL, NULL, NULL, 0, 3),
(4, '/assets/cms/uploads/images/galleries/4.jpg', 1, '4', NULL, NULL, NULL, NULL, NULL, 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `grid_cols`
--

DROP TABLE IF EXISTS `grid_cols`;
CREATE TABLE IF NOT EXISTS `grid_cols` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_field_id` int(11) NOT NULL,
  `content_type_id` int(11) NOT NULL,
  `content_field_type_id` int(11) NOT NULL,
  `label` varchar(50) NOT NULL,
  `short_tag` varchar(50) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `is_searchable` varchar(4) DEFAULT NULL,
  `options` text,
  `settings` text,
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `content_field_type_id` (`content_field_type_id`),
  KEY `content_type_id` (`content_type_id`),
  KEY `grid_id` (`content_field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `grid_col_data`
--

DROP TABLE IF EXISTS `grid_col_data`;
CREATE TABLE IF NOT EXISTS `grid_col_data` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `entry_id` int(11) NOT NULL,
  `grid_col_id` int(6) UNSIGNED DEFAULT NULL,
  `is_draft` tinyint(1) UNSIGNED DEFAULT '0',
  `row_order` int(4) UNSIGNED DEFAULT NULL,
  `row_data` text,
  PRIMARY KEY (`id`),
  KEY `field_id` (`grid_col_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` varchar(15) NOT NULL,
  `permissions` text,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `modifiable_permissions` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

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

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_slug` varchar(50) NOT NULL,
  `module_name` varchar(50) NOT NULL,
  `module_version` varchar(12) NOT NULL,
  `module_description` text NOT NULL,
  `module_options` text NOT NULL,
  `has_backend` int(1) NOT NULL,
  `has_plugin` int(1) NOT NULL,
  `has_widget` int(1) NOT NULL,
  `is_core` int(1) NOT NULL,
  `is_enabled` int(1) NOT NULL,
  `is_required` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `module_slug` (`module_slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `module_slug`, `module_name`, `module_version`, `module_description`, `module_options`, `has_backend`, `has_plugin`, `has_widget`, `is_core`, `is_enabled`, `is_required`) VALUES
(1, 'addons', 'Addons', '1.0', 'The module description.', '', 1, 0, 0, 1, 1, 1),
(2, 'content', 'Content', '1.0', 'This is by far the largest and most feature rich module of them all. The content module is made up of entries, content types, content fields, categories, and code snippets.', '', 1, 0, 0, 1, 1, 1),
(3, 'dashboard', 'Dashboard', '1.0', 'The dashboard module is used to show Google Analytics on the dashboard of of your admin panel.', '', 1, 0, 0, 0, 1, 1),
(4, 'filemanager', 'Filemanager', '1.0', '', '', 1, 0, 0, 1, 1, 1),
(5, 'settings', 'Settings', '1.0', '', '', 1, 0, 0, 0, 1, 1),
(6, 'users', 'Users', '1.0', 'Manage user accounts and user attributes such as group permissions, etc.', '', 1, 0, 0, 0, 1, 1),
(7, 'navigations', 'Navigations', '1.1', 'The Navigations add-on is navigation made simple. Build any kind of navigation you like, without limitation.', '', 1, 0, 0, 0, 1, 1),
(8, 'galleries', 'Galleries', '1.1', 'The Galleries add-on allows you to add simple image galleries to pages on your site.', '', 1, 0, 0, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `navigations`
--

DROP TABLE IF EXISTS `navigations`;
CREATE TABLE IF NOT EXISTS `navigations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `navigations`
--

INSERT INTO `navigations` (`id`, `title`, `required`) VALUES
(1, 'Primary Navigation', 0),
(2, 'Footer Links', 0);

-- --------------------------------------------------------

--
-- Table structure for table `navigation_items`
--

DROP TABLE IF EXISTS `navigation_items`;
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `navigation_items`
--

INSERT INTO `navigation_items` (`id`, `type`, `entry_id`, `title`, `url`, `tag_id`, `class`, `target`, `parent_id`, `navigation_id`, `subnav_visibility`, `hide`, `disable_current`, `disable_current_trail`, `sort`) VALUES
(1, 'page', 1, 'Home', NULL, NULL, NULL, NULL, 0, 2, 'show', 0, 0, 0, 1),
(2, 'url', NULL, 'PageStudioCMS', 'http://pagestudiocms.com/', NULL, NULL, '_blank', 0, 2, 'show', 0, 0, 0, 2),
(3, 'url', NULL, 'Cosmo Interactive', 'http://cosmointeractive.co', NULL, NULL, '_blank', 0, 2, 'show', 0, 0, 0, 3),
(4, 'page', 1, 'Home', NULL, NULL, NULL, NULL, 0, 1, 'show', 0, 0, 0, 0),
(5, 'url', NULL, 'Contact', '#contact', NULL, NULL, NULL, 0, 1, 'show', 0, 0, 0, 3),
(6, 'url', NULL, 'Gallery', '#gallery', NULL, NULL, NULL, 0, 1, 'show', 0, 0, 0, 2),
(7, 'url', NULL, 'Features', '#features', NULL, NULL, NULL, 0, 1, 'show', 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `revisions`
--

DROP TABLE IF EXISTS `revisions`;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `revisions`
--

INSERT INTO `revisions` (`id`, `revision_resource_type_id`, `resource_id`, `content_type_id`, `author_id`, `author_name`, `revision_date`, `revision_data`) VALUES
(1, 2, 1, NULL, 1, 'Cosmo Mathieu', '2016-03-15 14:10:13', 'a:12:{s:5:"title";s:4:"Page";s:10:"short_name";s:4:"page";s:12:"theme_layout";s:5:"pages";s:13:"dynamic_route";s:0:"";s:17:"enable_versioning";s:1:"1";s:13:"max_revisions";s:1:"5";s:15:"entries_allowed";s:0:"";s:17:"category_group_id";s:0:"";s:21:"restrict_admin_access";s:1:"0";s:6:"access";s:1:"0";s:6:"layout";s:0:"";s:9:"page_head";s:0:"";}'),
(2, 1, 1, 1, 1, 'Cosmo Mathieu', '2016-03-15 14:21:46', 'a:16:{s:5:"title";s:25:"Welcome to Perfect Studio";s:10:"field_id_1";a:2:{s:3:"src";s:38:"/assets/cms/uploads/images/hero-bg.jpg";s:3:"alt";s:0:"";}s:10:"field_id_2";s:14:"Perfect Studio";s:10:"field_id_3";s:56:"A wonderfully crafted responsive theme for PageStudioCMS";s:10:"field_id_4";s:15:"About The Theme";s:10:"field_id_5";s:503:"<p>This theme is based of the Bocour bootstrap template by... Lorem ipsum dolor sit amet, vis tale malis tacimates et, graece doctus omnesque ne est, deserunt pertinacia ne nam. Pro eu simul affert referrentur, natum mutat erroribus te his</p>\r\n\r\n<p>Ne mundi fabulas corrumpit vim, nulla vivendum conceptam eu nam. Ius ex principes complectitur, ex quo duis suscipit. Ius fastidii reprimique no. Sadipscing appellantur pri ad. Oratio moderatius definitiones cum ex, mea ne brute vivendum percipitur.</p>";s:4:"slug";s:4:"home";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:56:"A wonderfully crafted responsive theme for PageStudioCMS";s:6:"status";s:9:"published";s:12:"created_date";s:22:"03/15/2016 02:15:43 pm";s:14:"published_date";s:22:"03/15/2016 02:15:43 pm";s:9:"author_id";s:1:"1";s:19:"content_type_change";s:0:"";s:9:"save_exit";s:1:"1";}'),
(3, 1, 1, 1, 1, 'Cosmo Mathieu', '2016-03-15 14:50:39', 'a:15:{s:5:"title";s:25:"Welcome to Perfect Studio";s:10:"field_id_1";a:2:{s:3:"src";s:38:"/assets/cms/uploads/images/hero-bg.jpg";s:3:"alt";s:0:"";}s:10:"field_id_2";s:14:"PERFECT STUDIO";s:10:"field_id_3";s:56:"A wonderfully crafted responsive theme for PageStudioCMS";s:10:"field_id_4";s:15:"About The Theme";s:10:"field_id_5";s:503:"<p>This theme is based of the Bocour bootstrap template by... Lorem ipsum dolor sit amet, vis tale malis tacimates et, graece doctus omnesque ne est, deserunt pertinacia ne nam. Pro eu simul affert referrentur, natum mutat erroribus te his</p>\r\n\r\n<p>Ne mundi fabulas corrumpit vim, nulla vivendum conceptam eu nam. Ius ex principes complectitur, ex quo duis suscipit. Ius fastidii reprimique no. Sadipscing appellantur pri ad. Oratio moderatius definitiones cum ex, mea ne brute vivendum percipitur.</p>";s:4:"slug";s:4:"home";s:10:"meta_title";s:0:"";s:13:"meta_keywords";s:0:"";s:16:"meta_description";s:56:"A wonderfully crafted responsive theme for PageStudioCMS";s:6:"status";s:9:"published";s:12:"created_date";s:22:"03/15/2016 02:15:43 pm";s:14:"published_date";s:22:"03/15/2016 02:15:43 pm";s:9:"author_id";s:1:"1";s:19:"content_type_change";s:0:"";}');

-- --------------------------------------------------------

--
-- Table structure for table `revision_resource_types`
--

DROP TABLE IF EXISTS `revision_resource_types`;
CREATE TABLE IF NOT EXISTS `revision_resource_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `key_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `key_name` (`key_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) NOT NULL,
  `value` text NOT NULL,
  `module` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `slug`, `value`, `module`) VALUES
(1, 'site_name', 'Perfect Studio', NULL),
(2, 'site_description', 'Built to simplify web development, and make content management easy.', NULL),
(3, 'ga_account_id', 'Perfect Studio', NULL),
(4, 'suspend', '0', NULL),
(5, 'enable_admin_toolbar', '1', NULL),
(6, 'custom_404', '1', 'content'),
(7, 'site_homepage', '1', 'content'),
(8, 'enable_registration', '0', 'users'),
(9, 'default_group', '2', 'users'),
(10, 'email_activation', '0', 'users'),
(11, 'ga_email', '', NULL),
(12, 'ga_password', '', NULL),
(13, 'ga_profile_id', '', NULL),
(14, 'theme', 'default', NULL),
(15, 'layout', 'landing_page', NULL),
(16, 'enable_profiler', '0', NULL),
(17, 'editor_stylesheet', 'assets/css/content.css', NULL),
(18, 'enable_inline_editing', '0', NULL),
(19, 'blog_url', '', NULL),
(20, 'blog_title', '', NULL),
(21, 'blog_landing_page', 'news', NULL),
(22, 'blog_posts_per_page', '3', NULL),
(23, 'blog_comment_per_page', '2', NULL),
(24, 'blog_links_per_page', '5', NULL),
(25, 'blog_post_order', 'desc', NULL),
(26, 'blog_comment_order', 'asc', NULL),
(27, 'blog_public', '1', NULL),
(28, 'blog_comments_notify', '0', NULL),
(29, 'themes_path', 'themes', NULL),
(30, 'theme_name', 'default', NULL),
(31, 'modules_path', '', NULL),
(32, 'modules_status', '', NULL),
(33, 'portal_online', '1', NULL),
(34, 'portal_login_on', '1', NULL),
(35, 'portal_forgot_pass', '1', NULL),
(36, 'portal_theme', 'default', NULL),
(37, 'default_timezone', 'America/New_York', NULL),
(38, 'default_date_format', 'F jS, Y', NULL),
(39, 'default_time_format', 'g:i a', NULL),
(40, 'default_gmt_offset', '', NULL),
(41, 'notification_email', '', NULL),
(42, 'admin_email', '', NULL),
(43, 'reply_email', '', NULL),
(44, 'webmaster_email', '', NULL),
(45, 'mail_reply_email', '', NULL),
(46, 'mail_server', '', NULL),
(47, 'mail_login', '', NULL),
(48, 'mail_password', '', NULL),
(49, 'mail_incoming_srv', '', NULL),
(50, 'mail_outgoing_srv', '', NULL),
(51, 'mail_ssl_on', 'true', NULL),
(52, 'mail_authen_srvc', 'ssl', NULL),
(53, 'mail_incoming_port', '', NULL),
(54, 'mail_outgoing_port', '465', NULL),
(55, 'mail_send_as_html', 'true', NULL),
(56, 'mail_protocol', 'smtp', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `snippets`
--

DROP TABLE IF EXISTS `snippets`;
CREATE TABLE IF NOT EXISTS `snippets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `short_name` varchar(50) NOT NULL,
  `snippet` text,
  PRIMARY KEY (`id`),
  KEY `short_name` (`short_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
