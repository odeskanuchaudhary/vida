<?php
/**
 * ViDA Matchmaking Blog CPT
 * @vida
 *
 * Filename: class-vida-matchmaking-blog-cpt.php
 *
 * Description: Custom Post Type for ViDA Matchmaking Blog
 * @Params: 
 *
 * Class: ViDA_Matchmaking_Blog_CPT
 */

 
defined( 'ABSPATH' ) or die( "This page intentionally left blank." );

if ( ! class_exists( 'ViDA_Matchmaking_Blog_CPT' ) ) {
	
	
	class ViDA_Matchmaking_Blog_CPT {	
		
		
		public function __construct( ) {
			
			//register custom post type
			add_action( 'init', array( $this, 'matchmaking_blog_cpt'), 0  );

			//register custom post taxonomy
			add_action( 'init', array( $this, 'matchmaking_blog_category'), 0 );
			
			//query_vars			
			//add_filter( 'query_vars', array( $this, 'matchmaking_blog_posttype_query_vars') );	
			
			//filter permalink			
			add_filter( 'post_type_link', array( $this, 'matchmaking_blog_posttype_permalink'), 1, 2 );	
			
			//permastruct
			add_action( 'init', array( $this, 'matchmaking_blog_custom_rewrite_rule') );
			
			add_filter('template_redirect', array( $this, 'matchmaking_blog_custom_template_redirect') );
			
			//rewrite fix
			//add_action( 'pre_get_posts',  array( $this, 'matchmaking_blog_custom_parse_request') );
			
		}
		
				
		// Register Custom Post Type
		function matchmaking_blog_cpt() {

			$labels = array(
				'name'                  => _x( 'Matchmaking Posts', 'Post Type General Name', 'vida' ),
				'singular_name'         => _x( 'Matchmaking Post', 'Post Type Singular Name', 'vida' ),
				'menu_name'             => __( 'Matchmaking Blog', 'vida' ),
				'name_admin_bar'        => __( 'Matchmaking Post', 'vida' ),
				'archives'              => __( 'Matchmaking Post Archives', 'vida' ),
				'attributes'            => __( 'Matchmaking Post Attributes', 'vida' ),
				'parent_item_colon'     => __( 'Parent Matchmaking Post:', 'vida' ),
				'all_items'             => __( 'All Posts', 'vida' ),
				'add_new_item'          => __( 'Add New Matchmaking Post', 'vida' ),
				'add_new'               => __( 'Add New Post', 'vida' ),
				'new_item'              => __( 'New Matchmaking Post', 'vida' ),
				'edit_item'             => __( 'Edit Matchmaking Post', 'vida' ),
				'update_item'           => __( 'Update Matchmaking Post', 'vida' ),
				'view_item'             => __( 'View Matchmaking Post', 'vida' ),
				'view_items'            => __( 'View Matchmaking Posts', 'vida' ),
				'search_items'          => __( 'Search Matchmaking Post', 'vida' ),
				'not_found'             => __( 'Not found', 'vida' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'vida' ),
				'featured_image'        => __( 'Featured Image', 'vida' ),
				'set_featured_image'    => __( 'Set featured image', 'vida' ),
				'remove_featured_image' => __( 'Remove featured image', 'vida' ),
				'use_featured_image'    => __( 'Use as featured image', 'vida' ),
				'insert_into_item'      => __( 'Insert into post', 'vida' ),
				'uploaded_to_this_item' => __( 'Uploaded to this post', 'vida' ),
				'items_list'            => __( 'Matchmaking Posts list', 'vida' ),
				'items_list_navigation' => __( 'Posts list navigation', 'vida' ),
				'filter_items_list'     => __( 'Filter posts list', 'vida' ),
			);
			$rewrite = array(
				'slug'                  => 'matchmaking',
				'with_front'            => true,
				'pages'                 => true,
				'feeds'                 => true,
			);
			$args = array(
				'label'                 => __( 'Matchmaking Post', 'vida' ),
				'description'           => __( 'ViDA Matchmaking Blog', 'vida' ),
				'labels'                => $labels,
				'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
				'taxonomies'            => array( 'matchmaking_category' ),
				'hierarchical'          => false,
				'public'                => true,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'menu_position'         => 5,
				'menu_icon'             => 'dashicons-welcome-write-blog',
				'show_in_admin_bar'     => true,
				'show_in_nav_menus'     => false,
				'can_export'            => true,
				'has_archive'           => false,		
				'exclude_from_search'   => false,
				'publicly_queryable'    => true,
				'query_var'             => 'matchmaking',
				//'query_var'             => false,
				'rewrite'               => $rewrite,
				'capability_type'       => 'post',
				//'register_meta_box_cb'  => array( $this, 'vida_matchmaking_blog_cpt_hide_meta_boxes' )
			);
			register_post_type( 'matchmaking', $args );

		} //Custom Post Type

		
		// Register Custom Taxonomy
		function matchmaking_blog_category() {

			$labels = array(
				'name'                       => _x( 'Matchmaking Categories', 'Taxonomy General Name', 'vida' ),
				'singular_name'              => _x( 'Matchmaking Category', 'Taxonomy Singular Name', 'vida' ),
				'menu_name'                  => __( 'Matchmaking Category', 'vida' ),
				'all_items'                  => __( 'All Categories', 'vida' ),
				'parent_item'                => __( 'Parent Category', 'vida' ),
				'parent_item_colon'          => __( 'Parent Category:', 'vida' ),
				'new_item_name'              => __( 'New Category Name', 'vida' ),
				'add_new_item'               => __( 'Add New Category', 'vida' ),
				'edit_item'                  => __( 'Edit Category', 'vida' ),
				'update_item'                => __( 'Update Category', 'vida' ),
				'view_item'                  => __( 'View Category', 'vida' ),
				'separate_items_with_commas' => __( 'Separate categories with commas', 'vida' ),
				'add_or_remove_items'        => __( 'Add or remove categories', 'vida' ),
				'choose_from_most_used'      => __( 'Choose from the most used', 'vida' ),
				'popular_items'              => __( 'Popular Categories', 'vida' ),
				'search_items'               => __( 'Search Categories', 'vida' ),
				'not_found'                  => __( 'Not Found', 'vida' ),
				'no_terms'                   => __( 'No categories', 'vida' ),
				'items_list'                 => __( 'Categories list', 'vida' ),
				'items_list_navigation'      => __( 'Categories list navigation', 'vida' ),
			);
			$args = array(
				'labels'                     => $labels,
				'hierarchical'               => true,
				'public'                     => true,
				'show_ui'                    => true,
				'show_admin_column'          => true,
				'show_in_nav_menus'          => false,
				'show_tagcloud'              => true,
			);
			register_taxonomy( 'matchmaking_category', array( 'matchmaking' ), $args );

		} //Taxonomy
		
		function matchmaking_blog_posttype_query_vars( $query_vars ) {
			
			$query_vars[] = 'matchmaking';
			
			return $query_vars;
			
		}

		// Customize permalink
		function matchmaking_blog_posttype_permalink( $post_link, $post ) {

			if ( 'matchmaking' == get_post_type( $post ) ) {
				
				$post_link = str_replace( '/matchmaking/', '/blog/', $post_link );
				
			}

			return $post_link;
		}
		
		
		function matchmaking_blog_custom_rewrite_rule() {				
			
			//add_rewrite_rule( 'matchmaking/([^/]+)$', 'blog/$matches[1]', 'top' );
			add_rewrite_rule( 'blog/([^/]+)$', 'index.php?post_type=matchmaking&matchmaking=$matches[1]', 'top' );
			
		}
		
		//redirect matchmaking posts
		function matchmaking_blog_custom_template_redirect() {
			
			if( strpos($_SERVER['REQUEST_URI'], "matchmaking/") ) {
				
				wp_redirect( get_permalink($post->ID), 301 );
				
				exit;
			}
			
			
					
			
			
		}
		

		// Trick Wordpress to know our custom post type matchmaking-blog
		function matchmaking_blog_custom_parse_request( $query ) {
			
			//echo '<pre>' . print_r(get_option('rewrite_rules'), true) . '</pre>';
			//var_dump( $query->query_vars['post_type'] );

			// Only loop the main query
			if ( ! $query->is_main_query() )
				return;			

			// Only loop our very specific rewrite rule match
			if ( 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
				return;
			}

			// 'name' will be set if post permalinks are just post_name, otherwise the page rule will match
			if ( ! empty( $query->query['name'] ) ) {

				$query->set( 'post_type', array( 'post', 'matchmaking', 'page' ) );
			}
		}		

		
		//hide metaboxes
		function vida_matchmaking_blog_cpt_hide_meta_boxes() {
			
			global $wp_meta_boxes;

			foreach ( $wp_meta_boxes as $k => $v ) {
				foreach ( $wp_meta_boxes[ $k ] as $j => $u ) {
					foreach ( $wp_meta_boxes[ $k ][ $j ] as $l => $y ) {
                        // XXX: Is this use of $y on the next line correct? || $m == 'postcustom' 
						foreach ( $wp_meta_boxes[ $k ][ $j ][ $l ] as $m => $y ) {
							//echo $m . "<br />";
							if ( ! ( $m == 'vida_html_embed_options' || $m == 'html_categorydiv' || $m == 'submitdiv' || $m == 'slugdiv'  )  ) {
								//unset( $wp_meta_boxes[ $k ][ $j ][ $l ][ $m ] );
							}
						}
					}
				}
			}

			return;
		}
		
	} //End class

} //end if

$vida_matchmaking_blog_instance = new ViDA_Matchmaking_Blog_CPT();