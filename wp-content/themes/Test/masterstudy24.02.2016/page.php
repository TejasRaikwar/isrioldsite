<?php get_header();?>
	<?php get_template_part('partials/title_box'); ?>
	<div class="container">
	    <?php if ( have_posts() ) :
	        while ( have_posts() ) : the_post();
				the_content();
	        endwhile;
	    endif; ?>
	    
	    <?php
        wp_link_pages( array(
            'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', STM_DOMAIN ) . '</span>',
            'after'       => '</div>',
            'link_before' => '<span>',
            'link_after'  => '</span>',
            'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', STM_DOMAIN ) . ' </span>%',
            'separator'   => '<span class="screen-reader-text">, </span>',
        ) );
        ?>
	
<!--deleted code paste here for comment-->

		

	</div>

<?php get_footer();?>