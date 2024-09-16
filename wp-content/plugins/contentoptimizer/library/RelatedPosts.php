<?php
class Related_Posts extends WP_Widget {

	function __construct() {
		parent::__construct(
			'related-post-widget', // Base ID
			__('Related Posts'),
			array( 
				'classname' => 'widget_related_posts',
				'description' => __( "Display related posts in a sidebar.")
			)
		);
		$this->alt_option_name='widget_related_posts';

		add_action( 'save_post', array($this, 'flush_related_cache') );
		add_action( 'deleted_post', array($this, 'flush_related_cache') );
		add_action( 'switch_theme', array($this, 'flush_related_cache') );
		
		add_action('admin_enqueue_scripts',array($this,'initialize'));
	}
	
	function initialize() {
		wp_enqueue_script('mootools', COPTIMIZER_URL.'skin/_js/mootools.js', false, '1.4.1');
	}
	
	function widget($args, $instance) {
		$cache=wp_cache_get('widget_cach_related_posts', 'widget');
		if( !is_array($cache) )
			$cache=array();
		if( ! isset( $args['widget_id'] ) )
			$args['widget_id']=$this->id;
		if( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}
		global $post;
		$post=get_post( $post->ID );
		
		if( get_the_terms( $post->ID, 'related_keywords' ) === false ){
			$taxonomies=get_object_taxonomies( $post->post_type, 'objects' );
		}else{
			$taxonomies=array( 'related_keywords'=>true );
		}
		$tax_query=array( 'relation' => 'OR' );
		foreach ( $taxonomies as $taxonomy_slug => $_t ){
			$terms=get_the_terms( $post->ID, $taxonomy_slug );
			if( !empty( $terms ) ) {
				$outIds=array();
				foreach( $terms as $term ) {
					$outIds[]=$term->term_id;
				}
				$tax_query[]=array(
					'taxonomy' => $taxonomy_slug,
					'field' => 'id',
					'terms' => $outIds,
					'operator' => 'IN'
				);
			}
		}
		extract($args);
		$title=( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Related Posts' );
		$title=apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$wpQuery=new WP_Query(
			apply_filters(
				'widget_posts_args',
				array(
					'posts_per_page' => (int)$instance['number'],
					'no_found_rows' => true,
					'post_status' => 'publish',
					'ignore_sticky_posts' => true,
					'orderby' => 'date',
					'order' => 'DESC',
					'tax_query' => $tax_query,
					'post__not_in' => array( $post->ID )
				)
			)
		);
		if(!$wpQuery->have_posts()){
			$wpQuery=new WP_Query(
				apply_filters(
					'widget_posts_args',
					array(
						'posts_per_page' => (int)$instance['number'],
						'no_found_rows' => true,
						'post_status' => 'publish',
						'ignore_sticky_posts' => true,
						'orderby' => 'date',
						'order' => 'DESC',
						'post__not_in' => array( $post->ID )
					)
				)
			);
		}
		if($wpQuery->have_posts()){
			echo $before_widget; ?>
<?php if( $title )
	echo $before_title.$title.$after_title; ?>
<ul>
<?php while ( $wpQuery->have_posts() ){
	$wpQuery->the_post(); ?>
	<li>
		<a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
	</li>
<?php } ?>
</ul>
<?php echo $after_widget; 
			wp_reset_postdata();
		}
		$cache[$args['widget_id']]=ob_get_flush();
		wp_cache_set('widget_cach_related_posts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance=$old_instance;
		$instance['title']=strip_tags($new_instance['title']);
		$instance['number']=strip_tags($new_instance['number']);
		$this->flush_related_cache();
		$alloptions=wp_cache_get( 'alloptions', 'options' );
		if( isset($alloptions['widget_related_posts']) )
			delete_option('widget_related_posts');
		return $instance;
	}

	function flush_related_cache() {
		wp_cache_delete('widget_cach_related_posts', 'widget');
	}

	function form( $instance ) {
		$title=isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number=isset( $instance['number'] ) ? esc_attr( $instance['number'] ) : 4;
	//	$taxonomies=get_taxonomies('','objects');
	//	var_dump( $taxonomies );
?>
<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of Posts:' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" min="1" value="<?php echo $number; ?>" />
</p>
<?php
	}
}