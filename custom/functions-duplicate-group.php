<?php
function rd_duplicate_group_as_draft(){
global $wpdb;

//Get parent post
$parent = get_post( ( $_GET['post'] ) );
$parentID = $parent->ID;

//Get child posts
$childargs = array('post_parent'=>$parent->ID);
$children = get_children($childargs);

//Set the author for the new posts
$current_user = wp_get_current_user();
$new_post_author = $current_user->ID;

//Insert a new parent post
$newparentargs = array(
	'comment_status' => $parent->comment_status,
	'ping_status'    => $parent->ping_status,
	'post_author'    => $new_post_author,
	'post_content'   => $parent->post_content,
	'post_excerpt'   => $parent->post_excerpt,
	'post_name'      => $parent->post_name,
	'post_password'  => $parent->post_password,
	'post_status'    => 'publish',
	'post_title'     => $parent->post_title,
	'post_type'      => $parent->post_type,
	'to_ping'        => $parent->to_ping,
	'menu_order'     => $parent->menu_order
);
$newpostid = wp_insert_post( $newparentargs );

//duplicate parent post meta
$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$parentID");
if (count($post_meta_infos)!=0) {
	$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
	foreach ($post_meta_infos as $meta_info) {
		$meta_key = $meta_info->meta_key;
		$meta_value = addslashes($meta_info->meta_value);
		$sql_query_sel[]= "SELECT $newpostid, '$meta_key', '$meta_value'";
	}
	$sql_query.= implode(" UNION ALL ", $sql_query_sel);
	$wpdb->query($sql_query);
}

update_post_meta($newpostid, 'arrivaldate', '01.01.9999');
update_post_meta($newpostid, 'leavingdate', '01.01.9999');

//Get the new post as an objet
$newparent = get_post($newpostid);

//Insert new child posts with $newparent as the parent ID
$newchildargs = array(
	'comment_status' => $newparent->comment_status,
	'ping_status'    => $newparent->ping_status,
	'post_author'    => $new_post_author,
	'post_content'   => $newparent->post_content,
	'post_excerpt'   => $newparent->post_excerpt,
	'post_name'      => $newparent->post_name,
	'post_parent'    => $newpostid,
	'post_password'  => $newparent->post_password,
	'post_status'    => 'publish',
	'post_title'     => $newparent->post_title,
	'post_type'      => $newparent->post_type,
	'to_ping'        => $newparent->to_ping,
	'menu_order'     => $newparent->menu_order
);

foreach ($children as $child) {
	$newchild = wp_insert_post( $newchildargs );
	$newchildid = get_post($newchild);

	//duplicate child post meta
	$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$parentID");
	if (count($post_meta_infos)!=0) {
		$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
		foreach ($post_meta_infos as $meta_info) {
			$meta_key = $meta_info->meta_key;
			$meta_value = addslashes($meta_info->meta_value);
			$sql_query_sel[]= "SELECT $newchild, '$meta_key', '$meta_value'";
		}
		$sql_query.= implode(" UNION ALL ", $sql_query_sel);
		$wpdb->query($sql_query);
	}

	//update the arrival and leaving date to show at the top of hte list
	update_post_meta($newchild, 'arrivaldate', '01.01.9999');
	update_post_meta($newchild, 'leavingdate', '01.01.9999');
}

wp_redirect( admin_url( 'post.php?post='.$newpostid.'&action=edit' ) );
	
}
add_action( 'admin_action_rd_duplicate_group_as_draft', 'rd_duplicate_group_as_draft' );