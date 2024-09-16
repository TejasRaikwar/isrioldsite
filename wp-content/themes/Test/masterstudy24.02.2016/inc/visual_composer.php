<?php

add_action( 'vc_before_init', 'stm_vc_set_as_theme' );

function stm_vc_set_as_theme() {
	vc_set_as_theme( true );
}

if( function_exists( 'vc_set_default_editor_post_types' ) ){
	vc_set_default_editor_post_types( array( 'page', 'post', 'service', 'project', 'sidebar' ) );
}

if ( is_admin() ) {
	if ( ! function_exists( 'stm_vc_remove_teaser_metabox' ) ) {
		function stm_vc_remove_teaser_metabox() {
			$post_types = get_post_types( '', 'names' );
			foreach ( $post_types as $post_type ) {
				remove_meta_box( 'vc_teaser', $post_type, 'side' );
			}
		}
		add_action( 'do_meta_boxes', 'stm_vc_remove_teaser_metabox' );
	}
}

add_action( 'admin_init', 'stm_update_existing_shortcodes' );

function stm_update_existing_shortcodes(){

	if ( function_exists( 'vc_add_params' ) ) {

		vc_add_params( 'vc_gallery', array(
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Gallery type', STM_DOMAIN ),
				'param_name' => 'type',
				'value'    => array(
					__( 'Image grid', STM_DOMAIN ) => 'image_grid',
					__( 'Slick slider', STM_DOMAIN ) => 'slick_slider',
					__( 'Slick slider 2', STM_DOMAIN ) => 'slick_slider_2'
				)
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Thumbnail size', STM_DOMAIN ),
				'param_name' => 'thumbnail_size',
				'dependency' => array(
					'element' => 'type',
					'value' => array( 'slick_slider_2' )
				),
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			)
		));

		vc_add_params( 'vc_column_inner', array(
			array(
				'type' => 'column_offset',
				'heading' => __( 'Responsiveness', 'js_composer' ),
				'param_name' => 'offset',
				'group' => __( 'Width & Responsiveness', 'js_composer' ),
				'description' => __( 'Adjust column for different screen sizes. Control width, offset and visibility settings.', 'js_composer' )
			)
		));

		vc_add_params( 'vc_separator', array(
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Type', STM_DOMAIN ),
				'param_name' => 'type',
				'value'    => array(
					__( 'Type 1', STM_DOMAIN ) => 'type_1',
					__( 'Type 2', STM_DOMAIN ) => 'type_2'
				)
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			),
		) );

		vc_add_params( 'vc_video', array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Iframe Link', STM_DOMAIN ),
				'param_name' => 'link'
			),
			array(
				'type' => 'attach_image',
				'heading' => __( 'Preview Image', STM_DOMAIN ),
				'param_name' => 'image'
			),
		) );

		vc_add_params( 'vc_wp_pages', array(
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			)
		) );

		vc_add_params( 'vc_basic_grid', array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Gap', 'js_composer' ),
				'param_name' => 'gap',
				'value' => array(
					__( '0px', 'js_composer' ) => '0',
					__( '1px', 'js_composer' ) => '1',
					__( '2px', 'js_composer' ) => '2',
					__( '3px', 'js_composer' ) => '3',
					__( '4px', 'js_composer' ) => '4',
					__( '5px', 'js_composer' ) => '5',
					__( '10px', 'js_composer' ) => '10',
					__( '15px', 'js_composer' ) => '15',
					__( '20px', 'js_composer' ) => '20',
					__( '25px', 'js_composer' ) => '25',
					__( '30px', 'js_composer' ) => '30',
					__( '35px', 'js_composer' ) => '35',
					__( '40px', 'js_composer' ) => '40',
					__( '45px', 'js_composer' ) => '45',
					__( '50px', 'js_composer' ) => '50',
					__( '55px', 'js_composer' ) => '55',
					__( '60px', 'js_composer' ) => '60',
				),
				'std' => '30',
				'description' => __( 'Select gap between grid elements.', 'js_composer' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			)
		) );

	}

	if( function_exists( 'vc_remove_param' ) ){
		vc_remove_param( 'vc_cta_button2', 'h2' );
		vc_remove_param( 'vc_cta_button2', 'content' );
		vc_remove_param( 'vc_cta_button2', 'btn_style' );
		vc_remove_param( 'vc_cta_button2', 'color' );
		vc_remove_param( 'vc_cta_button2', 'size' );
		vc_remove_param( 'vc_cta_button2', 'css_animation' );
	}

    if( function_exists( 'vc_remove_element' ) ){
        vc_remove_element( "vc_cta_button" );
        vc_remove_element( "vc_posts_slider" );
        vc_remove_element( "vc_icon" );
        vc_remove_element( "vc_pinterest" );
        vc_remove_element( "vc_googleplus" );
        vc_remove_element( "vc_facebook" );
        vc_remove_element( "vc_tweetmeme" );
    }

}

if ( function_exists( 'vc_map' ) ) {
	add_action( 'init', 'vc_stm_elements' );
}

