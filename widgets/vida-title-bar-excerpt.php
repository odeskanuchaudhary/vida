<?php

class ViDA_Title_Bar_Excerpt extends WP_Widget {

// constructor
    function vida_title_bar_excerpt() {
		$widget_ops = array('classname' => 'vida_title_bar_widget', 'description' => __( 'Display a title, sub-title and excerpt.', 'vida') );
        parent::__construct(false, $name = __('ViDA: Title, Sub-Title + Excerpt', 'vida'), $widget_ops);
		$this->alt_option_name = 'vida_title_bar_excerpt_widget';
				/*
		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );		*/		
    }
	
	// widget form creation
	function form($instance) {

	// Check values
		$titlebar_title = isset( $instance['titlebar_title'] ) ? esc_attr( $instance['titlebar_title'] ) : '';		$titlebar_title_class = isset( $instance['titlebar_title_class'] ) ? esc_attr( $instance['titlebar_title_class'] ) : '';				$titlebar_sub_title = isset( $instance['titlebar_sub_title'] ) ? esc_attr( $instance['titlebar_sub_title'] ) : '';		$titlebar_sub_title_class = isset( $instance['titlebar_sub_title_class'] ) ? esc_attr( $instance['titlebar_sub_title_class'] ) : '';
		$titlebar_excerpt_text = isset( $instance['titlebar_excerpt_text'] ) ? esc_textarea( $instance['titlebar_excerpt_text'] ) : '';		$titlebar_excerpt_text_class = isset( $instance['titlebar_excerpt_text_class'] ) ? esc_textarea( $instance['titlebar_excerpt_text_class'] ) : '';
	?>

	<p>
	<strong><label for="<?php echo $this->get_field_id('titlebar_title'); ?>"><?php _e('Title Headline Text', 'vida'); ?></label></strong>
	<input class="large-text" id="<?php echo $this->get_field_id('titlebar_title'); ?>" name="<?php echo $this->get_field_name('titlebar_title'); ?>" type="text" value="<?php echo $titlebar_title; ?>" /><br />	<label for="<?php echo $this->get_field_id('titlebar_title_class'); ?>"><?php _e('CSS class: ', 'vida'); ?></label><input class="regular-text" id="<?php echo $this->get_field_id('titlebar_title_class'); ?>" name="<?php echo $this->get_field_name('titlebar_title_class'); ?>" type="text" value="<?php echo $titlebar_title_class; ?>" />
	</p>
	<p>	<strong><label for="<?php echo $this->get_field_id('titlebar_sub_title'); ?>"><?php _e('Sub-Title Headline Text', 'vida'); ?></label></strong>	<input class="large-text" id="<?php echo $this->get_field_id('titlebar_sub_title'); ?>" name="<?php echo $this->get_field_name('titlebar_sub_title'); ?>" type="text" value="<?php echo $titlebar_sub_title; ?>" /><br />	<label for="<?php echo $this->get_field_id('titlebar_sub_title_class'); ?>"><?php _e('CSS class: ', 'vida'); ?></label>	<input class="regular-text" id="<?php echo $this->get_field_id('titlebar_sub_title_class'); ?>" name="<?php echo $this->get_field_name('titlebar_sub_title_class'); ?>" type="text" value="<?php echo $titlebar_sub_title_class; ?>" />	</p>
	<p>
	<strong><label for="<?php echo $this->get_field_id('titlebar_excerpt_text'); ?>"><?php _e('Enter your excerpt.', 'vida'); ?></label></strong>
	<textarea class="large-text" id="<?php echo $this->get_field_id('titlebar_excerpt_text'); ?>" name="<?php echo $this->get_field_name('titlebar_excerpt_text'); ?>"><?php echo $titlebar_excerpt_text; ?></textarea><br />	<label for="<?php echo $this->get_field_id('titlebar_excerpt_text_class'); ?>"><?php _e('CSS class: ', 'vida'); ?></label>	<input class="regular-text" id="<?php echo $this->get_field_id('titlebar_excerpt_text_class'); ?>" name="<?php echo $this->get_field_name('titlebar_excerpt_text_class'); ?>" type="text" value="<?php echo $titlebar_excerpt_text_class; ?>" />
	</p>
	<?php
	}

	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['titlebar_title'] = strip_tags($new_instance['titlebar_title']);				$instance['titlebar_sub_title'] = strip_tags($new_instance['titlebar_sub_title']);
		$instance['titlebar_excerpt_text'] = strip_tags($new_instance['titlebar_excerpt_text']);		$instance['titlebar_title_class'] = strip_tags($new_instance['titlebar_title_class']);				$instance['titlebar_sub_title_class'] = strip_tags($new_instance['titlebar_sub_title_class']);				$instance['titlebar_excerpt_text_class'] = strip_tags($new_instance['titlebar_excerpt_text_class']);				/*
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['vida_title_bar_excerpt']) )
			delete_option('vida_title_bar_excerpt');		  		*/
		  
		return $instance;
	}
		/*	
	function flush_widget_cache() {
		wp_cache_delete('vida_title_bar_excerpt', 'widget');
	}		*/
	
	// display widget
	function widget($args, $instance) {		/*	
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'vida_title_bar_excerpt', 'widget' );
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

		ob_start();				*/
		extract($args);

		$titlebar_title = ( ! empty( $instance['titlebar_title'] ) ) ? $instance['titlebar_title'] : '';				$titlebar_sub_title = ( ! empty( $instance['titlebar_sub_title'] ) ) ? $instance['titlebar_sub_title'] : '';
		$titlebar_excerpt_text = isset( $instance['titlebar_excerpt_text'] ) ? esc_textarea($instance['titlebar_excerpt_text']) : '';	
		$titlebar_title_class = ( ! empty( $instance['titlebar_title_class'] ) ) ? $instance['titlebar_title_class'] : '';				$titlebar_sub_title_class = ( ! empty( $instance['titlebar_sub_title_class'] ) ) ? $instance['titlebar_sub_title_class'] : '';				$titlebar_excerpt_text_class = ( ! empty( $instance['titlebar_excerpt_text_class'] ) ) ? $instance['titlebar_excerpt_text_class'] : '';
?>
		<?php echo $before_widget ?>
				<?php if ( $titlebar_title ) echo '<h2 class="widget-title '.$titlebar_title_class.'">' . $titlebar_title . '</h2>'; ?>								<?php if ( $titlebar_sub_title ) echo '<h3 class="sub-title '.$titlebar_sub_title_class.'">' . $titlebar_sub_title . '</h3>'; ?>
				<?php if ($titlebar_excerpt_text !='') : ?>				  <div class="textwidget">
					<p class="excerpt-text wow zoomIn <?php echo $titlebar_excerpt_text_class; ?>">
						<?php echo $titlebar_excerpt_text; ?>
					</p>									  </div>
				<?php endif; ?>
		<?php echo $after_widget ?>		
	<?php
	/*
		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'vida_title_bar_excerpt', $cache, 'widget' );
		} else {
			ob_end_flush();
		}				*/
	}
	
}