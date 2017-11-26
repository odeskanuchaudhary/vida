<?php

class ViDA_Image_Hover_Info extends WP_Widget {

// constructor
    function vida_image_hover_info() {
		$widget_ops = array('classname' => 'vida_image_hover_info_widget', 'description' => __( 'Display an image and add hover effect to the description.', 'vida') );
        parent::__construct(false, $name = __('ViDA: Image Hover Info', 'vida'), $widget_ops);
		$this->alt_option_name = 'vida_image_hover_info_widget';
	
    }
	
	// widget form creation
	function form($instance) {

	// Check values
		$title     			= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$more_link_text 	= isset( $instance['more_link_text'] ) ? esc_attr( $instance['more_link_text'] ) : '';
		$more_link_url 	= isset( $instance['more_link_url'] ) ? esc_attr( $instance['more_link_url'] ) : '';
		$image_uri 			= isset( $instance['image_uri'] ) ? esc_url( $instance['image_uri'] ) : '';	
		
		$use_lazyimage 		= isset( $instance['use_lazyimage'] ) ? (bool) $instance['use_lazyimage'] : false;
		
	?>
	
	<p><label for="<?php echo $this->get_field_id('image_uri'); ?>"><strong><?php _e('Image:', 'vida'); ?></strong></label></p>
	
	<div style="clear:both;display:block;">
	
		<div style="display:inline-block;width:19%;">
			<?php
			if ( $image_uri != '' ) :
			   echo '<img class="custom_media_image img-responsive alignleft" src="' . $image_uri . '" style="max-width:100px; margin-right: 20px;" />';
			   ?>
			   <input type="button" class="button button-primary custom_media_button" id="custom_media_button" name="<?php echo $this->get_field_name('image_uri'); ?>" value="New Image" style="margin-top:5px;" />
			<?php
			else :
			?>
				<input type="button" class="button button-primary custom_media_button" id="custom_media_button" name="<?php echo $this->get_field_name('image_uri'); ?>" value="Upload Image" style="margin-top:5px;" />
			<?php
			endif;
			?>
		</div>
		<div style="display:inline-block;width:80%;">
			<input class="widefat custom_media_url" id="<?php echo $this->get_field_id( 'image_uri' ); ?>" name="<?php echo $this->get_field_name( 'image_uri' ); ?>" type="text" value="<?php echo $image_uri; ?>" size="12" /><br />
			
			<input class="checkbox" type="checkbox" <?php checked( $use_lazyimage ); ?> id="<?php echo $this->get_field_id( 'use_lazyimage' ); ?>" name="<?php echo $this->get_field_name( 'use_lazyimage' ); ?>" /> &nbsp;<label for="<?php echo $this->get_field_id( 'use_lazyimage' ); ?>"><?php _e( 'Lazy load image?', 'vida' ); ?></label><br />
			
		</div>
		
		<div class="clearfix"></div>

	</div>
	
	<hr />

	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><strong><?php _e('Image/Cover Title:', 'vida'); ?></strong></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id('more_link_url'); ?>"><strong><?php _e('Link URL:', 'vida'); ?></strong></label>
	<input class="widefat" id="<?php echo $this->get_field_id('more_link_url'); ?>" name="<?php echo $this->get_field_name('more_link_url'); ?>" type="text" value="<?php echo $more_link_url; ?>" />
	</p>
	
	<p>
	<label for="<?php echo $this->get_field_id('more_link_text'); ?>"><strong><?php _e('Read More Link Text:', 'vida'); ?></strong></label>
	<input class="widefat" id="<?php echo $this->get_field_id('more_link_text'); ?>" name="<?php echo $this->get_field_name('more_link_text'); ?>" type="text" value="<?php echo $more_link_text; ?>" />
	</p>
	
	<hr />
	
	<?php
	}

	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 			 = strip_tags($new_instance['title']);
	
		$instance['more_link_text'] = strip_tags($new_instance['more_link_text']);
	    $instance['more_link_url'] 		 = esc_url_raw( $new_instance['more_link_url'] );
	    $instance['image_uri'] 		 = esc_url_raw( $new_instance['image_uri'] );

		
		$instance['use_lazyimage'] 		= isset( $new_instance['use_lazyimage'] ) ? (bool) $new_instance['use_lazyimage'] : false;		

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['vida_image_hover_info']) )
			delete_option('vida_image_hover_info');		  
		  
		return $instance;
	}

	// display widget
	function widget($args, $instance) {
		
		$uwid =  $this->id_base . '-' . sanitize_title($instance['title']);
		
		$cache = array();
		
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'vida_image_hover_info', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ||  $uwid != $args['widget_id'] ) {
			//$args['widget_id'] = $this->id;
			$args['widget_id'] = $uwid;
		}
		
		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}


		ob_start();
		extract($args);

		$title 			 = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title 			 = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		
		$more_link_text = isset( $instance['more_link_text'] ) ? esc_html($instance['more_link_text']) : '';
		$more_link_url 		 = isset( $instance['more_link_url'] ) ? esc_url($instance['more_link_url']) : '';	
		$image_uri 		 = isset( $instance['image_uri'] ) ? esc_url($instance['image_uri']) : '';	
		
		$use_lightbox 		= isset( $instance['use_lightbox'] ) ? (bool) $instance['use_lightbox'] : false;
		$use_lazyimage 		= isset( $instance['use_lazyimage'] ) ? (bool) $instance['use_lazyimage'] : false;

?>
		<div class="box">

			  
				<?php if ( $use_lightbox ) : 
				
					$lb_styles = '';
					
					?>

					<span class="su-lightbox" data-mfp-src="#<?php echo $uwid; ?>" data-mfp-type="inline">
				
				<?php endif; ?>
			  
				  <?php if ($image_uri != '') : ?>
				  
					<img src="<?php echo $image_uri; ?>" class="<?php if( $use_lazyimage ) echo 'lazy'; ?> aligncenter img-responsive" />
				  
				  <?php endif; ?>
				  
				  <div class="caption full-caption">
				  
					<a href="<?php echo $more_link_url; ?>" target="_blank">
					
						<?php if ( $title ) echo '<h4 style="color:inherit;"><strong>' . $title . '</strong></h4>'; ?>
					
						<?php if ( $more_link_text ) echo '<span class="img-hover-more-link">' . $more_link_text . '</span>'; ?>
					
				    </a>
					
				  </div>

				<?php if ( $use_lightbox ) : ?>
				
					</span>
				
				<?php endif; ?>
				
				

			
		</div>
	<?php

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'vida_image_hover_info', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
		
		wp_enqueue_style( 'vida-widgets-styles', get_stylesheet_directory_uri() . '/includes/css/vida-widgets.css' );
		//wp_enqueue_style( 'magnific-popup' );
		//wp_enqueue_script( 'magnific-popup' );
		//wp_enqueue_script( 'su-other-shortcodes' );
		
	} //widget
	
}