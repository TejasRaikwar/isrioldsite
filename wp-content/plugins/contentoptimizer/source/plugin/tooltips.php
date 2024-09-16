<div class="wrap"><h2>Manage Tooltips</h2></div>

<?php if ( isset($replacedCounter) ){ ?>
<div id="message" class="updated fade"><p><?php if( $replacedCounter==0 ){?>
	<span style="color:red">Nothing found.</span>
	<?php }elseif( $replacedCounter!=0 ){?>
	<span style="color:green">Processed <?php echo $replacedCounter;?> element(s).</span>
	<?php } ?></p></div>
<?php } ?>


<?php if( isset( $_GET['action'] ) && $_GET['action'] == 'edit' && isset( $_GET['id'] ) ){ ?>
<form id="project_form" class="postbox_form" method="post" action="?page=manage-tooltips" enctype="multipart/form-data">
<div class="postbox-container" style="width:50%;"><div class="meta-box-sortables" style="padding:5px;">
<?php $flgCreateTooltipCheckbox=false; include_once( COPTIMIZER_PATH.'/source/plugin/tooltips-create.php' ); ?>
</div></div>
<div class="postbox-container" style="width:50%;"><div class="meta-box-sortables" style="padding:5px;">
<div class="postbox">
	<h3 class="hndle">Posts</h3>
	<div class="inside" style="max-height:744px; overflow: auto;"><fieldset><ol>
		<?php if( !empty( $postIds ) ){
			foreach( $postIds as $postId ){ ?>
			<a href="<?php echo get_permalink( $postId );?>" target="_blank"><?php echo get_the_title( $postId );?></a><br>
		<?php }
		} ?>
	</ol></fieldset></div>
</div>
</div></div>
<div class="postbox-container" style="width:100%;">
	<input type="hidden" name="settings[tooltip][id]" value="<?php echo ( isset($settings['tooltip']['id']) )?$settings['tooltip']['id']:''; ?>" />
	<input type="hidden" name="settings[tooltip][keyword]" value="<?php echo ( isset($settings['tooltip']['keyword']) )?$settings['tooltip']['keyword']:''; ?>" />
	<input type="hidden" name="settings[tooltip][replace]" value="<?php echo ( isset($settings['tooltip']['replace']) )?$settings['tooltip']['replace']:''; ?>" />
	<input type="submit" class="button-secondary action" value="Update" name="action" />
</div>
</form>
<?php } ?>



<form method="post" id="manager_form" action="?page=manage-tooltips">
<div class="tablenav top">
	<div class="alignleft actions">
		<select name="action">
			<option selected="selected" value="">Bulk Actions</option>
			<option value="trash">Delete</option>
		</select>
		<input id="doaction" class="button-secondary action" type="submit" value="Apply" name="">
	</div>
</div>
<input type="hidden" name="page" value="manage-tooltips">
<table class="wp-list-table widefat fixed" cellspacing="0">
	<thead>
		<tr>
			<th scope="col" id="cb" class="manage-column column check-column">
				<input type="checkbox">
			</th>
			<th scope="col" class="manage-column">
				<span>Keyword</span>
			</th>
			<th scope="col" class="manage-column">
				<span>Replace</span>
			</th>
			<th scope="col" class="manage-column">
				<span>Number of Posts</span>
			</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th scope="col" id="cb" class="manage-column column check-column">
				<input type="checkbox">
			</th>
			<th scope="col" class="manage-column">
				<span>Keyword</span>
			</th>
			<th scope="col" class="manage-column">
				<span>Replace</span>
			</th>
			<th scope="col" class="manage-column">
				<span>Number of Posts</span>
			</th>
		</tr>
	</tfoot>
	<tbody id="the-list"><?php
	if( !empty( $arrList ) ){
		foreach( $arrList as $item ){
?>	<tr id="post-2" class="alternate author-self status-publish format-default iedit" valign="top">
			<th scope="row" class="check-column"><input name="items[]" value="<?php echo $item['settings']['id'];?>" type="checkbox" id="check-<?php echo $item['settings']['id'];?>"></th>
			<td>
				<strong>
					<a class="row-title" title="Edit tooltip" href="?page=manage-tooltips&action=edit&id=<?php echo $item['settings']['id'];?>"><?php echo (empty($item['settings']['keyword']))?$item['settings']['id']:$item['settings']['keyword'];?></a>
				</strong>
				<div class="row-actions">
					<span class="view"><a rel="permalink" title="Edit tooltip" href="?page=manage-tooltips&action=edit&id=<?php echo $item['settings']['id'];?>">Edit</a>&nbsp;|&nbsp;</span>
					<span class="trash"><a href="#" rel="<?php echo $item['settings']['id'];?>" class="click-me-del-manage" id="<?php echo $item['settings']['id'];?>" title="Delete tooltip" >Delete</a></span>
				</div>
			</td>
			<td>
				<?php echo $item['settings']['replace'];?>
			</td>
			<td>
				<a href="#" class="show-updated-posts" rel="<?php echo $item['settings']['id'];?>"><?php echo count( $item['postIds'] );?></a>
			</td>
		</tr>
		<tr>
			<td style="display:none;" id="view-posts-<?php echo $item['settings']['id'];?>" colspan="4">

				<?php if( !empty( $item['postIds'] ) ){
					foreach( $item['postIds'] as $postId ){ ?>
					<a href="<?php echo get_permalink( $postId );?>" target="_blank"><?php echo get_the_title( $postId );?></a><br>
				<?php }
				} ?>
			</div>
			</td>
		</tr><?php
		}
	}else{
?>	<tr class="alternate author-self status-publish format-default iedit" valign="top">
			<td colspan="3">No tooltips</td>
		</tr><?php
	}
?> </tbody>
</table>
<div class="tablenav bottom">
	<div class="alignleft actions">
		<select name="action2">
			<option selected="selected" value="">Bulk Actions</option>
			<option value="trash">Move to Trash</option>
		</select>
		<input id="doaction2" class="button-secondary action" type="submit" value="Apply" name="">
	</div>
	<div class="tablenav-pages"><?php
		$noInput=1;
		include Amazonpub::$pathName."/source/pagination.php";
?></div>
</div>
</form>
<script type="text/javascript">
$$('.click-me-del-manage').addEvent('click',function(e){
	e && e.stop();
	var el='check-'+this.get('id');
	if ( !$(el).get('checked') ) {
		$(el).set('checked',true);
		if ($(el).get('checked')) {
			$$('select[name="action"] option[value="trash"]')[0].set('selected','selected');
			$('manager_form').submit();
		}
		$(el).set('checked',false);
	}
});
$$('.show-updated-posts').addEvent('click',function(e){
	e && e.stop();
	var el='view-posts-'+this.get('rel');
	if ( $(el).getStyle('display') == 'none' ) {
		$(el).setStyle("display", "table-cell");
	}else{
		$(el).setStyle("display", "none");
	}
});
</script>