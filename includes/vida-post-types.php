<?php
/**
 * ADD Vida Custom Post Types
 * @ViDA cpt
 */


/**
 * Custom HTML Embed Pages
 */ 
require get_stylesheet_directory() . "/inc/class-vida-html-embed.php";

/**
 * Matchmaking Blog Custom Post Type 
 */ 
require get_stylesheet_directory() . "/inc/class-vida-matchmaking-blog-cpt.php";

function vida_testimonials_quickedit_box( $column_name, $post_type ) {
	
	if ( 'vida_content_length' != $column_name )
		return;
	
		?>
	
		<fieldset class="inline-edit-col-right inline-edit-book">
			<div class="inline-edit-col column-<?php echo $column_name; ?>">
			  <label for="content_l"><span class=""><?php _e( 'Content Length ', 'client' ); ?></span>
				<?php wp_nonce_field( '_content_nonce', 'content_nonce' );  ?>
				<select id="content_l" name="content_l">
					<option value="" ><?php echo esc_attr( __( '--' ) ); ?></option>
					<option value="short" ><?php echo esc_attr( __( 'Short' ) ); ?></option>
					<option value="normal" ><?php echo esc_attr( __( 'Normal' ) ); ?></option>
					<option value="long" ><?php echo esc_attr( __( 'Long' ) ); ?></option>
				</select>		
			  </label>
			</div>
		</fieldset>
		<?php
	
}
add_action( 'quick_edit_custom_box', 'vida_testimonials_quickedit_box', 10, 2 );
add_action( 'bulk_edit_custom_box', 'vida_testimonials_quickedit_box', 10, 2 );


function vida_testimonials_enqueue_edit_scripts() {
	
   wp_enqueue_script( 'vida-admin-edit', get_bloginfo( 'stylesheet_directory' ) . '/includes/js/vida.quick_edit.js', array( 'jquery', 'inline-edit-post' ), '', true );

   }
add_action( 'admin_print_scripts-edit.php', 'vida_testimonials_enqueue_edit_scripts' );


function vida_testimonials_save_bulk_edit() {
	
   // get our variables
   $post_ids = ( isset( $_POST[ 'post_ids' ] ) && !empty( $_POST[ 'post_ids' ] ) ) ? $_POST[ 'post_ids' ] : array();
   
   $content_l = ( isset( $_POST[ 'content_l' ] ) && !empty( $_POST[ 'content_l' ] ) ) ? $_POST[ 'content_l' ] : NULL;
   
   // if everything is in order
   if ( !empty( $post_ids ) && is_array( $post_ids ) && !empty( $content_l ) ) {
      foreach( $post_ids as $post_id ) {
         update_post_meta( $post_id, 'content_l', $content_l );
      }
   }
   
}
add_action( 'wp_ajax_vida_testimonials_save_bulk_edit', 'vida_testimonials_save_bulk_edit' );

// Add to search filter in admin columns 
function vida_testimonials_taxonomy_search_filter() {
	
	global $typenow;
	
	if ( 'testimonials' === $typenow ){
		
		$taxonomy_list = array( 'testimonial_type', 'testimonial_country' );
		
		foreach ( $taxonomy_list as $taxonomy ) {
		
			$selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
			
			$info_taxonomy = get_taxonomy($taxonomy);
			$taxonomy_terms = get_terms( $taxonomy );
			//var_dump($taxonomy_terms) . "Count: " . count($taxonomy_terms);
			
			wp_dropdown_categories(array(
				'show_option_all' => __("All {$info_taxonomy->label}"),
				'taxonomy'        => $taxonomy,
				'name'            => $taxonomy,
				'orderby'         => 'name',
				'selected'        => $selected,
				'show_count'      => true,
				'hierarchical'	  => true,
				'pad_counts'      => true,
				'hide_empty'      => false,
				'hide_if_empty'   => true,
				'value_field'	  => 'slug',
			));
			
		}
		
	}
	
}
add_action('restrict_manage_posts', 'vida_testimonials_taxonomy_search_filter');

