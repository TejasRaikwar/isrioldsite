<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$expert = get_post_meta(get_the_id(), 'course_expert', true);
$rating_enabled = get_option('woocommerce_enable_review_rating');
?>

<?php
	

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class('single_product_inner_content'); ?>>
	
	<div class="single_product_title"><?php woocommerce_get_template( 'single-product/title.php' ); ?></div>
	
	<div class="single_product_after_title">
		<div class="clearfix">
			<div class="pull-left meta_pull">
				<?php if(!empty($expert) and $expert != 'no_teacher'): ?>
				<div class="pull-left">
					<a href="<?php echo get_permalink($expert); ?>">
						<div class="meta-unit teacher clearfix">
							<div class="pull-left">
								<i class="fa-icon-stm_icon_teacher"></i>
							</div>
							<div class="meta_values">
								<div class="label h6"><?php _e('Teacher', STM_DOMAIN); ?></div>
								<div class="value h6"><?php echo esc_attr(get_the_title($expert)); ?></div>
							</div>
						</div>
					</a>
				</div>
				<?php endif; ?>
			
				<?php 
				$args = array(
					'number' => '2',
				);
				$product_cats = get_the_terms( get_the_id(), 'product_cat'); 
				if(!empty($product_cats)):?>
					<div class="pull-left xs-product-cats-left">
						<div class="meta-unit categories clearfix">
							<div class="pull-left">
								<i class="fa-icon-stm_icon_category"></i>
							</div>
							<div class="meta_values">
								<div class="label h6"><?php _e('Category:', STM_DOMAIN); ?></div>
								<div class="value h6">
									<?php foreach($product_cats as $product_cat): ?>
										<a href="<?php echo get_term_link($product_cat); ?>"><?php echo($product_cat->name.'<span>/</span>'); ?></a>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
				
			</div> <!-- meta pull -->
			
			<div class="pull-right xs-comments-left">
				<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
				<?php $comments_num = get_comments_number(get_the_id()); ?>
				<?php if($comments_num): ?>
					<div class="meta-unit text-right xs-text-left">
						<div class="value h6"><?php echo esc_attr($comments_num).' '.__('Reviews', STM_DOMAIN); ?></div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	
	<!-- Images -->
	<div class="stm_woo_gallery-wrapper">
		<?php do_action( 'woocommerce_before_single_product_summary' ); ?>
		<a href="#" class="gallery-prev gallery-btn hidden"><i class="fa fa-chevron-left"></i></a>
		<a href="#" class="gallery-next gallery-btn hidden"><i class="fa fa-chevron-right"></i></a>
	</div>
	<!-- Images END-->
		
	<!-- Sidebar visible sm and xs -->
	<div class="stm_product_meta_single_page visible-sm visible-xs">
		<?php wc_get_template_part('content-single-product-meta-side'); ?>
	</div>
	
	<!-- Content -->
	<?php the_content(); ?>
	<!-- Content END -->
	
	<div class="multiseparator"></div>
	
	<!-- Teacher -->
	<?php if(!empty($expert) and $expert != 'no_expert'): ?>
		<?php $teacher_post = get_post($expert); ?>
		<?php $teacher_job = get_post_meta($expert, 'expert_sphere', true); ?>
		<?php
		$origin_socials = array(
			'facebook',
			'linkedin',
			'twitter',
			'google-plus',
			'youtube-play',
		); ?>
		<h3 class="teacher_single_product_page_title"><?php _e('About Instructor', STM_DOMAIN); ?></h3>
		<div class="teacher_single_product_page clearfix">
			<a href="<?php echo get_the_permalink($expert); ?>" title="<?php _e('Watch Expert Page', STM_DOMAIN); ?>">
				<?php $expert_image = wp_get_attachment_image_src(get_post_thumbnail_id($expert), 'img-129-129', false); ?>
				<?php if(!empty($expert_image[0])): ?>
					<img class="img-responsive" src="<?php echo esc_url($expert_image[0]); ?>" />
				<?php endif; ?>
				<div class="title h4"><?php echo esc_attr(get_the_title($expert)); ?></div>
				<?php if(!empty($teacher_job)): ?>
					<label class="job"><?php echo esc_attr($teacher_job); ?></label>
				<?php endif; ?>
			</a>
			<div class="expert_socials">
				<div class="clearfix heading_font">
					<?php foreach($origin_socials as $social): ?>
						<?php $current_social = get_post_custom_values($social, $expert); ?>
						<?php if(!empty($current_social[0])): ?>
							<a class="expert-social-<?php echo($social); ?>" href="<?php echo($current_social[0]); ?>" title="<?php echo __('View expert on', STM_DOMAIN).' '.$social ?>">
								<i class="fa fa-<?php echo($social); ?>"></i>
							</a>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="clearfix"></div>
			<?php if(!empty($teacher_post->post_excerpt)): ?>
				<div class="content">
					<?php echo esc_attr($teacher_post->post_excerpt); ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="multiseparator"></div>
		<?php wp_reset_postdata(); ?>
	<?php endif; ?>
	<!-- Teacher END-->
	
	
	
	<?php 
	if($rating_enabled == 'yes'):
		$product = wc_get_product(get_the_id()); 
		$rating_count = $product->get_rating_count();
		$average      = $product->get_average_rating();
		$average = round($average, 1); ?>

		<!-- Reviews -->
		<h3 class="woo_reviews_title"><?php _e('Reviews', STM_DOMAIN); ?></h3>
		<div class="clearfix">
			<!-- Reviews Average ratings -->
			<div class="average_rating">
				<p class="rating_sub_title"><?php _e('Average Rating', STM_DOMAIN);?></p>
				<div class="average_rating_unit heading_font">
					<div class="average_rating_value"><?php echo esc_attr($average); ?></div>
					<div class="average-rating-stars">
						<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
					</div>
					<div class="average_rating_num">
						<?php echo esc_attr($rating_count.' '.__('Ratings', STM_DOMAIN)); ?>
					</div>
				</div>
			</div>
			<!-- Reviews Average ratings END -->
			
			<!-- Review detailed Rating -->
			<?php 
				// WP_Comment_Query arguments
				$args = array (
					'status'         => 'approve',
					'type'           => 'comment',
					'post_id'        => get_the_id(),
				);
				
				// The Comment Query
				$woo_reviews = new WP_Comment_Query;
				$comments = $woo_reviews->query( $args );
				
				$rate1 = $rate2 = $rate3 = $rate4 = $rate5 = 0;
				// The Comment Loop
				if ( $comments ) {
					foreach ( $comments as $comment ) {
						$rate = get_comment_meta($comment->comment_ID, 'rating', true);
						switch($rate) {
							case 1:
								$rate1++;
								break;
							case 2:
								$rate2++;
								break;
							case 3:
								$rate3++;
								break;
							case 4:
								$rate4++;
								break;
							case 5:
								$rate5++;
								break;
						} // switch
					}
				}
				$rates = array('5'=>$rate5,'4'=>$rate4,'3'=>$rate3,'2'=>$rate2,'1'=>$rate1);
			?>
			<div class="detailed_rating">
				<p class="rating_sub_title"><?php _e('Detailed Rating', STM_DOMAIN);?></p>
				<table class="detail_rating_unit">
					<?php foreach($rates as $key => $rate): ?>
						<?php 
							if($rate !=0 or $rating_count != 0) {
								$fill_value = round($rate*100/$rating_count, 2); 
							} else {
								$fill_value = 0;
							}
						?>
						<tr class="stars_<?php echo esc_attr($key); ?>">
							<td class="key"><?php echo esc_attr(__('Stars', STM_DOMAIN).' '.$key); ?></td>
							<td class="bar">
								<div class="full_bar">
									<div class="bar_filler" style="width:<?php echo esc_attr($fill_value); ?>%"></div>
								</div>
							</td>
							<td class="value"><?php echo esc_attr($rate); ?></td>
						</tr>
					<?php endforeach; ?>
				</table>
			</div>
			<!-- Review detailed Rating END -->
		</div> <!-- clearfix -->
		<div class="multiseparator"></div>
	<?php endif; ?>
	<?php if ( comments_open() || get_comments_number() ): ?>
		<?php comments_template(); ?>
	<?php endif; ?>
		
	<!-- Reviews END -->
	
	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
