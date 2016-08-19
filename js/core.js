/********************
* This file contains all the jQuery required to run the plugin
* Please backup this file before making changes
* Version 1
********************/


jQuery(document).ready(function(){
	var loading = jQuery('#loadingDiv').hide();
	jQuery(document)
	.ajaxStart(function () {
		loading.show();
	})
	.ajaxStop(function () {
	loading.hide();
	});
});
jQuery(document).ready(function(){
 
    jQuery('.upload_image_button').click(function(){
 
        var textfieldid = jQuery(this).prev().attr("id");
 
        wp.media.editor.send.attachment = function(props, attachment){jQuery('#' + textfieldid).val(attachment.url);}
        wp.media.editor.open(this);
        return false;
         
  });
   
});

jQuery(document).ready(function(){


	//start date for search query
	jQuery('#startdate').datetimepicker({																								
		timepicker: false,
		format:'d.m.Y'
	});

	//end date for search query
	jQuery('#enddate').datetimepicker({																								
		timepicker: false,
		format:'d.m.Y'
	});

	//Actual booking check out time
	jQuery('#date1').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Actual booking check out time
	jQuery('#date2').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//up coming Bookings Report
	jQuery('#date12').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//up coming Bookings Report
	jQuery('#date11').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//up coming payments Report
	jQuery('#date13').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//up coming payments Report
	jQuery('#date14').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Client Report
	jQuery('#date15').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Client Report
	jQuery('#date16').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Operator Report
	jQuery('#date17').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Operator Report
	jQuery('#date18').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Top Operator Report
	jQuery('#date19').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Top Operator Report
	jQuery('#date20').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Top Client Report
	jQuery('#date21').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Top Client Report
	jQuery('#date22').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Top Locations Report
	jQuery('#date23').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Top Locations Report
	jQuery('#date24').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Top Apartments Report
	jQuery('#date25').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Top Apartments Report
	jQuery('#date26').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});
	//Top Apartments Report
	jQuery('#leavingdate').datetimepicker({
		timepicker: false,
		format:'d.m.Y'
	});

	/********************
	// jQuery UI Tabs
	********************/

	//Tabs for apartment terms and conditions
    jQuery( "#tabs" ).tabs();
    jQuery( "#pricing-tabs" ).tabs();

});

	jQuery(document).ready(function(){
	    jQuery('.dashboard_widget').DataTable({
	        "order": [[ 1, "desc" ]],
	        
	    });
	})

	jQuery(document).ready(function(){
	    jQuery('.bookingstable').DataTable({
	        "order": [[ 7, "desc" ]],
	        "iDisplayLength": -1
	    });
	})

	jQuery(document).ready(function(){
		jQuery ("#booking-container").steps({
		    headerTag: "h3",
		    bodyTag: "section",
		    transitionEffect: "slideLeft",
		    autoFocus: true
		});
	})

	jQuery(document).ready(function(){
		jQuery('#accordion').accordion({
			active: false,
			collapsible: true,
			autoHeight: false,
			heightStyle: "content" 
		});
	})
	


jQuery(document).ready(function(){
	jQuery('#arrivaldate').datetimepicker({
		format:'d.m.Y',
		timepicker: false
	})	
	jQuery('#leavingdate').datetimepicker({
		format:'d.m.Y',
		timepicker: false
	})	
	jQuery('#actualcheckintime').datetimepicker({
		format:'d.m.Y',
		datepicker: false,
		timepicker: true
	})	
	jQuery('#actualcheckouttime').datetimepicker({
		format:'d.m.Y',
		datepicker: false,
		timepicker: true
	})	
	jQuery('#apartmentduedate').datetimepicker({
		format:'d.m.Y',
		timepicker: false
	})
	jQuery('#balanceduedate').datetimepicker({
		format:'d.m.Y',
		timepicker: false
	})
	jQuery('#depositdate').datetimepicker({
		format:'d.m.Y',
		timepicker: false
	})
})


/********************
// Ajax auto populate booking fields
********************/																																																																																																																																																																																																																																																																													


