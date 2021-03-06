<?php
/*
Template Name: ViDA - Sales Funnel Thin
*/

get_header(); 

?>

	<?php	
	
	$vida_show_header = false;
	
	$sales_posts_class = 'sales-thanks';
	
	?>

	<div class="container">
	  <div class="row">
		<div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
	
			<div id="primary" class="sales-content-area">
			
				<main id="main" class="site-main" role="main">
				
				<?php 
				
				  $vida_custom_header_html  = vida_get_metabox( 'vida_custom_header_html' );
				
				  if ( $vida_custom_header_html ) :
				
					printf( '<div id="sales-custom-header">%s</div>', $vida_custom_header_html );
					
					$sales_posts_class = 'sales-funnel custom-header';
					
				  endif;				
				
				?>
				
					<article id="post-<?php the_ID(); ?>" <?php $sales_posts_class; ?>>
					
						<?php if ( $vida_show_header ) : ?>
							<header class="entry-header">
								<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
							</header><!-- .entry-header -->
							
						<?php endif; ?>

						<div class="entry-content">
						
						  <?php while ( have_posts() ) : the_post(); ?>
							
							<?php the_content(); ?>
							<?php
								wp_link_pages( array(
									'before' => '<div class="page-links">' . __( 'Pages:', 'moesia' ),
									'after'  => '</div>',
								) );
							?>
							
						  <?php endwhile; // end of the loop. ?>
						  
						</div><!-- .entry-content -->
						
						<footer class="entry-footer">
							<?php edit_post_link( __( 'Edit', 'moesia' ), '<span class="edit-link">', '</span>' ); ?>
						</footer><!-- .entry-footer -->
					
					</article>

				</main><!-- #main -->
				
			</div><!-- #primary -->
	
		</div>
	  </div>
	</div>	

<?php get_footer(); ?>
