<div class="wrap">
	<h2>SEO Bot</h2>
</div>
<?php if ( isset($replacedCounter) ){ ?>
<div id="message" class="updated fade"><p><?php if( $replacedCounter==0 ){?>
	<span style="color:red">Nothing found.</span>
	<?php }elseif( $replacedCounter!=0 ){?>
	<span style="color:green">Processed <?php echo $replacedCounter;?> element(s).</span>
	<?php } ?></p></div>
<?php } ?>

<form id="project_form" class="wh postbox_form" method="post" action="" enctype="multipart/form-data">
<div class="postbox-container" style="width:50%;"><div class="meta-box-sortables" style="padding:5px;">

<div class="postbox"><div class="handlediv" title="Click to toggle"><br></div>
	<h3 class="hndle">Keywords</h3>
	<div class="inside"><fieldset><ol>
		<li>
			<label>Keyword/Text Search</label><input type="text" id="search_keyword" name="settings[keyword]" value="<?php if( (isset($settings['keyword']) ) )echo $settings['keyword']; ?>" />
			<p class="helper"><font color="Red">Note:</font> Input text you would like to search for.</p>
		</li>
		<li>
			<input type="button" id="get_list" value="Search" class="button button-primary button-large" />
			<div id="search_result"></div>
		</li>
		<li>
			<label>Replace to Keyword/Text</label><input type="text" name="settings[replace]" value="<?php if( (isset($settings['replace']) ) )echo $settings['replace']; ?>" />
			<p class="helper"><font color="Red">Note:</font> Input text you would like to replace your keyword/text with. If empty, it is not replaced.</p>
		</li>
		<li>
			<label>Text Decoration</label>
			<select id="select_index" name="settings[decoration]">
				<option value="" <?php if( !isset($settings['decoration']) ) echo 'selected="selected"'; ?>>None</option>
				<option value="1" <?php if( isset($settings['decoration']) && $settings['decoration']=="1" ) echo 'selected="selected"'; ?>>Bold</option>
				<option value="2" <?php if( isset($settings['decoration']) && $settings['decoration']=="2" ) echo 'selected="selected"'; ?>>Italic</option>
				<option value="3" <?php if( isset($settings['decoration']) && $settings['decoration']=="3" ) echo 'selected="selected"'; ?>>Underlined</option>
			</select>
		</li>
		<li>
			<label>Occurrence</label><input type="text" name="settings[text_occurrence]" value="<?php if( (isset($settings['text_occurrence']) ) ) echo $settings['text_occurrence']; else echo 0;?>" class="required validate-integer" />
			<p class="helper"><font color="Red">Note:</font> Define how many times the changes should be applied per one article/page. 0 - apply to all.</p>
		</li>
	</ol></fieldset></div>
</div>


