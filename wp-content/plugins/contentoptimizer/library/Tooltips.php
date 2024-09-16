<?php

 if( !class_exists('Optimizer_Tooltips') ){
class Optimizer_Tooltips{

	private $_option='optimizer_post_tooltip';
	private $_postId=false;
	private $_metaId=false;
	private $_settings=false;

	public function run(){
		$this->get( $arrList );
		$this->summData( $arrList );
		if( isset( $_GET['action'] ) && $_GET['action'] == 'edit' && isset( $_GET['id'] ) ){
			extract( array( 'settings'=> array( 'tooltip'=>$arrList[$_GET['id']]['settings'] ), 'postIds'=>$arrList[$_GET['id']]['postIds'] ) );
		}
		if( isset( $_POST['action'] ) ){
			$replacedCounter=0;
			if( $_POST['action'] == 'trash' && isset( $_POST['items'] ) && !empty( $_POST['items'] ) ){
				foreach( $_POST['items'] as $_tooltipId ){
					$replacedCounter+=count( $arrList[ $_tooltipId ]['postIds'] );
					$this
						->setSettings( $arrList[ $_tooltipId ]['settings'] )
						->removeTooltip( $arrList[ $_tooltipId ]['postIds'] );
				}
			}
			if( $_POST['action'] == 'Update' && isset( $_POST['settings']['tooltip']['id'] ) ){
				$replacedCounter+=count( $arrList[$_POST['settings']['tooltip']['id']]['postIds'] );
				$this
					->setSettings( $_POST['settings']['tooltip'] )
					->updatePostsTooltips( $arrList[$_POST['settings']['tooltip']['id']]['postIds'] );
				
			}
			$this->setSettings()->postId()->metaId()->get( $arrList );
			$this->summData( $arrList );
		}
		include_once( COPTIMIZER_PATH.'/source/plugin/tooltips.php' );
	}

	public function removeTooltip( $_ids=array() ){
		global $wpdb;
		foreach( $_ids as $metaId=>$postId ){
			$contentPost=get_post( $postId );
			$matches=null;
			$_newContent=$contentPost->post_content;
			if( preg_match_all( '/\[(\[?)(tooltip)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)/s', $contentPost->post_content, $matches, PREG_SET_ORDER ) !== false && !empty( $matches ) ){
				foreach( $matches as $key=>&$_tooltip ){
					$_tooltip['attr']=shortcode_parse_atts( $_tooltip[3] );
					if( $_tooltip['attr']['id'] == $this->_settings['id'] ){
						if( $_tooltip['attr']['type'] == 'css' || $_tooltip['attr']['type'] == 'box' ){
							$_newContent=str_replace( $matches[$key][0], '', $_newContent );
						}
						if( !isset( $_tooltip['attr']['type'] ) ){
							$_newContent=str_replace( $matches[$key][0], $matches[$key][5], $_newContent );
						}
					}
				}
				if( $_newContent != $contentPost->post_content ){
					$this->postId( $contentPost->ID )->delete();
					$wpdb->update( $wpdb->posts, array('post_content'=>$_newContent), array( 'ID'=>$contentPost->ID ) );
				}
			}
		}
	}

	public function updatePostsTooltips( $_ids=array() ){
		global $wpdb;
		foreach( $_ids as $metaId=>$postId ){
			$contentPost=get_post( $postId );
			$matches=null;
			$_newContent=$contentPost->post_content;
			if( preg_match_all( '/\[(\[?)(tooltip)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)/s', $contentPost->post_content, $matches, PREG_SET_ORDER ) !== false && !empty( $matches ) ){
				foreach( $matches as $key=>&$_tooltip ){
					$_before=$_after='';
					$_tooltip['attr']=shortcode_parse_atts( $_tooltip[3] );
					if( $_tooltip['attr']['id'] == $this->_settings['id'] ){
						if( $_tooltip['attr']['type'] == 'css' ){
							$this->updateStylesheet( $_before );
							$_newContent=str_replace( $matches[$key][0], $_before, $_newContent );
						}
						if( !isset( $_tooltip['attr']['type'] ) ){
							$this->updateElement( $_before, $_after );
							$_newContent=str_replace( $matches[$key][0], $_before.$matches[$key][5].$_after, $_newContent );
						}
						if( $_tooltip['attr']['type'] == 'box' ){
							$this->updateBox( $_after );
							$_newContent=str_replace( $matches[$key][0], $_after, $_newContent );
						}
					}
				}
				if( $_newContent != $contentPost->post_content ){
					$this->postId( $contentPost->ID )->metaId( $metaId )->set();
					$wpdb->update( $wpdb->posts, array('post_content'=>$_newContent), array( 'ID'=>$contentPost->ID ) );
				}
			}
		}
	}

	public function postId( $_id=false ){
		$this->_postId=$_id;
		return $this;
	}

	public function metaId( $_id=false ){
		$this->_metaId=$_id;
		return $this;
	}

	public function setSettings( $settings=false ){
		$this->_settings=$settings;
		return $this;
	}

	public function updateElement( &$before, &$after ){
		if( empty( $this->_settings ) ){
			return $this;
		}
		$before='[tooltip id="'.$this->_settings['id'].'"'.
		(( isset( $this->_settings['flg_keyword_colors'] ) )?' keyword_color="'.$this->_settings['keyword_color'].'" background_color="'.$this->_settings['background_color'].'"':'').
		']';
		$after='[/tooltip]';
		return $this;
	}

	public function updateStylesheet( &$before ){
		if( empty( $this->_settings ) ){
			return $this;
		}
		if( !empty( $this->_settings['box_stylesheet'] ) ){
			$before='[tooltip type="css" html="'.htmlentities( $this->_settings['box_stylesheet'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' ).'" /]';
		}
		return $this;
	}

	public function updateBox( &$after ){
		if( empty( $this->_settings ) ){
			return $this;
		}
		$_values='';
		foreach( $this->_settings as $_name=>$_value ){
			if( !in_array( $_name, array( 'box_stylesheet', 'flg_keyword_colors', 'keyword_color', 'background_color', 'keyword', 'replace' ) ) )
				$_values.=' '.$_name.'="'.htmlentities( $_value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' ).'"';
		}
		$after='[tooltip type="box"'.$_values.' /]';
		return $this;
	}

	public function delete(){
		if( empty( $this->_postId ) || empty ( $this->_settings ) ){
			return false;
		}
		return delete_post_meta( $this->_postId, $this->_option, base64_encode( serialize( $this->_settings ) ) );
	}

	public function set(){
		if( empty( $this->_postId ) || empty ( $this->_settings ) ){
			return false;
		}
		if( empty( $this->_metaId ) ){
			add_post_meta( $this->_postId, $this->_option, base64_encode( serialize( $this->_settings ) ) );
		}else{
			global $wpdb;
			return (bool)$wpdb->query( 'UPDATE '.$wpdb->postmeta.' SET `meta_value`=\''.base64_encode( serialize( $this->_settings ) ).'\' WHERE `meta_id`="'.$this->_metaId.'"' );
		}
		return true;
	}

	public function get( &$arrList ){
		global $wpdb;
		if( empty( $this->_postId ) ){
			$arrList=$wpdb->get_results( 'SELECT * FROM '.$wpdb->postmeta.' WHERE `meta_key`="'.$this->_option.'"', ARRAY_A );
		}else{
			$arrList=$wpdb->get_results( 'SELECT * FROM '.$wpdb->postmeta.' WHERE `meta_key`="'.$this->_option.'" AND `post_id`="'.$this->_postId.'"', ARRAY_A );
		}
		foreach( $arrList as &$_item ){
			$_item['meta_value']=unserialize( base64_decode( $_item['meta_value'] ) );
		}
		return true;
	}

	public function summData( &$arrList ){
		$arrNew=array();
		foreach( $arrList as $_item ){
			if( isset( $arrNew[ $_item['meta_value']['id'] ] ) ){
				$arrNew[ $_item['meta_value']['id'] ]['postIds'][ $_item['meta_id'] ]=$_item['post_id'];
			}else{
				$arrNew[ $_item['meta_value']['id'] ]=array(
					'settings'=>$_item['meta_value'],
					'postIds'=>array( 
						$_item['meta_id'] => $_item['post_id']
					),
				);
			}
		}
		$arrList=$arrNew;
		return true;
	}

}
}
?>