jQuery(document).ready(function(){
		jQuery('#bookingtype').change(function() {
		//get the data i need	
		var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
		var bookingtype = jQuery('#bookingtype').val();				
		var apartmentname = jQuery('#apartmentname').val();	
		var startdate = jQuery('#arrivaldate').val();
		var enddate = jQuery('#leavingdate').val();

		//got the data, make the ajax request
		jQuery(function(){
		    jQuery.ajax({
	            url: siteUrl,
	            type:'POST',
	            data:'action=my_special_action&apartmentname=' + apartmentname + 
	            '&bookingtype=' + bookingtype +
	            '&startdate=' + startdate +
	            '&enddate=' + enddate,
	            dataType:'json',
	            success:function(data){
	            	
	            	//got it back, now assign it to its fields. 	            	
	            	jQuery('#checkintime').val(data.checkintime);
	            	jQuery('#checkouttime').val(data.checkouttime);
	            	jQuery('#ownerprice').val(data.ownerprice);	
	            	jQuery('#emergencycontact').val(data.emergencycontact);
	            	jQuery('#arrivalprocess').val(data.arrivalprocess);
	            	jQuery('#terms').val(data.terms); 
	            	jQuery('#numberofnights').val(data.nights);
	            
	            	if (data.bookingtype == 'Corporate') {
    					jQuery('#rentalprice').val(data.rentalprice);
    					jQuery('#priceperperson').val(null);

					} else if (data.bookingtype == 'Groups') {
					    jQuery('#priceperperson').val(data.rentalprice);
					    jQuery('#rentalprice').val(null);

					} else if (data.bookingtype == 'Leisure') {
					    jQuery('#priceperperson').val(data.rentalprice);
					    jQuery('#rentalprice').val(null);

					}


	            	
			    }
			});
		});
	});
})

/********************
// Ajax populate the hidden location field. This is hidden for the benefit of recording location data against a booking
********************/																																																																																																																																																																																																																																																																											

jQuery(document).ready(function(){
	
		jQuery('#apartmentname').change(function() {
		//get the data i need	
		var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
		var apartmentname = jQuery('#apartmentname').val();					
		//got the data, make the ajax request
		jQuery(function(){
		    jQuery.ajax({
	            url:siteUrl,
	            type:'POST',
	            data:'action=getlocation&apartmentname=' + apartmentname,	            
	            success:function(data){
	            	//got it back, now assign it to its fields. 	            	
	            	jQuery('#location').val(data);
	            	//console.log(data);
	            	//alert(data);
	            }
			});
		});
	});

})

/********************
// Ajax auto populate booking vat rate field
********************/						


jQuery(document).ready(function(){
	jQuery('#calculate').click(function() {

	jQuery('#chargetype').on('click', function () {
	    jQuery(this).val(this.checked ? true : false);
	    console.log(jQuery(this).val());
	});
		
	//get the data i need	
	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
	var vatselect = jQuery('#vatselect').prop('checked');
	var arrivaldate = jQuery('#arrivaldate').val();	
	var leavingdate = jQuery('#leavingdate').val();
	var actualcheckintime = jQuery('#actualcheckintime').val();	
	var actualcheckouttime = jQuery('#actualcheckouttime').val();
	var rentalprice = jQuery('#rentalprice').val();	
	var bookingtype = jQuery('#bookingtype').val();
	var deposit = jQuery('#deposit').val();
	var supplementsprice = jQuery('#supplementsprice').val();
	if (jQuery('#chargetype').prop('checked')==true) {var chargetype = 'true'} else {var chargetype = 'false'}
	var priceperperson = jQuery('#priceperperson').val();
	var numberofguests = jQuery('#numberofguests').val();	
	var discount = jQuery('#discount').val();
	var customvatvalue = jQuery('#customvatvalue').val();

	console.log(chargetype);    

    
    if( jQuery('#vatselect').prop('checked') == true ) {																																																																																																																																																																																																																																																											
		//got the data, make the ajax request
		jQuery(function(){
		    jQuery.ajax({
	            url:siteUrl,
	            type:'POST',
	            data:'action=my_special_vataction&arrivaldate=' + arrivaldate + 
	            '&leavingdate=' + leavingdate + 
	            '&vatselect=' + vatselect +
	            '&actualcheckintime=' + actualcheckintime + 
	            '&actualcheckouttime=' + actualcheckouttime + 
	            '&rentalprice=' + rentalprice + 
	            '&bookingtype=' + bookingtype + 
	            '&deposit=' + deposit + 
	            '&supplementsprice=' + supplementsprice + 
	            '&chargetype=' + chargetype +
	            '&priceperperson=' + priceperperson + 
	            '&numberofguests=' + numberofguests + 
	            '&discount=' + discount +
	            '&customvatvalue=' + customvatvalue,
	           	dataType:'json',
	            success:function(result){
	            	//got it back, now assign it to its fields. 	            	
	            	jQuery('#vatamount').val(result.vatfigure);
	            	jQuery('#balancedue').val(result.balancedue);
	            	jQuery('#totalcost').val(result.balancedue);
	            	jQuery('#numberofnights').text(result.nights);	            
	          

			    }
			});
		});

    } else if( jQuery('#vatselect').prop('checked') == false ) {
    	//got the data, make the ajax request
		jQuery(function(){
		    jQuery.ajax({
	            url:siteUrl,
	            type:'POST',
	            data:'action=my_special_vataction&arrivaldate=' + arrivaldate + 
	            '&leavingdate=' + leavingdate + 
	            '&actualcheckintime=' + actualcheckintime + 
	            '&actualcheckouttime=' + actualcheckouttime + 
	            '&rentalprice=' + rentalprice + 
	            '&bookingtype=' + bookingtype + 
	            '&deposit=' + deposit + 
	            '&supplementsprice=' + supplementsprice  + 
	            '&chargetype=' + chargetype +
	            '&priceperperson=' + priceperperson + 
	            '&numberofguests=' + numberofguests + 
	            '&discount=' + discount,
	            dataType:'json',
	            success:function(result){
	            	//got it back, now assign it to its fields. 	            	
	            	jQuery('#vatamount').val('0');
	            	jQuery('#balancedue').val(result.balancedue);
	            	jQuery('#totalcost').val(result.balancedue);   
	            	jQuery('#numberofnights').text(result.nights);
					
	            	
			    }
			});
		});
    }
});
})
/********************
// Ajax auto populate the operator details
********************/	