// The search filter request
function vida_testimonials_taxonomy_search_filter_query($request) {
	
	global $pagenow;
	
	$post_type = 'testimonials';
	//$taxonomy = 'testimonial_country';
	
	if ( is_admin() && $pagenow == 'edit.php' && isset( $request['post_type'] ) && $request['post_type'] == $post_type ) {
		
		$taxonomy_list = array( 'testimonial_country', 'testimonial_type' );
		
		foreach ( $taxonomy_list as $taxonomy ) {
		
			$term = get_term( $request[$taxonomy], $taxonomy );

			if ( isset($term) && ! is_wp_error($term) )
				$request['term'] = $term->slug;
			
		}
		
	}
	
	return $request;
	
	/*
	
	$post_type = 'testimonials';
	$taxonomy = 'testimonial_country';
	$q_vars    = &$query->query_vars;
	
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 )
	{
		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
		$q_vars[$taxonomy] = $term->slug;
	}	
	*/
	
}
add_action( 'request', 'vida_testimonials_taxonomy_search_filter_query' );
//add_filter('parse_query', 'vida_testimonials_taxonomy_search_filter_query');

// Change columns
function vida_testimonials_posttype_columns($columns) {
	
	$cols = array();
	$cols['cb'] = $columns['cb'];
	$cols['title'] = 'Author';
	$cols['vida_testimonials_type'] = 'Type';
	$cols['vida_testimonials_category'] = 'Country/Location';
	$cols['vida_content_length'] = 'Content Length';
	$cols['date'] = $columns['date'];
	
	return $cols;
	
}
add_filter( 'manage_edit-testimonials_columns', 'vida_testimonials_posttype_columns' );	

// populate columns
function vida_testimonials_posttype_populate_columns( $column, $post_id ) {
	
	
	if ( 'vida_testimonials_type' == $column ) {
		
		//$t_format = get_post_format() ?: 'Not Set';
		
		//echo ucwords( $t_format );
		
		$terms = get_the_term_list( $post_id , 'testimonial_type' , '' , ',' , '' );
					
		if ( is_string( $terms ) )
			echo $terms;
		else
			_e( 'Not Set', 'vida' );
		
	}
	
	if ( 'vida_testimonials_category' == $column ) {
				
		$terms = get_the_term_list( $post_id , 'testimonial_country' , '' , ',' , '' );
					
		if ( is_string( $terms ) )
			echo $terms;
		else
			_e( 'Not Set', 'vida' );
				
	}
	
	if ( 'vida_content_length' == $column ) {
		
		$content_l = client_get_meta( 'content_l' ) ?: 'Not Set' ;
		
		echo '<div id="content_l-' . $post_id . '">' . ucwords( $content_l ) . '</div>';
		
	}
	
}
add_action( 'manage_posts_custom_column', 'vida_testimonials_posttype_populate_columns', 10, 2 );


