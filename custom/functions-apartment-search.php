<?php


/**
**********************************
The function to return the data
**********************************
**/

function customer_query_ajax() {

			//get the post values for the locations
			$location = ($_POST['location']);
			//get the operatorname
			$operator = ($_POST['operator']);
			//get the number of nights stay
			$noofnights = ($_POST['noofnights']);
			//ge the booking type
			$bookingtype = ($_POST['bookingtype']);
			

			//now get all the posts in those locations
			ob_start();

			global $post;
			
			//Location and Operator
			if ($location && $operator) {
					// WP_Query arguments
					$args = array (
						'post_type' => array( 'apartments' ),
						'posts_per_page'         => -1,
						'meta_query'             => array(
							'relation' => 'AND',
								array(
									'key'       => 'operatorname',
									'value'     => $operator,
								),
								array(
									'key'       => 'apptlocation1',
									'value'     => $location,
								),
							),
					);
					
			//Location Only
			} elseif ( ( $location ) && ( !$operator ) ) {
					// WP_Query arguments
						$args = array (
							'post_type' => array( 'apartments' ),
							'posts_per_page'         => -1,
							'meta_query'             => array(
								array(
									'key'       => 'apptlocation1',
									'value'     => $location,
								),
							),
						);

			//Operator Only
			} elseif ( ( !$location ) && ( $operator ) ) {
					// WP_Query arguments
						$args = array (
							'post_type' => array( 'apartments' ),
							'posts_per_page'         => -1,
							'meta_query'             => array(
								array(
									'key'       => 'operatorname',
									'value'     => $operator,
								),
							),
						);
			}

			

			// The Query
			$query = new WP_Query( $args );
	

			// The Loop
			if ( $query->have_posts() ) { ?>


				<div id="apartment-list">
					
					<table cellpadding="0" cellspacing="0" border="0" width="100%" class="bookings-aligntop container-table">
	                    <tbody>
	                        <tr><th colspan="3"><h2><i class="fa fa-map-marker"></i>Locations</h2></th></tr>				
	                        <?php $i = 1; ?>
							<?php while ( $query->have_posts() ) { $query->the_post(); 


								$apptlocation1 = get_post_meta(get_the_ID(), 'apptlocation1', true);
								$bedrooms = get_post_meta( get_the_ID(), 'bedrooms', true );
								$bathrooms = get_post_meta(get_the_ID(), 'bathrooms', true);
								$sleeps = get_post_meta( get_the_ID(), 'sleeps', true );
								$descriptionstring = get_post_meta( get_the_ID(), 'description', true); 
								$description = str_replace("&nbsp;", " ", $descriptionstring);
								

								//get the booking type
								 if ( $bookingtype == 'Corporate' ) {
										$prefix = 'cp';
									} elseif ( ($bookingtype == 'Groups') || ($bookingtype == 'Leisure') ) {
										$prefix = 'gr';
									}
								//get the stay length
								if ( $noofnights <= '7' ) {

										$stay = '37';

									} elseif ( $noofnights > '7' && $noofnights <= '28' ) {

										$stay = '728';

									} elseif ( $noofnights > '28' && $noofnights <= '90' ) {

										$stay = '2990';

									} elseif ( $noofnights > '90' ) {

										$stay = '90';

									} else {

										$stay = "incorect date";

									}

								$price = get_post_meta(get_the_ID(), $prefix . $stay, true);			
								

							?>

								<td width="33%" id="<?php echo $i; ?>">
									
									<div class="apartment-entry-container">
										
										<table id="<?php echo get_the_ID(); ?>" bgcolor="#efefef" cellpadding="10" cellspacing="0" border="0" width="100%" class="bookings-aligntop container-table apartment-entry">
		                    				<tbody>
		                    					<tr>
		                    						<td class="featured-image-holder" valign="top" width="100%" style="padding-top:20px;text-align:center">
		                    						
		                    							<?php 
														$attachment_id = get_post_thumbnail_id( $post->ID );

														$image_attributes = wp_get_attachment_image_src( $attachment_id, 'medium' ); // returns an array
														if( $image_attributes ) {
														?> 
														<img style="width:300px;height:auto;"src="<?php echo $image_attributes[0]; ?>">
														<?php //echo wp_get_attachment_image( 1 ); ?>

														<?php } ?>													

		                    						</td>
		                    					</tr>
		                    					<tr>
		                    						<td class="pricingentry" width="100%" data-price="<?php echo $prefix.$stay ?>">
		                    							<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
		                    							<?php
		                    							if ($price >= 1) {
		                    								echo '<p class="pricestring"><strong>Price: &pound;' . $price . '</strong></p>';
		                    							} else {
		                    								echo '<p class="pricestring">No price available, please call for a quote.</p>';
		                    							}
		                    							
		                    							?>	
		                    							<p>Additional Pricing Information</p>	                    							
		                    							<textarea style="display:none;background: none; width:100%" id="additionalinfo" rows="5" style="width:100%;">
		                    								
		                    							</textarea>
		                    							<p><strong>Overview</strong></p>          							
		                    							<p>Location: <?php echo $apptlocation1; ?><br/>
		                    							Bedrooms: <?php echo $bedrooms; ?><br/>
		                    							Bathrooms: <?php echo $bathrooms; ?><br/>
		                    							Sleeps: <?php echo $sleeps; ?></p>
		                    							<p><strong>Description</strong></p>		                    							
		                    							<?php echo $description; ?>
		                    							<div class="selectthis">
		                    								<p>
		                    									<input type="checkbox" class="additionalinfotoggle" name="selectthis" id="selectthis" value="<?php echo get_the_ID(); ?>">Select this apartment
		                    								</p>		
		                    							</div>
		                    							<input type="hidden" id="postid" value="<?php echo get_the_ID(); ?>">
		                    							<script type="text/javascript">
		                    								
																jQuery('.additionalinfotoggle').on('click',function(){
																	jQuery(this).closest('td.pricingentry').find('#additionalinfo').show();
																});
														
		                    							</script>                    							
		                    						</td> 
		                    						
							                    </tr>
		                    				</tbody>
		                    			</table>

									</div>
	                    			
	                    		<?php
	    						if ($i % 3 == 0) {

	                        	echo '</td></tr>';
		                        } else {
		                        	echo '</td>';
		                        }  
	    						?>													

							<?php $i++; }  ?>

	                    </tbody>
	                </table>

				</div>

                <div class="customer-query-form">                	
                	<form>
                		<table cellpadding="0" cellspacing="0" border="0" width="100%" class="bookings-aligntop container-table apartment-entry">
                			<tbody>
                				<tr><th colspan="4"><h2><i class="fa fa-envelope"></i>Client Details</h2></th></tr>
            					<tr>
            						<td>
            							<label for="name">Client Name</label><br/>
            							<input type="text" name="name" id="name">
            						</td>
            						<td>
            							<label for="email">Client Email</label><br/>
            							<input type="text" name="email" id="email">
            						</td>
            						<td>
			                        <p>Select the reseller</p>
			                        <?php 
			                        //begin the loop to list the resellers
			                        $resellerargs = array('post_type' => 'resellerp','posts_per_page'   => -1,'orderby' => 'title', 'order' => 'ASC', );
			                        $resellerquery = new WP_Query( $resellerargs );
			                        if ( $resellerquery->have_posts() ) {  
			                            echo '<select class="widefat" id="reseller">';
			                            echo '<option value="">Please Select</option>';
			                            while ( $resellerquery->have_posts() ) { $resellerquery->the_post();  ?>                                
			                                <option class="widefat reseller-item" name="reseller" value="<?php echo the_title(); ?>" id="<?php echo get_the_id(); ?>" name="<?php echo the_title(); ?>">                               
			                                    <?php echo the_title(); ?>
			                                </option> 

			                        <?php } 
			                        echo '</select>'; 
			                        } wp_reset_postdata(); ?>
			                    </td>
            						<td>
            							<label for="send">Click to send</label><br/>
            							<input style="text-align:center;" class="wp-core-ui button-primary" id="search-query-send" value="Send" />
            							<input style="text-align:center;" class="wp-core-ui button-primary" id="cancel" value="Cancel" />
            							
            						</td>
            					</tr>
            				</tbody>
            			</table>
                	</form>
                </div>
               <script>
                /********************
				// Supporting email functions and ajax starts here
				********************/	
				jQuery(document).ready(function(){
					jQuery('#emailme').click(function(){
						jQuery('.selectthis').attr("style", "display: none !important;");
						jQuery('.apartment-entry-container input:checkbox:not(:checked)').each(function() {
							jQuery(this).closest('.apartment-entry-container').remove();
						});
						jQuery('.customer-query-form').show();			
					});
				});
				
				//remove the links from the titles if the search is for a reseller
				jQuery('#reseller').change(function() {
					if (jQuery(this).val()==="") {
						//do nothing
					} else{
						jQuery('.apartment-entry-container a').removeAttr('href');
					};
				});

				jQuery('#search-query-send').click(function() {				  
				  var postidstring = [];
				  var commentsstring = [];
				  var pricestring = [];
				  var name = jQuery('#name').val();		  
				  var email = jQuery('#email').val();
				  var reseller = jQuery('#reseller').val();

				  	//generate the string of post ID's for the next query
				 	jQuery('.apartment-entry-container:has(input:checked)').each(function() {				 		
					   	var idstr = jQuery(this).find('input[type=checkbox]').val();
					   	postidstring += postidstring.length > 0 ? ',' + idstr : idstr;   
				    });

				 	//generate the string of comments for the next query
					jQuery('.apartment-entry-container').each(function() {					   
					   var commstr = jQuery(this).find('textarea').val().replace(/\n\r?/g, '<br>');
					   commentsstring += commentsstring.length > 0 ? '%%' + commstr : commstr;                   
					});

					
					//generate the string of prices for the next query
					jQuery('.apartment-entry-container').each(function() {					   
					   var pristr = jQuery(this).find('.pricestring').text();
					   pricestring += pricestring.length > 0 ? ',' + pristr : pristr;                   
					});
			
				 	
					//send everything off to the next function
					var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
					jQuery.ajax({
					    url: siteUrl,
					    type: 'POST',
					    data: 'action=apartmentsearchemail&email=' + email + '&name=' + name + '&reseller=' + reseller + '&postidstring=' + postidstring + '&commentsstring=' + commentsstring + '&pricestring=' + pricestring,
					    success: function(result) {
				      		//got it back, now assign it to its fields.                     
				      		alert('Your message has been sent.');
				    	}
				  	});	
				  	
				});	

				        	 
               

                //cancel the sending of the form
                jQuery('#cancel').click(function(){
                	jQuery('.selectthis').css("display","block !important");
                	jQuery('.customer-query-form').hide();
                });
              				
              	//print the search results into a browser
				function printClick() {
		  			var w = window.open();
		  			var html = jQuery("#apartment-list").html(); 
		  			jQuery(w.document.head).html('<link rel="stylesheet" type="text/css" href="<?php echo get_site_url();?>/wp-content/plugins/scp-bookings/css/printview-styles.css">');   		
		    		jQuery(w.document.body).html(html); 
				}
				jQuery(function() {
				    jQuery("#printme").click(printClick);
				});	

				/********************
				// Supporting email functions and ajax ends here
				********************/			
                </script>

					
				 <?php } else {
				 	echo '<h2>Oh dear.</h2>';
				 	echo '<p>Looks like there were no Apartments that match that criteria. Either that or theinformation on the Apartment your looking for may be inaccrate.</p>';
				 } wp_reset_postdata();			

			$content = ob_get_clean();
	
			echo $content;

			die();
				
		}

add_action('wp_ajax_customer_query_ajax', 'customer_query_ajax');
add_action('wp_ajax_nopriv_customer_query_ajax', 'customer_query_ajax');



function icl_load_jquery_ui() {
	wp_enqueue_script('jquery-ui-dialog', false, array('jquery'), false, true );
}
add_action( 'admin_enqueue_scripts', 'icl_load_jquery_ui' ); 



?>