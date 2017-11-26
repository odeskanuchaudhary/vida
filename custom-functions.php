<?php
/**
 * Custom Functions for ViDA
 * 
 * @package Moesia / Child
 * moesia-vida
 */

 
$is_page_login = is_login_page();

 //* redirect to maintenance
 if ( ! ( is_user_logged_in() || $is_page_login ) ) {
	
	//header('Location: https://www.virtualdatingassistants.com/maintenance.html');
	
}

function is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}

function vida_admin_scripts() {
	
	if( ! is_admin() )
		return;
	
	wp_enqueue_script(
		'vida-admin-scripts', 
		get_stylesheet_directory_uri() .  '/js/vida-admin.js', 
		array('jquery'), 
		null, 
		false 
	);	
	
}
add_action( 'admin_enqueue_scripts', 'vida_admin_scripts', 0 );


/**
 * Adds Title above disqus comments,
 * Removes Moesia post nav (next-prev article links)
 
if ( ! function_exists( 'moesia_post_nav' ) ) :

	function moesia_post_nav() {
		
		echo '<h3 class="utility-title vida-comment-title">Comments? Put \'em here</h3>';
		
	}

endif;
*/


/**
 * Remove WP_Video_Capture scripts on pages not using it
 */ 
function vida_remove_plugin_actions() {
	
	if ( class_exists( 'WP_Video_Capture' ) && ! is_page( 'share-your-experience' )  ) {
	
		global $wp_video_capture;
	
		remove_action( 'wp_enqueue_scripts', array( $wp_video_capture, 'register_resources' ), 10 );
		remove_action( 'wp_enqueue_scripts', array( $wp_video_capture, 'register_resources_pro' ), 10 );			
		
	}
	
}
add_action( 'template_redirect', 'vida_remove_plugin_actions', 12 );

	
/**
 * Remove WP_Biographia widget until they fix the WP_Widget constructor issue
 */
if ( class_exists ('WP_BiographiaWidget') ) {
	remove_action( 'widgets_init', array( WP_Biographia::get_instance(), 'widgets_init'), 10 );
}


/**
 * Define Static URL constant for static files
 */
 
function vida_static_uri() {
	
	if ( is_admin() )
		wp_enqueue_script('jquery');
	
	// you can edit this
	//$staticURI = "https://static.virtualdatingassistants.com";
	$staticURI = "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://static.virtualdatingassistants.com";
	
	//static off
	//$staticURI = "http://vida.local";
	
	$mainURL =  get_bloginfo('url');	
	$themePath = get_stylesheet_directory_uri();
	
	$folderPath = str_replace( $mainURL, '', $themePath );
	//define
		
	// test out with logo image and if not restricted
	$staticURIlogo = $staticURI . $folderPath . "/images/vida-medialogos-trans.png";
	
	//print $staticURIlogo;
	
	$file_headers = @get_headers($staticURIlogo);
	
	//var_dump($file_headers[0]);
	
	if ( !$staticURIlogo )
		$staticURI = get_stylesheet_directory_uri();
	
	
	define('VIDA_STATIC_URI', $staticURI );
	
	if ( !defined('VIDA_MODE') ) :
	
		if ( preg_match( "/\blocal\b/i", $mainURL ) || preg_match( "/\bstaging\b/i", $mainURL ) )
			define('VIDA_MODE', "Offline" );
		else
			define('VIDA_MODE', "Online" );
		
	endif;
	
	$vida_icon_gif = $staticURI . "/files/images/assets/vida-icon.gif";
	
	$vida_icon_gif_base64 = base64_encode( file_get_contents( $vida_icon_gif ) );
	
	$vida_placeholder_img = 'data:image/gif;base64, ' . $vida_icon_gif_base64;
	
	define( 'VIDA_IMAGE_PLACEHOLDER', $vida_placeholder_img );
	
}
add_action('init', 'vida_static_uri'); 

