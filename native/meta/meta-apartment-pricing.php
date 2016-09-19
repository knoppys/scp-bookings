<?php

/**
Adds a Price Meta box to the Apartments Post Type
*/

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function apartmentprice_add_meta_box() {

    $screens = array( 'apartments' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'apartmentprice_sectionid',
            __( 'Apartment Pricing', 'apartmentprice_textdomain' ),
            'apartmentprice_meta_box_callback',
            $screen,
            'advanced',
            'core'
        );
    }
}
add_action( 'add_meta_boxes', 'apartmentprice_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function apartmentprice_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'apartmentprice_meta_box', 'apartmentprice_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing values
     * from the database and use the value for the form.
     */

    //get the checkin and price details
    
    $cp37 = get_post_meta($post->ID, 'cp37', true); 
    $cp728 = get_post_meta($post->ID, 'cp728', true); 
    $cp2990 = get_post_meta($post->ID, 'cp2990', true); 
    $cp90 = get_post_meta($post->ID, 'cp90', true); 
    
    $gr37 = get_post_meta($post->ID, 'gr37', true); 
    $gr728 = get_post_meta($post->ID, 'gr728', true); 
    $gr2990 = get_post_meta($post->ID, 'gr2990', true); 
    $gr90 = get_post_meta($post->ID, 'gr90', true); 



/**
Meta box Contents
*/
?>
 <table cellpadding="0" cellspacing="0" border="0" class="bookings-admin" >
     <tbody>
         <td>

            <table cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop container-table" width="100%">            
                <tbody>
                <tr><th colspan="2"><h2><i class="fa fa-gbp"></i>Pricing Information</h2></th></tr>
                    <tr>
                        <td>
                            <div id="pricing-tabs">
                                <ul>
                                    <li><a href="#pricing-tab1">Corporate</a></li>
                                    <li><a href="#pricing-tab2">Group</a></li>                       
                                </ul>
                                <div id="pricing-tab1">
                                   <table cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop" width="100%"> 
                                        <tr>
                                           <td width="25%">
                                                <?php
                                                //Corporate pricing field
                                                echo '<label for="cp37">';
                                                    _e( '3-7 nights', 'bookingscheckin_textdomain' );
                                                echo '</label>';
                                                echo '<input type="text" class="widefat" name="cp37" id="cp37" value="' . esc_attr( $cp37 ) . '"/>';
                                                ?>  
                                           </td> 
                                           <td width="25%">
                                                <?php
                                                //Corporate pricing field
                                                echo '<label for="cp728">';
                                                    _e( '7 - 28 nights', 'bookingscheckin_textdomain' );
                                                echo '</label>';
                                                echo '<input type="text" class="widefat" name="cp728" id="cp728" value="' . esc_attr( $cp728 ) . '"/>';
                                                ?>  
                                           </td>
                                           <td width="25%">
                                                <?php
                                                //Corporate pricing field
                                                echo '<label for="cp2990">';
                                                    _e( '29 - 90 nights', 'bookingscheckin_textdomain' );
                                                echo '</label>';
                                                echo '<input type="text" class="widefat" name="cp2990" id="cp2990" value="' . esc_attr( $cp2990 ) . '"/>';
                                                ?>  
                                           </td>
                                           <td width="25%">
                                                <?php
                                                //Corporate pricing field
                                                echo '<label for="cp90">';
                                                    _e( '90 + nights ', 'bookingscheckin_textdomain' );
                                                echo '</label>';
                                                echo '<input type="text" class="widefat" name="cp90" id="cp90" value="' . esc_attr( $cp90 ) . '"/>';
                                                ?>  
                                           </td>
                                       </tr>
                                   </table>

                                </div>
                                <div id="pricing-tab2">
                                    <table cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop" width="100%"> 
                                        <tr>
                                           <td width="25%">
                                                <?php
                                                //Corporate pricing field
                                                echo '<label for="gr37">';
                                                    _e( '3-7 nights', 'bookingscheckin_textdomain' );
                                                echo '</label>';
                                                echo '<input type="text" class="widefat" name="gr37" id="gr37" value="' . esc_attr( $gr37 ) . '"/>';
                                                ?>  
                                           </td> 
                                           <td width="25%">
                                                <?php
                                                //Corporate pricing field
                                                echo '<label for="gr728">';
                                                    _e( '7 - 28 nights', 'bookingscheckin_textdomain' );
                                                echo '</label>';
                                                echo '<input type="text" class="widefat" name="gr728" id="gr728" value="' . esc_attr( $gr728 ) . '"/>';
                                                ?>  
                                           </td>
                                           <td width="25%">
                                                <?php
                                                //Corporate pricing field
                                                echo '<label for="gr2990">';
                                                    _e( '29 - 90 nights', 'bookingscheckin_textdomain' );
                                                echo '</label>';
                                                echo '<input type="text" class="widefat" name="gr2990" id="gr2990" value="' . esc_attr( $gr2990 ) . '"/>';
                                                ?>  
                                           </td>
                                           <td width="25%">
                                                <?php
                                                //Corporate pricing field
                                                echo '<label for="gr90">';
                                                    _e( '90 + nights ', 'bookingscheckin_textdomain' );
                                                echo '</label>';
                                                echo '<input type="text" class="widefat" name="gr90" id="gr90" value="' . esc_attr( $gr90 ) . '"/>';
                                                ?>  
                                           </td>
                                       </tr>
                                    </table>
                                </div>
                            </div>
                    


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
function apartmentprice_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['apartmentprice_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['apartmentprice_meta_box_nonce'], 'apartmentprice_meta_box' ) ) {
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
    if ( ! isset( $_POST['cp37'] ) ) {
        return;
    }

    // Sanitize user input.
    $my_data_cp37 = sanitize_text_field( $_POST['cp37'] );
    $my_data_gr37 = sanitize_text_field( $_POST['gr37'] );

    $my_data_cp728 = sanitize_text_field( $_POST['cp728'] );
    $my_data_gr728 = sanitize_text_field( $_POST['gr728'] );

    $my_data_cp2990 = sanitize_text_field( $_POST['cp2990'] );
    $my_data_gr2990 = sanitize_text_field( $_POST['gr2990'] );

    $my_data_cp90 = sanitize_text_field( $_POST['cp90'] );
    $my_data_gr90 = sanitize_text_field( $_POST['gr90'] );

    

    // Update the meta field in the database.
    update_post_meta( $post_id, 'cp37', $my_data_cp37 );
    update_post_meta( $post_id, 'gr37', $my_data_gr37 );

    update_post_meta( $post_id, 'cp728', $my_data_cp728 );
    update_post_meta( $post_id, 'gr728', $my_data_gr728 );

    update_post_meta( $post_id, 'cp2990', $my_data_cp2990 );
    update_post_meta( $post_id, 'gr2990', $my_data_gr2990 );

    update_post_meta( $post_id, 'cp90', $my_data_cp90 );
    update_post_meta( $post_id, 'gr90', $my_data_gr90 );

    
}
add_action( 'save_post', 'apartmentprice_save_meta_box_data' );

?>