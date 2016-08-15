<?php

/**
Add sub menu page for listing apartmnets as the default page isnt comprehensive enough
**/

function Locationslistings_callback() { 

			//get all the required information for the query builder. 
			global $post; 
			echo '<div class="wrap">';
			echo '<h2>Locations</h1>';
			echo '<div class="apartments-button"><a href="' . site_url() . '/wp-admin/post-new.php?post_type=locations" class="page-title-action">Add Location</a></div>';

			$args = array ('post_type'=>'locations','posts_per_page' => -1);
			$Locationsquery = new WP_Query( $args );


			//get the Locations
			if ( $Locationsquery->have_posts() ) { ?>			
				<table  cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop dashboard_widget">
					<thead>
						<tr>
							<th>
								<strong><p><i class="fa fa-user"></i>Location Name</p></strong>
							</th>
							<th>
								<strong><p><i class="fa fa-user"></i>Numbmer of apartments</p></strong>
							</th>	
																			
						</tr>
					</thead>
				<tbody>
				<?php while ( $Locationsquery->have_posts() ) { $Locationsquery->the_post(); ?>

				<tr>
					<?php $locationname = get_the_title(); ?>
					<td><a href="<?php echo get_site_url(); ?>/wp-admin/post.php?post=<?php echo get_the_id(); ?>&action=edit"><?php echo $locationname; ?></a></td>
					<td>
						<?php
						// WP_Query arguments
						$args = array (
							'post_type'             => array( 'apartments' ),
							'posts_per_page'        => -1,
							'meta_query'			=> array(
									array(
										'key'	=>	'apptlocation1',
										'value'	=>	$locationname,
										),
								)
						);

						// The Query
						$apartmentcount = new WP_Query( $args );
						echo $apartmentcount->found_posts;
						?>
					</td>							
				</tr>
				
				<?php } } else {/*leave for now*/} 
				echo '</tbody>';
				echo '</table>';
				echo '</div>';

				wp_reset_postdata();
	
 }


 

?>