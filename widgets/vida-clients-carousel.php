<?php

class ViDA_Clients extends WP_Widget {

	// constructor
    function vida_clients() {
		$widget_ops = array('classname' => 'vida_clients_widget', 'description' => __( 'Show your visitors your impressive client list.', 'vida') );
        parent::__construct(false, $name = __('ViDA: Clients Carousel', 'vida'), $widget_ops);
		$this->alt_option_name = 'vida_clients_widget';
    }
	
	// widget form creation
	function form($instance) {

	// Check values
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$image_uri = isset( $instance['image_uri'] ) ? esc_url_raw( $instance['image_uri'] ) : '';		
	?>

	<p><?php _e('In order to display this widget, you must first add some clients from the dashboard. Add as many as you want and the theme will automatically display their logos in a carousel.', 'vida'); ?></p>
	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'vida'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

    <?php
        if ( $image_uri != '' ) :
           echo '<p><img class="custom_media_image" src="' . $image_uri . '" style="max-width:100px;" /></p>';
        endif;
    ?>
    <p><label for="<?php echo $this->get_field_id('image_uri'); ?>"><?php _e('[DEPRECATED - Go to Edit Row > Theme > Background image] Upload an image for the background if you want. It will get a parallax effect.', 'vida'); ?></label></p> 
    <p><input type="button" class="button button-primary custom_media_button" id="custom_media_button" name="<?php echo $this->get_field_name('image_uri'); ?>" value="Upload Image" style="margin-top:5px;" /></p>
	<p><input class="widefat custom_media_url" id="<?php echo $this->get_field_id( 'image_uri' ); ?>" name="<?php echo $this->get_field_name( 'image_uri' ); ?>" type="text" value="<?php echo $image_uri; ?>" size="3" /></p>	
	
	<?php
	}

	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
	    $instance['image_uri'] = esc_url_raw( $new_instance['image_uri'] );			

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['vida_clients']) )
			delete_option('vida_clients');		  
		  
		return $instance;
	}
	
	// display widget
	function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'vida_clients', 'widget' );
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

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Our clients', 'vida' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$image_uri = isset( $instance['image_uri'] ) ? esc_url($instance['image_uri']) : '';		

		/**
		 * Filter the arguments for the Recent Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */
		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'post_type' 		  => 'clients',
			'posts_per_page'	  => -1	
		) ) );

		if ($r->have_posts()) :
?>
		<section id="clients" class="clients-area">
			<div class="container">
				<?php if ( $title ) echo $before_title . '<span class="wow bounce">' . $title . '</span>' . $after_title; ?>
				<div class="carousel clearfix slider">
					<?php while ( $r->have_posts() ) : $r->the_post(); ?>
						<div class="clearfix">	
							<?php $link = get_post_meta( get_the_ID(), 'wpcf-client-link', true ); ?>
							<?php if ($link) : ?>	
								<a href="<?php echo esc_url($link); ?>" target="_blank"><?php the_post_thumbnail(); ?></a>
							<?php else : ?>
								<?php the_post_thumbnail('moesia-clients-thumb'); ?>
							<?php endif; ?>
						</div>
					<?php endwhile; ?>
				</div>				
			</div>
		<?php if ($image_uri != '') : ?>
			<style type="text/css">
				.clients-area {
				    display: block;			    
					background: url(<?php echo $image_uri; ?>) no-repeat;
					background-position: center top;
					background-attachment: fixed;
					background-size: cover;
					z-index: -1;
				}
			</style>
		<?php endif; ?>				
		</section>		
	<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'vida_clients', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
		
		wp_enqueue_script( 'vida-carousel', get_stylesheet_directory_uri() .  '/js/slick.min.js', array( 'jquery' ), true );	
		wp_enqueue_script( 'vida-carousel-init', get_stylesheet_directory_uri() .  '/js/carousel-init.js', array('vida-carousel'), true );
	
	}
	
}