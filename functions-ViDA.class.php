<?php
/**
 * Functions class for ViDA 
 * 
 * 
 * NOTE: To add your custom functions, use the custom-functions.php file
 *
 * @package Moesia 
 *
 * Text Domain: vida-men
 *
 */


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

// Define our text domain
define('VIDA_TEXT_DOMAIN', 'vida-men');


/**
 * Main theme class.
 *
 * @parent moesia
 *
 * @website Men's
 */ 


  class ViDA {
	
	/**
     * Holds the class object.
     *
	 * singleton pattern
	 *
     * @var object
     */
	public static $instance;	 	

	
	/**
	 * template file.
	 *
	 * @var string
	 */
	public $file = __FILE__;
	
	/**
	 * template name.
	 *
	 * @var string
	 */
	protected static $theme_name;
	
	/**
	 * template version.
	 *
	 * @var string
	 */
	protected static $theme_version;
	
	
	CONST TEXT_DOMAIN = VIDA_TEXT_DOMAIN;
	
	CONST INCLUDES_DIR = '/inc' ;
	CONST WIDGETS_DIR = '/inc/widgets' ;
	CONST HELPERS_DIR = '/inc/helpers' ;
	
	private $BLOG_URL = null;	
	public $STATIC_URI = null;	
	public $THEME_DIR = null;
	public $THEME_PARENT_DIR = null;
	public $VIDA_MODE = null;
		
	CONST VIDA_STATIC_URI = "";	
	

	/**
	 * Starts the theme
	 */
	public function __construct( )
	{
		
		
		$mainURL =  get_bloginfo('url');
		$this->BLOG_URL = $mainURL;		
		
		$parent_path = get_template_directory_uri();
		
		$this->THEME_PARENT_DIR = $parent_path;
		$child_path = get_stylesheet_directory_uri();
		$this->THEME_DIR = $child_path;
		
		
		
		/* init our custom metaboxes */
		//$this->setup_meta_boxes();
		
		
		/* build our post types */
		//add_action( 'init', array( $this, 'setup_post_types' ), 0 );		
		
		/* custom theme support */
		//add_action( 'after_setup_theme', array( $this, 'setup_theme_support' ), 11 );	
		
		/* init our custom scripts and styles */
		//add_action( 'wp_enqueue_scripts', array( $this, 'setup_scripts_and_styles' ), 11 );
		
		/* build our child theme and options */
		//add_action( 'after_setup_theme', array( $this, 'setup_vida_child_theme' ), 12 );
		
		/* init our custom shortcodes */
		//add_action( 'after_setup_theme', array( $this, 'setup_shortcodes' ), 13 );
		
		/* init our custom widgets for site origin page builder */
		//add_action( 'widgets_init', array( $this, 'setup_vida_widgets' ), 11 );


		/* init our filter hooks */
		//$this->setup_filter_hooks();
		
		/* init our action hooks */
		//$this->setup_action_hooks();
		
		/* init our custom hooks */
		//$this->setup_custom_hooks();
		


		
	}

	public function init_theme( $theme_name, $theme_version )
	{
		
		$this->$theme_name = $theme_name;
		$this->$theme_version = $theme_version;

		$this->get_static_uri();

	}

	/**
	 * returns the current instance
	 */
	public static function get_instance()
	{
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof ViDA ) )
		{
			self::$instance = new ViDA();
		}

		return self::$instance;
	}	
	
	/**
	 * ViDA PostTypes class
	 */
	public function setup_post_types() {
		
		$this->Get_Function('PostTypes');
		
	}		
	
	/**
	 * ViDA ThemeSupport class
	 */
	public function setup_theme_support() {
		
		$this->Get_Function('ThemeSupport');
		
	}	
		
	/**
	 * ViDA ScriptsAndStyles class
	 */
	public function setup_scripts_and_styles() {
		
		$this->Get_Function('ScriptsAndStyles');
		
	}	
	
	/**
	 * ViDA ChildTemplate class
	 * -contains the HTML re-structure
	 */
	public function setup_vida_child_theme() {
		
		$this->Get_Function('ChildTemplate');		
		
	}

	/**
	 * ViDA Widgets class
	 */
	public function setup_vida_widgets() {
		
		$this->Get_Function('ViDAWidgets');
		
	}
	
	/**
	 * ViDA ShortCodes class
	 */
	public function setup_shortcodes() {
		
		$this->Get_Function('ShortCodes');
		
	}
	
	/**
	 * ViDA FilterHooks class
	 */
	private function setup_filter_hooks() {
		
		$this->Get_Function('FilterHooks');
		
	}
	
	/**
	 * ViDA ActionHooks class
	 */
	private function setup_action_hooks() {
		
		$this->Get_Function('ActionHooks');
		
	}	
		
	/**
	 * ViDA CustomHooks class
	 */
	private function setup_custom_hooks() {
		
		$this->Get_Function('CustomHooks');
		
	}
	
	/**
	 * Setup our Metaboxes
	 */
	private function setup_meta_boxes() {
		
		$this->Get_Function('ViDAMetaboxes');
		
	}
	
	
	/**
	 * Executes given function
	 */
	protected static function Get_Function($class)
	{
		
		return '';

		if (class_exists($class) == false)
		{
			$path = dirname(__FILE__).ViDA::get_instance()->INCLUDES_DIR.'/'.$class.'.class.php';
			if (file_exists($path) !== true)
			{
				return false;
			}

			require_once($path);
		}

		$b = new $class;

		return $b->setup();

	}
	


	
	/**
	 * Returns Link URL for static file location
	 *
	 * Check for staging, local server or Live server
	 */
	private function get_static_uri()
	{
		
		if (is_null($this->STATIC_URI))
		{
			if ( preg_match( "/\blocal\b/i", $this->BLOG_URL ) ) {
				
				$this->STATIC_URI = "http://vida.local/files/images";
				define('VIDA_MODE', "Offline" );
				
				$this->VIDA_MODE = "Offline";
				
			} else {
				
				$this->STATIC_URI = "https://static.virtualdatingassistants.com/files/images";
				define('VIDA_MODE', "Online" );	
				
				$this->VIDA_MODE = "Online";
				
			}
				
		}				
		
		//define('VIDA_STATIC_URI', $this->STATIC_URI );	
		
		return $this->STATIC_URI;

	}


	
	/**
	 * Echoes given helper
	 */
	public static function Get_Helper($class, $echo=true)
	{
		if (class_exists($class) == false)
		{
			$path = dirname(__FILE__).ViDA::HELPERS_DIR .'/'.$class.'.class.php';
			if (file_exists($path) !== true)
			{
				return false;
			}

			require_once($path);
		}

		$c = new $class;

		if ($echo)
		{
			echo $c->render();
			return true;
		}
		else
		{
			return $c->render();
		}
	}
	
	
	/////HELPER		
	/**
	 * ViDA custom metabox retreiver
	 *
	 * Params: $value = id/name of meta field to retrieve; $plain - return undecoded value
	 * USAGE: ViDA::get_metabox( $value, true )
	 */
	static function get_metabox( $value, $plain=false ) {
		
		global $post;

		$field = get_post_meta( $post->ID, $value, true );
		
		if ( !isset($field) )
			return  false;
		
		if ( ! empty( $field ) ) {
			if ( $plain )
				return ( $field );
			else
				return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
		} else {
			return false;
		}
		
	}

	
	

  } //ViDA




//* End of ViDA functions

?>