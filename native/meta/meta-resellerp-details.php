<?php

/**
Adds a Lead Guest Meta box to the Bookings Post Type
*/

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function resellerdetails_add_meta_box() {

    $screens = array( 'resellerp' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'resellerdetails_sectionid',
            __( 'Reseller Details', 'resellerdetails_textdomain' ),
            'resellerdetails_meta_box_callback',
            $screen,
            'advanced',
            'core'
        );

    }
}
add_action( 'add_meta_boxes', 'resellerdetails_add_meta_box' );


/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function resellerdetails_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'resellerdetails_meta_box', 'resellerdetails_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing values
     * from the database and use the value for the form.
     */

    //lead guest details
    $resellerp_clientname = get_post_meta( $post->ID, 'resellerp_clientname', true );
    $resellerp_address = get_post_meta( $post->ID, 'resellerp_address', true );
    $resellerp_phone = get_post_meta( $post->ID, 'resellerp_phone', true );
    $resellerp_website = get_post_meta( $post->ID, 'resellerp_website', true );
    $resellerp_terms = get_post_meta( $post->ID, 'resellerp_terms', true );
    $resellerp_email = get_post_meta( $post->ID, 'resellerp_email', true );
    $resellerp_pageurl = get_post_meta( $post->ID, 'resellerp_pageurl', true );
    $scphs = get_post_meta( $post->ID, 'scphs', true );
    $shs = get_post_meta( $post->ID, 'shs', true );

    