jQuery(document).ready(function(){
	jQuery('#operatorname').change(function() { 
	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php'; 
		var operatorname = jQuery('#operatorname').val();  
		jQuery(function(){
		    jQuery.ajax({
	            url:siteUrl,
	            type:'POST',
	            data:'action=operatordetails&operatorname=' + operatorname,           
	            success:function(result){
	            	//got it back, now assign it to its fields. 	            	
	            	jQuery('#operatorajax').html( result );;    
	            	
	            }
			});
		});
	});
})

/********************
// Ajax auto populate the client details
********************/	

jQuery(document).ready(function(){
	jQuery('#clientname').change(function() {  
		var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
		var clientname = jQuery('#clientname').val();  
		console.log(clientname);
		jQuery(function(){
		    jQuery.ajax({
	            url:siteUrl,
	            type:'POST',
	            data:'action=clientdetails&clientname=' + clientname,           
	            success:function(result){
	            	//got it back, now assign it to its fields. 	            	
	            	jQuery('#clientajax').html( result );  
	            	
	            }
			});
		});
	});
})

/********************
// Ajax reduce balancedue after deposit paid
********************/	
jQuery(document).ready(function(){

jQuery('#recalculate').click(function() { 
var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php'; 
	var deposit = jQuery('#deposit').val();  
	var balancedue = jQuery('#balancedue').val();
	var depositpaid = jQuery('#depositpaid').val();  
	var apartmentpaid = jQuery('#apartmentpaid').val(); 
	var balancepaid = jQuery('#balancepaid').val(); 
	jQuery(function(){
	    jQuery.ajax({
            url:siteUrl,
            type:'POST',
            data:'action=depositpaid&deposit=' + deposit + 
            '&balancedue=' + balancedue + 
            '&apartmentpaid=' + apartmentpaid + 
            '&balancepaid=' + balancepaid +
            '&depositpaid=' + depositpaid,
            success:function(result){
            	//got it back, now assign it to its fields. 	            	
            	jQuery('#balancedue').val(result);  
            	//console.log( result );       	   
            }
		});
	});
});
})
/********************
// Ajax send an email to the client
********************/	