//* Register Custom Post Type - ViDA Testimonials
function vida_testimonials() {

	$labels = array(
		'name'                  => _x( 'Testimonials', 'Post Type General Name', 'vida' ),
		'singular_name'         => _x( 'Testimonial', 'Post Type Singular Name', 'vida' ),
		'menu_name'             => __( 'Testimonials', 'vida' ),
		'name_admin_bar'        => __( 'Testimonial', 'vida' ),
		'archives'              => __( 'Item Archives', 'vida' ),
		'parent_item_colon'     => __( 'Parent Item:', 'vida' ),
		'all_items'             => __( 'ViDA Testimonials', 'vida' ),
		'add_new_item'          => __( 'Add New Testimonial', 'vida' ),
		'add_new'               => __( 'Add New', 'vida' ),
		'new_item'              => __( 'New Testimonial', 'vida' ),
		'edit_item'             => __( 'Edit Testimonial', 'vida' ),
		'update_item'           => __( 'Update Testimonial', 'vida' ),
		'view_item'             => __( 'View Testimonial', 'vida' ),
		'search_items'          => __( 'Search Testimonial', 'vida' ),
		'not_found'             => __( 'Not found', 'vida' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'vida' ),
		'featured_image'        => __( 'Featured Image', 'vida' ),
		'set_featured_image'    => __( 'Set featured image', 'vida' ),
		'remove_featured_image' => __( 'Remove featured image', 'vida' ),
		'use_featured_image'    => __( 'Use as featured image', 'vida' ),
		'insert_into_item'      => __( 'Insert into item', 'vida' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'vida' ),
		'items_list'            => __( 'Testimonials list', 'vida' ),
		'items_list_navigation' => __( 'Testimonials list navigation', 'vida' ),
		'filter_items_list'     => __( 'Filter items list', 'vida' ),
	);
	$args = array(
		'label'                 => __( 'Testimonial', 'vida' ),
		'description'           => __( 'ViDA Testimonials', 'vida' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'page-attributes' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-format-quote',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite' 				=> array( 'slug' => 'testimonial', 'with_front' => false ),
		'capability_type'       => 'page',
	);
	register_post_type( 'testimonials', $args );

}
add_action( 'init', 'vida_testimonials', 5 );

// Add testimonial 'Country Location' category
function vida_testimonial_taxonomies() {

	$labels = array(
		'name'                       => _x( 'Country Location', 'Taxonomy General Name', 'vida' ),
		'singular_name'              => _x( 'Country Location', 'Taxonomy Singular Name', 'vida' ),
		'menu_name'                  => __( 'Country Locations', 'vida' ),
		'all_items'                  => __( 'All Country Locations', 'vida' ),
		'parent_item'                => __( 'Parent Country Location', 'vida' ),
		'parent_item_colon'          => __( 'Parent Country Location:', 'vida' ),
		'new_item_name'              => __( 'New Country Location Name', 'vida' ),
		'add_new_item'               => __( 'Add New Country Location', 'vida' ),
		'edit_item'                  => __( 'Edit Country Location', 'vida' ),
		'update_item'                => __( 'Update Country Location', 'vida' ),
		'view_item'                  => __( 'View Country Location', 'vida' ),
		'separate_items_with_commas' => __( 'Separate Country Locations with commas', 'vida' ),
		'add_or_remove_items'        => __( 'Add or Remove Country Location', 'vida' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'vida' ),
		'popular_items'              => __( 'Popular Country Locations', 'vida' ),
		'search_items'               => __( 'Search Country Locations', 'vida' ),
		'not_found'                  => __( 'Country Location Not Found', 'vida' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => false,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'rewrite' 					 => false,
		'show_in_quick_edit'              => false,
		//'update_count_callback'		 => '_update_post_term_count',
		'meta_box_cb'				 => 'vida_taxonomy_meta_box_callback',
	);
	

	$labels2 = array(
		'name'                       => _x( 'Testimonial Type', 'Taxonomy General Name', 'vida' ),
		'singular_name'              => _x( 'Testimonial Type', 'Taxonomy Singular Name', 'vida' ),
		'menu_name'                  => __( 'Testimonial Types', 'vida' ),
		'all_items'                  => __( 'All Testimonial Types', 'vida' ),
		'parent_item'                => __( 'Parent Testimonial Type', 'vida' ),
		'parent_item_colon'          => __( 'Parent Testimonial Type:', 'vida' ),
		'new_item_name'              => __( 'New Testimonial Type Name', 'vida' ),
		'add_new_item'               => __( 'Add New Testimonial Type', 'vida' ),
		'edit_item'                  => __( 'Edit Testimonial Type', 'vida' ),
		'update_item'                => __( 'Update Testimonial Type', 'vida' ),
		'view_item'                  => __( 'View Testimonial Type', 'vida' ),
		'separate_items_with_commas' => __( 'Separate Testimonial Types with commas', 'vida' ),
		'add_or_remove_items'        => __( 'Add or Remove Testimonial Type', 'vida' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'vida' ),
		'popular_items'              => __( 'Popular Testimonial Type', 'vida' ),
		'search_items'               => __( 'Search Testimonial Types', 'vida' ),
		'not_found'                  => __( 'Testimonial Type Not Found', 'vida' ),
	);
	$args2 = array(
		'labels'                     => $labels2,
		'hierarchical'               => true,
		'public'                     => false,
		'rewrite' 					 => false,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_menu'				 => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'show_in_quick_edit'              => false,
		//'update_count_callback'		 => '_update_post_term_count',
		'meta_box_cb'				 => 'vida_taxonomy_meta_box_callback',
	);
	
	
	register_taxonomy( 'testimonial_type', array( 'testimonials' ), $args2 );
	
	register_taxonomy( 'testimonial_country', array( 'testimonials' ), $args );
	
}
add_action( 'init', 'vida_testimonial_taxonomies', 0 );

// Callback to show the taxonomies in Custom Metaboxes
function vida_taxonomy_meta_box_callback( $post, $box ) {
	
	$defaults = array( 'taxonomy' => 'category' );
	
	if ( ! isset( $box['args'] ) || ! is_array( $box['args'] ) ) {
	    $args = array();
	}
	else {
	    $args = $box['args'];
	}
	extract( wp_parse_args($args, $defaults), EXTR_SKIP );
	$tax = get_taxonomy( $taxonomy );
	?>
	
	<div id="taxonomy-<?php echo $taxonomy; ?>" class="categorydiv">
	        <?php 
			
	        $name = ( $taxonomy == 'category' ) ? 'post_category' : 'tax_input[' . $taxonomy . ']';
			
	        //echo "<input type='hidden' name='{$name}[]' value='0' />"; 
			// Allows for an empty term set to be sent. 0 is an invalid Term ID and will be ignored by empty() checks.
			
			$info_taxonomy = get_taxonomy($taxonomy);
			//$taxonomy_terms = get_terms( $taxonomy );
	        
	        $term_obj = get_the_terms( $post->ID, $taxonomy ); //_log($term_obj[0]->term_id)
			
			if ( 'testimonial_type' === $taxonomy )
				$selected = isset($term_obj[0]->term_id) ? $term_obj[0]->term_id : get_term_by('slug', 'quote', 'testimonial_type')->term_id;
			elseif ( 'testimonial_country' === $taxonomy )
				$selected = isset($term_obj[0]->term_id) ? $term_obj[0]->term_id : get_term_by('slug', 'us', 'testimonial_country')->term_id;
			
			wp_dropdown_categories(array(
				'taxonomy'        => $taxonomy,				
				'name'			=> "{$name}[]",
				'orderby'         => 'name',				
				'hide_empty'      => 0,
				'class'			=> 'widefat',
				'selected'		=> $selected,
			));
			
			
	        ?>
	</div>
	<?php
}
/**
 * Client Information Meta Box
 * Client Name, Client Location
 */

function client_get_meta( $value ) {
	global $post;

	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}

function client_add_meta_box() {
	add_meta_box(
		'client-client',
		__( 'Author Information', 'client' ),
		'client_html',
		'testimonials',
		'normal',
		'high'
	);	
	
	//content length
	add_meta_box(
		'client-content',
		__( 'Content Length', 'content' ),
		'content_html',
		'testimonials',
		'side',
		'core'
	);
}
add_action( 'add_meta_boxes', 'client_add_meta_box' );

function client_html( $post ) {
	wp_nonce_field( '_client_nonce', 'client_nonce' ); ?>

	<p>
		<strong><label for="client_name"><?php _e( 'Name/Company', 'client' ); ?></label></strong><br>
		<input type="text" class="regular-text" name="client_name" id="client_name" value="<?php echo client_get_meta( 'client_name' ); ?>">
	</p>
	
	<p>
		<strong><label for="client_location"><?php _e( 'Location', 'client' ); ?></label></strong><br>
		<input type="text" class="regular-text" name="client_location" id="client_location" value="<?php echo client_get_meta( 'client_location' ); ?>">
	</p><?php
}


function content_html( $post ) {
	wp_nonce_field( '_content_nonce', 'content_nonce' ); 
	
	$content_l = client_get_meta( 'content_l' ) ?: 'normal' ;
	?>

	<p>
		<strong><label for="content_l"><?php _e( 'Content Length: ', 'client' ); ?></label></strong>
		<select id="content_l" name="content_l">
			<option value="short" <?php selected( $content_l, 'short' ); ?>><?php echo esc_attr( __( 'Short' ) ); ?></option>
			<option value="normal" <?php selected( $content_l, 'normal' ); ?>><?php echo esc_attr( __( 'Normal' ) ); ?></option>
			<option value="long" <?php selected( $content_l, 'long' ); ?>><?php echo esc_attr( __( 'Long' ) ); ?></option>
		</select>
		
		</p>
	<?php
}


function content_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['content_nonce'] ) || ! wp_verify_nonce( $_POST['content_nonce'], '_content_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	if ( array_key_exists( 'content_l', $_POST ) )
		update_post_meta( $post_id, 'content_l', esc_attr( $_POST['content_l'] ) );
		
	if ( isset( $_POST['content_l'] ) )
		update_post_meta( $post_id, 'content_l', esc_attr( $_POST['content_l'] ) );	
}
add_action( 'save_post', 'content_save' );

function client_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['client_nonce'] ) || ! wp_verify_nonce( $_POST['client_nonce'], '_client_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	if ( isset( $_POST['client_name'] ) )
		update_post_meta( $post_id, 'client_name', esc_attr( $_POST['client_name'] ) );
	
	if ( isset( $_POST['client_location'] ) )
		update_post_meta( $post_id, 'client_location', esc_attr( $_POST['client_location'] ) );
}
add_action( 'save_post', 'client_save' );

