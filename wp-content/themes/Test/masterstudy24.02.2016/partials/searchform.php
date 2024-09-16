<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		
			<div class="modal-body heading_font">
				<div class="search-title"><?php _e('Search', STM_DOMAIN); ?></div>
				<form role="search" method="get" id="searchform" action="<?php echo( home_url( '/' ) ); ?>">
				    <div class="search-wrapper">
				        <input placeholder="<?php _e('Start typing here...', STM_DOMAIN); ?>" type="text" class="form-control search-input" value="<?php echo get_search_query(); ?>" name="s" id="s" />
				        <button type="submit" class="search-submit" ><i class="fa fa-search"></i></button>
				    </div>
				</form>
			</div>
		
		</div>
	</div>
</div>