<div class="postbox"><div class="handlediv" title="Click to toggle"><br></div>
	<h3 class="hndle">Links</h3>
	<div class="inside"><fieldset><ol>
		<li>
			<label>Add Link</label><input type="checkbox" name="settings[create_link]" value="1"<?php if( (isset($settings['create_link']) && $settings['create_link']==1) ){?> checked="checked"<?php } ?> id="create_link" />
			<p class="helper"><font color="Red">Note:</font> Provide the link that should be added for the above keyword/text.</p>
		</li>
		<div class="create_link" <?php if( (!isset($settings['create_link']) || $settings['create_link']!=1) ){?>style="display:none;"<?php } ?>>
			<li>
				<label>Link</label><input type="text" name="settings[link]" value="<?php if( (isset($settings['link'])) )echo $settings['link']; ?>" class="create_link_settings"<?php if( !isset($settings['appearance']) ) echo ' disabled="disabled"'; ?> />
			</li>
			<li>
				<label>Add Cloaked Redirect</label><input type="checkbox" name="settings[cloaked_redirect]" value="1"<?php if( ( isset($settings['cloaked_redirect']) && $settings['cloaked_redirect']==1 ) ){ ?> checked="checked"<?php } ?> class="create_link_settings"<?php if( !isset($settings['appearance']) ) echo ' disabled="disabled"'; ?> />
			</li>
			<li>
				<label>Cloaking Link <?php echo site_url();?></label><input type="text" name="settings[cloaking_link]" value="<?php if( (isset($settings['cloaking_link'])) )echo $settings['cloaking_link']; ?>" class="create_link_settings"<?php if( !isset($settings['appearance']) ) echo ' disabled="disabled"'; ?> />
			<p class="helper"><font color="Red">Note:</font> Provide the folder name for your cloaked redirect e.g. /featured</p>				
			</li>
			<li>
				<label>Links Occurrence</label><input type="text" name="settings[links_occurrence]" value="<?php if( (isset($settings['links_occurrence']) ) ) echo $settings['links_occurrence']; else echo 0;?>" class="required validate-integer" />
				<p class="helper"><font color="Red">Note:</font> Define how many links should be added per one article/page. 0 - apply to all.</p>
			</li>
		</div>
	</ol></fieldset></div>
</div>

<div class="postbox"><div class="handlediv" title="Click to toggle"><br></div>
	<h3 class="hndle">Settings</h3>
	<div class="inside"><fieldset><ol>
		<li>
			<label>Appearance</label>
			<select id="select_appearance" name="settings[appearance]">
				<option value="0" <?php if( isset($settings['appearance']) && $settings['appearance']=="0" ) echo 'selected="selected"'; ?>>All Site</option>
				<?php if( count( $pages ) > 0 ){ ?><option value="1" <?php if( isset($settings['appearance']) && $settings['appearance']=="1" ) echo 'selected="selected"'; ?>>All Pages</option><?php } ?>
				<option value="2" <?php if( isset($settings['appearance']) && $settings['appearance']=="2" ) echo 'selected="selected"'; ?>>All Posts</option>
				<?php if( count( $categories ) > 0 ){ ?><option value="3" <?php if( isset($settings['appearance']) && $settings['appearance']=="3" ) echo 'selected="selected"'; ?>>Specified Category</option><?php } ?>
				<?php if( count( $pages ) > 0 ){ ?><option value="4" <?php if( isset($settings['appearance']) && $settings['appearance']=="4" ) echo 'selected="selected"'; ?>>Specified Page</option><?php } ?>
				<option value="5" <?php if( isset($settings['appearance']) && $settings['appearance']=="5" ) echo 'selected="selected"'; ?>>Specified URL</option>
			</select>
			<p class="helper"><font color="Red">Note:</font> Select where the changes should be applied.</p>
		</li>
		<?php if( count( $categories ) > 0 ){ ?><li class="hide_appearances appearance_3"<?php if( !isset($settings['appearance']) || $settings['appearance']!=3 ) echo ' style="display:none;"'; ?>>
			<label>Select Category</label>
			<select id="select_index" name="settings[category]">
				<?php foreach($categories as $_c){?>
				<option value="<?php echo $_c->cat_ID; ?>" <?php if( isset($settings['category']) && $settings['category']==$_c->cat_ID ) echo 'selected="selected"'; ?>><?php echo $_c->cat_name; ?></option>
				<?php } ?>
			</select>
			<p class="helper"><font color="Red">Note:</font> Select Category where the changes should be applied.</p>
		</li><?php } ?>
		<?php if( count( $pages ) > 0 ){ ?><li class="hide_appearances appearance_4"<?php if( !isset($settings['appearance']) || $settings['appearance']!=4 ) echo ' style="display:none;"'; ?>>
			<label>Select Page</label>
			<select id="select_index" name="settings[page]">
				<?php foreach($pages as $_c){?>
				<option value="<?php echo $_c['ID']; ?>" <?php if( isset($settings['page']) && $settings['page']==$_c['ID'] ) echo 'selected="selected"'; ?>><?php echo $_c['post_title']; ?></option>
				<?php } ?>
			</select>
			<p class="helper"><font color="Red">Note:</font> Select Page where the changes should be applied.</p>
		</li><?php } ?>
		<li class="hide_appearances appearance_5"<?php if( !isset($settings['appearance']) || $settings['appearance']!=5 ) echo ' style="display:none;"'; ?>>
			<label>Specified URL<font color="Red">*</font></label>
			<input type="text" name="settings[url]" class="required validate-url" value="<?php if( (isset($settings['url']) ) ){ echo $settings['url']; } ?>" />
		</li>
		<li>
			<label>Exclude URLs</label>
			<textarea name="settings[exclude]" cols="57" rows="3"><?php if( (isset($settings['exclude']) ) ) echo $settings['exclude'];?></textarea>	
			<p class="helper"><font color="Red">Note:</font> Provide URLs where the changes should not be applied, each URL from a new line.</p>
		</li>
	</ol></fieldset></div>
