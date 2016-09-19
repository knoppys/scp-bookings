<?php

/**
Adds an Operator Meta box to the Bookings Post Type
*/

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function bookingsoperator_add_meta_box() {

    $screens = array( 'apartments' );
    
    foreach ( $screens as $screen ) {

        add_meta_box(
            'bookingsoperator_sectionid',
            __( 'Operator Name', 'bookingsoperator_textdomain' ),
            'bookingsoperator_meta_box_callback',
            $screen,
            'advanced',
            'low'
        );
    }
}
add_action( 'add_meta_boxes', 'bookingsoperator_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function bookingsoperator_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'bookingsoperator_meta_box', 'bookingsoperator_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $operatorname = get_post_meta( $post->ID, 'operatorname', true );
    $operatoremail = get_post_meta( $post->ID, 'operatoremail', true);
    $operatorphone = get_post_meta( $post->ID, 'operatorphone', true);
    $operators = get_posts(
        array(
            'post_type'   => 'operators', 
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
                
                <?php

                //get the post status
                $post_status = get_post_status( $ID );                 
                if ($post_status == 'auto-draft') { ?>

                   
                    <table cellpadding="0" cellspacing="0" border="0" width="100%" class="container-table">
                       <tbody>
                            <tr><th colspan="2"><h2><i class="fa fa-plane"></i>Operator name</h2></th></tr>
                            <tr>
                                <td colspan="2">
                                    <?php
                                    echo '<label for="operatorname">';
                                    _e( 'Select the Operator', 'bookingsoperator_textdomain' );
                                    echo '</label> ';
                                    echo '<select class="widefat" id="operatorname" name="operatorname">';
                                    echo '<option  value="' . esc_attr( $operatorname ) . '" size="25" />' . esc_attr( $operatorname ) . '</option>';
                                        foreach ($operators as $operator) {
                                            echo '<option value="' . $operator->post_title . '" size="25" />' . $operator->post_title . '</option>'; 
                                        }                                        
                                    echo "</select>";                                
                                    ?>                                
                                </td>
                            </tr>
                            <tr id="operatorajax">
                                <!-- TO GO HERE -->
                            </tr>
                       </tbody>
                    </table>

                    <?php } else { ?>

                    <table cellpadding="0" cellspacing="0" border="0" width="100%" class="container-table">
                        <tbody>
                            <tr><th colspan="2"><h2><i class="fa fa-building"></i>operator name</h2></th></tr>
                            <tr>
                                <td colspan="2">
                                    <?php
                                    echo '<label for="operatorname">';
                                    _e( 'Select the operator', 'bookingsoperator_textdomain' );
                                    echo '</label> ';
                                    echo '<select class="widefat" id="operatorname" name="operatorname">';
                                    echo '<option value="' . esc_attr( $operatorname ) . '" size="25" />' . esc_attr( $operatorname ) . '</option>';
                                        foreach ($operators as $operator) {
                                            echo '<option value="' . $operator->post_title . '" size="25" />' . $operator->post_title . '</option>'; 
                                        }
                                        
                                    echo "</select>";
                                    ?> 
                                </td>
                            </tr>                         

                            <tr>
                               <td>
                                    <?php
                                    //deposit date field
                                    echo '<label for="operatorphone">';
                                         _e( 'operator Phone', 'bookingsrentalprice_textdomain' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="operatorphone" id="operatorphone" value="' . esc_attr( $operatorphone ) . '"/>';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    //deposit date field
                                    echo '<label for="operatoremail">';
                                         _e( 'operator Email', 'bookingsrentalprice_textdomain' );
                                    echo '</label>';
                                    echo '<input type="text" class="widefat" name="operatoremail" id="operatoremail" value="' . esc_attr( $operatoremail ) . '"/>';

                                    ?>
                               </td>
                            </tr>                              
                             
                        </tbody>
                    </table>

                <?php } ?> 

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
function bookingsoperator_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['bookingsoperator_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['bookingsoperator_meta_box_nonce'], 'bookingsoperator_meta_box' ) ) {
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
    if ( ! isset( $_POST['operatorname'] ) ) {
        return;
    }

    // Sanitize user input.
    $my_data_operatorname = sanitize_text_field( $_POST['operatorname'] );
    $my_data_operatoremail = sanitize_text_field( $_POST['operatoremail'] );
    $my_data_operatorphone = sanitize_text_field( $_POST['operatorphone'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, 'operatorname', $my_data_operatorname );
    update_post_meta( $post_id, 'operatoremail', $my_data_operatoremail );
    update_post_meta( $post_id, 'operatorphone', $my_data_operatorphone );
}
add_action( 'save_post', 'bookingsoperator_save_meta_box_data' );

?>