<?php

class ViDA_Team_Member extends WP_Widget {

// constructor
    function vida_team_member() {
		$widget_ops = array('classname' => 'vida_team_member_widget', 'description' => __( 'Display a member info.', 'vida') );
        parent::__construct(false, $name = __('ViDA: Team Member', 'vida'), $widget_ops);
		$this->alt_option_name = 'vida_team_member_widget';
	
    }
	
	// widget form creation
	function form($instance) {

	// Check values
		$title     			= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$short_bio 		= isset( $instance['short_bio'] ) ?  esc_textarea( $instance['short_bio'] ) : '';
		$name_alias 	= isset( $instance['name_alias'] ) ? esc_attr( $instance['name_alias'] ) : '';
		$image_uri 			= isset( $instance['image_uri'] ) ? esc_url( $instance['image_uri'] ) : '';	
		$use_lightbox 		= isset( $instance['use_lightbox'] ) ? (bool) $instance['use_lightbox'] : false;
		$use_lazyimage 		= isset( $instance['use_lazyimage'] ) ? (bool) $instance['use_lazyimage'] : false;
		
	?>

	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><strong><?php _e('Member Name:', 'vida'); ?></strong></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id('name_alias'); ?>"><strong><?php _e('Member Alias:', 'vida'); ?></strong></label>
	<input class="widefat" id="<?php echo $this->get_field_id('name_alias'); ?>" name="<?php echo $this->get_field_name('name_alias'); ?>" type="text" value="<?php echo $name_alias; ?>" />
	</p>
	
	<p>
	<label for="<?php echo $this->get_field_id('short_bio'); ?>"><strong><?php _e('Short Bio:', 'vida'); ?></strong></label>
	<textarea class="widefat" id="<?php echo $this->get_field_id('short_bio'); ?>" name="<?php echo $this->get_field_name('short_bio'); ?>" rows=6 ><?php echo $short_bio; ?></textarea>
	<br />
	<input class="checkbox" type="checkbox" <?php checked( $use_lightbox ); ?> id="<?php echo $this->get_field_id( 'use_lightbox' ); ?>" name="<?php echo $this->get_field_name( 'use_lightbox' ); ?>" /> &nbsp;<label for="<?php echo $this->get_field_id( 'use_lightbox' ); ?>"><?php _e( 'Show short bio in a lightbbox popup?', 'vida' ); ?></label></p>	
	
    <p><label for="<?php echo $this->get_field_id('image_uri'); ?>"><strong><?php _e('Member Image:', 'vida'); ?></strong></label></p>
	
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
	
	<?php
	}

	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 			 = strip_tags($new_instance['title']);
		
		if ( current_user_can('unfiltered_html') )
			$instance['short_bio'] =  $new_instance['short_bio'];
		else
			$instance['short_bio'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['short_bio']) ) );
	
		$instance['name_alias'] = strip_tags($new_instance['name_alias']);
	    $instance['image_uri'] 		 = esc_url_raw( $new_instance['image_uri'] );

		$instance['use_lightbox'] 		= isset( $new_instance['use_lightbox'] ) ? (bool) $new_instance['use_lightbox'] : false;
		$instance['use_lazyimage'] 		= isset( $new_instance['use_lazyimage'] ) ? (bool) $new_instance['use_lazyimage'] : false;		

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['vida_team_member']) )
			delete_option('vida_team_member');		  
		  
		return $instance;
	}

	// display widget
	function widget($args, $instance) {
		
		$uwid =  $this->id_base . '-' . sanitize_title($instance['title']);
		
		$cache = array();
		
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'vida_team_member', 'widget' );
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
		$short_bio = apply_filters( 'widget_textarea', empty( $instance['short_bio'] ) ? '' : $instance['short_bio'], $instance );
		
		$name_alias = isset( $instance['name_alias'] ) ? esc_html($instance['name_alias']) : '';
		$image_uri 		 = isset( $instance['image_uri'] ) ? esc_url($instance['image_uri']) : '';	
		
		$use_lightbox 		= isset( $instance['use_lightbox'] ) ? (bool) $instance['use_lightbox'] : false;
		$use_lazyimage 		= isset( $instance['use_lazyimage'] ) ? (bool) $instance['use_lazyimage'] : false;

?>
		<div class="member-widget profile">
			<div class="member-info prof_h">
			  
				<?php if ( $use_lightbox ) : 
				
					$lb_styles = '';
					
					?>

					<span class="su-lightbox" data-mfp-src="#<?php echo $uwid; ?>" data-mfp-type="inline">
				
				<?php endif; ?>
			  
				  <?php if ($image_uri != '') : ?>
				  
					<img src="<?php echo $image_uri; ?>" class="<?php if( $use_lazyimage ) echo 'lazy'; ?> aligncenter img-circle" />
				  
				  <?php endif; ?>
				  
					<?php if ( $title ) echo '<h3 class="member-name wow bounce">' . $title . '</h3>'; ?>
					
					<?php if ( $name_alias ) echo '<h4 class="member-alias wow bounce">' . $name_alias . '</h4>'; ?>

				<?php if ( $use_lightbox ) : ?>
				
					</span>
				
				<?php endif; ?>
				
				<?php if ( $short_bio !='' ) : ?>
					
					<div id="<?php echo $uwid; ?>" class="<?php if ( $use_lightbox ) echo 'su-lightbox-content'; ?> prof_c member-info " <?php if ( $use_lightbox ) : ?>style="display:none;width:50%;margin-top:40px;margin-bottom:40px;padding:40px;background-color:#FFFFFF;color:#2f2f2f;box-shadow:0px 0px 15px #333333;text-align:center;max-width:700px"<?php endif; ?>>
						<?php echo wpautop( do_shortcode( $short_bio ) ); ?>
					</div>
						
				<?php endif; ?>
				
			</div>
			
		</div>		
	<?php

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'vida_team_member', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
		
		
		su_query_asset( 'css', 'magnific-popup' );
		su_query_asset( 'js', 'jquery' );
		su_query_asset( 'js', 'magnific-popup' );
		su_query_asset( 'js', 'su-other-shortcodes' );
		
					
		wp_enqueue_style( 'magnific-popup' );
		wp_enqueue_script( 'magnific-popup' );
		wp_enqueue_script( 'su-other-shortcodes' );
		
	} //widget
	
}