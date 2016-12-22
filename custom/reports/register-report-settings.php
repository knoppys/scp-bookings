<?php
/*******************************
Regsiter the report settings 
and their callback functions
*******************************/
function clientreportsettings() {
    //register our settings
    register_setting( 'clientreportexclude-group', 'client-excludelist' );
}

function operatorreportsettings() {
    //register our settings
    register_setting( 'operatorreportexclude-group', 'operator-excludelist' );
}

function apartmentreportsettings() {
    //register our settings
    register_setting( 'apartmentreportexclude-group', 'apartment-excludelist' );
}

function locationreportsettings() {
    //register our settings
    register_setting( 'locationreportexclude-group', 'location-excludelist' );
}