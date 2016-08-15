<?php

/**
Add sub menu page for listing reseller pages as the default page isnt comprehensive enough
**/


function resellerp_callback() { 

			//get all the required information for the query builder. 
			global $post; 
			echo '<div class="wrap">';
			echo '<h2>Reseller Pages</h1>';
			echo '<div class="apartments-button"><a href="/wp-admin/post-new.php?post_type=resellerp" class="page-title-action">Add Reseller Page</a></div>';

			$args = array ('post_type'=>'resellerp','posts_per_page' => -1);
			$resellerquery = new WP_Query( $args );


			//get the operators
			if ( $resellerquery->have_posts() ) { ?>			
				<table  cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop dashboard_widget">
					<thead>
						<tr>
							<th>
								<strong><p><i class="fa fa-user"></i>Reseller Name</p></strong>
							</th>																		
						</tr>
					</thead>
				<tbody>
				<?php while ( $resellerquery->have_posts() ) { $resellerquery->the_post(); ?>

				<tr>
					<?php $resellername = get_the_title(); ?>
					<td><a href="<?php echo get_site_url(); ?>/wp-admin/post.php?post=<?php echo get_the_id(); ?>&action=edit"><?php echo $resellername; ?></a></td>										
				</tr>
				
				<?php } } else {/*leave for now*/} 
				echo '</tbody>';
				echo '</table>';
				echo '</div>';

				wp_reset_postdata();
	
 }


 

?>