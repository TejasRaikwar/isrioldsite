CREATE TABLE `wp_woocommerce_attribute_taxonomies` (  `attribute_id` bigint(20) NOT NULL AUTO_INCREMENT,  `attribute_name` varchar(200) NOT NULL,  `attribute_label` longtext,  `attribute_type` varchar(200) NOT NULL,  `attribute_orderby` varchar(200) NOT NULL,  `attribute_public` int(1) NOT NULL DEFAULT '1',  PRIMARY KEY (`attribute_id`),  KEY `attribute_name` (`attribute_name`)) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40000 ALTER TABLE `wp_woocommerce_attribute_taxonomies` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_woocommerce_attribute_taxonomies` ENABLE KEYS */;
