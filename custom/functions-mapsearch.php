<?php

/**
Title of the function and what it does
**/

function implement_ajax_postcodesearch() {
	if(isset($_POST['postcode'])) {	

		$postcode = ($_POST['postcode']);	
		$postcodes = array();

		// WP_Query arguments
		$args = array(
			'post_type' => 'apartments',
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key'     => 'postcode',
					'value'   => $postcode.' ',
					'compare' => 'LIKE',
				),
			),
			
		);

		// The Query
		$query = new WP_Query( $args );

		// The Loop
		if ( $query->have_posts() ) { while ( $query->have_posts() ) { $query->the_post();
				
				$id = get_the_id();
				$apartment = get_post_meta($id);
				$title = get_the_title();
				$link = get_permalink();
				
				$apartments[] = array(		
						"postcode" => $apartment['postcode'][0],	
						"title" => $title,			
						"address" => $apartment['address'][0].' '.$apartment['postcode'][0],			
						"url" => $link,								
						"info" => 'Beds: '.$apartment['bedrooms'][0].'<br>Sleeps: '.$apartment['sleeps'][0],
					);

			}
		} 

		// Restore original Post Data
		wp_reset_postdata();

		//$array = array('postcodes' => $postcodes);

	    $data = json_encode($apartments);    
		
		echo $data;
		//var_dump($data);

	    die();
	}
}
add_action('wp_ajax_postcodesearch', 'implement_ajax_postcodesearch');
add_action('wp_ajax_nopriv_postcodesearch', 'implement_ajax_postcodesearch');
