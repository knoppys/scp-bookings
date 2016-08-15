<?php
function implement_ajax_getsearchresults() {
	if(isset($_POST['location'])){
		    
		//get the location from the ajax request
			$location = ($_POST['location']);
			//$noofrooms = ($_POST['noofrooms']);
			$noofpeople = ($_POST['noofpeople']);			

		//get the posts that match the location name
			$args = array( 
			'post_type' => 'apartments', 			
			'posts_per_page' => -1,
			'orderby'	=> 'meta_value',
			'order'		=> 'ASC',
			'post_status' => 'publish',
			'meta_query' => array(
				array(
					'key' => 'apptlocation1',
					'value' => $location,
					'compare' => 'LIKE'
					),	
				array(
					'key' => 'sleeps',
					'value' => $noofpeople,
					'compare' => 'LIKE'
					),
			));
		
					
			$query = new WP_Query( $args );

		//send it back as a template
			ob_start(); ?>
			
			<div class="container">				
				<div class="row">
					<div class="col-md-8">
						

						<?php 
						// The Query
						$query = new WP_Query( $args );

						if ( $query->have_posts() ) { 			
							 while ( $query->have_posts() ) { 
								$query->the_post() ; 							
							
								$parking = get_post_meta( get_the_ID(), 'parking', true );    
								$description = get_post_meta( get_the_ID(), 'description', true );   
								$shortdescription = get_post_meta( get_the_ID(), 'shortdescription', true ); 
								$internet = get_post_meta( get_the_ID(), 'internet', true );
								$lift = get_post_meta( get_the_ID(), 'lift', true );
								$bedrooms = get_post_meta( get_the_ID(), 'bedrooms', true );
								$bathrooms = get_post_meta( get_the_ID(), 'bathrooms', true );
								$sleeps = get_post_meta( get_the_ID(), 'sleeps', true );
								$livingroom = get_post_meta( get_the_ID(), 'livingroom', true );
								$diningroom = get_post_meta( get_the_ID(), 'diningroom', true );
								$kitchen = get_post_meta( get_the_ID(), 'kitchen', true );
								$tv = get_post_meta( get_the_ID(), 'tv', true );
								$dvd = get_post_meta( get_the_ID(), 'dvd', true );
								$broadband = get_post_meta( get_the_ID(), 'broadband', true );					    
								$rating = get_post_meta( get_the_ID(), 'rating', true );					    
								$housekeeping = get_post_meta( get_the_ID(), 'housekeeping', true );
								$laundry = get_post_meta( get_the_ID(), 'laundry', true );
								$reception = get_post_meta( get_the_ID(), 'reception', true );
								$location = get_post_meta(get_the_ID(), 'apptlocation1', true); 
								?>

								<div class="row apartment">
									<div class="col-md-12">
										
										<div class="row">
											<div class="col-sm-4 apartment-image">
												<?php 
												if(has_post_thumbnail()){
													the_post_thumbnail('medium');
												} else {
													echo '<img style="height:144px;" src="' . get_template_directory_uri() . '/images/camera-icon-md.png" />';
												}
												 ?>
												<a class="btn btn-primary" href="<?php the_permalink(); ?>">More</a>	
											</div>
											<div class="col-sm-8 apartment-info">
												<div class="row">
													<div class="col-md-12">
														<h3 class="apartment-title"><?php the_title(); ?></h3>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-5">
														<ul class="facilities">
															<?php if( ! empty( $sleeps ) ) { echo '<li><i class="fa fa-users" style="padding-right:10px;"></i>Sleeps ' . $sleeps . '</li>'; } ?>
															<?php if( ! empty( $bedrooms ) ) { echo '<li><i class="fa fa-bed" style="padding-right:10px;"></i>' . $bedrooms . ' Bedrooms</li>'; } ?>
															<?php if( ! empty( $tv ) ) { echo '<i class="fa fa-desktop" style="padding-right:10px;"></i>' . $tv . '</li>'; } ?>
															<?php if( ! empty( $dvd ) ) { echo '<li><i class="fa fa-youtube-play" style="padding-right:10px;"></i>' . $dvd . '</li>'; } ?>
															<?php if( ! empty( $housekeeping ) ) { echo '<li><i class="fa fa-check-square" style="padding-right:10px;"></i>' . $housekeeping . '</li>'; } ?>					
														</ul>
														<?php
															if ( $rating == '1' ){
																echo '<div class="facilities rating">Rating<i class="fa fa-star"></i></div>';
															} 	elseif ( $rating == '2') {
																	echo '<div class="facilities rating">Rating : <i class="fa fa-star"></i><i class="fa fa-star"></i></div>';
															}  	elseif ( $rating == '3') {
																	echo '<div class="facilities rating">Rating : <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>';
															}	elseif ( $rating == '4') {
																	echo '<div class="facilities rating">Rating : <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>';
															}	elseif ( $rating == '5') {
																	echo '<div class="facilities rating">Rating : <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>';
															}
														?>
													</div>
													<div class="col-sm-5">
														<ul class="facilities">											
															<?php if( ! empty( $reception ) ) { echo '<li><i class="fa fa-user-plus" style="padding-right:10px;"></i>' . $reception . '</li>'; } ?>
															<?php if( ! empty( $kitchen ) ) { echo '<li><i class="fa fa-cutlery" style="padding-right:10px;"></i>' . $kitchen . '</li>'; } ?>
															<?php if( ! empty( $parking ) ) { echo '<li><i class="fa fa-car" style="padding-right:10px;"></i>' . $parking . '</li>'; } ?>
															<?php if( ! empty( $lift ) ) { echo '<li><i class="fa fa-wheelchair" style="padding-right:10px;"></i>' . $lift . '</li>'; } ?>
															<?php if( ! empty( $laundry ) ) { echo '<li><i class="fa fa-cog" style="padding-right:10px;"></i>' . $laundry . '</li>'; } ?>
														</ul>
														
													</div>
												</div>									
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 description">									
												<p> 
												<?php echo $shortdescription; ?>
												</p>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>

						
						<?php page_navi(); ?>
						<?php  } else {	echo 'Sorry but no apartments were found'; } ?> 	
						<?php wp_reset_postdata(); ?>


					</div>
					<div class="col-md-4">
						<aside>
							<?php get_template_part('sidebar'); ?>
						</aside>
					</div>
				</div>
			</div>


			
			<?php $data = ob_get_clean();
			echo $data;

			die();
		} 
	}
add_action('wp_ajax_getsearchresults', 'implement_ajax_getsearchresults');
add_action('wp_ajax_nopriv_getsearchresults', 'implement_ajax_getsearchresults'); 
?>