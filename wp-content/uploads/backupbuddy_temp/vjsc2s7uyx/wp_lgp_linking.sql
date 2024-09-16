CREATE TABLE `wp_lgp_linking` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `cat_id` int(11) NOT NULL DEFAULT '0',  `linking_text` text COLLATE utf8mb4_unicode_520_ci NOT NULL,  PRIMARY KEY (`id`),  UNIQUE KEY `cat_id` (`cat_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40000 ALTER TABLE `wp_lgp_linking` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_lgp_linking` ENABLE KEYS */;
