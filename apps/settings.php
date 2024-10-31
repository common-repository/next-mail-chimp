<?php
namespace themeDevMail\Apps;
if( ! defined( 'ABSPATH' )) die( 'Forbidden' );

class Settings{
	
	 /**
     * Custom post type
     * Method Description: Set custom post type
     * @since 1.0.0
     * @access public
     */
	const POST_TYPE = 'next-mailto';

	
    // general option key
	public static $general_key = '__next_mail_general_data';
	
	// global opyion key
	public static $global_key = '__next_mail_global_data';

	public static $body_position = ['left_content' => 'Left & Top in Body', 'right_content' => 'Right & Top in Body', 'top_content' => 'Left & Bottom in Body', 'bottom_content' => 'Right & Bottom in Body', 'center_content' => 'Center in Body', 'unset_position' => ' No Position'];
	

	protected $accessTokenUrl = 'https://login.mailchimp.com/oauth2/token';

	protected $list_url = 'https://%s.api.mailchimp.com/3.0/lists/%s';
	
	private static $cache = 12;

	public static $form_style = [ 'form1' => ['text' => 'Subscrible Style-1', 'url' => ''], 'form2' => ['text' => 'Subscrible Style-2', 'url' => ''], 'form3' => ['text' => 'Subscrible Style-3', 'url' => ''], 'form4' => ['text' => 'Subscrible Style-4', 'url' => ''], 'form5' => ['text' => 'Subscrible Style-5', 'url' => ''], 'form6' => ['text' => 'Subscrible Style-6', 'url' => ''], 'form7' => ['text' => 'Subscrible Style-7', 'url' => ''], 'form8' => ['text' => 'Subscrible Style-8', 'url' => ''] ];
	

