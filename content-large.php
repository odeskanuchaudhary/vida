<?php
/**
 * @package Moesia
 * @theme moesia-vida
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix big-image'); ?>>

	<div class="post-content">    
    
		<header class="entry-header">			
			<?php the_title( sprintf( '<h3 class="h1 entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
		</header><!-- .entry-header -->
    
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumb">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" >
				<?php 
				
				ob_start();
				
				the_post_thumbnail('vida-blog-full', array( 'class' => 'lazy aligncenter img-responsive' ) );
				
				$post_thumb = ob_get_clean();
				
				$src_replace = sprintf( 'src="%s" data-src=', VIDA_IMAGE_PLACEHOLDER );
				
				
				echo str_replace( 'src=', $src_replace, $post_thumb );
				
				?>
			</a>			
		</div>	
	<?php endif; ?>

		<div class="entry-summary">
			<?php if ( (get_theme_mod('full_content') == 1) && is_home() ) : ?>
				<?php the_content(); ?>
			<?php else : ?>
				<?php the_excerpt(); ?>
      
			<a href="<?php the_permalink(); ?>" class="read-more" rel="bookmark">Click to Continue</a>
			<?php endif; ?>
		</div><!-- .entry-content -->
		
	</div>

</article><!-- #post-## -->