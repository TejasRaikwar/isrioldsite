CREATE TABLE `wp_users` (  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,  `user_login` varchar(60) NOT NULL DEFAULT '',  `user_pass` varchar(255) NOT NULL DEFAULT '',  `user_nicename` varchar(50) NOT NULL DEFAULT '',  `user_email` varchar(100) NOT NULL DEFAULT '',  `user_url` varchar(100) NOT NULL DEFAULT '',  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',  `user_activation_key` varchar(255) NOT NULL DEFAULT '',  `user_status` int(11) NOT NULL DEFAULT '0',  `display_name` varchar(250) NOT NULL DEFAULT '',  PRIMARY KEY (`ID`),  KEY `user_login_key` (`user_login`),  KEY `user_nicename` (`user_nicename`),  KEY `user_email` (`user_email`)) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40000 ALTER TABLE `wp_users` DISABLE KEYS */;
INSERT INTO `wp_users` VALUES('1', 'superadmin', '$P$Bh5csE4WKWMs.PLJuDPcfCesNRS49y0', 'superadmin', 'shripal125@gmail.com', '', '2015-08-26 16:45:13', '', '0', 'superadmin');
INSERT INTO `wp_users` VALUES('7', 'isriadmin', '$P$Bjdso6YlT6K3dyStkHegDZbvSkfLB1.', 'isriadmin', 'shripal@isritechnologies.com', '', '2018-09-26 17:08:27', '1537981722:$P$BDmybqkgjzARc5uFHLpvuv.W20fwoK0', '0', 'isri admin');
/*!40000 ALTER TABLE `wp_users` ENABLE KEYS */;