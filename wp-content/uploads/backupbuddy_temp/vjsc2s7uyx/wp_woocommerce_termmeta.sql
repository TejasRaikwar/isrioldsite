CREATE TABLE `wp_woocommerce_termmeta` (  `meta_id` bigint(20) NOT NULL AUTO_INCREMENT,  `woocommerce_term_id` bigint(20) NOT NULL,  `meta_key` varchar(255) DEFAULT NULL,  `meta_value` longtext,  PRIMARY KEY (`meta_id`),  KEY `woocommerce_term_id` (`woocommerce_term_id`),  KEY `meta_key` (`meta_key`)) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;
/*!40000 ALTER TABLE `wp_woocommerce_termmeta` DISABLE KEYS */;
INSERT INTO `wp_woocommerce_termmeta` VALUES('1', '24', 'order', '5');
INSERT INTO `wp_woocommerce_termmeta` VALUES('3', '26', 'order', '4');
INSERT INTO `wp_woocommerce_termmeta` VALUES('5', '28', 'order', '6');
INSERT INTO `wp_woocommerce_termmeta` VALUES('7', '30', 'order', '1');
INSERT INTO `wp_woocommerce_termmeta` VALUES('8', '31', 'order', '16');
INSERT INTO `wp_woocommerce_termmeta` VALUES('9', '32', 'order', '14');
INSERT INTO `wp_woocommerce_termmeta` VALUES('10', '33', 'order', '17');
INSERT INTO `wp_woocommerce_termmeta` VALUES('11', '34', 'order', '8');
INSERT INTO `wp_woocommerce_termmeta` VALUES('12', '35', 'order', '2');
INSERT INTO `wp_woocommerce_termmeta` VALUES('13', '26', 'product_count_product_cat', '1');
INSERT INTO `wp_woocommerce_termmeta` VALUES('15', '34', 'product_count_product_cat', '1');
INSERT INTO `wp_woocommerce_termmeta` VALUES('16', '30', 'product_count_product_cat', '1');
INSERT INTO `wp_woocommerce_termmeta` VALUES('18', '31', 'product_count_product_cat', '1');
INSERT INTO `wp_woocommerce_termmeta` VALUES('20', '33', 'product_count_product_cat', '1');
INSERT INTO `wp_woocommerce_termmeta` VALUES('23', '31', 'display_type', '');
INSERT INTO `wp_woocommerce_termmeta` VALUES('24', '31', 'thumbnail_id', '0');
INSERT INTO `wp_woocommerce_termmeta` VALUES('25', '34', 'display_type', '');
INSERT INTO `wp_woocommerce_termmeta` VALUES('26', '34', 'thumbnail_id', '0');
INSERT INTO `wp_woocommerce_termmeta` VALUES('27', '26', 'display_type', '');
INSERT INTO `wp_woocommerce_termmeta` VALUES('28', '26', 'thumbnail_id', '0');
INSERT INTO `wp_woocommerce_termmeta` VALUES('29', '33', 'display_type', '');
INSERT INTO `wp_woocommerce_termmeta` VALUES('30', '33', 'thumbnail_id', '0');
INSERT INTO `wp_woocommerce_termmeta` VALUES('31', '24', 'display_type', '');
INSERT INTO `wp_woocommerce_termmeta` VALUES('32', '24', 'thumbnail_id', '0');
INSERT INTO `wp_woocommerce_termmeta` VALUES('33', '28', 'display_type', '');
INSERT INTO `wp_woocommerce_termmeta` VALUES('34', '28', 'thumbnail_id', '0');
INSERT INTO `wp_woocommerce_termmeta` VALUES('35', '35', 'display_type', '');
INSERT INTO `wp_woocommerce_termmeta` VALUES('36', '35', 'thumbnail_id', '0');
INSERT INTO `wp_woocommerce_termmeta` VALUES('37', '30', 'display_type', '');
INSERT INTO `wp_woocommerce_termmeta` VALUES('38', '30', 'thumbnail_id', '0');
INSERT INTO `wp_woocommerce_termmeta` VALUES('39', '38', 'order', '12');
INSERT INTO `wp_woocommerce_termmeta` VALUES('40', '39', 'order', '10');
INSERT INTO `wp_woocommerce_termmeta` VALUES('41', '40', 'order', '13');
INSERT INTO `wp_woocommerce_termmeta` VALUES('42', '41', 'order', '7');
INSERT INTO `wp_woocommerce_termmeta` VALUES('43', '42', 'order', '15');
INSERT INTO `wp_woocommerce_termmeta` VALUES('44', '43', 'order', '3');
INSERT INTO `wp_woocommerce_termmeta` VALUES('45', '44', 'order', '11');
INSERT INTO `wp_woocommerce_termmeta` VALUES('46', '45', 'order', '9');
INSERT INTO `wp_woocommerce_termmeta` VALUES('48', '39', 'product_count_product_cat', '1');
INSERT INTO `wp_woocommerce_termmeta` VALUES('49', '45', 'product_count_product_cat', '1');
INSERT INTO `wp_woocommerce_termmeta` VALUES('50', '42', 'product_count_product_cat', '1');
INSERT INTO `wp_woocommerce_termmeta` VALUES('51', '43', 'product_count_product_cat', '1');
INSERT INTO `wp_woocommerce_termmeta` VALUES('52', '41', 'product_count_product_cat', '1');
INSERT INTO `wp_woocommerce_termmeta` VALUES('53', '44', 'product_count_product_cat', '1');
INSERT INTO `wp_woocommerce_termmeta` VALUES('57', '41', 'thumbnail_id', '0');
INSERT INTO `wp_woocommerce_termmeta` VALUES('56', '41', 'display_type', '');
INSERT INTO `wp_woocommerce_termmeta` VALUES('66', '24', 'product_count_product_cat', '1');
INSERT INTO `wp_woocommerce_termmeta` VALUES('61', '43', 'display_type', '');
INSERT INTO `wp_woocommerce_termmeta` VALUES('62', '43', 'thumbnail_id', '0');
INSERT INTO `wp_woocommerce_termmeta` VALUES('65', '35', 'product_count_product_cat', '1');
INSERT INTO `wp_woocommerce_termmeta` VALUES('63', '45', 'display_type', '');
INSERT INTO `wp_woocommerce_termmeta` VALUES('64', '45', 'thumbnail_id', '0');
INSERT INTO `wp_woocommerce_termmeta` VALUES('67', '38', 'product_count_product_cat', '1');
INSERT INTO `wp_woocommerce_termmeta` VALUES('68', '40', 'product_count_product_cat', '1');
INSERT INTO `wp_woocommerce_termmeta` VALUES('69', '28', 'product_count_product_cat', '1');
INSERT INTO `wp_woocommerce_termmeta` VALUES('70', '32', 'product_count_product_cat', '1');
INSERT INTO `wp_woocommerce_termmeta` VALUES('72', '39', 'display_type', '');
INSERT INTO `wp_woocommerce_termmeta` VALUES('73', '39', 'thumbnail_id', '0');
INSERT INTO `wp_woocommerce_termmeta` VALUES('74', '44', 'display_type', '');
INSERT INTO `wp_woocommerce_termmeta` VALUES('75', '44', 'thumbnail_id', '0');
INSERT INTO `wp_woocommerce_termmeta` VALUES('76', '38', 'display_type', '');
INSERT INTO `wp_woocommerce_termmeta` VALUES('77', '38', 'thumbnail_id', '0');
INSERT INTO `wp_woocommerce_termmeta` VALUES('78', '40', 'display_type', '');
INSERT INTO `wp_woocommerce_termmeta` VALUES('79', '40', 'thumbnail_id', '0');
INSERT INTO `wp_woocommerce_termmeta` VALUES('80', '32', 'display_type', '');
INSERT INTO `wp_woocommerce_termmeta` VALUES('81', '32', 'thumbnail_id', '0');
INSERT INTO `wp_woocommerce_termmeta` VALUES('82', '42', 'display_type', '');
INSERT INTO `wp_woocommerce_termmeta` VALUES('83', '42', 'thumbnail_id', '0');
/*!40000 ALTER TABLE `wp_woocommerce_termmeta` ENABLE KEYS */;