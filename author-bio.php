<?php
/**
 * Author bio
 *
 */
 
 
if ( apply_filters( 'vida_bio_active', TRUE ) )
	return;	
?>

<div class="author-bio vida-bio-box clearfix">
	
	<div class="col-md-12 col-sm-12 col-xs-12">
		<h3 class="h2 no-margin-top">
			<strong><?php print( __('About ViDA', 'moesia') ); ?></strong>		
		</h3>
	
		<p class="">
			<?php 
		
			if ( is_singular( 'post' ) ) :
			
				echo esc_html(the_author_meta( 'description' ));
					
			elseif( is_singular( 'matchmaking' ) ) :
			
				$category_description = '<p><a href="https://www.virtualdatingassistants.com/">ViDA</a> is your personalized, highly-confidential service that takes a more modern approach to introducing you to your ideal match. Instead of working with a single matchmaker using a tiny rolodex of potential partners, our team of matchmakers tap into the world’s largest database of available singles. We quickly single out the matches who meet all of your criteria and get you on a date where you can finally experience true chemistry. We’ve helped thousands discover true love and we’re ready to make you our next success story. Ready to finally meet your ideal partner? Schedule your free confidential consultation with us now:</p>
				
				<p class="text-center">[vida_button link="/matchmaker-consultation" class="blue-btn" ]<strong><i class="fa fa-mars"></i></strong>  Men Click Here[/vida_button]   [vida_button link="/matchmaker-consultation-women" class="pink-btn" ]<strong><i class="fa fa-venus"></i></strong>  Women Click Here[/vida_button]</p>';
			
				echo apply_filters( 'category_archive_meta', '<div class="about-vida-cat-description">' . do_shortcode( $category_description ) . '</div>' );				
				
			endif;
			
			?>
		</p>
		
	</div>
</div> 

<?php

add_filter( 'vida_bio_active', '__return_true' );