function vc_stm_elements(){
	$order_by_values = array(
		'',
		__( 'Date', 'js_composer' ) => 'date',
		__( 'ID', 'js_composer' ) => 'ID',
		__( 'Author', 'js_composer' ) => 'author',
		__( 'Title', 'js_composer' ) => 'title',
		__( 'Modified', 'js_composer' ) => 'modified',
		__( 'Random', 'js_composer' ) => 'rand',
		__( 'Comment count', 'js_composer' ) => 'comment_count',
		__( 'Menu order', 'js_composer' ) => 'menu_order',
	);

	$order_way_values = array(
		'',
		__( 'Descending', 'js_composer' ) => 'DESC',
		__( 'Ascending', 'js_composer' ) => 'ASC',
	);
	vc_map( array(
		'name'        => __( 'STM Teachers', STM_DOMAIN ),
		'base'        => 'stm_experts',
		'icon'        => 'stm_experts',
		'params'      => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => __( 'Section title', STM_DOMAIN ),
				'param_name' => 'experts_title',
				'description' => __( "Title will be shown on the top of section", STM_DOMAIN )
			),
			array(
				'type' => 'number_field',
				'holder' => 'div',
				'heading' => __( 'Number of Teachers to output', STM_DOMAIN ),
				'param_name' => 'experts_max_num',
				'description' => __( "Fill field with number only", STM_DOMAIN )
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Style', STM_DOMAIN ),
				'param_name' => 'experts_output_style',
				'value'      => array(
					'Carousel' => 'experts_carousel',
					'List' => 'experts_list'
				)
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'All teachers', STM_DOMAIN ),
				'param_name' => 'experts_all',
				'value'      => array(
					'Show link to all Teachers' => 'yes',
					'Hide link to all Teachers' => 'no'
				)
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'heading' => __( 'Number of Teachers per row', STM_DOMAIN ),
				'param_name' => 'expert_slides_per_row',
				'std' => 2,
				'value'      => array(
					'1' => 1,
					'2' => 2,
				)
			),
		)
	) );
	
	vc_map( array(
		'name'        => __( 'STM Teacher Details', STM_DOMAIN ),
		'base'        => 'stm_teacher_detail',
		'icon'        => 'stm_teacher_detail',
		'category'    => __( 'STM', STM_DOMAIN ),
		'description' => __('Only on expert page', STM_DOMAIN),
		'params'      => array(
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css'
			)
		)
	) );
	
	
	vc_map( array(
		'name'        => __( 'STM Testimonials', STM_DOMAIN ),
		'base'        => 'stm_testimonials',
		'icon'        => 'stm_testimonials',
		'params'      => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => __( 'Section title', STM_DOMAIN ),
				'param_name' => 'testimonials_title',
				'description' => __( "Title will be shown on the top of section", STM_DOMAIN )
			),
			array(
				'type' => 'number_field',
				'heading' => __( 'Number of testimonials to output', STM_DOMAIN ),
				'param_name' => 'testimonials_max_num',
				'description' => __( "Fill field with number only", STM_DOMAIN )
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Text Color', STM_DOMAIN ),
				'param_name' => 'testimonials_text_color',
				'value' => '#aaaaaa',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Number of testimonials per row', STM_DOMAIN ),
				'param_name' => 'testimonials_slides_per_row',
				'std' => 2,
				'value'      => array(
					'1' => 1,
					'2' => 2,
				)
			),
		)
	) );
	
	// Get post types to offer
	$post_list_data = array(
		'Post'	=> 'post',
		'Experts' => 'experts',
		'Testimonials' => 'testimonial'
	);
	
	vc_map( array(
		'name'        => __( 'STM Post List', STM_DOMAIN ),
		'base'        => 'stm_post_list',
		'icon'        => 'stm_post_list',
		'params'      => array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Post Data', STM_DOMAIN ),
				'param_name' => 'post_list_data_source',
				'description' => __( "Choose post type", STM_DOMAIN ),
				'value' => $post_list_data,
			),
			array(
				'type' => 'number_field',
				'heading' => __( 'Number of items to output', STM_DOMAIN ),
				'param_name' => 'post_list_per_page',
				'description' => __( "Fill field with number only", STM_DOMAIN )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Number of items to output per row', STM_DOMAIN ),
				'param_name' => 'post_list_per_row',
				'value' => array(
					'1' => 1,
					'2' => 2,
					'3' => 3,
					'4' => 4,
					'6' => 6,
				),
				'std' => 3,
				'group' => __('List design', STM_DOMAIN),
			),
			array(
				'type' => 'checkbox',
				'heading' => __( 'Show post date', STM_DOMAIN ),
				'param_name' => 'post_list_show_date',
				'group' => __('Item design', STM_DOMAIN),
			),
			array(
				'type' => 'checkbox',
				'heading' => __( 'Show post categories', STM_DOMAIN ),
				'param_name' => 'post_list_show_cats',
				'group' => __('Item design', STM_DOMAIN),
			),
			array(
				'type' => 'checkbox',
				'heading' => __( 'Show post tags', STM_DOMAIN ),
				'param_name' => 'post_list_show_tags',
				'group' => __('Item design', STM_DOMAIN),
			),
			array(
				'type' => 'checkbox',
				'heading' => __( 'Show comments tags', STM_DOMAIN ),
				'param_name' => 'post_list_show_comments',
				'group' => __('Item design', STM_DOMAIN),
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			)
		)
	) );
	
	vc_map( array(
		'name'        => __( 'Icon Box', STM_DOMAIN ),
		'base'        => 'stm_icon_box',
		'icon'        => 'stm_icon_box',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => __( 'Title', STM_DOMAIN ),
				'param_name' => 'title'
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Title Holder', STM_DOMAIN ),
				'param_name' => 'title_holder',
				'value' => array(
					'H1' => 'h1',
					'H2' => 'h2',
					'H3' => 'h3',
					'H4' => 'h4',
					'H5' => 'h5',
				),
				'std' => 'h3'
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Box background color', STM_DOMAIN ),
				'param_name' => 'box_bg_color',
				'description' => 'default - green'
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Box text color', STM_DOMAIN ),
				'param_name' => 'box_text_color',
				'description' => 'Default - white'
			),
			array(
				'type' 				=> 'dropdown',
				'heading' 			=> __( 'Link color style', STM_DOMAIN ),
				'param_name' 		=> 'link_color_style',
				'value'				=> array(
					'Standart' => 'standart',
					'Dark'  => 'dark',
				),
				'description'       => __( 'Enter icon size in px', STM_DOMAIN )
			),
			array(
				'type' 				=> 'iconpicker',
				'heading' 			=> __( 'Icon', STM_DOMAIN ),
				'param_name' 		=> 'icon',
				'value'				=> ''
			),
			array(
				'type' 				=> 'number_field',
				'heading' 			=> __( 'Icon Size', STM_DOMAIN ),
				'param_name' 		=> 'icon_size',
				'value'				=> '60',
				'description'       => __( 'Enter icon size in px', STM_DOMAIN )
			),
			array(
				'type' 				=> 'dropdown',
				'heading' 			=> __( 'Icon Align', STM_DOMAIN ),
				'param_name' 		=> 'icon_align',
				'value'				=> array(
					'Center' => 'center',
					'Left'  => 'left',
					'Right' => 'right'
				),
				'description'       => __( 'Enter icon size in px', STM_DOMAIN )
			),
			array(
				'type' 				=> 'number_field',
				'heading' 			=> __( 'Icon Height', STM_DOMAIN ),
				'param_name' 		=> 'icon_height',
				'value'				=> '65',
				'dependency' => array(
					'element' => 'icon_align',
					'value' => array( 'center' )
				),
				'description'       => __( 'Enter icon height in px', STM_DOMAIN )
			),
			array(
				'type' 				=> 'number_field',
				'heading' 			=> __( 'Icon Width', STM_DOMAIN ),
				'param_name' 		=> 'icon_width',
				'value'				=> '65',
				'dependency' => array(
					'element' => 'icon_align',
					'value' => array( 'left', 'right' )
				),
				'description'       => __( 'Enter icon height in px', STM_DOMAIN )
			),
			array(
				'type' 				=> 'colorpicker',
				'heading' 			=> __( 'Icon Color', STM_DOMAIN ),
				'param_name' 		=> 'icon_color',
				'value' 			=> '#fff',
				'description'		=> 'Default - White'
			),
			array(
				'type' => 'textarea_html',
				'heading' => __( 'Text', STM_DOMAIN ),
				'param_name' => 'content'
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Icon Css', STM_DOMAIN ),
				'param_name' => 'css_icon',
				'group'      => __( 'Icon Design options', STM_DOMAIN )
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			)
		)
	) );
	
	vc_map( array(
		'name'        => __( 'Stats Counter', STM_DOMAIN ),
		'base'        => 'stm_stats_counter',
		'icon'        => 'stm_stats_counter',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => __( 'Title', STM_DOMAIN ),
				'param_name' => 'title'
			),
			array(
				'type' 				=> 'number_field',
				'heading' 			=> __( 'Counter Value', STM_DOMAIN ),
				'param_name' 		=> 'counter_value',
				'value'				=> '1000'
			),
			array(
				'type' 				=> 'textfield',
				'heading' 			=> __( 'Duration', STM_DOMAIN ),
				'param_name' 		=> 'duration',
				'value'				=> '2.5'
			),
			array(
				'type' 				=> 'iconpicker',
				'heading' 			=> __( 'Icon', STM_DOMAIN ),
				'param_name' 		=> 'icon',
				'value'				=> ''
			),
			array(
				'type' 				=> 'textfield',
				'heading' 			=> __( 'Icon Size', STM_DOMAIN ),
				'param_name' 		=> 'icon_size',
				'value'				=> '65',
				'description'       => __( 'Enter icon size in px', STM_DOMAIN )
			),
			array(
				'type' 				=> 'textfield',
				'heading' 			=> __( 'Icon Height', STM_DOMAIN ),
				'param_name' 		=> 'icon_height',
				'value'				=> '90',
				'description'       => __( 'Enter icon height in px', STM_DOMAIN )
			),
			array(
				'type' 				=> 'dropdown',
				'heading' 			=> __( 'Text alignment', STM_DOMAIN ),
				'param_name' 		=> 'icon_text_alignment',
				'value' => array(
					'Center' => 'center',
					'Left' => 'left',
					'Right' => 'right',
				),
				'description'       => __( 'Text alignment in block', STM_DOMAIN )
			),
			array(
				'type' 				=> 'colorpicker',
				'heading' 			=> __( 'Text color', STM_DOMAIN ),
				'param_name' 		=> 'icon_text_color',
				'description'       => __( 'Text color(white - default)', STM_DOMAIN )
			),
			array(
				'type' 				=> 'colorpicker',
				'heading' 			=> __( 'Counter text color', STM_DOMAIN ),
				'param_name' 		=> 'counter_text_color',
				'description'       => __( 'Counter Text color(yellow - default)', STM_DOMAIN )
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			)
		)
	) );
	
	vc_map( array(
		'name'        => __( 'Icon Button', STM_DOMAIN ),
		'base'        => 'stm_icon_button',
		'icon'        => 'stm_icon_button',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type' => 'vc_link',
				'heading' => __( 'Link', STM_DOMAIN ),
				'param_name' => 'link'
			),
			array(
				'type' 				=> 'textfield',
				'heading' 			=> __( 'Link tooltip (title)', STM_DOMAIN ),
				'param_name' 		=> 'link_tooltip',
				'value'				=> ''
			),
			array(
				'type' 				=> 'dropdown',
				'heading' 			=> __( 'Button alignment', STM_DOMAIN ),
				'param_name' 		=> 'btn_align',
				'value' 			=> array(
					'Left' => 'left',
					'Center' => 'center',
					'Right' => 'right'
				),
				'std' => 'left',
			),
			array(
				'type' 				=> 'dropdown',
				'heading' 			=> __( 'Button Size', STM_DOMAIN ),
				'param_name' 		=> 'btn_size',
				'value' 			=> array(
					'Normal' => 'btn-normal-size',
					'Small' => 'btn-sm',
				),
				'std' => 'left',
			),
			array(
				'type' 				=> 'colorpicker',
				'heading' 			=> __( 'Button Text Color', STM_DOMAIN ),
				'param_name' 		=> 'button_color',
				'value'				=> ''
			),
			array(
				'type' 				=> 'colorpicker',
				'heading' 			=> __( 'Button Text Color Hover', STM_DOMAIN ),
				'param_name' 		=> 'button_text_color_hover',
				'value'				=> ''
			),
			array(
				'type' 				=> 'colorpicker',
				'heading' 			=> __( 'Button Background Color', STM_DOMAIN ),
				'param_name' 		=> 'button_bg_color',
				'value'				=> ''
			),
			array(
				'type' 				=> 'colorpicker',
				'heading' 			=> __( 'Button Background Color Hover', STM_DOMAIN ),
				'param_name' 		=> 'button_bg_color_hover',
				'value'				=> ''
			),
			array(
				'type' 				=> 'colorpicker',
				'heading' 			=> __( 'Button Border Color', STM_DOMAIN ),
				'param_name' 		=> 'button_border_color',
				'value'				=> ''
			),
			array(
				'type' 				=> 'colorpicker',
				'heading' 			=> __( 'Button Border Color Hover', STM_DOMAIN ),
				'param_name' 		=> 'button_border_color_hover',
				'value'				=> ''
			),
			array(
				'type' 				=> 'iconpicker',
				'heading' 			=> __( 'Icon', STM_DOMAIN ),
				'param_name' 		=> 'icon',
				'value'				=> ''
			),
			array(
				'type'	 			=> 'dropdown',
				'heading'			=> 'Icon Size',
				'param_name'		=> 'icon_size',
				'value' => array(
					__( '10px', 'js_composer' ) => '10',
					__( '11px', 'js_composer' ) => '11',
					__( '12px', 'js_composer' ) => '12',
					__( '13px', 'js_composer' ) => '13',
					__( '14px', 'js_composer' ) => '14',
					__( '15px', 'js_composer' ) => '15',
					__( '16px', 'js_composer' ) => '16',
					__( '17px', 'js_composer' ) => '17',
					__( '18px', 'js_composer' ) => '18',
					__( '19px', 'js_composer' ) => '19',
					__( '20px', 'js_composer' ) => '20',
				),
				'std' => '16',
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			)
		)
	) );
	
	vc_map( array(
		'name'        => __( 'Colored Separator', STM_DOMAIN ),
		'base'        => 'stm_color_separator',
		'icon'        => 'stm_color_separator',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Separator Color', STM_DOMAIN ),
				'param_name' => 'color'
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			)
		)
	) );
	
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		vc_map( array(
			'name'        => __( 'Product Categories', STM_DOMAIN ),
			'base'        => 'stm_product_categories',
			'icon'        => 'stm_product_categories',
			'category'    => __( 'STM', STM_DOMAIN ),
			'params'      => array(
				array(
					'type' => 'dropdown',
					'heading' => __( 'View type', STM_DOMAIN ),
					'param_name' => 'view_type',
					'value' => array(
						'Carousel' => 'stm_vc_product_cat_carousel',
						'List' => 'stm_vc_product_cat_list',
					),
					'std' => 'stm_vc_product_cat_carousel'
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Carousel Auto Scroll', STM_DOMAIN ),
					'param_name' => 'auto',
				),
				array(
					'type' => 'number_field',
					'heading' => __( 'Number of items to output', STM_DOMAIN ),
					'param_name' => 'number',
					'description' => 'Leave field empty to display all categories',
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Number of items per row', STM_DOMAIN ),
					'param_name' => 'per_row',
					'value' => array(
						'6' => 6,
						'4' => 4,
						'3' => 3,
						'2' => 2,
						'1' => 1
					),
					'std' => 6
				),
				array(
					'type' => 'colorpicker',
					'heading' => __( 'Box text Color', STM_DOMAIN ),
					'param_name' => 'box_text_color',
					'group' => 'Item Options'
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Text box Align', STM_DOMAIN ),
					'param_name' => 'text_align',
					'value' => array(
						'Center' => 'center',
						'Left' => 'left',
						'Right' => 'right',
					),
					'group' => 'Item Options'
				),
				array(
					'type' => 'number_field',
					'heading' => __( 'Icon size', STM_DOMAIN ),
					'param_name' => 'icon_size',
					'group' => 'Item Options',
					'value' => '60',
					'description' => 'If category has font icon chosen - size will be apllied',
				),
				array(
					'type' => 'number_field',
					'heading' => __( 'Icon height', STM_DOMAIN ),
					'param_name' => 'icon_height',
					'group' => 'Item Options',
					'value' => '69',
					'description' => 'If category has font icon chosen - height will be apllied',
				),
				array(
					'type'       => 'css_editor',
					'heading'    => __( 'Css', STM_DOMAIN ),
					'param_name' => 'css',
					'group'      => __( 'Design options', STM_DOMAIN )
				)
			)
		) );
		
		
		$experts = array(
		    'Choose expert for course' => 'no_expert',
	    );
		
		$experts_args = array(
			'post_type'		=> 'teachers',
			'post_status' => 'publish',
			'posts_per_page'=> -1,
		);
		
		$experts_query = new WP_Query($experts_args);
		
		foreach($experts_query->posts as $expert){
			$experts[$expert->post_title] = $expert->ID;
		}
		
		vc_map( array(
			'name'        => __( 'Products List (All, featured, teacher courses)', STM_DOMAIN ),
			'base'        => 'stm_featured_products',
			'icon'        => 'stm_color_separator',
			'category'    => __( 'STM', STM_DOMAIN ),
			'params'      => array(
				array(
					'type' => 'dropdown',
					'heading' => __( 'Meta sorting key', STM_DOMAIN ),
					'param_name' => 'meta_key',
					'value' => array(
						'All' => 'all',
						'Featured' => '_featured',
						'Expert' => 'expert',
					),
					'std' => 'all'
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Choose expert', STM_DOMAIN ),
					'param_name' => 'expert_id',
					'value' => $experts,
					'std' => 'no_expert',
					'dependency' => array(
						'element' => 'meta_key',
						'value' => array( 'expert' )
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'View type', STM_DOMAIN ),
					'param_name' => 'view_type',
					'value' => array(
						'Carousel' => 'featured_products_carousel',
						'List' => 'featured_products_list',
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Carousel Auto Scroll', STM_DOMAIN ),
					'param_name' => 'auto',
				),
				array(
					'type' => 'number_field',
					'heading' => __( 'Number of items to output', STM_DOMAIN ),
					'param_name' => 'per_page',
					'description' => __( 'Leave empty to display all', STM_DOMAIN ),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Number of items per row', STM_DOMAIN ),
					'param_name' => 'per_row',
					'value' => array(
						'4' => 4,
						'3' => 3,
						'2' => 2,
						'1' => 1
					),
					'std' => 4
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order', STM_DOMAIN ),
					'param_name' => 'order',
					'value' => array(
						'Descending' => 'DESC',
						'Ascending' => 'ASC',
					),
					'std' => 'DESC'
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order by', STM_DOMAIN ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'std' => 'date'
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Dont Show price', STM_DOMAIN ),
					'param_name' => 'hide_price',
					'group' => 'Item Options'
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Don\'t Show rating', STM_DOMAIN ),
					'param_name' => 'hide_rating',
					'group' => 'Item Options'
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Don\'t Show comments number', STM_DOMAIN ),
					'param_name' => 'hide_comments',
					'group' => 'Item Options'
				),
				array(
					'type' => 'colorpicker',
					'heading' => __( 'Price Badge background color', STM_DOMAIN ),
					'param_name' => 'price_bg',
					'group' => 'Item Options'
				),
				array(
					'type' => 'colorpicker',
					'heading' => __( 'Price Badge (Free) background color', STM_DOMAIN ),
					'param_name' => 'free_price_bg',
					'group' => 'Item Options'
				),
				array(
					'type'       => 'css_editor',
					'heading'    => __( 'Css', STM_DOMAIN ),
					'param_name' => 'css',
					'group'      => __( 'Design options', STM_DOMAIN )
				)
			)
		) );
	}
	
	vc_map( array(
		'name'        => __( 'Mailchimp', STM_DOMAIN ),
		'base'        => 'stm_mailchimp',
		'icon'        => 'stm_mailchimp',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Title', STM_DOMAIN ),
				'param_name' => 'title'
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			)
		)
	) );
	
	vc_map( array(
		'name'        => __( 'Countdown', STM_DOMAIN ),
		'base'        => 'stm_countdown',
		'icon'        => 'stm_countdown',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type' => 'stm_datepicker_vc',
				'heading' => __( 'Count to date', STM_DOMAIN ),
				'param_name' => 'datepicker',
				'holder' => 'div'
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Labels color', STM_DOMAIN ),
				'param_name' => 'label_color',
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			)
		)
	) );
	
	
	
	
	if ( in_array( 'contact-form-7/wp-contact-form-7.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		$args = array('post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1);
		$available_cf7 = array();
		if( $cf7Forms = get_posts( $args ) ){
			foreach($cf7Forms as $cf7Form){
				$available_cf7[$cf7Form->post_title] = $cf7Form->ID;
			};
		} else {
			$available_cf7['No CF7 forms found'] = 'none';
		};
		vc_map( array(
			'name'        => __( 'Sign Up Now', STM_DOMAIN ),
			'base'        => 'stm_sign_up_now',
			'icon'        => 'icon-wpb-contactform7',
			'category'    => __( 'STM', STM_DOMAIN ),
			'params'      => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Title', STM_DOMAIN ),
					'param_name' => 'title'
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Choose form', STM_DOMAIN ),
					'param_name' => 'form',
					'value' => $available_cf7,
				),
				array(
					'type'       => 'css_editor',
					'heading'    => __( 'Css', STM_DOMAIN ),
					'param_name' => 'css',
					'group'      => __( 'Design options', STM_DOMAIN )
				)
			)
		) );
	}
	
	vc_map( array(
		'name'        => __( 'Post info', STM_DOMAIN ),
		'base'        => 'stm_post_info',
		'icon'        => 'stm_post_info',
		'description' => __('Only on post page', STM_DOMAIN),
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css'
			)
		)
	) );
	
	vc_map( array(
		'name'        => __( 'Post tags', STM_DOMAIN ),
		'base'        => 'stm_post_tags',
		'icon'        => 'stm_post_tags',
		'category'    => __( 'STM', STM_DOMAIN ),
		'description' => __('Only on post page', STM_DOMAIN),
		'params'      => array(
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css'
			)
		)
	) );
	
	vc_map( array(
		'name'        => __( 'Share', STM_DOMAIN ),
		'base'        => 'stm_share',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Title', STM_DOMAIN ),
				'param_name' => 'title',
				'value'      => __( 'Share:', STM_DOMAIN )
			),
			array(
				'type'       => 'textarea_raw_html',
				'heading'    => __( 'Code', STM_DOMAIN ),
				'param_name' => 'code',
				'value'      => "<span class='st_facebook_large' displayText=''></span>
<span class='st_twitter_large' displayText=''></span>
<span class='st_googleplus_large' displayText=''></span>"
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group' => __( 'Design options', STM_DOMAIN )
			)
		)
	) );
	
	vc_map( array(
		'name'        => __( 'Multiply separator', STM_DOMAIN ),
		'base'        => 'stm_multy_separator',
		'icon'        => 'stm_multy_separator',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css'
			)
		)
	) );
	
	vc_map( array(
		'name'        => __( 'Post author', STM_DOMAIN ),
		'base'        => 'stm_post_author',
		'icon'        => 'stm_post_author',
		'description' => __('Only on post page', STM_DOMAIN),
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css'
			)
		)
	) );
	
	vc_map( array(
		'name'        => __( 'Post comments', STM_DOMAIN ),
		'base'        => 'stm_post_comments',
		'icon'        => 'stm_post_comments',
		'description' => __('Only on post page', STM_DOMAIN),
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css'
			)
		)
	) );
	
	vc_map( array(
		'name'        => __( 'Course Lessons', STM_DOMAIN ),
		'base'        => 'stm_course_lessons',
		'as_parent'   => array('only' => 'stm_course_lesson'),
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Section Title', STM_DOMAIN ),
				'param_name' => 'title',
				'holder'	=> 'div'
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group'      => __( 'Design options', STM_DOMAIN )
			)
		),
		'js_view' => 'VcColumnView'
	) );
	
	vc_map( array(
		'name'        => __( 'Lesson', STM_DOMAIN ),
		'base'        => 'stm_course_lesson',
		'as_child' => array('only' => 'stm_course_lessons'),
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Lesson title', STM_DOMAIN ),
				'param_name' => 'title',
				'holder'	=> 'div'
			),
			array(
				'type'	 => 'checkbox',
				'heading' => __('Private', STM_DOMAIN),
				'param_name' => 'private_lesson',
			),
			array(
				'type' 				=> 'iconpicker',
				'heading' 			=> __( 'Icon', STM_DOMAIN ),
				'param_name' 		=> 'icon',
				'value'				=> ''
			),
			array(
				'type'	=> 'textarea_html',
				'param_name' => 'content',
				'holder'	=> 'div',
				'group'	=> 'Tab Text'
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Lesson badge', STM_DOMAIN ),
				'param_name' => 'badge',
				'value' => array(
					'Choose Badge'	=> 'no_badge',
					'Test'		=> 'test',
					'Video'		=> 'video',
					'Exam'		=> 'exam',
					'Quiz'		=> 'quiz',
					'Lecture'   => 'lecture',
					'Seminar'	=> 'seminar',
					'Free'		=> 'free',
					'Practice'  => 'practice',
					'Exercise'  => 'exercise',
					'Activity'  => 'activity',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Preview video', STM_DOMAIN ),
				'description' => __('This video will be opened in popup by clicking "Preview" button (just insert link to the video)', STM_DOMAIN),
				'param_name' => 'preview_video',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Private lesson content placeholder', STM_DOMAIN ),
				'description' => __('You can change standart placeholder to your custom text', STM_DOMAIN),
				'param_name' => 'private_placeholder',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Lesson meta', STM_DOMAIN ),
				'param_name' => 'meta',
				'holder'	=> 'div',
				'group' => 'Lesson meta',
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Lesson Icon', STM_DOMAIN ),
				'param_name' => 'meta_icon',
				'group' => 'Lesson meta',
			),
		)
	) );
	
	vc_map( array(
		'name'        => __( 'Pricing Plan', STM_DOMAIN ),
		'base'        => 'stm_pricing_plan',
		'icon'        => 'stm_pricing_plan',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Plan title', STM_DOMAIN ),
				'param_name' => 'title',
				'holder'	=> 'div'
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Plan Color', STM_DOMAIN ),
				'param_name' => 'color',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Plan price', STM_DOMAIN ),
				'param_name' => 'price',
				'holder'	=> 'div'
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Plan payment period', STM_DOMAIN ),
				'param_name' => 'period',
				'holder'	=> 'div'
			),
			array(
				'type' => 'textarea_html',
				'heading' => __( 'Plan Text', STM_DOMAIN ),
				'param_name' => 'content',
				'holder'	=> 'div'
			),
			array(
				'type' => 'vc_link',
				'heading' => __( 'Plan Button', STM_DOMAIN ),
				'param_name' => 'button',
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group' => __('Design Options', STM_DOMAIN),
			)
		)
	) );
	
	vc_map( array(
		'name'        => __( 'Contact', STM_DOMAIN ),
		'base'        => 'stm_contact',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Name', STM_DOMAIN ),
				'param_name' => 'name'
			),
			array(
				'type'       => 'attach_image',
				'heading'    => __( 'Image', STM_DOMAIN ),
				'param_name' => 'image'
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image Size', STM_DOMAIN ),
				'param_name' => 'image_size',
				'description' => __( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "projects_gallery" size.', STM_DOMAIN )
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Job', STM_DOMAIN ),
				'param_name' => 'job'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Phone', STM_DOMAIN ),
				'param_name' => 'phone'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Email', STM_DOMAIN ),
				'param_name' => 'email'
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Skype', STM_DOMAIN ),
				'param_name' => 'skype'
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group' => __( 'Design options', STM_DOMAIN )
			)
		)
	) );
	
	vc_map( array(
		'name'        => __( 'Gallery Grid', STM_DOMAIN ),
		'base'        => 'stm_gallery_grid',
		'icon'        => 'stm_gallery_grid',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Title', STM_DOMAIN ),
				'param_name' => 'title'
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Masonry Mode', STM_DOMAIN ),
				'param_name' => 'masonry'
			),
			array(
				'type'       => 'number_field',
				'heading'    => __( 'Gallery per page', STM_DOMAIN ),
				'param_name' => 'per_page'
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css'
			)
		)
	) );
	
	vc_map( array(
		'name'        => __( 'Certificate', STM_DOMAIN ),
		'base'        => 'stm_certificate',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Certificate name', STM_DOMAIN ),
				'param_name' => 'title'
			),
			array(
				'type'       => 'attach_image',
				'heading'    => __( 'Certificate Print', STM_DOMAIN ),
				'param_name' => 'image'
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css'
			)
		)
	) );
	
	vc_map( array(
		'name'        => __( 'Event info', STM_DOMAIN ),
		'base'        => 'stm_event_info',
		'icon'        => 'stm_event_info',
		'description' => __('Only on event page', STM_DOMAIN),
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css'
			)
		)
	) );
	
	vc_map( array(
		'name'        => __( 'Teachers Grid', STM_DOMAIN ),
		'base'        => 'stm_teachers_grid',
		'icon'        => 'stm_teachers_grid',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'number_field',
				'heading'    => __( 'Teacher per page', STM_DOMAIN ),
				'param_name' => 'per_page',
				'default'	 => '8',
				
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css'
			)
		)
	) );
	
	vc_map( array(
		'name'        => __( 'Teachers Grid', STM_DOMAIN ),
		'base'        => 'stm_teachers_grid',
		'icon'        => 'stm_teachers_grid',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'number_field',
				'heading'    => __( 'Teacher per page', STM_DOMAIN ),
				'param_name' => 'per_page',
				'default'	 => '8',
				
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css'
			)
		)
	) );
	
	vc_map( array(
		'name'        => __( 'Events Grid', STM_DOMAIN ),
		'base'        => 'stm_events_grid',
		'icon'        => 'stm_events_grid',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'number_field',
				'heading'    => __( 'Events per page', STM_DOMAIN ),
				'param_name' => 'per_page',
				'default'	 => '8',
				
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css'
			)
		)
	) );
	
	$stm_sidebars_array = get_posts( array( 'post_type' => 'sidebar', 'posts_per_page' => -1 ) );
	$stm_sidebars = array( __( 'Select', STM_DOMAIN ) => 0 );
	if( $stm_sidebars_array ){
		foreach( $stm_sidebars_array as $val ){
			$stm_sidebars[ get_the_title( $val ) ] = $val->ID;
		}
	}

	vc_map( array(
		'name'        => __( 'STM Sidebar', STM_DOMAIN ),
		'base'        => 'stm_sidebar',
		'category'    => __( 'STM', STM_DOMAIN ),
		'params'      => array(
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Code', STM_DOMAIN ),
				'param_name' => 'sidebar',
				'value'      => $stm_sidebars
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Sidebar position', STM_DOMAIN ),
				'param_name' => 'sidebar_position',
				'value'      => array(
					'Right'  => 'right',
					'Left'   => 'left'
				)
			),
			array(
				'type'       => 'css_editor',
				'heading'    => __( 'Css', STM_DOMAIN ),
				'param_name' => 'css',
				'group' => __( 'Design options', STM_DOMAIN )
			)
		)
	) );

}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Stm_Course_Lessons extends WPBakeryShortCodesContainer {
	}
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_Stm_Experts extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Teacher_Detail extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Testimonials extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Post_List extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Icon_Box extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Stats_Counter extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Icon_Button extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Product_Categories extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Color_Separator extends WPBakeryShortCode {
	}
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		class WPBakeryShortCode_Stm_Featured_Products extends WPBakeryShortCode {
		}
	}
	class WPBakeryShortCode_Stm_Mailchimp extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Countdown extends WPBakeryShortCode {
	}
	if ( in_array( 'contact-form-7/wp-contact-form-7.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		class WPBakeryShortCode_Stm_Sign_Up_Now extends WPBakeryShortCode {
		}
	}
	class WPBakeryShortCode_Stm_Post_Info extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Post_Tags extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Share extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Multy_Separator extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Post_Author extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Post_Comments extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Course_Lesson extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Pricing_Plan extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Contact extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Gallery_Grid extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Certificate extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Event_Info extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Teachers_Grid extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Events_Grid extends WPBakeryShortCode {
	}
	class WPBakeryShortCode_Stm_Sidebar extends WPBakeryShortCode {
	}
}

