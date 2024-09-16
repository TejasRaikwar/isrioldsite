CREATE TABLE `wp_lgp_posts` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `post_id` int(11) NOT NULL DEFAULT '0',  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',  `content` text COLLATE utf8mb4_unicode_520_ci NOT NULL,  PRIMARY KEY (`id`),  UNIQUE KEY `post_id` (`post_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40000 ALTER TABLE `wp_lgp_posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_lgp_posts` ENABLE KEYS */;
