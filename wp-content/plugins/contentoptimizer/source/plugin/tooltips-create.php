<div class="postbox"><div class="handlediv" title="Click to toggle"><br></div>
	<h3 class="hndle">Tooltips</h3>
	<div class="inside"><fieldset><ol>
		<?php if( $flgCreateTooltipCheckbox ){ ?>
		<li>
			<label>Create Tooltip</label><input type="checkbox" name="settings[create_tooltip]" value="1"<?php if( (isset($settings['create_tooltip']) && $settings['create_tooltip']==1) ){?> checked="checked"<?php } ?> id="create_tooltip" />
			<p class="helper"><font color="Red">Note:</font> Add tooltip for the provided keyword/text.</p>
		</li>
		<div class="create_tooltip"<?php if( (!isset($settings['create_tooltip']) || $settings['create_tooltip']!=1) ){?> style="display:none;"<?php } ?>>
		<?php } ?>
			<li>
				<label>Change Keyword Colors</label>
				<input type="checkbox" id="flg_keyword_colors" name="settings[tooltip][flg_keyword_colors]"<?php echo ( isset($settings['tooltip']['flg_keyword_colors']) )?' checked="checked"':''; ?> />
			</li>
			<li class="flg_keyword_colors"<?php echo ( isset($settings['tooltip']['flg_keyword_colors']) )?'':'style="display:none;"'; ?>>
				<label>Keyword Color</label>
				<label for="keyword_color" >
					<input type="text" id="keyword_color" name="settings[tooltip][keyword_color]" value="<?php echo ( isset($settings['tooltip']['keyword_color']) )?$settings['tooltip']['keyword_color']:"#000000"; ?>" class="my-color-field" data-default-color="#000000"/>
				</label>
			</li>
			<li class="flg_keyword_colors"<?php echo ( isset($settings['tooltip']['flg_keyword_colors']) )?'':'style="display:none;"'; ?>>
				<label>Keyword Background Color</label>
				<label for="background_color">
					<input type="text" id="background_color" name="settings[tooltip][background_color]" value="<?php echo ( isset($settings['tooltip']['background_color']) )?$settings['tooltip']['background_color']:"#ffffff"; ?>" class="my-color-field" data-default-color="#ffffff"/>
				</label>
			</li>
			<li>
				<label>Tooltip Box Content</label>
				<div class="wp_editor">
				<?php wp_editor( ( isset($settings['tooltip']['html']) )?stripslashes( $settings['tooltip']['html'] ):'Input Your Content Here', "tooltip_html", array( 'textarea_name'=>'settings[tooltip][html]', 'textarea_rows'=>7 ) ); ?>
				</div>
			</li>
			<li>
				<label>Tooltip Box Background Color</label>
				<label for="box_background_color">
					<input type="text" id="box_background_color" name="settings[tooltip][box_background_color]" value="<?php echo ( isset($settings['tooltip']['box_background_color']) )?$settings['tooltip']['box_background_color']:"#eeeeee"; ?>" class="my-color-field" data-default-color="#eeeeee" />
				</label>
			</li>
			<li>
				<label>Tooltip Box Opacity</label>
				<input type="text" name="settings[tooltip][box_opacity]" value="<?php echo ( isset($settings['tooltip']['box_opacity']) )?$settings['tooltip']['box_opacity']:"0.95"; ?>" />
			</li>
			<li>
				<label>Tooltip Box Automatic Width</label>
				<input type="checkbox" id="box_flg_width" name="settings[tooltip][box_flg_width]"<?php echo ( isset($settings['tooltip']['box_flg_width']) )?' checked="checked"':''; ?> />
			</li>
			<li>
				<label>Tooltip Box Width (px)</label>
				<input type="text" class="box_flg_width" name="settings[tooltip][box_width]" value="<?php echo ( isset($settings['tooltip']['box_width']) )?$settings['tooltip']['box_width']:"350"; ?>" disabled="disabled" />
			</li>
			<li>
				<label>Tooltip Box Padding (px)</label>
				<input type="text" name="settings[tooltip][box_padding]" value="<?php echo ( isset($settings['tooltip']['box_padding']) )?$settings['tooltip']['box_padding']:"10"; ?>" />
			</li>
			<li>
				<label>Tooltip Box Border Color</label>
				<label for="box_border_color">
					<input type="text" id="box_border_color" name="settings[tooltip][box_border_color]" value="<?php echo ( isset($settings['tooltip']['box_border_color']) )?$settings['tooltip']['box_border_color']:"#3F3F3F"; ?>" class="my-color-field" data-default-color="#3F3F3F" />
				</label>
			</li>
			<li>
				<label>Tooltip Box Border Width (px)</label>
				<input type="text" name="settings[tooltip][box_border_width]" value="<?php echo ( isset($settings['tooltip']['box_border_width']) )?$settings['tooltip']['box_border_width']:"1"; ?>" />
			</li>
			<li>
				<label>Tooltip Box Border Radius (px)</label>
				<input type="text" name="settings[tooltip][box_border_radius]" value="<?php echo ( isset($settings['tooltip']['box_border_radius']) )?$settings['tooltip']['box_border_radius']:"0"; ?>" />
			</li>
			<li>
				<label>Tooltip Box Stylesheet (css)</label>
				<textarea name="settings[tooltip][box_stylesheet]" cols="57" rows="3"><?php if( (isset($settings['tooltip']['box_stylesheet']) ) ) echo $settings['tooltip']['box_stylesheet'];?></textarea>
			</li>
		<?php if( $flgCreateTooltipCheckbox ){ ?>
		</div>
		<?php } ?>
	</ol></fieldset></div>
</div>
<script type="text/javascript">
window.addEvent('domready', function(){
	
	jQuery('#keyword_color').wpColorPicker({
		defaultColor: true
	});
	jQuery('#background_color').wpColorPicker({
		defaultColor: true
	});
	jQuery('#box_background_color').wpColorPicker({
		defaultColor: true
	});
	jQuery('#box_border_color').wpColorPicker({
		defaultColor: true
	});
	
	<?php if( $flgCreateTooltipCheckbox ){ ?>
	$('create_tooltip').addEvent('change',function(){
		if( !this.checked ){
			$$('.create_tooltip_settings').set('disabled','disabled');
			$$('.create_tooltip').hide();
		}else{
			$$('.create_tooltip').show();
			$$('.create_tooltip_settings').each(function(elt){
				elt.erase('disabled');
			});
		}
	});
	<?php } ?>
	
	$('box_flg_width').addEvent('change',function(){
		if( this.checked ){
			$$('.box_flg_width').set('disabled','disabled');
		}else{
			$$('.box_flg_width').each(function(elt){
				elt.erase('disabled');
			});
		}
	});
	
	$('flg_keyword_colors').addEvent('change',function(){
		if( !this.checked ){
			$$('.flg_keyword_colors').hide();
		}else{
			$$('.flg_keyword_colors').each(function(elt){
				elt.show();
			});
		}
	});

});
</script>