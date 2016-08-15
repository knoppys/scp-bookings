<?php

/**
Add sub menu page for listing apartmnets as the default page isnt comprehensive enough
**/

function clientlistings_callback() { 

			//get all the required information for the query builder. 
			global $post; 
			echo '<div class="wrap">';
			echo '<h2>Clients</h1>';
			echo '<div class="apartments-button"><a href="' . site_url() . '/wp-admin/post-new.php?post_type=clients" class="page-title-action">Add Client</a></div>';

			$args = array ('post_type'=>'clients','posts_per_page' => -1);
			$clientquery = new WP_Query( $args );


			//get the Locations
			if ( $clientquery->have_posts() ) { ?>			
				<table  cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop dashboard_widget">
					<thead>
						<tr>
							<th>
								<strong><p><i class="fa fa-user"></i>Client Name</p></strong>
							</th>
							<th>
								<strong><p><i class="fa fa-user"></i>Contact Name</p></strong>
							</th>
							<th>
								<strong><p><i class="fa fa-phone"></i>Client Telephone</p></strong>
							</th>	
							<th>
								<strong><p><i class="fa fa-envelope"></i>Client Email</p></strong>
							</th>										
						</tr>
					</thead>
				<tbody>
				<?php while ( $clientquery->have_posts() ) { $clientquery->the_post(); ?>

				<tr>					
					<td><a href="<?php echo get_site_url(); ?>/wp-admin/post.php?post=<?php echo get_the_id(); ?>&action=edit"><?php the_title(); ?></a></td>
					<td><?php echo get_post_meta($post->ID, 'clientcontact', true); ?></td>	
					<td><?php echo get_post_meta($post->ID, 'clientphone', true); ?></td>	
					<td><?php echo get_post_meta($post->ID, 'clientemail', true); ?></td>							
				</tr>
				
				<?php } } else {/*leave for now*/} 
				echo '</tbody>';
				echo '</table>';
				echo '</div>';

				wp_reset_postdata();
	
 }


 

?>