</div>

<input type="submit" name="replace" value="Update" style="float:left;" class="button button-primary button-large">

</div></div>
<div class="postbox-container" style="width:50%;"><div class="meta-box-sortables" style="padding:5px;">
<?php $flgCreateTooltipCheckbox=true; include_once( COPTIMIZER_PATH.'/source/plugin/tooltips-create.php' ); ?>
<div class="postbox"><div class="handlediv" title="Click to toggle"><br></div>
	<h3 class="hndle">Images</h3>
	<div class="inside"><fieldset><ol>
		<li>
			<label>Update Images</label><input type="checkbox" name="settings[upgrade_images]" value="1"<?php if( (isset($settings['upgrade_images']) && $settings['upgrade_images']==1) ){?> checked="checked"<?php } ?> id="upgrade_images" />
			<p class="helper"><font color="Red">Note:</font> Update ALT / TITLE tags for the images.</p>
		</li>
		<div class="upgrade_images"<?php if( (!isset($settings['upgrade_images']) || $settings['upgrade_images']!=1) ){?> style="display:none;"<?php } ?> >
			<li>
				<label>Title Text</label>
				<select name="settings[images_title]">
					<option value="" <?php if( !isset($settings['images_title']) ) echo 'selected="selected"'; ?>>Not update</option>
					<option value="1" <?php if( isset($settings['images_title']) && $settings['images_title']=="1" ) echo 'selected="selected"'; ?>>Keyword</option>
					<option value="2" <?php if( isset($settings['images_title']) && $settings['images_title']=="2" ) echo 'selected="selected"'; ?>>Post Title</option>
					<option value="3" <?php if( isset($settings['images_title']) && $settings['images_title']=="3" ) echo 'selected="selected"'; ?>>Random Post Tag</option>
					<option value="4" <?php if( isset($settings['images_title']) && $settings['images_title']=="4" ) echo 'selected="selected"'; ?>>Random Post Category</option>
				</select>
			</li>
			<li>
				<label>Alt Text</label>
				<select name="settings[images_alt]">
					<option value="" <?php if( !isset($settings['images_alt']) ) echo 'selected="selected"'; ?>>Not update</option>
					<option value="1" <?php if( isset($settings['images_alt']) && $settings['images_alt']=="1" ) echo 'selected="selected"'; ?>>Keyword</option>
					<option value="2" <?php if( isset($settings['images_alt']) && $settings['images_alt']=="2" ) echo 'selected="selected"'; ?>>Post Title</option>
					<option value="3" <?php if( isset($settings['images_alt']) && $settings['images_alt']=="3" ) echo 'selected="selected"'; ?>>Random Post Tag</option>
					<option value="4" <?php if( isset($settings['images_alt']) && $settings['images_alt']=="4" ) echo 'selected="selected"'; ?>>Random Post Category</option>
				</select>
			</li>
			<li>
				<label>Update Type</label>
				<select name="settings[images_update_type]">
					<option value="1" <?php if( isset($settings['images_update_type']) && $settings['images_update_type']=="1" ) echo 'selected="selected"'; ?>>Add alt/title value to images in the selected content that do not have alt/title tag value</option>
					<option value="2" <?php if( isset($settings['images_update_type']) && $settings['images_update_type']=="2" ) echo 'selected="selected"'; ?>>Overwrite current alt/title value of images in the selected content</option>
					<option value="5" <?php if( isset($settings['images_update_type']) && $settings['images_update_type']=="5" ) echo 'selected="selected"'; ?>>Append existing alt/title value of images in the selected content</option>
					<option value="3" <?php if( isset($settings['images_update_type']) && $settings['images_update_type']=="3" ) echo 'selected="selected"'; ?>>Add alt/title value to all images on the site that do not have alt/title tag value</option>
					<option value="4" <?php if( isset($settings['images_update_type']) && $settings['images_update_type']=="4" ) echo 'selected="selected"'; ?>>Overwrite alt/title value of all images on the site</option>
					<option value="6" <?php if( isset($settings['images_update_type']) && $settings['images_update_type']=="6" ) echo 'selected="selected"'; ?>>Append existing alt/title value of all images on the site</option>
				</select>
			</li>
		</div>
	</ol></fieldset></div>
