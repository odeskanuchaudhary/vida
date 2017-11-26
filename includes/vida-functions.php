<?php
/**
 * Custom Theme Functions for ViDA
 * 
 * @package Moesia
 *
 * 1. Page Builder for ViDA
 * 2. ViDA Theme Widgets for Page Builder
 * 3. Custom Themes Filters
 * 4. Custom Defined Theme location hooks
 * 5. 
 * 6. Metabox to hide live chat
 */
 

/**
 * 1. Setup tab for ViDA theme widget
 */
 
 function vida_theme_widgets_tab($tabs){
	$tabs[] = array(
		'title' => __('ViDA Theme Widgets', 'moesia'),
		'filter' => array(
			'groups' => array('vida-theme')
		)
	);
	return $tabs;
}
add_filter('siteorigin_panels_widget_dialog_tabs', 'vida_theme_widgets_tab', 20);
 

/* 2. ViDA Theme widgets */

function vida_theme_widgets($widgets) {
	$theme_widgets = array(
		'ViDA_Title_Bar_Excerpt',
		'ViDA_Testimonials',
		'ViDA_Textarea',
		'ViDA_Heading_Tags',
		'ViDA_Team_Member',
		'ViDA_Image_Hover_Info',
		'ViDA_Clients',
		'Moesia_Action',
	);
	foreach($theme_widgets as $theme_widget) {
		if( isset( $widgets[$theme_widget] ) ) {
			$widgets[$theme_widget]['groups'] = array('vida-theme');
			$widgets[$theme_widget]['icon'] = 'dashicons dashicons-schedule';
		}
	}
	return $widgets;
}
add_filter('siteorigin_panels_widgets', 'vida_theme_widgets');


	//unregister parent widgets we don't need
	function vida_parent_widgets_unregister() {
		
		remove_filter('siteorigin_panels_widgets', 'moesia_theme_widgets');
		remove_filter('siteorigin_panels_widget_dialog_tabs', 'moesia_theme_widgets_tab', 20);
		remove_filter('siteorigin_panels_widget_dialog_tabs', 'moesia_theme_widgets_tab', 20);
		
		if ( function_exists('siteorigin_panels_activate') )
			unregister_widget( 'Moesia_Action' );
			
		unregister_widget( 'Moesia_Testimonials' );
		unregister_widget( 'Moesia_Recent_Comments' );
		unregister_widget( 'Moesia_Recent_Posts' );
		unregister_widget( 'Moesia_Social_Profile' );
		unregister_widget( 'Moesia_Contact_Info' );
		unregister_widget( 'Moesia_Skills' );
		unregister_widget( 'Moesia_Services' );
		unregister_widget( 'Moesia_Employees' );
		unregister_widget( 'Moesia_Fp_Social_Profile' );
		unregister_widget( 'Moesia_Projects' );
		unregister_widget( 'Moesia_Latest_News' );
		unregister_widget( 'Moesia_Blockquote' );
		unregister_widget( 'Moesia_Facts' );
		unregister_widget( 'Moesia_Video_Widget' );
		unregister_widget( 'Moesia_Clients' );
		unregister_widget( 'Moesia_Action' );
		
		
	}
	add_action( 'widgets_init', 'vida_parent_widgets_unregister', 25 );
	
	
	function vida_widgets_init() {
		
		global $pagenow;		
		
		if ( $pagenow != 'widgets.php' ) {
			
			//Register the front page widgets
			if ( function_exists('siteorigin_panels_activate') ) {	
			  
				register_widget( 'ViDA_Title_Bar_Excerpt' );
				register_widget( 'ViDA_Testimonials' );
				
				register_widget( 'ViDA_Team_Member' );
				register_widget( 'ViDA_Image_Hover_Info' );
				register_widget( 'ViDA_Heading_Tags' );
				register_widget( 'ViDA_Clients' );
				register_widget( 'Moesia_Action' );
				//widget column
			}
			
		} else  {
			
			// unregister widgets we only use on PB
			//unregister_widget( 'Moesia_Clients' );			
			
		}
		register_widget( 'ViDA_Textarea' );
		register_widget( 'ViDA_Sidebar_Optin' );
	

	}
	add_action( 'widgets_init', 'vida_widgets_init', 30 );


	/**
	 * Load the custom vida widgets for Page Builder.
	 */
	if ( function_exists('siteorigin_panels_activate') ) {
		require get_stylesheet_directory() . "/widgets/vida-title-bar-excerpt.php";
		require get_stylesheet_directory() . "/widgets/vida-testimonials.php";
		require get_stylesheet_directory() . "/widgets/vida-textarea.php";
		require get_stylesheet_directory() . "/widgets/vida-heading-tags.php";
		require get_stylesheet_directory() . "/widgets/vida-clients-carousel.php";
		require get_stylesheet_directory() . "/widgets/vida-team-member.php";
		require get_stylesheet_directory() . "/widgets/vida-image-hover-info.php";
		//require get_template_directory() . "/widgets/fp-call-to-action.php";
		require get_stylesheet_directory() . "/widgets/vida-sidebar-optin.php";
	}
	
	/**
	 * Load the custom vida widgets for Widgets area only.	 */
	require_once get_stylesheet_directory() . '/widgets/vida-textarea.php';
	require_once get_stylesheet_directory() . "/widgets/vida-sidebar-optin.php";

 
	/**
	 * 3. Custom Filter Functions
	 * @ fitlered locations: body_class, _remove_script_version, 
	 *   wp_print_scripts, wp_print_styles, wp_head, admin-image upload sizes
	 */	
	

	//* Filter Function to remove query strings from links/sources */
	function _remove_script_version( $src ) {
		
		$parts = explode( '?ver', $src );
		
		return $parts[0];

	}
	add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
	add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );
	
	
	/*function to add async to all scripts*/
	function js_async_attr($tag, $handle){

		//exclude Thrive Themes from async
		global $post;
		$current_post_type = get_post_type( $post );

		if ( 'tve_form_type' == $current_post_type )
			return $tag;
		
		// do not async if admin or jquery || 'jquery-migrate' == $handle
		// TODO: async jQuery and test with ViDA_Script_Loader || 'jquery-migrate' == $handle || 'mr_tracking' == $handle
		if ( is_admin() || 'jquery' == $handle || 'jquery-core' == $handle )
			return $tag;
		
		# Add async to all remaining scripts
		return str_replace( " src", " async='async' src", $tag );
		
	}
	add_filter( 'script_loader_tag', 'js_async_attr', 10, 2 );	
	
	
	
	//* Filter to add body Classes
	function vida_add_body_class($classes) {
	
		if ( is_page_template('page_sales-funnel.php') || is_page_template('page_sales-funnel-thin.php') || is_page_template('page_vida-sales-builder.php') )
			$classes[] = 'vida-funnel-type';
		
		if ( is_page_template('page_sales-funnel.php' ) )
			$classes[] = 'sales-funnel-main';
		
		if ( is_page_template('page_sales-funnel-thin.php' ) )
			$classes[] = 'sales-funnel-thin';
		
		if ( is_page_template('page_vida-sales-builder.php') )
			$classes[] = 'sales-funnel-builder';
		
		//* extend more here
		
		
		return $classes;

	}
	add_filter('body_class', 'vida_add_body_class');



	/* ViDA custom filters A
	 * -> @ViDA Scripts 
	 * hide scripts not needed.
	 */
	function vida_filter_scripts_out() {
		
		global $post;
		
		//* hide scripts
		
		// blog, single posts
		if (  is_front_page() || is_page( 12 ) ) {
			
			wp_dequeue_script( 'comment-reply' );
			
		}
		
		//press
		if (  ! is_page( 20 ) ) {
			
			wp_dequeue_script( 'slb_core' );
			
		}
		
		//profile writing
		if (  ! ( is_page( 203 ) || is_page( 8117 ) )  ) {
			
			wp_dequeue_script( 'timed-content_js' );
			
		}
		
		//service not available page
		if (  ! is_page( 6523 ) ) {
			
			wp_dequeue_script( 'jquery-form' );
			wp_dequeue_script( 'contact-form-7' );
			
		}		
		
		//moesia general
		if ( get_theme_mod('moesia_scroller') != 1 )  {
			/* override nice scroller - dont use! */
			wp_dequeue_script( 'moesia-nicescroll-init' );
			wp_deregister_script( 'moesia-nicescroll-init' );

		}

		//remove clickfunnels click_pop script if not used
		//if ( ! ( is_singular( 'post' ) || has_shortcode( $post->post_content, 'clickfunnels_clickpop') ) ) {
		if ( is_a( $post, 'WP_Post' ) && ! has_shortcode( $post->post_content, 'clickfunnels_clickpop') ) {
			wp_dequeue_script( 'cf_clickpop' );
		}

		
	}	
	add_action( 'wp_print_scripts', 'vida_filter_scripts_out', 20 );
	
	
	/* ViDA custom filters B
	 * -> @ViDA Styles 
	 * hide styles not needed.
	 */
	function vida_filter_style_out() {
		

		// hide styles in general, only show on page it is used
		
		if (  ! is_page( 203 ) ) {
			
			wp_dequeue_style('timed-content-css');
			
		}
		
		if (  ! is_page( 20 ) ) {
			
			wp_dequeue_style('slb_core');			
		}
		
		if (  ! is_page( 6523 ) ) {
			
			wp_dequeue_style('contact-form-7');
			
		}

		if ( ! ( is_singular('post') || is_home()  )  ) {
			
			wp_dequeue_style('wp-biographia-bio');
			wp_dequeue_style('crp-style-rounded-thumbs');			
			wp_dequeue_style('open-sans-css');		
			
		}
		
	}	
	add_action( 'wp_print_styles', 'vida_filter_style_out', 20 );	
	
	
	
	/* ViDA custom filters C
	 * -> @ViDA Scripts 
	 * hide scripts - conditional options.
	 *
	 * NOTE: This is hooked early at 0, just hook your action to the same/or higher priority of the filter to be removed 
	 * Fronthooks only
	 */
	function vida_filter_wphead_out() {	
	
		/**
		 * Hide Header / Footer
		 * 
		 */		 
		$hideHeader = vida_get_metabox( 'vida_utility_hide_header' );
		$hideFooter = vida_get_metabox( 'vida_utility_hide_footer' );
		
		if ( $hideHeader )
			add_filter( 'hide_vida_header', '__return_true' );
		else
			add_filter( 'hide_vida_header', '__return_false' );
		
		if ( $hideFooter )
			add_filter( 'hide_vida_footer', '__return_true' );
		else
			add_filter( 'hide_vida_footer', '__return_false' );	
		
		
		if ( is_page_template('page_sales-funnel.php') || is_page_template('page_sales-funnel-thin.php') ) {
			
			add_filter( 'hide_vida_header', '__return_true' );
			add_filter( 'hide_vida_footer', '__return_true' );	
			
		}
		
		/**
		 * Women's Button Link
		 * check if the current page/post is set to hide the floating button, if not show it
		 */
		
		//bottom bar
		$hideBottomBarLink = vida_get_metabox( 'vida_utility_hide_womens_bar_link' );
		
		if ( $hideBottomBarLink )
			add_filter( 'hide_vida_womens_bottom_bar', '__return_true' );
		else
			add_filter( 'hide_vida_womens_bottom_bar', '__return_false' );
		
		//floating button
		$hideFloatingButton = vida_get_metabox( 'vida_utility_hide_floating_button_link' );

		if ( $hideFloatingButton )
			add_filter( 'vida_hide_floating_button', '__return_true' );
		else
			add_filter( 'vida_hide_floating_button', '__return_false' );
				
		/* Update: July 29, 2017 - From Nick - Hide Women's bottom bar and floating button on Matchmaker blog only */
		if ( is_singular( 'matchmaking' ) || is_page( 'matchmaking-blog' ) || is_post_type_archive( 'matchmaking' ) ) {
			add_filter( 'vida_hide_floating_button', '__return_true' );
			add_filter( 'hide_vida_womens_bottom_bar', '__return_true' );
		}
		
		/**
		 * Hide Live Chat box
		 * check if the page is set to hide livechat, if not show it
		 
		 
		//get metabox
		$hideLCbox = vida_get_metabox( 'vida_live_chat_hide_livechat' );
			
		if ( $hideLCbox ) {

			//if using a plugin
			if ( class_exists( 'LiveChat' ) )
				remove_action( 'wp_head', array( LiveChat::get_instance(), 'tracking_code' ), 10 );
			
			// filter function to show live-chat
			add_filter( 'hide_vida_live_chat', '__return_true' );
			
		} 
		*/
	}
	add_action( 'wp_head', 'vida_filter_wphead_out', 0 );
	
	
	/* ViDA custom filters D - Remove actions hooked into 'init' action
	 * -> @ViDA Scripts 
	 * hide scripts - conditional options.
	 *
	 * NOTE: This is hooked early at 0, just hook your action to the same/or higher priority of the filter to be removed 
	 */
	function vida_filter_init_out() {	

		
		
	}
	add_action( 'init', 'vida_filter_init_out', 0 );


	//* We add our options to the media upload
	add_filter( 'image_size_names_choose', 'vida_custom_sizes' );
	function vida_custom_sizes( $sizes ) {
			
		return array_merge( $sizes, array(
			'vida-blog-onethird' => __( 'ViDA Small (1/3)' ),
			'vida-blog-onehalf' => __( 'ViDA Medium (1/2)' ),
			'vida-blog-twothird' => __( 'ViDA Large (2/3)' ),
			'vida-blog-threefourth' => __( 'ViDA xLarge (3/4)' ),
			'vida-blog-full' => __( 'ViDA Full (Post Area Width)' ),
		) );
			
	}
	
	//* add content wrapper for blog posts
	add_filter( 'the_content', 'vida_content', 0 );
	function vida_content( $content ) {
		
		return '<div class="vida-post-content">' . $content . '</div>';
		
	}
	
	add_action( 'wp_footer', 'vida_remove_disqus_scripts', 0 );
	function vida_remove_disqus_scripts() {
		
		remove_action( 'wp_footer', 'dsq_output_footer_comment_js', 10 );
		
	}
	add_action( 'wp_head', 'vida_remove_disqus_scripts', 0 );
	


	remove_filter('pre_term_description', 'wp_filter_kses');

 /* End of Custom Filter Functions */
 
 
