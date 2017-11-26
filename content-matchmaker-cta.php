<?php
/**
 * The template used for displaying matchmaker CTA at bottom of blog posts.
 *
 * @package Moesia-Vida
 */
 	
?>
			 
<div id="matchmaker-cta" class="vida-wide clearfix">

  <div class="row">
  
	<div class="col-lg-7 col-xs-12">
	
		<div class="matchmaker-cta-img  text-center">
			<?php 
			
			$fci_img = ViDA_get_URI_static( 'matchmaker_cta_img.jpg', 'files/images' );
			
			printf( '<img alt="Free Consultation" class="img-responsive aligncenter" src="%s" width="400" height="265" />', esc_url($fci_img) );	
			
			 ?>
			 
		</div>
		
	</div>
	
	<div class="col-lg-5 col-xs-12">

		<div class="matchmaker-cta-content  text-center">
		  
	
			<p class="h4"><strong><em><span style="color: #ef5a29">A 20-minute call with one of our matchmakers is all it takes to meet the love of your life.</span></em></strong></p>
			
			<p style=""><span>If you're finally ready to meet your perfect match, book your confidential consultation with us now.</span></p>
			
			<ul class="matchmaker-btns list-inline">
				<li>
					<a class="mens-btn" href="<?php echo home_url('/') ?>">Men Click<br />HERE</a>
				</li>
				<li>
					<a class="womens-btn" href="/women">Women Click<br />HERE</a>	   
				</li>
			</ul>
	
		</div>
		
	</div>

  </div>
  
</div>
