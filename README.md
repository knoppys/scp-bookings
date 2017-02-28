Changelog

V6.7
- Bug fix to the sorting in list views. Markup error adding archive funciton to additional <td>
V6.5.9
- Bug fix update to the archive function

V.6.5.3
- Updated google map API key to comply with google api access requests.

V6.5
- Google map apartment searh added.

V6.0.2
- Default currency for all bookings set to £ on save.
- Added update_post_meta() function inside SCP Parent to update all currnt bookings with £. Will remove after the loop has run. 

V6.0
- Added the new google map search facility.

V5.9.10
- Updated bookings edit screen and confirmation emails to use variable currency symbols.

V5.9.7
- Fixed the problem with the client details and operator details not picking up single quotes in the edit booking screen. Added stripslashes in the PHP.

NOTE*** This was the last migration ***NOTE
Jan 31st

V4.9.1
- Bookings fields amendments have been updated. 
- Default sort by Checkin Date on the new accounts screen

V4.8.6
Booking confirmations changes. 
- New field added to contain a seperate price sent to the Operator allowing for override
- Operator email now shows Nightly Rate and Owner Price
- Client Email now shows Nightly Rate and Total Price
- Variable checks added to the nightly rate text in the confirmations.


V4.8.5
Bug fix where number of bathrooms and number of bedrooms were both saving as the same meta. 

V4.7.1

Left debug information on booking listings, this has been removed
Pagination has been added to speed up the page overall usage on the Accounts Page, this does not fix the loading time but improves usability slightly.
Space added in booking confirmation emails between the date and time

V4.7 Customer Query

Added conditional display check for Listing Price and Additional Comments.
Fixed bug with $comments display string.
Added pre_replace() to remove all in line styling from $description in the email template.

V4.6

Customer Query Email template generator changed from the use of get_posts() to WP_Query and all seems to be working fine. Still need to fix a bug in the reseller email.

V4.5 BOOKING PROCESS

Update the booking process to include new fields and reduce some of the extra unwanted VAT calculation tools.
The Custom VAT Value field has been removed
The VAT Select Checkbox has been removed
The Price Per Night field can now be used as a single price for both Price Per Night and Price Per Person Per Night. The system will check the booking type to decide how this value is handled.
The programming behind the VAT Calculator (SCP-bookings/custom/functions-vat-calculator.php) has been rebuilt to accommodate the missing information from the Custom VAT and VAT Select data.
BOOKING CONFORMATIONS
Client and Operator Booking Confirmations now contain the same Pricing information. The nightly rate text (PPN or PPPPN) is based on the Booking Type and the price itself is given net or Inc vat based on the Show as Inc VAT checkbox in the booking form.
DATA HANDLING
To accommodate the new single price field, we have written legacy code to check if the booking has a Price Per Person value from the previous $priceperperson meta key. If it does, then show the value in the Price Per Night Field ($rentalprice). The save function will update the booking and save the value in the rental price meta for future use.

NOTE: We may have to look into the reporting to check to make sure the reports take into account the single use meta field.

V4 The new customer query tool is complete. Users can now send correctly formatted emails over to clients and the reseller tool also works. In addition, unpublished / pending apartments in the search results now have a request update button. This sends an email to Bryony to update the apartment and make it available to send in emails.

V3.9 Revamp of the Customer Query System. Requires testing by the client but both the SCP and Reseller Emails seem to be working fine.

V3.8.5 Bug fix incorrect meta showing on the city guides page.

V3.8.4 Bug fix where the address was not showing. This seemed to be fixed when I changed the PH variable names in the get+page _by_title function on both the client confirmation (local and email) and operator confirmation