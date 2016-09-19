<?php

function customerquery_callback() { 

	//get all the required information for the query builder. 
	global $post; 

	//get the operator list, locations list and resellers list
	$locationsargs = array('post_type' => 'locations','posts_per_page'   => -1,'orderby' => 'title', 'order' => 'ASC', );
	$locationsquery = new WP_Query( $locationsargs );

    $operatorsargs = array('post_type' => 'operators','posts_per_page'   => -1,'orderby' => 'title', 'order' => 'ASC', );
    $operatorsquery = new WP_Query( $operatorsargs );

    




?>

<div id="loadingDiv">
    <i class="fa fa-cog fa-spin"></i> : Wont be a moment.
</div>

<table cellpadding="0" cellspacing="0" border="0" class="bookings-admin" >
     <tbody>
         <td>

            <table cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop container-table" width="100%">            
                <tbody>
                <tr><th colspan="5"><h2><i class="fa fa-home"></i>Customer Apartment Search</h2></th></tr>
                    <tr>
                    <td width="200px">
                        <p>Select a Location</p>
                        <?php 
                        //begin the loop to list the locations
						if ( $locationsquery->have_posts() ) { 	
                            echo '<select class="widefat" id="location">';
                            echo '<option value="">Please select</option>';
							while ( $locationsquery->have_posts() ) { $locationsquery->the_post();	?>                                
    	                        <option class="widefat location-item" name="location" value="<?php echo the_title(); ?>" id="<?php echo get_the_id(); ?>" name="<?php echo the_title(); ?>">	                           
    	                          	<?php echo the_title(); ?>
    	                    	</option> 

						<?php } 
                        echo '</select>'; 
                        } wp_reset_postdata(); ?>
                    </td>  
                    <td width="200px">
                        <p>Select an Operator</p>
                        <?php 
                        //begin the loop to list the locations
                        if ( $operatorsquery->have_posts() ) {  
                            echo '<select class="widefat" id="operator">';
                            echo '<option value="">Please select</option>';
                            while ( $operatorsquery->have_posts() ) { $operatorsquery->the_post();  ?>
                                <option class="widefat location-item" name="operatorname" value="<?php echo the_title(); ?>" id="<?php echo get_the_id(); ?>" name="<?php echo the_title(); ?>">                              
                                    <?php echo the_title(); ?>
                                </option> 

                        <?php } 
                        echo '</select>'; 
                        } wp_reset_postdata(); ?>
                    </td>  
                    <td width="200px">
                        <p>Select the number of nights</p>
                        <input type="text" id="noofnights" class="widefat" placeholder="number of nights"/>
                    </td> 
                    <td width="200px">
                        <p>Select the booking type</p>
                        <select class="widefat" id="bookingtypesearch">
                            <option>Please select</option>
                            <option value="Corporate">Corporate</option>
                            <option value="Groups">Groups</option>
                            <option value="Leisure">Leisure</option>
                        </select>
                    </td> 
                    
                    </tr>                    
                    <tr>
                    	<td colspan="5" style="padding-top:20px;padding-bottom:20px;">
                    		<button class="wp-core-ui button-primary" id="customerapartmentsquery">Ok, lets go.</button>
                    	</td>
                    </tr>
                </tbody>
           	</table>


           	<!-- Table content populated from function in functions.php -->
            <div id="searchresults" style="display:none;">             	  
              	<table id="searchresult" cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop" width="100%">
	        	</table>
	        	<button class="wp-core-ui button-primary hide-select" id="printme">Print Me</button> 
	        	<button class="wp-core-ui button-primary hide-select" id="emailme">Email Me</button>
			</div>

			

       	</td>
   	</tbody>
</table>

<?php } ?>