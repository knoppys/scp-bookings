<?php

/**
Adds a Client Details Meta Box to the Client Post Type
*/

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function clientdetails_add_meta_box() {

    $screens = array( 'clients' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'clientdetails_sectionid',
            __( 'Client Details', 'clientdetails_textdomain' ),
            'clientdetails_meta_box_callback',
            $screen
        );
    }
}
add_action( 'add_meta_boxes', 'clientdetails_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function clientdetails_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'clientdetails_meta_box', 'clientdetails_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing values
     * from the database and use the value for the form.
     */

    //apartment details
    $clientcontact = get_post_meta( $post->ID, 'clientcontact', true );
    $clientphone = get_post_meta( $post->ID, 'clientphone', true );
    $clientemail = get_post_meta( $post->ID, 'clientemail', true );
    $clientaddress = get_post_meta( $post->ID, 'clientaddress', true );
   




/**
Meta box Contents
*/
?>
 <table class="bookings-admin">
     <tbody>
         <td>
   
            <!--client Contact Table -->
            <table width="100%" class="container-table" cellpadding="0" cellspacing="0" border="0">            
                <tbody>
                    <tr><th colspan="3"><h2><i class="fa fa-home"></i>Client Details</h2></th></tr>
                    <tr>
                        <td width="50%">                        
                            <?php
                            //Contact name
                            echo '<label for="clientcontact">';
                                _e( 'Client Contact Name', 'bookingscheckin_textdomain' );
                            echo '</label>';
                            echo '<input type="text" class="widefat" name="clientcontact" id="clientcontact" value="' . esc_attr( $clientcontact ) . '"/>';
                            ?>
                           <?php
                            //Telephone
                            echo '<label for="clientphone">';
                                _e( 'Telephone Number', 'bookingscheckin_textdomain' );
                            echo '</label>';
                            echo '<input type="text" class="widefat" name="clientphone" id="clientphone" value="' . esc_attr( $clientphone ) . '"/>';
                            ?>  
                            <?php
                            //Email
                            echo '<label for="clientemail">';
                                _e( 'Client Email Address (comma separated)', 'bookingscheckin_textdomain' );
                            echo '</label>';
                            echo '<input type="text" class="widefat" name="clientemail" id="clientemail" value="' . esc_attr( $clientemail ) . '"/>';
                            ?>                           
                        </td>
                        <td width="50%">
                            <?php
                            //Address
                            echo '<label for="clientaddress">';
                                _e( 'Address', 'bookingscheckin_textdomain' );
                            echo '</label>';
                            echo '<textarea rows="3" class="widefat" name="clientaddress" id="clientaddress" />';
                                echo esc_attr( $clientaddress );
                            echo '</textarea>';
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
function clientdetails_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['clientdetails_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['clientdetails_meta_box_nonce'], 'clientdetails_meta_box' ) ) {
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
    if ( ! isset( $_POST['clientemail'] ) ) {
        return;
    }

    // Sanitize user input.
    $my_data_clientemail = sanitize_text_field( $_POST['clientemail'] );
    $my_data_clientcontact = sanitize_text_field( $_POST['clientcontact'] );
    $my_data_clientphone = sanitize_text_field( $_POST['clientphone'] );
    $my_data_clientaddress = sanitize_text_field( $_POST['clientaddress'] );
   

    // Update the meta field in the database.
    update_post_meta( $post_id, 'clientemail', $my_data_clientemail );
    update_post_meta( $post_id, 'clientcontact', $my_data_clientcontact );
    update_post_meta( $post_id, 'clientphone', $my_data_clientphone );
    update_post_meta( $post_id, 'clientaddress', $my_data_clientaddress );
    



}
add_action( 'save_post', 'clientdetails_save_meta_box_data' );


?>