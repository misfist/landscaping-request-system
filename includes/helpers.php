<?php
/**
 * Helper Functions
 *
 * @since   1.0.0
 * @package Landscaping_Request_System
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Debug Helper
 * Output data to the browser console.
 */
if( !function_exists( 'console_log' ) ) {
function console_log( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output );

    echo "<script>console.log( $output );</script>";
}
}