	public function __construct($load = true){
		if($load){
			
            add_action('init', [ $this, 'next_posttype' ]);
            add_action('admin_menu', [ $this, 'themeDev_mail_admin_menu' ]);
			
			// Load script file for settings page
			add_action( 'admin_enqueue_scripts', [$this, 'themedev_script_loader_admin' ] );
			
			add_action( 'wp_enqueue_scripts', [$this, 'themedev_script_loader_public' ] );
		}
	}
	
	
	 /**
     * Public Static method : post_type
     * Method Description: Get custom post type
     * @since 1.0.0
     * @access public
     */
	public static function post_type(){
		return self::POST_TYPE;
	}
	/**
     * Public method : themeDev_add_custom_post
     * Method Description: Create custom post type
     * @since 1.0.0
     * @access public
     */
	public function themeDev_mail_admin_menu(){
        add_menu_page(
            esc_html__( 'Next Mail', 'next-mailchimp' ),
            esc_html__( 'Next Mail', 'next-mailchimp' ),
            'manage_options',
            self::post_type(),
            [ $this ,'themedev_next_mail_settings'],
            'dashicons-email-alt',
            6
        );
		
		add_submenu_page( self::post_type(), esc_html__('My Forms', 'next-mailchimp'), esc_html__('My Forms', 'next-mailchimp'), 'manage_options', 'edit.php?post_type='.self::post_type());
		add_submenu_page( self::post_type(), esc_html__( 'Support', 'next-mailchimp' ), esc_html__( 'Support', 'next-mailchimp' ), 'manage_options', 'next-mail-support', [ $this ,'themedev_next_mail_settings_supports'], 11); 
        
    }
    /**
     * Public method : next_posttype
     * Method Description: Create custom post type
     * @since 1.0.0
     * @access public
     */
    public function next_posttype(){
		$labels = array(
			'name'               => __( 'Forms', 'next-mailchimp' ),
			'singular_name'      => __( 'Form', 'next-mailchimp' ),
			'menu_name'          => __( 'My Forms', 'next-mailchimp' ),
			'name_admin_bar'     => __( 'Forms', 'next-mailchimp' ),
			'add_new'            => __( 'Add New Form', 'next-mailchimp' ),
			'add_new_item'       => __( 'Add New Form', 'next-mailchimp' ),
			'new_item'           => __( 'New Form', 'next-mailchimp' ),
			'edit_item'          => __( 'Edit Form', 'next-mailchimp' ),
			'view_item'          => __( 'View Form', 'next-mailchimp' ),
			'all_items'          => __( 'All Forms', 'next-mailchimp' ),
			'search_items'       => __( 'Search Forms', 'next-mailchimp' ),
			'parent_item_colon'  => __( 'Parent Forms:', 'next-mailchimp' ),
			'not_found'          => __( 'No Form found.', 'next-mailchimp' ),
			'not_found_in_trash' => __( 'No Form found in Trash.', 'next-mailchimp' ),
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'rewrite'             => false,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_nav_menus'   => false,
			'exclude_from_search' => true,
			'capability_type'     => 'page',
			'hierarchical'        => false,
			'supports'            => array( 'title' ),
		);

		register_post_type( self::post_type(), $args );
		
	}
	/**
	 * Method Name: themedev_next_mail_settings
	 * Description: Next Settings
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function themedev_next_mail_settings(){
		$message_status = 'No';
		$message_text = '';
		$active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'general';
		
		if($active_tab == 'general'){
			// general options
			if(isset($_POST['themedev-mail-general'])){
				$options = isset($_POST['themedev']) ? self::sanitize($_POST['themedev']) : [];
				
				if(update_option( self::$general_key, $options)){
					$message_status = 'yes';
					$message_text = __('Successfully save general data.', 'next-mailchimp');
					$this->__listed_mail(false);
				}
			}
			
			
		}
		//  get general data
		$getGeneral = get_option( self::$general_key, '');	
		$listed = $this->__listed_mail();  
		
		if($active_tab == 'global'){
			// global options
			$forms = $this->get_mail();
			if(isset($_POST['themedev-mail-global'])){
				$options = isset($_POST['themedev']) ? self::sanitize($_POST['themedev']) : [];
				if(update_option( self::$global_key , $options)){
					$message_status = 'yes';
					$message_text = __('Successfully save global data.', 'next-mailchimp');
					
				}
				
			}
			
		}
		//  get general data
		$getGlobal = get_option( self::$global_key, []);

		include ( NEXT_MAIL_PLUGIN_PATH.'/views/admin/settings.php');
	}

	public function get_mail(){
       
        $args['post_status'] = 	'publish';
        $args['post_type'] = self::post_type();
       
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
	/**
	 * Method Name: __listed_mail
	 * Description: Next Settings
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function  __listed_mail( $load = true, $listed = ''){
		$getGeneral = get_option( self::$general_key, '');
		$token = isset($getGeneral['general']['mail']['api_key']) ? $getGeneral['general']['mail']['api_key'] : '';

		if( strlen($token) > 5){
			$tokenData   = get_transient( '_next_mail_mail_list', '' );
			$dataToken 	 = is_array($tokenData) ? $tokenData : '';

			$get_transient_time   = get_transient( 'timeout__next_mail_mail_list' );		
        	if( !empty($dataToken)){	
				if( $load ){
					return $dataToken;
				}
				
			}
			$header = [
				'Authorization' => 'apikey ' . $token,
				'Content-Type' => 'application/json; charset=utf-8',
			];
			
			$body = [
			];
			try {
				$server = explode( '-', $token );
				$hosting = end($server);
				$url = sprintf($this->list_url, $hosting, $listed);
				
				$respon = wp_remote_get( $url, array( 'timeout' => 120, 'httpversion' => '1.1', 'headers' => $header ) );
				
				if ( !is_array( $respon ) ) {
					return $dataToken;
				}
				
				$response = isset( $respon['body']) ?  $respon['body'] : [];
				$response = @json_decode($response, true);
				if(isset($response['lists'])){
					$lists = isset($response['lists']) ?  $response['lists'] : [];
					$data = array_map(function( $a ){
						$return['id'] = isset($a['id']) ? $a['id'] : '';
						$return['name'] = isset($a['name']) ? $a['name'] : '';
						$return['member_count'] = isset($a['stats']['member_count']) ? $a['stats']['member_count'] : 0;
						$return['unsubscribe_count'] = isset($a['stats']['unsubscribe_count']) ? $a['stats']['unsubscribe_count'] : 0;
						$return['campaign_count'] = isset($a['stats']['campaign_count']) ? $a['stats']['campaign_count'] : 0;
						return $return;
					}, $lists);
					set_transient( '_next_mail_mail_list', $data , self::$cache*60*60 );
					
					return $data;
				}

			}
			catch (Exception $e) {
				return __('Api Errors', 'next-mailchimp');
			}		
		}
		return __('Enter API Keys', 'next-mailchimp');
	}
	/**
	 * Method Name: themedev_next_mail_settings_supports
	 * Description: Next Support Page
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function themedev_next_mail_settings_supports(){
		include ( NEXT_MAIL_PLUGIN_PATH.'/views/admin/supports.php');
	}
	/**
     * Public method : sanitize
     * Method Description: Sanitize for Review
     * @since 1.0.0
     * @access public
     */
	public static function sanitize($value, $senitize_func = 'sanitize_text_field'){
        $senitize_func = (in_array($senitize_func, [
                'sanitize_email', 
                'sanitize_file_name', 
                'sanitize_hex_color', 
                'sanitize_hex_color_no_hash', 
                'sanitize_html_class', 
                'sanitize_key', 
                'sanitize_meta', 
                'sanitize_mime_type',
                'sanitize_sql_orderby',
                'sanitize_option',
                'sanitize_text_field',
                'sanitize_title',
                'sanitize_title_for_query',
                'sanitize_title_with_dashes',
                'sanitize_user',
                'esc_url_raw',
                'wp_filter_nohtml_kses',
            ])) ? $senitize_func : 'sanitize_text_field';
        
        if(!is_array($value)){
            return $senitize_func($value);
        }else{
            return array_map(function($inner_value) use ($senitize_func){
                return self::sanitize($inner_value, $senitize_func);
            }, $value);
        }
	}
	
