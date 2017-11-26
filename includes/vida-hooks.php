<?php
/**
 * ViDA Custom Theme Hooks
 * @ViDA hooks
 * 
 * TODO: define to extend vida_wp_head
 */

 
/* Filters */
function vida_theme_filters() {
	
	//* Add loading to body class
	add_filter( 'body_class', function($classes){$classes[] = 'vida-loading'; return $classes; } );
 
	//* Adds browser type to body class
	function browser_body_class($classes) {
		
		global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

		if($is_lynx) $classes[] = 'lynx';
		elseif($is_gecko) $classes[] = 'gecko';
		elseif($is_opera) $classes[] = 'opera';
		elseif($is_NS4) $classes[] = 'ns4';
		elseif($is_safari) $classes[] = 'safari';
		elseif($is_chrome) $classes[] = 'chrome';
		elseif($is_IE) $classes[] = 'ie';
		else $classes[] = 'unknown';

		if($is_iphone) $classes[] = 'iphone';
		
		if ( is_archive() || is_search() || is_page_template( 'page_blog.php' ) )
			$classes[] = 'blog';
		
		return $classes;
	}
	add_filter('body_class','browser_body_class');
	
}
add_action( 'after_setup_theme', 'vida_theme_filters', 12 );


// vida theme setup hooks
function vida_theme_hooks() {
	
	
	/*
	 * Set initial filter defaults
	 *
	 */		
	/*
	 * Adds the custom header - Homepage Optin
	 */
	function vida_custom_header_top() {
		
		require get_stylesheet_directory() . "/includes/custom-banner.php";
		
	}
	add_action( 'tha_header_bottom', 'vida_custom_header_top' );	
	
	
	function vida_header_media_logos() {
		
		// filter to show or hide this header top bar, useful for sales pages.
		if ( apply_filters( 'hide_vida_header', TRUE ) )
			return;

		//$mediaLogos = ViDA_get_URI_static( 'vida-medialogos-trans.png', 'wp-content/themes/moesia-vida/images' );
		$mediaLogosImg = './wp-content/themes/moesia-vida/images/vida-medialogos-trans.png';
		$mediaLogosImgBase64 = base64_encode( file_get_contents( $mediaLogosImg ) );
		$mediaLogos = 'data:image/png;base64,' . $mediaLogosImgBase64;
		//$mediaLogos = $mediaLogosImg;
		
?>
<style type="text/css">
header#masthead #header-media-logos{height:21px;background:#407c9d;background:-moz-linear-gradient(top, #407c9d 0%, #407c9d 61%, #3a738f 100%);background:-webkit-gradient(left top, left bottom, color-stop(0%, #407c9d), color-stop(61%, #407c9d), color-stop(100%, #3a738f));background:-webkit-linear-gradient(top, #407c9d 0%, #407c9d 61%, #3a738f 100%);background:-o-linear-gradient(top, #407c9d 0%, #407c9d 61%, #3a738f 100%);background:-ms-linear-gradient(top, #407c9d 0%, #407c9d 61%, #3a738f 100%);background:linear-gradient(to bottom, #407c9d 0%, #407c9d 61%, #3a738f 100%);filter:progid:DXImageTransform.Microsoft.gradient( startColorstr='#407c9d', endColorstr='#3a738f', GradientType=0 );clear:both;display:block;max-height:55px;margin:0;padding:0;overflow:hidden;border-bottom:#3f7f9b 1px solid;position:relative;vertical-align:middle;width:100%;z-index:9997}header#masthead #header-media-logos > #media-logos-images{background-image:url(<?php echo $mediaLogos; ?>);background-repeat:no-repeat;background-position:center center;background-size:96% auto;clear:both;display:block;height:100%;max-height:54px}header#masthead #header-media-logos:before{content:"";display:none;position:absolute;bottom:0;left:0;top:50%;height:100%;width:100%;z-index:9996;border:red 1px solid;background:red}@media only screen and ( min-width: 360px ){header#masthead #header-media-logos{height:24px}}@media only screen and ( min-width: 481px ){header#masthead #header-media-logos{height:28px}}@media only screen and ( min-width: 560px ){header#masthead #header-media-logos{height:32px}}@media only screen and ( min-width: 640px ){header#masthead #header-media-logos{height:36px}}@media only screen and ( min-width: 768px ){header#masthead #header-media-logos{height:42px}}@media only screen and ( min-width: 992px ){header#masthead #header-media-logos{height:46px}}@media only screen and ( min-width: 1025px ){header#masthead #header-media-logos{height:50px}}@media only screen and ( min-width: 1200px ){header#masthead #header-media-logos{height:55px}header#masthead #header-media-logos > #media-logos-images{background-size:inherit}}
</style>
<?php
		
		echo '<div class="banner-row"><div id="header-media-logos" class=""><a id="top" name="top"></a><div id="media-logos-images"></div></div></div>';
		//echo '<div class="banner-row"><div id="header-media-logos" class=""><a id="top" name="top"></a><img class="aligncenter img-responsive" alt="Media Logo\'s" src="'. $mediaLogos . '" width="1170" height="54" /></div></div>';

	}
	add_action( 'tha_header_bottom', 'vida_header_media_logos', 12 );
	

	/*
	 * Adds class for our Sales - Page builder
	 */
	function vida_content_before_container_class() {
		
		
		
		
	}
	add_action( 'tha_content_before', 'vida_content_before_container_class' );	
	
	
	/*
	 * ViDA Nav bar
	 * overwrites Nav bar @moesia
	 */
	if ( ! function_exists( 'vida_nav_bar' ) ) {
		
	  function vida_nav_bar() {
		 
		// filter to show or hide this header top bar, useful for sales pages.
		if ( apply_filters( 'hide_vida_header', TRUE ) )
			return;

		

		//* get image, is static URI defined, use it, is not available, use stylesheet URI		
		//$hlogo = esc_url( ViDA_get_URI_static( 'vida-logo.png', 'wp-content/themes/moesia-vida/images' ) );
		$hlogo = './wp-content/themes/moesia-vida/images/vida-logo.png';
		
		$hlogo = base64_encode( file_get_contents( $hlogo ) );
		
		ob_start();
		
		echo '<div class="top-bar">						
				<div class="container vida-wide">
					<div class="site-branding text-center col-md-3">';
						echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="';
							bloginfo('name');
						echo '"><img class="site-logo" src="data:image/png;base64, ' . $hlogo . '" alt="';
							bloginfo('name');
						echo '" width="210" height="56" /></a>';				
				echo '</div>';
				echo '<button class="menu-toggle btn"><i class="fa fa-bars"></i></button>';
			  if ( ! ( is_home() || is_singular( 'post' ) ) ) :
				echo '<div class="vida-phone-no col-md-3 text-center pull-right">';
						echo '<div id="vida-header-phone">';
						
						  if ( function_exists('pll_current_language') ) {
							  
							  echo '<!-- polylang filter - ' . pll_current_language("locale") . ' -->' ;
							if ( pll_current_language('locale') === 'en_GB' ) {
							
								echo '<a href="tel:0203.290.6222" title="Call ViDA: 0203.290.6222"><span class="phone-digits">0203-290-6222</span></a>';
								
							} else {					
								
								//echo '<a href="tel:1.877.271.1717" title="Call ViDA: 1.877.271.1717"><span class="phone-digits">1-877-271-1717</span></a>';
								
							}
							  echo '<!-- /polylang filter -->';
							  
						  } elseif ( ! apply_filters( 'CBC_Plugin_is_Disabled', TRUE ) ) {
							
							//echo do_shortcode('[CBC show="n" country="uk"]<a href="tel:1.877.271.1717" title="Call ViDA: 1.877.271.1717"><span class="phone-digits">1-877-271-1717</span></a>[/CBC]');
							echo do_shortcode('[CBC show="y" country="uk"]<a href="tel:0203.290.6222" title="Call ViDA: 0203.290.6222"><span class="phone-digits">0203-290-6222</span></a>[/CBC]');						
							
						  } else {
						  
							//echo '<a href="tel:1.877.271.1717" title="Call ViDA: 1.877.271.1717"><span class="phone-digits">1-877-271-1717</span></a>';
							  
						  }
						  
						echo '</div>';				
				echo '</div>';
			  endif;
				echo '<nav id="site-navigation" class="main-navigation col-md-6" role="navigation">';
					if ( ! ( is_home() || is_singular( 'post' ) ) )
						wp_nav_menu( array( 'theme_location' => 'primary', 'container_id' => 'vida-top-menu' ) );
					else
						wp_nav_menu( array( 'theme_location' => 'tertiary', 'container_id' => 'vida-top-menu' ) );
				echo '</nav>';			
			echo '</div>';
		echo '</div>';
		
		ob_end_flush();
		
	  }
	  
	}
	 
	if (get_theme_mod('moesia_menu_top', 0) == 0) {
		remove_action('tha_header_after', 'moesia_nav_bar');
		add_action('tha_header_after', 'vida_nav_bar');
	} else {
		remove_action('tha_header_before', 'moesia_nav_bar');
		add_action('tha_header_before', 'vida_nav_bar');
	}


	/*
	 * Adds the custom footer for ViDA 
	 */
	function vida_custom_footer_menu() {

		// try to include logo:
		if ( get_theme_mod('site_logo') ) : 

			$flogo = ViDA_get_URI_static( 'vida-logo.png', 'wp-content/themes/moesia-vida/images' );
		
			$footer_logo = sprintf( '<img alt="%s" class="site-logo" width="210" height="56" src="%s" />' , get_bloginfo('name'), $flogo );

			printf( '<a href="%s">%s</a>', home_url('/'), $footer_logo );
			
		endif;	
		
		// Add footer menu 
		if ( ! ( is_home() || is_singular( 'post' ) ) )
			wp_nav_menu(array( 'menu_id' => 'vida-footer-menu', 'container_class' => 'footer-menu widget text-center', 'menu_class' => 'menu list-unstyled', 'theme_location' => 'secondary' ) );
		else
			wp_nav_menu(array( 'menu_id' => 'vida-footer-menu', 'container_class' => 'footer-menu widget text-center', 'menu_class' => 'menu list-unstyled', 'theme_location' => 'footerblog' ) );

	}
	add_action( 'tha_footer_top', 'vida_custom_footer_menu' );

	
	/*
	 * Adds Privacy and Terms links to footer
	 */
	function vida_custom_privacyterms_footerlinks() {

		print ('<p id="custom-copyright" class="text-center"><small><smaller>');
			printf( 'Copyright &copy; %s', 'Virtual Dating Assistants' );
		print ('</smaller></small></p>');
		
		print ('<p id="custom-privacylink" class="text-center"><small><smaller>');
			printf( '<a href="%s">%s</a>&nbsp;|&nbsp;<a href="%s">%s</a>', home_url('privacy-policy'), 'Privacy Policy', home_url('terms-conditions'), 'Terms and Conditions' );
		print ('</smaller></small></p>');
		
	}
	add_action( 'vida_privacyterms', 'vida_custom_privacyterms_footerlinks' );
	
	/*
	 * Adds Women's Site Link - Bottom Bar
	 */
	function vida_womens_site_bottom_bar() {
		
		if ( apply_filters( 'hide_vida_womens_bottom_bar', TRUE ) )
			return;
		
?>
<!-- Women's Bottom Bar -->
<style>#womens-bottom-bar{padding:30px 15px;}#womens-bottom-bar a{color:#dedede;-webkit-appearance:none;-webkit-user-select:none;-webkit-transition: all 300ms ease-out;-moz-transition:all 300ms ease-out;-o-transition:all 300ms ease-out;-ms-transition:all 300ms ease-out;transition:all 300ms ease-out;}#womens-bottom-bar a:hover,#womens-bottom-bar a:focus{color:#FFFFFF;text-decoration:none;}</style>
<div id="womens-bottom-bar" class="clearfix" style="background-color:#3a738f">
	<div class="container text-center">
		<h3><a target="_blank" href="https://www.virtualdatingassistants.com/women/online-matchmaking"><i class="fa fa-female fa-lg"></i> &nbsp; I'm a female, take me to the site for women!</a></h3>
	</div>
</div>
<!-- Women's Bottom Bar End -->

<?php
	}
	add_action( 'tha_content_after', 'vida_womens_site_bottom_bar' );


} //vida theme setup
add_action( 'after_setup_theme', 'vida_theme_hooks', 20 );



