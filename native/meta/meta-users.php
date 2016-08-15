<?php

add_action( 'show_user_profile', 'add_extra_social_links' );
add_action( 'edit_user_profile', 'add_extra_social_links' );

function add_extra_social_links( $user ) { ?>

        <h3>Web App Information</h3>

        <table class="form-table">

            <tr>
                <th><label for="companyname">Company Name</label></th>
                <td>
                    <select name="companyname">
                        <option><?php echo esc_attr( get_the_author_meta( 'companyname', $user->ID ) ); ?></option>
                        <?php
                        $args = array(
                            'post_type' => array('operators','clients'),
                            'posts_per_page' => -1,
                            'orderby' => 'title',
                            ); 
                        $myposts = get_posts( $args );
                        foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
                            <option value="<?php echo $post->post_title; ?>">
                              <?php echo $post->post_title; ?>  
                            </option>                      
                        <?php endforeach; ?>
                        <?php wp_reset_postdata();?>
                    </select>              
                </td>                         
            </tr>           

            <tr>
                <th><label for="companyadmin">Is this user a company admin.</label></th>
                <td>
                    <select name="companyadmin" id="companyadmin">
                        <option><?php echo esc_attr( get_the_author_meta( 'companyadmin', $user->ID ) ); ?></option>
                        <option value="Y">Yes, is admin</option>
                        <option value="N">No, is not admin</option>
                    </select>
                </td>
            </tr>
            
        </table>
    <?php
}


add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );
 
function my_save_extra_profile_fields( $user_id ) {
 
    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
 
    /* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
    update_usermeta( $user_id, 'companyadmin', $_POST['companyadmin'] );
    update_usermeta( $user_id, 'companyname', $_POST['companyname'] );
}


?>