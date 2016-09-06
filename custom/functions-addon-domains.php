<?php
/************************************
Reseller Pages Add On Domains
************************************/
function implement_addon() {
	if(isset($_POST['pageurl']))
		{   

    $domain = ($_POST['pageurl']);

    $url = "https://$user:$pass@$domain:2083/frontend/$skin/addon/doadddomain.html?dir=query.servicedcitypads.com&domain=tes1t.testing.com&subdomain=te1st.testing.com";
    $result = @file_get_contents($url);
    if ($result === FALSE) die("ERROR: Reseller not created. Please make sure you have entered the PageURL correct.");
    echo $result;   

		die();
	} 
}
add_action('wp_ajax_addondomainaction', 'implement_addon');
add_action('wp_ajax_nopriv_addondomainaction', 'implement_addon');
?>