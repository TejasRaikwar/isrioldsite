<?php get_header();?>

<div class="error_page">
	<div class="container">
	    <div class="row">
	        <div class="col-md-12">
		        <div class="heading_font">
		            <div class="error_404">404</div>
		            <div class="h2"><?php _e('The page you are looking for does not exist.', STM_DOMAIN); ?></div>
		        </div>
		        <a href="/" class="btn btn-default"><?php _e('GO BACK TO HOMEPAGE', STM_DOMAIN) ?></a>
	        </div>
	    </div>
	</div>
</div>

<?php get_footer();?>