<?php
/**
 * Plugin Name:     Landscaping Request System
 * Plugin URI:      http://chelan.highline.edu/~csci201
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          Domino Developers
 * Author URI:      http://chelan.highline.edu/~csci201
 * Text Domain:     landscaping-request-system
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Landscaping_Request_System
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Plugin Directory
 */
define( 'LRS_DIR', dirname( __FILE__ ) );
define( 'LRS_DIR_URI', plugin_dir_url( __FILE__ ) );

/**
 * Load dependencies
 * 
 * @see https://www.php.net/manual/en/function.require-once.php
 * @see https://www.php.net/manual/en/function.include-once.php
 */
require_once( LRS_DIR . '/includes/request.php' 		);
require_once( LRS_DIR . '/includes/contact-form.php' 	);
require_once( LRS_DIR . '/includes/confirmation.php' 	);

require_once( LRS_DIR . '/includes/helpers.php' 		);
require_once( LRS_DIR . '/includes/dbfunctions.php'     );
require_once( LRS_DIR . '/includes/arrays.php'          );
require_once( LRS_DIR . '/includes/functions.php'       );

/** Alternatively, use include_once */
// include_once( LRS_DIR . 'includes/dbfunctions.php' );
// include_once( LRS_DIR . 'includes/arrays.php' );
// include_once( LRS_DIR . 'includes/functions.php' );

/**
 * Kick it off.
 * Called when plugin is activated
 * 
 * @link https://developer.wordpress.org/reference/functions/register_activation_hook/
 */
function lrs_init() {}
register_activation_hook( __FILE__, 'lrs_init' );