<p>
	<label id="<?php echo $this->get_field_id( 'title' ); ?>-label" for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', $this->domain ); ?>:</label>
	<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" aria-labelledby="<?php echo $this->get_field_id( 'title' ); ?>-label" />
</p>

<p>
	<input type="checkbox" id="<?php echo $this->get_field_id( 'include_css' ); ?>" name="<?php echo $this->get_field_name( 'include_css' ); ?>"<?php checked( $instance['include_css'] ); ?> value="1" aria-labelledby="<?php echo $this->get_field_id( 'include_css' ); ?>-label" />
	<label id="<?php echo $this->get_field_id( 'include_css' ); ?>-label" for="<?php echo $this->get_field_id( 'include_css' ); ?>"><?php _e( 'Include reference for widget CSS?', $this->domain ); ?>:</label>
	<span class="description"><?php _e( 'Leave unchecked if you include styles for your widget in your theme style sheet', $this->domain ); ?></span>
</p>