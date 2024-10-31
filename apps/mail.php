<?php
namespace themeDevMail\Apps;
if( ! defined( 'ABSPATH' )) die( 'Forbidden' );

use \themeDevMail\Apps\Settings as Settings;

class Mail{
    
	private $getGeneral = [];
	
	private $getGlobal = [];

	public $from_id = 0;

	public $id_name = '';

	public $class_name = '';

	public $btn_text = '';

	public $btn_style = '';

	public $icon_position = '';

	public $content_position = '';

	public $icon = '';

	private $url = 'https://%s.api.mailchimp.com/3.0/lists/%s/members/';
	
    public function __construct($load = true){
		if($load){
           
            // add meta box
            add_action( 'add_meta_boxes', [ $this, 'next_meta_box_for_listed' ] );
			 // save post
			add_action( 'save_post', array( $this, 'next_meta_box_for_listed_data' ), 1, 2  );

			// short-code
			add_shortcode( 'next-mail', [ $this, 'next_mail_shortcode'] );

			// load api
			add_action('init', [ $this, 'next_rest_api']);

			add_action('wp_footer', [ $this, '__the_body_content_body' ] );
		}
		$this->getGeneral = get_option( Settings::$general_key );
		$this->getGlobal = get_option( Settings::$global_key );

	}

	/**
     * Method: next_rest_api
     * Method Description: Connect Rest Api
     * @since 1.0.0
     * @access public
	 */
	public function next_rest_api(){
		add_action( 'rest_api_init', function () {
		  register_rest_route( 'next-mail', '/send/(?P<data>\w+)/',
			array(
				'methods' => 'GET',
				'callback' => [ $this, 'next_rest_api_callback'],
			  ) 
		  );
		} );
	}

	/**
     * Method: next_rest_api_callback
     * Method Description: Callback Rest Api
     * @since 1.0.0
     * @access public
	 */
	public function next_rest_api_callback( \WP_REST_Request $request ){		
		$return = ['success' => [], 'error' => [] ];

		$param = (int) isset($request['data']) ? $request['data'] : '';
		if(empty($param) OR $param == 0 OR $param == ''){
			$return['error'] = __('Please select any forms.', 'next-mailchimp');
			return $return;
		}

		// get api
		$api_key = isset( $this->getGeneral['general']['mail']['api_key'] ) ? trim($this->getGeneral['general']['mail']['api_key']) : '';
		if( empty($api_key) OR $api_key == 0 OR $api_key == ''){
			$return['error'] =  __('Please Enter you API Key.', 'next-mailchimp');
			return $return;
		}
		
		$post = get_post($param);
		$post_id = property_exists($post, 'ID') ? $post->ID : 0;
		if($post_id == 0 || $post_id == ''){
			$return['error'] =  __('Invalid form.', 'next-mailchimp');
			return $return;
		}
		$options = get_post_meta( $post_id, '__next_mail_listed_info', true);
		$listed_id = isset($options['listed_id']) ? $options['listed_id'] : '';
		if($listed_id == 0 || $listed_id == ''){
			$return['error'] =  __('Please select any listed.', 'next-mailchimp');
			return $return;
		}

		$forms_data = (array) isset($request['nextmail']) ? Settings::sanitize($request['nextmail']) : '';
		$fisrt = isset($forms_data['first_name']) ? trim($forms_data['first_name']) : '';
		$last = isset($forms_data['last_name']) ? trim($forms_data['last_name']) : '';
		$email = isset($forms_data['email']) ? trim( Settings::sanitize($forms_data['email'], 'sanitize_email')) : '';
		$phone = isset($forms_data['phone']) ? trim($forms_data['phone']) : '';
		$address = isset($forms_data['address']) ? trim($forms_data['address']) : '';
		$city = isset($forms_data['city']) ? trim($forms_data['city']) : '';
		$state = isset($forms_data['state']) ? trim($forms_data['state']) : '';
		$zip = isset($forms_data['zip']) ? trim($forms_data['zip']) : '';
		$country = isset($forms_data['country']) ? trim($forms_data['country']) : '';

		$postData = [];
		$additional = [];
		// first name
		if( !empty($fisrt)){
			$additional['FNAME'] = $fisrt;
		}else{
			$require = isset($options['provider']['first_name']['require']) ? 'Yes' : '';
			if($require == 'Yes'){
				$return['error'] =  __('Enter first name', 'next-mailchimp');
				return $return;
			}
			
		}

		// last name
		if( !empty($last)){
			$additional['LNAME'] = $last;
		}else{
			$require = isset($options['provider']['last_name']['require']) ? 'Yes' : '';
			if($require == 'Yes'){
				$return['error'] =  __('Enter last name', 'next-mailchimp');
				return $return;
			}
			
		}

		// email name
		if( !empty($email)){
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$return['error'] =  __('Enter valid email address', 'next-mailchimp');
				return $return;
			}
			$postData['email_address'] = $email;
		}else{
			$require = isset($options['provider']['email']['require']) ? 'Yes' : '';
			if($require == 'Yes'){
				$return['error'] =  __('Enter email address', 'next-mailchimp');
				return $return;
			}
			
		}

