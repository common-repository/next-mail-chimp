<?php
if( ! defined( 'ABSPATH' )) die( 'Forbidden' );
/**
 * Plugin Name: Next Mail
 * Description: The most Advanced Mail Chimp for Subscribe. 
 * Plugin URI: http://products.themedev.net/next-mailchimp/
 * Author: ThemeDev
 * Version: 2.0.3
 * Author URI: http://themedev.net/
 *
 * Text Domain: next-mailchimp
 *
 * @package NextSocial 
 * @category Free
 * Domain Path: /languages/
 * License: GPL2+
 */
/**
 * Defining static values as global constants
 * @since 1.0.0
 */
define( 'NEXT_MAIL_VERSION', '2.0.2' );
define( 'NEXT_MAIL_PREVIOUS_STABLE_VERSION', '2.0.1' );

define( 'NEXT_MAIL_KEY', 'next-mailchimp' );

define( 'NEXT_MAIL_DOMAIN', 'next-mailchimp' );

define( 'NEXT_MAIL_FILE_', __FILE__ );
define( "NEXT_MAIL_PLUGIN_PATH", plugin_dir_path( NEXT_MAIL_FILE_ ) );
define( 'NEXT_MAIL_PLUGIN_URL', plugin_dir_url( NEXT_MAIL_FILE_ ) );

// initiate actions
add_action( 'plugins_loaded', 'themedev_mail_load_plugin_textdomain' );
/**
 * Load eBay Search textdomain.
 * @since 1.0.0
 * @return void
 */
function themedev_mail_load_plugin_textdomain() {
	load_plugin_textdomain( 'next-mailchimp', false, basename( dirname( __FILE__ ) ) . '/languages'  );

	// add action page hook
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'themedev_mail_action_links' );
	/**
	 * Load Next Review Loader main page.
	 * @since 1.0.0
	 * @return plugin output
	 */

	do_action( 'nextmail/loaded' );

	require_once(NEXT_MAIL_PLUGIN_PATH.'init.php');
	new \themeDevMail\Init();

}

// added custom link
function themedev_mail_action_links($links){
	$links[] = '<a href="' . admin_url( 'admin.php?page=next-mailto' ).'"> '. __('Settings', 'next-mailchimp').'</a>';
	return $links;
}