/**
 * 4. Custom Defined Theme hooks
 * vida_body_start, vida_body_end, vida_wp_head
 */
 
	function vida_body_start() {
		do_action( 'vida_body_start' );
	}
	 
	function vida_body_end() {
		do_action( 'vida_body_end' );
	}
 
	//* ViDA ontraport CGI & POF Pro catch
	function vida_ontraport_query_var( $vars ){
		
		$vars[] = "email";
		$vars[] = "name";
		$vars[] = "fullname";
		$vars[] = "firstname";
		$vars[] = "ip_addy"; 
		
		$vars[] = "sid";
		$vars[] = "a";
		$vars[] = "g";
		$vars[] = "adid";
		
		$vars[] = "utm_campaign";
		$vars[] = "utm_source";
		$vars[] = "utm_medium";
		$vars[] = "utm_content";
		$vars[] = "utm_term";		
		
	  return $vars;
	}
	add_filter( 'query_vars', 'vida_ontraport_query_var' );

	
	//* ViDA custom metabox retreiver
	function vida_get_metabox( $value ) {
		
		global $post;

		if ( is_home() && 'page' == get_option( 'show_on_front' ) ) {
			$pID = get_option('page_for_posts' );
		} elseif ( isset( $post ) ) {
			$pID = $post->ID;
		} else {
			return false;			
		}

		$field = get_post_meta( $pID, $value, true );
		
		if ( !isset($field) )
			return  false;
		
		if ( ! empty( $field ) ) {
			return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
		} else {
			return false;
		}
	}
	
	//* ViDA custom metabox retreiver for RAW scripts
	function vida_get_metabox_raw( $value ) {
		
		global $post;
		
		if ( is_home() && 'page' == get_option( 'show_on_front' ) ) {
			$pID = get_option('page_for_posts' );
		} elseif ( isset( $post ) ) {
			$pID = $post->ID;
		} else {
			return false;			
		}

		$field = get_post_meta( $pID, $value, true );
		
		if ( !isset($field) )
			return  false;
		
		if ( ! empty( $field ) ) {
			return ( $field );
		} else {
			return false;
		}
	}
	
		
