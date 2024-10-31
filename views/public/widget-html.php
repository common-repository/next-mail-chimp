<div class="next-mail-widget">
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title :' , 'next-mailchimp' ) ?> </label>
		<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" type="text" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'from_id' ); ?>"><?php _e( 'Form Name :' , 'next-mailchimp' ) ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'from_id' ); ?>" name="<?php echo $this->get_field_name( 'from_id' ); ?>">
			<?php
            if( is_array($listed) && sizeof($listed) > 0){
			 foreach( $listed as $k=>$v):
			?>
				<option value="<?php echo $k;?>" <?php echo ($k == $select_from) ? 'selected' : ''; ?>> <?php _e($v, 'next-mailchimp'); ?> </option>
			 <?php 
             endforeach;
            }?>
		</select>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php _e( 'Button Text :' , 'next-mailchimp' ) ?> </label>
		<input id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" value="<?php echo $instance['button_text']; ?>" class="widefat" type="text" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php _e( 'Form Style :' , 'next-mailchimp' ) ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>">
			<option value="">Default</option>
			<?php
			 foreach( $this->login_style as $k=>$v):
				if( in_array($k, ['form1', 'form2', 'form3', 'form4', 'form5', 'form6', 'form7', 'form8']) ):
			?>
				<option value="<?php echo $k;?>" <?php echo ($instance['style'] == $k ) ? 'selected' : ''; ?> > <?php _e( isset($v['text']) ? $v['text'] : $k, 'next-mailchimp'); ?> </option>
			 <?php 
			 	endif;
			 endforeach;?>
		</select>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'box_only' ); ?>"><?php _e( 'Hide Title' , 'next-mailchimp' ) ?></label>
		<input id="<?php echo $this->get_field_id( 'box_only' ); ?>" name="<?php echo $this->get_field_name( 'box_only' ); ?>" value="true" <?php if( $instance['box_only'] ) echo 'checked="checked"'; ?> type="checkbox" />
		<br /><small><?php _e( 'Only Show the Mail Box without Title.' , 'next-mailchimp' ) ?></small>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'custom_class' ); ?>"><?php _e( 'Custom Class :' , 'next-mailchimp' ) ?> </label>
		<input id="<?php echo $this->get_field_id( 'custom_class' ); ?>" name="<?php echo $this->get_field_name( 'custom_class' ); ?>" value="<?php echo $instance['custom_class']; ?>" class="widefat" type="text" />
	</p>
</div>