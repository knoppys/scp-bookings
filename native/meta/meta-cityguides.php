<?php

/**
Adds a City Guides Meta Box to the City Guides Post Type
*/

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function cityguides_add_meta_box() {

    $screens = array( 'cityguides' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'cityguides_sectionid',
            __( 'City Guides', 'cityguides_textdomain' ),
            'cityguides_meta_box_callback',
            $screen
        );
    }
}
add_action( 'add_meta_boxes', 'cityguides_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function cityguides_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'cityguides_meta_box', 'cityguides_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing values
     * from the database and use the value for the form.
     */

    //apartment details
    $wheretoeat = get_post_meta( $post->ID, 'wheretoeat', true );
    $wheretodrink = get_post_meta( $post->ID, 'wheretodrink', true );
    $wheretogoout = get_post_meta( $post->ID, 'wheretogoout', true );
    $wteimg = get_post_meta($post->ID, 'wteimg', true);
    $wtdimg = get_post_meta($post->ID, 'wtdimg', true);
    $wtgoimg = get_post_meta($post->ID, 'wtgoimg', true);

    //Editor Settings
    $settings = array(
      'textarea_rows' => '20',
      )
    



/**
Meta box Contents
*/
?>
 <table class="bookings-admin">
     <tbody>
         <td>
   
            <!--client Contact Table -->
            <table width="100%" class="" cellpadding="0" cellspacing="0" border="0">            
                <tbody>                    
                    <tr>
                        <div id="tabs">
                          <ul>
                            <li><a href="#tabs-1">Where to eat</a></li>
                            <li><a href="#tabs-2">Where to drink</a></li>
                            <li><a href="#tabs-3">Where to go out</a></li>
                          </ul>
                            <div id="tabs-1">
                                <?php
                                /*
                                  Could save a few isses later
                                  wp_editor( stripslashes( $content ), strtolower($value['id']), $settings );
                                   <?php
                                //Corporate pricing field
                                echo '<label for="wteimg">';
                                    _e( '3-7 nights', 'bookingscheckin_textdomain' );
                                echo '</label>';
                                echo '<input type="text" class="widefat" name="wteimg" id="wteimg" value="' . esc_attr( $wteimg ) . '"/>';
                                ?>   
                                */                                                        
                                wp_editor($wheretoeat, 'wheretoeat');     

                                ?>
                                <div class="imgupload">
                                <p>Upload the banner image here.</p>
                                  <input id="wteimg" name="wteimg" type="text" value="<?php echo $wteimg; ?>"/>
                                  <input class="upload_image_button" id="_btn" type="button" value="Upload" />                                                           
                                </div>
                            </div>
                            <div id="tabs-2">
                                <?php
                                /*
                                  Could save a few isses later
                                  wp_editor( stripslashes( $content ), strtolower($value['id']), $settings );
                                */                                    
                                wp_editor($wheretodrink, 'wheretodrink');
                                ?>
                                <div class="imgupload">
                                <p>Upload the banner image here.</p>
                                  <input id="wtdimg" name="wtdimg" type="text" value="<?php echo $wtdimg; ?>" />
                                  <input class="upload_image_button" id="_btn" type="button" value="Upload" />
                                </div>
                               
                            </div>
                            <div id="tabs-3">
                                <?php
                                /*
                                  Could save a few isses later
                                  wp_editor( stripslashes( $content ), strtolower($value['id']), $settings );
                                */
                                wp_editor($wheretogoout, 'wheretogoout');
                                ?>
                                <div class="imgupload">
                                <p>Upload the banner image here.</p>
                                  <input id="wtgoimg" name="wtgoimg" type="text" value="<?php echo $wtgoimg; ?>" />
                                  <input class="upload_image_button" id="_btn" type="button" value="Upload" />
                                </div>
                            </div>                         
                        </div>                             
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
function cityguides_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['cityguides_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['cityguides_meta_box_nonce'], 'cityguides_meta_box' ) ) {
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
    if ( ! isset( $_POST['wheretoeat'] ) ) {
        return;
    }

    // Update the meta field in the database.
    update_post_meta( $post_id, 'wheretoeat', $_POST['wheretoeat'] );
    update_post_meta( $post_id, 'wheretodrink', $_POST['wheretodrink'] );
    update_post_meta( $post_id, 'wheretogoout', $_POST['wheretogoout'] );
    update_post_meta( $post_id, 'wteimg', $_POST['wteimg'] );
    update_post_meta( $post_id, 'wtdimg', $_POST['wtdimg'] );
    update_post_meta( $post_id, 'wtgoimg', $_POST['wtgoimg'] );




}
add_action( 'save_post', 'cityguides_save_meta_box_data' );


?>