/**
Meta box Contents
*/
?>
 <table cellpadding="0" cellspacing="0" border="0" class="bookings-admin" >
     <tbody>
         <td>
      
            <!-- Apartment Table -->
            <table cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop container-table" width="100%">            
                <tbody>
                <tr><th><h2><i class="fa fa-user"></i>Reseller Details</h2></th></tr>
                    <tr>
                        <td> 
                            <table width="100%">
                                <tbody>
                                    <tr>
                                        <td>
                                            <?php
                                            //Name field
                                            echo '<label for="resellerp_clientname">';
                                                _e( 'Client Name', 'bookingscheckin_textdomain' );
                                            echo '</label>';
                                            echo '<input type="text" class="widefat" name="resellerp_clientname" id="resellerp_clientname" value="' . esc_attr( $resellerp_clientname ) . '"/>';
                                            ?>
                                        </td>                                        
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php
                                            //Name field
                                            echo '<label for="resellerp_email">';
                                                _e( 'Client Email', 'bookingscheckin_textdomain' );
                                            echo '</label>';
                                            echo '<input type="text" class="widefat" name="resellerp_email" id="resellerp_email" value="' . esc_attr( $resellerp_email ) . '"/>';
                                            ?>
                                        </td>                                        
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php
                                            //Name field
                                            echo '<label for="resellerp_address">';
                                                _e( 'Address', 'bookingscheckin_textdomain' );
                                            echo '</label>';
                                            echo '<input type="text" class="widefat" name="resellerp_address" id="resellerp_address" value="' . esc_attr( $resellerp_address ) . '"/>';
                                            ?>
                                        </td>                                        
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php
                                            //Name field
                                            echo '<label for="resellerp_phone">';
                                                _e( 'Phone', 'bookingscheckin_textdomain' );
                                            echo '</label>';
                                            echo '<input type="text" class="widefat" name="resellerp_phone" id="resellerp_phone" value="' . esc_attr( $resellerp_phone ) . '"/>';
                                            ?>
                                        </td>                                        
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php
                                            //Name field
                                            echo '<label for="resellerp_website">';
                                                _e( 'Website', 'bookingscheckin_textdomain' );
                                            echo '</label>';
                                            echo '<input type="text" class="widefat" name="resellerp_website" placeholder="Enter full URL for example: http://www.website.com"id="resellerp_website" value="' . esc_attr( $resellerp_website ) . '"/>';
                                            ?>
                                        </td>                                        
                                    </tr>  
                                    <tr>
                                        <td>
                                            <?php
                                            //Name field
                                            echo '<label for="resellerp_pageurl">';
                                                _e( 'Page URL', 'bookingscheckin_textdomain' );
                                            echo '</label>';
                                            echo '<input type="text" class="widefat" name="resellerp_pageurl" placeholder="If the client requires hosting space, please enter the clients subdomain here"id="resellerp_pageurl" value="' . esc_attr( $resellerp_pageurl ) . '"/>';
                                            ?>
                                        </td>                                    
                                    </tr>  
                                    <tr class="table" align="" style="padding: 0px !important;">
                                        <td>
                                            <table width="100%" style="background:#e2e2e2;border-radius:4px;">
                                                <tr>
                                                    <td width="30%">
                                                        <p id="shs"><strong>Self Hosted Solution</strong><input name="shs" style="background:none;border:none;box-shadow:inset 0 0px 0px rgba(0,0,0,.07)" readonly type="hidden" value="" /><span id="addhere1"><?php if($scphs){echo $shs;}?></span></p>
                                                        <p>Click here to send the client an email with the download link to the Reseller Script instrcutions and regarding its setup.</p>
                                                        <a class="wp-core-ui button-primary" role="button">Send Reseller Email</a>                              
                                                    </td>   
                                                    <td width="30%">
                                                        <p id="scphs"><strong>SCP Hosted Solution</strong><input name ="scphs" style="background:none;border:none;box-shadow:inset 0 0px 0px rgba(0,0,0,.07)" readonly type="hidden" value="" /><span id="addhere2"><?php if($scphs){echo $scphs;}?></span></p>
                                                        <p>Click here to send the client an email with instructions to use the SCP Hosted Reseller Script and create an entry on the SCP Server.</p>
                                                        <a id="createreseller" class="wp-core-ui button-primary" role="button">Create Reseller</a>
                                                    </td>
                                                    <td width="30%">
                                                        <p><strong>Delete SCP Hosted Solution</strong></p>
                                                        <p>Click here to permenantly remove the resellers entry from the SCP Server.</p>
                                                        <a class="wp-core-ui button-primary" role="button">Delete Reseller</a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>                    
                                    </tr>                                 
                                    <tr>
                                        <td>
                                            <?php
                                            //building name field
                                            echo '<label for="resellerp_terms">';
                                                 _e( 'Reseller Terms', 'bookingsbuildingname_textdomain' );
                                            echo '</label>';
                                            echo '<textarea rows="12" class="widefat" name="resellerp_terms" id="resellerp_terms" />';
                                            echo esc_attr( $resellerp_terms );
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
function resellerdetails_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['resellerdetails_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['resellerdetails_meta_box_nonce'], 'resellerdetails_meta_box' ) ) {
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
    if ( ! isset( $_POST['resellerp_clientname'] ) ) {
        return;
    }

    $my_data = sanitize_text_field( $_POST['resellerp_clientname'] );
    $my_data_location2 = sanitize_text_field( $_POST['resellerp_address'] );
    $my_data_buildingname = sanitize_text_field( $_POST['resellerp_phone'] );
    $my_data_address = sanitize_text_field( $_POST['resellerp_website'] );
    $my_data_town = sanitize_text_field( $_POST['resellerp_terms'] );
    $my_data_email = sanitize_text_field( $_POST['resellerp_email'] );
    $my_data_pageurl = sanitize_text_field( $_POST['resellerp_pageurl'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, 'resellerp_clientname', $my_data );
    update_post_meta( $post_id, 'resellerp_address', $my_data_location2 );
    update_post_meta( $post_id, 'resellerp_phone', $my_data_buildingname );
    update_post_meta( $post_id, 'resellerp_website', $my_data_address );
    update_post_meta( $post_id, 'resellerp_terms', $my_data_town );
    update_post_meta( $post_id, 'resellerp_email', $my_data_email );
    update_post_meta( $post_id, 'resellerp_pageurl', $my_data_pageurl );

    //no santitize
    update_post_meta( $post_id, 'scphs', ( $_POST['scphs'] ) );
    update_post_meta( $post_id, 'shs', ( $_POST['shs'] ) );
   
    
}
add_action( 'save_post', 'resellerdetails_save_meta_box_data' );

?>