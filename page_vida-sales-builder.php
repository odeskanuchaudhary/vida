<?php
/*
Template Name: ViDA - Sales Funnel - Page Builder
*/

get_header(); ?>

	<div id="primary" class="sales-content-area">
	
		<main id="main" class="site-main vida-gray-bg" role="main">

			<div class="entry-content clearfix">
			
			  <?php while ( have_posts() ) : the_post(); ?>
				
				<?php the_content(); ?>
				<?php
					wp_link_pages( array(
						'before' => '<div class="page-links">' . __( 'Pages:', 'moesia' ),
						'after'  => '</div>',
					) );
				?>
				
			  <?php endwhile; // end of the loop. ?>
			  
			  <?php do_action( 'vida_privacyterms' ); ?>
			  
			</div><!-- .entry-content -->

		</main><!-- #main -->
		
	</div><!-- #primary -->

<?php get_footer(); ?>
