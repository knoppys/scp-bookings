<?php

function welcomepacks_callback() { 

			//get all the required information for the query builder. 
			global $post; 
			echo '<div class="wrap">';
			echo '<h2>Welcome Packs</h1>';
			echo '<div class="welcomepacks-button"><a href="' . site_url() . '/wp-admin/post-new.php?post_type=welcomepacks" class="page-title-action">Add Welcome Pack</a></div>';

			$args = array ('post_type'=>'welcomepacks','posts_per_page' => -1);
			$welcomepacksquery = new WP_Query( $args );

			//get the welcomepacks
			if ( $welcomepacksquery->have_posts() ) { ?>			
				<table  cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop dashboard_widget">
					<thead>
						<tr>
							<th>
								<strong><p><i class="fa fa-user"></i>Pack Name</p></strong>
							</th>
							<th class="options">
								<p><strong>Options</strong></p>
							</th>						
						</tr>
					</thead>
				<tbody>
				<?php while ( $welcomepacksquery->have_posts() ) { $welcomepacksquery->the_post(); ?>

				<tr>
					<td><a href="<?php echo get_site_url(); ?>/wp-admin/post.php?post=<?php echo get_the_id(); ?>&action=edit"><?php the_title(); ?></a></td>					
					<td>
						<a href="<?php the_permalink(); ?>" target="_blank"><i class="fa fa-file-text" style="padding-right:10px;"></i>View</a>
					</td>			
				</tr>
				
				<?php } } else {/*leave for now*/} 
				echo '</tbody>';
				echo '</table>';
				echo '</div>';

				wp_reset_postdata();
	
 } 

?>