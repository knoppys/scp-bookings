Changelog

V3.8.4
- Bug fix where the address was not showing. This seemed to be fixed when i changed the PHP variable names in the get+page _by_title function on both the client confirmation (local and email) and operator confirmation (local and email). 

V3.8.3
- Bug fix where the booking confirmation email were showing the wrong fields. 

V3.8.1 
- Updated the listings tables due to incompatibility with UK Dates. included Moment.js and DatatablesMoment.js and edited the tables to use the correct date format. 

V3.5.1
- Updated the booking confirmation emails to use the posted value from the booking form as the conditional check is already carried out function side. 

V3.5
- Upgraded all editors to use wpautop() to ensure that all meta is saved as HTML with tags.
-- Includes Apartment meta : additional location information, description, terms and arrival process.
-- Includes Bookings meta : terms and arrival process
-- Includes Booking Confirmations : terms, arrival process, other informaiton.

V3.4.15
- Added a conditional check to see default the terms to the Corporate Terms if there are none in Groups or Leisure. 

V3.4.12
- Added AddOnDomain functionality to resellers.
	- Still working on the Delete Add Domain Function

V3.4.6
- Updated supplements fields to accomodate individual calculations

V3.4
- City Guides Post Type
- City Guides UI
- Select City Guide as meta in Locations UI
- City Guides Documentation
- Addded suppliments conditional check for Nightly or Flat Rate
- Additional Notes fields added to both Client and Operator Email confirmations and static confirmations
