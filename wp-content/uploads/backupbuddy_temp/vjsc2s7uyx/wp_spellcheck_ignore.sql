CREATE TABLE `wp_spellcheck_ignore` (  `id` mediumint(9) NOT NULL AUTO_INCREMENT,  `keyword` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,  `type` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,  UNIQUE KEY `id` (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40000 ALTER TABLE `wp_spellcheck_ignore` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_spellcheck_ignore` ENABLE KEYS */;
