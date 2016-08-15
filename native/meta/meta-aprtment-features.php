<?php
ini_set('display_errors', 'On');
/**
Adds an Apartment Details Meta box to the Apartments Post Type
*/

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function apartmentdetails_add_meta_box() {

    $screens = array( 'apartments' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'apartmentdetails_sectionid',
            __( 'Apartment Features', 'apartmentdetails_textdomain' ),
            'apartmentdetails_meta_box_callback',
            $screen,
            'advanced',
            'high'

        );
    }
}
add_action( 'add_meta_boxes', 'apartmentdetails_add_meta_box' );
/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function apartmentdetails_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'apartmentdetails_meta_box', 'apartmentdetails_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $ref = get_post_meta( $post->ID, 'ref', true ); 
    $parking = get_post_meta( $post->ID, 'parking', true );    
    $description = get_post_meta( $post->ID, 'description', true );   
    $shortdescription = get_post_meta( $post->ID, 'shortdescription', true ); 
    $internet = get_post_meta( $post->ID, 'internet', true );
    $lift = get_post_meta( $post->ID, 'lift', true );
    $bedrooms = get_post_meta( $post->ID, 'bedrooms', true );
    $bathrooms = get_post_meta( $post->ID, 'bathrooms', true );
    $sleeps = get_post_meta( $post->ID, 'sleeps', true );
    $livingroom = get_post_meta( $post->ID, 'livingroom', true );
    $diningroom = get_post_meta( $post->ID, 'diningroom', true );
    $kitchen = get_post_meta( $post->ID, 'kitchen', true );
    $tv = get_post_meta( $post->ID, 'tv', true );
    $dvd = get_post_meta( $post->ID, 'dvd', true );
    $sofabed = get_post_meta( $post->ID, 'sofabed', true );
    

    $additionalfeatures = get_post_meta( $post->ID, 'additionalfeatures', true );
    $laundry = get_post_meta( $post->ID, 'laundry', true );
    $housekeeping = get_post_meta( $post->ID, 'housekeeping', true );
    $reception = get_post_meta( $post->ID, 'reception', true );
    $rating = get_post_meta( $post->ID, 'rating', true );
    
   ?>
    
    <table cellpadding="0" cellspacing="0" border="0" class="bookings-admin">    
        <tbody>
            <tr>
                <td>

                <table cellpadding="0" cellspacing="0" border="0" class="bookings-ref" width="100%">
                    <tbody>
                        <tr>
                            <td>                                                     
                                <?php
                                //Bathrooms field
                                echo '<label for="ref">';
                                    _e( 'Refrence', 'bookingscheckin_textdomain' );
                                echo ':&nbsp</label>';
                                echo '<input type="text" class="widefat" name="ref" id="ref" value="' . esc_attr( $ref ) . '"/>';
                                ?>                                                        
                            </td>
                        </tr>
                    </tbody>
                </table>
                   
                   <!-- Description Table -->
                    <table cellpadding="0" cellspacing="0" border="0" width="100%" class="bookings-aligntop container-table">
                       <tbody>
                            <tr><th colspan="3"><h2><i class="fa fa-building"></i>Apartment Details</h2></th></tr>                           
                                                        
                            <tr>
                                <td colspan="3" width="100%" class="haseditor">    
                                                      
                                    <?php
                                    echo '<label for="description">Apartment Description: Upload images using the Add Media button below. </label>';                              
                                    wp_editor($description, 'description');
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <?php
                                    //short description field
                                    echo '<label for="Apartment Short Description">';
                                         _e( 'Short Description', 'bookingsrentalprice_textdomain' );
                                    echo '</label>';
                                    echo '<textarea rows="3" class="widefat" name="shortdescription" id="shortdescription" />';
                                    echo esc_attr( $shortdescription );
                                    echo '</textarea>';
                                    ?>
                                </td>
                                <td colspan="1">
                                    <?php
                                    //Sleeps field
                                    echo '<label for="rating">';
                                        _e( 'Rating', 'bookingscheckin_textdomain' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="rating" id="rating" value="' . esc_attr( $rating ) . '"/>';
                                    echo '(number 1 - 5)';
                                    ?>
                                </td>
                            </tr>
                 
                            
                            <tr>
                                <td colspan="3">
                                    <h3 style="text-align:center; border-bottom:1px solid #d2d2d2;">Apartment Amenities</h3>
                                </td>
                            </tr>
                            <tr>
                                <td width="33%">
                                    <?php
                                    //Parking field
                                    echo '<label for="parking">';
                                         _e( 'Parking', 'bookingsrentalprice_textdomain' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="parking" id="parking" value="' . esc_attr( $parking ) . '" />';
                                    $pos = parking_meta_values('parking', 'apartments');                                 
                                    ?>
                                    <script>
                                      jQuery(function() {
                                        var availableTags = [ "<?php echo  implode('","',$pos); ?>" ];
                                        jQuery( "#parking" ).autocomplete({
                                          source: availableTags
                                        });
                                      });
                                    </script>                               
                                </td>

                                <td width="33%" style="border-left:1px solid #d2d2d2;border-right:1px solid #d2d2d2;">
                                    <?php
                                    //Internet field
                                    echo '<label for="internet">';
                                         _e( 'Internet', 'bookingsrentalprice_textdomain' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="internet" id="internet" value="' . esc_attr( $internet ) . '" />';
                                    $pos = internet_meta_values('internet', 'apartments');                                 
                                    ?>
                                    <script>
                                      jQuery(function() {
                                        var availableTags = [ "<?php echo  implode('","',$pos); ?>" ];
                                        jQuery( "#internet" ).autocomplete({
                                          source: availableTags
                                        });
                                      });
                                    </script>                               
                                </td>

                                <td width="33%">
                                    <?php
                                    //Lift field
                                    echo '<label for="lift">';
                                         _e( 'Lift', 'bookingsrentalprice_textdomain' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="lift" id="lift" value="' . esc_attr( $lift ) . '" />';
                                    $pos = lift_meta_values('lift', 'apartments');                                 
                                    ?>
                                    <script>
                                      jQuery(function() {
                                        var availableTags = [ "<?php echo  implode('","',$pos); ?>" ];
                                        jQuery( "#lift" ).autocomplete({
                                          source: availableTags
                                        });
                                      });
                                    </script>                               
                                </td>
                            </tr>
                            <tr>
                                <td width="33%">
                                    <?php
                                    //bedrooms field
                                    echo '<label for="bedrooms">';
                                        _e( 'Bedrooms', 'bookingscheckin_textdomain' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="bedrooms" id="bedrooms" value="' . esc_attr( $bedrooms ) . '"/>';
                                    ?>
                                </td>
                                <td width="33%" style="border-left:1px solid #d2d2d2;border-right:1px solid #d2d2d2;">
                                    <?php
                                    //Bathrooms field
                                    echo '<label for="bathrooms">';
                                        _e( 'Bathrooms', 'bookingscheckin_textdomain' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="bathrooms" id="bathrooms" value="' . esc_attr( $bathrooms ) . '"/>';
                                    ?>
                                </td>
                                <td width="33%">
                                    <?php
                                    //Sleeps field
                                    echo '<label for="sleeps">';
                                        _e( 'Sleeps', 'bookingscheckin_textdomain' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="sleeps" id="sleeps" value="' . esc_attr( $sleeps ) . '"/>';
                                   
                                    if ($sofabed) {
                                    	echo '<input type="checkbox" checked="checked" class="widefat" name="sofabed" id="sofabed" value="TRUE"/>Includes sofa bed';
                                    } else {
                                    	echo '<input type="checkbox" class="widefat" name="sofabed" id="sofabed" value="TRUE"/>Includes sofa bed';
                                    }
                                    
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="33%">
                                    <?php
                                    //Living Room field
                                    echo '<label for="livingroom">';
                                         _e( 'Living Room', 'bookingsrentalprice_textdomain' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="livingroom" id="livingroom" value="' . esc_attr( $livingroom ) . '" />';
                                    $pos = livingroom_meta_values('livingroom', 'apartments');                                 
                                    ?>
                                    <script>
                                      jQuery(function() {
                                        var availableTags = [ "<?php echo  implode('","',$pos); ?>" ];
                                        jQuery( "#livingroom" ).autocomplete({
                                          source: availableTags
                                        });
                                      });
                                    </script>
                                </td>
                                <td width="33%" style="border-left:1px solid #d2d2d2;border-right:1px solid #d2d2d2;">
                                    <?php
                                    //Dining Room field
                                    echo '<label for="diningroom">';
                                         _e( 'Dining Room', 'bookingsrentalprice_textdomain' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="diningroom" id="diningroom" value="' . esc_attr( $diningroom ) . '" />';
                                    $pos = diningroom_meta_values('diningroom', 'apartments');                                 
                                    ?>
                                    <script>
                                      jQuery(function() {
                                        var availableTags = [ "<?php echo  implode('","',$pos); ?>" ];
                                        jQuery( "#diningroom" ).autocomplete({
                                          source: availableTags
                                        });
                                      });
                                    </script>
                                </td>
                                <td width="33%">
                                    <?php
                                    //Kitchen field
                                    echo '<label for="kitchen">';
                                         _e( 'Kitchen', 'bookingsrentalprice_textdomain' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="kitchen" id="kitchen" value="' . esc_attr( $kitchen ) . '" />';
                                    $pos = kitchen_meta_values('kitchen', 'apartments');                                 
                                    ?>
                                    <script>
                                      jQuery(function() {
                                        var availableTags = [ "<?php echo  implode('","',$pos); ?>" ];
                                        jQuery( "#kitchen" ).autocomplete({
                                          source: availableTags
                                        });
                                      });
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <td width="33%">
                                    <?php
                                    //TV field
                                    echo '<label for="tv">';
                                         _e( 'TV', 'bookingsrentalprice_textdomain' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="tv" id="tv" value="' . esc_attr( $tv ) . '" />';
                                    $pos = tv_meta_values('tv', 'apartments');                                 
                                    ?>
                                    <script>
                                      jQuery(function() {
                                        var availableTags = [ "<?php echo  implode('","',$pos); ?>" ];
                                        jQuery( "#tv" ).autocomplete({
                                          source: availableTags
                                        });
                                      });
                                    </script>
                                    <?php
                                    //Kitchen field
                                    echo '<label for="reception">';
                                         _e( '24 Hour Reception', 'bookingsrentalprice_textdomain' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="reception" id="reception" value="' . esc_attr( $reception ) . '" />';
                                    $pos = kitchen_meta_values('reception', 'apartments');                                 
                                    ?>
                                    <script>
                                      jQuery(function() {
                                        var availableTags = [ "<?php echo  implode('","',$pos); ?>" ];
                                        jQuery( "#reception" ).autocomplete({
                                          source: availableTags
                                        });
                                      });
                                    </script>
                                </td>
                                <td width="33%" style="border-left:1px solid #d2d2d2;border-right:1px solid #d2d2d2;">
                                    <?php
                                    //TV field
                                    echo '<label for="dvd">';
                                         _e( 'DVD', 'bookingsrentalprice_textdomain' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="dvd" id="dvd" value="' . esc_attr( $dvd ) . '" />';
                                    $pos = dvd_meta_values('dvd', 'apartments');                                 
                                    ?>
                                    <script>
                                      jQuery(function() {
                                        var availableTags = [ "<?php echo  implode('","',$pos); ?>" ];
                                        jQuery( "#dvd" ).autocomplete({
                                          source: availableTags
                                        });
                                      });
                                    </script>
                                    <?php
                                    //Kitchen field
                                    echo '<label for="laundry">';
                                         _e( 'Laundry Facilities', 'bookingsrentalprice_textdomain' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="laundry" id="laundry" value="' . esc_attr( $laundry ) . '" />';
                                    $pos = kitchen_meta_values('laundry', 'apartments');                                 
                                    ?>
                                    <script>
                                      jQuery(function() {
                                        var availableTags = [ "<?php echo  implode('","',$pos); ?>" ];
                                        jQuery( "#laundry" ).autocomplete({
                                          source: availableTags
                                        });
                                      });
                                    </script>
                                </td>
                                <td width="33%">
                                    
                                    <?php
                                    //Kitchen field
                                    echo '<label for="housekeeping">';
                                         _e( 'Housekeeping', 'bookingsrentalprice_textdomain' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="housekeeping" id="housekeeping" value="' . esc_attr( $housekeeping ) . '" />';
                                    $pos = kitchen_meta_values('housekeeping', 'apartments');                                 
                                    ?>
                                    <script>
                                      jQuery(function() {
                                        var availableTags = [ "<?php echo  implode('","',$pos); ?>" ];
                                        jQuery( "#housekeeping" ).autocomplete({
                                          source: availableTags
                                        });
                                      });
                                    </script>
                                </td>

                            <tr>
                                <td colspan="3">
                                    <?php
                                    //Additional Features
                                    echo '<label for="additionalfeatures">';
                                         _e( 'Additional Features', 'bookingsrentalprice_textdomain' );
                                    echo '</label>';
                                    echo '<textarea rows="3" class="widefat" name="additionalfeatures" id="additionalfeatures" />';
                                    echo esc_attr( $additionalfeatures );
                                    echo '</textarea>';
                                    ?>
                                </td>
                            </tr>
                        
                       </tbody>
                    </table>

                  


                </td>
            </tr>
        </tbody>
    </table>    

<?php } 

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function apartmentdetails_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['apartmentdetails_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['apartmentdetails_meta_box_nonce'], 'apartmentdetails_meta_box' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */
    
    // Make sure that it is set.
    if ( ! isset( $_POST['parking'] ) ) {
        return;
    }

    // Sanitize user input.
    $my_data_parking = sanitize_text_field( $_POST['parking'] );
    $my_data_shortdescription = sanitize_text_field( $_POST['shortdescription'] );
    $my_data_internet = sanitize_text_field( $_POST['internet'] );
    $my_data_lift = sanitize_text_field( $_POST['lift'] );
    $my_data_bedrooms = sanitize_text_field( $_POST['bedrooms'] );
    $my_data_bathrooms = sanitize_text_field( $_POST['bathrooms'] );
    $my_data_sleeps= sanitize_text_field( $_POST['sleeps'] );
    $my_data_livingroom = sanitize_text_field( $_POST['livingroom'] );
    $my_data_diningroom = sanitize_text_field( $_POST['diningroom'] );
    $my_data_kitchen = sanitize_text_field( $_POST['kitchen'] );
    $my_data_tv = sanitize_text_field( $_POST['tv'] );
    $my_data_dvd = sanitize_text_field( $_POST['dvd'] );
    $my_data_ref = sanitize_text_field( $_POST['ref'] );
    //$my_data_sofabed = sanitize_text_field( $_POST['sofabed'] );
    
    $my_data_additionalfeatures = sanitize_text_field( $_POST['additionalfeatures'] );
    $my_data_reception = sanitize_text_field( $_POST['reception'] );
    $my_data_laundry = sanitize_text_field( $_POST['laundry'] );
    $my_data_housekeeping = sanitize_text_field( $_POST['housekeeping'] );
    $my_data_rating = sanitize_text_field( $_POST['rating'] );


    // Update the meta field in the database.
    update_post_meta( $post_id, 'parking', $my_data_parking );
    update_post_meta( $post_id, 'description', $_POST['description'] );
    update_post_meta( $post_id, 'shortdescription', $my_data_shortdescription );
    update_post_meta( $post_id, 'internet', $my_data_internet );
    update_post_meta( $post_id, 'lift', $my_data_lift );
    update_post_meta( $post_id, 'bedrooms', $my_data_bedrooms );
    update_post_meta( $post_id, 'bathrooms', $my_data_bedrooms );
    update_post_meta( $post_id, 'sleeps', $my_data_sleeps);
    update_post_meta( $post_id, 'livingroom', $my_data_livingroom);
    update_post_meta( $post_id, 'diningroom', $my_data_diningroom);
    update_post_meta( $post_id, 'kitchen', $my_data_kitchen);
    update_post_meta( $post_id, 'tv', $my_data_tv);
    update_post_meta( $post_id, 'dvd', $my_data_dvd);
    update_post_meta( $post_id, 'ref', $my_data_ref);
    //update_post_meta( $post_id, 'sofabed', $my_data_sofabed);
    
    update_post_meta( $post_id, 'additionalfeatures', $my_data_additionalfeatures);
    update_post_meta( $post_id, 'reception', $my_data_reception);
    update_post_meta( $post_id, 'laundry', $my_data_laundry);
    update_post_meta( $post_id, 'housekeeping', $my_data_housekeeping);
    update_post_meta( $post_id, 'rating', $my_data_rating);

}
add_action( 'save_post', 'apartmentdetails_save_meta_box_data' );
?>