/* end 4. */	

/**
 * 5. Add page builder Widget attribute for Content By Country plugin
 *
 * plugin trying to filter: Content by Country
 * class: ICWP_CustomContentByCountry
 */

	function vida_filter_admin_init() {
	 
		// Custom content by Country - set filter if plugin is active or not
		if ( class_exists( 'ICWP_CustomContentByCountry' ) )
			add_filter( 'CBC_Plugin_is_Disabled', '__return_false' );
		else
			add_filter( 'CBC_Plugin_is_Disabled', '__return_true' );		
		
	}
	add_action( 'init', 'vida_filter_admin_init', 5 );
	


add_action( 'admin_init', 'vida_cbc_page_builder_admin_hooks' );
function vida_cbc_page_builder_admin_hooks() {

	if ( apply_filters( 'CBC_Plugin_is_Disabled', TRUE ) )
		return;		
	
	// add ViDA group to SO panel row
	function row_style_groups($groups) {

	  $groups['vida'] = array(
				'name' => __('Custom Content By Country', 'siteorigin-panels'),
				'priority' => 15
	  );
	  return $groups;
	}
	//add_filter( 'siteorigin_panels_widget_style_groups', 'widget_style_groups' );
	add_filter( 'siteorigin_panels_row_style_groups', 'row_style_groups' );

	// create the fields for custom content by country
	function vida_panels_row_style_fields( $fields ) {
		
			$fields['cbc_display'] = array(
				'name' => __('Country Codes', 'vida-panels'),
				'type' => 'text',
				'group' => 'vida',
				'description' => __('Two character country codes (e.g. us, es, uk).', 'vida-panels'),
				'priority' => 8,
			);
			$fields['cbc_hide'] = array(
				'name' => __('Display for this Country', 'vida-panels'),
				'label' => __('', 'vida-panels'),
				'type' => 'select',
				'group' => 'vida',
				'options' => array(
					'y' => __('Show', 'siteorigin-panels'),
					'n' => __('Hide', 'siteorigin-panels'),
				),
				'description' => __('Show/hide content from the locations above. (Default: Show)', 'vida-panels'),
				'priority' => 9,
			);		
			return $fields;

	}
	//add_filter('siteorigin_panels_widget_style_fields', 'vida_panels_widget_style_fields', 10);  //if you want to add on a cell widget
	add_filter('siteorigin_panels_row_style_fields', 'vida_panels_row_style_fields', 10); 

}

