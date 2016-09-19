<?php

/**
Adds a Checkin and Checkout Details and Price Meta box to the Apartments Post Type
*/

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function apartmentcheckinandcheckout_add_meta_box() {

    $screens = array( 'apartments' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'apartmentcheckinandcheckout_sectionid',
            __( 'Checkin and Checkout Times', 'apartmentcheckinandcheckout_textdomain' ),
            'apartmentcheckinandcheckout_meta_box_callback',
            $screen,
            'advanced',
            'core'
        );
    }
}
add_action( 'add_meta_boxes', 'apartmentcheckinandcheckout_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function apartmentcheckinandcheckout_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'apartmentcheckinandcheckout_meta_box', 'apartmentcheckinandcheckout_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing values
     * from the database and use the value for the form.
     */

    //get the checkin and price details
    $apptchekintime = get_post_meta( $post->ID, 'apptchekintime', true );
    $apptchekouttime = get_post_meta( $post->ID, 'apptchekouttime', true );

/**
Meta box Contents
*/
?>
 <table cellpadding="0" cellspacing="0" border="0" class="bookings-admin" >
     <tbody>
         <td>

            <table cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop container-table" width="100%">            
                <tbody>
                <tr><th colspan="2"><h2><i class="fa fa-clock-o"></i>Checkin and Checkout Times</h2></th></tr>
                    <tr>
                        <td width="50%">                        
                            <?php
                            //Checkin time field
                            echo '<label for="apptchekintime">';
                                _e( 'Checkin Time', 'bookingscheckin_textdomain' );
                            echo '</label>';
                            echo '<input type="text" class="widefat" name="apptchekintime" id="apptchekintime" value="' . esc_attr( $apptchekintime ) . '"/>';
                            ?>                            
                        </td>
                        <td width="50%">
                            <?php
                            //Ceckout time field
                            echo '<label for="apptchekouttime">';
                                _e( 'Checkout Time', 'bookingscheckin_textdomain' );
                            echo '</label>';
                            echo '<input type="text" class="widefat" name="apptchekouttime" id="apptchekouttime" value="' . esc_attr( $apptchekouttime ) . '"/>';
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>


         </td>
     </tbody>
 </table>

<?php    

}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function apartmentcheckinandcheckout_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['apartmentcheckinandcheckout_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['apartmentcheckinandcheckout_meta_box_nonce'], 'apartmentcheckinandcheckout_meta_box' ) ) {
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
    if ( ! isset( $_POST['apptchekouttime'] ) ) {
        return;
    }

    // Sanitize user input.
    $my_data_apptchekintime = sanitize_text_field( $_POST['apptchekintime'] );
    $my_data_apptchekouttime = sanitize_text_field( $_POST['apptchekouttime'] );

    

    // Update the meta field in the database.
    update_post_meta( $post_id, 'apptchekintime', $my_data_apptchekintime );
    update_post_meta( $post_id, 'apptchekouttime', $my_data_apptchekouttime );

    
}
add_action( 'save_post', 'apartmentcheckinandcheckout_save_meta_box_data' );

?>