</div>


<div class="postbox"><div class="handlediv" title="Click to toggle"><br></div>
	<h3 class="hndle">Tags</h3>
	<div class="inside"><fieldset><ol>
		<li>
			<label>Update Tags</label>
			<input type="checkbox" name="settings[flg_tags]" value="1"<?php if( (isset($settings['flg_tags']) && $settings['flg_tags']==1) ){?> checked="checked"<?php } ?> id="advanced" />
			<p class="helper"><font color="Red">Note:</font> Provide tags to be added to posts.</p>
		</li>
		<div class="advanced"<?php if( (!isset($settings['flg_tags']) || $settings['flg_tags']!=1) ){?> style="display:none;"<?php } ?> >
			<li>
				<label>Tags</label>
				<input type="text" name="settings[advanced][keywords]" value="<?php echo ( isset($settings['advanced']['keywords']) )?$settings['advanced']['keywords']:""; ?>" class="advanced_settings" />
				<p class="helper"><font color="Red">Note:</font> Input tags separated by comma e.g. tag1, tag2, tag3.</p>
			</li>
			<li>
				<label>Add provided tags to existing tags</label>
				<input type="radio" name="settings[advanced][type]" value="1"<?php if( !isset($settings['advanced']['type']) || (isset($settings['advanced']['type']) && $settings['advanced']['type']==1) ){?> checked="checked"<?php } ?> class="advanced_settings" />
			</li>
			<li>
				<label>Update tags using provided tags randomly</label>
				<input type="radio" name="settings[advanced][type]" value="2"<?php if( (isset($settings['advanced']['type']) && $settings['advanced']['type']==2) ){?> checked="checked"<?php } ?> class="advanced_settings" />
			</li>
			<li>
				<label>Edit Type</label>
				<select name="settings[advanced][update]" class="advanced_settings" >
					<option value="1" <?php if( isset($settings['advanced']['update']) && $settings['advanced']['update']=="1" ) echo 'selected="selected"'; ?>>Update tags in the selected content</option>
					<option value="2" <?php if( isset($settings['advanced']['update']) && $settings['advanced']['update']=="2" ) echo 'selected="selected"'; ?>>Update tags on all site</option>
				</select>
			</li>
		</div>
	</ol></fieldset></div>
</div>



</div></div>

