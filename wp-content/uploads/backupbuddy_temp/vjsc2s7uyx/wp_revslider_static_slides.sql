CREATE TABLE `wp_revslider_static_slides` (  `id` int(9) NOT NULL AUTO_INCREMENT,  `slider_id` int(9) NOT NULL,  `params` longtext NOT NULL,  `layers` longtext NOT NULL,  `settings` text NOT NULL,  UNIQUE KEY `id` (`id`)) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40000 ALTER TABLE `wp_revslider_static_slides` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_revslider_static_slides` ENABLE KEYS */;
