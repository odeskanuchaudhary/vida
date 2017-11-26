<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Moesia
 */
?>
		<?php tha_content_bottom(); ?>
		</div><!-- #content -->
		<?php tha_content_after(); ?>
		

	<?php
	// filter to show or hide footer, useful for sales pages.
	if ( ! apply_filters( 'hide_vida_footer', TRUE ) ) :
	
	?>

			<?php tha_footer_before(); ?>
			<?php if ( is_active_sidebar( 'sidebar-3' ) || is_active_sidebar( 'sidebar-4' ) || is_active_sidebar( 'sidebar-5' ) ) : ?>
				<?php get_sidebar('footer'); ?>
			<?php endif; ?>

			<footer id="colophon" class="site-footer" role="contentinfo">
				<?php tha_footer_top(); ?>
				<div class="site-info container">
					&copy; <?php echo date('Y'); ?> VIDA - Virtual Dating Assistants. All Rights Reserved.
				</div><!-- .site-info -->
			</footer><!-- #colophon -->
			<?php tha_footer_after(); ?>
		</div><!-- #page -->
	
	
	<?php endif; ?>
	
<?php wp_footer(); ?>

<?php vida_body_end(); ?>
</body>
</html>