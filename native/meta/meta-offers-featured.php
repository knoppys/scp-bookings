<?php

/**
Adds a Client Meta box to the Bookings Post Type
*/


function specialoffersfeatured_add_meta_box() {

    $screens = array( 'special_offers' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'specialoffersfeatured_sectionid',
            __( 'Featured Offer', 'specialoffersfeatured_textdomain' ),
            'specialoffersfeatured_meta_box_callback',
            $screen,
            'side',
            'low'
        );
    }
}
add_action( 'add_meta_boxes', 'specialoffersfeatured_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function specialoffersfeatured_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'specialoffersfeatured_meta_box', 'specialoffersfeatured_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $isfeatured = get_post_meta( $post->ID, 'isfeatured', true );
    
    ?>
    
    <table cellpadding="0" cellspacing="0" border="0" class="bookings-admin">    
        <tbody>
            <tr>
                <td>

              
               
                <?php
                echo '<label for="isfeatured">';
                _e( 'Is this a featured offer?');
                echo '</label><br/>';
                echo '<input type="checkbox" id="isfeatured"> Featured';
                ?> 

               
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
function specialoffersfeatured_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['specialoffersfeatured_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['specialoffersfeatured_meta_box_nonce'], 'specialoffersfeatured_meta_box' ) ) {
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
    if ( ! isset( $_POST['isfeatured'] ) ) {
        return;
    }

    // Sanitize user input.
    $my_data_isfeatured = sanitize_text_field( $_POST['isfeatured'] );


    // Update the meta field in the database.
    update_post_meta( $post_id, 'isfeatured', $my_data_isfeatured );

}
add_action( 'save_post', 'specialoffersfeatured_save_meta_box_data' );
?>