/**
 * 1. vida_body_start: All scripts/fucntions to go right after opening <body> tag...
 * - useful for analytics, tag codes, etc...
 */


	//* Add GOOGLE TAG MANAGER into vida_body_start	
	function vida_gtm() {
?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TMKN2M4');</script>
<!-- End Google Tag Manager -->
<?php
	}
	add_action( 'wp_head', 'vida_gtm', 5 );
	
	function vida_gtm_noscript() {
?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TMKN2M4"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php
	}
	add_action( 'vida_body_start', 'vida_gtm_noscript', 5 );
	


function vida_styles_override() {
	
?>
<style id="vida-custom-override-styles" type="text/css">
.vida-loading .home-bottom-optin{background:none !important;background-image:none !important}.vida-loaded .home-bottom-optin{background:inherit;background-image:inherit}@media (min-width: 1200px){.vida-loading .introvida_bg,.vida-loading .tim-ferris-wrapper,.vida-loading .media-outlets{background:none !important}}
</style>
<?php
	
}
add_action( 'wp_head', 'vida_styles_override' );


/**
 * Lazy loading function
 */
// add lazy load image styles	
function vida_lazyload_image_styles_init() {	

?>
<style id="vida-lazy-styles" type="text/css">
.no-js .lazy{display:none}.vida-lazy-wrap{display:inherit;width:100%;vertical-align:middle;clear:both;height:auto;max-height:100%}.lazy{display:inherit}img.lazy{display:table;vertical-align:middle;height:auto;min-height:32px;}img.lazy,iframe.lazy{background-image:url('/files/images/assets/vida-loader.gif');background-repeat:no-repeat;background-position:center center;background-size:auto auto;background-attachment:inherit}iframe.lazy{background-color:#efefef;}img.lazy.handled,iframe.lazy.handled{background-image:none !important}
</style>	
<?php
	
}
add_action( 'wp_head', 'vida_lazyload_image_styles_init' );

// add lazy class to images 
function vida_img_add_lazy_class($content) {
	
	if ( ! is_singular( array ( 'post', 'matchmaking' ) ) ) 
		return $content;
	
    return preg_replace_callback('/(<\s*img[^>]+)(src\s*=\s*"[^"]+")([^>]+>)/i', 'preg_lazy_images', $content);
	
}
add_filter('the_content', 'vida_img_add_lazy_class');

function preg_lazy_images($img_match) {
 
    $img_replace = $img_match[1] . 'src="' . VIDA_IMAGE_PLACEHOLDER . '" data-src' . substr($img_match[2], 3) . $img_match[3];
 
    $img_replace = preg_replace('/class\s*=\s*"/i', 'class="lazy ', $img_replace);
 
    $img_replace .= '<noscript>' . $img_match[0] . '</noscript>';
	
    return $img_replace;
}

//init the lazy function
function vida_init_lazy_images(){
?>
<script id="vida-lazy" type="text/javascript">	
;(function($){if(typeof(lazy)!='undefined'){$('.lazy').lazy({effect:"fadeIn",enableThrottle:true,throttle:250,visibleOnly:true,vidaLoader:function(element){setTimeout(function(){if(element[0].tagName.toLowerCase()==="iframe"){element.attr("src",element.attr("data-src"));element.removeAttr("data-src");}else{response(false);}},1000);},asyncLoader:function(element){setTimeout(function(){element.load()},5000);},beforeLoad:function(element){var eSrc=element.data('src');console.log(element[0].tagName.toLowerCase()+' '+eSrc+'" loading...');},afterLoad:function(element){element.addClass('handled');var eSrc=element.data('src');console.log(element[0].tagName.toLowerCase()+' '+eSrc+'" loaded...');},removeAttribute:true,});}})(window.jQuery);
</script>
<?php
}
//add_action( 'wp_footer', 'vida_init_lazy_images', 0 );


/**
 * Set First Time Visitor Cookie
 */

function vida_check_first_time_visitors(){
	
	//if this cookies are set, means the user has already subscribed
	if ( isset( $_COOKIE['contact_id'] ) && isset( $_COOKIE['sess_'] ) )
		return setcookie( 'vida_landing_url', '', time() - (3600*24*365), '/', COOKIE_DOMAIN, ( $_SERVER['SERVER_PORT'] == 443 ? true : false ) );
	
	$first_time_url = "";
	
	if ( !isset( $_COOKIE['vida_landing_url'] ) ) {
		
		$first_url = "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		
		setcookie( 'vida_landing_url', esc_url( $first_url ), time() + (3600*24*365), '/', COOKIE_DOMAIN, ( $_SERVER['SERVER_PORT'] == 443 ? true : false ) );
		
		define( "ACCESSED", false );
		
	} else {
		
		//unset( $_COOKIE['vida_landing_url'] );
		
		define( "ACCESSED", true );
		
	}

}
add_action( 'init', 'vida_check_first_time_visitors', 1 );


/**
 * ViDA - UTM - Ontraport Tracking Script
 *
 * Inserted vida_utm_init() after mrtracking()
 * ,'sess_' - is a conflict, don't include as it will break the utm vars
 */
 
function vida_ontraport_tracking_script() {

?>

<script type="text/javascript">
function vida_utm_init(){for(var i=["utm_source","utm_medium","utm_term","utm_content","utm_campaign","referral_page","aff_","ref_","oprid","afft_","contact_id"],t=0;t<i.length;t++)gC(i[t])&&jQuery("form").each(function(){$this=jQuery(this),$this.find('input[name="'+i[t]+'"]').length>0&&$this.find('input[name="'+i[t]+'"]').val(gC(i[t])),gC("vida_landing_url")&&$this.find('input[id="vida_landing_url"]').length<=0&&(jQuery('<input type="hidden" id="vida_landing_url" name="f1530" value="'+decodeURIComponent(gC("vida_landing_url"))+'" />').appendTo($this),console.log("ViDA: First time visit tracked!"))})
console.log("ViDA: OntraPort UTM vars set!")}function vida_mrtracking(){"undefined"==typeof mrtracking?(setTimeout(function(){vida_mrtracking()},50),console.log("Error-ViDA: OntraPort MRTracking!")):(mrtracking(),console.log("ViDA: OntraPort MRTracking done!"))}function vida_ontraport_init(){_mri="21567",_mr_domain="vida.ontraport.com",vida_mrtracking(),vida_utm_init()}ViDA_Load_Script("https://optassets.ontraport.com/tracking.js",vida_ontraport_init,!0,!0)
</script>

<?php
	
		/*	
		(function( $ ) {
		'use strict';
			jQuery.ajax({
			type: "GET",
			url: "//optassets.ontraport.com/tracking.js",
			success: function(){ _mri="21567",_mr_domain="vida.ontraport.com"; mrtracking(); vida_utm_init(); },
			dataType: "script",
			cache: true
			});
		})( jQuery );

		*/		

}
add_action( 'wp_footer', 'vida_ontraport_tracking_script', 999 );
// ViDA - UTM - Ontraport Tracking Script


//SO Session - Ontraport field ID: f1547
// PHP set cookie
// Free Strategy Session page only

function vida_check_so_form_details(){
	
	//var so_active

	if ( ! ( isset( $_COOKIE['vida_so_email'] ) || isset( $_COOKIE['vida_so_name'] ) ) ) {

		if ( isset( $_COOKIE['ScheduleOnce_SessionId'] ) && isset( $_COOKIE['ScheduleOnce_email'] ) ) {	
		
			setcookie( 'vida_so_email', esc_attr( $_COOKIE['ScheduleOnce_email'] ), time() + (3600*24*365), '/', COOKIE_DOMAIN, ( $_SERVER['SERVER_PORT'] == 443 ? true : false ) );

		}

		if ( isset( $_COOKIE['ScheduleOnce_SessionId'] ) && isset( $_COOKIE['ScheduleOnce_name'] ) ) {
		
			setcookie( 'vida_so_name', esc_attr( $_COOKIE['ScheduleOnce_name'] ), time() + (3600*24*365), '/', COOKIE_DOMAIN, ( $_SERVER['SERVER_PORT'] == 443 ? true : false ) );

		}

	}
	
}


// JS cookie
// Free Strategy Session page only

function vida_js_check_so_form_details(){
	
	?>
	
	<script type="text/javascript">
	
	var v_email, v_name, e_exp="expires=Sun, 18 Jan 2038 00:00:00 GMT";

	if ( ! ( gC( 'vida_so_email' ) || gC( 'vida_so_name' ) ) ) {

		if ( gC( 'ScheduleOnce_SessionId' ) && gC( 'ScheduleOnce_email' ) ) {
		
			v_email = gC( 'ScheduleOnce_email' );
		
			document.cookie = 'vida_so_email' + '=' + v_email + ';' + e_exp + ';' + "path=/";

		}

		if ( gC( 'ScheduleOnce_SessionId' ) && gC( 'ScheduleOnce_name' ) ) {
		
			v_name = gC( 'ScheduleOnce_name' );
		
			document.cookie = 'vida_so_name' + '=' + v_name + ';' + e_exp + ';' + "path=/";

		}

	}
	</script>
	<?php
	
}





add_action('admin_enqueue_scripts', function()
{
    global $post;

	if ( is_singular() ) {
		
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');	
	
		wp_enqueue_media(array(
			'post' => $post->ID,
		));
	}
});

/**
 * 3. Others: All inside hooks of pages/posts, etc...
 * - just name your hook and description
 */
	 
	//* free_consultation_image under biographia box on posts
	function free_consultation_img( $content ) {
		
		add_filter( 'vida_bio_active', '__return_false' );
		
		ob_start();	
		
		if ( is_singular( array ( 'post' ) ) ) {
			
			
			//add author bio box - trigger from Moesia settings
			if ( '' != get_theme_mod('author_bio') ) : 
				get_template_part( 'author-bio' );
			endif;	
		
			//add free consulation box
			//$fci_link = home_url('free-strategy-session');
			
			//make static
			$fci_img = ViDA_get_URI_static( 'blog-free-consultation-750.jpg', 'files/images' );
			//$fci_img = get_stylesheet_directory_uri() . '/images/';
			
			$fci_object = sprintf( '<img alt="Free Consultation" class="lazy img-responsive" src="%s" width="750" height="295" />', esc_url($fci_img) );	
			
			//$vida_content = sprintf( '<div class="free-consultation-box"><a title="Sign up right now for your free confidential consultation" href="%s">%s</a></div>', $fci_link, $fci_object );
			
			$vida_content = do_shortcode( "[thrive_2step id='9418']" . $fci_object . "[/thrive_2step]" );
			echo $vida_content;	
			
		} else if ( is_singular( array ( 'matchmaking' ) ) ) {
			
			get_template_part( 'content', 'matchmaker-cta' );
			
		}
		
		$addcontent = ob_get_clean();
		
		$content = $content . $addcontent;
		
		return $content;
	}
	add_filter( 'the_content', 'free_consultation_img', 10 );
	

			
			/*
			 * Adds the Women's button link to men's site
			 */
			function vida_button_womens_link() {
				
				
				if ( apply_filters( 'vida_hide_floating_button', TRUE ) )
					return;	

				$opp_site_slug = "/women/";
				
				if ( null !== ViDA::get_metabox('btn_link_custom_slug')  )
					$opp_site_slug .= ViDA::get_metabox('btn_link_custom_slug');
				
				$opp_site_slug = preg_replace( '#/+#', '/', $opp_site_slug );				
				$opp_site_link = home_url( $opp_site_slug );
				
				$womens_btn_text = __( '<span class="visible-xs">W<i class="fa fa-venus"></i>men</span><span class="hidden-xs">Women G<i class="fa fa-venus"></i> Here</span>', 'vida-moesia' ); 
				
				$womens_btn_link = sprintf( '<a href="%s" title="Visit Women\'s Site" target="_blank">%s</a>', esc_url( $opp_site_link ), $womens_btn_text );
				
				echo '<div class="vida-floating-button women-site-button">' . $womens_btn_link . '</div>';
				
			}
			add_action( 'tha_content_bottom', 'vida_button_womens_link' );
	
	
		
			/*
			 * Adds the SCRIPT for the Men's button link to women's site
			 */
			function vida_mens_button_link_script() {
				
				if ( apply_filters( 'vida_hide_floating_button', TRUE ) )
					return;	
				
				ViDA::get_instance()->Get_Helper('FloatingButtonScript');
				

			}
			add_action( 'tha_footer_after', 'vida_mens_button_link_script' );
			
	
	
	add_action( 'tha_content_bottom', 'vida_edit_post_link' );
	function vida_edit_post_link() {

		edit_post_link();
		
	}
	
	
 /* Ends vida-hooks.php */
 
 
/* TEST CF IP-GEO LOCATION */
function vida_cf_ip_geo_location() {
	
	global $vida_country_code;
	global $country_code;
	
	if ( isset($_SERVER['HTTP_CF_IPCOUNTRY']) )
		$country_code = $_SERVER['HTTP_CF_IPCOUNTRY'];
	
	if ( is_user_logged_in() ) {
		//echo "Connection: " . $_SERVER['HTTP_CONNECTION'];		
	}
	
	$vida_country_code = sprintf( "vida-ip-geo-%s", strtolower( $country_code ) );
	
	
	if ( null !== $country_code )
		add_filter( 'body_class', function($classes){ global $vida_country_code; $classes[] = $vida_country_code; return $classes; } );
	else
		add_filter( 'body_class', function($classes){ $classes[] = 'vida-no-ip-geo'; return $classes; } );
	
}
add_action( 'init', 'vida_cf_ip_geo_location', 1 );




/**
 * ViDA Custom Page Redirect 
 *
 * 301 redirect current page to a new location
 */

function vida_do_301_redirect_url() {
	
	global $post;
	
	$vida_301_redirect_page_url = ViDA::get_metabox('vida_301_redirect_url') ? esc_url_raw( ViDA::get_metabox('vida_301_redirect_url') ) : null;
	
	if ( ! isset ( $vida_301_redirect_page_url ) )
		return;
	else
		wp_redirect( $vida_301_redirect_page_url, 301 );
	
	exit();
		
		
}
add_action('template_redirect', 'vida_do_301_redirect_url', 5 );


/**
 * ViDA Custom Page CF-GEO Location Redirect 
 *
 * Uses cloudflare Http IP-Geo location
 */
function vida_cf_ip_geo_location_redirect() {
	
	global $post;
	global $vida_country_code;
	global $country_code;
	
	
	if ( vida_get_metabox( 'vida_utility_enable_ipgeo_redirect' ) === 'enable-geo-redirect' ) {
		
		//echo 'redirect enabled' . $vida_country_code;
		$vida_c_code = vida_get_metabox( 'ipgeo_redirect_country_code' );
		$vida_r_slug = vida_get_metabox( 'ipgeo_redirect_slug' );
		$vida_geoip_view = vida_get_metabox( 'ipgeo_redirect_showhide_page' );
		
		//$country_code = "US";

		if ( ! isset( $vida_c_code ) )
			return;	
		
		if ( ! isset( $vida_r_slug ) )
			return;


		if ( 'ipgeo_hide' == $vida_geoip_view && ( strtolower( $vida_c_code ) == strtolower( $country_code ) ) ) {				
				
			wp_redirect( get_permalink($vida_r_slug), 301 );

			exit;
			
		} elseif ( 'ipgeo_show' == $vida_geoip_view && ( strtolower( $vida_c_code ) != strtolower( $country_code ) ) ) { //restrict to country only
			
			wp_redirect( get_permalink($vida_r_slug), 301 );
					
			exit;
				
		} // ipgeo_hide

	} // vida_get_metabox

	
} 
add_action('template_redirect', 'vida_cf_ip_geo_location_redirect', 10 );


function vida_cf_ip_geo_info() {
	
	if ( ! is_user_logged_in() )
		return;
	
	global $country_code;
	
	$vida_c_code = vida_get_metabox( 'ipgeo_redirect_country_code' );
	$vida_r_slug = vida_get_metabox( 'ipgeo_redirect_slug' );
	$vida_geoip_view = vida_get_metabox( 'ipgeo_redirect_showhide_page' );
	
	print_r ( 'CF IP GEO: ' . strtolower( $country_code ) . '\n\n' );
	print 'ViDA Metabox Country Code: ' . strtolower( $vida_c_code ) . '<br />';
	print 'ViDA Metabox Redirection Slug: ' . get_permalink($vida_r_slug) . '<br />';
	print 'ViDA Metabox Page Restriction: ' . $vida_geoip_view . '<br />';
	
}
//add_action('wp_head', 'vida_cf_ip_geo_info', -99 );


function vida_pll_filter() {
		
	global $polylang;
	
	if ($polylang) {

		remove_filter( 'get_pages', array( $polylang->filters, 'get_pages' ) );
		//remove_filter( 'get_pages', array( &$polylang->filters, 'get_pages' ) );
		
	}
	
}
add_action('wp_loaded', 'vida_pll_filter' );
?>