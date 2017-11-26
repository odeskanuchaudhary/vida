<?php

class ViDA_Wide_Optin extends WP_Widget {

// constructor
    function vida_wide_optin() {
		$widget_ops = array('classname' => 'vida_wide_optin_widget', 'description' => __( 'Display a custom wide optin bar.', 'vida') );
        parent::__construct(false, $name = __('ViDA: Wide Optin', 'vida'), $widget_ops);
		$this->alt_option_name = 'vida_wide_optin_widget';
		
		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );		
    }
	
	// widget form creation
	function form($instance) {

	// Check values
		$title     			= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$form_text 		= isset( $instance['form_text'] ) ? esc_textarea( $instance['form_text'] ) : '';
	?>

	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Headline Text', 'vida'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	<p>
	<label for="<?php echo $this->get_field_id('form_text'); ?>"><?php _e('Enter your excerpt.', 'vida'); ?></label>
	<textarea class="widefat" id="<?php echo $this->get_field_id('form_text'); ?>" name="<?php echo $this->get_field_name('form_text'); ?>"><?php echo $form_text; ?></textarea>
	</p>
	<?php
	}

	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 			 = strip_tags($new_instance['title']);
		$instance['form_text'] 	 = strip_tags($new_instance['form_text']);		
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['vida_wide_optin']) )
			delete_option('vida_wide_optin');		  
		  
		return $instance;
	}
	
	function flush_widget_cache() {
		wp_cache_delete('vida_wide_optin', 'widget');
	}
	
	// display widget
	function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'vida_wide_optin', 'widget' );
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

		$title 			 = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title 			 = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$form_text 	 = isset( $instance['form_text'] ) ? esc_textarea($instance['form_text']) : '';	

?>
		<?php echo $before_widget ?>
				<?php if ( $title ) echo '<h2 class="widget-title">' . $title . '</h2>'; ?>				
				<?php if ($form_text !='') : ?>				  <div class="textwidget">
					<p class="excerpt-text wow zoomIn">
						<?php echo $form_text; ?>
					</p>									  </div>
				<?php endif; ?>
		<?php echo $after_widget ?>	
	<?php

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'vida_wide_optin', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}
	
}