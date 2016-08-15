<?php

/**
Adds a Apartment Meta box to the Bookings Post Type
*/

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function operatordetails_add_meta_box() {

    $screens = array( 'Operators' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'operatordetails_sectionid',
            __( 'Operator Details', 'operatordetails_textdomain' ),
            'operatordetails_meta_box_callback',
            $screen
        );
    }
}
add_action( 'add_meta_boxes', 'operatordetails_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function operatordetails_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'operatordetails_meta_box', 'operatordetails_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing values
     * from the database and use the value for the form.
     */

    //apartment details
    $operatorcontact = get_post_meta( $post->ID, 'operatorcontact', true );
    $operatortelephone = get_post_meta( $post->ID, 'operatortelephone', true );
    $operatoremail = get_post_meta( $post->ID, 'operatoremail', true );
    $operatoraddress = get_post_meta( $post->ID, 'operatoraddress', true );
    $operatorref = get_post_meta( $post->ID, 'operatorref', true );
    $operatormobile = get_post_meta( $post->ID, 'operatormobile', true );
    $operatorfax = get_post_meta( $post->ID, 'operatorfax', true );
   




/**
Meta box Contents
*/
?>
 <table class="bookings-admin">
     <tbody>
         <td>
   
            <!--Operator Contact Table -->
            <table width="100%" class="container-table" cellpadding="0" cellspacing="0" border="0">            
                <tbody>
                    <tr><th colspan="3"><h2><i class="fa fa-home"></i>Operator Details</h2></th></tr>
                    <tr>
                        <td width="50%">                        
                            <?php
                            //Contact name
                            echo '<label for="operatorcontact">';
                                _e( 'Operator Contact Name', 'bookingscheckin_textdomain' );
                            echo '</label>';
                            echo '<input type="text" class="widefat" name="operatorcontact" id="operatorcontact" value="' . esc_attr( $operatorcontact ) . '"/>';
                            ?>
                            <?php
                            //Telephone
                            echo '<label for="operatortelephone">';
                                _e( 'Telephone', 'bookingscheckin_textdomain' );
                            echo '</label>';
                            echo '<input type="text" class="widefat" name="operatortelephone" id="operatortelephone" value="' . esc_attr( $operatortelephone ) . '"/>';
                            ?>
                            <?php
                            //Telephone
                            echo '<label for="operatormobile">';
                                _e( 'Telephone (Mobile)', 'bookingscheckin_textdomain' );
                            echo '</label>';
                            echo '<input type="text" class="widefat" name="operatormobile" id="operatormobile" value="' . esc_attr( $operatormobile ) . '"/>';
                            ?>  
                            <?php
                            //Telephone
                            echo '<label for="Operator Fax">';
                                _e( 'Fax', 'bookingscheckin_textdomain' );
                            echo '</label>';
                            echo '<input type="text" class="widefat" name="Operator Fax" id="Operator Fax" value="' . esc_attr( $Operatorfax ) . '"/>';
                            ?>  
                            <?php
                            //Email
                            echo '<label for="operatoremail">';
                                _e( 'Operator Email Address (comma separated)', 'bookingscheckin_textdomain' );
                            echo '</label>';
                            echo '<input type="text" class="widefat" name="operatoremail" id="operatoremail" value="' . esc_attr( $operatoremail ) . '"/>';
                            ?>                           
                        </td>
                        <td width="50%">
                            <?php
                            //Address
                            echo '<label for="operatoraddress">';
                                _e( 'Address', 'bookingscheckin_textdomain' );
                            echo '</label>';
                            echo '<textarea rows="3" class="widefat" name="operatoraddress" id="operatoraddress" />';
                                echo esc_attr( $operatoraddress );
                            echo '</textarea>';
                            ?> 
                            <?php
                            //Email
                            echo '<label for="operatorref">';
                                _e( 'Operator Ref', 'bookingscheckin_textdomain' );
                            echo '</label>';
                            echo '<input type="text" class="widefat" name="operatorref" id="operatorref" value="' . esc_attr( $operatorref ) . '"/>';
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
function operatordetails_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['operatordetails_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['operatordetails_meta_box_nonce'], 'operatordetails_meta_box' ) ) {
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
    if ( ! isset( $_POST['operatoremail'] ) ) {
        return;
    }

    // Sanitize user input.
    $my_data_operatoremail = sanitize_text_field( $_POST['operatoremail'] );
    $my_data_operatorcontact = sanitize_text_field( $_POST['operatorcontact'] );
    $my_data_operatortelephone = sanitize_text_field( $_POST['operatortelephone'] );
    $my_data_operatoraddress = sanitize_text_field( $_POST['operatoraddress'] );
    $my_data_operatorref = sanitize_text_field( $_POST['operatorref'] );
    $my_data_operatormobile = sanitize_text_field( $_POST['operatormobile'] );
    $my_data_operatorfax = sanitize_text_field( $_POST['operatorfax'] );
   

    // Update the meta field in the database.
    update_post_meta( $post_id, 'operatoremail', $my_data_operatoremail );
    update_post_meta( $post_id, 'operatorcontact', $my_data_operatorcontact );
    update_post_meta( $post_id, 'operatortelephone', $my_data_operatortelephone );
    update_post_meta( $post_id, 'operatoraddress', $my_data_operatoraddress );
    update_post_meta( $post_id, 'operatorref', $my_data_operatorref );
    update_post_meta( $post_id, 'operatormobile', $my_data_operatormobile );
    update_post_meta( $post_id, 'operatorfax', $my_data_operatorfax );
}
add_action( 'save_post', 'operatordetails_save_meta_box_data' );


?>
