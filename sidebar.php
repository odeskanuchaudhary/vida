<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Moesia
 */

if ( ! ( is_active_sidebar( 'sidebar-1' ) || is_active_sidebar( 'sidebar-optin' ) )  ){
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php if ( ! ( is_singular( 'matchmaking' ) || is_page( 'matchmaking-blog' ) || is_post_type_archive( 'matchmaking' ) ) ) dynamic_sidebar( 'sidebar-optin' ); ?>
	<?php //dynamic_sidebar( 'sidebar-search' ); ?>
	<?php
		if ( is_singular( 'matchmaking' ) || is_page( 'matchmaking-blog' ) || is_post_type_archive( 'matchmaking' ) )
			dynamic_sidebar( 'sidebar-matchmaking' );
		else
			dynamic_sidebar( 'sidebar-1' );
	?>
</div><!-- #secondary -->
