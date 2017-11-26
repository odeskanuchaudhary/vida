<?php
/**
 * Functions for ViDA - theme custom details
 * 
 * 
 * NOTE: To add your custom functions, use the custom-functions.php file
 *
 * @package Moesia
 */


/**
 * Main ViDA class
 *
 * - Inlcude functions file
 * 
 * - start our child template
 */
 
require_once "functions-ViDA.class.php";

ViDA::get_instance()->init_theme( 'moesia-vida', '2.0' );


if ( ! function_exists( 'vida_theme_setup' ) ) : 
/**
 * Sets up ViDA theme defaults and registers support for various WordPress features.
 * Removes other parent setup
 */
function vida_theme_setup() {
	
	add_theme_support( 'title-tag' );

	/*
	 * Remove parent theme setups we don't need/use
	 */	
	
	remove_theme_support( 'custom-header' );
	
	// remove post formats
	remove_theme_support( 'post-formats' );

	// remove custom scripts
	remove_action( 'wp_enqueue_scripts', 'moesia_custom_styles');
	
	// remove images sizes
	if ( function_exists( 'remove_image_size' ) ) {
		
		remove_image_size('moesia-thumb');
		remove_image_size('project-image');
		remove_image_size('moesia-news-thumb');
		remove_image_size('moesia-news-thumb');
		remove_image_size('moesia-clients-thumb');
		remove_image_size('moesia-testimonials-thumb');	
		remove_image_size('moesia-employees-thumb');		
		
	}
	
	// hide wp generator
	remove_action('wp_head', 'wp_generator');
	
	// removes EditURI/RSD (Really Simple Discovery) link.
	remove_action('wp_head', 'rsd_link');
	
	// removes wlwmanifest (Windows Live Writer) link.
	remove_action('wp_head', 'wlwmanifest_link');	
	
	// Remove the REST API lines from the HTML Header
    remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
	
	remove_action( 'after_setup_theme', 'moesia_custom_header_setup', 10 );
	
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	
	remove_action('wp_print_styles', 'print_emoji_styles');	
	
	/*
	 * Add our custom theme setups
	 *
	 * Footer menu, additional sidebars, etc..
	 */

	// Add our footer menu
	register_nav_menus( array(
		'secondary' => __( 'Footer Menu', 'vida-footer-menu' ),
		'tertiary' => __( 'Blog - Posts', 'vida-blog-menu' ),
		'footerblog' => __( 'Blog - Posts Footer Menu', 'vida-blog-footer' ),
	) );	
	
	// Register the articles pages' sidebar. 
	register_sidebar(
		array(
			'id' => 'article-header-widget',
			'name' => __( 'Articles Header Widget', 'moesia-vida' ),
			'description' => __( 'Header widget for the articles pages only', 'moesia-vida' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>'
		)
	);
	register_sidebar( array(
		'name'          => __( 'Sidebar Search', 'moesia' ),
		'id'            => 'sidebar-search',
		'description'   => __( 'Widget to add a search box in the sidebar, goes at the top most of the sidebar.', 'moesia-vida' ),
		'before_widget' => '<aside id="%1$s" class="widget sidebar-nopadding %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '',
		'after_title'   => '',
	) );
	register_sidebar( array(
		'name'          => __( 'Sidebar Optin', 'moesia' ),
		'id'            => 'sidebar-optin',
		'description'   => __( 'Widget to display an optin in the posts\' sidebar, goes above the main sidebar.', 'moesia-vida' ),
		'before_widget' => '<aside id="%1$s" class="widget sidebar-nopadding %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Sidebar - Matchmaking', 'moesia' ),
		'id'            => 'sidebar-matchmaking',
		'description'   => __( 'Widget to display an optin in the posts\' sidebar, goes above the main sidebar.', 'moesia-vida' ),
		'before_widget' => '<aside id="%1$s" class="widget sidebar-nopadding %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	// Add custom image sizes
	if ( function_exists('add_image_size') ) {

	
		//add_image_size( 'vida-blog-thumb', xxx, xxx, TRUE ); <-- in case of changing blog featured
		
		// used mainly as the featured
		add_image_size( 'vida-blog-featured', 682, 480, TRUE );
		
		// blog full width
		add_image_size( 'vida-blog-full', 720, 9999 );
		
		// blog three-fourth width
		add_image_size( 'vida-blog-threefourth', 525, 9999 );
		
		// blog two-third width
		add_image_size( 'vida-blog-twothird', 460, 9999 );
		
		// blog half width 
		add_image_size( 'vida-blog-onehalf', 355, 9999 );		
		
		// blog one-third width
		add_image_size( 'vida-blog-onethird', 230, 9999 );

		// related posts thumbs
		add_image_size( 'vida-rel-thumb', 237, 165, true );		
		
	} //end custom image sizes
	
	
}
endif; //vida_theme_setup
add_action( 'after_setup_theme', 'vida_theme_setup', 11 );


/**
 * Widgets Area.
 *
 * Remove unnecessary widgets
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
	
function remove_parent_widgets(){
		
	// remove footer sidebars
	unregister_sidebar( 'sidebar-3' );
	unregister_sidebar( 'sidebar-4' );
	unregister_sidebar( 'sidebar-5' );
	
	
}
add_action( 'widgets_init', 'remove_parent_widgets', 11 );

	
/**
 * Enqueue, Dequeue Scripts and Styles.
 * @ViDA Scripts/Styles
 * Overwrite parent scripts and styles
 */
function vida_moesia_scripts() {
	
  //* custom var 
	$body_classes = get_body_class();

	//* deregister scripts
	//wp_deregister_script( 'moesia-waypoints' );
	//wp_deregister_script( 'moesia-pretty-photo-js' );
	//wp_deregister_script( 'moesia-pretty-photo-init' );	/* use our own custom prettyphoto script */		
	//wp_deregister_script( 'moesia-fitvids' );	
	//wp_deregister_script( 'moesia-carousel' );	
	//wp_deregister_script( 'moesia-carousel-init' );	
	
  //* Remove CSS fonts not needed
	wp_dequeue_style('moesia-headings-fonts');
	wp_dequeue_style('moesia-roboto-condensed');
	wp_dequeue_style('moesia-roboto');
	wp_dequeue_style('moesia-body-fonts');
	wp_dequeue_style('moesia-style'); //parent style - remove to overwrite	
	wp_dequeue_style('moesia-font-awesome'); //fa style - remove to overwrite	

  //* Styles 
  
	// Add parent style for reference, child style
	wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
	wp_enqueue_style( 'vida-style', get_stylesheet_directory_uri().'/style.css' );

	//ViDA fonts
	//wp_enqueue_style( 'vida-fonts', get_stylesheet_directory_uri() . '/css/vida-fonts.css' );
	wp_enqueue_style( 'acaslonpro-font', get_stylesheet_directory_uri() . '/css/acaslonpro-font.css' );
	wp_enqueue_style( 'geomanist-font', get_stylesheet_directory_uri() . '/css/geomanist-font.css' );
	wp_enqueue_style( 'merriweather-font', get_stylesheet_directory_uri() . '/css/merriweather-font.css' );
	wp_enqueue_style( 'montserrat-font', get_stylesheet_directory_uri() . '/css/montserrat-font.css' );
	wp_enqueue_style( 'raleway-font', get_stylesheet_directory_uri() . '/css/raleway-font.css' );
	wp_enqueue_style( 'baskerville-font', get_stylesheet_directory_uri() . '/css/baskerville-font.css' );
	wp_enqueue_style( 'roadradio-font', get_stylesheet_directory_uri() . '/css/roadradio-font.css' );
	wp_enqueue_style( 'itcavantgardepro-font', get_stylesheet_directory_uri() . '/css/itcavantgardepro-font.css' );
	wp_enqueue_style( 'texgyreadventor-font', get_stylesheet_directory_uri() . '/css/texgyreadventor-font.css' );
	
	// CSS for sales funnel pages
	if( in_array('vida-funnel-type', $body_classes) ) {			
		wp_enqueue_style( 
			'vida-sales-funnel', 
			get_stylesheet_directory_uri() . '/includes/css/sales-funnel.css', 
			array(), 
			false, 
			'all' 			
		);
	}
	
	//CSS for single posts
	if (  array ( 'post', 'matchmaking' ) )
		wp_enqueue_style( 'vida-single-style', get_stylesheet_directory_uri() . '/includes/css/single.css' );
	
	//NEW CSS for blog and single posts
	if ( ! is_page() || is_page( 'matchmaking-blog' ) || is_singular( array ( 'post', 'matchmaking' ) ) )
		wp_enqueue_style( 'vida-blog-style', get_stylesheet_directory_uri() . '/includes/css/blog.css' );	
	
	$fontAwesome = ViDA_get_URI_static( 'font-awesome.min.css', 'files/css' );
	//$fontAwesome = home_url('/') . "files/css/font-awesome.min.css";
	wp_enqueue_style( 'vida-font-awesome', $fontAwesome, array('vida-style'), null, 'all' );


  //* Scripts
    //wp_enqueue_script( 'vida-waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array('jquery'), true );  
	wp_enqueue_script( 'froogaloop', '//f.vimeocdn.com/js/froogaloop2.min.js', array('jquery'), null,  true );	

	// enqueue fitvids	
	//wp_enqueue_script( 'moesia-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array('jquery'), true );

		
	/**
	 * prettyPhoto functions
	 * deregister / dequeue and register / enqueue - to use again
	 */	
		
	wp_enqueue_style( 'vida-pretty-photo', get_template_directory_uri() . '/inc/prettyphoto/css/prettyPhoto.min.css' );	
	wp_enqueue_script( 'vida-pretty-photo-js', get_template_directory_uri() . '/inc/prettyphoto/js/jquery.prettyPhoto.min.js', array('jquery'), null, true );		
	//wp_enqueue_script( 'vida-pretty-photo-init', get_stylesheet_directory_uri() . '/js/prettyphoto-init-custom.js', array('jquery', 'vida-pretty-photo-js'), null, true );		

	//Lazy script extensions/plugins
	wp_enqueue_script( 'jquery-lazy', get_stylesheet_directory_uri() . '/js/jquery.lazy.min.js', array('jquery'), false );
	//wp_enqueue_script( 'jquery-lazy-plugins', get_stylesheet_directory_uri() . '/js/jquery.lazy.plugins.min.js', array('jquery-lazy'), true );
	
	//CSS for ontraport forms
	wp_enqueue_style( 'vida-form-style', get_stylesheet_directory_uri() . '/includes/css/vida-form.css' );	
	
	// ViDA scripts file
	wp_enqueue_script(
		'vida-custom-scripts', 
		get_stylesheet_directory_uri() .  '/js/vida-custom.min.js', 
		array( 'jquery', 'moesia-fitvids' ), 
		null, 
		true 
	);		

}
add_action( 'wp_enqueue_scripts', 'vida_moesia_scripts', 12 ); 
/* End of custom scripts/styles for ViDA */


function vida_scripts_init() {
	
}
add_action( 'widgets_init', 'vida_scripts_init', 99 ); 
/* End of custom scripts for ViDA plugins/js */


/* Disable XML PRC */
add_filter('xmlrpc_enabled', '__return_false');

function vida_remove_xmlrpc_getUsersBlogs( $methods ) {
    unset( $methods['wp.getUsersBlogs'] );
    return $methods;   
}
add_filter( 'xmlrpc_methods', 'vida_remove_xmlrpc_getUsersBlogs');

function vida_remove_xmlrpc_pingback( $methods ) {
    unset( $methods['pingback.ping'] );
    return $methods;   
}
add_filter( 'xmlrpc_methods', 'vida_remove_xmlrpc_pingback');


/**
 * Include ViDA custom scripts.
 * scripts hooked into  @core functions and @theme locations, theme/site setup, shortcodes
 */

// custom post types - testimonials, clients
require get_stylesheet_directory() . "/includes/vida-post-types.php";
	
// vida hooks/functions add scripts into @theme locations
require get_stylesheet_directory() . "/includes/vida-hooks.php";
	
// custom theme functions - created for ViDA
require get_stylesheet_directory() . "/includes/vida-functions.php";
	
// vida shortcodes
require get_stylesheet_directory() . "/includes/vida-shortcodes.php";


/*** CUSTOM FUNCTIONS FILE ***/
require "custom-functions.php";



//* End of ViDA functions
?>