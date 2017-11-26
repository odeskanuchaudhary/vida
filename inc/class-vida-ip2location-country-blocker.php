<?php
/**
 * ViDA IP2Location Country Blocker
 * @vida
 *
 * Filename: class-vida-ip2location-country-blocker.php
 *
 * Description: Adds hooks/filters to work with the ip2location plugin.
 * @Params: /blog?noredirect=true
 *
 * Class: ViDA_IP2Location_Country_Blocker
 */

 
defined( 'ABSPATH' ) or die( "This page intentionally left blank." );

if ( ! class_exists( 'ViDA_IP2Location_Country_Blocker' ) ) {
	
	
	class ViDA_IP2Location_Country_Blocker {		
		
		
		public function __construct( ) {
			
			//filter query vars
			add_filter( 'query_vars', array( $this, 'vida_ip2loc_blocker_query_vars') );
			
			//filter permalink to add query vars
			add_action( 'template_redirect', array( $this, 'vida_ip2loc_blocker_posts_permalink') );
			
		}
		
		function vida_ip2loc_blocker_query_vars($query_vars) {
			
			$query_vars[] = "noredirect";
			
			return $query_vars;
			
		}

		
		// Customize permalink
		function vida_ip2loc_blocker_posts_permalink() {			
			
			//we only want this for posts
			if ( ! is_singular('post') )
				return;
			
			//check if 'norediect' is set, added in the permalink from the ip2location plugin (?noredirect=true)
			if( strpos(wp_get_referer(), "noredirect") ) {			
			
				if( strpos($_SERVER['REQUEST_URI'], "noredirect") ) {
					
					return;
					
				} else {				
					
					wp_redirect( esc_url_raw( add_query_arg( array( 'noredirect' => "true" ) ) ), 301 );
					
					exit;
					
				}
				
			}			

		}

		
	} //End class

} //end if

$vida_ip2loc_country_blocker = new ViDA_IP2Location_Country_Blocker();