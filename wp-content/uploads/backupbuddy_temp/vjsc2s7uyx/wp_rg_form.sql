CREATE TABLE `wp_rg_form` (  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,  `title` varchar(150) COLLATE utf8mb4_unicode_520_ci NOT NULL,  `date_created` datetime NOT NULL,  `is_active` tinyint(1) NOT NULL DEFAULT '1',  `is_trash` tinyint(1) NOT NULL DEFAULT '0',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40000 ALTER TABLE `wp_rg_form` DISABLE KEYS */;
INSERT INTO `wp_rg_form` VALUES('1', 'Careers', '2016-09-26 11:44:42', '1', '1');
INSERT INTO `wp_rg_form` VALUES('2', 'Career Form', '2016-09-26 11:46:26', '1', '0');
/*!40000 ALTER TABLE `wp_rg_form` ENABLE KEYS */;