	/**
     *  ebay_settings_script_loader .
     * Method Description: Settings Script Loader
     * @since 1.0.0
     * @access public
     */
    public function themedev_script_loader_public(){
        wp_register_script( 'themedev_mail_settings_script', NEXT_MAIL_PLUGIN_URL. 'assets/public/script/public-script.js', array( 'jquery' ), NEXT_MAIL_VERSION, false);
        
		wp_register_style( 'themedev_mail_settings_css_public', NEXT_MAIL_PLUGIN_URL. 'assets/public/css/public-style.css', false, NEXT_MAIL_VERSION);
        wp_enqueue_style( 'themedev_mail_settings_css_public' );

		wp_register_style( 'themedev_mail_fonts', NEXT_MAIL_PLUGIN_URL. 'assets/public/css/nx-subscribe.css', false, NEXT_MAIL_VERSION);
		
		wp_register_script( 'themedev_mail_subscribe', NEXT_MAIL_PLUGIN_URL. 'assets/public/script/subscribe.js', array( 'jquery' ), NEXT_MAIL_VERSION, false);
		wp_enqueue_script( 'themedev_mail_subscribe' );

		wp_register_style( 'select2', NEXT_MAIL_PLUGIN_URL. 'assets/select2/css/select2-min.css', false, NEXT_MAIL_VERSION );
		wp_register_script( 'select2', NEXT_MAIL_PLUGIN_URL. 'assets/select2/script/select2-min.js', array( 'jquery' ), NEXT_MAIL_VERSION, false);

     }
	 
	 /**
     *  ebay_settings_script_loader .
     * Method Description: Settings Script Loader
     * @since 1.0.0
     * @access public
     */
    public function themedev_script_loader_admin(){
		$screen = get_current_screen();
		//echo $screen->id;
		if( in_array($screen->id, [ 'toplevel_page_next-mailto', 'next-mailto', 'edit-next-mailto', 'next-mail_page_next-mail-support']) ){
			
			wp_register_script( 'themedev_mail_settings_script_admin', NEXT_MAIL_PLUGIN_URL. 'assets/admin/scripts/admin-settings.js', array( 'jquery' ), NEXT_MAIL_VERSION, false);
			wp_enqueue_script( 'themedev_mail_settings_script_admin' );
			
			wp_register_style( 'themedev_mail_settings_css_admin', NEXT_MAIL_PLUGIN_URL. 'assets/admin/css/admin-style.css', false, NEXT_MAIL_VERSION);
			wp_enqueue_style( 'themedev_mail_settings_css_admin' );

			wp_register_style( 'select2', NEXT_MAIL_PLUGIN_URL. 'assets/select2/css/select2-min.css', false, NEXT_MAIL_VERSION);
			wp_register_script( 'select2', NEXT_MAIL_PLUGIN_URL. 'assets/select2/script/select2-min.js', array( 'jquery' ), NEXT_MAIL_VERSION, false);
		}

		wp_register_style( 'themedev_ads', NEXT_MAIL_PLUGIN_URL. 'assets/admin/css/ads.css', false, NEXT_MAIL_VERSION);
		wp_enqueue_style( 'themedev_ads' );

			
     }
	
	 
}