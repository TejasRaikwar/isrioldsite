CREATE TABLE `wp_spellcheck_options` (  `id` mediumint(9) NOT NULL AUTO_INCREMENT,  `option_name` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,  `option_value` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,  UNIQUE KEY `id` (`id`)) ENGINE=MyISAM AUTO_INCREMENT=139 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40000 ALTER TABLE `wp_spellcheck_options` DISABLE KEYS */;
INSERT INTO `wp_spellcheck_options` VALUES('1', 'email', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('2', 'email_address', '');
INSERT INTO `wp_spellcheck_options` VALUES('3', 'email_frequency', '1');
INSERT INTO `wp_spellcheck_options` VALUES('4', 'ignore_caps', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('5', 'check_pages', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('6', 'check_posts', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('7', 'check_theme', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('8', 'check_menus', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('9', 'scan_frequency', '1');
INSERT INTO `wp_spellcheck_options` VALUES('10', 'scan_frequency_interval', 'daily');
INSERT INTO `wp_spellcheck_options` VALUES('11', 'email_frequency_interval', 'daily');
INSERT INTO `wp_spellcheck_options` VALUES('12', 'language_setting', 'en_CA');
INSERT INTO `wp_spellcheck_options` VALUES('13', 'page_titles', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('14', 'post_titles', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('15', 'tags', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('16', 'categories', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('17', 'seo_desc', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('18', 'seo_titles', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('19', 'page_slugs', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('20', 'post_slugs', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('21', 'api_key', '');
INSERT INTO `wp_spellcheck_options` VALUES('22', 'pro_word_count', '0');
INSERT INTO `wp_spellcheck_options` VALUES('23', 'total_word_count', '0');
INSERT INTO `wp_spellcheck_options` VALUES('24', 'ignore_emails', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('25', 'ignore_websites', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('26', 'scan_in_progress', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('27', 'last_scan_started', '0');
INSERT INTO `wp_spellcheck_options` VALUES('28', 'last_scan_finished', '  13 seconds ');
INSERT INTO `wp_spellcheck_options` VALUES('29', 'page_count', '0');
INSERT INTO `wp_spellcheck_options` VALUES('30', 'post_count', '0');
INSERT INTO `wp_spellcheck_options` VALUES('31', 'check_sliders', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('32', 'check_media', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('33', 'media_count', '0');
INSERT INTO `wp_spellcheck_options` VALUES('34', 'highlight_word', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('35', 'highlight_word', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('36', 'highlight_word', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('37', 'check_ecommerce', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('38', 'check_cf7', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('39', 'check_tag_desc', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('40', 'check_tag_slug', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('41', 'check_cat_desc', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('42', 'check_cat_slug', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('43', 'check_custom', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('44', 'last_scan_date', '1491390867');
INSERT INTO `wp_spellcheck_options` VALUES('45', 'check_authors', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('46', 'last_scan_type', 'Page Content');
INSERT INTO `wp_spellcheck_options` VALUES('47', 'empty_checked', '0');
INSERT INTO `wp_spellcheck_options` VALUES('48', 'check_authors_empty', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('49', 'check_menu_empty', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('50', 'check_page_titles_empty', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('51', 'check_post_titles_empty', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('52', 'check_tag_desc_empty', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('53', 'check_cat_desc_empty', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('54', 'check_page_seo_empty', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('55', 'check_post_seo_empty', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('56', 'check_media_seo_empty', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('57', 'check_media_empty', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('58', 'check_ecommerce_empty', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('59', 'empty_scan_in_progress', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('60', 'empty_page_count', '0');
INSERT INTO `wp_spellcheck_options` VALUES('61', 'empty_post_count', '0');
INSERT INTO `wp_spellcheck_options` VALUES('62', 'empty_media_count', '0');
INSERT INTO `wp_spellcheck_options` VALUES('63', 'pro_empty_count', '0');
INSERT INTO `wp_spellcheck_options` VALUES('64', 'last_empty_type', 'None');
INSERT INTO `wp_spellcheck_options` VALUES('65', 'literary_factor', '0');
INSERT INTO `wp_spellcheck_options` VALUES('66', 'empty_factor', '0');
INSERT INTO `wp_spellcheck_options` VALUES('67', 'page_sip', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('68', 'post_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('69', 'seo_title_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('70', 'seo_desc_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('71', 'media_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('72', 'author_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('73', 'cf7_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('74', 'menu_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('75', 'page_title_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('76', 'post_title_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('77', 'tag_title_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('78', 'tag_desc_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('79', 'tag_slug_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('80', 'cat_title_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('81', 'cat_desc_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('82', 'cat_slug_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('83', 'page_slug_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('84', 'post_slug_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('85', 'slider_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('86', 'ecommerce_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('87', 'free_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('88', 'empty_page_seo_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('89', 'empty_post_seo_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('90', 'empty_media_seo_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('91', 'empty_author_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('92', 'empty_menu_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('93', 'empty_page_title_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('94', 'empty_post_title_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('95', 'empty_tag_desc_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('96', 'empty_cat_desc_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('97', 'empty_ecommerce_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('98', 'empty_media_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('99', 'empty_free_sip', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('100', 'entire_scan', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('101', 'entire_empty_scan', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('102', 'scan_start_time', '1491201977');
INSERT INTO `wp_spellcheck_options` VALUES('103', 'empty_start_time', '0');
INSERT INTO `wp_spellcheck_options` VALUES('104', 'page_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('105', 'post_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('106', 'seo_title_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('107', 'seo_desc_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('108', 'media_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('109', 'author_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('110', 'cf7_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('111', 'menu_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('112', 'page_title_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('113', 'post_title_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('114', 'tag_title_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('115', 'tag_desc_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('116', 'tag_slug_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('117', 'cat_title_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('118', 'cat_desc_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('119', 'cat_slug_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('120', 'page_slug_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('121', 'post_slug_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('122', 'slider_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('123', 'ecommerce_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('124', 'free_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('125', 'empty_page_seo_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('126', 'empty_post_seo_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('127', 'empty_media_seo_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('128', 'empty_author_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('129', 'empty_menu_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('130', 'empty_page_title_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('131', 'empty_post_title_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('132', 'empty_tag_desc_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('133', 'empty_cat_desc_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('134', 'empty_ecommerce_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('135', 'empty_media_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('136', 'empty_free_sip_finish', 'false');
INSERT INTO `wp_spellcheck_options` VALUES('137', 'scan_page_drafts', 'true');
INSERT INTO `wp_spellcheck_options` VALUES('138', 'scan_post_drafts', 'true');
/*!40000 ALTER TABLE `wp_spellcheck_options` ENABLE KEYS */;