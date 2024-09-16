<?php

 if( !class_exists('ContentOptimizer') ){
class ContentOptimizer{
	public function run(){
		add_action( 'widgets_init', array( $this,'registerWidget') );
		add_action( 'init', array( $this, 'setupTaxonomy' ) );
		include_once( COPTIMIZER_PATH.'/library/Content.php' );
		if( !is_admin() ){
			$optimizeContent=new Optimizer_Content();
			$arrayOptions=get_option( $optimizeContent->_optionName );
			if( $arrayOptions !== false ){
				$arrayOptions=json_decode($arrayOptions, true);
				$_linkTail=(isset($_SERVER['HTTPS'])?'https://':'http://').( $_SERVER['HTTP_HOST']|$_SERVER['SERVER_NAME'] ).$_SERVER['REDIRECT_URL'].(( !empty( $_SERVER['QUERY_STRING'] ) )?('?'.$_SERVER['QUERY_STRING']):'' );
				if( isset( $arrayOptions[$_linkTail] ) ){
					header( 'Location: '.$arrayOptions[$_linkTail], true, 307 );
					exit;
				}
			}
		}
		add_action('admin_menu',array($this,'registerMenu'));
		add_shortcode( 'tooltip', array($this,'addTooltip') );
		if( !is_admin() || ( is_admin() && isset($_GET['page']) && $_GET['page']!='contentoptimizer' && $_GET['page']!='manage-tooltips' ) ){
			return;
		}
		
		add_filter('wp_default_editor', create_function('', 'return "tinymce";'));
		add_filter( 'mce_buttons_3', array( $this, 'wpEditorFontsizeFilter' ) );
		
		add_action('admin_enqueue_scripts',array($this,'initialize'));
		add_action( 'wp_ajax_getcontents', array(&$this,'getContents') );
	}

	function wpEditorFontsizeFilter( $options ){
		array_shift( $options );
		array_unshift( $options, 'fontselect');
		array_unshift( $options, 'fontsizeselect');
		array_unshift( $options, 'formatselect');
		return $options;
	}

	public function setupTaxonomy(){
		register_taxonomy( 'related_keywords', array( 'post', 'page', 'attachment' ), array(
			'hierarchical' => FALSE,
			'labels' => array(
				'name' => __( 'Related Keywords' ),
				'singular_name' => __( 'Related Keywords' ),
				'search_items' => __( 'Search Related Keywords' ),
				'all_items' => __( 'All Related Keywords' ),
				'parent_item' => __( 'Parent Related Keywords' ),
				'parent_item_colon' => __( 'Parent Related Keywords:' ),
				'edit_item' => __( 'Edit Related Keyword' ), 
				'update_item' => __( 'Update Related Keyword' ),
				'add_new_item' => __( 'Add New Related Keyword' ),
				'new_item_name' => __( 'New Related Keyword Name' ),
				'menu_name' => __( 'Related Keywords' ),
			),
			'show_ui' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'rewrite' => true,
		));
	}

	public function registerWidget(){
		include_once( COPTIMIZER_PATH.'/library/Widget.php' );
		register_widget( 'Optimized_Posts' );
		include_once( COPTIMIZER_PATH.'/library/RelatedPosts.php' );
		register_widget( 'Related_Posts' );
	}

	public function initialize(){
		wp_enqueue_script('mootools', COPTIMIZER_URL.'skin/_js/mootools.js', false, '1.4.1');
		wp_enqueue_script('validator', COPTIMIZER_URL.'skin/_js/validator/validator.js', false, '0.1');
		wp_enqueue_script('post');
		wp_enqueue_script( 'iris', '/wp-admin/js/iris.min.js', array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );
		wp_enqueue_script( 'wp-color-picker', "/wp-admin/js/color-picker.js", array( 'iris' ), false, 1 );
		wp_enqueue_style('monetizer_plugin_clone_css', COPTIMIZER_URL.'skin/_css/plugin.css');
		wp_enqueue_style('monetizer_validator', COPTIMIZER_URL.'skin/_js/validator/style.css');
		wp_enqueue_style('colors');
		wp_enqueue_style( 'wp-color-picker' );
	}
	
	public function hex2rgb( $hex ) {
		$hex = str_replace("#", "", $hex);
		if ( strlen($hex) == 3 ){
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		}else{
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		$rgb = array($r, $g, $b);
		return $rgb;
	}
	
	public function addTooltip( $atts, $value='' ){
		if( isset( $atts['type'] ) ){
			if( $atts['type'] == 'css' ){
				return '<style type="text/css">'.html_entity_decode( $atts['html'], ENT_QUOTES ).'</style>';
			}
			if( $atts['type'] == 'box' ){
				$_background=$this->hex2rgb( $atts['box_background_color'] );
				return '<div id="'.$atts['id'].'" style="'.
					'position: absolute;'.
					'width: '.( !isset( $atts['box_flg_width'] ) ? $atts['box_width'].'px' : 'auto' ).';'.
					'left: 0px;'.
					'top: 0px;'.
					'z-index: 999999;'.
					'display: none;'.
					'background-color:rgba( '.$_background[0].','.$_background[1].','.$_background[2].','.$atts['box_opacity'].');'.
					'border: '.$atts['box_border_width'].'px solid '.$atts['box_border_color'].';'.
					'border-radius: '.$atts['box_border_radius'].'px;'.
					'">'.
						'<div style="margin: '.$atts['box_padding'].'px;">'.
							html_entity_decode( $atts['html'], ENT_SUBSTITUTE | ENT_QUOTES, 'UTF-8' ).
						'</div>'.
						'<a href="" style="'.
						'width: 16px;'.
						'height: 16px;'.
						'line-height: 16px;'.
						'position: absolute;'.
						'right: 5px;'.
						'top: 2px;'.
						'text-decoration: none;'.
						'text-align: right;'.
						'opacity: 0.6;'.
						'color: #444;'.
						'font-style: normal;'.
						'font-weight: bold;'.
						'font-size: 16px;'.
						'font-family: Arial, monospace;'.
						'cursor: pointer;" id="c'.$atts['id'].'" >×</a>'.
					'</div>'.
					'<script type="text/javascript">
var indiv_'.$atts['id'].'=false, intip_'.$atts['id'].'=false;
var close_'.$atts['id'].'=function(){
	if( indiv_'.$atts['id'].' === false && intip_'.$atts['id'].' === false ){
		document.getElementById("'.$atts['id'].'").style.display="none";
	}
}
var divBlock;
var selectedTooltip;
var div_'.$atts['id'].' = document.getElementById("'.$atts['id'].'");
var tip_'.$atts['id'].' = document.getElementsByClassName("t'.$atts['id'].'");
var x_'.$atts['id'].' = document.getElementById("c'.$atts['id'].'");
div_'.$atts['id'].'.onmouseenter = function() {
	indiv_'.$atts['id'].'=true;
};
div_'.$atts['id'].'.onmouseleave = function() {
	indiv_'.$atts['id'].'=false;
	setTimeout( close_'.$atts['id'].', 10 );
};
for (var i=0; i<tip_'.$atts['id'].'.length; i++){
	tip_'.$atts['id'].'[i].onmouseenter = function() {
		var divBlock=document.getElementById("'.$atts['id'].'");
		divBlock.style.display="inline";
		divBlock.style.position="fixed";
		selectedTooltip=this;
		var rect=this.getBoundingClientRect();
		userPage = document.compatMode=="CSS1Compat" ? document.documentElement : document.body;
		var divBlockRec=divBlock.getBoundingClientRect();
		if( rect.bottom+divBlockRec.height > userPage.clientHeight ) {
			divBlock.style.top=(rect.top-divBlockRec.height)+"px";
		}else{
			divBlock.style.top=(rect.bottom)+"px";
		}
		if( rect.left+rect.width/2-divBlockRec.width/2 < 0 ) {
			divBlock.style.left="0px";
		}else if( rect.left+rect.width/2+divBlockRec.width/2 > userPage.clientWidth ){
			divBlock.style.left=(userPage.clientWidth-divBlockRec.width)+"px";
		}else{
			divBlock.style.left=(rect.left+rect.width/2-divBlockRec.width/2)+"px";
		}
		intip_'.$atts['id'].'=true;
	}
	tip_'.$atts['id'].'[i].onmouseleave = function() {
		intip_'.$atts['id'].'=false;
		setTimeout( close_'.$atts['id'].', 10 );
	}
	tip_'.$atts['id'].'[i].click = function() {
		return false;
	}
}
x_'.$atts['id'].'.onclick = function() {
	intip_'.$atts['id'].'=false;
	indiv_'.$atts['id'].'=false;
	document.getElementById("'.$atts['id'].'").style.display="none";
	return false;
}
window.onscroll = function() {
	if( indiv_'.$atts['id'].' != false || intip_'.$atts['id'].' != false ){
		divBlock=document.getElementById("'.$atts['id'].'");
		divBlock.style.display="inline";
		divBlock.style.position="fixed";
		var rect=selectedTooltip.getBoundingClientRect();
		userPage = document.compatMode=="CSS1Compat" ? document.documentElement : document.body;
		var divBlockRec=divBlock.getBoundingClientRect();
		if( rect.bottom+divBlockRec.height > userPage.clientHeight ) {
			divBlock.style.top=(rect.top-divBlockRec.height)+"px";
		}else{
			divBlock.style.top=(rect.bottom)+\'px\';
		}
	}
}
</script>'
				;
			}
		}
		$_before='<span class="t'.$atts['id'].'" style="text-decoration:none; display:inline;'.((!empty( $atts ))?'color:'.$atts['keyword_color'].';background-color:'.$atts['background_color'].';':'').'"'.
		'>';
		$_after='</span>';
		return $_before.$value.$_after;
	}

	public function registerMenu(){
		add_menu_page( 'SEO Bot', 'SEO Bot', 'activate_plugins', 'contentoptimizer', array($this,'optimizeContent'), COPTIMIZER_URL.'skin/logo_s.png' );
		add_submenu_page( 'contentoptimizer', 'Optimize Content', 'Optimize Content', 'activate_plugins', 'contentoptimizer' );
		add_submenu_page( 'contentoptimizer', 'Manage Tooltips', 'Manage Tooltips', 'activate_plugins', 'manage-tooltips', array($this,'manageTooltips') );
	}

	public function optimizeContent(){
		include_once( COPTIMIZER_PATH.'/library/Content.php' );
		$optimizeContent=new Optimizer_Content();
		$optimizeContent->optimizeContent();
	}

	public function manageTooltips(){
		include_once( COPTIMIZER_PATH.'/library/Tooltips.php' );
		$tooltips=new Optimizer_Tooltips();
		$tooltips->run();
	}

	public function getContents(){
		include_once( COPTIMIZER_PATH.'/library/Content.php' );
		$optimizeContent=new Optimizer_Content();
		$optimizeContent->getContents();
	}
}
}
?>