<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that
 * also follow WordPress Coding Standards and PHP best practices.
 *
 * @package   Gelato
 * @author    Enej Bajgoric <enej.bajgoric@ubc.ca>
 * @license   GPL-2.0+
 * @link      http://ctlt.ubc.ca
 * @copyright 2014 CTLT UBC
 *
 * @wordpress-plugin
 * Plugin Name:       Gelato
 * Plugin URI:        http://github.com/ubc/gelato
 * Description:       Gelato
 * Version:           1.0.0
 * Author:            Enej Bajgoric
 * Text Domain:       gelato-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/ubc/gelato
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/
define( 'GELATO_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'GELATO_BASENAME', plugin_basename( __FILE__ ) );
define( 'GELATO_DIR_URL' ,  plugins_url( '', GELATO_BASENAME ) );
define( 'GELATO_SLUG'	 , 'session' );
define( 'GELATO_CPT'	 , 'gelato' );
define( 'GELATO_VERSION' ,  0.1 );



/*
 *
 */
require_once( GELATO_DIR_PATH . 'public/class-gelato.php' );

require_once( GELATO_DIR_PATH . 'public/includes/scoops/class-gelato-scoop.php' );
require_once( GELATO_DIR_PATH . 'public/includes/scoops/navbar/class-navbar-scoop.php' );
require_once( GELATO_DIR_PATH . 'public/includes/scoops/navigation/class-navigation-scoop.php' );
require_once( GELATO_DIR_PATH . 'public/includes/scoops/media/class-media-scoop.php' );
require_once( GELATO_DIR_PATH . 'public/includes/scoops/presentpress/class-presentpress-scoop.php' );
require_once( GELATO_DIR_PATH . 'public/includes/scoops/pulse/class-pulse-scoop.php' );


/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 */
register_activation_hook( __FILE__, array( 'Gelato', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Gelato', 'deactivate' ) );


add_action( 'plugins_loaded', array( 'Gelato', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*

 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-gelato-admin.php' );
	add_action( 'plugins_loaded', array( 'Gelato_Admin', 'get_instance' ) );

}




