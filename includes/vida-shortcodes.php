<?php
/**
 * ADD Vida Shortcodes
 * @ViDA Shortcodes
 */
function vida_shortcodes() {

	//* Add [vida_copyright]
	function sc_vida_copyright( $atts ) {
		
		return '<small>&copy; ' . date('Y') . ' VIDA - Virtual Dating Assistants. All Rights Reserved.</small>';
		
	}
	add_shortcode( 'vida_copyright', 'sc_vida_copyright' );
	
	//* Add [vida_cpt show="posttype" hide="posttype"] Shortcode
	function sc_vida_cpt( $atts, $content = null ) {		
		
		global $post;
		
		// Attributes
		extract( shortcode_atts(
			array(
				'show' => '',
				'hide' => '',
			), $atts )
		);
		
		if ( $hide ) {
			
			if ( is_singular( array( $hide ) ) || is_post_type_archive( array( $hide ) ) )
				return false;
			
		} else {
			
			if ( ! ( is_singular( array( $show ) ) || is_post_type_archive( array( $show ) ) ) )
				return false;
			
		}
		
		return  '<div class="vida-cpt-filter" >'. do_shortcode($content).'</div>';
	}
	add_shortcode( 'vida_cpt', 'sc_vida_cpt' );
	
	
	//* Add [vida_category show="cat_IDs" hide="cat_IDs"] Shortcode
	function sc_vida_category( $atts, $content = null ) {
	
		global $post;
		
		// Attributes
		extract( shortcode_atts(
			array(
				'show' => '',
				'hide' => '',
			), $atts )
		);
		
		$vida_str = "";

		//var_dump( get_queried_object() ) ;

		// Code			
		if ( is_home()  &&  ( '' != $show ) ) {
			
			return '';
			
		} elseif ( is_archive() ) {
			
			if ( ! in_category( array ( $show ) ) && ( in_category( array ( $hide ) )  ) )
				return '';				
			
		} elseif ( is_singular( ) ) {
		
			if ( '' != $hide &&  has_category( array ( $hide ), $post ) ) {
				
				return '';
				
			} elseif ( '' != $show &&  ! has_category( array ( $show ), $post ) ) {
				
				return '';
				
			} 

			
		} else {
			
			
		}
		
		/*
		if ( $show != '' ) {
			
			if (  ( is_category() && ! in_category( array ( $show ) ) ) ||  ( is_category() && in_category( array ( $hide ) ) )  ) {
				
				//if true = hide it, return empty;
				print 'not';
				
				return '';
				
			} elseif ( is_singular( 'post' ) ) {
				
				the_category();
				
				if ( ! in_category( array ( $show ), $post->ID ) && ( in_category( array ( $hide ), $post->ID )  ) )		
					return '';
				
			}
			
		} elseif ( $hide !='' ) {
			
			if ( is_category() && in_category( array ( $hide ) ) ) {
				
				return '';
				
			} elseif ( is_singular( 'post' ) ) {
				
				if ( in_category( array ( $hide ), $post->ID )  )	
					return '';
				
			}
			
			
		}
		
		
		*/
			
		return $vida_str . '<div class="vida-category-filter" >'. do_shortcode($content).'</div>';
			
	}
	add_shortcode( 'vida_category', 'sc_vida_category' );

	//* Add [vida_lazy_image] Shortcode; usage: [vida_lazy_image link="" width="" height="" class=""]
	function sc_vida_lazy_image( $atts ) {
		
		// Attributes
		extract( shortcode_atts(
			array(
				'link' => '',
				'alt' => '',
				'width' => '',
				'height' => '',
				'class' => '',
			), $atts )
		);
		
		$vida_img_default = VIDA_IMAGE_PLACEHOLDER;
		$vida_class = "lazy ";
		$vida_class_fb = "lazy-fallback ";
		$vida_img = "";
		
		if ( $link )
			$link = esc_url( $link );
		else
			return 'Please add image link!';
			
		if ( $class )
			$vida_class .= $class;
		
		$vida_img = sprintf ( '<img src="%s" class="%s" data-src="%s" alt="%s" width="%s" height="%s" />', $vida_img_default, $vida_class, $link, $alt, $width, $height );
		$vida_img_fb =	sprintf ( '<img class="%s" src="%s" alt="%s" width="%s" height="%s" />', $vida_class_fb, $link, $alt, $width, $height );

		// Code
		return '<div class="vida-lazy-wrap">' . $vida_img . '<noscript>' . $vida_img_fb . '</noscript></div>';
	}
	add_shortcode( 'vida_lazy_image', 'sc_vida_lazy_image' );
	
	
	//* Add [vida_number_bg_list] Shortcode
	function sc_vida_number_bg_list( $atts, $content = null ) {
		
		// Attributes
		extract( shortcode_atts(
			array(
				'width' => '',
			), $atts )
		);
		
		$vida_styles = "";
		
		if ( $width )
			$vida_styles .= sprintf( 'style="max-width:%spx;"', $width );
		
		if ($content) :
			$content = str_replace( '<li>', '<li class="vida-flex-display"><span class="number-bg-content vida-flex-display1">', $content );
			$content = str_replace( '</li>', '</span></li>', $content );
		endif;
		
		// Code
		return '<div class="vida-number-bg" '.$vida_styles.'>'. do_shortcode($content).'</div>';
	}
	add_shortcode( 'vida_number_bg_list', 'sc_vida_number_bg_list' );	
	
	
	//* Add [vida_button] Shortcode
	function sc_vida_button( $atts, $content = null ) {
		
		// Attributes
		extract( shortcode_atts(
			array(
				'link' => '',
				'class' => '',
			), $atts )
		);
		
		$vida_class = "";
		
		if ( $class )
			$vida_class .= $class;
		
		if ( $link )
			$link = esc_url( $link );
		
		// Code
		return '<a class="button vida-button '.$vida_class.'" href="'.$link.'">'. __( $content ) .'</a>';
	}
	add_shortcode( 'vida_button', 'sc_vida_button' );

	
	//* Add [vida_textarea] Shortcode
	function sc_vida_textarea( $atts, $content = null ) {
		
		// Attributes
		extract( shortcode_atts(
			array(
				'width' => '',
				'border' => '',
				'class' => '',
				'style' => '',
			), $atts )
		);
		
		$vida_styles = "";
		$vida_class = "";
		
		if ( $width )
			$vida_styles .= sprintf( 'max-width:%spx;', $width );
		
		if ( $border )
			$vida_class = "with_border";
		
		if ( $class )
			$vida_class .= $class;
		
		if ( $style )
			$vida_styles .= $style;
		
		
		// Code
		return '<div class="textarea vida_textarea '.$vida_class.'" style="'.$vida_styles.'">'. do_shortcode( $content ).'</div>';
	}
	add_shortcode( 'vida_textarea', 'sc_vida_textarea' );
	
	
	//* Add [vida_video_wrapper] Shortcode
	function sc_vida_video_wrapper( $atts, $content = null ) {
		
		// Attributes
		extract( shortcode_atts(
			array(
				'width' => '',
			), $atts )
		);
		
		$vida_styles = "";
		
		if ( $width )
			$vida_styles .= sprintf( 'style="max-width:%spx;"', $width );
		
		
		// Code
		return '<div class="vida_video_wrapper" '.$vida_styles.'>'.$content.'</div>';
	}
	add_shortcode( 'vida_video_wrapper', 'sc_vida_video_wrapper' );	

	
	//* Add [vida_spacer] Shortcode
	function sc_vida_spacer( $atts, $content = null ) {
		
		// Attributes
		extract( shortcode_atts(
			array(
				'top' => '',
				'bottom' => '',
				'class' => '',
			), $atts )
		);
		
		$vida_styles = "";
		$vida_class = "vida-spacer ";
		
		if ( $top )
			$vida_styles .= sprintf( 'style="margin-top:%spx;"', $top );
		
		if ( $bottom )
			$vida_styles .= sprintf( 'style="margin-bottom:%spx;"', $bottom );
		
		if ( $class )
			$vida_class .= $class;
		
		
		// Code
		return '<div class="'. $vida_class .'" '.$vida_styles.'></div>';
	}
	add_shortcode( 'vida_spacer', 'sc_vida_spacer' );	


	//* Add [vida_backtotop] Shortcode
	function sc_vida_backtotop( $atts ) {
		
		// Attributes
		extract( shortcode_atts(
			array(
				'align' => 'left',
				'text' => '',
			), $atts )
		);
		
		$vida_styles = "";
		$totop = "";
		$icontotop = '<i class="fa fa-angle-double-up "></i>';
		
		if ( $align=='right' )
			$vida_styles = sprintf( 'style="text-align:%s;"', $align );
		
		/* position icon and text */
		if ( $text ) :
			if ( $align ) /* alignment considered to right */
				$totop = sprintf( '<a href="#top">%s %s</a>', $text, $icontotop ); 
			else
				$totop = sprintf( '<a href="#top">%2$s %1$s</a>', $text, $icontotop );
		else :
			$totop = sprintf( '<a href="#top">%s</a>', $icontotop );	
		endif;
		
		// Code
		return '<p class="vida_backtotop" '.$vida_styles.'>'.$totop.'</p>';
	}
	add_shortcode( 'vida_backtotop', 'sc_vida_backtotop' );	
	

	//* Add [vida_date] Shortcode
	function sc_vida_date( $atts ) {
		
		// Attributes
		extract( shortcode_atts(
			array(
				'current' => 'day',
			), $atts )
		);
		
		$toggle = strtolower($current);
		
		if ( $toggle=='year' ) :
		
			return date('Y');
		
		elseif ( $toggle=='month' ) :
		
			return date('F');
		
		else :
		
			return date('l');//Current day
		
		endif;
		
	}
	add_shortcode( 'vida_date', 'sc_vida_date' );	
	
	
	

	/**
	 * ViDA OntraPort shortcodes
	 * -gets query vars from OP then creates shortcode
	 */
	 
	//* Email
	//*Add [vida_OP_email] Shortcode
	function sc_vida_OP_email( $atts ) {
		
		// Attributes
		extract( shortcode_atts(
			array(), $atts )
		);
		
		$op_eml = get_query_var( 'email' ) ? get_query_var( 'email' ) : '(your-email)' ;
		
		return  esc_html($op_eml);
		
	}
	add_shortcode( 'vida_OP_email', 'sc_vida_OP_email' );		
	
	
	// Fname
	//* Add [vida_OP_Fname] Shortcode
	function sc_vida_OP_Fname( $atts ) {
		
		// Attributes
		extract( shortcode_atts(
			array(), $atts )
		);
		
		$fname =  get_query_var( 'firstname' ) ? get_query_var( 'firstname' ) : 'Friend' ;
		
		return  $fname;
		
	}
	add_shortcode( 'vida_OP_Fname', 'sc_vida_OP_Fname' );	
	
	//* IP
	/* end of OP shortcodes */
	
	// POF sid
	//* Add [pof_subid] Shortcode
	function sc_pof_subid( $atts ) {
		
		// Attributes
		extract( shortcode_atts(
			array(), $atts )
		);
		
		$subid =  get_query_var( 'sid' ) ? get_query_var( 'sid' ) : 'N/A' ;
		
		return  $subid;
		
	}
	add_shortcode( 'pof_subid', 'sc_pof_subid' );	


	
	// POF age
	//* Add [pof_age] Shortcode
	function sc_pof_age( $atts ) {

		// Attributes
		extract( shortcode_atts(
			array(), $atts )
		);
		
		$pofage = (isset($_GET['a']) && $_GET['a'] != 0) ? ($_GET['a'] / 235) : 'N/A';

		return  $pofage;
		
	}
	add_shortcode( 'pof_age', 'sc_pof_age' );	
	
	
	// POF gender
	//* Add [pof_gender] Shortcode
	function sc_pof_gender() {

		$pofgender = (isset($_GET['g'])) ? (($_GET['g'] == 'bhwdd') ? 'Female' : 'Male') : 'N/A';

		return  $pofgender;
		
	}
	add_shortcode( 'pof_gender', 'sc_pof_gender' );

	
	// POF state
	//* Add [pof_state] Shortcode
	function sc_pof_state( $atts ) {
		
		// Attributes
		extract( shortcode_atts(
			array(), $atts )
		);
		
		$pofstate = (isset($_GET['state'])) ? (ucwords(str_replace('xfvcdhs',' ',(substr($_GET['state'],8))))) : 'N/A';

		return  $pofstate;
		
	}
	add_shortcode( 'pof_state', 'sc_pof_state' );

	
	// POF campaign
	//* Add [pof_campaign] Shortcode
	function sc_pof_campaign() {

		$pofcampaign  = isset($_GET['cid']) ? $_GET['cid'] : 'N/A';

		return  $pofcampaign;
		
	}
	add_shortcode( 'pof_campaign', 'sc_pof_campaign' );


	
	// POF creative/ad
	//* Add [pof_adid] Shortcode
	function sc_pof_adid() {

		$pofadid  = isset($_GET['adid']) ? $_GET['adid'] : 'N/A';

		return  $pofadid;
		
	}
	add_shortcode( 'pof_adid', 'sc_pof_adid' );

	
//http://apps.virtualdatingassistants.com/pof/tracking/track-postback.php?amount=&subid=
	
	
}
add_action( 'init', 'vida_shortcodes' );

/* end vida shortcodes */

?>