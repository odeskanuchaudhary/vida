<?php
/**
 * The custom banner for ViDA.
 *
 * @package Moesia
 */

 
if ( (get_theme_mod('moesia_banner') == 1 && is_front_page()) ||  (get_theme_mod('moesia_banner') != 1) ) :

	//get static uri version of BG if exists:
	$bgImg = ViDA_get_URI_static( 'vida_background_1024w.jpg', 'wp-content/themes/moesia-vida/images' );
	$bgImg2 = ViDA_get_URI_static( 'vida_background_1440w.jpg', 'wp-content/themes/moesia-vida/images' );
	$bgImg3 = ViDA_get_URI_static( 'vida_background_1920w.jpg', 'wp-content/themes/moesia-vida/images' );

	?>
<style id="vida-banner-styles" type="text/css">.has-banner:after{z-index:9992}html,body{height:100%;width:100%;margin:0;padding:0}body,#page{height:100%;min-height:100%}header#masthead{display:table;width:100%;max-height:1080px;overflow:hidden;table-layout:fixed;border-collapse:separate;height:100%;min-height:100% !important}header#masthead .banner-row{display:table-row;z-index:9997;width:100%}header#masthead #vida-banner{position:relative;display:table-cell;vertical-align:middle;z-index:9997;margin:0 auto 0;padding:0 0 10px;width:100%;height:100%;max-height:100%;font-size:16px}header#masthead #header-media-logos{display:table-cell !important}#scroll-down{position:absolute;z-index:9997;bottom:5px;left:calc( 50% - 32px );font-size:1.5em;display:block;font-weight:100 !important;outline:none;width:64px;height:64px;border:solid 3px #bbb;-webkit-border-radius:100%;-moz-border-radius:100%;border-radius:100%;text-align:center;-webkit-animation:fadein .5s;-moz-animation:fadein .5s;animation:fadein .5s;-webkit-transition:all 300ms ease-out;-moz-transition:all 300ms ease-out;-o-transition:all 300ms ease-out;-ms-transition:all 300ms ease-out;transition:all 300ms ease-out}.vida-loading #scroll-down{background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB0AAAAQCAYAAADqDXTRAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH4QEEFy0DA4RiwAAAAB1pVFh0Q29tbWVudAAAAAAAQ3JlYXRlZCB3aXRoIEdJTVBkLmUHAAABJ0lEQVQ4y7XTv0sDMRTA8W9sh3OxS+VAanFrQbTVipugkorunVUEQTc5/wJBcHMWxKV7Z1fBzR9FcapjFy3nolOX8hy8SuvV2ubigyx5ST68lwSCuNllGhbmqEkSiyEVUmmSBU5eproSVY+cCxrQpDe1LVgqpJYTwbnOjObCzwDERZhYH2W80V5ZL0ORPDV5IKPeooArO2Sv3oOJ5hMcHU4i8joCNI63+XA6d9TLUNzKm1YcAgFwoXTgo9TXrAix2z0WnXaLI7S6q6Xfw9V41Vx4sQV4KNAGbARGgSOBJrAVcBjYFIz/llCKlgj311BYOmOs2fmd1mKzG+c89/wW3qXP6fxjP1QNUvHd/g+4ZwwG9q30z4oNQTt3bPpozOF/BsOwu2oKfgKsyrAILzEFlgAAAABJRU5ErkJggg==);background-position:50% 50%;background-repeat:no-repeat;background-size:29px 16px;display:none}#scroll-down .fa{line-height:1.25em;color:#bbb;font-weight:100 !important;-webkit-transition:all 300ms ease-out;-moz-transition:all 300ms ease-out;-o-transition:all 300ms ease-out;-ms-transition:all 300ms ease-out;transition:all 300ms ease-out}#scroll-down:hover{border:solid 3px #999}#scroll-down:hover .fa{color:#999}@media all and (min-device-width : 320px) and (max-device-width : 780px) and (orientation:landscape){#scroll-down{position:relative}}#top{position:absolute;display:block;width:100%;height:0;top:46px}#vida-banner > .container{display:block;padding-top:0;padding-left:0;padding-right:0;max-width:100% !important}#vida-welcome-box{display:inherit;-webkit-animation:fadein 1s;animation:fadein 1s}#vida-banner h1{margin-bottom:20px;line-height:1;font-family:arial,serif;font-size:160%;font-size:4.5vmax}#vida-banner h1 span{display:block;margin-bottom:5px}#vida-banner .home-str1,#vida-banner .home-str3{color:#074568;font-family:"ITCAvantGardePro-MdObl", 'Avant Garde', Avantgarde, 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;font-style:italic}#vida-banner .home-str2,#vida-banner .home-str4{color:#3f7f9b;font-family:"ITCAvantGardePro-Bold", 'Avant Garde', Avantgarde, 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;font-weight:bold;font-style:italic}#vida-banner .home-str4{color:#074568}#vida-banner h2{color:#000000;font-family:'RoadRadio', Verdana, Tahoma;font-style:initial;text-transform:uppercase;font-size:2rem;margin-bottom:20px}.banner-form span.group-words{display:block}#vida-banner .banner-form{-webkit-animation:fadein .5s;animation:fadein .5s;position:relative}#vida-banner .banner-form .vida-form{position:relative;-webkit-animation:fadein 1.5s;animation:fadein 1.5s}#vida-banner .banner-form .vida-form::before,#vida-banner .banner-form .vida-form:before{position:relative;content:"";display:block;margin:0 auto;max-width:200px;height:2px;background:#074568}#vida-banner .banner-form .vida-form h3{color:#074568;font-family:Tahoma, Geneva, Verdana, sans-serif;margin-bottom:10px;font-weight:normal;font-size:inherit}.vida-loading #vida-banner .banner-form .vida-form h3{font-weight:bold}.vida-loaded #vida-banner .banner-form .vida-form h3{font-family:'Montserrat', verdana, sans-serif}#vida-banner .banner-form .vida-form input[type="email"],#vida-banner .banner-form .vida-form input[type="text"]{border:#bbb 1px solid;font-size:1.6rem;font-family:inherit;margin-top:10px;margin-bottom:10px;padding:10px 15px;max-width:360px;width:100%}.vida-loading #vida-banner .banner-form .vida-form input[type="email"],.vida-loading #vida-banner .banner-form .vida-form input[type="text"]{font-family:"Trebuchet MS", Helvetica, sans-serif}#vida-banner .banner-form .vida-form button[type="submit"]{width:auto;min-width:160px}@media ( min-width: 640px ) and ( max-width: 1024px ){.has-banner:after{background-image:url(<?php echo $bgImg; ?>)}#vida-banner h2{font-size:2.5rem}}@media only screen and ( min-width: 1025px ){.has-banner:after{background-image:url(<?php echo $bgImg2; ?>)}#vida-banner h1{font-size:5.8rem}#vida-banner h2{font-size:2.5rem;font-size:2.5vmax}}@media only screen and ( min-width: 1440px ){.has-banner:after{background-image:url(<?php echo $bgImg3; ?>)}#vida-banner h1{font-size:6.2rem}}</style>
	
