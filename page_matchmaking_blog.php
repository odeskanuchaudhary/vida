<?php
/**
Template Name: Matchmaking Blog
*/

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php 
		
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		
		$args = array(
			'post_type'        => 'matchmaking',
			'orderby'          => 'post_date',
			'order'            => 'DESC',			
			'post_status'      => 'publish',
			'paged'			   => $paged,
		); 

		$wp_query = new WP_Query($args); 
		
		if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					if ( get_theme_mod('blog_layout') == 'large-images' )  {
						get_template_part( 'content', 'large' );	
					} else {
						get_template_part( 'content', get_post_format() );	
					}

				?>

			<?php endwhile; ?>	
		
			
		<?php wp_reset_postdata(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>
		
		<?php moesia_paging_nav(); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar('matchmaking'); ?>
<?php get_footer(); ?>
