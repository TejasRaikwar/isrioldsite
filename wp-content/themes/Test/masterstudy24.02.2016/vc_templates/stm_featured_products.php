<?php
extract( shortcode_atts( array(
	'meta_key' => 'all',
	'expert_id' => 'no_expert',
	'view_type' => 'featured_products_carousel',
	'auto' => '0',
	'per_page' => '-1',
	'per_row' => 4,
	'order' => 'DESC',
	'orderby' => 'date',
	'hide_price' => false,
	'hide_rating' => false,
	'hide_comments' => false,
	'price_bg' => '#48a7d4',
	'free_price_bg' => '#eab830',
	'css'   => ''
), $atts ) );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

// All args for extract all products
$args = array(  
    'post_type' => 'product',
    'post_status' => 'publish',
    'order' => $order,
    'orderby' => $orderby,
    'posts_per_page' => $per_page,
);

$args['meta_query'][] = array(
	'key' => '_stock_status',
	'value' => 'instock',	
);

// Get featured products
if ($meta_key == '_featured') {
	$args['meta_query'][] = array(
		'key' => '_featured',
		'value' => 'yes',	
	);
} elseif($meta_key == 'expert' and $meta_key != 'no_expert') {
	$args['meta_query'][] = array(
		'key' => 'course_expert',
		'value' => $expert_id,	
	);
}

$featured_query = new WP_Query( $args ); 

$featured_product_num = rand(0, 99999);

$cols_per_row = 12/$per_row;
?>


<?php if($featured_query->have_posts()): ?>

	<div class="stm_featured_products_unit <?php echo esc_attr($view_type); ?>">
		
		<?php if($view_type == 'featured_products_carousel'): ?>
			<div class="simple_carousel_with_bullets">
				<div class="simple_carousel_bullets_init_<?php echo esc_attr($featured_product_num); ?> clearfix">
		<?php else: ?>
			<div class="row">
		<?php endif; ?>
		
			<?php while($featured_query->have_posts()): $featured_query->the_post(); ?>
				<?php 
				$expert = get_post_meta(get_the_id(), 'course_expert', true); 
				$stock = get_post_meta(get_the_id(), '_stock', true ); 
				$regular_price = get_post_meta(get_the_id(), '_regular_price', true ); 
				$sale_price = get_post_meta(get_the_id(), '_sale_price', true );
				?>
				<div class="col-md-<?php echo esc_attr($cols_per_row); ?> col-sm-4 col-xs-12">
					<div class="stm_featured_product_single_unit<?php echo esc_attr($css_class); ?> heading_font">
						<div class="stm_featured_product_single_unit_centered">
							
							
								<div class="stm_featured_product_image">
									
									<?php if(!$hide_price): ?>
										<div class="stm_featured_product_price">
											<?php if(!empty($sale_price) and $sale_price != 0): ?>
												<div class="price" style="background-color:<?php echo esc_attr($price_bg); ?>">
													<h5><?php echo esc_attr(get_woocommerce_currency_symbol().$sale_price); ?></h5>
												</div>
											<?php elseif(!empty($regular_price) and $regular_price != 0): ?>
												<div class="price" style="background-color:<?php echo esc_attr($price_bg); ?>">
													<h5><?php echo esc_attr(get_woocommerce_currency_symbol().$regular_price); ?></h5>
												</div>
											<?php else: ?>
												<div class="price price_free" style="background-color:<?php echo esc_attr($free_price_bg); ?>">
													<h5><?php _e('Free', STM_DOMAIN); ?></h5>
												</div>
											<?php endif; ?>
										</div>
									<?php endif; ?>	
									
									
									<?php if(has_post_thumbnail()): ?>
									<a href="<?php the_permalink() ?>" title="<?php _e('View course', STM_DOMAIN) ?> - <?php the_title(); ?>">
										<?php the_post_thumbnail('img-270-283', array('class'=>'img-responsive')); ?>
									</a>
									<?php else: ?>
										<div class="no_image_holder"></div>
									<?php endif; ?>
								</div>
								
								<div class="stm_featured_product_body">
									<a href="<?php the_permalink() ?>"  title="<?php _e('View course', STM_DOMAIN) ?> - <?php the_title(); ?>">
										<div class="title"><?php the_title(); ?></div>
									</a>
									<?php if(!empty($expert) and $expert != 'no_expert'): ?>
										<div class="expert"><?php echo esc_attr(get_the_title($expert)); ?></div>
									<?php else: ?>
										<div class="expert">&nbsp;</div>
									<?php endif; ?>
								</div>
								
								<div class="stm_featured_product_footer">
									<div class="clearfix">
										<div class="pull-left">
											
											<?php if(!$hide_comments): ?>
												<?php $comments_num = get_comments_number(get_the_id()); ?>
												<?php if($comments_num): ?>
													<div class="stm_featured_product_comments">
														<i class="fa-icon-stm_icon_comment_o"></i><span><?php echo esc_attr($comments_num); ?></span>
													</div>
												<?php else: ?>
													<div class="stm_featured_product_comments">
														<i class="fa-icon-stm_icon_comment_o"></i><span>0</span>
													</div>
												<?php endif; ?>
											<?php endif; ?>
											
											<?php if(!empty($stock)): ?>
												<div class="stm_featured_product_stock">
													<i class="fa-icon-stm_icon_user"></i><span><?php echo esc_attr(floatval($stock)); ?></span>
												</div>
											<?php else: ?>
												<div class="stm_featured_product_stock">
													<i class="fa-icon-stm_icon_user"></i><span>0</span>
												</div>
											<?php endif; ?>
											
										</div>
										<?php if(!$hide_rating): ?>
											<div class="pull-right">
												<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
											</div>
										<?php endif; ?>
									</div>
									
									<div class="stm_featured_product_show_more">
										<a class="btn btn-default" href="<?php the_permalink() ?>" title="<?php _e('View more', STM_DOMAIN) ?>"><?php _e('View more', STM_DOMAIN); ?></a>
									</div>
									
								</div>
								
						</div>
					</div>
				</div>
			<?php endwhile; ?>
			
		<?php if($view_type == 'featured_products_carousel'): ?>
				</div> <!-- simple_carousel_with_bullets_init -->
				<div class="simple-carousel-bullets"></div>
			</div> <!-- simple_carousel_with_bullets -->
		<?php else: ?>
			</div> <!-- row -->
		<?php endif; ?>
		
	</div> <!-- stm_featured_products_unit -->
	
