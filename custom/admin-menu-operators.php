<?php

/**
Add sub menu page for listing apartmnets as the default page isnt comprehensive enough
**/

function operatorslistings_callback() { 

			//get all the required information for the query builder. 
			global $post; 
			echo '<div class="wrap">';
			echo '<h2>Operators</h1>';
			echo '<div class="apartments-button"><a href="' . site_url() . '/wp-admin/post-new.php?post_type=operators" class="page-title-action">Add Operator</a></div>';

			$args = array ('post_type'=>'operators','posts_per_page' => -1);
			$operatorsquery = new WP_Query( $args );


			//get the operators
			if ( $operatorsquery->have_posts() ) { ?>			
				<table  cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop dashboard_widget">
					<thead>
						<tr>
							<th>
								<strong><p>Operator Name</p></strong>
							</th>
							<th>
								<strong><p>Operator Contact</p></strong>
							</th>
							<th>
								<strong><p>Operator Phone Number</p></strong>
							</th>
							<th>
								<strong><p>Operator Mobile Number</p></strong>
							</th>	
							<th>
								<strong><p>Operator Email Address</p></strong>
							</th>
							<th>
								<strong><p>Operator Address</p></strong>
							</th>
																			
						</tr>
					</thead>
				<tbody>
				<?php while ( $operatorsquery->have_posts() ) { $operatorsquery->the_post(); ?>

				<tr>
					<?php $operatorname = get_the_title(); ?>
					<td><a href="<?php echo get_site_url(); ?>/wp-admin/post.php?post=<?php echo get_the_id(); ?>&action=edit"><?php echo $operatorname; ?></a></td>
					<td>
						<?php echo get_post_meta($post->ID , 'operatorcontact' , true); ?>
					</td>
					<td>
						<?php echo get_post_meta($post->ID,'operatorphone', true); ?>
					</td>							
					<td>
						<?php echo get_post_meta($post->ID,'operatormobile', true); ?>
					</td>
					<td>
						<a href="mailto:<?php echo get_post_meta($post->ID,'operatoremail', true); ?>"><?php echo get_post_meta($post->ID,'operatoremail', true); ?></a>
					</td>
					<td>
						<?php echo get_post_meta($post->ID,'operatoraddress', true); ?>
					</td>
				</tr>
				
				<?php } } else {/*leave for now*/} 
				echo '</tbody>';
				echo '</table>';
				echo '</div>';

				wp_reset_postdata();
	
 }


 

?>