/**
 * Custom function to return static URI
 * -must define VIDA_STATIC_URI - if none would return using stylesheet_directory_uri
 *
 * @vars $fileName = required,
 *		 $fileFolder = null, if file is under a subfolder of the default static URI
 *		 $customURIstatic = null, if other static URI defined
 */
function ViDA_get_URI_static( $fileName, $fileFolder="", $customURIstatic=null) {
	
	$fileURI = "";
	$fileImg = "";
	$fileUri = "";
	
	if ( empty($fileName) )
		return;	
	
	if ( $fileFolder )
		$fileImg = sprintf( '/%s/%s', $fileFolder, $fileName );
	else
		$fileImg = sprintf( '/%s', $fileName );
	
	if ( $customURIstatic )
		$fileUri = esc_url( $customURIstatic );
	else
		$fileUri = VIDA_STATIC_URI;
	
	//$fileURI = VIDA_STATIC_URI . $fileImg;
	
	return VIDA_STATIC_URI . $fileImg;
	
	
} //end static URI function


 
/**
 * Load jQuery, jQuery UI
 */
 
function vida_load_jquery_ui() {
	
    global $wp_scripts;
	
	//force native wordpress jQuery on header
	//wp_enqueue_script( 'jquery', false, array(), false, false );
	
	if( ! is_admin() ) {	
	 
		// get registered script object for jquery-ui
		$ui = $wp_scripts->query('jquery-ui-core');
	 
		// tell WordPress to load the Smoothness theme from Google CDN
		$protocol = is_ssl() ? 'https' : 'http';
		$url = "$protocol://ajax.googleapis.com/ajax/libs/jqueryui/{$ui->ver}/themes/smoothness/jquery-ui.min.css";
		//wp_enqueue_style('jquery-ui-smoothness', $url, false, null);
		
		//wp_enqueue_script( 'jquery-ui-autocomplete' );			
	
	}
	
}
//add_action('wp_enqueue_scripts', 'vida_load_jquery_ui', 0);

/**
 * Custom Async Script Loader
 *
 * Used to load external/internal scripts asynchronously 
 */
function vida_script_loader() {
?>
<script id="vida-script-loader" type="text/javascript">	
function ViDA_Load_Script(e,a,t,n){var c=document.createElement("script")
c.type="text/javascript",c.async=!1,t&&(c.async=!0),n&&c.setAttribute("data-cfasync",!1),c.readyState?c.onreadystatechange=function(){"loaded"!=c.readyState&&"complete"!=c.readyState||(c.onreadystatechange=null,a())}:c.onload=function(){a()},c.src=e,document.getElementsByTagName("head")[0].appendChild(c)}
</script>
<?php
}
//add_action( 'wp_enqueue_scripts', 'vida_script_loader', 1 );
add_action( 'wp_head', 'vida_script_loader', -5 );


function vida_script_oninit() {
	
		// ViDA init scripts file
		wp_enqueue_script(
			'vida-scripts-init', 
			get_stylesheet_directory_uri() .  '/js/vida-init.min.js', 
			array('jquery','jquery-lazy'), 
			null, 
			true 
		);
		
}	
add_action( 'wp_enqueue_scripts', 'vida_script_oninit', 2 );



// adds live chat
function add_vida_live_chat() {
	
	if ( apply_filters( 'hide_vida_live_chat', TRUE ) || VIDA_MODE == "Offline"  )
		return;
	
?>
<script id="vida-live-chat">
window.__lc=window.__lc||{};window.__lc.license=6716361;
jQuery(document).ready(function($) {
$(window).load(function() {
setTimeout(function(){var lc=document.createElement('script');lc.type='text/javascript';lc.async=true;lc.src=('https:'==document.location.protocol?'https://':'http://')+'cdn.livechatinc.com/tracking.js';var s=document.getElementsByTagName('script')[0];s.parentNode.appendChild(lc,s);},500);
});	
});
</script>
<?php

}
add_action( 'wp_footer', 'add_vida_live_chat', 999 );
//add_action( 'vida_body_end', 'add_vida_live_chat' );

