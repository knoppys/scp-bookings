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

		//get the id
		$ID = get_the_ID();
		//get the post meta
	    $startdate = get_post_meta( $ID, 'arrivaldate', true );
	    $enddate = get_post_meta( $ID, 'leavingdate', true );   
	    $bookingtype = get_post_meta( $ID, 'bookingtype', true); 
	    $operatorname = get_post_meta( $ID, 'operatorname', true);
	    $balancedue = get_post_meta($ID, 'balancedue', true);
	    $apartmentname = get_post_meta($ID, 'apartmentname', true);
	    $deposit = get_post_meta($ID, 'deposit', true);
	    $costcode = get_post_meta($ID, 'costcode', true);
	    $depositpaid = get_post_meta($ID, 'depositpaid', true);
	    $balancepaid = get_post_meta($ID, 'balancepaid', true);
	    $clientname = get_post_meta($ID, 'clientname', true);
	    $depositdate = get_post_meta($ID ,'depositdate', true);
	    $apartmentduedate = get_post_meta($ID, 'apartmentduedate');
	    $balanceduedate = get_post_meta($ID, 'balanceduedate', true); 
	    $totalcost = $balancedue + $deposit;

	    //calculate number of nights stay
	    $startdate = get_post_meta( $ID, 'arrivaldate', true );
	    $enddate = get_post_meta( $ID, 'leavingdate', true ); 
	    $datetime1 = new DateTime($startdate);
	    $datetime2 = new DateTime($enddate);
	    $interval = $datetime1->diff($datetime2);
	    $numberofnights = $interval->format('%a nights');
		?>
	
		
			<tr>
				<td>
					<p><?php the_title(); ?></p>
				</td>
				<td>
					<p><?php echo $operatorname; ?></p>
				</td>
				<td>
					<p><?php echo $clientname; ?></p>
				</td>
				<td>
					<p><?php echo $apartmentname; ?></p>
				</td>
				<td style="text-align:right;">
					<p><strong>£ &nbsp;<?php echo $totalcost; ?></strong></p>
				</td>
				<td style="text-align:right;">
				<?php
				if ($depositpaid == "Yes") {
					echo '<p style="color:green;">';
					echo '£&nbsp' . $deposit;
					echo '</p>';
				} elseif ( ($depositpaid == "No") || ($depositpaid == "") ) {
					echo '<p style="color:red;">';
					echo '£&nbsp' . $deposit;
					echo '</p>';
				}							
				?>
				</td>
				<td>
					<p><?php echo $depositdate; ?></p>
				</td>
				<td style="text-align:right;">
				<?php
				if ($balancepaid == "Yes") {
					echo '<p style="color:green;">';
					echo '£&nbsp' . $balancedue;
					echo '</p>';
				} elseif ( ($balancepaid == "No") || ($balancepaid == "") ) {
					echo '<p style="color:red;">';
					echo '£&nbsp' . $balancedue;
					echo '</p>';
				}							
				?>
				</td>
				<td>
					<p><?php echo $balanceduedate; ?></p>
				</td>
				<td style="text-align:right;">
				<?php
				if ($apartmentpaid == "Yes") {
					echo '<p style="color:green;">';
					echo '£&nbsp' . $apartmentpaid;
					echo '</p>';
				} elseif ( ($apartmentpaid == "No") || ($apartmentpaid == "") ) {
					echo '<p style="color:red;">';
					echo '£&nbsp' . $balancedue;
					echo '</p>';
				}							
				?>
				</td>
				<td>
					<p><?php echo $balanceduedate; ?></p>
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