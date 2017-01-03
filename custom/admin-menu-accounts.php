<?php
function accountslistings_callback(){
	function ignore_divide_by_zero($errno, $errstring){
		return ($errstring == 'Division by zero');}
		set_error_handler('ignore_divide_by_zero', E_WARNING);
		global $post; 
		echo '<div class="wrap">';
		echo '<h2>SCP Bookings</h2>';
		echo '<h3>Accounts</h3>';
		$args = array (
			'post_type'	=>'bookings',
			'posts_per_page'	=> '-1',
		);
		$apartmentsquery = new WP_Query( $args );
			//get the apartments
		if ( $apartmentsquery->have_posts() ) { ?>
			<table style="width:100%;" class="accountstable postbox">

				<thead>
					<tr>
						<th>
							<strong><p></i>Guest<br>Name</p></strong>
						</th>
						<th>
							<strong><p></i>Check<br>In</p></strong>
						</th>
						<th>
							<strong><p></i>Nights</p></strong>
						</th>
						<th>
							<strong><p></i>Property</p></strong>
						</th>
						<th>
							<strong><p></i>Guests</p></strong>
						</th>
						<th>
							<strong><p></i>Client Name</p></strong>
						</th>
						<th>
							<strong><p></i>Price<br>Per<br>Night</p></strong>
						</th>
						<th>
							<strong><p></i>Price<br>(Gross)</p></strong>
						</th>
						<th>
							<strong><p></i>Category</p></strong>
						</th>
						<th>
							<strong><p></i>Operator</p></strong>
						</th>
						<th>
							<strong><p></i>Operator<br>PPN</p></strong>
						</th>						
						<th>
							<strong><p></i>Operator<br>Price</p></strong>
						</th>
					</tr>

				</thead>
				<tbody>
				<?php  while ( $apartmentsquery->have_posts() ) { $apartmentsquery->the_post(); 						

						//get the number of nights
						if (get_post_meta($post->ID, 'numberofnights', true)) {
						    $numberofnights = get_post_meta($post->ID, 'numberofnights', true);
						} else {
							$datetime1 = new DateTime(get_post_meta($post->ID, 'arrivaldate', true));
							$datetime2 = new DateTime(get_post_meta($post->ID, 'leavingdate', true));
							$interval = $datetime1->diff($datetime2);	
							$numberofnights = $interval->format('%a nights');
						}
						
						$refid = get_post_meta($post->ID, 'refid', true);
						
						$arrivaldate = get_post_meta($post->ID, 'arrivaldate', true);
						$guestname = get_post_meta($post->ID, 'guestname', true);
						$apartment = get_post_meta($post->ID, 'apartmentname', true);
						$bookingtype = get_post_meta($post->ID, 'bookingtype', true);
						$noofguests = get_post_meta($post->ID, 'numberofguests', true);
						
						$ownerprice = get_post_meta($post->ID, 'ownerprice', true);
						if($bookingtype == 'Corporate') {                                                       
							$ppn = get_post_meta($post->ID, 'rentalprice', true);
						} elseif ($bookingtype == 'Groups' || ($bookingtype == 'Leisure')) {				                       
							$ppn = get_post_meta($post->ID, 'priceperperson', true);
						}
						$priceanight = $ppn;	
						$totalcost = get_post_meta( $post->ID, 'totalcost', true);
						$pricepnowner = $ownerprice / $numberofnights;
						$operatorname = get_post_meta( $post->ID, 'operatorname', true );
						$clientname = get_post_meta( $post->ID, 'clientname', true );
						$operatorobject = get_page_by_title( $operatorname, OBJECT, 'operators' );
						$clientname = get_post_meta( $post->ID, 'clientname', true );
						if (!empty(get_post_meta( $post->ID, 'actualcheckintime', true ))) {
							$checkintime = get_post_meta($post->ID,'actualcheckintime',true);
						} else {
							$checkintime = get_post_meta($post->ID,'checkintime',true);
						}
						if (!empty(get_post_meta( $post->ID, 'actualcheckouttime', true ))) {
							$checkouttime = get_post_meta($post->ID,'actualcheckouttime',true);
						} else {
							$checkouttime = get_post_meta($post->ID,'checkouttime',true);
						}
						
						$clientobject = get_page_by_title( $clientname, OBJECT, 'clients' );	
						?>
						<tr>
							<td>
								<a href="<?php echo get_site_url(); ?>/wp-admin/post.php?post=<?php echo get_the_id(); ?>&action=edit"><?php echo $guestname; ?></a>
							</td>
					
							<td><?php echo $arrivaldate;?></td>
					
							<td><?php echo $numberofnights;?></td>
		
							<td><a href="<?php echo get_site_url(); ?>/wp-admin/post.php?post=<?php echo get_the_id(); ?>&action=edit"><?php echo $apartment; ?></a></td>
		
							<td style="text-align:center;"><?php echo $noofguests;?></td>
	
							<td><a href="<?php echo get_site_url(); ?>/wp-admin/post.php?post=<?php echo $clientobject->ID; ?>&action=edit"><?php echo $clientname; ?></a></td>								
				
							<td class="pound"><?php echo $priceanight; ?></td>
							
			
							<td class="pound"><?php echo $totalcost; ?></td>
	
							<td><?php echo $bookingtype;?></td>

							<td><a href="<?php echo get_site_url(); ?>/wp-admin/post.php?post=<?php echo $operatorobject->ID; ?>&action=edit"><?php echo $operatorname; ?></a></td>
							
							<td class="pound"><?php echo substr ($pricepnowner, 0, 5); ?></td>	

							<td class="pound"><?php echo $ownerprice; ?></td>
						</tr>
				
				<?php } } else {}
}?>