</form>
<script type="text/javascript">
window.addEvent('domready', function(){

	$('create_link').addEvent('change',function(){
		if( !this.checked ){
			$$('.create_link_settings').set('disabled','disabled');
			$$('.create_link').hide();
		}else{
			$$('.create_link').show();
			$$('.create_link_settings').each(function(elt){
				elt.erase('disabled');
			});
		}
	});
	
	$('upgrade_images').addEvent('change',function(){
		if( !this.checked ){
			$$('.upgrade_images_settings').set('disabled','disabled');
			$$('.upgrade_images').hide();
		}else{
			$$('.upgrade_images').show();
			$$('.upgrade_images_settings').each(function(elt){
				elt.erase('disabled');
			});
		}
	});
	
	$('advanced').addEvent('change',function(){
		if( !this.checked ){
			$$('.advanced_settings').set('disabled','disabled');
			$$('.advanced').hide();
		}else{
			$$('.advanced').show();
			$$('.advanced_settings').each(function(elt){
				elt.erase('disabled');
			});
		}
	});
	
	$('get_list').addEvent('click',function(){
		new Request.JSON({
			url: 'admin-ajax.php',
			method: 'post',
			data:{
				action: 'getcontents',
				keyword: $('search_keyword').get('value')
			},
			onRequest: function(){
				$('get_list').set('value', 'Loading...');
			},
			onSuccess: function(request){
				$('search_result').empty();
				if( request.replacedCounter == 0 ){
					new Element( 'p', {html: 'Nothing Found'}).inject($('search_result'));
				}else{
					new Element( 'p', {html: 'Found: '+request.replacedCounter}).inject($('search_result'));
				}
				Object.each(request.links, function( value, key ){
					stringType='';
					var _s=_s2="";
					if( request.type_counter[key] > 1 ){
						_s="s";
					}
					if( request.all_counter[key] > 1 ){
						_s2="s";
					}
					if( key == 'post' ){
						stringType=request.type_counter[key]+' Post'+_s+' Found Out Of '+request.all_counter[key]+' Post'+_s2;
					}else if ( key == 'page' ){
						stringType=request.type_counter[key]+' Page'+_s+' Found Out Of '+request.all_counter[key]+' Page'+_s2;
					}else if ( key == 'category' ){
						if( _s == '' ){
							_s ='y';
						}else{
							_s ='ies';
						}
						if( _s2 == '' ){
							_s2 ='y';
						}else{
							_s2 ='ies';
						}
						stringType=request.type_counter[key]+' Categor'+_s+' Found Out Of '+request.all_counter[key]+' Categor'+_s2;
					}else if ( key == 'post_tag' ){
						stringType=request.type_counter[key]+' Tag'+_s+' Found Out Of '+request.all_counter[key]+' Tag'+_s2;
					}else{
						stringType=request.type_counter[key]+' Data'+_s+' Found Out Of '+request.all_counter[key]+' Data'+_s2;
					}
					new Element( 'p', {html: stringType}).inject($('search_result'));
					Object.each(value, function( data, postId ){
						if( data.counter > 1 ){
							_s="s";
						}else{
							_s="";
						}
						new Element( 'input', { type:'hidden', name:'arrExclude[url]['+postId+']', value:data.url }).inject($('search_result'));
						new Element( 'input', { type:'checkbox', name:'arrExclude[name]['+postId+']', value:'On' }).inject($('search_result'));
						new Element( 'span', { html: data.counter+' Occurrence'+_s+': ' }).inject($('search_result'));
						new Element( 'a', { html: data.name, href: data.url, target: '_blank' }).inject($('search_result'));
						new Element( 'br' ).inject($('search_result'));
					});
				});
				$('get_list').set('value', 'New search');
			},
			onFailure: function(){
				new Element( 'p', {html: 'Sorry, your request failed'}).inject($('search_result'));
				myElement.set('text', ' :(');
				$('get_list').set('value', 'Check again!');
			}
		}).send();
	});

	$('select_appearance').addEvent('change',function(){
		$$('.hide_appearances').hide();
		$$('.appearance_'+this.value).show();
	});
});
</script>