<?php
/**
 * ViDAMetaboxes class
 *
 * @theme moesia-vida
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
	
// Exit if our Main class isn't ready
if ( ! class_exists( 'ViDA' ) ) {
	return;
}

// require our abstract class helper
require_once('abstract.ViDASetup.class.php');
	

class ViDAMetaboxes extends ViDA_Setup {
	
	/**
     * Holds the class object.
     * @var object
     */
	public static $instance;

    /**
     * Holds the base class object.
     * @var object
     */
    public $base;	

    /**
     * Holds the default post types to add metaboxes.
     * @var object, array
     */
    public $metabox_posttypes = array();
	
	
    /**
     * abstract constructor.
     */	
	public function setup() {


	    // Set our object.
	    $this->set();
		
		add_action( 'add_meta_boxes', array( $this, 'init' ) );

		//require_once ( get_stylesheet_directory() . ViDA::WIDGETS_DIR . "/vida-title-bar-excerpt.php" );		
			
		// Fire a hook to say that the metaboxes are loaded.
		do_action( 'vida_metaboxes_loaded' );
		
	}

    /**
     * Sets the object instance and base class instance.
     */
    public function set() {
		
		self::$instance = $this;
        $this->base 	= ViDA::get_instance();	
		$this->metabox_posttypes = array( 'page', 'post' );
		
	}

    /**
     * Initializes metaboxes.
	 * 
	 * Accepts filter for post types: vida_metabox_posttypes
     */	
	public function init() {
		
		$vida_posttypes = apply_filters( 'vida_metabox_posttypes', $this->metabox_posttypes );
		
		add_meta_box(
			'vida_page_post_html_filters', __( 'ViDA: Page/Post Options', $this->base->TEXT_DOMAIN ), array (
				$this,
				"sidebar_page_post_options"		
			), $vida_posttypes, 'side', 'core' );

			
		// Fire a hook to say that the metaboxes initialized.
		do_action( 'vida_metaboxes_init' );
		
	}
	
	/**
	 * Sidebar Metabox Output
	 *
	 * HTML Output
	 * Page/Post options
	 */
	public function sidebar_page_post_options() {
		
		// Fire a hook before the sidebar_page_post_options are loaded.
		do_action( 'vida_metabox_sidebar_before_load' );
		
		// Start the metabox with our default theme options - header & footer
		$this->default_header_footer_options();
		
		// Fire a hook to say that the sidebar_page_post_options are loaded.
		do_action( 'vida_metabox_sidebar_loaded' );

	}
	
	
	private function default_header_footer_options( $post ) {
		
		echo "PRIVATE FUNC";
		//create wp nonce
		wp_nonce_field( '_default_header_footer_options', 'default_header_footer_options' ); 
		
		?>
		
			<p><strong>Site Header and Footer</strong></p>
					<p><input type="checkbox" name="vida_utility_hide_header" id="vida_utility_hide_header" value="hide-header" <?php echo ( vida_get_metabox( 'vida_utility_hide_header' ) === 'hide-header' ) ? 'checked' : ''; ?>>
						<label for="vida_utility_hide_header"><?php _e( 'Hide Header (Media + Logo, Menu)', 'vida_utility' ); ?></label>	</p>
						
					<p><input type="checkbox" name="vida_utility_hide_footer_logo" id="vida_utility_hide_footer_logo" value="hide-footer-logo" <?php echo ( vida_get_metabox( 'vida_utility_hide_footer_logo' ) === 'hide-footer-logo' ) ? 'checked' : ''; ?>>
						<label for="vida_utility_hide_footer_logo"><?php _e( 'Hide Footer Logo', 'vida_utility' ); ?></label>	</p>

					<p><input type="checkbox" name="vida_utility_hide_footer_menu" id="vida_utility_hide_footer_menu" value="hide-footer-menu" <?php echo ( vida_get_metabox( 'vida_utility_hide_footer_menu' ) === 'hide-footer-menu' ) ? 'checked' : ''; ?>>
						<label for="vida_utility_hide_footer_menu"><?php _e( 'Hide Footer Menu', 'vida_utility' ); ?></label>	</p>

					<p><input type="checkbox" name="vida_utility_hide_footer_copyright" id="vida_utility_hide_footer_copyright" value="hide-footer-copyright" <?php echo ( vida_get_metabox( 'vida_utility_hide_footer_copyright' ) === 'hide-footer-copyright' ) ? 'checked' : ''; ?>>
						<label for="vida_utility_hide_footer_copyright"><?php _e( 'Hide Footer Copyright', 'vida_utility' ); ?></label>	</p>		
		
		
		<?php
		
		
	}
	
	
	
}// Ends class
	
?>