<?php
/**
Show up coming bookings with some filter options
**/

function upcomingbookings_callback() {
	
	//get the operators
	$operatorargs = array('post_type'=>'Operators','posts_per_page'   => -1,'orderby' => 'title', 'order' => 'ASC');
	$operatornames = get_posts($operatorargs);
	//get the apartments
	$apartmentargs = array('post_type'=>'apartments','posts_per_page'   => -1,'orderby' => 'title', 'order' => 'ASC');
	$apartmentnames = get_posts($apartmentargs);
	//get the bookings
	$bookingsargs = array('post_type'=>'bookings','posts_per_page'   => -1,'orderby' => 'title', 'order' => 'ASC');
	$bookingsnames = get_posts($bookingsargs);
	//get the clients
	$clientargs = array('post_type'=>'clients','posts_per_page'   => -1,'orderby' => 'title', 'order' => 'ASC');
	$clientnames = get_posts($clientargs);
	//get the locations
	$locationsargs = array('post_type'=>'Locations','posts_per_page'   => -1,'orderby' => 'title', 'order' => 'ASC');
	$locationnames = get_posts($locationsargs);


?>
 <table cellpadding="0" cellspacing="0" border="0" class="bookings-admin" >
     <tbody>
         <td>

            <table cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop container-table" width="100%">            
                <tbody>
                <tr><th><h2><i class="fa fa-search"></i>Reports Filter</h2><br><p>Please ensure you refresh your page before generating another report.</p></th></tr>
                    <tr>
                        <td>
                            <div id="tabs">
                                <ul>
                                    <li><a href="#tab1"><i class="fa fa-book"></i>Upcoming Bookings</a></li>
                                    <li><a href="#tab2"><i class="fa fa-gbp"></i>Upcoming Payments</a></li>
                                    <li><a href="#tab3"><i class="fa fa-user"></i>Client Reports</a></li>
                                    <li><a href="#tab4"><i class="fa fa-user"></i>Operator Reports</a></li>
                                    <li><a href="#tab5"><i class="fa fa-trophy"></i>Leader Boards</a></li>    
                                             
                                </ul>
                                <div id="tab1"> 
                                	<?php
		                            //date 1 field
		                            echo '<label for="date11">';
		                                _e( 'Start Date');
		                            echo '</label>';
		                            echo '<input type="text" class="widefat" name="date11" id="date11" />';
		                            ?>  
		                           	<div style="padding:20px 0">
		                            	<button class="wp-core-ui button-primary" id="searchquery">Ok now search!</button>
		                            </div>
	                            </div>
	                            
                                <div id="tab2">
                                	<?php
		                            //date 1 field
		                            echo '<label for="date13">';
		                                _e( 'Start Date');
		                            echo '</label>';
		                            echo '<input type="text" class="widefat" name="date13" id="date13" />';
		                            ?>  
		                            <?php
		                            //date 1 field
		                            echo '<label for="date14">';
		                                _e( 'End Date');
		                            echo '</label>';
		                            echo '<input type="text" class="widefat" name="date14" id="date14" />';
		                            ?> 
		                            
		                            <div style="padding:20px 0">
	                            		<button class="wp-core-ui button-primary" id="paymentsquery">Ok now search!</button>
	                           	 	</div>
                                </div>
                                <div id="tab3">
	                                <?php
		                            //date 1 field
		                            echo '<label for="date15">';
		                                _e( 'Start Date');
		                            echo '</label>';
		                            echo '<input type="text" class="widefat" name="date15" id="date15"/>';
		                            ?>  
		                            <?php
		                            //date 1 field
		                            echo '<label for="date16">';
		                                _e( 'End Date');
		                            echo '</label>';
		                            echo '<input type="text" class="widefat" name="date16" id="date16"/>';
		                            ?>  
                                    <?php
		                            echo '<label for="clientreportname">';
		                            _e( 'Select a Client');
		                            echo '</label> ';
		                            echo '<select class="widefat" id="clientreportname" name="clientreportname">';                                
		                            echo '<option value="" size="25" />Please select a client</option>';
		                                foreach ($clientnames as $clientname) : setup_postdata( $post );
		                                    echo '<option value="' . $clientname->post_title . '" size="25" />' . $clientname->post_title . '</option>'; 
										endforeach; 
										wp_reset_postdata();	                                
		                            echo "</select>";
		                            ?>		
		                            <?php
		                            echo '<label for="clientreportapartment">';
		                            _e( 'Select an Apartment');
		                            echo '</label> ';
		                            echo '<select class="widefat" id="clientreportapartment" name="clientreportapartment">';                                
		                            echo '<option value="ANY" size="25" />ANY</option>';
		                                foreach ($apartmentnames as $apartmentname) : setup_postdata( $post );
		                                    echo '<option value="' . $apartmentname->post_title . '" size="25" />' . $apartmentname->post_title . '</option>'; 
		                                endforeach; 
										wp_reset_postdata();
		                            echo "</select>";
		                            ?>
		                            <?php
		                            echo '<label for="clientreportlocation">';
		                            _e( 'Select an Location');
		                            echo '</label> ';
		                            echo '<select class="widefat" id="clientreportlocation" name="clientreportlocation">';                                
		                            echo '<option value="ANY" size="25" />ANY</option>';
		                                foreach ($locationnames as $location) : setup_postdata( $post );
		                                    echo '<option value="' . $location->post_title . '" size="25" />' . $location->post_title . '</option>'; 
		                                endforeach; 
										wp_reset_postdata();
		                            echo "</select>";
		                            ?>			                           		                            
		                            <div style="padding:20px 0">
	                            		<button class="wp-core-ui button-primary" id="clientquery">Ok now search!</button>
	                           	 	</div>
                                </div> 
                                <div id="tab4">
								    <?php
								    //date 1 field
								    echo '<label for="date17">';
								        _e( 'Start Date');
								    echo '</label>';
								    echo '<input type="text" class="widefat" name="date17" id="date17" value="' . esc_attr( $date17 ) . '"/>';
								    ?>  
								    <?php
								    //date 1 field
								    echo '<label for="date18">';
								        _e( 'End Date');
								    echo '</label>';
								    echo '<input type="text" class="widefat" name="date18" id="date18" value="' . esc_attr( $date18 ) . '"/>';
								    ?>  
								    <?php
								    echo '<label for="operatorreportname">';
								    _e( 'Select an Operator');
								    echo '</label> ';								    
								    echo '<select class="widefat" id="operatorreportname" name="operatorreportname">';                                
								    echo '<option value="ANY" size="25" />Please select an operator</option>';
								        foreach ($operatornames as $operatorname) : setup_postdata( $post );
								            echo '<option value="' . $operatorname->post_title . '" size="25" />' . $operatorname->post_title . '</option>'; 
								        endforeach; 
										wp_reset_postdata();
								    echo "</select>";
								    ?>		
								    <?php
								    echo '<label for="operatorreportapartment">';
								    _e( 'Select an Apartment');
								    echo '</label> ';
								    echo '<select class="widefat" id="operatorreportapartment" name="operatorreportapartment">';                                
								    echo '<option value="ANY" size="25" />ANY</option>';
								        foreach ($apartmentnames as $apartmentname) : setup_postdata( $post );
								            echo '<option value="' . $apartmentname->post_title . '" size="25" />' . $apartmentname->post_title . '</option>'; 
								        endforeach; 
										wp_reset_postdata();
								    echo "</select>";
								    ?>
								    <?php
								    echo '<label for="operatorreportlocation">';
								    _e( 'Select an Location');
								    echo '</label> ';
								    echo '<select class="widefat" id="operatorreportlocation" name="operatorreportlocation">';                                
								    echo '<option value="ANY" size="25" />ANY</option>';
								        foreach ($locationnames as $location) : setup_postdata( $post );
								            echo '<option value="' . $location->post_title . '" size="25" />' . $location->post_title . '</option>'; 
								        endforeach; 
										wp_reset_postdata();
								    echo "</select>";
								    ?>									   	                            
								    <div style="padding:20px 0">
										<button class="wp-core-ui button-primary" id="operatorquery">Ok now search!</button>
									</div>
								</div>     
								<div id="tab5">
								    <table cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop container-table leader-table">
										<thead>
										<tr>
											<th>
												<p><strong><i class="fa fa-users"></i>Top Operators</strong></p>
											</th>		
										</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<?php
											        //date 1 field
											        echo '<label for="date19">';
											            _e( 'Start Date');
											        echo '</label>';
											        echo '<input type="text" class="widefat" name="date19" id="date19" value="' . esc_attr( $date19 ) . '"/>';
											        ?>  
											        <?php
											        //date 1 field
											        echo '<label for="date20">';
											            _e( 'End Date');
											        echo '</label>';
											        echo '<input type="text" class="widefat" name="date20" id="date20" value="' . esc_attr( $date20 ) . '"/>';
											        ?>  
												</td>
											</tr>
											<tr>
												<td>
													<div style="padding:20px 0">
														<button class="wp-core-ui button-primary" id="leaderoperator">Ok now search!</button>
													</div>
												</td>
											</tr>
										</tbody>
									</table>  
									<table cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop container-table leader-table">
										<thead>
										<tr>
											<th>
												<p><strong><i class="fa fa-users"></i>Top Clients</strong></p>
											</th>		
										</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<?php
											        //date 1 field
											        echo '<label for="date21">';
											            _e( 'Start Date');
											        echo '</label>';
											        echo '<input type="text" class="widefat" name="date21" id="date21" value=""/>';
											        ?>  
											        <?php
											        //date 1 field
											        echo '<label for="date22">';
											            _e( 'End Date');
											        echo '</label>';
											        echo '<input type="text" class="widefat" name="date22" id="date22" value=""/>';
											        ?>  
												</td>
											</tr>
											<tr>
												<td>
													<div style="padding:20px 0">
														<button class="wp-core-ui button-primary" id="leaderclient">Ok now search!</button>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
									<table cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop container-table leader-table">
										<thead>
										<tr>
											<th>
												<p><strong><i class="fa fa-map-marker"></i>Top Locations</strong></p>
											</th>		
										</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<?php
											        //date 1 field
											        echo '<label for="date23">';
											            _e( 'Start Date');
											        echo '</label>';
											        echo '<input type="text" class="widefat" name="date23" id="date23" value=""/>';
											        ?>  
											        <?php
											        //date 1 field
											        echo '<label for="date24">';
											            _e( 'End Date');
											        echo '</label>';
											        echo '<input type="text" class="widefat" name="date24" id="date24" value=""/>';
											        ?>  
											        <?php
						                            echo '<label for="leaderloc_clientname">';
						                            _e( 'Select a Client');
						                            echo '</label> ';
						                            echo '<select class="widefat" id="leaderloc_clientname" name="leaderloc_clientname">';                                
						                           	echo '<option value="ANY" size="25" />ANY</option>';
						                                foreach ($clientnames as $clientname) : setup_postdata( $post );
						                                    echo '<option value="' . $clientname->post_title . '" size="25" />' . $clientname->post_title . '</option>'; 
						                                endforeach; 
														wp_reset_postdata();
						                            echo "</select>";
						                            ?>
						                            <?php
						                            echo '<label for="leaderloc_operatorname">';
						                            _e( 'Select an Operator');
						                            echo '</label> ';
						                            echo '<select class="widefat" id="leaderloc_operatorname" name="leaderloc_operatorname">';                                
						                           	echo '<option value="ANY" size="25" />ANY</option>';
						                                foreach ($operatornames as $operatorname) : setup_postdata( $post );
						                                    echo '<option value="' . $operatorname->post_title . '" size="25" />' . $operatorname->post_title . '</option>'; 
						                                endforeach; 
														wp_reset_postdata();
						                            echo "</select>";
						                            ?>
												</td>
											</tr>
											<tr>
												<td>
													<div style="padding:20px 0">
														<button class="wp-core-ui button-primary" id="leaderlocations">Ok now search!</button>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
									<table cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop container-table leader-table">
										<thead>
										<tr>
											<th>
												<p><strong><i class="fa fa-home"></i>Top Apartments</strong></p>
											</th>		
										</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<?php
											        //date 1 field
											        echo '<label for="date25">';
											            _e( 'Start Date');
											        echo '</label>';
											        echo '<input type="text" class="widefat" name="date25" id="date25" value=""/>';
											        ?>  
											        <?php
											        //date 1 field
											        echo '<label for="date26">';
											            _e( 'End Date');
											        echo '</label>';
											        echo '<input type="text" class="widefat" name="date26" id="date26" value=""/>';
											        ?>  
											       	<?php
												    echo '<label for="leaderapp_clientname">';
												    _e( 'Select a Client');
												    echo '</label> ';
												    echo '<select class="widefat" id="leaderapp_clientname" name="leaderapp_clientname">';                                
												    echo '<option value="ANY" size="25" />ANY</option>';
												        foreach ($clientnames as $clientname) : setup_postdata( $post );
												            echo '<option value="' . $clientname->post_title . '" size="25" />' . $clientname->post_title . '</option>'; 
												        endforeach; 
														wp_reset_postdata();
												    echo "</select>";
												    ?>
												    <?php
												    echo '<label for="leaderapp_operatorname">';
												    _e( 'Select an Operator');
												    echo '</label> ';
												    echo '<select class="widefat" id="leaderapp_operatorname" name="leaderapp_operatorname">';                                
												    echo '<option value="ANY" size="25" />ANY</option>';
												        foreach ($operatornames as $operatorname) : setup_postdata( $post );
												            echo '<option value="' . $operatorname->post_title . '" size="25" />' . $operatorname->post_title . '</option>'; 
												        endforeach; 
														wp_reset_postdata();
												    echo "</select>";
												    ?>
												</td>
											</tr>
											<tr>
												<td>
													<div style="padding:20px 0">
														<button class="wp-core-ui button-primary" id="leaderapartments">Ok now search!</button>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								    								   	                            
								    
								</div>                    
							 </div>
                        </td>
                    </tr>
                </tbody>
            </table>


            <!-- Table content populated from function in functions.php -->
            <div id="searchresults" style="display:none;">             	  
              	<table id="searchresult" cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop container-table" width="100%">
	        	</table>
	        	 <div id="loadingDiv">Your report is generating, this can take a few mins.</div>     
	        	<button class="wp-core-ui button-primary" id="printme">Print Me</button> 
			</div>			
			<script>
				//print the contents to a new window for printing
				function printClick() {
			  		var w = window.open();
			  		var html = jQuery("#searchresult").html(); 
			  			jQuery(w.document.head).html('<link rel="stylesheet" type="text/css" href="<?php echo get_site_url();?>/wp-content/plugins/scp-bookings/css/printview-styles.css">');   		
			    		jQuery(w.document.body).html(html); 		

					}

				jQuery(function() {
				    jQuery("#printme").click(printClick);
				});
			</script>


         </td>
     </tbody>
 </table>

<?php } //end
?>