jQuery('#email_client').click(function(e){
	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
		var buttonid = this.id;
		var bookingtype = jQuery('#bookingtype').val();
		var useremail = jQuery('#useremail').attr('value');
		var username = jQuery('#username').val();
		var title = jQuery('#title').val();
		var guestname = jQuery('#guestname').val();
		var email = jQuery('#email').val();
		var phone = jQuery('#phone').val();
		var apartmentname = jQuery('#apartmentname').val();
		var numberofapts = jQuery('#numberofapts').val();
		var additionalnotes = jQuery('#additionalnotes').val();
		var apptbreakdown = jQuery('#apptbreakdown').val();		
		var terms = jQuery('#terms').val();
		var arrivalprocess = jQuery('#arrivalprocess').val();
		var emergencycontact = jQuery('#emergencycontact').val;
		var clientname = jQuery('#bookingsclient_new_field').val();
		var clientname = jQuery('#clientname').val();
		var clientemail = jQuery('#clientemail').val();
		var clientphone = jQuery('#clientphone').val();	
		var arrivaldate = jQuery('#arrivaldate').val();	 
		var leavingdate = jQuery('#leavingdate').val();
		var checkintime = jQuery('#checkintime').val();
		var checkouttime = jQuery('#checkouttime').val();
		var actualcheckintime = jQuery('#actualcheckintime').val();	
		var actualcheckouttime = jQuery('#actualcheckouttime').val();		
		var supplementsprice = jQuery('#supplementsprice').val();
		var priceperperson = jQuery('#priceperperson').val();
		var numberofguests = jQuery('#numberofguests').val();	
		var discount = jQuery('#discount').val();
		var rentalprice = jQuery('#rentalprice').val();
		var vatamount = jQuery('#vatamount').val();		
		var totalcost = jQuery('#totalcost').val();
		var costcode = jQuery('#costcode').val();
		var displayname = jQuery('#displayname').val();
		var welcomepack = jQuery('#welcomepack').val();
		var vatselect = jQuery('#vatselect').prop('checked');

		
	
	
	jQuery.ajax({
		url:siteUrl,
	    type:'POST',
	    data:'action=booking_confirmation_email_client&guestname=' + guestname + 
	    '&useremail=' + useremail + 
	    '&bookingtype=' + bookingtype + 
	    '&username=' + username +
	    '&title=' + title + 
	    '&email=' + email + 
	    '&phone=' + phone + 
	    '&apartmentname=' + apartmentname + 
	    '&numberofapts=' + numberofapts + 
	    '&additionalnotes=' + additionalnotes + 
	    '&apptbreakdown=' + apptbreakdown + 
	    '&arrivaldate=' + arrivaldate + 
	    '&terms=' + terms + 
	    '&arrivalprocess=' + arrivalprocess + 
	    '&emergencycontact=' + emergencycontact + 
	    '&clientname=' + clientname + 
	    '&clientemail=' + clientemail + 
	    '&clientname=' + clientname + 
	    '&clientphone=' + clientphone + 
	    '&leavingdate=' + leavingdate + 
	    '&actualcheckintime=' + actualcheckintime + 
	    '&actualcheckouttime=' + actualcheckouttime + 
	    '&supplementsprice=' + supplementsprice + 
	    '&priceperperson=' + priceperperson + 
	    '&numberofguests=' + numberofguests + 
	    '&discount='  + discount + 
	    '&vatamount=' + vatamount + 
	    '&vatselect=' + vatselect +
	    '&totalcost=' + totalcost +
	    '&checkintime=' + checkintime +
	    '&checkouttime=' + checkouttime + 
	    '&buttonid=' + buttonid + 
	    '&rentalprice=' + rentalprice +
	    '&costcode=' + costcode +
	    '&displayname=' + displayname +
	    '&welcomepack=' + welcomepack,
         success:function(result){ 
            	alert('Your email was sent to the client.');
            	console.log(result);
            	
		    }

	});


});
/********************
// Ajax send an email to the operator
********************/	

