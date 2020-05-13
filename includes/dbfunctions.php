<?php
/**
 * Database Functions
 * 
 * @see https://developer.wordpress.org/reference/classes/wpdb/
 * 
 */

 // Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $lrs_db_version;  // If you want to track the version of your DB currently on the site
$lrs_db_version = '1.0';

/**
 * Create Database Tables
 * 
 * @link https://developer.wordpress.org/reference/functions/maybe_create_table/
 * 
 */
function lrs_create_tables() {
    global $wpdb;
    global $lrs_db_version;

    $table = 'TABLENAME'; 
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table ( /** SQL STATEMENT */) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	maybe_create_table( $table, $sql );

	add_option( 'lrs_db_version', $lrs_db_version );
}

/**
 * Get Entity ID
 *
 * @param string $entity
 * @return mixed $result || false
 */
function lrs_get_id( $entity ) {
    global $wpdb;
    $sql = false;

    switch( $entity ) {
        case 'order' :
            $sql = ""; // SQL statement if $entity passed is 'order'
        break;
        case 'service' :
            $sql = ""; // SQL statement if $entity passed is 'order'
        break;
        case 'city' :
            $sql = ""; // SQL statement if $entity passed is 'order'
        break;
    }

    if( $sql ) {
        $results = $wpdb->get_results( $wpdb->prepare( $sql ) );

        return $result;
    }
    
    return false;
}


// function to get bookingIds
function getBookingId(){
    
    global $cnxn;
    $sql = "SELECT bookingID
    FROM orders;";
    $statement = $cnxn->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();

    return $result;
}

// function to get service
function getServiceId(){
    global $cnxn;
    $sql = "SELECT serviceID, service
    FROM Services;";
    $statement = $cnxn->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();

    return $result;
}
// function to get cites
function getCityId(){
    global $cnxn;
    $sql = "SELECT cityID, city
    FROM Location;";
    $statement = $cnxn->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();

    return $result;
}