add_action( 'init', 'vida_cbc_page_builder_front_hooks' );
function vida_cbc_page_builder_front_hooks() {
	
	if ( apply_filters( 'CBC_Plugin_is_Disabled', TRUE ) ) :
	
		function hide_cbc_variations() {
			
			?>
			<style>			
				.cbc-variation {
					display: none;					
				}
			</style>			
			<?php
		}
		add_action( 'wp_head', 'hide_cbc_variations' );	
	
		return;	
		
	endif;

	// add filter to before content and check for Content By Country
	function vida_before_row_widgets_cbc_filter() {

		// start output buffering to be used for CBC filtering
		ob_start();
		
	}
	add_filter( 'siteorigin_panels_before_row', 'vida_before_row_widgets_cbc_filter' );


	// add filter to before content and check for Content By Country
	function vida_after_row_widgets_cbc_filter( $panel_id, $panels_data, $attributes ) {	
		
		$cbc_widget_content = "";
		$cbc_locations = "";
		
		// global
		$GLOBALS['panel_id'] = $panel_id;
		
		// get the panel data that holds all widgets
		if( is_string( $panels_data ) ) {
			$panels_data = json_decode( $panels_data, true );
		}
		
		
		
		//get the buffer content
		$cbc_widget_content = ob_get_clean();	

		// get the metabox details for the CBC plugin
		$cbc_locations = (isset($panels_data['style']['cbc_display'])) ? $panels_data['style']['cbc_display'] : '';	
		
		// if no location, no filtering, return the buffer!
		if ( null === $cbc_locations || '' === $cbc_locations )
			return $cbc_widget_content;

		// get option to handle the locations specified
		$cbc_hidden = !($panels_data['style']['cbc_hide']=='y') ? 'n' : 'y'; //boolean

		//$cbc_out = sprintf('[CBC country="%s" show="%s"]%s[/CBC]',$cbc_locations ,$cbc_hidden , $cbc_widget_content );
		
		$cbc_out = do_shortcode('[CBC country="'.$cbc_locations.'" show="'.$cbc_hidden.'"]'.$cbc_widget_content.'[/CBC]');
		
		
		echo '<!--Start CBC filter-->' .  $cbc_out  . '<!--Ends CBC filter-->';
		
	}
	add_filter( 'siteorigin_panels_after_row', 'vida_after_row_widgets_cbc_filter', 10, 3 );

}

function vida_so_row_filters() {
	
	remove_filter( 'siteorigin_panels_row_style_fields', 'moesia_panels_row_style_fields', 10 );
	//add_filter('siteorigin_panels_row_style_fields', array('SiteOrigin_Panels_Default_Styling', 'row_style_fields' ) );
	remove_filter( 'siteorigin_panels_row_style_attributes', 'moesia_panels_panels_row_style_attributes', 10 );
	
}
add_action( 'after_setup_theme', 'vida_so_row_filters', 11 );

function vida_custom_row_style_fields( $fields ) {
	
		$fields['background'] = array(
			'name' => __('Background Color', 'vida'),
			'type' => 'color',
			'priority' => 5,
		);
		
		$fields['background_image'] = array(
			'name' => __('Background Image', 'vida'),
			'type' => 'url',
			'description' => __('URL of background image.', 'vida'),			
			'priority' => 6,
		);

		$fields['background_display'] = array(
			'name' => __('Background Image Display', 'vida'),
			'type' => 'select',
			'options' => array(
				'center' => __('Centered, with original size', 'vida'),
				'center_top' => __('Centered, Top', 'vida'),
				'tile' => __('Tiled Image', 'vida'),
				'cover' => __('Cover', 'vida'),				
				'contain' => __('Contain', 'vida'),				
			),
			'priority' => 7,
		);
		
		$fields['vida_lazy_bg'] = array(
			'name'        => __('Background Image Loading', 'vida'),
			'type'        => 'checkbox',
			'label' 		=> 'Enable Lazy Load',
			'description' => __('If enabled, will have a lazy load effect.', 'vida'),
			'priority'    => 8,
		);
		
	
		$fields['color'] = array(
			'name' => __('Text Color', 'vida'),
			'type' => 'color',
			'description' => __('Default text color.', 'vida'),
			'priority'    => 15,
		);	
	

		$fields['collapse_order'] = array(
			'name' => __('Collapse Order', 'vida'),
			'type' => 'select',
			'options' => array(
				'' => __('Default', 'vida'),
				'left-top' => __('Left on Top', 'vida'),
				'right-top' => __('Right on Top', 'vida'),
			),
			'priority' => 15,
		);

		$fields['id'] = array(
			'name' => __('Row ID', 'siteorigin-panels'),
			'type' => 'text',
			'group' => 'attributes',
			'description' => __('A custom ID used for this row.', 'siteorigin-panels'),
			'priority' => 4,
		);
		
		$fields['class'] = array(
				'name' => __('Row Class', 'vida'),
				'type' => 'text',
				'group' => 'attributes',
				'description' => __('A CSS class', 'vida'),
				'priority' => 5,
		);
		$fields['cell_class'] = array(
				'name' => __('Cell Class', 'vida'),
				'type' => 'text',
				'group' => 'attributes',
				'description' => __('Class added to all cells in this row.', 'vida'),
				'priority' => 6,
		);
	
  return $fields;
}
add_filter( 'siteorigin_panels_row_style_fields', 'vida_custom_row_style_fields', 11 );

/* Adds .lazy class to div containing background image data-src */
function vida_custom_row_style_attributes( $attributes, $args ) {

	//reset
	$attributes['style'] = '';
	
	//customize background:
	if( !empty( $args['background'] ) ) {
		$attributes['style'] .= 'background-color: '.$args['background'].'; ';
	}
	
	if( !empty( $args['background_display'] ) && !empty( $args['background_image'] ) ) {
		
		if ( !empty( $args['vida_lazy_bg'] ) ) {
			
			$attributes['data-src'] = esc_url($args['background_image']);
		
		} else {
			
			$attributes['style'] .= 'background: url('.esc_url($args['background_image']).'); ';
			
		}
		
		switch( $args['background_display'] ) {
			
			case 'tile':
				$attributes['style'] .= 'background-repeat: repeat;';
				break;
			
			case 'cover':
				$attributes['style'] .= 'background-size: cover;';
				break;
				
			case 'contain':
				$attributes['style'] .= 'background-size: contain; background-position: center top; background-repeat: no-repeat;';
				break;
		
			case 'center':
				$attributes['style'] .= 'background-position: center center; background-repeat: no-repeat;';
				break;
				
			case 'center_top':
				$attributes['style'] .= 'background-position: center top; background-repeat: no-repeat;';
				break;
		}
		
		$attributes['style'] .= 'background-attachment: inherit;';

		//add the lazy class
		if( !empty( $args['vida_lazy_bg'] ) ) {
			//$attributes['class'][] = 'lazy';
			array_push( $attributes['class'], 'lazy' );
		}
		
	}
	
	if(empty($attributes['style'])) unset($attributes['style']);

    return $attributes;
}
add_filter('siteorigin_panels_row_style_attributes', 'vida_custom_row_style_attributes', 10, 2);