jQuery('#email_operator').click(function(e){
	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
		var buttonid = this.id;
		var bookingtype = jQuery('#bookingtype').val();
		var useremail = jQuery('#useremail').attr('value');
		var username = jQuery('#username').val();
		var title = jQuery('#title').val();
		var guestname = jQuery('#guestname').val();
		var email = jQuery('#email').val();
		var phone = jQuery('#phone').val();
		var apartmentname = jQuery('#apartmentname').val();
		var numberofapts = jQuery('#numberofapts').val();
		var additionalnotes = jQuery('#additionalnotes').val();
		var apptbreakdown = jQuery('#apptbreakdown').val();		
		var terms = jQuery('#terms').val();
		var arrivalprocess = jQuery('#arrivalprocess').val();
		var emergencycontact = jQuery('#emergencycontact').val;
		var clientname = jQuery('#bookingsclient_new_field').val();
		var operatorname = jQuery('#clientname').val();
		var operatoremail = jQuery('#operatoremail').val();
		var operatorphone = jQuery('#clientphone').val();	
		var arrivaldate = jQuery('#arrivaldate').val();	
		var leavingdate = jQuery('#leavingdate').val();
		var checkintime = jQuery('#checkintime').val();
		var checkouttime = jQuery('#checkouttime').val();
		var actualcheckintime = jQuery('#actualcheckintime').val();	
		var actualcheckouttime = jQuery('#actualcheckouttime').val();		
		var supplementsprice = jQuery('#supplementsprice').val();
		var priceperperson = jQuery('#priceperperson').val();
		var numberofguests = jQuery('#numberofguests').val();	
		var discount = jQuery('#discount').val();
		var rentalprice = jQuery('#rentalprice').val();
		var vatamount = jQuery('#vatamount').val();
		var totalcost = jQuery('#totalcost').val();
		var costcode = jQuery('#costcode').val();
		var displayname = jQuery('#displayname').val();
		var welcomepack = jQuery('#welcomepack').val();
		var vatselect = jQuery('#vatselect').prop('checked');
	
	
	jQuery.ajax({
		url:siteUrl,
	    type:'POST',
	    data:'action=booking_confirmation_email_operator&guestname=' + guestname + 
	    '&useremail=' + useremail + 
	    '&bookingtype=' + bookingtype + 
	    '&username=' + username +
	    '&title=' + title + 
	    '&email=' + email + 
	    '&phone=' + phone + 
	    '&apartmentname=' + apartmentname + 
	    '&numberofapts=' + numberofapts + 
	    '&additionalnotes=' + additionalnotes + 
	    '&apptbreakdown=' + apptbreakdown + 
	    '&arrivaldate=' + arrivaldate + 
	    '&terms=' + terms + 
	    '&arrivalprocess=' + arrivalprocess + 
	    '&emergencycontact=' + emergencycontact + 
	    '&clientname=' + clientname + 
	    '&operatoremail=' + operatoremail + 
	    '&operatorname=' + operatorname + 
	    '&operatorphone=' + operatorphone + 
	    '&leavingdate=' + leavingdate + 
	    '&actualcheckintime=' + actualcheckintime + 
	    '&actualcheckouttime=' + actualcheckouttime + 
	    '&supplementsprice=' + supplementsprice + 
	    '&priceperperson=' + priceperperson + 
	    '&numberofguests=' + numberofguests + 
	    '&discount='  + discount + 
	    '&vatamount=' + vatamount + 
	    '&vatselect=' + vatselect +
	    '&totalcost=' + totalcost +
	    '&checkintime=' + checkintime +
	    '&checkouttime=' + checkouttime + 
	    '&buttonid=' + buttonid + 
	    '&rentalprice=' + rentalprice +
	    '&costcode=' + costcode +
	    '&displayname=' + displayname +
	    '&welcomepack=' + welcomepack,
         success:function(result){ 
            	alert('Your email was sent to the Operator.');
            	console.log(operatoremail);
            	
		    }

	});


});



/********************
// Ajax search query for upcoming bookings
********************/	

jQuery('#searchquery').click(function(){
	jQuery('#searchresults').show();
});

