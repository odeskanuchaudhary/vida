<?php
/**
 * @package Moesia
 * @Sub-package Moesia-ViDA
 */

get_header(); ?>

	<div id="primary" class="row fullwidth">
		<main id="main" class="site-main" role="main">
		
		<?php while ( have_posts() ) : the_post(); ?>
		
			<div id="vida-testimonials" class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 clearfix">	

				<article id="testimonial-<?php the_ID(); ?>" <?php post_class( 'testimonial text-center clearfix' ); ?>>

					<div class="entry-content testimonial-body">
					
						<?php the_content(); ?>		

					</div><!-- .entry-content -->
					
					<?php 
						$client_name = client_get_meta( 'client_name' ); 
						$client_location = client_get_meta( 'client_location' ); 					
					?>
						
					<h4 class="text-center client-name col-xs-10 col-xs-offset-1"><?php echo $client_name; ?></h4>

					<?php if ($client_location != '') : ?>

						<span class="client-function col-xs-10 col-xs-offset-1"><?php echo esc_html($client_location); ?></span>

					<?php endif;?>	

				</article><!-- #post-## -->
				
			</div>
			
		<?php endwhile; // end of the loop. ?>
			
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>