		// phone
		if( !empty($phone)){
			$additional['LNAME'] = $phone;
		}else{
			$require = isset($options['provider']['phone']['require']) ? 'Yes' : '';
			if($require == 'Yes'){
				$return['error'] =  __('Enter phone number', 'next-mailchimp');
				return $return;
			}
			
		}

		// address
		if( !empty($address)){
			$additional['ADDRESS']['addr1'] = $address;
		}else{
			$require = isset($options['provider']['address']['require']) ? 'Yes' : '';
			if($require == 'Yes'){
				$return['error'] =  __('Enter Street Address ', 'next-mailchimp');
				return $return;
			}
			
		}

		// city
		if( !empty($city)){
			$additional['ADDRESS']['city'] = $city;
		}else{
			$require = isset($options['provider']['city']['require']) ? 'Yes' : '';
			if($require == 'Yes'){
				$return['error'] =  __('Enter City ', 'next-mailchimp');
				return $return;
			}
			
		}

		// state
		if( !empty($state)){
			$additional['ADDRESS']['state'] = $state;
		}else{
			$require = isset($options['provider']['state']['require']) ? 'Yes' : '';
			if($require == 'Yes'){
				$return['error'] =  __('Enter State ', 'next-mailchimp');
				return $return;
			}
			
		}
		// state
		if( !empty($zip)){
			$additional['ADDRESS']['zip'] = $zip;
		}else{
			$require = isset($options['provider']['zip']['require']) ? 'Yes' : '';
			if($require == 'Yes'){
				$return['error'] =  __('Enter ZIP ', 'next-mailchimp');
				return $return;
			}
			
		}

		// country
		if( !empty($country)){
			$additional['ADDRESS']['country'] = $country;
		}else{
			$require = isset($options['provider']['country']['require']) ? 'Yes' : '';
			if($require == 'Yes'){
				$return['error'] =  __('Select Country ', 'next-mailchimp');
				return $return;
			}
			
		}

		$postData['status'] =  'subscribed';
		if(sizeof($additional) > 0):
			$postData['merge_fields'] =  $additional;
		endif;
		$postData['status_if_new'] =  'subscribed';


		$api_data = explode( '-', $api_key );	
		$hosting = end($api_data);	
		$url = sprintf( $this->url, $hosting, $listed_id); 
		$response = wp_remote_post( $url, [
			'method' => 'POST',
			'data_format' => 'body',
			'timeout' => 45,
			'headers' => [

							'Authorization' => 'apikey '.$api_key,
							'Content-Type' => 'application/json; charset=utf-8'
					],
			'body' => json_encode($postData	)
			]
		);

		if ( is_wp_error( $response ) ) {
		   $error_message = $response->get_error_message();
		   $return['error'] = "Something went wrong: $error_message";
		} else {
			$msg = isset($options['success_send']) ? $options['success_send'] : '';
			$msg_error = isset($options['already_send']) ? $options['already_send'] : '';
			$return['success'] = $response;
			$return['success']['msg'] = __($msg, 'next-mailchimp');
			$return['success']['msg_error'] = __($msg_error, 'next-mailchimp');
		}

