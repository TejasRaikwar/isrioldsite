CREATE TABLE `wp_spellcheck_words` (  `id` mediumint(9) NOT NULL AUTO_INCREMENT,  `word` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,  `page_name` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,  `page_type` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,  `ignore_word` tinyint(1) DEFAULT '0',  `page_id` mediumint(9) DEFAULT NULL,  UNIQUE KEY `id` (`id`)) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40000 ALTER TABLE `wp_spellcheck_words` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_spellcheck_words` ENABLE KEYS */;
