<?php
class Optimized_Posts extends WP_Widget {

	function __construct() {
		parent::__construct(
			'optimized-post-widget', // Base ID
			__('Optimized Posts'),
			array( 
				'classname' => 'widget_optimized_posts',
				'description' => __( "Display posts selected by keyword.")
			)
		);
		$this->alt_option_name='widget_optimized_posts';

		add_action( 'save_post', array($this, 'flush_optimized_cache') );
		add_action( 'deleted_post', array($this, 'flush_optimized_cache') );
		add_action( 'switch_theme', array($this, 'flush_optimized_cache') );
		
		add_action('admin_enqueue_scripts',array($this,'initialize'));
	}
	
	function initialize() {
		wp_enqueue_script('mootools', COPTIMIZER_URL.'skin/_js/mootools.js', false, '1.4.1');
	}
	
	function widget($args, $instance) {
		$cache=wp_cache_get('widget_cach_optimized_posts', 'widget');
		if( !is_array($cache) )
			$cache=array();
		if( ! isset( $args['widget_id'] ) )
			$args['widget_id']=$this->id;
		if( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}
		ob_start();
		extract($args);
		$title=( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Optimized Posts' );
		$title=apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$wpQuery=new WP_Query(
			apply_filters(
				'widget_posts_args',
				array( 
					'posts_per_page' => count( $instance['posts'] ),
					'no_found_rows' => true,
					'post_status' => 'publish',
					'ignore_sticky_posts' => true,
					'post__in' => $instance['posts'],
					'orderby' => 'ID',
					'order' => 'ASC'
				)
			)
		);
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
		wp_cache_set('widget_cach_optimized_posts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance=$old_instance;
		$instance['title']=strip_tags($new_instance['title']);
		$instance['keyword']=strip_tags($new_instance['keyword']);
		$instance['posts']=isset( $new_instance['posts'] ) ? $new_instance['posts'] : array();
		$this->flush_optimized_cache();
		$alloptions=wp_cache_get( 'alloptions', 'options' );
		if( isset($alloptions['widget_optimized_posts']) )
			delete_option('widget_optimized_posts');
		return $instance;
	}

	function flush_optimized_cache() {
		wp_cache_delete('widget_cach_optimized_posts', 'widget');
	}

	function form( $instance ) {
		$title    =isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$keyword    =isset( $instance['keyword'] ) ? esc_attr( $instance['keyword'] ) : '';
		$posts    =isset( $instance['posts'] ) ? $instance['posts'] : array();
?>
<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'keyword' ); ?>"><?php _e( 'Keyword:' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'keyword' ); ?>" name="<?php echo $this->get_field_name( 'keyword' ); ?>" type="text" value="<?php echo $keyword; ?>" />
</p>
<p>
	<label>&nbsp;</label>
	<input id="<?php echo $this->get_field_id( 'button-keyword' ); ?>" type="button" value="<?php _e( 'Get posts' ); ?>" class="button button-primary" />
</p>
<p id="<?php echo $this->get_field_id( 'keyword-result' ); ?>">
<?php 
if( !empty( $posts ) ){		
	$wpQuery=new WP_Query(
		apply_filters(
			'widget_posts_args',
			array(
				'posts_per_page' => count( $instance['posts'] ),
				'no_found_rows' => true,
				'post_status' => 'publish',
				'ignore_sticky_posts' => true,
				'post__in' => $posts,
				'orderby' => 'ID',
				'order' => 'ASC'
			)
		)
	);
	while ( $wpQuery->have_posts() ){
		$wpQuery->the_post();
		?><input type="checkbox" name="<?php echo $this->get_field_name( 'posts' ); ?>[]" value="<?php the_ID() ?>" checked />
		<a href="<?php the_permalink(); ?>" target="_blank" ><?php get_the_title() ? the_title() : the_ID(); ?></a><br/><?
		wp_reset_postdata();
	}
}
?>
</p>
<script type="text/javascript">
<!--//--><![CDATA[//><!--
$('<?php echo $this->get_field_id( 'button-keyword' ); ?>').addEvent('click',function(){
	new Request.JSON({
		url: 'admin-ajax.php',
		method: 'post',
		data:{
			action: 'getcontents',
			keyword: $('<?php echo $this->get_field_id( 'keyword' ); ?>').get('value')
		},
		onRequest: function(){
			$('<?php echo $this->get_field_id( 'button-keyword' ); ?>').set('value', 'Loading...');
		},
		onSuccess: function(request){
			$('<?php echo $this->get_field_id( 'keyword-result' ); ?>').empty();
			if( request.replacedCounter == 0 ){
				new Element( 'p', {html: 'Nothing Found'}).inject($('<?php echo $this->get_field_id( 'keyword-result' ); ?>'));
			}
			Object.each(request.links, function( value, key ){
				if( key != 'post' ){
					return;
				}
				Object.each(value, function( data, postId ){
					var checkboxElement = new Element( 'input', {
						type: 'checkbox', 
						name: '<?php echo $this->get_field_name( 'posts' ); ?>[]', 
						value: postId,
						checked: true
					})
					if( <?php echo '['.implode( ',', $posts ).']'; ?>.contains( parseInt( postId ) ) ){
						checkboxElement.checked=true;
					}
					checkboxElement.inject($('<?php echo $this->get_field_id( 'keyword-result' ); ?>'));
					new Element( 'a', { html: data.name, href: data.url, target: '_blank' }).inject($('<?php echo $this->get_field_id( 'keyword-result' ); ?>'));
					new Element( 'br' ).inject($('<?php echo $this->get_field_id( 'keyword-result' ); ?>'));
				});
			});
			$('<?php echo $this->get_field_id( 'button-keyword' ); ?>').set('value', 'New search');
		},
		onFailure: function(){
			new Element( 'p', {html: 'Sorry, your request failed'}).inject($('<?php echo $this->get_field_id( 'keyword-result' ); ?>'));
			myElement.set('text', ' :(');
			$('<?php echo $this->get_field_id( 'button-keyword' ); ?>').set('value', 'Check again!');
		}
	}).send();
});
//--><!]]>
</script>
<?php
	}
}