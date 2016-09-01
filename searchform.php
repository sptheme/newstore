<?php
/**
 * The template for displaying search forms in Underscores.me
 *
 * @package newstore
 */
?>
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
		<div class="input-group">
			<input type="search" class="field form-control" name="s" id="s" placeholder="<?php esc_attr_e( 'Search &hellip;', 'newstore' ); ?>" />
			<?php if ( defined( 'ICL_LANGUAGE_CODE' ) ) { ?>
				<input type="hidden" name="lang" value="<?php echo( ICL_LANGUAGE_CODE ); ?>"/>
			<?php } ?>
			<span class="input-group-btn">
				<button type="submit" class="btn btn-primary">
				  <span class="fa fa-search"></span>
				</button>
			</span>
		</div>
	</form>
