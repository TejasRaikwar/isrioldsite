<?php

 if( !class_exists('Optimizer_Content') ){
class Optimizer_Content{

	public function optimizeContent(){
		$settings=$_POST;
		$categories=get_categories('hide_empty=0');
		$pages=$this->getPosts('page');
		if( empty( $settings ) ){
			include_once( COPTIMIZER_PATH.'/source/plugin/content.php' );
		}
		$_onlyTest=false; // test dont modify content in base
		$arraySettings=array();
		if( ( !isset( $settings['settings']['keyword'] ) || empty( $settings['settings']['keyword'] ) ) && isset( $settings['settings']['upgrade_images'] ) ){
			$settings['settings']['keyword']=' ';
		}
		if( isset( $settings['settings']['keyword'] ) && ( !isset( $settings['settings']['replace'] ) || ( isset($settings['settings']['replace']) && empty($settings['settings']['replace']) ) ) ){
			$settings['settings']['replace']=$settings['settings']['keyword'];
		}
		if( ( isset( $settings['settings']['keyword'] ) && isset( $settings['settings']['replace'] ) ) 
			|| ( isset( $settings['settings']['upgrade_images'] ) && in_array( $settings['settings']['upgrade_images'], array( 3,4,6 ) ) ) 
		){
			set_time_limit(0);
			ignore_user_abort(true);
			include_once( COPTIMIZER_PATH.'/library/Tooltips.php' );
			$_tooltip = new Optimizer_Tooltips();
			$settings['settings']['keyword']=(strlen( $settings['settings']['keyword'] )>1)?trim( $settings['settings']['keyword'] ):$settings['settings']['keyword'];
			$_before=$_after=$_beforeLink=$_afterLink=$_beforePost=$_afterPost="";
			if( isset( $settings['settings']['create_tooltip'] ) ){
				$_tooltip
					->setSettings( $settings['settings']['tooltip']+array( 'id'=>md5( $settings['settings']['keyword'].time() ), 'keyword'=>$settings['settings']['keyword'], 'replace'=>$settings['settings']['replace'] ) )
					->updateElement( $_before, $_after );
				unset( $settings['settings']['tooltip']['flg_keyword_colors'], $settings['settings']['tooltip']['keyword_color'], $settings['settings']['tooltip']['background_color'] );
			}
			if( isset( $settings['settings']['decoration'] ) ){
				switch( $settings['settings']['decoration'] ){
					case 1: $_before.='<b>';$_after='</b>'.$_after;break;
					case 2: $_before.='<i>';$_after='</i>'.$_after;break;
					case 3: $_before.='<u>';$_after='</u>'.$_after;break;
				}
			}
			if( isset( $settings['settings']['create_link'] ) ){
				if( isset( $settings['settings']['cloaked_redirect'] ) ){
					$_beforeLink='<a href="'.site_url().$settings['settings']['cloaking_link'].'" rel="nofollow">';
					$this->addCloakedLink( site_url().$settings['settings']['cloaking_link'], $settings['settings']['link'] );
				}else{
					$_beforeLink='<a href="'.$settings['settings']['link'].'">';
				}
				$_afterLink='</a>';
			}
			if( isset( $settings['settings']['create_tooltip'] ) ){
				$_tooltip->updateStylesheet( $_beforePost )->updateBox( $_afterPost );
			}
			$arrList=array();
			$arrTags=array();
			if( isset( $settings['settings']['appearance'] ) ){
				switch ( $settings['settings']['appearance'] ){
					case 0:
						$arrList=$this->getPosts();
						$arrTags=$this->getTags();
					break;
					case 1:
						$arrList=$this->getPosts('page');
					break;
					case 2:
						$arrList=$this->getPosts('post');
					break;
					case 3: 
						$arrList=$this->getPosts('post',$settings['settings']['category']);
					break;
					case 4: 
						if( isset($settings['settings']['page']) && $settings['settings']['page']!='' ) 
							$arrList=$this->getPosts('page',null,$settings['settings']['page']);
					break;
					case 5:
						foreach( $this->getPosts() as $_post ){
							if( get_permalink( $_post['ID'] ) == $settings['settings']['url'] ){
								$arrList=$this->getPosts('post',null,$_post['ID']);
								continue;
							}
						}
					break;
				}
			}else{
				$arrList=$this->getPosts();
				$arrTags=$this->getTags();
			}
			if( !empty( $settings['arrExclude'] ) ){
				foreach( $settings['arrExclude']['url'] as $postId=>$urlExclude ){
					if( !isset( $settings['arrExclude']['name'][$postId] ) ){
						$settings['settings']['exclude'].="\n".$urlExclude;
					}
				}
			}
			if( !empty( $settings['settings']['exclude'] ) ){
				foreach( $arrList as $key=>$_post ){
					foreach( preg_split( '/\\r\\n?|\\n/', $settings['settings']['exclude'] ) as $_url ){
						if( get_permalink( $_post['ID'] ) == trim( $_url ) ){
							unset( $arrList[$key] );
							continue; // foreach
						}
					}
				}
			}
			$settings['replacedCounter']=0;
			global $wpdb;
			
			// TAGS CATEGORIES
			$_arrKeywordPos=array();
			foreach( $arrTags as &$_data ){
				if( in_array( $_data['taxonomy'], array('category','post_tag') ) ){
					$_data['slug']=str_replace( array( '-', '_' ), ' ', $_data['slug'] );
					$keywordCount=substr_count( strtolower( $_data['name'] ), strtolower( $settings['settings']['keyword'] ) );
					$keywordTitleCount=substr_count( strtolower( $_data['slug'] ), strtolower( $settings['settings']['keyword'] ) );
					if( $keywordCount + $keywordTitleCount > 0 ){
						$_arrKeywordPos[ $_data['term_id'] ]=array( 'name' => array(), 'slug' =>array() );
					}
					if( $keywordCount !== 0 ){
						for( $pos=-1; $pos < strlen( $_data['name'] )-strlen( $settings['settings']['keyword'] ); ){
							$pos=strpos( strtolower( $_data['name'] ), strtolower( $settings['settings']['keyword'] ), $pos+1 );
							if( $pos===false ){
								$pos=strlen( $_data['name'] );
								continue;
							}
							if( !ctype_alpha( @$_data['name'][$pos-1] ) 
								&& !ctype_alpha( @$_data['name'][ $pos+strlen( $settings['settings']['keyword'] ) ] ) ){
								$_arrKeywordPos[ $_data['term_id'] ]['name'][ $pos ]=true;
							}
						}
					}
					if( $keywordTitleCount !== 0 ){
						for( $pos=-1; $pos < strlen( $_data['slug'] )-strlen( $settings['settings']['keyword'] ); ){
							$pos=strpos( strtolower( $_data['slug'] ), strtolower( $settings['settings']['keyword'] ), $pos+1 );
							if( $pos===false ){
								$pos=strlen( $_data['slug'] );
								continue;
							}
							if( !ctype_alpha( @$_data['slug'][$pos-1] ) 
								&& !ctype_alpha( @$_data['slug'][ $pos+strlen( $settings['settings']['keyword'] ) ] ) ){
								$_arrKeywordPos[ $_data['term_id'] ]['slug'][ $pos ]=true;
							}
						}
					}
				}
			}
			if( !empty( $_arrKeywordPos ) ){
				foreach( array_filter( $_arrKeywordPos ) as $_dataId=>$_keywordsPositions ){
					foreach( $arrTags as $_data ){
						if( $_data['term_id'] == $_dataId ){
							$data=array(
								'name'=>$_data['name'],
								'slug'=>$_data['slug']
							);
							$_dPosition=0;
							foreach( $_keywordsPositions['name'] as $_position=>$value ){
								$data['name']=$this->replaceTextN( 
									$settings['settings']['keyword'], 
									$settings['settings']['replace'], 
									$data['name'],
									$_dPosition+$_position
									 // without $before & $after 
								);
								$_dPosition+=( strlen( $settings['settings']['replace'] )-strlen( $settings['settings']['keyword'] ) );
							}
							$_dPosition=0;
							foreach( $_keywordsPositions['slug'] as $_position=>$value ){
								$data['slug']=str_replace(' ','-',$this->replaceTextN( 
									$settings['settings']['keyword'], 
									$settings['settings']['replace'], 
									$data['slug'],
									$_dPosition+$_position
									 // without $before & $after 
								) );
								$_dPosition+=( strlen( $settings['settings']['replace'] )-strlen( $settings['settings']['keyword'] ) );
							}
							$settings['replacedCounter']++;
							if( !$_onlyTest ){
								$wpdb->update( $wpdb->terms, $data, array( 'term_id'=>$_data['term_id'] ) );
							}
							break; // foreach - check other post data
						}
					}
				}
			}
			// Update Tags in posts/pages
			if( isset( $settings['settings']['flg_tags'] ) && $settings['settings']['flg_tags'] == 1 && @$settings['settings']['advanced']['update']==2 ){ // update tags for all posts/pages
				$_tagKeywords=explode( ',', $settings['settings']['advanced']['keywords'] );
			}
			// POSTS PAGES
			$_arrKeywordPos=$_arrKeywordInTitlePos=$_arrKeywordBroken=$_arrKeywordInTags=array();
			foreach( $arrList as $_data ){
				if( in_array( $_data['post_type'], array('post','page') ) ){
					$keywordCount=substr_count( strtolower( $_data['post_content'] ), strtolower( $settings['settings']['keyword'] ) );
					$keywordTitleCount=substr_count( strtolower( $_data['post_title'] ), strtolower( $settings['settings']['keyword'] ) );
					$keywordImagesCount=substr_count( strtolower( $_data['post_content'] ), strtolower( '<img' ) );
					if( $keywordCount + $keywordTitleCount + $keywordImagesCount > 0 ){
						$_arrKeywordPos[ $_data['ID'] ]=array( 'content'=>array(), 'inhtml' => array(), 'title'=>array(), 'image'=>array() );
					}
					if( isset( $settings['settings']['flg_tags'] ) && $settings['settings']['flg_tags'] == 1 && @$settings['settings']['advanced']['update']==2 ){ // update tags for all posts/pages
						$_arrTags=wp_get_post_tags( $_data['ID'] );
						$_placeTags=array();
						$_tagKeywords=explode( ',', trim( htmlentities( $settings['settings']['advanced']['keywords'] ) ) );
						$_tagKeywords[]=$settings['settings']['replace'];
						if( isset( $settings['settings']['flg_tags'] ) && $settings['settings']['flg_tags'] == 1 ){
							if( @$settings['settings']['advanced']['type']==2 ){
								foreach( $_arrTags as &$_tag ){
									$_placeTags[]=$this->createNewTagName( $_tag->name, $_tagKeywords );
								}
								if( !$_onlyTest ){
									wp_set_post_terms( $_data['ID'], implode( ',', $_placeTags ), 'post_tag', false ); // replace exesting
								}
							}elseif( @$settings['settings']['advanced']['type']==1 ){
								if( !$_onlyTest ){
									wp_set_post_terms( $_data['ID'], implode( ',', $_tagKeywords ), 'post_tag', true ); // add new tags
								}
							}
						}
					}
					if( ( $keywordCount + $keywordImagesCount ) > 0 ){
						$_arrKeywordInTags[ $_data['ID'] ]=$_arrKeywordBroken[ $_data['ID'] ]=array();
						for( $pos=-1; $pos < strlen( $_data['post_content'] ); ){
							$pos=strpos( strtolower( $_data['post_content'] ), strtolower( $settings['settings']['keyword'] ), $pos+1 );
							if( $pos===false ){
								$pos=strlen( $_data['post_content'] );
								continue; // for
							}
							if( !ctype_alpha( @$_data['post_content'][$pos-1] ) 
								&& !ctype_alpha( @$_data['post_content'][ $pos+strlen( $settings['settings']['keyword'] ) ] ) 
								&& !( ( @$_data['post_content'][ $pos-1 ] == '<' || @$_data['post_content'][ $pos+strlen( $settings['settings']['keyword'] ) ] == '>' )&&
								in_array( strtolower( $settings['settings']['keyword'] ), array( "a", "accesskey", "href", "name", "tabindex", "target", "area", "alt", "coords", "shape", "b", "basefont", "size", "big", "blockquote", "body", "alink", "link", "vlink", "background", "bgcolor", "bgproperties", "bottommargin", "leftmargin", "marginheight", "marginwidth", "rightmargin", "text", "topmargin", "br", "clear", "caption", "align", "center", "web", "col", "span", "valign", "colgroup", "dd", "del", "div", "class", "dl", "dt", "em", "fieldset", "font", "color", "face", "form", "accept", "charset", "action", "enctype", "method", "frame", "bordercolor", "frameborder", "noresize", "scrolling", "src", "frameset", "border", "cols", "framespacing", "rows", "h1", "h2", "h3", "h4", "h5", "h6", "head", "hr", "noshade", "width", "html", "i", "iframe", "img", "dynsrc", "height", "hspace", "vspace", "ismap", "lowsrc", "usemap", "ins", "kbd", "layer", "left", "top", "z", "index", "li", "type", "value", "link", "rel", "map", "marquee", "behavior", "direction", "loop", "scrollamount", "scrolldelay", "truespeed", "meta", "nobr", "noframes", "noscript", "javascript", "ol", "start", "p", "pre", "q", "samp", "script", "small", "spacer", "strike", "strong", "style", "sub", "sup", "table", "cellpadding", "callspacing", "frame", "rules", "tbody", "char", "tdth", "colspan", "nowrap", "rowspan", "tfoot", "thead", "title", "tr", "tt", "u", "ul" ) ) )
							){
								$_arrKeywordPos[ $_data['ID'] ]['content'][ $pos ]=@$_data['post_content'][ $pos-1].substr( $_data['post_content'], $pos, strlen( $settings['settings']['keyword'] ) ).@$_data['post_content'][ $pos+strlen( $settings['settings']['keyword'] ) ] ;
							}/*else{
								$_arrKeywordBroken[ $_data['ID'] ][ $pos ]=@$_data['post_content'][ $pos-1].substr( $_data['post_content'], $pos, strlen( $settings['settings']['keyword'] ) ).@$_data['post_content'][ $pos+strlen( $settings['settings']['keyword'] ) ];
							}*/
						}
						$_flgWordInHTMLTags=$_flgWordInTagsIsText=$_flgInTagsOpenQuotes=$_flgInTagsOpen2Quotes=$_wordInImage=$_wordInImageType=false;
						$_wordInImageBegin=$_wordInImageEnd=$_wordInImageInsert=0;
						for( $pos=0; $pos < strlen( $_data['post_content'] ); $pos++ ){
							if( $_data['post_content'][ $pos ] == '<' || $_data['post_content'][ $pos ] == '[' ){
								$_flgWordInHTMLTags=true;
								if( $_data['post_content'][ $pos ].$_data['post_content'][ $pos+1 ].$_data['post_content'][ $pos+2 ].$_data['post_content'][ $pos+3 ] == '<img' ){
									$_wordInImage=true;
									$_wordInImageInsert=$pos+4;
								}
							}
							if( $_data['post_content'][ $pos ] == '>' || $_data['post_content'][ $pos ] == ']' ){
								$_flgWordInTagsIsText=$_flgWordInHTMLTags=false;
								if( $_wordInImage && $_data['post_content'][ $pos ] == '>' ){
									$_wordInImage=$_wordInImageType=false;
									$_wordInImageBegin=$_wordInImageEnd=$_wordInImageInsert=0;
								}
							}
							
							if( $_flgWordInHTMLTags && ( $_data['post_content'][ $pos ].$_data['post_content'][ $pos+1 ].$_data['post_content'][ $pos+2 ].$_data['post_content'][ $pos+3 ] == ' alt'
								|| $_data['post_content'][ $pos ].$_data['post_content'][ $pos+1 ].$_data['post_content'][ $pos+2 ].$_data['post_content'][ $pos+3 ].$_data['post_content'][ $pos+4 ].$_data['post_content'][ $pos+5 ] == ' title' )
							){
								$_flgWordInTagsIsText=true;
								if( $_wordInImage ){
									if( $_data['post_content'][ $pos ].$_data['post_content'][ $pos+1 ].$_data['post_content'][ $pos+2 ].$_data['post_content'][ $pos+3 ] == ' alt' ){
										$_wordInImageType="alt";
									}else{
										$_wordInImageType="title";
									}
								}
							}
							if( $_flgWordInTagsIsText ){
								if( $_data['post_content'][ $pos ] === "'" && !$_flgInTagsOpen2Quotes ){
									if( $_flgInTagsOpenQuotes  ){
										$_flgWordInTagsIsText==false;
										$_flgInTagsOpenQuotes=false;
										if( $_wordInImageBegin!==0 ){
											$_wordInImageEnd=$pos-1;
										}
									}else{
										$_flgInTagsOpenQuotes=true;
									}
								}
								if( $_data['post_content'][ $pos ] === '"' && !$_flgInTagsOpenQuotes ){
									if( $_flgInTagsOpen2Quotes ){
										$_flgWordInTagsIsText=false;
										$_flgInTagsOpen2Quotes=false;
										if( $_wordInImageBegin!==0 ){
											$_wordInImageEnd=$pos-1;
										}
									}else{
										$_flgInTagsOpen2Quotes=true;
									}
								}
							}
							if( $_wordInImage && ( $_flgInTagsOpen2Quotes || $_flgInTagsOpenQuotes ) && $_flgWordInTagsIsText && $_wordInImageBegin===0 ){
								$_wordInImageBegin=$pos+1;
							}
							if( $_wordInImageInsert!==0 && isset( $settings['settings']['upgrade_images'] ) ){
								if( !isset( $_arrKeywordPos[ $_data['ID'] ]['image'][$_wordInImageInsert] ) ){
									$_arrKeywordPos[ $_data['ID'] ]['image'][$_wordInImageInsert]=array( 'title'=>array(), 'alt'=>array() );
								}
								if( $_wordInImageBegin!==0 && $_wordInImageEnd!==0 ){
									$_arrKeywordPos[ $_data['ID'] ]['image'][$_wordInImageInsert][$_wordInImageType]=array(
										$_wordInImageBegin,
										$_wordInImageEnd-$_wordInImageBegin+1,
										substr( $_data['post_content'], $_wordInImageBegin, $_wordInImageEnd-$_wordInImageBegin+1 )
									);
									$_wordInImageBegin=$_wordInImageEnd=0;
								}
							}
							if( isset( $_arrKeywordPos[ $_data['ID'] ]['content'][ $pos ] ) && $_flgWordInHTMLTags && ( !$_flgWordInTagsIsText || !$_wordInImage ) ){
							//	$_arrKeywordInTags[ $_data['ID'] ]['content'][ $pos ]="keyword in tag: ".$_arrKeywordPos[ $_data['ID'] ]['content'][ $pos ];
								unset( $_arrKeywordPos[ $_data['ID'] ]['content'][ $pos ] );
							}
							if( isset( $_arrKeywordPos[ $_data['ID'] ]['content'][ $pos ] ) && $_flgWordInTagsIsText ){
								$_arrKeywordPos[ $_data['ID'] ]['inhtml'][ $pos ]=$_arrKeywordPos[ $_data['ID'] ]['content'][ $pos ];
							//	unset( $_arrKeywordPos[ $_data['ID'] ]['content'][ $pos ] );
							}
						}
					}
					if( isset( $_arrKeywordPos[ $_data['ID'] ]['image'] ) ){
						foreach( $_arrKeywordPos[ $_data['ID'] ]['image'] as $_posInsert=>$_arrImage ){
							if( ( $settings['settings']['images_update_type'] == 1 
									|| $settings['settings']['images_update_type'] == 2 
									|| $settings['settings']['images_update_type'] == 5 ) 
								&& !empty( $_arrKeywordPos[ $_data['ID'] ]['content'] ) ){ // founded content
								$_arrKeywordPos[ $_data['ID'] ]['content'][ $_posInsert ]=true;
							}elseif( $settings['settings']['images_update_type'] == 3 
								|| $settings['settings']['images_update_type'] == 4 
								|| $settings['settings']['images_update_type'] == 6 ){ // all content
								$_arrKeywordPos[ $_data['ID'] ]['content'][ $_posInsert ]=true;
							}
						}
					}
					if( empty( $_arrKeywordPos[ $_data['ID'] ]['content'] ) ){
						unset( $_arrKeywordPos[ $_data['ID'] ] );
					}
					if( $keywordTitleCount > 0 ){
						for( $pos=-1; $pos < strlen( $_data['post_title'] )-strlen( $settings['settings']['keyword'] ); ){
							$pos=strpos( strtolower( $_data['post_title'] ), strtolower( $settings['settings']['keyword'] ), $pos+1 );
							if( $pos===false ){
								$pos=strlen( $_data['post_title'] );
								continue; // for
							}
							if( !ctype_alpha( @$_data['post_title'][$pos-1] ) 
								&& !ctype_alpha( @$_data['post_title'][ $pos+strlen( $settings['settings']['keyword'] ) ] ) ){
								$_arrKeywordPos[ $_data['ID'] ]['title'][ $pos ]=@$_data['post_title'][ $pos-1].substr( $_data['post_title'], $pos, strlen( $settings['settings']['keyword'] ) ).@$_data['post_title'][ $pos+strlen( $settings['settings']['keyword'] ) ];
							}
						}
					}
				}
			}
			if( $_onlyTest ){
				var_dump( $_arrKeywordPos );
			}
			if( !empty( $_arrKeywordPos ) ){
				foreach( $_arrKeywordPos as $_dataId=>&$_keywordsPositions ){
					foreach( $_keywordsPositions as $_replaceTypeId=>&$_replaceType ){
						if( empty( $_replaceType ) ){
							unset( $_keywordsPositions[$_replaceTypeId] );
						}
					}
					if( empty( $_keywordsPositions ) ){
						unset( $_keywordsPositions[$_dataId] );
						continue;
					}
					foreach( $arrList as $_data ){
						if( $_data['ID'] == $_dataId ){
							$data=array(
								'post_title'=>$_data['post_title'],
								'post_content'=>$_data['post_content']
							);
							$_postTags=wp_get_post_terms( $_dataId, 'post_tag', array("fields" => "names") );
							$_postCategories=wp_get_post_terms( $_dataId, 'category', array("fields" => "names") );
							$occurrence=$occurrenceLink=$_dPosition=$_dTitlePosition=0;
							$_setBeforeLink=$_beforeLink;
							$_setAfterLink=$_afterLink;
							if( isset( $_keywordsPositions['title'] ) ) foreach( $_keywordsPositions['title'] as $_position=>$value ){
								$data['post_title']=$this->replaceTextN( 
									$settings['settings']['keyword'], 
									$settings['settings']['replace'], 
									$data['post_title'],
									$_dTitlePosition+$_position
									 // without $before & $after 
								);
								$_dTitlePosition+=( strlen( $settings['settings']['replace'] )-strlen( $settings['settings']['keyword'] ) );
							}
							if( isset( $_keywordsPositions['content'] ) ){
								ksort( $_keywordsPositions['content'] );
								foreach( $_keywordsPositions['content'] as $_position => &$value ){
									if( isset( $_keywordsPositions['inhtml'][$_position] ) ){
										$data['post_content']=$this->replaceTextN( 
											$settings['settings']['keyword'], 
											$settings['settings']['replace'], 
											$data['post_content'],
											$_dPosition+$_position
											 // without $before & $after 
										);
										$_dPosition+=( strlen( $settings['settings']['replace'] )-strlen( $settings['settings']['keyword'] ) );
									}elseif( isset( $_keywordsPositions['image'] ) && isset( $_keywordsPositions['image'][$_position] ) ){
										//insert alt/title to image tag
										foreach( $_keywordsPositions['image'][$_position] as $_types=>$_positions ){
											$_replacedText=null;
											switch( $settings['settings']['images_'.$_types] ){
												case null: break;
												case 1: $_replacedText=$settings['settings']['replace'];break;
												case 2: $_replacedText=$data['post_title'];break;
												case 3:
													if( count( $_postTags ) > 1 ){
														$_replacedText=$_postTags[rand(0, count( $_postTags )-1 )];
													}else{
														$_replacedText=$_postTags[0];
													}
												break;
												case 4:
													if( count( $_postCategories ) > 1 ){
														$_replacedText=$_postCategories[rand(0, count( $_postCategories )-1 )];
													}else{
														$_replacedText=$_postCategories[0];
													}
												break;
											}
											if( $_onlyTest ){
												var_dump( array( $_replacedText, $_position, $_positions, $settings['settings']['images_update_type'] ) );
											}
											if( $_replacedText != null ){
												if( empty( $_positions ) && (
													$settings['settings']['images_update_type'] == 1 
													|| $settings['settings']['images_update_type'] == 3
												) ){ // вставляем в предопределенную область внутри image
													$_replacedText=' '.$_types.'="'.$_replacedText.'" ';
													if( $_onlyTest ){
														var_dump( array( $data['post_content'], $_replacedText, $_dPosition+$_position, 1 ) );
													}
													$data['post_content']=substr_replace( $data['post_content'], $_replacedText, $_dPosition+$_position, 1 );
													$_dPosition+=( strlen( $_replacedText )-1 );
												}elseif( !empty( $_positions ) && (
													$settings['settings']['images_update_type'] == 2 
													|| $settings['settings']['images_update_type'] == 4
													|| $settings['settings']['images_update_type'] == 5
													|| $settings['settings']['images_update_type'] == 6
												) ){ // вставляем в область по рамерам
													if( $settings['settings']['images_update_type'] == 5
														|| $settings['settings']['images_update_type'] == 6 ){
														$_replacedText=$_replacedText.' - '.substr( $data['post_content'], $_dPosition+$_positions[0], $_positions[1] );
													}
													if( $_onlyTest ){
														var_dump( array( $_replacedText, $_dPosition+$_positions[0], $_positions[1] ) );
													}
													$data['post_content']=substr_replace( $data['post_content'], $_replacedText, $_dPosition+$_positions[0], $_positions[1] );
													if( isset( $_keywordsPositions['content'][ $_positions[0] ] ) ){ // not replace replaced value
														unset( $_keywordsPositions['content'][ $_positions[0] ] );
													}
													$_dPosition+=( strlen( $_replacedText )-$_positions[1] );
												}
											}
										}
									}elseif( (int)$settings['settings']['links_occurrence']==0 
										|| $occurrenceLink < (int)$settings['settings']['links_occurrence']
										|| (int)$settings['settings']['text_occurrence']==0 
										|| $occurrence < (int)$settings['settings']['text_occurrence']
									){
										if( (int)$settings['settings']['links_occurrence']==0 || $occurrenceLink < (int)$settings['settings']['links_occurrence'] ){
											$_beforeLinkTxt=$_setBeforeLink;
											$_afterLinkTxt=$_setAfterLink;
											$occurrenceLink++;
										}else{
											$_beforeLinkTxt=$_afterLinkTxt='';
										}
										if( (int)$settings['settings']['text_occurrence']==0 || $occurrence < (int)$settings['settings']['text_occurrence'] ){
											$_beforeText=$_before;
											$_afterText=$_after;
											$occurrence++;
										}else{
											$_beforeText=$_afterText='';
										}
										$data['post_content']=$this->replaceTextN(
											$settings['settings']['keyword'], 
											$settings['settings']['replace'], 
											$data['post_content'],
											$_dPosition+$_position,
											$_beforeLinkTxt.$_beforeText,
											$_afterText.$_afterLinkTxt
										);
										$_dPosition+=( strlen( $_beforeLinkTxt.$_beforeText.$settings['settings']['replace'].$_afterText.$_afterLinkTxt )-strlen( $settings['settings']['keyword'] ) );
									}
								} //end foreach( $_keywordsPositions['content']
							}
							if( ( $_beforePost != '' || $_afterPost != '' )
								&& $_data['post_content'] !== $data['post_content']
							){
								$data['post_content']=$_beforePost.$data['post_content'].$_afterPost;
							}
							$settings['replacedCounter']++;
							if( !$_onlyTest ){
								if( $_data['post_content'] !== $data['post_content'] ){
									$_tooltip->postId( $_data['ID'] )->set();
								}
								$wpdb->update( $wpdb->posts, $data, array( 'ID'=>$_data['ID'] ) );
							}
							if( isset( $settings['settings']['flg_tags'] ) && $settings['settings']['flg_tags'] == 1 && @$settings['settings']['advanced']['update']==1 ){ // update tags for founded posts/pages
								$_arrTags=wp_get_post_tags( $_data['ID'] );
								$_placeTags=array();
								$_tagKeywords=explode( ',', trim( htmlentities( $settings['settings']['advanced']['keywords'] ) ) );
								$_tagKeywords[]=$settings['settings']['replace'];
								if( @$settings['settings']['advanced']['type']==2 ){
									foreach( $_arrTags as &$_tag ){
										$_placeTags[]=$this->createNewTagName( $_tag->name, $_tagKeywords );
									}
									if( !$_onlyTest ){
										wp_set_post_terms( $_data['ID'], implode( ',', $_placeTags ), 'post_tag', false ); // replace exesting
									}
								}elseif( @$settings['settings']['advanced']['type']==1 ){
									if( !$_onlyTest ){
										wp_set_post_terms( $_data['ID'], implode( ',', $_tagKeywords ), 'post_tag', true ); // add new tags
									}
								}
							}
							break; // foreach - check other post data
						}
					}
				}
			}
		}
		extract( $settings );
		include_once( COPTIMIZER_PATH.'/source/plugin/content.php' );
	}

	public $_optionName = 'contentoptimizer_redirects';
	
	public function addCloakedLink( $cloakUrl, $redirectUrl ){
		$_oldOptions=get_option( $this->_optionName );
		if ( $_oldOptions !== false ) {
			$_oldOptions=json_decode($_oldOptions, true);
			$_oldOptions[$cloakUrl]=$redirectUrl;
			update_option( $this->_optionName, json_encode( $_oldOptions ) );
		}else{
			add_option( $this->_optionName, json_encode( array( $cloakUrl => $redirectUrl ) ) );
		}
	}

	public function createNewTagName( $_name, $_newNames ){
		$_addedTagTail=trim( $_newNames[ array_rand( $_newNames, 1 ) ] );
		if( strpos( $_name, $_addedTagTail )===false ){
			return $_name." ".$_addedTagTail;
		}else{
			foreach( $_newNames as $_oneName ){
				if( strpos( $_name, $_oneName )===false ){
					return $_name." ".$_oneName;
				}
			}
			return $_name;
		}
	}

	public function getContents(){
//		$settings=$_GET;
		$settings=$_POST;
		$returnArray=array( 'replacedCounter'=>0, 'links'=>array(), 'type_counter'=>array(), 'all_counter'=>array());
		if( isset( $settings['keyword'] ) && $settings['keyword']!='' ){
			$settings['keyword']=trim( $settings['keyword'] );
			set_time_limit(0);
			ignore_user_abort(true);
			$arrList=$arrTags=$_arrKeywordPos=$_arrKeywordBroken=$_arrKeywordInTags=array();
			$arrList=$this->getPosts();
			$arrTags=$this->getTags();
			global $wpdb;
			foreach( $arrList as $_data ){
				if( in_array( $_data['post_type'], array('post','page') ) ){
					$keywordCount=substr_count( strtolower( $_data['post_content'] ), strtolower( $settings['keyword'] ) );
					if( $keywordCount !== 0 ){
						$_arrKeywordInTags[ $_data['ID'] ]=$_arrKeywordBroken[ $_data['ID'] ]=$_arrKeywordPos[ $_data['ID'] ]=array();
						for( $pos=-1; $pos < strlen( $_data['post_content'] )-strlen( $settings['keyword'] ); ){
							$pos=strpos( strtolower( $_data['post_content'] ), strtolower( $settings['keyword'] ), $pos+1 );
							if( $pos===false ){
								$pos=strlen( $_data['post_content'] );
								continue;
							}
							if( !ctype_alpha( @$_data['post_content'][$pos-1] ) 
								&& !ctype_alpha( @$_data['post_content'][ $pos+strlen( $settings['keyword'] ) ] ) 
								&& !( ( @$_data['post_content'][ $pos-1 ] == '<' || @$_data['post_content'][ $pos+strlen( $settings['keyword'] ) ] == '>' ) &&
								in_array( strtolower( $settings['keyword'] ), array( "a", "accesskey", "href", "name", "tabindex", "target", "area", "alt", "coords", "shape", "b", "basefont", "size", "big", "blockquote", "body", "alink", "link", "vlink", "background", "bgcolor", "bgproperties", "bottommargin", "leftmargin", "marginheight", "marginwidth", "rightmargin", "text", "topmargin", "br", "clear", "caption", "align", "center", "web", "col", "span", "valign", "colgroup", "dd", "del", "div", "class", "dl", "dt", "em", "fieldset", "font", "color", "face", "form", "accept", "charset", "action", "enctype", "method", "frame", "bordercolor", "frameborder", "noresize", "scrolling", "src", "frameset", "border", "cols", "framespacing", "rows", "h1", "h2", "h3", "h4", "h5", "h6", "head", "hr", "noshade", "width", "html", "i", "iframe", "img", "dynsrc", "height", "hspace", "vspace", "ismap", "lowsrc", "usemap", "ins", "kbd", "layer", "left", "top", "z", "index", "li", "type", "value", "link", "rel", "map", "marquee", "behavior", "direction", "loop", "scrollamount", "scrolldelay", "truespeed", "meta", "nobr", "noframes", "noscript", "javascript", "ol", "start", "p", "pre", "q", "samp", "script", "small", "spacer", "strike", "strong", "style", "sub", "sup", "table", "cellpadding", "callspacing", "frame", "rules", "tbody", "char", "tdth", "colspan", "nowrap", "rowspan", "tfoot", "thead", "title", "tr", "tt", "u", "ul" ) ) )
							){
								$_arrKeywordPos[ $_data['ID'] ][ $pos ]=@$_data['post_content'][ $pos-1].substr( $_data['post_content'], $pos, strlen( $settings['keyword'] ) ).@$_data['post_content'][ $pos+strlen( $settings['keyword'] ) ] ;
							}else{
								$_arrKeywordBroken[ $_data['ID'] ][ $pos ]=@$_data['post_content'][ $pos-1].substr( $_data['post_content'], $pos, strlen( $settings['keyword'] ) ).@$_data['post_content'][ $pos+strlen( $settings['keyword'] ) ];
							}
						}
						$_flgWordInHTMLTags=$_flgWordInTagsIsText=$_flgInTagsOpenQuotes=$_flgInTagsOpen2Quotes=false;
						for( $pos=0; $pos < strlen( $_data['post_content'] ); $pos++ ){
							if( $_data['post_content'][ $pos ] == '<' || $_data['post_content'][ $pos ] == '[' ){
								$_flgWordInHTMLTags=true;
							}
							if( $_data['post_content'][ $pos ] == '>' || $_data['post_content'][ $pos ] == ']' ){
								$_flgWordInTagsIsText=$_flgWordInHTMLTags=false;
							}
							if( $_flgWordInHTMLTags && ( $_data['post_content'][ $pos ].$_data['post_content'][ $pos+1 ].$_data['post_content'][ $pos+2 ].$_data['post_content'][ $pos+3 ] == ' alt'
								|| $_data['post_content'][ $pos ].$_data['post_content'][ $pos+1 ].$_data['post_content'][ $pos+2 ].$_data['post_content'][ $pos+3 ].$_data['post_content'][ $pos+4 ].$_data['post_content'][ $pos+5 ] == ' title' )
							){
								$_flgWordInTagsIsText=true;
							}
							if( $_flgWordInTagsIsText ){
								if( $_data['post_content'][ $pos ] === "'" ){
									if( $_flgInTagsOpenQuotes ){
										$_flgWordInTagsIsText==false;
										$_flgInTagsOpenQuotes=false;
									}else{
										$_flgInTagsOpenQuotes=true;
									}
								}
								if( $_data['post_content'][ $pos ] === '"' ){
									if( $_flgInTagsOpen2Quotes ){
										$_flgWordInTagsIsText=false;
										$_flgInTagsOpen2Quotes=false;
									}else{
										$_flgInTagsOpen2Quotes=true;
									}
								}
							}
							if( isset( $_arrKeywordPos[ $_data['ID'] ][ $pos ] ) && $_flgWordInHTMLTags && !$_flgWordInTagsIsText ){
								$_arrKeywordInTags[ $_data['ID'] ][ $pos ]=$_arrKeywordPos[ $_data['ID'] ][ $pos ];
								unset( $_arrKeywordPos[ $_data['ID'] ][ $pos ] );
							}
							if( isset( $_arrKeywordPos[ $_data['ID'] ][ $pos ] ) && $_flgWordInTagsIsText ){
								$_arrKeywordPos[ $_data['ID'] ][ $pos.":h" ]=$_arrKeywordPos[ $_data['ID'] ][ $pos ];
								unset( $_arrKeywordPos[ $_data['ID'] ][ $pos ] );
							}
						}
						if( !empty( $_arrKeywordPos[ $_data['ID'] ] ) ){
							if( !isset( $returnArray['links'][$_data['post_type']] ) ){
								$returnArray['links'][$_data['post_type']]=array();
							}
							$returnArray['links'][$_data['post_type']][ $_data['ID'] ]=array(
								'name'=>$_data['post_title'], 
								'url'=>get_permalink( $_data['ID'] ), 
								'counter'=>count( $_arrKeywordPos[ $_data['ID'] ] )
							);
						}
					}
					$keywordTitleCount=substr_count( strtolower( $_data['post_title'] ), strtolower( $settings['keyword'] ) );
					if( $keywordTitleCount !== 0 ){
						for( $pos=-1; $pos < strlen( $_data['post_title'] )-strlen( $settings['keyword'] ); ){
							$pos=strpos( strtolower( $_data['post_title'] ), strtolower( $settings['keyword'] ), $pos+1 );
							if( $pos===false ){
								$pos=strlen( $_data['post_title'] );
								continue;
							}
							if( !ctype_alpha( @$_data['post_title'][$pos-1] ) 
								&& !ctype_alpha( @$_data['post_title'][ $pos+strlen( $settings['keyword'] ) ] ) ){
								if( !isset( $returnArray['links'][ $_data['post_type'] ][ $_data['ID'] ] ) ){
									if( !isset( $returnArray['links'][ $_data['post_type'] ] ) ){
										$returnArray['links'][ $_data['post_type'] ]=array();
									}
									$returnArray['links'][ $_data['post_type'] ][ $_data['ID'] ]=array(
										'name'=>$_data['post_title'], 
										'url'=>get_permalink( $_data['ID'] ), 
										'counter'=>1
									);
								}else{
									$returnArray['links'][ $_data['post_type'] ][ $_data['ID'] ]['counter']++;
								}
							}
						}
					}
					$returnArray['all_counter'][ $_data['post_type'] ]++;
				}
			}
			if( !empty( $returnArray['links'] ) ){
				if( !empty( $returnArray['links']['post'] ) ){
					$returnArray['type_counter']['post']=count( $returnArray['links']['post'] );
				}
				if( !empty( $returnArray['links']['page'] ) ){
					$returnArray['type_counter']['page']=count( $returnArray['links']['page'] );
				}
				$returnArray['replacedCounter']=@$returnArray['type_counter']['post']+@$returnArray['type_counter']['page'];
			}
			foreach( $arrTags as $_data ){
				if( in_array( $_data['taxonomy'], array('category','post_tag') ) ){
					$keywordCount=substr_count( strtolower( $_data['name'] ), strtolower( $settings['keyword'] ) );
					$keywordTitleCount=substr_count( strtolower( $_data['slug'] ), strtolower( $settings['keyword'] ) );
					if( $keywordCount !== 0 ){
						
						for( $pos=-1; $pos < strlen( $_data['name'] )-strlen( $settings['keyword'] ); ){
							$pos=strpos( strtolower( $_data['name'] ), strtolower( $settings['keyword'] ), $pos+1 );
							if( $pos===false ){
								$pos=strlen( $_data['name'] );
								continue;
							}
							if( !ctype_alpha( @$_data['name'][$pos-1] ) 
								&& !ctype_alpha( @$_data['name'][ $pos+strlen( $settings['keyword'] ) ] ) ){
								if( !isset( $returnArray['links'][ $_data['taxonomy'] ][ $_data['term_id'] ] ) ){
									if( !isset( $returnArray['links'][ $_data['taxonomy'] ] ) ){
										$returnArray['links'][ $_data['taxonomy'] ]=array();
									}
									$returnArray['links'][ $_data['taxonomy'] ][ $_data['term_id'] ]=array(
										'name'=>$_data['name'], 
										'url'=>( $_data['taxonomy']=='category'?get_category_link( $_data['term_id'] ) : get_tag_link( $_data['term_id'] ) ), 
										'counter'=>1
									);
								}else{
									$returnArray['links'][ $_data['taxonomy'] ][ $_data['term_id'] ]['counter']++;
								}
							}
						}
					}
					if( $keywordTitleCount !== 0 ){
						for( $pos=-1; $pos < strlen( $_data['slug'] )-strlen( $settings['keyword'] ); ){
							$pos=strpos( strtolower( $_data['slug'] ), strtolower( $settings['keyword'] ), $pos+1 );
							if( $pos===false ){
								$pos=strlen( $_data['slug'] );
								continue;
							}
							if( !ctype_alpha( @$_data['slug'][$pos-1] ) 
								&& !ctype_alpha( @$_data['slug'][ $pos+strlen( $settings['keyword'] ) ] ) ){
								if( !isset( $returnArray['links'][ $_data['taxonomy'] ][ $_data['term_id'] ] ) ){
									if( !isset( $returnArray['links'][ $_data['taxonomy'] ] ) ){
										$returnArray['links'][ $_data['taxonomy'] ]=array();
									}
									$returnArray['links'][ $_data['taxonomy'] ][ $_data['term_id'] ]=array(
										'name'=>$_data['name'], 
										'url'=>( $_data['taxonomy']=='category'?get_category_link( $_data['term_id'] ) : get_tag_link( $_data['term_id'] ) ), 
										'counter'=>1
									);
								}else{
									$returnArray['links'][ $_data['taxonomy'] ][ $_data['term_id'] ]['counter']++;
								}
							}
						}
					}
				}
				$returnArray['all_counter'][ $_data['taxonomy'] ]++;
			}
			if( !empty( $returnArray['links'] ) ){
				if( !empty( $returnArray['links']['category'] ) ){
					$returnArray['type_counter']['category']=count( $returnArray['links']['category'] );
				}
				if( !empty( $returnArray['links']['post_tag'] ) ){
					$returnArray['type_counter']['post_tag']=count( $returnArray['links']['post_tag'] );
				}
				$returnArray['replacedCounter']+=@$returnArray['type_counter']['category']+@$returnArray['type_counter']['post_tag'];
			}
		}
		echo json_encode( $returnArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP );
		die();
	}

	public function findTextInWorld( $find, $replace ){
		$_flgFirstUpper=false;
		$_counterUppers=0;
		for( $_key=0; $_key<=strlen( $find ); $_key++ ){
			$_char=$find[$_key];
			if( $_key==0 && $_char != strtolower( $_char ) ){
				$_flgFirstUpper=true;
				$_counterUppers++;
			}
			if( $_key!=0 && $_char != strtolower( $_char ) ){
				$_flgFirstUpper=false;
				$_counterUppers++;
			}
		}
		if( $_counterUppers == strlen( $find ) ){
			return strtoupper( $replace );
		}
		if( $_flgFirstUpper ){
			return ucfirst( $replace );
		}
		return $replace;
	}

	public function replaceTextN( $search, $replace, $content, $position, $before='', $after='' ){
		$searchPieces=explode( " ", substr( $content, $position, strlen( $search ) ) );
		$replacePieces=explode( " ", $replace );
		foreach( $searchPieces as $_id=>$piece ){
			if( isset( $replacePieces[$_id] ) )
				$replacePieces[$_id]=$this->findTextInWorld( $searchPieces[$_id], $replacePieces[$_id] );
			
		}
		return substr_replace( $content, $before.implode( " ", $replacePieces ).$after, $position, strlen( $search ) );
	}

	public function getPosts( $postType=null, $postCategory=null, $postId=null ){
		global $wpdb;
		$_query="SELECT a.ID, a.post_content, a.post_title, a.post_type FROM ".$wpdb->posts." a".( (isset($postCategory))?" JOIN ".$wpdb->term_relationships." b ON b.object_id=a.ID":'' ).( (isset($postType))?" WHERE post_type='".$postType."' AND post_status='publish'":'' ).( (isset($postCategory))?" AND b.term_taxonomy_id='".$postCategory."'":'' ).( (isset($postId))?" AND a.ID='".$postId."'":'' );
		return $wpdb->get_results( $_query, ARRAY_A );
	}

	public function getTags(){
		global $wpdb;
		$_query="SELECT a.term_id, a.name, a.slug, b.taxonomy FROM ".$wpdb->terms." as a LEFT JOIN ".$wpdb->term_taxonomy." as b ON a.term_id=b.term_id";
		return $wpdb->get_results( $_query, ARRAY_A );
	}
}
}
?>