// add for widgets/cells
function vida_custom_widget_style_fields( $fields ) {

	//reset
	$attributes['style'] = '';
	
	//customize background:
	if( !empty( $args['background'] ) ) {
		$attributes['style'] .= 'background-color: '.$args['background'].'; ';
	}	
		
		$fields['background_image'] = array(
			'name' => __('Background Image', 'vida'),
			'type' => 'url',
			'group' => 'design',
			'description' => __('URL of background image.', 'vida'),			
			'priority' => 6,
		);

		$fields['background_display'] = array(
			'name' => __('Background Image Display', 'vida'),
			'type' => 'select',
			'group' => 'design',
			'options' => array(
				'center' => __('Centered, with original size', 'vida'),
				'center_top' => __('Centered, Top', 'vida'),
				'tile' => __('Tiled Image', 'vida'),
				'cover' => __('Cover', 'vida'),				
				'contain' => __('Contain', 'vida'),				
			),
			'priority' => 7,
		);
		
		$fields['vida_lazy_bg'] = array(
			'name'        => __('Background Image Loading', 'vida'),
			'type'        => 'checkbox',
			'label' 		=> 'Enable Lazy Load',
			'group' => 'design',
			'description' => __('If enabled, will have a lazy load effect.', 'vida'),
			'priority'    => 8,
		);
		
		unset( $fields['background_image_attachment'] );
		
	return $fields;
	
}
add_filter('siteorigin_panels_widget_style_fields', 'vida_custom_widget_style_fields' );
//remove_filter('siteorigin_panels_widget_style_fields', array('SiteOrigin_Panels_Default_Styling', 'widget_style_fields' ) );


function vida_custom_widget_style_attributes( $attributes, $args ) {
	
	
//customize background:
	if( !empty( $args['background'] ) ) {
		$attributes['style'] .= 'background-color: '.$args['background'].'; ';
	}
	
	if( !empty( $args['background_display'] ) && !empty( $args['background_image'] ) ) {
		
		if ( !empty( $args['vida_lazy_bg'] ) ) {
			
			$attributes['data-src'] = esc_url($args['background_image']);
		
		} else {
			
			$attributes['style'] .= 'background: url('.esc_url($args['background_image']).'); ';
			
		}
		
		switch( $args['background_display'] ) {
			
			case 'tile':
				$attributes['style'] .= 'background-repeat: repeat;';
				break;
			
			case 'cover':
				$attributes['style'] .= 'background-size: cover; background-repeat: no-repeat;';
				break;
				
			case 'contain':
				$attributes['style'] .= 'background-size: contain; background-position: center center; background-repeat: no-repeat; ';
				break;
		
			case 'center':
				$attributes['style'] .= 'background-position: center center; background-repeat: no-repeat;';
				break;
				
			case 'center_top':
				$attributes['style'] .= 'background-position: center top; background-repeat: no-repeat;';
				break;
		}
		
		$attributes['style'] .= 'background-attachment: inherit;';

		//add the lazy class
		if( !empty( $args['vida_lazy_bg'] ) ) {
			array_push( $attributes['class'], 'lazy' );
		}
		
	}
	
	if(empty($attributes['style'])) unset($attributes['style']);
	
	
	return $attributes;	
}
add_filter( 'siteorigin_panels_widget_style_attributes', 'vida_custom_widget_style_attributes', 10, 2 );
//add_filter('siteorigin_panels_widget_style_attributes', array('SiteOrigin_Panels_Default_Styling', 'widget_style_attributes' ), 10, 2);




