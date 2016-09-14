<?php
/**
Adds a Location Details Meta box to the Apartments Post Type
*/

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function apartmentlocation_add_meta_box() {

    $screens = array( 'apartments' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'apartmentlocation_sectionid',
            __( 'Location Details', 'apartmentlocation_textdomain' ),
            'apartmentlocation_meta_box_callback',
            $screen,
            'advanced',
            'high'

        );
    }
}
add_action( 'add_meta_boxes', 'apartmentlocation_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function apartmentlocation_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'apartmentlocation_meta_box', 'apartmentlocation_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $apptlocation1 = get_post_meta( $post->ID, 'apptlocation1', true );
    $apptlocation2 = get_post_meta( $post->ID, 'apptlocation2', true );
    $address = get_post_meta( $post->ID, 'address', true );
    $buildingname = get_post_meta( $post->ID, 'buildingname', true);
    $postcode = get_post_meta( $post->ID, 'postcode', true );
    $town = get_post_meta( $post->ID, 'town', true );
    $state = get_post_meta( $post->ID, 'state', true );
    $additionalinfo = get_post_meta( $post->ID, 'additionalinfo', true );
    $options = get_posts(
        array(
            'post_type'   => 'locations', 
            'orderby'     => 'title', 
            'order'       => 'ASC', 
            'numberposts' => -1 
        )
    );?>
    
    <table cellpadding="0" cellspacing="0" border="0" class="bookings-admin">    
        <tbody>
            <tr>
                <td>

                
                   
                   <!-- Location Table -->
                    <table cellpadding="0" cellspacing="0" border="0" width="100%" class="bookings-aligntop container-table">
                       <tbody>
                            <tr><th colspan="2"><h2><i class="fa fa-map-marker"></i>Location</h2></th></tr>
                            <tr>
                                <td>
                                    <?php
                                    echo '<label for="apptlocation1">';
                                    _e( 'Select Location 1', 'apartmentlocation_textdomain' );
                                    echo '</label> ';
                                    echo '<select class="widefat" id="apptlocation1" name="apptlocation1">';
                                    echo '<option value="' . esc_attr( $apptlocation1 ) . '" size="25" />' . esc_attr( $apptlocation1 ) . '</option>';
                                        foreach ($options as $option) {
                                            echo '<option id="apptlocation1" name="apptlocation1" value="' . $option->post_title . '" size="25" />' . $option->post_title . '</option>'; 
                                        }
                                        
                                    echo "</select>";
                                    ?> 
                                </td>
                                <td>
                                    <?php
                                    echo '<label for="apptlocation2">';
                                    _e( 'Select Location 2', 'apartmentlocation_textdomain' );
                                    echo '</label> ';
                                    echo '<select class="widefat" id="apptlocation2" name="apptlocation2">';
                                    echo '<option value="' . esc_attr( $apptlocation2 ) . '" size="25" />' . esc_attr( $apptlocation2 ) . '</option>';
                                        foreach ($options as $option) {
                                            echo '<option id="apptlocation2" name="apptlocation2" value="' . $option->post_title . '" size="25" />' . $option->post_title . '</option>'; 
                                        }
                                        
                                    echo "</select>";
                                    ?> 
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                <?php
                                    //building name field
                                    echo '<label for="buildingname">';
                                         _e( 'Enter the building name', 'bookingsbuildingname_textdomain' );
                                    echo '</label>';
                                    echo '<textarea rows="1" class="widefat" name="buildingname" id="buildingname" />';
                                    echo esc_attr( $buildingname );
                                    echo '</textarea>';
                                    ?>
                                    <?php
                                    //Address field
                                    echo '<label for="address">';
                                         _e( 'Enter the street Address', 'bookingsrentalprice_textdomain' );
                                    echo '</label>';
                                    echo '<textarea rows="1" class="widefat" name="address" id="address" />';
                                    echo esc_attr( $address );
                                    echo '</textarea>';
                                    ?>
                                    <?php
                                    //Post Code field
                                    echo '<label for="postcode">';
                                         _e( 'Post Code (this will auto configure the google map)', 'bookingsrentalprice_textdomain' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="postcode" id="postcode" value="' . esc_attr( $postcode ) . '"/>';
                                    ?>
                                </td>
                                <td width="50%">

                                    <?php
                                    //Country field
                                    echo '<label for="town">';
                                         _e( 'Town (type to search)', 'bookingsrentalprice_textdomain' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="town" id="town" value="' . esc_attr( $town ) . '" />';
                                    $pos = country_meta_values('town', 'apartments');                                 
                                    ?>
                                    <script>
                                      jQuery(function() {
                                        var availableTags = [ "<?php echo  implode('","',$pos); ?>" ];
                                        jQuery( "#town" ).autocomplete({
                                          source: availableTags
                                        });
                                      });
                                    </script>


                                    <?php
                                    //State field
                                    echo '<label for="state">';
                                         _e( 'State (type to search)', 'bookingsrentalprice_textdomain' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="state" id="state" value="' . esc_attr( $state ) . '" />';
                                    $state = country_meta_values('state', 'apartments');                                 
                                    ?>
                                    <script>
                                      jQuery(function() {
                                        var availableTags = [ "<?php echo  implode('","',$state); ?>" ];
                                        jQuery( "#state" ).autocomplete({
                                          source: availableTags
                                        });
                                      });
                                    </script>
                                
                                </td>
                            </tr>

                            <tr>                    
                                <td colspan="2" class="haseditor">
                                <label for="additional-info">Additional Location Information</label>
                                    <?php
                                        wp_editor($additionalinfo, 'additionalinfo', $settings = array('wpautop' => false));
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
function apartmentlocation_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['apartmentlocation_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['apartmentlocation_meta_box_nonce'], 'apartmentlocation_meta_box' ) ) {
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
    if ( ! isset( $_POST['apptlocation1'] ) ) {
        return;
    }

    // Sanitize user input.
    $my_data = sanitize_text_field( $_POST['apptlocation1'] );
    $my_data_location2 = sanitize_text_field( $_POST['apptlocation2'] );
    $my_data_buildingname = sanitize_text_field( $_POST['buildingname'] );
    $my_data_address = sanitize_text_field( $_POST['address'] );
    $my_data_postcode = sanitize_text_field( $_POST['postcode'] );
    $my_data_town = sanitize_text_field( $_POST['town'] );
    $my_data_state = sanitize_text_field( $_POST['state'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, 'apptlocation1', $my_data );
    update_post_meta( $post_id, 'apptlocation2', $my_data_location2 );
    update_post_meta( $post_id, 'buildingname', $my_data_buildingname );
    update_post_meta( $post_id, 'address', $my_data_address );
    update_post_meta( $post_id, 'postcode', $my_data_postcode );
    update_post_meta( $post_id, 'town', $my_data_town );
    update_post_meta( $post_id, 'state', $my_data_state );
    update_post_meta( $post_id, 'additionalinfo', $_POST['additionalinfo'] );
}
add_action( 'save_post', 'apartmentlocation_save_meta_box_data' );

?>