<?php

class ViDA_Testimonials extends WP_Widget {



// constructor

    function vida_testimonials() {

		$widget_ops = array('classname' => 'vida_testimonials_widget', 'description' => __( 'Display testimonials from your clients.', 'vida') );

        parent::__construct(false, $name = __('ViDA - Testimonials', 'vida'), $widget_ops);

		$this->alt_option_name = 'vida_testimonials_widget';

		

		add_action( 'save_post', array($this, 'flush_widget_cache') );

		add_action( 'deleted_post', array($this, 'flush_widget_cache') );

		add_action( 'switch_theme', array($this, 'flush_widget_cache') );		

    }

	

	// widget form creation

	function form($instance) {



	// Check values

		$title     		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';

		$number    		= isset( $instance['number'] ) ? intval( $instance['number'] ) : -1;

		$category   	= isset( $instance['category'] ) ? esc_attr( $instance['category'] ) : '';
		
		$content_l   	= isset( $instance['content_l'] ) ? esc_attr( $instance['content_l'] ) : '';

		$see_all   		= isset( $instance['see_all'] ) ? esc_url_raw( $instance['see_all'] ) : '';

		$see_all_text  	= isset( $instance['see_all_text'] ) ? esc_html( $instance['see_all_text'] ) : '';

		$random 		= isset( $instance['random'] ) ? (bool) $instance['random'] : false;	

		$onecol 		= isset( $instance['onecol'] ) ? (bool) $instance['onecol'] : false;
		
		$t_format 		= isset( $instance['t_format'] ) ? $instance['t_format'] : 'quote'; 

	?>

	

	<p><?php _e('<em>In order to display this widget, you must first add some testimonials from the dashboard. Add as many as you want and the theme will automatically display them all.</em>', 'vida'); ?></p>



	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><strong><?php _e('Display Widget Title:', 'vida'); ?></strong></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<h3><?php _e( 'Filter Options:', 'vida' ); ?></h3>
	
	<p><label><strong><?php _e( 'Type of testimonial to show:', 'vida' ); ?></strong></label> &nbsp;
	
	<input type="radio" name="<?php echo $this->get_field_name( 't_format' ); ?>" id="<?php echo $this->get_field_id( 't_format' ); ?>-quote" value="quote" <?php checked( $t_format, 'quote' ); ?>><label for="<?php echo $this->get_field_id( 't_format' ); ?>-quote"><?php _e( 'Text/Quote Testimonials', 'vida_testimonials' ); ?></label> &nbsp; 
	
	<input type="radio" name="<?php echo $this->get_field_name( 't_format' ); ?>" id="<?php echo $this->get_field_id( 't_format' ); ?>-video" value="video" <?php checked( $t_format, 'video' ) ?>><label for="<?php echo $this->get_field_id( 't_format' ); ?>-video"><?php _e( 'Video Testimonials', 'vida_testimonials' ); ?></label> &nbsp; 
	
	<input type="radio" name="<?php echo $this->get_field_name( 't_format' ); ?>" id="<?php echo $this->get_field_id( 't_format' ); ?>-audio" value="audio" <?php checked( $t_format, 'audio' ) ?>><label for="<?php echo $this->get_field_id( 't_format' ); ?>-audio"><?php _e( 'Audio Testimonials', 'vida_testimonials' ); ?></label> &nbsp;
	
	</p>

	<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><strong><?php _e( 'Number of testimonials to show ', 'vida' ); ?></strong><?php _e( '(-1 shows all of them):', 'vida' ); ?></label>

	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" />
	</p>

	<p><label for="<?php echo $this->get_field_id( 'category' ); ?>"><strong><?php _e( 'Country Location:', 'vida' ); ?></strong></label>
	
	<select id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>">
		<option value=""><?php echo esc_attr( __( 'All' ) ); ?></option>
		<?php
			$locations = get_terms( 'testimonial_country', array(
				'orderby'    => 'count',
				'hide_empty' => true,
				)
			);
		
			foreach( $locations as $location ) {
				echo '<option value="' . $location->slug . '" ' . ( $category==$location->slug ? 'selected="selected"' : '' ) . ' >' . ( ( $location->name ) ? $location->name : '(NA)' ) . '</option>';
			}		
		?>
	</select>
	</p>


	<p><label for="<?php echo $this->get_field_id( 'content_l' ); ?>"><strong><?php _e( 'Content Length:', 'vida' ); ?></strong></label>	
	<select id="<?php echo $this->get_field_id( 'content_l' ); ?>" name="<?php echo $this->get_field_name( 'content_l' ); ?>">
		<option value="" <?php selected( $content_l, '' ); ?>><?php echo esc_attr( __( '-Any-' ) ); ?></option>
		<option value="short" <?php selected( $content_l, 'short' ); ?>><?php echo esc_attr( __( 'Short' ) ); ?></option>
		<option value="normal" <?php selected( $content_l, 'normal' ); ?>><?php echo esc_attr( __( 'Normal' ) ); ?></option>
		<option value="long" <?php selected( $content_l, 'long' ); ?>><?php echo esc_attr( __( 'Long' ) ); ?></option>
	</select>
	<span class="description"><?php _e( 'Used only with text/quote.', 'vida' ); ?></span>
	</p>
	
	<p><input class="checkbox" type="checkbox" <?php checked( $random ); ?> id="<?php echo $this->get_field_id( 'random' ); ?>" name="<?php echo $this->get_field_name( 'random' ); ?>" />

	<label for="<?php echo $this->get_field_id( 'random' ); ?>"><?php _e( 'Show random testimonials? <em>(Default: Menu order)</em>', 'vida' ); ?></label></p>	
	
	<p><input class="checkbox" type="checkbox" <?php checked( $onecol ); ?> id="<?php echo $this->get_field_id( 'onecol' ); ?>" name="<?php echo $this->get_field_name( 'onecol' ); ?>" />

	<label for="<?php echo $this->get_field_id( 'onecol' ); ?>"><?php _e( 'Show testimonials in a single column? (By default they are rendered in two)', 'vida' ); ?></label></p>
	
    <p><label for="<?php echo $this->get_field_id('see_all'); ?>"><?php _e('Enter the URL for your testimonials page. Useful if you want to show here just a few testimonials, then send your visitors to a page that uses the testimonials page template.', 'vida'); ?></label>

	<input class="widefat custom_media_url" id="<?php echo $this->get_field_id( 'see_all' ); ?>" name="<?php echo $this->get_field_name( 'see_all' ); ?>" type="text" value="<?php echo $see_all; ?>" size="3" /></p>	

    <p><label for="<?php echo $this->get_field_id('see_all_text'); ?>"><?php _e('The text for the button [Defaults to <em>See all our testimonials</em> if left empty]', 'vida'); ?></label>

	<input class="widefat custom_media_url" id="<?php echo $this->get_field_id( 'see_all_text' ); ?>" name="<?php echo $this->get_field_name( 'see_all_text' ); ?>" type="text" value="<?php echo $see_all_text; ?>" size="3" /></p>

	




	<?php

	}



