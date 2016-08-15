<?php

function documentation_callback() { 

echo '<div class="wrap">';
echo '<h2>Documentation</h1>';
echo '</div>'; ?>

<div id="tabs">
	<style type="text/css">
	.tab-content ul > li {
	    list-style: initial;
	}
	</style>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#webapp" aria-controls="webapp" role="tab" data-toggle="tab">Web App</a></li>
    <li role="presentation" class="active"><a href="#reseller" aria-controls="reseller" role="tab" data-toggle="tab">Reseller Pages</a></li>
    
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="webapp">
    	<p>The purpose of the web app is to allow users to log into the front end of the website and view all bookings allocated to either their email address or their comapny.</p>
    	<ul>
    		<li>
    			<strong><p>There are two types of user access.</p></strong>
    			<ol>
		    		<li>
		    			<p>Company Admin Users</p>
		    			<p>These users can see all of the bookings that are applied to the Operator / Client name displayed in the "Operator Name" / "Client Name" field in the booking form.</p>    		
		    		</li>
		    		<li>
		    			<p>Company users</p>
		    			<p>These users can see all of the bookings that are applied to the Operator / Client email address displayed in the "Operator Email" / "Client Email" fields in the booking form.</p>   
		    		</li>
    			</ol>
    		</li>
    		<li>
    			<strong><p>To add a new user</p></strong>
    			<ol>
    				<li>Select Users > Add New</li>
    				<li>Fill in all the user details using the contacts email address as the username and click Add New User</li>
    				<li>You will then be returned to the main user list screen. From here find the user you just created and click edit.</li>
    				<li>Scroll down the page where you will find the Web App Information details.</li>
    				<li>Select the Client / Operator this contact applies to and chose Admin or Not Admin.</li>
    				<li>Click update user.</li>
    			</ol>
    		</li>
    	</ul>
    </div>
  
  </div>
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="reseller">
      <p>The purpose of the reseller pages is to allow other Travel Management Companies to make use of the Customer Search Query under their own brand. Emails are sent out as per usual however, the email links the client to a branded page of their own showing all the apartment details and links to their own website and contact details. No trace of Serviced City Pads remains.</p>
      <p>To add a new Reseller, open <strong>SCP Bookings > Reseller Pages</strong></p>
      <ol>
          <li>Click Add Reseller Page</li>
          <li>Fill in all the details</li>
          <ul>
            <li>Website: This is the customers website address.</li>            
            <li>Page URL: If the client requires an address other than their main web address to send traffic to for the search results, please add this in here.</li>            
          </ul>
          <li>Click Publish</li>            
          <li>You can then download the .zip file from the Reseller Download section on the right. Email this to the client and ask them to upload the extracted folder up to the root of their chosen web directory.</li>            
      </ol>
    </div>
  
  </div>

</div>

<?php } ?>