<form method="get" class="search group" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<fieldset>
		<legend class="hidden">Surchformular</legend>
		<label for="s" class="hidden"><?php _e( 'Search', 'Takelage' ); ?></label>
		<input type="text" class="searchfield" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php esc_attr_e( 'Search &hellip;', 'Takelage' ); ?>" />
		<button type="submit" class="searchbutton" name="submit"><span><?php esc_attr_e( 'Search', 'Takelage' ); ?></span></button>
	</fieldset>
</form>