<?php endif; ?>

<?php wp_reset_postdata(); ?>

<?php if($view_type == 'featured_products_carousel'): ?>
	<script type="text/javascript">
		(function($) {
		    "use strict";
			
			$(document).ready(function() {
				simple_carousel_bullets_cfs();
			});
			
			$(window).load(function() {
				$('.simple_carousel_bullets_init_<?php echo($featured_product_num); ?>').trigger('destroy');
				simple_carousel_bullets_cfs();
			});
			
			$(window).resize(function() {
				$('.simple_carousel_bullets_init_<?php echo($featured_product_num); ?>').trigger('destroy');
				simple_carousel_bullets_cfs();
			});
			
			var items = 1;
			
			function simple_carousel_bullets_cfs(){
				$('.simple_carousel_bullets_init_<?php echo($featured_product_num); ?>').carouFredSel({
					scroll   : {
					    items: items,
						fx : "direct",
				        duration : 800,                         
				        pauseOnHover : true
				    },
				    debug: false,
				    auto: {
				        play:<?php if( $auto ) { echo esc_attr($auto); } else { echo esc_attr('false'); }; ?>,
				        timeoutDuration: 5000
				    },
				    swipe: { 
					    onTouch: true 
					},
					responsive: true,
				    width: "100%",
				    items: {
				        visible: {
				            min:1,
				            max:<?php echo esc_attr($per_row) ?>
				        },
				    },
				    pagination: {
						container: function() {
				            return $(this).closest('.simple_carousel_with_bullets').find('.simple-carousel-bullets');
				        }
					},
				});
				
				items = $('.simple_carousel_bullets_init_<?php echo($featured_product_num); ?>').triggerHandler("currentVisible");
			};
		})(jQuery);
	</script>
<?php endif; ?>