/**
 * 6. Metabox - ViDA Custom filters for pages/posts
 * -Metabox + Hook
 */ 
	
	//* Adds the metabox

	add_action( 'admin_init', 'vida_custom_filters_metabox', 5 );

	function vida_custom_filters_metabox() {
		
		//this inserts the metaboxes
		function vida_filters_add_meta_box() {
			
			global $post;
		
			if ( ! isset( $post ) )
				return false;
		
			// checks for post/page ID	
			//$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
			$post_id = $post->ID;
		
			//get template file name
			$template_file = get_post_meta($post_id,'_wp_page_template',TRUE);	
			
			
				if ( $template_file == 'page_sales-funnel.php' || $template_file == 'page_sales-funnel-thin.php' ) {

					add_meta_box(
						'vida_custom_header-vida-custom-header',
						__( 'ViDA Custom Page Header', 'vida_custom_header' ),
						'vida_custom_header_render_html',
						'page',
						'normal',
						'high'
					);				
					
				}
				
				add_meta_box(
					'vida_custom_filters-vida-custom-filers',
					__( 'ViDA Custom Page Options', 'vida_custom_filters' ),
					'vida_metabox_filters_html',
					'post',
					'side',
					'core'
				);
				add_meta_box(
					'vida_custom_filters-vida-custom-filers',
					__( 'ViDA Custom Page Options', 'vida_custom_filters' ),
					'vida_metabox_filters_html',
					'page',
					'side',
					'core'
				);
			
				add_meta_box(
					'vida_custom_scripts-vida-custom-scripts',
					__( 'ViDA Custom Scripts (Insert Header/Footer CSS/JS)', 'vida_custom_scripts' ),
					'vida_custom_scripts_render_html',
					'page',
					'normal',
					'high'
				);
				
		}
		add_action( 'add_meta_boxes', 'vida_filters_add_meta_box' );

		function vida_metabox_filters_html( $post ) {
			wp_nonce_field( '_vida_metabox_filter', 'vida_metabox_filter' ); 
			
			global $post_type;
			
			$vida_301_redirect_page_url = esc_url( ViDA::get_metabox('vida_301_redirect_url') );
			
			?>
			
			<p>301 Redirect to:
				<input class="large-text" id="vida_301_redirect_url" name="vida_301_redirect_url" type="text" value="<?php echo $vida_301_redirect_page_url; ?>" placeholder="(Enter URL or leave blank to disable)" /><?php if ( null != $vida_301_redirect_page_url ) { ?><span class="description"><a title="<?php echo $vida_301_redirect_page_url; ?>" href="<?php echo $vida_301_redirect_page_url; ?>" target="_blank">View Redirect</a></span><?php } ?>			
			</p>

			<hr />

			<p><strong>Live Chat Software</strong></p>
			<p><input type="checkbox" name="vida_live_chat_hide_livechat" id="vida_live_chat_hide_livechat" value="hide-livechat" <?php echo ( vida_get_metabox( 'vida_live_chat_hide_livechat' ) === 'hide-livechat' ) ? 'checked' : ''; ?>>
				<label for="vida_live_chat_hide_livechat"><?php _e( 'Disable LiveChat on this page', 'vida_live_chat' ); ?></label>	</p>

			<hr />
			
			<p><strong>Site Header and Footer</strong></p>
			<p><input type="checkbox" name="vida_utility_hide_header" id="vida_utility_hide_header" value="hide-header" <?php echo ( vida_get_metabox( 'vida_utility_hide_header' ) === 'hide-header' ) ? 'checked' : ''; ?>>
				<label for="vida_utility_hide_header"><?php _e( 'Hide Header and Menu', 'vida_utility' ); ?></label>	</p>
				
			<p><input type="checkbox" name="vida_utility_hide_footer" id="vida_utility_hide_footer" value="hide-footer" <?php echo ( vida_get_metabox( 'vida_utility_hide_footer' ) === 'hide-footer' ) ? 'checked' : ''; ?>>
				<label for="vida_utility_hide_footer"><?php _e( 'Hide Footer', 'vida_utility' ); ?></label>	</p>
				
			<hr />
			
			<p><strong>Women's Site Link (Floating Button & Bar)</strong></p>
					<p><input type="checkbox" name="vida_utility_hide_womens_bar_link" id="vida_utility_hide_womens_bar_link" value="hide-bar-link" <?php echo ( vida_get_metabox( 'vida_utility_hide_womens_bar_link' ) === 'hide-bar-link' ) ? 'checked' : ''; ?>> <label for="vida_utility_hide_womens_bar_link"><?php _e( 'Disable Bottom Bar Link', 'vida_utility' ); ?></label>	</p>
					
					<p><input type="checkbox" name="vida_utility_hide_floating_button_link" id="vida_utility_hide_floating_button_link" value="hide-button-link" <?php echo ( vida_get_metabox( 'vida_utility_hide_floating_button_link' ) === 'hide-button-link' ) ? 'checked' : ''; ?>> <label for="vida_utility_hide_floating_button_link"><?php _e( 'Disable Floating Button', 'vida_utility' ); ?></label>	</p>

				<div id="btn_scroll_options">
				
					<p>Directly link to a specific page:<br /><span class="description">www.virtualdatingassistants.com/women/</span>
					<input class="large-text" id="btn_link_custom_slug" name="btn_link_custom_slug" type="text" value="<?php echo ViDA::get_metabox('btn_link_custom_slug'); ?>" placeholder=" (enter page slug only) " /><span class="description"> e.g. online-matchmakers</span></p>
			
				
					<p>Hide on scroll position (number only): <br /><input class="medium-text" id="vida_button_scroll_position" name="vida_button_scroll_position" type="text" value="<?php echo ViDA::get_metabox('vida_button_scroll_position'); ?>" placeholder=" (Default: 1/3 of page) " /><span class="description"> e.g. 1300</span></p>
					
				</div>
					<script type="text/javascript">
						jQuery(function($) {
							$("#vida_utility_hide_floating_button_link").click( function() {
								if ( $("#vida_utility_hide_floating_button_link").prop("checked") )
									$("#btn_scroll_options").hide();
								else
									$("#btn_scroll_options").show();								
							});
						});					
					</script>				
			
			<hr />
				
			<p><strong>IP-GEO Location Country Restriction</strong></p>
				
			<p><input type="checkbox" name="vida_utility_enable_ipgeo_redirect" id="vida_utility_enable_ipgeo_redirect" value="enable-geo-redirect" <?php echo ( vida_get_metabox( 'vida_utility_enable_ipgeo_redirect' ) === 'enable-geo-redirect' ) ? 'checked' : ''; ?>> <label for="vida_utility_enable_ipgeo_redirect"><?php _e( 'Enable Country-Based Restriction', 'vida_utility' ); ?></label></p>
			
			<div id="ipgeo_redirect_options" style="display:none">
			
				<?php $ipgeo_selected = vida_get_metabox( 'ipgeo_redirect_showhide_page' ); ?>
				
				<p class="text-center"><input type="radio" name="ipgeo_redirect_showhide_page" id="ipgeo_redirect_show_page" value="ipgeo_show" <?php checked( $ipgeo_selected, 'ipgeo_show' ); if ( empty( $ipgeo_selected )  ) echo 'checked'; ?>><label for="ipgeo_redirect_show_page"><?php _e( 'Show', 'vida_utility' ); ?></label> &nbsp; <input type="radio" name="ipgeo_redirect_showhide_page" id="ipgeo_redirect_hide_page" value="ipgeo_hide" <?php checked( $ipgeo_selected, 'ipgeo_hide' ) ?>><label for="ipgeo_redirect_hide_page"><?php _e( 'Hide', 'vida_utility' ); ?></label></p>
				
				<p>Country Code: <input class="small-text" id="ipgeo_redirect_country_code" name="ipgeo_redirect_country_code" type="text" value="<?php echo ViDA::get_metabox('ipgeo_redirect_country_code'); ?>" placeholder=" US" size="2" min="2" max="2"/><span class="description"> e.g. US, GB, AU</span></p>				
				
				<p>Redirect to:
				
					<select id="ipgeo_redirect_slug" name="ipgeo_redirect_slug">
						<option value=""><?php echo esc_attr( __( 'Select page' ) ); ?></option> 
						<?php 
						$current_ID = get_the_ID();
						$pages = get_pages( array( 'post_status' => 'publish', 'exclude' => array($current_ID) ) );
						$ipgeo_redirect_slug_page = ViDA::get_metabox('ipgeo_redirect_slug'); 
						
						foreach( $pages as $page ) {
							echo '<option value="' . $page->ID . '" ' . ( $ipgeo_redirect_slug_page==$page->ID ? 'selected="selected"' : '' ) . ' >' . ( ( $page->post_title ) ? $page->post_title : '(No Title)' ) . '</option>';
						}
						?>	
					</select>
				
					</p>
					
			</div>
			
			<script type="text/javascript">
				jQuery(function($) {
					function vida_check_geoip_functions() {
						if ( $("#vida_utility_enable_ipgeo_redirect").prop("checked") ) {
							$("#ipgeo_redirect_options").show();
							$("#ipgeo_redirect_country_code").prop( "required", true );
							$("#ipgeo_redirect_slug").prop( "required", true );
						} else {
							$("#ipgeo_redirect_options").hide();
							$("#ipgeo_redirect_country_code").prop( "required", false );
							$("#ipgeo_redirect_slug").prop( "required", false );
						}							
					}
					$("#vida_utility_enable_ipgeo_redirect").click( function() {
						vida_check_geoip_functions();							
					});
					vida_check_geoip_functions();
				});					
			</script>
			
			<?php
		}

		function vida_custom_header_render_html( $post ) {
			wp_nonce_field( '_vida_custom_header_filter', 'vida_custom_header_filter' ); 
			
			global $post_type;
			
			?>

			<p>
				<label for="vida_custom_header_html"><?php _e( 'Custom Page Header: ', 'vida_custom_header' ); ?> <span class="description">(Add your custom header here. Goes above the white area.)</span></label>
				<?php 
				$vida_custom_header_html  = vida_get_metabox( 'vida_custom_header_html' );
				wp_editor( $vida_custom_header_html, 'vida_custom_header_html', array( 'textarea_name' => 'vida_custom_header_html', 'textarea_rows' => '8', 'media_buttons' => true, 'tinymce' => true, 'quicktags' => true ) ); ?>
			</p>		
			
			<?php
		}

		function vida_custom_scripts_render_html( $post ) {
			wp_nonce_field( '_vida_custom_scripts_filter', 'vida_custom_scripts_filter' ); 
			
			global $post_type;
			
			?>

			<p>
				<label for="vida_custom_scripts_header_html"><?php _e( 'Header: Insert Scripts into <head> section: ', 'vida_custom_scripts' ); ?> <span class="description">(Add CSS/JS here)</span></label>
				<?php 
				$vida_custom_scripts_header_html  = vida_get_metabox_raw( 'vida_custom_scripts_header_html' );
				wp_editor( $vida_custom_scripts_header_html, 'vida_custom_scripts_header_html', array( 'textarea_name' => 'vida_custom_scripts_header_html', 'textarea_rows' => '5', 'media_buttons' => false, 'tinymce' => false, 'quicktags' => false ) ); ?>
			</p>		

			<p>
				<label for="vida_custom_scripts_footer_html"><?php _e( 'Footer: Insert Scripts into \'Footer\' area of the site: ', 'vida_custom_scripts' ); ?> <span class="description">(Add CSS/JS here)</span></label>
				<?php 
				$vida_custom_scripts_footer_html  = vida_get_metabox_raw( 'vida_custom_scripts_footer_html' );
				wp_editor( $vida_custom_scripts_footer_html, 'vida_custom_scripts_footer_html', array( 'textarea_name' => 'vida_custom_scripts_footer_html', 'textarea_rows' => '5', 'media_buttons' => false, 'tinymce' => false, 'quicktags' => false ) ); ?>
			</p>			
			<?php
		}		

		/* Save Function - custom page options */
		function vida_metabox_filters_save( $post_id ) {
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
			if ( ! isset( $_POST['vida_metabox_filter'] ) || ! wp_verify_nonce( $_POST['vida_metabox_filter'], '_vida_metabox_filter' ) ) return;
			if ( ! current_user_can( 'edit_post', $post_id ) ) return;

			//custom 301 redirect
			if ( isset( $_POST['vida_301_redirect_url'] ) )
				update_post_meta( $post_id, 'vida_301_redirect_url', esc_url_raw( $_POST['vida_301_redirect_url'] ) );
			else
				update_post_meta( $post_id, 'vida_301_redirect_url', null );

			//hide live chat
			if ( isset( $_POST['vida_live_chat_hide_livechat'] ) )
				update_post_meta( $post_id, 'vida_live_chat_hide_livechat', esc_attr( $_POST['vida_live_chat_hide_livechat'] ) );
			else
				update_post_meta( $post_id, 'vida_live_chat_hide_livechat', null );


			if ( isset( $_POST['vida_utility_hide_header'] ) )
				update_post_meta( $post_id, 'vida_utility_hide_header', esc_attr( $_POST['vida_utility_hide_header'] ) );
			else
				update_post_meta( $post_id, 'vida_utility_hide_header', null );

			if ( isset( $_POST['vida_utility_hide_footer'] ) )
				update_post_meta( $post_id, 'vida_utility_hide_footer', esc_attr( $_POST['vida_utility_hide_footer'] ) );
			else
				update_post_meta( $post_id, 'vida_utility_hide_footer', null );
			
			//women's bottom bar link
			if ( isset( $_POST['vida_utility_hide_womens_bar_link'] ) )
				update_post_meta( $post_id, 'vida_utility_hide_womens_bar_link', esc_attr( $_POST['vida_utility_hide_womens_bar_link'] ) );
			else
				update_post_meta( $post_id, 'vida_utility_hide_womens_bar_link', null );
			
			//floating button
			if ( isset( $_POST['vida_utility_hide_floating_button_link'] ) )
				update_post_meta( $post_id, 'vida_utility_hide_floating_button_link', esc_attr( $_POST['vida_utility_hide_floating_button_link'] ) );
			else
				update_post_meta( $post_id, 'vida_utility_hide_floating_button_link', null );

			//floating button - custom link/slug
			if ( isset( $_POST['btn_link_custom_slug'] ) )
				update_post_meta( $post_id, 'btn_link_custom_slug', esc_attr( $_POST['btn_link_custom_slug'] ) );
			else
				update_post_meta( $post_id, 'btn_link_custom_slug', null );			

			//floating button - scroll position
			if ( isset( $_POST['vida_button_scroll_position'] ) )
				update_post_meta( $post_id, 'vida_button_scroll_position', esc_attr( $_POST['vida_button_scroll_position'] ) );
			else
				update_post_meta( $post_id, 'vida_button_scroll_position', null );
			
			
			/* Custom IP-GEO redirect */
			//enabled checkbox
			if ( isset( $_POST['vida_utility_enable_ipgeo_redirect'] ) ) {
				
				update_post_meta( $post_id, 'vida_utility_enable_ipgeo_redirect', esc_attr( $_POST['vida_utility_enable_ipgeo_redirect'] ) );
				
				//country code
				if ( isset( $_POST['ipgeo_redirect_country_code'] ) )
					update_post_meta( $post_id, 'ipgeo_redirect_country_code', esc_attr( $_POST['ipgeo_redirect_country_code'] ) );
				
				// ipgeo_redirect_showhide_page
				if ( isset( $_POST['ipgeo_redirect_showhide_page'] ) )
					update_post_meta( $post_id, 'ipgeo_redirect_showhide_page', esc_attr( $_POST['ipgeo_redirect_showhide_page'] ) );

				//slug
				if ( isset( $_POST['ipgeo_redirect_slug'] ) )
					update_post_meta( $post_id, 'ipgeo_redirect_slug', esc_attr( $_POST['ipgeo_redirect_slug'] ) );
				
				
			} else {
				
				update_post_meta( $post_id, 'vida_utility_enable_ipgeo_redirect', null ); update_post_meta( $post_id, 'ipgeo_redirect_showhide_page', null );
				update_post_meta( $post_id, 'ipgeo_redirect_country_code', null );
				update_post_meta( $post_id, 'ipgeo_redirect_showhide_page', null );	
				update_post_meta( $post_id, 'ipgeo_redirect_slug', null );				
				
			}


		}		
		add_action( 'save_post', 'vida_metabox_filters_save' );
		
		
		/* Save Function - custom header */
		function vida_custom_header_save( $post_id ) {
			
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
			if ( ! isset( $_POST['vida_custom_header_filter'] ) || ! wp_verify_nonce( $_POST['vida_custom_header_filter'], '_vida_custom_header_filter' ) ) return;
			if ( ! current_user_can( 'edit_post', $post_id ) ) return;

			if ( isset( $_POST['vida_custom_header_html'] ) )
				update_post_meta( $post_id, 'vida_custom_header_html', $_POST['vida_custom_header_html'] );		
			
		}		
		add_action( 'save_post', 'vida_custom_header_save' );
		
		/* Save Function - header and footer scripts */
		function vida_custom_scripts_save( $post_id ) {
			
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
			if ( ! isset( $_POST['vida_custom_scripts_filter'] ) || ! wp_verify_nonce( $_POST['vida_custom_scripts_filter'], '_vida_custom_scripts_filter' ) ) return;
			if ( ! current_user_can( 'edit_post', $post_id ) ) return;

			if ( isset( $_POST['vida_custom_scripts_header_html'] ) )
				update_post_meta( $post_id, 'vida_custom_scripts_header_html', $_POST['vida_custom_scripts_header_html'] );
			
			if ( isset( $_POST['vida_custom_scripts_footer_html'] ) )
				update_post_meta( $post_id, 'vida_custom_scripts_footer_html', $_POST['vida_custom_scripts_footer_html'] );
			
		}		
		add_action( 'save_post', 'vida_custom_scripts_save' );
		
	}

	
	/* Output the header metaboxes on the site */	
	add_action( 'wp_head', 'vida_custom_scripts_header_insert_html', 99 );
	function vida_custom_scripts_header_insert_html() {
		
		$vida_custom_scripts_header_html  = vida_get_metabox_raw( 'vida_custom_scripts_header_html' );
				
		if ( $vida_custom_scripts_header_html ) :
				
			echo ( "<!-- ViDA Header Scripts -->" . $vida_custom_scripts_header_html . "<!-- End ViDA Header Scripts -->" );

		endif;	
		
	}
	
	/* Output the footer metaboxes on the site */	
	add_action( 'wp_footer', 'vida_custom_scripts_footer_insert_html', 99 );
	function vida_custom_scripts_footer_insert_html() {
		
		$vida_custom_scripts_footer_html  = vida_get_metabox_raw( 'vida_custom_scripts_footer_html' );
				
		if ( $vida_custom_scripts_footer_html ) :
				
			echo ( "<!-- ViDA Footer Scripts -->" . $vida_custom_scripts_footer_html . "<!-- End ViDA Footer Scripts -->" );

		endif;	
		
	}	
	