//fitler live chat, false, shown by default
//add_filter( 'hide_vida_live_chat', '__return_false' );
add_filter( 'hide_vida_live_chat', '__return_true' );


/**
 * Overwrite header output, remove header image on homepage
 */
	function vida_header_overwrite_start() {
		//start flush
		ob_start();
	}
	add_action( 'tha_header_top', 'vida_header_overwrite_start' );

	function vida_header_overwrite_end() {
		//end flush
		ob_end_clean();
	}
	add_action( 'tha_header_bottom', 'vida_header_overwrite_end' );
/* end Overwrite header output */


/*gets easrly css needed for first time byte*/
function vida_early_scripts() {
	wp_enqueue_script( 'early-init', get_stylesheet_directory_uri() . '/js/criticalcss-bookmarklet-devtool-snippet.js', array(), null, false );	
}
//add_action( 'wp_enqueue_scripts', 'vida_early_scripts', -1 ); 


//* This adds a div section to the blog and single posts used as a reference for the sticky widget stop/end
function vida_sticky_widget_stop() {

	if (  ! ( is_page() || is_singular( 'post' ) )  ) {
		
		echo '<div class="clearfix"></div>';
		echo '<div id="content-end" class="clearfix"></div>';
		
	}
	
}
add_action( 'tha_content_bottom', 'vida_sticky_widget_stop', 12 );

function vida_alter_query_args() {
	
	global $wp;
	$vida_name_str = '';
	
	if ( isset($_GET["name"]) ) {
		
		$vida_name_str = $_GET["name"];
		
		wp_redirect( esc_url_raw( add_query_arg( array( 'firstname' => $vida_name_str, 'name' => false ), get_permalink() ) ), 301 );
		exit;
		
	} //exited if query_var = name only
	
	/*
	elseif ( isset($wp->query_vars["post_type"]) ) {
		
		wp_redirect( home_url('/') );

				exit;
		
	}
	*/
	
}
add_action( 'template_redirect', 'vida_alter_query_args' );


function vida_unset_utm_queryvar( $query_vars ) {
		
		$arr_params = array();
		$hasUtm = false;
		
		if ( isset($_GET["utm_campaign"]) ) {
			$arr_params['utm_campaign'] = $_GET["utm_campaign"] ;
			unset($_GET["utm_campaign"]); 
			$hasUtm = true;
		}		
		
		if ( isset($_GET["utm_source"]) ) {
			$arr_params['utm_source'] = $_GET["utm_source"] ;
			unset($_GET["utm_source"]);
			$hasUtm = true;
		}
		
		if ( isset($_GET["utm_medium"]) ) {
			$arr_params['utm_medium'] = $_GET["utm_medium"] ;
			unset($_GET["utm_medium"]);
			$hasUtm = true;
		}	
		if ( isset($_GET["utm_content"]) ) {
			$arr_params['utm_content'] = $_GET["utm_content"] ;
			unset($_GET["utm_content"]);
			$hasUtm = true;
		}
		
		if ( isset($_GET["utm_term"]) ) {
			$arr_params['utm_term'] = $_GET["utm_term"] ;
			unset($_GET["utm_term"]);
			$hasUtm = true;
		}
		
		if ( $hasUtm ) {
			
			if ( isset($_GET["email"]) ) {
				$arr_params['email'] = $_GET["email"] ;
				unset($_GET["email"]);
			}		
				
		}

		add_query_arg( $arr_params );		

	
	return $query_vars;
	
}
add_filter( 'query_vars', 'vida_unset_utm_queryvar' );


add_filter( 'jpeg_quality', function() { return 80;} );

/**
 * Custom IP2Location Country Redirection functions
 */ 
require get_stylesheet_directory() . "/inc/class-vida-ip2location-country-blocker.php";

/**
 * Custom Hello Bar for Lead Quizzes functions
 */ 
require get_stylesheet_directory() . "/includes/custom-hello-bar.php";

/* End of Custom functions */