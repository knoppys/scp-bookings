<?php

function apartmentslistings_callback() { 

			//get all the required information for the query builder. 
			global $post; 
			echo '<div class="wrap">';
			echo '<h2>Apartments</h1>';
			echo '<div class="apartments-button"><a href="' . site_url() . '/wp-admin/post-new.php?post_type=apartments" class="page-title-action">Add Apartment</a></div>';

			$args = array ('post_type'=>'apartments','posts_per_page' => -1);
			$apartmentsquery = new WP_Query( $args );

			//get the apartments
			if ( $apartmentsquery->have_posts() ) { ?>			
				<table  cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop dashboard_widget">
					<thead>
						<tr>
							<th>
								<strong><p><i class="fa fa-calendar"></i>Published / Modified Date</p></strong>
							</th>
							<th>
								<strong><p><i class="fa fa-user"></i>Apartment Name</p></strong>
							</th>
							<th>
								<strong><p><i class="fa fa-user"></i>Location 1</p></strong>
							</th>
							<th>
								<strong><p><i class="fa fa-user"></i>Location 2</p></strong>
							</th>
							<th>
								<strong><p><i class="fa fa-user"></i>Apartment Status</p></strong>
							</th>
							<th>
								<strong><p><i class="fa fa-user"></i>Operator</p></strong>
							</th>
							<th>
								<strong><p><i class="fa fa-user"></i>Operator Phone</p></strong>
							</th>	
							<th class="options">
								<p><strong>Options</strong></p>
							</th>						
						</tr>
					</thead>
				<tbody>
				<?php while ( $apartmentsquery->have_posts() ) { $apartmentsquery->the_post(); 
				
					$operatorname = get_post_meta( $post->ID, 'operatorname', true );
					$location1 = get_post_meta( $post->ID, 'apptlocation1', true );	
					$location2 = get_post_meta( $post->ID, 'apptlocation2', true );		
					$operatorphone = get_post_meta( $post->ID, 'operatorphone', true);			
					?>

				<tr>
					<td><?php the_modified_date(); ?></td>
					<td><a href="<?php echo get_site_url(); ?>/wp-admin/post.php?post=<?php echo get_the_id(); ?>&action=edit"><?php the_title(); ?></a></td>
					<td><?php echo $location1;?></td>
					<td><?php echo $location2;?></td>
					<td><?php echo get_post_status( $post->ID ); ?></td>
					<td><?php echo $operatorname; ?></td>
					<td><?php echo $operatorphone; ?></td>	
					<td>
						<a href="<?php echo get_site_url() .'/?post_type=apartments&p='.get_the_id(); ?>" target="_blank"><i class="fa fa-file-text" style="padding-right:10px;"></i>View</a>
					</td>			
				</tr>
				
				<?php } } else {/*leave for now*/} 
				echo '</tbody>';
				echo '</table>';
				echo '</div>';

				wp_reset_postdata();
	
 } 

?>