<?php
/*
Plugin Name: SEO Bot
Plugin URI: http://getbusinessblog.com/wordpress-plugins/seo-bot
Description: SEO Bot helps you optimize the content of your WordPress site for search engines.
Version: 1.0.1
Author: GetBusinessBlog.com
Author URI: http://getbusinessblog.com
*/

if( !defined('COPTIMIZER_URL') )
	define( 'COPTIMIZER_URL', plugin_dir_url( __FILE__ ) );
if( !defined('COPTIMIZER_PATH') )
	define( 'COPTIMIZER_PATH', plugin_dir_path( __FILE__ ) );
if( !defined('COPTIMIZER_BASENAME') )
	define( 'COPTIMIZER_BASENAME', plugin_basename( __FILE__ ) );

define( 'COPTIMIZER_FILE', __FILE__ );

if(!defined('ENT_SUBSTITUTE')) {
	if( version_compare( PHP_VERSION, '5.3.0', '<') ){
		define('ENT_SUBSTITUTE', 0);
	}elseif( version_compare( PHP_VERSION, '5.4.0', '<') ){
		define('ENT_SUBSTITUTE', ENT_IGNORE);
	}
}

error_reporting(E_ALL ^ E_NOTICE );

include_once( COPTIMIZER_PATH.'/library/Plugin.php' );
$pluginClass=new ContentOptimizer();
$pluginClass->run();
