<?php


/***************************
* Some custom queries for the apartments
****************************/

// Country Field Meta Query
function country_meta_values( 
$key = 'country', 
$type = 'apartments', 
$status = 'publish' ) 
{

global $wpdb;

if( empty( $key ) )
    return;

    $res = $wpdb->get_col( $wpdb->prepare( "
    SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
    LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
    WHERE pm.meta_key = '%s'
    AND p.post_status = '%s'
    AND p.post_type = '%s'
    ", $key, $status, $type ) );

        return $res;
    }  

// State Field Meta Query
function state_meta_values( 
$key = 'state', 
$type = 'apartments', 
$status = 'publish' ) 
{

global $wpdb;

if( empty( $key ) )
    return;

    $res = $wpdb->get_col( $wpdb->prepare( "
    SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
    LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
    WHERE pm.meta_key = '%s'
    AND p.post_status = '%s'
    AND p.post_type = '%s'
    ", $key, $status, $type ) );

        return $res;
    } 

// Parking Field Meta Query
function parking_meta_values( 
$key = 'parking', 
$type = 'apartments', 
$status = 'publish' ) 
{

global $wpdb;

if( empty( $key ) )
    return;

    $res = $wpdb->get_col( $wpdb->prepare( "
    SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
    LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
    WHERE pm.meta_key = '%s'
    AND p.post_status = '%s'
    AND p.post_type = '%s'
    ", $key, $status, $type ) );

        return $res;
    }

// Internet Field Meta Query
function internet_meta_values( 
$key = 'internet', 
$type = 'apartments', 
$status = 'publish' ) 
{

global $wpdb;

if( empty( $key ) )
    return;

    $res = $wpdb->get_col( $wpdb->prepare( "
    SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
    LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
    WHERE pm.meta_key = '%s'
    AND p.post_status = '%s'
    AND p.post_type = '%s'
    ", $key, $status, $type ) );

        return $res;
    }


// Lift Field Meta Query
function lift_meta_values( 
$key = 'lift', 
$type = 'apartments', 
$status = 'publish' ) 
{

global $wpdb;

if( empty( $key ) )
    return;

    $res = $wpdb->get_col( $wpdb->prepare( "
    SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
    LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
    WHERE pm.meta_key = '%s'
    AND p.post_status = '%s'
    AND p.post_type = '%s'
    ", $key, $status, $type ) );

        return $res;
    }


// Living Room Field Meta Query
function livingroom_meta_values( 
$key = 'livingroom', 
$type = 'apartments', 
$status = 'publish' ) 
{

global $wpdb;

if( empty( $key ) )
    return;

    $res = $wpdb->get_col( $wpdb->prepare( "
    SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
    LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
    WHERE pm.meta_key = '%s'
    AND p.post_status = '%s'
    AND p.post_type = '%s'
    ", $key, $status, $type ) );

        return $res;
    }


// Dining Room Field Meta Query
function diningroom_meta_values( 
$key = 'diningroom', 
$type = 'apartments', 
$status = 'publish' ) 
{

global $wpdb;

if( empty( $key ) )
    return;

    $res = $wpdb->get_col( $wpdb->prepare( "
    SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
    LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
    WHERE pm.meta_key = '%s'
    AND p.post_status = '%s'
    AND p.post_type = '%s'
    ", $key, $status, $type ) );

        return $res;
    }


// Kitchen Field Meta Query
function kitchen_meta_values( 
$key = 'kitchen', 
$type = 'apartments', 
$status = 'publish' ) 
{

global $wpdb;

if( empty( $key ) )
    return;

    $res = $wpdb->get_col( $wpdb->prepare( "
    SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
    LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
    WHERE pm.meta_key = '%s'
    AND p.post_status = '%s'
    AND p.post_type = '%s'
    ", $key, $status, $type ) );

        return $res;
    }

// TV Field Meta Query
function tv_meta_values( 
$key = 'tv', 
$type = 'apartments', 
$status = 'publish' ) 
{

global $wpdb;

if( empty( $key ) )
    return;

    $res = $wpdb->get_col( $wpdb->prepare( "
    SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
    LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
    WHERE pm.meta_key = '%s'
    AND p.post_status = '%s'
    AND p.post_type = '%s'
    ", $key, $status, $type ) );

        return $res;
    }

// DVD Field Meta Query
function dvd_meta_values( 
$key = 'dvd', 
$type = 'apartments', 
$status = 'publish' ) 
{

global $wpdb;

if( empty( $key ) )
    return;

    $res = $wpdb->get_col( $wpdb->prepare( "
    SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
    LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
    WHERE pm.meta_key = '%s'
    AND p.post_status = '%s'
    AND p.post_type = '%s'
    ", $key, $status, $type ) );

        return $res;
    }

// Broadband Field Meta Query
function broadband_meta_values( 
$key = 'broadband', 
$type = 'apartments', 
$status = 'publish' ) 
{

global $wpdb;

if( empty( $key ) )
    return;

    $res = $wpdb->get_col( $wpdb->prepare( "
    SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
    LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
    WHERE pm.meta_key = '%s'
    AND p.post_status = '%s'
    AND p.post_type = '%s'
    ", $key, $status, $type ) );

        return $res;
    }
?>