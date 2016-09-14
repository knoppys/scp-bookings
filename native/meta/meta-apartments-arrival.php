<?php

/**
Adds a Arrival Process and Emergency Contact box to the Apartments Post Type
*/

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function apartmentsarrival_add_meta_box() {

    $screens = array( 'apartments' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'apartmentsarrival_sectionid',
            __( 'Other Information', 'apartmentsarrival_textdomain' ),
            'apartmentsarrival_meta_box_callback',
            $screen,
            'advanced',
            'core'
        );
    }
}
add_action( 'add_meta_boxes', 'apartmentsarrival_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function apartmentsarrival_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'apartmentsarrival_meta_box', 'apartmentsarrival_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing values
     * from the database and use the value for the form.
     */

    //get the checkin and price details
    $emergencycontact = get_post_meta( $post->ID, 'emergencycontact', true );
    $arrivalprocess = get_post_meta( $post->ID, 'arrivalprocess', true );


/**
Meta box Contents
*/
?>
 <table cellpadding="0" cellspacing="0" border="0" class="bookings-admin" >
     <tbody>
         <td>

            <table cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop container-table" width="100%">            
                <tbody>
                <tr><th colspan="2"><h2><i class="fa fa-info-circle"></i>Other Information</h2></th></tr>
                    <tr>
                        <td>                        
                            <?php
                            //Checkin time field
                            echo '<label for="emergencycontact">';
                                _e( 'Emergency Contact', 'bookingscheckin_textdomain' );
                            echo '</label>';
                            echo '<input type="text" class="widefat" name="emergencycontact" id="emergencycontact" value="' . esc_attr( $emergencycontact ) . '"/>';
                            ?>                            
                        </td>
                    </tr>
                    <tr>                        
                        <td class="haseditor">
                            <?php
                            echo '<label for="arrivalprocess">';
                                _e( 'Arrival Process', 'bookingscheckin_textdomain' );
                            echo '</label>';                            
                            $arrivalprocesssettings = array('media_buttons' => false, 'wpautop' => false);
                            wp_editor($arrivalprocess, 'arrivalprocess', $arrivalprocesssettings);
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
function apartmentsarrival_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['apartmentsarrival_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['apartmentsarrival_meta_box_nonce'], 'apartmentsarrival_meta_box' ) ) {
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
    if ( ! isset( $_POST['arrivalprocess'] ) ) {
        return;
    }

    // Sanitize user input.
    $my_data_emergencycontact = sanitize_text_field( $_POST['emergencycontact'] );


    // Update the meta field in the database.
    update_post_meta( $post_id, 'emergencycontact', $my_data_emergencycontact );
    update_post_meta( $post_id, 'arrivalprocess', $_POST['arrivalprocess'] );

    
}
add_action( 'save_post', 'apartmentsarrival_save_meta_box_data' );

?>