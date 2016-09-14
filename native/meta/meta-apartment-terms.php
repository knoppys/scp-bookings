<?php

/**
Adds a Terms Meta box to the Apartments Post Type
*/

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function apartmentterms_add_meta_box() {

    $screens = array( 'apartments' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'apartmentterms_sectionid',
            __( 'Terms and Conditions', 'apartmentterms_textdomain' ),
            'apartmentterms_meta_box_callback',
            $screen,
            'advanced',
            'core'
        );
    }
}
add_action( 'add_meta_boxes', 'apartmentterms_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function apartmentterms_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'apartmentterms_meta_box', 'apartmentterms_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing values
     * from the database and use the value for the form.
     */

    //get the checkin and price details
    $Corporate = get_post_meta( $post->ID, 'Corporate', true );
    $Groups = get_post_meta( $post->ID, 'Groups', true );
    $Leisure = get_post_meta( $post->ID, 'Leisure', true );
    $frontendcancellation = get_post_meta($post->ID, 'frontendcancellation', true);


/**
Meta box Contents
*/
?>
 <table cellpadding="0" cellspacing="0" border="0" class="bookings-admin" >
     <tbody>
         <td>

            <table cellpadding="0" cellspacing="0" border="0" class="bookings-aligntop container-table" width="100%">            
                <tbody>
                <tr><th><h2><i class="fa fa-gbp"></i>Terms and Conditions</h2></th></tr>
                    <tr>
                        <td>
                            <div id="tabs">
                                <ul>
                                    <li><a href="#tab1">Corporate Terms</a></li>
                                    <li><a href="#tab2">Group Terms</a></li>
                                    <li><a href="#tab3">Leisure Terms</a></li>
                                    <li><a href="#tab4">Front End Cancellation Terms</a></li>
                                </ul>
                                <div id="tab1">
                                    <?php                                                        
                                    wp_editor($Corporate, 'Corporate', $settings = array('wpautop' => false));                                  
                                    ?>                        
                                </div>
                                <div id="tab2">
                                    <?php                                    
                                    wp_editor($Groups, 'Groups', $settings = array('wpautop' => false));
                                    ?>
                                </div>
                                <div id="tab3">
                                    <?php
                                    wp_editor($Leisure, 'Leisure', $settings = array('wpautop' => false));
                                    ?>
                                </div>
                                <div id="tab4">
                                    <?php
                                    wp_editor($frontendcancellation, 'frontendcancellation', $settings = array('wpautop' => false));
                                    ?>
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
function apartmentterms_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['apartmentterms_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['apartmentterms_meta_box_nonce'], 'apartmentterms_meta_box' ) ) {
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
  


    // Update the meta field in the database.
    update_post_meta( $post_id, 'Corporate', $_POST['Corporate'] );
    update_post_meta( $post_id, 'Groups', $_POST['Groups'] );
    update_post_meta( $post_id, 'Leisure', $_POST['Leisure'] );
    update_post_meta( $post_id, 'frontendcancellation', $_POST['frontendcancellation'] );

    
}
add_action( 'save_post', 'apartmentterms_save_meta_box_data' );

?>