<div class="banner-row">

  <section id="vida-banner">
	
	<div class="container vida-wide clearfix ">
	
	  <div class="row banner-form">
		
		<div class="col-xs-12 col-sm-8 col-sm-offset-4 col-md-7 col-md-offset-5 col-lg-7 col-lg-offset-5 clearfix">
		
			<div id="vida-welcome-box" class="text-center">
			
				<h1 class="">
					<span class="home-str1">Get</span>
					<span class="home-str2">High Quality Dates</span>
					<span class="home-str3">With The Women</span>
					<span class="home-str4">You Want</span>
				</h1>
				
				<h2 class="h4"><span class="group-words">Delivered On</span>A Silver Platter</h2>

			</div>
					
			<div id="" class="row clearfix ">
			
				<div class="vida-form text-center col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

				  <h3>Yes! I'd like to meet my ideal woman today!</h3>

					<div class="vida-ontraport-form moonray-form-p2c21567f527 ussr">
					  <form action="https://forms.ontraport.com/v2.4/form_processor.php?" method="post" accept-charset="UTF-8">
						<div class="col-xs-12">
							<div class="best-email"><input tabindex="0700" name="f1523" type="email" class="best-email moonray-form-input" id="mr-field-element-271265849483" value="" placeholder="Enter Your Best Email..."/></div>
							<input name="email" tabindex="0701" type="email" class="moonray-form-input" id="mr-field-element-406510613393" required value="" placeholder="Enter Your E-mail"/>
						</div>						
						<div class="col-xs-12">
							<button tabindex="0702" id="vida-ontraport-form-btn"  title="Match Me" alt="Match Me" class="vida-button" name="submit-button" type="submit">Match Me</button>							
						</div>
						<div class="hidden vida-hidden moonray-form-input-type-hidden">
							<input name="f1522" type="hidden" id="vida-page-source" value="Homepage (Men's)" />
							<input name="f1520" type="hidden" id="vida-form-name" value="Optin 1" />
							<input name="afft_" type="hidden" value=""/>
							<input name="aff_" type="hidden" value=""/>
							<input name="sess_" type="hidden" value=""/>
							<input name="ref_" type="hidden" value=""/>
							<input name="own_" type="hidden" value=""/>
							<input name="oprid" type="hidden" value=""/>
							<input name="contact_id" type="hidden" value=""/>
							<input name="utm_source" type="hidden" value=""/>
							<input name="utm_medium" type="hidden" value=""/>
							<input name="utm_term" type="hidden" value=""/>
							<input name="utm_content" type="hidden" value=""/>
							<input name="utm_campaign" type="hidden" value=""/>
							<input name="referral_page" type="hidden" value=""/>
							<input name="uid" type="hidden" value="p2c21567f527"/>
						</div>							
					  </form>
					</div>
					  
				</div><!-- /.vida-form -->

			</div>
					
		</div>
		
	  </div>
	  
	</div>
	
	<a id="scroll-down" href="#top" class="clearfix"><i class="fa fa-angle-down fa-2x" aria-hidden="true"></i></a>

  </section>
  
</div>

<?php endif; ?>