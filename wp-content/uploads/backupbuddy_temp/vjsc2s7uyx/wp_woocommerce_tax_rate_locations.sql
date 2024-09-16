CREATE TABLE `wp_woocommerce_tax_rate_locations` (  `location_id` bigint(20) NOT NULL AUTO_INCREMENT,  `location_code` varchar(255) NOT NULL,  `tax_rate_id` bigint(20) NOT NULL,  `location_type` varchar(40) NOT NULL,  PRIMARY KEY (`location_id`),  KEY `tax_rate_id` (`tax_rate_id`),  KEY `location_type` (`location_type`),  KEY `location_type_code` (`location_type`,`location_code`(90))) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40000 ALTER TABLE `wp_woocommerce_tax_rate_locations` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_woocommerce_tax_rate_locations` ENABLE KEYS */;
