<?php
namespace themeDevMail;
if( ! defined( 'ABSPATH' )) die( 'Forbidden' );
/**
 * Class Name : Init - This main class for ebay plugin
 * Class Type : Normal class
 *
 * initiate all necessary classes, hooks, configs
 *
 * @since 1.0.0
 * @access Public
 */

Class Init{
     
    
	 /**
     * Construct the plugin object
     * @since 1.0.0
     * @access public
     */
	public function __construct(){
	    $this->social_autoloder();
         new Apps\Settings();
         new Apps\Mail();
         new Apps\Widget();

         if(current_user_can('manage_options')){
               // proactive
               Apps\Proactive\Init::instance()->_init();
          }
         
	}
	
	
	/**
     * Review aws_autoloder.
     * xs_review autoloader loads all the classes needed to run the plugin.
     * @since 1.0.0
     * @access private
     */
	
	private function social_autoloder(){
		require_once NEXT_MAIL_PLUGIN_PATH . '/loader.php';
        Loader::run_plugin_social();
	}
	 
}