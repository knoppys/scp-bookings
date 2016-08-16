<?php
/**
Adds a Location Details Meta box to the Apartments Post Type
*/

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function locationinfo_add_meta_box() {

    $screens = array( 'Locations' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'locationinfo_sectionid',
            __( 'Location Details', 'locationinfo_textdomain' ),
            'locationinfo_meta_box_callback',
            $screen,
            'advanced',
            'high'

        );
    }
}
add_action( 'add_meta_boxes', 'locationinfo_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function locationinfo_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'locationinfo_meta_box', 'locationinfo_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $cityoffers = get_post_meta( $post->ID, 'cityoffers', true );
    $areainformation = get_post_meta( $post->ID, 'areainformation', true );
    $reviews = get_post_meta( $post->ID, 'reviews', true );
    $cityguide = get_post_meta( $post->ID, 'cityguide', true );
    $cityguides = get_posts(
        array(
            'post_type'   => 'cityguides', 
            'orderby'     => 'title', 
            'order'       => 'ASC', 
            'numberposts' => -1 
        )
    ); 
    ?>
    
    <table cellpadding="0" cellspacing="0" border="0" class="bookings-admin">    
        <tbody>
            <tr>
                <td>

                
                   
                   <!-- Location Table -->
                    <table cellpadding="0" cellspacing="0" border="0" width="100%" class="bookings-aligntop container-table">
                       <tbody>
                            <tr><th>Additional Location Information</th></tr>
                            <tr>
                                <td>
                                    <?php
                                    echo '<label for="City Guide">';
                                    _e( 'Select the City Guide', 'bookingsoperator_textdomain' );
                                    echo '</label> ';
                                    echo '<select class="widefat" id="cityguide" name="cityguide">';
                                    echo '<option  value="' . esc_attr( $cityguide ) . '" size="25" />' . esc_attr( $cityguide ) . '</option>';
                                        foreach ($cityguides as $cityguide) {
                                            echo '<option value="' . $cityguide->post_title . '" size="25" />' . $cityguide->post_title . '</option>'; 
                                        }                                        
                                    echo "</select>";                                
                                    ?>     
                                </td>
                            </tr>
                            <tr>                    
                                <td class="haseditor">
                                <label for="additional-info">City Offers</label>
                                   <?php
                                    $cityofferscontent = esc_attr( $cityoffers );
                                    $cityofferssettings = array('wpautop' => true, 'textarea_name' => 'cityoffers', 'media_buttons' => false);
                                    wp_editor(html_entity_decode($cityofferscontent), 'cityoffers', $cityofferssettings);
                                    ?>
                                </td>
                            </tr>
                            <tr>                    
                                <td class="haseditor">
                                <label for="additional-info">Area Information</label>
                                   <?php
                                    $areainformationcontent = esc_attr( $areainformation );
                                    $areainformationsettings = array('wpautop' => true, 'textarea_name' => 'areainformation', 'media_buttons' => false);
                                    wp_editor(html_entity_decode($areainformationcontent), 'areainformation', $areainformationsettings);
                                    ?>
                                </td>
                            </tr>
                            <tr>                    
                                <td class="haseditor">
                                <label for="additional-info">Reviews</label>
                                   <?php
                                    $reviewscontent = esc_attr( $reviews );
                                    $reviewssettings = array('wpautop' => true, 'textarea_name' => 'reviews', 'media_buttons' => false);
                                    wp_editor(html_entity_decode($reviewscontent), 'reviews', $reviewssettings);
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
function locationinfo_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['locationinfo_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['locationinfo_meta_box_nonce'], 'locationinfo_meta_box' ) ) {
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
    if ( ! isset( $_POST['cityoffers'] ) ) {
        return;
    }

   
    

    // Update the meta field in the database.
    update_post_meta( $post_id, 'cityoffers', $_POST['cityoffers'] );
    update_post_meta( $post_id, 'areainformation', $_POST['areainformation'] );
    update_post_meta( $post_id, 'reviews', $_POST['reviews'] );
    update_post_meta( $post_id, 'cityguide', $_POST['cityguide'] );
   
}
add_action( 'save_post', 'locationinfo_save_meta_box_data' );

?>