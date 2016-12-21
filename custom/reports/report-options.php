<?php
function clientreportsettings() {
    //register our settings
    register_setting( 'clientreportexclude-group', 'excludelist' );
}

function scp_bookings_options_page() {
?>
<div class="wrap">
<h2>Client Report options</h2>
<p>Select the Clients you wish to <strong>EXCLUDE</strong> from all Client Reports</p>

<form method="post" action="options.php" class="reportoptions">
    <?php 
    settings_fields( 'clientreportexclude-group' );
    do_settings_sections( 'clientreportexclude-group' );
    $options = get_option( 'excludelist' );  
    $i = 0;
    $args = array('post_type' => 'clients', 'posts_per_page' => -1, 'post_status' => 'ANY', 'orderby'=>'title', 'order'=>'ASC');
    $clients = get_posts($args); 
    ?>
    <div class="widefat">
    <?php foreach ( $clients as $client ) : setup_postdata( $post ); ?>
        <div class="item">
            <?php echo $client->post_title ?> 
            <input 
            class="iteminput"
            type='checkbox' 
            name='clientidfield'            
            value=''
            id="<?php echo $client->ID; ?>"> 
            <?php $i++; ?>
        </div>
    <?php endforeach; 
    wp_reset_postdata();    
    ?>    
    </div>
    <div class="widefat" style="display:block;">
    	<label>Excluded ID's</label>
    	<input type="text" name="excludelist" id="excludelist" value="<?php echo get_option( 'excludelist' ); ?>">
    </div>
    <?php submit_button(); ?>
</form>
</div>
<script type="text/javascript">
	
	jQuery(document).ready(function(){
		jQuery('.iteminput').on('click', function(){
			var id = jQuery(this).attr('ID');
			var string = jQuery('#excludelist').val();
			var newstring = string + id + ',';
			jQuery('#excludelist').val(newstring);
		})
	})

</script>
<?php } ?>