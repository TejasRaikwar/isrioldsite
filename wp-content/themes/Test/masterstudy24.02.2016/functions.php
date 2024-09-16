<?php
	
	$inc_path = get_template_directory() . '/inc';
	
	$widgets_path = get_template_directory() . '/inc/widgets';
	define('STM_DOMAIN', 'stm_domain');
	
		// Theme setups
		
		// Custom code and theme main setups
		require_once( $inc_path . '/setup.php' );
		
		// Enqueue scripts and styles for theme
		require_once( $inc_path . '/scripts_styles.php' );
		
		// Customizer opt
		require_once ( $inc_path . '/redux-framework/admin-init.php' );
		//require_once( $inc_path . '/customizer/setup.php' );
		
		// Required plugins for theme
		require_once( $inc_path . '/tgm/tgm-plugin-registration.php' );
		
		// Visual composer custom modules
		if ( in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			require_once( $inc_path . '/visual_composer.php' );
		}

		// Custom code for any outputs modifying
		require_once( $inc_path . '/payment.php' );
		require_once( $inc_path . '/custom.php' );
		
		// Custom code for woocommerce modifying
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		    require_once( $inc_path . '/woocommerce_setups.php' );
		    
		    // Custom Woo widget
		    require_once( $widgets_path . '/woo_popular_courses.php' );
		}
		
		// Mailchimp widget
		require_once( $widgets_path . '/mailchimp.php' );
		require_once( $widgets_path . '/contacts.php' );
		require_once( $widgets_path . '/pages.php' );
		require_once( $widgets_path . '/socials.php' );
		require_once( $widgets_path . '/recent_posts.php' );
		require_once( $widgets_path . '/working_hours.php' );
			
		// Less compiler only in stm dev area
		$stm_uri = str_replace('www.', '',$_SERVER['HTTP_HOST'] );
		
		if(preg_match('/.stm/', $stm_uri)) {
			require_once( $inc_path . '/less/lessc.connect.php' );
		}