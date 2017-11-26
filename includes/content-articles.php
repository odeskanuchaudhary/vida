<?php
/**
 * The template used for displaying page content in page-articles
 *
 * @package Moesia
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<style>
.content-area .articulos {
	font: normal 16px/1.57142857 Arial,"Helvetica Neue",Helvetica,sans-serif !important;
}

 .content-area .articulos .hentry {
	   padding-top: 0;
 }
 
  .content-area .articulos h1 {
	font-family: Arial, Tahoma, Verdana !important;
	font-size: 36px;
	text-shadow: 2px 2px 8px rgba(150, 150, 150, 1) !important;
  }

	.content-area .articulos h2 {
	  font-size: inherit;
	  padding-bottom: 15px !important;
	  font-family: Arial, Tahoma, Verdana !important;	
		
	}
	
	.content-area .articulos h3 {	
	  font-family: Arial, Tahoma, Verdana !important;
	  font-size: 18px !important;
	  font-weight: normal !important;
	  line-height: 24px !important;
	  margin-top: 15px !important;
	  color: #111 !important;
	}
	
	.content-area .articulos h4 {
	  font-family: Arial, Tahoma, Verdana !important;
	  font-size: 16px !important;
	  font-weight: normal !important;
	  line-height: 20px !important;
	}
	
	.content-area .articulos p {
		margin-bottom: 20px;
		
	}
	
	.content-area .articulos hr {
		border-top: #111 1px solid;
	}
	
	  .content-area .articulos #related-articulos {		
		  font: normal 16px/1.57142857 Arial,"Helvetica Neue",Helvetica,sans-serif;
	  }
	  
		.content-area .articulos #related-articulos .articlethumb {
		  float: left;
		  margin: 15px 35px 35px 0px;
		}
		
			.content-area .articulos #related-articulos .articlethumb img {
			  width: 150px !important;
			  height: auto !important;
			  -webkit-box-shadow: -4px 3px 5px rgba(50, 50, 50, 0.25);
			  -moz-box-shadow: -4px 3px 5px rgba(50, 50, 50, 0.25);
			  box-shadow: -4px 3px 5px rgba(50, 50, 50, 0.25);
			}
	
		.content-area .articulos #related-articulos h2 {
			padding: 10px 0 10px !important;
			margin: 5px 0 10px !important;
		}
		
		.content-area .articulos #related-articulos h2 a, .content-area .articulos #related-articulos h2 a:hover {
		  font-size: 19px;
		  color: #b30a0a;
		  text-decoration: underline;
		  padding: 0 !important;
		  margin: 0 !important;
		}
		
		.content-area .articulos #related-articulos .rtext p {
		  font-size: 1.6rem;
		  padding: 0;
		  color: #111 !important;
		  margin-bottom: 20px;
		}
		
			.content-area .articulos #related-articulos .read-more {
			  background: #606163 !important;
			  font-size: 1.6rem !important;
			  padding: 15px 35px !important;
			  font-family: 'museo300', Arial, Tahoma !important;
			  text-decoration: underline !important;
			  color: #ededed;
			}
			  .content-area .articulos #related-articulos .read-more:hover {
				 color: #ffffff;
			  }
			
			
		.content-area .articulos #related-articulos .clear {
			height: 0;
		}
		
		.content-area .articulos .entry-summary a.read-more {
			margin: 5px 0 5px !important;			
		}
		
		
	@media (min-width: 768px) {
		
		.content-area .articulos h1 {
			font-size: 54px !important;		
		}
		.content-area .articulos h2 {
			font-size: 24px;
		}
		
	}
	
</style>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title"><strong><span style="color: #b30a0a;">', '</span></strong></h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'moesia' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	
			<?php get_template_part( 'includes/articles', 'related' ); ?>				

					
	<footer class="entry-footer">
		<?php edit_post_link( __( 'Edit', 'moesia' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
