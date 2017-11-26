<?php
/**
 * HTML Embed Pages
 * @vida
 *
 * Filename: class-vida-html-embed.php
 *
 * Description: HTML Embed post type to add custom HTML pages.
 * @Params: Title/Slug, HTML embed link
 *
 * Class: ViDA_HTML_Embed_Pages
 */

 
defined( 'ABSPATH' ) or die( "This page intentionally left blank." );

if ( ! class_exists( 'ViDA_HTML_Embed_Pages' ) ) {
	
	
	class ViDA_HTML_Embed_Pages {		
		
		
		public function __construct( ) {
			
			//register post type
			add_action( 'init', array( $this, 'vida_html_posttype'), 0  );
			
			//register taxonomy
			add_action( 'init', array( $this, 'vida_html_taxonomy'), 0  );
			
			
			//add styles
			add_action('admin_head', array( $this, 'custom_admin_css') );
			
			//customize admin columns
			add_filter( 'manage_edit-vida_html_columns', array( $this, 'vida_html_posttype_columns' ) );	
			
			//populate admin columns
			add_action( 'manage_posts_custom_column', array( $this, 'vida_html_posttype_populate_columns' ), 10, 2 );

			//add metaboxes			
			add_action( 'add_meta_boxes', array( $this, 'vida_html_posttype_metabox_render') );			
		
			//save metaboxes
			add_action( 'save_post', array( $this, 'vida_html_posttype_metabox_save') );
			
			//filter permalink			
			add_filter( 'post_type_link', array( $this, 'vida_html_posttype_permalink'), 10, 2 );

			//rewrite fix
			add_action( 'pre_get_posts',  array( $this, 'vida_html_posttype_custom_parse_request') );
		
		}
		
		
		// Register Custom Post Type
		function vida_html_posttype() {

			$labels = array(
				'name'                  => _x( 'HTML Pages', 'Post Type General Name', 'vida' ),
				'singular_name'         => _x( 'HTML Page', 'Post Type Singular Name', 'vida' ),
				'menu_name'             => __( 'HTML Pages', 'vida' ),
				'name_admin_bar'        => __( 'HTML Page', 'vida' ),
				'archives'              => __( 'HTML Page Archives', 'vida' ),
				'parent_item_colon'     => __( 'Parent Item:', 'vida' ),
				'all_items'             => __( 'All HTML Pages', 'vida' ),
				'add_new_item'          => __( 'Add New Page', 'vida' ),
				'add_new'               => __( 'Add New', 'vida' ),
				'new_item'              => __( 'New Page', 'vida' ),
				'edit_item'             => __( 'Edit Page', 'vida' ),
				'update_item'           => __( 'Update Page', 'vida' ),
				'view_item'             => __( 'View Page', 'vida' ),
				'search_items'          => __( 'Search Page', 'vida' ),
				'not_found'             => __( 'Not found', 'vida' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'vida' ),
				'featured_image'        => __( 'Featured Image', 'vida' ),
				'set_featured_image'    => __( 'Set featured image', 'vida' ),
				'remove_featured_image' => __( 'Remove featured image', 'vida' ),
				'use_featured_image'    => __( 'Use as featured image', 'vida' ),
				'insert_into_item'      => __( 'Insert into item', 'vida' ),
				'uploaded_to_this_item' => __( 'Uploaded to this item', 'vida' ),
				'items_list'            => __( 'Pages list', 'vida' ),
				'items_list_navigation' => __( 'Pages list navigation', 'vida' ),
				'filter_items_list'     => __( 'Filter items list', 'vida' ),
			);
			$rewrite = array(
				'slug'                  => 'vida_html',
				'with_front'            => false,
				'pages'                 => false,
				'feeds'                 => false,
			);
			$args = array(
				'label'                 => __( 'HTML Page', 'vida' ),
				'description'           => __( 'HTML Embed post type to add custom HTML pages', 'vida' ),
				'labels'                => $labels,
				'supports'              => array( 'title', 'custom-fields' ),
				'taxonomies'            => array( 'html_category' ),
				'hierarchical'          => false,
				'public'                => true,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'menu_position'         => 20,
				'menu_icon'             => 'dashicons-media-code',
				'show_in_admin_bar'     => true,
				'show_in_nav_menus'     => false,
				'can_export'            => true,
				'has_archive'           => false,		
				'exclude_from_search'   => false,
				'publicly_queryable'    => true,
				'rewrite'               => $rewrite,
				'capability_type'       => 'page',
				'register_meta_box_cb'  => array( $this, 'vida_html_embed_hide_meta_boxes' )
			);
			register_post_type( 'vida_html', $args );

		} //posttype

		// Register ViDA_HTML Posttype Taxonomy
		function vida_html_taxonomy() {

			$labels = array(
				'name'                       => _x( 'Categories', 'Taxonomy General Name', 'text_domain' ),
				'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'text_domain' ),
				'menu_name'                  => __( 'Category', 'text_domain' ),
				'all_items'                  => __( 'All Categories', 'text_domain' ),
				'parent_item'                => __( 'Parent Category', 'text_domain' ),
				'parent_item_colon'          => __( 'Parent Category:', 'text_domain' ),
				'new_item_name'              => __( 'New Category Name', 'text_domain' ),
				'add_new_item'               => __( 'Add New Category', 'text_domain' ),
				'edit_item'                  => __( 'Edit Category', 'text_domain' ),
				'update_item'                => __( 'Update Category', 'text_domain' ),
				'view_item'                  => __( 'View Category', 'text_domain' ),
				'separate_items_with_commas' => __( 'Separate categories with commas', 'text_domain' ),
				'add_or_remove_items'        => __( 'Add or remove categories', 'text_domain' ),
				'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
				'popular_items'              => __( 'Popular Categories', 'text_domain' ),
				'search_items'               => __( 'Search Categories', 'text_domain' ),
				'not_found'                  => __( 'Not Found', 'text_domain' ),
				'no_terms'                   => __( 'No Categories', 'text_domain' ),
				'items_list'                 => __( 'Categories list', 'text_domain' ),
				'items_list_navigation'      => __( 'Categories list navigation', 'text_domain' ),
			);

			$args = array(
				'labels'                     => $labels,
				'hierarchical'               => true,
				'public'                     => false,
				'show_ui'                    => true,
				'show_admin_column'          => true,
				'show_in_nav_menus'          => false,
				'show_tagcloud'              => false,
			);
			register_taxonomy( 'html_category', array( 'vida_html' ), $args );

		} //vida_html_taxonomy
		
		
		// Create Metabox for page URL
		function vida_html_posttype_metabox_render() {
			
			function vida_html_embed_options_html( $post ) {
				
				//create nonce
				wp_nonce_field( '_vida_html_embed_options', 'vida_html_embed_options' );				
				
				?>
				<p>
				  <label for="vida_html_url"><strong><?php _e( 'HTML File Link:', 'vida_html_embed_options' ); ?></strong><span class="description"><?php _e( ' (Add the link to the html file here)', 'vida_html_embed_options' ); ?></span></label><br />
				<?php echo site_url('/'); ?><input type="text" name="vida_html_url" class="regular-text" id="vida_html_url" value="<?php echo ( get_post_meta( $post->ID, 'vida_html_url', true ) ); ?>" />
				</p>
				
				<?php
			}
			
			add_meta_box(
				'vida_html_embed_options',
				__( 'HTML Embed Page Options', 'vida_html_embed_options' ),
				'vida_html_embed_options_html',
				'vida_html',
				'normal',
				'core'
			);
			
		} //vida_html_posttype_metabox_render
		
		
		// Save Metabox data
		function vida_html_posttype_metabox_save( $post_id ){			
			
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
			if ( ! isset( $_POST['vida_html_embed_options'] ) || ! wp_verify_nonce( $_POST['vida_html_embed_options'], '_vida_html_embed_options' ) ) return;
			if ( ! current_user_can( 'edit_post', $post_id ) ) return;
			
			
			if ( isset( $_POST['vida_html_url'] ) )
				update_post_meta( $post_id, 'vida_html_url', ltrim( esc_attr( $_POST['vida_html_url'] ), '/' )  );
			else
				update_post_meta( $post_id, 'vida_html_url', null );
			
			
		} //vida_html_posttype_metabox_save		
		

		// Customize permalink
		function vida_html_posttype_permalink( $post_link, $post ) {
			
			if ( 'vida_html' == get_post_type( $post ) ) {
				
				$post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
				
			}

			return $post_link;
		}
		
		// Trick Wordpress to know our custom post type
		function vida_html_posttype_custom_parse_request( $query ) {

			// Only loop the main query
			if ( ! $query->is_main_query() )
				return;

			// Only loop our very specific rewrite rule match
			if ( 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
				return;
			}

			// 'name' will be set if post permalinks are just post_name, otherwise the page rule will match
			if ( ! empty( $query->query['name'] ) ) {
				$query->set( 'post_type', array( 'post', 'vida_html', 'page' ) );
			}
		}		

		
		// admin columns headers
		function vida_html_posttype_columns( $columns ) {
			$cols                        				= array();
			$cols['cb']                  				= $columns['cb'];
			$cols['vida_html_title'] 					= $columns['title'];
			$cols['vida_html_slug'] 					= 'URL/HTML file source';		
			$cols['vida_html_taxonomy-html_category']	= 'Category/Group';
			$cols['date']                				= 'Date';

			return $cols;
		}
		
		// populate columns
		function vida_html_posttype_populate_columns( $column, $post_id ) {
			
			$site_url = site_url() . '/';
			
			if ( 'vida_html_title' == $column ) {
				$edit_link    = get_edit_post_link( get_the_ID() );
				$page_title = get_the_title();
				echo '<strong><a class="row-title" href="' . $edit_link . '" aria-label="' . $page_title . '">' . $page_title . '</a></strong>';
			}
			
			if ( 'vida_html_slug' == $column ) {
				$url_slug = get_permalink();
				$url_source = get_post_meta( get_the_ID(), 'vida_html_url', true );
				echo '<strong><a href="' . $url_slug . '" target="_blank">' . $url_slug . '</a></strong><br />';
				echo '<small>' . $site_url . $url_source . '</small>';
			}
			
			if ( 'vida_html_taxonomy-html_category' == $column ) {
				
				$terms = get_the_term_list( $post_id , 'html_category' , '' , ',' , '' );
				
				if ( is_string( $terms ) )
					echo $terms;
				else
					_e( 'Unable to get category/group', 'vida' );
				
			}

			
		}
		
		// custom admin styles
		function custom_admin_css() {
			
			global $post_type;
			
			if ( 'vida_html' == $post_type ) {
			
				echo '<style>
					#vida_html_title {
						width: 25%;
					}
					#vida_html_taxonomy-html_category {
						width: 15%;
					}
					</style>';
				
			}
		 }
		

		//hide metaboxes
		function vida_html_embed_hide_meta_boxes() {
			
			global $wp_meta_boxes;

			foreach ( $wp_meta_boxes as $k => $v ) {
				foreach ( $wp_meta_boxes[ $k ] as $j => $u ) {
					foreach ( $wp_meta_boxes[ $k ][ $j ] as $l => $y ) {
                        // XXX: Is this use of $y on the next line correct? || $m == 'postcustom' 
						foreach ( $wp_meta_boxes[ $k ][ $j ][ $l ] as $m => $y ) {
							//echo $m . "<br />";
							if ( ! ( $m == 'vida_html_embed_options' || $m == 'html_categorydiv' || $m == 'submitdiv' || $m == 'slugdiv'  )  ) {
								unset( $wp_meta_boxes[ $k ][ $j ][ $l ][ $m ] );
							}
						}
					}
				}
			}

			return;
		}
		
	} //End class

} //end if

$vida_html_embed_instance = new ViDA_HTML_Embed_Pages();