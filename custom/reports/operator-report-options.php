<?php
function operator_options_page() {
?>
<div class="wrap">
<h2>operator Report options</h2>
<p>Select the operators you wish to <strong>EXCLUDE</strong> from all operator Reports</p>

<form method="post" action="options.php" class="reportoptions">
    <?php 
    settings_fields( 'operatorreportexclude-group' );
    do_settings_sections( 'operatorreportexclude-group' );
    $options = get_option( 'operator-excludelist' );  
    $i = 0;
    $args = array('post_type' => 'operators', 'posts_per_page' => -1, 'post_status' => 'ANY', 'orderby'=>'title', 'order'=>'ASC');
    $operators = get_posts($args); 
    ?>
    <div class="widefat">
    <?php foreach ( $operators as $operator ) : setup_postdata( $post ); ?>
        <div class="item">
            <?php echo $operator->post_title ?> 
            <input 
            class="iteminput"
            type='checkbox' 
            name='operatoridfield'            
            value=''
            id="<?php echo $operator->ID; ?>"> 
            <?php $i++; ?>
        </div>
    <?php endforeach; 
    wp_reset_postdata();    
    ?>    
    </div>
    <div class="widefat" style="display:none;">
    	<label>Excluded ID's</label>
    	<input type="text" name="operator-excludelist" id="operator-excludelist" value="<?php echo get_option( 'operator-excludelist' ); ?>">
    </div>
     <div class="widefat">
        <?php submit_button(); ?>
    </div>
</form>
</div>
<script type="text/javascript">
	
	jQuery(document).ready(function(){        

		jQuery('.iteminput').on('click', function(){
			const id = jQuery(this).attr('id');
            const inputValue = jQuery('input[type=text]').val();

            // Split the IDs into an array by comma.
            const currentIds = inputValue.split(',');

            if (currentIds.indexOf(id) === -1) {
                // ID has not yet been added to the input box.
                // We can add it to the array here, and
                // update it later.
                currentIds.push(id);
            } else {
                // ID is in the current list of IDs. We
                // can remove it like this:
                currentIds.splice(currentIds.indexOf(id), 1);
            }

            // Finally, we can reset the input string
            // with the new values we set above.
            jQuery('input[type=text]').val(currentIds.join(','));
		})
	});

    jQuery(document).ready(function(){
        jQuery('.iteminput').each(function(){
            var id = jQuery(this).attr('id');
            var string = jQuery('input[type=text]').val();

            if (string.indexOf(id) >= 1) {
                jQuery('input#'+id).prop('checked', true);
            }  

            console.log(string);

        });
    })

</script>
<?php } ?>