add_filter( 'vc_iconpicker-type-fontawesome', 'stm_construct_icons' );

function stm_construct_icons( $fonts ){
	
	$fonts['Master Study icons'] = array(
		array( "fa-icon-stm_icon_teacher" => __( "STM Teacher", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_category" => __( "STM Category", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_film-play" => __( "STM Film play", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_clock" => __( "STM Clock", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_bullhorn" => __( "STM Bullhorn", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_mail-o" => __( "STM Mail-o", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_phone-o" => __( "STM Phone-o", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_pin-o" => __( "STM Pin-o", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_skype-o" => __( "STM Skype-o", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_book" => __( "STM Book", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_alarm" => __( "STM Alarm", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_briefcase" => __( "STM Briefcase", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_diamond" => __( "STM Diamond", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_earth" => __( "STM Earth", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_graduation-hat" => __( "STM Graduation Hat", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_license" => __( "STM License", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_users" => __( "STM Users", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_brain" => __( "STM Brain", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_handshake" => __( "STM Handshake", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_net" => __( "STM Net", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_linkedin" => __( "STM LinkedIn", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_pin" => __( "STM Pin", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_market_research" => __( "STM Market Researches", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_medal_one" => __( "STM Champion Medal", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_mountain_biking" => __( "STM Bike Riding", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_paint_palette" => __( "STM Paint Palette", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_phone" => __( "STM Phone", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_fax" => __( "STM Fax", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_seo_monitoring" => __( "STM SEO monitoring", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_seo_performance_up" => __( "STM SEO performance up", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_user" => __( "STM User", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_guitar" => __( "STM Guitar", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_add_user" => __( "STM Add User", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_aps" => __( "STM Adope PhotoShop", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_chevron_right" => __( "STM Chevrone Right", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_chevron_left" => __( "STM Chevrone Left", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_viral_marketing" => __( "STM Viral Marketing", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_yoga" => __( "STM Yoga", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_youtube_play" => __( "STM Youtube Play", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_book_black" => __( "STM Book solid", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_book_stack" => __( "STM Book stack", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_ecommerce_cart" => __( "STM Ecommerce cart", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_certificate" => __( "STM Certificate", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_climbing" => __( "STM Mountain Climbing", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_comment_o" => __( "STM Comment solid", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_drawing_tool_circle" => __( "STM Circle Drawer", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_diploma_paper" => __( "STM Diploma Paper", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_drawing_tool_point" => __( "STM Point Drawer", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_dribble" => __( "STM Dribble", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_doc_edit" => __( "STM Document Edit", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_users_group" => __( "STM Users group", STM_DOMAIN ) ),
		array( "fa-icon-stm_icon_ms_logo" => __( "STM Small logo", STM_DOMAIN ) ),
	);

    return $fonts;
}

add_filter( 'vc_load_default_templates', 'vc_right_sidebar_template' );

function vc_right_sidebar_template( $data ) {
	$template               = array();
	$template['name']       = __( 'Content with Right sidebar', STM_DOMAIN );
	$template['content']    = <<<CONTENT
        [vc_row full_width="" parallax="" parallax_image=""][vc_column width="3/4" el_class="vc_sidebar_position_right" offset="vc_col-lg-9 vc_col-md-9 vc_col-sm-12"][/vc_column][vc_column width="1/4" offset="vc_hidden-sm vc_hidden-xs"][vc_widget_sidebar sidebar_id="default" el_class="sidebar-area-right sidebar-area"][/vc_column][/vc_row]
CONTENT;

	array_unshift( $data, $template );
	return $data;
}

add_filter( 'vc_load_default_templates', 'vc_left_sidebar_template' );

function vc_left_sidebar_template( $data ) {
	$template               = array();
	$template['name']       = __( 'Content with left sidebar', STM_DOMAIN );
	$template['content']    = <<<CONTENT
        [vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/4" offset="vc_hidden-sm vc_hidden-xs"][vc_widget_sidebar sidebar_id="default" el_class="sidebar-area-left sidebar-area"][/vc_column][vc_column width="3/4" el_class="vc_sidebar_position_left" offset="vc_col-lg-9 vc_col-md-9 vc_col-sm-12"][/vc_column][/vc_row]
CONTENT;

	array_unshift( $data, $template );
	return $data;
}


// Add number field
add_shortcode_param( 'number_field', 'number_field_vc_st' );
function number_field_vc_st( $settings, $value ) {
	return '<div class="stm_number_field_block">'
		.'<input type="number" name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
		esc_attr( $settings['param_name'] ) . ' ' .
		esc_attr( $settings['type'] ) . '_field" type="text" value="' . esc_attr( $value ) . '" />' .
		'</div>'; // This is html markup that will be outputted in content elements edit form
}

// Datepicker field

add_shortcode_param( 'stm_datepicker_vc', 'stm_datepicker_vc_st', get_template_directory_uri().'/inc/vc_extend/jquery.stmdatetimepicker.js' );
function stm_datepicker_vc_st( $settings, $value ) {
	return '<div class="stm_datepicker_vc_field">'
		.'<input type="text" name="' . esc_attr( $settings['param_name'] ) . '" class="stm_datepicker_vc wpb_vc_param_value wpb-textinput ' .
		esc_attr( $settings['param_name'] ) . ' ' .
		esc_attr( $settings['type'] ) . '_field" type="text" value="' . esc_attr( $value ) . '" />' .
		'</div>';
}