<?php

if ( ! class_exists('ViDA_Textarea') ) :

class ViDA_Textarea extends WP_Widget {

	// constructor
    function vida_textarea() {
		$widget_ops = array( 'classname' => 'vida_textarea_widget sidebar-nopadding', 'description' => __( 'Textarea only for pure text', 'vida') );
        parent::__construct(false, $name = __('ViDA: Textarea', 'vida'), $widget_ops);
		$this->alt_option_name = 'vida_textarea_widget';
		
    }
	
	// widget form creation
	function form($instance) {

	// Check values
	$only_textarea = isset( $instance['only_textarea'] ) ?  esc_textarea($instance['only_textarea']) : '';
	
	
	?>

	<p>
	<label for="<?php echo $this->get_field_id('only_textarea'); ?>"><?php _e('Enter your text here. (HTML tags accepted)', 'vida'); ?></label>
	<textarea class="widefat" rows="16" id="<?php echo $this->get_field_id('only_textarea'); ?>" name="<?php echo $this->get_field_name('only_textarea'); ?>"><?php echo $only_textarea; ?></textarea>
	</p>
	
	<?php
	}

	// update widget
	function update($new_instance, $old_instance) {
		
		$instance = $old_instance;
		
		if ( current_user_can('unfiltered_html') )
			$instance['only_textarea'] =  $new_instance['only_textarea'];
		else
			$instance['only_textarea'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['only_textarea']) ) );
		
		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['vida_textarea']) )
			delete_option('vida_textarea');	
		
		return $instance;
	}

	
	// display widget
	function widget($args, $instance) {
		
		$uwid =  $this->id_base . '-' . rand(100,999);
		
		$cache = array();
		
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'vida_textarea', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ||  $uwid != $args['widget_id'] ) {
			$args['widget_id'] = $uwid;
		}
		
		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}
		
		
		ob_start();

		extract($args);	
		
		//$only_textarea = isset( $instance['only_textarea'] ) ? $instance['only_textarea'] : '';
		$only_textarea = apply_filters( 'widget_textarea', empty( $instance['only_textarea'] ) ? '' : $instance['only_textarea'], $instance );
		
		if ($only_textarea !='') :
		
			echo $before_widget;
			
		?>
		
			<div class="textwidget">
			
				<?php echo wpautop ( do_shortcode( $only_textarea ) ); ?>
			
			</div>
			
		<?php
		
			echo $after_widget;
			
		endif;
		
		
		
		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'vida_textarea', $cache, 'widget' );
		} else {
			ob_end_flush();
		}

	}
	
}

endif;
?>