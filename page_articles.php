<?php
/**
 * Template Name: Articles
 *
 *
 * @package Moesia
 */

get_header(); ?>

	
	<?php get_template_part( 'includes/articles', 'menu' ); ?>

	<div id="primary" class="content-area">

		<?php if ( is_active_sidebar( 'article-header-widget' ) && is_page('1536')) : ?>
	
			<div id="articleheaderform">
			
				<?php dynamic_sidebar( 'article-header-widget' ); ?>
				
			</div>
		
		<?php endif; ?>
		
		
		<main id="main" class="site-main articulos" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'includes/content', 'articles' ); ?>

				<?php
					// load up the comment template if needed
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar('articles'); ?>
<?php get_footer(); ?>
