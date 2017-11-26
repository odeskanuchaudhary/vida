<?php
/**
 * @package Moesia
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( (has_post_thumbnail()) && ( get_theme_mod( 'moesia_post_img' )) ) : ?>
		<div class="single-thumb">
			<?php the_post_thumbnail(); ?>
		</div>	
	<?php endif; ?>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); 
		
		/*?>
		<div class="entry-meta">
			<?php moesia_posted_on(); ?>
		</div><!-- .entry-meta --><?php */ ?>
		
	</header><!-- .entry-header -->

	<div class="entry-content">
	
	<?php
		
	/* Add Audio tag for podcast categories */
		
	if ( in_category('podcasts') ) :
	
		//get powerpress details for the podcast, using the 'enclosure' custom field
		$pod_details = get_post_meta( get_the_ID(), 'enclosure', true );		

		//get audio filename from $pod_details - since this is an array, we check with the mp3 extension
		$pod_audio_url = strstr($pod_details, '.mp3', true);

		//if we have an audio, included embed code
		if ( null != $pod_audio_url ) {
			
		?>
		
		<div class="vida-audio-podcast">
			
			<audio controls preload="auto" class="fullwidth">
				<source src="<?php echo $pod_audio_url ?>.mp3" type="audio/mpeg">
				<embed type="application/x-shockwave-flash" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" flashvars="audioUrl=<?php echo $pod_audio_url ?>.mp3" width="100%" height="27" quality="best"></embed>
			</audio>

			<div id="player_fallback"></div>

			<script type="text/javascript">// Fallback for Firefox
				jQuery(document).ready(function($){
					var audioTag = $('.pid-<?php echo $post->ID ?> audio');
					if ( $.browser.mozilla == true ) {
						var fallback = '<embed type="application/x-shockwave-flash" flashvars="audioUrl=<?php echo $pod_audio_url; ?>.mp3" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="100%" height="27" quality="best">';
						audioTag.hide();
						audioTag.after( fallback );
					}
				});
			</script>

		</div>
		
		<?php
		}
		
	endif; //ends in_category
	
	?>

	<?php the_content(); ?>

	</div><!-- .entry-content -->

</article><!-- #post-## -->