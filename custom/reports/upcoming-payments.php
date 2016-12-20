<?php
/**
**********************************
Upcoming Payments Tab
**********************************
**/
function implement_ajax_paymentssearch() {

//set the date
if ( ($_POST['startdate']) ) {
	$startdate = ($_POST['startdate']);
} else {
	$startdate = '01.01.1970';
}

if ( ($_POST['enddate']) ) {
	$enddate = ($_POST['enddate']);
} else {
	$enddate = '31.12.3000';
}



$datestring = join(',',dateRange($startdate, $enddate));

$args = array( 
	'post_type' => 'bookings',
	'meta_key' => 'arrivaldate',
	'meta_value' => $datestring,
	'meta_compare' => 'IN',
	'posts_per_page' => -1				
);


// The Query
$query = new WP_Query( $args );
ob_start();
// The Loop
if ( $query->have_posts() ) {?>	
	<thead>
		<tr>
			<th>
				<p><strong>Arrival Date</strong></p>
			</th>
			<th>
				<p><strong>Booking Ref</strong></p>
			</th>
			<th>
				<p><strong>Operator Name</strong></p>
			</th>
			<th>
				<p><strong>Client Name</strong></p>
			</th>						
			<th>
				<p><strong>Apartment Name</strong></p>
			</th>
			<th>
				<p><strong>Location</strong></p>
			</th>
			<th>
				<p><strong>Total Cost</strong></p>
			</th>
			<th>
				<p><strong>Deposit</strong></p>
			</th>
			<th>
				<p><strong>Deposit Due Date</strong></p>
			</th>
			<th>
				<p><strong>Current Balance Due</strong></p>
			</th>
			<th>
				<p><strong>Balance Due Date</strong></p>
			</th>
			<th>
				<p><strong>Apartment Due</strong></p>
			</th>
			<th>
				<p><strong>Apartment Due Date</strong></p>
			</th>
			<th class="options">
				<p><strong>Options</strong></p>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php while ( $query->have_posts() ) {

		$query->the_post(); 
		$ID = get_the_ID();
		$booking = get_post_meta($ID);

		//get the id
		$ID = get_the_ID();
		//get the post meta
	    $totalcost = $balancedue + $deposit;

	    //calculate number of nights stay
	    $startdate = $booking['arrivaldate'][0];
	    $enddate = $booking['leavingdate'][0]; 
	    $datetime1 = new DateTime($startdate);
	    $datetime2 = new DateTime($enddate);
	    $interval = $datetime1->diff($datetime2);
	    $numberofnights = $interval->format('%a nights');
		?>
	
		
			<tr>
				<td>
					<p><?php echo $booking['arrivaldate'][0]; ?></p>
				</td>
				<td>
					<p><?php echo $post->post_title; ?></p>
				</td>
				<td>
					<p><?php echo $booking['operatorname'][0]; ?></p>
				</td>
				<td>
					<p><?php echo $booking['clientname'][0]; ?></p>
				</td>
				<td>
					<p><?php echo $booking['apartmentname'][0]; ?></p>
				</td>
				<td>
					<?php $page = get_page_by_title( $booking['apartmentname'][0], $output, 'apartments' ); ?>
					<p><?php echo get_post_meta($page->ID, 'apptlocation1', true); ?></p>
				</td>
				<td style="text-align:right;">
					<p><strong>£ &nbsp;<?php echo $totalcost; ?></strong></p>
				</td>
				<td style="text-align:right;">
				<?php
				if ($booking['depositpaid'][0] == "Yes") {
					echo '<p style="color:green;">';
					echo '£&nbsp' . $booking['deposit'][0];
					echo '</p>';
				} elseif ( ($booking['depositpaid'][0] == "No") || ($booking['depositpaid'][0] == "") ) {
					echo '<p style="color:red;">';
					echo '£&nbsp' . $booking['deposit'][0];
					echo '</p>';
				}							
				?>
				</td>
				<td>
					<p><?php echo $booking['depositdate'][0]; ?></p>
				</td>
				<td style="text-align:right;">
				<?php
				if ($booking['balancepaid'][0] == "Yes") {
					echo '<p style="color:green;">';
					echo '£&nbsp' . $booking['balancedue'][0];
					echo '</p>';
				} elseif ( ($booking['balancepaid'][0] == "No") || ($booking['balancepaid'][0] == "") ) {
					echo '<p style="color:red;">';
					echo '£&nbsp' . $booking['balancedue'][0];
					echo '</p>';
				}							
				?>
				</td>
				<td>
					<p><?php echo $booking['balanceduedate'][0]; ?></p>
				</td>
				<td style="text-align:right;">
				<?php
				if ($booking['apartmentpaid'][0] == "Yes") {
					echo '<p style="color:green;">';
					echo '£&nbsp' . $booking['apartmentpaid'][0];
					echo '</p>';
				} elseif ( ($booking['apartmentpaid'][0] == "No") || ($booking['apartmentpaid'][0] == "") ) {
					echo '<p style="color:red;">';
					echo '£&nbsp' . $booking['balancedue'][0];
					echo '</p>';
				}							
				?>
				</td>
				<td>
					<p><?php echo $booking['balanceduedate'][0]; ?></p>
				</td>

				
				<td class="options">
					<a href="<?php echo get_site_url();?>/wp-admin/post.php?post=<?php echo $ID ;?>&action=edit"><i class="fa fa-file-text" style="padding-right:10px;"></i></a>
				</td>
			</tr>
			


	<?php }
} else {
	echo 'no posts found';
}
echo '</tbody>'; 
// Restore original Post Data
wp_reset_postdata();

$content = ob_get_clean();

echo $content;

die();
	
}

add_action('wp_ajax_paymentsquery', 'implement_ajax_paymentssearch');
add_action('wp_ajax_nopriv_paymentsquery', 'implement_ajax_paymentssearch');