CREATE TABLE `wp_rg_form_view` (  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,  `form_id` mediumint(8) unsigned NOT NULL,  `date_created` datetime NOT NULL,  `ip` char(15) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,  `count` mediumint(8) unsigned NOT NULL DEFAULT '1',  PRIMARY KEY (`id`),  KEY `date_created` (`date_created`),  KEY `form_id` (`form_id`)) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40000 ALTER TABLE `wp_rg_form_view` DISABLE KEYS */;
INSERT INTO `wp_rg_form_view` VALUES('1', '2', '2016-09-27 10:38:06', '171.50.199.33', '3');
INSERT INTO `wp_rg_form_view` VALUES('2', '2', '2016-10-01 10:35:58', '77.75.78.170', '1');
INSERT INTO `wp_rg_form_view` VALUES('3', '2', '2016-10-02 17:20:36', '77.75.78.172', '2');
INSERT INTO `wp_rg_form_view` VALUES('4', '2', '2016-10-04 23:49:25', '100.43.81.143', '1');
INSERT INTO `wp_rg_form_view` VALUES('5', '2', '2016-10-08 12:09:30', '5.255.250.78', '2');
INSERT INTO `wp_rg_form_view` VALUES('6', '2', '2016-10-10 12:20:07', '122.179.173.84', '4');
INSERT INTO `wp_rg_form_view` VALUES('7', '2', '2016-10-11 15:15:09', '64.233.173.22', '8');
/*!40000 ALTER TABLE `wp_rg_form_view` ENABLE KEYS */;