	// update widget

	function update($new_instance, $old_instance) {

		$instance = $old_instance;

		$instance['title'] 			= strip_tags($new_instance['title']);

		$instance['number'] 		= strip_tags($new_instance['number']);	

		$instance['see_all'] 		= esc_url_raw( $new_instance['see_all'] );	

		$instance['see_all_text'] 	= strip_tags($new_instance['see_all_text']);

		$instance['category'] 		= strip_tags($new_instance['category']);
		
		$instance['content_l'] 		= isset( $new_instance['content_l'] ) ? $new_instance['content_l'] : '';	

		$instance['random'] 		= isset( $new_instance['random'] ) ? (bool) $new_instance['random'] : false;
		
		$instance['onecol'] 		= isset( $new_instance['onecol'] ) ? (bool) $new_instance['onecol'] : false;
		
		$instance['t_format'] 		= isset( $new_instance['t_format'] ) ? $new_instance['t_format'] : 'quote'; 


		$this->flush_widget_cache();



		$alloptions = wp_cache_get( 'alloptions', 'options' );

		if ( isset($alloptions['vida_testimonials']) )

			delete_option('vida_testimonials');		  

		  

		return $instance;

	}

	

	function flush_widget_cache() {

		wp_cache_delete('vida_testimonials', 'widget');

	}

	

	// display widget

