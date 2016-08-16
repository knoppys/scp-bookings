<?php

/**
Add sub menu page for listing city guides as the default page isnt comprehensive enough
**/


function cityguides_callback() { 

			//get all the required information for the query builder. 
			global $post; 
			echo '<div class="wrap">';
			echo '<h2>City Guides</h1>';
			echo '<div class="apartments-button"><a href="' . site_url() . '/wp-admin/post-new.php?post_type=cityguides" class="page-title-action">Add City Guide</a></div>';

			$args = array ('post_type'=>'cityguides','posts_per_page' => -1);
			$cityguidesquery = new WP_Query( $args );


			//get the operators
			if ( $cityguidesquery->have_posts() ) { ?>			
				<table  cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop dashboard_widget">
					<thead>
						<tr>
							<th>
								<strong><p><i class="fa fa-user"></i>Guide Name</p></strong>
							</th>																										
						</tr>
					</thead>
				<tbody>
				<?php while ( $cityguidesquery->have_posts() ) { $cityguidesquery->the_post(); ?>

				<tr>
					<?php $cityguidename = get_the_title(); ?>
					<td><a href="<?php echo get_site_url(); ?>/wp-admin/post.php?post=<?php echo get_the_id(); ?>&action=edit"><?php echo $cityguidename; ?></a>
					</td>					
				</tr>
				
				<?php } } else {/*leave for now*/} 
				echo '</tbody>';
				echo '</table>';
				echo '</div>';

				wp_reset_postdata();
	
 }


 

?>