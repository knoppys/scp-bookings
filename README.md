Changelog
V4.5
- Update the booking process to include new fields and reduce some of the extra unwanted VAT calculation tools.
-- The Custom VAT Value field has been removed
-- The VAT Select Checkbox has been removed
-- The Price Per Night field can now be used as a single price for both Price Per Night and Price Per Person Per Night. The system will check the booking type to decide how this value is handled.
-- The programming behind the VAT Calculator (scp-bookings/custom/functions-vat-calculator.php) has been rebuilt to accommodate the missing information from the Custom VAT and VVAT Select data.
- Booking Confirmations
-- Client and Operator Booking Confirmations now contain the same Pricing information. The nightlyrate text (PPN or PPPPN) is based on the Booking Type and the price itself is given net or inc vat based on the Show as Inc VAT checkbox in the booking form.
-Legacy functions
-- To accommodate the new single price field, we have written legacy code to check if the booking has a Price Per Person value from the previous $priceperperson meta key. If it does, then show the value in the Price Per Night Field ($rentalprice). The save function will update the booking and save the value in the rental price meta for future use.

NOTE: We may have to look into the reporting to check to make sure the reports take into account the single use meta field. 

V4
- The new customer query tool is complete. Users can now send correctly formatted emails over to clients and the reseller tool also works. In addition, unpublished / pending apartments in the search results now have a request update button. This sends an email to Bryony to update the apartment and make it avaiable to send in emails.

V3.9
- Revamp of the Customer Query System. Requires testing by the client but both the SCP and Reseller Emails seem to be working fine. 

V3.8.5
- Bug fix incorrect meta showing on the city guides page. 

V3.8.4
- Bug fix where the address was not showing. This seemed to be fixed when i changed the PHP variable names in the get+page _by_title function on both the client confirmation (local and email) and operator confirmatio