	function widget($args, $instance) {

		$cache = array();
		
		$grouped_by = false;
		$c_args = '';
		$cl_args = '';
		$f_args = '';
		$tax_rel = '';
		$t_args = '';

		if ( ! $this->is_preview() ) {

			$cache = wp_cache_get( 'vida_testimonials', 'widget' );

		}



		if ( ! is_array( $cache ) ) {

			$cache = array();

		}



		if ( ! isset( $args['widget_id'] ) ) {

			$args['widget_id'] = $this->id;

		}



		if ( isset( $cache[ $args['widget_id'] ] ) ) {

			echo $cache[ $args['widget_id'] ];

			return;

		}


		ob_start();

		extract($args);



		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( '', 'vida' );



		$title 			= apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$see_all 		= isset( $instance['see_all'] ) ? esc_url($instance['see_all']) : '';

		$see_all_text 	= isset( $instance['see_all_text'] ) ? esc_html($instance['see_all_text']) : '';

		$number 		= ( ! empty( $instance['number'] ) ) ? intval( $instance['number'] ) : -1 ;

		

		$category 		= isset( $instance['category'] ) ? esc_attr($instance['category']) : '';
		
		$content_l   	= isset( $instance['content_l'] ) ? esc_attr( $instance['content_l'] ) : '';

		$random 		= isset( $instance['random'] ) ? (bool) $instance['random'] : false;

		
		if ( $random ) {

			$random = 'rand';	

		} else {

			$random = 'menu_order';

		}

		
		$incols 		= isset( $instance['onecol'] ) ? (bool) $instance['onecol'] : false;

		if ( $incols ) {

			$incols = 'col-sm-12';	

		} else {

			$incols = 'col-sm-6';

		}
		

	/* Build the WP_Query */
	
	//testimonials WP_Query args (defaults)
	$t_args = array(
	
		'no_found_rows'       => true,

		'post_status'         => 'publish',

		'post_type' 		  => 'testimonials',

		'posts_per_page'	  => $number,
		
		'order'        	  	  => 'DESC',
		
	);

		
	//Testimonial Taxonomy - Country Location:
	if ( $category ) {
	
		$c_args = array(
			'taxonomy' => 'testimonial_country',
			'field' => 'slug',
			'terms' => array (
				$category,
			),
			'operator' => 'IN'
		);
		
	}

	//Testimonial Post Format:
	$t_format = isset( $instance['t_format'] ) ? $instance['t_format'] : 'quote'; 
	
	if ( isset($t_format) ) {
		$f_args = array(
			'taxonomy' => 'testimonial_type',
			'field' => 'slug',
			'terms' => array(
				$t_format
			),
			'operator' => 'IN'
		);
	}

	
	if ( $c_args && $f_args ) {

		$tax_rel = array (
			'relation' => 'AND',
		);
		
	}
		
	// Build the tax query
	$t_args['tax_query'] = array(
		$c_args,
		$f_args,
	);
	

	// Tax_Query Relation
	if ( $c_args && $f_args ) {
		
		$t_args['tax_query']['relation'] = 'AND';
		
	}
	
	
		
	//Check for content length		
	if ( $t_format == 'quote' ) :
		
		if ( ! empty($content_l) ) {
			$grouping = array($content_l);
		} else {
			$grouping = array("short","normal","long");
		}
			
		//if number -1 = show all 
		if ( $number == -1 ) {
			
			$random = array( 'meta_value' => 'DESC', 'menu_order' => 'ASC' );
			shuffle($grouping);
			$grouped_by = $grouping;

		} else {
				
			$groupings_sel = array_rand( $grouping, 1 );
			$grouped_by = $grouping[$groupings_sel];
				
		}
			
	endif;
		
	//orderby
	$t_args['orderby'] = $random;

	if ( isset($grouped_by) && $t_format == 'quote' ) {
		
		$t_args['meta_key'] = 'content_l';
		$t_args['meta_value'] = $grouped_by;
		$t_args['meta_compare'] = 'IN';
		
		
		$cl_args = array (
			array (
			'key' => 'content_l',
			'value' => $grouped_by,
			'compare' => 'IN',
			),
		);
	
	}

	$t_args['meta_query'] = $cl_args;

	
//print_r( $t_args );

	$r = new WP_Query( $t_args );	


		if ($r->have_posts()) :

		//initialize variables
		$ttotal_posts = $r->post_count;
		$current_class = 'even'; //starts 0
?>

		<?php echo $before_widget ?>
		<div id="vida-testimonials" class="container-fluid clearfix">		
			
			<?php if ( $title ) echo $before_title . '<span class="wow bounce">' . $title . '</span>' . $after_title; ?>
			
			<div id="testimonials-list" class="clearfix">

				<?php while ( $r->have_posts() ) : $r->the_post(); 	?>

					<?php 
					$client_name = client_get_meta( 'client_name' ); 
					$client_location = client_get_meta( 'client_location' ); 					
					
					$current_class = ($current_class == 'odd') ? 'even' : 'odd';
					$current_p = $r->current_post+1;

					$testimonial_class = 'testimonial testimonial-' . $current_p . ' text-center col-xs-12 fadeInUp clearfix type-' . $t_format . ' ' . $incols . ' ' . $current_class;
					
					if ( $ttotal_posts == $current_p )
						$testimonial_class .= ' last';
					
					?>

					<div id="testimonial-<?php the_ID(); ?>" <?php post_class( $testimonial_class ); ?>>

						<div class="testimonial-body"><?php the_content(); ?></div>

						<h4 class="text-center client-name col-xs-10 col-xs-offset-1"><?php echo $client_name; ?></h4>

						<?php if ($client_location != '') : ?>

							<span class="client-function col-xs-10 col-xs-offset-1"><?php echo esc_html($client_location); ?></span>

						<?php endif;?>						

					</div>

				<?php endwhile; ?>
				
			</div>

				<?php if ($see_all != '') : ?>
				
				  <div id="more-testimonials" class="row clearfix">

					<a href="<?php echo esc_url($see_all); ?>" class="vida-button all-news">

						<?php if ($see_all_text) : ?>

							<?php echo $see_all_text; ?>

						<?php else : ?>

							<?php echo __('See all our testimonials', 'vida'); ?>

						<?php endif; ?>

					</a>
					
				  </div>

				<?php endif; ?>	
				
				</div>
			
			<?php echo $after_widget ?>
			
		
	

	<?php

		// Reset the global $the_post as this query will have stomped on it

		wp_reset_postdata();



		endif;



		if ( ! $this->is_preview() ) {

			$cache[ $args['widget_id'] ] = ob_get_flush();

			wp_cache_set( 'vida_testimonials', $cache, 'widget' );

		} else {

			ob_end_flush();

		}

	}

	

}