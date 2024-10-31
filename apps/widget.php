<?php
namespace themeDevMail\Apps;
if( ! defined( 'ABSPATH' )) die( 'Forbidden' );

use \themeDevMail\Apps\Settings as Settings;

class Widget extends \WP_Widget {
    private $login, $login_style, $from_id;
	public function __construct() {
		add_action( 'widgets_init', [ $this, 'next_mail_register_widgets'] );
		$this->login = new Mail(false);
		
		$this->login_style = Settings::$form_style;
		$this->login->btn_style = 'from1';
        $this->from_id = 0;
       
		parent::__construct(
			'next-mail-widget', 
			__('Next MailChimp', 'next-mailchimp'), 
			array( 'description' => __( 'Next MailChimp for Subscribe.', 'next-mailchimp' ), ) 
		);
	}

	public function widget( $args, $instance ) {
		
		extract( $args );
		
		$title 		= isset($instance['title']) ? $instance['title'] : '';
		$button_text = isset($instance['button_text']) ? $instance['button_text'] : '';
		$style 		= isset($instance['style']) ? $instance['style'] : '';
		$from_id 	= isset($instance['from_id']) ? $instance['from_id'] : 0;
		$custom_class 	= isset($instance['custom_class']) ? $instance['custom_class'] : '';
		$box_only 		= isset($instance['box_only']) ? $instance['box_only'] : false;
		
		if( !$box_only ){
			echo $before_widget . $before_title . $title . $after_title;
		}
        $atts['form-id'] = $from_id;
        $atts['class'] = $custom_class;
        $atts['btn-text'] = $button_text;
        $atts['btn-style'] = $style;
        $atts['icon-position'] = '';
        $atts['icon'] = '';
     
		echo $this->login->next_mail_shortcode_action($atts);

		if( !$box_only ){
			echo $after_widget;
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['from_id'] 	= $new_instance['from_id'] ;
		$instance['style'] 		= $new_instance['style'] ;
		$instance['title'] 		= $new_instance['title'] ;
		$instance['button_text'] = isset($new_instance['button_text']) ? $new_instance['button_text'] : '';
		$instance['box_only'] 	= $new_instance['box_only'] ;
		$instance['custom_class'] 	= $new_instance['custom_class'] ;
		return $instance;
	}

	public function form( $instance ) {
		$defaults = array( 'title' => __( 'Subscribe' , 'next-mailchimp' )  , 'from_id' => 0, 'style' => '', 'button_text' => '' , 'box_only' => false, 'custom_class' => '');
        $instance = wp_parse_args( (array) $instance, $defaults );
        $select_from = isset($instance['from_id']) ? $instance['from_id'] : 0;
        
        $listed = $this->get_mail(); 

        include ( NEXT_MAIL_PLUGIN_PATH.'/views/public/widget-html.php');
	}
	function next_mail_register_widgets() {
		register_widget( 'themeDevMail\Apps\Widget' );
    }
    

    public function get_mail(){
       
        $args['post_status'] = 	'publish';
        $args['post_type'] = Settings::post_type();
       
        $posts = get_posts($args);    
        $options = [];
        $count = count($posts);
        if($count > 0):
            foreach ($posts as $post) {
                $options[$post->ID] = $post->post_title;
            }
        endif;  

        return $options;
    }
}





