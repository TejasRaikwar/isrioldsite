CREATE TABLE `wp_revslider_layer_animations` (  `id` int(9) NOT NULL AUTO_INCREMENT,  `handle` text NOT NULL,  `params` text NOT NULL,  `settings` text,  UNIQUE KEY `id` (`id`)) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40000 ALTER TABLE `wp_revslider_layer_animations` DISABLE KEYS */;
INSERT INTO `wp_revslider_layer_animations` VALUES('1', 'Choose Automatic', '{\"movex\":\"-190\",\"movey\":\"340\",\"movez\":\"-40\",\"rotationx\":\"400\",\"rotationy\":\"140\",\"rotationz\":\"490\",\"scalex\":\"90\",\"scaley\":\"200\",\"skewx\":\"29\",\"skewy\":\"42\",\"captionopacity\":\"0\",\"captionperspective\":\"600\",\"originx\":\"-60\",\"originy\":\"40\"}', NULL);
/*!40000 ALTER TABLE `wp_revslider_layer_animations` ENABLE KEYS */;
