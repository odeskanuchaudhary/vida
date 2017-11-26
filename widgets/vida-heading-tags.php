<?php
class ViDA_Heading_Tags extends WP_Widget {

// constructor
    function vida_heading_tags() {
		$widget_ops = array('classname' => 'vida_heading_tags_widget', 'description' => __( 'Page Headings H1, H2, H3', 'vida') );
        parent::__construct(false, $name = __('ViDA: Page Heading Tags', 'vida'), $widget_ops);
		$this->alt_option_name = 'vida_heading_tags_widget';
				/*		
		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );				*/
    }
	
	// widget form creation
	function form($instance) {

	// Check values
		$header1tag     			= isset( $instance['header1tag'] ) ? esc_attr( $instance['header1tag'] ) : '';				$header2tag     			= isset( $instance['header2tag'] ) ? esc_attr( $instance['header2tag'] ) : '';				$header3tag     			= isset( $instance['header3tag'] ) ? esc_attr( $instance['header3tag'] ) : '';		$header1tag_class     			= isset( $instance['header1tag_class'] ) ? esc_attr( $instance['header1tag_class'] ) : '';				$header2tag_class     			= isset( $instance['header2tag_class'] ) ? esc_attr( $instance['header2tag_class'] ) : '';				$header3tag_class     			= isset( $instance['header3tag_class'] ) ? esc_attr( $instance['header3tag_class'] ) : '';		
	?>

	<p>
	<strong><label for="<?php echo $this->get_field_id('header1tag'); ?>"><?php _e('Heading 1 - H1', 'vida'); ?></label></strong>
	<input class="large-text" id="<?php echo $this->get_field_id('header1tag'); ?>" name="<?php echo $this->get_field_name('header1tag'); ?>" type="text" value="<?php echo $header1tag; ?>" /><br />	<label for="<?php echo $this->get_field_id('header1tag_class'); ?>"><?php _e('CSS class: ', 'vida'); ?></label>	<input class="regular-text" id="<?php echo $this->get_field_id('header1tag_class'); ?>" name="<?php echo $this->get_field_name('header1tag_class'); ?>" type="text" value="<?php echo $header1tag_class; ?>" />
	</p>
	<p>	<strong><label for="<?php echo $this->get_field_id('header2tag'); ?>"><?php _e('Heading 2 - H2', 'vida'); ?></label></strong>	<input class="widefat" id="<?php echo $this->get_field_id('header2tag'); ?>" name="<?php echo $this->get_field_name('header2tag'); ?>" type="text" value="<?php echo $header2tag; ?>" /><br />	<label for="<?php echo $this->get_field_id('header2tag_class'); ?>"><?php _e('CSS class: ', 'vida'); ?></label>	<input class="regular-text" id="<?php echo $this->get_field_id('header2tag_class'); ?>" name="<?php echo $this->get_field_name('header2tag_class'); ?>" type="text" value="<?php echo $header2tag_class; ?>" />	</p>		<p>	<strong><label for="<?php echo $this->get_field_id('header3tag'); ?>"><?php _e('Heading 3 - H3', 'vida'); ?></label></strong>	<input class="widefat" id="<?php echo $this->get_field_id('header3tag'); ?>" name="<?php echo $this->get_field_name('header3tag'); ?>" type="text" value="<?php echo $header3tag; ?>" /><br />	<label for="<?php echo $this->get_field_id('header3tag_class'); ?>"><?php _e('CSS class: ', 'vida'); ?></label>	<input class="regular-text" id="<?php echo $this->get_field_id('header3tag_class'); ?>" name="<?php echo $this->get_field_name('header3tag_class'); ?>" type="text" value="<?php echo $header3tag_class; ?>" />	</p>		
	<?php
	}

	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['header1tag'] = strip_tags($new_instance['header1tag']);				$instance['header2tag'] = strip_tags($new_instance['header2tag']);				$instance['header3tag'] = strip_tags($new_instance['header3tag']);				$instance['header1tag_class'] = strip_tags($new_instance['header1tag_class']);				$instance['header2tag_class'] = strip_tags($new_instance['header2tag_class']);				$instance['header3tag_class'] = strip_tags($new_instance['header3tag_class']);		
		/*				$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['vida_heading_tags']) )
			delete_option('vida_heading_tags');		  
		*/
		return $instance;
	}
		/*
	function flush_widget_cache() {
		wp_cache_delete('vida_heading_tags', 'widget');
	}
	*/
	// display widget
	function widget($args, $instance) {
		/*				$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'vida_heading_tags', 'widget' );
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

		$header1tag = ( ! empty( $instance['header1tag'] ) ) ? $instance['header1tag'] : '';				$header2tag = ( ! empty( $instance['header2tag'] ) ) ? $instance['header2tag'] : '';				$header3tag = ( ! empty( $instance['header3tag'] ) ) ? $instance['header3tag'] : '';
		$header1tag_class = ( ! empty( $instance['header1tag_class'] ) ) ? $instance['header1tag_class'] : '';				$header2tag_class = ( ! empty( $instance['header2tag_class'] ) ) ? $instance['header2tag_class'] : '';				$header3tag_class = ( ! empty( $instance['header3tag_class'] ) ) ? $instance['header3tag_class'] : '';		
?>
		<?php echo $before_widget ?>
				<?php if ( $header1tag ) echo '<h1 class="widget-title headline1 '. $header1tag_class .'">' . $header1tag . '</h1>'; ?>								<?php if ( $header2tag ) echo '<h2 class="headline2 '. $header2tag_class .'">' . $header2tag . '</h2>'; ?>								<?php if ( $header3tag ) echo '<h3 class="headline3 '. $header3tag_class .'">' . $header3tag . '</h3>'; ?>
		<?php echo $after_widget ?>		
	<?php
	/*
		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'vida_heading_tags', $cache, 'widget' );
		} else {
			ob_end_flush();
		}	*/	
	}
	
}