/*
	Usage: client_get_meta( 'client_name' )
	Usage: client_get_meta( 'client_location' )
*/
 
/* END - ViDA Testimonials */




// Register Custom Post Type
function vida_clients() {

	$labels = array(
		'name'                  => _x( 'Clients', 'Post Type General Name', 'vida' ),
		'singular_name'         => _x( 'Client', 'Post Type Singular Name', 'vida' ),
		'menu_name'             => __( 'ViDA Clients', 'vida' ),
		'name_admin_bar'        => __( 'ViDA Clients', 'vida' ),
		'archives'              => __( 'Client Archives', 'vida' ),
		'parent_item_colon'     => __( 'Parent Item:', 'vida' ),
		'all_items'             => __( 'All ViDA Clients', 'vida' ),
		'add_new_item'          => __( 'Add New Item', 'vida' ),
		'add_new'               => __( 'Add New', 'vida' ),
		'new_item'              => __( 'New Client', 'vida' ),
		'edit_item'             => __( 'Edit Client', 'vida' ),
		'update_item'           => __( 'Update Client', 'vida' ),
		'view_item'             => __( 'View Client', 'vida' ),
		'search_items'          => __( 'Search Client', 'vida' ),
		'not_found'             => __( 'Not found', 'vida' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'vida' ),
		'featured_image'        => __( 'Featured Image', 'vida' ),
		'set_featured_image'    => __( 'Set featured image', 'vida' ),
		'remove_featured_image' => __( 'Remove featured image', 'vida' ),
		'use_featured_image'    => __( 'Use as featured image', 'vida' ),
		'insert_into_item'      => __( 'Insert into item', 'vida' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'vida' ),
		'items_list'            => __( 'Clients list', 'vida' ),
		'items_list_navigation' => __( 'Clients list navigation', 'vida' ),
		'filter_items_list'     => __( 'Filter items list', 'vida' ),
	);
	$args = array(
		'label'                 => __( 'Client', 'vida' ),
		'description'           => __( 'ViDA Clients', 'vida' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'excerpt', 'thumbnail', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-groups',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => false,
		'has_archive'           => false,		
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'rewrite' 				=> array( 'slug' => 'what-we-do' ),
		'capability_type'       => 'page',
	);
	register_post_type( 'clients', $args );

}
add_action( 'init', 'vida_clients', 0 );


/* redirect our custom post-types */
function vida_redirect_post_types(){
	
    global $post;
	
    if( is_singular('testimonials') && ( null !=  get_page_by_path( 'reviews', OBJECT, 'page' ) ) ) {
		
        wp_redirect( home_url('/reviews') );
		
		exit;

    } elseif( is_singular('clients') ) {
		
		wp_redirect( home_url('/what-we-do') );
		
		exit;
		
	}
	
}
add_action('template_redirect', 'vida_redirect_post_types');


/* redirect our custom post-type taxonomy */
function vida_redirect_taxonmy_terms(){

	$tax_object = get_queried_object();
	
	if ( is_tax() && ( "testimonial_country" == $tax_object->taxonomy )  ) {	
		
        wp_redirect( home_url('/about-us') );
		
		exit;
		
	}
	
}
//add_action('wp', 'vida_redirect_taxonmy_terms');


/* Add post formats */
function vida_post_type_supports() {
	
	if( ! is_admin() )
		return;
	
	global $pagenow, $post;
	
	//on edit posts
	if  ( 'post.php' === $pagenow && isset($_GET['post']) && 'testimonials' != get_post_type( $_GET['post'] ) )
		return;

	//on new posts
	if  ( 'post-new.php' === $pagenow && isset($_GET['post_type']) && 'testimonials'!== $_GET['post_type'] )
		return;
		
	//add video type for testimonials
	//add_theme_support( 'post-formats', array( 'standard', 'video', 'audio' ) );
	
}
//add_action( 'after_setup_theme', 'vida_post_type_supports', 20 );
?>