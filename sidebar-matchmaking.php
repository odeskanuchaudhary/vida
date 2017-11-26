<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Moesia
 */

if ( ! ( is_active_sidebar( 'sidebar-matchmaking' ) )  ){
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-matchmaking' );	?>
</div><!-- #secondary -->
