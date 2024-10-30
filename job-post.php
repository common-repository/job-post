<?php 
/* @wordpress-plugin
 * Plugin Name: Job Post
 * Description: Powerful & Robust plugin to create a Job Board on your website in simple & elegant way. 
 * Author:  Rock Technolabs Group
 * Author URI: http://rocktechnolabs.com/
 * Version:           1.0.0
 * Domain Path:       /languages
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Version
define( 'JOBPOST_VERSION', '1.0.0' );
define( 'JOBPOST_DB_VERSION', 1 );

// Define the URL to the plugin folder
define( 'JOBPOST_FOLDER', 'job-post' );

if( ! defined( 'JOBPOST_URL' ) )
	define( 'JOBPOST_URL', WP_PLUGIN_URL . '/' . JOBPOST_FOLDER );

// Define the basename
define( 'JOBPOST_BASENAME', plugin_basename( __FILE__ ) );

// Define the complete directory path
define( 'JOBPOST_DIR', dirname( __FILE__ ) );
define( 'JOBPOST_DIR_PATH', plugin_dir_path( __FILE__ ) );
 
const GET_METABOX_ERROR_PARAM = 'meta-error';
 
// jobpost global functions
require_once(  JOBPOST_DIR_PATH . 'function.php' );

require_once(  JOBPOST_DIR_PATH . 'tables.php' );

// add tempalte
require_once(  JOBPOST_DIR_PATH . 'rctjp-class-page-template.php' );
add_action( 'plugins_loaded', array( 'Page_Template_Plugin', 'get_instance' ) );
require_once(  JOBPOST_DIR_PATH . 'js/rctjp_contact_send_mail.php' );
require_once(  JOBPOST_DIR_PATH . 'templates/rctjp_re_captcha.php' );

add_action( 'wp_ajax_rctjp_contact_send_mail', 'rctjp_contact_send_mail' );
add_action( 'wp_ajax_nopriv_rctjp_contact_send_mail', 'rctjp_contact_send_mail' );

add_action( 'wp_ajax_rctjp_re_captcha', 'rctjp_re_captcha' );
add_action( 'wp_ajax_nopriv_rctjp_re_captcha', 'rctjp_re_captcha' );
