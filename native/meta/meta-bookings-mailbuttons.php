<?php
/**
Adds a Location Details Meta box to the Apartments Post Type
*/

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function emailbuttons_add_meta_box() {

    $screens = array( 'bookings' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'emailbuttons_sectionid',
            __( 'Related Bookings', 'emailbuttons_textdomain' ),
            'emailbuttons_meta_box_callback',
            $screen,
            'side',
            'core'

        );
    }
}

add_action( 'add_meta_boxes', 'emailbuttons_add_meta_box' );




/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function emailbuttons_meta_box_callback( $post ) { 

  ?>                  
                   
       <!-- Location Table -->
        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="bookings-aligntop">
           <tbody>                            
                <tr>
                    <td>                                          
                        <?php
                        
                        //if this is a child booking
                        if ($post->post_parent) {                                     
                          
                          $args = array(
                            'post_type' =>  'bookings',
                            'post_parent' =>  $post->post_parent,                                        
                            );

                          $myposts = get_posts( $args ); ?>                          
                          <table class="relatedbookings">
                            <tbody>                                 
                                  <tr>
                                    <td class="childheader"><strong>Apartment name</strong></td>
                                    <td class="childheader"><strong>Checkin</strong></td>
                                    <td class="childheader"><strong>Checkout</strong></td>
                                  </tr>
                                   <tr class="parentbooking">
                                    <td><a href="post.php?post=<?php echo $post->post_parent; ?>&action=edit"><?php echo get_post_meta($post->post_parent, 'apartmentname', true); ?></a> </td>
                                    <td class=""><?php echo get_post_meta($post->post_parent, 'arrivaldate', true); ?></td>
                                    <td class=""><?php echo get_post_meta($post->post_parent, 'leavingdate', true); ?></td>
                                  </tr>
                              <?php
                                foreach ($myposts as $child) { ?>                                  
                                  <tr>
                                    <td class="childcontent"><a href="post.php?post=<?php echo $child->ID; ?>&action=edit"><?php echo get_post_meta($child->ID, 'apartmentname', true); ?></td>
                                    <td class="childcontent"><?php echo get_post_meta($child->ID, 'arrivaldate', true); ?></td>
                                    <td class="childcontent"><?php echo get_post_meta($child->ID, 'leavingdate', true); ?></td>
                                  </tr>
                                <?php }
                              ?>
                            </tbody>
                          </table>

                          <?php }

                        //if this is a parent
                          $args = array(
                            'post_parent' => $post->ID,
                            'post_type'   => 'bookings', 
                            'numberposts' => -1,
                            'post_status' => 'any' 
                          );
                          $children = get_children( $args, OBJECT ); 
                          if ($children) { ?>
                            <table class="relatedbookings">
                              <tbody>                                 
                                    <tr>
                                      <td class="childheader"><strong>Apartment name</strong></td>
                                      <td class="childheader"><strong>Checkin</strong></td>
                                      <td class="childheader"><strong>Checkout</strong></td>
                                    </tr>  
                                    <tr>
                                      <td colspan="3">
                                        You are viewing the parent booking
                                      </td>
                                    </tr>                                
                                <?php
                                  foreach ($children as $childr) { ?>                                  
                                    <tr>
                                      <td class="childcontent"><a href="post.php?post=<?php echo $childr->ID; ?>&action=edit"><?php echo get_post_meta($childr->ID, 'apartmentname', true); ?></td>
                                      <td class="childcontent"><?php echo get_post_meta($childr->ID, 'arrivaldate', true); ?></td>
                                      <td class="childcontent"><?php echo get_post_meta($childr->ID, 'leavingdate', true); ?></td>
                                    </tr>
                                  <?php } ?>
                              </tbody>
                            </table>
                          <?php } ?>                          
                    </td>                               
                </tr>
           </tbody>
        </table>                    

               
<?php } ?>
