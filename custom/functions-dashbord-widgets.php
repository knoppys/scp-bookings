<?php
//Add 2 columns layout to the dashboard
function wp_two_columns() {
    add_screen_option(
        'layout_columns',
        array(
            'max'     => 3,
            'default' => 1
        )
    );
}
add_action( 'admin_head-index.php', 'wp_two_columns' );

function scp_bookings_dashboard_widgets() {
/*
	wp_add_dashboard_widget(
                 'upcoming_bookings_dashboard_widget',         	// Widget slug.
                 'Upcoming Bookings',         					// Title.
                 'upcoming_bookings_dashboard_widget_function' 	// Display function.
        );

    wp_add_dashboard_widget(
                 'top_operators_widget',         					// Widget slug.
                 'Top 5 Reports',									      	// Title.
                 'top_5_function' 									// Display function.
        );
  	
  	Remove the dashboar widgets so we can merge the functionality into a single widget.
    wp_add_dashboard_widget(
                 'top_clients_widget',         					// Widget slug.
                 'Top 5 Clients by Total Spend this year',      	// Title.
                 'top_clients_widget_function' 					// Display function.
        );		
    wp_add_dashboard_widget(
                 'top_apartments_widget',         					// Widget slug.
                 'Top 5 Apartments by Total Revenue this year',      	// Title.
                 'top_apartments_widget_function' 					// Display function.
        );
    */
}
add_action( 'wp_dashboard_setup', 'scp_bookings_dashboard_widgets' );

/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function upcoming_bookings_dashboard_widget_function() {

	$today = time();

	$args = array( 
			'post_type' => 	'bookings',
			'posts_per_page' => -1
			);			
		
			// The Query
			$query = new WP_Query( $args );
			
			// The Loop
			if ( $query->have_posts() ) {?>	
			<table style="width:100%;" class="dashboard_widget" id="bookingsdashboard">
				<thead>
					<tr>
						<th>
							<p><strong>Booking Ref</strong></p>
						</th>
						<th>
							<p><strong>Arrival Date</strong></p>
						</th>
						<th>
							<p><strong>Booking Type</strong></p>
						</th>
						<th>
							<p><strong>Operator Name</strong></p>
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

				    //calculate number of nights stay
				    $datetime1 = new DateTime($startdate);
				    $datetime2 = new DateTime($enddate);
				    $interval = $datetime1->diff($datetime2);
				    $numberofnights = $interval->format('%a nights');
					?>				
						
					<?php
					//Get todays date and get a unix timestamp.
					//Get a timestamp from the arrival date
					$today = new DateTime();				
					$timestamp = $today->getTimestamp();	
					$bookingdate = strtotime($startdate);		
					
					//Check to see if the timestamp from the booking date is equal to or greater than 
					//todays date. If it is then it is an upcoming booking, if it is less then, then it is past
					//and should be hidden.
					//if($bookingdate >= $timestamp) { ?>
						<tr>
							<td>
								<h3><?php the_title(); ?></h3>
							</td>
							<td id="arrivaldate-widget">
								<p><span class="arrivaldate-widget-unix"><span style="display:none;"><?php echo strtotime($startdate); ?></span><?php echo $startdate . '<br/>(' . $numberofnights . ')'; ?></p>
							</td>
							<td>
								<p><?php echo $bookingtype; ?></p>
							</td>
							<td>
								<p><?php echo $operatorname; ?></p>
							</td>
							<td>
								<a href="<?php echo get_site_url();?>/wp-admin/post.php?post=<?php echo $ID; ?>&action=edit"><i class="fa fa-file-text" style="padding-right:10px;"></i>Edit</a>
							</td>
						</tr>	
					<?php 
					//} else {
						//do nothing
					//}
					?>
					
					


				<?php }
			} else {
				echo 'no posts found';
			}
			echo '</tbody>';
			echo '</table>';

			// Restore original Post Data
			wp_reset_postdata();
}



function top_5_function() { ?>

<div id="tabs">
	<!--
	<div id="loadingDiv">
	    <i class="fa fa-cog fa-spin"></i> : Wont be a moment.
	</div>
	-->
	<?php
	$startdate 	=  	'1.1.' . date("Y");
	$enddate 	= 	'31.12.' . date("Y");
	?>
	<ul>
		<li><a href="#tabs-1">Top 5 Operators by spend</a></li>
		<li><a href="#tabs-2">Top 5 Clients by spend</a></li>
		<li><a href="#tabs-3">Top 5 Apartments by revenue</a></li>
	</ul>

	<div id="tabs-1">	
	<?php echo '<input type="hidden" class="widefat" name="date19" id="date19" value="' . $startdate . '"/>'; ?>
	<?php echo '<input type="hidden" class="widefat" name="date20" id="date20" value="' . $enddate . '"/>'; ?>
		<button class="page-title-action" id="leaderoperator-dash" >Click here to generate the report</button>
		<div class="leaderdash-operator-div" style="display:none;">             	  
          	<table id="searchresult-operator" cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop leaderdash-operator" width="100%">          	
          		<p class="pleasewait-operator"><i class="fa fa-cog fa-spin"></i> : Generating your report, this may take a few moments.</p>
        	</table>      	
		</div>
	</div>

	<div id="tabs-2">
	<?php echo '<input type="hidden" class="widefat" name="date21" id="date21" value="' . $startdate . '"/>'; ?>
	<?php echo '<input type="hidden" class="widefat" name="date22" id="date22" value="' . $enddate . '"/>'; ?>
		<button class="page-title-action" id="leaderclient-dash" >Click here to generate the report</button>
		<div class="leaderdash-client-div" style="display:none;">             	  
          	<table id="searchresult-client" cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop leaderdash-client" width="100%">          	
          		<p class="pleasewait-client"><i class="fa fa-cog fa-spin"></i> : Generating your report, this may take a few moments.</p>
        	</table>      	
		</div>
	</div>

	<div id="tabs-3">
	<?php echo '<input type="hidden" class="widefat" name="date23" id="date23" value="' . $startdate . '"/>'; ?>
	<?php echo '<input type="hidden" class="widefat" name="date24" id="date24" value="' . $enddate . '"/>'; ?>
		<button class="page-title-action" id="leaderapartments-dash">Click here to generate the report</button>
		<div class="leaderdash-apartment-div" style="display:none;">             	  
          	<table id="searchresult-apartment" cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop leaderdash-apartment" width="100%">          	
          		<p class="pleasewait-apartment"><i class="fa fa-cog fa-spin"></i> : Generating your report, this may take a few moments.</p>
        	</table>      	
		</div>
	</div>

</div>


<?php } ?>