jQuery('#searchquery').click(function() { 
	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
	var startdate = jQuery('#date11').val();
	var enddate = jQuery('#date12').val(); 
	var operatorname = jQuery('#operatorname').val(); 
	var apartmentname =  jQuery('#apartmentname').val();
	var bookingtype = jQuery('#bookingtype option:selected').text();
	jQuery(function(){
	    jQuery.ajax({
            url:siteUrl,
            type:'POST',
            data:'action=searchquery&operatorname=' + operatorname + 
            '&startdate=' + startdate +
            '&enddate=' + enddate +
            '&bookingtype=' + bookingtype +
            '&apartmentname=' + apartmentname,
            success:function(result){
            	//got it back, now assign it to its fields. 	            	
            	jQuery('#searchresult').html( result );
            	jQuery('#searchresult').DataTable({"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]});
            	
            }
		});
	});
});


/********************
// Ajax search query for upcoming payments
********************/	

jQuery('#paymentsquery').click(function(){
	jQuery('#searchresults').show();
});

jQuery('#paymentsquery').click(function() {  
	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
	var startdate = jQuery('#date13').val();
	var enddate = jQuery('#date14').val();
	var operatorname = jQuery('#operatorname').val(); 
	var apartmentname =  jQuery('#apartmentname').val()
	var bookingtype = jQuery('#bookingtype option:selected').text();
	var clientname = jQuery('#clientname').val();

	jQuery(function(){
	    jQuery.ajax({
            url:siteUrl,
            type:'POST',
            data:'action=paymentsquery&operatorname=' + operatorname + 
            '&startdate=' + startdate + 
            '&enddate=' + enddate +
            '&bookingtype=' + bookingtype +
            '&clientname=' + clientname +
            '&apartmentname=' + apartmentname,
            success:function(result){
            	//got it back, now assign it to its fields. 	            	
            	jQuery('#searchresult').html( result );
            	jQuery('#searchresult').DataTable({"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]});
            //console.log(result);
            	
            }
		});
	});
});

/********************
// Ajax search query for client report
********************/	

jQuery('#clientquery').click(function(){
	jQuery('#searchresults').show();
});

jQuery('#clientquery').click(function() {  
	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
	var clientname = jQuery('#clientreportname').val();
	var startdate = jQuery('#date15').val();
	var enddate = jQuery('#date16').val();
	var apartmentname = jQuery('#clientreportapartment').val();
	var location = jQuery('#clientreportlocation').val();

	jQuery(function(){
	    jQuery.ajax({
            url:siteUrl,
            type:'POST',
            data:'action=clientreport&clientname=' + clientname + 
            '&apartmentname=' + apartmentname +
            '&location=' + location +
            '&startdate=' + startdate +
            '&enddate=' + enddate,          
            success:function(result){
            //got it back, now assign it to its fields. 	            	
            jQuery('#searchresult').html( result );
            jQuery('#searchresult').DataTable({"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]});
            	
            }
		});		
	});
});

/********************
// Ajax search query for operator report
********************/	

jQuery('#operatorquery').click(function(){
	jQuery('#searchresults').show();
});

jQuery('#operatorquery').click(function() {  
	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
	var operatorname = jQuery('#operatorreportname').val();
	var startdate = jQuery('#date17').val();
	var enddate = jQuery('#date18').val();
	var apartmentname = jQuery('#operatorreportapartment').val();
	var location = jQuery('#operatorreportlocation').val();

	jQuery(function(){
	    jQuery.ajax({
            url:siteUrl,
            type:'POST',
            data:'action=operatorreport&operatorname=' + operatorname + 
            '&apartmentname=' + apartmentname +
            '&location=' + location +
            '&startdate=' + startdate +
            '&enddate=' + enddate,          
            success:function(result){
            //got it back, now assign it to its fields. 	            	
           	jQuery('#searchresult').html( result );
           	jQuery('#searchresult').DataTable({"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]});
            	
            }
		});		
	});
});

/********************
// Ajax search query for Top Operator Report
********************/	

jQuery('#leaderoperator').click(function(){
	jQuery('#searchresults').show();
});

jQuery('#leaderoperator').click(function() { 	
	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
	var startdate = jQuery('#date19').val();
	var enddate = jQuery('#date20').val();

	jQuery(function(){
	    jQuery.ajax({
            url:siteUrl,
            type:'POST',
            data:'action=topoperator&startdate=' + startdate +
            '&enddate=' + enddate,          
            success:function(result){
            //got it back, now assign it to its fields. 	            	
           	jQuery('#searchresult').html( result );
            jQuery('#searchresult').DataTable({"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]});
            	
            }
		});		
	});
});


/********************
// Ajax search query for Top Client Report
********************/	

jQuery('#leaderclient').click(function(){
	jQuery('#searchresults').show();
});

jQuery('#leaderclient').click(function() { 	
	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
	var startdate = jQuery('#date21').val();
	var enddate = jQuery('#date22').val();

	jQuery(function(){
	    jQuery.ajax({
            url:siteUrl,
            type:'POST',
            data:'action=topclient&startdate=' + startdate +
            '&enddate=' + enddate,          
            success:function(result){
            //got it back, now assign it to its fields. 	            	
           	jQuery('#searchresult').html( result );
            //console.log(result);
            jQuery(function(){
		            // this will hide all the rows that equal 0 spend.
				    var search = '£0';
				    jQuery("#searchresult").filter(function() {
				        return jQuery(this).text() == search;
				    }).parent('tr').hide();
				    jQuery('#searchresult').DataTable({"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]});

	            });
			}		
		});	
	});	
});



/********************
// Ajax search query for Top Locations Report
********************/	

jQuery('#leaderlocations').click(function(){
	jQuery('#searchresults').show();
});

jQuery('#leaderlocations').click(function() { 
var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';	
	var startdate = jQuery('#date23').val();
	var enddate = jQuery('#date24').val();
	var clientname = jQuery('#leaderloc_clientname').val();
	var operatorname = jQuery('#leaderloc_operatorname').val();


	jQuery(function(){
	    jQuery.ajax({
            url:siteUrl,
            type:'POST',
            data:'action=toplocations&startdate=' + startdate +
            '&enddate=' + enddate +
            '&operatorname=' + operatorname +
            '&clientname=' + clientname,          
            success:function(result){
            //got it back, now assign it to its fields. 	            	
           	jQuery('#searchresult').html( result );
            //console.log(result);
	            jQuery(function(){
		            // this will hide all the rows that equal 0 spend.
				    var search = '£0';
				    jQuery("#searchresult").filter(function() {
				        return jQuery(this).text() == search;
				    }).parent('tr').hide();
				    jQuery('#searchresult').DataTable({"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]});
	            });
			}		
		});	
	});	

});


/********************
// Ajax search query for Top Apartment Report
********************/	

jQuery('#leaderapartments').click(function(){
	jQuery('#searchresults').show();
});

jQuery('#leaderapartments').click(function() { 	
	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
	var startdate = jQuery('#date25').val();
	var enddate = jQuery('#date26').val();
	var clientname = jQuery('#leaderapp_clientname').val();
	var operatorname = jQuery('#leaderapp_operatorname').val();

	jQuery(function(){
	    jQuery.ajax({
            url:siteUrl,
            type:'POST',
            data:'action=topapartments&startdate=' + startdate +
            '&enddate=' + enddate +
            '&operatorname=' + operatorname + 
            '&clientname=' + clientname,          
            success:function(result){
            //got it back, now assign it to its fields. 	            	
           	jQuery('#searchresult').html( result );
            //console.log(result);
	            jQuery(function(){
		            // this will hide all the rows that equal 0 spend.
				    var search = '£0';
				    jQuery("#searchresult").filter(function() {
				        return jQuery(this).text() == search;
				    }).parent('tr').hide();
				    jQuery('#searchresult').DataTable({"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]});
	            });
			}		
		});	
	});	
});

/********************
// Ajax search query for Customer Apartment Search
********************/	

jQuery('#customerapartmentsquery').click(function(){
	jQuery('#searchresults').show();
});

jQuery('#customerapartmentsquery').click(function() { 
	var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';
	var operatorname = jQuery('#operator').val();
	var location = jQuery('#location').val();
	var noofnights = jQuery('#noofnights').val();
	var bookingtype = jQuery('#bookingtypesearch').val();

	jQuery(function(){
	    jQuery.ajax({
            url:siteUrl,
            type:'POST',
            data:'action=customer_query_ajax&operator=' + operatorname + '&location=' + location + '&noofnights=' + noofnights + '&bookingtype=' + bookingtype,       
            success:function(result){
            //got it back, now assign it to its fields. 	            	
           	jQuery('#searchresult').html( result );
            //console.log(result);
            	
            }
		});		
	});

});


/********************
// Ajax update all bookings posts
********************/
jQuery(document).ready(function(){
	jQuery('#updateclick').click(function(){
		var siteUrl = siteUrlobject.siteUrl+'/wp-admin/admin-ajax.php';

		jQuery(function(){
		    jQuery.ajax({
	            url:siteUrl,
	            type:'POST',
	            data:'action=update_bookings',
	            success:function(result){
	            //got it back, now assign it to its fields. 
	            jQuery('#searchresults').html( result );	            	
	            jQuery('#searchresults').show();	
	            	
	            }
			});		
		});
		console.log('bookings updated');
	});
});