/* end 6 */


function vida_style_visible_logged_in() {
	
	print "<!-- visible-logged-in style -->";
	
	if ( is_user_logged_in() ) :
	?>
	
		<style>.site-content .visible-logged-in { display: block !important;   visibility: visible !important;}</style>
		
	<?php else : ?>
	
		<style>.logged-in .site-content .visible-logged-in { display: block !important;  visibility: visible !important; }</style>	
	
	<?php
	endif;
	
}

add_action( 'wp_head', 'vida_style_visible_logged_in' );



/* get current menu name from location */
function vida_get_theme_menu_name( $theme_location ) {
	if( ! $theme_location ) return false;
 
	$theme_locations = get_nav_menu_locations();
	if( ! isset( $theme_locations[$theme_location] ) ) return false;
 
	$menu_obj = get_term( $theme_locations[$theme_location], 'nav_menu' );
	if( ! $menu_obj ) $menu_obj = false;
	if( ! isset( $menu_obj->name ) ) return false;
 
	return $menu_obj->name;
}


/**
 * vida-related-posts
 */
function vida_related_posts( $post_ids, $exclude_current ) {
	
	if ( !$post_ids ) {
		
		echo '<p class="text-center"><span class="label bg-danger">Please enter post IDs for the related post function.</span></p>';
		
		return;
		
	}
	
	$ex_post_ids = array ( $exclude_current, "4966" ); // add custom exclude post IDs
	
	$sel_post_ids = array_diff( $post_ids, $ex_post_ids );
	//print_r($sel_post_ids);
	
	$args = array(
	  'posts_per_page' => 4,
	  'numberposts' => 4,
	  'post__in'   => $sel_post_ids,
	  'order' => 'ASC',
	  'orderby' => 'rand',
	  'ignore_sticky_posts' => 1,
	);
	
	$related_posts = get_posts( $args );
	
	
	if ( empty($related_posts) ) {
		
		echo '<p class="text-center"><span class="label bg-danger">No found related posts. Please enter valid post IDs.</span></p>';
		
		return;
		
	} else { //list the posts
	
		global $post;
		
		print '<ul id="vida-popular-posts" class="vida-related-posts clearfix">';
		
		  foreach ( $related_posts as $post ) :
		
			setup_postdata( $post ); 
			
			?>		
				<li class="vida-crp col-xs-12 col-sm-6 col-md-3">
				  <span class="rel-wrap">
					<a href="<?php the_permalink(); ?>">
						<?php 
						if ( has_post_thumbnail() ) {
							
							/* revised - use OutputBuffer to catch image, replace src attribute with data-src for lazy loading */
							ob_start();
							
							the_post_thumbnail( array( 237, 165, true ), array( 'class' => 'lazy rel-thumb') );
							//the_post_thumbnail( array( 245, 200, true ), array( 'class' => 'rel-thumb') );
							
							$post_thumb = ob_get_clean();
							
							$src_replace = sprintf( 'src="%s" data-src=', VIDA_IMAGE_PLACEHOLDER );
							
							echo str_replace( 'src=', $src_replace, $post_thumb );
							
						} else {
							
							$post_image = "";
							
							if ( ! $post_image ) {
								
								echo '<img src="/wp-content/plugins/contextual-related-posts/default.png" alt="' . get_the_title() . '" title="' . get_the_title() . '" width="245" height="200" class="lazy rel-thumb">';
								
							}
							
						}
						 ?>					
						<div class="rel-title"><?php the_title(); ?></div>
					</a>
				  </span>					
				</li>			
			<?php
		  endforeach; 
   
		 wp_reset_postdata();
		
		print '</ul>';
		
	}
	
}

?>