		return $return;
	}
	 /**
     * Public method : next_sharing_shortcode
     * Method Description: Sharing Shortcode
     * @since 1.0.0
     * @access public
     */
	public function next_mail_shortcode( $atts , $content = null ){
	
		$atts = shortcode_atts(
								[
										'form-id' => 0,
										'class' => '',
										'btn-style' => '',
										'btn-text' => '',
										'icon' => '',
										'icon-position' => '',
									], $atts, 'next-mail' 
							);

		return $this->next_mail_shortcode_action( $atts );
	}

	public function next_mail_shortcode_action( $atts = '' ){
		if(!isset($this->getGeneral['general']['mail']['ebable'])){
			return '';
		}

		$this->from_id = isset($atts['form-id']) ? $atts['form-id'] : 0;
		
		$post = get_post($this->from_id);
		if(!is_object($post)){
			return '';
		}
		$post_id = property_exists($post, 'ID') ? $post->ID : 0;
		if($post_id == 0 || $post_id == ''){
			return '';
		}
		
		$options = get_post_meta( $post_id, '__next_mail_listed_info', true);
		$icon_id = isset($options['button_icon']) ? $options['button_icon'] : '';
		$icon_position = isset($options['button_position']) ? $options['button_position'] : 'left';
		$claasName = isset($options['custom_class']) ? $options['custom_class'] : '';


		$this->class_name = isset($atts['class']) ? $atts['class'] : $claasName;

		$btnText = isset($options['button_text']) ? $options['button_text'] : '';
		$button_style = isset($options['button_style']) ? $options['button_style'] : 'form1';

		$this->btn_text = isset($atts['btn-text']) ? $atts['btn-text'] : '';
		$this->btn_text = (strlen($this->btn_text) > 2) ? $this->btn_text : $btnText;

		$this->btn_style = isset($atts['btn-style']) ? $atts['btn-style'] : '';
		$this->btn_style = (strlen($this->btn_style) > 2) ? $this->btn_style : $button_style;

		$this->icon_position = isset($atts['icon-position']) ? $atts['icon-position'] : '';
		$this->icon_position = (strlen($this->icon_position) > 1) ? $this->icon_position : $icon_position;

		$this->icon = isset($atts['icon']) ? $atts['icon'] : '';
		$this->icon = (strlen($this->icon) > 2) ? $this->icon : $icon_id;
		// icon font
		// select 2
		wp_enqueue_style( 'select2' );
		wp_enqueue_script( 'select2' );
		wp_enqueue_style( 'themedev_mail_fonts' );
		wp_enqueue_script( 'themedev_mail_settings_script' );
		wp_localize_script('themedev_mail_settings_script', 'next_mail', array( 'siteurl' => get_option('siteurl'), 'url' => NEXT_MAIL_PLUGIN_URL, 'nonce' => wp_create_nonce( 'wp_rest' ), 'resturl' => get_rest_url() ));
		
		// custommfiled
		$custom_filed = isset($options['provider']) ? $options['provider'] : ['email' => ['enable' => 'Yes']];

		require_once(NEXT_MAIL_PLUGIN_PATH.'apps/country.php');
		$countryList = next_mail_country();

		ob_start();
		include ( NEXT_MAIL_PLUGIN_PATH.'/views/public/btn-html.php');
		$nextButton = ob_get_contents();
		ob_end_clean();
		
		return $nextButton;
	}
 /**
     * Public method : __the_body_content_body
     * Method Description: Mail option for page
     * @since 1.0.0
     * @access public
     */
	public function __the_body_content_body( ){
		
		if(!isset($this->getGlobal['global']['popup']['ebable'])){
			return '';
		}

		$body_position = isset($this->getGlobal['global']['popup']['body_position']) ? $this->getGlobal['global']['popup']['body_position'] : 'center_content';
		
		$this->content_position = 'nextmail-position_fixed next-'.$body_position;
		
		if( in_array($body_position, ['left_content', 'right_content', 'top_content', 'bottom_content', 'center_content']) ){
			
			$from_id = isset($this->getGlobal['global']['popup']['listed_id']) ? $this->getGlobal['global']['popup']['listed_id'] : 0;
			$timing = isset($this->getGlobal['global']['popup']['timing']) ? $this->getGlobal['global']['popup']['timing'] : 12;
		
			$atts['form-id'] = $from_id;
			$atts['class'] = '';
			$atts['button_text'] = '';
			$atts['btn-text'] = '';
			$atts['btn-style'] = '';
			$atts['icon-position'] = '';
			$atts['icon'] = '';

			echo $this->next_mail_shortcode_action($atts);
		}
		
	}
    /**
     * Public method : next_meta_box_for_sharing
     * Method Description: Sharing option for page
     * @since 1.0.0
     * @access public
     */
	 public function next_meta_box_for_listed(){
		if(!isset($this->getGeneral['general']['mail']['ebable'])){
			return '';
		}
		global $post;
		if( !isset($post->post_type) ){
			return '';
		}
		if( $post->post_type == Settings::post_type() ): 
			add_meta_box(
				'__next_mail_listed_id',
				esc_html__('Form Options', 'next-mailchimp'),
				[$this, 'next_listed_options_page'],
				Settings::post_type(),
				'normal',
				'high'
			);

		endif;
	 }
	/**
     * Public method : next_listed_options_page
     * Method Description: Selected listed id
     * @since 1.0.0
     * @access public
     */
	 public function next_listed_options_page(){
		global $post;
		
		$options_view['email'] = 'Email Address';
		$options_view['first_name'] = 'First Name';
		$options_view['last_name'] = 'Last Name';
		$options_view['phone'] = 'Phone';
		$options_view['address'] = 'Street Address';
		$options_view['city'] = 'City';
		$options_view['state'] = 'State';
		$options_view['zip'] = 'ZIP';
		$options_view['country'] = 'Country';
		$core_option = $options_view;
		
		require_once(NEXT_MAIL_PLUGIN_PATH.'apps/country.php');
		$countryList = next_mail_country();
		
		$post_id = property_exists($post, 'ID') ? $post->ID : 0;
		$options = get_post_meta( $post_id, '__next_mail_listed_info', true);
		
		if(empty($options) ){
			$options = ['provider' => ['email' => ['enable' => 'Yes']]];
		}else if( isset($options['provider']) ){
			$options_view = $options['provider'];
		}
		

		$listed_id = isset($options['listed_id']) ? $options['listed_id'] : '';
		$setting = new Settings();
		$listed = $setting->__listed_mail();  
		
		// select 2
		wp_enqueue_style( 'select2' );
		wp_enqueue_script( 'select2' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_style( 'themedev_mail_fonts' );

		$icons = $this->__get_icons();

		$icon_id = isset($options['button_icon']) ? $options['button_icon'] : 'nx-subscribe-contact';
		$icon_position = isset($options['button_position']) ? $options['button_position'] : 'left';

		$buttonstyle = Settings::$form_style;
		$button_style  = isset($options['button_style']) ? $options['button_style'] : 'form1';
				
		include( NEXT_MAIL_PLUGIN_PATH.'views/admin/select-listed.php' );
	 }
	
	 /**
     * Public method : next_meta_box_for_listed_data
     * Method Description: Selected listed id Save
     * @since 1.0.0
     * @access public
     */
	 public function next_meta_box_for_listed_data( $post_id, $post ){
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
		// check post id
		if( !empty($post_id) AND is_object($post) ){
			if( isset( $_POST['themedev_mail'] ) ){
				update_post_meta( $post_id, '__next_mail_listed_info', Settings::sanitize($_POST['themedev_mail']) );
			}
		}
	 }

	 public function __get_icons() {
		global $wp_filesystem;
		require_once ( ABSPATH . '/wp-admin/includes/file.php' );
		WP_Filesystem();
		 
		$local_file =    NEXT_MAIL_PLUGIN_PATH. '/assets/public/css/nx-font-array.json';
		$content    =   '';
		if ( $wp_filesystem->exists( $local_file ) ) {
			$content = (array) json_decode( $wp_filesystem->get_contents( $local_file ) , true);
		} 
		return $content;
	}
}