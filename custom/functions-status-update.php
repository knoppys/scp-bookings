<?php
// Scheduled Action Hook
function update_archive_status( ) {

	$args=array('post_type'=>'bookings','post_status'=>array('publish','draft'));
	$knoposts = get_posts( $args );
	foreach ( $knoposts as $knopost ) {

		$leavingdate = strtotime(get_post_meta($knopost->ID,'leavingdate',true ));
		$today = time();


		if ($leavingdate <= $today) {

			$post = array(
			'ID' => $knopost->ID,
			'post_status' => 'archive',
			);
			wp_update_post($post);
			
		};	
		
	
	}

}

// Schedule Cron Job Event
function update_status() {
	if ( ! wp_next_scheduled( 'update_archive_status' ) ) {
		wp_schedule_event( time(), 'daily', 'update_archive_status' );
	}
}
add_action( 'wp', 'update_status' );